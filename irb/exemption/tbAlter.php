
<?php require_once('../Connections/dbc.php');
mysql_query("ALTER TABLE exemption add appFinished VARCHAR(10)") or die("Create table Error: ".mysql_error());
echo "exemption table altered";

mysql_query("ALTER TABLE continuation add appFinished VARCHAR(10)") or die("Create table Error: ".mysql_error());
echo "continuation table altered";
mysql_close($con);

?>
