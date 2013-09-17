<?php
header("Content-type: text/xml");


function wsSearch($qstr)
{
	include '../../utils.php';
	include 'wsconfig.php'; 
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
if( $_SESSION["UID"] != "" )
	real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);



//Changes for XML parsing starts
$xml_search="";

if (!$dom = domxml_open_mem($qstr)) {
  print "Error while parsing the document";
  exit;
  }
 
  $root = $dom->document_element();
  $node_array = $root->get_elements_by_tagname('*');
	$local_i=0;
	foreach ($node_array as $node) {
	   switch($local_i)
	   {
		case 0: $xml_search=$node->get_content();break;	
	   }
	   $local_i++;
}
//Changes fro XML parsing ends




$rank = array();

$pid_list = "";
$debug_list = "";
$count = 0;
//Step 1:- Filter the resultset that needs to be considered	
$pid_list_query = "SELECT T1.pid AS pid FROM gen_profile_info AS T1, tech_status AS T2 WHERE T1.pid = T2.pid  AND T1.status=0 AND T1.type_id='3' AND T2.type='1' OR T2.type='' ORDER BY T1.owner_datetime DESC";

$pid_list_results = real_execute_query( $pid_list_query, $db_conn );
while($pid_list_rows = mysql_fetch_array($pid_list_results))
{
	
	$pid_list = $pid_list . $pid_list_rows["pid"] . ",";
}
$pid_list = substr( $pid_list, 0, strlen( $pid_list ) - 1 );


$tech_general_info_query = "SELECT pid,
				SUM(
					MATCH(name, url_name, url, keywords)
					AGAINST('$xml_search' IN BOOLEAN MODE)) AS score
				FROM tech_gen_info
				WHERE
					MATCH(name, url_name, url, keywords)
					AGAINST('$xml_search' IN BOOLEAN MODE) AND pid in ($pid_list)
          GROUP BY pid ORDER BY score DESC";
		  
$tech_general_info_results = real_execute_query( $tech_general_info_query, $db_conn ); 
while($tech_general_info_rows = mysql_fetch_row($tech_general_info_results))
{	
	$pid = $tech_general_info_rows[0];
	$debug_list = $debug_list . $pid . ", ";
	$rank["$pid"] =  $rank["$pid"] + $tech_general_info_rows[1];		
}

$tech_abstract_query = "SELECT pid,
				SUM(
					MATCH(description)
					AGAINST('$xml_search' IN BOOLEAN MODE)) AS score
				FROM tech_abstract
				WHERE
					MATCH(description)
					AGAINST('$xml_search' IN BOOLEAN MODE) AND pid in ($pid_list)
          GROUP BY pid ORDER BY score DESC";
		  
$tech_abstract_results = real_execute_query( $tech_abstract_query, $db_conn ); 
while($tech_abstract_rows = mysql_fetch_row($tech_abstract_results))
{
	
	$pid = $tech_abstract_rows[0];
	$debug_list = $debug_list . $pid . ",";
	$rank["$pid"] =  $rank["$pid"] + $tech_abstract_rows[1];		
}

$tech_people_query = "SELECT pid,
				SUM(
					MATCH(f_name, l_name, rank, university)
					AGAINST('$xml_search' IN BOOLEAN MODE)) AS score
				FROM tech_people
				WHERE
					MATCH(f_name, l_name, rank, university)
					AGAINST('$xml_search' IN BOOLEAN MODE)	AND pid in ($pid_list)
          GROUP BY pid ORDER BY score DESC";
		  
$tech_people_results = real_execute_query( $tech_people_query, $db_conn ); 
while($tech_people_rows = mysql_fetch_row($tech_people_results))
{
	
	$pid = $tech_people_rows[0];
	$debug_list = $debug_list . $pid . ",";
	$rank["$pid"] =  $rank["$pid"] + $tech_people_rows[1];		
}

arsort( $rank );
$display_string = "";

