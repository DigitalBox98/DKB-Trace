/*****************************************************************************
*
*                                     trace.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module contains the entry routine for the raytracer and the code to
*  parse the parameters on the command line.
*
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

#include <ctype.h>
#include <sys/time.h>

#include "frame.h"		/* common to ALL modules in this program */
#include "dkbproto.h"

#define MAX_FILE_NAMES 1
unsigned int Options;
int Quality;

FILE *bfp;

extern FRAME Frame;

char Input_File_Name[FILE_NAME_LENGTH], Output_File_Name[FILE_NAME_LENGTH];

#define MAX_LIBRARIES 10
char *Library_Paths[MAX_LIBRARIES];
int Library_Path_Index;

FILE_HANDLE *Output_File_Handle;
int File_Buffer_Size;
static int Number_Of_Files;
DBL VTemp;
DBL Antialias_Threshold;
int First_Line, Last_Line;
int Display_Started = FALSE;

/* Stats kept by the ray tracer: */
long Number_Of_Pixels, Number_Of_Rays, Number_Of_Pixels_Supersampled;
long Ray_Sphere_Tests, Ray_Sphere_Tests_Succeeded;
long Ray_Plane_Tests, Ray_Plane_Tests_Succeeded;
long Ray_Triangle_Tests, Ray_Triangle_Tests_Succeeded;
long Ray_Quadric_Tests, Ray_Quadric_Tests_Succeeded;
long Ray_Quartic_Tests, Ray_Quartic_Tests_Succeeded;
long Bounding_Region_Tests, Bounding_Region_Tests_Succeeded;
long Calls_To_Noise, Calls_To_DNoise;
long Shadow_Ray_Tests, Shadow_Rays_Succeeded;
long Reflected_Rays_Traced, Refracted_Rays_Traced;
long Transmitted_Rays_Traced;

char DisplayFormat, OutputFormat;

