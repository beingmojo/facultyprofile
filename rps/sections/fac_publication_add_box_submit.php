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
	$max_pub_id = real_unescape( $_POST["max_pub_id"] );
	$itr = 0;
	for( $i = 1; $i <= 3; $i++ )
	{
		$year = substr( real_unescape( $_POST["fac_publication_year".$i] ), 0, 16 );
		$ranking = real_unescape( $_POST["fac_publication_ranking".$i] );
		$ipFilter = new InputFilter($_filter_tags,"",1,1,1);
		$name = $ipFilter->process( $_POST["fac_publication_name".$i] );
		$url = substr( real_unescape( $_POST["fac_publication_url".$i] ), 0, 255 );
		$url = real_validate_url($url);
		$category = substr( real_unescape( $_POST["fac_publication_category".$i] ), 0, 32 );
		if( $category == "" )
			$group_by = substr( real_unescape( $_POST["fac_publication_group_by".$i] ), 0, 32 );
		else
			$group_by = $category;
		$status = ($_POST["fac_publication_status".$i]=="on")?"1":"0";
		if( $year != "" && $name != "" )
		{ 
			$itr ++;
			$query = "INSERT INTO fac_publication ( pid, pub_id, year, ranking, name, url, group_by, status ) VALUES( " .
					real_mysql_specialchars($pid, true) .
					", " . ($max_pub_id + $itr) . 
					", " . real_mysql_specialchars( $year, false ) .
					", " . real_mysql_specialchars( $ranking, true ) .
					", " . real_mysql_specialchars( $name, false ) .
					", " . real_mysql_specialchars( $url, false ) .
					", " . real_mysql_specialchars( $group_by, false ) .
					", " . real_mysql_specialchars( $status, true ) .
					"  )";
	
			real_execute_query( $query, $db_conn );
		}
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>