<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$view = real_unescape( $_POST["view"] );
$section_id = real_unescape( $_POST["section_id"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$pp_id = real_unescape( $_POST["pp_id"] );
	$degree = substr( real_unescape( $_POST["ppl_prof_preparation_degree"] ), 0, 255 );
	$major = substr( real_unescape( $_POST["ppl_prof_preparation_major"] ), 0, 255 );
	$institution = substr( real_unescape( $_POST["ppl_prof_preparation_institution"] ), 0, 255 );
	$year = substr( real_unescape( $_POST["ppl_prof_preparation_year"] ), 0, 16 );
	$status = ($_POST["ppl_prof_preparation_status"]=="on")?"1":"0";	
	if( $degree != "" || $major != "" || $institution != "" || $year != "" )
	{
		$query = "UPDATE ppl_prof_preparation SET " .
					" degree=". real_mysql_specialchars( $degree, false ) .
					", major=" . real_mysql_specialchars( $major, false ) .
					", institution=" . real_mysql_specialchars( $institution, false ) .
					", year=" . real_mysql_specialchars( $year, false ) .
					", status=" . real_mysql_specialchars( $status, true ) .
					" WHERE pid=". real_mysql_specialchars( $pid, true ) .
					" AND pp_id=" . real_mysql_specialchars( $pp_id, true );
		
		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>