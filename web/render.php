<?php

include("check_session.php");

?>

<?php

  // Get Token Id
  $token_id = $_POST["token_id"];

  // Generate temporary filenames
  $filename = "scene_".$token_id;
  $stdlog = "stdout_".$token_id.".log";
  $errlog = "stderr_".$token_id.".log";
  $dat_filename = $filename.".dat";
  $tga_filename = $filename.".tga";
  $png_filename = $filename.".png";

  // Web root directory
  $web_root = "/var/services/web_packages/dkb-trace";

  // Read content of scene and generate dat file
  $content = $_POST["scene"];

  $file = fopen($web_root."/work_images/".$dat_filename ,"w");
  fwrite($file,$content);
  fclose($file);

  // Read parameters
  $width = $_POST["widthvalue"];
  $height = $_POST["heightvalue"];
  $antialiasing = $_POST["antialiasing"];
  $quality = $_POST["quality"];

  // Generate scene in background with DKB Trace with log file and remove std log file at the end
  exec("/var/packages/dkb-trace/target/share/dkb-trace/web/exec.sh ".chr(34)."/var/packages/dkb-trace/target/bin/dkb-trace +i".$web_root."/work_images/".$dat_filename." +w$width +h$height +l/var/packages/dkb-trace/target/share/dkb-trace/dat +o".$web_root."/work_images/".$tga_filename ." +ft +a$antialiasing +q$quality +v ".chr(34)." ".chr(34)."mv ".$web_root."/work_images/".$stdlog." ".$web_root."/work_images/stdout.log".chr(34)." >".$web_root."/work_images/".$stdlog."  2>".$web_root."/work_images/".$errlog." &", $output, $return);

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


<?php

  // Get Token Id
  //$token_id = $_GET["token_id"];

  // Error log file
  //$errlog = "stderr_".$token_id.".log";

  // Web root directory
  //$web_root = "/volume1/web";

  // Error when rendering scene : ie errlog file not empty
  sleep(1);
  if ( 0 != filesize( $web_root."/work_images/".$errlog ) )
  {
 
?>

<h2><span class="label label-primary">DKB Trace Renderer 2.2</span></h2><br><br>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Control Panel</h3>
  </div>
  <div class="panel-body">
	  
    <button type="button" class="btn btn-warning" onclick=" window.history.back();">
      <span class="glyphicon glyphicon-step-backward"></span> Back
    </button>
	  
    <button type="button" class="btn btn-default" onclick="window.open('help.html','DKB-Trace Documentation','left=400,top=100,width=700,height=600');">
      <span class="glyphicon glyphicon-question-sign"></span> Documentation
    </button>

  </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Error detected </h3>
  </div>
  <div class="panel-body">
	 
  
<?php
	$errfile = fopen($web_root."/work_images/".$errlog, "r");
    $errlineno = 1;
    // Display error lines
	while(!feof($errfile)) 
	{
	  $errline = fgets($errfile);
	  echo $errline."<br>";

	  // Find err line number 
	  $pattern = '/line [0-9]+/';
	  if (preg_match($pattern, $errline, $matches) == 1)
	  {
		  $errlineno = str_replace("line ", "", $matches[0]);
	  }
	}
	fclose($errfile);
	
?>	
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Scene Description </h3>
  </div>
  <div class="panel-body">
    <pre>
<?php

    // Read dat filename
    $filename = "scene_".$token_id;
    $dat_filename = $filename.".dat";
	
	$file = fopen($web_root."/work_images/".$dat_filename ,"r");
    $content = fread($file, filesize($web_root."/work_images/".$dat_filename));
	fclose($file);

    $content_lines = explode("\n", $content);
	
	$errline = $errlineno;
	$topline = $errline-10;
	$bottomline = $errline+10;
	$line = 0;
	echo "...\n";
	foreach($content_lines as $key => $value)
	{
	  if ($line >= $topline and $line <= $bottomline)
	  {
	    if ($line == $errline)
	    {
	      echo "<font color=red>".$line." ".$value."</font>";
	    }
		else
		{
	      echo $line." ".$value;
		}
	  }
	  $line = $line+1;
	}
	echo "\n...";
	
	
?>
    </pre>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Control Panel</h3>
  </div>
  <div class="panel-body">
	  
    <button type="button" class="btn btn-warning" onclick=" window.history.back();">
      <span class="glyphicon glyphicon-step-backward"></span> Back
    </button>
	  
    <button type="button" class="btn btn-default" onclick="window.open('help.html','DKB-Trace Documentation','left=400,top=100,width=700,height=600');">
      <span class="glyphicon glyphicon-question-sign"></span> Documentation
    </button>

  </div>
</div>


<?php	
}
// Redirect to status page
else
{
?>
  <script type="text/javascript">
    window.location.replace("status.php?<?php echo "token_id=".$token_id."&width=".$width."&height=".$height."&antialiasing=".$antialiasing."&quality=".$quality; ?>");
  </script>
   
<?php
}
?>

</body>
</html>



