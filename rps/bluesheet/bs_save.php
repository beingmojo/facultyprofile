<?php
include '../utils.php';
include 'includes/bs_ldaputils.php';

session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$connect = @mysql_connect($_db_server,$_db_username,$_db_password);
@mysql_select_db($_db_name,$connect);
/*
foreach ($_POST as $var => $value) 
{ 
	echo "$var = $value<br>\n";
} 
exit;
echo "<br><br><br>";
*/

if ( isset($_GET['route']) )
{
	$bs_id = $_GET['bs_id'];
	$routed_by = $_SESSION['UID'];
	$dataset = real_get_pplc('utaID', $routed_by, $_ldap_search_dn_ppl);
	$routed_by = $dataset[0][22];
	
	$query = "SELECT * FROM bs_info where bs_id='$bs_id'";
	$result_i = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
	if ($row = mysql_fetch_array($result_i))
	{
		$proposal_title = $row["proposal_title"];
		$query = "SELECT * FROM bs_sponsor_info where bs_id='$bs_id' and sp_id=" . $row["sp_id"];
		$result_i1 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
		if ($row1 = mysql_fetch_array($result_i1))
		{
			$sponsor = $row1["sponsor"];
		}
	}

	$query = "UPDATE bs_info set routed_by='$routed_by', routed_time=NOW() where bs_id='$bs_id'";
	$result_i = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
	
	$copis = "";
	
	$query = "SELECT * FROM bs_i_info WHERE bs_id = $bs_id";
	$result_i = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
	while($row = mysql_fetch_array($result_i))
	{
		if ($row["i_id"] == "1")
			$pi = $row["name"];
		else
		{
			if ($copis == "")
				$copis = $row["name"];
			else
				$copis .=  ", " . $row["name"];
		}
	}

	$email_text = "A bluesheet has been submitted and needs your approval. \n";
	if ($proposal_title != "")
		$email_text .= "Title: $proposal_title \n";
	$email_text .= 	"PI: $pi \n";
	if ($sponsor != "")
		$email_text .= 	"Sponsor: $sponsor \n";
	if($copis != "")
		$email_text .= 	"CoPIs: $copis \n";
	$email_text .= 	"Please login at http://{$_SERVER['HTTP_HOST']}{$_home}/loginscreen.php?view=2 to review this bluesheet. \n " . 
	"\n ------------------------------------------------------------------------------- \n" .
	"Technical Questions/Difficulties call 2-1060 or email erahelpdesk@uta.edu . \n" . 
	"Looking for help? Check out blue sheet quick start guide: \n" . 
	"Word Document: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.doc \n" .
	"PDF: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.pdf \n" .
	"Other Blue-sheet related questions email office@institution.edu or contact your specialist (http://www.uta.edu/ra/GCS/specialists.htm). \n\n" . 
	"If you are receiving multiple emails for the same bluesheet, please submit a preferred email address to erahelpdesk@uta.edu & we will add it for future routing.";
	$email_subject = "New bluesheet submitted";
	
	$query = "select A.login_id from ppl_general_info A, bs_info B where A.pid=B.pid and B.bs_id=$bs_id and B.started_by!=A.login_id";
	$result_i = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
	if($row = mysql_fetch_array($result_i))
	{
		$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id) VALUES($bs_id, '" . $row["login_id"] . "', 'Pending', 1)";
		$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
		// get the email addresses of pi from ldap based on their login id.
		$dataset = real_get_pplc('utaID', $row["loginid"], $_ldap_search_dn_ppl);
		$copi_name = $dataset[0][22];
		$copi_email = $dataset[0][30];
		$message = "Dear " . $copi_name . ": \n\n" . $email_text;
		mail( $copi_email, $email_subject, $message, "From: GCS<office@institution.edu>" );
	}
	
	$query = "select A.login_id from ppl_general_info A, bs_info B where A.pid=B.pid and B.bs_id=$bs_id and B.started_by=A.login_id";
	$result_i = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
	if($row = mysql_fetch_array($result_i))
	{
		$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id, timestamp) VALUES($bs_id, '" . $row["login_id"] . "', 'Approved', 1, NOW())";
		$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
	}

	$query = "SELECT * FROM bs_i_info WHERE bs_id = $bs_id";
	$result_i = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
	while($row = mysql_fetch_array($result_i))
	{
		$dean_login_id = "";
		$chair_login_id = "";
		$dept = $row["dept"];
		$i_id = $row["i_id"];
		
		if (trim($row["loginid"]) != "")
		{
			$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id, i_loginid) VALUES($bs_id, '" . $row["loginid"] . "', 'Pending', $i_id, '" . $row["loginid"] . "')";
			$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
			// get the email addresses of copi from ldap based on their login id.
			$dataset = real_get_pplc('utaID', $row["loginid"], $_ldap_search_dn_ppl);
			$copi_name = $dataset[0][22];
			$copi_email = $dataset[0][30];
			$message = "Dear " . $copi_name . ": \n\n" . $email_text;
			mail( $copi_email, $email_subject, $message, "From: GCS<office@institution.edu>" );
		}
		
		$query = "SELECT hid FROM gen_hierarchy_types WHERE name='$dept'";
		$result_i1 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
		if ($row1 = mysql_fetch_array($result_i1))
		{
			$hid = $row1["hid"];
			// get the dean
			$query = "SELECT * FROM gen_dept_hierarchy WHERE hid=$hid AND authority_type=1";
			$result_i2 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
			if ($row2 = mysql_fetch_array($result_i2))
			{
				$dean_login_id = $row2["login_id"];
				
				$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id, i_loginid) VALUES($bs_id, '$dean_login_id', 'Pending', $i_id, '" . $row["loginid"] . "')";
				$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
				
				// get the email addresses of dean from ldap based on their login id.
				$dataset = real_get_pplc('utaID', $dean_login_id, $_ldap_search_dn_ppl);
				$dean_name = $dataset[0][22];
				$dean_email = $dataset[0][30];
				// send email to dean
				$message = "Dear " . $dean_name . ": \n\n" . $email_text;
				mail( $dean_email, $email_subject, $message, "From: GCS<office@institution.edu>" );				
			}
			// get the chair
			$query = "SELECT * FROM gen_dept_hierarchy WHERE hid=$hid AND authority_type=2";
			$result_i2 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
			if ($row2 = mysql_fetch_array($result_i2))
			{
				$chair_login_id = $row2["login_id"];
				
				$query ="INSERT INTO bs_routing (bs_id, loginid, status, i_id, i_loginid) VALUES($bs_id, '$chair_login_id', 'Pending', $i_id, '" . $row["loginid"] . "')";
				$result_i2 = real_execute_bs_query($query, $connect) or die("04 - " . mysql_error() . "==" . $query);

				// get the email addresses of chairperson from ldap based on their login id.
				$dataset = real_get_pplc('utaID', $chair_login_id, $_ldap_search_dn_ppl);
				$chairperson_name = $dataset[0][22];
				$chairperson_email = $dataset[0][30];
				// send email to chairperson
				$message = "Dear " . $chairperson_name . ": \n\n" . $email_text;
				mail( $chairperson_email, $email_subject, $message, "From: GCS<office@institution.edu>" );				
			}
		}
	}
	
	// EH&S
	$query123 = "SELECT * FROM bs_info WHERE bs_id = $bs_id";
	$result_i123 = real_execute_bs_query($query123, $connect) or die("01 - " . mysql_error() . "==" . $query123);
	while($row123 = mysql_fetch_array($result_i123))
	{
		if (($row123['radioactive_materials']=='No') && ($row123['controlled_substances']=='No') && 
			($row123['laser_devices']=='No') && ($row123['radiation_producing_machines']=='No'))
		{
		}
		else
		{
			$query ="INSERT INTO bs_routing (bs_id, loginid, status, i_id) VALUES($bs_id, '000000000', 'Pending', 1)";
			$result_i2 = real_execute_bs_query($query, $connect) or die("05 - " . mysql_error());
			$message = "Dear Sir/Madam: \n\n" . $email_text;
			mail( "EHandS@institution.edu", $email_subject, $message, "From: GCS<office@institution.edu>" );
		}
	}

	// Add the last signatory
	$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id) VALUES($bs_id, '9999999999', 'Pending', 1)";
	$result_i2 = real_execute_bs_query($query, $connect) or die("05 - " . mysql_error());
	
	$query = "UPDATE bs_info set bs_status='Routed' WHERE bs_id = $bs_id";
	$result_i = real_execute_bs_query($query, $connect) or die("06 - " . mysql_error() . "==" . $query);
	real_redirect("../researchspace.php", "view=2", $connect);
}

