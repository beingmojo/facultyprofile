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
	$max_ppl_id = real_unescape( $_POST["max_ppl_id"] );
	$itr = 0;
	$boxname = $_POST["find_profile_boxname"];
	$rows = $_POST[ $boxname . "_rows" ];
	$type = $_POST[ $boxname . "_type" ];
	for( $itr = 0 ; $itr < $rows; $itr ++ )
	{
		$name = substr( real_unescape( $_POST[ $boxname . "_" . $itr . "_0" ] ), 0, 255 );
		$rank = substr( real_unescape( $_POST[ $boxname . "_" . $itr . "_1" ] ), 0, 255 );
		$ppl_pid = $_POST[ $boxname . "_" . $itr . "_2" ]; 
		$login_id = substr( real_unescape( $_POST[ $boxname . "_" . $itr . "_3" ] ), 0, 255 );
		$title = substr( real_unescape( $_POST[ $boxname . "_" . $itr . "_4" ] ), 0, 8 );
		$l_name = substr( real_unescape( $_POST[ $boxname . "_" . $itr . "_5" ] ), 0, 255 );
		$f_name = substr( real_unescape( $_POST[ $boxname . "_" . $itr . "_6" ] ), 0, 255 );
		$m_name = substr( real_unescape( $_POST[ $boxname . "_" . $itr . "_7" ] ), 0, 255 );
		

		if( $name != "" )
		{ 
			$query = "INSERT INTO ctr_people ( pid, ppl_id, full_name, title, f_name, m_name, l_name, ppl_login_id, rank ) VALUES( " .
					$pid .
					", " . ($max_ppl_id + $itr + 1) . 
					", " . real_mysql_specialchars( $name, false ) .
					", " . real_mysql_specialchars( $title, false ) .
					", " . real_mysql_specialchars( $f_name, false ) .
					", " . real_mysql_specialchars( $m_name, false ) .
					", " . real_mysql_specialchars( $l_name, false ) .
					", " . real_mysql_specialchars( $login_id, false ) .
					", " . real_mysql_specialchars( $rank, false ) .
					"  )";
	
			real_execute_query( $query, $db_conn );
			$query = "INSERT IGNORE INTO gen_association (	pid, assoc_login_id ) VALUES (  " . real_mysql_specialchars( $pid, true ) . ", " . real_mysql_specialchars( $login_id, false ) . " )";
			real_execute_query( $query, $db_conn );
			real_update_last_modified_timestamp( $db_conn, $pid );
		}
	}
}

real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );

?>