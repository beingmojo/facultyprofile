<?php
include '../utils.php';
include '../fileutils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );

$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$course_id = real_unescape( $_POST["course_id"] );
	$file_id = real_unescape( $_POST["ppl_teaching_file_id"] );
	$query = "DELETE FROM ppl_teaching " .
				" WHERE pid= " . real_mysql_specialchars( $pid, true ) .
				" AND course_id=" . real_mysql_specialchars( $course_id, true );
	real_execute_query( $query, $db_conn );

	real_delete_file( $db_conn, $file_id );	
	real_update_last_modified_timestamp( $db_conn, $pid );
	
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>