void main (argc, argv)
  int argc;
  char **argv;
  {
  register int i;
  struct timeval t1, t2; 
  
  STARTUP_DKB_TRACE

  printf ("\n\n          DKB Ray Trace   Version 2.14\n");
  printf ("          ----------------------------\n\n");
  printf ("        Copyright (c) 1991  David K. Buck\n\n");
  printf ("  Written by:\n");
  printf ("  David K. Buck (dbuck@ccs.carleton.ca) (CIS: 70521, 1371)\n");
  printf ("  22C Sonnet Cr.  Nepean, Ontario\n");
  printf ("  Canada, K2H 8W7\n\n");
  printf ("  This program is freely distributable.\n\n");

  printf ("  Conversion to IBM P.C. w/TARGA output and\n");
  printf ("  other various improvements by Aaron A. Collins\n\n");

  printf ("  GIF format file reader by Steve A. Bennett\n\n");

  printf ("  Noise and DNoise functions by Robert Skinner\n\n");

  printf ("  Quartic (4th order) Shapes by Alexander Enzmann\n\n");

  printf ("  NAS Synology version by http://digitalboxweb.wordpress.com\n");
  printf ("  Render Time is now displayed in the stats\n\n");
  
  PRINT_OTHER_CREDITS

/* Parse the command line parameters */
  if (argc == 1)
     usage();

  init_vars();

  Output_File_Name[0]='\0';

  Library_Paths[0] = NULL;
  Library_Path_Index = 0;

/* Read the default parameters from trace.def */
  get_defaults();

  for (i = 1 ; i < argc ; i++ )
    if ((*argv[i] == '+') || (*argv[i] == '-'))
      parse_option(argv[i]);
    else
      parse_file_name(argv[i]);

   if (Last_Line == -1)
      Last_Line = Frame.Screen_Height;

   if (Options & DISKWRITE) {
      switch (OutputFormat) {
         case '\0':
         case 'd':
         case 'D':
                   if ((Output_File_Handle = Get_Dump_File_Handle()) == NULL) {
                      close_all();
                      exit(1);
                      }
                   break;
/*
         case 'i':
         case 'I':
                   if ((Output_File_Handle = Get_Iff_File_Handle()) == NULL) {
                      close_all();
                      exit(1);
                      }
                   break;

*/
         case 'r':
         case 'R':
                   if ((Output_File_Handle = Get_Raw_File_Handle()) == NULL) {
                      close_all();
                      exit(1);
                      }
                   break;

         case 't':
         case 'T':
                   if ((Output_File_Handle = Get_Targa_File_Handle()) == NULL) {
                      close_all();
                      exit(1);
                      }
                   break;

         default:
                   fprintf (stderr, "Unrecognized output file format %c\n", OutputFormat);
                   exit(1);
         }

      if (Output_File_Name[0] == '\0')
         strcpy (Output_File_Name, Default_File_Name (Output_File_Handle));
      }

   Print_Options();

   Initialize_Tokenizer(Input_File_Name);
   printf ("Parsing...\n");
   Parse (&Frame);
   Terminate_Tokenizer();

  if (Options & DISPLAY)
    {
    printf ("Displaying...\n");
    display_init(Frame.Screen_Width, Frame.Screen_Height);
    Display_Started = TRUE;
    }

/*  Start timer */
  gettimeofday(&t1, NULL);

/* Get things ready for ray tracing */
   if (Options & DISKWRITE)
      if (Options & CONTINUE_TRACE) {
         if (Open_File (Output_File_Handle, Output_File_Name,
                 &Frame.Screen_Width, &Frame.Screen_Height, File_Buffer_Size,
                 READ_MODE) != 1) {
            fprintf (stderr, "Error opening output file\n");
            close_all();
            exit(1);
            }

         initialize_renderer();
         Read_Rendered_Part();
         }
      else {
         if (Open_File (Output_File_Handle, Output_File_Name,
                 &Frame.Screen_Width, &Frame.Screen_Height, File_Buffer_Size,
                 WRITE_MODE) != 1) {
            fprintf (stderr, "Error opening output file\n");
            close_all();
            exit(1);
            }

         initialize_renderer();
         }
  else
     initialize_renderer();

  pq_init();
  Initialize_Noise();

/* Ok, go for it - trace the picture */
  if (!(Options & DISPLAY))
      printf ("Rendering...\n");

  Start_Tracing ();

/* End timer */
  gettimeofday(&t2, NULL);
    
/* Wait for a CR if the user requested it. */

/* Clean up and leave */
  display_finished();

  close_all ();
  

  
  print_stats(t1, t2);

  FINISH_DKB_TRACE
  }

/* Print out usage error message */

void usage ()
    {
    printf ("\nUsage:");
    printf ("\n   trace  [+/-] Option1 [+/-] Option2");
    printf ("\n");
    printf ("\n Options:");
    printf ("\n    dx = display in format x");
    printf ("\n    v  = verbose");
    printf ("\n    p  = prompt exit");
    printf ("\n    x  = enable early exit by key hit");
    printf ("\n    fx = write output file in format x");
    printf ("\n         ft - Uncompressed Targa-24  fd - DKB/QRT Dump  fr - 3 Raw Files");
    printf ("\n    a  = perform antialiasing");
    printf ("\n    c  = continue aborted trace");
    printf ("\n    qx = image quality 0=rough, 9=full");
    printf ("\n    lxxx = library path prefix");
    printf ("\n    wxxx = width of the screen");
    printf ("\n    hxxx = height of the screen");
    printf ("\n    sxxx = start at line number xxx");
    printf ("\n    exxx = end at line number xxx");
    printf ("\n    bxxx = Use xxx kilobytes for output file buffer space");
    printf ("\n    ifilename = input file name");
    printf ("\n    ofilename = output file name");
    printf ("\n\n");
    exit(1);
    }

