/*****************************************************************************
*
*                                   vect.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements additional quartic math-helping functions.
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

#include <stdio.h>
#include <math.h>
#include "frame.h"
#include "dkbproto.h"

#ifdef ABS
#undef ABS
#endif

#define ABS(x) ((x) < 0.0 ? (0.0 - x) : (x))

#ifndef PI
#define PI   3.141592653589793238462643383280
#endif

#ifndef TWO_PI
#define TWO_PI 6.283185207179586476925286766560
#endif

#define TWO_PI_3  2.0943951023931954923084
#define TWO_PI_43 4.1887902047863909846168
#define MINUS_INFINITY -1.0e10
#define POSITIVE_INFINITY 1.0e10

#define EPSILON 1.0e-5

#ifdef TEST
void
show_poly(label, order, Coeffs)
   char *label;
   int order;
   DBL *Coeffs;
{
   int i;
   printf("%s", label);
   for (i=0;i<=order;i++) {
      printf("%.2lf x^%d", Coeffs[i], order-i);
      if (i==order) printf("\n");
      else printf(" + ");
      }
}

void
show_points(label, count, point_list)
   char *label;
   int count;
   DBL *point_list;
{
   int i;
   printf("%s", label);
   for (i=0;i<count;i++) {
      printf("%lf", point_list[i]);
      if (i==(count-1)) printf("\n");
      else printf(", ");
      }
}

/* Deflate a polynomial by the factor (x - a). */
void
deflate(n, coeffs, a)
   int n;
   DBL *coeffs;
   DBL a;
{
   register int i;
   DBL temp, rem = coeffs[0];
   coeffs[0] = 0.0;
   for (i=1;i<=n;i++) {
      temp = coeffs[i];
      coeffs[i] = rem;
      rem = temp + rem * a;
      }
}

/* find the coefficients of the derivative of a polynomial */
void
dydx(order, coeffs, dcoeffs)
   int order;
   DBL *coeffs;
   DBL *dcoeffs;
{
   register int i;
   for (i=0;i<order;i++)
      dcoeffs[i] = (order - i) * coeffs[i];
}

#define MAX_ITERATIONS 100
typedef void (*polyfunction) PARAMS((DBL x, int n, DBL *Coeffs, DBL *val, DBL *dx));

void
polyeval(x, n, Coeffs, val, dx)
   DBL x
   int n;
   DBL *Coeffs, *val, *dx;
{
   register int i;
   *val = Coeffs[0];
   *dx = 0.0;
   for (i=1;i<=n;i++) {
      *dx = *dx * x + *val;
      *val = *val * x + Coeffs[i];
      }
}

/* Solve for a single root of a polynomial, using a bracketed
   Newton-Raphson technique. 1 = root found, 0 = failure. */
int
rtsafe(funcd, n, Coeffs, x1, x2, epsilon, result)
   polyfunction funcd;
   int n;
   DBL *Coeffs, x1, x2, epsilon, *result;
{
   int j;
   DBL df, dx, dxold, f, fh, fl;
   DBL swap, temp, xh, xl, rts;
   (*funcd)(x1, n, Coeffs, &fl, &df);
   (*funcd)(x2, n, Coeffs, &fh, &df);
   if (ABS(fl) < epsilon) {
      /* Root is on the lower bound */
      *result = x1;
      return 1;
      }
   else if (ABS(fh) < epsilon) {
      /* Root is on the upper bound */
      *result = x2;
      return 1;
      }
   else if (fl * fh >= 0.0) {
      /* Bad bounds - function should change signs over the given interval */
      *result = 0.0;
      return 0;
      }
   if (fl < 0.0) {
      xl = x1;
      xh = x2;
      }
   else {
      xh = x1;
      xl = x2;
      swap = fl;
      fl = fh;
      fh = swap;
      }
   rts = 0.5 * (x1 + x2);
   dxold = ABS(x2-x1);
   dx = dxold;
   (*funcd)(rts, n, Coeffs, &f, &df);
   for (j=1;j<=MAX_ITERATIONS;j++) {
      if ((((rts-xh)*df-f)*((rts-xl)*df-f) >= 0.0) ||
	 /* Newton out of range, bisect instead */
	  (ABS(2.0*f) > ABS(dxold*df))) {
	 /* Newton not converging fast enough, bisect instead */
	 dxold = dx;
	 dx = 0.5 * (xh-xl);
	 rts = xl + dx;
	 if (xl == rts) {
	    *result = rts;
	    return 1;
	    }
	 }
      else {
	 dxold = dx;
	 dx = f / df;
	 temp = rts;
	 rts -= dx;
	 if (temp == rts) {
	    *result = rts;
	    return 1;
	    }
	 }
      if (ABS(dx) < epsilon) {
	 *result = rts;
	 return 1;
	 }
      (*funcd)(rts, n, Coeffs, &f, &df);
      if (f < 0.0) {
	 xl = rts;
	 fl = f;
	 }
      else {
	 xh = rts;
	 fh = f;
	 }
      }
   *result = 0.0;
   return 0;
}
#endif

