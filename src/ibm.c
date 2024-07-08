/*****************************************************************************
*
*                                      ibm.c
*
*   from DKBTrace (c) 1990  David Buck
*
*  This module implements the IBM-specific routines for DKBTrace.
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
*     ATX              (613) 526-4141
*     OMX              (613) 731-3419
*     Mystic           (613) 731-0088 or (613) 731-6698
*
*  Fidonet:   1:163/109.9
*  Internet:  David_Buck@Carleton.CA
*  The "You Can Call Me RAY" BBS    (708) 358-5611
*
*  IBM Port by Aaron A. Collins. Aaron may be reached on the following BBS'es:
*
*     The "You Can Call Me RAY" BBS (708) 358-5611
*     The Information Exchange BBS  (708) 945-5575
*
*****************************************************************************/

/* Original IBM VGA "colour" output routines for MS/DOS by Aaron A. Collins.

   This will deliver approximate colorings using HSV values for the selection.
   The pallette map is divided into 4 parts - upper and lower half generated
   with full and half "value" (intensity), respectively.  These halves are
   further halved by full and half saturation values of each range (pastels).
   There are three constant colors, black, white, and grey.  They are used
   when the saturation is low enough that the hue becomes undefined, and which
   one is selected is based on a simple range map of "value".  Usage of the
   pallette is accomplished by converting the requested color RGB into an HSV
   value.  If the saturation is too low (< .25) then black, white or grey is
   selected.  If there is enough saturation to consider looking at the hue,
   then the hue range of 1-63 is scaled into one of the 4 pallette quadrants
   based on its "value" and "saturation" characteristics.

   Further SVGA, MVGA mods by Aaron A. Collins:
   SVGA, MVGA assembler routines originally by John Bridges.
   VESA assembler routines from FRACTINT, by The Stone Soup Group
   AT&T VDC600 SVGA mods to DKB Trace 2.01 module IBM.C by John Gooding

   This file now represents the collective wisdom of the VGAKIT34 package,
   with support for all of the SVGA types known to mankind.  Seriously,
   VGAKIT34 is an excellent technical reference for IBM programmers wishing
   to do any sort of SVGA video access, and it encompasses nearly all of the
   SVGA adapters in use today.  It was written by John Bridges, a.k.a.
   CIS:73307,606, GENIE:J.BRIDGES.  It was originally coded in IBM 80x86
   assembler, and since DKBTrace is a completely "C"-based package, I have
   converted John's assembler routines all into "C".  These may be a tad bit
   slower, but they should be compatible across a wide variety of 80x86/(S)VGA
   machines.  Note if you have a regular cheapo VGA card like myself, included
   is "MODE13x" or MVGA (modified VGA) mode (some call it "tweaked", but I
   call it "Simulated SVGA"), which gives 360x480 on any reasonably register-
   compatible plain vanilla VGA card.  This mode gives a good simulated 640 by
   480 screen resolution.  I did not implement all the neat hi-res modes of
   all the various SVGA adapters, if you select a trace size bigger than the
   program and/or card can handle (most likely 640x480), it is dynamically
   scaled to fit the available resolution, so you'll be able to see a rough
   approximation of an 800x600 trace even on any el-cheapo VGA card at 320x200
   resolution.  The VESA VGA mode was freely adapted from FRACTINT, whose GIF
   reading routines we are already using in DKBTrace.  I hope my conversion
   of it works properly.

   There is still a reported problem with the EVEREX autodetect returning
   TRIDENT.  In fact EVEREX uses a TRIDENT chip set, but apparently there
   is some difference in operation.  There are cryptic diagnostic messages
   such as T0000, etc. printed as a result of the autodetection routines
   to help track down why the error is happening.  If you are experiencing
   problems with EVEREX or TRIDENT, make note of the letter-4 digit code you
   are given.  There is now an autodetect for VDC600 that I hope will work
   universally.  A similar problem as the EVEREX exists, in that the VDC600
   is detected as a PARADISE because it uses the PARADISE chip set.  I am now
   looking for what I believe to be the model number in the BIOS ROM of the
   VDC600 to differentiate between the two.  I hope this works  with all
   VDC600's, as I only had one example to work from.  Please send all bug
   reports to Aaron Collins at the "You Can Call Me RAY" BBS, the number is
   above in the header of this and the other DKB source files.
*/

#include "frame.h"
#include "dkbproto.h"
#include <dos.h>	/* MS-DOS specific - for int86() REGS struct, etc. */

#ifdef TURBOC
#include <sys\time.h>
extern unsigned _stklen = 12288;   /* HUGE stack for HEAVY recursion */
#else
#include <time.h>
#endif


/* The supported VGA adapter types 1 - 9, A - G.  0 is for auto-detect. */

#define	BASIC_VGA	1		/* 1 - Tested: AAC */
#define	MODE13x		2		/* 2 - Tested: AAC */
#define	TSENG3		3		/* 3 - Tested: William Minus */
#define	TSENG4		4		/* 4 - Tested: William Minus */
#define	VDC600		5		/* 5 - Tested: John Gooding */
#define	OAKTECH		6		/* 6 - Untested */
#define	VIDEO7		7		/* 7 - Untested */
#define CIRRUS		8		/* 8 - Tested: AAC */
#define	PARADISE	9		/* 9 - Tested: John Degner */
#define	AHEADA		17		/* A - Untested */
#define	AHEADB		18		/* B - Untested */
#define	CHIPSTECH	19		/* C - Untested */
#define	ATIVGA		20		/* D - Tested: William Earl */
#define	EVEREX		21		/* E - Tested: A+B problem - Larry Minton */
#define	TRIDENT		22		/* F - Untested */
#define VESA		23		/* G - Untested */


