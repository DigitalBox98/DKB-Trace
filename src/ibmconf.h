/*****************************************************************************
*
*                                   ibmconf.h
*
*   from DKBTrace (c) 1990  David Buck
*
*  This file contains ibm-specific defines, types, etc.
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


/* The following defines may be added when porting to other systems or
   other compilers.  The defaults are shown here:


   #define PARAMS(x) x                   - use 'x' for ANSI, '()' for non ANSI
   #define EPSILON 1.0e-5                - a small value used for quartics
   #define FILE_NAME_LENGTH 150          - default file name length
   #define DBL double                    - floating point precision
   #define HUGE_VAL 1.0e+17              - a really big number
   #define DBL_FORMAT_STRING "%lf"       - the string to use for scanfs of doubles
   #define DEFAULT_OUTPUT_FORMAT  'd'    - the default +f format
   #define TEST_ABORT                    - code to test for ^C or abort
                                           (called on each pixel)
   #define RED_RAW_FILE_EXTENSION ".red" - for +fr, this is the extension for the
                                           red file
   #define GREEN_RAW_FILE_EXTENSION ".grn"  - ditto for the green file
   #define BLUE_RAW_FILE_EXTENSION ".blu"   - ditto again for the blue file
   #define STARTUP_DKB_TRACE             - first executable statement of main
                                           (useful for initialization)
   #define PRINT_OTHER_CREDITS           - used for people who extend dkbtrace.
                                           (put your own printf's here)
   #define FINISH_DKB_TRACE              - last statement before exiting normally
   #define FILENAME_SEPARATOR "/"        - the character that separates names
                                           in a path.
   #define setvbuf(w,x,y,z)              - some systems don't understand setvbuf.
                                           If not, just define it away - it's
                                           not critical to the raytracer.  It
                                           just buffers disk accesses.
*/

#include <conio.h>
#include <stdarg.h>
#include <stdlib.h>


#ifndef TURBOC
void _cdecl main(int, char **);	/* so MSC can use FASTCALL's... */
#define main (_cdecl main)
#define	MK_FP(seg,ofs)	((void far *)(((unsigned long)(seg) << 16) | (unsigned)(ofs)))
#else
#define _cdecl	cdecl	/* Turbo-C equivalent function names/keywords */
#define _enable	enable
#define _disable disable
#define outpw	outport
#define outp	outportb
#define inp	inportb
#endif

#ifdef MATH_CO
#define DBL long double
#else
#define DBL double
#endif

#ifdef MATH_CO
#define DBL_FORMAT_STRING "%Lf"
#else
#define DBL_FORMAT_STRING "%lf"
#endif

#if defined(MATH_CO) && !defined(TURBOC)
#define ACOS acosl
#define SQRT sqrtl
#define POW powl
#define COS cosl
#define SIN sinl
#define EPSILON 1.0e-15
#else
#define ACOS acos
#define SQRT sqrt
#define POW pow
#define COS cos
#define SIN sin
#define EPSILON 1.0e-5
#endif

#define DEFAULT_OUTPUT_FORMAT	't'

#define TEST_ABORT if (Options & EXITENABLE) if (kbhit()) { Stop_Flag = TRUE; getch(); }

#define RED_RAW_FILE_EXTENSION	 ".r8"	/* PICLAB's "RAW" file format */
#define GREEN_RAW_FILE_EXTENSION ".g8"	/* PICLAB's "RAW" file format */
#define BLUE_RAW_FILE_EXTENSION	 ".b8"	/* PICLAB's "RAW" file format */

#define FILENAME_SEPARATOR "\\"		/* wierd 'ol IBM's like backslashes */

#define PARAMS(x) x			/* This gives us ANSI prototyping */
