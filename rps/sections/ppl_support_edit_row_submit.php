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
	$sup_id = real_unescape( $_POST["sup_id"] );
	$s_date = substr( real_unescape( $_POST["ppl_support_s_date"] ), 0, 16 );
	$e_date = substr( real_unescape( $_POST["ppl_support_e_date"] ), 0, 16 );
	$title = substr( real_unescape( $_POST["ppl_support_title"] ), 0, 255 );
	$sponsor = substr( real_unescape( $_POST["ppl_support_sponsor"] ), 0, 255 );
	$award_amt = substr( real_unescape( $_POST["ppl_support_award_amt"] ), 0, 32 );
	$prj_status = real_unescape( $_POST["ppl_support_prj_status"] );
	$status = ($_POST["ppl_support_status"]=="on")?"1":"0";
	
	if( $s_date != "" || $e_date != "" || $title != "" || $sponsor != "" )
	{
		$query = "UPDATE ppl_support SET " .
					" s_date=". real_mysql_specialchars( $s_date, false ) .
					", e_date=" . real_mysql_specialchars( $e_date, false ) .
					", title=" . real_mysql_specialchars( $title, false ) .
					", sponsor=" . real_mysql_specialchars( $sponsor, false ) .
					", award_amt=" . real_mysql_specialchars( $award_amt, false ) .
					", prj_status=" . real_mysql_specialchars( $prj_status, false ) .
					", status=" . real_mysql_specialchars( $status, true ) .
					" WHERE pid=". real_mysql_specialchars( $pid, true ) .
					" AND sup_id=" . real_mysql_specialchars( $sup_id, true );
		
		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>