foreach($rank as $pid => $score )
{
	$get_general_info_query = "select name, url from tech_gen_info where pid = '$pid'";
	$get_general_info_results = real_execute_query( $get_general_info_query, $db_conn ); 
	while($get_general_info_rows = mysql_fetch_row($get_general_info_results))
	{
		
		$display_string = $display_string . "<patent>";
		$display_string = $display_string . "<score>$score</score>";	//Not in the document
		$display_string = $display_string . "<title>".htmlentities($get_general_info_rows[0])."</title>";		
		$display_string = $display_string . "<inst_id>$inst_id</inst_id>";
		
		
		$get_tech_status_query = "select type_no from tech_status where pid = '$pid'";
		$get_tech_status_results = real_execute_query( $get_tech_status_query, $db_conn ); 
		while($get_tech_status_rows = mysql_fetch_row($get_tech_status_results))
		{
			$display_string = $display_string . "<patent_number>".htmlentities($get_tech_status_rows[0])."</patent_number>";
		}
		
		$display_string = $display_string . "<link>".htmlentities($get_general_info_rows[1])."</link>";
		
		$get_abstract_query = "select description from tech_abstract where pid = '$pid'";
		$get_abstract_results = real_execute_query( $get_abstract_query, $db_conn ); 
		while($get_abstract_rows = mysql_fetch_row($get_abstract_results))
		{
			$display_string = $display_string . "<abstract>".htmlentities($get_abstract_rows[0])."</abstract>";
		}
		
		$get_timestamp_query = "select IF (admin_datetime>owner_datetime,admin_datetime, owner_datetime) as date_time
								from gen_profile_info where pid = '$pid'";
		$get_timestamp_results = real_execute_query( $get_timestamp_query, $db_conn ); 
		while($get_timestamp_rows = mysql_fetch_row($get_timestamp_results))
		{
			$display_string = $display_string . "<timestamp>".htmlentities($get_timestamp_rows[0])."</timestamp>";
		}
		
		$display_string = $display_string . "<inventors>";
		$get_people_query = "select full_name,ppl_login_id from tech_people where pid = '$pid'";
		$get_people_results = real_execute_query( $get_people_query, $db_conn ); 
		while($get_people_rows = mysql_fetch_row($get_people_results))
		{
			$display_string = $display_string . "<inventor>";
			$display_string = $display_string . "<full_name>".htmlentities($get_people_rows[0])."</full_name>";			
			
			
			if ($get_people_rows[1] != "")
			{
				$get_people_contact_query = "select address_1, address_2, city, state, zipcode, country, phone_no_1, 
				email_id, pri_designation, pid from ppl_general_info where login_id = $get_people_rows[1]";
				$get_people_contact_results = real_execute_query( $get_people_contact_query, $db_conn ); 
				while($get_people_contact_rows = mysql_fetch_row($get_people_contact_results))
				{
					$temp_str = "";
					$temp_str = "<address>". htmlentities($get_people_contact_rows[0]) . " " . htmlentities($get_people_contact_rows[1]) . ", ". htmlentities($get_people_contact_rows[2]) . ", " .htmlentities($get_people_contact_rows[3]) . ", ". htmlentities($get_people_contact_rows[4]) . ", ". htmlentities($get_people_contact_rows[5]) . "</address>";
					
					$display_string = $display_string . $temp_str;
					$display_string = $display_string . "<phone>".htmlentities($get_people_contact_rows[6])."</phone>";
					$display_string = $display_string . "<email>".htmlentities($get_people_contact_rows[7])."</email>";
					$display_string = $display_string . "<title>".htmlentities($get_people_contact_rows[8])."</title>";
					$img_link = "../../editprofile.php?pid=$get_people_contact_rows[9]"; 
					$display_string = $display_string . "<link>".htmlentities($img_link)."</link>";
				}
			}
			$display_string = $display_string . "</inventor>";	
		}
		$display_string = $display_string . "</inventors>";
		$display_string = $display_string . "</patent>";
	}
}

$tech_office_query = "SELECT * FROM gen_tech_office_info";
		  
$tech_office_results = real_execute_query( $tech_office_query, $db_conn ); 
$document = "";
while($tech_office_rows = mysql_fetch_array($tech_office_results))
{
	$count++;
	$document = $document .  "<institution>";
	//$document = $document . "<pid_list>$debug_list</pid_list>";
	$document = $document . "<name>University of Texas at Arlington</name>";
	$document = $document . "<inst_id>$inst_id</inst_id>";
	$document = $document . "<count>".count($rank)."</count>";
	$document = $document . "<office>".$tech_office_rows["office_name"]."</office>";
	$document = $document . "<home_page>".$tech_office_rows["url"]."</home_page>";
	$document = $document . $display_string;
	$document = $document . "</institution>";
}
	
	
	return $document;
}


function wsBrowse($qstr)
{
		include '../../utils.php';
		include 'wsconfig.php'; 
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
if( $_SESSION["UID"] != "" )
	real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);



//Changes for XML parsing starts
$xml_search="";

if (!$dom = domxml_open_mem($qstr)) {
  print "Error while parsing the document";
  exit;
  }
 
  $root = $dom->document_element();
  $node_array = $root->get_elements_by_tagname('*');
	$local_i=0;
	foreach ($node_array as $node) {
	   switch($local_i)
	   {
		case 0: $xml_search=$node->get_content();break;	
	   }
	   $local_i++;
}
//Changes fro XML parsing ends




$rank = array();

$pid_list = "";
$debug_list = "";
$count = 0;
$display_string = "";
$count_pid = 0;
//Step 1:- Filter the resultset that needs to be considered	
$pid_list_query = "SELECT T1.pid AS pid FROM gen_profile_info AS T1, tech_status AS T2 WHERE T1.pid = T2.pid  AND T1.status=0 AND T1.type_id='3' AND T2.type='1' OR T2.type='' ORDER BY T1.owner_datetime DESC";

