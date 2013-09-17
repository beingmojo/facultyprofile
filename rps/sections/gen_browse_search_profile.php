<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;

Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
Header("Content-type: text/xml");

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$rowsperpage = 10;
if( is_numeric( $_GET["pageno"] ) ) 
	$pageno = (int)$_GET["pageno"];
else
	$pageno = 0;

	
/*
 * Escaped query params
 */
$dept_esc = real_mysql_specialchars(stripslashes($_GET['dept']), true);
$fname_esc = mysql_real_escape_string(stripslashes($_GET['fname']));
$lname_esc = mysql_real_escape_string(stripslashes($_GET['lname']));
$name_esc = mysql_real_escape_string(stripslashes($_GET['name']));



$cnt_query = "SELECT COUNT(1) ";
if( $_GET["type"] == 'ppl' )
{
	$fld_query = "SELECT CONCAT( T1.title, IF(T1.title<>'', ' ', '') , T1.l_name, IF(T1.f_name<>'', ', ', '') , 	T1.f_name, IF(T1.m_name<>'', ' ', '') , T1.m_name ) as name, T1.pri_designation as designation, T1.pid, T1.login_id, T1.title, T1.l_name, T1.f_name, T1.m_name ";
	$clause = " FROM ppl_general_info T1, gen_profile_info T2 WHERE T2.status = 0 AND T1.pid = T2.pid AND T2.type_id=1 ";
	if(strlen($fname_esc)!=0)
		$clause = $clause." AND T1.f_name LIKE '".$fname_esc."%'";
	if(strlen($lname_esc)!=0)
		$clause = $clause." AND T1.l_name LIKE '".$lname_esc."%'";
	$clause = $clause . " ORDER BY T1.l_name, T1.f_name, T1.m_name";
}

if( $_GET["type"] == 'ppla' )
{
	$fld_query = "SELECT CONCAT( T1.title, IF(T1.title<>'', ' ', '') , T1.l_name, IF(T1.f_name<>'', ', ', '') , 	T1.f_name, IF(T1.m_name<>'', ' ', '') , T1.m_name ) as name, T1.pri_designation as designation, T1.pid, T1.login_id, T1.title, T1.l_name, T1.f_name, T1.m_name , T1.phone_no_1, T1.phone_no_2, T1.email_id, T1.status_phone_no_1, T1.status_phone_no_2, T1.status_email_id ";
	$clause = " FROM ppl_general_info T1, gen_profile_info T2 WHERE T2.status = 0 AND T1.pid = T2.pid AND T2.type_id=1 ";
	if(strlen($fname_esc)!=0)
		$clause = $clause." AND T1.f_name LIKE '".$fname_esc."%'";
	if(strlen($lname_esc)!=0)
		$clause = $clause." AND T1.l_name LIKE '".$lname_esc."%'";
	$clause = $clause . " ORDER BY T1.l_name, T1.f_name, T1.m_name";
}

if( $_GET["type"] == 'pplb' )
{
	$fld_query = "SELECT CONCAT( T1.title, IF(T1.title<>'', ' ', '') , T1.l_name, IF(T1.f_name<>'', ', ', '') , 	T1.f_name, IF(T1.m_name<>'', ' ', '') , T1.m_name ) as name, T1.pri_designation as designation, T1.pid, T1.login_id, T1.title, T1.l_name, T1.f_name, T1.m_name , T1.phone_no_1, T1.phone_no_2, T1.email_id, T1.status_phone_no_1, T1.status_phone_no_2, T1.status_email_id, T1.mailbox, T1.office_location, T1.room_no, T1.status_mail_address, T1.pri_hid ";
	$clause = " FROM ppl_general_info T1, gen_profile_info T2 WHERE T2.status = 0 AND T1.pid = T2.pid AND T2.type_id=1 ";
	if(strlen($fname_esc)!=0)
		$clause = $clause." AND T1.f_name LIKE '".$fname_esc."%'";
	if(strlen($lname_esc)!=0)
		$clause = $clause." AND T1.l_name LIKE '".$lname_esc."%'";
	$clause = $clause . " ORDER BY T1.l_name, T1.f_name, T1.m_name";		
}

