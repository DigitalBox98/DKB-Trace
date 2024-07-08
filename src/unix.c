#include <math.h>
#include "config.h"

void unix_init_dkb_trace PARAMS ((void))
   {
   }

int matherr (x)
   struct exception *x;
   {
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

     default:
        break;
     }
   return(1);
   }

void display_finished ()
   {
   }

void display_init ()
   {
   }

void display_close ()
   {
   }

void display_plot (x, y, Red, Green, Blue)
   int x, y;
   char Red, Green, Blue;
   {
   }

