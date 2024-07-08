/*****************************************************************************
*
*                                   amiga.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module handles all of the Amiga-specific code for the raytracer.
*
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
#include "dkbproto.h"

#include <proto/exec.h>
#include <proto/intuition.h>
#include <proto/graphics.h>
#include <proto/dos.h>
#include <exec/types.h>
#include <intuition/intuition.h>
#include <graphics/display.h>

void geta4(void);
void Requestor_Handler(void);
void Amiga_open(void);
void Amiga_close(void);
void open_requestor(void);
void close_requestor(void);
void write_byte(int x, int y, unsigned char n);
void write_hame_pixel(int x, int y, char Red, char Green, char Blue);

void write_cookie(unsigned char *brand, int line);
void make_hame_palette(struct ViewPort *vp);
void SetRGB8 (short reg, unsigned char rr, unsigned char gg,
              unsigned char bb, short base);

extern int Options;
extern char DisplayFormat;

#define INT_REV 29L
#define GR_REV 29L

struct IntuitionBase *IntuitionBase;
struct GfxBase *GfxBase;
struct Screen *s;
volatile struct Window *w;
struct Task *Requestor_Task;

volatile int Requestor_Running;
volatile extern int Stop_Flag;

#define SCREEN_WIDTH 320
#define SCREEN_HEIGHT 400

#define HAME_SCREEN_WIDTH 640
#define HAME_SCREEN_HEIGHT 402

struct NewScreen Ham_Screen =
   {
   0, 0,
   SCREEN_WIDTH, SCREEN_HEIGHT,
   6,
   0, 1,
   INTERLACE | HAM,
   SCREENQUIET,
   NULL,
   (UBYTE *) "DKB Ray Trace",
   NULL,
   NULL
   };


struct NewScreen Ham_E_Screen =
   {
   0, 0,
   HAME_SCREEN_WIDTH, HAME_SCREEN_HEIGHT,
   4,
   0, 1,
   INTERLACE | HIRES,
   SCREENQUIET,
   NULL,
   (UBYTE *) "DKB Ray Trace",
   NULL,
   NULL
   };

int lacer; /* if non-zero, screen is an interlace screen. Set this... */
           /* ...as soon as you open your HAM-E screen.               */

unsigned char *fp0,*fp1,*fp2,*fp3; /* These are pointers which have been... */
                                   /* ...cached from the screens BitMap[]   */
                                   /* ...array. This allows us to get at    */
                                   /* ...them much faster. Set them as soon */
                                   /* ...as you open your HAM-E screen.     */

unsigned char bitpat[] =    /* This table is used as a table of masks... */
  {                         /* ...to isolate bits in the HAM-E pixels    */
    128,64,32,16,8,4,2,1,
  };

unsigned char ham_cookie[] =  /* ham mode cookie... preceeds any HAM...    */
  {                           /* ...color registers, and triggers hardware */
    0xA2,0xF5,0x84,0xDC,      /* ...into ham mode.                         */
    0x6D,0xB0,0x7F,0x18
  };

struct Window *Requestor_Window;
volatile struct MsgPort *Requestor_Port;

struct IntuiText chip Body_Text =
   {0, 1, JAM1, 5, 10, NULL, (UBYTE *) "Click to abort the picture", NULL};

struct IntuiText chip Abort_Text =
   {0, 1, JAM1, 5, 3, NULL, (UBYTE *) "Abort", NULL};

UWORD chip ColorTbl[16] = { 0x000, 0x111, 0x222, 0x333, 0x444, 0x555, 0x666,
                       0x777, 0x888, 0x999, 0xaaa, 0xbbb, 0xccc, 0xddd,
                       0xeee, 0xfff };

LONG last_red = 0, last_green = 0, last_blue = 0, last_y = -1;

void amiga_init_dkb_trace(void )
   {
   (void) onbreak(amiga_close_all);
   }

