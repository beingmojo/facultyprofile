<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dbc = "localhost";
$database_dbc = "irbdb";
$username_dbc = "root";
$password_dbc = "mypass";
$con = mysql_pconnect($hostname_dbc, $username_dbc, $password_dbc) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_dbc, $con) or die(mysql_error()); 
?>