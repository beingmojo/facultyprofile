<?php  
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
if( $_SESSION["UID"] != "" )
	real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
$pid = $_GET["pid"];

$login_id_query ="SELECT owner_login_id FROM gen_profile_info WHERE pid=".real_mysql_specialchars( $pid, true );

$login_id_results = real_execute_query( $login_id_query, $db_conn);

$login_id_row = mysql_fetch_array($login_id_results);

$login_id = $login_id_row["owner_login_id"];

$gen_association_query = "select distinct T1.pid, T1.type_id from gen_profile_info T1, gen_association T2 where  T1.pid = T2.pid AND T2.assoc_login_id = ".real_mysql_specialchars($login_id, true);
			
$gen_association_results = real_execute_query ( $gen_association_query, $db_conn );	

if( mysql_num_rows( $gen_association_results ) > 0 )
	mysql_data_seek( $gen_association_results, 0 );
$type = array();
while( $gen_association_rows = mysql_fetch_array( $gen_association_results) )
{
	$pid = $gen_association_rows["pid"];
	switch( $gen_association_rows["type_id"] )
	{
	case 1:
		$info_query = "SELECT 
						CONCAT( 
							T1.title, IF(T1.title<>'', ' ', ''), 
							T1.l_name, IF(T1.f_name<>'', ', ', ''), 
							T1.f_name, IF(T1.m_name<>'', ' ', ''), 
							T1.m_name ) as name,
						T1.designation as info,
						image_id as image_id
						FROM ppl_general_info T1
						WHERE T1.pid = ".real_mysql_specialchars( $pid, true );
							
		break;
	case 2:
		$info_query = "SELECT T1.name as name, 
							CONCAT( SUBSTRING( T1.description, 1, 255 ), '...' ) as info,
							T2.ctr_image_id as image_id
						FROM ctr_info T1, ctr_gen_info T2
						WHERE T1.pid = T2.pid AND T1.pid=".real_mysql_specialchars( $pid, true );
					
		break;
	case 3:
		$info_query = "SELECT T1.name as name, 
							CONCAT( SUBSTRING( T2.description, 1, 255 ), '...' ) as info,
							T1.image_id as image_id
							FROM tech_gen_info T1, tech_abstract T2
							WHERE T1.pid=T2.pid AND T1.pid=".real_mysql_specialchars( $pid, true );
		break;
	case 4:
		$info_query = "SELECT T1.name as name, 
							CONCAT( SUBSTRING( T1.description, 1, 255 ), '...' ) as info,
							T2.fac_image_id as image_id
							FROM fac_info T1, fac_gen_info T2
							WHERE T1.pid = T2.pid AND T1.pid=".real_mysql_specialchars( $pid, true );
		break;
	case 5:
		$info_query = "SELECT T1.name as name, 
							CONCAT( SUBSTRING( T1.description, 1, 255 ), '...' ) as info,
							T1.image_id as image_id
							FROM eqp_info T1
							WHERE T1.pid=".real_mysql_specialchars( $pid, true );
		break;
	case 6:
		$info_query = "SELECT T1.name as name, 
							CONCAT( SUBSTRING( T1.description, 1, 255 ), '...' ) as info,
							T2.ctr_image_id as image_id
						FROM ctr_info T1, ctr_gen_info T2
						WHERE T1.pid = T2.pid AND T1.pid=".real_mysql_specialchars( $pid, true );
					
	}
	if( $info_query != '' )
	{
		$info_results = real_execute_query( $info_query, $db_conn );
		if( $info_rows = mysql_fetch_array( $info_results ) )
		{
			$name["$pid"] = $info_rows["name"];
			$info["$pid"] = $info_rows["info"];
			$image["$pid"] = $info_rows["image_id"];
			$type["$pid"] = $gen_association_rows["type_id"];

		}
	}
}
if( mysql_num_rows( $gen_association_results ) > 0 )
	asort( $type );
?>

<html>
<head>

<link href="../styles/style1.css" rel="stylesheet" type="text/css">

</head>

<body bgcolor="white">

<form name='ppl_general_info_rank_edit_form'>
<?php
	$curr_type_id = 0;
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_general_info_rank_edit_box' >" );
		print( "<tr>" );
			print( "<td width='100%'>" );
			print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
				if( count( $type ) <= 0 )
					print( "<span class='page_heading'>&nbsp;There are no associated profiles.</span>" );
				else
				{
					foreach( $type as $pid=>$type_id )
					{
						print( "<tr><td colspan='3'><HR></td></tr>" );
						if( $type_id > $curr_type_id )
						{
							$curr_type_id = $type_id;
							print( "<tr>" );
								print( "<td colspan='3'>" );
								switch( $curr_type_id )
								{
								case 1:
									print( "<img alt='faculty' src='../images/bullets/faculty.png'>" );
									print( "<span class='page_heading'>&nbsp;Faculty Profiles</span>" );
									break;
								case 2:
									print( "<img alt='Research Center' src='../images/bullets/center.png'>" );
									print( "<span class='page_heading'>&nbsp;Research Center Profiles</span>" );
									break;
								case 3:
									print( "<img alt='Technology' src='../images/bullets/technology.png'>" );
									print( "<span class='page_heading'>&nbsp;Technology Profiles</span>" );
									break;
								case 4:
									print( "<img alt='facility' src='../images/bullets/facility.png'>" );
									print( "<span class='page_heading'>&nbsp;Facility Profiles</span>" );
									break;
								case 5:
									print( "<img alt='equipment' src='../images/bullets/equipment.gif'>" );
									print( "<span class='page_heading'>&nbsp;Equipment Profiles</span>" );
									break;
								case 6:
									print( "<img alt='Lab/Group' src='../images/bullets/labgroup.gif'>" );
									print( "<span class='page_heading'>&nbsp;Labs & Groups Profiles</span>" );
									break;
								}
								print( "</span" );
								print( "</td>" );
							print( "</tr>" );
							print( "<tr><td colspan='3'><HR></td></tr>" );
						}

						print( "<tr>" );
							print( "<td rowspan='2' width='48' height='48'>" );
								if( $image["$pid"] != 0 )
									print( "<img src='../images/48/". "$pid" . "_0_" . $image["$pid"] . ".jpg" . "' alt='". $name["$pid"]. "' border='1'>" );
							print( "</td>" );
							print( "<td rowspan='2' width='5'></td>" );
							print( "<td>" );
								if( $type["$pid"] == 1 ){ $src = "../editprofile.php"; }
								if( $type["$pid"] == 2 ){ $src = "../editprofile.php";  }
								if( $type["$pid"] == 3 ){ $src = "../editprofile.php";  }
								if( $type["$pid"] == 4 ){ $src = "../editprofile.php"; }
								if( $type["$pid"] == 5 ){ $src = "../editprofile.php"; }
								if( $type["$pid"] == 6 ){ $src = "../editprofile.php"; }
								print( "<a href='#' onclick='parent.ShowProfile(\"$src?pid=$pid\")'><span class='font_topic'>" . $name["$pid"] . "</span></a>" );
							print( "</td>" );
								
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>" );
								print( "<span class='form_elements'>" . $info["$pid"] . "</span>" );
							print( "</td>" );
						print( "</tr>" );
					}
				}		
			print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
		
		
	print( "</table>" );
	
?>

</form>
</body>
</html>