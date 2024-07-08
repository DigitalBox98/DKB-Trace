/*****************************************************************************
*
*                                   quartics.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements the code for the quartic (4th order) shapes.
*
*  This file was written by Alexander Enzmann.  He wrote the code for DKB 2.11
*  QUARTICS (4th order shapes) and generously provided us these enhancements.
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


/* Basic form of a quartic equation
   a00*x^4 + a01*x^3*y + a02*x^3*z + a03*x^3 + a04*x^2*y^2 + 
   a05*x^2*y*z + a06*x^2*y + a07*x^2*z^2 + a08*x^2*z + a09*x^2 + 
   a10*x*y^3 + a11*x*y^2*z + a12*x*y^2 + a13*x*y*z^2 + a14*x*y*z + 
   a15*x*y + a16*x*z^3 + a17*x*z^2 + a18*x*z + a19*x + a20*y^4 + 
   a21*y^3*z + a22*y^3 + a23*y^2*z^2 + a24*y^2*z + a25*y^2 + a26*y*z^3 + 
   a27*y*z^2 + a28*y*z + a29*y + a30*z^4 + a31*z^3 + a32*z^2 + a33*z + a34
*/

int factorials[5] = {1, 1, 2, 6, 24};	/* 0!, 1!, 2!, 3!, 4! */
int term_counts[5] = {1, 4, 10, 20, 35};
int terms4[35][4] = {
   {4, 0, 0, 0 }, {3, 1, 0, 0 }, {3, 0, 1, 0 }, {3, 0, 0, 1 }, {2, 2, 0, 0 },
   {2, 1, 1, 0 }, {2, 1, 0, 1 }, {2, 0, 2, 0 }, {2, 0, 1, 1 }, {2, 0, 0, 2 },
   {1, 3, 0, 0 }, {1, 2, 1, 0 }, {1, 2, 0, 1 }, {1, 1, 2, 0 }, {1, 1, 1, 1 },
   {1, 1, 0, 2 }, {1, 0, 3, 0 }, {1, 0, 2, 1 }, {1, 0, 1, 2 }, {1, 0, 0, 3 },
   {0, 4, 0, 0 }, {0, 3, 1, 0 }, {0, 3, 0, 1 }, {0, 2, 2, 0 }, {0, 2, 1, 1 },
   {0, 2, 0, 2 }, {0, 1, 3, 0 }, {0, 1, 2, 1 }, {0, 1, 1, 2 }, {0, 1, 0, 3 },
   {0, 0, 4, 0 }, {0, 0, 3, 1 }, {0, 0, 2, 2 }, {0, 0, 1, 3 }, {0, 0, 0, 4 },
   };

int terms3[20][4] = {
   {3, 0, 0, 0 }, {2, 1, 0, 0 }, {2, 0, 1, 0 }, {2, 0, 0, 1 }, {1, 2, 0, 0 },
   {1, 1, 1, 0 }, {1, 1, 0, 1 }, {1, 0, 2, 0 }, {1, 0, 1, 1 }, {1, 0, 0, 2 },
   {0, 3, 0, 0 }, {0, 2, 1, 0 }, {0, 2, 0, 1 }, {0, 1, 2, 0 }, {0, 1, 1, 1 },
   {0, 1, 0, 2 }, {0, 0, 3, 0 }, {0, 0, 2, 1 }, {0, 0, 1, 2 }, {0, 0, 0, 3 },
   };

int terms2[10][4] = {
   {2, 0, 0, 0 }, {1, 1, 0, 0 }, {1, 0, 1, 0 }, {1, 0, 0, 1 }, {0, 2, 0, 0 },
   {0, 1, 1, 0 }, {0, 1, 0, 1 }, {0, 0, 2, 0 }, {0, 0, 1, 1 }, {0, 0, 0, 2 },
   };

int terms1[4][4] = {
   {1, 0, 0, 0 }, {0, 1, 0, 0 }, {0, 0, 1, 0 }, {0, 0, 0, 1 },
   };


METHODS Quartic_Methods =
   { Object_Intersect, All_Quartic_Intersections,
     Inside_Quartic, Quartic_Normal, Copy_Quartic,
     Translate_Quartic, Rotate_Quartic,
     Scale_Quartic, Invert_Quartic};

