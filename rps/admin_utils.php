<?php

/***************************************************************************************
function: real_admin_login_ldap
description: authenticates the user credentails using ldap and creates a session on success
params:
	$db_conn - database link
	$ldap_server - ldap server name
	$dn - ldap dn ( with oouidoo as the pattern to be replaces for uid )
	$uid - user login id
	$passwd - user password
returns: session id
on error: redirects to error page
****************************************************************************************/
function real_admin_login_ldap( $db_conn, $ldap_server, $dn, $uid, $passwd )
{
	global $_ldap_server;
	global $_ldap_login_dn;
	global $_err_ldap_connect;
	global $_err_uid_null;
	global $_err_login;
	global $_err_page;
	real_reset_error();

	if( $uid == "" )
	{
		real_set_error( $_err_uid_null );  
		real_redirect_onerror( $_err_page, "", $db_conn);
	}
	if( $ldap = ldap_connect($_ldap_server)) 
	{ 
		session_start();
		$old_sessid = session_id();
		session_regenerate_id();
		$new_sessid = session_id();
		session_id($old_sessid);
		session_destroy();
		
		$old_session = $_SESSION;
		session_id($new_sessid);
		session_start();
		$_SESSION = $old_session;
		
		$login_id = real_get_login_id_by_login_name_ldap( $db_conn, $uid );
		if($login_id == "")
		{
			exit();
			real_set_error( $_err_login );
			real_redirect_onerror( $_err_page, "", $db_conn);
		}
		$_SESSION['UID'] = $login_id;
		$_SESSION['UPASSWD'] = "";
		$sessionid = session_id();
		$remoteip = $_SERVER['REMOTE_ADDR'];
		$log = real_login_session( $db_conn, $login_id, $sessionid, $remoteip );
		if( $log == false )
		{
			real_set_error( $_err_login );
			real_redirect_onerror( $_err_page, "", $db_conn);
		}
		else
		{
			return $sessionid;
		}
	}
	else
	{
		real_set_error( $_err_ldap_connect );
		real_redirect_onerror( $_err_page, "", $db_conn);
	}
}

?>