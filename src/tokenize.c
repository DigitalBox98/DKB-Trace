/*****************************************************************************
*
*                                     tokenize.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements the first part of a two part parser for the scene
*  description files.  This phase changes the input file into tokens.
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

#include <ctype.h>
#include "frame.h"
#include "dkbproto.h"

/* This module tokenizes the input file and sends the tokens created
to the parser (the second stage).  Tokens sent to the parser contain a
token ID, the line number of the token, and if necessary, some data for
the token.  */

#define MAX_STRING_INDEX 41
char String[MAX_STRING_INDEX];
int String_Index;
extern char Library_Path[];

/* Here are the reserved words.  If you need to add new words, be sure
to declare them in frame.h */

struct Reserved_Word_Struct Reserved_Words [LAST_TOKEN] = {
AGATE_TOKEN, "AGATE",
ALL_TOKEN, "ALL",
ALPHA_TOKEN, "ALPHA",
AMBIENT_TOKEN, "AMBIENT",
AMPERSAND_TOKEN, "&",
AT_TOKEN, "@",
BACK_QUOTE_TOKEN, "`",
BACK_SLASH_TOKEN, "\\",
BAR_TOKEN, "|",
BLUE_TOKEN, "BLUE",
BRILLIANCE_TOKEN, "BRILLIANCE",
BOZO_TOKEN, "BOZO",
BOUNDED_TOKEN, "BOUNDED_BY",
BUMPS_TOKEN, "BUMPS",
CHECKER_TOKEN, "CHECKER",
CHECKER_TEXTURE_TOKEN, "CHECKER_TEXTURE",
COLON_TOKEN, ":",
COLOUR_TOKEN, "COLOR",
COLOUR_TOKEN, "COLOUR",
COLOUR_MAP_TOKEN, "COLOR_MAP",
COLOUR_MAP_TOKEN, "COLOUR_MAP",
COMMA_TOKEN, ",",
COMPOSITE_TOKEN, "COMPOSITE",
CONCENTRATION_TOKEN, "CONCENTRATION",
DASH_TOKEN, "-",
DECLARE_TOKEN, "DECLARE",
DENTS_TOKEN, "DENTS",
DIFFERENCE_TOKEN, "DIFFERENCE",
DIFFUSE_TOKEN, "DIFFUSE",
DIRECTION_TOKEN, "DIRECTION",
DOLLAR_TOKEN, "$",
DUMP_TOKEN, "DUMP",
END_BOUNDED_TOKEN, "END_BOUND",
END_CHECKER_TEXTURE_TOKEN, "END_CHECKER_TEXTURE",
END_COLOUR_MAP_TOKEN, "END_COLOR_MAP",
END_COLOUR_MAP_TOKEN, "END_COLOUR_MAP",
END_COMPOSITE_TOKEN, "END_COMPOSITE",
END_DIFFERENCE_TOKEN, "END_DIFFERENCE",
END_FOG_TOKEN, "END_FOG",
END_INTERSECTION_TOKEN, "END_INTERSECTION",
END_OBJECT_TOKEN, "END_OBJECT",
END_OF_FILE_TOKEN, "End of File",
END_PLANE_TOKEN, "END_PLANE",
END_POINTS_TOKEN, "END_POINTS",
END_POLYGON_TOKEN, "END_POLYGON",
END_QUADRIC_TOKEN, "END_QUADRIC",
END_QUARTIC_TOKEN, "END_QUARTIC",
END_SHAPE_TOKEN, "END_SHAPE",
END_SMOOTH_TRIANGLE_TOKEN, "END_SMOOTH_TRIANGLE",
END_SPHERE_TOKEN, "END_SPHERE",
END_TEXTURE_TOKEN, "END_TEXTURE",
END_TRIANGLE_TOKEN, "END_TRIANGLE",
END_UNION_TOKEN, "END_UNION",
END_VIEW_POINT_TOKEN, "END_VIEW_POINT",
EQUALS_TOKEN, "=",
EXCLAMATION_TOKEN, "!",
FLOAT_TOKEN, "FLOAT",
FOG_TOKEN, "FOG",
FREQUENCY_TOKEN, "FREQUENCY",
GIF_TOKEN, "GIF",
GRANITE_TOKEN, "GRANITE",
GRADIENT_TOKEN, "GRADIENT",
GREEN_TOKEN, "GREEN",
HASH_TOKEN, "#",
HAT_TOKEN, "^",
IDENTIFIER_TOKEN, "IDENTIFIER",
IFF_TOKEN, "IFF",
IMAGEMAP_TOKEN, "IMAGEMAP",
INCLUDE_TOKEN, "INCLUDE",
INTERSECTION_TOKEN, "INTERSECTION",
INVERSE_TOKEN, "INVERSE",
IOR_TOKEN, "IOR",
LEFT_ANGLE_TOKEN, "<",
LEFT_BRACKET_TOKEN, "{",
LEFT_SQUARE_TOKEN, "[",
LIGHT_SOURCE_TOKEN, "LIGHT_SOURCE",
LOCATION_TOKEN, "LOCATION",
LOOK_AT_TOKEN, "LOOK_AT",
MARBLE_TOKEN, "MARBLE",
METALLIC_TOKEN, "METALLIC",
OBJECT_TOKEN, "OBJECT",
ONCE_TOKEN, "ONCE",
PERCENT_TOKEN, "%",
PHASE_TOKEN, "PHASE",
PHONG_TOKEN, "PHONG",
PHONGSIZE_TOKEN, "PHONGSIZE",
PLANE_TOKEN, "PLANE",
PLUS_TOKEN, "+",
POINTS_TOKEN, "POINTS",
POINT_AT_TOKEN, "POINT_AT",
POLYGON_TOKEN, "POLYGON",
QUADRIC_TOKEN, "QUADRIC",
QUARTIC_TOKEN, "QUARTIC",
QUESTION_TOKEN, "?",
RAW_TOKEN, "RAW",
RED_TOKEN, "RED",
REFLECTION_TOKEN, "REFLECTION",
REFRACTION_TOKEN, "REFRACTION",
REVOLVE_TOKEN, "REVOLVE",
RIGHT_TOKEN, "RIGHT",
RIGHT_ANGLE_TOKEN, ">",
RIGHT_BRACKET_TOKEN, ")",
RIGHT_SQUARE_TOKEN, "]",
RIPPLES_TOKEN, "RIPPLES",
ROTATE_TOKEN, "ROTATE",
ROUGHNESS_TOKEN, "ROUGHNESS",
SCALE_TOKEN, "SCALE",
SEMI_COLON_TOKEN, ";",
SHAPE_TOKEN, "SHAPE",
SKY_TOKEN, "SKY",
SINGLE_QUOTE_TOKEN, "'",
SIZE_TOKEN, "SIZE",
SLASH_TOKEN, "/",
SMOOTH_TRIANGLE_TOKEN, "SMOOTH_TRIANGLE",
SPECULAR_TOKEN, "SPECULAR",
SPHERE_TOKEN, "SPHERE",
SPOTLIGHT_TOKEN, "SPOTLIGHT",
SPOTTED_TOKEN, "SPOTTED",
STAR_TOKEN, "*",
STRING_TOKEN, "STRING",
TEXTURE_TOKEN, "TEXTURE",
TILDE_TOKEN, "~",
TILE2_TOKEN, "TILE2",
TRANSLATE_TOKEN, "TRANSLATE",
TRIANGLE_TOKEN, "TRIANGLE",
TURBULENCE_TOKEN, "TURBULENCE",
UNION_TOKEN, "UNION",
UP_TOKEN, "UP",
VIEW_POINT_TOKEN, "VIEW_POINT",
WAVES_TOKEN, "WAVES",
WOOD_TOKEN, "WOOD",
WRINKLES_TOKEN, "WRINKLES"
  };

