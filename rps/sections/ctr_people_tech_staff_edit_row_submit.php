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
	$tech_staff_no = real_unescape( $_POST["ctr_people_tech_staff_no"] );
	$query = "UPDATE ctr_gen_info SET " .
				" tech_staff_no=". real_mysql_specialchars( $tech_staff_no, true ) .
				" WHERE pid=". real_mysql_specialchars( $pid, true );
	real_execute_query( $query, $db_conn );
	real_update_last_modified_timestamp( $db_conn, $pid );
}

real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );

?>