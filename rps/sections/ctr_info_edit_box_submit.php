<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$view = real_unescape( $_POST["view"] );
$section_id = real_unescape( $_POST["section_id"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$ctr_info_address_1 = substr( real_unescape( $_POST["ctr_info_address_1"] ), 0, 255 );
	$ctr_info_address_2 = substr( real_unescape( $_POST["ctr_info_address_2"] ), 0, 255 );
	$ctr_info_mailbox = substr( real_unescape( $_POST["ctr_info_mailbox"] ), 0, 8 );
	$ctr_info_city = substr( real_unescape( $_POST["ctr_info_city"] ), 0, 32 );
	$ctr_info_state = substr( real_unescape( $_POST["ctr_info_state"] ), 0, 32 );
	$ctr_info_zipcode = substr( real_unescape( $_POST["ctr_info_zipcode"] ), 0, 16 );
	$ctr_info_office_location = substr( real_unescape( $_POST["ctr_info_office_location"] ), 0, 255 );
	$ctr_info_room_no = substr( real_unescape( $_POST["ctr_info_room_no"] ), 0, 16 );
	$ctr_info_url_name = substr( real_unescape( $_POST["ctr_info_url_name"] ), 0, 255 );
	$ctr_info_url = substr( real_unescape( $_POST["ctr_info_url"] ), 0, 255 );
	$ctr_info_url = real_validate_url($ctr_info_url);
	$ctr_info_email_id = substr( real_unescape( $_POST["ctr_info_email_id"] ), 0, 255 );
	$ctr_info_phone_no_1 = substr( real_unescape( $_POST["ctr_info_phone_no_1"] ), 0, 32 );
	$ctr_info_phone_no_2 = substr( real_unescape( $_POST["ctr_info_phone_no_2"] ), 0, 32 );
	$ctr_info_fax_no = substr( real_unescape( $_POST["ctr_info_fax_no"] ), 0, 32 );
	$query = "UPDATE ctr_gen_info SET ".
				" address_1=" . real_mysql_specialchars( $ctr_info_address_1, false ) .
				", address_2=" . real_mysql_specialchars( $ctr_info_address_2, false ) .
				", mailbox=" . real_mysql_specialchars( $ctr_info_mailbox, false ) .
				", city=" . real_mysql_specialchars( $ctr_info_city, false ) .
				", state=" . real_mysql_specialchars( $ctr_info_state, false ) .
				", zipcode=" . real_mysql_specialchars( $ctr_info_zipcode, false ) .
				", office_location=" . real_mysql_specialchars( $ctr_info_office_location, false ) .
				", room_no=" . real_mysql_specialchars( $ctr_info_room_no, false ) .
				", url_name=" . real_mysql_specialchars( $ctr_info_url_name, false ) .
				", url=" . real_mysql_specialchars( $ctr_info_url, false ) .
				", email_id=" . real_mysql_specialchars( $ctr_info_email_id, false ) .
				", phone_no_1=" . real_mysql_specialchars( $ctr_info_phone_no_1, false ) .
				", phone_no_2=" . real_mysql_specialchars( $ctr_info_phone_no_2, false ) .
				", fax_no=" . real_mysql_specialchars( $ctr_info_fax_no, false ) .				
				" WHERE pid=" . real_mysql_specialchars( $pid, true ) ;
	real_execute_query( $query, $db_conn );
	real_update_last_modified_timestamp( $db_conn, $pid );
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );
		
?>