/* Make a table for user-defined symbols.  500 symbols should be more
than enough. */

#define MAX_SYMBOLS 500

char **Symbol_Table;
int Number_Of_Symbols;

#define MAX_INCLUDE_FILES 10

DATA_FILE Include_Files[MAX_INCLUDE_FILES];
int Include_File_Index;
DATA_FILE *Data_File;

struct Token_Struct Token;

#define CALL(x) { if (!(x)) return (FALSE); }

void Initialize_Tokenizer(filename)
   char *filename;
   {
   Symbol_Table = NULL;
   Data_File = NULL;

   Include_File_Index = 0;
   Data_File = &Include_Files[0];

   Data_File->File = Locate_File (filename, "r");
   if (Data_File->File == NULL) {
      fprintf (stderr, "Cannot open input file\n");
      exit(1);
      }

   Data_File->Filename = malloc(strlen(filename) + 1);
   strcpy (Data_File->Filename, filename);
   Data_File->Line_Number = 0;


   if ((Symbol_Table = (char **) malloc (MAX_SYMBOLS * sizeof (char *))) == NULL) {
      fprintf(stderr, "Cannot allocate space for symbol table\n");
      exit(1);
      }

   Token.End_Of_File = FALSE;
   Number_Of_Symbols = 0;
   }


