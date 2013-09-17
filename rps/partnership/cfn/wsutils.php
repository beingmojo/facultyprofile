<?php
header("Content-type: text/xml");


function wsSearch($qstr)
{
	include '../../utils.php';
	include '../../bluesheet/includes/bs_ldaputils.php';
	include 'wsconfig.php';
	
	session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);

if( $_SESSION["UID"] != "" )
	real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

	
$document = "";

//Changes for XML parsing starts
	$xml_search="";
	$xml_key="";
	$xml_faculty="false";
	$xml_researchcenter="false";
	$xml_technology="false";
	$xml_facility="false";
	$xml_equipment="false";
	$xml_labgroup="false";
	$xml_subsearch="off";
	$xml_pidlist="";

	if (!$dom = domxml_open_mem($qstr)) {

	  return "Error while parsing the document";
	  exit;
  	}
		  //return "qstr=".$qstr. " "; 
  	$root = $dom->document_element();
  	$node_array = $root->get_elements_by_tagname('*');
	$local_i=0;
	foreach ($node_array as $node) {
	   switch($local_i)
	   {
	    case 0: $xml_key=$node->get_content();break;
		case 1: $xml_search=$node->get_content();break;
		case 2: $xml_faculty=$node->get_content();break;
		case 3: $xml_researchcenter=$node->get_content();break;
		case 4: $xml_technology=$node->get_content();break;
		case 5: $xml_facility=$node->get_content();break;
		case 6: $xml_equipment=$node->get_content();break;
		case 7: $xml_labgroup=$node->get_content();break;
		case 8: $xml_searchtype=$node->get_content();break;
		case 9: $xml_subsearch=$node->get_content();break;
		case 10: $xml_pidlist=$node->get_content();break;
	   }
	   $local_i++;
	}
	
	if(strcmp($xml_key,$inst_key)!=0)
	{
		$document = "<error><msg>Invalid Key</msg></error>";
		return $document;
	}
	
	$pid_list="";
	if( $xml_subsearch == "on" )
		$pid_list = $xml_pidlist;
	//Changes fro XML parsing ends


	$rawsearchstring = $xml_search;
	$decodedsearchstring = rawurldecode($rawsearchstring);
	$searchstrings = explode( ' ', $decodedsearchstring );
	$searchstring = "";
	
	$searchtype_basic = 0;
	$searchtype_basic_faculty = 0;
	$searchtype_basic_researchcenter = 0;
	$searchtype_basic_technology = 0;
	$searchtype_basic_facility = 0;
	$searchtype_basic_equipment = 0;
	$searchtype_basic_labgroup = 0;
	foreach( $searchstrings as $srchstr )
	{
		if( $srchstr != "" )
		{
			$searchstring = $searchstring . $srchstr . "*";
		
		} 
	}
	$src = "editprofile.php";
	$searchtype = $xml_searchtype;

	if( $searchtype == "home" ||  $searchtype == "")
	{
		$searchtype_basic = -1;
		$searchtype_basic_faculty = 1;
		$searchtype_basic_researchcenter = 1;
		$searchtype_basic_technology = 1;
		$searchtype_basic_facility = 1;
		$searchtype_basic_equipment =1;
		$searchtype_basic_labgroup =1;
		$link='newsearch.php';
	}
	
	if( $searchtype == "basic" )
	{
		$searchtype_basic = 1;
		if( $xml_faculty == "true" )
			$searchtype_basic_faculty = 1;
		if( $xml_researchcenter == "true" )
			$searchtype_basic_researchcenter = 1;
		if( $xml_technology == "true" )
			$searchtype_basic_technology = 1;
		if( $xml_facility == "true" )
			$searchtype_basic_facility = 1;
	
		$link='newsearch.php';
	}

$rank = array();
$section = array();
if( $pid_list != '' )
{
	$pid_list_clause1 = " AND T1.pid IN ( $pid_list ) ";
	$pid_list_clause = " AND pid IN ( $pid_list ) ";
}
	