$pid = $_POST['pid'];
$sstatus = $_POST['sstatus'];
if ($sstatus == "1") // Save only
	$sstatus = "Saved";
else if ($sstatus == "2") // Submit , not further editable
	$sstatus = "Submitted";
else if ($sstatus == "3") // ogcs transparent edit, retain status
	$sstatus = "";
else if ($sstatus == "4") // ogcs edit + route
{
	$route = 1;
	$sstatus = "Routed";
}
else if ($sstatus == "5") //ogcs says return to pi
{
	$sstatus = "Saved";
	$rtpc = $_POST['rtpc'];
	$ret_by = "OGCS";
}

if (($_POST['bs_id'] == 0) || ($_POST['bs_id'] == ""))
{
	// Get the main bluesheet id first before doing anything else
	// by adding a dummy record of this form into the bluesheet form
	//$query = "INSERT INTO bs_info (bs_timestamp, pid, bs_status) VALUES(NOW()," . $_POST['pid'] . ",'".$sstatus."')";
	$query = "INSERT INTO bs_info (bs_timestamp, pid, bs_status, started_by) VALUES(NOW()," . $_POST['pid'] . ",'Saved','".$_SESSION['UID']."')";
	$result_i = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
	$bs_id = mysql_insert_id();
	//echo "Query: $query<br>\nResult: bs_id=$bs_id<br>\n";
}
else
	$bs_id = $_POST['bs_id'];
	
if (isset($_POST['bs_name']))	
	$bs_name = $_POST['bs_name'];
else
	$bs_name = "";

if (isset($_POST['bs_comments']))
	$bs_comments = $_POST['bs_comments'];
else
	$bs_comments = "";

