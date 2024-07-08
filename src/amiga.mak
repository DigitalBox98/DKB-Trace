# Makefile for DKB Ray Tracing Program by David Buck and Aaron Collins
# This file is released to the public domain.
#
#
# MAKE Macros and Such...
#

#***************************************************************
#*
#*                      Amiga Options
#*
#***************************************************************

# Uncomment for Amiga Lattice C for IEEE w/o coprocessor
CFLAGS	= -cusrft -fi -m0 -q5w5e -b0 -O -v

# Uncomment for Amiga Lattice C with 68881
#CFLAGS	= -cusrft -f8 -m2 -q5w5e -b0 -O -v

# Flags for debugging
#CFLAGS	= -cusrft -q5w5e -d5

LIBSIEEE	= lib:lcmieee.lib lib:lcnb.lib lib:amiga.lib
LIBS881	= lib:lcm881.lib lib:lcnb.lib lib:amiga.lib

OBJ	= o
MACHINE_OBJ	= amiga.$(OBJ)

DKBOBJS = trace.$(OBJ) render.$(OBJ) tokenize.$(OBJ) parse.$(OBJ) \
	  objects.$(OBJ) spheres.$(OBJ) quadrics.$(OBJ) lighting.$(OBJ) \
	  prioq.$(OBJ) texture.$(OBJ) matrices.$(OBJ) csg.$(OBJ) dump.$(OBJ) \
	  colour.$(OBJ) viewpnt.$(OBJ) ray.$(OBJ) planes.$(OBJ) iff.$(OBJ) \
	  gif.$(OBJ) gifdecod.$(OBJ) triangle.$(OBJ) raw.$(OBJ) targa.$(OBJ) \
          quartics.$(OBJ) vect.$(OBJ) $(MACHINE_OBJ)


#  Amiga Linkage...
#
dkbieee:	$(DKBOBJS)
	blink with withfile LIB $(LIBSIEEE) TO dkbieee

dkb881:	$(DKBOBJS)
	blink with withfile LIB $(LIBS881) TO dkb881

trace.$(OBJ) : trace.c dkbproto.h frame.h vector.h config.h

tokenize.$(OBJ) : tokenize.c dkbproto.h frame.h config.h

parse.$(OBJ) : parse.c dkbproto.h frame.h config.h

render.$(OBJ) : render.c dkbproto.h frame.h vector.h config.h

lighting.$(OBJ) : lighting.c dkbproto.h frame.h vector.h config.h

prioq.$(OBJ) : prioq.c dkbproto.h frame.h config.h

texture.$(OBJ) : texture.c dkbproto.h frame.h vector.h config.h

objects.$(OBJ) : objects.c dkbproto.h frame.h vector.h config.h

spheres.$(OBJ) : spheres.c dkbproto.h frame.h vector.h config.h

planes.$(OBJ) : planes.c dkbproto.h frame.h vector.h config.h

quadrics.$(OBJ) : quadrics.c dkbproto.h frame.h vector.h config.h

quartics.$(OBJ) : quartics.c dkbproto.h frame.h vector.h config.h

vect.$(OBJ) : vect.c dkbproto.h frame.h config.h

matrices.$(OBJ) : matrices.c dkbproto.h frame.h vector.h config.h

csg.$(OBJ) : csg.c dkbproto.h frame.h vector.h config.h

colour.$(OBJ) : colour.c dkbproto.h frame.h config.h

viewpnt.$(OBJ) : viewpnt.c dkbproto.h frame.h vector.h config.h

ray.$(OBJ) : ray.c dkbproto.h frame.h vector.h config.h

iff.$(OBJ) : iff.c dkbproto.h frame.h config.h

gif.$(OBJ) : gif.c dkbproto.h frame.h config.h

gifdecod.$(OBJ) : gifdecod.c dkbproto.h frame.h config.h

raw.$(OBJ) :	raw.c dkbproto.h frame.h config.h

triangle.$(OBJ) : triangle.c dkbproto.h frame.h vector.h config.h

amiga.$(OBJ) :	amiga.c dkbproto.h frame.h config.h

dump.$(OBJ) :	dump.c dkbproto.h frame.h config.h


