/*
	Here are some routines I wrote which implement +d option on
	unix computers running X-windows. For now, only black
	and white output is supported. If I get access to a computer
	with a color monitor, I'll probably add support for colors to
	my routines. 

	In future I'll probably add some more dithering methods.
	I have tested these routines on SUN 3 and SUN 4. I'm using
	the tvtwm window manager. 

	If you have some suggestions to my source code or if you change
	anything, please let me know. I can be reached at the following
	address: Marek Rzewuski, Avstikkeren 11, 1156 Oslo 11, Norway or
	marekr@ifi.uio.no on Internet.
*/
	
#include <stdio.h>
#include <X11/Xlib.h>		/* some Xlib stuff */
#include <X11/Xutil.h>
#include "theIcon"		

#include "frame.h"
#include "dkbproto.h"

#define 	BORDER_WIDTH	2
#define	EV_MASK	(ButtonPressMask | \
		 KeyPressMask	 | \
		 ExposureMask    | \
		 StructureNotifyMask)

Display		*theDisplay;
int		theScreen;
int		theDepth;
unsigned long	theBlackPixel;
unsigned long	theWhitePixel;
XEvent		theEvent;	
Window  	theWindow, openWindow();
GC		theGC;
unsigned char	*bitmap; 	/* pointer to our picture bitmap */
unsigned char	*bitmapPos;     /* position to the last drawn pixel in our bitmap */


/* global DKBTrace variables */

extern FRAME Frame;
extern unsigned int Options;
extern char DisplayFormat;
extern int First_Line;

enum pixval { BLACK, WHITE };

/* an dither matrix used to produce some dithering when using black/white screen */
int dither_matrix[8][8] = {
    {  2, 60, 16, 56,  3, 57, 13, 53 },
    { 34, 18, 48, 32, 35, 19, 45, 29 },
    { 10, 50,  6, 64, 11, 51,  7, 61 },
    { 42, 26, 38, 22, 43, 27, 39, 23 },
    {  4, 58, 14, 54,  1, 59, 15, 55 },
    { 36, 20, 46, 30, 33, 17, 47, 31 },
    { 44, 28, 40, 24, 41, 25, 37, 21 },
    {  2, 60, 16, 56,  3, 57, 13, 53 }};

void unix_init_dkb_trace PARAMS ((void))
   {
   }

enum pixval
dither(r, g, b, x, y)
    int r, g, b, x, y;
{
    int greyval;

    /* They say those numbers are the best, don't ask me why... */
    greyval = (0.299*r + 0.587*g  + 0.114*b) * 64. / 255.;
    return (greyval < dither_matrix[x%8][y%8]) ? BLACK : WHITE;
}




/* Sets up a connection to the X server and stores informations about the enviroment */

initX()
{
  theDisplay = XOpenDisplay(NULL);
  if (theDisplay == NULL) {
    fprintf(stderr,"ERROR: Cannot establish a connection to the X server %s\n",
	    XDisplayName(NULL));
    exit(1);
  }
  theScreen = DefaultScreen(theDisplay);
  theDepth  = DefaultDepth(theDisplay, theScreen);
  theWhitePixel = WhitePixel(theDisplay, theScreen);
  theBlackPixel = BlackPixel(theDisplay, theScreen);
}

/* This procedure will do the following things:
   1) 	Set up attributes desired for the window
   2)	Set up an icon to our window.
   3) 	Send hints to the window manager.
   4) 	Open a window on the display
   5)	Tell the X to place the window on the screen
   6)	Flush out all the queued up X requests to the X server */

Window openWindow(x,y,width,height,flag,theNewGC)
int	x,y;
int	width,height;
int	flag;
GC	*theNewGC;
{
  XSetWindowAttributes	theWindowAttributes;
  XSizeHints		theSizeHints;
  unsigned	long	theWindowMask;
  Window		theNewWindow;
  Pixmap 		theIconPixmap;
  XWMHints		theWMHints;


  /* Set up some attributes for the window. Override_redirect tells
     the window manager to deal width the window or leave it alone */

  theWindowAttributes.border_pixel 	= theBlackPixel;
  theWindowAttributes.background_pixel 	= theWhitePixel;
  theWindowAttributes.override_redirect = False;
  theWindowMask = CWBackPixel | CWBorderPixel | CWOverrideRedirect;

  /* Now, open out window */
  
  theNewWindow = XCreateWindow(theDisplay,
			       RootWindow(theDisplay,theScreen),
			       x,y,
			       width, height,
			       BORDER_WIDTH,
			       theDepth,
			       InputOutput,
			       CopyFromParent,
			       theWindowMask,
			       &theWindowAttributes);

  /* Create one iconbitmap */

  theIconPixmap = XCreateBitmapFromData(theDisplay,
					theNewWindow,
					theIcon_bits,
					theIcon_width,
					theIcon_height);

  /* Now tell the window manager where on screen we should place our 
     window. */

  theWMHints.icon_pixmap	= theIconPixmap;
  theWMHints.initial_state 	= NormalState; 		/* we don't want an iconized window when it's created */
  theWMHints.flags		= IconPixmapHint | StateHint;

  XSetWMHints(theDisplay,theNewWindow,&theWMHints);

  theSizeHints.flags		= PPosition | PSize;
  theSizeHints.x		= x;
  theSizeHints.y		= y;
  theSizeHints.width		= width;
  theSizeHints.height		= height;
 /* theSizeHints.min_width	= width;
  theSizeHints.min_height	= height;
  theSizeHints.max_width	= width;
  theSizeHints.max_height	= height; */

  XSetNormalHints(theDisplay,theNewWindow,&theSizeHints);


  if (createGC(theNewWindow, theNewGC) == 0) {
    XDestroyWindow(theDisplay, theNewWindow);
    return((Window) 0);
  } 
 
  /* make a name for our window */
  
  XStoreName(theDisplay, theNewWindow, "DKBTrace v2.10\0");

  /* Now, could we please see the window on the screen?
     Until now, we have dealed with a window which has been created
     but noe appeared on the screen. Maping the window places it visibly	
     on the screen */

  XMapWindow(theDisplay,theNewWindow);
  XFlush(theDisplay);
  return(theNewWindow);
}