void Terminate_Tokenizer()
   {
   int i;

   if (Symbol_Table != NULL) {
      for (i = 1 ; i < Number_Of_Symbols ; i++)
         free(Symbol_Table[i]);

      free (Symbol_Table);
      }

   if (Data_File != NULL) {
      fclose (Data_File->File);
      free (Data_File->Filename);
      }
   }

/* The main tokenizing routine.  Set up the files and continue parsing
until the end of file */

/* This function performs most of the work involved in tokenizing.  It
   reads the first character of the token and decides which function to
   call to tokenize the rest.  For simple tokens, it simply writes them
   out to the token buffer.  */

/* Read a token from the input file and store it in the Token variable.
If the token is an INCLUDE token, then set the include file name and
read another token. */

void Get_Token ()
  {
  register int c;
  static int token_count = 0, line_count = 0;

  if (Token.Unget_Token)
    {
    Token.Unget_Token = FALSE;
    return;
    }

  if (Token.End_Of_File)
    return;

  Token.Token_Id = END_OF_FILE_TOKEN;

  while (Token.Token_Id == END_OF_FILE_TOKEN) {

     Skip_Spaces (Data_File);
   
     c = getc(Data_File->File);
     if (c == EOF) {
       if (Include_File_Index == 0) {
          Token.Token_Id = END_OF_FILE_TOKEN;
          Token.End_Of_File = TRUE;
          putchar ('\n');
          return;
          }

       Data_File = &Include_Files[--Include_File_Index];
       continue;
       }
   
     String[0] = '\0';
     String_Index  = 0;
   
     switch (c)
       {
       case '\n': Data_File->Line_Number++;
                  break;
   
       case '{' : Parse_Comments(Data_File);
                  break;
   
       case '@' : Write_Token (AT_TOKEN, Data_File);
                  break;
   
       case '&' : Write_Token (AMPERSAND_TOKEN, Data_File);
                  break;
   
       case '`' : Write_Token (BACK_QUOTE_TOKEN, Data_File);
                  break;
   
       case '\\': Write_Token (BACK_SLASH_TOKEN, Data_File);
                  break;
   
       case '|' : Write_Token (BAR_TOKEN, Data_File);
                  break;
   
       case ':' : Write_Token (COLON_TOKEN, Data_File);
                  break;
   
       case ',' : Write_Token (COMMA_TOKEN, Data_File);
                  break;
   
       case '-' : Write_Token (DASH_TOKEN, Data_File);
                  break;
   
       case '$' : Write_Token (DOLLAR_TOKEN, Data_File);
                  break;
   
       case '=' : Write_Token (EQUALS_TOKEN, Data_File);
                  break;
   
       case '!' : Write_Token (EXCLAMATION_TOKEN, Data_File);
                  break;
   
       case '#' : Write_Token (HASH_TOKEN, Data_File);
                  break;
   
       case '^' : Write_Token (HAT_TOKEN, Data_File);
                  break;
   
       case '<' : Write_Token (LEFT_ANGLE_TOKEN, Data_File);
                  break;
   
       case '(' : Write_Token (LEFT_BRACKET_TOKEN, Data_File);
                  break;
   
       case '[' : Write_Token (LEFT_SQUARE_TOKEN, Data_File);
                  break;
   
       case '%' :  Write_Token (PERCENT_TOKEN, Data_File);
                  break;
   
       case '+' : Write_Token (PLUS_TOKEN, Data_File);
                  break;
   
       case '?' : Write_Token (QUESTION_TOKEN, Data_File);
                  break;
   
       case '>' : Write_Token (RIGHT_ANGLE_TOKEN, Data_File);
                  break;
   
       case ')' : Write_Token (RIGHT_BRACKET_TOKEN, Data_File);
                  break;
   
       case ']' : Write_Token (RIGHT_SQUARE_TOKEN, Data_File);
                  break;
   
       case ';' : Write_Token (SEMI_COLON_TOKEN, Data_File);
                  break;
   
       case '\'': Write_Token (SINGLE_QUOTE_TOKEN, Data_File);
                  break;
   
       case '/' : Write_Token (SLASH_TOKEN, Data_File);
                  break;
   
       case '*' : Write_Token (STAR_TOKEN, Data_File);
                  break;
   
       case '~' : Write_Token (TILDE_TOKEN, Data_File);
                  break;
   
       case '"' : Parse_String (Data_File);
                  break;
   
       case '0':   case '1':   case '2':   case '3':   case '4':   case '5':
       case '6':   case '7':   case '8':   case '9':
                  ungetc (c, Data_File->File);
                  if (Read_Float (Data_File) != TRUE)
                     return;
                  break;
   
       case 'a': case 'b': case 'c': case 'd': case 'e': case 'f': case 'g':
       case 'h': case 'i': case 'j': case 'k': case 'l': case 'm': case 'n':
       case 'o': case 'p': case 'q': case 'r': case 's': case 't': case 'u':
       case 'v': case 'w': case 'x': case 'y': case 'z':
       case 'A': case 'B': case 'C': case 'D': case 'E': case 'F': case 'G':
       case 'H': case 'I': case 'J': case 'K': case 'L': case 'M': case 'N':
       case 'O': case 'P': case 'Q': case 'R': case 'S': case 'T': case 'U':
       case 'V': case 'W': case 'X': case 'Y': case 'Z': case '_':
                  ungetc (c, Data_File->File);
                  if (Read_Symbol (Data_File) != TRUE)
                     return;
                  break;

       case '\r':
       case '\032':   /* Control Z - EOF on many systems */
       case '\0': break;

       default:
         fprintf (stderr, "Error in %s line %d\n", Data_File->Filename, Data_File->Line_Number);
         fprintf (stderr, "Illegal character in input file, value is %02x\n", c);
         break;
       }

    if (Token.Token_Id == INCLUDE_TOKEN)
       {
       if (Skip_Spaces (Data_File) != TRUE)
          Token_Error (Data_File, "Expecting a string after INCLUDE\n");

       if ((c = getc(Data_File->File)) != '"')
          Token_Error (Data_File, "Expecting a string after INCLUDE\n");

       Parse_String(Data_File);
       Include_File_Index++;
       if (Include_File_Index > MAX_INCLUDE_FILES)
          Token_Error (Data_File, "Too many nested include files\n");

       Data_File = &Include_Files[Include_File_Index];
       Data_File->Line_Number = 0;

       Data_File->Filename = malloc(strlen(Token.Token_String) + 1);
       if (Data_File->Filename == NULL) {
          fprintf (stderr, "Out of memory opening include file: %s\n",
                   Token.Token_String);
          exit (1);
          }

       strcpy (Data_File->Filename, Token.Token_String);

       if ((Data_File->File = Locate_File (Token.Token_String, "r")) == NULL) {
          fprintf (stderr, "Cannot open include file: %s\n", Token.Token_String);
          exit(1);
          }
       Token.Token_Id = END_OF_FILE_TOKEN;
       }

    }

  token_count++;
  if (token_count > 1000) {
    token_count = 0;
    putchar('.');
    fflush(stdout);
    line_count++;
    if (line_count > 78) {
       line_count = 0;
       putchar ('\n');
       }
    }
  return;
  }