// PI Saving Part
$name = $_POST['piFullName'];
$pi = $name;
$dept = html_entity_decode(urldecode($_POST['piDept']));
$pi_dept = $dept;
$box = $_POST['piBox#'];
$phone = $_POST['piPhoneNumber'];
$email = $_POST['piEmail'];
$rank = $_POST['piRank'];
if ($rank == "Other")
	$rank = $_POST['piRankopt'];
$citizenship = $_POST['piCitizenship'];

$query = "DELETE FROM bs_i_info WHERE bs_id=$bs_id";
$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
$query = "INSERT INTO bs_i_info (bs_id, name, dept, box_number, phone, email, rank, citizenship) " .
 "VALUES ($bs_id, '$name', '$dept', '$box', '$phone', '$email', '$rank', '$citizenship')";
$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
$pi_id = mysql_insert_id();
//echo "Query: $query<br>\nResult: pi_id=$pi_id<br>\n";
 
// Sponsor Saving Part
$deadline = $_POST['siDeadline'];
$submission_method = $_POST['siSubMethod'];
$sponsor = $_POST['siSponsor'];
$prime_sponsor = $_POST['siPrimeSponsor'];
$contact_name = $_POST['siSponsorContactName'];
$phone = $_POST['siPhoneNumber'];
$email = $_POST['siEmail'];
$address = $_POST['siAddress'];
$number_of_copies = $_POST['siNoOfCopies'];
$shipment_method = $_POST['siShipMethod'];
$sponsor_link = $_POST['siSponsorLink'];
if ($number_of_copies == '')
	$number_of_copies = 0;
$query = "DELETE FROM bs_sponsor_info WHERE bs_id=$bs_id";
$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
$query = "INSERT INTO bs_sponsor_info (bs_id, deadline, submission_method, sponsor, prime_sponsor, contact_name, " . 
  "phone, email, address, number_of_copies, shipment_method, sponsor_link) VALUES ($bs_id, STR_TO_DATE('$deadline', '%m/%d/%Y'), " . 
  "'$submission_method', '$sponsor', '$prime_sponsor', '$contact_name', '$phone', '$email', '$address', " . 
  "$number_of_copies, '$shipment_method', '$sponsor_link')";
//echo "Query: $query<br>\nResult: sp_id=$sp_id<br>\n";  
$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
$sp_id = mysql_insert_id();
//echo "Query: $query<br>\nResult: sp_id=$sp_id<br>\n";

// Co-Investigators Saving Part
$copiCount = $_POST['CoPiCount'];
$copis = "";
$copi_flag = 1;
for($i=1; $i<=$copiCount; $i++)
{
	$name = $_POST['ci' . $i . 'Name'];
	if ($copis == "")
		$copis = $name;
	else
		$copis .=  "; $name";
	$dept = html_entity_decode(urldecode($_POST['ci' . $i . 'Dept']));
	$box_number = $_POST['ci' . $i . 'Box#'];
	$phone = $_POST['ci' . $i . 'Phone'];
	$email = $_POST['ci' . $i . 'Email'];
	$rank = $_POST['ci' . $i . 'Rank'];
	$citizenship = $_POST['ci' . $i . 'Citizenship'];
	$loginid = $_POST['ci' . $i . 'LoginID'];
	if (trim($loginid) == "")
		$copi_flag = 0;
	$query = "INSERT INTO bs_i_info (bs_id, name, dept, box_number, phone, email, rank, citizenship, loginid) " . 
		"VALUES ($bs_id, '$name', '$dept', '$box_number', '$phone', '$email', '$rank', '$citizenship','$loginid')";
	$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
	//echo "Query: $query<br>\n";
}

$query = "UPDATE bs_info set copi_flag=$copi_flag where bs_id=$bs_id";
$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);

$handle_copi_routing = false;

$query = "SELECT bs_status FROM bs_info where bs_id=$bs_id";
$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
if ($row = mysql_fetch_array($result_i))
{
	if ($row["bs_status"]=="Routed")
		$handle_copi_routing = true;
}

