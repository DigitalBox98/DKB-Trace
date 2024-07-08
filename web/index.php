<?php

include("check_session.php");

?>

<!DOCTYPE html>
<html>
<head>
  <title>DKB Trace</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-3.2.0.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

</head>


<body onload="generateTokenId();">
	<h2><span class="label label-primary">DKB Trace Renderer 2.2</span></h2><br><br>

			
<form method="post" action="render.php">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Control Panel</h3>
  </div>
  <div class="panel-body">

  <!-- Token Id --> 
  <input type="text" name="token_id" id="token_id" style="display:none;">
	  
  <div class="dropdown">

    <button type="reset" class="btn btn-default">
      <span class="glyphicon glyphicon-cog"></span> Reset
    </button>
	
    <button type="button" class="btn btn-default" onclick="window.open('help.html','DKB-Trace Documentation','left=400,top=100,width=700,height=600');">
      <span class="glyphicon glyphicon-question-sign"></span> Documentation
    </button>

    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
	<span class="glyphicon glyphicon-star-empty"></span>
		Samples
    <span class="caret"></span></button>
    <ul class="dropdown-menu dropdown-menu-right">
      <li><a href="#">alphats2.dat</a></li>
      <li><a href="#">alphatst.dat</a></li>
      <li><a href="#">arches.dat</a></li>
      <li><a href="#">car.dat</a></li>
      <li><a href="#">checker2.dat</a></li>
      <li><a href="#">chess.dat</a></li>
      <li><a href="#">colortes.dat</a></li>
      <li><a href="#">desk.dat</a></li>
      <li><a href="#">devil.dat</a></li>
      <li><a href="#">dish.dat</a></li>
      <li><a href="#">eight.dat</a></li>
      <li><a href="#">fishx.dat</a></li>
      <li><a href="#">folium.dat</a></li>
      <li><a href="#">hyptorus.dat</a></li>
      <li><a href="#">illum1.dat</a></li>
      <li><a href="#">illum2.dat</a></li>
      <li><a href="#">image13.dat</a></li>
      <li><a href="#">kscope.dat</a></li>
      <li><a href="#">lamp.dat</a></li>
      <li><a href="#">lemnisc2.dat</a></li>
      <li><a href="#">lemnisca.dat</a></li>
      <li><a href="#">lily1.dat</a></li>
      <li><a href="#">lpops1.dat</a></li>
      <li><a href="#">lpops2.dat</a></li>
      <li><a href="#">monkey.dat</a></li>
      <li><a href="#">ntreal.dat</a></li>
      <li><a href="#">pacman.dat</a></li>
      <li><a href="#">partorus.dat</a></li>
      <li><a href="#">pencil.dat</a></li>
      <li><a href="#">piriform.dat</a></li>
      <li><a href="#">planet.dat</a></li>
      <li><a href="#">pool.dat</a></li>
      <li><a href="#">poolball.dat</a></li>
      <li><a href="#">quarcyl.dat</a></li>
      <li><a href="#">quarpara.dat</a></li>
      <li><a href="#">roman.dat</a></li>
      <li><a href="#">room.dat</a></li>
      <li><a href="#">rosetest.dat</a></li>
      <li><a href="#">skyvase.dat</a></li>
      <li><a href="#">snack.dat</a></li>
      <li><a href="#">spline.dat</a></li>
      <li><a href="#">stonewal.dat</a></li>
      <li><a href="#">sunset.dat</a></li>
      <li><a href="#">sunset1.dat</a></li>
      <li><a href="#">tcubic.dat</a></li>
      <li><a href="#">tetra.dat</a></li>
      <li><a href="#">tomb.dat</a></li>
      <li><a href="#">torus.dat</a></li>
      <li><a href="#">trough.dat</a></li>
      <li><a href="#">waterbow.dat</a></li>
      <li><a href="#">wealth.dat</a></li>
      <li><a href="#">window.dat</a></li>
      <li><a href="#">witch.dat</a></li>
    </ul>


    <button type="submit" class="btn btn-success">
      <span class="glyphicon glyphicon-play-circle"></span> Render
    </button>

  </div>

  </div>
</div>

		
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Parameters</h3>
  </div>
  <div class="panel-body">
	  

    <!-- wxxx = width of the screen -->
	Width : <input type="number" name="widthvalue" id="widthvalue" value="640" min="0" max="2560" step="10" onchange="changeWidthSliderValue(this.value)">
    (0 - 2560) <input type="range" name="witdh" id="widthslider" min="0" max="2560" value="640" step="10" style="width: 200px;" onchange="changeWidthValue(this.value)" > <br>
		
		
	<!-- hxxx = height of the screen -->
	Height : <input type="number" name="heightvalue" id="heightvalue" value="480" min="0" max="1920" step="10" onchange="changeHeightSliderValue(this.value)">
    (0 - 1920) <input type="range" name="height" id="heightslider" min="0" max="1920" value="480" step="10" style="width: 200px;" onchange="changeHeightValue(this.value)" > <br>
	
    <!-- a  = perform antialiasing (yes : +a or no : -a) -->
	<!-- If the anti-aliasing threshold is 0.0, then every pixel is
         supersampled.  If the threshold is 1.0, then no anti-aliasing
         is done.  Good values seem to be around 0.2 to 0.4.
	-->
	Antialiasing : <input name="antialiasing" value="0.3">
	(0.0 every pixel is supersamples. 1.0 no anti-aliasing. good values around 0.2 to 0.4) <br><br>
	
    <!-- qx = image quality 0=rough, 9=full -->
	Image quality : <input type="number" name="quality" value="9">
    (0=rough, 9=full) <br><br>

  </div>
</div>
	
	
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Scene Description : <label id="scenelabel">window.dat</label></h3>
  </div>
  <div class="panel-body">
	 
  
  <br>
  <textarea name="scene" id="scene" rows=25 cols=120>
{ Window Highlighting DKB Scene by Aaron A. Collins }
{ This file is hereby released to the public domain. }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ Someone to take in the breathtaking view... }

VIEW_POINT
   LOCATION <0.0  20.0  -100.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
END_VIEW_POINT

{ Put down the beloved famous raytrace green/yellow checkered floor }

OBJECT
   PLANE <0.0 1.0 0.0> -10.0 END_PLANE
   TEXTURE
      CHECKER COLOUR Yellow COLOUR Green
      SCALE < 20.0 20.0 20.0 >
      AMBIENT 0.1
      DIFFUSE 0.9
   END_TEXTURE
   COLOUR Yellow
END_OBJECT

{
 Now a Blue Plastic sphere floating in space over the ground - note that no 
 Phong or specular reflection is given.  Any would conflict with the window
 "highlights" by showing that they are not exactly in the mirror direction!
}

OBJECT
   SPHERE <0.0 25.0 0.0> 40.0 END_SPHERE
   TEXTURE
      COLOUR Blue
      REFLECTION 0.8
      AMBIENT 0.3
      DIFFUSE 0.7
   END_TEXTURE
   COLOUR Blue
END_OBJECT

{
 A wall with a window frame to block the light source and cast the shadows
}

OBJECT
  UNION
    TRIANGLE <-1000.0 -1000.0 0.0> <1000.0 4.0 0.0> <1000.0 -1000.0 0.0> END_TRIANGLE
    TRIANGLE <-1000.0 -1000.0 0.0> <1000.0 4.0 0.0> <-1000.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 4.0 0.0> <-1000.0 21.0 0.0> <-1000.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 4.0 0.0> <-1000.0 21.0 0.0> <4.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <-1000.0 21.0 0.0> <1000.0 1000.0 0.0> <-1000.0 1000.0 0.0> END_TRIANGLE
    TRIANGLE <-1000.0 21.0 0.0> <1000.0 1000.0 0.0> <1000.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <1000.0 4.0 0.0> <17.0 21.0 0.0> <1000.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <1000.0 4.0 0.0> <17.0 21.0 0.0> <17.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 12.0 0.0> <17.0 13.0 0.0> <4.0 13.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 12.0 0.0> <17.0 13.0 0.0> <17.0 12.0 0.0> END_TRIANGLE
    TRIANGLE <10.0 21.0 0.0> <11.0 4.0 0.0> <11.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <10.0 21.0 0.0> <11.0 4.0 0.0> <10.0 4.0 0.0> END_TRIANGLE
  END_UNION
  TRANSLATE <39.0 89.0 -120.0>
  TEXTURE
    COLOUR Black
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
END_OBJECT

{
  Now, the 4 actual "panes" to be reflected back onto the sphere for psuedo-
  "highlights".  They are not exactly co-incident with where the actual light
  source is, because they would block the light.  They are very near by where
  the openings are in the black wall above, close enough to give the proper
  illusion.  This is massive cheating, but then, this isn't reality, you see.
}

OBJECT
  UNION
    TRIANGLE <4.0 21.0 0.0> <10.0 13.0 0.0> <10.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 21.0 0.0> <10.0 13.0 0.0> <4.0 13.0 0.0> END_TRIANGLE

    TRIANGLE <11.0 21.0 0.0> <17.0 13.0 0.0> <11.0 13.0 0.0> END_TRIANGLE
    TRIANGLE <11.0 21.0 0.0> <17.0 13.0 0.0> <17.0 21.0 0.0> END_TRIANGLE

    TRIANGLE <4.0 12.0 0.0> <10.0 4.0 0.0> <4.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 12.0 0.0> <10.0 4.0 0.0> <10.0 12.0 0.0> END_TRIANGLE

    TRIANGLE <11.0 12.0 0.0> <17.0 4.0 0.0> <11.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <11.0 12.0 0.0> <17.0 4.0 0.0> <17.0 12.0 0.0> END_TRIANGLE
  END_UNION
  SCALE <15.0 15.0 15.0>
  TRANSLATE <20.0 90.0 -100.0>
  TEXTURE
    COLOUR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
END_OBJECT


{ A Light above the sphere, behind the camera and window frame for shadows }

OBJECT
   SPHERE <0.0 0.0 0.0> 0.001 END_SPHERE
   TRANSLATE <50.0 111.0 -130.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
  </textarea>
  
  
  </div>
</div>
  
  
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Control Panel</h3>
  </div>
  <div class="panel-body">
	  
    <button type="button" class="btn btn-primary" onclick="window.location.href='login.html';">
      <span class="glyphicon glyphicon-user"></span> Login 
    </button>

    <button type="reset" class="btn btn-default">
      <span class="glyphicon glyphicon-cog"></span> Reset
    </button>

    <button type="button" class="btn btn-default" onclick="window.open('help.html','DKB-Trace Documentation','left=400,top=100,width=700,height=600');">
      <span class="glyphicon glyphicon-question-sign"></span> Documentation
    </button>

    <button type="submit" class="btn btn-success">
      <span class="glyphicon glyphicon-play-circle"></span> Render 
    </button>

  </div>
</div>
  
  
  
</form>

<!-- Sample file : alphats2.dat -->

<textarea id="alphats2.dat" name="alphats2.dat" style="display:none;">
INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <0.0  20.0  -100.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
END_VIEW_POINT

FOG
   COLOUR RED 0.2 GREEN 0.2 BLUE 0.2
   200.0
END_FOG

{ Put down the beloved famous raytrace green/yellow checkered floor }
OBJECT
   PLANE <0.0 1.0 0.0> -10.0 END_PLANE
   TEXTURE
      CHECKER COLOUR Yellow COLOUR Green
      AMBIENT 0.2
      DIFFUSE 0.8
      SCALE < 20.0 20.0 20.0 >
   END_TEXTURE
   COLOUR Yellow
END_OBJECT

OBJECT
   SPHERE <0.0  25.0  0.0>  40.0 END_SPHERE

   TEXTURE
      AMBIENT 0.2
      DIFFUSE 0.6
      COLOUR Red
      SCALE <10.0 10.0 10.0>
      ROTATE <-90.0 0.0 0.0>
      PHONG 1.0
      PHONGSIZE 20
   END_TEXTURE
   COLOUR Red
END_OBJECT

OBJECT
   SPHERE <-100.0  150.0  200.0>  20.0 END_SPHERE
   TEXTURE
      COLOUR Magenta
      AMBIENT 0.2
      DIFFUSE 0.6
      PHONG 1.0
      PHONGSIZE 20
   END_TEXTURE
   COLOUR Magenta
END_OBJECT

OBJECT
   SPHERE <100.0  25.0  100.0>  30.0 END_SPHERE

   TEXTURE
      COLOUR Red
      AMBIENT 0.2
      DIFFUSE 0.6
      PHONG 1.0
      PHONGSIZE 20
   END_TEXTURE
   COLOUR Red
END_OBJECT

OBJECT
   SPHERE <0.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <100.0  120.0  40.0>
   TEXTURE
      COLOUR White
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT	
</textarea>



<!-- Sample file : alphatst.dat -->

<textarea id="alphatst.dat" name="alphatst.dat" style="display:none;">
INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <0.0  20.0  -100.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
END_VIEW_POINT

OBJECT
   PLANE <0.0 1.0 0.0> -10.0 END_PLANE
   COLOUR White
   TEXTURE
      COLOUR White
      AMBIENT 0.2
      DIFFUSE 0.8
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0  25.0  0.0>  40.0 END_SPHERE

   TEXTURE
      COLOUR Red
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <100.0  120.0  40.0>
   TEXTURE
      COLOUR White
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>
	
<!-- Sample file : arches.dat -->

<textarea id="arches.dat" name="arches.dat" style="display:none;">
   {  Author name : Dan Farmer
                    Minneapolis, MN

      Parabolic arches on the water.  Is this the St. Louis McDonalds?

      This data file is for use with DKBTrace by David Buck.  This file
      is released to the public domain and may be used or altered by
      anyone as desired. }

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"		{ Includes the new "Polished_Metal" texture }

VIEW_POINT
   LOCATION <60.0  0.0  -135.0>
   DIRECTION <0.0 0.0  2.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
   LOOK_AT <0.0 0.0 0.0>
END_VIEW_POINT

{ Light }
OBJECT  
   SPHERE <0.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <200.0  200.0  -150.0>
   TEXTURE
      COLOUR Orange             { Note the color of light}
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR Orange
END_OBJECT

{ Now draw the sky (From SUNSET.DAT }
OBJECT
   SPHERE <0.0  0.0  0.0> 300.0 END_SPHERE
   TEXTURE
      0.05
      GRADIENT <0.0  1.0  0.0>
      COLOUR_MAP [0.0 0.8  COLOUR RED 0.5 GREEN 0.1 BLUE 0.7
                           COLOUR RED 0.1 GREEN 0.1 BLUE 0.9]
                 [0.8 1.0 COLOUR RED 0.1 GREEN 0.1 BLUE 0.9
                          COLOUR RED 0.1 GREEN 0.1 BLUE 0.9]
      END_COLOUR_MAP
      SCALE <300.0  300.0  300.0>
      AMBIENT 0.7
      DIFFUSE 0.0   { we don't want clouds casting shadows on the sky }
   END_TEXTURE
   COLOUR RED 0.7  GREEN 0.7 BLUE 1.0
END_OBJECT

{ Put in a few clouds }

OBJECT
   SPHERE <0.0  0.0  0.0> 259.0 END_SPHERE

   TEXTURE
      BOZO
      TURBULENCE 0.7
      COLOUR_MAP
          [0.0 0.6  COLOUR RED 1.0 GREEN 1.0 BLUE 1.0 ALPHA 1.0
                    COLOUR RED 1.0 GREEN 1.0 BLUE 1.0 ALPHA 1.0]
          [0.6 0.8 COLOUR RED 1.0 GREEN 1.0 BLUE 1.0 ALPHA 1.0
                    COLOUR RED 1.0 GREEN 1.0 BLUE 1.0]
          [0.8 1.001 COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
                     COLOUR RED 0.8 GREEN 0.8 BLUE 0.8]
      END_COLOUR_MAP
      SCALE <100.0  20.0  100.0>
      AMBIENT 0.7
      DIFFUSE 0.0
   END_TEXTURE
   COLOUR RED 0.7  GREEN 0.7  BLUE 1.0
END_OBJECT



{ Define the ocean surface }
OBJECT
   PLANE <0.0  1.0  0.0> -10.0 END_PLANE

   TEXTURE
      COLOUR Blue
      WAVES 0.05
      REFLECTION 0.8
      FREQUENCY 5000.0
      SCALE <3000.0 3000.0 3000.0>
   END_TEXTURE
   COLOUR Blue
END_OBJECT

{ Put a floor underneath to catch any errant waves from the ripples }
OBJECT
   PLANE <0.0  1.0  0.0> -11.0 END_PLANE
   TEXTURE
      0.05
      COLOUR Blue
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   COLOUR Blue
END_OBJECT


COMPOSITE
  OBJECT
    DIFFERENCE
        QUADRIC Paraboloid_Y			{ Declared in SHAPES.DAT }
            SCALE <20.0 20.0 5.0>
            ROTATE <180.0 0.0 0.0>
            TRANSLATE <0.0 0.0 0.0>
        END_QUADRIC
        QUADRIC Paraboloid_Y
            SCALE <15.0 20.0 15.0>
            ROTATE <180.0 0.0 0.0>
            TRANSLATE <0.0 -2.0 0.0>
        END_QUADRIC
    END_DIFFERENCE
    TEXTURE
        Polished_Metal				{ Declared in TEXTURES.DAT }
	0.05
        COLOR White				{ Declared in COLORS.DAT }
    END_TEXTURE
    COLOR White
  END_OBJECT
TRANSLATE <0.0 30.0 -25.0>
END_COMPOSITE

COMPOSITE
  OBJECT
    DIFFERENCE
        QUADRIC Paraboloid_Y
            SCALE <20.0 20.0 5.0>
            ROTATE <180.0 0.0 0.0>
            TRANSLATE <0.0 0.0 0.0>
        END_QUADRIC
        QUADRIC Paraboloid_Y
            SCALE <15.0 20.0 15.0>
            ROTATE <180.0 0.0 0.0>
            TRANSLATE <0.0 -2.0 0.0>
        END_QUADRIC
    END_DIFFERENCE
    TEXTURE
        Polished_Metal
	0.05
	COLOR White
    END_TEXTURE
    COLOR White
  END_OBJECT
TRANSLATE <0.0 30.0 50.0>
END_COMPOSITE
</textarea>

<!-- Sample file : car.dat -->

<textarea id="car.dat" name="car.dat" style="display:none;">
{
   ÛÛÛÛÛÛÛÛ    ÛÛÛ    ÛÛÛ  ÛÛÛÛÛÛÛÛ
  °ÛÛÛÛÛÛÛÛÛÛ °ÛÛÛ  °ÛÛÛÛ °ÛÛÛÛÛÛÛÛÛÛ
  °ÛÛÛ    ÛÛÛ °ÛÛÛÛÛÛÛÛ   °ÛÛÛ   °ÛÛÛ    ÛÛ
  °ÛÛÛ    ÛÛÛ °ÛÛÛÛÛÛÛ    °ÛÛÛÛÛÛÛÛÛ    ÛÛÛÛ  ÛÛ  Û  ÛÛÛÛÛ  ÜÛÛÛÛ  ÜÛÛÛÛ
  °ÛÛÛ    ÛÛÛ °ÛÛÛ °ÛÛÛ   °ÛÛÛ   °ÛÛÛ  °°ÛÛ  °ÛÛÛÛ °ÛÛ °ÛÛ °ÛÛ°°  °ÛÛÜÜÛ
  °ÛÛÛÛÛÛÛÛÛÛ °ÛÛÛ  °ÛÛÛÛ °ÛÛÛÛÛÛÛÛÛÛ   °ÛÛ  °ÛÛ   °ÛÛ °ÛÛ °ÛÛ    °ÛÛ°°
  °ÛÛÛÛÛÛÛÛ   °ÛÛÛ   °ÛÛÛ °ÛÛÛÛÛÛÛÛ     °ÛÛÛÛ°ÛÛ   °°ÛÛÛÛÛÜ°°ÛÛÛÛ °°ÛÛÛÛ
  °°°°°°°°    °°°    °°°  °°°°°°°°      °°°° °°     °°°°°°  °°°°   °°°°

 CAR.DAT  DKBTrace Script             February 27, '91

 By Jorge Arreguin
    I. Allende # 611
    Cortazar , Gto.
    Mexico  CP 38300
    
    Renders a Futuristic Car, making a diferent use of the imagemap

    This data file is for use with DKBTrace by David Buck.  This file
    is released to the public domain and may be used or altered by
    anyone as desired.
}

{-----------------------------DECLARACIONES------------------------}

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

DECLARE JA_Hyperboloid = QUADRIC
       <  1.0  -1.0  1.0>
       <  0.0   0.0  0.0>
       <  0.0   0.0  0.0>
      -0.6
END_QUADRIC

DECLARE Near_Black = COLOUR RED 0.1 GREEN 0.1 BLUE 0.1

DECLARE Llanta = INTERSECTION
 QUADRIC Sphere SCALE < 1.0 1.0 1.0 > END_QUADRIC
 QUADRIC JA_Hyperboloid SCALE < 0.7 0.3 0.7 > INVERSE END_QUADRIC
END_INTERSECTION

DECLARE Polvera = OBJECT
 QUADRIC Sphere SCALE < 0.8 0.2 0.8 > END_QUADRIC
 TEXTURE
  COLOR Gray
  REFLECTION 0.3
  PHONG 0.8
  PHONGSIZE 10.0
 END_TEXTURE
 COLOR Gray
END_OBJECT

VIEW_POINT
   LOCATION <0.0  -33.0  0.0>
   DIRECTION <0.0 2.0  0.0>
   UP  <0.0  0.0  1.0>
   RIGHT <1.33333 0.0 0.0>
   ROTATE < -30.0 0.0 30.0 >
END_VIEW_POINT

OBJECT
   SPHERE <0.0  0.0  0.0>  5.0 END_SPHERE
   TRANSLATE <-10.0  -30.0  50.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT  
   SPHERE <0.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <40.0  -40.0  45.0>
   COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

{--------------------------------------- CUERPO --------------------}

OBJECT
 INTERSECTION
  QUADRIC
    Sphere
    SCALE < 10.0 10.0 4.0 >
  END_QUADRIC
  PLANE < 1.0 0.0 0.0 > 0.0
    ROTATE < 0.0 -16.2379 0.0 >
    TRANSLATE < -5.0 0.0 0.0 >
    INVERSE
  END_PLANE
  PLANE < 0.0 0.0 1.0 > 0.01 END_PLANE
  PLANE < 0.0 0.0 1.0 > 0.005 INVERSE END_PLANE
  QUADRIC
    Cylinder_X
    SCALE < 1.0 5.0 5.0 >
  END_QUADRIC
 END_INTERSECTION
 BOUNDED_BY SPHERE < 0.0 0.0 0.0 > 10.0 END_SPHERE END_BOUND
 TEXTURE
  COLOR Blue
  REFLECTION 0.4
 END_TEXTURE
 COLOR Blue
END_OBJECT

OBJECT
 UNION
  INTERSECTION
   QUADRIC
    Sphere
    SCALE < 10.0 10.0 4.0 >
   END_QUADRIC
   PLANE < 1.0 0.0 0.0 > 0.0
    ROTATE < 0.0 -16.2379 0.0 >
    TRANSLATE < -5.0 0.0 0.0 >
    INVERSE
   END_PLANE
   PLANE < 0.0 0.0 1.0 > 0.01 INVERSE END_PLANE
   QUADRIC
    Cylinder_X
    SCALE < 1.0 5.0 5.0 >
   END_QUADRIC
  END_INTERSECTION
  INTERSECTION
   QUADRIC
    Sphere
    SCALE < 3.352 8.380 3.352 >
    ROTATE < 0.0 -16.2379 0.0 >
    TRANSLATE < -5.0 0.0 0.0 >
   END_QUADRIC
   PLANE < 1.0 0.0 0.0 > 0.0
    ROTATE < 0.0 -16.2379 0.0 >
    TRANSLATE < -5.0 0.0 0.0 >
   END_PLANE
   PLANE < 1.0 0.0 0.0 > 0.0
    ROTATE < 0.0 -64.0 0.0 >
    TRANSLATE < -5.0 0.0 0.0 >
    INVERSE
   END_PLANE
   PLANE < 0.0 0.0 1.0 > 0.01 INVERSE END_PLANE
   QUADRIC
    Cylinder_X
    SCALE < 1.0 5.0 5.0 >
   END_QUADRIC
  END_INTERSECTION
 END_UNION
 BOUNDED_BY SPHERE < 0.0 0.0 0.0 > 10.0 END_SPHERE END_BOUND
 TEXTURE
  IMAGEMAP < 1.0 -1.0 0.0 > GIF "glass3.gif" ONCE
  SCALE < 18.6 10.0 1.0 >
  TRANSLATE < -8.38 -5.0 0.0 >
  PHONG 0.8
  PHONGSIZE 20.0
  REFLECTION 0.4
 END_TEXTURE
 COLOR Blue
END_OBJECT

{------------------------------- LLANTAS ------------------------------}

OBJECT
 INTERSECTION
  Llanta
  SCALE < 1.907 1.0 1.907 >
  TRANSLATE < -4.0 -5.0 0.907 >
 END_INTERSECTION
 TEXTURE
  COLOR Near_Black
  PHONG 0.8
  PHONGSIZE 40.0
 END_TEXTURE
 COLOR Near_Black
END_OBJECT

OBJECT
 INTERSECTION
  Llanta
  SCALE < 1.907 1.0 1.907 >
  TRANSLATE < -4.0 5.0 0.907 >
 END_INTERSECTION
 TEXTURE
  COLOR Near_Black
  PHONG 0.8
  PHONGSIZE 40.0
 END_TEXTURE
 COLOR Near_Black
END_OBJECT

OBJECT
 INTERSECTION
  Llanta
  SCALE < 1.435 1.0 1.435 >
  TRANSLATE < 6.5 -5.0 0.435 >
 END_INTERSECTION
 TEXTURE
  COLOR Near_Black
  PHONG 0.8
  PHONGSIZE 40.0
 END_TEXTURE
 COLOR Near_Black
END_OBJECT


OBJECT
 INTERSECTION
  Llanta
  SCALE < 1.435 1.0 1.435 >
  TRANSLATE < 6.5 5.0 0.435 >
 END_INTERSECTION
 TEXTURE
  COLOR Near_Black
  PHONG 0.8
  PHONGSIZE 40.0
 END_TEXTURE
 COLOR Near_Black
END_OBJECT

{---------------------------- POLVERAS -------------------------}

OBJECT
 Polvera
 SCALE < 1.3 1.0 1.3 >
 TRANSLATE < 6.5 5.0 0.435 >
END_OBJECT

OBJECT
 Polvera
 SCALE < 1.3 1.0 1.3 >
 TRANSLATE < 6.5 -5.0 0.435 >
END_OBJECT

OBJECT
 Polvera
 SCALE < 1.8 1.0 1.8 >
 TRANSLATE < -4.0 5.0 0.907 >
END_OBJECT

OBJECT
 Polvera
 SCALE < 1.8 1.0 1.8 >
 TRANSLATE < -4.0 -5.0 0.907 >
END_OBJECT

{------------------------------ PISO y BARDAS -----------------------------}

OBJECT
 PLANE < 0.0 0.0 -1.0 > 1.0 END_PLANE
 TEXTURE
  CHECKER COLOR Brown COLOR Khaki
  ROTATE < -90.0 0.0 0.0 >
  REFLECTION 0.5
 END_TEXTURE
 COLOR Maroon
END_OBJECT

OBJECT
 PLANE < -1.0 0.0 0.0 > 11.0 END_PLANE
 TEXTURE
  COLOR Maroon
  REFLECTION 0.5
 END_TEXTURE
 COLOR Maroon
END_OBJECT

OBJECT
 PLANE < 0.0 1.0 0.0 > 7.0 END_PLANE
 TEXTURE
  COLOR Maroon
  REFLECTION 0.5
 END_TEXTURE
 COLOR Maroon
END_OBJECT

</textarea>

<!-- Sample file : checker2.dat -->

<textarea id="checker2.dat" name="checker2.dat" style="display:none;">
   {  Author name : Dan Farmer
                    Minneapolis, MN

      Demonstrates one use of the powerful ALPHA parameter for colors.

      This data file is for use with DKBTrace by David Buck.  This file
      is released to the public domain and may be used or altered by
      anyone as desired. }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
    LOCATION <-1.5  30.0  -150.0>
    DIRECTION <0.0 0.0 2.0>
    UP  <0.0  1.0  0.0>
    RIGHT <1.33333 0.0 0.0>
    LOOK_AT <0.0  25.0  35.0>
END_VIEW_POINT

OBJECT    { Basic Light source }
    SPHERE <0.0 0.0 0.0> 5.0 END_SPHERE
    TRANSLATE <100.0  100.0  -200.0>
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
    SPHERE <0.0  0.0  0.0> 200000.0 END_SPHERE
    TEXTURE
        0.05
        MARBLE
        TURBULENCE 1.0
        COLOUR_MAP
            [0.0 0.5   COLOUR RED 0.5 GREEN 0.6 BLUE 1.0
                       COLOUR RED 0.6 GREEN 0.5 BLUE 1.0]
            [0.5 0.6   COLOUR RED 0.5 GREEN 0.6 BLUE 1.0
                       COLOUR RED 1.0 GREEN 1.0 BLUE 1.0]
            [0.6 1.001 COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
                       COLOUR RED 0.5 GREEN 0.5 BLUE 0.5]
        END_COLOUR_MAP
        SCALE <10.0 10.0 10.0>
        AMBIENT 1.0
        DIFFUSE 0.0
    END_TEXTURE
    COLOUR SkyBlue
END_OBJECT

{*****************************************************************************}
{
  This composite makes a checkerboard with alternating marblized and solid
  checks.
   Ideas:
    1) Sub-plane could also be a smaller-scaled checker pattern.
    2) Also, what if sub-plane was a solid color plane, but farther below
       the upper plane, say y= -2.0 ?
   So many ideas, so little time.  Anybody got a 486 to spare?
}
COMPOSITE

    { Marbled checkerboard pattern using ALPHA 1.0 }
    OBJECT
        PLANE <0.0 1.0 0.0 > 0.0 END_PLANE      { Checkerboard surface plane }
        TEXTURE
            CHECKER COLOUR Thistle COLOUR White ALPHA 1.0
            SCALE <10.0 10.0 10.0>
        END_TEXTURE
        COLOR White ALPHA 1.0
    END_OBJECT

    { Marble sub-plane. }
    OBJECT
        PLANE <0.0 1.0 0.0 > -0.1 END_PLANE
        TEXTURE
	    White_Marble
	    SCALE <10.0 10.0 10.0>
        END_TEXTURE
        COLOR White
    END_OBJECT
END_COMPOSITE


{*****************************************************************************}
{
  This next composite uses the ALPHA parameter to make a sphere with
  a "cutout" checker pattern.  A smaller, reflective sphere inside
  is just there to add interest.

  Again, don't limit this to checker patterns.  Try it with GRADIENT and
  BOZO, for example. Or maybe MARBLE with ALPHA 1.0 for all but the
  "veins".
  Try a series of "nested" concentric spheres, all with the transparent
  checker pattern as its surface, perhaps in different colors.
}

COMPOSITE
    OBJECT    { Sphere with transparent checker sections }
        SPHERE <0.0 25.0 0.0 > 25.0 END_SPHERE
        TEXTURE
            CHECKER COLOUR YellowGreen COLOUR White  ALPHA 1.0
            SCALE <2.0 500.0 1.0>
            ROTATE <90 0.0 -90.0>
        END_TEXTURE
        COLOR White ALPHA 1.0
    END_OBJECT

    BOUNDED_BY
        SPHERE <0.0 25.0 0.0> 25.2 END_SPHERE
    END_BOUND
END_COMPOSITE

</textarea>

<!-- Sample file : chess.dat -->

<textarea id="chess.dat" name="chess.dat" style="display:none;">
{
* CHESS.DAT
*
* Written by Ville Saari
* Copyright (c) 1991 Ferry Island Pixelboys
*
* DKBTrace scene description for chess board.
* 
* Created: 01-Feb-91
* Updated: 02-Mar-91
*
* This scene has 430 primitives in objects and 41 in bounding shapes and
* it takes over 40 hours to render by standard amiga.
*
* If you do some nice modifications or additions to this file, please send 
* me a copy. My Internet address is:
*
*         vsaari@niksula.hut.fi
}

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <59 20 -48>
   DIRECTION <0 0 1>
   UP <0 1 0>
   RIGHT <1.33 0 0>
   LOOK_AT <0 0 1>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <800 600 -200>
   COLOUR White
   TEXTURE
      COLOUR White
      AMBIENT 1
      DIFFUSE 0
   END_TEXTURE
   LIGHT_SOURCE
END_OBJECT

DECLARE Pawn = UNION
   SPHERE <0 7 0> 1.5 END_SPHERE

   QUADRIC Sphere
      SCALE <1.2 0.3 1.2>
      TRANSLATE <0 5.5 0>
   END_QUADRIC

   INTERSECTION
      PLANE <0 1 0> 5.5 END_PLANE
      QUADRIC Hyperboloid_Y
         TRANSLATE <0 5 0>
         SCALE <0.5 1 0.5>
      END_QUADRIC
      PLANE <0 -1 0> -2.5 END_PLANE
   END_INTERSECTION

   QUADRIC Sphere
      SCALE <2 0.5 2>
      TRANSLATE <0 2.3 0>
   END_QUADRIC

   INTERSECTION
      SPHERE <0 0 0> 2.5 END_SPHERE
      PLANE <0 -1 0> 0 END_PLANE
   END_INTERSECTION
END_UNION

DECLARE Rook = UNION
   INTERSECTION
      UNION
         PLANE < 1 0 0> -0.5 END_PLANE
         PLANE <-1 0 0> -0.5 END_PLANE
         PLANE < 0 1 0>  9   END_PLANE
      END_UNION

      UNION
         PLANE <0 0  1> -0.5 END_PLANE
         PLANE <0 0 -1> -0.5 END_PLANE
         PLANE <0 1  0>  9   END_PLANE
      END_UNION

      PLANE <0 1 0> 10 END_PLANE
      QUADRIC Cylinder_Y SCALE <2 1 2> END_QUADRIC
      QUADRIC Cylinder_Y SCALE <1.2 1 1.2> INVERSE END_QUADRIC
      PLANE <0 -1 0> -8 END_PLANE
   END_INTERSECTION

   INTERSECTION
      PLANE <0 1 0> 8 END_PLANE
      QUADRIC Hyperboloid_Y
         SCALE <1 1.5 1>
         TRANSLATE <0 5.401924 0>
      END_QUADRIC
      PLANE <0 -1 0> -3 END_PLANE
   END_INTERSECTION

   QUADRIC Sphere
      SCALE <2.5 0.5 2.5>
      TRANSLATE <0 2.8 0>
   END_QUADRIC

   INTERSECTION
      SPHERE <0 0 0> 3 END_SPHERE
      PLANE <0 -1 0> 0 END_PLANE
   END_INTERSECTION
END_UNION

DECLARE Knight = UNION
   INTERSECTION
      QUADRIC Cylinder_Z
         SCALE <17.875 17.875 1>
         TRANSLATE <-18.625 7 0>
         INVERSE
      END_QUADRIC

      QUADRIC Cylinder_Z
         SCALE <17.875 17.875 1>
         TRANSLATE <18.625 7 0>
         INVERSE
      END_QUADRIC

      QUADRIC Cylinder_X
         SCALE <1 5.1 5.1>
         TRANSLATE <0 11.2 -5>
         INVERSE
      END_QUADRIC

      UNION
         PLANE <0 1 0> 0
            ROTATE <30 0 0>
            TRANSLATE <0 9.15 0>
         END_PLANE
         PLANE <0 0 1> 0
            ROTATE <-20 0 0>
            TRANSLATE <0 10 0>
         END_PLANE
      END_UNION

      UNION
         PLANE <0 -1 0> 0
            ROTATE <30 0 0>
            TRANSLATE <0 7.15 0>
         END_PLANE
         PLANE <0 1 0> 0
            ROTATE <60 0 0>
            TRANSLATE <0 7.3 0>
         END_PLANE
      END_UNION

      UNION
         PLANE <0 1 0> 0
            ROTATE <0 0 -45>
         END_PLANE
         PLANE <0 1 0> 0
            ROTATE <0 0 45>
         END_PLANE
         TRANSLATE <0 9 0>
      END_UNION

      QUADRIC Cylinder_Y SCALE <2 1 2> END_QUADRIC
      SPHERE <0 7 0> 4 END_SPHERE
   END_INTERSECTION

   QUADRIC Sphere
      SCALE <2.5 0.5 2.5>
      TRANSLATE <0 2.8 0>
   END_QUADRIC

   INTERSECTION
      SPHERE <0 0 0> 3 END_SPHERE
      PLANE <0 -1 0> 0 END_PLANE
   END_INTERSECTION
END_UNION

DECLARE Bishop = UNION
   SPHERE <0 10.8 0> 0.4 END_SPHERE

   INTERSECTION
      UNION
         PLANE <0 0 -1> -0.25 END_PLANE
         PLANE <0 0  1> -0.25 END_PLANE
         PLANE <0 1  0>  0    END_PLANE
         ROTATE <30 0 0>
         TRANSLATE <0 8.5 0>
      END_UNION

      QUADRIC Sphere
         SCALE <1.4 2.1 1.4>
         TRANSLATE <0 8.4 0>
      END_QUADRIC

      PLANE <0 -1 0> -7 END_PLANE
   END_INTERSECTION

   QUADRIC Sphere
      SCALE <1.5 0.4 1.5>
      TRANSLATE <0 7 0>
   END_QUADRIC

   INTERSECTION
      PLANE <0 1 0> 7 END_PLANE
      QUADRIC Hyperboloid_Y
         SCALE <0.6 1.4 0.6>
         TRANSLATE <0 7 0>
      END_QUADRIC
      PLANE <0 -1 0> -3 END_PLANE
   END_INTERSECTION

   QUADRIC Sphere
      SCALE <2.5 0.5 2.5>
      TRANSLATE <0 2.8 0>
   END_QUADRIC

   INTERSECTION
      SPHERE <0 0 0> 3 END_SPHERE
      PLANE <0 -1 0> 0 END_PLANE
   END_INTERSECTION