/*
   Solve the quadratic equation:
      x[0] * x^2 + x[1] * x + x[2] = 0.

   The value returned by this function is the number of real roots.
   The roots themselves are returned in y[0], y[1].
*/
solve_quadratic(x, y)
   DBL *x, *y;
{
   DBL d, t, a, b, c;
   a = x[0];
   b = -x[1];
   c = x[2];
   if (a == 0.0) {
      if (b == 0.0)
         return 0;
      y[0] = -c / b;
      return 1;
      }
   d = b * b - 4.0 * a * c;
   if (d < 0.0) return 0;
   d = sqrt(d);
   t = 2.0 * a;
   y[0] = (b + d) / t;
   y[1] = (b - d) / t;
   return 2;
}

/*
   Solve the cubic equation:

      x[0] * x^3 + x[1] * x^2 + x[2] * x + x[3] = 0.

   The result of this function is an integer that tells how many real
   roots exist.  Determination of how many are distinct is up to the
   process that calls this routine.  The roots that exist are stored
   in (y[0], y[1], y[2]).

   Note: this function relies very heavily on trigonometric functions and
   the square root function.  If an alternative solution is found that does
   not rely on transcendentals this code will be replaced.
*/
int
solve_cubic(x, y)
   DBL *x, *y;
{
   DBL Q, R, Q3, R2, sQ, d, an, theta;
   DBL A2, a0, a1, a2, a3;
   a0 = x[0];
   if (a0 == 0.0) return solve_quadratic(&x[1], y);
   else if (a0 != 1.0) {
      a1 = x[1] / a0;
      a2 = x[2] / a0;
      a3 = x[3] / a0;
      }
   else {
      a1 = x[1];
      a2 = x[2];
      a3 = x[3];
      }
   A2 = a1 * a1;
   Q = (A2 - 3.0 * a2) / 9.0;
   R = (2.0 * A2 * a1 - 9.0 * a1 * a2 + 27.0 * a3) / 54.0;
   Q3 = Q * Q * Q;
   R2 = R * R;
   d = Q3 - R2;
   an = a1 / 3.0;
   if (d >= 0.0) {
      /* Three real roots. */
      d = R / sqrt(Q3);
      theta = acos(d) / 3.0;
      sQ = -2.0 * sqrt(Q);
      y[0] = sQ * cos(theta) - an;
      y[1] = sQ * cos(theta + TWO_PI_3) - an;
      y[2] = sQ * cos(theta + TWO_PI_43) - an;
      return 3;
      }
   else {
      sQ = pow(sqrt(R2 - Q3) + ABS(R), 1.0 / 3.0);
      if (R < 0)
	 y[0] = (sQ + Q / sQ) - an;
      else
	 y[0] = -(sQ + Q / sQ) - an;
      return 1;
      }
}

/*
   Solve the quartic equation:
      x[0] x^4 + x[1] x^3 + x[2] x^2 + x[3] x + x[4] = 0
   The value of this function is the number of real roots. The roots
   themselves are returned in results[0-3].

   Two methods of implementation are given, the first is faster by
   than the second by approximately 7-8% (with both in unoptimized form).
   Hand optimization of the first function has been implemented, resulting
   in a boost of around 15% of its speed.
*/