if ($handle_copi_routing)
{
	$email_text = "A bluesheet has been submitted and needs your approval. \n";
	if ($proposal_title != "")
		$email_text .= "Title: $proposal_title \n";
	$email_text .= 	"PI: $pi \n";
	if ($sponsor != "")
		$email_text .= 	"Sponsor: $sponsor \n";
	if($copis != "")
		$email_text .= 	"CoPIs: $copis \n";
	$email_text .= 	"Please login at http://{$_SERVER['HTTP_HOST']}{$_home}/loginscreen.php?view=2 to review this bluesheet. \n " . 
	"\n ------------------------------------------------------------------------------- \n" .
	"Technical Questions/Difficulties call 2-1060 or email erahelpdesk@uta.edu . \n" . 
	"Looking for help? Check out blue sheet quick start guide: \n" . 
	"Word Document: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.doc \n" .
	"PDF: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.pdf \n" .
	"Other Blue-sheet related questions email office@institution.edu or contact your specialist (http://www.uta.edu/ra/GCS/specialists.htm). \n\n" . 
	"If you are receiving multiple emails for the same bluesheet, please submit a preferred email address to erahelpdesk@uta.edu & we will add it for future routing.";
	$email_subject = "New bluesheet submitted";

	$query = 'update bs_routing A, bs_i_info B set A.status="Pending", A.i_id=B.i_id where A.status="Not Required" and A.bs_id=B.bs_id and A.i_id!=1 and A.i_loginid=B.loginid';
	$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);

	$query = "select * from bs_i_info where bs_id=$bs_id and i_id!=1 and loginid not in (select i_loginid from bs_routing where bs_id=$bs_id and i_id!=1)";
	$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
	while ($row = mysql_fetch_array($result_i))
	{
		//insert into routing table, this CoPI, his chair and dean, and send informative email to all of them !!!
		$dean_login_id = "";
		$chair_login_id = "";
		$dept = $row["dept"];
		$i_id = $row["i_id"];
		
		if (trim($row["loginid"]) != "")
		{
			$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id, i_loginid) VALUES($bs_id, '" . $row["loginid"] . "', 'Pending', $i_id, '" . $row["loginid"] . "')";
			$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
			// get the email addresses of copi from ldap based on their login id.
			$dataset = real_get_pplc('utaID', $row["loginid"], $_ldap_search_dn_ppl);
			$copi_name = $dataset[0][22];
			$copi_email = $dataset[0][30];
			// send email to dean
			$message = "Dear " . $copi_name . ": \n\n" . $email_text;
			mail( $copi_email, $email_subject, $message, "From: GCS<office@institution.edu>" );			
		}
		
		$query = "SELECT hid FROM gen_hierarchy_types WHERE name='$dept'";
		$result_i1 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
		if ($row1 = mysql_fetch_array($result_i1))
		{
			$hid = $row1["hid"];
			// get the dean
			$query = "SELECT * FROM gen_dept_hierarchy WHERE hid=$hid AND authority_type=1";
			$result_i2 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
			if ($row2 = mysql_fetch_array($result_i2))
			{
				$dean_login_id = $row2["login_id"];
				
				$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id, i_loginid) VALUES($bs_id, '$dean_login_id', 'Pending', $i_id, '" . $row["loginid"] . "')";
				$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
				
				// get the email addresses of dean from ldap based on their login id.
				$dataset = real_get_pplc('utaID', $dean_login_id, $_ldap_search_dn_ppl);
				$dean_name = $dataset[0][22];
				$dean_email = $dataset[0][30];
				// send email to dean
				$message = "Dear " . $dean_name . ": \n\n" . $email_text;
				mail( $dean_email, $email_subject, $message, "From: GCS<office@institution.edu>" );				
			}
			// get the chair
			$query = "SELECT * FROM gen_dept_hierarchy WHERE hid=$hid AND authority_type=2";
			$result_i2 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
			if ($row2 = mysql_fetch_array($result_i2))
			{
				$chair_login_id = $row2["login_id"];
				
				$query ="INSERT INTO bs_routing (bs_id, loginid, status, i_id, i_loginid) VALUES($bs_id, '$chair_login_id', 'Pending', $i_id, '" . $row["loginid"] . "')";
				$result_i2 = real_execute_bs_query($query, $connect) or die("04 - " . mysql_error() . "==" . $query);

				// get the email addresses of chairperson from ldap based on their login id.
				$dataset = real_get_pplc('utaID', $chair_login_id, $_ldap_search_dn_ppl);
				$chairperson_name = $dataset[0][22];
				$chairperson_email = $dataset[0][30];
				// send email to chairperson
				$message = "Dear " . $chairperson_name . ": \n\n" . $email_text;
				mail( $chairperson_email, $email_subject, $message, "From: GCS<office@institution.edu>" );
			}
		}
	}
	$query = "update bs_routing set status='Not Required' where bs_id=$bs_id and i_id!=1 and i_loginid not in (select loginid from bs_i_info where bs_id=$bs_id and i_id!=1)";
	$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
}

// External-Investigators Saving part
$query = "DELETE FROM bs_ei_info WHERE bs_id=$bs_id";
$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
$extiCount = $_POST['ExtICount'];
for($i=1; $i<=$extiCount; $i++)
{
	$name = $_POST['exti' . $i . 'Name'];
	$iname = $_POST['exti' . $i . 'IName'];
	$dept = $_POST['exti' . $i . 'Dept'];
	$box_number = $_POST['exti' . $i . 'Box#'];
	$phone = $_POST['exti' . $i . 'Phone'];
	$email = $_POST['exti' . $i . 'Email'];
	$rank = $_POST['exti' . $i . 'Rank'];
	$citizenship = $_POST['exti' . $i . 'Citizenship'];
	$funding = $_POST['exti' . $i . 'Funding'];	
	$query = "INSERT INTO bs_ei_info (bs_id, name, dept, box_number, phone, email, rank, citizenship, funding, inst_name) " . 
		"VALUES ($bs_id, '$name', '$dept', '$box_number', '$phone', '$email', '$rank', '$citizenship', '$funding', '$iname')";
	$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
	//echo "Query: $query<br>\n";
}

// The main form saving/updating back to the bs_info main table
$proposal_title = $_POST['propinfoTitle'];
$proposal_type = $_POST['propinfoType'];
$prev_acct_number = $_POST['propinfoPrevAcctNo'];
$abstract = $_POST['prjAbstractText'];
$prj_period_from  = $_POST['bu_prjYr1'];
$prj_period_to = $_POST['bu_prjYr2'];
//---------------------------------------
if ($_POST['vAnimals'] == "Yes")
{
	if ($_POST['pvAnimals'] == "Approved")
		$vertebrate_animals = $_POST['pvAnimalsNo'];
	else
		$vertebrate_animals = "Pending";
}
else if ($_POST['vAnimals'] == "No")
	$vertebrate_animals = "No";