/* Mark that the token has been put back into the input stream.  The next
call to Get_Token will return the last-read token instead of reading a
new one from the file. */

void Unget_Token ()
  {
  Token.Unget_Token = TRUE;
  }

/* Skip over spaces in the input file */

int Skip_Spaces (Data_File)
  DATA_FILE *Data_File;
  {
  register int c;

  while (TRUE)
    {
    c = getc(Data_File->File);
    if (c == EOF)
      return (FALSE);

    if (!(isspace(c) || c == 0x0A))
      break;

    if (c == '\n')
       Data_File->Line_Number++;
    }

  ungetc (c, Data_File->File);
  return (TRUE);
  }

/* Comments start with an open brace ({) and end with a close brace (}).
   The open brace has been read already.  Continue reading until a close
   brace is encountered. Be sure to count the lines while you're at it.
   Incidently, nested comments are supported (in case you do such esoteric
   things) */

int Parse_Comments (Data_File)
  DATA_FILE *Data_File;
  {
  register int c;
  int End_Of_Comment;
  
  End_Of_Comment = FALSE;
  while (!End_Of_Comment)
    {
    c = getc (Data_File->File);
    if (c == EOF)
      {
      Token_Error (Data_File, "No closing comment found");
      return (FALSE);
      }

    if (c == (int) '\n')
      Data_File->Line_Number++;

    if (c == (int) '{')
      CALL (Parse_Comments(Data_File))
    else
      End_Of_Comment = (c == (int) '}');
    }

  return (TRUE);
  }

