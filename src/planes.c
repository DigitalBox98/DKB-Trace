/*****************************************************************************
*
*                                    planes.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements functions that manipulate planes.
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

METHODS Plane_Methods =
   { Object_Intersect, All_Plane_Intersections,
     Inside_Plane, Plane_Normal,
     Copy_Plane,
     Translate_Plane, Rotate_Plane,
     Scale_Plane, Invert_Plane};

extern PLANE *Get_Plane_Shape();

extern RAY *VP_Ray;
extern long Ray_Plane_Tests, Ray_Plane_Tests_Succeeded;

int All_Plane_Intersections (Object, Ray, Depth_Queue)
   OBJECT *Object;
   RAY *Ray;
   PRIOQ *Depth_Queue;
   {
   PLANE *Shape = (PLANE *) Object;
   DBL Depth;
   VECTOR Intersection_Point;
   INTERSECTION Local_Element;

   if (Intersect_Plane (Ray, Shape, &Depth))
      if (Depth > Small_Tolerance)
         {
         Local_Element.Depth = Depth;
         Local_Element.Object = Shape -> Parent_Object;
         VScale (Intersection_Point, Ray -> Direction, Depth);
         VAdd (Intersection_Point, Intersection_Point, Ray -> Initial);
         Local_Element.Point = Intersection_Point;
         Local_Element.Shape = (SHAPE *)Shape;
         pq_add (Depth_Queue, &Local_Element);
         return (TRUE);
         }

   return (FALSE);
   }

int Intersect_Plane (Ray, Plane, Depth)
   RAY *Ray;
   PLANE *Plane;
   DBL *Depth;
   {
   DBL NormalDotOrigin, NormalDotDirection;

   Ray_Plane_Tests++;
   if (Ray == VP_Ray) {
      if (!Plane->VPCached) {
         VDot (Plane->VPNormDotOrigin, Plane->Normal_Vector, Ray->Initial);
         Plane->VPNormDotOrigin += Plane->Distance;
         Plane->VPNormDotOrigin *= -1.0;
         Plane->VPCached = TRUE;
         }

      VDot (NormalDotDirection, Plane->Normal_Vector, Ray->Direction);
      if ((NormalDotDirection < Small_Tolerance) &&
          (NormalDotDirection > -Small_Tolerance))
	     return (FALSE);

      *Depth = Plane->VPNormDotOrigin / NormalDotDirection;
      if ((*Depth >= Small_Tolerance) && (*Depth <= Max_Distance)) {
         Ray_Plane_Tests_Succeeded++;
         return (TRUE);
         }
      else
         return (FALSE);
      }
   else {
      VDot (NormalDotOrigin, Plane->Normal_Vector, Ray->Initial);
      NormalDotOrigin += Plane->Distance;
      NormalDotOrigin *= -1.0;

      VDot (NormalDotDirection, Plane->Normal_Vector, Ray->Direction);
      if ((NormalDotDirection < Small_Tolerance) &&
          (NormalDotDirection > -Small_Tolerance))
            return (FALSE);

      *Depth = NormalDotOrigin / NormalDotDirection;
      if ((*Depth >= Small_Tolerance) && (*Depth <= Max_Distance)) {
         Ray_Plane_Tests_Succeeded++;
         return (TRUE);
         }
      else
         return (FALSE);
      }
   }

int Inside_Plane (Test_Point, Object)
   VECTOR *Test_Point;
   OBJECT *Object;
   {
   PLANE *Plane = (PLANE *) Object;
   DBL Temp;

   VDot (Temp, *Test_Point, Plane->Normal_Vector);
   return ((Temp + Plane->Distance) <= Small_Tolerance);
   }

void Plane_Normal (Result, Object, Intersection_Point)
   OBJECT *Object;
   VECTOR *Result, *Intersection_Point;
   {
   PLANE *Plane = (PLANE *) Object;

   *Result = Plane->Normal_Vector;
   }

void *Copy_Plane (Object)
   OBJECT *Object;
   {
   PLANE *New_Shape;

   New_Shape = Get_Plane_Shape ();
   *New_Shape = * ((PLANE *)Object);
   New_Shape -> Next_Object = NULL;

   if (New_Shape->Shape_Texture != NULL)
      New_Shape->Shape_Texture = Copy_Texture (New_Shape->Shape_Texture);

   return (New_Shape);
   }

void Translate_Plane (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   PLANE *Plane = (PLANE *) Object;
   VECTOR Translation;

   VEvaluate (Translation, Plane->Normal_Vector, *Vector);
   Plane->Distance -= Translation.x + Translation.y + Translation.z;

   Translate_Texture (&Plane->Shape_Texture, Vector);
   }

void Rotate_Plane (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   TRANSFORMATION Transformation;

   Get_Rotation_Transformation (&Transformation, Vector);
   MTransformVector (&((PLANE *) Object)->Normal_Vector,
                     &((PLANE *) Object)->Normal_Vector, &Transformation);

   Rotate_Texture (&((PLANE *) Object)->Shape_Texture, Vector);
   }

void Scale_Plane (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   DBL Length;
   PLANE *Plane = (PLANE  *) Object;

   Plane->Normal_Vector.x = Plane->Normal_Vector.x / Vector->x;
   Plane->Normal_Vector.y = Plane->Normal_Vector.y / Vector->y;
   Plane->Normal_Vector.z = Plane->Normal_Vector.z / Vector->z;

   VLength(Length, Plane->Normal_Vector);
   VScale (Plane->Normal_Vector, Plane->Normal_Vector, 1.0 / Length);
   Plane->Distance /= Length;

   Scale_Texture (&((PLANE *) Object)->Shape_Texture, Vector);
   }

void Invert_Plane (Object)
   OBJECT *Object;
   {
   PLANE *Plane = (PLANE  *) Object;

   VScale (Plane->Normal_Vector, Plane->Normal_Vector, -1.0);
   Plane->Distance *= -1.0;
   }

