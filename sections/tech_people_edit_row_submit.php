<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$ppl_id = real_unescape( $_POST["ppl_id"] );
	$title = substr( real_unescape( $_POST["tech_people_title"] ), 0, 8 );
	$f_name = substr( real_unescape( $_POST["tech_people_f_name"] ), 0, 255 );
	$m_name = substr( real_unescape( $_POST["tech_people_m_name"] ), 0, 255 );
	$l_name = substr( real_unescape( $_POST["tech_people_l_name"] ), 0, 255 );
	$rank = substr( real_unescape( $_POST["tech_people_rank"] ), 0, 255 );
	$login_id = substr( real_unescape( $_POST["tech_people_login_id"] ), 0, 255 );
	
	if( $f_name != ""  &&  $l_name != "" )
	{
		$query = "UPDATE tech_people SET " .
					" title=". real_mysql_specialchars( $title, false ) .
					", f_name=" . real_mysql_specialchars( $f_name, false ) .
					", m_name=" . real_mysql_specialchars( $m_name, false ) .
					", l_name=" . real_mysql_specialchars( $l_name, false ) .
					", rank=" . real_mysql_specialchars( $rank, false ) .
					", ppl_login_id=" . real_mysql_specialchars( $login_id, false ) .																				
					" WHERE pid=". real_mysql_specialchars( $pid, true ) .
					" AND ppl_id=" . real_mysql_specialchars( $ppl_id, true );
		
		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
}

real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );

?>