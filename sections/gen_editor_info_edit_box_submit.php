<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$user1_name = $_POST["user1_name"];
	$user2_name = $_POST["user2_name"];
	$user1_login_id = $_POST["user1_login_id"];
	$user2_login_id = $_POST["user2_login_id"];
	
	$query = "UPDATE gen_profile_info SET " .
				"user1_login_id = " . real_mysql_specialchars( $user1_login_id, false ) .
				", user2_login_id = " . real_mysql_specialchars( $user2_login_id, false ) .
				", user1_name = " . real_mysql_specialchars( $user1_name, false ) .
				", user2_name = " . real_mysql_specialchars( $user2_name, false ) .
				" WHERE pid = ". real_mysql_specialchars( $pid, true ) ;
				
	real_execute_query( $query, $db_conn );	
	real_update_last_modified_timestamp( $db_conn, $pid );
}

real_redirect( "../customize_profile.php", "pid=$pid&view=1", $db_conn );