extern long Ray_Quartic_Tests, Ray_Quartic_Tests_Succeeded;

int
All_Quartic_Intersections(Object, Ray, Depth_Queue)
   OBJECT *Object;
   RAY *Ray;
   PRIOQ *Depth_Queue;
{
   QUARTIC *Shape = (QUARTIC *) Object;
   DBL Depths[4];
   VECTOR Intersection_Point;
   INTERSECTION Local_Element;
   int cnt, i, j, Intersection_Found;

   Intersection_Found = FALSE;
   Ray_Quartic_Tests++;
   cnt = Intersect_Quartic(Ray, Shape, &Depths[0]);
   if (cnt > 0) Ray_Quartic_Tests_Succeeded++;
   for (i=0;i<cnt;i++) {
      for (j=0;j<i;j++)
	 if (Depths[i] == Depths[j]) goto l0;

      if (Depths[i] < Small_Tolerance)
         continue;

      Local_Element.Depth = Depths[i];
      Local_Element.Object = Shape -> Parent_Object;
      VScale (Intersection_Point, Ray -> Direction, Depths[i]);
      VAdd (Intersection_Point, Intersection_Point, Ray -> Initial);
      Local_Element.Point = Intersection_Point;
      Local_Element.Shape = (SHAPE *)Shape;
      pq_add (Depth_Queue, &Local_Element);
      Intersection_Found = TRUE;
      l0:;
      }
   return (Intersection_Found);
}

