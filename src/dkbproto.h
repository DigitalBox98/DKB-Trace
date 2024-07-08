/*****************************************************************************
*
*                                     dkbproto.h
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module defines the prototypes for all system-independent functions.
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


/* Prototypes for functions defined in trace.c */
void usage PARAMS((void));
void init_vars PARAMS((void));
void close_all PARAMS((void));
void get_defaults PARAMS((void));
void read_options PARAMS((char *file_name));
void parse_option PARAMS((char *Option_String));
void parse_file_name PARAMS((char *File_Name));
void Print_Options PARAMS((void));
void print_stats PARAMS((void));
FILE *Locate_File PARAMS((char *filename, char *mode));

/* Prototypes for functions defined in render.c */
void initialize_renderer PARAMS((void));
void Read_Rendered_Part PARAMS((void));
void Create_Ray PARAMS((RAY *ray, int width, int height, DBL x, DBL y));
void Supersample PARAMS((COLOUR *result, int x, int y, int Width,int Height));
void Start_Tracing PARAMS((void));
void Trace PARAMS((RAY *Ray, COLOUR *Colour));
void check_stats PARAMS((register int y));
void allocate_lines PARAMS((COLOUR **Previous_Line, COLOUR **Current_Line, char **Previous_Line_Antialiased_Flags, char **Current_Line_Antialiased_Flags, RAY *Ray));
void output PARAMS((register int y, COLOUR **Previous_Line, COLOUR **Current_Line, char **Previous_Line_Antialiased_Flags, char **Current_Line_Antialiased_Flags));

/* Prototypes for functions defined in tokenize.c */
void Initialize_Tokenizer PARAMS((char *Input_File_Name));
void Terminate_Tokenizer PARAMS((void));
void Tokenize PARAMS((char *name));
int Process_Token PARAMS((void));
int Skip_Spaces PARAMS((DATA_FILE *Data_File));
int Parse_Comments PARAMS((DATA_FILE *Data_File));
void Begin_String PARAMS((void));
void Stuff_Character PARAMS((int c, DATA_FILE *Data_File));
void End_String PARAMS((DATA_FILE *Data_File));
int Read_Float PARAMS((DATA_FILE *Data_File));
void Parse_String PARAMS((DATA_FILE *Data_File));
int Read_Symbol PARAMS((DATA_FILE *Data_File));
int Find_Reserved PARAMS((void));
int Find_Symbol PARAMS((void));
void Write_Token PARAMS((int Token_Id, DATA_FILE *Data_File));
void Token_Error PARAMS((DATA_FILE *Data_File, char *str));
void Get_Token PARAMS((void));
void Unget_Token PARAMS((void));

