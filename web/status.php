<?php

include("check_session.php");

?>

<?php
  // Get Token Id
  $token_id = $_GET["token_id"];

  // Read parameters
  $width = $_GET["width"];
  $height = $_GET["height"];
  $antialiasing = $_GET["antialiasing"];
  $quality = $_GET["quality"];
  
  // Log file
  $stdlog = "stdout_".$token_id.".log";

  // Web root directory
  $web_root = "/var/services/web_packages/dkb-trace";

  $outputprogress="";
  $returnprogress="";

  // Display status until log file exists
  if (file_exists($web_root."/work_images/".$stdlog))
  {
    exec("tail --lines=30 ".$web_root."/work_images/".$stdlog."| grep Line | tail --lines=2 | awk '{ print $2 }'", $outputprogress, $returnprogress);
  
    $i=1;
    foreach($outputprogress as $key => $value)
    {
		if ($i==1)
		{
			// Get first value in order to get complete line number
			$first_value=$value;
		}
    }
  
    $pourcent = floor($first_value*100/$height);
  }
  // Display scene	
  else
  {
    header("Location: display.php?token_id=".$token_id."&width=".$width."&height=".$height."&antialiasing=".$antialiasing."&quality=".$quality);      
  }

  
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
    <h3 class="panel-title">Progress</h3>
  </div>
  <div class="panel-body">

  <div class='progress'>
    <div class='progress-bar progress-bar-success progress-bar-striped active' id='renderprogress' role='progressbar' aria-valuenow='<?php echo $pourcent?>' aria-valuemin='0' aria-valuemax='100' style='width:<?php echo $pourcent?>%'><?php echo $pourcent?>%
    </div>
  </div>

	  
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

	<script type="text/javascript">
	  setTimeout("location.reload(true);",2000);
    </script>

</body>
</html>
