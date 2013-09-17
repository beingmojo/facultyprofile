<?php
$con = mysql_connect("localhost", "root", "mypass") or die(mysql_error()); 
mysql_select_db("irbdb", $con) or die(mysql_error()); 
?>