else
	$vertebrate_animals = "";
//---------------------------------------
if ($_POST['humanSubjects'] == "Yes")
{
	if ($_POST['ccphumanSubjects'] == "Approved")
		$human_subjects = $_POST['phumanSubjectsNo'];
	else
		$human_subjects = "Pending";
}
else if ($_POST['humanSubjects'] == "No")
	$human_subjects = "No";
else
	$human_subjects = "";
//---------------------------------------
if ($_POST['rDNA'] == "Yes")
{
	if ($_POST['prDNA'] == "Approved")
		$recombinant_dna = $_POST['prDNANo'];
	else
		$recombinant_dna = "Pending";
}
else if ($_POST['rDNA'] == "No")
	$recombinant_dna = "No";
else
	$recombinant_dna = "";
//---------------------------------------
if ($_POST['bAgents'] == "Yes")
{
	if ($_POST['pbAgents'] == "Approved")
		$biological_agents = $_POST['pbAgentsNo'];
	else
		$biological_agents = "Pending";
}
else if ($_POST['bAgents'] == "No")
	$biological_agents = "No";
else
	$biological_agents = "";
//---------------------------------------
//-- EH&S
if ($_POST['ccradioMaterials'] == "Yes")
{
	if ($_POST['pradioMaterials'] == "Approved")
		$radioactive_materials = $_POST['pradioMaterialsNo'];
	else
		$radioactive_materials = "Pending";
}
else if ($_POST['ccradioMaterials'] == "No")
	$radioactive_materials = "No";
else
	$radioactive_materials = "";
//---------------------------------------
//-- EH&S
if ($_POST['cSubstances'] == "Yes")
{
	if ($_POST['pcSubstances'] == "Approved")
		$controlled_substances = $_POST['pcSubstancesNo'];
	else
		$controlled_substances = "Pending";
}
else if ($_POST['cSubstances'] == "No")
	$controlled_substances = "No";
else
	$controlled_substances = "";
//---------------------------------------
$select_agents = $_POST['selectAgents'];
$radiation_producing_machines = $_POST['rpMachines'];  //-- EH&S
$laser_devices = $_POST['lDevices'];   //-- EH&S
$fna_percent = $_POST['fAPercentage'];
$special_considerations_1 = $_POST['scmgmtPlan'];
$special_considerations_2  = $_POST['sccostShare'];
$special_considerations_3 = $_POST['scIPCmaterials'];
$special_considerations_4 = $_POST['sccoopAgreements'];
$special_considerations_5  = $_POST['sccollabf'];
$special_considerations_6 = $_POST['scshipf'];

$bu_reqMTDC = $_POST['bu_reqMTDC'];
$bu_lIDC = $_POST['bu_lIDC'];

if ($sstatus != "")
{
  $query = "UPDATE bs_info set pi_id=$pi_id, sp_id=$sp_id, proposal_title='$proposal_title', proposal_type='$proposal_type', " . 
  "prev_acct_number='$prev_acct_number', abstract='$abstract', prj_period_from=STR_TO_DATE('$prj_period_from', '%m/%d/%Y'), " . 
  "prj_period_to=STR_TO_DATE('$prj_period_to', '%m/%d/%Y'), human_subjects='$human_subjects', vertebrate_animals='$vertebrate_animals', " . 
  "recombinant_dna='$recombinant_dna', biological_agents='$biological_agents', select_agents='$select_agents', " . 
  "radioactive_materials='$radioactive_materials', controlled_substances='$controlled_substances', " . 
  "radiation_producing_machines='$radiation_producing_machines', laser_devices='$laser_devices'," . 
  "fna_percent='$fna_percent', special_considerations_1='$special_considerations_1', " . 
  "special_considerations_2='$special_considerations_2', special_considerations_3='$special_considerations_3', " . 
  "special_considerations_4='$special_considerations_4', special_considerations_5='$special_considerations_5', " . 
  "special_considerations_6='$special_considerations_6', bs_name='$bs_name', bs_comments='$bs_comments', " . 
  "bs_timestamp=NOW(), pid=$pid, bs_status='$sstatus', ret_comments='$rtpc', ret_by='$ret_by', bu_reqMTDC='$bu_reqMTDC', bu_lIDC='$bu_lIDC' WHERE bs_id=$bs_id";
  if ($sstatus == "Submitted")
  {
	  $message = "Dear Specialists: \n\n" . 
		"A Internal Routing Form (bluesheet) is pending routing from you.\n" .
		"Title: $proposal_title \n" . 
		"PI: $pi \n" .
		"Sponsor: $sponsor \n" .
		"CoPIs: $copis \n " . 
		"Please login at http://{$_SERVER['HTTP_HOST']}{$_home}/loginscreen.php?view=2 to review this bluesheet.\n" . 
		"\nThank you.\n-----------------------------------------------\n".
		"Technical Questions/Difficulties call 2-1060 or email erahelpdesk@uta.edu \n" . 
		"Looking for help? Check out blue sheet quick start guide: \n" . 
		"Word Document: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.doc \n" .
		"PDF: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.pdf \n" .
		"\n\nElectronic Research Administration";
		mail( "office@instituiton.edu", "Pending Bluesheet [$pi_dept]", $message, "From: GCS<raweb@uta.edu>" );
  }
}
else
{
  $query = "UPDATE bs_info set pi_id=$pi_id, sp_id=$sp_id, proposal_title='$proposal_title', proposal_type='$proposal_type', " . 
  "prev_acct_number='$prev_acct_number', abstract='$abstract', prj_period_from=STR_TO_DATE('$prj_period_from', '%m/%d/%Y'), " . 
  "prj_period_to=STR_TO_DATE('$prj_period_to', '%m/%d/%Y'), human_subjects='$human_subjects', vertebrate_animals='$vertebrate_animals', " . 
  "recombinant_dna='$recombinant_dna', biological_agents='$biological_agents', select_agents='$select_agents', " . 
  "radioactive_materials='$radioactive_materials', controlled_substances='$controlled_substances', " . 
  "radiation_producing_machines='$radiation_producing_machines', laser_devices='$laser_devices'," . 
  "fna_percent='$fna_percent', special_considerations_1='$special_considerations_1', " . 
  "special_considerations_2='$special_considerations_2', special_considerations_3='$special_considerations_3', " . 
  "special_considerations_4='$special_considerations_4', special_considerations_5='$special_considerations_5', " . 
  "special_considerations_6='$special_considerations_6', bs_name='$bs_name', bs_comments='$bs_comments', " . 
  "bs_timestamp=NOW(), pid=$pid, bu_reqMTDC='$bu_reqMTDC', bu_lIDC='$bu_lIDC' WHERE bs_id=$bs_id";
}
$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
//echo "Query: $query<br>\n";

