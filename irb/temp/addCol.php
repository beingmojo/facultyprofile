<?php require_once('../Connections/con3.php'); ?>
<?php
  mysql_select_db($database_con3, $con3);
  mysql_query("alter table application add COLUMN facultyReviewDate varchar(25)") or die("Alter table Error: ".mysql_error());
echo "New column added";
mysql_close($con3);


?>
