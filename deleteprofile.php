<?php
//� 2006 The University of Texas at Arlington 
//Page created by: 
//Last edited by : Raghavendra
//Last edited    : 25th April 2006
//Last change made : commenting

/*page info---------- This page is for deleting a profile permanently
person with proper admin rights can delete a profile.
This page allows to delete a profile by just taking the pid as input
*/

session_start();
// including the 'utils.php' file
include 'utils.php';
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

//getting the pid from the url
$pid = real_mysql_specialchars( $_GET["pid"], true );
//checking wether the person is admin and has proper rights to delete a profile
$is_admin = real_check_user_groupid( $db_conn, "admin" );

//if pid is not empty and the user has admin rights
if( $pid !="" && is_admin == true )
{
	$section_query = "SELECT table_name FROM gen_section_types T1, gen_profile_section T2 WHERE T2.pid = $pid AND T1.section_id = T2.section_id";
	$section_results = real_execute_query( $section_query, $db_conn );
	while( $section_rows = mysql_fetch_array( $section_results ) )
	{
		$table_query = "SHOW TABLES LIKE '" . $section_rows["table_name"] . "'";
		$table_results = real_execute_query( $table_query, $db_conn );
		while( $table_rows = mysql_fetch_array( $table_results ) )
		{
			$query = "DELETE FROM " . $table_rows[0] . " WHERE pid = $pid ";
			print( $query . "<BR>" );
			$result = real_execute_query( $query, $db_conn );
			if ($result != null)
			print("successfully deleted<BR><BR>");
		}
	}
	
	$query = "DELETE FROM all_additional_section WHERE pid=$pid";
	print( $query . "<BR>" );	
	$result = real_execute_query( $query, $db_conn );
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	$query = "DELETE FROM gen_profile_section where pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn );
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	$query = "DELETE FROM gen_profile_hierarchy WHERE pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn );
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	//deleting from table which does not meet the above condition
	
	$query = "DELETE FROM ppl_course WHERE pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn);
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	$query = "DELETE FROM fac_people WHERE pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn);
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	$query = "DELETE FROM fac_publication WHERE pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn);
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	$query = "DELETE FROM tech_description WHERE pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn);
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	$query = "DELETE FROM tech_additional WHERE pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn);
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	
	$query = "DELETE FROM gen_association WHERE pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn);
	if ($result != null)
	print("successfully deleted<BR><BR>");

	$query = "DELETE FROM gen_profile_cluster WHERE pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn);
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	$query = "DELETE FROM gen_profile_section_additional WHERE pid=$pid";
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn);
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	
	
	$type_query = "SELECT type_id FROM gen_profile_info WHERE pid = $pid";
	$type_results = real_execute_query( $type_query, $db_conn );
	$type_rows = mysql_fetch_array( $type_results );
	switch( $type_rows["type_id"] )
	{
	case 1:
		$query = "DELETE FROM ppl_general_info WHERE pid = $pid";
		break;
	case 2:
		$query = "DELETE FROM ctr_gen_info WHERE pid = $pid";
		
		break;
	case 3:
		$query = "DELETE FROM tech_gen_info WHERE pid = $pid";
		
		break;
	case 4:
		$query = "DELETE FROM fac_gen_info WHERE pid = $pid";
		
		break;
	case 5:
		$query = "DELETE FROM eqp_info WHERE pid = $pid";
		
		break;
	case 6:
		$query = "DELETE FROM ctr_gen_info WHERE pid = $pid";
	}
	print( $query . "<BR>" );
	$result = real_execute_query( $query, $db_conn );
	if ($result != null)
	print("successfully deleted<BR><BR>");
	
	// deleting the images associated with the profile
	$query = "DELETE FROM gen_image_info where pid=$pid";
	print( $query . "<BR>" );
	real_execute_query( $query, $db_conn );
	
	
	foreach( glob( "images/128/".$pid."_*.*" ) as $fn )
	{
		unlink( $fn );
	}
	foreach( glob( "images/48/".$pid."_*.*" ) as $fn )
	{
		unlink( $fn );
	}
	foreach( glob( "images/0/".$pid."_*.*" ) as $fn )
	{
		unlink( $fn );
	}


	$query = "DELETE FROM gen_profile_info where pid=$pid";
	print( $query );
	$result = real_execute_query( $query, $db_conn );
	if ($result != null)
	print("successfully deleted<BR><BR>");
}
// if no matching profile found or pid is empty
if($pid="")
Print("no such profile exists");
?>