/* Solve a quartic using the method of Lodovico Ferrari (Circa 1731) */
int
solve_quartic(x, results)
   DBL *x, *results;
{
   DBL cubic[4], roots[3];
   DBL a0, a1, y, d1, x1, t1, t2;
   DBL c0, c1, c2, c3, c4, d2, q1, q2;
   int i, j;
   c0 = x[0];
   if (c0 == 0.0)
      return solve_cubic(&x[1], results);
   else if (x[4] == 0.0) {
      results[0] = 0.0;
      return 1 + solve_cubic(x, &results[1]);
      }
   else if (c0 != 1.0) {
      c1 = x[1] / c0;
      c2 = x[2] / c0;
      c3 = x[3] / c0;
      c4 = x[4] / c0;
      }
   else {
      c1 = x[1];
      c2 = x[2];
      c3 = x[3];
      c4 = x[4];
      }

   /* The first step is to take the original equation:

	 x^4 + b*x^3 + c*x^2 + d*x + e = 0

      and rewrite it as:

	 x^4 + b*x^3 = -c*x^2 - d*x - e,

      adding (b*x/2)^2 + (x^2 + b*x/2)y + y^2/4 to each side gives a
      perfect square on the lhs:

	 (x^2 + b*x/2 + y/2)^2 = (b^2/4 - c + y)x^2 + (b*y/2 - d)x + y^2/4 - e

      By choosing the appropriate value for y, the rhs can be made a perfect
      square also.  This value is found when the rhs is treated as a quadratic
      in x with the discriminant equal to 0.  This will be true when:

	 (b*y/2 - d)^2 - 4.0 * (b^2/4 - c*y)*(y^2/4 - e) = 0, or

	 y^3 - c*y^2 + (b*d - 4*e)*y - b^2*e + 4*c*e - d^2 = 0.

      This is called the resolvent of the quartic equation.  */

   a0 = 4.0 * c4;
   cubic[0] = 1.0;
   cubic[1] = -1.0 * c2;
   cubic[2] = c1 * c3 - a0;
   cubic[3] = a0 * c2 - c1 * c1 * c4 - c3 * c3;
   i = solve_cubic(&cubic[0], &roots[0]);
   if (i == 3)
      y = max(roots[0], max(roots[1], roots[2]));
   else
      y = roots[0];

   /* What we are left with is a quadratic squared on the lhs and a
      linear term on the right.  The linear term has one of two signs,
      take each and add it to the lhs.  The form of the quartic is now:

	 a' = b^2/4 - c + y,    b' = b*y/2 - d, (from rhs quadritic above)

	 (x^2 + b*x/2 + y/2) = +sqrt(a'*(x + 1/2 * b'/a')^2), and
	 (x^2 + b*x/2 + y/2) = -sqrt(a'*(x + 1/2 * b'/a')^2).

      By taking the linear term from each of the right hand sides and
      adding to the appropriate part of the left hand side, two quadratic
      formulas are created.  By solving each of these the four roots of
      the quartic are determined.
   */
   i = 0;
   a0 = c1 / 2.0;
   a1 = y / 2.0;

   t1 = a0 * a0 - c2 + y;
   if (t1 < 0.0) {
      /* First Special case, a' < 0 means all roots are complex. */
	if (t1 > -EPSILON)
	    t1 = 0;
	else return 0;
	}
   if (t1 == 0) {
      /* Second special case, the "x" term on the right hand side above
	 has vanished.  In this case:
	    (x^2 + b*x/2 + y/2) = +sqrt(y^2/4 - e), and
	    (x^2 + b*x/2 + y/2) = -sqrt(y^2/4 - e).  */
      t2 = a1 * a1 - c4;
      if (t2 < 0.0) return 0;
      x1 = 0.0;
      d1 = sqrt(t2);
      }
   else {
      x1 = sqrt(t1);
      d1 = 0.5 * (a0 * y - c3) / x1;
      }
   /* Solve the first quadratic */
   q1 = -a0 - x1;
   q2 = a1 + d1;
   d2 = q1 * q1 - 4.0 * q2;
   if (d2 >= 0.0) {
      d2 = sqrt(d2);
      results[0] = 0.5 * (q1 + d2);
      results[1] = 0.5 * (q1 - d2);
      i = 2;
      }
   /* Solve the second quadratic */
   q1 = q1 + x1 + x1;
   q2 = a1 - d1;
   d2 = q1 * q1 - 4.0 * q2;
   if (d2 >= 0.0) {
      d2 = sqrt(d2);
      results[i++] = 0.5 * (q1 + d2);
      results[i++] = 0.5 * (q1 - d2);
      }
   return i;
}

