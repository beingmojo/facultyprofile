<?php
$con = mysql_connect("localhost", "irbadmin", "irbadmin") or die(mysql_error()); 
mysql_select_db("irbdb", $con) or die(mysql_error()); 
 
// Create table
$sql = "CREATE TABLE application (ID MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY, username VARCHAR(20), App_Number VARCHAR(20), ProjectTitle VARCHAR(100))";

if(mysql_query($sql))
{ 
	echo "<br>table created";
}
else
{
  	echo "<br>Error creating table: " . mysql_error();
}
mysql_close($con);
?>