


 <?php require_once('connection/dbc.php'); ?>

<?php
mysql_query("CREATE TABLE security (ID VARCHAR(30), SecurityCode VARCHAR(30))") or die("Create table Error: ".mysql_error());

echo "Security table created";
mysql_close($con); 


?>