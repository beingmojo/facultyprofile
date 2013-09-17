<?php
include 'utils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$view = $_GET['view'];

$uid = real_unescape( $_SESSION[ 'UID' ] );
$lname = substr( real_unescape( $_POST[ "lname" ] ), 0, 255 );
$fname = substr( real_unescape( $_POST[ "fname" ] ), 0, 255 );
$email = substr( real_unescape( $_POST[ "email" ] ), 0, 255 );
$phone = substr( real_unescape( $_POST[ "phone" ] ), 0, 32 );

$rank = real_unescape( $_POST[ "rankdept" ] );
//$dept = substr( real_unescape( $_POST[ "dept" ] ), 0, 32 );

$query = "UPDATE gen_login_info SET ". 
		" lname = " . real_mysql_specialchars($lname, false) . 
		", fname = " . real_mysql_specialchars($fname, false) . 
		", email_id = " . real_mysql_specialchars($email, false) . 
		", phone_no = " . real_mysql_specialchars($phone, false) . 
/* // Include rank and dept into the database as and when they are available through LDAP
		", rank = " . real_mysql_specialchars($rank, false) . 
		", dept = " . real_mysql_specialchars($dept, false) . 
*/
		", datetime = NOW() WHERE login_id = " . real_mysql_specialchars($uid, false);
$result = real_execute_query($query, $db_conn);

$_SESSION["UFNAME"] = $fname;
$_SESSION["ULNAME"] = $lname;
$_SESSION["UEMAIL"] = $email;

// Create scratch profile over here!
// creating a faculty profile so type_id == 1
$type_id = 1;

$profile_query = "SELECT * FROM gen_profile_info WHERE owner_login_id = ".real_mysql_specialchars($uid, false)." and type_id=1";
$session_results = real_execute_query( $profile_query, $db_conn );
if( mysql_num_rows( $session_results ) > 0 )
{
	// scratch profile already exists, we should probably do an update
	// in the tables to reflect the new changes that are made (if any)
	$profile_query = "UPDATE gen_profile_info SET name=".real_mysql_specialchars($lname.", ".$fname, false)." WHERE owner_login_id=$uid";
	real_execute_query( $profile_query, $db_conn );

	$profile_query = "UPDATE ppl_general_info SET f_name=".real_mysql_specialchars($fname, false).", l_name=".real_mysql_specialchars($lname, false).", " . 
					"pri_designation=".real_mysql_specialchars($rank, false).", phone_no_1=".real_mysql_specialchars($phone, false)." WHERE login_id=".real_mysql_specialchars($uid, false); 
	real_execute_query( $profile_query, $db_conn );
}
else if (isset($_POST['autoprofile']))
{

if( $fname != "" && $lname !="" )
	{
		$faculty_sections = array( "1","2","3","4","5","6","7","8","10","11" );
		$profile_query = "INSERT INTO gen_profile_info ( type_id, name, owner_login_id, status ) VALUES ( " .
						real_mysql_specialchars($type_id, true) .
						", " . real_mysql_specialchars( $lname . ", " . $fname,	false ) .
						", " . real_mysql_specialchars($uid, false) .
						", 1 )"; 
	
		real_execute_query( $profile_query, $db_conn );
		$pid = mysql_insert_id( $db_conn );
		
		//$image_id = real_insert_image( $db_conn, $pid, 0, "imagefile", "images" );

		$profile_query = "INSERT INTO ppl_general_info ( pid, login_id, f_name, l_name, 
							pri_designation, phone_no_1) VALUES ( ".real_mysql_specialchars($pid, true).
							", " . real_mysql_specialchars($uid, false) .
							", " . real_mysql_specialchars( $fname, false ) .
							", " . real_mysql_specialchars( $lname, false ) .
							", " . real_mysql_specialchars( $rank, false ) .
							", " . real_mysql_specialchars( $phone, false ) .
							" )"; 
		real_execute_query( $profile_query, $db_conn );
	
		$section_query = "INSERT INTO gen_profile_section (pid, section_id) SELECT $pid, section_id FROM gen_section_types WHERE type_id = ".real_mysql_specialchars($type_id, true);
		real_execute_query( $section_query, $db_conn );
		
		if( $rank_changed == "1" || $pri_rank_changed == "1" )
		{	
			$query = "DELETE FROM gen_profile_hierarchy WHERE pid = ".real_mysql_specialchars($pid, true);
			real_execute_query( $query, $db_conn );
			$query = "INSERT INTO gen_profile_hierarchy (pid, hid) VALUES (".real_mysql_specialchars($pid, true).", ".real_mysql_specialchars($pri_hid, true).")";
			real_execute_query( $query, $db_conn );
			$hid_list = explode( "|", $hid );
			foreach( $hid_list as $curr_hid )
			{
				if( $curr_hid != "" )
				{
					$query = "INSERT INTO gen_profile_hierarchy (pid, hid) VALUES (".real_mysql_specialchars($pid, true).", ".real_mysql_specialchars($curr_hid, true).")";
					real_execute_query( $query, $db_conn );
				}
			}
		}
	}
	else
	{
		real_redirect( "createfaculty.php", "", $db_conn );
	}
}
real_redirect("researchspace.php", "view=$view", $db_conn);
?>
