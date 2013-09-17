<?php
ini_set('upload_max_filesize', '8M');
ini_set('memory_limit', '8M');
ini_set('post_max_size', '8M');
ini_set('session.bug_compat_42', '1');
ini_set('session.bug_compat_warn', '0');
ini_set('sendmail_from', 'ospirb@txstate.edu'); 
//ini_set('upload_max_filesize','4M');
//$con = mysql_connect("localhost", "ospirb", "ospirb080307") or die(mysql_error()); 
$hostname_con = "www.osp.txstate.edu";
$database_con = "osp_irbdb";
$username_con = "ospirb";
$password_con = "ospirb080307";
$con = mysql_pconnect($hostname_con, $username_con, $password_con) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db("osp_irbdb", $con) or die(mysql_error()); 
?>