// Saving the budget table
// Get the budget values from the posted data
$query = "DELETE FROM bs_budget WHERE bs_id=$bs_id";
$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);

$fields = array('sal', 'fb', 'mo', 'conServ', 'ss', 'tuition', 'ps', 'tDom', 'tFor', 'pTrav', 'stem', 
	'equip', 'tdc', 'mtdc', 'idc', 'tc'); 
$fieldnames = array('Salary', 'Fringe Benefits', 'M&O - Materials', 'Consulting Services (non-UTA)', 
	'Scholarships/Stipend', 'Tuition', 'Participant Support', 'Travel (Domestic)', 'Travel (Foreign)', 
	'Participant Travel', 'STEM Tuition', 'Equipment', 'tdc', 'mtdc', 'idc', 'tc'); 
for( $ii = 0; $ii<count($fields); $ii++)
{
	$query = "SELECT f_id FROM bs_budget_field WHERE field_name='$fieldnames[$ii]'";
	$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
	$row_i = mysql_fetch_array($result_i);
	$f_id = $row_i['f_id'];
	$name = $fieldnames[$ii];
	//echo "Query: $query<br>\nResult: f_id=$f_id<br>\n";
	$e_id = 0;
	$Yr1 = $_POST['bu_' . $fields[$ii] . '1'];
	$Yr2 = $_POST['bu_' . $fields[$ii] . '2'];
	$Yr3 = $_POST['bu_' . $fields[$ii] . '3'];
	$Yr4 = $_POST['bu_' . $fields[$ii] . '4'];
	$Yr5 = $_POST['bu_' . $fields[$ii] . '5'];
	$bTotal = $_POST['bu_' . $fields[$ii] . 'Total'];
	
	$query = "INSERT INTO bs_budget (bs_id, type_id, id, Yr1, Yr2, Yr3, Yr4, Yr5, bTotal, name) " . 
	"VALUES ($bs_id, 4, $f_id, '$Yr1', '$Yr2', '$Yr3', '$Yr4', '$Yr5', '$bTotal', '$name')";
	$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
	//echo "Query: $query<br>\n";
}

//Now try to save the customcategories
$customCount = $_POST['customCount'];
for( $ii=100, $jj=0; $jj<$customCount; $ii++, $jj++)
{
	$name = $_POST['customName' . $ii];
	$Yr1 = $_POST['custom' . $ii . '1'];
	$Yr2 = $_POST['custom' . $ii . '2'];
	$Yr3 = $_POST['custom' . $ii . '3'];
	$Yr4 = $_POST['custom' . $ii . '4'];
	$Yr5 = $_POST['custom' . $ii . '5'];

	$bTotal = $_POST['custom' . $ii . 'Total'];
	
	$id = $ii;
	$query = "INSERT INTO bs_budget (bs_id, type_id, id, Yr1, Yr2, Yr3, Yr4, Yr5, bTotal, name) " . 
		"VALUES ($bs_id, 3, $id, '$Yr1', '$Yr2', '$Yr3', '$Yr4', '$Yr5', '$bTotal', '$name')";
	$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
	//echo "Query: $query<br>\n";
}

// and now the custom subcontractors fields can be saved.
// firstly count the no of subcontractors passed to the page.
$subConCount = 0;
foreach ($_POST as $var => $value) 
{ 
	if (substr($var, 0, 6) == 'subCon')
	{
		if ((substr($var, -4, 4) == 'Name') || (substr($var, -2, 2) == 'ID'))
			$subConCount++;
	}
} 

