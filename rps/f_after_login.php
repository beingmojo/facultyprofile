<?php
include 'utils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);

$view = $_GET['view'];

$query = "SELECT login_id, fname, lname, email FROM gen_login_session WHERE session_id = '" . session_id() . "'";

$session_results = real_execute_query( $query, $db_conn );
if( mysql_num_rows( $session_results ) > 0 )
{
	$session_rows = mysql_fetch_array( $session_results );
	$_SESSION["UID"] = $session_rows[0];
	$_SESSION["UFNAME"] = $session_rows[1];
	$_SESSION["ULNAME"] = $session_rows[2];	
	$_SESSION["UEMAIL"] = $session_rows[3];	
	real_redirect("researchspace.php", "view=$view", $db_conn );
}
else
{
	real_set_error( $_err_login );
	real_redirect_onerror( $_err_page, "", $db_conn);
}
?>