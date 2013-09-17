<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );

if( real_can_user_edit( $db_conn, $pid ) == true )
{	
	$deletequery = "DELETE FROM gen_profile_cluster WHERE type=2 AND pid = " . real_mysql_specialchars( $pid, true );
	$deleteresult = real_execute_query( $deletequery, $db_conn);
	
	$clusterquery = "SELECT cluster_id FROM gen_tech_cluster_types";
	$clusterresult = real_execute_query( $clusterquery, $db_conn );
	$noofclusters = mysql_num_rows($clusterresult);
	
	for($n=1;$n<=$noofclusters;$n++)
	{
	 $fieldname='t'.$n;
	 if($_POST[$fieldname]=='1')
	 {
		print $n."-->";
		$insertquery = "INSERT INTO gen_profile_cluster (pid,cluster_id,type) VALUES ".
					"( " . real_mysql_specialchars( $pid, true ) .
					", " . real_mysql_specialchars( $n, true ) .
					", " . real_mysql_specialchars( 2, true) .
					" ) ";		
 	    $resultinsert = real_execute_query($insertquery,$db_conn);
		real_update_last_modified_timestamp( $db_conn, $pid );
	 }
	}
}
real_redirect( "../customize_profile.php", "pid=$pid&view=2", $db_conn );
?>