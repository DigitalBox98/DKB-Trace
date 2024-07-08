/*****************************************************************************
*
*                                   frame.h
*
*   from DKBTrace (c) 1990  David Buck
*
*  This header file is included by all C modules in DKBTrace.  It defines all
*  globally-accessible types and constants.
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


/* Generic header for all modules */

#include <stdio.h>
#include <string.h>
#include <math.h>
#include "config.h"

#ifndef TRUE
#define TRUE 1
#define FALSE 0
#endif

#ifndef FILE_NAME_LENGTH
#define FILE_NAME_LENGTH 150
#endif

#ifndef DBL
#define DBL double
#endif

#ifndef HUGE_VAL
#define HUGE_VAL 1.0e+17
#endif

#ifndef DBL_FORMAT_STRING
#define DBL_FORMAT_STRING "%lf"
#endif

#ifndef DEFAULT_OUTPUT_FORMAT
#define DEFAULT_OUTPUT_FORMAT	'd'
#endif

#ifndef TEST_ABORT
#define TEST_ABORT
#endif

#ifndef RED_RAW_FILE_EXTENSION
#define RED_RAW_FILE_EXTENSION ".red"
#endif

#ifndef GREEN_RAW_FILE_EXTENSION
#define GREEN_RAW_FILE_EXTENSION ".grn"
#endif

#ifndef BLUE_RAW_FILE_EXTENSION
#define BLUE_RAW_FILE_EXTENSION ".blu"
#endif

#ifndef STARTUP_DKB_TRACE
#define STARTUP_DKB_TRACE
#endif

#ifndef PRINT_OTHER_CREDITS
#define PRINT_OTHER_CREDITS
#endif

#ifndef FINISH_DKB_TRACE
#define FINISH_DKB_TRACE
#endif

#ifndef FILENAME_SEPARATOR
#define FILENAME_SEPARATOR "/"
#endif

/* These values determine the minumum and maximum distances
   that qualify as ray-object intersections */
#define Small_Tolerance 0.001
#define Max_Distance 1.0e7

typedef struct q_entry INTERSECTION;
typedef struct Vector_Struct VECTOR;
typedef DBL MATRIX [4][4];
typedef struct Colour_Struct COLOUR;
typedef struct Colour_Map_Entry COLOUR_MAP_ENTRY;
typedef struct Colour_Map_Struct COLOUR_MAP;
typedef struct Transformation_Struct TRANSFORMATION;
typedef struct Image_Struct IMAGE;
typedef struct Texture_Struct TEXTURE;
typedef struct Method_Struct METHODS;
typedef struct Viewpoint_Struct VIEWPOINT;
typedef struct Object_Shape SHAPE;
typedef struct Object_Struct OBJECT;
typedef struct Sphere_Shape SPHERE;
typedef struct Quadric_Shape QUADRIC;
typedef struct Quartic_Shape QUARTIC;
typedef struct Triangle_Shape TRIANGLE;
typedef struct Smooth_Triangle_Shape SMOOTH_TRIANGLE;
typedef struct Plane_Shape PLANE;
typedef struct CSG_Type CSG_SHAPE;
typedef struct Composite_Object_Struct COMPOSITE;
typedef struct Ray_Struct RAY;
typedef struct Frame_Struct FRAME;
typedef struct prioq_struct PRIOQ;
typedef int TOKEN;
typedef int CONSTANT;
typedef struct Chunk_Header_Struct CHUNK_HEADER;
typedef struct Data_File_Struct DATA_FILE;
typedef struct complex_block complex;

struct Vector_Struct
   {
   DBL x, y, z;
   };



struct Colour_Struct
   {
   DBL Red, Green, Blue, Alpha;
   };


struct Colour_Map_Entry
   {
   DBL start, end;
   COLOUR Start_Colour, End_Colour;
   };


struct Colour_Map_Struct
   {
   int Number_Of_Entries;
   COLOUR_MAP_ENTRY *Colour_Map_Entries;
   int Transparency_Flag;
   };


struct Transformation_Struct
   {
   MATRIX matrix;
   MATRIX inverse;
   };


