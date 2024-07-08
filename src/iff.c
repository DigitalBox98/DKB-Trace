/*****************************************************************************
*
*                                     iff.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This file implements a simple IFF format file reader.
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
#include "dkbproto.h"

static IMAGE_COLOUR *iff_colour_map;
static int colourmap_size;
static CHUNK_HEADER Chunk_Header;

#define FORM 0x464f524dL
#define ILBM 0x494c424dL
#define BMHD 0x424d4844L
#define CAMG 0x43414d47L
#define CMAP 0x434d4150L
#define BODY 0x424f4459L
#define CMPNONE 0

#define HAM 0x800

void iff_error()
   {
   fprintf (stderr, "Invalid IFF file\n");
   exit(1);
   }

int read_byte(f)
   FILE *f;
   {
   int c;
   if ((c = getc(f)) == EOF)
      iff_error();
   return (c);
   }

int read_word(f)
   FILE *f;
   {
   int result;

   result = read_byte(f)*256;
   result += read_byte(f);
   return (result);
   }

long read_long(f)
   FILE *f;
   {
   int i;
   long result;

   result = 0;
   for (i = 0 ; i < 4 ; i++)
      result = result * 256 + read_byte(f);

   return (result);
   }

void Read_Chunk_Header (f, dest)
   FILE *f;
   CHUNK_HEADER *dest;
   {
   dest->name = read_long(f);
   dest->size = read_long(f);
   }

void Read_Iff_Image(Image, filename)
   IMAGE *Image;
   char *filename;
   {
   FILE *f;
   unsigned char **row_bytes;
   int c, i, j, k, nBytes, nPlanes, compression,
       mask, byte_index, count, viewmodes;
   int Previous_Red, Previous_Green, Previous_Blue;
   struct Image_Line *line;
   unsigned long creg;

   if ((f = Locate_File(filename, "rb")) == NULL) {
      fprintf (stderr, "Cannot open IFF file %s\n", filename);
      exit(1);
      }

   Previous_Red = Previous_Green = Previous_Blue = 0;

   viewmodes = 0;
   iff_colour_map = NULL;

   while (1) {
      Read_Chunk_Header(f, &Chunk_Header);
      switch ((int) Chunk_Header.name) {
         case FORM:  if (read_long(f) != ILBM)
                        iff_error();
                     break;

         case BMHD:  Image->iwidth = read_word(f);
                     Image->width = (DBL)Image->iwidth;
                     Image->iheight = read_word(f);
                     Image->height = (DBL)Image->iheight;

                     read_word(f);  /* x position ignored */
                     read_word(f);  /* y position ignored */
                     nPlanes = read_byte(f);
                     colourmap_size = 1<<nPlanes;
                     read_byte(f);   /* masking ignored */
                     compression = read_byte(f);   /* masking ignored */
                     read_byte(f);   /* pad */
                     read_word(f);   /* Transparent colour ignored */
                     read_word(f);   /* Aspect ratio ignored */
                     read_word(f);   /* page width ignored */
                     read_word(f);   /* page height ignored */
                     break;

         case CAMG:  viewmodes = (int) read_long(f);   /* Viewmodes */
                     if (viewmodes & HAM)
                        colourmap_size = 16;

                     break;

         case CMAP:  colourmap_size = (int) Chunk_Header.size / 3;

                     if ((iff_colour_map = (IMAGE_COLOUR *) malloc(sizeof(IMAGE_COLOUR)*colourmap_size)) == NULL) {
			fprintf(stderr, "Cannot allocate memory for IFF colour map\n");
			exit(1);
			}

                     for (i = 0 ; i < colourmap_size ; i++) {
                        iff_colour_map[i].Red = read_byte(f);
                        iff_colour_map[i].Green = read_byte(f);
                        iff_colour_map[i].Blue = read_byte(f);
                        iff_colour_map[i].Alpha = 0;
                        }

                     Previous_Red = iff_colour_map[0].Red;
                     Previous_Green = iff_colour_map[0].Green;
                     Previous_Blue = iff_colour_map[0].Blue;
                     for (i = colourmap_size * 3 ; (long) i < Chunk_Header.size ; i++)
                        read_byte(f);
 
                     break;

         case BODY:  if ((iff_colour_map == NULL) || (viewmodes & HAM)) {
                        Image->Colour_Map_Size = 0;
                        Image->Colour_Map = NULL;
                        }
                     else {
                        Image->Colour_Map_Size = colourmap_size;
                        Image->Colour_Map = iff_colour_map;
                        }

                     if ((row_bytes = (unsigned char **) malloc (4*nPlanes)) == NULL) {
                        fprintf (stderr, "Cannot allocate memory for row bytes\n");
                        exit(1);
                        }

                     for (i = 0 ; i < nPlanes ; i++)
                        if ((row_bytes[i] = (unsigned char *)
                                        malloc((Image->iwidth+7)/8)) == NULL) {
			   fprintf (stderr, "Cannot allocate memory for row bytes\n");
                           exit(1);
                        }

                     if (Image->Colour_Map == NULL) {
                        if ((Image->data.rgb_lines = (struct Image_Line *)
                            malloc(Image->iheight * sizeof (struct Image_Line)))==NULL) {
                           fprintf (stderr, "Cannot allocate memory for picture\n");
                           exit(1);
                           }
                        }
                     else {
                        if ((Image->data.map_lines = (unsigned char **)
                            malloc(Image->iheight * sizeof (unsigned char *)))==NULL) {
                           fprintf (stderr, "Cannot allocate memory for picture\n");
                           exit(1);
                           }
                        }

                     for (i = 0 ; i < Image->iheight ; i++) {

                        if (Image->Colour_Map == NULL) {
                           if (((Image->data.rgb_lines[i].red = (unsigned char *)
                                                 malloc(Image->iwidth))==NULL) ||
                               ((Image->data.rgb_lines[i].green = (unsigned char *)
                                                 malloc(Image->iwidth))==NULL) ||
                               ((Image->data.rgb_lines[i].blue = (unsigned char *)
                                                 malloc(Image->iwidth))==NULL)) {
                              fprintf (stderr, "Cannot allocate memory for picture\n");
                              exit(1);
                              }
                           }
                        else {
                           if ((Image->data.map_lines[i] = (unsigned char *)
                               malloc(Image->iwidth * sizeof(unsigned char))) == NULL) {
                              fprintf (stderr, "Cannot allocate memory for picture\n");
                              exit(1);
                              }
                           }

                        for (j = 0 ; j < nPlanes ; j++)
                           if (compression == CMPNONE) {
                              for (k = 0 ; k < (Image->iwidth+7)/8 ; k++)
                                 row_bytes[j][k] = (unsigned char)read_byte(f);
                              if ((Image->iwidth & 7) != 0)
                                 read_byte(f);
                              }

                           else {
                              nBytes = 0;
                              while (nBytes != (Image->iwidth+7)/8) {
                                 c = read_byte(f);
                                 if ((c >= 0) && (c <= 127))
                                    for (k = 0 ; k <= c ; k++)
                                       row_bytes[j][nBytes++] = (unsigned char)read_byte(f);
                                 else if ((c >= 129) && (c <= 255)) {
                                    count = 257-c;
                                    c = read_byte(f);
                                    for (k = 0 ; k < count ; k++)
                                       row_bytes[j][nBytes++] = (unsigned char)c;
                                    }
                                 }
                       	   }

                        mask = 0x80;
                        byte_index = 0;
                        for (j = 0 ; j < Image->iwidth ; j++) {
                           creg = 0;
                           for (k = nPlanes-1 ; k >= 0 ; k--)
                              if (row_bytes[k][byte_index] & mask)
                                creg = creg*2 + 1;
                              else
                                creg *= 2;


                           if (viewmodes & HAM) {
                              line = &Image->data.rgb_lines[i];
                              switch (creg >> 4) {
                                 case 0:
                                    Previous_Red = line->red[j] = (unsigned char)iff_colour_map[creg].Red;
                                    Previous_Green = line->green[j] = (unsigned char)iff_colour_map[creg].Green;
                                    Previous_Blue = line->blue[j] = (unsigned char)iff_colour_map[creg].Blue;
                                    break;

                                 case 1:
                                    line->red[j] = (unsigned char)Previous_Red;
                                    line->green[j] = (unsigned char)Previous_Green;
                                    line->blue[j] = (unsigned char)(((creg & 0xf)<<4) + (creg&0xf));
                                    Previous_Blue = (int) line->blue[j];
                                    break;

                                 case 2:
                                    line->red[j] = (unsigned char)(((creg & 0xf)<<4) + (creg&0xf));
                                    Previous_Red = (int) line->red[j];
                                    line->green[j] = (unsigned char)Previous_Green;
                                    line->blue[j] = (unsigned char)Previous_Blue;
                                    break;

                                 case 3:
                                    line->red[j] = (unsigned char)Previous_Red;
                                    line->green[j] = (unsigned char)(((creg & 0xf)<<4) + (creg&0xf));
                                    Previous_Green = (int) line->green[j];
                                    line->blue[j] = (unsigned char)Previous_Blue;
                                    break;
                                 }
                              }
                           else if (nPlanes == 24) {
                              line = &Image->data.rgb_lines[i];
                              line->red[j] = (unsigned char)((creg >> 16) & 0xFF);
                              line->green[j] = (unsigned char)((creg >> 8) & 0xFF);
                              line->blue[j] = (unsigned char)(creg & 0xFF);
                              }
                           else {
                              if (creg > (unsigned long)Image->Colour_Map_Size) {
                                 fprintf (stderr, "Error - IFF Image Map Colour out of range\n");
                                 exit(1);
                                 }
                              Image->data.map_lines[i][j] = (char)creg;
                              }

                           mask >>= 1;
                           if (mask == 0) {
                              mask = 0x80;
                              byte_index++;
                              }
                           }
                        }

                     free (row_bytes);
                     fclose (f);
                     return;

         default:
            for (i = 0 ; (long) i < Chunk_Header.size ; i++)
               if (getc(f) == EOF)
                  iff_error();
            break;
         }
      }
   }

