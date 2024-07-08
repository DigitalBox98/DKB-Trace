/*****************************************************************************
*
*                                    render.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements the main raytracing loop.
*
* This software is freely distributable. The source and/or object code may be
* copied or uploaded to communications services so long as this notice remains
* at the top of each file.  If any changes are made to the program, you must
* clearly indicate in the documentation and in the programs startup message
* who it was who made the changes. The documentation should also describe what
* those changes were. This software may not be included in whole or in
* part into any commercial package without the express written consent of the
* author.  It may, however, be included in other public domain or freely
* distributed software so long as the proper credit for the software is given.
*
* This software is provided as is without any guarantees or warranty. Although
* the author has attempted to find and correct any bugs in the software, he
* is not responsible for any damage caused by the use of the software.  The
* author is under no obligation to provide service, corrections, or upgrades
* to this package.
*
* Despite all the legal stuff above, if you do find bugs, I would like to hear
* about them.  Also, if you have any comments or questions, you may contact me
* at the following address:
*
*     David Buck
*     22C Sonnet Cres.
*     Nepean Ontario
*     Canada, K2H 8W7
*
*  I can also be reached on the following bulleton boards:
*
*     OMX              (613) 731-3419
*     Mystic           (613) 596-4249  or  (613) 596-4772
*
*  Fidonet:   1:163/109.9
*  Internet:  dbuck@ccs.carleton.ca
*  The "You Can Call Me RAY" BBS    (708) 358-5611
*
*  IBM Port by Aaron A. Collins. Aaron may be reached on the following BBS'es:
*
*     The "You Can Call Me RAY" BBS (708) 358-5611
*     The Information Exchange BBS  (708) 945-5575
*
*****************************************************************************/

#include "frame.h"
#include "vector.h"
#include "dkbproto.h"

extern FILE_HANDLE *Output_File_Handle;
extern char Output_File_Name[FILE_NAME_LENGTH];
extern char OutputFormat;
extern int File_Buffer_Size;
extern unsigned int Options;
extern int Quality;
volatile int Stop_Flag;
extern int First_Line, Last_Line;
extern long Number_Of_Pixels, Number_Of_Rays, Number_Of_Pixels_Supersampled;

extern short *hashTable;
extern unsigned short crctab[256];
#define rand3d(a,b) crctab[(int)(hashTable[(int)(hashTable[(int)((a)&0xfff)]^(b))&0xfff])&0xff]

FRAME Frame;
RAY *VP_Ray;
int Trace_Level, SuperSampleCount;


#define MAX_TRACE_LEVEL 5

void Output_Line PARAMS((int y, COLOUR **Previous_Line, COLOUR **Current_Line,
  char **Previous_Line_Antialiased_Flags, char **Current_Line_Antialiased_Flags));

COLOUR *Previous_Line, *Current_Line;
char *Previous_Line_Antialiased_Flags, *Current_Line_Antialiased_Flags;
RAY Ray;

void Create_Ray (ray, width, height, x, y)
   RAY *ray;
   int width, height;
   DBL x, y;
   {
   register DBL X_Scalar, Y_Scalar;
   VECTOR Temp_Vect_1, Temp_Vect_2;

   /* Convert the X Coordinate to be a DBL from 0.0 to 1.0 */
   X_Scalar = (x - (DBL) width / 2.0) / (DBL) width;

   /* Convert the Y Coordinate to be a DBL from 0.0 to 1.0 */
   Y_Scalar = (( (DBL)(Frame.Screen_Height - 1) - y) -
	      (DBL) height / 2.0) / (DBL) height;

   VScale (Temp_Vect_1, Frame.View_Point.Up, Y_Scalar);
   VScale (Temp_Vect_2, Frame.View_Point.Right, X_Scalar);
   VAdd (ray->Direction, Temp_Vect_1, Temp_Vect_2);
   VAdd (ray->Direction, ray->Direction, Frame.View_Point.Direction);
   VNormalize (ray->Direction, ray->Direction);
   Initialize_Ray_Containers (ray);
   ray->Quadric_Constants_Cached = FALSE;
   }


