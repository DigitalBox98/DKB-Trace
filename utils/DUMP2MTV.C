/*
 * Dump2MTV.C - Converts DKB/QRT Dump 24-bit output file to MTV/Rayshade format
 *
 * Written by Ville Saari
 *
 * Copyright (c) 1991 Ferry Island Pixelboys.
 * All rights reserved.
 *
 * Created 27-Dec-90
 * Updated 31-jan-90
 *
 * Updated 26-Apr-91 V. 1.10 - Aaron A. Collins - made somewhat more portable,
 * and made the program read and write files instead of stdin and stdout.
 */

#include "stdio.h"
#include "stdlib.h"

#define BUFSIZE 32768L

FILE *infile, *outfile;

void error(char *text, int code)
   {
   if(code) fputs("Dump2MTV: ", stderr);
   fputs(text, stderr);
   if (infile != NULL)
	  fclose(infile);
   if (outfile != NULL)
	  {
	  fflush(outfile);
	  fclose(outfile);
	  }
   exit(code);
   }

void main(ac, arg)
int ac;
char *arg[];
   {
   char *buffer;
   long bufptr, width, height, f, n;
   char *c;

   fputs(
         "\033[33;1mDUMP2MTV\033[0m V1.10 by Ville Saari.\n"
         "Copyright (c) 1990 Ferry Island Pixelboys.\n"
         "Freeware.\n\n", stderr);

   if (ac != 3)
	  error("Usage: Dump2MTV inputfile outputfile\n", 0);
  
   if((infile = fopen(arg[1], "rb")) == NULL)
	   error("Can't open input file.\n", 1);

   if((outfile = fopen(arg[2], "wb")) == NULL)
	   error("Can't create output file.\n", 1);

   if(!(buffer=malloc((unsigned int)BUFSIZE)))
      error("Can't allocate memory for buffer.\n", 103);

   if(!fread(buffer, 4, 1, infile))
      error("Can't read DKB/QRT Dump header.\n", 20);

   fprintf(stderr,
      "Picture size: %d x %d.\n"
      "Processing line      ",
      width=(unsigned char)buffer[0]|((unsigned char)buffer[1]<<8),
      height=(unsigned char)buffer[2]|((unsigned char)buffer[3]<<8));

   fprintf(outfile, "%d %d\n", width, height);
   bufptr=0;

   for(f=0; f<height; f++)
      {
      fprintf(stderr, "\033[5D%-5d", f);
      
      if(((unsigned char)fgetc(infile)|((unsigned char)fgetc(infile)<<8))!=(int)f)
         error("DKB/QRT Dump file incomplete.\n", 20);

      for(n=0, c=buffer+bufptr; n<width; n++, c+=3) *c=(char)fgetc(infile);
      for(n=0, c=buffer+bufptr+1; n<width; n++, c+=3) *c=(char)fgetc(infile);
      for(n=0, c=buffer+bufptr+2; n<width; n++, c+=3) *c=(char)fgetc(infile);

      if((bufptr+=3*width)+3*width>BUFSIZE || f>=height-1)
         {
         if(!fwrite(buffer, (unsigned int)bufptr, 1, outfile))
            error("Error in writing MTV/Rayshade file.\n", 20);
         bufptr=0;
         }
      }
   fputs("\n", stderr);
   }