/* Intersection of a ray and a quartic */
int
Intersect_Quartic(Ray, Shape, Depths)
   RAY *Ray;
   QUARTIC *Shape;
   DBL *Depths;
{
   DBL x,y,z,x2,y2,z2,x3,y3,z3,x4,y4,z4;
   DBL xx,yy,zz,xx2,yy2,zz2,xx3,yy3,zz3,xx4,yy4,zz4;
   DBL *a, t[5];

   x = Ray->Initial.x;
   y = Ray->Initial.y;
   z = Ray->Initial.z;
   xx = Ray->Direction.x;
   yy = Ray->Direction.y;
   zz = Ray->Direction.z;
   x2 = x * x;  y2 = y * y;  z2 = z * z;
   x3 = x * x2; y3 = y * y2; z3 = z * z2;
   x4 = x * x3; y4 = y * y3; z4 = z * z3;
   xx2 = xx * xx;  yy2 = yy * yy;  zz2 = zz * zz;
   xx3 = xx * xx2; yy3 = yy * yy2; zz3 = zz * zz2;
   xx4 = xx * xx3; yy4 = yy * yy3; zz4 = zz * zz3;
   a = Shape->Coeffs;

   /*
      Determine the coefficients of t^n, where the line is represented
      as (x,y,z) + (xx,yy,zz)*t.
   */
   t[0] = (a[ 0]*xx4+a[ 1]*xx3*yy+a[ 2]*xx3*zz+a[ 4]*xx2*yy2+
           a[ 5]*xx2*yy*zz+a[ 7]*xx2*zz2+a[10]*xx*yy3+
	   a[11]*xx*yy2*zz+a[13]*xx*yy*zz2+a[16]*xx*zz3+
	   a[20]*yy4+a[21]*yy3*zz+a[23]*yy2*zz2+a[26]*yy*zz3+a[30]*zz4);

   t[1] = (4*a[ 0]*x*xx3+
           a[ 1]*(3*x*xx2*yy+xx3*y)+
	   a[ 2]*(3*x*xx2*zz+xx3*z)+
	   a[ 3]*xx3+
	   a[ 4]*(2*x*xx*yy2+2*xx2*y*yy)+
	   a[ 5]*(xx2*(y*zz+yy*z)+2*x*xx*yy*zz)+
	   a[ 6]*xx2*yy+
	   a[ 7]*(2*x*xx*zz2+2*xx2*z*zz)+
	   a[ 8]*xx2*zz+
	   a[10]*(x*yy3+3*xx*y*yy2)+
	   a[11]*(xx*(2*y*yy*zz+yy2*z)+x*yy2*zz)+
	   a[12]*xx*yy2+
	   a[13]*(xx*(y*zz2+2*yy*z*zz)+x*yy*zz2)+
	   a[14]*xx*yy*zz+
	   a[16]*(x*zz3+3*xx*z*zz2)+
	   a[17]*xx*zz2+
	   4*a[20]*y*yy3+
	   a[21]*(3*y*yy2*zz+yy3*z)+
	   a[22]*yy3+
	   zz*(2*a[23]*yy*(y*zz+yy*z)+
	   a[24]*yy2+
	   zz*(a[26]*(y*zz+3*yy*z)+
	   a[27]*yy+zz*(4*a[30]*z+a[31]))));

   t[2] = (6*a[ 0]*x2*xx2+
           3*a[ 1]*x*xx*(x*yy+xx*y)+
           3*a[ 2]*x*xx*(x*zz+xx*z)+
	   3*a[ 3]*x*xx2+
	   a[ 4]*(x2*yy2+4*x*xx*y*yy+xx2*y2)+
	   a[ 5]*(x2*yy*zz+2*x*xx*(y*zz+yy*z)+xx2*y*z)+
	   a[ 6]*(2*x*xx*yy+xx2*y)+
	   a[ 7]*(x2*zz2+4*x*xx*z*zz+xx2*z2)+
	   a[ 8]*(2*x*xx*zz+xx2*z)+
	   a[ 9]*xx2+
	   a[10]*(3*x*y*yy2+3*xx*y2*yy)+
	   a[11]*(x*yy*(2*y*zz+yy*z)+xx*(y2*zz+2*y*yy*z))+
	   a[12]*(x*yy2+2*xx*y*yy)+
	   a[13]*(x*zz*(y*zz+2*yy*z)+xx*(2*y*z*zz+yy*z2))+
	   a[14]*(x*yy*zz+xx*(y*zz+yy*z))+
	   a[15]*xx*yy+
	   a[16]*(3*x*z*zz2+3*xx*z2*zz)+
	   a[17]*(x*zz2+2*xx*z*zz)+
	   a[18]*xx*zz+
	   6*a[20]*y2*yy2+
	   3*a[21]*y*yy*(y*zz+yy*z)+
	   3*a[22]*y*yy2+
	   a[23]*(y2*zz2+4*y*yy*z*zz+yy2*z2)+
	   a[24]*(2*y*yy*zz+yy2*z)+
	   a[25]*yy2+
	   zz*(3*a[26]*z*(y*zz+yy*z)+
	   a[27]*(y*zz+2*yy*z)+
	   a[28]*yy+
	   6*a[30]*z2*zz+
	   3*a[31]*z*zz+
	   a[32]*zz));

   t[3] = (4*a[ 0]*x3*xx+
           a[ 1]*x2*(x*yy+3*xx*y)+
	   a[ 2]*x2*(x*zz+3*xx*z)+
	   3*a[ 3]*x2*xx+
	   2*a[ 4]*x*y*(x*yy+xx*y)+
	   a[ 5]*x*(x*(y*zz+yy*z)+2*xx*y*z)+
	   a[ 6]*x*(x*yy+2*xx*y)+
	   2*a[ 7]*x*z*(x*zz+xx*z)+
	   a[ 8]*x*(x*zz+2*xx*z)+
	   2*a[ 9]*x*xx+
	   a[10]*(3*x*y2*yy-xx*y3)+
	   a[11]*(x*y*(y*zz+2*yy*z)+xx*y2*z)+
	   a[12]*(2*x*y*yy+xx*y2)+
	   a[13]*(x*z*(2*y*zz+yy*z)+xx*y*z2)+
	   a[14]*(x*(y*zz+yy*z)+xx*y*z)+
	   a[15]*(x*yy+xx*y)+
	   a[16]*(3*x*z2*zz+xx*z3)+
	   a[17]*(2*x*z*zz+xx*z2)+
	   a[18]*(x*zz+xx*z)+
	   a[19]*xx+
	   4*a[20]*y3*yy+
	   a[21]*y2*(y*zz+3*yy*z)+
	   3*a[22]*y2*yy+
	   2*a[23]*y*z*(y*zz+yy*z)+
	   a[24]*y*(y*zz+2*yy*z)+
	   2*a[25]*y*yy+
	   a[26]*(3*y*z2*zz+yy*z3)+
	   a[27]*(2*y*z*zz+yy*z2)+
	   a[28]*(y*zz+yy*z)+
	   a[29]*yy+
	   zz*(4*a[30]*z3+3*a[31]*z2+2*a[32]*z+a[33]));

   t[4] = a[ 0]*x4+a[ 1]*x3*y+a[ 2]*x3*z+a[ 3]*x3+a[ 4]*x2*y2+
	  a[ 5]*x2*y*z+a[ 6]*x2*y+a[ 7]*x2*z2+a[ 8]*x2*z+a[ 9]*x2+
	  a[10]*x*y3+a[11]*x*y2*z+a[12]*x*y2+a[13]*x*y*z2+a[14]*x*y*z+
	  a[15]*x*y+a[16]*x*z3+a[17]*x*z2+a[18]*x*z+a[19]*x+a[20]*y4+
	  a[21]*y3*z+a[22]*y3+a[23]*y2*z2+a[24]*y2*z+a[25]*y2+
	  a[26]*y*z3+a[27]*y*z2+a[28]*y*z+a[29]*y+a[30]*z4+a[31]*z3+
	  a[32]*z2+a[33]*z+a[34];
   return solve_quartic(t, Depths);
}