END_UNION

DECLARE QueenAndKing = UNION
   SPHERE <0 10.5 0> 1.5 END_SPHERE

   INTERSECTION
      UNION
         SPHERE <1.75 12 0> 0.9 ROTATE <0 150 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0 120 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0  90 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0  60 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0  30 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9                   END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0  -30 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0  -60 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0  -90 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0 -120 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0 -150 0> END_SPHERE
         SPHERE <1.75 12 0> 0.9 ROTATE <0 180 0> END_SPHERE
         INVERSE
      END_UNION

      PLANE <0 1 0> 11.5 END_PLANE

      QUADRIC Cone_Y
         SCALE <1 3 1>
         TRANSLATE <0 5 0>
      END_QUADRIC

      PLANE <0 -1 0> -8 END_PLANE
   END_INTERSECTION

   QUADRIC Sphere
      SCALE <1.8 0.4 1.8>
      TRANSLATE <0 8 0>
   END_QUADRIC

   INTERSECTION
      PLANE <0 1 0> 8 END_PLANE
      QUADRIC Hyperboloid_Y
         SCALE <0.7 1.6 0.7>
         TRANSLATE <0 7 0>
      END_QUADRIC
      PLANE <0 -1 0> -3 END_PLANE
   END_INTERSECTION

   QUADRIC Sphere
      SCALE <2.5 0.5 2.5>
      TRANSLATE <0 2.8 0>
   END_QUADRIC

   INTERSECTION
      SPHERE <0 0 0> 3 END_SPHERE
      PLANE <0 -1 0> 0 END_PLANE
   END_INTERSECTION
END_UNION

DECLARE Queen = UNION
   SPHERE <0 12.3 0> 0.4 END_SPHERE
   UNION QueenAndKing END_UNION
END_UNION

DECLARE King = UNION
   INTERSECTION
      UNION
         INTERSECTION
            PLANE <0  1 0>  13 END_PLANE
            PLANE <0 -1 0> -12.5 END_PLANE
         END_INTERSECTION

         INTERSECTION
            PLANE < 1 0 0> 0.25 END_PLANE
            PLANE <-1 0 0> 0.25 END_PLANE
         END_INTERSECTION
      END_UNION

      PLANE < 0  0  1>   0.25 END_PLANE
      PLANE < 0  0 -1>   0.25 END_PLANE
      PLANE < 1  0  0>   0.75 END_PLANE
      PLANE <-1  0  0>   0.75 END_PLANE
      PLANE < 0  1  0>  13.5  END_PLANE
      PLANE < 0 -1  0> -11.5  END_PLANE
   END_INTERSECTION

   UNION QueenAndKing END_UNION
END_UNION

DECLARE WWood = TEXTURE
   WOOD
   TURBULENCE 0.1
   COLOUR_MAP
      [ 0.0 0.35 COLOUR RED 0.7  GREEN 0.4
                 COLOUR RED 0.7  GREEN 0.4  ]
      [ 0.35 1.0 COLOUR RED 0.95 GREEN 0.62
                 COLOUR RED 0.95 GREEN 0.62 ]
   END_COLOUR_MAP
   SCALE <0.6 1000.0 0.6>
   TRANSLATE <200.0 0.0 100.0>
   SPECULAR 1
   ROUGHNESS 0.02
END_TEXTURE

DECLARE BWood = TEXTURE
   WOOD
   TURBULENCE 0.1
   COLOUR_MAP
      [ 0.0 0.55 COLOUR RED 0.45 GREEN 0.25
                 COLOUR RED 0.45 GREEN 0.25 ]
      [ 0.55 1.0 COLOUR RED 0.30 GREEN 0.16
                 COLOUR RED 0.30 GREEN 0.16 ]
   END_COLOUR_MAP
   SCALE <0.6 1000.0 0.6>
   TRANSLATE <100.0 0.0 -200.0>
   SPECULAR 1
   ROUGHNESS 0.02
END_TEXTURE

DECLARE WPawn = OBJECT
   UNION Pawn END_UNION

   BOUNDED_BY
      SPHERE <0 4 0> 4.72 END_SPHERE
   END_BOUND

   TEXTURE WWood END_TEXTURE
   COLOUR RED 0.95 GREEN 0.62
END_OBJECT

DECLARE BPawn = OBJECT
   UNION Pawn END_UNION

   BOUNDED_BY
      SPHERE <0 4 0> 4.72 END_SPHERE
   END_BOUND

   TEXTURE BWood END_TEXTURE
   COLOUR RED 0.4 GREEN 0.2
END_OBJECT

DECLARE WRook = OBJECT
   UNION Rook END_UNION

   BOUNDED_BY
      SPHERE <0 5 0> 5.831 END_SPHERE
   END_BOUND

   TEXTURE WWood END_TEXTURE
   COLOUR RED 0.95 GREEN 0.62
END_OBJECT

DECLARE BRook = OBJECT
   UNION Rook END_UNION

   BOUNDED_BY
      SPHERE <0 5 0> 5.831 END_SPHERE
   END_BOUND

   TEXTURE BWood END_TEXTURE
   COLOUR RED 0.4 GREEN 0.2
END_OBJECT

DECLARE WKnight = OBJECT
   UNION Knight END_UNION

   BOUNDED_BY
      SPHERE <0 5 0> 5.831 END_SPHERE
   END_BOUND

   TEXTURE WWood END_TEXTURE
   COLOUR RED 0.95 GREEN 0.62
END_OBJECT

DECLARE BKnight = OBJECT
   UNION Knight END_UNION
   ROTATE <0 180 0>

   BOUNDED_BY
      SPHERE <0 5 0> 5.831 END_SPHERE
   END_BOUND

   TEXTURE BWood END_TEXTURE
   COLOUR RED 0.4 GREEN 0.2
END_OBJECT

DECLARE WBishop = OBJECT
   UNION Bishop END_UNION

   BOUNDED_BY
      SPHERE <0 5.5 0> 6.265 END_SPHERE
   END_BOUND

   TEXTURE WWood END_TEXTURE
   COLOUR RED 0.95 GREEN 0.62
END_OBJECT

DECLARE BBishop = OBJECT
   UNION Bishop END_UNION
   ROTATE <0 180 0>

   BOUNDED_BY
      SPHERE <0 5.5 0> 6.265 END_SPHERE
   END_BOUND

   TEXTURE BWood END_TEXTURE
   COLOUR RED 0.4 GREEN 0.2
END_OBJECT

DECLARE WQueen = OBJECT
   UNION Queen END_UNION

   BOUNDED_BY
      INTERSECTION
         SPHERE <0 6 0> 6.71 END_SPHERE
         QUADRIC Cylinder_Y SCALE <3 1 3> END_QUADRIC
      END_INTERSECTION
   END_BOUND

   TEXTURE WWood END_TEXTURE
   COLOUR RED 0.95 GREEN 0.62
END_OBJECT

DECLARE BQueen = OBJECT
   UNION Queen END_UNION

   BOUNDED_BY
      INTERSECTION
         SPHERE <0 6 0> 6.71 END_SPHERE
         QUADRIC Cylinder_Y SCALE <3 1 3> END_QUADRIC
      END_INTERSECTION
   END_BOUND

   TEXTURE BWood END_TEXTURE
   COLOUR RED 0.4 GREEN 0.2
END_OBJECT

DECLARE WKing = OBJECT
   UNION King END_UNION

   BOUNDED_BY
      INTERSECTION
         SPHERE <0 6.5 0> 7.16 END_SPHERE
         QUADRIC Cylinder_Y SCALE <3 1 3> END_QUADRIC
      END_INTERSECTION
   END_BOUND

   TEXTURE WWood END_TEXTURE
   COLOUR RED 0.95 GREEN 0.62
END_OBJECT

DECLARE BKing = OBJECT
   UNION King END_UNION

   BOUNDED_BY
      INTERSECTION
         SPHERE <0 6.5 0> 7.16 END_SPHERE
         QUADRIC Cylinder_Y SCALE <3 1 3> END_QUADRIC
      END_INTERSECTION
   END_BOUND

   TEXTURE BWood END_TEXTURE
   COLOUR RED 0.4 GREEN 0.2
END_OBJECT

OBJECT { Sky }
   SPHERE <0 -39000 0> 40000 INVERSE END_SPHERE

   TEXTURE
      BOZO
      TURBULENCE 0.6
      COLOUR_MAP
         [0 0.5 COLOUR RED 0.4 GREEN 0.5 BLUE 1
                  COLOUR RED 0.4 GREEN 0.5 BLUE 1.0]
         [0.5 0.7 COLOUR RED 0.4 GREEN 0.5 BLUE 1
                  COLOUR RED 1 GREEN 1 BLUE 1.0]
         [0.7 1 COLOUR RED 1 GREEN 1 BLUE 1
                  COLOUR RED 0.7 GREEN 0.7 BLUE 0.7]
      END_COLOUR_MAP
      SCALE <500 500 500>
      AMBIENT 1
      DIFFUSE 0
   END_TEXTURE

   COLOUR RED 0.4 GREEN 0.5 BLUE 1
END_OBJECT

OBJECT { Ground }
   PLANE <0 1 0> -80 END_PLANE

   TEXTURE
      0.05
      COLOUR GREEN 1
      AMBIENT 0.5
      DIFFUSE 0.5
   END_TEXTURE
   COLOUR GREEN 1
END_OBJECT

DECLARE Frame = INTERSECTION
   PLANE < 0  1  0> -0.0001 END_PLANE
   PLANE < 0 -1  0>  3 END_PLANE
   PLANE < 0  0 -1> 35 END_PLANE
   PLANE <-1  0  1>  0 END_PLANE
   PLANE < 1  0  1>  0 END_PLANE
END_INTERSECTION

COMPOSITE
   COMPOSITE
      OBJECT
         UNION
            INTERSECTION Frame END_INTERSECTION
            INTERSECTION Frame ROTATE <0 180 0> END_INTERSECTION
         END_UNION

         TEXTURE
            WOOD
            TURBULENCE 0.3
            SCALE <0.8 1000 0.8>
            ROTATE <0 0 -88>
            TRANSLATE <200 40 -20>
            SPECULAR 1
            ROUGHNESS 0.02
         END_TEXTURE

         COLOUR RED 0.5 GREEN 0.25
      END_OBJECT

      OBJECT
         UNION
            INTERSECTION Frame ROTATE <0 -90 0> END_INTERSECTION
            INTERSECTION Frame ROTATE <0  90 0> END_INTERSECTION
         END_UNION

         TEXTURE
            WOOD
            TURBULENCE 0.3
            SCALE <0.8 1000 0.8>
            ROTATE <-91 0 0>
            TRANSLATE <100 30 0>
            SPECULAR 1
            ROUGHNESS 0.02
         END_TEXTURE

         COLOUR RED 0.5 GREEN 0.25
      END_OBJECT
   
      OBJECT { Board }
         INTERSECTION
            PLANE < 1  0  0> 32 END_PLANE
            PLANE <-1  0  0> 32 END_PLANE
            PLANE < 0  1  0>  0 END_PLANE
            PLANE < 0 -1  0>  1 END_PLANE
            PLANE < 0  0  1> 32 END_PLANE
            PLANE < 0  0 -1> 32 END_PLANE
         END_INTERSECTION
   
         TEXTURE
            CHECKER_TEXTURE
               TEXTURE
                  MARBLE
                  TURBULENCE 1.0
                  COLOUR_MAP
                     [0.0 0.7 COLOUR White
                              COLOUR White]
                     [0.7 0.9 COLOUR White
                              COLOUR RED 0.8 GREEN 0.8 BLUE 0.8]
                     [0.9 1.0 COLOUR RED 0.8 GREEN 0.8 BLUE 0.8
                              COLOUR RED 0.5 GREEN 0.5 BLUE 0.5]
                  END_COLOUR_MAP
                  SCALE <0.6 1 0.6>
                  ROTATE <0 -30 0>
               END_TEXTURE
            TILE2
               TEXTURE
                  GRANITE
                  SCALE <0.3 1 0.3>
                  COLOUR_MAP
                    [0 1 COLOUR Black
                         COLOUR RED 0.5 GREEN 0.5 BLUE 0.5]
                  END_COLOUR_MAP
               END_TEXTURE
            END_CHECKER_TEXTURE
            SCALE <8 1 8>
            SPECULAR 1
            ROUGHNESS 0.02
            REFLECTION 0.25
         END_TEXTURE

         COLOUR RED 0.63 GREEN 0.52 BLUE 0.45
      END_OBJECT
   
      OBJECT { Table }
         UNION
            INTERSECTION
               PLANE  <0  1 0> -3 END_PLANE
               PLANE  <0 -1 0>  8 END_PLANE
               SPHERE <0 -5.5 0> 55 END_SPHERE
            END_INTERSECTION
   
            INTERSECTION
               PLANE <0 1 0> -8 END_PLANE
               QUADRIC Hyperboloid_Y
                  SCALE <10 20 10>
                  TRANSLATE <0 -20 0>
               END_QUADRIC
            END_INTERSECTION
         END_UNION
   
         TEXTURE GRANITE
            SCALE <6 6 6>
            SPECULAR 1
            ROUGHNESS 0.02
            REFLECTION 0.3
         END_TEXTURE
   
         COLOUR RED 0.5 GREEN 0.5 BLUE 0.5
      END_OBJECT
   
      BOUNDED_BY
         PLANE <0 1 0> 0 END_PLANE
      END_BOUND
   END_COMPOSITE

   COMPOSITE
      OBJECT WPawn TRANSLATE <-28 0 -20> END_OBJECT
      OBJECT WPawn TRANSLATE <-20 0 -20> END_OBJECT
      OBJECT WPawn TRANSLATE <-12 0 -20> END_OBJECT
      OBJECT WPawn TRANSLATE < -4 0 -20> END_OBJECT
      OBJECT WPawn TRANSLATE <  4 0 -20> END_OBJECT
      OBJECT WPawn TRANSLATE < 12 0 -20> END_OBJECT
      OBJECT WPawn TRANSLATE < 20 0 -20> END_OBJECT
      OBJECT WPawn TRANSLATE < 28 0 -20> END_OBJECT
   
      OBJECT WRook   TRANSLATE <-28 0 -28> END_OBJECT
      OBJECT WKnight TRANSLATE <-20 0 -28> END_OBJECT
      OBJECT WBishop TRANSLATE <-12 0 -28> END_OBJECT
      OBJECT WQueen  TRANSLATE < -4 0 -28> END_OBJECT
      OBJECT WKing   TRANSLATE <  4 0 -28> END_OBJECT
      OBJECT WBishop TRANSLATE < 12 0 -28> END_OBJECT
      OBJECT WKnight TRANSLATE < 20 0 -28> END_OBJECT
      OBJECT WRook   TRANSLATE < 28 0 -28> END_OBJECT
   
      BOUNDED_BY
         QUADRIC Cylinder_X
            SCALE <1 9.56 9.56>
            TRANSLATE <0 6.5 -24>
         END_QUADRIC
      END_BOUND
   END_COMPOSITE
   
   COMPOSITE
      OBJECT BPawn TRANSLATE <-28 0 20> END_OBJECT
      OBJECT BPawn TRANSLATE <-20 0 20> END_OBJECT
      OBJECT BPawn TRANSLATE <-12 0 20> END_OBJECT
      OBJECT BPawn TRANSLATE < -4 0 20> END_OBJECT
      OBJECT BPawn TRANSLATE <  4 0 20> END_OBJECT
      OBJECT BPawn TRANSLATE < 12 0 20> END_OBJECT
      OBJECT BPawn TRANSLATE < 20 0 20> END_OBJECT
      OBJECT BPawn TRANSLATE < 28 0 20> END_OBJECT
   
      OBJECT BRook   TRANSLATE <-28 0 28> END_OBJECT
      OBJECT BKnight TRANSLATE <-20 0 28> END_OBJECT
      OBJECT BBishop TRANSLATE <-12 0 28> END_OBJECT
      OBJECT BQueen  TRANSLATE < -4 0 28> END_OBJECT
      OBJECT BKing   TRANSLATE <  4 0 28> END_OBJECT
      OBJECT BBishop TRANSLATE < 12 0 28> END_OBJECT
      OBJECT BKnight TRANSLATE < 20 0 28> END_OBJECT
      OBJECT BRook   TRANSLATE < 28 0 28> END_OBJECT
   
      BOUNDED_BY
         QUADRIC Cylinder_X
            SCALE <1 9.56 9.56>
            TRANSLATE <0 6.5 24>
         END_QUADRIC
      END_BOUND
   END_COMPOSITE

   BOUNDED_BY
      INTERSECTION
         PLANE <0 1 0> 13.5 END_PLANE
         SPHERE <0 -30 0> 63 END_SPHERE
      END_INTERSECTION
   END_BOUND
END_COMPOSITE
</textarea>


<!-- Sample file : colortes.dat -->

<textarea id="colortes.dat" name="colortes.dat" style="display:none;">
INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <0.0  0.0  -60.0>
   LOOK_AT <0.0 0.0 0.0>
   RIGHT <1.3333 0.0 0.0>
END_VIEW_POINT

{ Light behind viewer postion (pseudo-ambient light) }
OBJECT  
   SPHERE <0.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <-50.0  50.0  -150.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT


{ Top row }
OBJECT                                           { Ball 1 }
    SPHERE  <-18.0 18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR White
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 2 }
    SPHERE  <-24 18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Red
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 3 }
    SPHERE  <-12.0 18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Green
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 4 }
    SPHERE  <-6.0 18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Blue
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 5 }
    SPHERE  <0.0 18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Yellow
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 6 }
    SPHERE  <6.0 18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Cyan
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 7 }
    SPHERE  <12.0 18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Magenta
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 8 }
    SPHERE  <18.0 18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Aquamarine
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 9 }
    SPHERE  <24.0 18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Black
    END_TEXTURE
END_OBJECT

{ 2nd row }
OBJECT                                           { Ball 1 }
    SPHERE  <-24.0 12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR BlueViolet
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 2 }
    SPHERE  <-18.0 12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Brown
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 3 }
    SPHERE  <-12.0 12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR CadetBlue
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 4 }
    SPHERE  <-6.0 12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Coral
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 5 }
    SPHERE  <0.0 12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR CornflowerBlue
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 6 }
    SPHERE  <6.0 12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR DarkGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 7 }
    SPHERE  <12.0 12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR DarkOliveGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 8 }
    SPHERE  <18.0 12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR DarkOrchid
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 9 }
    SPHERE  <24.0 12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR DarkSlateBlue
    END_TEXTURE
END_OBJECT

{ 3rd (Center ) row}
OBJECT                                           { Ball 1 }
    SPHERE  <-24.0 6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR DarkSlateGray
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 2 }
    SPHERE  <-18.0 6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR DarkTurquoise
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 3 }
    SPHERE  <-12.0 6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR DimGray
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 4 }
    SPHERE  <-6.0 6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Firebrick
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 5 }
    SPHERE  <0.0 6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR ForestGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 6 }
    SPHERE  <6.0 6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Gold
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 7 }
    SPHERE  <12.0 6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Goldenrod
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 8 }
    SPHERE  <18.0 6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Gray
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 9 }
    SPHERE  <24.0 6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR GreenYellow
    END_TEXTURE
END_OBJECT

{ 4th  row }
OBJECT                                           { Ball 1 }
    SPHERE  <-24.0 0.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR IndianRed
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 2 }
    SPHERE  <-18.0 0.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Khaki
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 3 }
    SPHERE  <-12.0 0.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR LightBlue
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 4 }
    SPHERE  <-6.0 0.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR LightGray
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 5 }
    SPHERE  <0.0 0.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR LightSteelBlue
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 6 }
    SPHERE  <6.0 0.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR LimeGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 7 }
    SPHERE  <12.0 0.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Maroon
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 8 }
    SPHERE  <18.0 0.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumAquamarine
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 9 }
    SPHERE  <24.0 0.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumBlue
    END_TEXTURE
END_OBJECT

{ 5th  row }
OBJECT                                           { Ball 1 }
    SPHERE  <-24.0 -6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumForestGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 2 }
    SPHERE  <-18.0 -6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumGoldenrod
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 3 }
    SPHERE  <-12.0 -6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumOrchid
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 4 }
    SPHERE  <-6.0 -6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumSeaGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 5 }
    SPHERE  <0.0 -6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumSlateBlue
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 6 }
    SPHERE  <6.0 -6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumSpringGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 7 }
    SPHERE  <12.0 -6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumTurquoise
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 8 }
    SPHERE  <18.0 -6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MediumVioletRed
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 9 }
    SPHERE  <24.0 -6.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR MidnightBlue
    END_TEXTURE
END_OBJECT

{ 6th  row }
OBJECT                                           { Ball 1 }
    SPHERE  <-24.0 -12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Navy
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 2 }
    SPHERE  <-18.0 -12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Orange
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 3 }
    SPHERE  <-12.0 -12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR OrangeRed
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 4 }
    SPHERE  <-6.0 -12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Orchid
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 5 }
    SPHERE  <0.0 -12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR PaleGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 6 }
    SPHERE  <6.0 -12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Pink
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 7 }
    SPHERE  <12.0 -12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Plum
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 8 }
    SPHERE  <18.0 -12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Salmon
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 9 }
    SPHERE  <24.0 -12.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR SeaGreen
    END_TEXTURE
END_OBJECT

{ 7th  row }
OBJECT                                           { Ball 1 }
    SPHERE  <-24.0 -18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Sienna
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 2 }
    SPHERE  <-18.0 -18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR SkyBlue
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 3 }
    SPHERE  <-12.0 -18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR SlateBlue
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 4 }
    SPHERE  <-6.0 -18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR SpringGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 5 }
    SPHERE  <0.0 -18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR SteelBlue
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 6 }
    SPHERE  <6.0 -18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Tan
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 7 }
    SPHERE  <12.0 -18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Thistle
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 8 }
    SPHERE  <18.0 -18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Turquoise
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 9 }
    SPHERE  <24.0 -18.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Violet
    END_TEXTURE
END_OBJECT

{ 8th  row }
OBJECT                                           { Ball 1 }
    SPHERE  <-24.0 -24.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR VioletRed
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 2 }
    SPHERE  <-18.0 -24.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR Wheat
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 3 }
    SPHERE  <-12.0 -24.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR YellowGreen
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 4 }
    SPHERE  <-6.0 -24.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR OldGold
    END_TEXTURE
END_OBJECT
{ ********************** UNUSED FOR NOW **********************************
OBJECT                                           { Ball 5 }
    SPHERE  <0.0 -24.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 6 }
    SPHERE  <6.0 -24.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 7 }
    SPHERE  <12.0 -24.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 8 }
    SPHERE  <18.0 -24.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR
    END_TEXTURE
END_OBJECT
OBJECT                                           { Ball 9 }
    SPHERE  <24.0 -24.0 -4.0> 3.25 END_SPHERE
    TEXTURE
    COLOR
    END_TEXTURE
END_OBJECT
****************** END OF UNUSED AREA ***************************}

</textarea>


<!-- Sample file : desk.dat -->

<textarea id="desk.dat" name="desk.dat" style="display:none;">
INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

DECLARE
  RedPencil = COMPOSITE
    OBJECT
      INTERSECTION
	QUADRIC Cylinder_Y SCALE <0.5 1.0 0.5> END_QUADRIC
	PLANE <0.0 1.0 0.0> 30.0 END_PLANE
	PLANE <0.0 1.0 0.0> 0.0 INVERSE END_PLANE
      END_INTERSECTION
      TEXTURE
        0.05
    	AMBIENT 0.3
	DIFFUSE 0.7
	COLOUR RED 1.0
      END_TEXTURE
     END_OBJECT

     OBJECT
       INTERSECTION
	QUADRIC Cylinder_Y SCALE <0.5 1.0 0.5> END_QUADRIC
	PLANE <0.0 1.0 0.0> 32.0 END_PLANE
	PLANE <0.0 1.0 0.0> 30.0 INVERSE END_PLANE
      END_INTERSECTION
      TEXTURE
        0.05
    	AMBIENT 0.3
	DIFFUSE 0.7
	COLOUR Tan
      END_TEXTURE
      END_OBJECT
   END_COMPOSITE

DECLARE
  GreenPencil = COMPOSITE
    OBJECT
      INTERSECTION
	QUADRIC Cylinder_Y SCALE <0.5 1.0 0.5> END_QUADRIC
	PLANE <0.0 1.0 0.0> 30.0 END_PLANE
	PLANE <0.0 1.0 0.0> 0.0 INVERSE END_PLANE
      END_INTERSECTION
      TEXTURE
        0.05
    	AMBIENT 0.3
	DIFFUSE 0.7
	COLOUR GREEN 1.0
      END_TEXTURE
     END_OBJECT
     OBJECT
       INTERSECTION
	QUADRIC Cylinder_Y SCALE <0.5 1.0 0.5> END_QUADRIC
	PLANE <0.0 1.0 0.0> 32.0 END_PLANE
	PLANE <0.0 1.0 0.0> 30.0 INVERSE END_PLANE
      END_INTERSECTION
      TEXTURE
        0.05
    	AMBIENT 0.3
	DIFFUSE 0.7
	COLOUR Tan
      END_TEXTURE
      END_OBJECT
   END_COMPOSITE

DECLARE
  BluePencil = COMPOSITE
    OBJECT
      INTERSECTION
	QUADRIC Cylinder_Y SCALE <0.5 1.0 0.5> END_QUADRIC
	PLANE <0.0 1.0 0.0> 30.0 END_PLANE
	PLANE <0.0 1.0 0.0> 0.0 INVERSE END_PLANE
      END_INTERSECTION
      TEXTURE
        0.05
    	AMBIENT 0.3
	DIFFUSE 0.7
	COLOUR BLUE 1.0
      END_TEXTURE
     END_OBJECT
     OBJECT
       INTERSECTION
	QUADRIC Cylinder_Y SCALE <0.5 1.0 0.5> END_QUADRIC
	PLANE <0.0 1.0 0.0> 32.0 END_PLANE
	PLANE <0.0 1.0 0.0> 30.0 INVERSE END_PLANE
      END_INTERSECTION
        TEXTURE
           0.05
	   AMBIENT 0.3
	   DIFFUSE 0.7
	   COLOUR Tan
        END_TEXTURE
      END_OBJECT
   END_COMPOSITE

VIEW_POINT
  	LOCATION <0.0 40.0 -150.0>
	UP <0.0 1.0 0.0>
	RIGHT <1.3333 0.0 0.0>
	LOOK_AT <0.0 0.0 0.0>
END_VIEW_POINT

{The back wall}

OBJECT
    PLANE <0.0 0.0 1.0> 200.0 END_PLANE
    TEXTURE
    	0.1
	AMBIENT 0.3
	DIFFUSE 0.7
	COLOUR LightGray
    END_TEXTURE
    COLOUR LightGray
END_OBJECT

{The ceiling}
OBJECT
    PLANE <0.0 1.0 0.0> 500.0 END_PLANE
    TEXTURE
    	0.1
	AMBIENT 0.3
	DIFFUSE 0.7
	COLOUR White
    END_TEXTURE
END_OBJECT


{The desk surface}

OBJECT
    INTERSECTION
        PLANE <0.0 1.0 0.0> 2.0 END_PLANE
	PLANE <0.0 1.0 0.0> -2.0 INVERSE END_PLANE
	PLANE <0.0 0.0 1.0> 100.0 END_PLANE
	PLANE <0.0 0.0 1.0> -100.0 INVERSE END_PLANE
	PLANE <1.0 0.0 0.0> 125.0 END_PLANE
	PLANE <1.0 0.0 0.0> -125.0 INVERSE END_PLANE
    END_INTERSECTION
    TRANSLATE <0.0 -20.0 0.0>
    TEXTURE
	0.05
	AMBIENT 0.4
	DIFFUSE 0.6
	Dark_Wood
	SCALE <5.0 1.0 1.0>
	REFLECTION 0.2
	BRILLIANCE 3.0
    END_TEXTURE
END_OBJECT

{Paperwork}
OBJECT
  UNION
    TRIANGLE
	<0.0 0.0 0.0>
	<8.5 0.0 0.0>
	<0.0 0.0 -11.0>
    END_TRIANGLE
    TRIANGLE
	<0.0 0.0 -11.0>
	<8.5 0.0 -11.0>
	<8.5 0.0 0.0>
    END_TRIANGLE
   END_UNION
   SCALE <3.0 1.0 3.0>
   ROTATE <0.0 -30.0 0.0>
   TRANSLATE <-20.0 -17.9 -40.0>

   TEXTURE
        0.05
	AMBIENT 0.1
	DIFFUSE 0.4
	COLOUR RED 0.5 GREEN 0.5 BLUE 0.3
   END_TEXTURE
   COLOUR RED 0.5 GREEN 0.5 BLUE 0.3
END_OBJECT

{A glass paperweight}
OBJECT
  INTERSECTION
	SPHERE <0.0 -5.0 0.0> 10.0 END_SPHERE
	PLANE <0.0 1.0 0.0> 0.0 INVERSE END_PLANE
  END_INTERSECTION
  TRANSLATE <0.0 -17.8 -35.0>
  TEXTURE
	AMBIENT 0.1
	DIFFUSE 0.6
	COLOUR RED 0.3 GREEN 0.5 BLUE 0.3 ALPHA 1.0
	REFLECTION 0.1
	REFRACTION 1.0
	IOR 1.5
	BRILLIANCE 2.0
   END_TEXTURE
END_OBJECT

{The desk lamp}

COMPOSITE
  OBJECT
     INTERSECTION
      QUADRIC Cylinder_Y SCALE <3.0 1.0 3.0> END_QUADRIC
      PLANE <0.0 1.0 0.0> 40.0 END_PLANE
      PLANE <0.0 1.0 0.0> -18.0 INVERSE END_PLANE
     END_INTERSECTION
     TEXTURE
	Shiny
        0.05
	AMBIENT 0.2
        DIFFUSE 0.7
        COLOUR RED 0.7 GREEN 0.6 BLUE 0.1
     END_TEXTURE
  END_OBJECT

  OBJECT
    INTERSECTION
	QUADRIC Cylinder_Y SCALE <25.0 1.0 25.0> END_QUADRIC
	PLANE <0.0 1.0 0.0> 2.0 END_PLANE
	PLANE <0.0 1.0 0.0> -2.0 INVERSE END_PLANE
    END_INTERSECTION
    TRANSLATE <0.0 -16.0 -5.0>
    TEXTURE
	0.05
	AMBIENT 0.3
	DIFFUSE 0.6
	COLOUR RED 0.5 GREEN 0.4 BLUE 0.1
	REFLECTION 0.4
	BRILLIANCE 4.0
	BUMPS 0.1
    END_TEXTURE
  END_OBJECT

  OBJECT
   INTERSECTION
     QUADRIC Cylinder_X SCALE <1.0 10.0 10.0> END_QUADRIC
     QUADRIC Cylinder_X SCALE <1.0 9.95 9.95> INVERSE END_QUADRIC
     PLANE <0.0 1.0 0.0> 0.0 INVERSE END_PLANE
     PLANE <1.0 0.0 0.0> -30.0 INVERSE END_PLANE
     PLANE <1.0 0.0 0.0> 30.0 END_PLANE
   END_INTERSECTION
	TRANSLATE <0.0 35.0 -13.0>
      TEXTURE
	Shiny
	0.05
	AMBIENT 0.5
	DIFFUSE 0.5
	COLOUR DarkGreen 
	REFLECTION 0.3
	BRILLIANCE 4.0
      END_TEXTURE
   END_OBJECT

   OBJECT
     UNION
	INTERSECTION
	   SPHERE <-30.0 35.0 -13.0> 10.0 END_SPHERE
	   SPHERE <-30.0 35.0 -13.0> 9.95 INVERSE END_SPHERE
	   PLANE <0.0 1.0 0.0> 35.0 INVERSE END_PLANE
	   PLANE <1.0 0.0 0.0> -30.0 END_PLANE
	END_INTERSECTION
	INTERSECTION
	   PLANE <0.0 1.0 0.0> 35.0 INVERSE END_PLANE
	   PLANE <1.0 0.0 0.0> 30.0 INVERSE END_PLANE
	   SPHERE <30.0 35.0 -13.0> 10.0 END_SPHERE
	   SPHERE <30.0 35.0 -13.0> 9.95 INVERSE END_SPHERE
	END_INTERSECTION
      END_UNION
      TEXTURE
	Shiny
	0.05
   	AMBIENT 0.2
	DIFFUSE 0.7
	COLOUR RED 0.7 GREEN 0.6 BLUE 0.1
	END_TEXTURE
   END_OBJECT


   ROTATE <0.0 35.0 0.0>
   TRANSLATE <50.0 0.0 30.0>
	
END_COMPOSITE
	
{The fluorescent tube inside the lamp}

OBJECT
   INTERSECTION
	QUADRIC Cylinder_X END_QUADRIC
	PLANE <1.0 0.0 0.0> -25.0 INVERSE END_PLANE
	PLANE <1.0 0.0 0.0>  25.0 END_PLANE
   END_INTERSECTION
   TRANSLATE <0.0 43.0 -10.0>
   ROTATE <0.0 35.0 0.0>
   TRANSLATE <50.0 0.0 30.0>
   TEXTURE
	COLOUR White
	AMBIENT 1.0
	DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

{The Picture itself}

COMPOSITE
  OBJECT
   INTERSECTION
	PLANE <1.0 0.0 0.0> 1.0 END_PLANE
	PLANE <1.0 0.0 0.0> -1.0 INVERSE END_PLANE
	PLANE <0.0 1.0 0.0> 1.0 END_PLANE
	PLANE <0.0 1.0 0.0> -1.0 INVERSE END_PLANE
	PLANE <0.0 0.0 1.0> 1.0 END_PLANE
	PLANE <0.0 0.0 1.0> -1.0 INVERSE END_PLANE
   END_INTERSECTION
   TRANSLATE <1.0 1.0 1.0>
   SCALE <20.0 15.0 1.0>
   TEXTURE
	AMBIENT 0.05
	DIFFUSE 0.9
	IMAGEMAP <1.0 -1.0 0.0> GIF "waterbowl.gif" ONCE
	SCALE <40.0 30.0 1.0>
	SCALE <1.5 1.5 1.0>
   END_TEXTURE
  END_OBJECT

{ The picture frame }
  OBJECT
    UNION
     INTERSECTION
	UNION
	  QUADRIC Cylinder_Y SCALE <1.0 1.0 1.0> TRANSLATE <41.0 0.0 0.0> END_QUADRIC
	  QUADRIC Cylinder_Y SCALE <1.0 1.0 1.0> TRANSLATE <-1.0 0.0 0.0> END_QUADRIC
	END_UNION
	  PLANE <0.0 1.0 0.0> 31.0 END_PLANE
          PLANE <0.0 1.0 0.0> -1.0 INVERSE END_PLANE
     END_INTERSECTION
     INTERSECTION
	UNION
  	  QUADRIC Cylinder_X SCALE <1.0 1.0 1.0> TRANSLATE <0.0 31.0 0.0> END_QUADRIC
	  QUADRIC Cylinder_X SCALE <1.0 1.0 1.0> TRANSLATE <0.0 -1.0 0.0> END_QUADRIC
	END_UNION
	  PLANE <1.0 0.0 0.0> 41.0 END_PLANE
	  PLANE <1.0 0.0 0.0> -1.0 INVERSE END_PLANE
     END_INTERSECTION
	  SPHERE <-1.0 -1.0 0.0> 1.0 END_SPHERE
	  SPHERE <-1.0 31.0 0.0> 1.0 END_SPHERE
	  SPHERE <41.0 -1.0 0.0> 1.0 END_SPHERE
	  SPHERE <41.0 31.0 0.0> 1.0 END_SPHERE
    END_UNION
    TEXTURE
	0.05
	Shiny
	COLOUR RED 0.6 GREEN 0.5 BLUE 0.1
	AMBIENT 0.3
	DIFFUSE 0.7
    END_TEXTURE
    COLOUR RED 0.6 GREEN 0.5 BLUE 0.1
  END_OBJECT

  SCALE <1.5 1.5 1.5>
  ROTATE <10.0 -35.0 0.0>
  TRANSLATE <-65.0 -15.0 -25.0>

END_COMPOSITE

{The pencil holder}
COMPOSITE
  OBJECT
    INTERSECTION
	QUADRIC Cylinder_Y SCALE <5.0 1.0 5.0> END_QUADRIC
	QUADRIC Cylinder_Y SCALE <4.8 1.0 4.8> INVERSE END_QUADRIC
	PLANE <0.0 1.0 0.0> 0.0 INVERSE END_PLANE
	PLANE <0.0 1.0 0.0> 15.0 ROTATE <-45.0 0.0 0.0> END_PLANE
    END_INTERSECTION
    TEXTURE
	0.05
	Shiny
	AMBIENT 0.3
	DIFFUSE 0.7
        COLOUR RED 0.7 GREEN 0.6 BLUE 0.1
	REFLECTION 0.4
	BRILLIANCE 6.0
    END_TEXTURE
  END_OBJECT
  COMPOSITE RedPencil
	ROTATE <0.0 0.0 -2.0>
	TRANSLATE <1.0 0.0 1.0>
  END_COMPOSITE
  COMPOSITE GreenPencil
	ROTATE <0.0 0.0 2.0>
	TRANSLATE <-1.0 3.0 0.0>
  END_COMPOSITE
  COMPOSITE BluePencil
	ROTATE <-2.0 0.0 3.0>
	TRANSLATE <0.0 -2.0 -1.0>
  END_COMPOSITE
  BOUNDED_BY
    INTERSECTION
	QUADRIC Cylinder_Y SCALE <6.0 1.0 6.0> END_QUADRIC
	PLANE <0.0 1.0 0.0> 36.0 END_PLANE
	PLANE <0.0 1.0 0.0> -4.0 INVERSE END_PLANE
    END_INTERSECTION
  END_BOUND

  ROTATE <0.0 45.0 0.0>
  TRANSLATE <70.0 -18.0 -20.0>

END_COMPOSITE

{The light source}

