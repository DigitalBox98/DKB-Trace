@echo off
:loop
if "%1"=="" goto end
tga2img %1
img2gif -d -m %1
del %1.img
shift
goto loop
:end