int
Inside_Quartic (point, Object)
   VECTOR *point;
   OBJECT *Object;
{
   QUARTIC *Shape = (QUARTIC *) Object;
   DBL Result,*a,x,y,z,x2,y2,z2,x3,y3,z3,x4,y4,z4;

   x = point->x; y = point->y; z = point->z;
   x2 = x * x;  y2 = y * y;  z2 = z * z;
   x3 = x * x2; y3 = y * y2; z3 = z * z2;
   x4 = x * x3; y4 = y * y3; z4 = z * z3;
   a = Shape->Coeffs;

   Result = a[ 0]*x4+a[ 1]*x3*y+a[ 2]*x3*z+a[ 3]*x3+a[ 4]*x2*y2+
	    a[ 5]*x2*y*z+a[ 6]*x2*y+a[ 7]*x2*z2+a[ 8]*x2*z+a[ 9]*x2+
	    a[10]*x*y3+a[11]*x*y2*z+a[12]*x*y2+a[13]*x*y*z2+a[14]*x*y*z+
	    a[15]*x*y+a[16]*x*z3+a[17]*x*z2+a[18]*x*z+a[19]*x+a[20]*y4+
	    a[21]*y3*z+a[22]*y3+a[23]*y2*z2+a[24]*y2*z+a[25]*y2+
	    a[26]*y*z3+a[27]*y*z2+a[28]*y*z+a[29]*y+a[30]*z4+a[31]*z3+
	    a[32]*z2+a[33]*z+a[34];

   if (Result < Small_Tolerance)
      return (TRUE);
   else
      return (FALSE);
}

/* Normal to a quartic */
void
Quartic_Normal(Result, Object, Intersection_Point)
   VECTOR *Result, *Intersection_Point;
   OBJECT *Object;
{
   QUARTIC *Shape = (QUARTIC *) Object;
   DBL *a,x,y,z,x2,y2,z2,x3,y3,z3,Len;

   a = Shape->Coeffs;
   x = Intersection_Point->x;
   y = Intersection_Point->y;
   z = Intersection_Point->z;
   x2 = x * x;  y2 = y * y;  z2 = z * z;
   x3 = x * x2; y3 = y * y2; z3 = z * z2;

   Result->x = 4*a[ 0]*x3+3*x2*(a[ 1]*y+a[ 2]*z+a[ 3])+
	       2*x*(a[ 4]*y2+y*(a[ 5]*z+a[ 6])+a[ 7]*z2+a[ 8]*z+a[ 9])+
	       a[10]*y3+y2*(a[11]*z+a[12])+y*(a[13]*z2+a[14]*z+a[15])+
	       a[16]*z3+a[17]*z2+a[18]*z+a[19];

   Result->y = a[ 1]*x3+x2*(2*a[ 4]*y+a[ 5]*z+a[ 6])+
	       x*(3*a[10]*y2+2*y*(a[11]*z+a[12])+a[13]*z2+a[14]*z+a[15])+
	       4*a[20]*y3+3*y2*(a[21]*z+a[22])+2*y*(a[23]*z2+a[24]*z+a[25])+
	       a[26]*z3+a[27]*z2+a[28]*z+a[29];

   Result->z = a[ 2]*x3+x2*(a[ 5]*y+2*a[ 7]*z+a[ 8])+
	       x*(a[11]*y2+y*(2*a[13]*z+a[14])+3*a[16]*z2+2*a[17]*z+a[18])+
	       a[21]*y3+y2*(2*a[23]*z+a[24])+y*(3*a[26]*z2+2*a[27]*z+a[28])+
	       4*a[30]*z3+3*a[31]*z2+2*a[32]*z+a[33];

   Len = Result->x * Result->x + Result->y * Result->y + Result->z * Result->z;
   Len = sqrt(Len);
   if (Len == 0.0) {
      /* The normal is not defined at this point of the surface.  Set it
         to any arbitrary direction. */
      Result->x = 1.0;
      Result->y = 0.0;
      Result->z = 0.0;
      }
   else {
      Result->x /= Len;		/* normalize the normal */
      Result->y /= Len;
      Result->z /= Len;
      }
   }

