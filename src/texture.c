/*****************************************************************************
*
*                                   texture.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements solid texturing functions such as wood, marble, and
*  bozo.  The noise function used here is the one described by Ken Perlin in
*  "Hypertexture", SIGGRAPH '89 Conference Proceedings page 253.
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
*
*  The Noise and DNoise functions (and associated functions) were written by
*  Robert Skinner (robert@sgi.com) and are used here with his permission.
*  They are a lot better than the noise functions I had before!
*
*****************************************************************************/


#include "frame.h"
#include "vector.h"
#include "dkbproto.h"

extern long Calls_To_Noise, Calls_To_DNoise;

#define MINX	-10000		/* Ridiculously large scaling values */
#define MINY	MINX
#define MINZ	MINX

#define MAXSIZE 267
#define RNDMASK 0x7FFF
#define RNDDIVISOR (float) RNDMASK
#define NUMBER_OF_WAVES 10
#define SINTABSIZE 1000

#define FLOOR(x) ((x) >= 0.0 ? floor(x) : (0.0 - floor(0.0 - (x)) - 1.0))
#define FABS(x) ((x) < 0.0 ? (0.0 - x) : (x))
#define SCURVE(a) ((a)*(a)*(3.0-2.0*(a)))
#define REALSCALE ( 2.0 / 65535.0 )
#define Hash3d(a,b,c) hashTable[(int)(hashTable[(int)(hashTable[(int)((a) & 0xfffL)] ^ ((b) & 0xfffL))] ^ ((c) & 0xfffL))]
#define INCRSUM(m,s,x,y,z)	((s)*(RTable[m]*0.5		\
					+ RTable[m+1]*(x)	\
					+ RTable[m+2]*(y)	\
					+ RTable[m+3]*(z)))

extern int Options;

DBL sintab [SINTABSIZE];
DBL frequency[NUMBER_OF_WAVES];
VECTOR Wave_Sources[NUMBER_OF_WAVES];
DBL	RTable[MAXSIZE];
short *hashTable;
unsigned short crctab[256] =
{
   0x0000, 0xc0c1, 0xc181, 0x0140, 0xc301, 0x03c0, 0x0280, 0xc241,
   0xc601, 0x06c0, 0x0780, 0xc741, 0x0500, 0xc5c1, 0xc481, 0x0440,
   0xcc01, 0x0cc0, 0x0d80, 0xcd41, 0x0f00, 0xcfc1, 0xce81, 0x0e40,
   0x0a00, 0xcac1, 0xcb81, 0x0b40, 0xc901, 0x09c0, 0x0880, 0xc841,
   0xd801, 0x18c0, 0x1980, 0xd941, 0x1b00, 0xdbc1, 0xda81, 0x1a40,
   0x1e00, 0xdec1, 0xdf81, 0x1f40, 0xdd01, 0x1dc0, 0x1c80, 0xdc41,
   0x1400, 0xd4c1, 0xd581, 0x1540, 0xd701, 0x17c0, 0x1680, 0xd641,
   0xd201, 0x12c0, 0x1380, 0xd341, 0x1100, 0xd1c1, 0xd081, 0x1040,
   0xf001, 0x30c0, 0x3180, 0xf141, 0x3300, 0xf3c1, 0xf281, 0x3240,
   0x3600, 0xf6c1, 0xf781, 0x3740, 0xf501, 0x35c0, 0x3480, 0xf441,
   0x3c00, 0xfcc1, 0xfd81, 0x3d40, 0xff01, 0x3fc0, 0x3e80, 0xfe41,
   0xfa01, 0x3ac0, 0x3b80, 0xfb41, 0x3900, 0xf9c1, 0xf881, 0x3840,
   0x2800, 0xe8c1, 0xe981, 0x2940, 0xeb01, 0x2bc0, 0x2a80, 0xea41,
   0xee01, 0x2ec0, 0x2f80, 0xef41, 0x2d00, 0xedc1, 0xec81, 0x2c40,
   0xe401, 0x24c0, 0x2580, 0xe541, 0x2700, 0xe7c1, 0xe681, 0x2640,
   0x2200, 0xe2c1, 0xe381, 0x2340, 0xe101, 0x21c0, 0x2080, 0xe041,
   0xa001, 0x60c0, 0x6180, 0xa141, 0x6300, 0xa3c1, 0xa281, 0x6240,
   0x6600, 0xa6c1, 0xa781, 0x6740, 0xa501, 0x65c0, 0x6480, 0xa441,
   0x6c00, 0xacc1, 0xad81, 0x6d40, 0xaf01, 0x6fc0, 0x6e80, 0xae41,
   0xaa01, 0x6ac0, 0x6b80, 0xab41, 0x6900, 0xa9c1, 0xa881, 0x6840,
   0x7800, 0xb8c1, 0xb981, 0x7940, 0xbb01, 0x7bc0, 0x7a80, 0xba41,
   0xbe01, 0x7ec0, 0x7f80, 0xbf41, 0x7d00, 0xbdc1, 0xbc81, 0x7c40,
   0xb401, 0x74c0, 0x7580, 0xb541, 0x7700, 0xb7c1, 0xb681, 0x7640,
   0x7200, 0xb2c1, 0xb381, 0x7340, 0xb101, 0x71c0, 0x7080, 0xb041,
   0x5000, 0x90c1, 0x9181, 0x5140, 0x9301, 0x53c0, 0x5280, 0x9241,
   0x9601, 0x56c0, 0x5780, 0x9741, 0x5500, 0x95c1, 0x9481, 0x5440,
   0x9c01, 0x5cc0, 0x5d80, 0x9d41, 0x5f00, 0x9fc1, 0x9e81, 0x5e40,
   0x5a00, 0x9ac1, 0x9b81, 0x5b40, 0x9901, 0x59c0, 0x5880, 0x9841,
   0x8801, 0x48c0, 0x4980, 0x8941, 0x4b00, 0x8bc1, 0x8a81, 0x4a40,
   0x4e00, 0x8ec1, 0x8f81, 0x4f40, 0x8d01, 0x4dc0, 0x4c80, 0x8c41,
   0x4400, 0x84c1, 0x8581, 0x4540, 0x8701, 0x47c0, 0x4680, 0x8641,
   0x8201, 0x42c0, 0x4380, 0x8341, 0x4100, 0x81c1, 0x8081, 0x4040
};


