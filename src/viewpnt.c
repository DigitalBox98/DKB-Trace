/*****************************************************************************
*
*                                     viewpnt.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements methods for managing the viewpoint.
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

METHODS Viewpoint_Methods =
   { NULL, NULL, NULL, NULL, Copy_Viewpoint,
     Translate_Viewpoint, Rotate_Viewpoint,
     Scale_Viewpoint, NULL};

void *Copy_Viewpoint (Object)
   OBJECT *Object;
   {
   VIEWPOINT *Viewpoint = (VIEWPOINT *) Object;
   VIEWPOINT *New_Viewpoint;

   New_Viewpoint = Get_Viewpoint();

   New_Viewpoint -> Location = Viewpoint -> Location;
   New_Viewpoint -> Direction = Viewpoint -> Direction;
   New_Viewpoint -> Right = Viewpoint -> Right;
   New_Viewpoint -> Up = Viewpoint -> Up;
   return (New_Viewpoint);
   }

void Translate_Viewpoint (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   VAdd (((VIEWPOINT *) Object) -> Location, 
         ((VIEWPOINT *) Object) -> Location,
         *Vector);
   }

void Rotate_Viewpoint (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   TRANSFORMATION Transformation;
   VIEWPOINT *Viewpoint = (VIEWPOINT *) Object;

   Get_Rotation_Transformation(&Transformation, Vector);
   MTransformVector (&(Viewpoint -> Location),
                     &(Viewpoint -> Location), &Transformation);

   MTransformVector (&(Viewpoint -> Direction),
                     &(Viewpoint -> Direction), &Transformation);

   MTransformVector (&(Viewpoint -> Up),
                     &(Viewpoint -> Up), &Transformation);

   MTransformVector (&(Viewpoint -> Right),
                     &(Viewpoint -> Right), &Transformation);
   }

void Scale_Viewpoint (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   TRANSFORMATION Transformation;
   VIEWPOINT *Viewpoint = (VIEWPOINT *) Object;

   Get_Scaling_Transformation(&Transformation, Vector);
   MTransformVector (&(Viewpoint -> Location),
                     &(Viewpoint -> Location), &Transformation);

   MTransformVector (&(Viewpoint -> Direction),
                     &(Viewpoint -> Direction), &Transformation);

   MTransformVector (&(Viewpoint -> Up),
                     &(Viewpoint -> Up), &Transformation);

   MTransformVector (&(Viewpoint -> Right),
                     &(Viewpoint -> Right), &Transformation);
   }

