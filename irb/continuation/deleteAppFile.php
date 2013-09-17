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
$ID = $_GET['ID'];
$path = "../appdoc/".$appNum."/continuation";
chmod($path, 02777);
$dh = @ opendir($path);

while (($file = @ readdir($dh)) !== false) {
    if($file == $fn ){
  			
		if (is_file("$path/$file")) unlink("$path/$file");
    }

@ closedir($dh);
}
header("Location: irb_continuation_summary.php?ID=".$ID);
exit;
?>