/* Prototypes for functions defined in parse.c */
void Parse PARAMS((FRAME *Frame_Ptr));
void Token_Init PARAMS((void));
void Frame_Init PARAMS((void));
COMPOSITE *Get_Composite_Object PARAMS((void));
SPHERE *Get_Sphere_Shape PARAMS((void));
QUADRIC *Get_Quadric_Shape PARAMS((void));
QUARTIC *Get_Quartic_Shape PARAMS((void));
PLANE *Get_Plane_Shape PARAMS((void));
TRIANGLE *Get_Triangle_Shape PARAMS((void));
SMOOTH_TRIANGLE *Get_Smooth_Triangle_Shape PARAMS((void));
CSG_SHAPE *Get_CSG_Shape PARAMS((void));
CSG_SHAPE *Get_CSG_Union PARAMS((void));
CSG_SHAPE *Get_CSG_Intersection PARAMS((void));
OBJECT *Get_Object PARAMS((void));
TEXTURE *Get_Texture PARAMS((void));
VIEWPOINT *Get_Viewpoint PARAMS((void));
COLOUR *Get_Colour PARAMS((void));
VECTOR *Get_Vector PARAMS((void));
DBL *Get_Float PARAMS((void));
TRANSFORMATION *Get_Transformation PARAMS((void));
DBL Parse_Float PARAMS((void));
void Parse_Vector PARAMS((VECTOR *Given_Vector));
void Parse_Coeffs PARAMS((DBL *Given_Coeffs));
void Parse_Colour PARAMS((COLOUR *Given_Colour));
COLOUR_MAP *Parse_Colour_Map PARAMS((void));
TEXTURE *Copy_Texture PARAMS((TEXTURE *Texture));
TEXTURE *Parse_Texture PARAMS((void));
SHAPE *Parse_Sphere PARAMS((void));
SHAPE *Parse_Plane PARAMS((void));
SHAPE *Parse_Triangle PARAMS((void));
SHAPE *Parse_Smooth_Triangle PARAMS((void));
SHAPE *Parse_Quadric PARAMS((void));
SHAPE *Parse_Quartic PARAMS((void));
CSG_SHAPE *Parse_CSG PARAMS((int type, OBJECT *Parent_Object));
SHAPE *Parse_Shape PARAMS((OBJECT *Object));
OBJECT *Parse_Object PARAMS((void));
OBJECT *Parse_Composite PARAMS((void));
void Parse_Fog PARAMS((void));
void Add_Composite_Light_Source PARAMS ((COMPOSITE *Object));
void Parse_Frame PARAMS((void));
void Parse_Viewpoint PARAMS((VIEWPOINT *Given_Vp));
void Parse_Declare PARAMS((void));
void Init_Viewpoint PARAMS((VIEWPOINT *vp));
void Link PARAMS((OBJECT *New_Object,OBJECT **Field,OBJECT **Old_Object_List));
CONSTANT Find_Constant PARAMS((void));
char *Get_Token_String PARAMS((TOKEN Token_Id));
void Parse_Error PARAMS((TOKEN Token_Id));
void Type_Error PARAMS((void));
void Undeclared PARAMS((void));
void Error PARAMS((char *str));

/* Prototypes for functions defined in objects.c */
INTERSECTION *Object_Intersect PARAMS((OBJECT *Object, RAY *Ray));
int All_Composite_Intersections PARAMS((OBJECT *Object, RAY *Ray, PRIOQ *Depth_Queue));
int All_Object_Intersections PARAMS((OBJECT *Object, RAY *Ray, PRIOQ *Depth_Queue));
int Inside_Basic_Object PARAMS((VECTOR *point, OBJECT *Object)); 
int Inside_Composite_Object PARAMS((VECTOR *point, OBJECT *Object));
void *Copy_Basic_Object PARAMS((OBJECT *Object));
void *Copy_Composite_Object PARAMS((OBJECT *Object));
void Translate_Basic_Object PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_Basic_Object PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_Basic_Object PARAMS((OBJECT *Object, VECTOR *Vector));
void Translate_Composite_Object PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_Composite_Object PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_Composite_Object PARAMS((OBJECT *Object, VECTOR *Vector));
void Invert_Basic_Object PARAMS((OBJECT *Object));
void Invert_Composite_Object PARAMS((OBJECT *Object));

/* Prototypes for functions defined in spheres.c */
int All_Sphere_Intersections PARAMS((OBJECT *Object, RAY *Ray, PRIOQ *Depth_Queue));
int Intersect_Sphere PARAMS((RAY *Ray, SPHERE *Sphere, DBL *Depth1, DBL *Depth2));
int Inside_Sphere PARAMS((VECTOR *point, OBJECT *Object));
void Sphere_Normal PARAMS((VECTOR *Result, OBJECT *Object, VECTOR *Intersection_Point));
void *Copy_Sphere PARAMS((OBJECT *Object));
void Translate_Sphere PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_Sphere PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_Sphere PARAMS((OBJECT *Object, VECTOR *Vector));
void Invert_Sphere PARAMS((OBJECT *Object));

