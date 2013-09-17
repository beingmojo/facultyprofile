<?php
include '../utils.php';
include '../imageutils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$name = substr( real_unescape( $_POST["fac_info_name"] ), 0, 255 );
	$hide_name = ($_POST["fac_info_hide_name"]=="1")?"1":"0";
	$ipFilter = new InputFilter($_filter_tags,"",1,1,1);
	$description = $ipFilter->process( $_POST["fac_about_description"] );

	$remove_image = ($_POST["fac_remove_image"]=="1")?"1":"0";
	//$remove_logo = ($_POST["fac_remove_logo"]=="1")?"1":"0";
	//$remove_banner = ($_POST["fac_remove_banner"]=="1")?"1":"0";
	$fac_image_id = real_unescape( $_POST["fac_info_fac_image_id"] );
	//$banner_image_id = real_unescape( $_POST["fac_info_banner_image_id"] );
	//$logo_image_id = real_unescape( $_POST["fac_info_logo_image_id"] );

	$contact_name = substr( real_unescape( $_POST["fac_info_contact_name"] ), 0, 255 );
	$contact_rank = substr( real_unescape( $_POST["fac_info_contact_rank"] ), 0, 255 );
	$contact_phone = substr( real_unescape( $_POST["fac_info_contact_phone"] ), 0, 255 );
	$contact_email = substr( real_unescape( $_POST["fac_info_contact_email"] ), 0, 255 );
	$contact_id = substr( real_unescape( $_POST["fac_info_contact_login_id"] ), 0, 255 );

	$keywords = substr( real_unescape( $_POST["fac_info_keywords"] ), 0, 255 );

	if( $remove_image == "1" )
	{
		if( $fac_image_id != 0 )
		{
			real_delete_image( $db_conn, $pid, 0, $fac_image_id, "../images" );
			$fac_image_id = 0;
		}
	}
	else
	{
		if( $fac_image_id == 0 || $fac_image_id == "" )
		{
			$cur_image_id = real_insert_image( $db_conn, $pid, 0, "imagefile", "../images" );
			if( $cur_image_id != 0 ) $fac_image_id = $cur_image_id;
		}
		else
			real_update_image( $db_conn, $pid, 0, "imagefile", $fac_image_id, "../images" );
	}
/*
	if( $remove_banner == "1" )
	{
		if( $banner_image_id != 0 )
		{
			real_delete_image( $db_conn, $pid, 0, $banner_image_id, "../images" );
			$banner_image_id = 0;
		}
	}
	else
	{
		if( $banner_image_id == 0 || $banner_image_id == "" )
		{
			$cur_image_id = real_insert_image_type( $db_conn, $pid, 0, "bannerfile", "../images", "banner" );
			if( $cur_image_id != 0 ) $banner_image_id = $cur_image_id;
		}
		else
			real_update_image_type( $db_conn, $pid, 0, "bannerfile", $banner_image_id, "../images", "banner" );
	}
	
	if( $remove_logo == "1" )
	{
		if( $logo_image_id != 0 )
		{
			real_delete_image( $db_conn, $pid, 0, $logo_image_id, "../images" );
			$logo_image_id = 0;
		}
	}
	else
	{
		if( $logo_image_id == 0 || $logo_image_id == "" )
		{
			$cur_image_id = real_insert_image_type( $db_conn, $pid, 0, "logofile", "../images", "logo" );
			if( $cur_image_id != 0 ) $logo_image_id = $cur_image_id;
		}
		else
			real_update_image_type( $db_conn, $pid, 0, "logofile", $logo_image_id, "../images", "logo" );
	}
*/	
	if( $name != "" )
	{
		$query = "UPDATE fac_info SET ".
					" name=" . real_mysql_specialchars( $name, false ) .
					", description=" . real_mysql_specialchars( $description, false ) .
					" WHERE pid=" . real_mysql_specialchars( $pid, true ) ;
		real_execute_query( $query, $db_conn );
	
	
		$query = "UPDATE gen_profile_info SET name = " . 
					real_mysql_specialchars( $name ) .
					" WHERE pid=" . real_mysql_specialchars( $pid, true ) ;
		real_execute_query( $query, $db_conn );

		$query = "DELETE FROM gen_association USING gen_association, fac_gen_info WHERE gen_association.assoc_login_id = fac_gen_info.contact_login_id AND gen_association.pid = ". real_mysql_specialchars( $pid, true );
		real_execute_query( $query, $db_conn );
		
		$query = "UPDATE fac_gen_info SET " .
					" contact_name=" . real_mysql_specialchars( $contact_name, false ) .
					", contact_rank=" . real_mysql_specialchars( $contact_rank, false ) .
					", contact_phone=" . real_mysql_specialchars( $contact_phone, false ) .
					", contact_email=" . real_mysql_specialchars( $contact_email, false ) .
					", contact_login_id=" . real_mysql_specialchars( $contact_id, false ) .
					", fac_image_id=" . real_mysql_specialchars( $fac_image_id, false ) .
					", hide_name=" . real_mysql_specialchars( $hide_name, true ) .
					", keywords=" . real_mysql_specialchars( $keywords, false ) .
					" WHERE pid=" . real_mysql_specialchars( $pid, true ) ;
		real_execute_query( $query, $db_conn );
		
		$query = "INSERT IGNORE INTO gen_association (	pid, assoc_login_id ) VALUES (  " . real_mysql_specialchars( $pid, true ) . ", " . real_mysql_specialchars( $contact_id, false ) . " )";
		real_execute_query( $query, $db_conn );
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view", $db_conn );
		
?>
