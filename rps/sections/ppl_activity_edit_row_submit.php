<?php
include '../utils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );

if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$act_id = real_unescape( $_POST["act_id"] );
	$name = substr( real_unescape( $_POST["ppl_activity_name"] ), 0, 255 );
	$ipFilter = new InputFilter($_filter_tags,"",1,1,1);
	$description = $ipFilter->process( $_POST["ppl_activity_description"] );
	$status = ($_POST["ppl_activity_status"]=="on")?"1":"0";

	if( $name != "" )
	{
		$query = "UPDATE ppl_activity SET " .
					" name=". real_mysql_specialchars( $name, false ) .
					", description=" . real_mysql_specialchars( $description, false ) .
					", status=" . real_mysql_specialchars( $status, true ) .
					" WHERE pid=". real_mysql_specialchars( $pid, true ) .
					" AND act_id=" . real_mysql_specialchars( $act_id, true );
		
		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>