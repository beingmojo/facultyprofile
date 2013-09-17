<?php require_once('Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}



$fn=$_GET['fn'];
$appNum=$_GET['appNum'];

$sql = sprintf("SELECT Status FROM application WHERE App_Number = '%s'", $appNum);
$app = mysql_query($sql, $con) or die(mysql_error());
$rs_app = mysql_fetch_assoc($app);

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
if(($_SESSION['User_Type'] == "IRB Chair") ||($_SESSION['User_Type'] == "IRB Staff"))
header("Location: appSummary_irb.php?appNum=".$appNum); 
else
header("Location: appSummary_applicant.php?appNum=".$appNum); 
exit;
?>
