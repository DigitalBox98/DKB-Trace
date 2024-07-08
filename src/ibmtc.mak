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

# Uncomment for Amiga Lattice C FFP
# CFLAGS	= -cusrft -ff -m0 -q5w5e -b0 -O -v
# DUMPFLAGS	= -cusrt -ff -m0 -q5w5e -O -v

# Uncomment for Amiga Lattice C with 68881
# CFLAGS	= -cusrft -f8 -m2 -q5w5e -b0 -O -v

# Flags for debugging
# CFLAGS	= -cusrft -f8 -m2 -b0 -q5w5e -d5 -v

#LIBSFFP	= lib:lcmffp.lib lib:lcnb.lib lib:amiga.lib
#LIBS881	= lib:lcm881.lib lib:lcnb.lib lib:amiga.lib
#OBJ	= o
#MACHINE_OBJ	= amiga.$(OBJ)


# Make's implicit rules for making a .o file from a .c file...
#
#.c.o :
#	$(CC) $(CFLAGS) $*

# Generic "Unix" MAKE's implicit rules for making a .OBJ file from a .C file
#
#*.o : *.c
# $(CC) $(CFLAGS) $*

#***************************************************************
#*
#*                      IBM Options
#*
#***************************************************************

# Note for the IBM Version:
# Uses system environment variable LIB for the linker's .LIB file path.
# (Example:  Set LIB=C:\LIB)  if you change this the two .LNK files will also
# need to be changed as well.  The system environment variable CMODEL also
# may be defined for the memory model of the compiler.  DKBTrace requires
# the "Large" memory model.  (Example Set CMODEL=l)  If you don't want to
# use the DOS environment variables, uncomment the following two lines:

CMODEL	=l
LIB	=c:\lib

CC	=tcc
OBJ	=obj
MACHINE_OBJ	= ibm.$(OBJ)

# Uncomment Turbo Link for Symbolic Debugging, or use DOS/MS-LINK for
# faster .EXE execution speed (shame on you, Borland, for no FARCALL!...)
# Note: you also must use a -v in the CFLAGS rather than -v- if you want
# to use the symbolic debugging facilities of Turbo-Debug.

#TLINK	=tlink /l/v
TLINK	=link /EXEPACK /PACKCODE /FARCALL
#
# IBM (Turbo-MAKE, actually) Specific MAKE Directives:
#
#
# Uncomment This for No Numeric Data Processor Extension (No Math Co)
#LINKFLAGS=$(LIB)\emu+$(LIB)\math$(CMODEL)+$(LIB)\c$(CMODEL);
#
# Uncomment This for NDP Extension (80x87 Co-Processor) Support
LINKFLAGS=$(LIB)\fp87+$(LIB)\math$(CMODEL)+$(LIB)\c$(CMODEL);
#

# Uncomment for 8086/8088 instruction set usage
#
#CFLAGS	=-m$(CMODEL) -r -K -G -O -Z -d -c -v- -k- -N- -DTURBOC


# Uncomment for 80186/80268 (incl. V20!) instruction set usage
#
CFLAGS	=-m$(CMODEL) -1 -a -r -K -G -O -Z -d -c -v- -k- -N- -DTURBOC

# Turbo-MAKE's implicit rules for making a .OBJ file from a .C file...
#
.c.obj :
 $(CC) $(CFLAGS) $*

# Generic "Unix" MAKE's implicit rules for making an .OBJ file from a .C file
#
#*.obj : *.c
# $(CC) $(CFLAGS) $*


#***************************************************************
#*
#*                          Common  Stuff
#*
#***************************************************************

DKBOBJS = trace.$(OBJ) render.$(OBJ) tokenize.$(OBJ) parse.$(OBJ) \
	  objects.$(OBJ) spheres.$(OBJ) quadrics.$(OBJ) lighting.$(OBJ) \
	  prioq.$(OBJ) texture.$(OBJ) matrices.$(OBJ) csg.$(OBJ) \
	  colour.$(OBJ) viewpnt.$(OBJ) ray.$(OBJ) planes.$(OBJ) iff.$(OBJ) \
	  gif.$(OBJ) gifdecod.$(OBJ) triangle.$(OBJ) raw.$(OBJ) dump.$(OBJ) \
	  targa.$(OBJ) quartics.$(OBJ) vect.$(OBJ) $(MACHINE_OBJ)


