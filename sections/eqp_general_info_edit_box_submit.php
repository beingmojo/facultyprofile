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
	$name = substr( real_unescape( $_POST["eqp_general_info_name"] ), 0, 255 );
	$contact_name = substr( real_unescape( $_POST["eqp_general_info_contact_name"] ), 0, 255 );
	$contact_login_id = substr( real_unescape( $_POST["eqp_general_info_contact_login_id"] ), 0, 255 );
	$address_1 = substr( real_unescape( $_POST["eqp_general_info_address_1"] ), 0, 255 );
	$address_2 = substr( real_unescape( $_POST["eqp_general_info_address_2"] ), 0, 255 );
	$mailbox = substr( real_unescape( $_POST["eqp_general_info_mailbox"] ), 0, 8 );
	$city = substr( real_unescape( $_POST["eqp_general_info_city"] ), 0, 32 );
	$state = substr( real_unescape( $_POST["eqp_general_info_state"] ), 0, 32 );
	$zipcode = substr( real_unescape( $_POST["eqp_general_info_zipcode"] ), 0, 16 );
	$location = substr( real_unescape( $_POST["eqp_general_info_location"] ), 0, 255 );
	$room_no = substr( real_unescape( $_POST["eqp_general_info_room_no"] ), 0, 16 );
	$contact_email = substr( real_unescape( $_POST["eqp_general_info_contact_email"] ), 0, 255 );
	$contact_phone = substr( real_unescape( $_POST["eqp_general_info_contact_phone"] ), 0, 32 );
	$contact_fax = substr( real_unescape( $_POST["eqp_general_info_contact_fax"] ), 0, 32 );
	$url_name = substr( real_unescape( $_POST["eqp_general_info_url_name"] ), 0, 255 );
	$url = substr( real_unescape( $_POST["eqp_general_info_url"] ), 0, 255 );
	$url = real_validate_url($url);
	$remove_image = ($_POST["eqp_general_info_remove_image"]=="on")?"1":"0";
	$image_id = real_unescape( $_POST["eqp_general_info_image_id"] );

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
	
	$pidquery  = "SELECT pid from ppl_general_info WHERE login_id = " . real_mysql_specialchars( $contact_login_id, false ) ;
	$pidresults = real_execute_query( $pidquery, $db_conn );
	while( $pidrows = mysql_fetch_array( $pidresults ) )
	{
		$contact_pid = $pidrows["pid"];
	}
	
	if( $name != "" )
	{
		$query = "UPDATE eqp_info SET ".
					" name=" . real_mysql_specialchars( $name, false ) .
					", contact_name=" . real_mysql_specialchars( $contact_name, false ) .
					", contact_login_id=" . real_mysql_specialchars( $contact_login_id, false ) .
					", contact_pid=" . real_mysql_specialchars( $contact_pid, true ) .
					", address_1=" . real_mysql_specialchars( $address_1, false ) .
					", address_2=" . real_mysql_specialchars( $address_2, false ) .
					", mailbox=" . real_mysql_specialchars( $mailbox, false ) .
					", city=" . real_mysql_specialchars( $city, false ) .
					", state=" . real_mysql_specialchars( $state, false ) .
					", zipcode=" . real_mysql_specialchars( $zipcode, false ) .
					", location=" . real_mysql_specialchars( $location, false ) .
					", room_no=" . real_mysql_specialchars( $room_no, false ) .
					", contact_email=" . real_mysql_specialchars( $contact_email, false ) .
					", contact_phone=" . real_mysql_specialchars( $contact_phone, false ) .
					", contact_fax=" . real_mysql_specialchars( $contact_fax, false ) .
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