#define	MISCOUT		0x3c2		/* VGA chip msic output reg. addr */
#define	SEQUENCER	0x3c4		/* VGA chip sequencer register addr */
#define	CRTC		0x3d4		/* VGA chip crt controller reg addr */


char *vga_names[] = 
    {
    "",
    "(1) Standard VGA",
    "(2) Simulated SVGA",
    "(3) Tseng Labs 3000 SVGA",
    "(4) Tseng Labs 4000 SVGA",
    "(5) AT&T VDC600 SVGA",
    "(6) Oak Technologies SVGA",
    "(7) Video 7 SVGA",
    "(8) Video 7 Vega (Cirrus) VGA",
    "(9) Paradise SVGA",
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    "(A) Ahead Systems Ver. A SVGA",
    "(B) Ahead Systems Ver. B SVGA",
    "(C) Chips & Technologies SVGA",
    "(D) ATI SVGA",
    "(E) Everex SVGA",
    "(F) Trident SVGA",
    "(G) VESA Standard SVGA Adapter"
    };


unsigned int vptbl[] =		/* CRTC register values for MODE13x */
    {
    0x6b00,	/* horz total */
    0x5901,	/* horz displayed */
    0x5a02,	/* start horz blanking */
    0x8e03U,	/* end horz blanking */
    0x5e04,	/* start h sync */
    0x8a05U,	/* end h sync */
    0x0d06,	/* vertical total */
    0x3e07,	/* overflow */
    0x4009,	/* cell height */
    0xea10U,	/* v sync start */
    0xac11U,	/* v sync end and protect cr0-cr7 */
    0xdf12U,	/* vertical displayed */
    0x2d13,	/* offset */
    0x0014,	/* turn off dword mode */
    0xe715U,	/* v blank start */
    0x0616,	/* v blank end */
    0xe317U	/* turn on byte mode */
};


int screen_height, screen_width;
int svga_width = 640;		/* default SVGA width/height, */
int svga_height = 480;		/* unless we find otherwise... */
int lastx, lasty, lastline;	/* Pixel / Line Caches */
int whichvga = BASIC_VGA;	/* BASIC_VGA mode by default */
int vga_512K = FALSE;		/* Flag for whether or not >= 512K VGA mem */
unsigned char svga_cur = 255;
unsigned char vesa_granularity = 1;	/* VESA default to 64K granules */
void (_cdecl *vesa_bankswitch)(void);	/* ptr to VESA bankswitch function */
unsigned char answer[257];		/* answer area for VESA BIOS calls */

extern unsigned int Options;
extern char DisplayFormat;

int auto_detect_vga(void);
int cirrus(void);
int chkbk(unsigned int);
int gochk(unsigned int, unsigned int);
void pdrsub(unsigned char);
void pallete_init(void);
void newbank(void);
void set_pallette_register(unsigned, unsigned, unsigned, unsigned);
void hsv_to_rgb(DBL, DBL, DBL, unsigned *, unsigned *, unsigned *);
void rgb_to_hsv(unsigned, unsigned, unsigned, DBL *, DBL *, DBL *);
int _cdecl matherr(struct exception *);