/* Make a copy of a quartic object */
void *
Copy_Quartic(Object)
   OBJECT *Object;
{
   QUARTIC *New_Shape;

   New_Shape = Get_Quartic_Shape ();
   *New_Shape = *((QUARTIC *) Object);
   New_Shape -> Next_Object = NULL;

   if (New_Shape->Shape_Texture != NULL)
      New_Shape->Shape_Texture = Copy_Texture (New_Shape->Shape_Texture);

   return (New_Shape);
}

/* Move a quartic */
void
Translate_Quartic(Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
{
   TRANSFORMATION Transformation;
   Get_Translation_Transformation(&Transformation, Vector);
   Transform_Quartic((QUARTIC *)Object,
		     (MATRIX *)&(Transformation.inverse[0][0]));
   Translate_Texture (&((QUARTIC *) Object)->Shape_Texture, Vector);
}

/* Rotation of a quartic */
void
Rotate_Quartic(Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
{
   TRANSFORMATION Transformation;
   Get_Rotation_Transformation(&Transformation, Vector);
   Transform_Quartic((QUARTIC *)Object,
		     (MATRIX *)&(Transformation.inverse[0][0]));
   Rotate_Texture (&((QUARTIC *) Object)->Shape_Texture, Vector);
}

/* Resize a quartic */
void
Scale_Quartic(Object, Vector)
   OBJECT *Object;
   VECTOR *Vector;
{
   TRANSFORMATION Transformation;
   Get_Scaling_Transformation (&Transformation, Vector);
   Transform_Quartic((QUARTIC *)Object,
		     (MATRIX *)&(Transformation.inverse[0][0]));
   Scale_Texture (&((QUARTIC *) Object)->Shape_Texture, Vector);
}

void
Invert_Quartic(Object)
   OBJECT *Object;
{
   QUARTIC *Shape = (QUARTIC *) Object;
   int i;
   for (i=0;i<35;i++)
      Shape->Coeffs[i] *= -1.0;
}

/* Given a set of power values from a term in the general quartic, return
   the index of the term. */
int
roll_term_indices(i, j, k)
   int i, j, k;
{
   int l, t;
   l = 4 - (i + j + k);
   if (i < 0 || i > 4 || j < 0 || j > 4 ||
       k < 0 || k > 4 || l < 0 || l > 4) {
      printf("Error in 'roll_term_indices': i = %d, j = %d, k = %d, l = %d\n",
	     i, j, k, l);
      exit(1);
      }
   for (t=0;t<term_counts[4];t++)
      if (i == terms4[t][0] && j == terms4[t][1] &&
          k == terms4[t][2] && l == terms4[t][3])
	 return t;
   printf("Term not  in 'roll_term_indices': i = %d, j = %d, k = %d, l = %d\n",
	     i, j, k, l);
   exit(1);
}

/* Given the total power and the index, return the individual powers */
void
unroll_term_indices( power, index, i, j, k, l)
   int power, index, *i, *j, *k, *l;
{
   if (power == 4) {
      *i = terms4[index][0];
      *j = terms4[index][1];
      *k = terms4[index][2];
      *l = terms4[index][3];
      }
   else if (power == 3) {
      *i = terms3[index][0];
      *j = terms3[index][1];
      *k = terms3[index][2];
      *l = terms3[index][3];
      }
   else if (power == 2) {
      *i = terms2[index][0];
      *j = terms2[index][1];
      *k = terms2[index][2];
      *l = terms2[index][3];
      }
   else if (power == 1) {
      *i = terms1[index][0];
      *j = terms1[index][1];
      *k = terms1[index][2];
      *l = terms1[index][3];
      }
   else {
      *i = 0;
      *j = 0;
      *k = 0;
      *l = 0;
      }
}

DBL
do_partial_term(q, row, power, i, j, k, l)
   MATRIX *q;
   int row, power, i, j, k, l;
{
   DBL result;
   result = ((DBL) factorials[power] /
		  (factorials[i]*factorials[j]*factorials[k]*factorials[l]));
   if (i>0) result *= POW((*q)[0][row], (DBL) i);
   if (j>0) result *= POW((*q)[1][row], (DBL) j);
   if (k>0) result *= POW((*q)[2][row], (DBL) k);
   if (l>0) result *= POW((*q)[3][row], (DBL) l);
   return result;
}

/* Using the transformation matrix q, transform the general quartic equation
   given by a. */
void
Transform_Quartic(Shape, q)
   QUARTIC *Shape;
   MATRIX *q;
{
   int term_index, partial_index;
   int ip, i, i0, i1, i2, i3;
   int jp, j, j0, j1, j2, j3;
   int kp, k, k0, k1, k2, k3;
   DBL b[35], partial_term;
   DBL tempx, tempy, tempz;

   /* Trim out any really low values from the transform. */
   for (i=0;i<4;i++) for (j=0;j<4;j++)
      if ((*q)[i][j] > -EPSILON && (*q)[i][j] < EPSILON) (*q)[i][j] = 0.0;

   for (i=0;i<35;i++) b[i] = 0.0;

   for (term_index=0;term_index<term_counts[4];term_index++) {
      if (Shape->Coeffs[term_index] == 0.0) continue;
      ip = terms4[term_index][0];	/* Power of original x term */
      jp = terms4[term_index][1];	/* Power of original y term */
      kp = terms4[term_index][2];	/* Power of original z term */
      /* Step through terms in: (q[0][0]*x+q[0][1]*y+q[0][2]*z+q[0][3])^i */
      for (i=0;i<term_counts[ip];i++) {
	 unroll_term_indices(ip, i, &i0, &i1, &i2, &i3);
	 tempx = do_partial_term(q, 0, ip, i0, i1, i2, i3);
	 if (tempx == 0.0) continue;

      /* Step through terms in: (q[1][0]*x+q[1][1]*y+q[1][2]*z+q[1][3])^j */
	 for (j=0;j<term_counts[jp];j++) {
	    unroll_term_indices(jp, j, &j0, &j1, &j2, &j3);
	    tempy = do_partial_term(q, 1, jp, j0, j1, j2, j3);
	    if (tempy == 0.0) continue;

      /* Step through terms in: (q[2][0]*x+q[2][1]*y+q[2][2]*z+q[2][3])^k */
	    for (k=0;k<term_counts[kp];k++) {
	       unroll_term_indices(kp, k, &k0, &k1, &k2, &k3);
	       tempz = do_partial_term(q, 2, kp, k0, k1, k2, k3);
 	       if (tempz == 0.0) continue;

	       /* Figure out it's index, and add it into the result */
	       partial_index = roll_term_indices(i0+j0+k0,i1+j1+k1,i2+j2+k2);
	       partial_term = Shape->Coeffs[term_index] * tempx * tempy * tempz;
	       b[partial_index] += partial_term;
	       }
	    }
	 }
      }
   for (i=0;i<35;i++) {
      if (b[i] > -EPSILON && b[i] < EPSILON)
	 Shape->Coeffs[i] = 0.0;
      else
	 Shape->Coeffs[i] = b[i];
      }
}
