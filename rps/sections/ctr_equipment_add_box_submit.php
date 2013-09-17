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
	$max_eqp_id = real_unescape( $_POST["max_eqp_id"] );
	$itr = 0;
	$boxname = $_POST["find_profile_boxname"];
	$rows = $_POST[ $boxname . "_rows" ];
	$type = $_POST[ $boxname . "_type" ];
	for( $itr = 0 ; $itr < $rows; $itr ++ )
	{
		$name = substr( real_unescape( $_POST[ $boxname . "_" . $itr . "_0" ] ), 0, 255 );
		$ipFilter = new InputFilter(array( "script" ),"",1,1,1);
		$description = $ipFilter->process( $_POST[ $boxname . "_" . $itr . "_1" ] );
		$eqp_pid = $_POST[ $boxname . "_" . $itr . "_2" ]; 
	
		if( $name != "" )
		{ 
			$query = "INSERT INTO ctr_equipment ( pid, eqp_id, eqp_pid, name, description ) VALUES( " .
					$pid .
					", " . ($max_eqp_id + $itr + 1) . 
					", " . real_mysql_specialchars( $eqp_pid, true ) .
					", " . real_mysql_specialchars( $name, false ) .
					", " . real_mysql_specialchars( $description, false ) .
					"  )";
	
			real_execute_query( $query, $db_conn );
			
			$query = "INSERT IGNORE INTO gen_association (pid, assoc_pid) VALUES ( " . real_mysql_specialchars( $pid, true ) . ", " . real_mysql_specialchars( $eqp_pid, true ) . ") ";
			real_execute_query( $query, $db_conn );
			real_update_last_modified_timestamp( $db_conn, $pid );			
		}
	}
}

real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );

?>