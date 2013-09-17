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
	$abstract = $ipFilter->process( $_POST["tech_status_abstract"] );
	$statustype = $_POST["tech_status_type"];
	$statusno = $_POST["tech_status_no"];
	
//	print $abstract." | ". $statustype ." | ". $statusno;
	$testquery="SELECT * FROM tech_status WHERE pid=".real_mysql_specialchars( $pid, true);
	$testresult=real_execute_query($testquery, $db_conn);
	$isthere=mysql_num_rows($testresult);
	if($isthere==1)
		$query = "UPDATE tech_status SET stage_status=" . real_mysql_specialchars( $abstract, false ) .
				 ", type=" . real_mysql_specialchars( $statustype, true) .
				 ", type_no=" .real_mysql_specialchars( $statusno, false) .
				 " WHERE pid=". real_mysql_specialchars( $pid, true );
	else
		$query = "INSERT INTO tech_status(stage_status, type, type_no, pid) VALUES ( ".
				 real_mysql_specialchars( $abstract, false) .
				 ", " . real_mysql_specialchars( $statustype, true) .
				 ", " . real_mysql_specialchars( $statusno, true) .
				 ", ".real_mysql_specialchars( $pid, true) .
				 ")";
	 
	real_execute_query( $query, $db_conn );
	real_update_last_modified_timestamp( $db_conn, $pid );
}
real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );
?>