void Compute_Colour (Colour, Colour_Map, value)
   COLOUR *Colour;
   COLOUR_MAP *Colour_Map;
   DBL value;
   {
   register int i;
   COLOUR_MAP_ENTRY *Entry;
   register DBL fraction;

   if (value > 1.0)
      value = 1.0;

   if (value < 0.0)
      value = 0.0;

   for (i = 0, Entry = &(Colour_Map->Colour_Map_Entries[0]) ; i < Colour_Map -> Number_Of_Entries ; i++, Entry++)
      if ((value >= Entry->start) && (value <= Entry->end))
      {
      fraction = (value - Entry->start) / (Entry->end - Entry->start);
      Colour -> Red = Entry->Start_Colour.Red + fraction * (Entry->End_Colour.Red - Entry->Start_Colour.Red);
      Colour -> Green = Entry->Start_Colour.Green + fraction * (Entry->End_Colour.Green - Entry->Start_Colour.Green);
      Colour -> Blue = Entry->Start_Colour.Blue + fraction * (Entry->End_Colour.Blue - Entry->Start_Colour.Blue);
      Colour -> Alpha = Entry->Start_Colour.Alpha + fraction * (Entry->End_Colour.Alpha - Entry->Start_Colour.Alpha);
      return;
      }

   Colour -> Red = 0.0;
   Colour -> Green = 0.0;
   Colour -> Blue = 0.0;
   Colour -> Alpha = 0.0;
   printf ("No colour for value: %g\n", value);
   return;
   }

void Initialize_Noise ()
   {
   register int i = 0;
   VECTOR point;

   InitRTable();

   for (i = 0 ; i < SINTABSIZE ; i++)
      sintab[i] = sin(i/(DBL)SINTABSIZE * (3.14159265359 * 2.0));

   for (i = 0 ; i < NUMBER_OF_WAVES ; i++)
      {
      DNoise (&point, (DBL) i, 0.0, 0.0);
      VNormalize (Wave_Sources[i], point);
      frequency[i] = (rand() & RNDMASK) / RNDDIVISOR + 0.01;
      }
   }

void InitTextureTable()
   {
   int i, j, temp;

   srand(0);

   if ((hashTable = (short int *) malloc(4096*sizeof(short int))) == NULL) {
      printf("Cannot allocate memory for hash table\n");
      exit(1);
      }
   for (i = 0; i < 4096; i++)
      hashTable[i] = i;
   for (i = 4095; i >= 0; i--) {
      j = rand() % 4096;
      temp = hashTable[i];
      hashTable[i] = hashTable[j];
      hashTable[j] = temp;
      }
   }


/* modified by AAC to work properly with little bitty integers (16 bits) */

void InitRTable()
   {
   int i;
   VECTOR rp;

   InitTextureTable();

   for (i = 0; i < MAXSIZE; i++)
      {
      rp.x = rp.y = rp.z = (DBL)i;
      RTable[i] = (unsigned int) R(&rp) * REALSCALE - 1.0;
      }
   }


int R(v)
   VECTOR *v;
   {
   v->x *= .12345;
   v->y *= .12345;
   v->z *= .12345;

   return (Crc16((char *) v, sizeof(VECTOR)));
   }

/*
 * Note that passing a VECTOR array to Crc16 and interpreting it as
 * an array of chars means that machines with different floating-point
 * representation schemes will evaluate Noise(point) differently.
 */

int Crc16(buf, count)
   register char *buf;
   register int  count;
   {
   register unsigned short crc = 0;

   while (count--)
      crc = (crc >> 8) ^ crctab[ (unsigned char) (crc ^ *buf++) ];

   return ((int) crc);
   }


/*
	Robert's Skinner's Perlin-style "Noise" function - modified by AAC
	to ensure uniformly distributed clamped values between 0 and 1.0...
*/

void setup_lattice(x, y, z, ix, iy, iz, jx, jy, jz, sx, sy, sz, tx, ty, tz)
   DBL *x, *y, *z, *sx, *sy, *sz, *tx, *ty, *tz;
   long *ix, *iy, *iz, *jx, *jy, *jz;
   {
   /* ensures the values are positive. */
   *x -= MINX;
   *y -= MINY;
   *z -= MINZ;

   /* its equivalent integer lattice point. */
   *ix = (long)*x; *iy = (long)*y; *iz = (long)*z;
   *jx = *ix + 1; *jy = *iy + 1; *jz = *iz + 1;

   *sx = SCURVE(*x - *ix); *sy = SCURVE(*y - *iy); *sz = SCURVE(*z - *iz);

   /* the complement values of sx,sy,sz */
   *tx = 1.0 - *sx; *ty = 1.0 - *sy; *tz = 1.0 - *sz;
   return;
   }


