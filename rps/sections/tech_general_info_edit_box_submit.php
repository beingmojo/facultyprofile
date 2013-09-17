<?php
include '../utils.php';
include '../imageutils.php';
session_start();
$_err_page = "../" . $_err_page;

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$name = substr( real_unescape( $_POST["tech_general_info_name"] ), 0, 255 );
	$keywords = substr( real_unescape( $_POST["tech_general_info_keywords"] ), 0, 255 );
	$url_name = substr( real_unescape( $_POST["tech_general_info_url_name"] ), 0, 255 );
	$url = substr( real_unescape( $_POST["tech_general_info_url"] ), 0, 255 );
	$url = real_validate_url($url);
	$remove_image = ($_POST["tech_general_info_remove_image"]=="on")?"1":"0";
	$image_id = real_unescape( $_POST["tech_general_info_image_id"] );

	if( $remove_image == "1" )
	{
		if( $image_id != 0 )
		{
			real_delete_image( $db_conn, $pid, 0, $image_id, "../images" );
			$image_id = 0;
		}
	}
	else
	{
		if( $image_id == 0 || $image_id == "" )
		{
			$cur_image_id = real_insert_image( $db_conn, $pid, 0, "imagefile", "../images" );
			if( $cur_image_id != 0 ) $image_id = $cur_image_id;
		}
		else
			real_update_image( $db_conn, $pid, 0, "imagefile", $image_id, "../images" );
	}
	
	if( $name != "" )
	{
		$query = "UPDATE tech_gen_info SET ".
					" name=" . real_mysql_specialchars( $name, false ) .
					", keywords=" . real_mysql_specialchars( $keywords, false ) .
					", url=" . real_mysql_specialchars( $url, false ) .
					", url_name=" . real_mysql_specialchars( $url_name, false ) .				
					", image_id = " . real_mysql_specialchars( $image_id, true ) .
					" WHERE pid=" . real_mysql_specialchars( $pid, false ) ;
		real_execute_query( $query, $db_conn );
	
	
		$query = "UPDATE gen_profile_info SET name = " . 
					real_mysql_specialchars( $name ) .
					" WHERE pid=" . real_mysql_specialchars( $pid, false ) ;
		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view", $db_conn );		
?>
