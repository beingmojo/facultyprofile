<?php require_once('../Connections/con3.php');
 mysql_select_db($database_con3, $con3);
mysql_query("alter table continuation modify ID VARCHAR(20) NOT NULL") or die("Alter table Error: ".mysql_error());
echo "Continuation table altered";
mysql_close($con3);
?>