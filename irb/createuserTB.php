
 <?php require_once('Connections/dbc.php'); ?>

<?php
mysql_query("CREATE TABLE messages(ID INTEGER UNSIGNED AUTO_INCREMENT, EmailTime VARCHAR(45), FromEmail VARCHAR(45), ToEmail VARCHAR(45), Subject VARCHAR(100), Msg TEXT, appNum VARCHAR(45), PRIMARY KEY (`ID`))") or die("Create table Error: ".mysql_error());
echo "table created";
mysql_close($con);
 
?>