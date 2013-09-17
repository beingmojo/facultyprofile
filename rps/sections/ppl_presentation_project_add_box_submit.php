<?php
include '../utils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$view = real_unescape( $_POST["view"] );
$section_id = real_unescape( $_POST["section_id"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$max_pr_id = real_unescape( $_POST["max_pr_id"] );
	$itr = 0;
	$name = substr( real_unescape( $_POST["ppl_presentation_project_name"] ), 0, 255 );
	$ipFilter = new InputFilter($_filter_tags,"",1,1,1);
	$description = $ipFilter->process( $_POST["ppl_presentation_project_description"] );
	if ($_POST["ppl_presentation_project_s_mm"] != "mm" && $_POST["ppl_presentation_project_s_dd"] != "dd" && $_POST["ppl_presentation_project_s_yyyy"] != "yyyy")
		$s_date = 	real_unescape($_POST["ppl_presentation_project_s_mm"])."/".
					real_unescape($_POST["ppl_presentation_project_s_dd"])."/".
					real_unescape($_POST["ppl_presentation_project_s_yyyy"]);
	else
		$s_date = "";
	$s_date = substr($s_date, 0, 16);
	if ($_POST["ppl_presentation_project_e_mm"] != "mm" && $_POST["ppl_presentation_project_e_dd"] != "dd" && $_POST["ppl_presentation_project_e_yyyy"] != "yyyy")
		$e_date = 	real_unescape($_POST["ppl_presentation_project_e_mm"])."/".
					real_unescape($_POST["ppl_presentation_project_e_dd"])."/".
					real_unescape($_POST["ppl_presentation_project_e_yyyy"]);
	else
		$e_date = "";
	$e_date = substr($e_date, 0, 16);
	
	$url_name = substr( real_unescape( $_POST["ppl_presentation_project_url_name"] ), 0, 255 );
	$url = substr( real_unescape( $_POST["ppl_presentation_project_url"] ), 0, 255 );
	$url = real_validate_url($url);
	$status = ($_POST["ppl_presentation_project_status"]=="on")?"1":"0";

	if( $name != "" )
	{ 
		$itr ++;
		$query = "INSERT INTO ppl_presentation_project ( pid, pr_id, name, description, s_date, e_date, url_name, url, status ) VALUES( " .
				real_mysql_specialchars($pid, true) .
				", " . ($max_pr_id + $itr) . 
				", " . real_mysql_specialchars( $name, false ) .
				", " . real_mysql_specialchars( $description, false ) .
				", " . real_mysql_specialchars( $s_date, false ) .
				", " . real_mysql_specialchars( $e_date, false ) .
				", " . real_mysql_specialchars( $url_name, false ) .
				", " . real_mysql_specialchars( $url, false ) .
				", " . real_mysql_specialchars( $status, true ) .
				"  )";

		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}

real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>