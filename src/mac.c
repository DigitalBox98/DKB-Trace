#include "frame.h"
#include "dkbproto.h"

#include <WindowMgr.h>

  WindowPtr pwin;

display_finished() {}

display_close() {
  DisposeWindow(pwin);
}

display_init() {
  Rect brect;
  SetRect(&brect, 10, 500, 522, 800);
  pwin = NewWindow(0, &brect, "\pPlot", TRUE, noGrowDocProc, -1, FALSE, 0);
  SetPort(pwin);
}

void display_plot (x, y, Red, Green, Blue)   /* plot a single RGB pixel */
  int x, y;
  char Red, Green, Blue;
  {
  if (Red || Green || Blue) {
    MoveTo(x,y);
    LineTo(x,y);
    }
}
