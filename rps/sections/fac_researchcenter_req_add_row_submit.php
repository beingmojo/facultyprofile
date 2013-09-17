<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$fac_pid = real_unescape( $_POST["fac_pid"] );
	if( real_check_user_groupid( $db_conn, "admin" ) )
	{
		$query = "UPDATE fac_researchcenter SET del_req = 0, add_req = 0 " .
					" WHERE pid= " . real_mysql_specialchars( $pid, true ) .
					" AND fac_pid=" . real_mysql_specialchars( $fac_pid, true );
		real_execute_query( $query, $db_conn );		

		$query = "INSERT IGNORE INTO gen_association (pid, assoc_pid) VALUES ( " . real_mysql_specialchars( $fac_pid, true ) . ", " . real_mysql_specialchars( $pid, true ) . ") ";
		real_execute_query( $query, $db_conn );
	}
	
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>
