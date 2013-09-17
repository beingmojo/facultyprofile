<?php require_once('Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

if (!($_SESSION['User_Type'] == "IRB Support")) { 
if (!($_SESSION['User_Type'] == "IRB Staff")) { 
  
 if (!($_SESSION['User_Type'] == "IRB Chair")){
  header("Location: ". $restrictGoTo); 
  exit;
  }
}
}


$fn=$_GET['fn'];
$appNum=$_GET['appNum'];
if (($rs_app['Status'] == "Application in Process") || ($rs_app['Status'] == "IRB Admin Requests Revision") || ($rs_app['Status'] == "IRB Chair Requests Revision")){

$path = "appdoc/".$appNum;
chmod($path, 02777);
$dh = @ opendir($path);

while (($file = @ readdir($dh)) !== false) {
    if($file == $fn ){
  			
		if (is_file("$path/$file")) unlink("$path/$file");
    }
}
@ closedir($dh);
}
header("Location: appSummary_irb.php?appNum=".$appNum); 
exit;
?>