int matherr (x)
   struct exception *x;
   {
   printf ("Math error type: %d from function %s values: %g %g\n",
           x->type, x->name, x->arg1, x->arg2);

   switch(x->type) 
     {
     case DOMAIN:
     case OVERFLOW:
        x->retval = 1.0e17;
        break;

     case SING:
     case UNDERFLOW:
        x->retval = 0.0;
        break;

     case TLOSS:
     case PLOSS:
        return (0);

     default:
        break;
     }
   return(1);
   }

void Requestor_Handler ()
   {
   Requestor_Port = CreatePort ("ray trace port", 0L);
   Requestor_Window = BuildSysRequest
             (NULL, &Body_Text, NULL, &Abort_Text, GADGETUP, 280L, 60L);
   Wait ((1 << Requestor_Port -> mp_SigBit)
          | (1 << Requestor_Window -> UserPort -> mp_SigBit));

   Requestor_Running = FALSE;
   Stop_Flag = TRUE;
   }

void Amiga_open()
   {
   IntuitionBase = (struct IntuitionBase *) OpenLibrary ("intuition.library",INT_REV);
   if (IntuitionBase == NULL)
     exit(FALSE);

   GfxBase = (struct GfxBase *) OpenLibrary ("graphics.library", GR_REV);
   if (GfxBase == NULL)
     exit(FALSE);
   Requestor_Running = FALSE;
   }

void Amiga_close()
   {
   if (Requestor_Running) {
      Signal (Requestor_Task, 1 << Requestor_Port -> mp_SigBit);
      Delay (2L);
      }

   if (Requestor_Window)
      FreeSysRequest (Requestor_Window);

   Requestor_Window = NULL;

   CloseLibrary (GfxBase) ;
   CloseLibrary (IntuitionBase) ;
   }

void open_requestor()
   {
   Requestor_Window = NULL;
   Stop_Flag = FALSE;
   Requestor_Running = TRUE;
   Requestor_Task = CreateTask ("Raytrace Requestor", 2L,
                                (APTR) Requestor_Handler, 20000L);
   }

void display_finished ()
   {
   if (Requestor_Running) {
     Signal (Requestor_Task, 1 << Requestor_Port -> mp_SigBit);
     Delay (2L);
     }

   if (Requestor_Window)
      FreeSysRequest (Requestor_Window);

   Requestor_Window = NULL;
   if (Options & PROMPTEXIT)
      {
      printf ("Finished.\nPress CR to quit.\n");
      getchar();
      }
   }

/*:
.n write_byte()
.k low_level write_byte byte_write write_pixel
.b

SYNOPSIS:   void write_byte(x,y,n);
                short x;
                int y;
                unsigned char n;

FUNCTION:   This function is similar to the Amiga's WritePixel routine.
            is simply takes the incoming position and value and writes
            them to the HAM-E screen appropriately.

INPUTS:     x - horizontal position on screen.
            y - vertical position on screen.
            n - value 0-255 to write in the pixel.

RESULTS:    None

BUGS:       None Known.

LIMITATIONS:Hard coded for screen width of 320 pixels (640 hi-res pixels)

SEE ALSO:   Global variables "fp3", "fp2", "fp1", "fp0", "bitpat[]"

:*/

void write_byte(x,y,n)
  int x;
  int y;
  unsigned char n;
  {
  register int ypos,byte_offset;
  register short bit_offset;
    ypos = y * 80; /* index to correct scan line - note hard coded width! */
    bit_offset = (x << 1) & 7; /* find base bit position */
    byte_offset = (x >> 2);   /* find base byte offset */
    if (n & 128) *(fp3 + ypos + byte_offset) |= bitpat[bit_offset];
            else *(fp3 + ypos + byte_offset) &= ~bitpat[bit_offset];
    if (n &  64) *(fp2 + ypos + byte_offset) |= bitpat[bit_offset];
            else *(fp2 + ypos + byte_offset) &= ~bitpat[bit_offset];
    if (n &  32) *(fp1 + ypos + byte_offset) |= bitpat[bit_offset];
            else *(fp1 + ypos + byte_offset) &= ~bitpat[bit_offset];
    if (n &  16) *(fp0 + ypos + byte_offset) |= bitpat[bit_offset];
            else *(fp0 + ypos + byte_offset) &= ~bitpat[bit_offset];
    bit_offset++; /* to next nybble */
    if (bit_offset == 8) /* carry into next byte? */
      {
        bit_offset=0;
        byte_offset++;
      }
    if (n & 8) *(fp3 + ypos + byte_offset) |= bitpat[bit_offset];
          else *(fp3 + ypos + byte_offset) &= ~bitpat[bit_offset];
    if (n & 4) *(fp2 + ypos + byte_offset) |= bitpat[bit_offset];
          else *(fp2 + ypos + byte_offset) &= ~bitpat[bit_offset];
    if (n & 2) *(fp1 + ypos + byte_offset) |= bitpat[bit_offset];
          else *(fp1 + ypos + byte_offset) &= ~bitpat[bit_offset];
    if (n & 1) *(fp0 + ypos + byte_offset) |= bitpat[bit_offset];
          else *(fp0 + ypos + byte_offset) &= ~bitpat[bit_offset];
  }