/* The following routines make it easier to handle strings.  They stuff
   characters into a string buffer one at a time making all the proper
   range checks.  Call Begin_String to start, Stuff_Character to put
   characters in, and End_String to finish.  The String variable contains
   the final string. */

void Begin_String()
  {
  String_Index = 0;
  }

void Stuff_Character (c, Data_File)
  int c;
  DATA_FILE *Data_File;
  {
  if (String_Index < MAX_STRING_INDEX)
    {
    String [String_Index++] = (char) c;
    if (String_Index >= MAX_STRING_INDEX)
      {
      Token_Error (Data_File, "String too long");
      String [String_Index-1] = '\0';
      }
    }
  }

void End_String (Data_File)
  DATA_FILE *Data_File;
  {
  Stuff_Character ((int) '\0', Data_File);
  }

/* Read a float from the input file and tokenize it as one token. The phase
   variable is 0 for the first character, 1 for all subsequent characters
   up to the decimal point, and 2 for all characters after the decimal
   point.  This helps to insure that the number is formatted properly. */

int Read_Float(Data_File)
  DATA_FILE *Data_File;
  {
  register int c, Finished, Phase;

  Finished = FALSE;
  Phase = 0;

  Begin_String();
  while (!Finished)
    {
    c = getc(Data_File->File);
    if (c == EOF)
      {
      Token_Error (Data_File, "Unexpected end of file");
      return (FALSE);
      }

    switch (Phase)
      {
      case 0: if (isdigit(c))
                Stuff_Character(c, Data_File);
              else
                if (c == '.') {
                   Stuff_Character('0', Data_File);
                   ungetc (c, Data_File->File);
                   }
                else
                   Token_Error (Data_File, "Error in decimal number");
              Phase = 1;
              break;
     
      case 1: if (isdigit(c))
                Stuff_Character(c, Data_File);
              else if (c == (int) '.')
                {
                Stuff_Character(c, Data_File);
                Phase = 2;
                }
              else if ((c == 'e') || (c == 'E')) {
                Stuff_Character(c, Data_File);
                Phase = 3;
                }
              else
                Finished = TRUE;
              break;

      case 2: if (isdigit(c))
                Stuff_Character(c, Data_File);
              else if ((c == 'e') || (c == 'E')) {
                Stuff_Character(c, Data_File);
                Phase = 3;
                }
              else
                Finished = TRUE;
              break;

      case 3: if (isdigit(c) || (c == '-'))
                Stuff_Character(c, Data_File);
              else
                Finished = TRUE;
      }
    }

  ungetc (c, Data_File->File);
  End_String(Data_File);

  Write_Token (FLOAT_TOKEN, Data_File);
  sscanf (String, DBL_FORMAT_STRING, &Token.Token_Float);

  return (TRUE);
  }

