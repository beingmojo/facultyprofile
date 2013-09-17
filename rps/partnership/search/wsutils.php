<?php
header("Content-type: text/xml");



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
//	   $xml_search=$node_array->item(0)->nodeValue;
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

	   /* case 0: $xml_key=$node->get_content();break;
		case 1: $xml_search=$node->get_content();break;
		case 2: $xml_faculty=$node->get_content();break;
		case 3: $xml_researchcenter=$node->get_content();break;
		case 4: $xml_technology=$node->get_content();break;
		case 5: $xml_facility=$node->get_content();break;
		case 6: $xml_equipment=$node->get_content();break;
		case 7: $xml_labgroup=$node->get_content();break;
		case 8: $xml_searchtype=$node->get_content();break;
		case 9: $xml_subsearch=$node->get_content();break;
		case 10: $xml_pidlist=$node->get_content();break;*/
	   }
	   $local_i++;
	}
	 //Use to Test
	/*$document = "<test>";
	$document .= "<xml_key>".$xml_key."</xml_key>";
	$document .= "<xml_search>".$xml_search."</xml_search>";
	$document .= "<xml_faculty>".$xml_faculty."</xml_faculty>";
	$document .= "<xml_researchcenter>".$xml_researchcenter."</xml_researchcenter>";
	$document .= "<xml_technology>".$xml_technology."</xml_technology>";
	$document .= "<xml_facility>".$xml_facility."</xml_facility>";
	$document .= "<xml_equipment>".$xml_equipment."</xml_equipment>";
	$document .= "<xml_labgroup>".$xml_labgroup."</xml_labgroup>";
	$document .= "<xml_searchtype>".$xml_searchtype."</xml_searchtype>";
	$document .= "<xml_subsearch>".$xml_subsearch."</xml_subsearch>";
	$document .= "<xml_pidlist>".$xml_pidlist."</xml_pidlist>";
	$document .= "</test>";

	return $document;*/

	if(strcmp($xml_key,$inst_key)!=0)
	{
		//$document = "<test><xmlkey>$xml_key</xmlkey><inskey>$inst_key</inskey></test>";
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

	/*if( $searchtype == "home" ||  $searchtype == "")
	{
		$searchtype_basic = -1;
		$searchtype_basic_faculty = 1;
		$searchtype_basic_researchcenter = 1;
		$searchtype_basic_technology = 1;
		$searchtype_basic_facility = 1;
		$searchtype_basic_equipment =1;
		$searchtype_basic_labgroup =1;
		$link='newsearch.php';
	}*/

	if( $xml_searchtype == "basic" )
	//if( $searchtype == "basic")
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

		/*$document = "<test>";

		$document .= "<searchtype_basic_faculty>".$searchtype_basic_faculty."</searchtype_basic_faculty>";
		$document .= "<searchtype_basic_researchcenter>".$searchtype_basic_researchcenter."</searchtype_basic_researchcenter>";
		$document .= "<searchtype_basic_technology>".$searchtype_basic_technology."</searchtype_basic_technology>";
		$document .= "<searchtype_basic_facility>".$searchtype_basic_facility."</searchtype_basic_facility>";

		$document .= "</test>";

		return $document;*/
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
					MATCH(name, description)
					AGAINST('$searchstring' IN BOOLEAN MODE)) AS score
				FROM ctr_info
				WHERE
					MATCH(name, description)
					AGAINST('$searchstring' IN BOOLEAN MODE)
				$pid_list_clause
				GROUP BY pid ORDER BY score DESC
			";

		/*$document = "<test>";
		$document .= "<query>".$ctr_info_search_query."</query>";
		$document .= "</test>";
		return $document;*/


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
			//print "<section_$pid>" . $section["$pid"] . "</section_$pid>";
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

					$rank["$pid"] = $rank["$pid"] + $search_rows[1];



					$section["$pid"] = $section["$pid"] . $gen_section_types_rows['name'] . ", ";
				}
			}

		}

	}

	arsort( $rank );
	$pid_list = "";
	$i = 0;
	foreach( $rank as $pid => $score )
	{
		$i++;
		//this will enable searching only inactive profiles. Please change status=0 if active profiles need to be searched
		$type_query = "SELECT type_id, owner_login_id from gen_profile_info WHERE pid = $pid AND status = 0" ;
		//print '<type_query>' .$type_query .'</type_query>';
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
				/*$document = "<institution >";
				$document .= $info_results;
				$document .= "</institution >";*/
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
	$document = "<institution >";
	$document .= $i ;
	$document .= "</institution >";

	if ($info)
	{
		//$doc = new DomDocument('1.0');
		//$doc = new_xmldoc( "1.0" );
		//$root = $doc->add_root( "root" );
		//$root->content = "contents of root";

		//$root = $doc->createElement('institution');
		//$root = $doc->appendChild($root);

		//$name = $doc->createElement('name');
		//$name = $root->appendChild($name);

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

		foreach( $info as $pid => $information )
		{
			if( $name["$pid"] == "" )
				continue;
			$sec = substr( $section["$pid"], 0, strlen( $section["$pid"] ) - 2 );

			//$document .= "<sec_Information>$sec</sec_Information>\n"


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

	//$query = "Select *  from gen_funding_mapping";
	//$result = mysql_query($query,$db_conn) or die("Error");
   // $row = mysql_fetch_row($result);


	return $document;
}


?>