void display_init(width, height) /* Set video to requested or best mode */
int width, height;
   {
   union REGS inr, outr;
   unsigned char far *fp;
   unsigned u;
   int i;
   long l, lt;

   lastline = -1;		/* make sure we display the 1st line... */
   screen_height = height;
   screen_width = width;
   if (DisplayFormat != '0')	/* if not 0, some display type specified */
	whichvga = DisplayFormat - '0';		/* de-ASCII-fy selection */
   else
	{
	whichvga = auto_detect_vga();
	printf("VGA detected: %s, with %s 512K RAM\n", vga_names[whichvga], vga_512K ? ">=" : "<");
	lt = l = time(&l);
	while (time(&l) < lt + 3)	/* display VGA type for 3 secs */
	    ;
	if (!vga_512K)			/* not enough RAM for 640 x 480? */
	    whichvga = MODE13x;		/* then try for next best mode... */
	}

	if (whichvga == CIRRUS)		/* Register Compatible VGA? */
	     whichvga = MODE13x;	/* MODE13x if > 320x200, else... */

	if (screen_height <= 200 || screen_width <= 320)
	whichvga = BASIC_VGA;		/* BASIC_VGA if <= 320x200 */

   switch (whichvga)
	{
	case MODE13x:
	    inr.x.ax = 0x0013;   /* setup to VGA 360x480x256 (mode 13X) */
	    int86(0x10, &inr, &outr);   /* then we'll tweak the VGA! */

	    outpw(SEQUENCER, 0x0604);   /* disable chain 4 */
	    outpw(SEQUENCER, 0x0f02);   /* allow writes to all planes */

	    for (u = 0; u < 43200; u++) /* clear the whole screen */
	        {
		fp = MK_FP(0xa000, u);
		*fp = 0;		    /* set all bytes to 0 */
		}

	    outpw(SEQUENCER, 0x0100);   /* synchronous reset */
	    outp(MISCOUT, 0xe7);	    /* use 28 mhz dot clock */
	    outpw(SEQUENCER, 0x0300);   /* restart sequencer */
	    outp(CRTC, 0x11);	    /* ctrl register 11, please */
	    outp(CRTC+1, inp(CRTC+1) & 0x7f); /* write-prot cr0-7 */

	    for (i = 0; i < 17; i++)    /* write CRTC register array */
		outpw(CRTC, vptbl[i]);
	    svga_width = 360;		/* Fake 640 mode actually is 360 */
	    break;
	case VDC600:
	    inr.x.ax = 0x005E;   /* setup to VGA 640x400x256 (mode 5EH) */
	    svga_height = 400;	 /* This is the only SVGA card w/400 Lines */
	    break;
	case OAKTECH:
	    inr.x.ax = 0x0053;   /* setup to VGA 640x480x256 most SVGAs */
	    break;
	case AHEADA:
	case AHEADB:
	    inr.x.ax = 0x0061;
	    break;
	case EVEREX:
	    inr.x.ax = 0x0070;	 /* BIOS Mode 0x16 for EV-678? */
	    inr.h.bl = 0x30;
	    break;
	case ATIVGA:
	    inr.x.ax = 0x0062;
	    break;
	case TRIDENT:
	    inr.x.ax = 0x005d;
	    break;
	case VIDEO7:
	    inr.x.ax = 0x6f05;
	    inr.h.bl = 0x67;
	    break;
	case CHIPSTECH:
	    inr.x.ax = 0x0079;
	    break;
	case PARADISE:
	    inr.x.ax = 0x005f;
	    break;
	case TSENG3:
	    inr.x.ax = 0x002e;
	    break;
	case TSENG4:
	    inr.x.ax = 0x002e;
	    break;
	case VESA:
	    inr.x.ax = 0x4f02;
	    inr.x.bx = 0x0101;
	default:		/* BASIC_VGA */
	    inr.x.ax = 0x0013;	/* setup to VGA 320x200x256 (mode 13H) */
	    svga_width = 320;	/* allow svga scaling to run at 320x200 */
	    svga_height = 200;
	}
   if (whichvga != MODE13x)
	int86(0x10, &inr, &outr);    /* then do the BIOS video int */

   pallete_init();
   return;
}