/* Types for reading IFF files. */
typedef struct {
   unsigned short Red, Green, Blue, Alpha;
   } IMAGE_COLOUR;

struct Image_Line
   {
   unsigned char *red, *green, *blue;
   };

typedef struct Image_Line IMAGE_LINE;

struct Image_Struct
   {
   DBL width, height;
   int iwidth, iheight;
   short Colour_Map_Size;
   IMAGE_COLOUR *Colour_Map;
   union {
      IMAGE_LINE *rgb_lines;
      unsigned char **map_lines;
      } data;
   };


#define NO_TEXTURE               0
#define COLOUR_TEXTURE           1
#define BOZO_TEXTURE             2
#define MARBLE_TEXTURE           3
#define WOOD_TEXTURE             4
#define CHECKER_TEXTURE          5
#define CHECKER_TEXTURE_TEXTURE  6
#define SPOTTED_TEXTURE          7
#define AGATE_TEXTURE            8
#define GRANITE_TEXTURE          9
#define GRADIENT_TEXTURE        10
#define IMAGEMAP_TEXTURE        11

#define NO_BUMPS   0
#define WAVES      1
#define RIPPLES    2
#define WRINKLES   3
#define BUMPS      4
#define DENTS      5

struct Texture_Struct
   {
   TEXTURE *Next_Texture;
   DBL Object_Reflection;
   DBL Object_Ambient;
   DBL Object_Diffuse, Object_Brilliance;
   DBL Object_Index_Of_Refraction;
   DBL Object_Refraction;
   DBL Object_Specular, Object_Roughness;
   DBL Object_Phong, Object_PhongSize;
   DBL Bump_Amount;
   DBL Texture_Randomness;
   DBL Frequency;
   DBL Phase;
   int Texture_Number ;
   int Bump_Number;
   TRANSFORMATION *Texture_Transformation;
   COLOUR *Colour1;
   COLOUR *Colour2;
   DBL Turbulence;
   VECTOR Texture_Gradient;
   COLOUR_MAP *Colour_Map;
   IMAGE *Image;
   short Metallic_Flag, Once_Flag, Constant_Flag;
   };

#define SPHERE_TYPE            0
#define TRIANGLE_TYPE          1
#define SMOOTH_TRIANGLE_TYPE   2
#define PLANE_TYPE             3
#define QUADRIC_TYPE           4
#define QUARTIC_TYPE           5
#define COMPOSITE_TYPE         6
#define OBJECT_TYPE            7
#define CSG_UNION_TYPE         8
#define CSG_INTERSECTION_TYPE  9
#define CSG_DIFFERENCE_TYPE   10
#define VIEWPOINT_TYPE        11

struct Object_Struct
   {
   METHODS *Methods;
   int Type;
   struct Object_Struct *Next_Object;
   struct Object_Struct *Next_Light_Source;
   SHAPE *Bounding_Shapes;
   SHAPE *Shape;
   char Light_Source_Flag;
   VECTOR  Object_Center;
   COLOUR *Object_Colour;
   TEXTURE *Object_Texture;
   };


typedef INTERSECTION *(*INTERSECTION_METHOD)PARAMS((OBJECT *, RAY *));
typedef int (*ALL_INTERSECTIONS_METHOD)PARAMS((OBJECT *, RAY *, PRIOQ *));
typedef int (*INSIDE_METHOD)PARAMS((VECTOR *, OBJECT *));
typedef void (*NORMAL_METHOD)PARAMS((VECTOR *, OBJECT *, VECTOR *));
typedef void *(*COPY_METHOD)PARAMS((OBJECT *));
typedef void (*TRANSLATE_METHOD)PARAMS((OBJECT *, VECTOR *));
typedef void (*ROTATE_METHOD)PARAMS((OBJECT *, VECTOR *));
typedef void (*SCALE_METHOD)PARAMS((OBJECT *, VECTOR *));
typedef void (*INVERT_METHOD)PARAMS((OBJECT *));