#  Amiga Linkage...
#
trace881:	$(DKBOBJS)
	blink with withfile LIB $(LIBS881) TO trace881

traceffp:	$(DKBOBJS)
	blink with withfile LIB $(LIBSFFP) TO traceffp

Sculpt2DKB:	Sculpt2DKB.o
	blink lib:c.o Sculpt2DKB.o lib $(LIBSFFP) to Sculpt2DKB

# IBM Linkage...
#
dkb.exe : $(DKBOBJS)
	$(TLINK) @dkbtc87.lnk

dkbno87.exe : $(DKBOBJS)
	$(TLINK) @dkbtc.lnk

Dump2RAW.exe : Dump2RAW.obj
	$(TLINK) $(LIB)\c0$(CMODEL)+Dump2RAW,Dump2RAW,Dump2RAW/m,$(LINKFLAGS)

TGA2Dump.exe : TGA2Dump.obj
	$(TLINK) $(LIB)\c0$(CMODEL)+TGA2Dump,TGA2Dump,TGA2Dump/m,$(LINKFLAGS)

Sculpt2D.exe : Sculpt2D.obj
	$(TLINK) $(LIB)\c0$(CMODEL)+Sculpt2D,Sculpt2D,Sculpt2D/m,$(LINKFLAGS)

gluetga.exe : gluetga.obj
	$(TLINK) $(LIB)\c0$(CMODEL)+gluetga,gluetga,gluetga/m,$(LINKFLAGS)

halftga.exe : halftga.obj
	$(TLINK) $(LIB)\c0$(CMODEL)+halftga,halftga,halftga/m,$(LINKFLAGS)

#
# Specific module/header dependencies for DKBtrace:
#

Dump2RAW.$(OBJ) : Dump2RAW.c config.h

TGA2Dump.$(OBJ) : TGA2Dump.c

Sculpt2DKB.$(OBJ) : Sculpt2DKB.c dkbproto.h frame.h

halftga.$(OBJ) : halftga.c

gluetga.$(OBJ) : gluetga.c

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

ibm.$(OBJ) :	ibm.c dkbproto.h frame.h config.h

unix.$(OBJ) :	unix.c dkbproto.h frame.h config.h


#
#
#  Utilities
#

#  Amiga Linkage
#
Dump2RGB:	Dump2RGB.o
		blink lib:c.o Dump2RGB.o LIB $(LIBSFFP) TO Dump2RGB

Dump2Raw:	Dump2Raw.o
		blink lib:c.o Dump2Raw.o LIB $(LIBSFFP) TO Dump2Raw

DumpToIFF:	DumpToIFF.o palette.o showprioq.o gio.o iffw.o ilbmw.o putpict.o packer.o
		blink with dumpwithfile LIB $(LIBSFFP) TO DumpToIFF

DumpToIFF.o:	DumpToIFF.c
		$(CC) $(DUMPFLAGS) $*

Dump2RGB.o:	Dump2RGB.c

Dump2Raw.o:	Dump2Raw.c

TGA2Dump.o:	TGA2Dump.c

palette.o:	palette.c showprioq.h
		$(CC) $(DUMPFLAGS) $*

showprioq.o:	showprioq.c showprioq.h
		$(CC) $(DUMPFLAGS) $*

gio.o:		gio.c
		$(CC) $(DUMPFLAGS) $*

iffw.o:		iffw.c
		$(CC) $(DUMPFLAGS) $*

ilbmw.o:		ilbmw.c
		$(CC) $(DUMPFLAGS) $*

putpict.o:		putpict.c
		$(CC) $(DUMPFLAGS) $*

packer.o:		packer.c
		$(CC) $(DUMPFLAGS) $*