int auto_detect_vga()		/* Autodetect (S)VGA Adapter Type */
    {
    unsigned char far *biosptr;
    unsigned char tmp_byte;
    unsigned int tmp_word, tmp_word1;
    int retcode = BASIC_VGA;
    union REGS inr, outr;
    struct SREGS segs;

/*  strcpy(answer, "THIS IS A TEST!$");	* Test for proper segment loss */
/*  inr.x.ax = 0x0900;	*/
/*  inr.x.dx = (unsigned int) answer;	 */
/*  segread(&segs);				* get our DS, etc. */
/*  segs.ds = (unsigned int) ((unsigned long)answer >> 16); * get segment? */
/*  int86x(0x21, &inr, &outr, &segs);		* DOS print string call */

    inr.x.ax = 0x4F00;			/* Test for VESA Adapter */
    inr.x.di = (unsigned int) answer;
    segread(&segs);			/* get our DS, etc. */
    segs.es = (unsigned int) ((unsigned long)answer >> 16); /* get segment? */
    int86x(0x10, &inr, &outr, &segs);	/* BIOS adapter identify call */
    if (outr.x.ax == 0x004F)		/* if response successful */
	if (!strncmp(answer, "VESA", 4))
	    {
	    inr.x.ax = 0x4F01;		/* BIOS fetch attributes call */
	    inr.x.bx = inr.x.cx = 0x0101;	/* get attrs for this mode */
	    inr.x.di = (unsigned int) answer;	/* deposit attribs here */
	    segread(&segs);			/* get our DS, etc. */
	    segs.es = (unsigned int) ((unsigned long)answer >> 16); /* seg? */
	    int86x(0x10, &inr, &outr, &segs);	/* BIOS fetch attrib call */
	    tmp_word = (unsigned int) *(answer + 12);	/* addr low word */
	    tmp_word1 = (unsigned int) *(answer + 14);	/* addr hi word */
	    vesa_bankswitch = (void (_cdecl *)(void))(((unsigned long) tmp_word1 << 16) | tmp_word);
	    tmp_word = (unsigned int) *(answer + 4);	/* "granule" size */
	    if (tmp_word < 1)
		tmp_word = 1;
	    vesa_granularity = (unsigned char)(64 / tmp_word);
	    vga_512K = TRUE;		/* assume all VESA's have >= 512K */
	    return (VESA);
	    }
    biosptr = MK_FP(0xC000, 0x0040);	/* Test for ATI Wonder */
    if (*biosptr == '3' && *(biosptr + 1) == '1')
	{
	_disable();			/* Disable system interrupts */
	outp(0x1CE, 0xBB);
	if (inp(0x1CD) & 0x20)
	    vga_512K = TRUE;
	_enable();			/* Re-enable system interrupts */
	return (ATIVGA);
	}
    inr.x.ax = 0x7000;			/* Test for Everex &| Trident */
    inr.x.bx = 0;
#ifndef TURBOC
    _asm cld;
#else
	#inline	cld;
#endif
    int86(0x10, &inr, &outr);
    if (outr.h.al == 0x70)
	{
	if (outr.h.ch & 0xC0)
	    vga_512K = TRUE;
	outr.x.dx &= 0xFFF0;
	if (outr.x.dx == 0x6780)
	    {
	    printf("\nT6780\n");
	    return (TRIDENT);
	    }
	if (outr.x.dx == 0x2360)
	    {
	    printf("\nT2360\n");
	    return (TRIDENT);
	    }
	if (outr.x.dx == 0x6730)	/* EVGA? (No BIOS Page Fn.) */
	    {
	    printf("\nE6730\n");
	    return (EVEREX);
	    }
	printf("\nE0000\n");
	return (EVEREX);	/* Newer board with fetchable bankswitch */
	}
    outp(0x3C4, 0x0B);			/* Test for Trident */
    tmp_byte = (unsigned char) inp(0x3C5);
    if ((tmp_byte > 1) && (tmp_byte < 0x10))
	{
	vga_512K = TRUE;
	printf("\nT0000\n");
	return (TRIDENT);
	}
    if (cirrus())			/* Test Video7 Vega VGA (Cirrus) */
	return (CIRRUS);
    inr.x.ax = 0x6F00;			/* Test for Video7 SVGA */
    inr.x.bx = 0;			/* note - Vega VGA (Cirrus) will */
#ifndef TURBOC
    _asm cld;
#else
    #inline cld;
#endif
    int86(0x10, &inr, &outr);		/* pass this test - test Cirrus 1st */
    if (outr.h.bh == 'V' && outr.h.bl == '7')
	{
	inr.x.ax = 0x6F07;		/* may need to clear direction flag */
#ifndef TURBOC
	_asm cld;
#else
	#inline cld;
#endif
	int86(0x10, &inr, &outr);
	if ((outr.h.ah & 0x7F) > 1)
	    vga_512K = TRUE;
	return (VIDEO7);
	}
    outp(0x3CE, 9);			/* Test for Paradise */
    if (!inp(0x3CF))
	{
	outpw(0x3CE, 0x050F);		/* Turn off write protect on regs */
	if (chkbk(1))			/* if bank 0 and 1 same not para. */
	    {				/* FALSE == banks same... (C) */
/*	    if (chkbk(64))		* if bank 0 and 64 same only 256K */
		vga_512K = TRUE;
	    biosptr = MK_FP(0xC000, 0x0039);	/* Test for AT&T VDC600 */
	    if ((*biosptr == '1') && (*biosptr+1 == '6')) /* p/n 003116 */
		return (VDC600);	/* a real Paradise is p/n 003145 */
	    return (PARADISE);
	    }
	}
    inr.x.ax = 0x5F00;			/* Test for Chips & Tech */
    inr.x.bx = 0;
#ifndef TURBOC
    _asm cld;
#else
    #inline cld;
#endif
    int86(0x10, &inr, &outr);
    if (outr.h.al == 0x5F)
	{
	if (outr.h.bh >= 1)
	    vga_512K = TRUE;
	return (CHIPSTECH);
	}
    outp(0x3D4, 0x33);			/* Test for Tseng 4000 or 3000 Chip */
    tmp_word = (unsigned int) inp(0x3D5) << 8;
    outpw(0x3D4, 0x0A33);
    outp(0x3D4, 0x33);
    if ((inp(0x3D5) & 0x0F) == 0x0A)
	{
	outpw(0x3D4, 0x0533);
	outp(0x3D4, 0x33);
	if ((inp(0x3D5) & 0x0F) == 0x05)
	    {
	    retcode = TSENG4;
	    outpw(0x3D4, tmp_word | 0x33);
	    outp(0x3BF, 0x03);		/* Enable access to extended regs */
	    outp(0x3D8, 0xA0);
	    }
	}
    tmp_byte = (unsigned char) inp(0x3CD);	/* save bank switch reg */
    outp(0x3CD, 0xAA);				/* test register w/ 0xAA */
    if (inp(0x3CD) == 0xAA)
	{
	outp(0x3CD, 0x55);			/* test register w/ 0x55 */
	if (inp(0x3CD) == 0x55)
	    {
	    outp(0x3CD, tmp_byte);		/* restore bank switch reg */
	    if (retcode != TSENG4)		/* yep, it's a Tseng... */
		retcode = TSENG3;
	    vga_512K = TRUE;
	    return (retcode);
	    }
	}
    outpw(0x3CE, 0x200F);		/* Test for Ahead A or B chipsets */
    tmp_byte = (unsigned char) inp(0x3CF);
    if (tmp_byte == 0x21)
	{
	vga_512K = TRUE;		/* Assume all Ahead's have 512K... */
	return (AHEADB);
	}
    if (tmp_byte == 0x20)
	{
	vga_512K = TRUE;
	return (AHEADA);
	}
    if ((inp(0x3DE) & 0xE0) == 0x60)	/* Test for Oak Tech OTI-067 */
	{
	outp(0x3DE, 0x0D);
	if (inp(0x3DF) & 0x80)
	    vga_512K = TRUE;
	return(OAKTECH);
	}
    return (BASIC_VGA);			/* Return 1 if Unknown/BASIC_VGA */
    }