/*:
.n write_cookie()
.k cookie low_level setup configure
.b

SYNOPSIS:   void write_cookie(brand,line);
                unsigned char *brand;
                int line;

FUNCTION:    This function writes the cookie on a particular line.
             The variable "brand" is a pointer to an arrary of data
             that contains the particular cookie for the mode you want.
             These arrays are the global ones "ham_cookie[]" and
             "reg_cookie[]".
             
             Call as:
             
                  write_cookie(ham_cookie,line);
                              -or-
                  write_cookie(reg_cookie,line);
             
             Note: If you have a four line palette, you need to call
             this function for each successive line the palette exists
             upon, for example:
             
                  write_cookie(reg_cookie,0);
                  write_cookie(reg_cookie,1);
                  write_cookie(reg_cookie,2);
                  write_cookie(reg_cookie,3);
                  
                        -or-
                  
                  for (i=0; i<4; i++)
                    {
                      write_cookie(reg_cookie,i);
                    }
             
             If the global variable "lacer" is set, this function will
             write the cookie data on the appropriate lines in both
             fields... sending four lines of cookie to the function
             with the lines 0,1,2,3 will write cookies on line pairs
             0-1, 2-3, 4-5, and 6-7.

INPUTS:     A pointer to the apropriate cookie and the line to put it on.

RESULTS:    None

BUGS:       None Known.

LIMITATIONS:None Known.

SEE ALSO:   The global variable "lacer" and the "ham_cookie[]"
            and reg_cookie[] global arrays.

:*/
void write_cookie(brand,line)
  unsigned char *brand;
  int line;
  {
  int i;
    if (lacer) /* we need double the cookie data! */
      {
        for (i=0; i<8; i++)
          {
            write_byte(i,line*2,brand[i]);
            write_byte(i,(line*2)+1,brand[i]);
          }
      }
    else
      {
        for (i=0; i<8; i++)
          {
            write_byte(i,line,brand[i]);
          }
      }
  }

/*:
.n make_hame_palette()
.k amiga_palette palette_amiga setup configure
.b

SYNOPSIS:   void make_hame_palette(vp);
                struct ViewPort *vp;

FUNCTION:   Sets palette for Amiga side of hardware: The palette here is
            designed to achieve two independant goals. First, and most
            importantly, it creates a situation where the IRGB lines at
            the Amiga's data port will exactly mirror the data in the
            bitplanes of the screen as each pixel is emitted. 
            Secondly, this palette makes the images visible, if not
            sensible, on a non HAM-e equipped Amiga... Hopefully this
            distinctive color palette will quickly cue the user that
            they are missing something good. :^)
            
            IRGB to 12 bit correspondence:
            
            bit 8 - b3 of red
            bit 4 - b3 of green
            bit 2 - b3 of blue
            bit 1 - b0 of blue

INPUTS:     A pointer to the ViewPort that "belongs" to this screen.

RESULTS:    None

BUGS:       None Known.

LIMITATIONS:None Known.

SEE ALSO:   

:*/
void make_hame_palette(vp)
  struct ViewPort *vp;
  {
  int rr,gg,bb,i;
  int col;
    col=0;
    for (i=0; i<16; i++)
      {
        rr=0; gg=0; bb=0;
        if (i & 8) rr  = 8; /* this builds the IRGB bit outputs...   */
        if (i & 4) gg  = 8; /* ...these four bits are all that are   */
        if (i & 2) bb  = 8; /* ...required to make the HAM-E run,    */
        if (i & 1) bb |= 1; /* ...they xfer b0->b3 to the IRGB lines */
        if (i != 0)     /* we don't mess with c0 - we leave it black */
          {
            rr += (col & 7); /* build strange colors in cregs 1-15...  */
            col += 2;        /* ...these extra bits sent to the color  */
            gg += (col & 7); /* ...registers make amiga palette very   */
            col += 2;        /* ...interesting to look at if the HAM-E */
            bb += (col & 6); /* ...is NOT attached. Otherwise useless. */
            col += 2;        /* ...The code in this "if" is optional.  */
          }
        SetRGB4(vp,i,rr,gg,bb); /* this actually sets the Amiga color regs */
      }
  }

