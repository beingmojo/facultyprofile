<?php require_once('Connections/con3.php'); ?>
<?php
  mysql_select_db($database_con3, $con3);
  mysql_query("alter table application add ChairReviewDate VARCHAR(15) default NULL") or die("Create table Error: ".mysql_error());
echo "application table altered";
mysql_close($con3);


?>
