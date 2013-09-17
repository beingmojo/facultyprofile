<?php require_once('../Connections/dbc.php');
mysql_query("ALTER TABLE continuation add username VARCHAR(30)") or die("Alter table Error: ".mysql_error());
echo "continuation table altered";
mysql_close($con);

?>