int cirrus()			/* Test for presence of Cirrus VGA Chip */
    {
    unsigned char tmp_byte;
    unsigned int crc_word, tmp_word;
    int retcode = FALSE;

    outp(0x3D4, 0x0C);	/* assume 3Dx addressing, scrn A start addr hi */
    crc_word = (unsigned int) inp(0x3D5) << 8;	/* save the crc */
    outp(0x3D5, 0);				/* clear the crc */
    outp(0x3D4, 0x1F);				/* Eagle ID register */
    tmp_byte = (unsigned char) inp(0x3D5);	/* nybble swap "register" */
    tmp_word = (((tmp_byte & 0x0F) << 4) | ((tmp_byte & 0xf0) >> 4)) << 8;
    outpw(0x3C4, tmp_word | 0x06);		/* disable extensions */
    if (!inp(0x3C5))
	{
	tmp_word = (unsigned int) tmp_byte << 8;
	outpw(0x3C4, tmp_word | 0x06);		/* re-enable extensions */
	if (inp(0x3C5) == 1)
	    retcode = TRUE;
	}
    outpw(0x3D5, crc_word | 0x0c);		/* restore the crc */
    return (retcode);
    }


int chkbk(bank)		/* Paradise specific VGA bank switch test */
unsigned int bank;	/* returns FALSE (C) if banks test the same... */
    {
    if (gochk(0x1234, bank))		/* TRUE = test failed */
	return(FALSE);	/* FALSE - bank 0 and 'bank' are the same... */
    if (gochk(0x4321, bank))
	return(FALSE);	/* FALSE - bank 0 and 'bank' are the same... */
    return (TRUE);	/* TRUE - bank 0 and 'bank' are different */
    }


int gochk(value, bank)		/* More Paradise specific stuff (feh!) */
    unsigned int value, bank;	/* returns TRUE (NZ) if bank test fails */
    {
    unsigned char far *fp;
    unsigned char bh, bl, ch, cl, oldbh, oldbl;	/* pardon my registers! */

    fp = MK_FP(0xb800, 0);		/* point out into display RAM */

    bh = (unsigned char)(value >> 8);	/* test signature hi order */
    bl = (unsigned char)(value & 0xff);	/* test signature lo order */
    ch = (unsigned char)(bank >> 8);	/* usually 0 */
    cl = (unsigned char)(bank & 0xff);	/* bank number to test */

    pdrsub(cl);		/* save prior video data and write test values */
    oldbl = *fp;
    *fp = bl;
    pdrsub(ch);
    oldbh = *fp;
    *fp = bh;

    pdrsub(cl);		/* XOR values written with old values */
    bl ^= *fp;
    pdrsub(ch);
    bh ^= *fp;

    pdrsub(cl);		/* restore old video data after testing */
    *fp = oldbl;
    pdrsub(ch);
    *fp = oldbh;

    pdrsub(0);		/* reselect bank zero */

    return ((int)(bh | bl));	/* bh and bl == 0 == OK, return FALSE */
    }


void pdrsub(bank)	/* Still More Paradise specific stuff (arrgh!!) */
    unsigned char bank;
    {
    unsigned int value;

    value = (unsigned int) bank << 8;
    outpw(0x3CE, value | 9);		/* perform the bank switch */
    }


void pallete_init()		/* Fill VGA 256 color palette with colors! */
    {
    union REGS inr, outr;
    register unsigned m;
    unsigned r, g, b;
    register DBL hue, sat, val;

    inr.x.ax = 0x1010;           /* make pallette register 0 black */
    inr.x.bx = 0;
    inr.h.ch = inr.h.cl = inr.h.dh = 0;   /* full off */
    int86(0x10, &inr, &outr);

    inr.x.ax = 0x1010;           /* make pallette register 64 white */
    inr.x.bx = 64;
    inr.h.ch = inr.h.cl = inr.h.dh = 63;  /* full on */
    int86(0x10, &inr, &outr);

    inr.x.ax = 0x1010;           /* make pallette register 128 dark grey */
    inr.x.bx = 128;
    inr.h.ch = inr.h.cl = inr.h.dh = 31;  /* half on (dark grey) */
    int86(0x10, &inr, &outr);

    inr.x.ax = 0x1010;           /* make pallette register 192 lite grey */
    inr.x.bx = 192;
    inr.h.ch = inr.h.cl = inr.h.dh = 48;  /* 3/4 on (lite grey) */
    int86(0x10, &inr, &outr);

    for (m = 1; m < 64; m++)     /* for the 1st 64 colors... */
	{
	sat = 0.5;	/* start with the saturation and intensity low */
	val = 0.5;
	hue = 360.0 * ((DBL)(m)) / 64.0;   /* normalize to 360 */
	hsv_to_rgb (hue, sat, val, &r, &g, &b);
	set_pallette_register (m, r, g, b); /* set m to rgb value */

	sat = 1.0;	/* high saturation and half intensity (shades) */
	val = 0.50;
	hue = 360.0 * ((DBL)(m)) / 64.0;   /* normalize to 360 */
	hsv_to_rgb (hue, sat, val, &r, &g, &b);
	set_pallette_register (m + 64, r, g, b);  /* set m + 64 */

	sat = 0.5;	/* half saturation and high intensity (pastels) */
	val = 1.0;

	hue = 360.0 * ((DBL)(m)) / 64.0;   /* normalize to 360 */
	hsv_to_rgb (hue, sat, val, &r, &g, &b);
	set_pallette_register (m + 128, r, g, b); /* set m + 128 */

	sat = 1.0;            /* normal full HSV set at full intensity */
	val = 1.0;
   
	hue = 360.0 * ((DBL)(m)) / 64.0;   /* normalize to 360 */
	hsv_to_rgb (hue, sat, val, &r, &g, &b);
	set_pallette_register (m + 192, r, g, b); /* set m + 192 */
	}
    return;
    }