struct Method_Struct
   {
   INTERSECTION_METHOD Intersection_Method;
   ALL_INTERSECTIONS_METHOD All_Intersections_Method;
   INSIDE_METHOD Inside_Method;
   NORMAL_METHOD Normal_Method;
   COPY_METHOD Copy_Method;
   TRANSLATE_METHOD Translate_Method;
   ROTATE_METHOD Rotate_Method;
   SCALE_METHOD Scale_Method;
   INVERT_METHOD Invert_Method;
   };


#define All_Intersections(x,y,z) ((*((x)->Methods->All_Intersections_Method)) (x,y,z))
#define Intersection(x,y) ((INTERSECTION *) ((*((x)->Methods->Intersection_Method)) (x,y)))
#define Inside(x,y) ((*((y)->Methods->Inside_Method)) (x,y))
#define Normal(x,y,z) ((*((y)->Methods->Normal_Method)) (x,y,z))
#define Copy(x) ((*((x)->Methods->Copy_Method)) (x))
#define Translate(x,y) ((*((x)->Methods->Translate_Method)) (x,y))
#define Scale(x,y) ((*((x)->Methods->Scale_Method)) (x,y))
#define Rotate(x,y) ((*((x)->Methods->Rotate_Method)) (x,y))
#define Invert(x) ((*((x)->Methods->Invert_Method)) (x))

struct Viewpoint_Struct
   {
   METHODS *Methods;
   int Type;
   VECTOR Location;
   VECTOR Direction;
   VECTOR Up;
   VECTOR Right;
   VECTOR Sky;
   };


struct Object_Shape
   {
   METHODS *Methods;
   int Type;
   struct Object_Shape *Next_Object;
   void *Parent_Object;
   TEXTURE *Shape_Texture;
   COLOUR *Shape_Colour;
   };


struct Sphere_Shape
   {
   METHODS *Methods;
   int Type;
   SHAPE *Next_Object;
   OBJECT *Parent_Object;
   TEXTURE *Shape_Texture;
   COLOUR *Shape_Colour;
   VECTOR  Center;
   DBL     Radius;
   DBL     Radius_Squared;
   DBL     Inverse_Radius;
   VECTOR  VPOtoC;
   DBL     VPOCSquared;
   short   VPinside, VPCached, Inverted;
   };


struct Quadric_Shape
   {
   METHODS *Methods;
   int Type;
   SHAPE *Next_Object;
   OBJECT *Parent_Object;
   TEXTURE *Shape_Texture;
   COLOUR *Shape_Colour;
   VECTOR  Object_2_Terms;
   VECTOR  Object_Mixed_Terms;
   VECTOR  Object_Terms;
   DBL Object_Constant;
   DBL Object_VP_Constant;
   int Constant_Cached;
   int Non_Zero_Square_Term;
   };

struct Quartic_Shape
   {
   METHODS *Methods;
   int Type;
   SHAPE *Next_Object;
   OBJECT *Parent_Object;
   TEXTURE *Shape_Texture;
   COLOUR *Shape_Colour;
   DBL Coeffs[35];
   };

#define X_AXIS 0
#define Y_AXIS 1
#define Z_AXIS 2

struct Triangle_Shape
   {
   METHODS *Methods;
   int Type;
   SHAPE *Next_Object;
   OBJECT *Parent_Object;
   TEXTURE *Shape_Texture;
   COLOUR *Shape_Colour;
   VECTOR  Normal_Vector;
   DBL     Distance;
   DBL     VPNormDotOrigin;
   unsigned int  VPCached:1;
   unsigned int  Dominant_Axis:2;
   unsigned int  Inverted:1;
   unsigned int  vAxis:2;         /* used only for smooth triangles */
   VECTOR  P1, P2, P3;
   };


struct Smooth_Triangle_Shape
   {
   METHODS *Methods;
   int Type;
   SHAPE *Next_Object;
   OBJECT *Parent_Object;
   TEXTURE *Shape_Texture;
   COLOUR *Shape_Colour;
   VECTOR  Normal_Vector;
   DBL     Distance;
   DBL     VPNormDotOrigin;
   unsigned int  VPCached:1;
   unsigned int  Dominant_Axis:2;
   unsigned int  Inverted:1;
   unsigned int  vAxis:2;         /* used only for smooth triangles */
   VECTOR  P1, P2, P3;
   VECTOR  N1, N2, N3, Perp;
   DBL  BaseDelta;
   };



