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
	$query = 	"DELETE FROM gen_association USING gen_association, fac_researchcenter
				WHERE gen_association.pid = fac_researchcenter.ctr_pid 
				AND gen_association.assoc_pid = fac_researchcenter.pid 
				AND fac_researchcenter.add_req = 0 
				AND fac_researchcenter.pid = " . real_mysql_specialchars( $pid, true );
	real_execute_query( $query, $db_conn );
	
	$query = "DELETE FROM fac_researchcenter " .
				" WHERE add_req = 0 AND pid= " . real_mysql_specialchars( $pid, true ) ;
	real_execute_query( $query, $db_conn );
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>
