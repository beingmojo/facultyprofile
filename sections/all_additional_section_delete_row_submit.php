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
	$sub_section_id = real_unescape( $_POST["sub_section_id"] );
	$image_id = real_unescape( $_POST["all_additional_section_image_id"] );
	$query = "DELETE FROM all_additional_section " .
				" WHERE pid= " . real_mysql_specialchars( $pid, true ) .
				" AND section_id = " . real_mysql_specialchars( $section_id, true ) .
				" AND sub_section_id=" . real_mysql_specialchars( $sub_section_id, true );
	real_execute_query( $query, $db_conn );

	real_delete_image( $db_conn, $pid, $section_id, $image_id, "../images" );
	real_update_last_modified_timestamp( $db_conn, $pid );
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>