struct Plane_Shape
   {
   METHODS *Methods;
   int Type;
   SHAPE *Next_Object;
   OBJECT *Parent_Object;
   TEXTURE *Shape_Texture;
   COLOUR *Shape_Colour;
   VECTOR  Normal_Vector;
   DBL     Distance;
   DBL     VPNormDotOrigin;
   int     VPCached;
   };


struct CSG_Type
   {
   METHODS *Methods;
   int Type;
   SHAPE *Next_Object;
   OBJECT *Parent_Object;
   SHAPE *Shapes;
   };
   

struct Composite_Object_Struct
   {
   METHODS *Methods;
   int Type;
   OBJECT *Next_Object;
   OBJECT *Next_Light_Source;
   SHAPE *Bounding_Shapes;
   OBJECT *Objects;
   };


#define MAX_CONTAINING_OBJECTS 10

struct Ray_Struct
   {
   VECTOR Initial;               /*  Xo  Yo  Zo  */
   VECTOR Direction;             /*  Xv  Yv  Zv  */
   VECTOR Initial_2;             /*  Xo^2  Yo^2  Zo^2  */
   VECTOR Direction_2;           /*  Xv^2  Yv^2  Zv^2  */
   VECTOR Initial_Direction;     /*  XoXv  YoYv  ZoZv  */
   VECTOR Mixed_Initial_Initial; /*  XoYo  XoZo  YoZo  */
   VECTOR Mixed_Dir_Dir;         /*  XvYv  XvZv  YvZv  */
   VECTOR Mixed_Init_Dir;        /*  XoYv+XvYo  XoZv+XvZo  YoZv+YvZo  */
   int Containing_Index;
   TEXTURE *Containing_Textures [MAX_CONTAINING_OBJECTS];
   DBL Containing_IORs [MAX_CONTAINING_OBJECTS];
   int Quadric_Constants_Cached;
   };


struct Frame_Struct
   {
   VIEWPOINT View_Point;
   int Screen_Height, Screen_Width;
   OBJECT *Light_Sources;
   OBJECT *Objects;
   DBL Atmosphere_IOR, Antialias_Threshold;
   DBL Fog_Distance;
   COLOUR Fog_Colour;
   };


#define DISPLAY 1
#define VERBOSE 2
#define DISKWRITE 4
#define PROMPTEXIT 8
#define ANTIALIAS 16
#define DEBUGGING 32
#define RGBSEPARATE 64
#define EXITENABLE 128
#define CONTINUE_TRACE 256

#define Make_Colour(c,r,g,b) { (c)->Red=(r);(c)->Green=(g);(c)->Blue=(b); (c)->Alpha=0.0; }

#define Make_Vector(v,a,b,c) { (v)->x=(a);(v)->y=(b);(v)->z=(c); }

/* Definitions for PRIOQ structure */

struct q_entry
   {
   DBL Depth;
   OBJECT *Object;
   VECTOR Point;
   SHAPE *Shape;
   };

struct prioq_struct
   {
   struct prioq_struct *next_pq;
   struct q_entry *queue;
   unsigned int current_entry, queue_size;
   };


/* Token Definitions for Parser */

