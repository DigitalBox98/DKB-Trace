# DKB-Trace 2.12

This ray tracer was written by David K. Buck and is released as freely distributable software. The author retains all copyrights but permits free distribution of the software through any medium. The software may be used without charge so long as the code is not included in any commercial product.
<br>

# Original archive

DKB-Trace raytracer archive is coming from the Amiga Fish collection : <br>
https://ftp.funet.fi/pub/amiga/fish/501-600/ff513/DKBTrace.lha
<br>

# Improvements 

A WEB gui based on Boostrap/PHP has been added in the "web" folder 
<br>

# How to build 

Launch the command :<br>
```
build.sh
```

In case of error, you might need to launch before :
```
autoreconf -f -i
```

# How to install 

Launch the command :<br>
```
sudo make install
```

# Command line sample 

The below command will generate the skyvase.dat scene : 
```
/usr/local/dkb-trace/bin/dkb-trace  +i/usr/local/dkb-trace/share/dkb-trace/dat/skyvase.dat +l/usr/local/dkb-trace/share/dkb-trace/dat +o$HOME/skyvase.tga +w320 +h240 +ft +a 
```

# Features

Below are the screenshots of a version for NAS Synology :

Main screen with render options : <br>
<img width="819" alt="dkb1" src="https://github.com/DigitalBox98/DKB-Trace/assets/57635141/87a4e282-8388-4e79-8738-3af0b29731e6">

Display image for scene rendering : <br>
<img width="667" alt="dkb2" src="https://github.com/DigitalBox98/DKB-Trace/assets/57635141/f36e78b9-bc29-4699-ac25-8a3b50a6391f">

Display statistics : <br>
<img width="724" alt="dkb3" src="https://github.com/DigitalBox98/DKB-Trace/assets/57635141/7113173d-a3bc-4e83-963e-8cf2ca959d4c">
<img width="772" alt="dkb4" src="https://github.com/DigitalBox98/DKB-Trace/assets/57635141/6da4d2e5-6a43-4de7-b778-d548a9e9e07a">

Select sample scenes : <br>
<img width="303" alt="dkb5" src="https://github.com/DigitalBox98/DKB-Trace/assets/57635141/03873bfe-6396-435a-9617-fd368aebdfc7">

Highlight errors in scene script : <br>
<img width="695" alt="dkb7" src="https://github.com/DigitalBox98/DKB-Trace/assets/57635141/de359175-ab59-425a-85a8-22f814786926">

Rendering progress: <br>
<img width="706" alt="dkb8" src="https://github.com/DigitalBox98/DKB-Trace/assets/57635141/6c0fbbae-3414-4976-a6d1-0e48605d624b">

Online documentation : <br>
<img width="663" alt="dkb10" src="https://github.com/DigitalBox98/DKB-Trace/assets/57635141/a2758524-34ef-4414-9f4f-c29ccc1c2a54">