if( $searchtype_basic == -1 || $searchtype_basic_faculty == 1 )
{
	$ppl_general_info_search_1_query = 
			"
				SELECT pid, 
				SUM(
					MATCH(f_name, m_name, l_name, designation, email_id, phone_no_1, phone_no_2, fax_no, cell_no, url_name_1, url_name_2, url_name_2, keywords) 
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score 
				FROM ppl_general_info 
				WHERE
					MATCH(f_name, m_name, l_name, designation, email_id, phone_no_1, phone_no_2, fax_no, cell_no, url_name_1, url_name_2, url_name_2, keywords) 
					AGAINST('$searchstring' IN BOOLEAN MODE)
				$pid_list_clause
				GROUP BY pid ORDER BY score DESC
			";

	$ppl_general_info_search_1_results = real_execute_query( $ppl_general_info_search_1_query, $db_conn );
	while( $ppl_general_info_search_1_rows = mysql_fetch_array( $ppl_general_info_search_1_results ) )
	{
		$pid = $ppl_general_info_search_1_rows[0];
		$rank["$pid"] =  $rank["$pid"] + $ppl_general_info_search_1_rows[1];
		$section["$pid"] = $section["$pid"] . "General Information, ";
	}

	$ppl_general_info_search_2_query = 
			"
				SELECT pid, 
				SUM(
					MATCH(address_1, address_2, city, state, zipcode, country, mailbox, office_location, room_no) 
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score 
				FROM ppl_general_info 
				WHERE
					MATCH(address_1, address_2, city, state, zipcode, country, mailbox, office_location, room_no) 
					AGAINST('$searchstring' IN BOOLEAN MODE)
				$pid_list_clause
				GROUP BY pid ORDER BY score DESC
			";		
	$ppl_general_info_search_2_results = real_execute_query( $ppl_general_info_search_2_query, $db_conn );
	while( $ppl_general_info_search_2_rows = mysql_fetch_array( $ppl_general_info_search_2_results ) )
	{
		$pid = $ppl_general_info_search_2_rows[0];
		
		$rank["$pid"] = $rank["$pid"] + $ppl_general_info_search_2_rows[1];
		$section["$pid"] = $section["$pid"] . "Address Information, ";
	}

}

if( $searchtype_basic == -1 || $searchtype_basic_researchcenter == 1 )
{
	$ctr_info_search_query = 
			"
				SELECT pid, 
				SUM(
					MATCH(name, description) 
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score
				FROM ctr_info 
				WHERE
					MATCH(name, description) 
					AGAINST('$searchstring' IN BOOLEAN MODE)
				$pid_list_clause
				GROUP BY pid ORDER BY score DESC
			";		
	
	$ctr_info_search_results = real_execute_query( $ctr_info_search_query, $db_conn );
	while( $ctr_info_search_rows = mysql_fetch_array( $ctr_info_search_results ) )
	{
		$pid = $ctr_info_search_rows[0];
		$rank["$pid"] = $rank["$pid"] + $ctr_info_search_rows[1];
		$section["$pid"] = $section["$pid"] . "General Information, ";
	}
	
	$ctr_general_info_search_query = 
			"
				SELECT pid, 
				SUM(
					MATCH(phone_no_1, phone_no_2, fax_no, url_name, address_1, address_2, city, state, zipcode, country, mailbox, office_location, room_no) 
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score 
				FROM ctr_gen_info 
				WHERE
					MATCH(phone_no_1, phone_no_2, fax_no, url_name, address_1, address_2, city, state, zipcode, country, mailbox, office_location, room_no) 
					AGAINST('$searchstring' IN BOOLEAN MODE)
					$pid_list_clause
				GROUP BY pid ORDER BY score DESC
			";		
	
	$ctr_general_info_search_results = real_execute_query( $ctr_general_info_search_query, $db_conn );
	while( $ctr_general_info_search_rows = mysql_fetch_array( $ctr_general_info_search_results ) )
	{
		$pid = $ctr_general_info_search_rows[0];
		$rank["$pid"] = $rank["$pid"] + $ctr_general_info_search_rows[1];
		$section["$pid"] = $section["$pid"] . "Contact Information, ";
	}
}	

if( $searchtype_basic == -1 || $searchtype_basic_technology == 1 )
{
	$tech_info_search_query = 
			"
				SELECT pid, 
				SUM(
					MATCH(name, keywords) 
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score
				FROM tech_gen_info 
				WHERE
					MATCH(name, keywords) 
					AGAINST('$searchstring' IN BOOLEAN MODE)
				$pid_list_clause
				GROUP BY pid ORDER BY score DESC
			";		
	
	$tech_info_search_results = real_execute_query( $tech_info_search_query, $db_conn );
	while( $tech_info_search_rows = mysql_fetch_array( $tech_info_search_results ) )
	{
		$pid = $tech_info_search_rows[0];
		$rank["$pid"] = $rank["$pid"] + $tech_info_search_rows[1];
		$section["$pid"] = $section["$pid"] . "General Information, ";
	}
		
}	

if( $searchtype_basic == -1 || $searchtype_basic_facility == 1 )
{
	$fac_info_search_query = 
			"
				SELECT pid, 
				SUM(
					MATCH(name, description) 
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score
				FROM fac_info 
				WHERE
					MATCH(name, description) 
					AGAINST('$searchstring' IN BOOLEAN MODE)
				$pid_list_clause
				GROUP BY pid ORDER BY score DESC
			";		
	
	$fac_info_search_results = real_execute_query( $fac_info_search_query, $db_conn );
	while( $fac_info_search_rows = mysql_fetch_array( $fac_info_search_results ) )
	{
		$pid = $fac_info_search_rows[0];
		
		$rank["$pid"] = $rank["$pid"] + $fac_info_search_rows[1];
		$section["$pid"] = $section["$pid"] . "General Information, ";
	}
	
	$fac_general_info_search_query = 
			"
				SELECT pid, 
				SUM(
					MATCH(phone_no_1, phone_no_2, fax_no, url_name, address_1, address_2, city, state, zipcode, country, mailbox, office_location, room_no) 
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score 
				FROM fac_gen_info 
				WHERE
					MATCH(phone_no_1, phone_no_2, fax_no, url_name, address_1, address_2, city, state, zipcode, country, mailbox, office_location, room_no) 
					AGAINST('$searchstring' IN BOOLEAN MODE)
					$pid_list_clause
				GROUP BY pid ORDER BY score DESC
			";		
	
	$fac_general_info_search_results = real_execute_query( $fac_general_info_search_query, $db_conn );
	while( $fac_general_info_search_rows = mysql_fetch_array( $fac_general_info_search_results ) )
	{
		$pid = $fac_general_info_search_rows[0];
		
		$rank["$pid"] = $rank["$pid"] + $fac_general_info_search_rows[1];
		$section["$pid"] = $section["$pid"] . "Contact Information, ";
	}
}	

if( $searchtype_basic == -1 || $searchtype_basic_equipment == 1 )
{
	$eqp_info_search_query = 
			"
				SELECT T1.pid,
				SUM(
					MATCH( T1.name, T1.description, T1.url_name,T2.name,T2.description, T2.url_name,T3.name,T3.description, T3.url_name,T3.keywords,T3.comments) 
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score
				FROM ctr_equipment T1, fac_equipment T2,eqp_info T3
				WHERE
					MATCH( T1.name, T1.description, T1.url_name,T2.name,T2.description, T2.url_name,T3.name,T3.description, T3.url_name,T3.keywords,T3.comments) 
					AGAINST('$searchstring' IN BOOLEAN MODE)
				$pid_list_clause1
				GROUP BY T1.pid ORDER BY score DESC
			";		
	
	$eqp_info_search_results = real_execute_query( $eqp_info_search_query, $db_conn );
	while( $eqp_info_search_rows = mysql_fetch_array( $eqp_info_search_results ) )
	{
		$pid = $eqp_info_search_rows[0];
		$rank["$pid"] = $rank["$pid"] + $eqp_info_search_rows[1];
		$section["$pid"] = $section["$pid"] . "General Information, ";
	}
	
	
}	

if( $searchtype_basic == -1 || $searchtype_basic_labgroup == 1 )
{
	$lab_info_search_query = 
			"
				SELECT pid, 
				SUM(
					MATCH(name, description) 
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score
				FROM ctr_info 
				WHERE
					MATCH(name, description) 
					AGAINST('$searchstring' IN BOOLEAN MODE)
				$pid_list_clause
				GROUP BY pid ORDER BY score DESC
			";		
	
	$lab_info_search_results = real_execute_query( $lab_info_search_query, $db_conn );
	while( $lab_info_search_rows = mysql_fetch_array( $lab_info_search_results ) )
	{
		$pid = $lab_info_search_rows[0];
		$rank["$pid"] = $rank["$pid"] + $lab_info_search_rows[1];
		$section["$pid"] = $section["$pid"] . "General Information, ";
	}
	
}	


//basic search


if( $searchtype_basic == -1 || $searchtype_basic == 1 )
{
	$where = 0;
	$gen_section_types_query = "SELECT * FROM gen_section_types";
	if( $searchtype_basic == 1 && $searchtype_basic_faculty == 1 )
	{
		$gen_section_types_query = $gen_section_types_query . " WHERE type_id = 1 ";
		$where = 1;
	}
	if( $searchtype_basic == 1 && $searchtype_basic_researchcenter == 1 )
	{
		$prepend = $where == 0 ? " WHERE " : " OR ";
		if( $where == 0 ) $where = 1;
		$gen_section_types_query = $gen_section_types_query . $prepend . " type_id = 2 ";
	}
	if( $searchtype_basic == 1 && $searchtype_basic_technology == 1 )
	{
		$prepend = $where == 0 ? " WHERE " : " OR ";
		if( $where == 0 ) $where = 1;
		$gen_section_types_query = $gen_section_types_query . $prepend . " type_id = 3 ";
	}
	if( $searchtype_basic == 1 && $searchtype_basic_facility == 1 )
	{
		$prepend = $where == 0 ? " WHERE " : " OR ";
		if( $where == 0 ) $where = 1;
		$gen_section_types_query = $gen_section_types_query . $prepend . " type_id = 4 ";
	}
	if( $searchtype_basic == 1 && $searchtype_basic_equipment == 1 )
	{
		$prepend = $where == 0 ? " WHERE " : " OR ";
		if( $where == 0 ) $where = 1;
		$gen_section_types_query = $gen_section_types_query . $prepend . " type_id = 5 ";
	}
	if( $searchtype_basic == 1 && $searchtype_basic_labgroup == 1 )
	{
		$prepend = $where == 0 ? " WHERE " : " OR ";
		if( $where == 0 ) $where = 1;
		$gen_section_types_query = $gen_section_types_query . $prepend . " type_id = 6 ";
	}
	$gen_section_types_results = real_execute_query( $gen_section_types_query, $db_conn );
	
	while( $gen_section_types_rows = mysql_fetch_array( $gen_section_types_results ) )
	{
		if( $gen_section_types_rows['table_exists'] == 1 )
		{
			$search_query = 
					"
						SELECT pid, 
						SUM(
							MATCH(". $gen_section_types_rows['index_fields'] .") 
							AGAINST('$searchstring' IN BOOLEAN MODE)) AS score 
						FROM " .  $gen_section_types_rows['table_name'] . "
						WHERE
							MATCH(". $gen_section_types_rows['index_fields'] .") 
							AGAINST('$searchstring' IN BOOLEAN MODE)
							$pid_list_clause
						GROUP BY pid ORDER BY score DESC
					";		
			$search_results = real_execute_query( $search_query, $db_conn );
			while( $search_rows = mysql_fetch_array( $search_results ) )
			{
				$pid = $search_rows[0];
				//$scores["$pid"] = $search_rows["score"];
				$rank["$pid"] = $rank["$pid"] + $search_rows[1];
				$section["$pid"] = $section["$pid"] . $gen_section_types_rows['name'] . ", ";
			}
		}
		
	}
}
arsort( $rank );

$pid_list = "";

foreach( $rank as $pid => $score )
{
	//this will enable searching only inactive profiles. Please change status=0 if active profiles need to be searched
	$type_query = "SELECT type_id, owner_login_id from gen_profile_info WHERE pid = $pid AND status = 0" ;
	$type_results = real_execute_query( $type_query, $db_conn );
	if( $type_rows = mysql_fetch_array( $type_results ) )
	{
		switch( $type_rows["type_id"] )
		{
		case 1:
			$info_query = "SELECT 
								CONCAT( T1.title, IF(T1.title<>'', ' ', '') , T1.l_name, IF(T1.f_name<>'', ', ', '') , 	T1.f_name, IF(T1.m_name<>'', ' ', '') , T1.m_name ) as name,
								T1.pri_designation as info,
							image_id as image_id
							FROM ppl_general_info T1
							WHERE T1.pid = $pid" ;
								
			break;
		case 2:
			$info_query = "SELECT T1.name as name, 
								CONCAT( SUBSTRING( T1.description, 1, 100 ) , '...' ) as info,
								T2.ctr_image_id as image_id
							FROM ctr_info T1, ctr_gen_info T2
							WHERE T1.pid=$pid AND T1.pid = T2.pid";
							
			break;
		case 3:
			$info_query = "SELECT T1.name as name, 
								CONCAT( SUBSTRING( T2.description, 1, 100 ) , '...' ) as info,
								T1.image_id as image_id
								FROM tech_gen_info T1, tech_abstract T2
								WHERE T1.pid=$pid AND T1.pid=T2.pid";
			break;
		case 4:
			$info_query = "SELECT T1.name as name, 
								CONCAT( SUBSTRING( T1.description, 1, 100 ) , '...' ) as info,
								T2.fac_image_id as image_id
							FROM fac_info T1, fac_gen_info T2
							WHERE T1.pid=$pid AND T1.pid = T2.pid";
			break;
		case 5:
			$info_query = "";
			break;
		case 6:
			$info_query = "SELECT T1.name as name, 
								CONCAT( SUBSTRING( T1.description, 1, 100 ) , '...' ) as info,
								T2.ctr_image_id as image_id
							FROM ctr_info T1, ctr_gen_info T2
							WHERE T1.pid=$pid AND T1.pid = T2.pid";
			break;
		
		}
		if( $info_query != '' )
		{
			$info_results = real_execute_query( $info_query, $db_conn );
			if( $info_rows = mysql_fetch_array( $info_results ) )
			{
				$name["$pid"] = $info_rows["name"];
				$info["$pid"] = $info_rows["info"];
				$image["$pid"] = $info_rows["image_id"];
				$type["$pid"] = $type_rows["type_id"];
				$owner["$pid"] = $type_rows["owner_login_id"];
			}
		}
	}
	
	$pid_list = $pid_list . "$pid,";
	
}
$pid_list = substr( $pid_list, 0, strlen( $pid_list ) - 1 );	

//This section has been written by Arjun/Abhishek
//the following section returns data in XML format in
//response to the query
//Changes made my Kenil Shah

if ($info)
{	
	$document =  '<institution>';							//XML root element
	$document = $document .  '<name>';
	$document = $document .  $inst_name;								//Name of the Institution
	$document = $document . '</name>';
	$document = $document . '<count>';		
	$document = $document .  count( $info );							//# of search results returned
	$document = $document . '</count>';
	//the following pidlist element has been added new to facilitate "Search within Results" function for profiles
	$document = $document . '<pidlist>';
	$document = $document .  $pid_list;
	$document = $document . '</pidlist>';


		
	//---------------------	
	
	foreach( $info as $pid => $information )
	{		
		if( $name["$pid"] == "" )
			continue;
		$sec = substr( $section["$pid"], 0, strlen( $section["$pid"] ) - 2 );
		$document = $document . '<searchresult>';
		$document = $document . '<score>';
		$temp2 = $rank["$pid"];
		$document = $document .  $temp2;
		$document = $document . '</score>';
		$document = $document . '<profile_type>';
		$document = $document .  $type["$pid"];
		$document = $document . '</profile_type>';
		$document = $document . '<profile_name>';
		$temp1 = strip_tags($name["$pid"]);
		$newteml = str_replace( "&" ,"&amp;", $temp1 );
		$document = $document .  mb_convert_encoding($newteml,"ISO_8859-1","UTF-8");
		$document = $document . '</profile_name>';		
		$document = $document . '<profile_link>';
		$link = "http://www.uta.edu/testrsp/profilesystem/editprofile.php?pid=$pid&onlyview=1";
		$strip_link = str_replace( "&" ,"&amp;", $link );
		$document = $document .  $strip_link;
		$document = $document . '</profile_link>';
		$document = $document . '<relevant_sections>';
		$newsec2 = str_replace( "&" ,'&amp;', $sec);
		$newsec = str_replace("Research / Services","Research or Services", $newsec2);
		$document = $document .  strip_tags($newsec);      
		
		$document = $document . '</relevant_sections>';
		$document = $document . '<institution_id>';
		$document = $document .  $inst_id;
		$document = $document . '</institution_id>';
		$document = $document . '<brief_description>';
		$newinfo = str_replace( "&" , '&amp;' , $info["$pid"]);
		$document = $document .  strip_tags($newinfo);
		$document = $document . '</brief_description>';
		$document = $document . '<imageurl>';
		if( $image["$pid"] != 0 )
		{
		//Absolute URL required
			$p= "http://www.uta.edu/testrsp/profilesystem/images/48/". $pid . "_0_" . $image["$pid"] .".jpg";
			$document = $document .  $p;			
		}
		$document = $document . '</imageurl>';
		
		//----The following is the newly added element
		//"Contact" element has been added to include the primary contact information in case of a center

		//Check if the profile type is other than Faculty or Technology
		if (($type["$pid"] == 2)||($type["$pid"] == 4)||($type["$pid"] == 5)||($type["$pid"] == 6))
		{
			$document = $document . '<contact>';
			//Find the primary contact name, profile id and email address
			$owner_query = "SELECT pid, title, f_name, m_name, l_name, email_id FROM ppl_general_info WHERE login_id = ".$owner["$pid"];
			$owner_searchresults = real_execute_query( $owner_query, $db_conn );
			if ($owner_cols = mysql_fetch_array ($owner_searchresults))
			{
				$document = $document . '<name>';
				$document = $document .  $owner_cols["title"]." ".$owner_cols["f_name"]." ".$owner_cols["m_name"]." ".$owner_cols["l_name"];
				$document = $document . '</name>';
				$document = $document . '<p_link>';
				$proflink = "http://www.uta.edu/testrsp/profilesystem/editprofile.php?pid=".$owner_cols["pid"]."&onlyview=1";
				$strip_proflink = str_replace( "&" ,"&amp;", $proflink );
				$document = $document .  $strip_proflink;
				$document = $document . '</p_link>';
				$document = $document . '<login>';
				$document = $document .  $owner["$pid"];
				$document = $document . '</login>';
				$document = $document . '<email>';
				$document = $document .  $owner_cols["email_id"];
				$document = $document . '</email>';
			}
			else
			{
				/*
				$dataset = real_get_pplc('utaid',$owner["$pid"], $_ldap_search_dn_ppl);
				$document = $document . '<name>';
				$document = $document .  $dataset[0][22];
				$document = $document . '</name>';
				$document = $document . '<p_link>';
				$proflink = "http://www.uta.edu/testrsp/profilesystem/editprofile.php?pid=".$owner_cols["pid"]."&onlyview=1";
				$strip_proflink = str_replace( "&" ,"&amp;", $proflink );
				$document = $document .  $strip_proflink;
				$document = $document . '</p_link>';
				$document = $document . '<login>';
				$document = $document .  $owner["$pid"];
				$document = $document . '</login>';
				$dataset = real_get_pplc('cedarid',$dataset[0][27], $_ldap_search_dn_acct);
				$email = $dataset[0][8];
				$document = $document . '<email>';
				$document = $document .  $email;
				$document = $document . '</email>';
				*/
			}
			$document = $document . '</contact>';
		}
		///Check if the profile type is Technology
		elseif ($type["$pid"] == 3)
		{
			// may contain more than one primary contact. Only find contacts within the institution
			$owner_query = "SELECT pid, full_name, ppl_login_id FROM tech_people WHERE ppl_login_id<>'' AND pid = ".$pid."";
			$owner_searchresults = real_execute_query( $owner_query, $db_conn );
			while ($owner_cols = mysql_fetch_array ($owner_searchresults))
			{
				$document = $document . '<contact>';
				$document = $document . '<name>';
				$document = $document .  $owner_cols["full_name"];
				$document = $document . '</name>';
				$document = $document . '<p_link>';
				$proflink = "http://www.uta.edu/testrsp/profilesystem/editprofile.php?pid=".$owner_cols["pid"]."&onlyview=1";
				$strip_proflink = str_replace( "&" ,"&amp;", $proflink );
				$document = $document .  $strip_proflink;
				$document = $document . '</p_link>';					
				$document = $document . '<login>';
				$login_info = $owner_cols["ppl_login_id"];
				$document = $document .  $login_info;
				$document = $document . '</login>';				
				$owners_query = "SELECT email_id FROM ppl_general_info WHERE login_id = ".$login_info."";
				$owner_results = real_execute_query( $owners_query, $db_conn );
				if ($owner_email = mysql_fetch_array ($owner_results))
				{
					$document = $document . '<email>';
					$document = $document .  $owner_email["email_id"];
					$document = $document . '</email>';
				}
				else
				{
					$dataset = real_get_pplc('utaid', $login_info, $_ldap_search_dn_ppl);
					$dataset = real_get_pplc('cedarid', $dataset[0][27], $_ldap_search_dn_acct);
					$email = $dataset[0][8];
					$document = $document . '<email>';
					$document = $document .  $email;
					$document = $document . '</email>';
				}
				$document = $document . '</contact>';
			}
		}
		
		//if the profile type is Faculty
		elseif ($type["$pid"] == 1)
		{				 		
			$document = $document . '<contact>';
			$document = $document . '<name>';
			$temp1 = strip_tags($name["$pid"]);
			$newteml = str_replace( "&" ,"&amp;", $temp1 );
			$document = $document .  (mb_convert_encoding($newteml,"ISO_8859-1","UTF-8"));
			$document = $document . '</name>';		
			$document = $document . '<p_link>';
			$link = "http://www.uta.edu/testrsp/profilesystem/editprofile.php?pid=$pid&onlyview=1";
			$strip_link = str_replace( "&" ,"&amp;", $link );
			$document = $document .  $strip_link;
			$document = $document . '</p_link>';
			if ($owner["$pid"] != "")
			{
				$owner_query = "SELECT email_id FROM ppl_general_info WHERE login_id = ".$owner["$pid"];
				$owner_searchresults = real_execute_query( $owner_query, $db_conn );
				if ($owner_cols = mysql_fetch_array ($owner_searchresults))
				{			
					
					$document = $document . '<login>';
					$document = $document .  $owner["$pid"];
					$document = $document . '</login>';
					$document = $document . '<email>';
					$emailadd = trim($owner_cols["email_id"]);
					$document = $document .  $emailadd;
					$document = $document . '</email>';
				}
			}
			else
			{				
				$owner_query = "SELECT login_id, email_id FROM ppl_general_info WHERE pid = ".$pid;
				$owner_searchresults = real_execute_query( $owner_query, $db_conn );
				if ($owner_cols = mysql_fetch_array ($owner_searchresults))
				{
					$document = $document . '<login>';
					$document = $document . ($owner_cols["login_id"]);
					$document = $document . '</login>';
					$document = $document . '<email>';
					$emailadd = trim($owner_cols["email_id"]);
					$document = $document .  $emailadd;
					$document = $document . '</email>';
				}
			}
			$document = $document . '</contact>';
		}
		
		$document = $document . '</searchresult>';

		
	}//end of for	
	
	$document = $document . '</institution>';

}//end of if
else
{
	$document =  "<institution />" ;		//if no search results are found.
}
return $document;
}
?>