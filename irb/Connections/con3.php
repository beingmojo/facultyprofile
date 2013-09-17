<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true" memory_limit, post_max_size
ini_set('upload_max_filesize', '8M');
ini_set('memory_limit', '8M');
ini_set('post_max_size', '8M');
ini_set('session.bug_compat_42', '1');
ini_set('session.bug_compat_warn', '0');
ini_set('sendmail_from', 'ospirb@txstate.edu'); 
//ini_set('upload_max_filesize','4M');
$hostname_con3 = "localhost";
$database_con3 = "osp_irbdb";
$username_con3 = "ospirb";
$password_con3 = "ospirb080307";
$con3 = mysql_pconnect($hostname_con3, $username_con3, $password_con3) or trigger_error(mysql_error(),E_USER_ERROR); 
?>