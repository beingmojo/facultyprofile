<?php require_once('Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "IRB Staff")) { 
  
 if (!($_SESSION['User_Type'] == "IRB Chair")){
  header("Location: ". $restrictGoTo); 
  exit;
  }
}


$rev=$_GET['ID'];
$theValue = (!get_magic_quotes_gpc()) ? addslashes($rev) : $rev;
 $query_Recordset = "delete FROM user WHERE username = '".$theValue."'";
$result = mysql_query($query_Recordset, $con) or die(mysql_error());
header("Location: listReviewers.php"); 
exit;
?>
