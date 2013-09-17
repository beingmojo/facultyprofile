<?php require_once('../Connections/con3.php'); ?>
<?php
  mysql_select_db($database_con3, $con3);
  mysql_query("alter table exemption MODIFY COLUMN project_purpose TEXT, MODIFY COLUMN category_pertains TEXT, MODIFY COLUMN exempt_reason TEXT ") or die("Alter table Error: ".mysql_error());
echo "exemption table altered";
mysql_close($con3);


?>
