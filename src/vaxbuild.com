$CC COLOUR.C
$CC CSG.C
$CC DUMP.C
$CC GIF.C
$CC GIFDECOD.C
$CC IFF.C
$CC LIGHTING.C
$CC MATRICES.C
$CC OBJECTS.C
$CC PARSE.C
$CC PLANES.C
$CC PRIOQ.C
$CC QUADRICS.C
$CC RAW.C
$CC RAY.C
$CC RENDER.C
$CC SPHERES.C
$CC TARGA.C
$CC TEXTURE.C
$CC TOKENIZE.C
$CC TRACE.C
$CC TRIANGLE.C
$CC VIEWPNT.C
$CC VAX.C
$link trace,-
COLOUR.OBJ,-
CSG.OBJ,-
DUMP.OBJ,-
GIF.OBJ,-
GIFDECOD.OBJ,-
IFF.OBJ,-
LIGHTING.OBJ,-
MATRICES.OBJ,-
OBJECTS.OBJ,-
PARSE.OBJ,-
PLANES.OBJ,-
PRIOQ.OBJ,-
QUADRICS.OBJ,-
RAW.OBJ,-
RAY.OBJ,-
RENDER.OBJ,-
SPHERES.OBJ,-
TARGA.OBJ,-
TEXTURE.OBJ,-
TOKENIZE.OBJ,-
TRIANGLE.OBJ,-
VAX.OBJ,-
VIEWPNT.OBJ,sys$input/opt
sys$share:vaxcrtl/shareable