void Supersample (result, x, y, Width, Height)
   COLOUR *result;
   int x, y, Width, Height;
   {
   COLOUR colour;
   register DBL dx, dy, Jitter_X, Jitter_Y;

   dx = (DBL) x;
   dy = (DBL) y;

   Number_Of_Pixels_Supersampled++;

   Make_Colour (result, 0.0, 0.0, 0.0);

   Jitter_X = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Jitter_Y = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Create_Ray (VP_Ray, Frame.Screen_Width, Frame.Screen_Height,
	         dx + Jitter_X, dy + Jitter_Y);

   Trace_Level = 0;
   Trace (VP_Ray, &colour);
   Clip_Colour (&colour, &colour);
   Scale_Colour (&colour, &colour, 0.11111111);
   Add_Colour (result, result, &colour);

   Jitter_X = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Jitter_Y = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Create_Ray (VP_Ray, Width, Height, dx + Jitter_X - 0.3333333,
                                      dy + Jitter_Y - 0.3333333);
   Trace_Level = 0;
   Trace (VP_Ray, &colour);
   Clip_Colour (&colour, &colour);
   Scale_Colour (&colour, &colour, 0.11111111);
   Add_Colour (result, result, &colour);

   Jitter_X = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Jitter_Y = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Create_Ray (VP_Ray, Width, Height, dx + Jitter_X - 0.3333333,
                                      dy + Jitter_Y);
   Trace_Level = 0;
   Trace (VP_Ray, &colour);
   Clip_Colour (&colour, &colour);
   Scale_Colour (&colour, &colour, 0.11111111);
   Add_Colour (result, result, &colour);

   Jitter_X = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Jitter_Y = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Create_Ray (VP_Ray, Width, Height, dx + Jitter_X - 0.3333333,
                                      dy + Jitter_Y + 0.3333333);
   Trace_Level = 0;
   Trace (VP_Ray, &colour);
   Clip_Colour (&colour, &colour);
   Scale_Colour (&colour, &colour, 0.11111111);
   Add_Colour (result, result, &colour);

   Jitter_X = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Jitter_Y = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Create_Ray (VP_Ray, Width, Height, dx + Jitter_X,
                                      dy + Jitter_Y - 0.3333333);
   Trace_Level = 0;
   Trace (VP_Ray, &colour);
   Clip_Colour (&colour, &colour);
   Scale_Colour (&colour, &colour, 0.11111111);
   Add_Colour (result, result, &colour);

   Jitter_X = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Jitter_Y = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Create_Ray (VP_Ray, Width, Height, dx + Jitter_X,
                                      dy + Jitter_Y + 0.3333333);
   Trace_Level = 0;
   Trace (VP_Ray, &colour);
   Clip_Colour (&colour, &colour);
   Scale_Colour (&colour, &colour, 0.11111111);
   Add_Colour (result, result, &colour);

   Jitter_X = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Jitter_Y = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Create_Ray (VP_Ray, Width, Height, dx + Jitter_X + 0.3333333,
                                      dy + Jitter_Y - 0.3333333);
   Trace_Level = 0;
   Trace (VP_Ray, &colour);
   Clip_Colour (&colour, &colour);
   Scale_Colour (&colour, &colour, 0.11111111);
   Add_Colour (result, result, &colour);

   Jitter_X = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Jitter_Y = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Create_Ray (VP_Ray, Width, Height, dx + Jitter_X + 0.3333333,
                                      dy + Jitter_Y);
   Trace_Level = 0;
   Trace (VP_Ray, &colour);
   Clip_Colour (&colour, &colour);
   Scale_Colour (&colour, &colour, 0.11111111);
   Add_Colour (result, result, &colour);

   Jitter_X = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Jitter_Y = (rand3d(x, y) & 0x7FFF) / 32768.0 * 0.33333333 - 0.16666666;
   Create_Ray (VP_Ray, Width, Height, dx + Jitter_X + 0.3333333,
                                      dy + Jitter_Y + 0.3333333);
   Trace_Level = 0;
   Trace (VP_Ray, &colour);
   Clip_Colour (&colour, &colour);
   Scale_Colour (&colour, &colour, 0.11111111);
   Add_Colour (result, result, &colour);
   }

void initialize_renderer()
   {
   allocate_lines(&Previous_Line, &Current_Line, &Previous_Line_Antialiased_Flags, &Current_Line_Antialiased_Flags, &Ray);
   }

