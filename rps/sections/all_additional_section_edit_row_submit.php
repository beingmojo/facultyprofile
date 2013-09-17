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
	$sub_section_id = real_unescape( $_POST["sub_section_id"] );
	$name = substr( real_unescape( $_POST["all_additional_section_name"] ), 0, 255 );
	$url_name = substr( real_unescape( $_POST["all_additional_section_url_name"] ), 0, 255 );
	$url = substr( real_unescape( $_POST["all_additional_section_url"] ), 0, 255 );
	$url = real_validate_url($url);
	$ipFilter = new InputFilter($_filter_tags,"",1,1,1);
	$description = $ipFilter->process( $_POST["all_additional_section_description"] );
	$status = ($_POST["all_additional_section_status"]=="on")?"1":"0";
	$remove_image = ($_POST["all_additional_section_remove_image"]=="on")?"1":"0";

	$image_id = real_unescape( $_POST["all_additional_section_image_id"] );

	if( $remove_image == "1" )
	{
		if( $image_id != 0 )
		{
			real_delete_image( $db_conn, $pid, $section_id, $image_id, "../images" );
			$image_id = 0;
		}
	}
	else
	{
		if( $image_id == 0 || $image_id == "" )
		{
			$cur_image_id = real_insert_image( $db_conn, $pid, $section_id, "imagefile", "../images" );
			if( $cur_image_id != 0 ) $image_id = $cur_image_id;
		}
		else
			real_update_image( $db_conn, $pid, $section_id, "imagefile", $image_id, "../images" );
	}	
	if( $name != "" )
	{
		$query = "UPDATE all_additional_section SET " .
					" name=". real_mysql_specialchars( $name, false ) .
					", url_name=" . real_mysql_specialchars( $url_name, false ) .
					", url=" . real_mysql_specialchars( $url, false ) .
					", description=" . real_mysql_specialchars( $description, false ) .
					", status=" . real_mysql_specialchars( $status, true ) .
					", image_id=" . real_mysql_specialchars( $image_id, true ) .
					" WHERE pid=". real_mysql_specialchars( $pid, true ) .
					" AND section_id=" . real_mysql_specialchars( $section_id, true ) .
					" AND sub_section_id=" . real_mysql_specialchars( $sub_section_id, true );
		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}

real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );

?>