void init_vars()
  {
  Output_File_Handle = NULL;
  File_Buffer_Size = 0;
  Options = 0;
  Quality = 9;
  Number_Of_Files = 0;
  First_Line = 0;
  Last_Line = -1;

  Number_Of_Pixels = 0L;
  Number_Of_Rays = 0L;
  Number_Of_Pixels_Supersampled = 0L;
  Ray_Sphere_Tests = 0L;
  Ray_Sphere_Tests_Succeeded = 0L;
  Ray_Plane_Tests = 0L;
  Ray_Plane_Tests_Succeeded = 0L;
  Ray_Triangle_Tests = 0L;
  Ray_Triangle_Tests_Succeeded = 0L;
  Ray_Quadric_Tests = 0L;
  Ray_Quadric_Tests_Succeeded = 0L;
  Ray_Quartic_Tests = 0L;
  Ray_Quartic_Tests_Succeeded = 0L;
  Bounding_Region_Tests = 0L;
  Bounding_Region_Tests_Succeeded = 0L;
  Calls_To_Noise = 0L;
  Calls_To_DNoise = 0L;
  Shadow_Ray_Tests = 0L;
  Shadow_Rays_Succeeded = 0L;
  Reflected_Rays_Traced = 0L;
  Refracted_Rays_Traced = 0L;
  Transmitted_Rays_Traced = 0L;

  Frame.Screen_Height = 100;
  Frame.Screen_Width = 100;

  Antialias_Threshold = 0.3;
  strcpy (Input_File_Name, "object.dat");
  return;
  }

/* Close all the stuff that has been opened. */
void close_all ()
   {
   if ((Options & DISPLAY) && Display_Started)
     display_close();

   if (Output_File_Handle)
      Close_File (Output_File_Handle);
   }

/* Read the default parameters from trace.def*/
void get_defaults()
  {
  FILE *defaults_file;
  char Option_String[256], *Option_String_Ptr;

  if ((defaults_file = fopen("trace.def", "r")) != NULL) {
     while (fgets(Option_String, 256, defaults_file) != NULL)
        read_options(Option_String);
     fclose (defaults_file);
     }

  if ((Option_String_Ptr = getenv("DKBOPT")) != NULL)
     read_options(Option_String_Ptr);
  }

void read_options (Option_Line)
  char *Option_Line;
  {
  register int c, String_Index, Option_Started;
  short Option_Line_Index = 0;
  char Option_String[80];

  String_Index = 0;
  Option_Started = FALSE;
  while ((c = Option_Line[Option_Line_Index++]) != '\0')
    {
    if (Option_Started)
      if (isspace(c))
        {
        Option_String[String_Index] = '\0';
        parse_option (Option_String);
        Option_Started = FALSE;
	String_Index = 0;
        }
     else
       Option_String[String_Index++] = (char) c;

    else /* Option_Started */
      if ((c == (int) '-') || (c == (int) '+'))
        {
        String_Index = 0;
        Option_String[String_Index++] = (char) c;
        Option_Started = TRUE;
        }
      else
        if (!isspace(c))
          {
          fprintf (stderr, "\nBad default file format.  Offending char: (%c), val: %d.\n", (char) c, c);
          exit (1);
          }
    }

  if (Option_Started)
    {
    Option_String[String_Index] = '\0';
    parse_option (Option_String);
    }
  }

