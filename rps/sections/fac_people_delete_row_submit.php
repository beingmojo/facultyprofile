<?php
include '../utils.php';
include '../imageutils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$pp_id = real_unescape( $_POST["ppl_id"] );
	
	$query = 	"DELETE FROM gen_association USING gen_association, fac_people 
					WHERE gen_association.assoc_login_id = fac_people.ppl_login_id 
					AND gen_association.pid = fac_people.pid 
					AND fac_people.ppl_id = " . real_mysql_specialchars( $pp_id, true ) . 
				"	AND fac_people.pid  = " . real_mysql_specialchars( $pid, true );
	real_execute_query( $query, $db_conn );
	
	$query = "DELETE FROM fac_people " .
				" WHERE pid= " . real_mysql_specialchars( $pid, true ) .
				" AND ppl_id=" . real_mysql_specialchars( $pp_id, true );
	real_execute_query( $query, $db_conn );

	
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>