refreshWindow(theExposedWindow)
Window 	theExposedWindow;
{
  int	i, x, y;	
  unsigned char	*dummy;
  dummy = bitmap;
  i = 0; x= 0; y = First_Line;
  do {
    if (*dummy) 
      XDrawPoint(theDisplay, theWindow, theGC,x,y);
    if (x == Frame.Screen_Width) {
      x = 0;
      y++;
    } else {
      dummy++;
      x++;
      i++;
    }
  } while(dummy != bitmapPos);		/* until dummy = the last drawn pixel in our window */
  XFlush(theDisplay);
}

/* Creates a new graphics context */

createGC(theNewWindow, theNewGC)
Window 	theNewWindow;
GC	*theNewGC;
{
  XGCValues theGCValues;
  *theNewGC = XCreateGC(theDisplay,
			theNewWindow, 
			(unsigned long) 0,
			&theGCValues);

  if (*theNewGC == 0) {
    return(0); /*error*/
  } else { /* set foreground and background defaults for the new GC */
    XSetForeground(theDisplay,
		   *theNewGC,
		   theBlackPixel);
    
    XSetBackground(theDisplay,
		  *theNewGC,
		  theWhitePixel);

    return(1); /* OK */
  }
}
    
initEvents(theWindow)
Window theWindow;
{
  XSelectInput(theDisplay,
	       theWindow,
	       EV_MASK);
}

void display_finished ()
{
  
}


void display_init ()
{
  int	i;

  /* set some room for a bitmap for our picture. I've got to "remember" the whole
     picture bacuse of resising of the window, overlaping etc. Then I've got to
     refresh the picture. This should be easy to convert to an "color version" in
     future */
   
  bitmap = (unsigned char *) malloc(sizeof(unsigned char) * (Frame.Screen_Width * Frame.Screen_Height));
  bitmapPos = bitmap;
  if (bitmap == NULL) 
    printf("ERROR: Can not allocate the buffer..\n");
  
  for (i = 0; i < (Frame.Screen_Width*Frame.Screen_Height); i++) {   
    *bitmapPos++ = 0;  
  }
  bitmapPos = bitmap;
  initX();
  theWindow = openWindow(0,0,Frame.Screen_Width,Frame.Screen_Height,0,&theGC);
  initEvents(theWindow);
  XFlush(theDisplay); 
  XNextEvent(theDisplay,&theEvent);
  XFlush(theDisplay); 
} /* end of display initilazation */

void display_close ()
{
  sleep(10);				/* an simple delay. 10 seconds. */
  XDestroyWindow(theDisplay,theWindow);
  XFlush(theDisplay);
  XCloseDisplay(theDisplay);
  free(bitmap);
}

void display_plot (x, y, Red, Green, Blue)
int x, y;
unsigned char Red, Green, Blue;
{
  unsigned char 	color;
  int			numEvents;
  /* lets find if there are some events waiting for us */

  numEvents = XPending(theDisplay);
  if (numEvents > 0) { 			/* now deal with the events.. */  
    XNextEvent(theDisplay,&theEvent);
    
    switch (theEvent.type) {
    case Expose:
      /*printf("Window is exposed.\n");*/
      refreshWindow(theEvent.xany.window);
      break;
  
    case MapNotify:
      /*printf("The window is mapped.\n");*/
      refreshWindow(theEvent.xany.window);
      break;

    case ButtonPress:
      /*printf("A mouse button was pressed.\n");*/
      break;

    case ConfigureNotify:
      /*printf("The window configuration has been changed\n");*/
      refreshWindow(theEvent.xany.window);
      break;
    }
  }
  color = (!dither(Red, Green, Blue, x, y));
  
  *bitmapPos = color;
  if (color) 
    XDrawPoint(theDisplay, theWindow, theGC,x,y); 
  bitmapPos++;
  /*XFlush(theDisplay); Let's be nice to the network, OK? */
}

