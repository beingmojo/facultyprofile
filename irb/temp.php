<?php require_once('Connections/dbc.php');
  $insertSQL = "UPDATE application SET trainingFinished= 'Yes', Status = 'Application Submitted to IRB Chairs for Review' where App_Number = '2008T7246'";
 
$Result1 = mysql_query($insertSQL, $con) or die(mysql_error());
?>