DBL Noise(x, y, z)
   DBL x, y, z;
   {
   long ix, iy, iz, jx, jy, jz;
   DBL sx, sy, sz, tx, ty, tz;
   DBL sum;
   short m;


   Calls_To_Noise++;
   
   setup_lattice(&x, &y, &z, &ix, &iy, &iz, &jx, &jy, &jz, &sx, &sy, &sz, &tx, &ty, &tz);

   /*
    *  interpolate!
    */
   m = Hash3d( ix, iy, iz ) & 0xFF;
   sum = INCRSUM(m,(tx*ty*tz),(x-ix),(y-iy),(z-iz));

   m = Hash3d( jx, iy, iz ) & 0xFF;
   sum += INCRSUM(m,(sx*ty*tz),(x-jx),(y-iy),(z-iz));

   m = Hash3d( ix, jy, iz ) & 0xFF;
   sum += INCRSUM(m,(tx*sy*tz),(x-ix),(y-jy),(z-iz));

   m = Hash3d( jx, jy, iz ) & 0xFF;
   sum += INCRSUM(m,(sx*sy*tz),(x-jx),(y-jy),(z-iz));

   m = Hash3d( ix, iy, jz ) & 0xFF;
   sum += INCRSUM(m,(tx*ty*sz),(x-ix),(y-iy),(z-jz));

   m = Hash3d( jx, iy, jz ) & 0xFF;
   sum += INCRSUM(m,(sx*ty*sz),(x-jx),(y-iy),(z-jz));

   m = Hash3d( ix, jy, jz ) & 0xFF;
   sum += INCRSUM(m,(tx*sy*sz),(x-ix),(y-jy),(z-jz));

   m = Hash3d( jx, jy, jz ) & 0xFF;
   sum += INCRSUM(m,(sx*sy*sz),(x-jx),(y-jy),(z-jz));

   sum = sum + 0.5;          /* range at this point -0.5 - 0.5... */
	
   if (sum < 0.0)
      sum = 0.0;
   if (sum > 1.0)
      sum = 1.0;

   return (sum);
   }


/*
       Vector-valued version of "Noise"
*/

void DNoise(result, x, y, z)
   VECTOR *result;
   DBL x, y, z;
   {
   long ix, iy, iz, jx, jy, jz;
   DBL px, py, pz, s;
   DBL sx, sy, sz, tx, ty, tz;
   short m;

   Calls_To_DNoise++;

   setup_lattice(&x, &y, &z, &ix, &iy, &iz, &jx, &jy, &jz, &sx, &sy, &sz, &tx, &ty, &tz);

   /*
    *  interpolate!
    */
   m = Hash3d( ix, iy, iz ) & 0xFF;
   px = x-ix;  py = y-iy;  pz = z-iz;
   s = tx*ty*tz;
   result->x = INCRSUM(m,s,px,py,pz);
   result->y = INCRSUM(m+4,s,px,py,pz);
   result->z = INCRSUM(m+8,s,px,py,pz);

   m = Hash3d( jx, iy, iz ) & 0xFF;
   px = x-jx;
   s = sx*ty*tz;
   result->x += INCRSUM(m,s,px,py,pz);
   result->y += INCRSUM(m+4,s,px,py,pz);
   result->z += INCRSUM(m+8,s,px,py,pz);

   m = Hash3d( jx, jy, iz ) & 0xFF;
   py = y-jy;
   s = sx*sy*tz;
   result->x += INCRSUM(m,s,px,py,pz);
   result->y += INCRSUM(m+4,s,px,py,pz);
   result->z += INCRSUM(m+8,s,px,py,pz);

   m = Hash3d( ix, jy, iz ) & 0xFF;
   px = x-ix;
   s = tx*sy*tz;
   result->x += INCRSUM(m,s,px,py,pz);
   result->y += INCRSUM(m+4,s,px,py,pz);
   result->z += INCRSUM(m+8,s,px,py,pz);

   m = Hash3d( ix, jy, jz ) & 0xFF;
   pz = z-jz;
   s = tx*sy*sz;
   result->x += INCRSUM(m,s,px,py,pz);
   result->y += INCRSUM(m+4,s,px,py,pz);
   result->z += INCRSUM(m+8,s,px,py,pz);

   m = Hash3d( jx, jy, jz ) & 0xFF;
   px = x-jx;
   s = sx*sy*sz;
   result->x += INCRSUM(m,s,px,py,pz);
   result->y += INCRSUM(m+4,s,px,py,pz);
   result->z += INCRSUM(m+8,s,px,py,pz);

   m = Hash3d( jx, iy, jz ) & 0xFF;
   py = y-iy;
   s = sx*ty*sz;
   result->x += INCRSUM(m,s,px,py,pz);
   result->y += INCRSUM(m+4,s,px,py,pz);
   result->z += INCRSUM(m+8,s,px,py,pz);

   m = Hash3d( ix, iy, jz ) & 0xFF;
   px = x-ix;
   s = tx*ty*sz;
   result->x += INCRSUM(m,s,px,py,pz);
   result->y += INCRSUM(m+4,s,px,py,pz);
   result->z += INCRSUM(m+8,s,px,py,pz);
   }