/* parse the command line parameters */
void parse_option (Option_String)
  char *Option_String;
  {
  register int Add_Option;
  unsigned int Option_Number;
  DBL threshold;

  if (*(Option_String++) == '-')
    Add_Option = FALSE;
  else
    Add_Option = TRUE;

  switch (*Option_String)
    {
    case 'B':
    case 'b':  sscanf (&Option_String[1], "%d", &File_Buffer_Size);
               File_Buffer_Size *= 1024;
               if (File_Buffer_Size < BUFSIZ)
                  File_Buffer_Size = BUFSIZ;
               Option_Number = 0;
               break;

    case 'C':
    case 'c':  Option_Number = CONTINUE_TRACE;
               break;

    case 'D':
    case 'd':  Option_Number = DISPLAY;
               DisplayFormat = (char)toupper(Option_String[1]);
               if (DisplayFormat == '\0')
                  DisplayFormat = '0';
               break;

    case 'V':
    case 'v':  Option_Number = VERBOSE;
               break;

    case 'W':
    case 'w':  sscanf (&Option_String[1], "%d", &Frame.Screen_Width);
	       Option_Number = 0;
               break;

    case 'H':
    case 'h':  sscanf (&Option_String[1], "%d", &Frame.Screen_Height);
	       Option_Number = 0;
               break;

    case 'F':
    case 'f':  Option_Number = DISKWRITE;
               if (isupper(Option_String[1]))
                  OutputFormat = (char)tolower(Option_String[1]);
               else
                  OutputFormat = Option_String[1];

               /* Default the output format to raw. */
               if (OutputFormat == '\0')
                  OutputFormat = DEFAULT_OUTPUT_FORMAT;
               break;

    case 'P':
    case 'p':  Option_Number = PROMPTEXIT;
               break;

    case 'I':
    case 'i':  strncpy (Input_File_Name, &Option_String[1], FILE_NAME_LENGTH);
	       Option_Number = 0;
               break;

    case 'O':
    case 'o':  strncpy (Output_File_Name, &Option_String[1], FILE_NAME_LENGTH);
	       Option_Number = 0;
               break;

    case 'A':
    case 'a':  Option_Number = ANTIALIAS;
               if (sscanf (&Option_String[1], DBL_FORMAT_STRING, &threshold) != EOF)
                   Antialias_Threshold = threshold;
               break;

    case 'X':
    case 'x':  Option_Number = EXITENABLE;
               break;


    case 'L':
    case 'l':  if (Library_Path_Index >= MAX_LIBRARIES) {
                  fprintf (stderr, "Too many library directories specified\n");
                  exit(1);
                  }

               Library_Paths [Library_Path_Index] = malloc (strlen(Option_String));
	       if (Library_Paths [Library_Path_Index] == NULL) {
		  fprintf (stderr, "Cannot allocate memory for library pathname\n");
		  exit(1);
		  }
               strcpy (Library_Paths [Library_Path_Index], &Option_String[1]);
               Library_Path_Index++;
	       Option_Number = 0;
               break;

    case 'S':
    case 's':  sscanf (&Option_String[1], "%d", &First_Line);
	       Option_Number = 0;
               break;

    case 'E':
    case 'e':  sscanf (&Option_String[1], "%d", &Last_Line);
	       Option_Number = 0;
               break;

    case 'Q':
    case 'q':  sscanf (&Option_String[1], "%d", &Quality);
	       Option_Number = 0;
               break;

               /* Turn on debugging print statements. */
    case 'Z':
    case 'z':  Option_Number = DEBUGGING;
               break;

    default:   fprintf (stderr, "\nInvalid option: %s\n\n", --Option_String);
	       Option_Number = 0;
    }

  if (Option_Number != 0)
      if (Add_Option)
           Options |= Option_Number;
      else Options &= ~Option_Number;
  }

void Print_Options()
   {
   int i;

   printf ("Options in effect: ");

   if (Options & CONTINUE_TRACE)
      printf ("+c ");
   else
      printf ("-c ");

   if (Options & DISPLAY)
      printf ("+d%c ", DisplayFormat);
   else
      printf ("-d ");

   if (Options & VERBOSE)
      printf ("+v ");
   else
      printf ("-v ");

   if (Options & DISKWRITE)
      printf ("+f%c ", OutputFormat);
   else
      printf ("-f ");

   if (Options & PROMPTEXIT)
      printf ("+p ");
   else
      printf ("-p ");

   if (Options & EXITENABLE)
      printf ("+x ");
   else
      printf ("-x ");

   if (Options & ANTIALIAS)
      printf ("+a%f ", Antialias_Threshold);
   else
      printf ("-a ");

   if (Options & DEBUGGING)
      printf ("+z ");

   if (File_Buffer_Size != 0)
      printf ("-b%d ", File_Buffer_Size/1024);

   printf ("-q%d -w%d -h%d -s%d -e%d\n-i%s ",
           Quality, Frame.Screen_Width, Frame.Screen_Height,
           First_Line, Last_Line, Input_File_Name);

   if (Options & DISKWRITE)
      printf ("-o%s ", Output_File_Name);

   for (i = 0 ; i < Library_Path_Index ; i++)
      printf ("-l%s ", Library_Paths[i]);

   printf ("\n");
   }

