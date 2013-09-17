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
		$query = 	"DELETE FROM gen_association USING gen_association, fac_facility
						WHERE gen_association.pid = fac_facility.fac_pid 
						AND gen_association.assoc_pid = fac_facility.pid 
						AND fac_facility.add_req = 0 
						AND fac_facility.pid = " . real_mysql_specialchars( $pid, true );
		real_execute_query( $query, $db_conn );
		
		$query = "DELETE FROM fac_facility " .
					" WHERE add_req = 0 AND pid= " . real_mysql_specialchars( $pid, true ) ;
		real_execute_query( $query, $db_conn );
	}
	else
	{
		$query = "UPDATE fac_facility SET del_req = 1 " .
					" WHERE add_req = 0 AND pid= " . real_mysql_specialchars( $pid, true );
		real_execute_query( $query, $db_conn );		
	}
	
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>