DBL Turbulence (x, y, z)
   DBL x, y, z;
   {
   register DBL pixelSize = 0.1;
   register DBL t = 0.0;
   register DBL scale, value;

   for (scale = 1.0 ; scale > pixelSize ; scale *= 0.5) {
      value = Noise (x/scale, y/scale, z/scale);
      t += FABS (value) * scale;
      }
   return (t);
   }

void DTurbulence (result, x, y, z)
   VECTOR *result;
   DBL x, y, z;
   {
   register DBL pixelSize = 0.01;
   register DBL scale;
   VECTOR value;

   result -> x = 0.0;
   result -> y = 0.0;
   result -> z = 0.0;

   value.x = value.y = value.z = 0.0;

   for (scale = 1.0 ; scale > pixelSize ; scale *= 0.5) {
      DNoise(&value, x/scale, y/scale, z/scale);
      result -> x += value.x * scale;
      result -> y += value.y * scale;
      result -> z += value.z * scale;
      }
   }

DBL cycloidal (value)
   DBL value;
   {

   if (value >= 0.0)
      return (sintab [(int)((value - floor (value)) * SINTABSIZE)]);
   else
      return (0.0 - sintab [(int)((0.0 - (value + floor (0.0 - value)))
                                    * SINTABSIZE)]);
   }


DBL Triangle_Wave (value)
   DBL value;
   {
   register DBL offset;

   if (value >= 0.0) offset = value - floor(value);
   else offset = value - (-1.0 - floor(FABS(value)));

   if (offset >= 0.5) return (2.0 * (1.0 - offset));
   else return (2.0 * offset);
   }


int Bozo (x, y, z, Texture, Colour)
DBL x, y, z;
TEXTURE *Texture;
COLOUR *Colour;
   {
   register DBL noise, turb;
   COLOUR New_Colour;
   VECTOR BozoTurbulence;


   if (Options & DEBUGGING)
      printf ("bozo %g %g %g ", x, y, z);

   if ((turb = Texture->Turbulence) != 0.0)
      {
      DTurbulence (&BozoTurbulence, x, y, z);
      x += BozoTurbulence.x * turb;
      y += BozoTurbulence.y * turb;
      z += BozoTurbulence.z * turb;
      }

   noise = Noise (x, y, z);

   if (Options & DEBUGGING)
      printf ("noise %g\n", noise);

   if (Texture -> Colour_Map != NULL) {
      Compute_Colour (&New_Colour, Texture->Colour_Map, noise);
      Colour -> Red += New_Colour.Red;
      Colour -> Green += New_Colour.Green;
      Colour -> Blue += New_Colour.Blue;
      Colour -> Alpha += New_Colour.Alpha;
      return (0);
      }

   if (noise < 0.4) {
      Colour -> Red += 1.0;
      Colour -> Green += 1.0;
      Colour -> Blue += 1.0;
      return (0);
      }

   if (noise < 0.6) {
      Colour -> Green += 1.0;
      return (0);
      }

   if (noise < 0.8) {
      Colour -> Blue += 1.0;
      return (0);
      }

   Colour -> Red += 1.0;
   return (0);
   }

int marble (x, y, z, Texture, colour)
   DBL x, y, z;
   TEXTURE *Texture;
   COLOUR *colour;
   {
   register DBL noise, hue;
   COLOUR New_Colour;

   noise = Triangle_Wave(x + Turbulence(x, y, z) * Texture -> Turbulence);

   if (Options & DEBUGGING)
      printf ("marble %g %g %g noise %g \n", x, y, z, noise);

   if (Texture -> Colour_Map != NULL)
      {
      Compute_Colour (&New_Colour, Texture->Colour_Map, noise);
      colour -> Red += New_Colour.Red;
      colour -> Green += New_Colour.Green;
      colour -> Blue += New_Colour.Blue;
      colour -> Alpha += New_Colour.Alpha;
      return (0);
      }

   if (noise < 0.0)
      {
      colour -> Red += 0.9;
      colour -> Green += 0.8;
      colour -> Blue += 0.8;
      }
   else if (noise < 0.9)
      {
      colour -> Red += 0.9;
      hue = 0.8 - noise * 0.8;
      colour -> Green += hue;
      colour -> Blue += hue;
      }
   return (0);
   }


void ripples (x, y, z, Texture, Vector)
   DBL x, y, z;
   TEXTURE *Texture;
   VECTOR *Vector;
   {
   register int i;
   VECTOR point;
   register DBL length, scalar, index;

   if (Options & DEBUGGING)
      printf ("ripples %g %g %g", x, y, z);

   for (i = 0 ; i < NUMBER_OF_WAVES ; i++) {
      point.x = x;
      point.y = y;
      point.z = z;
      VSub (point, point, Wave_Sources[i]);
      VDot (length, point, point);
      if (length == 0.0)
         length = 1.0;

      length = sqrt(length);
      index = length*Texture->Frequency
                    + Texture -> Phase;
      scalar = cycloidal (index) * Texture -> Bump_Amount;

      if (Options & DEBUGGING)
         printf (" index %g scalar %g length %g\n", index, scalar, length);
      
      VScale (point, point, scalar/length/(DBL)NUMBER_OF_WAVES);
      VAdd (*Vector, *Vector, point);
      }
   VNormalize (*Vector, *Vector);
   }

