<?php
include '../utils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$itr = 0;
	$boxname = $_POST["find_profile_boxname"];
	$rows = $_POST[ $boxname . "_rows" ];
	$type = $_POST[ $boxname . "_type" ];
	for( $itr = 0 ; $itr < $rows; $itr ++ )
	{
		$fac_pid = $_POST[ $boxname . "_" . $itr . "_2" ]; 
		if( real_check_user_groupid( $db_conn, "admin" ) )
		{
			$query = "INSERT INTO ctr_facility ( pid, fac_pid, add_req ) VALUES( " .
					real_mysql_specialchars($pid, true) .
					", " . real_mysql_specialchars( $fac_pid, true ) .
					",0  ) ON DUPLICATE KEY UPDATE add_req = 0";
	
			real_execute_query( $query, $db_conn );
			
			$query = "INSERT IGNORE INTO gen_association (pid, assoc_pid) VALUES ( " . real_mysql_specialchars( $fac_pid, true ) . ", " . real_mysql_specialchars( $pid, true ) . ") ";
			real_execute_query( $query, $db_conn );
		}
		else
		{
			$query = "INSERT IGNORE INTO ctr_facility ( pid, fac_pid ) VALUES( " .
					real_mysql_specialchars($pid, true) .
					", " . real_mysql_specialchars( $fac_pid, true ) .
					"  )";
	
			real_execute_query( $query, $db_conn );
		}
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}

real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );

?>