/* Prototypes for functions defined in quadrics.c */
int All_Quadric_Intersections PARAMS((OBJECT *Object, RAY *Ray, PRIOQ *Depth_Queue));
int Intersect_Quadric PARAMS((RAY *Ray, QUADRIC *Shape, DBL *Depth1, DBL *Depth2));
int Inside_Quadric PARAMS((VECTOR *point, OBJECT *Object));
void Quadric_Normal PARAMS((VECTOR *Result, OBJECT *Object, VECTOR *Intersection_Point));
void *Copy_Quadric PARAMS((OBJECT *Object));
void Transform_Quadric PARAMS((QUADRIC *Shape, TRANSFORMATION *Transformation));
void Quadric_To_Matrix PARAMS((QUADRIC *Quadric, MATRIX *Matrix));
void Matrix_To_Quadric PARAMS((MATRIX *Matrix, QUADRIC *Quadric));
void Translate_Quadric PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_Quadric PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_Quadric PARAMS((OBJECT *Object, VECTOR *Vector));
void Invert_Quadric PARAMS((OBJECT *Object));

/* Prototypes for functions defined in quartics.c */
int All_Quartic_Intersections PARAMS((OBJECT *Object, RAY *Ray, PRIOQ *Depth_Queue));
int Intersect_Quartic PARAMS((RAY *Ray, QUARTIC *Shape, DBL *Depths));
int Inside_Quartic PARAMS((VECTOR *point, OBJECT *Object));
void Quartic_Normal PARAMS((VECTOR *Result, OBJECT *Object, VECTOR *Intersection_Point));
void *Copy_Quartic PARAMS((OBJECT *Object));
void Translate_Quartic PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_Quartic PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_Quartic PARAMS((OBJECT *Object, VECTOR *Vector));
void Invert_Quartic PARAMS((OBJECT *Object));
int roll_term_indices PARAMS((int i, int j, int k));
void unroll_term_indices PARAMS((int power, int index, int *i, int *j, int *k, int *l));
DBL do_partial_term PARAMS((MATRIX *q, int row, int power, int i, int j, int k, int l));
void Transform_Quartic PARAMS((QUARTIC *Shape, MATRIX *q ));

/* Prototypes for functions defined in triangle.c */
void Find_Triangle_Dominant_Axis PARAMS((TRIANGLE *Triangle));
int Compute_Triangle  PARAMS((TRIANGLE *Triangle));
void Compute_Smooth_Triangle  PARAMS((SMOOTH_TRIANGLE *Triangle));
int All_Triangle_Intersections  PARAMS((OBJECT *Object, RAY *Ray, PRIOQ *Depth_Queue));
int Intersect_Triangle  PARAMS((RAY *Ray, TRIANGLE *Triangle, DBL *Depth));
int Inside_Triangle  PARAMS((VECTOR *point, OBJECT *Object));
void Triangle_Normal  PARAMS((VECTOR *Result, OBJECT *Object, VECTOR *Intersection_Point));
void *Copy_Triangle  PARAMS((OBJECT *Object));
void Translate_Triangle  PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_Triangle  PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_Triangle  PARAMS((OBJECT *Object, VECTOR *Vector));
void Invert_Triangle  PARAMS((OBJECT *Object));
void Smooth_Triangle_Normal  PARAMS((VECTOR *Result, OBJECT *Object, VECTOR *Intersection_Point));
void *Copy_Smooth_Triangle PARAMS((OBJECT *Object));
void Translate_Smooth_Triangle  PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_Smooth_Triangle  PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_Smooth_Triangle  PARAMS((OBJECT *Object, VECTOR *Vector));
void Invert_Smooth_Triangle  PARAMS((OBJECT *Object));

/* Prototypes for functions defined in vect.c */
int solve_quadratic PARAMS((DBL *x, DBL *y));
int solve_cubic PARAMS((DBL *x, DBL *y));
int solve_quartic PARAMS((DBL *x, DBL *y));
int polysolve PARAMS((int order, DBL *Coeffs, DBL *roots));