void waves (x, y, z, Texture, Vector)
   DBL x, y, z;
   TEXTURE *Texture;
   VECTOR *Vector;
   {
   register int i;
   VECTOR point;
   register DBL length, scalar, index, sinValue ;

   if (Options & DEBUGGING)
      printf ("waves %g %g %g\n", x, y, z);

   for (i = 0 ; i < NUMBER_OF_WAVES ; i++) {
      point.x = x;
      point.y = y;
      point.z = z;
      VSub (point, point, Wave_Sources[i]);
      VDot (length, point, point);
      if (length == 0.0)
         length = 1.0;

      length = sqrt(length);
      index = (length * Texture -> Frequency * frequency[i])
                   + Texture -> Phase;
      sinValue = cycloidal (index);

      scalar =  sinValue * Texture -> Bump_Amount /
                  frequency[i];
      VScale (point, point, scalar/length/(DBL)NUMBER_OF_WAVES);
      VAdd (*Vector, *Vector, point);
      }
   VNormalize (*Vector, *Vector);
   }

int wood (x, y, z, Texture, colour)
   DBL x, y, z;
   TEXTURE *Texture;
   COLOUR *colour;
   {
   register DBL noise, length;
   VECTOR WoodTurbulence;
   VECTOR point;
   COLOUR New_Colour;

   DTurbulence (&WoodTurbulence, x, y, z);

   if (Options & DEBUGGING)
      printf ("wood %g %g %g", x, y, z);

   point.x = cycloidal((x + WoodTurbulence.x)
               * Texture -> Turbulence);
   point.y = cycloidal((y + WoodTurbulence.y)
               * Texture -> Turbulence);
   point.z = 0.0;

   point.x += x;
   point.y += y;
   point.z += z;

   VLength (length, point);

   noise = Triangle_Wave(length);

   if (Options & DEBUGGING)
      printf ("noise %g\n", noise);

   if (Texture -> Colour_Map != NULL) {
      Compute_Colour (&New_Colour, Texture->Colour_Map, noise);
      colour -> Red += New_Colour.Red;
      colour -> Green += New_Colour.Green;
      colour -> Blue += New_Colour.Blue;
      colour -> Alpha += New_Colour.Alpha;
      return (0);
      }

   if (noise > 0.6) {
      colour -> Red += 0.4;
      colour -> Green += 0.133;
      colour -> Blue += 0.066;
      }
  else {
      colour -> Red += 0.666;
      colour -> Green += 0.312;
      colour -> Blue += 0.2;
      }
      return (0);
   }


void checker (x, y, z, Texture, colour)
   DBL x, y, z;
   TEXTURE *Texture;
   COLOUR *colour;
   {
   int brkindx;

   brkindx = (int) FLOOR(x) + (int) FLOOR(z);

   if (Options & DEBUGGING)
      printf ("checker %g %g %g\n", x, y, z);

   if (brkindx & 1)
      *colour = *Texture -> Colour1;
   else
      *colour = *Texture -> Colour2;
   return;
   }



void checker_texture (x, y, z, Texture, colour)
   DBL x, y, z;
   TEXTURE *Texture;
   COLOUR *colour;
   {
   int brkindx;
   VECTOR Point;

   brkindx = (int) FLOOR(x) + (int) FLOOR(z);

   if (Options & DEBUGGING)
      printf ("checker_texture %g %g %g\n", x, y, z);

   Make_Vector (&Point, x, y, z);

   if (brkindx & 1)
      Colour_At (colour, ((TEXTURE *) Texture -> Colour1), &Point);
   else
      Colour_At (colour, ((TEXTURE *) Texture -> Colour2), &Point);
   return;
   }



/*
   Ideas garnered from SIGGRAPH '85 Volume 19 Number 3, "An Image Synthesizer"
   By Ken Perlin.
*/


/*	
	With a little reflectivity and brilliance, can look like organ pipe
	metal.   With tiny scaling values can look like masonry or concrete.
	Works with color maps, supposedly. (?)
*/

void spotted (x, y, z, Texture, Colour)
   DBL x, y, z;
   TEXTURE *Texture;
   COLOUR *Colour;
   {
   register DBL noise;
   COLOUR New_Colour;

   noise = Noise (x, y, z);

   if (Options & DEBUGGING)
      printf ("spotted %g %g %g\n", x, y, z);

   if (Texture -> Colour_Map != NULL)
      {
      Compute_Colour (&New_Colour, Texture->Colour_Map, noise);
      Colour -> Red += New_Colour.Red;
      Colour -> Green += New_Colour.Green;
      Colour -> Blue += New_Colour.Blue;
      Colour -> Alpha += New_Colour.Alpha;
      return;
      }

   Colour -> Red += noise;             /* "white (1.0) * noise" */
   Colour -> Green += noise;
   Colour -> Blue += noise;

   return;
   }

