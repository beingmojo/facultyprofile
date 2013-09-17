<?php require_once('Connections/con3.php'); ?>
<?php
  mysql_select_db($database_con3, $con3);
//$query = "SELECT appNum, numReviewers, reviewRequestingDate, rev1Finished, rev2Finished, rev3Finished from reviewlog where ((noticeChair NOT LIKE 'Yes') && (appNum ='2008K9271'))";
//$query = "SELECT appNum, numReviewers, reviewRequestingDate, rev1Finished, rev2Finished, rev3Finished from reviewlog where (appNum ='2008K9271')";
$query = "update reviewlog set noticeChair='Yes' where appNum ='2008N3890'";

$result = mysql_query($query, $con3) or die(mysql_error());
echo "Done";
?>