/* Prototypes for functions defined in lighting.c */
void Colour_At PARAMS((COLOUR *Colour, TEXTURE *Texture, VECTOR *Intersection_Point));
void Perturb_Normal PARAMS((VECTOR *New_Normal, TEXTURE *Texture, VECTOR *Intersection_Point, VECTOR *Surface_Normal));
void Ambient PARAMS((TEXTURE *Texture, VECTOR *Intersection_Point, COLOUR *Surface_Colour, COLOUR *Colour));
void Diffuse PARAMS((TEXTURE *Texture, VECTOR *Intersection_Point, RAY *Eye, VECTOR *Surface_Normal, COLOUR *Surface_Colour, COLOUR *Colour));
void do_light PARAMS((OBJECT *Light_Source, DBL *Light_Source_Depth, RAY *Light_Source_Ray, VECTOR *Intersection_Point));
void do_blocking PARAMS((OBJECT *Blocking_Object, INTERSECTION *Local_Intersection, COLOUR *Light_Colour));
void do_phong PARAMS((TEXTURE *Texture, RAY *Light_Source_Ray, VECTOR Eye, VECTOR *Surface_Normal, COLOUR *Colour, COLOUR *Light_Colour, COLOUR *Surface_Colour));
void do_specular PARAMS((TEXTURE *Texture, RAY *Light_Source_Ray, VECTOR REye, VECTOR *Surface_Normal, COLOUR *Colour, COLOUR *Light_Colour, COLOUR *Surface_Colour));
void do_diffuse PARAMS((TEXTURE *Texture, RAY *Light_Source_Ray, VECTOR *Surface_Normal, COLOUR *Colour, COLOUR *Light_Colour, COLOUR *Surface_Colour));
void Reflect PARAMS((TEXTURE *Texture, VECTOR *Intersection_Point, RAY *Ray, VECTOR *Surface_Normal, COLOUR *Colour));
void Refract PARAMS((TEXTURE *Texture, VECTOR *Intersection_Point, RAY *Ray, VECTOR *Surface_Normal, COLOUR *Colour));
void Fog PARAMS((DBL Distance, COLOUR *Fog_Colour, DBL Fog_Distance, COLOUR *Colour));
void Compute_Reflected_Colour PARAMS ((RAY *Ray, TEXTURE *Texture, INTERSECTION *Intersection, COLOUR *Surface_Colour, COLOUR *Emitted_Colour));
void Determine_Surface_Colour PARAMS ((INTERSECTION *Intersection, COLOUR *Colour, RAY *Ray, int Shadow_Ray));

/* Prototypes for functions defined in prioq.c */
void pq_init PARAMS((void));
PRIOQ *pq_alloc PARAMS((void));
void pq_free PARAMS((PRIOQ *pq));
PRIOQ *pq_new PARAMS((int index_size));
void pq_balance PARAMS((PRIOQ *q, unsigned int entry_pos1));
void pq_add PARAMS((PRIOQ *q, INTERSECTION *entry));
INTERSECTION *pq_get_highest PARAMS((PRIOQ *q));
int pq_is_empty PARAMS((PRIOQ *q));
void pq_delete_highest PARAMS((PRIOQ *q));

/* Prototypes for functions defined in texture.c */
void Compute_Colour PARAMS((COLOUR *Colour,COLOUR_MAP *Colour_Map,DBL value));
void Initialize_Noise PARAMS((void));
void InitTextureTable PARAMS((void));
void InitRTable PARAMS((void));
int R PARAMS((VECTOR *v));
int Crc16 PARAMS((char *buf, int count));
void setup_lattice PARAMS((DBL *x, DBL *y, DBL *z, long *ix, long *iy, long *iz, long *jx, long *jy, long *jz, DBL *sx, DBL *sy, DBL *sz, DBL *tx, DBL *ty, DBL *tz));
DBL Noise PARAMS((DBL x, DBL y, DBL z));
void DNoise PARAMS((VECTOR *result, DBL x, DBL y, DBL z));
DBL cycloidal PARAMS((DBL value));
DBL Triangle_Wave PARAMS((DBL value));
DBL Turbulence PARAMS((DBL x, DBL y, DBL z));
void DTurbulence PARAMS((VECTOR *result, DBL x, DBL y, DBL z));
int Bozo PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *Colour));
int marble PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *colour));
void ripples PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, VECTOR *Vector));
void waves PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, VECTOR *Vector));
int wood PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *colour));
void checker PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *colour));
void checker_texture PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *colour));
void spotted PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *Colour));
void bumps PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, VECTOR *normal));
void dents PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, VECTOR *normal));
void agate PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *colour));
void wrinkles PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, VECTOR *normal));
void granite PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *Colour));
void gradient PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *Colour));
void texture_map PARAMS((DBL x, DBL y, DBL z, TEXTURE *Texture, COLOUR *colour));
void Translate_Texture PARAMS((TEXTURE **Texture_Ptr, VECTOR *Vector));
void Rotate_Texture PARAMS((TEXTURE **Texture_Ptr, VECTOR *Vector));
void Scale_Texture PARAMS((TEXTURE **Texture_Ptr, VECTOR *Vector));