void bumps (x, y, z, Texture, normal)
   DBL x, y, z;
   TEXTURE *Texture;
   VECTOR *normal;
   {
   VECTOR bump_turb;

   if (Texture -> Bump_Amount == 0.0)
      return;                            /* why are we here?? */

   if (Options & DEBUGGING)
      printf ("bumps %g %g %g\n", x, y, z);

   DNoise (&bump_turb, x, y, z);         /* Get Normal Displacement Val. */
   VScale(bump_turb, bump_turb, Texture->Bump_Amount);
   VAdd (*normal, *normal, bump_turb);   /* displace "normal" */
   VNormalize (*normal, *normal);        /* normalize normal! */
   return;
   }

/*
   dents is similar to bumps, but uses noise() to control the amount of
   dnoise() perturbation of the object normal...
*/

void dents (x, y, z, Texture, normal)
   DBL x, y, z;
   TEXTURE *Texture;
   VECTOR *normal;
   {
   VECTOR stucco_turb;
   DBL noise;

   if (Texture -> Bump_Amount == 0.0)
      return;                           /* why are we here?? */

   noise = Noise (x, y, z);

   noise =  noise * noise * noise * Texture->Bump_Amount;

   if (Options & DEBUGGING)
      printf ("dents %g %g %g noise %g\n", x, y, z, noise);

   DNoise (&stucco_turb, x, y, z);       /* Get Normal Displacement Val. */
	
   VScale (stucco_turb, stucco_turb, noise);
   VAdd (*normal, *normal, stucco_turb); /* displace "normal" */
   VNormalize (*normal, *normal);        /* normalize normal! */
   return;
   }


void agate (x, y, z, Texture, colour)
   DBL x, y, z;
   TEXTURE *Texture;
   COLOUR *colour;
   {
   register DBL noise, hue;
   COLOUR New_Colour;

   noise = cycloidal(1.3 * Turbulence(x, y, z) + 1.1 * z) + 1;
   noise *= 0.5;
   noise = pow(noise, 0.77);

   if (Options & DEBUGGING)
      printf ("agate %g %g %g noise %g\n", x, y, z, noise);

   if (Texture -> Colour_Map != NULL)
      {
      Compute_Colour (&New_Colour, Texture->Colour_Map, noise);
      colour -> Red += New_Colour.Red;
      colour -> Green += New_Colour.Green;
      colour -> Blue += New_Colour.Blue;
      colour -> Alpha += New_Colour.Alpha;
      return;
      }

   hue = 1.0 - noise;

   if (noise < 0.5)
      {
      colour -> Red += (1.0 - (noise / 10));
      colour -> Green += (1.0 - (noise / 5));
      colour -> Blue += hue;
      }
   else if (noise < 0.6)
      {
      colour -> Red += 0.9;
      colour -> Green += 0.7;
      colour -> Blue += hue;
      }
   else
      {
      colour -> Red += (0.6 + hue);
      colour -> Green += (0.3 + hue);
      colour -> Blue += hue;
      }
   return;
   }


/*
   Ideas garnered from the April 89 Byte Graphics Supplement on RenderMan,
   refined from "The RenderMan Companion, by Steve Upstill of Pixar, (C) 1990
   Addison-Wesley.
*/


/*
   wrinkles - This is my implementation of the dented() routine, using
   a surface iterative fractal derived from DTurbulence.  This is a 3-D vers.
   (thanks to DNoise()...) of the usual version using the singular Noise()...
   Seems to look a lot like wrinkles, however... (hmmm)
*/

void wrinkles (x, y, z, Texture, normal)
   DBL x, y, z;
   TEXTURE *Texture;
   VECTOR *normal;
   {
   register int i;
   register DBL scale = 1.0;
   VECTOR result, value;

   if (Texture -> Bump_Amount == 0.0)
      return;                                /* why are we here?? */

   if (Options & DEBUGGING)
      printf ("wrinkles %g %g %g\n", x, y, z);

   result.x = 0.0;
   result.y = 0.0;
   result.z = 0.0;

   for (i = 0; i < 10 ; scale *= 2.0, i++)
      {
      DNoise(&value, x * scale, y * scale, z * scale);   /* * scale,*/
      result.x += FABS (value.x / scale);
      result.y += FABS (value.y / scale);
      result.z += FABS (value.z / scale);
      }

   VScale(result, result, Texture->Bump_Amount);
   VAdd (*normal, *normal, result);             /* displace "normal" */
   VNormalize (*normal, *normal);               /* normalize normal! */
   return;
   }


/*
   Granite - kind of a union of the "spotted" and the "dented" textures,
   using a 1/f fractal noise function for color values.  Typically used
   w/ small scaling values.  Should work with colour maps for pink granite...
*/


void granite (x, y, z, Texture, Colour)
   DBL x, y, z;
   TEXTURE *Texture;
   COLOUR *Colour;
   {
   register int i;
   register DBL temp, noise = 0.0, freq = 1.0;
   COLOUR New_Colour;

   for (i = 0; i < 6 ; freq *= 2.0, i++)
      {
      temp = 0.5 - Noise (x * 4 * freq, y * 4 * freq, z * 4 * freq);
      temp = FABS(temp);
      noise += temp / freq;
      }

   if (Options & DEBUGGING)
      printf ("granite %g %g %g noise %g\n", x, y, z, noise);

   if (Texture -> Colour_Map != NULL)
      {
      Compute_Colour (&New_Colour, Texture->Colour_Map, noise);
      Colour -> Red += New_Colour.Red;
      Colour -> Green += New_Colour.Green;
      Colour -> Blue += New_Colour.Blue;
      Colour -> Alpha += New_Colour.Alpha;
      return;
      }

   Colour -> Red += noise;                  /* "white (1.0) * noise" */
   Colour -> Green += noise;
   Colour -> Blue += noise;

   return;
   }

