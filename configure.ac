# Process this file with autoconf to produce a configure script.

AC_INIT([dkb-trace], [2.2], [nicolas@digitalbox.com])
AM_INIT_AUTOMAKE

# Checks for programs.
AC_PROG_CC

# Checks for libraries.

# Checks for header files.
AC_HEADER_STDC
AC_CHECK_HEADERS([stdlib.h string.h sys/time.h])

# Checks for typedefs, structures, and compiler characteristics.

# Checks for library functions.
AC_CHECK_FUNCS([floor gettimeofday memset pow sqrt strchr strstr])
                   
AC_OUTPUT(Makefile doc/Makefile dat/Makefile src/Makefile web/Makefile)