if( $_GET["type"] == 'pplc' )
{
	$fld_query = "SELECT CONCAT( T1.title, IF(T1.title<>'', ' ', '') , T1.l_name, IF(T1.f_name<>'', ', ', '') , 	T1.f_name, IF(T1.m_name<>'', ' ', '') , T1.m_name ) as name, T1.pri_designation as designation, T1.pid, T1.login_id, T1.image_id, T1.title, T1.l_name, T1.f_name, T1.m_name , T1.phone_no_1, T1.phone_no_2, T1.email_id, T1.status_phone_no_1, T1.status_phone_no_2,T1.keywords, T1.status_email_id, T1.mailbox, T1.office_location, T1.room_no, T1.status_mail_address, T1.pri_hid ";
	$clause = " FROM ppl_general_info T1, gen_profile_info T2 WHERE T2.status = 0 AND T1.pid = T2.pid AND T2.type_id=1 ";
	if(strlen($fname_esc)!=0)
		$clause = $clause." AND T1.f_name LIKE '".$fname_esc."%'";
	if(strlen($lname_esc)!=0)
		$clause = $clause." AND T1.l_name LIKE '".$lname_esc."%'";
	if (isset($dept_esc))
	{
		$clause .= "AND (T1.pri_hid IN (SELECT b.hid FROM gen_hierarchy_types a, gen_hierarchy_types b where a.hid=" . $dept_esc . " and a.h1=b.h1) OR T1.hid IN (SELECT b.hid FROM gen_hierarchy_types a, gen_hierarchy_types b where a.hid=" . $dept_esc . " and a.h1=b.h1))";
	}
	$clause = $clause . " ORDER BY T1.l_name, T1.f_name, T1.m_name";
}

if( $_GET["type"] == 'ctr' )
{
	$fld_query = "SELECT T1.name, T1.description AS description, T1.pid ";
	$clause = " FROM ctr_info T1, gen_profile_info T2 WHERE T2.status = 0 AND T1.pid = T2.pid AND T2.type_id=2 ";
	if(strlen($name_esc)!=0){
		$clause = $clause." AND T1.name LIKE '%".$name_esc."%'";
	}
	$clause = $clause." ORDER BY T1.name";	
}

if( $_GET["type"] == 'lab' )
{
	$fld_query = "SELECT T1.name, T1.description AS description, T1.pid ";
	$clause = " FROM ctr_info T1, gen_profile_info T2 WHERE T2.status = 0 AND T1.pid = T2.pid AND T2.type_id=6 ";
	if(strlen($name_esc)!=0){
		$clause = $clause." AND T1.name LIKE '%".$name_esc."%'";
	}
	$clause = $clause." ORDER BY T1.name";	
}

if( $_GET["type"] == 'tech' )
{
	$fld_query = "SELECT T1.name, T2.description AS description, T1.pid ";
	$clause = " FROM tech_gen_info T1, tech_abstract T2, gen_profile_info T3 WHERE T1.pid = T2.pid AND T1.pid = T3.pid AND T3.status = 0 AND T3.type_id=3 ";
	if(strlen($name_esc)!=0){
		$clause = $clause." AND T1.name LIKE '%".$name_esc."%'";
	}
	$clause = $clause." ORDER BY T1.name";		
}

if( $_GET["type"] == 'fac' )
{
	$fld_query = "SELECT T1.name, T1.description AS description, T1.pid ";
	$clause= " FROM fac_info T1, gen_profile_info T2 WHERE T2.status = 0 AND T1.pid = T2.pid AND T2.type_id=4 ";
	if(strlen($name_esc)!=0){
		$clause = $clause." AND T1.name LIKE '%".$name_esc."%'";
	}
	$clause = $clause." ORDER BY T1.name";		
}

if( $_GET["type"] == 'eqp' )
{
	$fld_query = "SELECT T1.name, T1.description AS description, T1.pid ";
	$clause = " FROM eqp_info T1, gen_profile_info T2 WHERE T2.status=0 AND T1.pid = T2.pid AND T2.type_id=5 ";
	if(strlen($name_esc)!=0){
		$clause = $clause." AND T1.name LIKE '%".$name_esc."%'";
	}
	$clause = $clause." ORDER BY T1.name";		
}
$cnt_results = real_execute_query( $cnt_query . $clause, $db_conn );
$cnt_rows = mysql_fetch_row( $cnt_results );
$max_page = ceil( $cnt_rows[0] / $rowsperpage ) ;
if( $cnt_rows[0] <=  ( ($pageno - 1) * $rowsperpage ) )
	$pageno =  $max_page ;

