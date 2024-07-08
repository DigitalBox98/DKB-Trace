<html>
<head>
  <title>DKB Trace Render</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/dkb-trace/css/bootstrap.min.css">
  <script src="/dkb-trace/js/bootstrap.min.js"></script>
</head>

<body>
	<h2><span class="label label-primary">DKB Trace Renderer 2.2</span></h2><br><br>

<?php

// Generate temporary filenames
$timestamp = date_timestamp_get(date_create());
$filename = "scene_".$timestamp;
$dat_filename = $filename.".dat";
$tga_filename = $filename.".tga";
$png_filename = $filename.".png";

// Web root directory
$web_root = "/volume1/web";

// Read content of scene and generate file
$width = $_POST["widthvalue"];
$height = $_POST["heightvalue"];
$antialiasing = $_POST["antialiasing"];
$quality = $_POST["quality"];
?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Image Rendered</h3>
  </div>
  <div class="panel-body">
  
<?php
	
$content = $_POST["scene"];
$file = fopen($web_root."/web_images/".$dat_filename ,"w");
fwrite($file,$content);
fclose($file);

// Generate scene with DKB Trace
exec("/usr/local/dkb-trace/bin/dkb-trace +i".$web_root."/web_images/".$dat_filename." +w$width +h$height +l/usr/local/dkb-trace/share/dkb-trace/dat +o".$web_root."/web_images/".$tga_filename ." +ft +a$antialiasing +q$quality", $output);

// Convert TGA to PNG with ImageMagick
exec("/usr/bin/convert ".$web_root."/web_images/".$tga_filename." ".$web_root."/web_images/".$png_filename );
exec("cp ".$web_root."/web_images/".$png_filename." ".$web_root."/web_images/scene.png");

// Clean temporary files
exec("rm ".$web_root."/web_images/".$dat_filename);
exec("rm ".$web_root."/web_images/".$tga_filename);
exec("rm ".$web_root."/web_images/".$png_filename);

// Display scene image
echo "<img src=\"/web_images/scene.png\"><br><br>";
?>
	  

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Parameters</h3>
  </div>
  <div class="panel-body">

<?php

echo "Width : $width<br>";
echo "Height : $height<br>";
echo "Antialiasing : $antialiasing<br>";
echo "Quality : $quality<br>";
echo "Temporary scene : ".$filename."<br><br>";
?>

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Output Statistics</h3>
  </div>
  <div class="panel-body">

<?php

// Display statistics 
echo "<textarea rows=25 cols=120>";
foreach($output as $key => $value)
{
  echo $value . "\n";
}
echo "</textarea>";

?>
  </div>
</div>


</body>
</html>
