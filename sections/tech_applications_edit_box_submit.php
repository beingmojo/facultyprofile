<?php
include '../utils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$view = real_unescape( $_POST["view"] );
$section_id = real_unescape( $_POST["section_id"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$ipFilter = new InputFilter(array( "script" ),"",1,1,1);
	$abstract = $ipFilter->process( $_POST["tech_applications_abstract"] );
	$testquery="SELECT * FROM tech_applications WHERE pid=".real_mysql_specialchars( $pid, true);
	$testresult=real_execute_query($testquery, $db_conn);
	$isthere=mysql_num_rows($testresult);
	if($isthere==1)
		$query = "UPDATE tech_applications SET description=" . real_mysql_specialchars( $abstract, false ) .
				 " WHERE pid=". real_mysql_specialchars( $pid, true );
	else
		$query = "INSERT INTO tech_applications(description, pid) VALUES ( ".
				 real_mysql_specialchars( $abstract, false) .
				 ", ".real_mysql_specialchars( $pid, true) .
				 ")";
	 
	real_execute_query( $query, $db_conn );
	real_update_last_modified_timestamp( $db_conn, $pid );
}
real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );
?>