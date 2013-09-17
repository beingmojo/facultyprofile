<?php
include '../utils.php';
include '../imageutils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$ipFilter = new InputFilter($_filter_tags,"",1,1,1);
	$accomplishment = $ipFilter->process( $_POST["ctr_accomplishment"] );
}

$query  = "UPDATE ctr_gen_info SET accomplishment = " . real_mysql_specialchars( $accomplishment, false ) .
			"WHERE pid = " . real_mysql_specialchars( $pid, true ) ;
			
real_execute_query( $query, $db_conn );
real_update_last_modified_timestamp( $db_conn, $pid );
real_redirect( "../editprofile.php", "pid=$pid&view=$view", $db_conn );
?>