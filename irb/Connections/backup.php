<?php 
$hostname_con = "localhost";
$database_con = "osp_irbdb";
$username_con = "ospirb";
$password_con = "ospirb080307";

$backupFile = "/var/www/servers/www.osp.txstate.edu/web_root/irb_new/Connections/db_backup/". $database_con . date("Y-m-d-H-i-s")  . '.gz';

$command = "mysqldump --opt -h $hostname_con -u $username_con -p $password_con $database_con | gzip > $backupFile";

system($command);

?> 
