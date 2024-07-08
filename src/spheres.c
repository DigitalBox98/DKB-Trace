/*****************************************************************************
*
*                                      spheres.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements the sphere primitive.
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

METHODS Sphere_Methods =
   { Object_Intersect, All_Sphere_Intersections,
     Inside_Sphere, Sphere_Normal,
     Copy_Sphere,
     Translate_Sphere, Rotate_Sphere,
     Scale_Sphere, Invert_Sphere};

extern SPHERE *Get_Sphere_Shape();

extern RAY *VP_Ray;
extern long Ray_Sphere_Tests, Ray_Sphere_Tests_Succeeded;

int All_Sphere_Intersections (Object, Ray, Depth_Queue)
  OBJECT *Object;
  RAY *Ray;
  PRIOQ *Depth_Queue;
  {
  DBL Depth1, Depth2;
  VECTOR Intersection_Point;
  INTERSECTION Local_Element;
  register int Intersection_Found;
  SPHERE *Shape = (SPHERE *) Object;

  Intersection_Found = FALSE;
  if (Intersect_Sphere (Ray, Shape, &Depth1, &Depth2))
    {
    Local_Element.Depth = Depth1;
    Local_Element.Object = Shape -> Parent_Object;
    VScale (Intersection_Point, Ray -> Direction, Depth1);
    VAdd (Intersection_Point, Intersection_Point, Ray -> Initial);
    Local_Element.Point = Intersection_Point;
    Local_Element.Shape = (SHAPE *)Shape;
    pq_add (Depth_Queue, &Local_Element);
    Intersection_Found = TRUE;

    if (Depth2 != Depth1)
      {
      Local_Element.Depth = Depth2;
      Local_Element.Object = Shape -> Parent_Object;
      VScale (Intersection_Point, Ray -> Direction, Depth2);
      VAdd (Intersection_Point, Intersection_Point, Ray -> Initial);
      Local_Element.Point = Intersection_Point;
      Local_Element.Shape = (SHAPE *) Shape;
      pq_add (Depth_Queue, &Local_Element);
      Intersection_Found = TRUE;
      }
    }
  return (Intersection_Found);
  }

int Intersect_Sphere (Ray, Sphere, Depth1, Depth2)
   RAY *Ray;
   SPHERE *Sphere;
   DBL *Depth1, *Depth2;
   {
   VECTOR Origin_To_Center;
   DBL OCSquared, t_Closest_Approach, Half_Chord, t_Half_Chord_Squared;
   short inside;

   Ray_Sphere_Tests++;
   if (Ray == VP_Ray) {
      if (!Sphere->VPCached) {
         VSub (Sphere->VPOtoC, Sphere->Center, Ray->Initial);
         VDot (Sphere->VPOCSquared, Sphere->VPOtoC, Sphere->VPOtoC);
         Sphere->VPinside = (Sphere->VPOCSquared < Sphere->Radius_Squared);
         Sphere->VPCached = TRUE;
         }
      VDot (t_Closest_Approach, Sphere->VPOtoC, Ray->Direction);
      if (!Sphere->VPinside && (t_Closest_Approach < Small_Tolerance))
         return (FALSE);      
      t_Half_Chord_Squared = Sphere->Radius_Squared - Sphere->VPOCSquared +
                        (t_Closest_Approach * t_Closest_Approach);
      }
   else {
      VSub (Origin_To_Center, Sphere->Center, Ray->Initial);
      VDot (OCSquared, Origin_To_Center, Origin_To_Center);
      inside = (OCSquared < Sphere->Radius_Squared);
      VDot (t_Closest_Approach, Origin_To_Center, Ray->Direction);
      if (!inside && (t_Closest_Approach < Small_Tolerance))
         return (FALSE);

      t_Half_Chord_Squared = Sphere->Radius_Squared - OCSquared +
                        (t_Closest_Approach * t_Closest_Approach);
      }

   if (t_Half_Chord_Squared < Small_Tolerance)
      return (FALSE);

   Half_Chord = sqrt (t_Half_Chord_Squared);
   *Depth1 = t_Closest_Approach + Half_Chord;
   *Depth2 = t_Closest_Approach - Half_Chord;

   if ((*Depth1 < Small_Tolerance) || (*Depth1 > Max_Distance))
      if ((*Depth2 < Small_Tolerance) || (*Depth2 > Max_Distance))
         return (FALSE);
      else
         *Depth1 = *Depth2;
   else
      if ((*Depth2 < Small_Tolerance) || (*Depth2 > Max_Distance))
        *Depth2 = *Depth1;

   Ray_Sphere_Tests_Succeeded++;
   return (TRUE);
   }

int Inside_Sphere (Test_Point, Object)
   VECTOR *Test_Point;
   OBJECT *Object;
   {
   VECTOR Origin_To_Center;
   DBL OCSquared;
   SPHERE *Sphere = (SPHERE *) Object;

   VSub (Origin_To_Center, Sphere->Center, *Test_Point);
   VDot (OCSquared, Origin_To_Center, Origin_To_Center);

   if (Sphere->Inverted)
      return (OCSquared - Sphere->Radius_Squared > Small_Tolerance);
   else
      return (OCSquared - Sphere->Radius_Squared < Small_Tolerance);
   }

void Sphere_Normal (Result, Object, Intersection_Point)
   OBJECT *Object;
   VECTOR *Result, *Intersection_Point;
   {
   SPHERE *Sphere = (SPHERE *) Object;

   VSub (*Result, *Intersection_Point, Sphere->Center);
   VScale (*Result, *Result, Sphere->Inverse_Radius);
   }

void *Copy_Sphere (Object)
   OBJECT *Object;
   {
   SPHERE *New_Shape;

   New_Shape = Get_Sphere_Shape ();
   *New_Shape = *((SPHERE *) Object);
   New_Shape -> Next_Object = NULL;

	   if (New_Shape->Shape_Texture != NULL)
      New_Shape->Shape_Texture = Copy_Texture (New_Shape->Shape_Texture);

   return (New_Shape);
   }

void Translate_Sphere (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   VAdd (((SPHERE *) Object)->Center, ((SPHERE *) Object)->Center, *Vector);

   Translate_Texture (&((SPHERE *) Object)->Shape_Texture, Vector);
   }

void Rotate_Sphere (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   TRANSFORMATION Transformation;

   Get_Rotation_Transformation (&Transformation, Vector);
   MTransformVector (&((SPHERE *) Object)->Center,
                     &((SPHERE *) Object)->Center, &Transformation);

   Rotate_Texture (&((SPHERE *) Object)->Shape_Texture, Vector);
   }

void Scale_Sphere (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   SPHERE *Sphere = (SPHERE *) Object;

   if ((Vector->x != Vector->y) ||
       (Vector->x != Vector->z)) {
      fprintf (stderr, "Error - you cannot scale a sphere unevenly\n");
      exit (1);
      }

   VScale (Sphere->Center, Sphere->Center, Vector->x);
   Sphere->Radius *= Vector->x;
   Sphere->Radius_Squared = Sphere->Radius * Sphere->Radius;
   Sphere->Inverse_Radius = 1.0 / Sphere->Radius;


   Scale_Texture (&((SPHERE *) Object)->Shape_Texture, Vector);
   }

void Invert_Sphere (Object)
   OBJECT *Object;
   {
   ((SPHERE *) Object)->Inverted ^= TRUE;
   }