/* Prototypes for functions defined in csg.c */
int All_CSG_Union_Intersections PARAMS((OBJECT *Object, RAY *Ray, PRIOQ *Depth_Queue));
int All_CSG_Intersect_Intersections PARAMS((OBJECT *Object, RAY *Ray, PRIOQ *Depth_Queue)); 
int Inside_CSG_Union PARAMS((VECTOR *point, OBJECT *Object));
int Inside_CSG_Intersection PARAMS((VECTOR *point, OBJECT *Object));
void *Copy_CSG PARAMS((OBJECT *Object));
void Translate_CSG PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_CSG PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_CSG PARAMS((OBJECT *Object, VECTOR *Vector));
void Invert_CSG PARAMS((OBJECT *Object)); 
void Set_CSG_Parents PARAMS((CSG_SHAPE *, OBJECT *));

/* Prototypes for functions defined in colour.c */
DBL Colour_Distance PARAMS((COLOUR *colour1, COLOUR *colour2));
void Add_Colour PARAMS((COLOUR *result, COLOUR *colour1, COLOUR *colour2));
void Scale_Colour PARAMS((COLOUR *result, COLOUR *colour, DBL factor));
void Clip_Colour PARAMS((COLOUR *result, COLOUR *colour)); 

/* Prototypes for functions defined in viewpnt.c */
void *Copy_Viewpoint PARAMS((OBJECT *Object));
void Translate_Viewpoint PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_Viewpoint PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_Viewpoint PARAMS((OBJECT *Object, VECTOR *Vector));

/* Prototypes for functions defined in ray.c */
void Make_Ray PARAMS((RAY *r));
void Initialize_Ray_Containers PARAMS((RAY *Ray));
void Copy_Ray_Containers PARAMS((RAY *Dest_Ray, RAY *Source_Ray));
void Ray_Enter PARAMS((RAY *ray, TEXTURE *texture));
void Ray_Exit PARAMS((RAY *ray));

/* Prototypes for functions defined in planes.c */
int All_Plane_Intersections PARAMS((OBJECT *Object, RAY *Ray, PRIOQ *Depth_Queue));
int Intersect_Plane PARAMS((RAY *Ray, PLANE *Plane, DBL *Depth));
int Inside_Plane PARAMS((VECTOR *point, OBJECT *Object));
void Plane_Normal PARAMS((VECTOR *Result, OBJECT *Object, VECTOR *Intersection_Point));
void *Copy_Plane PARAMS((OBJECT *Object));
void Translate_Plane PARAMS((OBJECT *Object, VECTOR *Vector));
void Rotate_Plane PARAMS((OBJECT *Object, VECTOR *Vector));
void Scale_Plane PARAMS((OBJECT *Object, VECTOR *Vector));
void Invert_Plane PARAMS((OBJECT *Object));

/* Prototypes for functions defined in iff.c */
void iff_error PARAMS((void));
int read_byte PARAMS((FILE *f));
int read_word PARAMS((FILE *f));
long read_long PARAMS((FILE *f));
void Read_Chunk_Header PARAMS((FILE *f, CHUNK_HEADER *dest)); 
void Read_Iff_Image PARAMS((IMAGE *Image, char *filename));

/* Prototypes for functions defined in gif.c */
int out_line PARAMS((unsigned char *pixels, int linelen));
int get_byte PARAMS((void));
void Read_Gif_Image PARAMS((IMAGE *Image, char *filename));

