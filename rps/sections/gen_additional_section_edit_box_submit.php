<?php
include '../utils.php';
include '../imageutils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );

if( real_can_user_edit( $db_conn, $pid ) == true )
{	
	$sectionidquery = "SELECT section_id FROM gen_profile_section_additional WHERE pid = " . real_mysql_specialchars( $pid, true );
	$sectionidresults = real_execute_query( $sectionidquery, $db_conn );
	while( $sectionidrows = mysql_fetch_array( $sectionidresults ) )
	{
		if( $_POST[ "remove_".$sectionidrows["section_id"] ] == 1 )
		{
			$deletequery = "DELETE FROM gen_profile_section_additional " .
							" WHERE pid = " . real_mysql_specialchars( $pid, true ) .
							" AND section_id = " . real_mysql_specialchars( $sectionidrows["section_id"], true );
			real_execute_query( $deletequery, $db_conn );
			// delete the data too...
			$deletedataquery = "DELETE FROM all_additional_section " .
								" WHERE pid = " . real_mysql_specialchars( $pid, true ) .
								" AND section_id = " . real_mysql_specialchars( $sectionidrows["section_id"], true );
			real_execute_query( $deletedataquery, $db_conn );

			real_delete_section_images( $db_conn, $pid, $sectionidrows["section_id"], "../images" );

		}
		else
		{
			$updatequery = "UPDATE gen_profile_section_additional " .
							" SET status = ". real_mysql_specialchars( $_POST[ "hide_".$sectionidrows["section_id"] ], true ) . 
							", name = ". real_mysql_specialchars( $_POST[ "rename_".$sectionidrows["section_id"] ], false ) . 
							" WHERE pid = " . real_mysql_specialchars( $pid, true ) .
							" AND section_id = " . real_mysql_specialchars( $sectionidrows["section_id"], true );
							
			real_execute_query( $updatequery, $db_conn );
		}
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}

real_redirect( "../customize_profile.php", "pid=$pid", $db_conn );

?>