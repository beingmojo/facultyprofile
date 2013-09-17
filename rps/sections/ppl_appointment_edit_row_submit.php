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
	$app_id = real_unescape( $_POST["app_id"] );
	$s_date = substr( real_unescape( $_POST["ppl_appointment_s_date"] ), 0, 16 );
	$e_date = substr( real_unescape( $_POST["ppl_appointment_e_date"] ), 0, 16 );
	$rank = substr( real_unescape( $_POST["ppl_appointment_rank"] ), 0, 255 );
	$dept_school = substr( real_unescape( $_POST["ppl_appointment_dept_school"] ), 0, 255 );
	$off_coll = substr( real_unescape( $_POST["ppl_appointment_off_coll"] ), 0, 255 );
	$univ_comp = substr( real_unescape( $_POST["ppl_appointment_univ_comp"] ), 0, 255 );
	$status = ($_POST["ppl_appointment_status"]=="on")?"1":"0";

	if( $s_date != "" || $e_date != "" || $rank != "" || $dept_school != "" || $off_coll != "" || $univ_comp != "" )
	{
		$query = "UPDATE ppl_appointment SET " .
					" s_date = " . real_mysql_specialchars( $s_date, false ) .
					", e_date = " . real_mysql_specialchars( $e_date, false ) .
					", rank = " . real_mysql_specialchars( $rank, false ) .
					", dept_school = " . real_mysql_specialchars( $dept_school, false ) .
					", off_coll = " . real_mysql_specialchars( $off_coll, false ) .
					", univ_comp = " . real_mysql_specialchars( $univ_comp, false ) .
					", status = " . real_mysql_specialchars( $status, true ) .
					" WHERE pid=". real_mysql_specialchars( $pid, true ) .
					" AND app_id=" . real_mysql_specialchars( $app_id, true );
		
		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>