void display_finished ()
    {
    if (Options & PROMPTEXIT)
	{
	printf ("\007\007");	/* long beep */
	while(!kbhit())		/* wait for key hit */
	   ;
	if (!getch())		/* get another if ext. scancode */
	   getch();
	}
    }


void display_close()   /* setup to Text 80x25 (mode 3) */
    {
    union REGS inr, outr;

    inr.x.ax = 0x0003;
    int86(0x10, &inr, &outr);
    return;
    }


void display_plot (x, y, Red, Green, Blue)   /* plot a single RGB pixel */
   int x, y;
   char Red, Green, Blue;
   {
   register unsigned char color, svga_byte;
   unsigned char far *fp;
   unsigned int svga_lo, svga_word;
   unsigned long svga_loc;
   DBL h, s, v, fx, fy;

   if (!x)			/* first pixel on this line? */
	{
	lastx = -1;		/* reset cache, make sure we do the 1st one */
	lasty = lastline;	/* set last line do to prior line */
	}

   if (screen_height > svga_height)	/* auto-scale Y */
	{
	fy = (DBL)y / ((DBL)screen_height / (DBL)svga_height);
	y = (int)fy;		/* scale y to svga_height */
	if (y <= lasty)		/* discard if repeated line */
	    return;
	lastline = y;		/* save current working line */
	}

   if (screen_width > svga_width)		/* auto-scale X */
	{
	fx = (DBL)x / ((DBL)screen_width / (DBL)svga_width);
	x = (int)fx;		/* scale x to svga_width */
	if (x <= lastx)		/* discard if repeated pixel */
	    return;
	lastx = x;		/* save most recent pixel done */
	}

   /* Translate RGB value to best of 256 pallete Colors (by HSV?) */

   rgb_to_hsv((unsigned)Red,(unsigned)Green,(unsigned)Blue, &h, &s, &v);

   if (s < 0.20)   /* black or white if no saturation of color... */
   {
      if (v < 0.25)
         color = 0;        /* black */
      else if (v > 0.8)
         color = 64;       /* white */
      else if (v > 0.5)
         color = 192;      /* lite grey */
      else
         color = 128;      /* dark grey */
      }
   else
      {
      color = (unsigned char) (64.0 * ((DBL)(h)) / 360.0);

      if (!color)
         color = 1;        /* avoid black, white or grey */
      
      if (color > 63)
         color = 63;       /* avoid same */

      if (v > 0.50)
         color |= 0x80;    /* colors 128-255 for high inten. */

      if (s > 0.50)        /* more than half saturated? */
         color |= 0x40;    /* color range 64-128 or 192-255 */
      }

   switch (whichvga)		/* decide on bank switching scheme to use */
	{
	   case BASIC_VGA:	/* none */
		fp = MK_FP(0xa000, 320 * y + x);
		break;
	   case MODE13x:	/* faked */
		svga_word = 1 << (x & 3);	/* form bit plane mask */
		svga_word = (svga_word << 8) | 2;
		outpw(SEQUENCER, svga_word);	/* tweak the sequencer */
		fp = MK_FP(0xa000, 90 * y + (x >> 2));
		break;
	   default:	/* actual bank switch for all SVGA cards */
		svga_loc = (unsigned long)svga_width * y + x; /* scrn addr. */
		svga_lo = (unsigned int)(svga_loc & 0x0000ffffL);
		svga_loc &= 0x00ff0000L;	/* get high order byte */
		svga_byte = (unsigned char)(svga_loc >> 16);  /* bank # */
		if (svga_cur != svga_byte)	/* if not in correct bank */
		{
		    _disable();		   /* shut off system interrupts */
		    svga_cur = svga_byte;  /* set new curr. working bank */
		    newbank();		   /* and switch to it... */
		    _enable();		   /* restore system interrupts */
		}
		fp = MK_FP(0xa000, svga_lo);  /* use low order scrn addr */
	}

   *fp = color;		/* write normalized pixel color val to bitplane */

   return;
   }

