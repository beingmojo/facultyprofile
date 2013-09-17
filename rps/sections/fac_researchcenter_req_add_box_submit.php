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
	if( real_check_user_groupid( $db_conn, "admin" ) )
	{
		$query = "INSERT IGNORE INTO gen_association (pid, assoc_pid) SELECT fac_pid, pid FROM fac_researchcenter WHERE add_req = 1 AND pid = " . real_mysql_specialchars( $pid, true );
		real_execute_query( $query, $db_conn );

		$query = "UPDATE fac_researchcenter SET del_req = 0, add_req = 0 " .
					" WHERE add_req = 1 AND pid= " . real_mysql_specialchars( $pid, true ) ;
		real_execute_query( $query, $db_conn );		
	}
	
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>
