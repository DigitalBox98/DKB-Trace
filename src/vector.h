/*****************************************************************************
*
*                                    vector.h
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module contains macros to perform operations on vectors.
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


/* Misc. Vector Math Macro Definitions */

extern DBL VTemp;

/* Vector Add */
#define VAdd(a, b, c) {(a).x=(b).x+(c).x;(a).y=(b).y+(c).y;(a).z=(b).z+(c).z;}

/* Vector Subtract */
#define VSub(a, b, c) {(a).x=(b).x-(c).x;(a).y=(b).y-(c).y;(a).z=(b).z-(c).z;}

/* Scale - Multiply Vector by a Scalar */
#define VScale(a, b, k) {(a).x=(b).x*(k);(a).y=(b).y*(k);(a).z=(b).z*(k);}

/* Inverse Scale - Divide Vector by a Scalar */
#define VInverseScale(a, b, k) {(a).x=(b).x/(k);(a).y=(b).y/(k);(a).z=(b).z/(k);}

/* Dot Product - Gives Scalar angle (a) between two vectors (b) and (c) */
#define VDot(a, b, c) {a=(b).x*(c).x+(b).y*(c).y+(b).z*(c).z;}

/* Cross Product - returns Vector (a) = (b) x (c) 
   WARNING:  a must be different from b and c.*/
#define VCross(a,b,c) {(a).x=(b).y*(c).z-(b).z*(c).y; \
                       (a).y=(b).z*(c).x-(b).x*(c).z; \
                       (a).z=(b).x*(c).y-(b).y*(c).x;}

/* Evaluate - returns Vector (a) = Multiply Vector (b) by Vector (c) */
#define VEvaluate(a, b, c) {(a).x=(b).x*(c).x;(a).y=(b).y*(c).y;(a).z=(b).z*(c).z;}

/* Square a Vector */
#define	VSqr(a) {(a).x*(a).x;(a).y*(a).y;(a).z*(a).z;}

/* Simple Scalar Square Macro */
#define	Sqr(a)	(a*a)

/* Square a Vector (b) and Assign to another Vector (a) */
#define VSquareTerms(a, b) {(a).x=(b).x*(b).x;(a).y=(b).y*(b).y;(a).z=(b).z*(b).z;}

/* Vector Length - returs Scalar Euclidean Length (a) of Vector (b) */
#define VLength(a, b) {a=sqrt((b).x*(b).x+(b).y*(b).y+(b).z*(b).z);}

/* Normalize a Vector - returns a vector (length of 1) that points at (b) */
#define VNormalize(a,b) {VTemp=sqrt((b).x*(b).x+(b).y*(b).y+(b).z*(b).z);(a).x=(b).x/VTemp;(a).y=(b).y/VTemp;(a).z=(b).z/VTemp;}

/* Compute a Vector (a) Halfway Between Two Given Vectors (b) and (c) */
#define VHalf(a, b, c) {(a).x=0.5*((b).x+(c).x);(a).y=0.5*((b).y+(c).y);(a).z=0.5*((b).z+(c).z);}
