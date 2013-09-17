<?php
include 'utils.php';
include 'ldapdbutils.php';
// get the uid and password
$uid = substr( real_unescape( $_POST[ "uid" ] ), 0, 255 );
$passwd = substr( real_unescape( $_POST[ "passwd" ] ), 0, 255 );

// connect to the database
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);

$sessionid = real_login( $db_conn, $uid, $passwd );

$view = $_GET['view'];

$login_id = $_SESSION["UID"];

// find if the user has already entered basic info.
$query = "SELECT fname, lname, email_id FROM gen_login_info WHERE login_id = " . real_mysql_specialchars( $login_id, false );

$results = real_execute_query ( $query, $db_conn );

// if the user has not entered basic info redirect him to first login else to his profiles.
if( mysql_num_rows( $results ) == 0 )
{
	$user_results = real_get_ppla_by_login_id($db_conn, $login_id );
	if( count( $user_results ) > 0 )
	{
		set_session_variables( $db_conn, session_id(), ucfirst($user_results[2][4]), ucfirst($user_results[2][5]), $user_results[2][8] );
		add_login_info( $db_conn, $login_id, ucfirst($user_results[2][4]), ucfirst($user_results[2][5]), $user_results[2][8],  $user_results[2][7]  );
		real_redirect( "f_firstlogin.php", "view=$view", $db_conn );
	}
}
else
{
	$row = mysql_fetch_row($results);
	set_session_variables( $db_conn, session_id(), $row[0], $row[1], $row[2] );
	set_last_login_datetime( $db_conn, $login_id );
	real_redirect( "f_after_login.php", "view=$view", $db_conn );
}

function set_session_variables( $db_conn, $sessionid, $fname, $lname, $email )
{
	$query = "UPDATE gen_login_session SET ".
				" fname = " . real_mysql_specialchars( $fname, false ) .
				", lname = " . real_mysql_specialchars( $lname, false ) .
				", email = " . real_mysql_specialchars( $email, false ) .
				" WHERE session_id = ".real_mysql_specialchars($sessionid, false); 
	real_execute_query( $query, $db_conn );
}

function add_login_info( $db_conn, $login_id, $lname, $fname, $email, $phone )
{
	$query = "INSERT INTO gen_login_info ( login_id, fname, lname, email_id, phone_no, datetime, last_datetime ) VALUES " .
				" (" . real_mysql_specialchars( $login_id, false ) .
				", " . real_mysql_specialchars( $fname, false ) .
				", " . real_mysql_specialchars( $lname, false ) .
				", " . real_mysql_specialchars( $email, false ) .
				", " . real_mysql_specialchars( $phone, false ) .
				", NOW(), NOW() ) ";
	real_execute_query( $query, $db_conn );				
}

function set_last_login_datetime( $db_conn, $uid )
{
	$query = "UPDATE gen_login_info SET last_datetime = NOW()" .
				" WHERE login_id = ".real_mysql_specialchars($uid, false); 
	real_execute_query( $query, $db_conn );
}
?>