for( $ii = 1, $jj=1; $jj<=$subConCount; $ii++)
{
	$name = '';
	$e_id = 0;
	$type_id = 0;
	$flag = false;
	if (isset($_POST['subCon' . $ii . 'Name']))
	{
		$flag = true;
		$name = $_POST['subCon' . $ii . 'Name'];
		$type_id = 2;
	}
	else if (isset($_POST['subCon' . $ii . 'ID']))
	{
		$flag = true;
		$query = "SELECT ei_id FROM bs_ei_info WHERE inst_name='" . $_POST['subCon' . $ii . 'ID'] . "'";
		$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
		$row_i = mysql_fetch_array($result_i);
		$e_id = $row_i['ei_id'];
		$type_id = 1;
		$name = $_POST['subCon' . $ii . 'ID'];
	}
	if ($flag == true)
	{
		$jj++;
		$Yr1 = $_POST['subCon' . $ii . '1'];
		$Yr2 = $_POST['subCon' . $ii . '2'];
		$Yr3 = $_POST['subCon' . $ii . '3'];
		$Yr4 = $_POST['subCon' . $ii . '4'];
		$Yr5 = $_POST['subCon' . $ii . '5'];
		
		$bTotal = $_POST['subCon' . $ii . 'Total'];

		if ($type_id == 2)
		{
			$query = "SELECT MAX(id) AS m_id FROM bs_budget WHERE bs_id=$bs_id AND type_id=$type_id";
			$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
			$row_i = mysql_fetch_array($result_i);
			$id = $row_i['m_id'];
			if ($id == null) $id = 1;
			else $id = $id + 1;
		}
		else
			$id = $e_id;

		$query = "INSERT INTO bs_budget (bs_id, type_id, id, Yr1, Yr2, Yr3, Yr4, Yr5, bTotal, name) " . 
			"VALUES ($bs_id, $type_id, $id,'$Yr1', '$Yr2', '$Yr3', '$Yr4', '$Yr5', '$bTotal', '$name')";
		$result_i = real_execute_bs_query($query, $connect) or die("0 - " . mysql_error() . "==" . $query);
		//echo "Query: $query<br>\n";		
	}
}

