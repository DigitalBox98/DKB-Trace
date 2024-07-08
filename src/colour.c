/*****************************************************************************
*
*                                   colour.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements routines to manipulate colours.
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

#define FABS(x) ((x) < 0.0 ? (0.0 - (x)) : (x))

DBL Colour_Distance (colour1, colour2)
   COLOUR *colour1, *colour2;
   {
   return (FABS (colour1->Red - colour2->Red)
         + FABS (colour1->Green - colour2->Green)
         + FABS (colour1->Blue - colour2->Blue));
   }

void Add_Colour (result, colour1, colour2)
   COLOUR *result, *colour1, *colour2;
   {
   result->Red = colour1->Red + colour2->Red;
   result->Green = colour1->Green + colour2->Green;
   result->Blue = colour1->Blue + colour2->Blue;
   result->Alpha = colour1->Alpha + colour2->Alpha;
   }

void Scale_Colour (result, colour, factor)
   COLOUR *result, *colour;
   DBL factor;
   {
   result->Red = colour->Red * factor;
   result->Green = colour->Green * factor;
   result->Blue = colour->Blue * factor;
   result->Alpha = colour->Alpha * factor;
   }

void Clip_Colour (result, colour)
   COLOUR *result, *colour;
   {
   if (colour -> Red > 1.0)
      result -> Red = 1.0;
   else if (colour -> Red < 0.0)
      result -> Red = 0.0;
   else result -> Red = colour -> Red;

   if (colour -> Green > 1.0)
      result -> Green = 1.0;
   else if (colour -> Green < 0.0)
      result -> Green = 0.0;
   else result -> Green = colour -> Green;

   if (colour -> Blue > 1.0)
      result -> Blue = 1.0;
   else if (colour -> Blue < 0.0)
      result -> Blue = 0.0;
   else result -> Blue = colour -> Blue;

   if (colour -> Alpha > 1.0)
      result -> Alpha = 1.0;
   else if (colour -> Alpha < 0.0)
      result -> Alpha = 0.0;
   else result -> Alpha = colour -> Alpha;
   }