OBJECT
    SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
    TRANSLATE <20.0 100.0 -200.0>
    TEXTURE
	COLOUR White
	AMBIENT 0.3
	DIFFUSE 0.0
    END_TEXTURE
    LIGHT_SOURCE
    COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : devil.dat -->

<textarea id="devil.dat" name="devil.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ Variant of a devil's curve }
OBJECT
   INTERSECTION
     QUARTIC
     <-1.0   0.0   0.0    0.0  0.0   0.0   0.0  -2.0   0.0  0.36
       0.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0  0.0
       1.0   0.0   0.0    0.0  0.0  -0.25  0.0   0.0   0.0  0.0
      -1.0   0.0   0.0    0.0  0.0 >
       TEXTURE
         COLOR Red
 	 SPECULAR 0.8
 	 ROUGHNESS 0.01
	 AMBIENT 0.4
	 DIFFUSE 0.6
       END_TEXTURE
     END_QUARTIC
     SPHERE <0 0 0> 2 TEXTURE COLOR Clear END_TEXTURE END_SPHERE
     PLANE <0 0  1> 0.5 TEXTURE COLOR Clear END_TEXTURE END_PLANE
     PLANE <0 0 -1> 0.5 TEXTURE COLOR Clear END_TEXTURE END_PLANE
   END_INTERSECTION
   BOUNDED_BY
     SPHERE <0 0 0> 2 END_SPHERE
   END_BOUND
   SCALE <2 2 2>
   ROTATE <0 30 0>
   TRANSLATE <0 0 5>
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -5.0>
   DIRECTION <0.0  0.0  1.0>
   UP        <0.0  1.0  0.0>
   RIGHT     <1.33 0.0  0.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : dish.dat -->

<textarea id="dish.dat" name="dish.dat" style="display:none;">
{ Scene Description of a Satellite Dish by Aaron A. Collins }
{ Made to test the QUADRIC "Paraboloid" and "Cone" Shapes   } 

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <0.0  0.0  -70.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
END_VIEW_POINT

COMPOSITE

  OBJECT			{ The basic dish }
     INTERSECTION
       QUADRIC Paraboloid_Y
         SCALE <30.0 20.0 30.0>
       END_QUADRIC
       QUADRIC Paraboloid_Y
         SCALE <29.0 19.0 29.0>
	 INVERSE
       END_QUADRIC
       PLANE <0.0 1.0 0.0> 20.0 END_PLANE
     END_INTERSECTION
     TEXTURE
       COLOR RED 0.8 GREEN 0.2 BLUE 0.2
       AMBIENT 0.2
       DIFFUSE 0.8
       PHONG 1.0
       PHONGSIZE 10
     END_TEXTURE
     COLOR RED 0.8 GREEN 0.2 BLUE 0.2
  END_OBJECT

  OBJECT			{ The LNA thingy at the focal point }
    UNION
      INTERSECTION
        QUADRIC Cone_Y
          SCALE <1.0 10.0 1.0>
          TRANSLATE <0.0 31.0 0.0>
	  END_QUADRIC
        PLANE <0.0 1.0 0.0> 31.0 END_PLANE
        PLANE <0.0 -1.0 0.0> 0.0 END_PLANE
      END_INTERSECTION
      SPHERE <0.0 30.0 0.0> 2.0 END_SPHERE
    END_UNION
    TEXTURE
      COLOR RED 0.0 GREEN 0.2 BLUE 0.8
      AMBIENT 0.2
      DIFFUSE 0.8
      PHONG 1.0
      PHONGSIZE 30
    END_TEXTURE
    COLOR RED 0.0 GREEN 0.2 BLUE 0.8
  END_OBJECT

  OBJECT			{ The equatorial mount }
    QUADRIC Paraboloid_Y
      ROTATE <180.0 0.0 0.0>
      SCALE <30.0 60.0 30.0>
    END_QUADRIC
    TEXTURE
      COLOR RED 0.0 GREEN 0.8 BLUE 0.2
      AMBIENT 0.2
      DIFFUSE 0.8
      PHONG 1.0
      PHONGSIZE 30
    END_TEXTURE
    COLOR RED 0.0 GREEN 0.8 BLUE 0.2
  END_OBJECT

  ROTATE <-30.0 -30.0 0.0>

END_COMPOSITE

OBJECT
  SPHERE <0.0 0.0 0.0> 2.0 END_SPHERE
  TRANSLATE <100.0  120.0  -130.0>
  TEXTURE
    COLOUR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT

OBJECT
  SPHERE <0.0 0.0 0.0> 2.0 END_SPHERE
  TRANSLATE <-100.0  100.0  -130.0>
  TEXTURE
    COLOUR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : eight.dat -->

<textarea id="eight.dat" name="eight.dat" style="display:none;">
{
* EIGHT.DATA
*
* Written by Ville Saari
* Copyright (c) 1991 Ferry Island Pixelboys
*
* DKBTrace scene description for two billiard balls
* 
* Created: 07-Jan-91
* Updated: 09-Jan-91
*
* You will need number.iff which is included in this package.
*
* If you do some nice modifications or additions to this file, please send 
* me a copy. My Internet address is:
*
*         vsaari@niksula.hut.fi
}

VIEW_POINT
   LOCATION <-15.0 8.0 -10.0>
   DIRECTION <0.0 0.0 1.0>
   UP <0.0 1.0 0.0>
   RIGHT <1.333 0.0 0.0>
   SKY <0.0 1.0 0.0>
   LOOK_AT <0.0 5.0 5.0>
END_VIEW_POINT

OBJECT
   PLANE <0.0 1.0 0.0> 0.0 END_PLANE
   TEXTURE
      0.08
      AMBIENT 0.3
      DIFFUSE 0.7
      COLOUR GREEN 0.7
   END_TEXTURE
   COLOUR GREEN 0.7
END_OBJECT

OBJECT
   SPHERE <0.0 5.0 0.0> 5.0 END_SPHERE
   TEXTURE
      COLOUR RED 0.0  GREEN 0.0  BLUE 0.0
      AMBIENT 0.3
      DIFFUSE 0.7
      BRILLIANCE 1.0 
      PHONG 1.0      
      PHONGSIZE 20
      REFLECTION 0.3
   END_TEXTURE

   TEXTURE
      IMAGEMAP <1.0 -1.0 0.0> IFF "number.iff" ONCE
      TRANSLATE <-0.5 -0.5 -0.5>
      SCALE <4.0 4.0 4.0>
      ROTATE <-30.0 20.0 -45.0>
      TRANSLATE <0.0 5.0 0.0>
      AMBIENT 0.3
      DIFFUSE 0.7
      BRILLIANCE 1.0 
      PHONG 1.0      
      PHONGSIZE 20
      REFLECTION 0.3
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 5.0 10.0> 5.0 END_SPHERE
   COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 0.3
      DIFFUSE 0.7
      BRILLIANCE 1.0 
      PHONG 1.0      
      PHONGSIZE 20
      REFLECTION 0.3
   END_TEXTURE
END_OBJECT

COMPOSITE
   OBJECT
      INTERSECTION
         QUADRIC
            <900.0 900.0 -1.0>
            <0.0 0.0 0.0>
            <0.0 0.0 0.0>
            0.0
            TRANSLATE <0.0 0.0 -30.0>
         END_QUADRIC
         PLANE <0.0 0.0 -1.0> 0.0 END_PLANE
      END_INTERSECTION
      TEXTURE
         WOOD
         TRANSLATE <50.0 -50.0 0.0>
         SCALE <0.3 0.3 1000>
         ROTATE <-10.0 0.0 45.0>
         AMBIENT 0.3
         DIFFUSE 0.7
         PHONG 1.0      
         PHONGSIZE 20
         REFLECTION 0.3
      END_TEXTURE
   END_OBJECT
   OBJECT
      INTERSECTION
         SPHERE <0.0 0.0 -0.2> 1.1 END_SPHERE
         PLANE <0.0 0.0 1.0> 0.0 END_PLANE
         PLANE <0.0 0.0 -1.0> 0.4 END_PLANE
      END_INTERSECTION
      TEXTURE
         COLOUR RED 0.2 GREEN 0.5 BLUE 1.0
         AMBIENT 0.3
         DIFFUSE 0.7
      END_TEXTURE
   END_OBJECT
   ROTATE <-10.0 0.0 45.0>
   TRANSLATE <-4.5 6.0 14.5>
END_COMPOSITE

OBJECT
   SPHERE <0.0 0.0 0.0> 3.0 END_SPHERE
   TRANSLATE <-30.0 30.0 -15.0>
   COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
END_OBJECT
</textarea>

<!-- Sample file : fishx.dat -->

<textarea id="fishx.dat" name="fishx.dat" style="display:none;">
{BOWL.DAT}

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <0.0 10.0 -90.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0 1.0 0.0>
   RIGHT <1.0 0.0 0.0>
END_VIEW_POINT

{Top part of bowl}
OBJECT
    INTERSECTION
       SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
       SPHERE <0.0 0.0 0.0> 19.99 INVERSE END_SPHERE
       PLANE <0.0 1.0 0.0> 15.0 ROTATE <-10.0 0.0 0.0> END_PLANE
       PLANE <0.0 1.0 0.0> 10.0 ROTATE <-10.0 0.0 0.0> INVERSE END_PLANE
    END_INTERSECTION
    TRANSLATE <-8.0 0.0 0.0>
    TEXTURE
       COLOR LightGray ALPHA 0.7
       AMBIENT 0.3
       DIFFUSE 0.7
       REFRACTION 1.0
       IOR 1.5
    END_TEXTURE
END_OBJECT

{Bottom part of bowl}
OBJECT
   INTERSECTION
       SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
       SPHERE <0.0 0.0 0.0> 19.99 INVERSE END_SPHERE
       PLANE <0.0 1.0 0.0> 10.0 ROTATE <-10.0 0.0 0.0> END_PLANE
    END_INTERSECTION
    TRANSLATE <-8.0 0.0 0.0>
    TEXTURE
       AMBIENT 0.3
       DIFFUSE 0.7
       REFRACTION 0.5
    END_TEXTURE
END_OBJECT

OBJECT
    PLANE <0.0 1.0 0.0> -19.0 END_PLANE
    TEXTURE
       CHECKER COLOUR DarkSlateGrey COLOUR IndianRed
       SCALE <10.0 10.0 10.0>
    END_TEXTURE
END_OBJECT

OBJECT
    PLANE <0.0 0.0 1.0> 30.0 END_PLANE
    TEXTURE
       COLOUR RED 0.329804 BLUE 0.204314 GREEN 0.204314
    END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 0.0> 1.5 END_SPHERE
   TRANSLATE <-100.0  100.0  -130.0>
   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
   LIGHT_SOURCE
END_OBJECT


{Picture}
COMPOSITE
  OBJECT
   INTERSECTION
	PLANE <1.0 0.0 0.0> 1.0 END_PLANE
	PLANE <1.0 0.0 0.0> -1.0 INVERSE END_PLANE
	PLANE <0.0 1.0 0.0> 1.0 END_PLANE
	PLANE <0.0 1.0 0.0> -1.0 INVERSE END_PLANE
	PLANE <0.0 0.0 1.0> 1.0 END_PLANE
	PLANE <0.0 0.0 1.0> -1.0 INVERSE END_PLANE
   END_INTERSECTION
    TRANSLATE <1.0 1.0 1.0>
    SCALE <20.0 15.0 1.0>
    TEXTURE
       COLOR White
       AMBIENT 0.05
       DIFFUSE 0.9
    END_TEXTURE
  END_OBJECT

{ The picture frame }
  OBJECT
   UNION
    INTERSECTION
	UNION
	  QUADRIC Cylinder_Y SCALE <1.0 1.0 1.0> TRANSLATE <41.0 0.0 0.0> END_QUADRIC
	  QUADRIC Cylinder_Y SCALE <1.0 1.0 1.0> TRANSLATE <-1.0 0.0 0.0> END_QUADRIC
	END_UNION
	  PLANE <0.0 1.0 0.0> 31.0 END_PLANE
          PLANE <0.0 1.0 0.0> -1.0 INVERSE END_PLANE
    END_INTERSECTION
    INTERSECTION
	UNION
  	  QUADRIC Cylinder_X SCALE <1.0 1.0 1.0> TRANSLATE <0.0 31.0 0.0> END_QUADRIC
	  QUADRIC Cylinder_X SCALE <1.0 1.0 1.0> TRANSLATE <0.0 -1.0 0.0> END_QUADRIC
	END_UNION
	  PLANE <1.0 0.0 0.0> 41.0 END_PLANE
	  PLANE <1.0 0.0 0.0> -1.0 INVERSE END_PLANE
    END_INTERSECTION
	  SPHERE <-1.0 -1.0 0.0> 1.0 END_SPHERE
	  SPHERE <-1.0 31.0 0.0> 1.0 END_SPHERE
	  SPHERE <41.0 -1.0 0.0> 1.0 END_SPHERE
	  SPHERE <41.0 31.0 0.0> 1.0 END_SPHERE
   END_UNION
   TEXTURE
        Pine_Wood
	AMBIENT 0.3
	DIFFUSE 0.7
   END_TEXTURE
  END_OBJECT

    SCALE <1.5 1.5 1.5>
    TRANSLATE <20.0 20.0 29.0>
END_COMPOSITE
</textarea>

<!-- Sample file : folium.dat -->

<textarea id="folium.dat" name="folium.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{
  Folium - a plane with an oogah horn installed (?) or maybe a sassy
           olive sticking out it's pimento!
}

OBJECT
   INTERSECTION
     QUARTIC
     < 0.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0  2.0
       0.0   0.0  -3.0    0.0  0.0   0.0   0.0  -3.0   0.0  0.0
       0.0   0.0   0.0    0.0  0.0   1.0   0.0   0.0   0.0  0.0
       0.0   0.0   1.0    0.0  0.0 >
       TEXTURE
         COLOR Red
         PHONG 1.0
         PHONGSIZE 10
         AMBIENT 0.2
         DIFFUSE 0.8
       END_TEXTURE
     END_QUARTIC
     SPHERE <0 0 0> 10
       TEXTURE
         COLOR Clear
       END_TEXTURE
     END_SPHERE
   END_INTERSECTION
   BOUNDED_BY
     SPHERE <0 0 0> 11 END_SPHERE
   END_BOUND
   ROTATE <0 50 10>
   TRANSLATE <0 0 20>
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -10.0>
   DIRECTION <0.0  0.0  1.0>
   UP        <0.0  1.0  0.0>
   RIGHT     <1.33 0.0  0.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 300 -300>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : hyptorus.dat -->

<textarea id="hyptorus.dat" name="hyptorus.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"


{ Hyperbolic Torus having major radius sqrt(40), minor radius sqrt(12) }
OBJECT
   QUARTIC
   < 1.0   0.0   0.0    0.0     2.0   0.0   0.0  -2.0   0.0 -104.0
     0.0   0.0   0.0    0.0     0.0   0.0   0.0   0.0   0.0    0.0
     1.0   0.0   0.0   -2.0     0.0  56.0   0.0   0.0   0.0    0.0
     1.0   0.0  104.0   0.0   784.0 >
   END_QUARTIC
   BOUNDED_BY
     SPHERE <0 0 0> 20 END_SPHERE
   END_BOUND
   TEXTURE
      COLOR Red
      SPECULAR 1.0
      ROUGHNESS 0.01
      AMBIENT 0.2
      DIFFUSE 0.8
   END_TEXTURE
   ROTATE <90 0 0>
   ROTATE <0 30 0>
   TRANSLATE <0 0 20>
END_OBJECT

{ Put down a floor }
OBJECT
   PLANE <0.0  1.0  0.0> -20.0 END_PLANE
   TEXTURE
      Blue_Agate
      SCALE < 20.0 20.0 20.0 >
      AMBIENT 0.5
      DIFFUSE 0.5
   END_TEXTURE
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -20.0>
   DIRECTION <0.0  0.0   1.0>
   UP        <0.0  1.0   0.0>
   RIGHT     <1.33 0.0   0.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : illum1.dat -->

<textarea id="illum1.dat" name="illum1.dat" style="display:none;">
INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
        LOCATION <0.0 30.0 -200.0>
        DIRECTION <0.0 -0.2 1.0>
        UP <0.0 1.0 0.0>
        RIGHT <1.333 0.0 0.0>
END_VIEW_POINT

OBJECT
        PLANE <0.0 1.0 0.0> -60.0 END_PLANE
        TEXTURE
          0.01
          Pine_Wood
          SCALE <4.0 1.0 2.0>
          ROTATE <0.0 45.0 0.0>
          AMBIENT 0.3
          DIFFUSE 0.7
{	  REFLECTION 0.4	}
          BRILLIANCE 3.0
        END_TEXTURE
END_OBJECT

OBJECT
        QUADRIC Cylinder_X END_QUADRIC
        SCALE <5.0 5.0 5.0>
        TRANSLATE <0.0 -60.0 120.0>
        ROTATE <0.0 -40.0 0.0>
        TEXTURE
          0.01
          COLOUR Brown
          AMBIENT 0.3
          DIFFUSE 0.7
          REFLECTION 0.4
        END_TEXTURE
END_OBJECT

OBJECT
        QUADRIC Cylinder_X END_QUADRIC
        SCALE <5.0 5.0 5.0>
        TRANSLATE <0.0 -60.0 120.0>
        ROTATE <0.0 40.0 0.0>
        TEXTURE
          0.01
          COLOUR Brown
          AMBIENT 0.3
          DIFFUSE 0.7
{         REFLECTION 0.4	}
        END_TEXTURE
END_OBJECT

OBJECT
        PLANE <0.0 0.0 1.0> -240.0 END_PLANE
        TEXTURE
          0.01
          COLOUR Gray
          AMBIENT 0.2
          DIFFUSE 0.7
{         REFLECTION 0.75	}
          BRILLIANCE 3.0
        END_TEXTURE
END_OBJECT

OBJECT
        PLANE <0.0 0.0 1.0> 120.0 END_PLANE
        ROTATE <0.0 -40.0 0.0>
        TEXTURE
          0.01
          COLOUR Gray
          AMBIENT 0.2
          DIFFUSE 0.7
          REFLECTION 0.75
          BRILLIANCE 3.0
        END_TEXTURE
END_OBJECT

OBJECT
        PLANE <0.0 0.0 1.0> 120.0 END_PLANE
        ROTATE <0.0 40.0 0.0>
        TEXTURE
          0.01
          COLOUR Gray
          AMBIENT 0.2
          DIFFUSE 0.7
          REFLECTION 0.75
          BRILLIANCE 3.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 32.659862 0.0> 20.0 END_SPHERE

	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR White ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 0.0 -23.09401> 20.0 END_SPHERE

        ROTATE <0.0 -15.0 0.0>
	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR Red ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 0.0 -23.09401> 20.0 END_SPHERE

        ROTATE <0.0 -135.0 0.0>
	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR Green ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 0.0 -23.09401> 20.0 END_SPHERE

        ROTATE <0.0 105.0 0.0>
	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR Blue ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 -32.659862 -23.09401> 20.0 END_SPHERE

        ROTATE <0.0 -75.0 0.0>
	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR Cyan ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 -32.659862 -23.09401> 20.0 END_SPHERE

        ROTATE <0.0 -195.0 0.0>
	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR Magenta ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 -32.659862 -23.09401> 20.0 END_SPHERE

        ROTATE <0.0 45.0 0.0>
	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR Yellow ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 -32.659862 -46.18802> 20.0 END_SPHERE

        ROTATE <0.0 -15.0 0.0>
	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR DimGray ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 -32.659862 -46.18802> 20.0 END_SPHERE

        ROTATE <0.0 -135.0 0.0>
	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR Turquoise ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 -32.659862 -46.18802> 20.0 END_SPHERE

        ROTATE <0.0 105.0 0.0>
	TEXTURE COLOUR Clear END_TEXTURE
        TEXTURE
          0.01
          COLOUR Tan ALPHA 0.90
          AMBIENT 0.7
          DIFFUSE 0.3
          REFLECTION 0.5
          REFRACTION 1.0
          IOR 1.5
          BRILLIANCE 5.0
        END_TEXTURE
END_OBJECT

OBJECT
        SPHERE <0.0 0.0 0.0> 2.0 END_SPHERE
        TEXTURE
          COLOUR White
          AMBIENT 1.0
          DIFFUSE 0.0
        END_TEXTURE
        LIGHT_SOURCE
        COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : illum2.dat -->

<textarea id="illum2.dat" name="illum2.dat" style="display:none;">
INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
        LOCATION <0.0 30.0 -200.0>
        DIRECTION <0.0 -0.2 1.0>
        UP <0.0 1.0 0.0>
        RIGHT <1.333 0.0 0.0>
END_VIEW_POINT

OBJECT
   INTERSECTION
        PLANE <0.0 0.0 1.0> 1.0 END_PLANE
        PLANE <0.0 0.0 1.0> -1.0 INVERSE END_PLANE
        PLANE <0.0 1.0 0.0> -60.0 END_PLANE
   END_INTERSECTION

   SCALE <1.0 1.0 200.0>

   TEXTURE
        0.01
        Black_Marble
        SCALE <50.0 10.0 20.0>
        ROTATE <0.0 30.0 0.0>
        AMBIENT 0.3
        DIFFUSE 0.7
        REFLECTION 0.4
        BRILLIANCE 3.0
   END_TEXTURE
END_OBJECT

OBJECT
   INTERSECTION
        SPHERE <0.0 0.0 0.0> 10000.0 END_SPHERE
        SPHERE <0.0 0.0 0.0> 9999.0 INVERSE END_SPHERE
   END_INTERSECTION

   TRANSLATE <0.0 -9500.0 0.0>

   TEXTURE
        0.05
        Cloud_Sky
        SCALE <400.0 20.0 800.0>
        ROTATE <0.0 -45.0 0.0>
        AMBIENT 0.3
        DIFFUSE 0.5
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 32.659862 0.0> 20.0 END_SPHERE

   TEXTURE
        0.01
        COLOUR White
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 -23.09401> 20.0 END_SPHERE

   ROTATE <0.0 -15.0 0.0>
   TEXTURE
        0.01
        COLOUR Red
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 -23.09401> 20.0 END_SPHERE

   ROTATE <0.0 -135.0 0.0>
   TEXTURE
        0.01
        COLOUR Green
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 -23.09401> 20.0 END_SPHERE

   ROTATE <0.0 105.0 0.0>
   TEXTURE
        0.01
        COLOUR Blue
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 -32.659862 -23.09401> 20.0 END_SPHERE

   ROTATE <0.0 -75.0 0.0>
   TEXTURE
        0.01
        COLOUR Cyan
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 -32.659862 -23.09401> 20.0 END_SPHERE

   ROTATE <0.0 -195.0 0.0>
   TEXTURE
        0.01
        COLOUR Magenta
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 -32.659862 -23.09401> 20.0 END_SPHERE

   ROTATE <0.0 45.0 0.0>
   TEXTURE
        0.01
        COLOUR Yellow
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 -32.659862 -46.18802> 20.0 END_SPHERE

   ROTATE <0.0 -15.0 0.0>
   TEXTURE
        0.01
        COLOUR DimGray
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 -32.659862 -46.18802> 20.0 END_SPHERE

   ROTATE <0.0 -135.0 0.0>
   TEXTURE
        0.01
        COLOUR Turquoise
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 -32.659862 -46.18802> 20.0 END_SPHERE

   ROTATE <0.0 105.0 0.0>
   TEXTURE
        0.01
        COLOUR Tan
        AMBIENT 0.11
        DIFFUSE 0.22
        REFLECTION 0.7
        BRILLIANCE 5.0
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 0.0> 75.0 END_SPHERE
   TRANSLATE <0.0 9800.0 0.0> 
   ROTATE <-5.0 0.0 2.0>
   TRANSLATE <0.0 -11000.0 0.0>
   TEXTURE
     COLOUR Orange
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR Orange
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
   TRANSLATE <60.0 160.0 -200.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
   TRANSLATE <-60.0 160.0 -200.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : image13.dat -->

<textarea id="image13.dat" name="image13.dat" style="display:none;">
{ Image13.Dat }
{ Two rows of multi-colored pillars lead to a chrome hemisphere }
{ reflecting a blinding sunrise.}
{ - Drew Wells 1990 CIS 73767,1244 }

{ This file is for use with DKBTrace by David Buck. }
{ This file is released into the public domain. }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ Camera }
VIEW_POINT
   LOCATION <0.0  20.0 -100.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.333333333 0.0 0.0>
END_VIEW_POINT


{ Ground }
OBJECT
   PLANE < 0.0 1.0 0.0 > -10. END_PLANE
   TEXTURE
     White_Marble
     SCALE <10.0 10.0 10.0>
     AMBIENT 0.3
     DIFFUSE 0.7
   END_TEXTURE
   COLOR White
END_OBJECT

{ Sky/Ceiling }
OBJECT
  QUADRIC Sphere
    TRANSLATE < 0.0 0.0 0.0 >
    SCALE     < 200.0 100.0 200.0 >
    INVERSE
  END_QUADRIC
  TEXTURE
    0.05
    BOZO
    TURBULENCE 0.3
    COLOUR_MAP { Sky Colors }
    	[0.0 0.5   COLOUR RED 0.25 GREEN 0.25 BLUE 0.5
                   COLOUR RED 0.25 GREEN 0.25 BLUE 0.5]
	[0.5 0.6   COLOUR RED 0.25 GREEN 0.25 BLUE 0.5
                   COLOUR RED 0.7 GREEN 0.7 BLUE 0.7]
        [0.6 1.001 COLOUR RED 0.7 GREEN 0.7 BLUE 0.7
		   COLOUR RED 0.3 GREEN 0.3 BLUE 0.3]
    END_COLOUR_MAP
    SCALE <50.0 50.0 50.0>
    TRANSLATE <200.0 400.0 100.0>
    AMBIENT 0.6
    DIFFUSE 0.7
  END_TEXTURE
  COLOR White
END_OBJECT

{ Mirrored sphere to reflect sun }
{ Diffuse value controls aura effect }
OBJECT
   SPHERE < 0.0 0.0 110.0 > 40.0 END_SPHERE
   TEXTURE {mirror}
      COLOR White
      AMBIENT 0.0
      DIFFUSE 0.3
      REFLECTION 1.0
      BRILLIANCE 3.0
      SPECULAR 1.0
      ROUGHNESS 0.01
   END_TEXTURE
   COLOR White
END_OBJECT

{ Two rows of pillars - Grouped two per object for easy manipulation }
OBJECT
   UNION
      QUADRIC
         Cylinder_Y
	 SCALE <6.0 1.0 3.0>
	 TRANSLATE <-60.0 0.0 0.0>
      END_QUADRIC
      QUADRIC
         Cylinder_Y
	 SCALE <6.0 1.0 3.0>
	 TRANSLATE <60.0 0.0 0.0>
      END_QUADRIC
      QUADRIC
         Cylinder_Y
	 SCALE <6.0 1.0 3.0>
	 TRANSLATE <-60.0 0.0 180.0>
      END_QUADRIC
      QUADRIC
         Cylinder_Y
	 SCALE <6.0 1.0 3.0>
	 TRANSLATE <60.0 0.0 180.0>
      END_QUADRIC
      QUADRIC
         Cylinder_Y
	 SCALE <6.0 1.0 3.0>
	 TRANSLATE <-60.0 0.0 60.0>
      END_QUADRIC
      QUADRIC
         Cylinder_Y
	 SCALE <6.0 1.0 3.0>
	 TRANSLATE <60.0 0.0 60.0>
      END_QUADRIC
   END_UNION
   TEXTURE
     Blue_Agate
     SCALE <10.0 10.0 10.0>
     AMBIENT 0.2
     DIFFUSE 0.7
     BRILLIANCE 3.0
     SPECULAR 1.0
     ROUGHNESS 0.01
   END_TEXTURE
   COLOR Blue
END_OBJECT

OBJECT
   UNION
      QUADRIC
         Cylinder_Y
	 SCALE <6.0 1.0 3.0>
	 TRANSLATE <-60.0 0.0 30.0>
      END_QUADRIC
      QUADRIC
         Cylinder_Y
	 SCALE <6.0 1.0 3.0>
	 TRANSLATE <60.0 0.0 30.0>
      END_QUADRIC
   END_UNION
   TEXTURE
      GRADIENT < 1.0 1.0 0.0 >
      COLOUR_MAP
         [0.00 0.25  COLOUR RED 0.0 GREEN 0.0 BLUE 1.0
                     COLOUR RED 0.7 GREEN 0.3 BLUE 0.0]
         [0.25 0.75  COLOUR RED 1.0 GREEN 0.0 BLUE 1.0
                     COLOUR RED 0.8 GREEN 0.4 BLUE 1.0]
         [0.75 1.001 COLOUR RED 0.0 GREEN 0.3 BLUE 0.8
                     COLOUR RED 0.7 GREEN 0.3 BLUE 0.0]
      END_COLOUR_MAP
      SCALE <30.0 30.0 30.0>
      TRANSLATE <30.0 -30.0 0.0>
      AMBIENT 0.2
      DIFFUSE 0.7
      BRILLIANCE 3.0
      SPECULAR 1.0
      ROUGHNESS 0.01
  END_TEXTURE
  COLOR White
END_OBJECT

OBJECT
   INTERSECTION
      UNION
         QUADRIC
            Cylinder_Y
            SCALE <6.0 1.0 3.0>
            TRANSLATE <-60.0 0.0 60.0>
         END_QUADRIC
         QUADRIC
            Cylinder_Y
            SCALE <6.0 1.0 3.0>
            TRANSLATE <60.0 0.0 60.0>
         END_QUADRIC
      END_UNION
      PLANE < 0.0 1.0 0.0 > 250.0 END_PLANE
   END_INTERSECTION
   TEXTURE
     Blue_Agate
     SCALE <10.0 10.0 10.0>
     SPECULAR 1.0
     ROUGHNESS 0.01
  END_TEXTURE
  COLOR Blue
END_OBJECT

OBJECT
   INTERSECTION
      UNION
         QUADRIC
            Cylinder_Y
            SCALE <6.0 1.0 3.0>
            TRANSLATE <-60.0 0.0 90.0>
         END_QUADRIC
         QUADRIC
            Cylinder_Y
            SCALE <6.0 1.0 3.0>
            TRANSLATE <60.0 0.0 90.0>
         END_QUADRIC
      END_UNION
      PLANE < 0.0 1.0 0.0 > 250.0 END_PLANE
   END_INTERSECTION
   TEXTURE
      GRADIENT < 1.0 1.0 0.0 >
      COLOUR_MAP
         [0.00 0.25  COLOUR RED 0.0 GREEN 0.8 BLUE 0.4
                     COLOUR RED 0.2 GREEN 0.3 BLUE 0.0]
         [0.25 0.75  COLOUR RED 0.0 GREEN 0.0 BLUE 0.8
                     COLOUR RED 0.1 GREEN 0.6 BLUE 1.0]
         [0.75 1.001 COLOUR RED 0.0 GREEN 0.3 BLUE 0.4
                     COLOUR RED 0.8 GREEN 0.8 BLUE 0.0]
       END_COLOUR_MAP
       SCALE <30.0 30.0 30.0>
       TRANSLATE <30.0 -30.0 0.0>
       AMBIENT 0.2
       DIFFUSE 0.7
       BRILLIANCE 3.0
       SPECULAR 1.0
       ROUGHNESS 0.01
   END_TEXTURE
   COLOR White
END_OBJECT

OBJECT
   INTERSECTION
      UNION
         QUADRIC
            Cylinder_Y
            SCALE <6.0 1.0 3.0>
            TRANSLATE <-60.0 0.0 120.0>
         END_QUADRIC
         QUADRIC
            Cylinder_Y
            SCALE <6.0 1.0 3.0>
            TRANSLATE <60.0 0.0 120.0>
         END_QUADRIC
      END_UNION
      PLANE < 0.0 1.0 0.0 > 250.0 END_PLANE
   END_INTERSECTION
   TEXTURE
     Blue_Agate
     SCALE <10.0 10.0 10.0>
     SPECULAR 1.0
     ROUGHNESS 0.01
  END_TEXTURE
  COLOR Blue
END_OBJECT

OBJECT
   INTERSECTION
      UNION
         QUADRIC
            Cylinder_Y
            SCALE <6.0 1.0 3.0>
            TRANSLATE <-60.0 0.0 150.0>
         END_QUADRIC
         QUADRIC
            Cylinder_Y
            SCALE <6.0 1.0 3.0>
            TRANSLATE <60.0 0.0 150.0>
         END_QUADRIC
      END_UNION
      PLANE < 0.0 1.0 0.0 > 250.0 END_PLANE
   END_INTERSECTION
   TEXTURE
      GRADIENT < 1.0 1.0 0.0 >
      COLOUR_MAP
         [0.00 0.25  COLOUR RED 0.0 GREEN 0.8 BLUE 0.4
                     COLOUR RED 0.2 GREEN 0.3 BLUE 0.0]
         [0.25 0.75  COLOUR RED 0.0 GREEN 0.0 BLUE 0.8
                     COLOUR RED 0.1 GREEN 0.6 BLUE 1.0]
         [0.75 1.001 COLOUR RED 0.0 GREEN 0.3 BLUE 0.4
                     COLOUR RED 0.8 GREEN 0.8 BLUE 0.0]
      END_COLOUR_MAP
      SCALE <30.0 30.0 30.0>
      TRANSLATE <30.0 -30.0 0.0>
      AMBIENT 0.2
      DIFFUSE 0.7
      BRILLIANCE 3.0
      SPECULAR 1.0
      ROUGHNESS 0.01
   END_TEXTURE
   COLOR White
END_OBJECT

{ The Blinding Sun }
OBJECT
    SPHERE <0.0 0.0 0.0> 25.0 END_SPHERE
    TRANSLATE < 0.0 50.0 -100.0 >
    TEXTURE
       COLOUR White
       AMBIENT 1.0
       DIFFUSE 0.0
    END_TEXTURE
    LIGHT_SOURCE
    COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : kscope.dat -->

<textarea id="kscope.dat" name="kscope.dat" style="display:none;">
INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
	LOCATION <0.0 0.0 -100.0>
	UP <0.0 1.0 0.0>
	RIGHT <1.3333 0.0 0.0>
	LOOK_AT <0.0 11.547005 0.0>
END_VIEW_POINT

{The Kaleidoscope Tube}
COMPOSITE
COMPOSITE
  OBJECT
	UNION
	  TRIANGLE <0.0  1.1547005 -100.0>
		   <0.0  1.1547005  0.0>
		   <-1.0 -0.5773502 0.0>
	  INVERSE END_TRIANGLE

	  TRIANGLE <0.0  1.1547005 -100.0>
		   <-1.0 -0.5773502 -100.0>
		   <-1.0 -0.5773502 0.0>
          INVERSE END_TRIANGLE
	END_UNION
	TEXTURE 0.05
    	   AMBIENT 0.1
	   DIFFUSE 0.7
	   COLOUR White
	   REFLECTION 1.0
  	END_TEXTURE
  END_OBJECT

  OBJECT
	UNION
	  TRIANGLE <-0.001  1.1547005 -100.0>
		   <-0.001  1.1547005  0.0>
		   <1.0 -0.5773502  0.0>
	  INVERSE END_TRIANGLE


	  TRIANGLE <-0.001  1.1547005 -100.0>
		   <1.0 -0.5773502 -100.0>
		   <1.0 -0.5773502 0.0>
	  INVERSE END_TRIANGLE
	END_UNION
	TEXTURE 0.05
	   AMBIENT 0.1
	   DIFFUSE 0.7
	   COLOUR White
	   REFLECTION 1.0
        END_TEXTURE
  END_OBJECT

  OBJECT
	UNION
	  TRIANGLE
		  <-1.0 -0.5773502 -100.0>
		  <1.0  -0.5773502 -100.0>
		  <-1.0 -0.5773502 0.0>
	  END_TRIANGLE

	  TRIANGLE
		  <1.0  -0.5773502 -100.0>
		  <-1.0 -0.5773502 0.0>
		  <1.0 -0.5773502 0.0>
	END_TRIANGLE
	END_UNION
	TEXTURE
	   0.05
	   Cloud_Sky
	   AMBIENT 0.5
	   DIFFUSE 0.5
	END_TEXTURE
	COLOUR Cyan
  END_OBJECT

  OBJECT
	TRIANGLE <-1.0 -0.5773502 0.0>
		 <1.0 -0.5773502 0.0>
	         <0.0  1.1547005  0.0>
	END_TRIANGLE
        COLOUR RED 0.5 GREEN 0.5 BLUE 0.5 ALPHA 0.3
        TEXTURE
           0.1
	   AMBIENT 0.3
	   DIFFUSE 0.7
	   COLOUR RED 0.5 GREEN 0.5 BLUE 0.5 ALPHA 0.3
	END_TEXTURE
  END_OBJECT

  SCALE <10.0 10.0 1.0>
