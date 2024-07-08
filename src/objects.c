/*****************************************************************************
*
*                                    objects.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements the methods for objects and composite objects.
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

extern RAY *VP_Ray;
extern long Bounding_Region_Tests, Bounding_Region_Tests_Succeeded;

METHODS Composite_Methods =
   { Object_Intersect, All_Composite_Intersections,
     Inside_Composite_Object, NULL,
     Copy_Composite_Object,
     Translate_Composite_Object, Rotate_Composite_Object,
     Scale_Composite_Object, Invert_Composite_Object};

METHODS Basic_Object_Methods =
   { Object_Intersect, All_Object_Intersections,
     Inside_Basic_Object, NULL,
     Copy_Basic_Object,
     Translate_Basic_Object, Rotate_Basic_Object,
     Scale_Basic_Object, Invert_Basic_Object};


INTERSECTION *Object_Intersect (Object, Ray)
   OBJECT *Object;
   RAY *Ray;
   {
   INTERSECTION *Local_Intersection, *Queue_Element;
   PRIOQ *Depth_Queue;

   Depth_Queue = pq_new (128);

   if ((All_Intersections (Object, Ray, Depth_Queue))
      && ((Queue_Element = pq_get_highest (Depth_Queue)) != NULL))
      {
      if ((Local_Intersection = (INTERSECTION *) malloc(sizeof(INTERSECTION)))
              == NULL) {
          printf("Cannot allocate memory for local intersection\n");
          exit(1);
          }
      Local_Intersection->Point = Queue_Element->Point;
      Local_Intersection->Shape = Queue_Element->Shape;
      Local_Intersection->Depth = Queue_Element->Depth;
      Local_Intersection->Object = Queue_Element->Object;
      pq_free (Depth_Queue);
      return (Local_Intersection);
      }
   else
      {
      pq_free (Depth_Queue);
      return (NULL);
      }
   }

int All_Composite_Intersections (Object, Ray, Depth_Queue)
   OBJECT *Object;
   RAY *Ray;
   PRIOQ *Depth_Queue;
   {
   register int Intersection_Found;
   SHAPE *Bounding_Shape;
   INTERSECTION *Local_Intersection;
   OBJECT *Local_Object;

   for (Bounding_Shape = ((COMPOSITE *) Object) -> Bounding_Shapes ;
        Bounding_Shape != NULL ;
        Bounding_Shape = Bounding_Shape -> Next_Object) {

     Bounding_Region_Tests++;
     if ((Local_Intersection = Intersection ((OBJECT *) Bounding_Shape, Ray)) != NULL)
        free (Local_Intersection);
     else
        if (!Inside (&Ray -> Initial, (OBJECT *) Bounding_Shape))
           return (FALSE);
     Bounding_Region_Tests_Succeeded++;
     }

   Intersection_Found = FALSE;
   for (Local_Object = ((COMPOSITE *) Object) -> Objects ;
        Local_Object != NULL ;
        Local_Object = Local_Object -> Next_Object)

      if (All_Intersections (Local_Object, Ray, Depth_Queue))
         Intersection_Found = TRUE;

   return (Intersection_Found);
   }

int All_Object_Intersections (Object, Ray, Depth_Queue)
   OBJECT *Object;
   RAY *Ray;
   PRIOQ *Depth_Queue;
   {
   INTERSECTION *Local_Intersection;
   SHAPE *Bounding_Shape;

   for (Bounding_Shape = Object -> Bounding_Shapes ;
        Bounding_Shape != NULL ;
        Bounding_Shape = Bounding_Shape -> Next_Object) {

      Bounding_Region_Tests++;
      if ((Local_Intersection = Intersection ((OBJECT *) Bounding_Shape, Ray)) != NULL)
         free (Local_Intersection);
      else
         if (!Inside (&Ray -> Initial, (OBJECT *) Bounding_Shape))
            return (FALSE);
      Bounding_Region_Tests_Succeeded++;
      }

   All_Intersections ((OBJECT *)Object->Shape, Ray, Depth_Queue);

   if (pq_is_empty (Depth_Queue))
     return (FALSE);
   return (TRUE);
   }


int Inside_Basic_Object (Test_Point, Object)
   VECTOR *Test_Point;
   OBJECT *Object;
   {
   SHAPE *Bounding_Shape;

   for (Bounding_Shape = Object -> Bounding_Shapes ;
        Bounding_Shape != NULL ;
        Bounding_Shape = Bounding_Shape -> Next_Object)

      if (!Inside (Test_Point, (OBJECT *) Bounding_Shape))
         return (FALSE);

   if (Inside (Test_Point, (OBJECT *) Object -> Shape))
      return (TRUE);
   return (FALSE);
   }

int Inside_Composite_Object (Test_Point, Object)
   VECTOR *Test_Point;
   OBJECT *Object;
   {
   SHAPE *Bounding_Shape;
   OBJECT *Local_Object;

   for (Bounding_Shape = ((COMPOSITE *) Object) -> Bounding_Shapes ;
        Bounding_Shape != NULL ;
        Bounding_Shape = Bounding_Shape -> Next_Object)

     if (!Inside (Test_Point, (OBJECT *) Bounding_Shape))
       return (FALSE);

   for (Local_Object = ((COMPOSITE *) Object) -> Objects ;
        Local_Object != NULL ;
        Local_Object = Local_Object -> Next_Object)

      if (Inside (Test_Point, Local_Object))
         return (TRUE);

   return (FALSE);
   }

void *Copy_Basic_Object (Object)
   OBJECT *Object;
   {
   SHAPE *Local_Shape, *Copied_Shape;
   OBJECT *New_Object;

   New_Object = Get_Object();
   *New_Object = *Object;
   New_Object -> Next_Object = NULL;
   New_Object -> Bounding_Shapes = NULL;
   for (Local_Shape = Object -> Bounding_Shapes ;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object) {

      Copied_Shape = (SHAPE *) Copy((OBJECT *) Local_Shape);
      Link ((OBJECT *) Copied_Shape,
            (OBJECT **) &(Copied_Shape -> Next_Object),
            (OBJECT **) &(New_Object -> Bounding_Shapes));

      if ((Copied_Shape->Type == CSG_UNION_TYPE)
          || (Copied_Shape->Type == CSG_INTERSECTION_TYPE)
          || (Copied_Shape->Type == CSG_DIFFERENCE_TYPE))
         Set_CSG_Parents ((CSG_SHAPE *) Copied_Shape, New_Object);
      }

   New_Object -> Shape = (SHAPE *) Copy((OBJECT *) Object -> Shape);
   if ((New_Object->Shape->Type == CSG_UNION_TYPE)
       || (New_Object->Shape->Type == CSG_INTERSECTION_TYPE)
       || (New_Object->Shape->Type == CSG_DIFFERENCE_TYPE))
      Set_CSG_Parents ((CSG_SHAPE *) New_Object->Shape, New_Object);
   else
      New_Object->Shape->Parent_Object = New_Object;
   

   if (New_Object->Object_Texture != NULL)
      New_Object->Object_Texture = Copy_Texture (New_Object->Object_Texture);

   return (New_Object);
   }

void *Copy_Composite_Object (Object)
   OBJECT *Object;
   {
   COMPOSITE *New_Object;
   SHAPE *Local_Shape;
   OBJECT *Local_Object, *Copied_Object;

   New_Object = Get_Composite_Object();
   *New_Object = *((COMPOSITE *) Object);
   New_Object -> Next_Object = NULL;
   New_Object -> Objects = NULL;
   for (Local_Object = ((COMPOSITE *) Object) -> Objects;
        Local_Object != NULL ;
        Local_Object = Local_Object -> Next_Object) {

      Copied_Object = (OBJECT *) Copy(Local_Object);
      Link (Copied_Object,
            &(Copied_Object -> Next_Object),
            &(New_Object -> Objects));
      }

   New_Object -> Bounding_Shapes = NULL;
   for (Local_Shape = ((COMPOSITE *) Object) -> Bounding_Shapes;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object) {

      Copied_Object = (OBJECT *) Copy((OBJECT *) Local_Shape);
      Link (Copied_Object,
            &(Copied_Object -> Next_Object),
            (OBJECT **) &(New_Object -> Bounding_Shapes));
      }
   return (New_Object);
   }

void Translate_Basic_Object (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   SHAPE *Local_Shape;

   for (Local_Shape = Object -> Bounding_Shapes ;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object)

      Translate ((OBJECT *) Local_Shape, Vector);

   Translate ((OBJECT *) Object -> Shape, Vector);

   VAdd (Object -> Object_Center, Object -> Object_Center, *Vector);

   Translate_Texture (&Object->Object_Texture, Vector);
   }

void Rotate_Basic_Object (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   SHAPE *Local_Shape;
   TRANSFORMATION Transformation;

   for (Local_Shape = Object -> Bounding_Shapes ;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object)

      Rotate ((OBJECT *) Local_Shape, Vector);

   Rotate ((OBJECT *) Object -> Shape, Vector);
   Get_Rotation_Transformation (&Transformation, Vector);
   MTransformVector (&Object->Object_Center,
                     &Object->Object_Center, &Transformation);

   Rotate_Texture (&Object->Object_Texture, Vector);
   }

void Scale_Basic_Object (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   SHAPE *Local_Shape;

   for (Local_Shape = Object -> Bounding_Shapes ;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object)

      Scale ((OBJECT *) Local_Shape, Vector);

   Scale ((OBJECT *) Object -> Shape, Vector);

   VEvaluate (Object -> Object_Center, Object -> Object_Center, *Vector);

   Scale_Texture (&Object->Object_Texture, Vector);
   }

void Translate_Composite_Object (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   OBJECT *Local_Object;
   SHAPE *Local_Shape;

   for (Local_Object = ((COMPOSITE *) Object) -> Objects;
        Local_Object != NULL ;
        Local_Object = Local_Object -> Next_Object)
 
      Translate (Local_Object, Vector);   

   for (Local_Shape = ((COMPOSITE *) Object) -> Bounding_Shapes ;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object)

      Translate ((OBJECT *) Local_Shape, Vector);
   }

void Rotate_Composite_Object (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   OBJECT *Local_Object;
   SHAPE *Local_Shape;

   for (Local_Object = ((COMPOSITE *) Object) -> Objects;
        Local_Object != NULL ;
        Local_Object = Local_Object -> Next_Object)
 
      Rotate (Local_Object, Vector);   

   for (Local_Shape = ((COMPOSITE *) Object) -> Bounding_Shapes ;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object)

      Rotate ((OBJECT *) Local_Shape, Vector);
   }

void Scale_Composite_Object (Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
   {
   OBJECT *Local_Object;
   SHAPE *Local_Shape;

   for (Local_Object = ((COMPOSITE *) Object) -> Objects;
        Local_Object != NULL ;
        Local_Object = Local_Object -> Next_Object)
 
      Scale (Local_Object, Vector);   

   for (Local_Shape = ((COMPOSITE *) Object) -> Bounding_Shapes ;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object)

      Scale ((OBJECT *) Local_Shape, Vector);
   }


void Invert_Basic_Object (Object)
   OBJECT *Object;
   {
   SHAPE *Local_Shape;

   for (Local_Shape = Object -> Bounding_Shapes ;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object)

      Invert ((OBJECT *) Local_Shape);
   Invert ((OBJECT *) Object -> Shape);
   }

void Invert_Composite_Object (Object)
   OBJECT *Object;
   {
   OBJECT *Local_Object;
   SHAPE *Local_Shape;

   for (Local_Object = ((COMPOSITE *)Object) -> Objects;
        Local_Object != NULL ;
        Local_Object = Local_Object -> Next_Object)

      Invert (Local_Object);   

   for (Local_Shape = ((COMPOSITE *) Object) -> Bounding_Shapes ;
        Local_Shape != NULL ;
        Local_Shape = Local_Shape -> Next_Object)

      Invert ((OBJECT *) Local_Shape);
   }