void Read_Rendered_Part()
   {
   int rc, x, line_number;
   char Red, Green, Blue;

   while ((rc = Read_Line(Output_File_Handle, Previous_Line, &line_number)) == 1) {
      if (Options & DISPLAY)
         for (x = 0 ; x < Frame.Screen_Width ; x++) {
            Red = (char) (Previous_Line[x].Red * 255.0);
            Green = (char) (Previous_Line[x].Green * 255.0);
            Blue = (char) (Previous_Line[x].Blue * 255.0);
            display_plot (x, line_number, Red, Green, Blue);
            }
      }

   First_Line = line_number+1;

   if (rc == 0) {
      Close_File(Output_File_Handle);
      if (Open_File (Output_File_Handle, Output_File_Name,
              &Frame.Screen_Width, &Frame.Screen_Height, File_Buffer_Size,
              APPEND_MODE) != 1) {
         fprintf (stderr, "Error opening output file\n");
         exit(1);
         }
      return;
      }

   fprintf (stderr, "Error reading aborted data file\n");
   }

void Start_Tracing ()
   {
   COLOUR Colour;
   register int x, y;
   char Red, Green, Blue, Antialias_Center_Flag;

   for (y = (Options & ANTIALIAS)?First_Line-1:First_Line; y<Last_Line; y++) {

      check_stats(y);
 
      for (x = 0 ; x < Frame.Screen_Width ; x++) {
         Number_Of_Pixels++;
         if (Stop_Flag) {
            close_all();
            exit(0);
            }

         TEST_ABORT

         Create_Ray (VP_Ray, Frame.Screen_Width, Frame.Screen_Height, (DBL) x, (DBL) y);
         Trace_Level = 0;
         Trace (&Ray, &Colour);
         Clip_Colour (&Colour, &Colour);

         Current_Line[x] = Colour;

         if (Options & ANTIALIAS) {
            Antialias_Center_Flag = 0;
            Current_Line_Antialiased_Flags[x] = 0;

            if (x != 0) {
               if (Colour_Distance (&Current_Line[x-1], &Current_Line[x])
                   >= Frame.Antialias_Threshold) {
                  Antialias_Center_Flag = 1;
                  if (!(Current_Line_Antialiased_Flags[x-1])) {
                     Supersample (&Current_Line[x-1], 
                                  x-1, y, Frame.Screen_Width, Frame.Screen_Height);
                     Current_Line_Antialiased_Flags[x-1] = 1;
                     SuperSampleCount++;
                     }
                  }
               }

            if (y != First_Line-1) {
               if (Colour_Distance (&Previous_Line[x], &Current_Line[x])
                    >= Frame.Antialias_Threshold) {
                  Antialias_Center_Flag = 1;
                  if (!(Previous_Line_Antialiased_Flags[x])) {
                     Supersample (&Previous_Line[x],
                                  x, y-1, Frame.Screen_Width, Frame.Screen_Height);
                     Previous_Line_Antialiased_Flags[x] = 1;
                     SuperSampleCount++;
                     }
                  }
               }

            if (Antialias_Center_Flag) {
               Supersample (&Current_Line[x],
                            x, y, Frame.Screen_Width, Frame.Screen_Height);
               Current_Line_Antialiased_Flags[x] = 1;
               Colour = Current_Line[x];
               SuperSampleCount++;
               }
            }

         if (y != First_Line-1) {
            Red = (char) (Colour.Red * 255.0);
            Green = (char) (Colour.Green * 255.0);
            Blue = (char) (Colour.Blue * 255.0);

            if (Options & DISPLAY)
               display_plot (x, y, Red, Green, Blue);
            }
         }
      Output_Line(y, &Previous_Line, &Current_Line, &Previous_Line_Antialiased_Flags, &Current_Line_Antialiased_Flags);
      }

   if (Options & DISKWRITE) {
      Write_Line (Output_File_Handle, Previous_Line, Last_Line - 1);
      }
   }

void check_stats(y)
   register int y;
   {
      if (Options & VERBOSE)
         printf ("Line %3d", y);

      if (Options & ANTIALIAS)
         SuperSampleCount = 0;
   }

