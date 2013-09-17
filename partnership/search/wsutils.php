<?php
header("Content-type: text/xml");
//error_reporting(0);		//this one line of missing code which did not return the document on the devel site
ini_set("display_errors", 0);

function wsSearch($qstr)
{

	include '../../utils.php';
	include 'wsconfig.php';

	$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);


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

	$dom =  new DomDocument("1.0", "UTF-8");
	if (!$dom->loadXML($qstr)) {
	  print "Error while parsing the document";
	  exit;
	}

	$root = $dom->documentElement;
	$node_array = $root->getElementsByTagname('*');

	$local_i=0;
	foreach ($node_array as $node) {
	   switch($local_i)
	   {

		case 0: $xml_key=$node->nodeValue;break;
		case 1: $xml_search=$node->nodeValue;break;
		case 2: $xml_faculty=$node->nodeValue;break;
		case 3: $xml_researchcenter=$node->nodeValue;break;
		case 4: $xml_technology=$node->nodeValue;break;
		case 5: $xml_facility=$node->nodeValue;break;
		case 6: $xml_equipment=$node->nodeValue;break;
		case 7: $xml_labgroup=$node->nodeValue;break;
		case 8: $xml_searchtype=$node->nodeValue;break;
		case 9: $xml_subsearch=$node->nodeValue;break;
		case 10: $xml_pidlist=$node->nodeValue;break;

	   
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

	

	if( $xml_searchtype == "basic" )
	
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
		if( $xml_equipment == "true" )
			$searchtype_basic_equipment = 1;
		if( $xml_labgroup == "true" )
			$searchtype_basic_labgroup = 1;

		$link='newsearch.php';

		
	}

	$rank = array();
	$section = array();

	if( $pid_list != '' )
	{
		$pid_list_clause1 = " AND T1.pid IN ( $pid_list ) ";
		$pid_list_clause = " AND pid IN ( $pid_list ) ";
	}

	$searchstring = mysql_real_escape_string(stripslashes($searchstring));

	if( $searchtype_basic == -1 || $searchtype_basic_faculty == 1 )
	{
		$ppl_general_info_search_1_query =
			"
				SELECT pid,
				SUM(
					MATCH(f_name, m_name, l_name, designation, email_id, phone_no_1, phone_no_2, fax_no, cell_no, url_name_1, 	url_name_2, url_name_2, keywords)
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
					MATCH(T1.name, description)
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score
				FROM ctr_info as T1 INNER JOIN gen_profile_info USING (pid)
				WHERE
					MATCH(T1.name, description)
					AGAINST('$searchstring' IN BOOLEAN MODE)
					AND type_id='2'
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
	/**For equipments in facility and research center, all necessary details are extracted now itself and not along with the other profiles, as the 
     * equipment is searched based on the pid of the facility and research center. 
     * the info of thses profiles are currently stored in eqp_info[$pid] and later stored in info[$pid] to make sure that the results are passed to the xml 
     * in the descending order of the score. 
     **/
	if( $searchtype_basic == -1 || $searchtype_basic_equipment == 1 )
	{
		$ctr_eqp_info_search_query = 	
					"
						SELECT T1.pid,T1.eqp_id,T1.name,T1.description,T1.url_name,T1.image_id,T2.name as ctr_name,
						SUM(MATCH(T1.name,T1.description,T1.url_name) AGAINST ('$searchstring' IN BOOLEAN MODE)) as score
						FROM ctr_equipment as T1 LEFT JOIN ctr_info as T2 USING (pid) LEFT JOIN gen_profile_info as T3 USING (pid)
						WHERE MATCH(T1.name,T1.description,T1.url_name) AGAINST ('$searchstring' IN BOOLEAN MODE)
							AND T3.status='0' AND T1.eqp_pid = '0'
							$pid_list_clause1
						GROUP BY T1.eqp_id,T1.pid ORDER BY score DESC
					";
		$ctr_eqp_info_search_results = real_execute_query($ctr_eqp_info_search_query,$db_conn);
		
		while($ctr_eqp_info_search_row = mysql_fetch_array($ctr_eqp_info_search_results)) 
		{
			
			$pid = $ctr_eqp_info_search_row['pid']."#ctr_eqp".$ctr_eqp_info_search_row['eqp_id'];
			$name[$pid] = $ctr_eqp_info_search_row['name'];
			$ctr_eqp_info_search_row['description'] = strip_tags($ctr_eqp_info_search_row['description']);
			
			if(strlen($ctr_eqp_info_search_row['description']) > 130) {
				$ctr_eqp_info_search_row['description'] = substr($ctr_eqp_info_search_row['description'],0,130);
				$ctr_eqp_info_search_row['description'] = ereg_replace('(^.+)([[:space:]][^[:space:]]+)([[:space:]][^[:space:]]+$)','\\1\\2',$ctr_eqp_info_search_row['description']);
				$ctr_eqp_info_search_row['description'] .= "...";
			}
			
			$eqp_info[$pid] = $ctr_eqp_info_search_row['description'];
			//$image[$pid] = $ctr_eqp_info_search_row['pid']."_6_".$ctr_eqp_info_search_row['image_id'];
			$type[$pid] = 5;
			$owner[$pid] = "UTT";
			$rank[$pid] = $rank[$pid] + $ctr_eqp_info_search_row['score'];
			$section[$pid] = "Equipment Information ";
			$section[$pid] .= sprintf("(<a href=\"editprofile.php?pid=%s&amp;onlyview=1\">%s</a>), ",
										$ctr_eqp_info_search_row['pid'],$ctr_eqp_info_search_row['ctr_name']);
		}
		//Facility Equipment
		
		$fac_eqp_info_search_query = 	
					"
						SELECT T1.pid,T1.eqp_id,T1.name,T1.description,T1.url_name,T1.image_id,T2.name as fac_name,
						SUM(MATCH(T1.name,T1.description,T1.url_name) AGAINST ('$searchstring' IN BOOLEAN MODE)) as score
						FROM fac_equipment as T1 LEFT JOIN fac_info as T2 USING (pid) LEFT JOIN gen_profile_info as T3 USING (pid)
						WHERE MATCH(T1.name,T1.description,T1.url_name) AGAINST ('$searchstring' IN BOOLEAN MODE)
							AND T3.status='0' AND T1.eqp_pid = '0'
							$pid_list_clause1
						GROUP BY T1.eqp_id,T1.pid ORDER BY score DESC
					";
		$fac_eqp_info_search_results = real_execute_query($fac_eqp_info_search_query,$db_conn);
		while($fac_eqp_info_search_row = mysql_fetch_array($fac_eqp_info_search_results)) {
			$pid = $fac_eqp_info_search_row['pid']."#fac_eqp".$fac_eqp_info_search_row['eqp_id'];
			$name[$pid] = $fac_eqp_info_search_row['name'];
			$fac_eqp_info_search_row['description'] = strip_tags($fac_eqp_info_search_row['description']);
			if(strlen($fac_eqp_info_search_row['description']) > 130) {
				$fac_eqp_info_search_row['description'] = substr($fac_eqp_info_search_row['description'],0,130);
				$fac_eqp_info_search_row['description'] = ereg_replace('(^.+)([[:space:]][^[:space:]]+)([[:space:]][^[:space:]]+$)','\\1\\2',$fac_eqp_info_search_row['description']);
				$fac_eqp_info_search_row['description'] .= "...";
			}
			$eqp_info[$pid] = $fac_eqp_info_search_row['description'];
			//$image[$pid] = $fac_eqp_info_search_row['pid']."_6_".$fac_eqp_info_search_row['image_id'];
			$type[$pid] = 5;
			$owner[$pid] = "UTT";
			$rank[$pid] = $rank[$pid] + $fac_eqp_info_search_row['score'];
			$section[$pid] = "Equipment Information ";
			$section[$pid] .= sprintf("(<a href=\"editprofile.php?pid=%s&amp;onlyview=1\">%s</a>), ",
										$fac_eqp_info_search_row['pid'],$fac_eqp_info_search_row['fac_name']);
		}
		//General Equipment
		$gen_eqp_info_search_query = 	
					"
						SELECT pid,location,
							SUM(MATCH(name,description,url_name) AGAINST ('$searchstring' IN BOOLEAN MODE)) as score
						FROM eqp_info
						WHERE MATCH(name,description,url_name) AGAINST ('$searchstring' IN BOOLEAN MODE)
							$pid_list_clause
						GROUP BY pid
					";
		$gen_eqp_info_search_results = real_execute_query($gen_eqp_info_search_query,$db_conn);
		while($gen_eqp_info_search_row = mysql_fetch_array($gen_eqp_info_search_results)) {
			
			$pid = $gen_eqp_info_search_row['pid'];
			$rank[$pid] = $gen_eqp_info_search_row['score'];
			$section[$pid] = "General Equipment Information ";
			$section[$pid] .= sprintf("(<a href=\"editprofile.php?pid=%s&amp;onlyview=1\">%s</a>), ",
										$gen_eqp_info_search_row['pid'],$gen_eqp_info_search_row['location']);
		}

	}

	if( $searchtype_basic == -1 || $searchtype_basic_labgroup == 1 )
	{
		$lab_info_search_query =
				"
					SELECT T1.pid,
					SUM(
						MATCH(T1.name, description)
						AGAINST('$searchstring' IN BOOLEAN MODE)) AS score
					FROM ctr_info as T1
					INNER JOIN gen_profile_info USING (pid)
					WHERE
						MATCH(T1.name, description)
						AGAINST('$searchstring' IN BOOLEAN MODE)
						AND type_id = '6'
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


		if( $where == 1 ) //To make sure that the query should executed only if atleast one type of profile is checked.
		{
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
	
						$rank["$pid"] = $rank["$pid"] + $search_rows[1];
	
	
	
						$section["$pid"] = $section["$pid"] . $gen_section_types_rows['name'] . ", ";
					}
				}
	
			}
		}

	}

	arsort( $rank );
	$pid_list = "";
	$i = 0;
	//$count = 0;
	$temp_pid_list = array();
	foreach( $rank as $pid => $score )
	{
		$i++;
		$info_query = "";
		//this will enable searching only inactive profiles. Please change status=0 if active profiles need to be searched
		if( is_int($pid) ) //To avoid the fcility and research center's equipment pid's, as it is non integer and its detals already put in array.
		{
			$type_query = "SELECT type_id, owner_login_id from gen_profile_info WHERE pid = $pid AND status = 0" ;
			
			$type_results = real_execute_query( $type_query, $db_conn );
			if( $type_rows = mysql_fetch_array( $type_results ) )
			{
				switch( $type_rows["type_id"] )
				{
				case 1:
					$info_query = "SELECT
										CONCAT( IF(T1.title<>'', T1.title, ''),IF(T1.title<>'', ' ', '') , T1.l_name,IF(T1.f_name<>'', ', ', '') , IF(T1.f_name<>'', T1.f_name, ''), IF(T1.m_name<>'', ' ', '') ,IF(T1.m_name<>'', T1.m_name, '') ) as name,
										T1.pri_designation as info,
									image_id as image_id
									FROM ppl_general_info T1
									WHERE T1.pid = $pid" ;   //Changes made to handle the problem that concat gives null if one of the fields is null
					
	
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
					$info_query = "SELECT name as name,
										CONCAT( SUBSTRING( description, 1, 100 ) , '...' ) as info,
										image_id as image_id
									FROM eqp_info
									WHERE pid = $pid";
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
		}
		else
		{
			$info["$pid"] = $eqp_info["$pid"];
			//$count++;
					
		}
		if($info[$pid]) 
		{
			
			if(!(is_int($pid))) 
	        {
				$pid = ereg_replace("^([0-9]+)(.*)$","\\1",$pid);
	        }
			if(!in_array($pid,$temp_pid_list))
			{
				$temp_pid_list[] = $pid;
				$pid_list .= "$pid,";
			}
		}
        

	}

	$pid_list = substr( $pid_list, 0, strlen( $pid_list ) - 1 );
	$document = "<institution >";
	$document .= $i ;
	$document .= "</institution >";

	if ($info)
	{
		$document = "<institution >";
		$document .= "<name>";
		$document .= "$inst_name";
		$document .= "</name>";

		$document .= "<count>";
		$document .= count( $info );							//# of search results returned
		$document .= "</count>";
		$document .= "<pidlist>";
		$document .= $pid_list;
		$document .= "</pidlist>";
        $count = 0;
		foreach( $info as $pid => $information )
		{
			//$count++;
			if( $name["$pid"] == "" )
				continue;
			$sec = substr( $section["$pid"], 0, strlen( $section["$pid"] ) - 2 );

			            
			$document .= "<searchresult>";

			$document .= "<score>";
			$temp2 = $rank["$pid"];
			$document .= $temp2;
			$document .= "</score>";

			$document .= "<profile_type>";
			$document .= $type["$pid"];
			$document .= "</profile_type>";

			$document .= "<profile_name>";
			$temp1 = strip_tags(utf8_encode($name["$pid"]));
			$temp1 = htmlspecialchars($temp1,ENT_NOQUOTES);
			$document .= $temp1;
			//$document .= (mb_convert_encoding($newteml,"ISO_8859-1","UTF-8"));
			$document .= "</profile_name>";

			$document .= "<profile_link>";
			$link = "editprofile.php?pid=$pid&onlyview=1";
			$strip_link = str_replace( "&" ,"&amp;", $link );
			$document .= $strip_link;
			$document .= "</profile_link>";

			$document .= "<relevant_sections>";
			$newsec = str_replace( "&" ,'&amp;', $sec);
			$document .= strip_tags(utf8_encode($newsec));
			$document .= "</relevant_sections>";

			$document .= "<institution_id>";
			$document .= utf8_encode($inst_id);
			$document .= "</institution_id>";

			$document .= "<brief_description>";
			$newinfo = str_replace( "&" , '&amp;' , $info["$pid"]);
			$document .= (strip_tags(utf8_encode($newinfo)));
			$document .= "</brief_description>";

			$document .= "<imageurl>";
			if( $image["$pid"] != 0 )
			{
				$p= "images/48/". $pid . "_0_" . $image["$pid"] .".jpg";
				$document .= ($p);
			}
			$document .= "</imageurl>";

			$document .= "</searchresult>";

		}//end of for

               
		$document .= "</institution>";
	}
	else
	{
		//$document .= "<institution />";	//if no search results are found.
	}

	
	return $document;
}


?>