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
	$max_pp_id = real_unescape( $_POST["max_pp_id"] );
	$itr = 0;
	for( $i = 1; $i <= 3; $i++ )
	{
		$degree = substr( real_unescape( $_POST["ppl_prof_preparation_degree".$i] ), 0, 255 );
		$major = substr( real_unescape( $_POST["ppl_prof_preparation_major".$i] ), 0, 255 );
		$institution = substr( real_unescape( $_POST["ppl_prof_preparation_institution".$i] ), 0, 255 );
		$year = substr( real_unescape( $_POST["ppl_prof_preparation_year".$i] ), 0, 16 );
		$status = ($_POST["ppl_prof_preparation_status".$i]=="on")?"1":"0";
		if( $degree != "" || $major != "" || $institution != "" || $year != "" )
		{ 
			$itr ++;
			$query = "INSERT INTO ppl_prof_preparation ( pid, pp_id, degree, major, institution, year, status ) VALUES( " .
					real_mysql_specialchars($pid, true) .
					", " . ($max_pp_id + $itr) . 
					", " . real_mysql_specialchars( $degree, false ) .
					", " . real_mysql_specialchars( $major, false ) .
					", " . real_mysql_specialchars( $institution, false ) .
					", " . real_mysql_specialchars( $year, false ) .
					", " . real_mysql_specialchars( $status, true ) .
					"  )";
	
			real_execute_query( $query, $db_conn );
			real_update_last_modified_timestamp( $db_conn, $pid );
		}
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>