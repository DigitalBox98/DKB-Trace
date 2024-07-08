/*****************************************************************************
*
*                                      ray.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements functions pertaining to rays.
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

#define Mix(a,b,c) { \
   (a).x = (b).x * (c).y; \
   (a).y = (b).x * (c).z; \
   (a).z = (b).y * (c).z; }

void Make_Ray(r)
   RAY *r;
   {
   VECTOR Temp_Init_Dir;

   VSquareTerms (r -> Initial_2, r -> Initial);
   VSquareTerms (r -> Direction_2, r -> Direction);
   VEvaluate (r -> Initial_Direction, r -> Initial, r -> Direction);
   Mix (r -> Mixed_Initial_Initial, r -> Initial, r -> Initial);
   Mix (r -> Mixed_Dir_Dir, r -> Direction, r -> Direction);
   Mix (Temp_Init_Dir, r -> Initial, r -> Direction);
   Mix (r -> Mixed_Init_Dir, r -> Direction, r -> Initial);
   VAdd (r -> Mixed_Init_Dir, r -> Mixed_Init_Dir, Temp_Init_Dir);
   r -> Quadric_Constants_Cached = TRUE;
   }

void Initialize_Ray_Containers (Ray)
   RAY *Ray;
   {
   Ray -> Containing_Index = -1;
   }

void Copy_Ray_Containers (Dest_Ray, Source_Ray)
   RAY *Dest_Ray, *Source_Ray;
   {
   register int i;
   
   if ((Dest_Ray -> Containing_Index = Source_Ray -> Containing_Index)
         >= MAX_CONTAINING_OBJECTS) {
      fprintf (stderr, "ERROR - Containing Index too high\n");
      close_all();
      exit (1);
      }

   for (i = 0 ; i < MAX_CONTAINING_OBJECTS ; i++) {
      Dest_Ray -> Containing_Textures[i] = Source_Ray -> Containing_Textures[i];
      Dest_Ray -> Containing_IORs[i] = Source_Ray -> Containing_IORs[i];
      }
   }

void Ray_Enter (ray, texture)
   RAY *ray;
   TEXTURE *texture;
   {
   register int index;

   if ((index = ++(ray -> Containing_Index)) >= MAX_CONTAINING_OBJECTS) {
      fprintf (stderr, "Too many nested refracting objects\n");
      close_all();
      exit(1);
      }

   ray -> Containing_Textures [index] = texture;
   ray -> Containing_IORs [index] = texture->Object_Index_Of_Refraction;
   }

void Ray_Exit (ray)
   RAY *ray;
   {
   if (--(ray -> Containing_Index) < -1) {
      fprintf (stderr, "Too many exits from refractions\n");
      close_all();
      exit(1);
      }
   }
