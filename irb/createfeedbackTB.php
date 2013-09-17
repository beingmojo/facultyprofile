<?php require_once('../Connections/con3.php'); ?>
<?php
  mysql_select_db($database_con3, $con3);
  mysql_query("ALTER TABLE `irbdb`.`feedback` ADD COLUMN `pageurl` VARCHAR(200),
 ADD COLUMN `comments` TEXT DEFAULT NULL AFTER `ProjectType`,
 ADD COLUMN `commentsDate` VARCHAR(25) DEFAULT NULL" ) or die("Create table Error: ".mysql_error());
echo "application table altered";
mysql_close($con3);