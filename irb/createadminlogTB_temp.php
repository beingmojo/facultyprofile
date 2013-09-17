<?php require_once('Connections/con3.php');
mysql_select_db("osp_irbdb", $con3) or die(mysql_error()); 
mysql_query("CREATE TABLE adminlog(id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), date VARCHAR(25), activity VARCHAR(45), username VARCHAR(30), activityType VARCHAR(45))")

or die("Create table Error: ".mysql_error());
echo "adminlog table created";
mysql_close($con3);

?> 