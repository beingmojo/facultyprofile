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
	$description = $ipFilter->process( $_POST["eqp_description"] );
	$cost = substr( real_unescape( $_POST["eqp_cost"] ), 0, 32 );
	$value = real_unescape( $_POST["eqp_value"] );
	
	$query  = "UPDATE eqp_info SET description = " . real_mysql_specialchars( $description, false ) .
				", cost=" . real_mysql_specialchars( $cost, false ) .
				", value=" . real_mysql_specialchars( $value, true ) .
				" WHERE pid = " . real_mysql_specialchars( $pid, true ) ;
				
	real_execute_query( $query, $db_conn );
	real_update_last_modified_timestamp( $db_conn, $pid );
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view", $db_conn );
?>