/*:
.n SetRGB8()
.k palette_hame hame_palette setup configure
.b

SYNOPSIS:   void SetRGB8(reg,rr,gg,bb,base);
                int reg,rr,gg,bb,base;

FUNCTION:   This routine sets the color registers in the HAM-E hardware.
            It can handle color registers located at any point on screen,
            by setting the "base" variable to the starting scan line where
            the color registers exist. Normally, the cookie and it's
            associated color registers are located beginning at scan line 0.
            If the screen is an interlace screen, this routine will set both
            set of color registers identically; when in interlace, the
            HAM-E maintains separate sets of color registers for the
            odd and even interlace fields. Since this routine sets both
            sets of color registers identically, you don't have to
            worry about dealing with this feature.
            
INPUTS:     reg  - the color register number from 0 to 255 to be set
            rr   - the red value from 0-255
            gg   - the green value from 0-255
            bb   - the blue value from 0-255
            base - the starting scan line of the first coookie position
                   (usually zero)

RESULTS:    None

BUGS:       None Known.

LIMITATIONS:None Known.

SEE ALSO:   The global variable "lacer"

:*/
void SetRGB8(reg,rr,gg,bb,base)
  short reg;
  unsigned char rr,gg,bb;
  short base;
  {
  short p_row,p_index;
    p_row = (reg >> 6) + base;           /* palette row 0-3.  */
    p_index = ((reg & 0x3f) * 3) + 8;    /* reg 0-63 in p_row */
    if (lacer) /* then we need both fields! */
      {
        /* for the even field: */
        write_byte(p_index,   p_row*2, rr);         /* put RED value     */
        write_byte(p_index+1, p_row*2, gg);         /* put GREEN value   */
        write_byte(p_index+2, p_row*2, bb);         /* put BLUE value    */
        
        /* here is the stuff for the ODD field: */
        write_byte(p_index,   (p_row*2)+1, rr);     /* put RED value     */
        write_byte(p_index+1, (p_row*2)+1, gg);     /* put GREEN value   */
        write_byte(p_index+2, (p_row*2)+1, bb);     /* put BLUE value    */
      }
    else /* just write to one field */
      {
        write_byte(p_index,   p_row, rr);     /* put RED value     */
        write_byte(p_index+1, p_row, gg);     /* put GREEN value   */
        write_byte(p_index+2, p_row, bb);     /* put BLUE value    */
      }
  }