if( $pageno > 0 )
	$limit = " LIMIT " . ( $pageno - 1 ) * $rowsperpage . ", " . $rowsperpage;

$fld_results = real_execute_query( $fld_query . $clause . $limit, $db_conn );
$count = mysql_num_rows($fld_results);

//print "\n<br>".$data_source;
print '<?xml version="1.0" encoding="iso-8859-1"?>' . "\n";
$counter = 0;
$type  = $_GET["type"];
if(  $type=='ppl' || $type=='ppla' || $type=='pplb' || $type=='pplc')
{
	print "<$type maxpage='" . $max_page . "' pageno='". $pageno . "'>";
	while($rows=mysql_fetch_array($fld_results))
	{
		print ("<$type" . $counter . ">");
		print ("<name>". htmlspecialchars($rows["name"], ENT_QUOTES) . "</name>".
			  "<rank>". htmlspecialchars($rows["designation"], ENT_QUOTES) ."</rank>".
			  "<pid>". htmlspecialchars($rows["pid"], ENT_QUOTES) . "</pid>".
			  "<loginid>". htmlspecialchars($rows["login_id"], ENT_QUOTES) . "</loginid>".
			  "<title>". htmlspecialchars($rows["title"], ENT_QUOTES) . "</title>".
			  "<lname>". htmlspecialchars($rows["l_name"], ENT_QUOTES) . "</lname>".
			  "<fname>". htmlspecialchars($rows["f_name"], ENT_QUOTES) . "</fname>".
			  "<mname>". htmlspecialchars($rows["m_name"], ENT_QUOTES) . "</mname>" );
		if( $type == 'ppla' || $type == 'pplb' || $type == 'pplc' )
		{
			$phone = ( $rows["phone_no_1"] != "" && $rows["status_phone_no_1"] == 0 ) ? $rows["phone_no_1"] : "";
			if( $phone == "" )
				$phone = ( $rows["phone_no_2"] != "" && $rows["status_phone_no_2"] == 0 ) ? $rows["phone_no_2"] : "";
			$email = ( $rows["email_id"] != "" && $rows["status_email_id"] == 0 ) ? $rows["email_id"] : "";
			print( "<phone>". htmlspecialchars($phone, ENT_QUOTES) . "</phone>" );
			print( "<emailid>". htmlspecialchars($email, ENT_QUOTES) . "</emailid>" );
		}
		if( $type == 'pplb' || $type == 'pplc' )
		{
			$roomno = ( $rows["room_no"] != "" && $rows["status_mail_address"] == 0 ) ? $rows["room_no"] : "";
			$location = ( $rows["office_location"] != "" && $rows["status_mail_address"] == 0 ) ? $rows["office_location"] : "";
			$mailbox = ( $rows["mailbox"] != "" && $rows["status_mail_address"] == 0 ) ? $rows["mailbox"] : "";
			$hid = $rows["pri_hid"];
			print( "<room>". htmlspecialchars($roomno, ENT_QUOTES) . "</room>" );
			print( "<bldg>". htmlspecialchars($location, ENT_QUOTES) . "</bldg>" );
			print( "<box>". htmlspecialchars($mailbox, ENT_QUOTES) . "</box>" );	
			print( "<hid>". $hid . "</hid>" );	
		}
		if( $type == 'pplc' )
		{
			$keywords = str_replace("&", "&amp;", $rows["keywords"]);
			$iid = $rows["image_id"];
			print( "<iid>". $iid . "</iid>" );	
			print( "<keywords>". $keywords . "</keywords>" );	
		}		
		print ("</$type". $counter . ">");
		$counter++;
	}
	print ("</$type>");
}
else
{
	print "<$type maxpage='" . $max_page . "' pageno='". $pageno . "'>";
	while($rows=mysql_fetch_array($fld_results))
	{
		print ("<$type" . $counter . ">");
		print ("<name>". htmlspecialchars($rows["name"], ENT_QUOTES)."</name>".
				"<desc>". htmlspecialchars($rows["description"], ENT_QUOTES) ."</desc>" .
			  	"<pid>". htmlspecialchars($rows["pid"], ENT_QUOTES) ."</pid>");
		print ("</$type" . $counter . ">");
		$counter++;
	}
	print ("</$type>");
}
