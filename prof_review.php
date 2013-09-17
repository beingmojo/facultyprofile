<?php
include 'utils.php';
include 'bluesheet/includes/bs_ldaputils.php';
session_start();
$_err_page = "../" . $_err_page;
/*
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
Header("Content-type: text/xml");
*/
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);

$emessage = "\n\nTo View/Sign the Blue-sheet, please login at http://{$_SERVER['HTTP_HOST']}{$_home}/loginscreen.php?view=2 using your Texas State NetID and password. After successful login, under the Blue-Sheets tab please find the Blue-Sheets you need to review in 'Bluesheets for Review' Section.";

$bs_id = $_GET["bs_id"];
$query = "SELECT distinct(loginid), status, bs_id, description FROM bs_routing WHERE bs_id = " . $bs_id;
$results_1 = real_execute_query($query, $db_conn);
if (mysql_num_rows($results_1) > 0)
{
	$approve_count = 0;
	$deny_count = 0;
	$pending_count = 0;
	while($rows_1 = mysql_fetch_array($results_1))
	{
 
		if ($rows_1["status"] == "Approved")
		{
			$approve_count++;
		 	$dataset = real_get_pplc('utaID', $rows_1["loginid"], $_ldap_search_dn_ppl);
			if ($approve_count == 1)
				$approve_name = "<a href=\"mailto:" . $dataset[0][30] ."?subject=Regarding bluesheet&body=$emessage\">" . $dataset[0][5] ." ".$dataset[0][6] ." ". $dataset[0][4] . "</a>";
			else
				$approve_name .= ", <a href=\"mailto:" . $dataset[0][30] . 														"?subject=Regarding bluesheet&body=$emessage\">" .$dataset[0][5] ." ".$dataset[0][6] ." ". $dataset[0][4] . "</a>";
		}
		else if ($rows_1["status"] == "Denied")
		{
			$deny_count++;
			$dataset = real_get_pplc('utaID', $rows_1["loginid"], $_ldap_search_dn_ppl);
			if ($deny_count == 1)
				$deny_name = "<a href=\"mailto:" . $dataset[0][30] . 														"?subject=Regarding bluesheet&body=$emessage\">" .$dataset[0][5] ." ".$dataset[0][6] ." ". $dataset[0][4] . "</a>: " . $rows_1["description"] . "<br>";
			else
				$deny_name .= ", " . "<a href=\"mailto:" . $dataset[0][30] . 													"?subject=Regarding bluesheet&body=$emessage\">" . $dataset[0][5]  ." ".$dataset[0][6] ." ". $dataset[0][4]. "</a>: " . $rows_1["description"] . "<br>";
		}
		else if ($rows_1["status"] == "Pending")
		{
			$pending_count++;
			$dataset = real_get_pplc('utaID', $rows_1["loginid"], $_ldap_search_dn_ppl);
			if ($pending_count == 1)
				$pending_name = "<a href=\"mailto:" . $dataset[0][30] . "?subject=Regarding bluesheet&body=$emessage\">" .$dataset[0][5] ." ".$dataset[0][6] ." ". $dataset[0][4] . "</a>";
			else
				$pending_name .= ", " . "<a href=\"mailto:" . $dataset[0][30] . 														"?subject=Regarding bluesheet&body=$emessage\">" . $dataset[0][5]  ." ".$dataset[0][6] ." ". $dataset[0][4]. "</a>";
		}
	}
}

if ($approve_count > 0)
{
	$approve_name =  "<u>Approved by</u>: " . $approve_name;
}
if ($deny_count > 0)	
{
	$deny_name = "<br><u>Returned by</u>: " . $deny_name;
}
if ($pending_count > 0)
{
	$pending_name = "<br><u>Pending On</u>: " . $pending_name;
}

//print "<approvename apprcount='" . $approve_count . "'>".$approve_count."</approvename>";

//print $approve_count;
//print $pending_count;
//print $deny_count;
$total_ppl = $approve_name . $deny_name . $pending_name;
//print $approve_count."#;#";
//print $pending_count."#;#";
//print $deny_count."#;#";
print $total_ppl;
//echo $total_ppl;

?>