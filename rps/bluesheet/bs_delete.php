<?php  
include '../utils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$connect1 = $db_conn;

if (isset($_GET['bs_id']))
{
	$bs_id = $_GET['bs_id'];
	
	$query = "select bs_status from bs_info where bs_id = $bs_id";
	$result = mysql_query($query, $connect1);	
	if($row = mysql_fetch_array($result))
	{
		if ($row["bs_status"] == "Saved")
		{
			$query = "delete from bs_info where bs_id = $bs_id";
			$result = mysql_query($query, $connect1);
			
			$query = "delete from bs_i_info where bs_id = $bs_id";
			$result = mysql_query($query, $connect1);
			
			$query = "delete from bs_ei_info where bs_id = $bs_id";
			$result = mysql_query($query, $connect1);
			
			$query = "delete from bs_sponsor_info where bs_id = $bs_id";
			$result = mysql_query($query, $connect1);
			
			$query = "delete from bs_budget where bs_id = $bs_id";
			$result = mysql_query($query, $connect1);
			
			real_redirect("../researchspace.php", "view=2", $connect1);
		}
	}
	else
		real_redirect("../researchspace.php", "view=2", $connect1);
}