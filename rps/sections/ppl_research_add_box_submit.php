<?php
include '../utils.php';
include '../imageutils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$max_resch_id = real_unescape( $_POST["max_resch_id"] );
	$itr = 0;
	$name = substr( real_unescape( $_POST["ppl_research_name"] ), 0, 255 );
	$url_name = substr( real_unescape( $_POST["ppl_research_url_name"] ), 0, 255 );
	$url = substr( real_unescape( $_POST["ppl_research_url"] ), 0, 255 );
	$url = real_validate_url($url);
	$ipFilter = new InputFilter(array( "script" ),"",1,1,1);
	$description = $ipFilter->process( $_POST["ppl_research_description"] );
	$status = ($_POST["ppl_research_status"]=="on")?"1":"0";
	$image_id = real_insert_image( $db_conn, $pid, $section_id, "imagefile", "../images" );

	if( $name != "" )
	{ 
		$itr ++;
		$query = "INSERT INTO ppl_research ( pid, resch_id, name, url_name, url, description, status, image_id ) VALUES( " .
				real_mysql_specialchars($pid, true) .
				", " . ($max_resch_id + $itr) . 
				", " . real_mysql_specialchars( $name, false ) .
				", " . real_mysql_specialchars( $url_name, false ) .
				", " . real_mysql_specialchars( $url, false ) .
				", " . real_mysql_specialchars( $description, false ) .
				", " . real_mysql_specialchars( $status, true ) .
				", " . $image_id .
				"  )";

		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}

real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );

?>