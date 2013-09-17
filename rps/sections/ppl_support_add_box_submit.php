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
	
	$max_sup_id = real_unescape( $_POST["max_sup_id"] );
	$itr = 0;
	for( $i = 1; $i <= 3; $i++ )
	{
		$s_date = substr( real_unescape( $_POST["ppl_support_s_date".$i] ), 0, 16 );
		$e_date = substr( real_unescape( $_POST["ppl_support_e_date".$i] ), 0, 16 );
		$title = substr( real_unescape( $_POST["ppl_support_title".$i] ), 0, 255 );
		$sponsor = substr( real_unescape( $_POST["ppl_support_sponsor".$i] ), 0, 255 );
		$award_amt = substr( real_unescape( $_POST["ppl_support_award_amt".$i] ), 0, 32 );
		$prj_status = real_unescape( $_POST["ppl_support_prj_status".$i] );
		$status = ($_POST["ppl_support_status".$i]=="on")?"1":"0";
		if( $s_date != "" || $e_date != "" || $title != "" || $sponsor != "" )
		{ 
			$itr ++;
			$query = "INSERT INTO ppl_support ( pid, sup_id, s_date, e_date, title, sponsor, award_amt, prj_status, status ) VALUES( " .
					real_mysql_specialchars($pid, true) .
					", " . ($max_sup_id + $itr) . 
					", " . real_mysql_specialchars( $s_date, false ) .
					", " . real_mysql_specialchars( $e_date, false ) .
					", " . real_mysql_specialchars( $title, false ) .
					", " . real_mysql_specialchars( $sponsor, false ) .
					", " . real_mysql_specialchars( $award_amt, false ) .
					", " . real_mysql_specialchars( $prj_status, true ) .
					", " . real_mysql_specialchars( $status, true ) .
					"  )";
	
			real_execute_query( $query, $db_conn );
			real_update_last_modified_timestamp( $db_conn, $pid );
		}
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>