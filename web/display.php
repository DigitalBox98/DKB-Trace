<?php

include("check_session.php");

?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>DKB Trace Render</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/bootstrap.min.js"></script>
</head>

<body>
	<h2><span class="label label-primary">DKB Trace Renderer 2.2</span></h2><br><br>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Control Panel</h3>
  </div>
  <div class="panel-body">
	  
    <button type="button" class="btn btn-default" onclick=" window.history.back();">
      <span class="glyphicon glyphicon-step-backward"></span> Back
    </button>
	  
    <button type="button" class="btn btn-default" onclick="window.open('help.html','DKB-Trace Documentation','left=400,top=100,width=700,height=600');">
      <span class="glyphicon glyphicon-question-sign"></span> Documentation
    </button>

  </div>
</div>



<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Image Rendered</h3>
  </div>
  <div class="panel-body">
  
  <img src="work_images/scene.png"><br><br>

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Parameters</h3>
  </div>
  <div class="panel-body">

<?php

  // Read parameters
  $token_id = $_GET["token_id"];
  $width = $_GET["width"];
  $height = $_GET["height"];
  $antialiasing = $_GET["antialiasing"];
  $quality = $_GET["quality"];

echo "Width : $width<br>";
echo "Height : $height<br>";
echo "Antialiasing : $antialiasing<br>";
echo "Quality : $quality<br>";
echo "Token Id : ".$token_id."<br><br>";
?>

  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Output Statistics</h3>
  </div>
  <div class="panel-body">

<?php

  // Get Token Id
  $token_id = $_GET["token_id"];

  // Temporary filenames
  $filename = "scene_".$token_id;
  $stdlog = "stdout_".$token_id.".log";
  $errlog = "stderr_".$token_id.".log";
  $dat_filename = $filename.".dat";
  $tga_filename = $filename.".tga";
  $png_filename = $filename.".png";

  // Web root directory
  $web_root = "/var/services/web_packages/dkb-trace";

  // View result for statistics
  exec("cat ".$web_root."/work_images/stdout.log | grep -v Line", $output, $return);

  // Display statistics 
  echo "<pre>";
  foreach($output as $key => $value)
  {
    echo $value . "\n";
  }
  echo "</pre>";

		
  // Remove old PNG image
  exec("rm ".$web_root."/work_images/scene.png");

  // No error when rendering scene : go ahead
  sleep(1);
  if ( 0 == filesize( $web_root."/work_images/".$errlog ) )
  {

    // Convert up to Image Magick if exists
    if (exec("/usr/bin/convert")==TRUE) 
    {

      // Convert TGA to PNG with ImageMagick
      exec("/usr/bin/convert ".$web_root."/work_images/".$tga_filename." ".$web_root."/work_images/".$png_filename );
  
      // Copy PNG image
      exec("cp ".$web_root."/work_images/".$png_filename." ".$web_root."/work_images/scene.png");

      // Copy the statistics log
      //exec("mv ".$web_root."/work_images/".$stdlog." ".$web_root."/work_images/stdout.log");

      // Clean temporary files
      exec("rm ".$web_root."/work_images/".$dat_filename);
      exec("rm ".$web_root."/work_images/".$tga_filename);
      exec("rm ".$web_root."/work_images/".$png_filename);
      exec("rm ".$web_root."/work_images/".$stdlog);
      exec("rm ".$web_root."/work_images/".$errlog);

    } 
    // Image Magick not available : propose link to TGA image
    else 
    {
	
      // Copy TGA image
      exec("cp ".$web_root."/work_images/".$tga_filename." ".$web_root."/work_images/scene.tga");

      // Copy the statistics log
      //exec("cp ".$web_root."/work_images/".$stdlog." ".$web_root."/work_images/stdout.log");
 
      // Clean temporary files
      exec("rm ".$web_root."/work_images/".$dat_filename);
      exec("rm ".$web_root."/work_images/".$tga_filename);
      exec("rm ".$web_root."/work_images/".$stdlog);
      exec("rm ".$web_root."/work_images/".$errlog);

    }

  }



?>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Control Panel</h3>
  </div>
  <div class="panel-body">
	  
    <button type="button" class="btn btn-default" onclick=" window.history.back();">
      <span class="glyphicon glyphicon-step-backward"></span> Back
    </button>
	  
    <button type="button" class="btn btn-default" onclick="window.open('help.html','DKB-Trace Documentation','left=400,top=100,width=700,height=600');">
      <span class="glyphicon glyphicon-question-sign"></span> Documentation
    </button>

  </div>
</div>


</body>
</html>