#define AGATE_TOKEN                  0
#define ALL_TOKEN                    1
#define ALPHA_TOKEN                  2
#define AMBIENT_TOKEN                3
#define AMPERSAND_TOKEN              4
#define AT_TOKEN                     5
#define BACK_QUOTE_TOKEN             6
#define BACK_SLASH_TOKEN             7
#define BAR_TOKEN                    8
#define BLUE_TOKEN                   9
#define BRILLIANCE_TOKEN            10
#define BOZO_TOKEN                  11
#define BOUNDED_TOKEN               12
#define BUMPS_TOKEN                 13
#define CHECKER_TOKEN               14
#define CHECKER_TEXTURE_TOKEN       15
#define COLON_TOKEN                 16
#define COLOR_TOKEN                 17
#define COLOUR_TOKEN                18
#define COLOR_MAP_TOKEN             19
#define COLOUR_MAP_TOKEN            20
#define COMMA_TOKEN                 21
#define COMPOSITE_TOKEN             22
#define CONCENTRATION_TOKEN         23
#define DASH_TOKEN                  24
#define DECLARE_TOKEN               25
#define DENTS_TOKEN                 26
#define DIFFERENCE_TOKEN            27
#define DIFFUSE_TOKEN               28
#define DIRECTION_TOKEN             29
#define DOLLAR_TOKEN                30
#define DUMP_TOKEN                  31
#define END_BOUNDED_TOKEN           32
#define END_CHECKER_TEXTURE_TOKEN   33
#define END_COLOR_MAP_TOKEN         34
#define END_COLOUR_MAP_TOKEN        35
#define END_COMPOSITE_TOKEN         36
#define END_DIFFERENCE_TOKEN        37
#define END_FOG_TOKEN               38
#define END_INTERSECTION_TOKEN      39
#define END_OBJECT_TOKEN            40
#define END_OF_FILE_TOKEN           41
#define END_PLANE_TOKEN             42
#define END_POINTS_TOKEN            43
#define END_POLYGON_TOKEN           44
#define END_QUADRIC_TOKEN           45
#define END_QUARTIC_TOKEN           46
#define END_SHAPE_TOKEN             47
#define END_SMOOTH_TRIANGLE_TOKEN   48
#define END_SPHERE_TOKEN            49
#define END_TEXTURE_TOKEN           50
#define END_TRIANGLE_TOKEN          51
#define END_UNION_TOKEN             52
#define END_VIEW_POINT_TOKEN        53
#define EQUALS_TOKEN                54
#define EXCLAMATION_TOKEN           55
#define FLOAT_TOKEN                 56
#define FOG_TOKEN                   57
#define FREQUENCY_TOKEN             58
#define GIF_TOKEN                   59
#define GRADIENT_TOKEN              60
#define GRANITE_TOKEN               61
#define GREEN_TOKEN                 62
#define HASH_TOKEN                  63
#define HAT_TOKEN                   64
#define IDENTIFIER_TOKEN            65
#define IFF_TOKEN                   66
#define IMAGEMAP_TOKEN              67
#define INCLUDE_TOKEN               68
#define INTERSECTION_TOKEN          69
#define INVERSE_TOKEN               70
#define IOR_TOKEN                   71
#define LEFT_ANGLE_TOKEN            72
#define LEFT_BRACKET_TOKEN          73
#define LEFT_SQUARE_TOKEN           74
#define LIGHT_SOURCE_TOKEN          75
#define LOCATION_TOKEN              76
#define LOOK_AT_TOKEN               77
#define MARBLE_TOKEN                78
#define METALLIC_TOKEN              79
#define OBJECT_TOKEN                80
#define ONCE_TOKEN                  81
#define PERCENT_TOKEN               82
#define PHASE_TOKEN                 83
#define PHONG_TOKEN                 84
#define PHONGSIZE_TOKEN             85
#define PLANE_TOKEN                 86
#define PLUS_TOKEN                  87
#define POINTS_TOKEN                88
#define POINT_AT_TOKEN              89
#define POLYGON_TOKEN               90
#define QUADRIC_TOKEN               91
#define QUARTIC_TOKEN               92
#define QUESTION_TOKEN              93
#define RAW_TOKEN                   94
#define RED_TOKEN                   95
#define REFLECTION_TOKEN            96
#define REFRACTION_TOKEN            97
#define REVOLVE_TOKEN               98
#define RIGHT_TOKEN                 99
#define RIGHT_ANGLE_TOKEN          100
#define RIGHT_BRACKET_TOKEN        101
#define RIGHT_SQUARE_TOKEN         102
#define RIPPLES_TOKEN              103
#define ROTATE_TOKEN               104
#define ROUGHNESS_TOKEN            105
#define SCALE_TOKEN                106
#define SEMI_COLON_TOKEN           107
#define SHAPE_TOKEN                108
#define SINGLE_QUOTE_TOKEN         109
#define SIZE_TOKEN                 110
#define SKY_TOKEN                  111
#define SLASH_TOKEN                112
#define SMOOTH_TRIANGLE_TOKEN      113
#define SPECULAR_TOKEN             114
#define SPHERE_TOKEN               115
#define SPOTLIGHT_TOKEN            116
#define SPOTTED_TOKEN              117
#define STAR_TOKEN                 118
#define STRING_TOKEN               119
#define TEXTURE_TOKEN              120
#define TILDE_TOKEN                121
#define TILE2_TOKEN                122
#define TRANSLATE_TOKEN            123
#define TRIANGLE_TOKEN             124
#define TURBULENCE_TOKEN           125
#define UNION_TOKEN                126
#define UP_TOKEN                   127
#define VIEW_POINT_TOKEN           128
#define WAVES_TOKEN                129
#define WOOD_TOKEN                 130
#define WRINKLES_TOKEN             131
#define LAST_TOKEN                 132