void  allocate_lines(Previous_Line, Current_Line, Previous_Line_Antialiased_Flags, Current_Line_Antialiased_Flags, Ray)
   COLOUR **Previous_Line, **Current_Line;
   char **Previous_Line_Antialiased_Flags, **Current_Line_Antialiased_Flags;
   RAY *Ray;
   {
   register int i;

   VP_Ray = Ray;

   *Previous_Line = (COLOUR *) malloc (sizeof (COLOUR)*(Frame.Screen_Width + 1));
   *Current_Line = (COLOUR *) malloc (sizeof (COLOUR)*(Frame.Screen_Width + 1));

   for (i = 0 ; i <= Frame.Screen_Width ; i++) {
      (*Previous_Line)[i].Red = 0.0;
      (*Previous_Line)[i].Green = 0.0;
      (*Previous_Line)[i].Blue = 0.0;

      (*Current_Line)[i].Red = 0.0;
      (*Current_Line)[i].Green = 0.0;
      (*Current_Line)[i].Blue = 0.0;
      }

   if (Options & ANTIALIAS) {
      *Previous_Line_Antialiased_Flags =
          (char *) malloc (sizeof (char)*(Frame.Screen_Width + 1));
      *Current_Line_Antialiased_Flags =
          (char *)  malloc (sizeof (char)*(Frame.Screen_Width + 1));

      for (i = 0 ; i <= Frame.Screen_Width ; i++) {
         (*Previous_Line_Antialiased_Flags)[i] = 0;
         (*Current_Line_Antialiased_Flags)[i] = 0;
         }
   }

   Ray->Initial = Frame.View_Point.Location;
   return;
   }

void Output_Line (y, Previous_Line, Current_Line, Previous_Line_Antialiased_Flags, Current_Line_Antialiased_Flags)
   register int y;
   COLOUR **Previous_Line, **Current_Line;
   char **Previous_Line_Antialiased_Flags, **Current_Line_Antialiased_Flags;
   {
      COLOUR *Temp_Colour_Ptr;
      char *Temp_Char_Ptr;
 
      if (Options & DISKWRITE)
         if (y > First_Line) {
            Write_Line (Output_File_Handle, *Previous_Line, y-1);
         }

      if (Options & VERBOSE)
         if (Options & ANTIALIAS)
            printf (" supersampled %d times\n", SuperSampleCount);
         else
            putchar ('\n');

      Temp_Colour_Ptr = *Previous_Line;
      *Previous_Line = *Current_Line;
      *Current_Line = Temp_Colour_Ptr;

      Temp_Char_Ptr = *Previous_Line_Antialiased_Flags;
      *Previous_Line_Antialiased_Flags = *Current_Line_Antialiased_Flags;
      *Current_Line_Antialiased_Flags = Temp_Char_Ptr;

      return;
   }

void Trace (Ray, Colour)
   RAY *Ray;
   COLOUR *Colour;
   {
   OBJECT *Object;
   INTERSECTION *Local_Intersection, *New_Intersection;
   register int Intersection_Found;

   Number_Of_Rays++;
   Make_Colour (Colour, 0.0, 0.0, 0.0);

   Intersection_Found = FALSE;
   Local_Intersection = NULL;

   if (Trace_Level > MAX_TRACE_LEVEL) {
      return;
      }

   if (Frame.Fog_Distance == 0.0) {
      Make_Colour (Colour, 0.0, 0.0, 0.0);
      }
   else
      *Colour = Frame.Fog_Colour;

   if (Options & DEBUGGING)
      printf ("Calculating intersections level %d\n", Trace_Level);

    /* What objects does this ray intersect? */
   for (Object = Frame.Objects ; 
        Object != NULL ;
        Object = Object -> Next_Object) {

      if (New_Intersection = Intersection (Object, Ray)) {
         if (Intersection_Found) {
            if (Local_Intersection -> Depth > New_Intersection -> Depth) {
               free (Local_Intersection);
               Local_Intersection = New_Intersection;
               }
            else
               free (New_Intersection);
            }
         else
            Local_Intersection = New_Intersection;

         Intersection_Found = TRUE;
         }
      }

   if (Intersection_Found) {
      Determine_Surface_Colour (Local_Intersection, Colour, Ray, FALSE);
      free (Local_Intersection);
      }
   }
