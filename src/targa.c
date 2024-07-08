/*****************************************************************************
*
*                                     Targa.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module contains the code to read and write the Targa output file
*  format.
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

extern int First_Line;

FILE_HANDLE *Get_Targa_File_Handle()
   {
   FILE_HANDLE *handle;

   if ((handle = (FILE_HANDLE *) malloc(sizeof(FILE_HANDLE))) == NULL) {
      fprintf (stderr, "Cannot allocate memory for output file handle\n");
      return(NULL);
      }

   handle->Default_File_Name_p = Default_Targa_File_Name;
   handle->Open_File_p = Open_Targa_File;
   handle->Write_Line_p = Write_Targa_Line;
   handle->Read_Line_p = Read_Targa_Line;
   handle->Close_File_p = Close_Targa_File;
   return (handle);
   }

char *Default_Targa_File_Name()
   {
   return ("data.tga");
   }

int Open_Targa_File (handle, name, width, height, buffer_size, mode)
   FILE_HANDLE *handle;
   char *name;
   int *width;
   int *height;
   int buffer_size;
   int mode;
   {
   int data1, data2, i;

   handle->mode = mode;
   handle->filename = name;

   switch (mode) {
      case READ_MODE:
         if ((handle->file = fopen (name, "rb")) == NULL)
            return(0);

         if (buffer_size != 0) {
            if ((handle->buffer = malloc (buffer_size)) == NULL)
               return(0);

            setvbuf (handle->file, handle->buffer, _IOFBF, buffer_size);
            }

         for (i = 0 ; i < 12 ; i++)
            if (getc(handle->file) == EOF)
               return(0);

         if (((data1 = getc(handle->file)) == EOF)
             || ((data2 = getc(handle->file)) == EOF))
            return(0);

         *width  = data2 * 256 + data1;

         if (((data1 = getc(handle->file)) == EOF)
             || ((data2 = getc(handle->file)) == EOF))
            return(0);

         for (i = 0 ; i < 2 ; i++)
            if (getc(handle->file) == EOF)
               return(0);

         *height = data2 * 256 + data1;
         handle->width = *width;
         handle->height = *height;
         handle->buffer_size = buffer_size;
         break;

      case WRITE_MODE:
         if ((handle->file = fopen (name, "wb")) == NULL)
            return(0);

         if (buffer_size != 0) {
            if ((handle->buffer = malloc (buffer_size)) == NULL)
               return(0);

            setvbuf (handle->file, handle->buffer, _IOFBF, buffer_size);
            }

         for (i = 0; i < 10; i++)	/* 00, 00, 02, then 7 00's... */
            if (i == 2)
               putc(i, handle->file);
            else
               putc(0, handle->file);

         putc(First_Line % 256, handle->file); /* y origin set to "First_Line" */
         putc(First_Line / 256, handle->file);

         putc(*width % 256, handle->file);  /* write width and height */
         putc(*width / 256, handle->file);
         putc(*height % 256, handle->file);
         putc(*height / 256, handle->file);
         putc(24, handle->file);		/* 24 bits/pixel (16 million colors!) */
         putc(32, handle->file);		/* Bitmask, pertinent bit: top-down raster */

         handle->width = *width;
         handle->height = *height;
         handle->buffer_size = buffer_size;

         break;

      case APPEND_MODE:
         if ((handle->file = fopen (name, "ab")) == NULL)
            return(0);

         if (buffer_size != 0) {
            if ((handle->buffer = malloc (buffer_size)) == NULL)
               return(0);

            setvbuf (handle->file, handle->buffer, _IOFBF, buffer_size);
            }

         break;
      }
   return(1);
   }

void Write_Targa_Line (handle, line_data, line_number)
   FILE_HANDLE *handle;
   COLOUR *line_data;
   int line_number;
   {
   register int x;

   for (x = 0; x < handle->width; x++) {
      putc((int) floor (line_data[x].Blue * 255.0), handle->file);
      putc((int) floor (line_data[x].Green * 255.0), handle->file);
      putc((int) floor (line_data[x].Red * 255.0), handle->file);
      }

   if (handle->buffer_size == 0) {
      fflush(handle->file);                       /* close and reopen file for */
      handle->file = freopen(handle->filename, "ab",
                    handle->file);                /* integrity in case we crash*/
      }
   }

int Read_Targa_Line (handle, line_data, line_number)
   FILE_HANDLE *handle;
   COLOUR *line_data;
   int *line_number;
   {
   int x, data;
static int Targa_Line_Number = 0;

   for (x = 0; x < handle->width; x++) {

   /* Read the BLUE data byte.  If EOF is reached on the first character read,
      then this line hasn't been rendered yet.  Return 0.  If an EOF occurs
      somewhere within the line, this is an error - return -1. */

      if ((data = getc(handle->file)) == EOF)
         if (x == 0)
            return (0);
         else
            return (-1);

      line_data[x].Blue = (DBL) data / 255.0;

   /* Read the GREEN data byte. */
      if ((data = getc(handle->file)) == EOF)
         return (-1);
      line_data[x].Green = (DBL) data / 255.0;


   /* Read the RED data byte. */
      if ((data = getc(handle->file)) == EOF)
         return (-1);
      line_data[x].Red = (DBL) data / 255.0;
      }

   *line_number = Targa_Line_Number++;
   return(1);
   }

void Close_Targa_File (handle)
   FILE_HANDLE *handle;
   {
   fclose (handle->file);
   if (handle->buffer_size != 0)
      free (handle->buffer);
   }