#ifdef TEST
/* Solve a quartic using the method of Francois Vieta (Circa 1735) */
int
solve_quartic1(x, results)
   DBL *x, *results;
{
   DBL cubic[4], roots[3];
   DBL A2, y, z, p, q, r, d1, d2;
   int i, j, k;
   if (x[0] == 0.0)
      return solve_cubic(&x[1], results);
   else if (x[4] == 0.0) {
      results[0] = 0.0;
      return 1 + solve_cubic(x, &results[1]);
      }
   else if (x[0] != 1.0)
      for (i=1;i<5;i++) x[i] /= x[0];

   /* Compute the cubic resolvant */
   A2 = x[1] * x[1];
   p = -3.0 * A2 / 8.0 + x[2];
   q = A2 * x[1] / 8.0 - x[1] * x[2] / 2.0 + x[3];
   r = -3.0 * A2 * A2 / 256.0 + A2 * x[2] / 16.0 - x[1] * x[3] / 4.0 + x[4];

   cubic[0] = 1.0;
   cubic[1] = -1.0 * p / 2.0;
   cubic[2] = -1.0 * r;
   cubic[3] = r * p / 2.0 - q * q / 8.0;
   k = solve_cubic(&cubic[0], &roots[0]);
   z = roots[0];
   if (k == 3)
      z = max(max(roots[0], roots[1]), roots[2]);
   else
      z = roots[0];
   d1 = 2.0 * z - p;
   if (d1 < 0.0)
      return 0;
   else if (d1 == 0.0) {
      d2 = z * z - r;
      if (d2 < 0.0) return 0;
      d2 = sqrt(d2);
      }
   else {
      d1 = sqrt(d1);
      d2 = 0.5 * q / d1;
      }
   i = 0;
   cubic[0] = 1.0;
   cubic[1] = d1;
   cubic[2] = z - d2;
   j = solve_quadratic(&cubic[0], &roots[0]);
   if (j==1)
      results[i++] = roots[0] - x[1] / 4.0;
   else if (j == 2) {
      results[i++] = roots[0] - x[1] / 4.0;
      results[i++] = roots[1] - x[1] / 4.0;
      }
   cubic[1] = -d1;
   cubic[2] = z + d2;
   j = solve_quadratic(&cubic[0], &roots[0]);
   if (j == 0)
      return i;
   else if (j==1)
      results[i++] = roots[0] - x[1] / 4.0;
   else {
      results[i++] = roots[0] - x[1] / 4.0;
      results[i++] = roots[1] - x[1] / 4.0;
      }
   return i;
}

#ifndef __TURBOC__
int _FAR_ _cdecl
dbl_sort_func(const void _FAR_ *a, const void _FAR_ *b)
#else
int
dbl_sort_func(a, b)
   void *a, *b;
#endif
{
   return *((DBL *)a) - *((DBL *)b);
}

/*
   Solve the nth order equation:
      x[0] x^n + x[1] x^(n-1) + ... + x[n-1] x + x[n] = 0
   The value of this function is the number of real roots. The roots
   themselves are returned in roots[0-(n-1)]. The roots will be in sorted
   order when they are returned.
*/
int
polysolve(order, Coeffs, roots)
   int order;
   DBL *Coeffs;
   DBL *roots;
{
   DBL val, dx;
   DBL *inflections, *derivative, root;
   register int i, j;
   int ipoints, rootcount;
   if (order == 2) {
      rootcount = solve_quadratic(Coeffs, roots);  
      if (rootcount == 2 && roots[0] > roots[1]) {
	 root = roots[0];
	 roots[0] = roots[1];
	 roots[1] = root;
	 }
      }
   else if (order == 3) {
      rootcount = solve_cubic(Coeffs, roots);
#ifndef __TURBOC__
      qsort((void _FAR_ *)roots, rootcount, sizeof(DBL), dbl_sort_func);
#else
      qsort((void *)roots, rootcount, sizeof(DBL), dbl_sort_func);
#endif
      }
   else if (order == 4) {
      rootcount = solve_quartic(Coeffs, roots);
      qsort((void *)roots, (size_t)rootcount, sizeof(DBL), dbl_sort_func);
      }
   else {
      inflections = (DBL *)malloc((order+1) * sizeof(DBL));
      if (!inflections) {
	 printf("Failed to allocate memory for inflections in polysolve\n");
	 exit(1);
	 }
      derivative = (DBL *)malloc(order * sizeof(DBL));
      if (!derivative) {
	 printf("Failed to allocate memory for derivative in polysolve\n");
	 exit(1);
	 }
      dydx(order, Coeffs, derivative);
      /* show_poly("Derivs  : ", order-1, derivative); */
      ipoints = polysolve(order-1, derivative, &inflections[1]);
      /* show_points("Inflect : ", ipoints, &inflections[1]); */
      /* Strip out redundant inflection points */
      for (i=1;i<ipoints;)
	 if (inflections[i] == inflections[i+1]) {
	    for (j=i;j<ipoints;j++)
	       inflections[j] = inflections[j+1];
	    ipoints--;
	    }
	 else
	    i++;
      /* show_points("Stripped: ", ipoints, &inflections[1]); */
      /* Add negative and positive infinity to the list */
      inflections[0] = MINUS_INFINITY;
      inflections[ipoints+1] = POSITIVE_INFINITY;
      /* Use bounded Newton-Raphson to solve for roots between points of
         inflection. (When their values differ in sign.) */
      rootcount = 0;
      for (i=0;i<=ipoints;i++)
	 if (rtsafe(polyeval, order, Coeffs, inflections[i],
		    inflections[i+1], EPSILON, &root))
	    roots[rootcount++] = root;
      /* Free up the temporary memory */
      free(derivative);
      free(inflections);
      }
   return rootcount;
}
#endif