void display_init (width, height)
   int width, height;
   {
   Amiga_open();
   open_requestor();

   Delay (10);

   if (DisplayFormat == 'E') {
      if ((s = (struct Screen *) OpenScreen (&Ham_E_Screen)) == NULL)
         exit (FALSE);
      ShowTitle (s, FALSE);
      lacer = 1;
      fp0 = s->BitMap.Planes[0];
      fp1 = s->BitMap.Planes[1];
      fp2 = s->BitMap.Planes[2];
      fp3 = s->BitMap.Planes[3];
      make_hame_palette(&s->ViewPort);
      SetAPen (&(s->RastPort), 0L);
      RectFill (&(s -> RastPort), 0L, 0L, HAME_SCREEN_WIDTH-1, 1);
      SetAPen (&(s->RastPort), 1L);
      RectFill (&(s -> RastPort), 0L, 2L, HAME_SCREEN_WIDTH-1, HAME_SCREEN_HEIGHT-1);
      write_cookie(ham_cookie, 0);
      SetRGB8 (0x11, 0x80, 0x80, 0x80, 0);
      }
   else {
      if ((s = (struct Screen *) OpenScreen (&Ham_Screen)) == NULL)
         exit (FALSE);

      ShowTitle (s, FALSE);

      LoadRGB4 (&(s->ViewPort), ColorTbl, 16L);
      SetAPen (&(s->RastPort), 7L);
      RectFill (&(s -> RastPort), 0L, 0L, 319L, 399L);
      }
   }

void display_close ()
   {
   if (Requestor_Running) {
      Signal (Requestor_Task, 1 << Requestor_Port -> mp_SigBit);
      Delay (2L);
      }

   if (Requestor_Window)
      FreeSysRequest (Requestor_Window);

   Requestor_Window = NULL;

   CloseScreen (s);
   }

#define absdif(x,y) ((x > y) ? (x - y) : (y - x))
#define max3(x,y,z) ((x>y)?((x>z)?1:3):((y>z)?2:3))

void write_hame_pixel (x, y, Red, Green, Blue)
   int x, y;
   char Red, Green, Blue;
   {
   register unsigned char colour;
   short delta_red, delta_green, delta_blue;

   if ((x >= SCREEN_WIDTH )  || (y >= SCREEN_HEIGHT))
      return;

   Red = (Red >> 2) & 0x3F;
   Green = (Green >> 2) & 0x3F;
   Blue = (Blue >> 2) & 0x3F;

   if (last_y != y) {
      last_y = y;
      last_red = last_green = last_blue = 0;
      }

   delta_red = absdif (Red, last_red);
   delta_green = absdif (Green, last_green);
   delta_blue = absdif (Blue, last_blue);

   switch (max3(delta_red, delta_green, delta_blue)) {
      case 1:
         last_red = Red;
         colour = 0x80 + Red;
         break;
      case 2:
         last_green = Green;
         colour = 0xc0 + Green;
         break;
      case 3:
         last_blue = Blue;
         colour = 0x40 + Blue;
         break;
      }

   write_byte (x, y+2, colour);
   }

void display_plot (x, y, Red, Green, Blue)
   int x, y;
   char Red, Green, Blue;
   {
   register short colour, index, mask, i, colour_mask;
   register char *addr;
   short delta_red, delta_green, delta_blue;

   if (DisplayFormat == 'E')
      return (write_hame_pixel(x, y, Red, Green, Blue));

   if ((x >= SCREEN_WIDTH )  || (y >= SCREEN_HEIGHT))
      return;

   Red = (Red >> 4) & 0x0F;
   Green = (Green >> 4) & 0x0F;
   Blue = (Blue >> 4) & 0x0F;

   if (last_y != y) {
      last_y = y;
      last_red = last_green = last_blue = 0;
      }

   delta_red = absdif (Red, last_red);
   delta_green = absdif (Green, last_green);
   delta_blue = absdif (Blue, last_blue);

   switch (max3(delta_red, delta_green, delta_blue)) {
      case 1:
         last_red = Red;
         colour = 0x20 + Red;
         break;
      case 2:
         last_green = Green;
         colour = 0x30 + Green;
         break;
      case 3:
         last_blue = Blue;
         colour = 0x10 + Blue;
         break;
      }

   index = (SCREEN_WIDTH >> 3) * y + (x >> 3);
   mask = 0x80 >> (x & 7);

   colour_mask = 1;

   for (i = 0 ; i < 6 ; i++) {
      addr = &s->BitMap.Planes[i][index];
      *addr &= ~mask;
      *addr |= (colour&colour_mask) ? mask : 0x00;
      colour_mask <<= 1;
      }
   }

int amiga_close_all ()
   {
   close_all();
   return (1);
   }