/*
   Further Ideas Garnered from "The RenderMan Companion" (Addison Wesley)
*/


/*
   Color Gradient Texture - gradient based on the fractional values of x, y or
   z, based on whether or not the given directional vector is a 1.0 or a 0.0.
   Note - ONLY works with colour maps, preferably one that is circular - i.e.
   the last defined colour (value 1.001) is the same as the first colour (with
   a value of 0.0) in the map.  The basic concept of this is from DBW Render,
   but Dave Wecker's only supports simple Y axis gradients.
*/

void gradient (x, y, z, Texture, Colour)
   DBL x, y, z;
   TEXTURE *Texture;
   COLOUR *Colour;
   {
   COLOUR New_Colour;
   DBL value = 0.0, turb;
   VECTOR GradTurbulence;

   if ((turb = Texture->Turbulence) != 0.0)
      {
      DTurbulence (&GradTurbulence, x, y, z);
      x += GradTurbulence.x * turb;
      y += GradTurbulence.y * turb;
      z += GradTurbulence.z * turb;
      }

   if (Texture -> Colour_Map == NULL)
      return;
   if (Texture -> Texture_Gradient.x != 0.0)
      {
      x = FABS(x);
      value += x - FLOOR(x);	/* obtain fractional X component */
      }
   if (Texture -> Texture_Gradient.y != 0.0)
      {
      y = FABS(y);
      value += y - FLOOR(y);	/* obtain fractional Y component */
   }
   if (Texture -> Texture_Gradient.z != 0.0)
      {
      z = FABS(z);
      value += z - FLOOR(z);	/* obtain fractional Z component */
      }
   value = ((value > 1.0) ? fmod(value, 1.0) : value); /* clamp to 1.0 */

   if (Options & DEBUGGING)
      printf ("gradient %g %g %g value %g\n", x, y, z, value);

   Compute_Colour(&New_Colour, Texture->Colour_Map, value);
   Colour -> Red += New_Colour.Red;
   Colour -> Green += New_Colour.Green;
   Colour -> Blue += New_Colour.Blue;
   Colour -> Alpha += New_Colour.Alpha;
   return;
   }

/*
   2-D to 3-D Procedural Texture Mapping of a Bitmapped Image onto an Object:
	   
   Simplistic method of object image projection devised by DKB and AAC.

   1. Transform texture in 3-D space if requested.
   2. Determine local object 2-d coords from 3-d coords by <X Y Z> triple.
   3. Return pixel color value at that position on the 2-d plane of "Image".
   3. Map colour value in Image [0..255] to a more normal colour range [0..1].
*/

void texture_map (x, y, z, Texture, colour)
   DBL x, y, z;
   TEXTURE *Texture;
   COLOUR *colour;
   {
   /* determine local object 2-d coords from 3-d coords */
   /* "unwrap" object 2-d coord onto flat 2-d plane */
   /* return pixel color value at that posn on 2-d plane */

   int xcoor = 0, ycoor = 0;
   DBL width, height, turb;
   VECTOR TextureTurbulence;
   struct Image_Line *line;
   int reg_number;
   IMAGE_COLOUR *reg_colour;

   if ((turb = Texture->Turbulence) != 0.0)
      {
      DTurbulence (&TextureTurbulence, x, y, z);
      x += TextureTurbulence.x * turb;
      y += TextureTurbulence.y * turb;
      z += TextureTurbulence.z * turb;
      }

   width = Texture->Image->width;
   height = Texture->Image->height;

   if (Texture -> Texture_Gradient.x != 0.0) {
      if ((Texture->Once_Flag) &&
           ((x < 0.0) || (x > 1.0))) {

         Make_Colour (colour, 1.0, 1.0, 1.0);
         colour->Alpha = 1.0;
         return;
         }

      if (Texture -> Texture_Gradient.x > 0)
         xcoor = (int) fmod (x * width, width);
      else ycoor = (int) fmod (x * height, height);
      }

   if (Texture -> Texture_Gradient.y != 0.0) {
      if ((Texture->Once_Flag) &&
           ((y < 0.0) || (y > 1.0))) {

         Make_Colour (colour, 1.0, 1.0, 1.0);
         colour->Alpha = 1.0;
         return;
         }

      if (Texture -> Texture_Gradient.y > 0)
         xcoor = (int) fmod (y * width, width);
      else ycoor = (int) fmod (y * height, height);
      }

   if (Texture -> Texture_Gradient.z != 0.0) {
      if ((Texture->Once_Flag) &&
           ((z < 0.0) || (z > 1.0))) {
         Make_Colour (colour, 1.0, 1.0, 1.0);
         colour->Alpha = 1.0;
         return;
         }

      if (Texture -> Texture_Gradient.z > 0)
         xcoor = (int) fmod (z * width, width);
      else ycoor = (int) fmod (z * height, height);
      }

   /* Compensate for y coordinates on the images being upsidedown */
   ycoor = Texture->Image->iheight - ycoor;

   if (xcoor < 0)
      xcoor += Texture->Image->iwidth;
   else if (xcoor >= Texture->Image->iwidth)
      xcoor -= Texture->Image->iwidth;

   if (ycoor < 0)
      ycoor += Texture->Image->iheight;
   else if (ycoor >= Texture->Image->iheight)
      ycoor -= Texture->Image->iheight;

   if ((xcoor >= Texture->Image->iwidth) ||
       (ycoor >= Texture->Image->iheight) ||
       (xcoor < 0) || (ycoor < 0)) {
     printf ("Picture index out of range\n");
     close_all();
     exit (1);
     }

   if (Options & DEBUGGING)
      printf ("texture %g %g %g xcoor %d ycoor %d\n", x, y, z, xcoor, ycoor);

   if (Texture->Image->Colour_Map == NULL) {
      line = &Texture->Image->data.rgb_lines[ycoor];
      colour -> Red += (DBL) line->red[xcoor]/255.0;
      colour -> Green += (DBL) line->green[xcoor]/255.0;
      colour -> Blue += (DBL) line->blue[xcoor]/255.0;
      }
   else {
      reg_number = Texture->Image->data.map_lines[ycoor][xcoor];
      reg_colour = &Texture->Image->Colour_Map[reg_number];

      colour -> Red   += (DBL) reg_colour->Red/255.0;
      colour -> Green += (DBL) reg_colour->Green/255.0;
      colour -> Blue  += (DBL) reg_colour->Blue/255.0;
      colour -> Alpha += (DBL) reg_colour->Alpha/255.0;
      }
   }