END_COMPOSITE

  OBJECT
	SPHERE <-3.5 -3.0 -45.0> 3.0 END_SPHERE
	TEXTURE
	   0.05
	   AMBIENT 0.1
	   DIFFUSE 0.7
	   COLOUR Red ALPHA 0.8
	   REFLECTION 0.2 
	   REFRACTION 1.0
	   IOR 1.2
	   BRILLIANCE 3.0
        END_TEXTURE
  END_OBJECT

  OBJECT
	SPHERE <4.0 -3.0 -40.0> 2.5 END_SPHERE
	TEXTURE
           0.05
	   AMBIENT 0.1
	   DIFFUSE 0.7
	   COLOUR Green ALPHA 0.8
	   REFLECTION 0.2 
	   REFRACTION 1.0
	   IOR 1.2
	   BRILLIANCE 3.0
        END_TEXTURE
  END_OBJECT

  OBJECT
	SPHERE <0.0 4.0 -30.0> 2.0 END_SPHERE
	TEXTURE
           0.05
	   AMBIENT 0.1
	   DIFFUSE 0.7
	   COLOUR Magenta ALPHA 0.8
	   REFLECTION 0.2 
	   REFRACTION 1.0
	   IOR 1.2
	   BRILLIANCE 3.0
        END_TEXTURE
  END_OBJECT

  OBJECT
	SPHERE <0.0 -2.0 -20.0> 2.0 END_SPHERE
	TEXTURE
	   0.05
	   AMBIENT 0.1
	   DIFFUSE 0.7
	   COLOUR Yellow ALPHA 0.8
	   REFLECTION 0.2 
	   REFRACTION 1.0
	   IOR 1.2
	   BRILLIANCE 3.0
        END_TEXTURE
  END_OBJECT

  OBJECT
	SPHERE <2.0 -4.0 -70.0> 2.0 END_SPHERE
	TEXTURE 0.05
	   AMBIENT 0.1
	   DIFFUSE 0.7
	   COLOUR Cyan ALPHA 0.8
	   REFLECTION 0.2 
	   REFRACTION 1.0
	   IOR 1.2
 	   BRILLIANCE 3.0
        END_TEXTURE
  END_OBJECT

  OBJECT
	TRIANGLE
		<-1.0 -8.0 -50.0>
		< 0.0  1.0 -50.0>
		< 2.0 -3.0 -50.0>
	END_TRIANGLE

	TEXTURE
           0.05
	   AMBIENT 0.3
	   DIFFUSE 0.7
	   COLOUR RED 0.8 GREEN 0.5 BLUE 0.3 ALPHA 0.9
        END_TEXTURE
  END_OBJECT
		
  OBJECT
	TRIANGLE
		<1.0 7.0 -5.0>
		< -4.0  -1.0 -5.0>
		< 3.0 1.0 -5.0>
	END_TRIANGLE

        TEXTURE
	   0.05
	   AMBIENT 0.3
	   DIFFUSE 0.7
	   COLOUR RED 0.2 GREEN 0.9 BLUE 0.5 ALPHA 0.9
        END_TEXTURE
  END_OBJECT
		
  OBJECT
	TRIANGLE
		<-8.0 -5.0 -80.0>
		< -4.0  -1.0 -80.0>
		< 0.0 -4.0 -80.0>
	END_TRIANGLE
	TEXTURE
           0.05
	   AMBIENT 0.3
	   DIFFUSE 0.7
	   COLOUR RED 0.7 GREEN 0.7 BLUE 0.3 ALPHA 1.0
	   REFRACTION 0.9
	   IOR 1.0
        END_TEXTURE
  END_OBJECT

  OBJECT
	UNION
	   TRIANGLE
		<0.0 0.0 0.0>
		<0.0 1.0 0.0>
		<1.0 0.0 0.0>
	   END_TRIANGLE

	   TRIANGLE
		<1.0 0.0 0.0>
		<0.0 1.0 0.0>
		<1.0 1.0 0.0>
	   END_TRIANGLE
	END_UNION
	   ROTATE <20.0 45.0 -10.0>
	   TRANSLATE <-0.6 -0.5 -65.0>
	   SCALE <10.0 10.0 1.0>
	   TEXTURE
	   	AMBIENT 0.5
	   	DIFFUSE 0.3
		IMAGEMAP <1.0 -1.0 0.0> GIF "sunset.gif" ONCE
		ROTATE <20.0 45.0 -10.0>
		TRANSLATE <-0.6 -0.5 -65.0>
		SCALE <9.0 9.0 1.0>
		REFRACTION 0.25
		IOR 1.0
	   END_TEXTURE
   END_OBJECT

END_COMPOSITE

OBJECT
	SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
	TRANSLATE <0.0 0.0 20.0>
	TEXTURE
	   AMBIENT 1.0
	   DIFFUSE 0.0
	   COLOUR White
	END_TEXTURE
	COLOUR White
	LIGHT_SOURCE
END_OBJECT
</textarea>

<!-- Sample file : lamp.dat -->

<textarea id="lamp.dat" name="lamp.dat" style="display:none;">
{ DKB Data file LAMP.DAT originally by ?? }

{ This would have won the Intl. Obfuscated DKB Code Contest, So I }
{ reformatted it while converting it to DKB 2.10 :-)  All kidding }
{ aside, nice job, whoever wrote it!  -  Aaron A. Collins }

INCLUDE "colors.dat"
INCLUDE "shapes.dat"	{ contains the new "X_Disk" primitive }
INCLUDE "textures.dat"

VIEW_POINT
  LOCATION <0.0 -80.0 0.0>
  DIRECTION <0.0 1.0 0.0>
  UP <0.0 0.0 1.0>
  RIGHT <1.333333 0.0 0.0>
  TRANSLATE < 25.0 0.0 5.0 >
  ROTATE < -30.0 0.0 30.0 >
END_VIEW_POINT

OBJECT
  SPHERE <0.0 0.0 0.0> 1.0 END_SPHERE
  TRANSLATE <44.514 0.0 13.5>
  TEXTURE
    COLOR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOR White
END_OBJECT

OBJECT
  SPHERE <0.0 0.0 0.0> 1.0 END_SPHERE
  TRANSLATE <-60.514 0.0 160.5>
  TEXTURE
    COLOR RED 0.7 GREEN 0.7 BLUE 0.7
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOR RED 0.7 GREEN 0.7 BLUE 0.7
END_OBJECT

OBJECT
  SPHERE < 0.0 0.0 0.0 > 5.0 END_SPHERE
  TEXTURE Brass END_TEXTURE
END_OBJECT

OBJECT
  SPHERE < 38.161 0.0 17.197 > 1.0 END_SPHERE
  TEXTURE Brass END_TEXTURE
END_OBJECT

OBJECT
  SPHERE < 9.307 0.0 30.288 > 1.0 END_SPHERE
  TEXTURE Brass END_TEXTURE
END_OBJECT

OBJECT
  INTERSECTION X_Disk END_INTERSECTION
  SCALE < 31.685 1.0 1.0 >
  ROTATE < 0.0 -72.9193 0.0 >
  TEXTURE Brass END_TEXTURE
END_OBJECT

OBJECT INTERSECTION X_Disk END_INTERSECTION
  SCALE < 31.685 1.0 1.0 >
  ROTATE < 0.0 -155.5969 0.0 >
  TRANSLATE < 38.161 0.0 17.197 >
  TEXTURE Brass END_TEXTURE
END_OBJECT

OBJECT
  INTERSECTION X_Disk END_INTERSECTION
  SCALE < 3.2 0.5 0.5 >
  TRANSLATE < 38.161 0.0 17.197 >
  TEXTURE Brass END_TEXTURE
END_OBJECT

OBJECT
  INTERSECTION
    QUADRIC
      Cone_Z
      SCALE < 1.0 1.0 1.0 >
      TRANSLATE < 44.514 0.0 17.685 >
    END_QUADRIC
    QUADRIC
      Cone_Z
      SCALE < 1.0 1.0 1.0 >
      TRANSLATE < 44.514 0.0 16.685 >
      INVERSE
    END_QUADRIC
    PLANE < 0.0 0.0 1.0 > 7.685 INVERSE END_PLANE
    PLANE < 0.0 0.0 1.0 > 13.695 END_PLANE
  END_INTERSECTION
  TEXTURE Brass END_TEXTURE
END_OBJECT

OBJECT
  INTERSECTION
    QUADRIC
      Cone_Z
      SCALE < 0.2 0.2 1.0 >
      TRANSLATE < 44.514 0.0 33.496 >
    END_QUADRIC
    QUADRIC
      Cone_Z
      SCALE < 0.2 0.2 1.0 >
      TRANSLATE < 44.514 0.0 32.496 >
      INVERSE
    END_QUADRIC
    PLANE < 0.0 0.0 1.0 > 13.695 INVERSE END_PLANE
    PLANE < 0.0 0.0 1.0 > 23.496 END_PLANE
  END_INTERSECTION
  TEXTURE Brass END_TEXTURE
END_OBJECT

OBJECT
  PLANE < 0.0 0.0 1.0 > -4.0 END_PLANE
  TEXTURE
    COLOR Red
    AMBIENT 0.4
    DIFFUSE 0.6
    BRILLIANCE 8.0
    REFLECTION 0.8
    PHONG 1.0
    PHONGSIZE 30.0
  END_TEXTURE
END_OBJECT
</textarea>

<!-- Sample file : lemnisc2.dat -->

<textarea id="lemnisc2.dat" name="lemnisc2.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

COMPOSITE
   { Lemniscate of Gerono }
   OBJECT
      QUARTIC
      < 1.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0 -1.0
        0.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0  0.0
        0.0   0.0   0.0    0.0  0.0   1.0   0.0   0.0   0.0  0.0
        0.0   0.0   1.0    0.0  0.0 >
      END_QUARTIC
      BOUNDED_BY
      SPHERE <0 0 0> 2.01 END_SPHERE
      END_BOUND
	  TEXTURE
	    COLOR Red
		PHONG 1.0
		PHONGSIZE 10
		AMBIENT 0.2
		DIFFUSE 0.8
	  END_TEXTURE
	  ROTATE <0 0 45>
   END_OBJECT

   { Lemniscate of Gerono }
   OBJECT
      QUARTIC
      < 1.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0 -1.0
	    0.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0  0.0
		0.0   0.0   0.0    0.0  0.0   1.0   0.0   0.0   0.0  0.0
		0.0   0.0   1.0    0.0  0.0 >
      END_QUARTIC
      BOUNDED_BY
      SPHERE <0 0 0> 2.01 END_SPHERE
      END_BOUND
	  TEXTURE
	    COLOR Blue
		PHONG 1.0
		PHONGSIZE 10
		AMBIENT 0.2
		DIFFUSE 0.8
	  END_TEXTURE
	  ROTATE <0 0 -45>
   END_OBJECT

   SCALE <4 4 4>
   ROTATE <30 0 20>
   TRANSLATE <0 0 5>

END_COMPOSITE

VIEW_POINT
   LOCATION  <0.0  0.0 -10.0>
   RIGHT     <1.0  0.0  0.0>
   UP        <0.0  1.0  0.0>
   DIRECTION <0.0  0.0  1.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0 > 1 END_SPHERE
   TRANSLATE <200 30 -30>
   TEXTURE
     COLOUR White
	 AMBIENT 1.0
	 DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOUR White
	 AMBIENT 1.0
	 DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

{ Put down floor }
OBJECT
   PLANE <0.0 1.0 0.0> -30.0 END_PLANE
   TEXTURE
     White_Marble
     SCALE <30 30 30>
	 AMBIENT 0.3
	 DIFFUSE 0.7
   END_TEXTURE
   ROTATE <5 0 0>
END_OBJECT

</textarea>

<!-- Sample file : lemnisca.dat -->

<textarea id="lemnisca.dat" name="lemnisca.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ Lemniscate of Gerono }
OBJECT
   QUARTIC
   < 1.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0 -1.0
     0.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0  0.0
     0.0   0.0   0.0    0.0  0.0   1.0   0.0   0.0   0.0  0.0
     0.0   0.0   1.0    0.0  0.0 >
   END_QUARTIC
   BOUNDED_BY
   SPHERE <0 0 0> 2 END_SPHERE
   END_BOUND
   TEXTURE
      COLOR Red
      PHONG 1.0
      PHONGSIZE 10
      AMBIENT 0.2
      DIFFUSE 0.8
   END_TEXTURE
   ROTATE <0 -45 0>
   TRANSLATE <0 0 2>
END_OBJECT

{ Put down checkered floor }
OBJECT
   PLANE <0.0 1.0 0.0> -20.0 END_PLANE
   TEXTURE
      CHECKER COLOUR NavyBlue COLOUR MidnightBlue
      SCALE < 20.0 20.0 20.0 >
      AMBIENT 0.8
      DIFFUSE 0.2
   END_TEXTURE
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  1.0 -2.0>
   UP 	     <0.0  1.0  0.0>
   RIGHT     <1.33 0.0  0.0>
   LOOK_AT   <0.0  0.0  5.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOR White
END_OBJECT
</textarea>

<!-- Sample file : lily1.dat -->

<textarea id="lily1.dat" name="lily1.dat" style="display:none;">
{   LILY1.DAT  DKBTrace Script             January 26, '91
    By Dan Farmer
    1001 E. 80th Street, Apt #102
    Minneapolis, MN 55425

    Renders a water lily & pad on a pond.

    This data file is for use with DKBTrace by David Buck.  This file
    is released to the public domain and may be used or altered by
    anyone as desired.

}

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ A speckled yellow texture }
DECLARE StamenTexture = TEXTURE
    BUMPS 0.3
    GRANITE 0.5
    COLOR_MAP
        [0.00 0.40 COLOR Yellow COLOR Yellow]
        [0.40 0.50 COLOR Gold COLOR Wheat]
        [0.50 1.001 COLOR Wheat COLOR Yellow]
    END_COLOR_MAP
    SCALE <0.5 0.5 0.5>
END_TEXTURE

DECLARE Petal = OBJECT
{ Creates a shape like a wedge of orange peel
 With the main axis is in the Z plane, rotated upward on the X axis.

               ^
             /   \                ^
           /       \              |
         /           \            Y
       /               \          |
      --_             _--         v
         --_      _ --
              --               <- X ->
}
    INTERSECTION
        SPHERE <0.0 0.0 0.0> 30.0 END_SPHERE
        SPHERE <0.0 0.0 0.0> 29.9 INVERSE END_SPHERE
        PLANE <-1.0 0.0 0.0> 0.0 ROTATE <0.0 0.0 -45.0> END_PLANE
        PLANE <1.0 0.0 0.0> 0.0 ROTATE <0.0 0.0 45.0> END_PLANE
    END_INTERSECTION
    TEXTURE
       COLOR White
    END_TEXTURE
    COLOR White
    ROTATE <-20.0 0.0 0.0>
END_OBJECT

{ Rotate the petals around the center point to create the flower composite}
DECLARE PetalLayer1 = COMPOSITE
  OBJECT Petal TRANSLATE <0.0 0.0 30.0> END_OBJECT
  OBJECT Petal TRANSLATE <0.0 0.0 30.0> ROTATE < 0.0  -45.000000 0.0 > END_OBJECT
  OBJECT Petal TRANSLATE <0.0 0.0 30.0> ROTATE < 0.0  -90.000000 0.0 > END_OBJECT
  OBJECT Petal TRANSLATE <0.0 0.0 30.0> ROTATE < 0.0 -135.000000 0.0 > END_OBJECT
  OBJECT Petal TRANSLATE <0.0 0.0 30.0> ROTATE < 0.0  180.000000 0.0 > END_OBJECT
  OBJECT Petal TRANSLATE <0.0 0.0 30.0> ROTATE < 0.0 -225.000000 0.0 > END_OBJECT
  OBJECT Petal TRANSLATE <0.0 0.0 30.0> ROTATE < 0.0 -270.000000 0.0 > END_OBJECT
  OBJECT Petal TRANSLATE <0.0 0.0 30.0> ROTATE < 0.0 -315.000000 0.0 > END_OBJECT
  OBJECT SPHERE <0.0 -6.0 0.0> 15.0 END_SPHERE
      COLOR Yellow
      TEXTURE StamenTexture END_TEXTURE
  END_OBJECT
  ROTATE <0.0 -22.5 0.0>     { rotate 1/2 of the 45 degree step }
END_COMPOSITE

{******************************************************************************}
{ You }
VIEW_POINT
   LOCATION <20.0  120.0  -170.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
   LOOK_AT <0.0 0.0  -30.0>
END_VIEW_POINT

{ The Sun}
OBJECT  
   SPHERE <0.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <10.0  200.0  -150.0>
   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
   LIGHT_SOURCE
END_OBJECT

{ The pond }
OBJECT
    PLANE <0.0 1.0 0.0> 0.0 END_PLANE
    COLOR Blue
    TEXTURE
        COLOR Blue
        WAVES 0.3
        FREQUENCY 100.0
        SCALE <1000.0 1000.0 1000.0>
    END_TEXTURE
END_OBJECT

{ Create a somewhat rounded lily-pad with the split in one end, and a
  "cleavage-line" down the center }
OBJECT
    UNION
        QUADRIC Sphere
            SCALE <45.0 5.0 25.0>
            TRANSLATE <45.0 0.0 0.0>
        END_QUADRIC
        QUADRIC Sphere
            SCALE <45.0 5.0 25.0>
            TRANSLATE <45.0 0.0 0.0>
            ROTATE <0.0 -20.0 0.0>
        END_QUADRIC
        TRANSLATE <0.0 0.0 0.0>
    END_UNION
    TRANSLATE <-45.0 0.0 -10.0>
    SCALE <2.5 2.5 2.5>
    TEXTURE
       COLOR Green
    END_TEXTURE
END_OBJECT

{ Now, put it all together.}
COMPOSITE PetalLayer1 TRANSLATE <15.0 45.0 -10.0> END_COMPOSITE
</textarea>

<!-- Sample file : lpops1.dat -->

<textarea id="lpops1.dat" name="lpops1.dat" style="display:none;">
{LPOPS2.DAT - Original Data File By Tom Price }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
        LOCATION <0.0 35.0 -150.0>
        UP <0.0 1.0 0.0>
        RIGHT <1.3333 0.0 0.0>
        LOOK_AT <0.0 0.0 0.0>
END_VIEW_POINT

{The floor}
OBJECT
   PLANE <0.0 1.0 0.0> -60.0 END_PLANE
   TEXTURE 
        0.05 
        CHECKER COLOUR Brown COLOUR LightGray
        SCALE <40.0 40.0 40.0>
        AMBIENT 0.3
        DIFFUSE 0.7
        REFLECTION 0.4
        PHONG 1.0
        PHONGSIZE 20.0
   END_TEXTURE
   COLOUR RED 0.4 BLUE 0.4 GREEN 0.4
END_OBJECT

{The Sky}
OBJECT
   SPHERE <0.0 -40000.0 0.0> 50000.0 END_SPHERE
   TEXTURE 
        0.05 
        Cloud_Sky
        SCALE <8000.0 3000.0 3000.0>
        AMBIENT 0.7
        DIFFUSE 0.0
   END_TEXTURE
   COLOUR Blue
END_OBJECT

COMPOSITE
  OBJECT
     INTERSECTION
        SPHERE <0.0 0.0 0.0> 40.0 END_SPHERE
        QUADRIC Cylinder_Z SCALE <20.0 20.0 1.0> INVERSE END_QUADRIC
     END_INTERSECTION
     TEXTURE
        0.05
        COLOUR RED 0.6 GREEN 0.6 BLUE 0.0 
        AMBIENT 0.3
        DIFFUSE 0.7
        REFLECTION 0.7
        BRILLIANCE 6.0
        SPECULAR 0.5
     END_TEXTURE
  END_OBJECT

  COMPOSITE
     OBJECT
        TRIANGLE
           <-1.0 0.0 -0.5773502>
           < 1.0 0.0 -0.5773502>
           < 0.0 0.0  1.1547005>
        END_TRIANGLE
        TEXTURE
           0.05
           COLOUR Gold
           AMBIENT 0.3
           DIFFUSE 0.7
           REFLECTION 0.4
           BRILLIANCE 6.0
        END_TEXTURE
     END_OBJECT

     OBJECT
        TRIANGLE
           <-1.0 0.0 -0.5773502>
           < 0.0 0.0  1.1547005>
           < 0.0 1.6329931  0.0>
        END_TRIANGLE
        TEXTURE
           0.05
           COLOUR Gold
           AMBIENT 0.3
           DIFFUSE 0.7
           REFLECTION 0.4
           BRILLIANCE 6.0
        END_TEXTURE
     END_OBJECT
 
     OBJECT
        TRIANGLE
           < 1.0 0.0 -0.5773502>
           < 0.0 0.0  1.1547005>
           < 0.0 1.6329931  0.0>
        END_TRIANGLE
        TEXTURE
           0.05
           COLOUR Gold
           AMBIENT 0.3
           DIFFUSE 0.7
           REFLECTION 0.4
           BRILLIANCE 6.0
        END_TEXTURE
     END_OBJECT

     OBJECT
        TRIANGLE
           <-1.0 0.0 -0.5773502>
           < 1.0 0.0 -0.5773502>
           < 0.0 1.6329931  0.0>
        END_TRIANGLE
        TEXTURE
           0.05
           COLOUR RED 0.5 GREEN 0.4 BLUE 0.0
           AMBIENT 0.4
           DIFFUSE 0.6
           REFLECTION 0.2
           BRILLIANCE 6.0
        END_TEXTURE
     END_OBJECT

     TRANSLATE <0.0 -0.4082886 0.0>
     SCALE <15.0 15.0 15.0>
     ROTATE <-45.0 -50.0 10.0>
  END_COMPOSITE

  OBJECT
     INTERSECTION
        QUADRIC Cylinder_Y SCALE <7.0 1.0 7.0> END_QUADRIC
        PLANE <0.0 1.0 0.0> -20.0 END_PLANE
     END_INTERSECTION
     TEXTURE
        0.05
        Pine_Wood
        SCALE <10.0 100.0 10.0> 
        AMBIENT 0.3
        DIFFUSE 0.7
        REFLECTION 0.5
        SPECULAR 0.5
     END_TEXTURE
  END_OBJECT
  TRANSLATE <10.0 20.0 60.0>
END_COMPOSITE

COMPOSITE
  OBJECT
     SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
     TEXTURE
     	Glass
        0.05
     END_TEXTURE
  END_OBJECT    

  OBJECT
     INTERSECTION
        QUADRIC Cylinder_Y SCALE <3.0 1.0 3.0> END_QUADRIC
        PLANE <0.0 1.0 0.0> 0.0 END_PLANE
     END_INTERSECTION
     TEXTURE
        0.05
        Pine_Wood
        SCALE <10.0 50.0 10.0>  
        AMBIENT 0.3
        DIFFUSE 0.7
        REFLECTION 0.5
        SPECULAR 0.5
        END_TEXTURE
  END_OBJECT
  TRANSLATE <-40.0 15.0 -10.0>
END_COMPOSITE

COMPOSITE
  OBJECT
     SPHERE <0.0 0.0 0.0> 15.0 END_SPHERE
     TEXTURE
        0.05
        COLOUR RED 0.0 GREEN 0.6 BLUE 0.3 
        AMBIENT 0.1
        DIFFUSE 0.5
        REFLECTION 0.5
        BRILLIANCE 3.0
        SPECULAR 0.1
     END_TEXTURE
  END_OBJECT

  OBJECT
     INTERSECTION
        QUADRIC Cylinder_Y SCALE <3.0 1.0 3.0> END_QUADRIC
        PLANE <0.0 1.0 0.0> 0.0 END_PLANE
     END_INTERSECTION
     TEXTURE
        0.05
        Pine_Wood
        SCALE <10.0 100.0 10.0> 
        AMBIENT 0.3
        DIFFUSE 0.7
        REFLECTION 0.5
        SPECULAR 0.5
        END_TEXTURE
  END_OBJECT
  TRANSLATE <50.0 10.0 -30>
END_COMPOSITE

OBJECT
    SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
    TRANSLATE <-100.0 100.0 -200.0>
    TEXTURE
      COLOUR White
      AMBIENT 1.0
      DIFFUSE 0.0
    END_TEXTURE
    LIGHT_SOURCE
    COLOUR White
END_OBJECT
                
</textarea>

<!-- Sample file : lpops2.dat -->

<textarea id="lpops2.dat" name="lpops2.dat" style="display:none;">
{LPOPS2.DAT - Original Data File By Tom Price }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
        LOCATION <0.0 35.0 -150.0>
        UP <0.0 1.0 0.0>
        RIGHT <1.3333 0.0 0.0>
        LOOK_AT <0.0 0.0 0.0>
END_VIEW_POINT

FOG
        COLOUR RED 0.5 GREEN 0.5 BLUE 0.5
        1000.0
END_FOG

{The floor}
OBJECT
    PLANE <0.0 1.0 0.0> -60.0 END_PLANE
    TEXTURE 
        0.05 
        CHECKER COLOUR Brown COLOUR LightGray
        SCALE <40.0 40.0 40.0>
        TRANSLATE <-5.0 0.0 0.0>
        AMBIENT 0.2
        DIFFUSE 0.7
        REFLECTION 0.3
        PHONG 1.0
        PHONGSIZE 20.0
    END_TEXTURE
    COLOUR RED 0.4 BLUE 0.4 GREEN 0.4
END_OBJECT

{The Sky}
OBJECT
    SPHERE <0.0 -40000.0 0.0> 50000.0 END_SPHERE
    TEXTURE 
        0.05 
        Cloud_Sky
        SCALE <6000.0 3000.0 3000.0>
        ROTATE <0.0 -30.0 0.0>
        AMBIENT 0.7
        DIFFUSE 0.0
    END_TEXTURE
    COLOUR Blue
END_OBJECT

COMPOSITE
  OBJECT
    INTERSECTION
        SPHERE <0.0 0.0 0.0> 40.0 END_SPHERE
        QUADRIC Cylinder_Z SCALE <20.0 20.0 1.0> INVERSE END_QUADRIC
    END_INTERSECTION
    TEXTURE
        0.05
        AMBIENT 0.3
        DIFFUSE 0.7
        COLOUR RED 0.6 GREEN 0.6 BLUE 0.0 
        REFLECTION 0.7
        BRILLIANCE 6.0
        SPECULAR 0.5
    END_TEXTURE
  END_OBJECT

  COMPOSITE
    OBJECT
        TRIANGLE
           <-1.0 0.0 -0.5773502>
           < 1.0 0.0 -0.5773502>
           < 0.0 0.0  1.1547005>
        END_TRIANGLE
        TEXTURE
           0.05
           COLOUR Gold
           AMBIENT 0.3
           DIFFUSE 0.7
           REFLECTION 0.4
           BRILLIANCE 6.0
           SPECULAR 0.5
        END_TEXTURE
    END_OBJECT

    OBJECT
        TRIANGLE
           <-1.0 0.0 -0.5773502>
           < 0.0 0.0  1.1547005>
           < 0.0 1.6329931  0.0>
        END_TRIANGLE
        TEXTURE
           0.05
           COLOUR Gold
           AMBIENT 0.3
           DIFFUSE 0.7
           REFLECTION 0.4
           BRILLIANCE 6.0
           SPECULAR 0.5
        END_TEXTURE
    END_OBJECT
 
    OBJECT
        TRIANGLE
           < 1.0 0.0 -0.5773502>
           < 0.0 0.0  1.1547005>
           < 0.0 1.6329931  0.0>
        END_TRIANGLE
        TEXTURE
           0.05
           COLOUR Gold
           AMBIENT 0.3
           DIFFUSE 0.7
           REFLECTION 0.4
           BRILLIANCE 6.0
           SPECULAR 0.5
        END_TEXTURE
    END_OBJECT

    OBJECT
        TRIANGLE
           <-1.0 0.0 -0.5773502>
           < 1.0 0.0 -0.5773502>
           < 0.0 1.6329931  0.0>
        END_TRIANGLE
        TEXTURE
           0.05
           COLOUR RED 0.5 GREEN 0.4 BLUE 0.0
           AMBIENT 0.4
           DIFFUSE 0.6
           REFLECTION 0.2
           BRILLIANCE 6.0
        END_TEXTURE
    END_OBJECT

    TRANSLATE <0.0 -0.4082886 0.0>
    SCALE <15.0 15.0 15.0>
    ROTATE <-45.0 -50.0 10.0>
  END_COMPOSITE

  OBJECT
    INTERSECTION
        QUADRIC Cylinder_Y SCALE <7.0 1.0 7.0> END_QUADRIC
        PLANE <0.0 1.0 0.0> -20.0 END_PLANE
    END_INTERSECTION
    TEXTURE
        0.05
        Pine_Wood
        SCALE <10.0 100.0 10.0> 
        AMBIENT 0.3
        DIFFUSE 0.7
        REFLECTION 0.5
        SPECULAR 0.5
    END_TEXTURE
  END_OBJECT
  TRANSLATE <10.0 20.0 60.0>
END_COMPOSITE

COMPOSITE
  OBJECT
     SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
     TEXTURE
     	 Glass
         0.05
     END_TEXTURE
  END_OBJECT    

  OBJECT
     INTERSECTION
        QUADRIC Cylinder_Y SCALE <3.0 1.0 3.0> END_QUADRIC
        PLANE <0.0 1.0 0.0> 0.0 END_PLANE
     END_INTERSECTION
     TEXTURE
        0.05
        Pine_Wood
        SCALE <10.0 50.0 10.0>  
        AMBIENT 0.3
        DIFFUSE 0.7
        REFLECTION 0.5
        SPECULAR 0.5
        END_TEXTURE
  END_OBJECT
  TRANSLATE <-40.0 -5.0 -0.0>
END_COMPOSITE

COMPOSITE
  OBJECT
     SPHERE <0.0 0.0 0.0> 15.0 END_SPHERE
     TEXTURE
          0.05
          COLOUR RED 0.0 GREEN 0.6 BLUE 0.3 
          AMBIENT 0.1
          DIFFUSE 0.5
          REFLECTION 0.5
          BRILLIANCE 3.0
          SPECULAR 0.1
     END_TEXTURE
   END_OBJECT

   OBJECT
   INTERSECTION
        QUADRIC Cylinder_Y SCALE <3.0 1.0 3.0> END_QUADRIC
        PLANE <0.0 1.0 0.0> 0.0 END_PLANE
   END_INTERSECTION
   TEXTURE
        0.05
        Pine_Wood
        SCALE <10.0 100.0 10.0> 
        AMBIENT 0.3
        DIFFUSE 0.7
        REFLECTION 0.5
        SPECULAR 0.5
        END_TEXTURE
  END_OBJECT
  TRANSLATE <50.0 10.0 -30>
END_COMPOSITE

OBJECT
  SPHERE <250.0 25.0 350.0> 30.0 END_SPHERE
  TEXTURE
     Glass
     0.05
  END_TEXTURE
END_OBJECT      

COMPOSITE
  OBJECT
     SPHERE <0.0 0.0 0.0> 40.0 END_SPHERE
     TEXTURE 
{         IMAGEMAP <1.0 -1.0 0.0> GIF "city01.gif" ONCE }
          COLOR Blue
          SCALE <75.0 75.0 75.0>
          TRANSLATE <-127.5 -7.5 100.0> 
          AMBIENT 0.1
          DIFFUSE 0.5
          COLOUR RED 0.5 GREEN 0.5 BLUE 0.5
          REFLECTION 0.2
{         REFRACTION 0.4}
{         IOR 1.2       }
          PHONG 0.1
          PHONGSIZE 10
     END_TEXTURE
  END_OBJECT    

  OBJECT
     INTERSECTION
          QUADRIC Cylinder_Y SCALE <6.0 1.0 6.0> END_QUADRIC
          PLANE <0.0 1.0 0.0> -20.0 END_PLANE
     END_INTERSECTION
     TEXTURE
          0.05
          Pine_Wood
          SCALE <10.0 50.0 10.0>        
          AMBIENT 0.3
          DIFFUSE 0.7
          REFLECTION 0.5
          SPECULAR 0.5
     END_TEXTURE
  END_OBJECT
  TRANSLATE <-100.0 30.0 100.0>
END_COMPOSITE

OBJECT
    SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
    TRANSLATE <-100.0 100.0 -200.0>
    TEXTURE
        COLOUR White
        AMBIENT 1.0
        DIFFUSE 0.0
    END_TEXTURE
    LIGHT_SOURCE
    COLOUR White
END_OBJECT
                
</textarea>

<!-- Sample file : monkey.dat -->

<textarea id="monkey.dat" name="monkey.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

DECLARE Basic_Saddle =
   QUARTIC
   < 0.0   0.0   0.0   1.0  0.0   0.0   0.0   0.0   0.0  0.0
     0.0   0.0  -3.0   0.0  0.0   0.0   0.0   0.0   0.0  0.0
     0.0   0.0   0.0   0.0  0.0   0.0   0.0   0.0   0.0  0.0
     0.0   0.0   0.0  -1.0  0.0 >
   END_QUARTIC

DECLARE Unit_Cube =
   INTERSECTION
      PLANE < 1  0  0> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE <-1  0  0> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0  1  0> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0 -1  0> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0  0  1> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0  0 -1> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
   END_INTERSECTION

{ Monkey Saddle }
OBJECT
   INTERSECTION
     QUARTIC Basic_Saddle
       TEXTURE
         COLOR Red
	 SPECULAR 1.0
	 ROUGHNESS 0.05
	 AMBIENT 0.2
	 DIFFUSE 0.8
       END_TEXTURE
     END_QUARTIC
     INTERSECTION Unit_Cube SCALE <2 2 2> END_INTERSECTION
   END_INTERSECTION
   BOUNDED_BY
     INTERSECTION Unit_Cube SCALE <2.5 2.5 2.5> END_INTERSECTION
   END_BOUND
   ROTATE <0 20 0>
   ROTATE <-30 0 0>
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -10.0>
   RIGHT     <1.33 0.0   0.0>
   UP        <0.0  1.0   0.0>
   DIRECTION <0.0  0.0   1.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300> 
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : ntreal.dat -->

<textarea id="ntreal.dat" name="ntreal.dat" style="display:none;">
{Title-"Not A Trace of Reality"}

{ -+ Compuserve Hall Of Fame award winner +- }

{ This one is hard to describe and easy to look at. Have fun with it! }
{ - Drew Wells CIS 73767,1244 }
{ 11/29/90 }


{ This file is for use with DKBTrace by David Buck
  and is released into the public domain. }

