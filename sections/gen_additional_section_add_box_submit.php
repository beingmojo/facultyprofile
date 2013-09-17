<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$max_id = real_unescape( $_POST["gen_additional_section_maxid"] );
$name = real_unescape( $_POST["new_section_name"] );
if( real_can_user_edit( $db_conn, $pid ) == true  && $name != "" )
{	
	$max_id = $max_id == 0 ? 100 : ($max_id + 1);
	$addquery = "INSERT INTO gen_profile_section_additional ( pid, section_id, name ) VALUES " .
					"( " . real_mysql_specialchars( $pid, true ) .
					", " . real_mysql_specialchars( $max_id, true ) .
					", " . real_mysql_specialchars( $name, false ) .
					" ) ";
	real_execute_query( $addquery, $db_conn );
	real_update_last_modified_timestamp( $db_conn, $pid );
}

real_redirect( "../customize_profile.php", "pid=$pid", $db_conn );

?>