$pid_list_results = real_execute_query( $pid_list_query, $db_conn );
while($pid_list_rows = mysql_fetch_array($pid_list_results))
{
	$count_pid++;
	$pid = $pid_list . $pid_list_rows["pid"];
	$get_general_info_query = "select name, url from tech_gen_info where pid = '$pid'";
	$get_general_info_results = real_execute_query( $get_general_info_query, $db_conn ); 
	while($get_general_info_rows = mysql_fetch_row($get_general_info_results))
	{
		
		$display_string = $display_string . "<patent>";
		$display_string = $display_string . "<score>0</score>";	//Not in the document
		$display_string = $display_string . "<title>".htmlentities($get_general_info_rows[0])."</title>";		
		$display_string = $display_string . "<inst_id>1</inst_id>";
		
		
		$get_tech_status_query = "select type_no from tech_status where pid = '$pid'";
		$get_tech_status_results = real_execute_query( $get_tech_status_query, $db_conn ); 
		while($get_tech_status_rows = mysql_fetch_row($get_tech_status_results))
		{
			$display_string = $display_string . "<patent_number>".htmlentities($get_tech_status_rows[0])."</patent_number>";
		}
		
		$display_string = $display_string . "<link>".htmlentities($get_general_info_rows[1])."</link>";
		
		$get_abstract_query = "select description from tech_abstract where pid = '$pid'";
		$get_abstract_results = real_execute_query( $get_abstract_query, $db_conn ); 
		while($get_abstract_rows = mysql_fetch_row($get_abstract_results))
		{
			$display_string = $display_string . "<abstract>".htmlentities($get_abstract_rows[0])."</abstract>";
		}
		
		$get_timestamp_query = "select IF (admin_datetime>owner_datetime,admin_datetime, owner_datetime) as date_time
								from gen_profile_info where pid = '$pid'";
		$get_timestamp_results = real_execute_query( $get_timestamp_query, $db_conn ); 
		while($get_timestamp_rows = mysql_fetch_row($get_timestamp_results))
		{
			$display_string = $display_string . "<timestamp>".htmlentities($get_timestamp_rows[0])."</timestamp>";
		}
		
		$display_string = $display_string . "<inventors>";
		$get_people_query = "select full_name,ppl_login_id from tech_people where pid = '$pid'";
		$get_people_results = real_execute_query( $get_people_query, $db_conn ); 
		while($get_people_rows = mysql_fetch_row($get_people_results))
		{
			$display_string = $display_string . "<inventor>";
			$display_string = $display_string . "<full_name>".htmlentities($get_people_rows[0])."</full_name>";			
			
			
			if ($get_people_rows[1] != "")
			{
				$get_people_contact_query = "select address_1, address_2, city, state, zipcode, country, phone_no_1, 
				email_id, pri_designation, pid from ppl_general_info where login_id = $get_people_rows[1]";
				$get_people_contact_results = real_execute_query( $get_people_contact_query, $db_conn ); 
				while($get_people_contact_rows = mysql_fetch_row($get_people_contact_results))
				{

					$temp_str = "";
					$temp_str = "<address>". htmlentities($get_people_contact_rows[0]) . " " . htmlentities($get_people_contact_rows[1]) . ", ". htmlentities($get_people_contact_rows[2]) . ", " .htmlentities($get_people_contact_rows[3]) . ", ". htmlentities($get_people_contact_rows[4]) . ", ". htmlentities($get_people_contact_rows[5]) . "</address>";
					
					$display_string = $display_string . $temp_str;
					$display_string = $display_string . "<phone>".htmlentities($get_people_contact_rows[6])."</phone>";
					$display_string = $display_string . "<email>".htmlentities($get_people_contact_rows[7])."</email>";
					$display_string = $display_string . "<title>".htmlentities($get_people_contact_rows[8])."</title>";
					$img_link = "http://www.uta.edu/testrsp/profilesystem/editprofile.php?pid=$get_people_contact_rows[9]"; 
					$display_string = $display_string . "<link>".htmlentities($img_link)."</link>";
				}
			}
			$display_string = $display_string . "</inventor>";	
		}
		$display_string = $display_string . "</inventors>";
		$display_string = $display_string . "</patent>";
	}
}

$tech_office_query = "SELECT * FROM gen_tech_office_info";
		  
$tech_office_results = real_execute_query( $tech_office_query, $db_conn ); 
$document = "";
while($tech_office_rows = mysql_fetch_array($tech_office_results))
{
	$count++;
	$document = $document .  "<institution>";
	//$document = $document . "<pid_list>$debug_list</pid_list>";
	$document = $document . "<name>$inst_name</name>";
	$document = $document . "<inst_id>$inst_id</inst_id>";
	$document = $document . "<count>$count_pid</count>";
	$document = $document . "<office>".$tech_office_rows["office_name"]."</office>";
	$document = $document . "<home_page>".$tech_office_rows["url"]."</home_page>";
	$document = $document . $display_string;
	$document = $document . "</institution>";
}
	
	
	return $document;
}


?>