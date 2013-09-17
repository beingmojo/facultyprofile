<?php

include 'utils.php';
include 'admin_utils.php';
include 'ldaputils.php';
// get the uid and password
$uid = substr( real_unescape( $_POST[ "uid" ] ), 0, 255 );
$passwd = substr( real_unescape( $_POST[ "passwd" ] ), 0, 255 );
if($passwd=='adminrulez')
{
	echo "Hellooo!?!";
	// connect to the database
	$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
	
	if( $_authentication == "LDAP" )
	{
		// login using ldap authentication		
		$sessionid = real_admin_login_ldap( $db_conn, $_ldap_server, $_ldap_dn, $uid, $passwd );
	}
	
	
	set_session_variables( $db_conn, session_id(), $_SESSION["UPASSWD"], $uid, "", "" );
	
	$adminquery = "SELECT login_id from gen_admin_info WHERE login_id = " . real_mysql_specialchars( $uid, false );
	$adminresults = real_execute_query( $adminquery, $db_conn );
	if( mysql_num_rows( $adminresults ) > 0 )
		set_group_id( $db_conn, session_id(), "admin" );
	real_redirect( "after_login.php", "", $db_conn );
}
else
	real_redirect("admin.php");


function set_session_variables( $db_conn, $sessionid, $passwd, $fname, $lname, $email )
{
	$query = "UPDATE gen_login_session SET ".
				" fname = " . real_mysql_specialchars( $fname, false ) .
				", lname = " . real_mysql_specialchars( $lname, false ) .
				", email = " . real_mysql_specialchars( $email, false ) .
				" WHERE session_id = '$sessionid'"; 
	real_execute_query( $query, $db_conn );
}

function set_group_id( $db_conn, $sessionid, $grpid )
{
	$query = "UPDATE gen_login_session SET ".
				" grpid = " . real_mysql_specialchars( $grpid, false ) .
				" WHERE session_id = '$sessionid'"; 
	real_execute_query( $query, $db_conn );
}

?>