{ Note - This one is a memory hog for pc's because of the twister }
{        If you can't run it, try editing out some of the twister's }
{        parts.  Requires include file twister.inc }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

DECLARE It = 
QUADRIC Sphere SCALE <4.0 0.3 0.3> END_QUADRIC

{ Camera/Viewer }
VIEW_POINT
   DIRECTION <0.0 0.0  1.5>
   UP  <0.0  1.0  0.0>
   RIGHT <-1.333 0.0 0.0>
   TRANSLATE < -15.0  5.0  120.0>
   LOOK_AT <10.0 12.0 55.0>
END_VIEW_POINT

DECLARE Purple_Clouds = TEXTURE
      0.05
       BOZO
       TURBULENCE 0.6
       COLOUR_MAP
          [0.0 0.5   COLOUR RED 0.9 GREEN 0.5  BLUE 0.6
                     COLOUR RED 0.4 GREEN 0.0  BLUE 0.4]  
          [0.5 0.6   COLOUR RED 1.0 GREEN 1.0  BLUE 1.0 ALPHA 1.0
                     COLOUR RED 1.0 GREEN 1.0  BLUE 1.0 ALPHA 1.0 ]
          [0.6 1.001 COLOUR RED 1.0 GREEN 1.0  BLUE 1.0 ALPHA 1.0
                     COLOUR RED 1.0 GREEN 1.0  BLUE 1.0 ALPHA 1.0]
       END_COLOUR_MAP
END_TEXTURE

DECLARE Sunset_Sky = TEXTURE
      0.05
       GRADIENT <0.0 1.0 0.0>
       
       COLOUR_MAP   
          [0.0 0.4   COLOUR RED 0.8 GREEN 0.0 BLUE 0.0
                     COLOUR RED 0.4 GREEN 0.0 BLUE 0.4]
          [0.4 0.6   COLOUR RED 0.4 GREEN 0.0 BLUE 0.4
                     COLOUR RED 0.0 GREEN 0.0 BLUE 0.2]
          [0.6 1.001 COLOUR RED 0.0 GREEN 0.0 BLUE 0.2
                     COLOUR RED 0.0 GREEN 0.0 BLUE 0.0]
       END_COLOUR_MAP
       SCALE <700.0 700.0 700.0>
END_TEXTURE

DECLARE Twister = OBJECT
  UNION
    INCLUDE "twister.inc"
  END_UNION
  BOUNDED_BY
    SPHERE <0.0 5.0 0.0> 6.0  END_SPHERE
  END_BOUND
  TEXTURE
    White_Wood
    0.05
    SCALE <3.0 3.0 3.0>
    AMBIENT 0.1
    DIFFUSE 0.99
  END_TEXTURE
  COLOR Blue
END_OBJECT

DECLARE Slice = QUADRIC
   Sphere
   TRANSLATE <0.0 0.0 3.0>
   SCALE <0.25 1.00 0.25>
END_QUADRIC

DECLARE Thing = OBJECT
  UNION
    QUADRIC Slice END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -20.0  0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -40.0  0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -60.0  0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -80.0  0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -100.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -120.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -140.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -160.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0  180.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -200.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -220.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -240.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -260.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -280.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -300.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -320.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -340.0 0.0> END_QUADRIC
  END_UNION
  BOUNDED_BY
      QUADRIC Sphere SCALE <6.7 6.7 6.7> END_QUADRIC
  END_BOUND      
  TEXTURE
    COLOR RED 0.8 GREEN 0.22 BLUE 0.1
    BUMPS 0.3
    SCALE < 0.1 0.1 0.1>
    AMBIENT 0.1
    DIFFUSE 0.9
    PHONG 0.75
    PHONGSIZE 30.0
  END_TEXTURE
  COLOR RED 0.8 GREEN 0.22 BLUE 0.1
END_OBJECT    

{
DECLARE Slice2 = SPHERE <0.0 0.0 5.0> 0.1 END_SPHERE

DECLARE Thing2 =
OBJECT
  UNION
    SPHERE Slice2 END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -20.0  0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -40.0  0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -60.0  0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -80.0  0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -100.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -120.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -140.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -160.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0  180.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -200.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -220.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -240.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -260.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -280.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -300.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -320.0 0.0> END_SPHERE
    SPHERE Slice2 ROTATE <0.0 -340.0 0.0> END_SPHERE
  END_UNION
  BOUNDED_BY
    SPHERE <0.0 0.0 0.0> 12 END_SPHERE
  END_BOUND
  TEXTURE
    COLOR RED 0.1 GREEN 0.22 BLUE 0.8
    AMBIENT 0.1
    DIFFUSE 0.9
    PHONG 0.75
    PHONGSIZE 30.0
  END_TEXTURE
  COLOR RED 0.1 GREEN 0.22 BLUE 0.8
END_OBJECT    
}

DECLARE Slice2 = QUADRIC
  Sphere
  TRANSLATE <0.0 0.0 5.0>
  SCALE <0.1 0.1 0.1>
END_QUADRIC

DECLARE Thing2 =
OBJECT
  UNION
    QUADRIC Slice2 END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -20.0  0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -40.0  0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -60.0  0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -80.0  0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -100.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -120.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -140.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -160.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0  180.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -200.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -220.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -240.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -260.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -280.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -300.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -320.0 0.0> END_QUADRIC
    QUADRIC Slice2 ROTATE <0.0 -340.0 0.0> END_QUADRIC
  END_UNION
  BOUNDED_BY
    QUADRIC Sphere SCALE <12.0 12.0 12.0> END_QUADRIC
  END_BOUND
  TEXTURE
    COLOR RED 0.1 GREEN 0.22 BLUE 0.8
    AMBIENT 0.1
    DIFFUSE 0.9
    PHONG 0.75
    PHONGSIZE 30.0
  END_TEXTURE
  COLOR RED 0.1 GREEN 0.22 BLUE 0.8
END_OBJECT    


{*****************************************}
{*****************************************}

OBJECT
   Twister
   { SCALE <4.7 8.0 4.0> }
   ROTATE <-15.0 30.0 0.0>
   TRANSLATE <-16.0 7.7 61.5>    
END_OBJECT    
OBJECT
   Twister
   {SCALE <1.0 2.0 1.0> }
   ROTATE <-15.0 0.0 -10.0>
   TRANSLATE <0.0 1.0 88.0>    
END_OBJECT    
OBJECT
   Twister
   {SCALE <4.5 8.0 4.0>}
   ROTATE <0.0 45.0 0.0>
   TRANSLATE <13.0 25.0 40.0>    
END_OBJECT    

OBJECT
   Twister
   {SCALE <4.5 8.0 4.0>}
   ROTATE <-15.0 0.0 -10.0>
   TRANSLATE <26.0 14.0 70.0>    
END_OBJECT    

{ Little Things }
OBJECT
   Thing 
   SCALE <1.5 3.0 1.5>
   TRANSLATE < -11.0 1.55 95.0> 
END_OBJECT    
OBJECT
   Thing2 
   SCALE <6.0 6.0 6.0>
   ROTATE <-10.0 30.0 0.0>
   TRANSLATE <-11.0 1.55 95.0> 
END_OBJECT    

OBJECT
   Thing 
   SCALE <1.5 3.5 1.5>
   TRANSLATE <-10.0 10.55 95.0> 
END_OBJECT    
OBJECT
   Thing2 
   SCALE <10.0 10.0 10.0>
   ROTATE <0.0 0.0 -35.0>
   TRANSLATE < -10.0 10.55 95.0>    
END_OBJECT    

OBJECT
   Thing 
   SCALE <1.5 3.5 1.5>
   TRANSLATE < -4.0 4.0 80.0>    
END_OBJECT    
OBJECT
   Thing2 
   SCALE <6.0 6.0 6.0>
   ROTATE <-30.0 0.0 20.0>
   TRANSLATE < -4.6 5.55 80.0> 
END_OBJECT    


OBJECT
   Thing 
   SCALE <1.5 3.5 1.5>
   TRANSLATE < 11.0 1.6 90.0>    
END_OBJECT
OBJECT
   Thing2    
   SCALE <8.0 8.0 8.0>
   ROTATE <0.0 45.0 20.0>
   TRANSLATE < 10.0 7.0 90.0>    
END_OBJECT    

{cloud hills}
OBJECT
    QUADRIC Paraboloid_Y 
            SCALE<40.0 10.0 77.0>
    END_QUADRIC 
    ROTATE <0.0 0.0 180.0>
    TRANSLATE <0.0 21.0 -28.0>
    TEXTURE
      Purple_Clouds
      SCALE < 5.0 5.0 5.0>
      AMBIENT 0.5
      DIFFUSE 0.9    
    END_TEXTURE
    COLOR RED 0.5 GREEN 0.6 BLUE 0.2
END_OBJECT

{cloud hill to right}
OBJECT
    QUADRIC Paraboloid_Y 
            SCALE<30.0 10.0 40.0>
    END_QUADRIC 
    ROTATE <0.0 0.0 180.0>
    TRANSLATE <40.0 14.0 50.0>
    TEXTURE
      Purple_Clouds
      SCALE < 7.0 5.0 5.0>
      AMBIENT 0.5
      DIFFUSE 0.9    
    END_TEXTURE
    COLOR RED 0.6 GREEN 0.6 BLUE 0.1
END_OBJECT

{The Sun}
OBJECT
  SPHERE <0.0 0.0 0.0> 150.0 END_SPHERE
  TRANSLATE <150.0 40.0 1200.0>  
  TEXTURE
    COLOUR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT

{sky}
OBJECT
   SPHERE <0.0 0.0 0.0> 2000.0 INVERSE END_SPHERE
   TEXTURE
     Sunset_Sky
     TRANSLATE <0.0 200.0 0.0>
     SCALE <1.2 1.2 1.2>
     AMBIENT 0.6
     DIFFUSE 0.0
   END_TEXTURE
   COLOR White
END_OBJECT    
</textarea>

<!-- Sample file : pacman.dat -->

<textarea id="pacman.dat" name="pacman.dat" style="display:none;">
{
* PACMAN.DATA
*
* Written by Ville Saari
* Copyright (c) 1991 Ferry Island Pixelboys
*
* DKBTrace scene description for 'Pac Man doing his favourite job'
* 
* Created: 03-Jan-91
* Updated: 05-Jan-91
*
* You will need maze.iff which is included in this package.
*
* If you do some nice modifications or additions to this file, please send 
* me a copy. My Internet address is:
*
*         vsaari@niksula.hut.fi
}

INCLUDE "shapes.dat"

VIEW_POINT
   LOCATION <-80.0 35.0 -140.0>

   DIRECTION <0.0 0.0 1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.244 0.0 0.0>

   SKY <0.0 1.0 0.0>
   LOOK_AT <40.0 10.0 0.0>
END_VIEW_POINT

OBJECT { The maze-textured ground }
   PLANE <0.0 1.0 0.0> 0.0 END_PLANE
   TEXTURE
      IMAGEMAP <1.0 0.0 -1.0> IFF "maze.iff"
      SCALE <1600.0 1600.0 1600.0>
      TRANSLATE <-196.0 0.0 160.0>
      AMBIENT 0.3
      DIFFUSE 0.7
      REFLECTION 0.5
   END_TEXTURE
END_OBJECT

COMPOSITE { And now the world famous... Ta Da! ... PAC MAN }

   OBJECT { Body }
      INTERSECTION
         SPHERE <0.0 0.0 0.0>  30.0 END_SPHERE
         SPHERE <0.0 0.0 0.0>  28.0 INVERSE END_SPHERE
         UNION
            PLANE <0.0 1.0 0.0> 0.0 ROTATE <-35.0 0.0 0.0> END_PLANE
            PLANE <0.0 -1.0 0.0> 0.0 ROTATE <10.0 0.0 0.0> END_PLANE
         END_UNION
         SPHERE <0.0 0.0 -29.0> 1.5
            INVERSE
            ROTATE <16.0 -4.0 0.0>
         END_SPHERE
         SPHERE <0.0 0.0 -29.0> 1.5
            INVERSE
            ROTATE <16.0 4.0 0.0>
         END_SPHERE
      END_INTERSECTION

      TEXTURE
         COLOUR RED 0.9 GREEN 0.8
         AMBIENT 0.3
         DIFFUSE 0.7
         SPECULAR 0.5
         ROUGHNESS 0.1
      END_TEXTURE
   END_OBJECT
   
   OBJECT { Mouth }
      INTERSECTION
         SPHERE <0.0  0.0  0.0>  28.0 END_SPHERE
         UNION
            PLANE <0.0 2.0 0.0> -2.0 ROTATE <-35.0 0.0 0.0> END_PLANE
            PLANE <0.0 -2.0 0.0> -2.0 ROTATE <10.0 0.0 0.0> END_PLANE
         END_UNION
      END_INTERSECTION
   
      TEXTURE
         AMBIENT 0.25
         DIFFUSE 0.75
         COLOUR RED 0.5
      END_TEXTURE
   END_OBJECT
   
   OBJECT { Tongue }
      UNION
         SPHERE <3.0 0.0 -15.0> 10.0 END_SPHERE
         SPHERE <-3.0 0.0 -15.0> 10.0 END_SPHERE
      END_UNION
      ROTATE <-45.0 0.0 0.0>

      TEXTURE
         COLOUR RED 1.0
         WRINKLES 0.5
         SCALE <0.5 0.5 0.5>
         AMBIENT 0.3
         DIFFUSE 0.7
         REFLECTION 0.5
      END_TEXTURE
   END_OBJECT

   COMPOSITE { Right eye }
      OBJECT
         SPHERE <0.0 0.0 0.0> 6.0 END_SPHERE
         TEXTURE
            COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
            AMBIENT 0.3
            DIFFUSE 0.7
            REFLECTION 0.5
         END_TEXTURE
      END_OBJECT
      OBJECT
         SPHERE <0.0 0.0 -2.3> 4.0 END_SPHERE
         TEXTURE
            COLOUR RED 0.3 GREEN 0.4 BLUE 0.8
            AMBIENT 0.3
            DIFFUSE 0.7
            REFLECTION 0.5
         END_TEXTURE
      END_OBJECT
      OBJECT
         SPHERE <0.0 0.0 -5.5> 1.0 END_SPHERE
         TEXTURE
            COLOUR RED 0.0 GREEN 0.0 BLUE 0.0 
            AMBIENT 0.3
            DIFFUSE 0.7
            REFLECTION 0.5
         END_TEXTURE
      END_OBJECT
      OBJECT
         QUADRIC Sphere END_QUADRIC
         SCALE <9.0 2.0 9.0>
         TRANSLATE <0.0 8.0 6.0>
         ROTATE <0.0 0.0 -10.0>
         TEXTURE
            COLOUR RED 0.0 GREEN 0.0 BLUE 0.0 
         END_TEXTURE
      END_OBJECT
   
      ROTATE <-25.0 -20.0 0.0>
      TRANSLATE <0.0 0.0 -26.0>
      ROTATE <25.0 20.0 0.0>
   END_COMPOSITE
   
   COMPOSITE { Left eye }
      OBJECT
         SPHERE <0.0 0.0 0.0> 6.0 END_SPHERE
         TEXTURE
            COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
            AMBIENT 0.3
            DIFFUSE 0.7
            REFLECTION 0.5
         END_TEXTURE
      END_OBJECT
      OBJECT
         SPHERE <0.0 0.0 -2.3> 4.0 END_SPHERE
         TEXTURE
            COLOUR RED 0.3 GREEN 0.4 BLUE 0.8
            AMBIENT 0.3
            DIFFUSE 0.7
            REFLECTION 0.5
         END_TEXTURE
      END_OBJECT
      OBJECT
         SPHERE <0.0 0.0 -5.5> 1.0 END_SPHERE
         TEXTURE
            COLOUR RED 0.0 GREEN 0.0 BLUE 0.0 
            AMBIENT 0.3
            DIFFUSE 0.7
            REFLECTION 0.5
         END_TEXTURE
      END_OBJECT
      OBJECT
         QUADRIC Sphere END_QUADRIC
         SCALE <9.0 2.0 9.0>
         TRANSLATE <-0.0 8.0 6.0>
         ROTATE <0.0 0.0 10.0>
         TEXTURE
            COLOUR RED 0.0 GREEN 0.0 BLUE 0.0 
         END_TEXTURE
      END_OBJECT

      ROTATE <-25.0 20.0 0.0>
      TRANSLATE <0.0 0.0 -26.0>
      ROTATE <25.0 -20.0 0.0>
   END_COMPOSITE

   BOUNDED_BY
      SPHERE <0.0 0.0 -2.0> 32.0 END_SPHERE
   END_BOUND

   TRANSLATE <0.0 32.0 0.0>

END_COMPOSITE

OBJECT { Food... }
   SPHERE <0.0 27.0 -25.0> 4.0 END_SPHERE

   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 0.3
      DIFFUSE 0.7
      SPECULAR 2.0
      ROUGHNESS 0.01
      REFLECTION 0.6
   END_TEXTURE
END_OBJECT

OBJECT { ... more food ... }
   SPHERE <0.0 27.0 -45.0> 4.0 END_SPHERE

   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 0.3
      DIFFUSE 0.7
      REFLECTION 0.5
   END_TEXTURE
END_OBJECT

OBJECT { ... and even more ... }
   SPHERE <0.0 27.0 -65.0> 4.0 END_SPHERE

   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 0.3
      DIFFUSE 0.7
      REFLECTION 0.5
   END_TEXTURE
END_OBJECT

OBJECT { ... uh ... yet more food ... }
   SPHERE <0.0 27.0 -85.0> 4.0 END_SPHERE

   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 0.3
      DIFFUSE 0.7
      REFLECTION 0.5
   END_TEXTURE
END_OBJECT

OBJECT { ... Yuck! ... no more please! }
   SPHERE <0.0 27.0 -105.0> 4.0 END_SPHERE

   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 0.3
      DIFFUSE 0.7
      REFLECTION 0.5
   END_TEXTURE
END_OBJECT

OBJECT { Click }
   SPHERE <0.0  0.0  0.0> 2.0 END_SPHERE
   TRANSLATE <60.0  120.0  -170.0>
   TEXTURE
      COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
   LIGHT_SOURCE
END_OBJECT
</textarea>

<!-- Sample file : partorus.dat -->

<textarea id="partorus.dat" name="partorus.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"

{ Parabolic Torus having major radius sqrt(40), minor radius sqrt(12) }
OBJECT
   QUARTIC
   < 1.0   0.0   0.0    0.0     2.0   0.0   0.0   0.0  -2.0 -104.0
     0.0   0.0   0.0    0.0     0.0   0.0   0.0   0.0   0.0    0.0
     1.0   0.0   0.0    0.0    -2.0  56.0   0.0   0.0   0.0    0.0
     0.0   0.0   1.0  104.0   784.0 >
   END_QUARTIC
   SCALE <0.7 0.7 0.4>
   BOUNDED_BY
     SPHERE <0 0 0> 40 END_SPHERE
   END_BOUND
   TEXTURE
      COLOR Red
      PHONG 1.0
      PHONGSIZE 20
   END_TEXTURE
   ROTATE <120 0 0>
   ROTATE <0 -30 0>
   TRANSLATE <0 0 40>
END_OBJECT

{ Put down a floor }
OBJECT
   PLANE <0.0  1.0  0.0> -20.0 END_PLANE
   TEXTURE
      Blue_Agate
      SCALE < 20.0 20.0 20.0 >
      AMBIENT 0.5
      DIFFUSE 0.5
   END_TEXTURE
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -20.0>
   DIRECTION <0.0  0.0   1.0>
   UP        <0.0  1.0   0.0>
   RIGHT     <1.33 0.0   0.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : pencil.dat -->

<textarea id="pencil.dat" name="pencil.dat" style="display:none;">
{
  This data file makes a pencil along Y axis with the label "DKBtrace 2.11"

  By:  Jorge Arreguin

  Translation to English and DKB version 2.10 by Aaron A. Collins with a bit
  of help from David on the imagemap registration.

  NOTE - unless this is rendered at a minimum of 640 x whatever, the DKB logo
         is quite unreadable.

  The Pencil - major export of Faber, Pennsylvania, due to the plentiful
  presence of pencilwood trees and eraser-root plants, and the nearby
  graphite mines.
                                                (John Landis - Animal House)
}

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

DECLARE PencilPaint =
TEXTURE
   COLOR RED 1.0 GREEN 0.6666 BLUE 0.33333
END_TEXTURE

VIEW_POINT
  LOCATION <0.0 -70.0 0.0>
  DIRECTION <0.0 2.5 0.0>
  UP <0.0 0.0 1.0>
  RIGHT <1.333333 0.0 0.0>
  ROTATE < -20.0 0.0 -140.0 >
  TRANSLATE < 0.0 0.0 2.0 >
END_VIEW_POINT

OBJECT
  SPHERE <0.0 0.0 0.0> 2.0 END_SPHERE
  TRANSLATE <30.0 30.0 55.0>
  TEXTURE
    COLOUR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT

OBJECT
  SPHERE <0.0 0.0 0.0> 3.0 END_SPHERE
  TRANSLATE <-40.0 -40.0 35.0>
  TEXTURE
    COLOUR Grey
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR Grey
END_OBJECT


COMPOSITE

{----------------------------- PARTE METALICA ----------------------}
{                             (that metal part)                     }
COMPOSITE
OBJECT
  UNION
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > TRANSLATE <0.0 0.0 2.0 > END_QUADRIC
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > TRANSLATE <0.0 0.0 1.0 > END_QUADRIC
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > END_QUADRIC
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > TRANSLATE <0.0 0.0 -1.0 > END_QUADRIC
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > TRANSLATE <0.0 0.0 -2.0 > END_QUADRIC
  END_UNION
  TRANSLATE < 0.0 0.0 38.5 >
  TEXTURE
    COLOR Gold
    REFLECTION 0.3
  END_TEXTURE
END_OBJECT

OBJECT
  UNION
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > TRANSLATE <0.0 0.0 2.0 > END_QUADRIC
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > TRANSLATE <0.0 0.0 1.0 > END_QUADRIC
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > END_QUADRIC
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > TRANSLATE <0.0 0.0 -1.0 > END_QUADRIC
    QUADRIC Sphere SCALE < 4.0 4.0 1.5 > TRANSLATE <0.0 0.0 -2.0 > END_QUADRIC
  END_UNION
  TRANSLATE < 0.0 0.0 30.5 >
  TEXTURE
    COLOR Gold
    REFLECTION 0.3
  END_TEXTURE
END_OBJECT

OBJECT
  INTERSECTION Z_Disk END_INTERSECTION
  SCALE < 3.5 3.5 3.0 >
  TRANSLATE < 0.0 0.0 34.0 >
  TEXTURE
    COLOR Brown
    REFLECTION 0.25
  END_TEXTURE
END_OBJECT

BOUNDED_BY
  SPHERE <0.0 0.0 34.0> 9.0 END_SPHERE
END_BOUND
END_COMPOSITE

{---------------------------------- BORRADOR ----------------------------}
{                (the rubber eraser, from eraser-root plants)            }

COMPOSITE
 OBJECT
   INTERSECTION Z_Disk END_INTERSECTION
   SCALE < 3.5 3.5 3.0 >
   TRANSLATE < 0.0 0.0 41.0 >
   TEXTURE
    COLOR Pink
   END_TEXTURE
 END_OBJECT
 OBJECT SPHERE < 0.0 0.0 44.0 > 3.5 END_SPHERE
   TEXTURE
    COLOR Pink
   END_TEXTURE
 END_OBJECT
END_COMPOSITE

{---------------------------------- CUERPO DE MADERA ---------------------}
{                                 (body of pencilwood)                    }

OBJECT
  DIFFERENCE
   INTERSECTION
    PLANE < 0.0 1.0 0.0 > 3.031
      TEXTURE PencilPaint END_TEXTURE
      TEXTURE
        IMAGEMAP < -1.0 0.0 1.0 > GIF "dkb211.gif"
    ALPHA 0 1.0      { colour 0 is the "key" or transparent colour }
    ONCE

{ Now for the complicated image mapping:
  Currently, the pencil is standing up in the Z axis:
                   Z

             eraser  ^ *VP
                     | |   
                     | |
                     | |----/ Y
                     |     /
                     |    /
                     |   /
                     |  /
                     | /
             point   |/
                     -------------->
                                   X

  We want the image to be mapped as follows (viewed from the +ve Y axis):

          Right
          ---- z=28.0
          |  |
          |..|
          |..|
          |..|
          |ee|
          |ce|
      Top |ar| Bottom
          |rf|
          |T |
          | s|
          |B'|
          |Kt|
          |DI|
          ---- z=12.7
          Left

          ^  ^
          |  |
    x=1.75   x=-1.75

 The image map above gives (viewed from the Y axis):

                   ^ Z
          1,1 Right|
             ------|
             |     |
             |     |
         Top |     |Bottom
             |     |
             |     |
         <----------
          X   Left     

  Which is at least in the right orientation.

  Now, we must scale the image so the letters are the right size. }

         SCALE <15 1 15>  { Never use 0 for any scale value }

{ Now, we align the top left of the picture to the proper point on the
  pencil.  This is a bit tricky because the top left of the picture is now
  at x=15 z=0.  We have to move it to about x=-12, z=12 because the letters
  don't start at the very top of the image. }

         TRANSLATE <-12.20 0 12>

{ As you may have guessed, this still took a lot of trial and error to get it
  right, but some analysis of the picture before hand saved a lot of time. }

      END_TEXTURE
    END_PLANE
    PLANE < 0.0 1.0 0.0 > 3.031
      ROTATE < 0.0 0.0 60.0 >
      TEXTURE PencilPaint END_TEXTURE
    END_PLANE
    PLANE < 0.0 1.0 0.0 > 3.031
      ROTATE < 0.0 0.0 120.0 >
      TEXTURE PencilPaint END_TEXTURE
    END_PLANE
    PLANE < 0.0 1.0 0.0 > 3.031
      ROTATE < 0.0 0.0 180.0 >
      TEXTURE PencilPaint END_TEXTURE
    END_PLANE
    PLANE < 0.0 1.0 0.0 > 3.031
      ROTATE < 0.0 0.0 240.0 >
      TEXTURE PencilPaint END_TEXTURE
    END_PLANE
    PLANE < 0.0 1.0 0.0 > 3.031
      ROTATE < 0.0 0.0 300.0 >
      TEXTURE PencilPaint END_TEXTURE
    END_PLANE
    PLANE < 0.0 0.0 1.0 > 28.0 END_PLANE
    PLANE < 0.0 0.0 1.0 > 3.629 INVERSE END_PLANE
   END_INTERSECTION
   QUADRIC Cone_Z INVERSE SCALE < 0.275558 0.275558 1.0 > END_QUADRIC
  END_DIFFERENCE
  TEXTURE
    Pine_Wood
    TURBULENCE 0.1
    SCALE <1.5 1.5 1.5>
    ROTATE <0.0 90.0 0.0>
    TRANSLATE <30.0 0.0 0.0>
  END_TEXTURE
END_OBJECT

{---------------------------- PUNTA DE GRAFITO ------------------------------}
{                            (point of graphite)                             }

OBJECT
  INTERSECTION
    QUADRIC Cone_Z SCALE < 0.275558 0.275558 1.0 > END_QUADRIC
    PLANE < 0.0 0.0 1.0 > 3.629 END_PLANE
    PLANE < 0.0 0.0 1.0 > 0.001 INVERSE END_PLANE
  END_INTERSECTION
  TEXTURE
    COLOR Black
    REFLECTION 0.25
    PHONG 1.0
    PHONGSIZE 20
  END_TEXTURE
END_OBJECT

ROTATE < 90.0 0.0 0.0 >
TRANSLATE < 0.0 22.0 3.5 >
END_COMPOSITE

{-------------------------- PLANO DE HORIZONTE --------------------------}
{                           (plane of horizon)                           }

OBJECT
  PLANE < 0.0 0.0 1.0 > 0.0 END_PLANE
  TEXTURE
    COLOR Grey
    REFLECTION 0.25
  END_TEXTURE
END_OBJECT
</textarea>

<!-- Sample file : piriform.dat -->

<textarea id="piriform.dat" name="piriform.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ Piriform - looks a bit like a Hershey's Kiss along the X axis...}
OBJECT
   QUARTIC
   < 4.0   0.0   0.0   -4.0  0.0   0.0   0.0   0.0   0.0  0.0
     0.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0  0.0
     0.0   0.0   0.0    0.0  0.0   1.0   0.0   0.0   0.0  0.0
     0.0   0.0   1.0    0.0  0.0 >
   END_QUARTIC
   BOUNDED_BY
   SPHERE <0 0 0> 2 END_SPHERE
   END_BOUND
   TEXTURE
     COLOR RED 0.7 GREEN 0.0 BLUE 0.0
     PHONG 1.0
     PHONGSIZE 20
     AMBIENT 0.2
     DIFFUSE 0.8
   END_TEXTURE
   TRANSLATE <0 0.5 2>
END_OBJECT

{ Put down checkered floor }
OBJECT
   PLANE <0.0 1.0 0.0> -10.0 END_PLANE
   TEXTURE
      CHECKER
	 COLOUR RED 0.137255 GREEN 0.137255 BLUE 0.556863
	 COLOUR RED 0.184314 GREEN 0.184314 BLUE 0.309804
      SCALE < 20.0 20.0 20.0 >
      AMBIENT 0.8
      DIFFUSE 0.2
   END_TEXTURE
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  2.0 -2.0>
   UP        <0.0  1.0  0.0>
   RIGHT     <1.33 0.0  0.0>
   LOOK_AT   <0.0  0.0  1.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : planet.dat -->

<textarea id="planet.dat" name="planet.dat" style="display:none;">
{
* PLANET.DATA
*
* Written by Ville Saari
* Copyright (c) 1990 Ferry Island Pixelboys
*
* DKBTrace scene description for Earth-like planet
*
* Created 29-Dec-90
*
* If you do some nice modifications or additions to this file, please send 
* me a copy. My Internet address is:
*
*         vsaari@niksula.hut.fi
*
* FRACTINT-generated starfield backdrop added and conversion to DKB 2.10
* by Aaron A. Collins
}

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"
	
VIEW_POINT
	LOCATION <0.0 0.0 -80.0>
	DIRECTION <0.0 0.0 1.0>
	UP <0.0 1.0 0.0>
	RIGHT <1.33 0.0 0.0>
END_VIEW_POINT

OBJECT
	SPHERE <0.0 0.0 0.0> 30.0 END_SPHERE
	TEXTURE
		0.08
		BOZO
		TURBULENCE 0.5
		COLOUR_MAP
			[0.0 0.7  COLOUR RED 0.0 GREEN 0.3 BLUE 0.8
			          COLOUR RED 0.0 GREEN 0.3 BLUE 0.8]
			[0.7 1.0  COLOUR RED 0.0 GREEN 0.7 BLUE 0.0
			          COLOUR RED 0.6 GREEN 0.7 BLUE 0.0]
			[1.0 1.01 COLOUR RED 0.6 GREEN 0.7 BLUE 0.0
			          COLOUR RED 0.7 GREEN 0.3 BLUE 0.3]
		END_COLOUR_MAP
		SCALE <10.0 10.0 10.0>
		TRANSLATE <100.0 0 0>
		AMBIENT 0.0
		DIFFUSE 1.0
	END_TEXTURE
END_OBJECT

OBJECT
	SPHERE <0.0 0.0 0.0> 30.2 END_SPHERE
	TEXTURE
		BOZO
		TURBULENCE 1.0
		COLOUR_MAP
			[0.0 0.4 COLOUR RED 1.0 GREEN 1.0 BLUE 1.0 ALPHA 1.0
			         COLOUR RED 1.0 GREEN 1.0 BLUE 1.0 ALPHA 1.0]
			[0.4 0.9 COLOUR RED 1.0 GREEN 1.0 BLUE 1.0 ALPHA 1.0
			         COLOUR RED 1.0 GREEN 1.0 BLUE 1.0]
			[0.9 1.0 COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
			         COLOUR RED 1.0 GREEN 1.0 BLUE 1.0]
		END_COLOUR_MAP
		SCALE <12.0 3.0 12.0>
		ROTATE <30.0 0.0 -45.0>
		AMBIENT 0.0
		DIFFUSE 1.0
	END_TEXTURE
END_OBJECT

OBJECT
	PLANE <0.0 0.0 1.0> 80.0 END_PLANE
	TEXTURE
		IMAGEMAP <1.0 -1.0 0.0> GIF "stars.gif" {640x350}
		SCALE <100.0 100.0 100.0>
		AMBIENT 1.0
		DIFFUSE 0.0
	END_TEXTURE
END_OBJECT

OBJECT
	SPHERE <0.0 0.0 0.0> 2.0 END_SPHERE
	TRANSLATE <-200.0  200.0  -200.0>
	TEXTURE
		COLOUR White
		AMBIENT 1.0
		DIFFUSE 0.0
	END_TEXTURE
	LIGHT_SOURCE
	COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : pool.dat -->

<textarea id="pool.dat" name="pool.dat" style="display:none;">
{ DKB Script for a lawn with a swimming pool.
  Written by Dan Farmer.  Takes quite a while to render because of
  the many textures and waveforms used.  An interesting variation of this
  theme would be to change the VIEW to look into the garden globe and see
  the rest of the scene as the reflection in the globe.

  As stated below, most of the garden globe structure was taken from the
  file "ROMAN.DAT" that was included with DKBDAT.
}

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"

DECLARE Cube = INTERSECTION  { this is a good one to add to basicsha.dat }
        PLANE <0.0 0.0 1.0> 1.0 END_PLANE
        PLANE <0.0 0.0 -1.0> 1.0 END_PLANE
        PLANE <0.0 1.0 0.0> 1.0 END_PLANE
        PLANE <0.0 -1.0 0.0> 1.0 END_PLANE
        PLANE <1.0 0.0 0.0> 1.0 END_PLANE
        PLANE <-1.0 0.0 0.0> 1.0 END_PLANE
        SCALE <1.0 1.0 1.0>
END_INTERSECTION

{ Most of the garden globe is borrowed from "ROMAN.DAT"}
{******************************************************}
    DECLARE Beam = QUADRIC Cylinder_Y
        SCALE <0.5 20.0 0.5>
        TRANSLATE <2.0 0.0 0.0>
    END_QUADRIC

    { create a sample column for the base of the structure }
    DECLARE BaseColumn = OBJECT
       INTERSECTION
          UNION
             QUADRIC Beam END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -25.7  0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -51.4  0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -77.1  0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -102.8 0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -128.5 0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -154.2 0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -179.9 0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -205.6 0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -231.3 0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -257.0 0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -282.7 0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -308.4 0.0> END_QUADRIC
             QUADRIC Beam ROTATE <0.0 -334.1 0.0> END_QUADRIC
         END_UNION
         PLANE <0.0 1.0 0.0> 20.0 END_PLANE
         PLANE <0.0 -1.0 0.0> 0.0 END_PLANE
       END_INTERSECTION
       BOUNDED_BY
         INTERSECTION
            PLANE <0.0 1.0 0.0> 20.0 END_PLANE
            PLANE <0.0 -1.0 0.0> 0.0 END_PLANE
             QUADRIC
                Cylinder_Y
                SCALE <2.51 1.0 2.51>
             END_QUADRIC
         END_INTERSECTION
       END_BOUND
       TEXTURE
         White_Marble
	 SCALE <10.0 10.0 10.0>
         AMBIENT 0.4
         DIFFUSE 0.9
         REFLECTION 0.1
       END_TEXTURE
       COLOUR RED 0.8 GREEN 0.0 BLUE 0.0
    END_OBJECT

    { and a rectangular pad to serve as a footing for the column }
    DECLARE BasePad = OBJECT
       INTERSECTION Cube
           SCALE <4.0 1.0 4.0>
       END_INTERSECTION
       BOUNDED_BY
          QUADRIC
             Sphere
             SCALE <10.0 3.0 10.0>
          END_QUADRIC
       END_BOUND
       TEXTURE
         White_Marble
	 SCALE <10.0 10.0 10.0>
         AMBIENT 0.4
         DIFFUSE 0.9
         REFLECTION 0.1
       END_TEXTURE
       COLOUR RED 0.6 GREEN 0.6 BLUE 0.4
    END_OBJECT

    DECLARE Globe = OBJECT
        SPHERE <0.0 0.0 0.0> 5.0 END_SPHERE
        TEXTURE
          Mirror
	  COLOR Blue
        END_TEXTURE
	COLOR Blue
    END_OBJECT

    DECLARE Garden_Globe = COMPOSITE
       OBJECT BaseColumn TRANSLATE <0.0 0.0 0.0>   END_OBJECT
       OBJECT BasePad    TRANSLATE <0.0 -1.0 0.0>  END_OBJECT
       OBJECT BasePad    TRANSLATE <0.0 21.0 0.0>  END_OBJECT
       OBJECT Globe      TRANSLATE<0.0 26.0 0.0> END_OBJECT
    END_COMPOSITE
{******************** End of Garden Globe Epic ******************************}

{ Everybody's gotta have a point of view. }
VIEW_POINT
   LOCATION <0.0  30.0  -120.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
   LOOK_AT <0.0 0.0 0.0>
END_VIEW_POINT

{ No, fool... I said _BUD_ light! }
OBJECT  
   SPHERE <0.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <100.0  200.0  -200.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

{ "The sky was the color of her eyes" }
{             ... and just as cloudy! }
OBJECT
  SPHERE <0.0 -10000.0 -200.0> 15000.0 END_SPHERE
  TEXTURE
      0.05
      Cloud_Sky
      SCALE <7500.0 1000.0 5000.0>
      AMBIENT 0.7
      DIFFUSE 0.0
  END_TEXTURE
  COLOUR RED 0.5 GREEN 0.5 BLUE 1.0
END_OBJECT

{ Plant a little grass, well mowed. }
OBJECT
    PLANE <0.0 1.0 0.0> 0.0 END_PLANE
    TEXTURE
        0.05  { This value dithers the colours }
	COLOR Green
        RIPPLES 0.5
        FREQUENCY 2000.0
        SCALE <50000.0 50000.0 50000.0>
    END_TEXTURE
    COLOR Green
END_OBJECT

{ Now, we pour the concrete and set the tiles...}
OBJECT
    DIFFERENCE
        INTERSECTION Cube
            SCALE <45.0 10.0 60.0>
        END_INTERSECTION
        INTERSECTION Cube { Inside box }
            SCALE <35.0 11.0 50.0>
        END_INTERSECTION
    END_DIFFERENCE
    TRANSLATE <0.0 -8.0 0.0 >
    TEXTURE
        CHECKER COLOUR DarkTurquoise COLOUR White
        SCALE <2.0 2.0 2.0>
    END_TEXTURE
    COLOR DarkTurquoise
END_OBJECT

 { Better put some water in the pool! }
OBJECT
    INTERSECTION Cube
        SCALE <35.0 10.0 50.0>
        TRANSLATE<0.0 -9.0 0.0>
    END_INTERSECTION
    TEXTURE
        0.05
	COLOR LightBlue               {ALPHA 0.5 ?}
        RIPPLES 0.5
        FREQUENCY 100.0
        SCALE <5.0 5.0 10.0>
        TRANSLATE <20.0 4.0 -15.0>    { Where the ball floats?? }
	REFLECTION 0.5
	BRILLIANCE 3.0
{??     REFRACTION 1.0		{ Doesn't really help the scene any... }
        IOR 1.2 ?? }
    END_TEXTURE
    COLOR LightBlue
END_OBJECT

{ Let's add a diving board }
OBJECT
    UNION
        INTERSECTION Cube                        { The board itself }
            SCALE <6.0 1.0 30.0 >
            TRANSLATE <0.0 2.0 -30.0>
        END_INTERSECTION
        INTERSECTION Cube                        { A block under the board }
            SCALE <6.0 2.0 2.0 >
            TRANSLATE <0.0 1.0 -30.0>
        END_INTERSECTION
    END_UNION
    TEXTURE
        Cherry_Wood
	0.05
	SCALE <0.02 0.02 0.02>
    END_TEXTURE
    COLOR Brown
END_OBJECT

{ Float a red and white striped ball in the pool }
OBJECT
    SPHERE <0.0 0.0 0.0> 5.0 END_SPHERE
    TRANSLATE <20.0 4.0 -15.0>    { Sorta right front center of pool }
    TEXTURE
       GRADIENT < 1.0 1.0 0.0 >
       COLOUR_MAP
            [0.00 0.25  COLOUR White COLOUR White ]
            [0.25 0.75  COLOUR RED 1.0  COLOUR RED 1.0]
            [0.75 1.001 COLOUR White COLOUR White ]
       END_COLOUR_MAP
       SCALE <7.0 7.0 7.0>
       ROTATE <-30.0 30.0 0.0>
       AMBIENT 0.3
       DIFFUSE 0.7
       PHONG 0.5
       PHONGSIZE 10.0
    END_TEXTURE
    COLOR Red
END_OBJECT

{ Place the garden globe on left side of pool }
COMPOSITE Garden_Globe TRANSLATE <-60.0 0.0 0.0> END_COMPOSITE

{ The hedge behind the pool }
OBJECT
INTERSECTION Cube END_INTERSECTION
    SCALE <200.0 30.0 30.0>
    TRANSLATE <-100.0 0.0 180.0>
    TEXTURE
        0.05  { This value dithers the colours }
	COLOR YellowGreen
        TURBULENCE 0.5
        SPOTTED 0.5
        COLOUR_MAP
             [0.00 0.25  COLOUR YellowGreen COLOUR Green ]
             [0.25 0.75  COLOUR Green COLOUR DarkGreen]
             [0.75 1.001 COLOUR DarkGreen COLOUR YellowGreen ]
        END_COLOUR_MAP
        WRINKLES 1.0
        FREQUENCY 2000.0
        SCALE <10.0 10.0 20.0>
    END_TEXTURE
    COLOR YellowGreen
END_OBJECT

{ The hedge on the right side of pool }
OBJECT
INTERSECTION Cube END_INTERSECTION
    SCALE <30.0 30.0 100.0>
    TRANSLATE <100.0 0.0 -85.0>
    TEXTURE
        0.05  { This value dithers the colours }
	COLOR YellowGreen
        TURBULENCE 0.5
        SPOTTED 0.5
        COLOUR_MAP
             [0.00 0.25  COLOUR YellowGreen COLOUR Green ]
             [0.25 0.75  COLOUR Green COLOUR DarkGreen]
             [0.75 1.001 COLOUR DarkGreen COLOUR YellowGreen ]
	END_COLOUR_MAP
        WRINKLES 1.0
        FREQUENCY 2000.0
        SCALE <10.0 10.0 20.0>
    END_TEXTURE
    COLOR YellowGreen
END_OBJECT

{ A low, squat shrub of some generic species }
OBJECT
QUADRIC Sphere END_QUADRIC
    SCALE <30.0 20.0 25.0>
    TRANSLATE <-70.0 0.0 110.0>
    TEXTURE
        0.05  { This value dithers the colours }
	COLOR YellowGreen
        TURBULENCE 0.5
        SPOTTED 1.0
        COLOUR_MAP
             [0.00 0.25  COLOUR Khaki COLOUR Green ]
             [0.25 0.50  COLOUR Green COLOUR DarkGreen]
             [0.50 0.75  COLOUR DarkGreen COLOUR MediumForestGreen]
             [0.75 1.001 COLOUR MediumForestGreen COLOUR YellowGreen ]
        END_COLOUR_MAP
        WRINKLES 1.0
        FREQUENCY 2000.0
        SCALE <5.0 5.0 5.0>
    END_TEXTURE
    COLOR YellowGreen
END_OBJECT

</textarea>

<!-- Sample file : poolball.dat -->

<textarea id="poolball.dat" name="poolball.dat" style="display:none;">
   {  Author name : Dan Farmer
                    Minneapolis, MN
   ( with much help from Aaron Collins.)

      Pool balls. Illustrates use of intersections.
      Note: Gradients could also be used for the stripes.  The pool table
      needs a rail, and perhaps, pockets.  Maybe a picture of a nude hanging
      on the back wall and a cube of blue chalk sitting on the rail.
      Go for it!!
 
      This data file is for use with DKBTrace by David Buck.  This file
      is released to the public domain and may be used or altered by
      anyone as desired.
   }


INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ ***************** SET UP A BUNCH OF DECLARATIONS **************************}

DECLARE Ball = SPHERE < 0.0 0.0 0.0 > 1.0 END_SPHERE

DECLARE RightSide = OBJECT
    INTERSECTION
        SPHERE Ball END_SPHERE
        PLANE  <-1.0  0.0  0.0 > -0.5 END_PLANE  { Cut by Plane Facing Left }
    END_INTERSECTION
    TEXTURE
      Shiny
      COLOR White
    END_TEXTURE
    COLOR White
END_OBJECT


DECLARE Stripe = INTERSECTION	{ Note: we don't know the OBJECT color yet! }
    SPHERE Ball END_SPHERE
    PLANE  <-1.0  0.0  0.0 > 0.5 END_PLANE  { Cut by Plane Facing Left }
    PLANE  <1.0  0.0  0.0 >  0.5 END_PLANE  { And by Plane Facing Right }
END_INTERSECTION


DECLARE LeftSide = OBJECT
    INTERSECTION
        SPHERE Ball END_SPHERE
        PLANE  <1.0  0.0  0.0 > -0.5 END_PLANE  { Cut by Plane Facing Right }
    END_INTERSECTION
    TEXTURE
      Shiny
      COLOR White
    END_TEXTURE
    COLOR White
END_OBJECT



DECLARE _1_Ball = OBJECT
    SPHERE  Ball  END_SPHERE
    TEXTURE Shiny COLOR Yellow END_TEXTURE
    COLOR   Yellow
END_OBJECT

DECLARE _2_Ball = OBJECT
    SPHERE  Ball  END_SPHERE
    TEXTURE Shiny COLOR Blue END_TEXTURE
    COLOR   Blue
END_OBJECT

DECLARE _3_Ball = OBJECT
    SPHERE  Ball  END_SPHERE
    TEXTURE Shiny COLOR Red END_TEXTURE
    COLOR   Red
END_OBJECT

DECLARE _4_Ball = OBJECT
    SPHERE  Ball  END_SPHERE
    TEXTURE Shiny COLOR Violet END_TEXTURE
    COLOR   Violet
END_OBJECT

DECLARE _5_Ball = OBJECT
    SPHERE  Ball  END_SPHERE
    TEXTURE Shiny COLOR Orange END_TEXTURE
    COLOR   Orange
END_OBJECT

DECLARE _6_Ball = OBJECT
    SPHERE  Ball  END_SPHERE
    TEXTURE Shiny COLOR ForestGreen END_TEXTURE
    COLOR   ForestGreen
END_OBJECT

DECLARE _7_Ball = OBJECT
    SPHERE  Ball  END_SPHERE
    TEXTURE Shiny COLOR Maroon END_TEXTURE
    COLOR   Maroon
END_OBJECT

DECLARE _8_Ball = OBJECT
    SPHERE  Ball  END_SPHERE
    TEXTURE Shiny COLOR Black END_TEXTURE
    COLOR   Black
END_OBJECT



DECLARE _9_Ball = COMPOSITE	{ Yellow Stripe }
    OBJECT
      INTERSECTION Stripe END_INTERSECTION
      TEXTURE Shiny COLOR Yellow END_TEXTURE
      COLOR Yellow
    END_OBJECT
    OBJECT LeftSide  END_OBJECT
    OBJECT RightSide END_OBJECT
END_COMPOSITE

DECLARE _10_Ball = COMPOSITE	{ Blue Stripe }
    OBJECT
      INTERSECTION Stripe END_INTERSECTION
      TEXTURE Shiny COLOR Blue END_TEXTURE
      COLOR Blue
    END_OBJECT
    OBJECT LeftSide  END_OBJECT
    OBJECT RightSide END_OBJECT
END_COMPOSITE

DECLARE _11_Ball = COMPOSITE	{ Red Stripe }
    OBJECT
      INTERSECTION Stripe END_INTERSECTION
      TEXTURE Shiny COLOR Red END_TEXTURE
      COLOR Red  
    END_OBJECT
    OBJECT LeftSide  END_OBJECT
    OBJECT RightSide END_OBJECT
END_COMPOSITE


DECLARE _12_Ball = COMPOSITE	{ Violet Stripe }
    OBJECT
      INTERSECTION Stripe END_INTERSECTION
      TEXTURE Shiny COLOR Violet END_TEXTURE
      COLOR Violet
    END_OBJECT
    OBJECT LeftSide  END_OBJECT
    OBJECT RightSide END_OBJECT
END_COMPOSITE

DECLARE _13_Ball = COMPOSITE	{ Orange Stripe }
    OBJECT
      INTERSECTION Stripe END_INTERSECTION
      TEXTURE Shiny COLOR Orange END_TEXTURE
      COLOR Orange
    END_OBJECT
    OBJECT LeftSide  END_OBJECT
    OBJECT RightSide END_OBJECT
END_COMPOSITE

DECLARE _14_Ball = COMPOSITE	{ Green Stripe }
    OBJECT
      INTERSECTION Stripe END_INTERSECTION
      TEXTURE Shiny COLOR ForestGreen END_TEXTURE
      COLOR ForestGreen
    END_OBJECT
    OBJECT LeftSide  END_OBJECT
    OBJECT RightSide END_OBJECT
END_COMPOSITE

DECLARE _15_Ball = COMPOSITE	{ Maroon Stripe }
    OBJECT
      INTERSECTION Stripe END_INTERSECTION
      TEXTURE Shiny COLOR Maroon END_TEXTURE
      COLOR Maroon
    END_OBJECT
    OBJECT LeftSide  END_OBJECT
    OBJECT RightSide END_OBJECT
END_COMPOSITE

DECLARE CueStick = OBJECT
    INTERSECTION
      QUADRIC Cylinder_Y END_QUADRIC
      PLANE <0.0  1.0  0.0>  1.0 END_PLANE     { Cut by Plane Facing Up }
    END_INTERSECTION
    TEXTURE
      Dark_Wood
      SCALE <0.01  0.01  0.01>
      AMBIENT 0.3
      DIFFUSE 0.7
      PHONG 1.0
      PHONGSIZE 20
      REFLECTION 0.3
    END_TEXTURE
END_OBJECT        

{ ***************** SET UP THE VIEW & LIGHT SOURCES *************************}

VIEW_POINT
   LOCATION <0.0  0.0  -15.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
END_VIEW_POINT

{ Light }
OBJECT
   SPHERE <0.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <2.0  2.0  -250.0>
   ROTATE < 70.0 0.0 0.0 >
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOR White
END_OBJECT

{ ************************** SET UP THE TABLE *******************************}
{ 
    NOTE : The pooltable is set up as a composite in the X-Y Plane and then 
           the whole thing is thing is tilted "flat". 
           I personally find this easier to visualize.
}         
COMPOSITE
    OBJECT     { Felt table top }
        PLANE <0.0 0.0 1.0 > 1.0 END_PLANE
        TEXTURE Dull COLOR MediumForestGreen END_TEXTURE
	COLOR MediumForestGreen
    END_OBJECT

    { Cue stick }
    OBJECT CueStick
        SCALE     <  0.15  1.0  0.15  >         { Skinny and long }
        TRANSLATE <  0.0  -7.5    0.0  > 
    END_OBJECT

    { Cue Ball }
    OBJECT
        SPHERE Ball END_SPHERE
        TRANSLATE < 0.0  -6.0  0.0 >
        TEXTURE Shiny COLOR White END_TEXTURE
        COLOR White
    END_OBJECT

{ **************************** SET UP THE BALLS *******************************}
    { Row #1 }
    OBJECT _1_Ball
    END_OBJECT

    { Row #2 }
    OBJECT _3_Ball
        TRANSLATE < 1.0  1.732  0.0 >
    END_OBJECT
    COMPOSITE _10_Ball
        ROTATE < 0.0  0.0  -80.0 >
        TRANSLATE < -1.0  1.732  0.0 >
    END_COMPOSITE

    { Row #3 }
    COMPOSITE _11_Ball
        ROTATE < 0.0  -15.0  -2.0 >
        TRANSLATE < 2.0  3.464  0.0 >
    END_COMPOSITE
    OBJECT _8_Ball
        TRANSLATE < 0.0  3.464  0.0 >
    END_OBJECT
    OBJECT _5_Ball
        TRANSLATE <-2.0  3.464  0.0 >
    END_OBJECT

    { Row #4 }
    OBJECT _2_Ball
        TRANSLATE <-3.0  5.196  0.0 >
    END_OBJECT
    OBJECT _7_Ball
        TRANSLATE <-1.0  5.196  0.0 >
    END_OBJECT
    OBJECT _4_Ball
        TRANSLATE < 1.0  5.196  0.0 >
    END_OBJECT
    COMPOSITE _14_Ball
        ROTATE < 0.0  -15.0  -2.0 >
        TRANSLATE < 3.0  5.196  0.0 >
    END_COMPOSITE

    { Row #5 }
    COMPOSITE _15_Ball
        TRANSLATE <-4.0  6.928  0.0 >
    END_COMPOSITE
    COMPOSITE _13_Ball
        ROTATE < -5.0  11.0  -1.0 >
        TRANSLATE <-2.0  6.928  0.0 >
    END_COMPOSITE
    COMPOSITE _9_Ball
        ROTATE < -80.0  -13.0  29.0 >
        TRANSLATE < 0.0  6.928  0.0 >
    END_COMPOSITE
    COMPOSITE _12_Ball
        ROTATE < 15.0  15.0  -2.0 >
        TRANSLATE < 2.0  6.928  0.0 >
    END_COMPOSITE
    OBJECT _6_Ball
        TRANSLATE < 4.0  6.928  0.0 >
    END_OBJECT

    ROTATE < 70.0  0.0  0.0 >     
END_COMPOSITE


</textarea>

<!-- Sample file : quarcyl.dat -->

<textarea id="quarcyl.dat" name="quarcyl.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"

{ Quartic Cylinder - A Space Needle? }
OBJECT
   QUARTIC
   < 0.0   0.0   0.0   0.0   1.0   0.0   0.0   0.0   0.0   0.01
     0.0   0.0   0.0   0.0   0.0   0.0   0.0   0.0   0.0   0.0
     0.0   0.0   0.0   1.0   0.0   0.0   0.0   0.0   0.0   0.0
     0.0   0.0   0.01  0.0  -0.01 >
   END_QUARTIC
   BOUNDED_BY
     SPHERE <0 0 0> 2 END_SPHERE
   END_BOUND
   TEXTURE
      COLOR Red
      PHONG 1.0
      PHONGSIZE 10
      AMBIENT 0.2
      DIFFUSE 0.8
   END_TEXTURE
   ROTATE <-30 20 0>
   TRANSLATE <0 0 3>
END_OBJECT

{ Put down checkered floor }
OBJECT
   QUADRIC
      Plane_XZ
      TRANSLATE <0.0  -20.0  0.0>
   END_QUADRIC
   TEXTURE
      CHECKER COLOUR NavyBlue COLOUR MidnightBlue
      SCALE < 20.0 20.0 20.0 >
      AMBIENT 0.8
      DIFFUSE 0.2
   END_TEXTURE
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -3.0>
   DIRECTION <0.0  0.0  1.0>
   UP        <0.0  1.0  0.0>
   RIGHT     <1.33 0.0  0.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
      COLOR White
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
      COLOR White
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : quarpara.dat -->

<textarea id="quarpara.dat" name="quarpara.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"

DECLARE Rectangle =
   INTERSECTION
      PLANE < 1  0  0> 3 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE <-1  0  0> 3 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0  1  0> 3 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0 -1  0> 3 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0  0  1> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0  0 -1> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
   END_INTERSECTION

{ Quartic parabola of sorts }
OBJECT
   INTERSECTION
     QUARTIC
     < 0.1   0.0   0.0  0.0   0.0   0.0   0.0   0.0   0.0  -1.0
       0.0   0.0   0.0  0.0   0.0   0.0   0.0   0.0   0.0   0.0
       0.0   0.0   0.0  0.0   0.0   0.0   0.0   0.0   0.0  -1.0
       0.0   0.0  -1.0  0.0   0.9 >
       TEXTURE
         COLOR Red
	 PHONG 1.0
	 PHONGSIZE 20
	 AMBIENT 0.2
	 DIFFUSE 0.8
       END_TEXTURE
     END_QUARTIC
     INTERSECTION Rectangle END_INTERSECTION
   END_INTERSECTION
   BOUNDED_BY
      INTERSECTION Rectangle END_INTERSECTION
   END_BOUND
   { TRANSLATE <0 0 3> }
   ROTATE <-30 0 0>
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -10.0>
   DIRECTION <0.0  0.0   1.0>
   UP        <0.0  1.0   0.0>
   RIGHT     <1.33 0.0   0.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : roman.dat -->

<textarea id="roman.dat" name="roman.dat" style="display:none;">
{ First stage of the Tower of Pisa }
{ Later stages to follow           }
{ WARNING:  This picture can take a very long time to ray trace
   due to the large number of objects.  You have been warned :->  }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <0.0 25.0 -150.0>
   DIRECTION <0.0 0.1 1.0>
   UP <0.0 1.0 0.0>
   RIGHT <1.3333 0.0 0.0>
END_VIEW_POINT

DECLARE Beam = QUADRIC Cylinder_Y
    SCALE <0.5 20.0 0.5>
    TRANSLATE <2.0 0.0 0.0>
END_QUADRIC

{ create a sample column for the base of the structure }

DECLARE BaseColumn = OBJECT
   INTERSECTION
      UNION
         QUADRIC Beam END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -25.7  0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -51.4  0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -77.1  0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -102.8 0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -128.5 0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -154.2 0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -179.9 0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -205.6 0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -231.3 0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -257.0 0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -282.7 0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -308.4 0.0> END_QUADRIC
         QUADRIC Beam ROTATE <0.0 -334.1 0.0> END_QUADRIC
     END_UNION

     PLANE <0.0 1.0 0.0> 40.0 END_PLANE
     PLANE <0.0 -1.0 0.0> 0.0 END_PLANE
   END_INTERSECTION

   BOUNDED_BY
     INTERSECTION
        PLANE <0.0 1.0 0.0> 40.0 END_PLANE
        PLANE <0.0 -1.0 0.0> 0.0 END_PLANE
         QUADRIC
            Cylinder_Y
            SCALE <2.51 1.0 2.51>
         END_QUADRIC
     END_INTERSECTION
   END_BOUND

   TEXTURE
     Red_Marble
     SCALE <10.0 10.0 10.0>
     AMBIENT 0.4
     DIFFUSE 0.9
     REFLECTION 0.1
   END_TEXTURE

   COLOUR RED 0.8 GREEN 0.0 BLUE 0.0

END_OBJECT

{ and a rectangular pad to serve as a footing for the column }

DECLARE BasePad = OBJECT
   INTERSECTION
      PLANE <0.0 1.0 0.0> 1.0 END_PLANE
      PLANE <0.0 -1.0 0.0> 1.0 END_PLANE
      PLANE <0.0 0.0 1.0> 4.0 END_PLANE
      PLANE <0.0 0.0 -1.0> 4.0 END_PLANE
      PLANE <1.0 0.0 0.0> 4.0 END_PLANE
      PLANE <-1.0 0.0 0.0> 4.0 END_PLANE
   END_INTERSECTION

   BOUNDED_BY
      QUADRIC
         Sphere
         SCALE <10.0 3.0 10.0>
      END_QUADRIC
   END_BOUND

   TEXTURE
     Red_Marble
     SCALE <10.0 10.0 10.0>
     AMBIENT 0.4
     DIFFUSE 0.9
     REFLECTION 0.1
   END_TEXTURE

   COLOUR RED 0.6 GREEN 0.6 BLUE 0.4

END_OBJECT

{ and define a basic arch to span the columns }

DECLARE BaseArch = OBJECT
   INTERSECTION
      QUADRIC Cylinder_X SCALE <1.0 12.5 12.5> END_QUADRIC
      QUADRIC Cylinder_X SCALE <1.0 8.5 8.5> INVERSE END_QUADRIC
      PLANE <1.0 0.0 0.0> 2.0 END_PLANE
      PLANE <-1.0 0.0 0.0> 2.0 END_PLANE
      PLANE <0.0 -1.0 0.0> 0.0 END_PLANE
   END_INTERSECTION

   BOUNDED_BY
      QUADRIC
         Sphere
         SCALE <5.0 13.0 13.0>
      END_QUADRIC
   END_BOUND

   TEXTURE
     Red_Marble
     SCALE <10.0 10.0 10.0>
     AMBIENT 0.4
     DIFFUSE 0.9
     REFLECTION 0.1
   END_TEXTURE

   COLOUR RED 0.8 GREEN 0.8 BLUE 0.8

END_OBJECT

{ and finally define the first floor floor }

DECLARE BaseFloor = OBJECT
   INTERSECTION
      QUADRIC Cylinder_Y SCALE <50.0 50.0 50.0> END_QUADRIC
      QUADRIC Cylinder_Y SCALE <40.0 40.0 40.0> INVERSE END_QUADRIC
      PLANE <0.0 1.0 0.0> 2.0 END_PLANE
      PLANE <0.0 -1.0 0.0> 2.0 END_PLANE
   END_INTERSECTION

   TEXTURE
     Red_Marble
     SCALE <10.0 10.0 10.0>
     AMBIENT 0.4
     DIFFUSE 0.9
     REFLECTION 0.1
   END_TEXTURE

   COLOUR RED 0.8 GREEN 0.8 BLUE 0.6

END_OBJECT

{ place a ring of 14 columns with footings around the base }

DECLARE FullColumn = COMPOSITE
   OBJECT BaseColumn TRANSLATE <45.0 0.0 0.0>   END_OBJECT
   OBJECT BasePad    TRANSLATE <45.0 -1.0 0.0>  END_OBJECT
   OBJECT BasePad    TRANSLATE <45.0 41.0 0.0>  END_OBJECT
   OBJECT BaseArch   TRANSLATE <45.0 42.0 2.0>
                     ROTATE <0.0 -12.85 0.0>     END_OBJECT
END_COMPOSITE

DECLARE Level1 = COMPOSITE
   COMPOSITE FullColumn END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -25.7  0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -51.4  0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -77.1  0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -102.8 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -128.5 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -154.2 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -179.9 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -205.6 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -231.3 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -257.0 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -282.7 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -308.4 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -334.1 0.0> END_COMPOSITE
   COMPOSITE FullColumn ROTATE <0.0 -334.1 0.0> END_COMPOSITE
   OBJECT BaseFloor TRANSLATE <0.0 56.5 0.0>   END_OBJECT

   BOUNDED_BY
      INTERSECTION 
         QUADRIC Cylinder_Y SCALE <55.0 1.0 55.0> END_QUADRIC
         PLANE <0.0  -1.0  0.0> 0.0 END_PLANE
         PLANE <0.0  1.0   0.0> 60.0 END_PLANE
      END_INTERSECTION
   END_BOUND
END_COMPOSITE

COMPOSITE Level1 END_COMPOSITE

{ Add the sky to the picture }
OBJECT
   SPHERE <0.0 0.0 0.0> 300.0 END_SPHERE

   TEXTURE
      BOZO
      TURBULENCE 0.5
      COLOUR_MAP
          [0.0 0.6  COLOUR RED 0.5 GREEN 0.5 BLUE 1.0
                    COLOUR RED 0.5 GREEN 0.5 BLUE 1.0]
          [0.6 0.8 COLOUR RED 0.5 GREEN 0.5 BLUE 1.0
                    COLOUR RED 1.0 GREEN 1.0 BLUE 1.0]
          [0.8 1.001 COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
                     COLOUR RED 0.8 GREEN 0.8 BLUE 0.8]
      END_COLOUR_MAP
      SCALE <100.0  20.0  100.0>
      AMBIENT 0.8
      DIFFUSE 0.0
   END_TEXTURE

   COLOUR RED 0.5 GREEN 0.5 BLUE 1.0

END_OBJECT

{ Define the desert floor }
OBJECT
   PLANE <0.0 1.0 0.0> -2.0 END_PLANE

   TEXTURE
      0.05  { This value dithers the colours }
      COLOUR RED 1.0 GREEN 0.66 BLUE 0.2
      RIPPLES 0.5
      FREQUENCY 2000.0
      SCALE <50000.0 50000.0 50000.0>
      AMBIENT 0.3
      DIFFUSE 0.7
   END_TEXTURE

   COLOUR RED 1.0 GREEN 0.66 BLUE 0.2

END_OBJECT

{ Add a light source }
OBJECT
    SPHERE <0.0 0.0 0.0> 1.0 END_SPHERE

    TRANSLATE <60.0  50.0  -110.0>
    TEXTURE
      COLOUR White
      AMBIENT 1.0
      DIFFUSE 0.0
    END_TEXTURE
    LIGHT_SOURCE
    COLOUR White
END_OBJECT

</textarea>

<!-- Sample file : room.dat -->

<textarea id="room.dat" name="room.dat" style="display:none;">

{ Room.dat - Empty room created for CIS Comart Raytracing Group Project }
{ See Room.doc for guidelines }
{ 12/31/90 Drew Wells 73767,1244 - Feel free to make suggestions,}
{                                  it's a group project! }
{ DEADLINE for objects is 1/20/91 }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ Camera Facing North}
VIEW_POINT
   DIRECTION <0.0 0.0  1.5>
   UP  <0.0  1.0  0.0>
   RIGHT <1.333333 0.0 0.0>
   TRANSLATE < 10.0  5.0  -30.0>
   LOOK_AT <0.0 5.0 0.0>
END_VIEW_POINT

{***********************************************}
{ Define objects for use in scene               }
{ Your object should be DECLAREd here           }
{***********************************************}

DECLARE North_Wall = OBJECT 
   PLANE <0.0 0.0 1.0> 10.0 END_PLANE
   TEXTURE 
     GRANITE
     SCALE <1.0 20.0 1.0>
   END_TEXTURE
   COLOR Yellow
 END_OBJECT
{ South Wall commented out so camera can see in}
DECLARE South_Wall = OBJECT
   PLANE <0.0 0.0 1.0> -10.0 END_PLANE
   TEXTURE 
     Cherry_Wood
     0.05
     SCALE <10.0 10.0 10.0>
   END_TEXTURE
   COLOR Red
 END_OBJECT

{ Not visible with current viewpoint}
{ But could be useful for light coming through window etc. }
DECLARE East_Wall = OBJECT
   PLANE <1.0 0.0 0.0> 15.0 END_PLANE
   TEXTURE
     Jade
     SCALE <10.0 10.0 10.0>
   END_TEXTURE
   COLOR Green  
 END_OBJECT
DECLARE West_Wall = OBJECT
   PLANE <1.0 0.0 0.0> -15.0 END_PLANE
   TEXTURE 
     White_Wood
     0.05
     SCALE <15.0 20.0 3.0>
   END_TEXTURE
   COLOR Blue
 END_OBJECT
DECLARE Ceiling = OBJECT
   PLANE <0.0 1.0 0.0> 15.0 END_PLANE
   TEXTURE 
     Red_Marble
     SCALE <10.0 10.0 10.0>
   END_TEXTURE
   COLOR White
 END_OBJECT 
DECLARE Floor = OBJECT
   PLANE <0.0 1.0 0.0> 0.0 END_PLANE
   TEXTURE 
     Pine_Wood
     0.05
     SCALE <40.0 3.0 3.0>
   END_TEXTURE
   COLOR Violet
 END_OBJECT

{*****************************************}
{ Scene description                       }
{*****************************************}
OBJECT
  North_Wall
END_OBJECT
{ Comment out South Wall so camera can see in }
{OBJECT
  South_Wall
END_OBJECT}
OBJECT
  East_Wall
END_OBJECT
OBJECT
  West_Wall
END_OBJECT
OBJECT
  Ceiling
END_OBJECT
OBJECT
  Floor
END_OBJECT

{ Colored spheres to help visualize coordinates}
OBJECT {North}
 SPHERE <0.0 7.0 9.0> 1.0 END_SPHERE
 TEXTURE COLOR Yellow END_TEXTURE
 COLOR Yellow
END_OBJECT
{ South sphere not visible in example gif}
{OBJECT {South}
 SPHERE <0.0 5.0 -10.0> 1.0 END_SPHERE
 TEXTURE COLOR Red END_TEXTURE
 COLOR Red
END_OBJECT}
OBJECT {East}
 SPHERE <10.0 7.0 0.0> 1.0 END_SPHERE
 TEXTURE COLOR Green END_TEXTURE
 COLOR Green
END_OBJECT
OBJECT {West}
 SPHERE <-14.0 7.0 0.0> 1.0 END_SPHERE
 TEXTURE COLOR Blue END_TEXTURE
 COLOR Blue
END_OBJECT
OBJECT {Up}
 SPHERE <0.0 14.0 0.0> 1.0 END_SPHERE
 TEXTURE COLOR White END_TEXTURE
 COLOR White
END_OBJECT
OBJECT {Down}
 SPHERE <0.0 1.0 0.0> 1.0 END_SPHERE
 TEXTURE COLOR Violet END_TEXTURE
 COLOR Violet
END_OBJECT


{Crude Spot light - feel free to add more light sources.}
OBJECT
 INTERSECTION
   SPHERE <0.0 0.0 0.0> 2.0 INVERSE END_SPHERE
   SPHERE <0.0 0.0 0.0> 2.1 END_SPHERE
   PLANE  <0.0 0.0 1.0> 1.2 END_PLANE
 END_INTERSECTION 
 TEXTURE
   Brown_Agate
   SCALE <3.0 3.0 3.0>
   SPECULAR 1.0
 END_TEXTURE
 ROTATE <45.0 -40.0 0.0>
 TRANSLATE <10.0 10.0 -8.0>
END_OBJECT

OBJECT
  SPHERE <0.0 0.0 0.0> 0.0005 END_SPHERE
  TRANSLATE <10.0 10.0 -8.0>
  TEXTURE
    COLOUR White
    AMBIENT 0.001
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT

{ Far light source to light where spot doesn't }   
OBJECT
  SPHERE <0.0 0.0 0.0> 0.0008 END_SPHERE
  TRANSLATE <-10.0 10.0 -40.0>
  TEXTURE
    COLOUR White
    AMBIENT 0.001
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : rosetest.dat -->

<textarea id="rosetest.dat" name="rosetest.dat" style="display:none;">
{ Rose in a Glass Ball DKB imagemap test file by Aaron A. Collins }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <0.0  20.0  -100.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
END_VIEW_POINT

OBJECT
   SPHERE <0.0  25.0  0.0>  40.0 END_SPHERE

   TEXTURE				    { X-Y oriented bitmap image }
     IMAGEMAP <1.0 -1.0 0.0> GIF "rose.gif"
     SCALE < 75.0 75.0 75.0 >		    { scaled and translated so only }
     TRANSLATE < 35.0 -19.0 0.0 >	    { 1 instance of the map appears. }
     AMBIENT 0.3
     DIFFUSE 0.7
     PHONG 0.75
   END_TEXTURE

END_OBJECT

OBJECT
   PLANE <0.0 1.0 0.0> -10.0 END_PLANE

   TEXTURE
     COLOR Gold
     AMBIENT 0.1
     DIFFUSE 0.5
{    REFLECTION 1.0	}
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE  <0.0  0.0  0.0> 2.0 END_SPHERE
   TRANSLATE  <100.0  120.0  -130.0>

   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0.0  0.0  0.0> 2.0 END_SPHERE
   TRANSLATE <-100.0  100.0  -130.0>

   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : skyvase.dat -->

<textarea id="skyvase.dat" name="skyvase.dat" style="display:none;">
   {  Author: Dan Farmer
              Minneapolis, MN

      SKYVASE.DAT
      Vase made with Hyperboloid and sphere, sitting on a hexagonal
      marble column.  Take note of the color and surface characteristics
      of the gold band around the vase.  It seems to be a successful
      combination for gold or brass.

      This data file is for use with DKBTrace by David Buck.  This file
      is released to the public domain and may be used or altered by
      anyone as desired. }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

DECLARE DMF_Hyperboloid = QUADRIC  { Like Hyperboloid_Y, but more curvy }
	<1.0 -1.0  1.0>
	<0.0  0.0  0.0>
	<0.0  0.0  0.0>
	-0.5
END_QUADRIC

VIEW_POINT
   LOCATION <0.0  28.0  -200.0>
   DIRECTION <0.0 0.0  2.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
   LOOK_AT <0.0  -12.0 0.0>
END_VIEW_POINT

{ Light behind viewer postion (pseudo-ambient light) }
OBJECT  
   SPHERE <0.0  0.0  0.0>  2.0 END_SPHERE
   TRANSLATE <100.0  500.0  -500.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

COMPOSITE
   OBJECT
      UNION
        INTERSECTION
          PLANE <0 1 0> 0.7 END_PLANE
          QUADRIC DMF_Hyperboloid SCALE <0.75 1.25 0.75> END_QUADRIC
          QUADRIC DMF_Hyperboloid SCALE <0.70 1.25 0.70> INVERSE END_QUADRIC
          PLANE <0.0 1.0 0.0> -1.0 INVERSE END_PLANE
        END_INTERSECTION
        QUADRIC Sphere SCALE <1.6 0.75 1.6 > TRANSLATE <0 -1.15 0> END_QUADRIC
      END_UNION
      SCALE <20 25 20>
      TEXTURE
        Cloud_Sky
	0.05
	TURBULENCE 0.85
	SCALE <10.0 10.0 10.0>
	AMBIENT 0.3
	DIFFUSE 0.7
	SPECULAR 0.75
	ROUGHNESS 0.05
	REFLECTION 0.45
      END_TEXTURE
      COLOR Green
   END_OBJECT
   OBJECT  { Gold ridge around sphere portion of vase}
      QUADRIC Sphere
         SCALE <1.6 0.75 1.6 >
         TRANSLATE <0 -7.0 0>
         SCALE <20.5 4.0  20.5 >
      END_QUADRIC
      TEXTURE
	 Polished_Metal
	 0.05
	 COLOR OldGold
      END_TEXTURE
      COLOR OldGold
   END_OBJECT
   BOUNDED_BY
      INTERSECTION
	  Y_Disk
	  TRANSLATE <0.0 -0.5 0.0>
	  SCALE <34 100 34>
      END_INTERSECTION
   END_BOUND
END_COMPOSITE

OBJECT  { Stand for the vase }
    INTERSECTION Hexagon
      ROTATE <0.0 0.0 -90.0>	{ Stand it on end (vertical)}
      ROTATE<0.0 -45.0 0.0>	{ Turn it to a pleasing angle }
      SCALE<40 25 40>
      TRANSLATE<0 -70 0>
    END_INTERSECTION
    TEXTURE
      Black_Marble
      SCALE <10.0 10.0 10.0>
      AMBIENT 0.3
      DIFFUSE 0.7
      REFLECTION 0.85
    END_TEXTURE
    COLOR RED 1.0          {Color is only for debugging w/o texture}
END_OBJECT

OBJECT    {Left wall}
    PLANE <0 0 1> 50 END_PLANE
    ROTATE <0 -45 0>
    TEXTURE
      COLOR Gray
      AMBIENT 0.3
      DIFFUSE 0.7
      REFLECTION 0.5
    END_TEXTURE
    COLOR Gray
END_OBJECT

OBJECT     {Right wall}
    PLANE <0 0 1> 50 END_PLANE
    ROTATE <0 45 0>
    TEXTURE
      COLOR  Gray
      AMBIENT 0.3
      DIFFUSE 0.7
      REFLECTION 0.5
    END_TEXTURE
    COLOR  Gray
END_OBJECT
</textarea>

<!-- Sample file : snack.dat -->

<textarea id="snack.dat" name="snack.dat" style="display:none;">
{ DKB scene description file SNACK.DAT  }
{ File originally written by Tom Price  }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
  LOCATION <0.0 50.0 -150.0>
  UP <0.0 1.0 0.0>
  RIGHT <1.3333 0.0 0.0>
  LOOK_AT <0.0 0.0 0.0>
END_VIEW_POINT


OBJECT
  SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
  TRANSLATE <50.0 150.0 -250.0>
    TEXTURE
      COLOUR White
      AMBIENT 1.0
      DIFFUSE 0.0
    END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT

OBJECT
  SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
    TRANSLATE <-50.0 150.0 -250.0>
    TEXTURE
      COLOUR White
      AMBIENT 1.0
      DIFFUSE 0.0
    END_TEXTURE
    LIGHT_SOURCE
    COLOUR White
END_OBJECT


{The Sky}
OBJECT
  SPHERE <0.0 -49000.0 -200.0> 50000.0 INVERSE END_SPHERE
    TEXTURE 
      Cloud_Sky
      0.05 
      SCALE <5000.0 1000.0 5000.0>
      AMBIENT 0.7
      DIFFUSE 0.0
    END_TEXTURE
    COLOUR SkyBlue
END_OBJECT

{ The wood grain tabletop }
OBJECT
  INTERSECTION
    PLANE <1.0 0.0 0.0> 1.0 END_PLANE
    PLANE <1.0 0.0 0.0> -1.0 INVERSE END_PLANE
    PLANE <0.0 1.0 0.0> 1.0 END_PLANE
    PLANE <0.0 1.0 0.0> -1.0 INVERSE END_PLANE
    PLANE <0.0 0.0 1.0> 1.0 END_PLANE
    PLANE <0.0 0.0 1.0> -1.0 INVERSE END_PLANE
  END_INTERSECTION
    TEXTURE
      Pine_Wood
      SCALE <7.0 1.0 0.7>
      ROTATE <0.0 -30.0 0.0>
      AMBIENT 0.1
      DIFFUSE 0.5
      REFLECTION 0.3
      BRILLIANCE 3.0
    END_TEXTURE
  BOUNDED_BY
    INTERSECTION
      PLANE <1.0 0.0 0.0> 1.01 END_PLANE
      PLANE <1.0 0.0 0.0> -1.01 INVERSE END_PLANE
      PLANE <0.0 1.0 0.0> 1.01 END_PLANE
      PLANE <0.0 1.0 0.0> -1.01 INVERSE END_PLANE
      PLANE <0.0 0.0 1.0> 1.01 END_PLANE
      PLANE <0.0 0.0 1.0> -1.01 INVERSE END_PLANE
    END_INTERSECTION
  END_BOUND
  SCALE <200.0 1.0 200.0>
  TRANSLATE <0.0 -42.0 0.0>
END_OBJECT


{ a salami }
DECLARE
Salami = COMPOSITE
 { the outside skin }
  OBJECT
    UNION
      INTERSECTION
        QUADRIC Cylinder_X SCALE <1.0 20.0 20.0> END_QUADRIC
	PLANE <1.0 0.0 0.0> 10.0 END_PLANE
	PLANE <1.0 0.0 0.0> -10.0 INVERSE END_PLANE
      END_INTERSECTION
      SPHERE <-10.0 0.0 0.0> 20.0 END_SPHERE
    END_UNION
    TEXTURE
      0.05
      COLOUR RED 0.5 GREEN 0.2 BLUE 0.2
      AMBIENT 0.1
      DIFFUSE 0.8
      REFLECTION 0.2
      BRILLIANCE 3.0
      PHONG 0.3
      PHONGSIZE 20.0
    END_TEXTURE
    COLOUR RED 0.5 GREEN 0.2 BLUE 0.2
  END_OBJECT
  OBJECT
    INTERSECTION
      QUADRIC Cylinder_X SCALE <1.0 19.0 19.0> END_QUADRIC
      PLANE <1.0 0.0 0.0> 10.01 END_PLANE
      PLANE <1.0 0.0 0.0> -10.0 INVERSE END_PLANE
    END_INTERSECTION
    TEXTURE
      0.1
      COLOUR Pink
      AMBIENT 0.3
      DIFFUSE 0.7
    END_TEXTURE
    COLOUR Pink
  END_OBJECT
  BOUNDED_BY
    INTERSECTION
      QUADRIC Cylinder_X SCALE <1.0 20.01 20.01> END_QUADRIC
      PLANE <1.0 0.0 0.0> 10.02 END_PLANE
      PLANE <1.0 0.0 0.0> -30.01 INVERSE END_PLANE
    END_INTERSECTION
  END_BOUND
END_COMPOSITE

{ a salami slice }
DECLARE
Slice = COMPOSITE
 { the outside skin }
  OBJECT
    INTERSECTION
      QUADRIC Cylinder_X SCALE <1.0 20.0 20.0> END_QUADRIC
      PLANE <1.0 0.0 0.0> 0.5 END_PLANE
      PLANE <1.0 0.0 0.0> -0.5 INVERSE END_PLANE
    END_INTERSECTION
    TEXTURE
      0.05
      COLOUR RED 0.5 GREEN 0.2 BLUE 0.2
      AMBIENT 0.1
      DIFFUSE 0.8
      REFLECTION 0.2
      BRILLIANCE 3.0
      PHONG 0.3
      PHONGSIZE 20.0
    END_TEXTURE
    COLOUR RED 0.5 GREEN 0.2 BLUE 0.2
  END_OBJECT
    OBJECT
      INTERSECTION
        QUADRIC Cylinder_X SCALE <1.0 19.0 19.0> END_QUADRIC
        PLANE <1.0 0.0 0.0> 0.51 END_PLANE
        PLANE <1.0 0.0 0.0> -0.51 INVERSE END_PLANE
      END_INTERSECTION
      TEXTURE
        0.1
        AMBIENT 0.3
        DIFFUSE 0.7
        COLOUR Pink
      END_TEXTURE
      COLOUR Pink
    END_OBJECT
  BOUNDED_BY
    INTERSECTION
      QUADRIC Cylinder_X SCALE <1.0 20.01 20.01> END_QUADRIC
      PLANE <1.0 0.0 0.0> 0.52 END_PLANE
      PLANE <1.0 0.0 0.0> -0.52 INVERSE END_PLANE
    END_INTERSECTION
  END_BOUND
END_COMPOSITE


{ a wedge of cheese}
DECLARE
Cheese = OBJECT
  INTERSECTION
    QUADRIC Cylinder_Y SCALE <10.0 1.0 10.0> END_QUADRIC
    PLANE <0.0 1.0 0.0> 20.0 END_PLANE
    PLANE <0.0 1.0 0.0> 0.0 INVERSE END_PLANE
    PLANE <1.0 0.0 0.0>  5.0 ROTATE <0.0 30.0 0.0> END_PLANE
    PLANE <1.0 0.0 0.0> -5.0 ROTATE <0.0 -30.0 0.0> INVERSE END_PLANE
    QUADRIC Cylinder_X SCALE <1.0 1.0 1.5>
      ROTATE <0.0 -20.0 30>
      TRANSLATE <0.0 10.0 0.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 2.0 1.5>
      ROTATE <0.0 20.0 -30>
      TRANSLATE <0.0 12.0 -4.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.0 1.0>
      TRANSLATE <0.0 15.0 -9.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 2.0 1.5>
      ROTATE <0.0 -30.0 -30.0>
      TRANSLATE <0.0 15.0 5.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.5 1.5>
      ROTATE <0.0 0.0 -20.0>
      TRANSLATE <0.0 7.0 -9.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.0 1.0>
      ROTATE <0.0 10.0 10.0>
      TRANSLATE <0.0 10.0 -2.0>
    INVERSE END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.0 1.2>
      ROTATE <0.0 -10.0 0.0>
      TRANSLATE <0.0 5.0 0.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.3 1.0>
      TRANSLATE <0.0 3.0 -3.0>
      INVERSE
    END_QUADRIC
  END_INTERSECTION
  TEXTURE
    0.05
    COLOUR RED 1.0 GREEN 0.8 BLUE 0.0
    AMBIENT 0.2
    DIFFUSE 0.8
  END_TEXTURE
  COLOUR RED 1.0 GREEN 0.8 BLUE 0.0
  BOUNDED_BY
    INTERSECTION
      QUADRIC Cylinder_Y SCALE <10.01 1.0 10.01> END_QUADRIC
      PLANE <0.0 1.0 0.0> 20.01 END_PLANE
      PLANE <0.0 1.0 0.0> -0.01 INVERSE END_PLANE
    END_INTERSECTION
  END_BOUND
END_OBJECT

{ a slice of cheese}
DECLARE
CheeseSlice = OBJECT
  INTERSECTION
    QUADRIC Cylinder_Y SCALE <10.0 1.0 10.0> END_QUADRIC
    PLANE <0.0 1.0 0.0> 20.0 END_PLANE
    PLANE <0.0 1.0 0.0> 0.0 INVERSE END_PLANE
    PLANE <1.0 0.0 0.0>  0.2  END_PLANE
    PLANE <1.0 0.0 0.0> -0.2 INVERSE END_PLANE
    QUADRIC Cylinder_X SCALE <1.0 1.0 1.5>
      ROTATE <0.0 -20.0 30>
      TRANSLATE <0.0 10.0 0.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 2.0 1.5>
      ROTATE <0.0 20.0 -30>
      TRANSLATE <0.0 12.0 -4.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.0 1.0>
      TRANSLATE <0.0 15.0 -9.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 2.0 1.5>
      ROTATE <0.0 -30.0 -30.0>
      TRANSLATE <0.0 15.0 5.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.5 1.5>
      ROTATE <0.0 0.0 -20.0>
      TRANSLATE <0.0 7.0 -9.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.0 1.0>
      ROTATE <0.0 10.0 10.0>
      TRANSLATE <0.0 10.0 -2.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.0 1.2>
      ROTATE <0.0 -10.0 0.0>
      TRANSLATE <0.0 3.0 5.0>
      INVERSE
    END_QUADRIC
    QUADRIC Cylinder_X SCALE <1.0 1.3 1.0>
      ROTATE <0.0 0.0 0.0>
      TRANSLATE <0.0 2.0 2.0>
      INVERSE
    END_QUADRIC
  END_INTERSECTION
  TEXTURE
    0.05
    COLOUR RED 1.0 GREEN 0.8 BLUE 0.0
    AMBIENT 0.2
    DIFFUSE 0.8
  END_TEXTURE
  COLOUR RED 1.0 GREEN 0.8 BLUE 0.0
  BOUNDED_BY
    INTERSECTION
      QUADRIC Cylinder_Y SCALE <10.01 1.0 10.01> END_QUADRIC
      PLANE <0.0 1.0 0.0> 20.01 END_PLANE
      PLANE <0.0 1.0 0.0> -0.01 INVERSE END_PLANE
      PLANE <1.0 0.0 0.0> 0.3 END_PLANE
      PLANE <1.0 0.0 0.0> -0.3 INVERSE END_PLANE
    END_INTERSECTION
  END_BOUND
END_OBJECT

{ An oval glass dish }
DECLARE
Dish = OBJECT
  UNION
    INTERSECTION
      QUADRIC Sphere SCALE <100.0 25.0 25.0> END_QUADRIC
      QUADRIC Sphere SCALE <95.0 24.0 24.0> INVERSE END_QUADRIC
      PLANE <0.0 1.0 0.0> 0.0 END_PLANE
      PLANE <0.0 1.0 0.0> -5.0 INVERSE END_PLANE
    END_INTERSECTION
    INTERSECTION
      QUADRIC Cylinder_Y SCALE <95.0 1.0 24.0> END_QUADRIC
      PLANE <0.0 1.0 0.0> -4.0 END_PLANE
      PLANE <0.0 1.0 0.0> -5.0 INVERSE END_PLANE
    END_INTERSECTION
  END_UNION
  TEXTURE
    COLOUR Clear
    AMBIENT 0.1
    DIFFUSE 0.8
    REFRACTION 0.95
    IOR 1.5
    REFLECTION 0.05
    BRILLIANCE 2.0
  END_TEXTURE
  COLOUR Clear
  BOUNDED_BY
    INTERSECTION
      QUADRIC Cylinder_Y SCALE <100.01 1.0 25.01> END_QUADRIC
      PLANE <0.0 1.0 0.0> 0.01 END_PLANE
      PLANE <0.0 1.0 0.0> -5.01 INVERSE END_PLANE
    END_INTERSECTION
  END_BOUND
END_OBJECT

{ a slice of bread }
DECLARE
BreadSlice = COMPOSITE
  OBJECT
    UNION
      INTERSECTION
        PLANE <1.0 0.0 0.0> 10.0 END_PLANE
	PLANE <1.0 0.0 0.0> -10.0 INVERSE END_PLANE
	PLANE <0.0 1.0 0.0> 1.0 END_PLANE
	PLANE <0.0 1.0 0.0> -1.0 INVERSE END_PLANE
	PLANE <0.0 0.0 1.0> 10.0 END_PLANE
	PLANE <0.0 0.0 1.0> -10.0 INVERSE END_PLANE
      END_INTERSECTION
      INTERSECTION
        QUADRIC Cylinder_Y SCALE <11.0 1.0 7.0>
	  TRANSLATE <0.0 0.0 10.0>
	END_QUADRIC
	PLANE <0.0 1.0 0.0> 1.0 END_PLANE
	PLANE <0.0 1.0 0.0> -1.0 INVERSE END_PLANE
      END_INTERSECTION
    END_UNION
    TEXTURE
      0.05
      COLOUR RED 0.4 GREEN 0.3 BLUE 0.1
      AMBIENT 0.3
      DIFFUSE 0.7
      REFLECTION 0.1
      BRILLIANCE 2.0
    END_TEXTURE
    COLOUR RED 0.4 GREEN 0.3 BLUE 0.1
  END_OBJECT

  OBJECT
    UNION
      INTERSECTION
        PLANE <1.0 0.0 0.0> 9.5 END_PLANE
	PLANE <1.0 0.0 0.0> -9.5 INVERSE END_PLANE
	PLANE <0.0 1.0 0.0> 1.01 END_PLANE
	PLANE <0.0 1.0 0.0> -1.01 INVERSE END_PLANE
	PLANE <0.0 0.0 1.0> 9.5 END_PLANE
	PLANE <0.0 0.0 1.0> -9.5 INVERSE END_PLANE
      END_INTERSECTION
      INTERSECTION
        QUADRIC Cylinder_Y SCALE <10.5 1.0 6.5>
	  TRANSLATE <0.0 0.0 10.0>
	END_QUADRIC
	PLANE <0.0 1.0 0.0> 1.01 END_PLANE
	PLANE <0.0 1.0 0.0> -1.01 INVERSE END_PLANE
      END_INTERSECTION
    END_UNION
    TEXTURE
      0.1
      COLOUR RED 0.7 GREEN 0.6 BLUE 0.45
      AMBIENT 0.3
      DIFFUSE 0.7
    END_TEXTURE
    COLOUR RED 0.7 GREEN 0.6 BLUE 0.45
  END_OBJECT
  BOUNDED_BY
    INTERSECTION
      PLANE <1.0 0.0 0.0> 10.1 END_PLANE
      PLANE <1.0 0.0 0.0> -10.1 INVERSE END_PLANE
      PLANE <0.0 1.0 0.0> 1.0 END_PLANE
      PLANE <0.0 1.0 0.0> -1.1 INVERSE END_PLANE
      PLANE <0.0 0.0 1.0> 17.1 END_PLANE
      PLANE <0.0 0.0 1.0> -10.1 INVERSE END_PLANE
    END_INTERSECTION
  END_BOUND
END_COMPOSITE	

{ Now to put the scene together}
COMPOSITE
  OBJECT Dish
    SCALE <0.7 1.0 1.2>
    TRANSLATE <0.0 -36.0 -25.0>
  END_OBJECT

  COMPOSITE Salami
    ROTATE <0.0 35.0 0.0>
    TRANSLATE <-30.0 -20.0 -20.0>
  END_COMPOSITE

  OBJECT Cheese
    SCALE <2.0 2.0 2.0>
    ROTATE <0.0 25.0 0.0>
    TRANSLATE <30.0 -40.0 -25.0>
  END_OBJECT
  TRANSLATE <0.0 0.0 25.0>
  ROTATE <0.0 -15.0 0.0>
  TRANSLATE <-35.0 0.0 20.0>
END_COMPOSITE

{ now a sandwich }
COMPOSITE
  COMPOSITE Slice
    ROTATE <0.0 90.0 0.0>
    ROTATE <90.0 0.0 0.0>
    TRANSLATE <45.0 -33.0 -35.0>
  END_COMPOSITE

  OBJECT CheeseSlice
    SCALE <1.0 2.0 2.0>
    ROTATE <0.0 -90.0 0.0>
    ROTATE <90.0 0.0 0.0>
    TRANSLATE <0.0 0.0 -16.0>
    ROTATE <0.0 30.0 0.0>
    TRANSLATE <45.0 -35.0 -35.0>
  END_OBJECT

  COMPOSITE BreadSlice
    SCALE <1.6 2.0 1.0>
    ROTATE <0.0 -150.0 0.0>
    TRANSLATE <45.0 -38.0 -35.0>
  END_COMPOSITE

  COMPOSITE BreadSlice
    SCALE <1.6 2.0 1.0>
    ROTATE <0.0 -150.0 0.0>
    TRANSLATE <45.0 -29.0 -35.0>
  END_COMPOSITE
  TRANSLATE <0.0 15.0 10.0>
END_COMPOSITE

{spotlight on the sandwich}
OBJECT
  INTERSECTION
    QUADRIC Cylinder_Y SCALE <7.5 1.0 7.5> END_QUADRIC
    QUADRIC Cylinder_Y SCALE <7.4 1.0 7.4> INVERSE END_QUADRIC
    PLANE <0.0 1.0 0.0> 50.0 END_PLANE
    PLANE <0.0 1.0 0.0> 0.0 INVERSE END_PLANE
  END_INTERSECTION
  TRANSLATE <45.0 100.0 -25.0>
  TEXTURE
    COLOUR White
    AMBIENT 0.3
    DIFFUSE 0.7
  END_TEXTURE
  COLOUR White
END_OBJECT

OBJECT
  SPHERE <0.0 0.0 0.0> 4.0 END_SPHERE
  TRANSLATE <45.0 145.0 -25.0>
  TEXTURE
    COLOUR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT

COMPOSITE Slice
  ROTATE <0.0 90.0 0.0>
  ROTATE <65.0 0.0 0.0>
  TRANSLATE <-30.0 25.0 45.0>
END_COMPOSITE

COMPOSITE Slice
  ROTATE <0.0 90.0 0.0>
  ROTATE <60.0 0.0 0.0>
  TRANSLATE <35.0 25.0 25.0>
END_COMPOSITE

OBJECT CheeseSlice
  SCALE <1.0 2.0 2.0>
  ROTATE <0.0 -90.0 0.0>
  ROTATE <50.0 0.0 0.0>
  TRANSLATE <-20.0 35.0 30.0>
END_OBJECT

OBJECT CheeseSlice
  SCALE <1.0 2.0 2.0>
  ROTATE <0.0 -90.0 0.0>
  ROTATE <70.0 0.0 0.0>
  TRANSLATE <65.0 15.0 35.0>
END_OBJECT

COMPOSITE BreadSlice
  SCALE <1.6 2.0 1.0>
  ROTATE <-40.0 -60.0 0.0>
  TRANSLATE <-60.0 25.0 35.0>
END_COMPOSITE

COMPOSITE BreadSlice
  SCALE <1.6 2.0 1.0>
  ROTATE <60.0 50.0 0.0>
  TRANSLATE <70.0 0.0 30.0>
END_COMPOSITE
</textarea>

<!-- Sample file : spline.dat -->

<textarea id="spline.dat" name="spline.dat" style="display:none;">

{ Spline.Dat  - This file requires merry.inc }

{ Drew Wells 1990 CIS 73767,1244 }

{ This is a huge word "Merry" written in cursive over a reflective  }
{ checkered plain. Normally I avoid using the cliched checkered plane, }
{ but here it looks good with the huge, holiday "Merry". }

{ This file is for use with DKBTrace by David Buck. }
{ This file is released into the public domain. }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

INCLUDE "merry.inc"

VIEW_POINT
   LOCATION <10.0  25.0  -550.0>
   DIRECTION <0.0 0.0  3.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
   LOOK_AT <120.0 45.0 0.0>
END_VIEW_POINT

{ Put down the beloved famous raytrace green/yellow checkered floor }
OBJECT
   PLANE <0.0 1.0 0.0> 17.0 END_PLANE
   TEXTURE
      CHECKER
        COLOUR RED 1.0 BLUE 1.0 GREEN 1.0
	COLOUR RED 0.1 GREEN 0.6 BLUE 0.1
      SCALE < 20.0 20.0 20.0 >
      REFLECTION 0.5
      AMBIENT 0.1
      DIFFUSE 0.8
   END_TEXTURE
   COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
END_OBJECT

OBJECT
   UNION Merry END_UNION
   TEXTURE
     COLOR RED 1.0
     AMBIENT 0.1
     DIFFUSE 0.9
   END_TEXTURE
END_OBJECT

OBJECT
   SPHERE <0.0  0.0  0.0> 5.0 END_SPHERE
   TRANSLATE <200.0  120.99  -330.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

{
OBJECT
   SPHERE <0.0  0.0  0.0> 5.0 END_SPHERE
   TRANSLATE <-100.0  120.99  -330.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
}
</textarea>

<!-- Sample file : stonewal.dat -->

<textarea id="stonewal.dat" name="stonewal.dat" style="display:none;">
   {  Author name : Dan Farmer
                    Minneapolis, MN

      A pastoral scene with a granite stone fence.  This was never really
      "finished", but it works as it is.  Plenty of material to play around
      with here.  The basic building blocks are here... just use your
      imagination.

      This data file is for use with DKBTrace by David Buck.  This file
      is released to the public domain and may be used or altered by
      anyone as desired. }

INCLUDE "shapes.dat"		  {Includes New "Cube" Primitive}
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
    LOCATION <50.0  40.0  -350.0>
    LOOK_AT <-100.0 0.0 0.0>
    DIRECTION <0.0 0.0 2.0>
    RIGHT < 1.3333 0.0 0.0 >
END_VIEW_POINT

{ Add light source }
OBJECT
    SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
    TRANSLATE <100.0  200.0  -630.0>
    TEXTURE
      COLOR White
      AMBIENT 1.0
      DIFFUSE 0.0
    END_TEXTURE
    LIGHT_SOURCE
    COLOR White
END_OBJECT

OBJECT
    SPHERE <0.0 0.0 0.0> 50.0 END_SPHERE
    TRANSLATE <50.0  20000.0 50.0>
    TEXTURE
      COLOR White
      AMBIENT 1.0
      DIFFUSE 0.0
    END_TEXTURE
    LIGHT_SOURCE
    COLOR White
END_OBJECT

{ Add the sky to the picture }
OBJECT
    SPHERE <0.0 0.0 0.0> 1000000.0 END_SPHERE
    TEXTURE
        COLOR SkyBlue
	DIFFUSE 0.0
	AMBIENT 0.5
    END_TEXTURE
    COLOR SkyBlue
END_OBJECT

{ Grassy meadow }
OBJECT
    PLANE <0.0 1.0 0.0> -2.0 END_PLANE
    TEXTURE
        0.05  { This value dithers the colors }
	COLOR RED 0.2 GREEN 1.0 BLUE 0.4
	WAVES 1.0
	FREQUENCY 2000.0
	SCALE <50000.0 50000.0 50000.0>
	AMBIENT 0.1
	DIFFUSE 0.3
    END_TEXTURE
    COLOR RED 0.2 GREEN 1.0 BLUE 0.4
END_OBJECT

{ Put up a distant wall to prevent a black line in the middle of the
   screen }
OBJECT
    PLANE <0.0 0.0 1.0> 1000000.0  END_PLANE
    TEXTURE
    	COLOR RED 0.4 GREEN 0.4 BLUE 0.8
	AMBIENT 1.0
	DIFFUSE 0.0
    END_TEXTURE
    COLOR RED 0.4 GREEN 0.4 BLUE 0.8
END_OBJECT


DECLARE Wall_Segment = OBJECT
    INTERSECTION Cube END_INTERSECTION
    SCALE <8.0 50.0 100.0>
    TEXTURE
        0.05
        GRANITE
	AMBIENT 0.3
	DIFFUSE 0.7
	BRILLIANCE 7.0
	REFLECTION 0.1
	PHONG 1.0
	PHONGSIZE 60
    END_TEXTURE
    COLOR White
END_OBJECT

DECLARE Granite_Ball = OBJECT
    SPHERE <0.0 0.0 10.0> 10.0 END_SPHERE
    TEXTURE
        0.05
        GRANITE
	AMBIENT 0.3
	DIFFUSE 0.7
	BRILLIANCE 7.0
	REFLECTION 0.1
	PHONG 1.0
	PHONGSIZE 60
    END_TEXTURE
    COLOR White
END_OBJECT

DECLARE Column = OBJECT
    INTERSECTION Cube END_INTERSECTION
    SCALE <12.0 60.0 12.0>
    TEXTURE
        0.05
        GRANITE
	AMBIENT 0.3
	DIFFUSE 0.7
	BRILLIANCE 7.0
	REFLECTION 0.1
	PHONG 1.0
	PHONGSIZE 60
    END_TEXTURE
    COLOR White
END_OBJECT

{ NOTE: Granite column is 12 wide x 12 deep x 60 high
        Granite ball has a radius of 20 }
DECLARE Pillar = COMPOSITE
    OBJECT Column       TRANSLATE <0.0  0.0 0.0> END_OBJECT
    OBJECT Granite_Ball TRANSLATE <0.0 70.0 0.0> END_OBJECT
END_COMPOSITE

{ Note: Wall segments are 100 units long, Pillars are 12 units "long" }
COMPOSITE
    Pillar
    TRANSLATE <0.0 0.0 -106.0 >
END_COMPOSITE
OBJECT
    Wall_Segment
    TRANSLATE <-2.0 0.0 -6.0 >
END_OBJECT
COMPOSITE
    Pillar
    TRANSLATE <0.0 0.0 0.0 >
END_COMPOSITE
OBJECT
    Wall_Segment
    TRANSLATE <-2.0 0.0 112.0 >
END_OBJECT
COMPOSITE
    Pillar
    TRANSLATE <0.0 0.0 112.0 >
END_COMPOSITE
OBJECT
    Wall_Segment
    ROTATE <0.0 -90.0 0.0>
    TRANSLATE <76.0 0.0 114.0 >
END_OBJECT
COMPOSITE
    Pillar
    TRANSLATE <176.0 0.0 112.0 >
END_COMPOSITE
</textarea>

<!-- Sample file : sunset.dat -->

<textarea id="sunset.dat" name="sunset.dat" style="display:none;">
INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <0.0  10.0  200.0>
   DIRECTION <0.0  0.0  -1.0>
   UP <0.0  1.0  0.0>
   RIGHT <1.333333 0.0 0.0>
   LOOK_AT <0.0  130.0  -300.0>
END_VIEW_POINT

{ Define the ocean surface }
OBJECT
   PLANE <0.0  1.0  0.0> -10.0 END_PLANE

   TEXTURE
      COLOUR RED 1.0 GREEN 0.3
      WAVES 0.05
      FREQUENCY 5000.0
      SCALE <3000.0 3000.0 3000.0>
      REFLECTION 1.0
   END_TEXTURE
   COLOUR RED 1.0 GREEN 0.3
END_OBJECT

{ Put a floor underneath to catch any errant waves from the ripples }
OBJECT
   PLANE <0.0  1.0  0.0> -11.0 END_PLANE
   TEXTURE
      0.05
      COLOUR RED 1.0 GREEN 0.3
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   COLOUR RED 1.0 GREEN 0.3
END_OBJECT

{ Now draw the sky }
OBJECT
   SPHERE <0.0  0.0  0.0> 300.0 END_SPHERE

   TEXTURE
      GRADIENT <0.0  1.0  0.0>
      COLOUR_MAP [0.0 0.8  COLOUR RED 1.0 GREEN 0.3 BLUE 0.0
                           COLOUR RED 0.7 GREEN 0.7 BLUE 1.0]
                 [0.8 1.0 COLOUR RED 0.7 GREEN 0.7 BLUE 1.0
                          COLOUR RED 0.7 GREEN 0.7 BLUE 1.0]
      END_COLOUR_MAP
      SCALE <300.0  300.0  300.0>
      AMBIENT 0.7
      DIFFUSE 0.0   { we don't want clouds casting shadows on the sky }
   END_TEXTURE
   COLOUR RED 0.7  GREEN 0.7 BLUE 1.0
END_OBJECT

{ Put in a few clouds }
OBJECT
   SPHERE <0.0  0.0  0.0> 259.0 END_SPHERE

   TEXTURE
      BOZO
      TURBULENCE 0.5
      COLOUR_MAP
          [0.0 0.6  COLOUR RED 1.0 GREEN 1.0 BLUE 1.0 ALPHA 1.0
                    COLOUR RED 1.0 GREEN 1.0 BLUE 1.0 ALPHA 1.0]
          [0.6 0.8 COLOUR RED 1.0 GREEN 1.0 BLUE 1.0 ALPHA 1.0
                    COLOUR RED 1.0 GREEN 1.0 BLUE 1.0]
          [0.8 1.001 COLOUR RED 1.0 GREEN 1.0 BLUE 1.0
                     COLOUR RED 0.8 GREEN 0.8 BLUE 0.8]
      END_COLOUR_MAP
      SCALE <100.0  20.0  100.0>
      AMBIENT 0.7
      DIFFUSE 0.0
   END_TEXTURE
   COLOUR RED 0.7 GREEN 0.7 BLUE 1.0
END_OBJECT

{ Now to cast some light on the subject }
OBJECT
   SPHERE <0.0  0.0  0.0> 40.0 END_SPHERE

   TRANSLATE <0.0  0.0  -300.0>
   ROTATE <10.0  0.0  0.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : sunset1.dat -->

<textarea id="sunset1.dat" name="sunset1.dat" style="display:none;">
{
  This is the "classic" SUNSET scene by David K. Buck.  I'm resurrecting it
  because I always thought it looked very realistic...  - Aaron A. Collins
}

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   LOCATION <0.0  100.0  200.0>
   DIRECTION <0.0  0.0  -1.0>
   UP <0.0  1.0  0.0>
   RIGHT <1.333333 0.0 0.0>
END_VIEW_POINT

{ Define the ocean surface }
OBJECT
   PLANE <0.0 1.0 0.0> -10.0 END_PLANE

   TEXTURE
      WAVES 0.06
      FREQUENCY 5000.0
      SCALE <1000.0 1000.0 1000.0>
      REFLECTION 1.0
   END_TEXTURE
   COLOUR RED 1.0 GREEN 0.3
END_OBJECT

{ Put a floor underneath to catch any errant waves from the ripples }
OBJECT
   PLANE <0.0 1.0 0.0> -11.0 END_PLANE

   TEXTURE
      0.05
      COLOUR RED 1.0 GREEN 0.3
      AMBIENT 1.0
      DIFFUSE 0.0
   END_TEXTURE
   COLOUR RED 1.0 GREEN 0.3
END_OBJECT

{ Now draw the sky, a distant rear wall }
OBJECT
   PLANE <0.0 0.0 1.0> -200.0 END_PLANE

   TEXTURE
      0.05
      COLOUR RED 1.0 GREEN 0.3
      AMBIENT 0.3
      DIFFUSE 0.7
   END_TEXTURE
   COLOUR RED 1.0 GREEN 0.3
END_OBJECT

{ Now to cast some light on the subject }
OBJECT
   SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
   TRANSLATE <0.0  30.0  -160.0>

   TEXTURE
     COLOUR RED 1.0 GREEN 0.6
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE

   LIGHT_SOURCE
   COLOUR RED 1.0 GREEN 0.6
END_OBJECT
</textarea>

<!-- Sample file : tcubic.dat -->

<textarea id="tcubic.dat" name="tcubic.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ Cubic curve - can make a nice teardrop by cleverly adding a clipping plane }
OBJECT
   INTERSECTION
     QUARTIC
     < 0.0   0.0   0.0   -0.5  0.0   0.0   0.0   0.0   0.0 -0.5
       0.0   0.0   0.0    0.0  0.0   0.0   0.0   0.0   0.0  0.0
       0.0   0.0   0.0    0.0  0.0   1.0   0.0   0.0   0.0  0.0
       0.0   0.0   1.0    0.0  0.0 >
       TEXTURE
         COLOR Red
	 PHONG 1.0
	 DIFFUSE 0.8
	 AMBIENT 0.2
       END_TEXTURE
     END_QUARTIC
     SPHERE <0 0 0> 2
       TEXTURE
         COLOR Clear
       END_TEXTURE
     END_SPHERE
   END_INTERSECTION
   BOUNDED_BY
     SPHERE <0 0 0> 2.2 END_SPHERE
   END_BOUND
   ROTATE <0 20 0>
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -5.0>
   DIRECTION <0.0  0.0  1.0>
   UP        <0.0  1.0  0.0>
   RIGHT     <1.33 0.0  0.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : tetra.dat -->

<textarea id="tetra.dat" name="tetra.dat" style="display:none;">
INCLUDE "shapes.dat"		  {Includes New "Tetrahedron" Primitive}
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
        LOCATION <0.0 30.0 -200.0>
        DIRECTION <0.0 -0.15 1.0>
        UP <0.0 1.0 0.0>
        RIGHT <1.333 0.0 0.0>
END_VIEW_POINT

DECLARE Tetra = OBJECT
  INTERSECTION Tetrahedron END_INTERSECTION

  TEXTURE
    0.01
    COLOUR Gold
    AMBIENT 0.3
    DIFFUSE 0.7
    REFLECTION 0.4
    BRILLIANCE 6.0
  END_TEXTURE
  COLOUR Gold
END_OBJECT

OBJECT Tetra
 SCALE <10.0 10.0 10.0>
 ROTATE <0.0 -45.0 0.0>
 TRANSLATE <-10.0 0.0 -105.0>
END_OBJECT

OBJECT Tetra
 SCALE <10.0 10.0 10.0>
 ROTATE <0.0 -40.0 0.0>
 TRANSLATE <75.0 0.0 50.0>
END_OBJECT

OBJECT Tetra
 SCALE <10.0 10.0 10.0>
 ROTATE <0.0 30.0 0.0>
 TRANSLATE <-60.0 0.0 -50.0>
END_OBJECT

OBJECT Tetra
 SCALE <10.0 10.0 10.0>
 ROTATE <0.0 -75.0 0.0>
 TRANSLATE <60.0 0.0 -65.0>
END_OBJECT

OBJECT
   SPHERE <-50.0 50.0 100.0> 100.0 END_SPHERE
   TEXTURE
     0.01
     COLOUR White
     AMBIENT 0.05
     DIFFUSE 0.1
     REFLECTION 0.97
     BRILLIANCE 4.0
   END_TEXTURE
   COLOUR White
END_OBJECT

OBJECT
  PLANE <0.0 1.0 0.0> -50.0 END_PLANE
  TEXTURE
   0.01
   CHECKER COLOUR Blue COLOUR Gray
   SCALE <40.0 40.0 40.0>
   AMBIENT 0.3
   DIFFUSE 0.7
   REFLECTION 0.1
   BRILLIANCE 3.0
  END_TEXTURE
  COLOUR Blue
END_OBJECT

OBJECT
  PLANE <0.0 1.0 0.0> 500.0 END_PLANE
  TEXTURE
    0.05
    Cloud_Sky
    SCALE <200.0 50.0 100.0>
    AMBIENT 0.7
    DIFFUSE 0.0
  END_TEXTURE
  COLOUR RED 0.5 GREEN 0.5 BLUE 0.8
END_OBJECT

OBJECT
  SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
  TRANSLATE <60.0 60.0 -200.0>
  TEXTURE
    COLOUR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT

OBJECT
  SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE
  TRANSLATE <-60.0 60.0 -200.0>
  TEXTURE
    COLOUR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : tomb.dat -->

<textarea id="tomb.dat" name="tomb.dat" style="display:none;">

{ Title-"Tomb" }

{ -+ Compuserve Hall Of Fame award winner +- }

{ A haunted tomb on a hill, gravestones, rusty fence, pumpkin patch. }
{ - Drew Wells CIS 73767,1244 }
{ 11/29/90 }


{ This file is for use with DKBTrace by David Buck
  and is released into the public domain. }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"


{ Camera }
VIEW_POINT
   DIRECTION <0.0 0.0  1.5>
   UP  <0.0  1.0  0.0>
   RIGHT <-1.333 0.0 0.0>
   TRANSLATE < -15.0  5.0  120.0>
   LOOK_AT <10.0 12.0 55.0>
END_VIEW_POINT

DECLARE Yellow_Clouds = TEXTURE
      0.05
       BOZO
       TURBULENCE 0.6
       COLOUR_MAP
          [0.0 0.5   COLOUR RED 0.9 GREEN 0.5  BLUE 0.3
                     COLOUR RED 0.4 GREEN 0.4  BLUE 0.0]  
          [0.5 0.6   COLOUR RED 1.0 GREEN 1.0  BLUE 1.0 ALPHA 1.0
                     COLOUR RED 1.0 GREEN 1.0  BLUE 1.0 ALPHA 1.0 ]
          [0.6 1.001 COLOUR RED 1.0 GREEN 1.0  BLUE 1.0 ALPHA 1.0
                     COLOUR RED 1.0 GREEN 1.0  BLUE 1.0 ALPHA 1.0]
       END_COLOUR_MAP
END_TEXTURE

DECLARE Sunset_Sky = TEXTURE
      0.05
       GRADIENT <0.0 1.0 0.0>
       
       COLOUR_MAP
          [0.0 0.4  {blue}
                    COLOUR RED 0.8 GREEN 0.0 BLUE 0.0
                    COLOUR RED 0.4 GREEN 0.0 BLUE 0.4]
          
          [0.4 0.6  COLOUR RED 0.4 GREEN 0.0 BLUE 0.4
                    {white}
                    COLOUR RED 0.0 GREEN 0.0 BLUE 0.2]
          [0.6 1.001 COLOUR RED 0.0 GREEN 0.0 BLUE 0.2
                    {grey}
                    COLOUR RED 0.0 GREEN 0.0 BLUE 0.0]
       END_COLOUR_MAP
       SCALE <700.0 700.0 700.0>
END_TEXTURE

DECLARE Moss = TEXTURE
    MARBLE
    TURBULENCE 0.62
    COLOUR_MAP
   [0.0 0.5  COLOUR RED 0.7 GREEN 0.7 BLUE 0.45
    COLOUR RED 0.7 GREEN 0.65 BLUE 0.35]
   [0.5 0.55 COLOUR RED 0.55 GREEN 0.7 BLUE 0.45
    COLOUR RED 0.45 GREEN 0.60 BLUE 0.35]
   [0.55 0.6 COLOUR RED 0.0 GREEN 0.50 BLUE 0.20
    COLOUR RED 0.5 GREEN 0.6 BLUE 0.35]
   [0.6 0.7  COLOUR RED 0.5 GREEN 0.6 BLUE 0.35
    COLOUR RED 0.05 GREEN 0.35 BLUE 0.05]
   [0.7 0.8  COLOUR RED 0.05 GREEN 0.35 BLUE 0.05
    COLOUR RED 0.20 GREEN 0.30 BLUE 0.0]
   [0.8 0.9  COLOUR RED 0.20 GREEN 0.30 BLUE 0.0
    COLOUR RED 0.20 GREEN 0.50 BLUE 0.0]
   [0.9 1.001  COLOUR RED 0.20 GREEN 0.50 BLUE 0.00
    COLOUR RED 0.20 GREEN 0.30 BLUE 0.0]
    END_COLOUR_MAP
    SCALE <1.7 1.7 1.7>
END_TEXTURE


{***********************************************}
{ Define objects for use in scene               }
{***********************************************}

DECLARE Cross =
  OBJECT
    UNION
    { Tried to make celtic cross, but vga resolution is too coarse }
    { INTERSECTION
     QUADRIC Cylinder_Z
        SCALE <0.4 0.4 0.4>
        TRANSLATE <0.0 0.45 0.0>
     END_QUADRIC
     PLANE <0.0 0.0 -1.0>  0.02 END_PLANE
     PLANE <0.0  0.0 1.0> 0.02 END_PLANE
     END_INTERSECTION }

     {vertical part}
     INTERSECTION
      {top & bottom}
      PLANE <0.0 1.0 0.0> 1.0 END_PLANE
      PLANE <0.0 -1.0 0.0> 2.0 END_PLANE
      {front & back}
      PLANE <0.0 0.0 1.0> 0.12 END_PLANE
      PLANE <0.0 0.0 -1.0> 0.12 END_PLANE
      {left & right}
      PLANE <1.0 0.0 0.0> 0.15 END_PLANE
      PLANE <-1.0 0.0 0.0> 0.15 END_PLANE
     END_INTERSECTION
 
     {horizontal part}
     INTERSECTION
      {top & bottom}
      PLANE <0.0 1.0 0.0> 0.6 END_PLANE
      PLANE <0.0 -1.0 0.0> -0.3 END_PLANE
      {front & back}
      PLANE <0.0 0.0 1.0> 0.12 END_PLANE
      PLANE <0.0 0.0 -1.0> 0.12 END_PLANE
      {left & right walls}
      PLANE <1.0 0.0 0.0> 0.7 END_PLANE
      PLANE <-1.0 0.0 0.0> 0.7 END_PLANE
     END_INTERSECTION
    END_UNION
    BOUNDED_BY
     INTERSECTION
      PLANE <0.0 1.0 0.0> 1.1 END_PLANE
      PLANE <0.0 -1.0 0.0> 2.1 END_PLANE
      PLANE <0.0 0.0 1.0> 0.2 END_PLANE
      PLANE <0.0 0.0 -1.0> 0.2 END_PLANE
      PLANE <1.0 0.0 0.0> 0.8 END_PLANE
      PLANE <-1.0 0.0 0.0> 0.8 END_PLANE
     END_INTERSECTION
    END_BOUND
    TEXTURE
      GRANITE
      SCALE <0.1 0.1 0.1>
      AMBIENT 0.1
      DIFFUSE 0.9   
    END_TEXTURE
    COLOUR Blue
END_OBJECT

DECLARE Headstone =
  OBJECT
    UNION
     INTERSECTION      
       QUADRIC Cylinder_Z END_QUADRIC
       PLANE <0.0 0.0 -1.0>  0.1 END_PLANE
       PLANE <0.0  0.0 1.0> 0.1 END_PLANE
     END_INTERSECTION      
     INTERSECTION
       {top & bottom} 
       PLANE <0.0 1.0 0.0> 0.0 END_PLANE
       PLANE <0.0 -1.0 0.0> 2.0 END_PLANE
       {front & back}
       PLANE <0.0 0.0 1.0> 0.1 END_PLANE
       PLANE <0.0 0.0 -1.0> 0.1 END_PLANE
       {left & right }
       PLANE <1.0 0.0 0.0> 1.0 END_PLANE
       PLANE <-1.0 0.0 0.0> 1.0 END_PLANE
     END_INTERSECTION
    END_UNION
    TEXTURE 
      GRANITE 
      SCALE<0.1 0.2 0.1>
      AMBIENT 0.1
      DIFFUSE 0.9   
    END_TEXTURE
   COLOUR Blue
END_OBJECT

DECLARE Beam = QUADRIC Cylinder_Y
    SCALE <1.0 1.0 1.0>
END_QUADRIC

DECLARE Beam2 = QUADRIC Cylinder_Y
     INVERSE
     SCALE <0.5 1.0 0.5>
    TRANSLATE <1.4 0.0 0.0>
END_QUADRIC

DECLARE Beam3 =
  OBJECT
   INTERSECTION
     QUADRIC Beam  SCALE <1.2 1.0 1.2> END_QUADRIC
     QUADRIC Beam2 END_QUADRIC
     QUADRIC Beam2 ROTATE <0.0  -45.0 0.0> END_QUADRIC
     QUADRIC Beam2 ROTATE <0.0  -90.0 0.0> END_QUADRIC
     QUADRIC Beam2 ROTATE <0.0 -135.0 0.0> END_QUADRIC
     QUADRIC Beam2 ROTATE <0.0  180.0 0.0> END_QUADRIC
     QUADRIC Beam2 ROTATE <0.0   45.0 0.0> END_QUADRIC
     QUADRIC Beam2 ROTATE <0.0   90.0 0.0> END_QUADRIC
     QUADRIC Beam2 ROTATE <0.0  135.0 0.0> END_QUADRIC
     PLANE <0.0 1.0 0.0> 8.0 END_PLANE
     PLANE <0.0 -1.0 0.0> 0.0 END_PLANE
   END_INTERSECTION
   { Blue marble was modified to look like green moss/mold }
   TEXTURE
     Moss
     AMBIENT 0.1
     DIFFUSE 0.99
   END_TEXTURE
   COLOUR RED 0.8 GREEN 0.0 BLUE 0.0
END_OBJECT

DECLARE Pole = QUADRIC Cylinder_Y
   SCALE <0.1 1.0 0.1>
END_QUADRIC

     
DECLARE Xpole = QUADRIC Cylinder_X
   SCALE <0.1 0.1 0.1>
END_QUADRIC

{ Rusty iron gate & fence - object should have been composite to avoid the }
{                           "carved from one piece" look. }
DECLARE Gate = OBJECT
  UNION
   INTERSECTION
     QUADRIC Xpole  END_QUADRIC
     PLANE <1.0 0.0 0.0> 8.0 END_PLANE
     PLANE <-1.0 0.0 0.0> 2.0 END_PLANE
     TRANSLATE <0.0 6.5 0.0>
   END_INTERSECTION
   INTERSECTION
     QUADRIC Xpole  END_QUADRIC
     PLANE <1.0 0.0 0.0> 8.0 END_PLANE
     PLANE <-1.0 0.0 0.0> 2.0 END_PLANE
     TRANSLATE <0.0 1.9 0.0>
   END_INTERSECTION
   INTERSECTION
     QUADRIC Pole  END_QUADRIC
     PLANE <0.0 1.0 0.0> 7.5 END_PLANE
     PLANE <0.0 -1.0 0.0> 0.0 END_PLANE
     TRANSLATE <1.0 0.0 0.2>
   END_INTERSECTION
   SPHERE <1.0 7.5 0.0> 0.3 END_SPHERE
   INTERSECTION
     QUADRIC Pole END_QUADRIC
     PLANE <0.0 1.0 0.0> 7.75 END_PLANE
     PLANE <0.0 -1.0 0.0> 0.2 END_PLANE
     TRANSLATE <2.5 0.0 0.0>
   END_INTERSECTION
   SPHERE <2.5 7.75 0.0> 0.3 END_SPHERE
   INTERSECTION
     QUADRIC Pole END_QUADRIC
     PLANE <0.0 1.0 0.0> 8.0 END_PLANE
     PLANE <0.0 -1.0 0.0> 0.2 END_PLANE
     TRANSLATE <4.0 0.0 0.0>
   END_INTERSECTION
   SPHERE <4.0 8.0 0.0> 0.3 END_SPHERE
   INTERSECTION
     QUADRIC Pole  END_QUADRIC
     PLANE <0.0 1.0 0.0> 7.75 END_PLANE
     PLANE <0.0 -1.0 0.0> 0.2 END_PLANE
     TRANSLATE<5.5 0.0 0.0>
   END_INTERSECTION
   SPHERE <5.5 7.75 0.0> 0.3 END_SPHERE
   INTERSECTION
     QUADRIC Pole END_QUADRIC
     PLANE <0.0 1.0 0.0> 7.5 END_PLANE
     PLANE <0.0 -1.0 0.0> 0.2 END_PLANE
     TRANSLATE <7.0 0.0 0.0>
   END_INTERSECTION
   SPHERE <7.0 7.5 0.0> 0.3 END_SPHERE
  END_UNION
  BOUNDED_BY
   INTERSECTION
      PLANE <0.0 1.0 0.0> 9.0 END_PLANE
      PLANE <0.0 -1.0 0.0> 0.0 END_PLANE
      PLANE <0.0 0.0 1.0> 1.0 END_PLANE
      PLANE <0.0 0.0 -1.0> 1.0 END_PLANE
      PLANE <1.0 0.0 0.0> 8.0 END_PLANE
      PLANE <-1.0 0.0 0.0> 0.0 END_PLANE
   END_INTERSECTION
  END_BOUND
  TEXTURE 
    0.05
    Iron 
    AMBIENT 0.4
    DIFFUSE 0.99   
  END_TEXTURE 
  COLOUR Blue
END_OBJECT

{ A rectangular pad to serve as a footing for the column }
DECLARE BasePad =
   OBJECT
   INTERSECTION
      PLANE <0.0 1.0 0.0> 0.25 END_PLANE
      PLANE <0.0 -1.0 0.0> 0.25 END_PLANE
      PLANE <0.0 0.0 1.0> 1.2 END_PLANE
      PLANE <0.0 0.0 -1.0> 1.2 END_PLANE
      PLANE <1.0 0.0 0.0> 1.2 END_PLANE
      PLANE <-1.0 0.0 0.0> 1.2 END_PLANE
   END_INTERSECTION

   TEXTURE
     Moss
     SCALE <0.8 0.3 1.0>
     AMBIENT 0.1
     DIFFUSE 0.9
   END_TEXTURE
   COLOUR RED 0.6 GREEN 0.6 BLUE 0.4
END_OBJECT

DECLARE Column = COMPOSITE
   OBJECT Beam3   TRANSLATE <0.0 0.0 0.0> END_OBJECT
   OBJECT BasePad TRANSLATE <0.0 1.0 0.0> END_OBJECT
   OBJECT BasePad TRANSLATE <0.0 8.0 0.0> END_OBJECT
END_COMPOSITE

DECLARE Tomb = OBJECT
  UNION
   { Main structure }
   INTERSECTION
      {ceiling and floor}
      PLANE <0.0 1.0 0.0> 10.0 END_PLANE
      PLANE <0.0 -1.0 0.0> 6.0 END_PLANE
      {front and back walls}
      PLANE <0.0 0.0 1.0> 7.5 END_PLANE
      PLANE <0.0 0.0 -1.0> 7.5 END_PLANE
      {left & right walls}
      PLANE <1.0 0.0 0.0> 10.0 END_PLANE
      PLANE <-1.0 0.0 0.0> 10.0 END_PLANE
      {doorway}
      INTERSECTION
        {ceiling and floor} 
        PLANE <0.0 1.0 0.0> 7.0 END_PLANE
        PLANE <0.0 -1.0 0.0> 6.0 END_PLANE
        {front and back walls}
        PLANE <0.0 0.0 1.0> 17.5 END_PLANE
        PLANE <0.0 0.0 -1.0> 7.0 END_PLANE
        {left & right walls}
        PLANE <1.0 0.0 0.0> 3.0 END_PLANE
        PLANE <-1.0 0.0 0.0> 3.0 END_PLANE
        INVERSE 
      END_INTERSECTION
   END_INTERSECTION
   { Foundation }
   INTERSECTION
      {top & bottom}
      PLANE <0.0 1.0 0.0> -1.0 END_PLANE
      PLANE <0.0 -1.0 0.0> 5.0 END_PLANE
      {front & back}
      PLANE <0.0 0.0 1.0> 8.5 END_PLANE
      PLANE <0.0 0.0 -1.0> 8.5 END_PLANE
      {left & right}
      PLANE <1.0 0.0 0.0> 11.0 END_PLANE
      PLANE <-1.0 0.0 0.0> 11.0 END_PLANE
   END_INTERSECTION
  END_UNION
  BOUNDED_BY
   SPHERE <0.0 0.0 0.0> 18.0 END_SPHERE
  END_BOUND
  TEXTURE
       GRANITE
       BUMPS 0.8
       SCALE < 0.5 0.1 1.0>
       AMBIENT 0.1
       DIFFUSE 0.9
  END_TEXTURE
  COLOUR Blue
END_OBJECT

DECLARE InnerBeams = OBJECT
   UNION
    INTERSECTION
     QUADRIC Beam END_QUADRIC
     PLANE <0.0 1.0 0.0> 8.0 END_PLANE
     PLANE <0.0 -1.0 0.0> 2.0 END_PLANE
     TRANSLATE < 5.0 0.0 7.5>
    END_INTERSECTION
    INTERSECTION
     QUADRIC Beam END_QUADRIC
     PLANE <0.0 1.0 0.0> 8.0 END_PLANE
     PLANE <0.0 -1.0 0.0> 2.0 END_PLANE
     TRANSLATE < -5.0 0.0 7.5>
    END_INTERSECTION
   END_UNION
   TEXTURE
      GRANITE
      BUMPS 0.5
      SCALE < 0.5 0.6 1.0>
      AMBIENT 0.10
      DIFFUSE 0.9
   END_TEXTURE
   COLOUR Blue
END_OBJECT

DECLARE Pointy = OBJECT
   UNION
    {pointy part}
    INTERSECTION
      PLANE <0.0 -1.0 0.0> 1.0 END_PLANE
      PLANE <0.0 0.0 1.0> 0.5 END_PLANE
      PLANE <0.0 0.0 -1.0> 0.5 END_PLANE
      PLANE <1.0 0.0 0.0> 0.0 ROTATE <0.0 0.0 70.0> END_PLANE
      PLANE <-1.0 0.0 0.0> 0.0 ROTATE <0.0 0.0 -70.0> END_PLANE
      SCALE <3.0 4.0 1.0>
      TRANSLATE < 0.0 12.0 7.5>
    END_INTERSECTION
   END_UNION
   TEXTURE
      GRANITE
      BUMPS 0.5
      SCALE < 0.7 0.5 0.33>
      AMBIENT 0.10
      DIFFUSE 0.9
   END_TEXTURE
   COLOUR Blue
END_OBJECT

DECLARE CornerBeams = OBJECT
  UNION
    INTERSECTION
      QUADRIC Beam SCALE <1.5 1.0 1.5>END_QUADRIC
      PLANE <0.0 1.0 0.0> 10.0 END_PLANE
      PLANE <0.0 -1.0 0.0> 2.0 END_PLANE
      TRANSLATE < 10.0 0.0 7.5>
    END_INTERSECTION
    INTERSECTION      
      QUADRIC Beam SCALE <1.5 1.0 1.5> END_QUADRIC
      PLANE <0.0 1.0 0.0> 10.0 END_PLANE
      PLANE <0.0 -1.0 0.0> 2.0 END_PLANE
      TRANSLATE < -10.0 0.0 7.5>
    END_INTERSECTION
    SPHERE < -10.0 10.0 7.5> 1.5 END_SPHERE
    SPHERE <  10.0 10.0 7.5> 1.5 END_SPHERE
  END_UNION
  TEXTURE
      GRANITE
      BUMPS 0.5
      SCALE < 0.3 0.1 1.0>
      AMBIENT 0.10
      DIFFUSE 0.9
  END_TEXTURE
  COLOUR Blue
END_OBJECT

{ Ghost in tomb doorway }
DECLARE Figure = OBJECT
  INTERSECTION
     QUADRIC Beam SCALE <2.3 1.0 2.3> END_QUADRIC
     PLANE <0.0 1.0 0.0> 8.0 END_PLANE
     PLANE <0.0 -1.0 0.0> 2.0 END_PLANE
     TRANSLATE < 0.0 0.0 4.3>
  END_INTERSECTION
  TEXTURE
     GRANITE
     { Use any ghost image you like for the tomb doorway or comment }
     { out the Figure in TombAll }
     {IMAGEMAP <-1.0 1.0 0.0> GIF "ghost.gif" ONCE}
     SCALE < 6.5 8.0 6.5 >
     TRANSLATE < -1.0 7.5 4.3 >
     AMBIENT 0.10
     DIFFUSE 0.3
   END_TEXTURE
   COLOUR Blue
END_OBJECT

{ TombAll is the completed tomb }
DECLARE TombAll = COMPOSITE
   OBJECT Tomb END_OBJECT
   OBJECT InnerBeams END_OBJECT
   OBJECT Pointy END_OBJECT
   OBJECT CornerBeams END_OBJECT
   OBJECT Figure END_OBJECT
END_COMPOSITE

{ Pumpkin parts }
DECLARE Stem = OBJECT
  INTERSECTION
    QUADRIC Pole  END_QUADRIC
    PLANE <0.0 1.0 0.0> 0.04 ROTATE <0.0 -10.0 -10.0> END_PLANE
    PLANE <0.0 -1.0 0.0> 1.0 END_PLANE
    TRANSLATE<0.0 0.3 0.0>
  END_INTERSECTION
  TEXTURE
    BUMPS 0.5
    COLOR RED 0.04 GREEN 0.33 BLUE 0.05
    SCALE < 0.2 0.2 0.2>
    AMBIENT 0.1
    DIFFUSE 0.9   
  END_TEXTURE
  COLOR RED 0.04 GREEN 0.33 BLUE 0.05
END_OBJECT

DECLARE Slice = QUADRIC
  Sphere
  TRANSLATE <0.0 0.0 0.5>
  SCALE <0.28 0.30 0.40>
END_QUADRIC

DECLARE Pumpkin = OBJECT
  UNION
    QUADRIC Slice END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -20.0  0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -40.0  0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -60.0  0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -80.0  0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -100.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -120.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -140.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -160.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -180.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -200.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -220.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -240.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -260.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -280.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -300.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -320.0 0.0> END_QUADRIC
    QUADRIC Slice ROTATE <0.0 -340.0 0.0> END_QUADRIC
  END_UNION
  BOUNDED_BY
      QUADRIC Sphere SCALE <1.5 1.5 1.5> END_QUADRIC
  END_BOUND
  TEXTURE
    BUMPS 0.3
    COLOR RED 0.5 GREEN 0.22 BLUE 0.1
    SCALE < 0.1 0.1 0.1>
    AMBIENT 0.1
    DIFFUSE 0.9
    PHONG 0.75
    PHONGSIZE 30.0
  END_TEXTURE
  COLOR RED 0.5 GREEN 0.22 BLUE 0.1
END_OBJECT


{*****************************************}
{ Scene description     }
{*****************************************}

OBJECT
   Cross
   SCALE <1.7 2.0 1.0>
   ROTATE <-15.0 0.0 0.0>
   TRANSLATE <-16.0 7.7 61.5>    
END_OBJECT

OBJECT
   Headstone
   SCALE <1.0 1.0 1.0>
   ROTATE <15.0 0.0 0.0>
   TRANSLATE <-14.0 4.0 76.0>
END_OBJECT

OBJECT
   Headstone
   SCALE <1.0 1.0 1.0>
   TRANSLATE <12.0 4.0 74.0>
END_OBJECT

OBJECT
   Headstone
   SCALE <1.0 1.0 1.0>
   ROTATE <-10.0 0.0 0.0>
   TRANSLATE <18.0 8.0 70.0>
END_OBJECT

OBJECT
   Cross
   SCALE <1.5 2.0 1.0>
   ROTATE <-15.0 0.0 0.0>
   TRANSLATE <17.0 10.0 60.0>
END_OBJECT

OBJECT
   Cross
   SCALE <1.5 2.0 1.0>
   ROTATE <-15.0 0.0 20.0>
   TRANSLATE <26.0 10.0 70.0>
END_OBJECT

OBJECT
   Cross
   SCALE <1.5 2.0 1.0>
   ROTATE <-15.0 0.0 -10.0>
   TRANSLATE <31.0 10.0 78.0>
END_OBJECT


{ Little Pumpkin Patch }
OBJECT
   Pumpkin
   SCALE <1.5 2.0 1.5>
   TRANSLATE < 5.0 1.55 95.0>
END_OBJECT
OBJECT
   Stem
   SCALE <1.5 2.5 1.5>
   TRANSLATE < 5.0 1.55 95.0>
END_OBJECT
OBJECT
   Pumpkin
   SCALE <1.5 2.5 1.5>
   TRANSLATE < 11.0 1.6 90.0>
END_OBJECT
OBJECT
   Stem
   SCALE <1.5 2.5 1.5>
   TRANSLATE < 11.0 1.6 90.0>
END_OBJECT


{ Ghastly Tomb!}
COMPOSITE
   TombAll
   ROTATE <15.0 15.0 0.0>
   TRANSLATE <0.0 10.0 58.0>
END_COMPOSITE

{left entry gate}
OBJECT
   Gate
   TRANSLATE <-9.0 0.0 88.0>
END_OBJECT

{right entry gate}
OBJECT
   Gate
   ROTATE <-10.0 -160.0 0.0>
   TRANSLATE <7.0 0.0 87.5>
END_OBJECT

{Use gate object to make left & right fence}
OBJECT
   Gate
   TRANSLATE <-19.0 0.0 88.0>
END_OBJECT
OBJECT
   Gate
   TRANSLATE <-31.0 0.0 88.0>
END_OBJECT
OBJECT
   Gate
   TRANSLATE <9.0 0.0 88.0>
END_OBJECT
OBJECT
   Gate
   TRANSLATE <19.0 0.0 88.0>
END_OBJECT

{ Columns to hold the fence and gates up }
COMPOSITE Column TRANSLATE <-20.0 0.0 88.0> END_COMPOSITE
COMPOSITE Column TRANSLATE <-10.0 0.0 88.0> END_COMPOSITE
COMPOSITE Column TRANSLATE < 8.0 0.0 88.0> END_COMPOSITE
COMPOSITE Column TRANSLATE < 18.0 0.0 88.0> END_COMPOSITE

{hill under tomb}
OBJECT
    QUADRIC Paraboloid_Y
      SCALE<40.0 10.0 77.0>
    END_QUADRIC
    ROTATE <0.0 0.0 180.0>
    TRANSLATE <0.0 21.0 -28.0>
    TEXTURE
      BUMPS 0.8
      COLOR RED 0.5 GREEN 0.6 BLUE 0.2
      SCALE < 5.0 5.0 5.0>
      AMBIENT 0.1
      DIFFUSE 0.7    
    END_TEXTURE                                      
    COLOR RED 0.5 GREEN 0.6 BLUE 0.2
END_OBJECT

{hill to right of tomb}
OBJECT
    QUADRIC Paraboloid_Y
      SCALE<30.0 10.0 40.0>
    END_QUADRIC
    ROTATE <0.0 0.0 180.0>
    TRANSLATE <40.0 14.0 50.0>
    TEXTURE
      BUMPS 0.8
      COLOR RED 0.6 GREEN 0.6 BLUE 0.1
      SCALE < 7.0 5.0 5.0>
      AMBIENT 0.1
      DIFFUSE 0.7
    END_TEXTURE
    COLOR RED 0.6 GREEN 0.6 BLUE 0.1
END_OBJECT

{ Ground }
OBJECT
    PLANE <0.0 1.0 0.0> 1.0 END_PLANE
    TEXTURE
      BUMPS 0.7
      COLOR RED 0.6 GREEN 0.6 BLUE 0.1
      SCALE < 1.0 1.0 1.0>
      AMBIENT 0.1
      DIFFUSE 0.7
    END_TEXTURE
    COLOR RED 0.6 GREEN 0.6 BLUE 0.1
END_OBJECT

{The Sun}
OBJECT
  SPHERE <0.0 0.0 0.0> 150.0 END_SPHERE
  TRANSLATE <150.0 30.0 1200.0>
  TEXTURE
    COLOR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
  LIGHT_SOURCE
  COLOR White
END_OBJECT

{ Sky - gradient sunset}
OBJECT
  SPHERE <0.0 0.0 0.0> 2000.0 INVERSE END_SPHERE
   TEXTURE
     Sunset_Sky
     TRANSLATE <0.0 200.0 0.0>
     SCALE <1.2 1.2 1.2>
     AMBIENT 0.6
     DIFFUSE 0.0
   END_TEXTURE
   COLOR Green
END_OBJECT

{ Clouds - uses a sky texture with the sky portion defined as transparent }
{          so the gradient behind it is visible  }
OBJECT
   SPHERE <0.0 0.0 0.0> 1997.0 INVERSE END_SPHERE
   TEXTURE
    Yellow_Clouds
    SCALE <1000.0 30.0 100.0>
    AMBIENT 0.6
    DIFFUSE 0.0
   END_TEXTURE
   COLOR Green
END_OBJECT
</textarea>

<!-- Sample file : torus.dat -->

<textarea id="torus.dat" name="torus.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ Torus having major radius sqrt(40), minor radius sqrt(12) }
OBJECT
   QUARTIC
   < 1.0   0.0   0.0    0.0     2.0   0.0   0.0   2.0   0.0 -104.0
     0.0   0.0   0.0    0.0     0.0   0.0   0.0   0.0   0.0    0.0
     1.0   0.0   0.0    2.0     0.0  56.0   0.0   0.0   0.0    0.0
     1.0   0.0 -104.0   0.0   784.0 >
   END_QUARTIC
   BOUNDED_BY
   SPHERE <0 0 0> 10 END_SPHERE
   END_BOUND
   TEXTURE
     COLOR Red
     PHONG 1.0
     PHONGSIZE 10
     AMBIENT 0.2
     DIFFUSE 0.8
   END_TEXTURE
   ROTATE <-45 0 0>
   TRANSLATE <0 0 20>
   COLOR Red
END_OBJECT

{ Put down checkered floor }
OBJECT
   PLANE <0.0  1.0  0.0> -20.0 END_PLANE
   TEXTURE
      CHECKER COLOUR NavyBlue COLOUR MidnightBlue
      SCALE < 20.0 20.0 20.0 >
      AMBIENT 0.8
      DIFFUSE 0.2
   END_TEXTURE
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  2.0 -10.0>
   LOOK_AT   <0.0  0.0   0.0>
   UP        <0.0  1.0   0.0>
   RIGHT     <1.33 0.0   0.0>
END_VIEW_POINT

OBJECT
   SPHERE<0.0 0.0 0.0> 1 END_SPHERE
   TRANSLATE <50 100 0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 0.0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : trough.dat -->

<textarea id="trough.dat" name="trough.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"

DECLARE Quartic_Saddle =
   QUARTIC
   < 0.0   0.0   0.0   0.0  0.0   0.0   0.0   4.0   0.0  0.0
     0.0   0.0   0.0   0.0  0.0   0.0   0.0   0.0   0.0  0.0
     0.0   0.0   0.0   0.0  0.0   0.0   0.0   0.0   0.0 -1.0
     0.0   0.0   0.0   0.0  0.0 >
   END_QUARTIC

DECLARE Unit_Cube =
   INTERSECTION
      PLANE < 1  0  0> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE <-1  0  0> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0  1  0> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0 -1  0> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0  0  1> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
      PLANE < 0  0 -1> 1 TEXTURE COLOR Clear END_TEXTURE END_PLANE
   END_INTERSECTION

{ Crossed Trough }
OBJECT
   INTERSECTION
     QUARTIC Quartic_Saddle
       TEXTURE
         COLOR Red
	 SPECULAR 0.8
	 ROUGHNESS 0.005
	 AMBIENT 0.3
	 DIFFUSE 0.6
       END_TEXTURE
     END_QUARTIC
     INTERSECTION Unit_Cube END_INTERSECTION
   END_INTERSECTION
   BOUNDED_BY
     INTERSECTION Unit_Cube SCALE <1.5 1.5 1.5> END_INTERSECTION
   END_BOUND
   SCALE <2 2 2> 
   ROTATE <0 -10 0>
   ROTATE <-60 0 0>
   TRANSLATE <0 0 4>
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -4.0>
   RIGHT     <1.33 0.0  0.0>
   UP        <0.0  1.0  0.0>
   DIRECTION <0.0  0.0  1.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

</textarea>

<!-- Sample file : waterbow.dat -->

<textarea id="waterbow.dat" name="waterbow.dat" style="display:none;">
INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

VIEW_POINT
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.333 0.0 0.0>
   TRANSLATE <0.0 0.0 -56.0>
END_VIEW_POINT

OBJECT
   INTERSECTION
      SPHERE <0.0 0.0 0.0> 1.0 END_SPHERE
      SPHERE <0.0 0.0 0.0> 0.9 END_SPHERE
      PLANE  <0.0 1.0 0.0> 0.5 END_PLANE
   END_INTERSECTION
   BOUNDED_BY
      SPHERE <0.0 0.0 0.0> 21.0 END_SPHERE
   END_BOUND
   SCALE < 20.0 20.0 20.0 >
   TEXTURE
      0.05
      COLOUR Red
      AMBIENT 0.3
      DIFFUSE 0.8
      REFLECTION 0.1
   END_TEXTURE
   COLOUR Red
END_OBJECT

OBJECT
   INTERSECTION
      SPHERE <0.0 0.0 0.0> 1.0 END_SPHERE
      PLANE <0.0 1.0 0.0> 0.49 END_PLANE
   END_INTERSECTION
   BOUNDED_BY
      SPHERE <0.0 0.0 0.0> 21.0 END_SPHERE
   END_BOUND
   SCALE < 19.5 19.5 19.5 >
   TEXTURE
       RIPPLES 0.5
       FREQUENCY 100.0
       SCALE <100.0 100.0 100.0>
       REFLECTION 0.6
       REFRACTION 0.6
       IOR 1.2
   END_TEXTURE
   COLOUR Grey
END_OBJECT


OBJECT
   PLANE <0.0 1.0 0.0> -20.0 END_PLANE

   TEXTURE
      0.05
      Tan_Wood
      ROTATE <-45.0 0.0 0.0>
      SCALE <15.0 8.0 8.0>
      AMBIENT 0.3
      DIFFUSE 0.8
      REFLECTION 0.1
   END_TEXTURE
   COLOUR Tan
END_OBJECT

OBJECT
   PLANE <0.0 0.0 1.0> 100.0 END_PLANE

   TEXTURE
      Red_Marble
      SCALE <100.0 100.0 100.0>
      AMBIENT 0.3
      DIFFUSE 0.8
      REFLECTION 0.1
   END_TEXTURE
   COLOR Pink
END_OBJECT

OBJECT
   PLANE <0.0 1.0 0.0> 150.0 END_PLANE

   TEXTURE
     COLOUR RED 0.5 GREEN 0.5 BLUE 1.0
     AMBIENT 0.3
     DIFFUSE 0.8
   END_TEXTURE
   COLOUR RED 0.5 GREEN 0.5 BLUE 1.0
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 0.0> 5.0 END_SPHERE

   TRANSLATE <100.0  120.0  -130.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : wealth.dat -->

<textarea id="wealth.dat" name="wealth.dat" style="display:none;">
{ WEALTH.DAT - Original DKB data file by Tom Price }

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"

VIEW_POINT
  LOCATION <0.0 75.0 -100.0>
  DIRECTION <0.0 -0.5 1.0>
  UP <0.0 1.0 0.0>
  RIGHT <1.333 0.0 0.0>
END_VIEW_POINT

OBJECT
  QUADRIC Plane_XZ TRANSLATE <0.0 -10.0 0.0> END_QUADRIC
  TEXTURE 0.05
    Dark_Wood
    SCALE <10.0 10.0 70.0>
    AMBIENT 0.8
    DIFFUSE 0.2
    REFLECTION 0.4
    BRILLIANCE 3.0
  END_TEXTURE
  COLOR Brown
END_OBJECT

OBJECT
 QUADRIC Plane_XZ TRANSLATE <0.0 200.0 0.0> END_QUADRIC
 TEXTURE
  COLOR BLUE 0.5 RED 0.2 GREEN 0.2
  AMBIENT 0.5
  DIFFUSE 0.5
 END_TEXTURE
END_OBJECT

DECLARE Coin = OBJECT
  INTERSECTION
   QUADRIC Cylinder_Y SCALE <20.0 1.0 20.0> END_QUADRIC
   QUADRIC Plane_XZ TRANSLATE <0.0 1.0 0.0> END_QUADRIC
   QUADRIC Plane_XZ TRANSLATE <0.0 -1.0 0.0> INVERSE END_QUADRIC
  END_INTERSECTION

  TEXTURE 0.05
    AMBIENT 0.5
    DIFFUSE 0.5
    COLOR RED 1.0 GREEN 0.89 BLUE 0.55
    REFLECTION 0.6
    BRILLIANCE 4.0
  END_TEXTURE
  COLOR RED 1.0 GREEN 0.89 BLUE 0.55
END_OBJECT

  OBJECT Coin
    ROTATE <-15.0 0.0 -2.0>
    TRANSLATE <-27.0 -2.0 -3.0>
  END_OBJECT

  OBJECT Coin
    ROTATE <-15.0 0.0 0.0>
    TRANSLATE <-28.0 3.0 2.0>
  END_OBJECT
  OBJECT Coin
    ROTATE <-15.0 0.0 0.0>
    TRANSLATE <-30.0 10.0 0.0>
  END_OBJECT
  OBJECT Coin
    ROTATE <-15.0 0.0 0.0>
    TRANSLATE <-29.0 20.0 -2.0>
  END_OBJECT
  OBJECT Coin
    ROTATE <-15.0 0.0 -10.0>
    TRANSLATE <-31.0 30.0 3.0>
  END_OBJECT
  OBJECT Coin
    ROTATE <-15.0 0.0 0.0>
    TRANSLATE <-26.0 40.0 5.0>
  END_OBJECT
  OBJECT Coin
    ROTATE <-25.0 0.0 15.0>
    TRANSLATE <-23.0 50.0 8.0>
  END_OBJECT

OBJECT
   QUADRIC Sphere SCALE <35.0 35.0 35.0> END_QUADRIC
    TRANSLATE <40.0 25.0 40.0>
    TEXTURE 0.05
      COLOR White
      AMBIENT 0.1
      DIFFUSE 0.3
      REFLECTION 1.0
      BRILLIANCE 5.0
    END_TEXTURE
    COLOR White
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE

   TRANSLATE <60.0 100.0 -110.0>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOR White
END_OBJECT

OBJECT
   SPHERE <0.0 0.0 0.0> 20.0 END_SPHERE

   TRANSLATE <-60.0 100.0 -110.0>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOR White
END_OBJECT
</textarea>

<!-- Sample file : window.dat -->

<textarea id="window.dat" name="window.dat" style="display:none;">
{ Window Highlighting DKB Scene by Aaron A. Collins }
{ This file is hereby released to the public domain. }

INCLUDE "shapes.dat"
INCLUDE "colors.dat"
INCLUDE "textures.dat"

{ Someone to take in the breathtaking view... }

VIEW_POINT
   LOCATION <0.0  20.0  -100.0>
   DIRECTION <0.0 0.0  1.0>
   UP  <0.0  1.0  0.0>
   RIGHT <1.33333 0.0 0.0>
END_VIEW_POINT

{ Put down the beloved famous raytrace green/yellow checkered floor }

OBJECT
   PLANE <0.0 1.0 0.0> -10.0 END_PLANE
   TEXTURE
      CHECKER COLOUR Yellow COLOUR Green
      SCALE < 20.0 20.0 20.0 >
      AMBIENT 0.1
      DIFFUSE 0.9
   END_TEXTURE
   COLOUR Yellow
END_OBJECT

{
 Now a Blue Plastic sphere floating in space over the ground - note that no 
 Phong or specular reflection is given.  Any would conflict with the window
 "highlights" by showing that they are not exactly in the mirror direction!
}

OBJECT
   SPHERE <0.0 25.0 0.0> 40.0 END_SPHERE
   TEXTURE
      COLOUR Blue
      REFLECTION 0.8
      AMBIENT 0.3
      DIFFUSE 0.7
   END_TEXTURE
   COLOUR Blue
END_OBJECT

{
 A wall with a window frame to block the light source and cast the shadows
}

OBJECT
  UNION
    TRIANGLE <-1000.0 -1000.0 0.0> <1000.0 4.0 0.0> <1000.0 -1000.0 0.0> END_TRIANGLE
    TRIANGLE <-1000.0 -1000.0 0.0> <1000.0 4.0 0.0> <-1000.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 4.0 0.0> <-1000.0 21.0 0.0> <-1000.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 4.0 0.0> <-1000.0 21.0 0.0> <4.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <-1000.0 21.0 0.0> <1000.0 1000.0 0.0> <-1000.0 1000.0 0.0> END_TRIANGLE
    TRIANGLE <-1000.0 21.0 0.0> <1000.0 1000.0 0.0> <1000.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <1000.0 4.0 0.0> <17.0 21.0 0.0> <1000.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <1000.0 4.0 0.0> <17.0 21.0 0.0> <17.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 12.0 0.0> <17.0 13.0 0.0> <4.0 13.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 12.0 0.0> <17.0 13.0 0.0> <17.0 12.0 0.0> END_TRIANGLE
    TRIANGLE <10.0 21.0 0.0> <11.0 4.0 0.0> <11.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <10.0 21.0 0.0> <11.0 4.0 0.0> <10.0 4.0 0.0> END_TRIANGLE
  END_UNION
  TRANSLATE <39.0 89.0 -120.0>
  TEXTURE
    COLOUR Black
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
END_OBJECT

{
  Now, the 4 actual "panes" to be reflected back onto the sphere for psuedo-
  "highlights".  They are not exactly co-incident with where the actual light
  source is, because they would block the light.  They are very near by where
  the openings are in the black wall above, close enough to give the proper
  illusion.  This is massive cheating, but then, this isn't reality, you see.
}

OBJECT
  UNION
    TRIANGLE <4.0 21.0 0.0> <10.0 13.0 0.0> <10.0 21.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 21.0 0.0> <10.0 13.0 0.0> <4.0 13.0 0.0> END_TRIANGLE

    TRIANGLE <11.0 21.0 0.0> <17.0 13.0 0.0> <11.0 13.0 0.0> END_TRIANGLE
    TRIANGLE <11.0 21.0 0.0> <17.0 13.0 0.0> <17.0 21.0 0.0> END_TRIANGLE

    TRIANGLE <4.0 12.0 0.0> <10.0 4.0 0.0> <4.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <4.0 12.0 0.0> <10.0 4.0 0.0> <10.0 12.0 0.0> END_TRIANGLE

    TRIANGLE <11.0 12.0 0.0> <17.0 4.0 0.0> <11.0 4.0 0.0> END_TRIANGLE
    TRIANGLE <11.0 12.0 0.0> <17.0 4.0 0.0> <17.0 12.0 0.0> END_TRIANGLE
  END_UNION
  SCALE <15.0 15.0 15.0>
  TRANSLATE <20.0 90.0 -100.0>
  TEXTURE
    COLOUR White
    AMBIENT 1.0
    DIFFUSE 0.0
  END_TEXTURE
END_OBJECT


{ A Light above the sphere, behind the camera and window frame for shadows }

OBJECT
   SPHERE <0.0 0.0 0.0> 0.001 END_SPHERE
   TRANSLATE <50.0 111.0 -130.0>
   TEXTURE
     COLOUR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

<!-- Sample file : witch.dat -->

<textarea id="witch.dat" name="witch.dat" style="display:none;">
{ DKB sample QUARTIC data file written by Alexander Enzmann }

INCLUDE "colors.dat"
INCLUDE "shapes.dat"
INCLUDE "textures.dat"

{ Witch of Agnesi }
OBJECT
   INTERSECTION
     QUARTIC
     < 0.0   0.0   0.0   0.0   0.0   0.0   1.0   0.0   0.0   0.0
       0.0   0.0   0.0   0.0   0.0   0.0   0.0   0.0   0.0   0.0
       0.0   0.0   0.0   0.0   0.0   0.0   0.0   1.0   0.0   0.04
       0.0   0.0   0.0   0.0   0.04 >
       TEXTURE
         COLOR Red
	 SPECULAR 1.0
         ROUGHNESS 0.05
         AMBIENT 0.2
         DIFFUSE 0.8
       END_TEXTURE
     END_QUARTIC
     SPHERE <0 0 0> 1
       TEXTURE
         COLOR Clear
       END_TEXTURE
     END_SPHERE
   END_INTERSECTION
   BOUNDED_BY
     SPHERE <0 0 0> 1.5 END_SPHERE
   END_BOUND
   ROTATE <30 0 180>
END_OBJECT

VIEW_POINT
   LOCATION  <0.0  0.0 -3.0>
   DIRECTION <0.0  0.0  1.0>
   UP        <0.0  1.0  0.0>
   RIGHT     <1.33 0.0  0.0>
END_VIEW_POINT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT

OBJECT
   SPHERE <0 0 0> 1 END_SPHERE
   TRANSLATE <-200 30 -300>
   TEXTURE
     COLOR White
     AMBIENT 1.0
     DIFFUSE 0.0
   END_TEXTURE
   LIGHT_SOURCE
   COLOUR White
END_OBJECT
</textarea>

    <!-- Generate Token Id -->
	<script type="text/javascript">
	    function generateTokenId()
	    {
    	  document.getElementById("token_id").value = new Date().getTime();
	    }
    </script>

	<!-- Retrieve Sample filename -->
	<script type="text/javascript">

    $(".dropdown-menu li a").click(function(){
      var selFilename = $(this).text();
	  var selText = document.getElementById(selFilename).value ;
	  changeTextArea(selText);
	  document.getElementById("scenelabel").innerHTML = selFilename;
    });
	
    </script>

    <!-- Change TextArea with sample file content -->
	<script type="text/javascript">

    function changeTextArea(text)
    {
      document.getElementById("scene").value = text;
    }
	
    </script>
		
	<!-- Update slide bars -->
	<script type="text/javascript">
	function changeWidthValue(newValue)
	{
		document.getElementById("widthvalue").value = newValue;
	}
	function changeHeightValue(newValue)
	{
		document.getElementById("heightvalue").value=newValue;
	}
	function changeWidthSliderValue(newValue)
	{
		document.getElementById("widthslider").value=newValue;
	}
	function changeHeightSliderValue(newValue)
	{
		document.getElementById("heightslider").value=newValue;
	}
	</script>
	
</body>

</html>