void newbank()		/* Perform SVGA bank switch on demand - Voila! */
{
    register unsigned char tmp_byte, tmp_byte1;
    register unsigned int tmp_word;
    union REGS regs;

    switch (whichvga)
        {
	case VDC600:			/* AT&T VDC 600 */
	    tmp_byte = (unsigned char) (svga_cur << 4);	/* was >> 12... */
	    outpw(0x03CE,0x050F);
	    outp(0x03CE,0x09);
	    outp(0x03CF, tmp_byte);
	    break;
	case OAKTECH:			/* Oak Technology OTI-067 */
	    tmp_byte = (unsigned char)(svga_cur & 0x0F);
	    outp(0x3DF, (tmp_byte << 4) | tmp_byte);
	    break;
	case AHEADA:			/* Ahead Systems Ver A */
	    outpw(0x3CE, 0x200F);	/* enable extended registers */
	    tmp_byte = (unsigned char)(inp(0x3CC) & 0xDF);  /* bit 0 */
	    if (svga_cur & 1)
		    tmp_byte |= 0x20;
	    outp(0x3C2, tmp_byte);
	    outp(0x3CF, 0);		   /* bits 1, 2, 3 */
	    tmp_word = (unsigned int)((svga_cur >> 1 )|(inp(0x3D0) & 0xf8));
	    outpw(0x3CF, tmp_word << 8);
	    break;
	case AHEADB:			/* Ahead Systems Ver B */
	    outpw(0x3CE, 0x200F);	/* enable extended registers */
	    tmp_word = (unsigned int)((svga_cur << 4) | svga_cur);
	    outpw(0x3CF, (tmp_word << 8) | 0x000D);
	    break;
	case EVEREX:			/* Everex SVGA's */
	    outp(0x3C4, 8);
	    if (svga_cur & 1)
		 tmp_word = (unsigned int)(inp(0x3C5) | 0x80);
	    else tmp_word = (unsigned int)(inp(0x3C5) & 0x7F);
	    outpw(0x3C4, (tmp_word << 8) | 0x0008);
	    tmp_byte = (unsigned char)(inp(0x3CC) & 0xDF);
	    if (!(svga_cur & 2))
		 tmp_byte |= 0x20;
	    outp(0x3C2, tmp_byte);
	    break;
	case ATIVGA:			/* ATI VGA Wonder */
	    outp(0x1CE, 0xB2);
	    tmp_word = (unsigned int)((svga_cur << 1) | (inp(0x1CF) & 0xE1));
	    outpw(0x1CE, (tmp_word << 8) | 0x00B2);
	    break;
	case TRIDENT:
	    outp(0x3CE, 6);		/* set page size to 64K */
	    tmp_word = (unsigned int)(inp(0x3CF) | 4) << 8;
	    outpw(0x3CE, tmp_word | 0x0006);
	    outp(0x3C4, 0x0b);		/* switch to BPS mode */
	    inp(0x3C5);			/* dummy read?? */
	    tmp_word = (unsigned int)(svga_cur ^ 2) << 8;
	    outpw(0x3C4, tmp_word | 0x000E);
	    break;
	case VIDEO7:			/* Video-7 VRAM, FastRAM SVGA cards */
	    tmp_byte1 = tmp_byte = (unsigned char)(svga_cur & 0x0F);
	    outpw(0x3C4, 0xEA06);
	    tmp_word = (unsigned int)(tmp_byte & 1) << 8;
	    outpw(0x3C4, tmp_word | 0x00F9);
	    tmp_byte &= 0x0C;
	    tmp_word = (unsigned int)(tmp_byte >> 2 | tmp_byte) << 8;
	    outpw(0x3C4, tmp_word | 0x00F6);
	    tmp_word |= (inp(0x3C5) & 0xF0) << 8;
	    outpw(0x3C4, tmp_word | 0x00F6);
	    tmp_byte = (unsigned char)((tmp_byte1 << 4) & 0x20);
	    outp(0x3C2, (inp(0x3CC) & 0xDF) | tmp_byte);
	    break;
	case CHIPSTECH:			/* Chips & Technology VGA Chip Set */
	    outpw(0x46E8, 0x001E);	/* put chip in setup mode */
	    outpw(0x103, 0x0080);	/* enable extended registers */
	    outpw(0x46E8, 0x000E);	/* take chip out of setup mode */
	    tmp_word = (unsigned int)(svga_cur << 2) << 8; /* 64K -> 16K */
	    outpw(0x3D6, tmp_word | 0x0010);
	    break;
	case PARADISE:			/* Paradise, Professional, Plus */
	    outpw(0x3CE, 0x050F);	/* turn off VGA reg. write protect */
	    tmp_word = (unsigned int)(svga_cur << 4) << 8;
	    outpw(0x3CE, tmp_word | 0x0009);
	    break;
	case TSENG3:			/* Tseng 3000 - Orchid, STB, etc. */
	    tmp_byte = (unsigned char)(svga_cur & 0x07);
	    tmp_byte1 = (unsigned char)((tmp_byte << 3) | tmp_byte);
	    outp(0x3CD, tmp_byte1 | 0x40);
	    break;
	case TSENG4:			/* Tseng 4000 - Orchid PD+, etc. */
	    tmp_byte = (unsigned char)(svga_cur & 0x0F);
	    tmp_byte1 = (unsigned char)((tmp_byte << 4) | tmp_byte);
	    outp(0x3BF, 3);		/* enable access to extended regs */
	    outp(0x3D8, 0xA0);
	    outp(0x3CD, tmp_byte1);
	    break;
	case VESA:			/* VESA standard 640x480x256 */
	    regs.x.dx = (unsigned int) svga_cur * vesa_granularity;
	    regs.x.ax = 0x4F05;
	    int86(0x10, &regs, &regs);	/* Do the video BIOS interrupt */
	    (*vesa_bankswitch)();	/* call the bios bank-switch rtn */
        }
    return;
}

void set_pallette_register (Val, Red, Green, Blue)
   unsigned Val;
   unsigned Red, Green, Blue;
   {
   union REGS Regs;

   Regs.x.ax = 0x1010;              /* Set one pallette register function */
   Regs.x.bx = Val;                 /* the pallette register to set (color#)*/
   Regs.h.dh = (char)(Red & 0xff);   /* set the gun values (6 bits ea.) */
   Regs.h.ch = (char)(Green & 0xff);
   Regs.h.cl = (char)(Blue & 0xff);
   int86(0x10, &Regs, &Regs);       /* Do the video interrupt */
   }

