<?php
include '../utils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$pub_id = real_unescape( $_POST["pub_id"] );
	$year = substr( real_unescape( $_POST["ctr_publication_year"] ), 0, 16 );
	$ranking = real_unescape( $_POST["ctr_publication_ranking"] );
	$ipFilter = new InputFilter($_filter_tags,"",1,1,1);
	$name = $ipFilter->process( $_POST["ctr_publication_name"] );
	$url = substr( real_unescape( $_POST["ctr_publication_url"] ), 0, 255 );
	$url = real_validate_url($url);
	$category = substr( real_unescape( $_POST["ctr_publication_category"] ), 0, 32 );
	if( $category == "" )
		$group_by = substr( real_unescape( $_POST["ctr_publication_group_by"] ), 0, 32 );
	else
		$group_by = $category;
	$status = ($_POST["ctr_publication_status".$i]=="on")?"1":"0";
	if( $year != "" && $name != "" )
	{ 
		$itr ++;
		$query = "UPDATE ctr_publication SET " .
				"year = " . real_mysql_specialchars( $year, false ) .
				", ranking = " . real_mysql_specialchars( $ranking, true ) .
				", name = " . real_mysql_specialchars( $name, false ) .
				", url = " . real_mysql_specialchars( $url, false ) .
				", group_by = " . real_mysql_specialchars( $group_by, false ) .
				", status = " . real_mysql_specialchars( $status, true ) .
				" WHERE pid=". real_mysql_specialchars( $pid, true ) .
				" AND pub_id=" . real_mysql_specialchars( $pub_id, true );

		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>