<?php
include '../utils.php';
include '../imageutils.php';
include '../fileutils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;
//$filedir = './syllabi/';
//$fileuploaddir = '/opt/www/html/'.$_home."/syllabi/";

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );
$course_id = real_unescape( $_POST["course_id"] );

if( real_can_user_edit( $db_conn, $pid ) == true )
{
if( $pid != "" )
	{
		$query = "UPDATE ppl_teaching SET " .
					" archive=1 WHERE pid=". real_mysql_specialchars( $pid, true ) .
					" AND course_id=" . real_mysql_specialchars( $course_id, true );

		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );

		$query = "INSERT INTO ppl_teaching ( pid,  hid, course_number, section_number, course_title, days, times, location, description, file_id, course_goal, url_name, course_url, semester, year, status, archive, default_address, office_location, room_no, phone_no_1, email_id, office_hours) SELECT pid, hid, course_number, section_number, course_title, days, times, location, description, file_id, course_goal, url_name, course_url, semester, year, status, 0, default_address, office_location, room_no, phone_no_1, email_id, office_hours FROM ppl_teaching WHERE pid=".$pid." AND course_id=".$course_id;

		real_execute_query( $query, $db_conn );
		$course_id = mysql_insert_id( $db_conn ) ;
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}

real_redirect( "../editprofile.php", "pid=$pid&view=$view#$course_id", $db_conn );

?>