if (isset($route))
{
	$routed_by = $_SESSION['UID'];
	$dataset = real_get_pplc('utaID', $routed_by, $_ldap_search_dn_ppl);
	$routed_by = $dataset[0][22];
	
	$query = "SELECT * FROM bs_info where bs_id='$bs_id'";
	$result_i = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
	if ($row = mysql_fetch_array($result_i))
	{
		$proposal_title = $row["proposal_title"];
		$query = "SELECT * FROM bs_sponsor_info where bs_id='$bs_id' and sp_id=" . $row["sp_id"];
		$result_i1 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
		if ($row1 = mysql_fetch_array($result_i1))
		{
			$sponsor = $row1["sponsor"];
		}
		
	}

	$query = "UPDATE bs_info set routed_by='$routed_by', routed_time=NOW() where bs_id='$bs_id'";
	$result_i = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
	
		$copis = "";
	
	$query = "SELECT * FROM bs_i_info WHERE bs_id = $bs_id";
	$result_i = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
	while($row = mysql_fetch_array($result_i))
	{
		if ($row["i_id"] == "1")
			$pi = $row["name"];
		else
		{
			if ($copis == "")
				$copis = $row["name"];
			else
				$copis .=  ", " . $row["name"];
		}
	}

	$email_text = "A bluesheet has been submitted and needs your approval. \n";
	if ($proposal_title != "")
		$email_text .= "Title: $proposal_title \n";
	$email_text .= 	"PI: $pi \n";
	if ($sponsor != "")
		$email_text .= 	"Sponsor: $sponsor \n";
	if($copis != "")
		$email_text .= 	"CoPIs: $copis \n";
	$email_text .= 	"Please login at http://{$_SERVER['HTTP_HOST']}{$_home}/loginscreen.php?view=2 to review this bluesheet. \n " . 
	"\n ------------------------------------------------------------------------------- \n" .
	"Technical Questions/Difficulties call 2-1060 or email erahelpdesk@uta.edu. \n " . 
	"Looking for help? Check out blue sheet quick start guide: \n" . 
	"Word Document: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.doc \n" .
	"PDF: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.pdf \n" .
	"Other Blue-sheet related questions email office@institution.edu or contact your specialist (http://www.uta.edu/ra/GCS/specialists.htm). \n\n" . 
	"If you are receiving multiple emails for the same bluesheet, please submit a preferred email address to erahelpdesk@uta.edu & we will add it for future routing.";
	$email_subject = "New bluesheet submitted";
	
	$query = "select A.login_id from ppl_general_info A, bs_info B where A.pid=B.pid and B.bs_id=$bs_id and B.started_by!=A.login_id";
	$result_i = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
	if($row = mysql_fetch_array($result_i))
	{
		$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id) VALUES($bs_id, '" . $row["login_id"] . "', 'Pending', 1)";
		$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
		// get the email addresses of pi from ldap based on their login id.
		$dataset = real_get_pplc('utaID', $row["loginid"], $_ldap_search_dn_ppl);
		$copi_name = $dataset[0][22];
		$copi_email = $dataset[0][30];
		// send email to dean
		$message = "Dear " . $copi_name . ": \n\n" . $email_text;
		mail( $copi_email, $email_subject, $message, "From: GCS<office@institution.edu>" );		
	}
	
	$query = "select A.login_id from ppl_general_info A, bs_info B where A.pid=B.pid and B.bs_id=$bs_id and B.started_by=A.login_id";
	$result_i = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
	if($row = mysql_fetch_array($result_i))
	{
		$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id, timestamp) VALUES($bs_id, '" . $row["login_id"] . "', 'Approved', 1, NOW())";
		$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
	}
	
	$query = "SELECT * FROM bs_i_info WHERE bs_id = $bs_id";
	$result_i = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
	while($row = mysql_fetch_array($result_i))
	{
		$dean_login_id = "";
		$chair_login_id = "";
		$dept = $row["dept"];
		$i_id = $row["i_id"];
		
		if (trim($row["loginid"]) != "")
		{
			$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id, i_loginid) VALUES($bs_id, '" . $row["loginid"] . "', 'Pending', $i_id, '" . $row["loginid"] . "')";
			$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
			// get the email addresses of copi from ldap based on their login id.
			$dataset = real_get_pplc('utaID', $row["loginid"], $_ldap_search_dn_ppl);
			$copi_name = $dataset[0][22];
			$copi_email = $dataset[0][30];
			// send email to dean
			$message = "Dear " . $copi_name . ": \n\n" . $email_text;
			mail( $copi_email, $email_subject, $message, "From: GCS<office@institution.edu>" );
		}
		
		$query = "SELECT hid FROM gen_hierarchy_types WHERE name='$dept'";
		$result_i1 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
		if ($row1 = mysql_fetch_array($result_i1))
		{
			$hid = $row1["hid"];
			// get the dean
			$query = "SELECT * FROM gen_dept_hierarchy WHERE hid=$hid AND authority_type=1";
			$result_i2 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
			if ($row2 = mysql_fetch_array($result_i2))
			{
				$dean_login_id = $row2["login_id"];
				
				$query = "INSERT INTO bs_routing (bs_id, loginid, status, i_id, i_loginid) VALUES($bs_id, '$dean_login_id', 'Pending', $i_id, '" . $row["loginid"] . "')";
				$result_i2 = real_execute_bs_query($query, $connect) or die("03 - " . mysql_error() . " -- " . $query);
				
				// get the email addresses of dean from ldap based on their login id.
				$dataset = real_get_pplc('utaID', $dean_login_id, $_ldap_search_dn_ppl);
				$dean_name = $dataset[0][22];
				$dean_email = $dataset[0][30];
				// send email to dean
				$message = "Dear " . $dean_name . ": \n\n" . $email_text;
				mail( $dean_email, $email_subject, $message, "From: GCS<office@institution.edu>" );
			}
			// get the chair
			$query = "SELECT * FROM gen_dept_hierarchy WHERE hid=$hid AND authority_type=2";
			$result_i2 = real_execute_bs_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
			if ($row2 = mysql_fetch_array($result_i2))
			{
				$chair_login_id = $row2["login_id"];
				
				$query ="INSERT INTO bs_routing (bs_id, loginid, status, i_id, i_loginid) VALUES($bs_id, '$chair_login_id', 'Pending', $i_id, '" . $row["loginid"] . "')";
				$result_i2 = real_execute_bs_query($query, $connect) or die("04 - " . mysql_error() . "==" . $query);

				// get the email addresses of chairperson from ldap based on their login id.
				$dataset = real_get_pplc('utaID', $chair_login_id, $_ldap_search_dn_ppl);
				$chairperson_name = $dataset[0][22];
				$chairperson_email = $dataset[0][30];
				// send email to chairperson
				$message = "Dear " . $chairperson_name . ": \n\n" . $email_text;
				mail( $chairperson_email, $email_subject, $message, "From: GCS<office@institution.edu>" );				
			}
		}
	}
	
	// EH&S
	$query123 = "SELECT * FROM bs_info WHERE bs_id = $bs_id";
	$result_i123 = real_execute_bs_query($query123, $connect) or die("01 - " . mysql_error() . "==" . $query123);
	while($row123 = mysql_fetch_array($result_i123))
	{
		if (($row123['radioactive_materials']=='No') && ($row123['controlled_substances']=='No') && 
			($row123['laser_devices']=='No') && ($row123['radiation_producing_machines']=='No'))
		{
		}
		else
		{
			$query ="INSERT INTO bs_routing (bs_id, loginid, status, i_id) VALUES($bs_id, '000000000', 'Pending', 1)";
			$result_i2 = real_execute_bs_query($query, $connect) or die("05 - " . mysql_error());
			$message = "Dear Sir/Madam: \n\n" . $email_text;
			mail( "EHandS@institution.edu", $email_subject, $message, "From: GCS<office@institution.edu>" );
		}
	}
	
	// Add the last signatory
	$query ="INSERT INTO bs_routing (bs_id, loginid, status, i_id) VALUES($bs_id, '9999999999', 'Pending', 1)";
	$result_i2 = real_execute_bs_query($query, $connect) or die("05 - " . mysql_error());
	
	$query = "UPDATE bs_info set bs_status='Routed' WHERE bs_id = $bs_id";
	$result_i = real_execute_bs_query($query, $connect) or die("06 - " . mysql_error() . "==" . $query);
	real_redirect("../researchspace.php", "view=2", $connect);
}

echo $bs_id;
?>