/* Conversion from Hue, Saturation, Value to Red, Green, and Blue and back */
/* From "Computer Graphics", Donald Hearn & M. Pauline Baker, p. 304 */

void hsv_to_rgb(hue, s, v, r, g, b)
   DBL hue, s, v;               /* hue (0.0-360.0) s and v from 0.0-1.0) */
   unsigned *r, *g, *b;         /* values from 0 to 63 */
   {
   register DBL i, f, p1, p2, p3;
   register DBL xh;
   register DBL nr = 0.0, ng = 0.0, nb = 0.0;	/* rgb values of 0.0 - 1.0 */

   if (hue == 360.0)
      hue = 0.0;                /* (THIS LOOKS BACKWARDS BUT OK) */

   xh = hue / 60.0;             /* convert hue to be in 0,6     */
   i = floor(xh);               /* i = greatest integer <= h    */
   f = xh - i;                  /* f = fractional part of h     */
   p1 = v * (1 - s);
   p2 = v * (1 - (s * f));
   p3 = v * (1 - (s * (1 - f)));

   switch ((int) i)
      {
      case 0:
         nr = v;
         ng = p3;
         nb = p1;
         break;
      case 1:
         nr = p2;
         ng = v;
         nb = p1;
         break;
      case 2:
         nr = p1;
         ng = v;
         nb = p3;
         break;
      case 3:
         nr = p1;
         ng = p2;
         nb = v;
         break;
      case 4:
         nr = p3;
         ng = p1;
         nb = v;
         break;
      case 5:
         nr = v;
         ng = p1;
         nb = p2;
         break;
        }

   *r = (unsigned)(nr * 63.0); /* Normalize the values to 63 */
   *g = (unsigned)(ng * 63.0);
   *b = (unsigned)(nb * 63.0);
   
   return;
   }


void rgb_to_hsv(r, g, b, h, s, v)
   unsigned r, g, b;
   DBL *h, *s, *v;
   {
   register DBL m, r1, g1, b1;
   register DBL nr, ng, nb;		/* rgb values of 0.0 - 1.0      */
   register DBL nh = 0.0, ns, nv;	/* hsv local values */

   nr = (DBL) r / 255.0;
   ng = (DBL) g / 255.0;
   nb = (DBL) b / 255.0;

   nv = max (nr, max (ng, nb));
   m = min (nr, min (ng, nb));

   if (nv != 0.0)                /* if no value, it's black! */
      ns = (nv - m) / nv;
   else
      ns = 0.0;                 /* black = no colour saturation */

   if (ns == 0.0)                /* hue undefined if no saturation */
   {
      *h = 0.0;                  /* return black level (?) */
      *s = 0.0;
      *v = nv;
      return;
   }

   r1 = (nv - nr) / (nv - m);    /* distance of color from red   */
   g1 = (nv - ng) / (nv - m);    /* distance of color from green   */
   b1 = (nv - nb) / (nv - m);    /* distance of color from blue   */

   if (nv == nr)
   {
      if (m == ng)
         nh = 5. + b1;
      else
         nh = 1. - g1;
   } 

   if (nv == ng)
      {
      if (m == nb)
         nh = 1. + r1;
      else
         nh = 3. - b1;
      }

   if (nv == nb)
      {
      if (m == nr)
         nh = 3. + g1;
      else
         nh = 5. - r1;
      }

   *h = nh * 60.0;      /* return h converted to degrees */
   *s = ns;
   *v = nv;
   return;
   }


#if !__STDC__

/* ANSI Standard psuedo-random number generator */

static unsigned long int next = 1;

int rand()
   {
   next = next * 1103515245L + 12345L;
   return ((int) (next / 0x10000L) & 0x7FFF);
   }

void srand(seed)
   unsigned int seed;
   {
   next = seed;
   }

#endif


/* Math Error exception struct format:
	int type;		- exception type - see below
	char _FAR_ *name;	- name of function where error occured
	long double arg1;	- first argument to function
	long double arg2;	- second argument (if any) to function
	long double retval;	- value to be returned by function
*/

int _cdecl matherr(e)
   struct exception *e;
   {
   if (Options & DEBUGGING) {
      /* Since we are just making pictures, not keeping nuclear power under
         control - it really isn't important if there is a minor math problem.
         This routine traps and ignores them.  Note: the most common one is
         a DOMAIN error coming out of "acos". */
      switch (e->type) {
	 case DOMAIN   : printf("DOMAIN error in '%s'\n", e->name); break;
	 case SING     : printf("SING   error in '%s'\n", e->name); break;
	 case OVERFLOW : printf("OVERFLOW error in '%s'\n", e->name); break;
	 case UNDERFLOW: printf("UNDERFLOW error in '%s'\n", e->name); break;
	 case TLOSS    : printf("TLOSS error in '%s'\n", e->name); break;
	 case PLOSS    : printf("PLOSS error in '%s'\n", e->name); break;
	 case EDOM     : printf("EDOM error in '%s'\n", e->name); break;
	 case ERANGE   : printf("ERANGE error in '%s'\n", e->name); break;
	 default       : printf("Unknown math error in '%s'\n",e->name);break;
         }
      }
   return (1);	/* Indicate the math error was corrected... */
   }