/* Prototypes for functions defined in gifdecod.c */
void cleanup_gif_decoder PARAMS((void));
short init_exp PARAMS((short size));
short get_next_code PARAMS((void));
short decoder PARAMS((short linewidth));

/* Prototypes for functions defined in amiga.c */
void display_finished PARAMS((void));
void display_init PARAMS((int width, int height));
void display_close PARAMS((void));
void display_plot PARAMS((int x, int y, char Red, char Green, char Blue));

/* Prototypes for functions defined in matrices.c */
void MZero PARAMS((MATRIX *result));
void MIdentity PARAMS((MATRIX *result));
void MTimes PARAMS((MATRIX *result, MATRIX *matrix1, MATRIX *matrix2));
void MAdd PARAMS((MATRIX *result, MATRIX *matrix1, MATRIX *matrix2));
void MSub PARAMS((MATRIX *result, MATRIX *matrix1, MATRIX *matrix2));
void MScale PARAMS((MATRIX *result, MATRIX *matrix1, DBL amount));
void MTranspose PARAMS((MATRIX *result, MATRIX *matrix1));
void MTransformVector PARAMS((VECTOR *result, VECTOR *vector, TRANSFORMATION *transformation));
void MInverseTransformVector PARAMS((VECTOR *result, VECTOR *vector, TRANSFORMATION *transformation));
void Get_Scaling_Transformation PARAMS((TRANSFORMATION *result, VECTOR *vector));
void Get_Inversion_Transformation PARAMS((TRANSFORMATION *result));
void Get_Translation_Transformation PARAMS((TRANSFORMATION *transformation, VECTOR *vector));
void Get_Rotation_Transformation PARAMS((TRANSFORMATION *transformation, VECTOR *vector));
void Get_Look_At_Transformation PARAMS((TRANSFORMATION *transformation, VECTOR *Look_At, VECTOR *Up, VECTOR *Right));
void Compose_Transformations PARAMS((TRANSFORMATION *Original_Transformation, TRANSFORMATION *New_Transformation));

/* Prototypes for functions defined in dump.c */
FILE_HANDLE *Get_Dump_File_Handle PARAMS((void));
char *Default_Dump_File_Name PARAMS((void));
int Open_Dump_File PARAMS((FILE_HANDLE *handle, char *name,
                           int *width, int *height, int buffer_size, int mode));
void Write_Dump_Line PARAMS((FILE_HANDLE *handle, COLOUR *line_data, int line_number));
int Read_Dump_Line PARAMS((FILE_HANDLE *handle, COLOUR *line_data, int *line_number));
int Read_Dump_Int_Line PARAMS((FILE_HANDLE *handle, IMAGE_LINE *line_data, int *line_number));
void Read_Dump_Image PARAMS((IMAGE *Image, char *filename));
void Close_Dump_File PARAMS((FILE_HANDLE *handle));

/* Prototypes for functions defined in targa.c */
FILE_HANDLE *Get_Targa_File_Handle PARAMS((void));
char *Default_Targa_File_Name PARAMS((void));
int Open_Targa_File PARAMS((FILE_HANDLE *handle, char *name,
                           int *width, int *height, int buffer_size, int mode));
void Write_Targa_Line PARAMS((FILE_HANDLE *handle, COLOUR *line_data, int line_number));
int Read_Targa_Line PARAMS((FILE_HANDLE *handle, COLOUR *line_data, int *line_number));
void Close_Targa_File PARAMS((FILE_HANDLE *handle));

/* Prototypes for functions defined in Raw.c */
FILE_HANDLE *Get_Raw_File_Handle PARAMS((void));
char *Default_Raw_File_Name PARAMS((void));
int Open_Raw_File PARAMS((FILE_HANDLE *handle, char *name,
                           int *width, int *height, int buffer_size, int mode));
void Write_Raw_Line PARAMS((FILE_HANDLE *handle, COLOUR *line_data, int line_number));
int Read_Raw_Line PARAMS((FILE_HANDLE *handle, COLOUR *line_data, int *line_number));
void Close_Raw_File PARAMS((FILE_HANDLE *handle));