struct Reserved_Word_Struct
   {                                
   TOKEN Token_Number;
   char *Token_Name;
   };

/* Here's where you dump the information on the current token (fm. PARSE.C) */

struct Token_Struct
   {
   TOKEN Token_Id;
   int Token_Line_No;
   char *Token_String;
   DBL Token_Float;
   int Identifier_Number;
   int Unget_Token, End_Of_File;
   char *Filename;
   };

/* Types of constants allowed in DECLARE statement (fm. PARSE.C) */

#define OBJECT_CONSTANT            0
#define VIEW_POINT_CONSTANT        1
#define VECTOR_CONSTANT            2
#define FLOAT_CONSTANT             3
#define COLOUR_CONSTANT            4
#define QUADRIC_CONSTANT           5
#define QUARTIC_CONSTANT           6
#define SPHERE_CONSTANT            7
#define PLANE_CONSTANT             8
#define TRIANGLE_CONSTANT          9
#define SMOOTH_TRIANGLE_CONSTANT  10  
#define CSG_INTERSECTION_CONSTANT 11   
#define CSG_UNION_CONSTANT        12
#define CSG_DIFFERENCE_CONSTANT   13
#define COMPOSITE_CONSTANT        14
#define TEXTURE_CONSTANT          15

struct Constant_Struct
   {
   int Identifier_Number;
   CONSTANT Constant_Type;
   char *Constant_Data;
   };

struct Chunk_Header_Struct {
   long name;
   long size;
   };

struct Data_File_Struct {
   FILE *File;
   char *Filename;
   int Line_Number;
   };

struct complex_block {
   DBL r, c;
   };

#define READ_MODE 0
#define WRITE_MODE 1
#define APPEND_MODE 2

struct file_handle_struct {
   char *filename;
   int  mode;
   int width, height;
   int buffer_size;
   char *buffer;
   FILE *file;
   char *(*Default_File_Name_p) PARAMS((void));
   int  (*Open_File_p) PARAMS((struct file_handle_struct *handle,
		   char *name, int *width, int *height, int buffer_size,
		   int mode));
   void (*Write_Line_p) PARAMS((struct file_handle_struct *handle,
		   COLOUR *line_data, int line_number));
   int  (*Read_Line_p) PARAMS((struct file_handle_struct *handle,
		   COLOUR *line_data, int *line_number));
   void (*Read_Image_p) PARAMS((IMAGE *Image, char *filename));
   void (*Close_File_p) PARAMS((struct file_handle_struct *handle));
   };

typedef struct file_handle_struct FILE_HANDLE;

#define Default_File_Name(h) ((*((h)->Default_File_Name_p)) ())
#define Open_File(h,n,wd,ht,sz,m) ((*((h)->Open_File_p)) (h,n,wd,ht,sz,m))
#define Write_Line(h,l,n) ((*((h)->Write_Line_p)) (h, l, n))
#define Read_Line(h,l,n) ((*((h)->Read_Line_p)) (h, l, n))
#define Read_Image(h,i) ((*((h)->Read_Image_p)) (h, i))
#define Close_File(h) ((*((h)->Close_File_p)) (h))
