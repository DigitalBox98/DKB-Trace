/*****************************************************************************
*
*                                     gif.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  Gif-format file reader.
*
*  NOTE:  Portions of this module were written by Steve Bennett and are used
*         here with his permission.
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

/*
   The following routines were borrowed freely from FRACTINT, and represent
   a generalized GIF file decoder.  This seems the best, most universal format
   for reading in Bitmapped images.  GIF is a Copyright of Compuserve, Inc.
   Swiped and converted to entirely "C" coded routines by AAC for the most
   in future portability!
*/

#include "frame.h"
#include "dkbproto.h"

static IMAGE *Current_Image;  
static int Bitmap_Line;
static FILE *Bit_File;
unsigned char *decoderline  /*  [2049] */ ;  /* write-line routines use this */

static IMAGE_COLOUR *gif_colour_map;
static int colourmap_size;

int out_line (pixels, linelen)
   unsigned char *pixels;
   int linelen;
   {
   register int x;
   register unsigned char *line;

   line = Current_Image->data.map_lines[Bitmap_Line++];

   for (x = 0; x < linelen; x++) {
      if ((int)(*pixels) > Current_Image->Colour_Map_Size) {
         fprintf (stderr, "Error - GIF Image Map Colour out of range\n");
         exit(1);
      }

      line[x] = *pixels;
      pixels++;
      }

   return (0);
   }

#define READ_ERROR -1

int get_byte() /* get byte from file, return the next byte or an error */
   {
   register int byte;

   if ((byte = getc(Bit_File)) != EOF)
      return (byte);
   else {
      fprintf (stderr, "Premature End Of File reading GIF image\n");
      exit (1);
      }
   return (0);  /* Keep the compiler happy */
   }

/* Main GIF file decoder.  */

void Read_Gif_Image(Image, filename)
   IMAGE *Image;
   char *filename;
   {
   register int i, j, status;
   unsigned finished, planes;
   unsigned char buffer[16];

   status = 0;
   Current_Image = Image;

   if ((Bit_File = Locate_File(filename, "rb")) == NULL) {
      fprintf (stderr, "Cannot open GIF file %s\n", filename);
      exit(1);
      }

   /* zero out the full write-line */
   if ((decoderline = (unsigned char *) malloc (2049)) == NULL) {
      fprintf (stderr, "Cannot allocate space for GIF decoder line\n");
      fclose (Bit_File);
      exit (1);
      }

   for (i = 0; i < 2049; i++)
      decoderline[i] = (unsigned char) 0;

   /* Get the screen description */
   for (i = 0; i < 13; i++)
      buffer[i] = (unsigned char)get_byte();

   if (strncmp((char *) buffer,"GIF",3) ||          /* use updated GIF specs */
       buffer[3] < '0' || buffer[3] > '9' ||
       buffer[4] < '0' || buffer[4] > '9' ||
       buffer[5] < 'A' || buffer[5] > 'z' ) {

      fprintf (stderr, "Invalid GIF file format: %s\n", filename);
      fclose(Bit_File);
      exit (1);
      }

   planes = ((unsigned)buffer[10] & 0x0F) + 1;
   colourmap_size = (int)(1 << planes);

   if ((gif_colour_map = (IMAGE_COLOUR *)
         malloc (colourmap_size * sizeof (IMAGE_COLOUR))) == NULL) {
      fprintf (stderr, "Cannot allocate GIF Colour Map\n");
      fclose (Bit_File);
      exit (1);
      }

   if ((buffer[10] & 0x80) == 0) {    /* color map (better be!) */
      fprintf (stderr, "Invalid GIF file format: %s\n", filename);
      fclose(Bit_File);
      exit (1);
      }

   for (i = 0; i < colourmap_size ; i++) {
      gif_colour_map[i].Red = (unsigned char)get_byte();
      gif_colour_map[i].Green = (unsigned char)get_byte();
      gif_colour_map[i].Blue = (unsigned char)get_byte();
      gif_colour_map[i].Alpha = 0;
      }

 /* Now display one or more GIF objects */
   finished = FALSE;
   while (!finished) {
      switch (get_byte()) {
         case ';':                /* End of the GIF dataset */
            finished = TRUE;
            status = 0;
            break;

         case '!':                /* GIF Extension Block */
            get_byte();           /* read (and ignore) the ID */
            while ((i = get_byte()) > 0) /* get data len*/
            for (j = 0; j < i; j++)
                get_byte(); /* flush data */
            break;

         case ',': /* Start of image object. get description */
            for (i = 0; i < 9; i++) {
               if ((j = get_byte()) < 0) {	/* EOF test (?) */
                  status = -1;
                  break;
                  }
	       buffer[i] = (unsigned char) j;
               }

            if (status < 0) {
               finished = TRUE;
               break;
               }

            Image->iwidth  = buffer[4] | (buffer[5] << 8);
            Image->iheight = buffer[6] | (buffer[7] << 8);
            Image->width = (DBL) Image->iwidth;
            Image->height = (DBL) Image->iheight;

	    Bitmap_Line = 0;

            Image->Colour_Map_Size = colourmap_size;
            Image->Colour_Map = gif_colour_map;

            if ((Image->data.map_lines = (unsigned char **)
                 malloc(Image->iheight * sizeof (unsigned char *)))==NULL) {
               fprintf (stderr, "Cannot allocate memory for picture\n");
               exit(1);
               }

            for (i = 0 ; i < Image->iheight ; i++) {
               if ((Image->data.map_lines[i] = (unsigned char *) malloc(Image->iwidth))==NULL) {
                  fprintf (stderr, "Cannot allocate memory for picture\n");
                  exit(1);
                  }
               }

          /* Setup the color palette for the image */
            status = decoder ((short) Image->iwidth); /*put bytes in Buf*/
            finished = TRUE;
            break;

         default:
            status = -1;
            finished = TRUE;
            break;
         }
      }

   free (decoderline);
   fclose(Bit_File);
   }