/* Parse a string from the input file into a token. */
void Parse_String (Data_File)
  DATA_FILE *Data_File;
  {
  register int c;

  Begin_String();
  while (TRUE)
    {
    c = getc(Data_File->File);
    if (c == EOF)
      Token_Error (Data_File, "No end quote for string");

    if (c != (int) '"')
      Stuff_Character (c, Data_File);
    else
      break;
    }
  End_String(Data_File);

  Write_Token (STRING_TOKEN, Data_File);
  Token.Token_String = String;
  }

/* Read	in a symbol from the input file.  Check to see if it is a reserved
   word.  If it is, write out the appropriate token.  Otherwise, write the
   symbol out to the Symbol file and write out an IDENTIFIER token. An
   Identifier token is a token whose token number is greater than the
   highest reserved word. */

int Read_Symbol (Data_File)
  DATA_FILE *Data_File;
  {
  register int c, Symbol_Id;

  Begin_String();
  while (TRUE)
    {
    c = getc(Data_File->File);
    if (c == EOF)
      {
      Token_Error (Data_File, "Unexpected end of file");
      return (FALSE);
      }

    if (isalpha(c) || isdigit(c) || c == (int) '_')
      Stuff_Character (c, Data_File);
    else
      {
      ungetc (c, Data_File->File);
      break;
      }
    }
  End_String(Data_File);

  if ((Symbol_Id = Find_Reserved()) != -1)
     Write_Token (Symbol_Id, Data_File);
  else
    {
    if ((Symbol_Id = Find_Symbol()) == -1)
      if (++Number_Of_Symbols < MAX_SYMBOLS)
        {
        if ((Symbol_Table[Number_Of_Symbols] = malloc (strlen(String)+1)) == NULL)
           Token_Error (Data_File, "Cannot allocate space for identifier");

        strcpy (Symbol_Table[Number_Of_Symbols], String);
        Symbol_Id = Number_Of_Symbols;
        }
      else
        {
        fprintf (stderr, "\nToo many symbols\n");
        exit(1);
        }

    Write_Token (LAST_TOKEN + Symbol_Id, Data_File);
    }

  return (TRUE);
  }

/* Return the index the token in the reserved words table or -1 if it
   isn't there. */

int Find_Reserved ()
  {
  register int i;

  for (i = 0 ; i < LAST_TOKEN ; i++)
    if (strcmp (Reserved_Words[i].Token_Name, &(String[0])) == 0)
      return (Reserved_Words[i].Token_Number);

  return (-1);
  }

/* Check to see if a symbol already exists with this name.  If so, return
    its symbol ID. */

int Find_Symbol ()
  {
  register int i;

  for (i = 1 ; i <= Number_Of_Symbols ; i++)
    if (strcmp (Symbol_Table[i], String) == 0)
      return (i);

  return (-1);
  }

/* Write a token out to the token file */
void Write_Token (Token_Id, Data_File)
  TOKEN Token_Id;
  DATA_FILE *Data_File;
  {
  Token.Token_Id = Token_Id;
  Token.Token_Line_No = Data_File->Line_Number;
  Token.Filename = Data_File->Filename;
  Token.Token_String = String;

  if (Token.Token_Id > LAST_TOKEN)
    {
    Token.Identifier_Number = (int) Token.Token_Id - (int) LAST_TOKEN;
    Token.Token_Id = IDENTIFIER_TOKEN;
    }
  }

/* Report an error */
void Token_Error (Data_File, str)
  DATA_FILE *Data_File;
  char *str;
  {
  fprintf(stderr, "Error in %s line %d\n", Data_File->Filename, Data_File->Line_Number);
  fputs(str, stderr);
  fputs("\n\n", stderr);
  exit(1);
  }

