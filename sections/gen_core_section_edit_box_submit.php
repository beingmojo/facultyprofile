<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$view = real_unescape( $_POST["pid"] );

if( real_can_user_edit( $db_conn, $pid ) == true )
{	
	$sectionidquery = "SELECT section_id FROM gen_profile_section WHERE pid = " . real_mysql_specialchars( $pid, true );
	$sectionidresults = real_execute_query( $sectionidquery, $db_conn );
	while( $sectionidrows = mysql_fetch_array( $sectionidresults ) )
	{
		$updatequery = "UPDATE gen_profile_section SET status = ". real_mysql_specialchars( $_POST[ "hide_".$sectionidrows["section_id"] ], true ) . 
						" WHERE pid = " . real_mysql_specialchars( $pid, true ) .
						" AND section_id = " . real_mysql_specialchars( $sectionidrows["section_id"], true );
						
		real_execute_query( $updatequery, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}

real_redirect( "../customize_profile.php", "pid=$pid", $db_conn );

?>