<?php
$con = mysql_connect("localhost","root","mypass");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }// Create database
if (mysql_query("CREATE DATABASE irbdb",$con))
  {
  echo "Database created";
  }
else
  {
  echo "Error creating database: " . mysql_error();
  }// Create table in my_db database
mysql_select_db("irbdb", $con);

$sql = "CREATE TABLE users (ID MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY, First_Name VARCHAR(20), Last_Name VARCHAR(20), Phone VARCHAR(10), Email VARCHAR(30), User_Type VARCHAR(30),department VARCHAR(30), Rank VARCHAR(20), Major VARCHAR(40), HSP_Number VARCHAR(60), username VARCHAR(20), password VARCHAR(15))";

if(mysql_query($sql,$con))
{ 
	echo "<br>table created";
}
else
{
  	echo "<br>Error creating table: " . mysql_error();
}
mysql_close($con);
?>