void parse_file_name (File_Name)
  char *File_Name;
  {
  FILE *defaults_file;
  char Option_String[256];

  if (++Number_Of_Files > MAX_FILE_NAMES)
    {
    fprintf (stderr, "\nOnly %d file names are allowed in a command line.", 
             MAX_FILE_NAMES);
    exit(1);
    }

  if ((defaults_file = fopen(File_Name, "r")) != NULL) {
     while (fgets(Option_String, 256, defaults_file) != NULL)
        read_options(Option_String);
     fclose (defaults_file);
     }
  }

float timedifference_msec(struct timeval t0, struct timeval t1)
{
    return (t1.tv_sec - t0.tv_sec) * 1000.0f + (t1.tv_usec - t0.tv_usec) / 1000.0f;
}

void print_stats(struct timeval t1, struct timeval t2)
   {
   long i = (long) timedifference_msec(t1, t2);
   int msec = 0;
   int sec = 0;
   
   sec = (int) (i / (long)(1000));
   msec = (int) (i % (long)(1000));
        
   printf ("                  Statistics\n");
   printf ("                  ----------\n\n");
   printf ("# Rays:  %10ld    # Pixels:  %10ld  # Pixels supersampled: %10ld\n\n",
            Number_Of_Rays, Number_Of_Pixels, Number_Of_Pixels_Supersampled);

   printf ("\nIntersection Tests:\n\n");
   printf ("   Type       Tests    Succeeded\n");
   printf ("   ----    ----------  ----------\n\n");
   printf ("  Sphere   %10ld  %10ld\n", Ray_Sphere_Tests, Ray_Sphere_Tests_Succeeded);
   printf ("  Plane    %10ld  %10ld\n", Ray_Plane_Tests, Ray_Plane_Tests_Succeeded);
   printf ("  Triangle %10ld  %10ld\n", Ray_Triangle_Tests, Ray_Triangle_Tests_Succeeded);
   printf ("  Quadric  %10ld  %10ld\n", Ray_Quadric_Tests, Ray_Quadric_Tests_Succeeded);
   printf ("  Quartic  %10ld  %10ld\n", Ray_Quartic_Tests, Ray_Quartic_Tests_Succeeded);
   printf ("  Bounds   %10ld  %10ld\n\n", Bounding_Region_Tests, Bounding_Region_Tests_Succeeded);
   printf ("  Calls to Noise:   %10ld\n", Calls_To_Noise);
   printf ("  Calls to DNoise:  %10ld\n", Calls_To_DNoise);
   printf ("  Shadow Ray Tests: %10ld     Blocking Objects Found:  %10ld\n",
              Shadow_Ray_Tests, Shadow_Rays_Succeeded);
   printf ("  Reflected Rays:   %10ld\n", Reflected_Rays_Traced);
   printf ("  Refracted Rays:   %10ld\n", Refracted_Rays_Traced);
   printf ("  Transmitted Rays: %10ld\n\n", Transmitted_Rays_Traced);

   printf ("Render Time:      %3d hours %2d minutes %2d seconds (%d.%03d seconds)\n\n", (int)(sec / 3600), (int)((sec / 60) % 60), (int)(sec % 60), sec, msec);

   }

/* Find a file in the search path. */

FILE *Locate_File (filename, mode)
   char *filename, *mode;
   {
   FILE *f;
   int i;
   char pathname[FILE_NAME_LENGTH];

   /* Check the current directory first. */
   if ((f = fopen (filename, mode)) != NULL)
      return (f);

   for (i = 0 ; i < Library_Path_Index ; i++) {
      strcpy (pathname, Library_Paths[i]);
      if (FILENAME_SEPARATOR != NULL)
         strcat (pathname, FILENAME_SEPARATOR);
      strcat (pathname, filename);
      if ((f = fopen (pathname, mode)) != NULL)
         return (f);
      }

   return (NULL);
   }
