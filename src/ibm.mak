# IBM Makefile for DKB Ray Tracing Program by David Buck and Aaron Collins
# This file is released to the public domain.
#
# Note for the IBM Version:
# Uses system environment variable LIB for the linker's .LIB file path.
# (Example:  Set LIB=C:\LIB)  if you change this the two .LNK files will also
# need to be changed as well.  The system environment variable CMODEL also
# may be defined for the memory model of the compiler.  DKBTrace requires
# the "Large" memory model.  (Example Set CMODEL=l)  If you don't want to
# use the DOS environment variables, uncomment the following two lines:
#
#
# MAKE Macros and Such...
#

#CMODEL	=L
#LIB	=c:\lib
CC	=cl
OBJ	=obj
MACHINE_OBJ	= ibm.$(OBJ)

LINKER	=link /EXEPACK /PACKC /FARC /STACK:12288

# Uncomment for 8086/8088 instruction set usage
#
#CFLAGS	=/A$(CMODEL) /Gmsr /FPi /H32 /c /J

# Uncomment for 80186/80268 (incl. V20!) instruction set usage	[/Gmsr2]
#
CFLAGS	=/A$(CMODEL) /Gmsr2 /FPi87 /H32 /c /J

# If you have OS/2 to compile under, fix directory name and add this option
# to CFLAGS above...
#
# /B2 C:\msc\c2l.exe
#

# MS's NMAKE implicit rules for making an .OBJ file from a .C file...
#
.c.obj :
 $(CC) $(CFLAGS) /Oaxz $*.c

# The option:
#
# /Oaxz
#
# Is purported by Microsoft to produce the fastest possible code.  In fact it
# will break the RGB->HSV->RGB routines in IBM.C, if using the 8087 emulator.
# So, for IBM.C we are using:
#
# /Ogiltaz
#
# This optimization string works for IBM.C and should then have worked for all
# files, but, somehow, it BREAKS the compiler! (Internal compiler error C1001
# on TEXTURE.C!!)  Oh, well...
#

DKBOBJS = trace.$(OBJ) render.$(OBJ) tokenize.$(OBJ) parse.$(OBJ) \
	  objects.$(OBJ) spheres.$(OBJ) quadrics.$(OBJ) lighting.$(OBJ) \
	  prioq.$(OBJ) texture.$(OBJ) matrices.$(OBJ) csg.$(OBJ)  \
	  colour.$(OBJ) viewpnt.$(OBJ) ray.$(OBJ) planes.$(OBJ) iff.$(OBJ) \
	  gif.$(OBJ) gifdecod.$(OBJ) triangle.$(OBJ) raw.$(OBJ) dump.$(OBJ) \
	  targa.$(OBJ) quartics.$(OBJ) vect.$(OBJ) $(MACHINE_OBJ)

# DKB-Specific Dependencies
#
dkb.exe : $(DKBOBJS)
	$(LINKER) @ibm.lnk

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

raw.$(OBJ) : raw.c dkbproto.h frame.h config.h

dump.$(OBJ) : dump.c dkbproto.h frame.h config.h

targa.$(OBJ) : targa.c dkbproto.h frame.h config.h

triangle.$(OBJ) : triangle.c dkbproto.h frame.h vector.h config.h

ibm.$(OBJ) : ibm.c dkbproto.h frame.h config.h
 $(CC) $(CFLAGS) /Ogiltaz /D__STDC__ $*.c
