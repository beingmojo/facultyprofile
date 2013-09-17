<?php
include '../utils.php';
include '../ldapdbutils.php';
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

$type = $_GET["type"] ;
if( $type == 'ppl' )
{
	$results = real_get_ppl_by_name( $db_conn, $_GET['lname'], $_GET['fname'], $pageno );
}

if( $type == 'ppla' )
{
	$results = real_get_ppla_by_name( $db_conn, $_GET['lname'], $_GET['fname'], $pageno );
}

if( $type == 'pplb' )
{
	$results = real_get_pplb_by_name( $db_conn, $_GET['lname'], $_GET['fname'], $pageno );
}

$counter = 0;
$type  = $_GET["type"];
$pageno = $results[0];
$max_page = $results[1];
$data = $results[2];

//echo "<pre>"; print_r($data); echo "</pre>"; 
//exit();

print '<?xml version="1.0" encoding="iso-8859-1"?>' . "\n";
if(  $type=='ppl' || $type=='ppla' || $type=='pplb' )
{
	print "<$type maxpage='" . $max_page . "' pageno='". $pageno . "' count='" . count( $data ) . "'>";
	$counter = 0;
	while($counter < count( $data ))
	{
		print ("<$type" . $counter . ">");
		print ("<name>". ucwords(htmlspecialchars((string)$data[$counter][4]. ", " . (string)$data[$counter][5] ." ".(string)$data[$counter][6], ENT_QUOTES)) . "</name>".
			  "<rank>". htmlspecialchars((string)$data[$counter][1], ENT_QUOTES) . ( ($data[$counter][1] != "" && $data[$counter][2] != "") ? ", " : "" ) . htmlspecialchars((string)$data[$counter][2], ENT_QUOTES) ."</rank>".
			  "<pid>". "0" . "</pid>".
			  "<loginid>". htmlspecialchars((string)$data[$counter][3], ENT_QUOTES) . "</loginid>".
			  "<title>". "" . "</title>".
			  "<lname>". htmlspecialchars((string)$data[$counter][4], ENT_QUOTES) . "</lname>".
			  "<fname>". htmlspecialchars((string)$data[$counter][5], ENT_QUOTES) . "</fname>".
			  "<mname>". htmlspecialchars((string)$data[$counter][6], ENT_QUOTES) . "</mname>" );
		if( $type == 'ppla' ||  $type == 'pplb')
		{
			print( "<phone>". htmlspecialchars((string)$data[$counter][7], ENT_QUOTES) . "</phone>" );
			print( "<emailid>". htmlspecialchars((string)$data[$counter][8], ENT_QUOTES) . "</emailid>" );
		}
		if( $type == 'pplb' )
		{
			print( "<room>". htmlspecialchars((string)$data[$counter][10], ENT_QUOTES) . "</room>" );
			print( "<bldg>". htmlspecialchars((string)$data[$counter][11], ENT_QUOTES) . "</bldg>" );
			print( "<box>". htmlspecialchars((string)$data[$counter][12], ENT_QUOTES) . "</box>" );	
			$dept_code = htmlspecialchars((string)$data[$counter][13], ENT_QUOTES);
			$query = "select * from gen_ldap_hierarchy_mapping where dept_code='$dept_code'";
			$result = mysql_query($query, $db_conn);
			if ($row = mysql_fetch_array($result))
			{
				$hid = $row["hid"];
			}
			if ($hid=="0")
			{
				$query = "select * from ppl_general_info where login_id='".$data[$counter][3]."'";
				$result = mysql_query($query, $db_conn);
				if ($row = mysql_fetch_array($result))
				{
					$hid = $row["pri_hid"];
				}
			}
			print( "<hid>". $hid . "</hid>" );	
			print( "<deptcode>". $dept_code . "</deptcode>" );	
			print( "<cedarid>". htmlspecialchars((string)$data[$counter][20], ENT_QUOTES) . "</cedarid>" );
		}
		print ("</$type". $counter . ">");
		$counter = $counter + 1;
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
