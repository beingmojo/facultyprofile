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
	$max_app_id = real_unescape( $_POST["max_app_id"] );
	$itr = 0;
	for( $i = 1; $i <= 3; $i++ )
	{
		$s_date = substr( real_unescape( $_POST["ppl_appointment_s_date".$i] ), 0, 16 );
		$e_date = substr( real_unescape( $_POST["ppl_appointment_e_date".$i] ), 0, 16 );
		$rank = substr( real_unescape( $_POST["ppl_appointment_rank".$i] ), 0, 255 );
		$dept_school = substr( real_unescape( $_POST["ppl_appointment_dept_school".$i] ), 0, 255 );
		$off_coll = substr( real_unescape( $_POST["ppl_appointment_off_coll".$i] ), 0, 255 );
		$univ_comp = substr( real_unescape( $_POST["ppl_appointment_univ_comp".$i] ), 0, 255 );
		$status = ($_POST["ppl_appointment_status".$i]=="on")?"1":"0";
		if( $s_date != "" || $e_date != "" || $rank != "" || $dept_school != "" || $off_coll != "" || $univ_comp != "" )
		{ 
			$itr ++;
			$query = "INSERT INTO ppl_appointment ( pid, app_id, s_date, e_date, rank, dept_school, off_coll, univ_comp, status ) VALUES( " .
					real_mysql_specialchars($pid, true) .
					", " . ($max_app_id + $itr) . 
					", " . real_mysql_specialchars( $s_date, false ) .
					", " . real_mysql_specialchars( $e_date, false ) .
					", " . real_mysql_specialchars( $rank, false ) .
					", " . real_mysql_specialchars( $dept_school, false ) .
					", " . real_mysql_specialchars( $off_coll, false ) .
					", " . real_mysql_specialchars( $univ_comp, false ) .
					", " . real_mysql_specialchars( $status, true ) .
					"  )";
	
			real_execute_query( $query, $db_conn );
			real_update_last_modified_timestamp( $db_conn, $pid );
		}
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>