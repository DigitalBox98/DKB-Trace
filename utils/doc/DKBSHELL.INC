{
  This file is an include file for SHELLGEN.EXE (.BAS).  It describes the
  viewpoint, a simple sky, and a single light source.  This is just a starting
  point, as is all of the output from SHELLGEN.
}

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT {Hint:for starters, make "Z" 10 times the largest sphere radius } 
    LOCATION <0.0  0.0  -150.0> 
    DIRECTION <0.0 0.0  1.0>
    UP  <0.0  1.0  0.0>
    RIGHT <1.33333 0.0 0.0>
END_VIEW_POINT
 
OBJECT
   SPHERE <10.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <2.0  2.0  -250.0>
   ROTATE < -70.0 0.0 0.0 >
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT


{ Now draw the sky }
OBJECT
   SPHERE <0.0  0.0  0.0> 300.0 END_SPHERE
   TEXTURE
     COLOUR RED 0.0  GREEN 0.5 BLUE 1.0
     AMBIENT 0.7
     DIFFUSE 0.0   { we don't want clouds casting shadows on the sky }
   END_TEXTURE
END_OBJECT