void Translate_Texture (Texture_Ptr, Vector)
   TEXTURE **Texture_Ptr;
   VECTOR *Vector;
   {
   TEXTURE *Texture = *Texture_Ptr;
   TRANSFORMATION Transformation;

   while (Texture != NULL) {
      if (((Texture->Texture_Number != NO_TEXTURE)
            && (Texture->Texture_Number != COLOUR_TEXTURE))
         || (Texture->Bump_Number != NO_BUMPS)) {
      
         if (Texture->Constant_Flag) {
            Texture = Copy_Texture (Texture);
            *Texture_Ptr = Texture;
            Texture->Constant_Flag = FALSE;
            }

         if (!Texture -> Texture_Transformation)
            Texture -> Texture_Transformation = Get_Transformation ();
         Get_Translation_Transformation (&Transformation,
                                     Vector);
         Compose_Transformations (Texture -> Texture_Transformation,
                                  &Transformation);
         if (Texture->Texture_Number == CHECKER_TEXTURE_TEXTURE) {
            Translate_Texture ((TEXTURE **) &Texture->Colour1, Vector);
            Translate_Texture ((TEXTURE **) &Texture->Colour2, Vector);
            }
         }
      Texture_Ptr = &Texture->Next_Texture;
      Texture = Texture->Next_Texture;
      }
   }

void Rotate_Texture (Texture_Ptr, Vector)
   TEXTURE **Texture_Ptr;
   VECTOR *Vector;
   {
   TEXTURE *Texture = *Texture_Ptr;
   TRANSFORMATION Transformation;

   while (Texture != NULL) {
      if (((Texture->Texture_Number != NO_TEXTURE)
            && (Texture->Texture_Number != COLOUR_TEXTURE))
         || (Texture->Bump_Number != NO_BUMPS)) {
      
         if (Texture->Constant_Flag) {
            Texture = Copy_Texture (Texture);
            *Texture_Ptr = Texture;
            Texture->Constant_Flag = FALSE;
            }

         if (!Texture -> Texture_Transformation)
            Texture -> Texture_Transformation = Get_Transformation ();
         Get_Rotation_Transformation (&Transformation,
                                     Vector);
         Compose_Transformations (Texture -> Texture_Transformation,
                                  &Transformation);
         if (Texture->Texture_Number == CHECKER_TEXTURE_TEXTURE) {
            Rotate_Texture ((TEXTURE **) &Texture->Colour1, Vector);
            Rotate_Texture ((TEXTURE **) &Texture->Colour2, Vector);
            }
         }
      Texture_Ptr = &Texture->Next_Texture;
      Texture = Texture->Next_Texture;
      }
   }

void Scale_Texture (Texture_Ptr, Vector)
   TEXTURE **Texture_Ptr;
   VECTOR *Vector;
   {
   TEXTURE *Texture = *Texture_Ptr;
   TRANSFORMATION Transformation;

   while (Texture != NULL) {
      if (((Texture->Texture_Number != NO_TEXTURE)
            && (Texture->Texture_Number != COLOUR_TEXTURE))
         || (Texture->Bump_Number != NO_BUMPS)) {
      
         if (Texture->Constant_Flag) {
            Texture = Copy_Texture (Texture);
            *Texture_Ptr = Texture;
            Texture->Constant_Flag = FALSE;
            }

         if (!Texture -> Texture_Transformation)
            Texture -> Texture_Transformation = Get_Transformation ();
         Get_Scaling_Transformation (&Transformation,
                                     Vector);
         Compose_Transformations (Texture -> Texture_Transformation,
                                  &Transformation);

         if (Texture->Texture_Number == CHECKER_TEXTURE_TEXTURE) {
            Scale_Texture ((TEXTURE **) &Texture->Colour1, Vector);
            Scale_Texture ((TEXTURE **) &Texture->Colour2, Vector);
            }
         }
      Texture_Ptr = &Texture->Next_Texture;
      Texture = Texture->Next_Texture;
      }
   }

