<?php
include_once 'Encoding.php';
include_once 'strip_html_tags.php';

$_db_server = "localhost"; //database server name
$_db_name = "newprofile"; //database name
$_db_username = "ys11"; //databsae user name
$_db_password = "profilesystempass"; //database password
$_home = ""; //home directory of the web site
$_home_real_path = "/var/www/html/facultyprofile"; //the real (physical) path, on server, of the root directory of the application
$_home_images = "/var/www/html/facultyprofile/images"; //the real (physical) path, on server, of the images directory of the application
$_ldap_server = "matrix.txstate.edu"; //ldap server name
$_ldap_dn = "uid=oouidoo, dc=matrix, dc=txstate, dc=edu"; //ldap dn - oouidoo will be replaced by uid
$_ldap_global_dn = "dc=matrix,dc=txstate,dc=edu";
$_ldap_global_passwd = "7tq876gf"; //your ldap password
$_ldap_search_dn = "cn=People, dc=matrix,dc=txstate, dc=edu";
$_ldap_search_dn_ppl = "cn=People, dc=matrix,dc=txstate, dc=edu";
$_ldap_search_dn_acct = "cn=matrix, dc=matrix,dc=txstate, dc=edu";
$_ldap_search_dn_dept = "cn=Departments, dc=matrix,dc=txstate, dc=edu";
$_ldap_search_filter = "utaAccountName=oouidoo";
$_ldap_attr_lname = "sn";
$_ldap_attr_fname = "givenname";
$_ldap_attr_email = "mail";
$_index_page = "index.php"; //fully qualified url to index page to be redirected after logoff
$_err_page = $_home . "/errorpage.php"; //error page to be redirected after any error
$_session_time_out = 20; //session time out in minutes
$_err_code = -1; //variable to hold the recent error code
$_err_msg = "";
$_err_info = "";
// error codes
$_err_fatal = 0;
$_err_ldap_connect = 1;
$_err_db_connect = 2;
$_err_db_select = 3;
$_err_uid_null = 4;
$_err_uid_not_found = 5;
$_err_login = 6;
$_err_session = 7;
$_err_page_not_found = 8;
$_err_unauthorized = 9;
$_err_bs = 10;
$_err_blocked_account = 11;
$_err_session_error = 12;
$_err_ldap = 13;
$contact_admin = " If you like to report this to the administrator <a href='https://{$_SERVER['HTTP_HOST']}{$_home}/feedback.php'>click here</a>.";
$go_back = " <a href='javascript:history.back()'>Click here</a> to go back.";
$go_home = " <a href='$_index_page'>Click here</a> to login again.";
// error messages
$_errors[$_err_fatal] = "Fatal Error" . $contact_admin;
$_errors[$_err_ldap_connect] = "The LDAP server could not be connected." . $contact_admin;
$_errors[$_err_db_connect] = "The database server could not be connected." . $contact_admin;
$_errors[$_err_db_select] = "The organization database could not be found." . $contact_admin;
$_errors[$_err_uid_null] = "The user id should not be empty." . $go_back;
$_errors[$_err_uid_not_found] = "The user id could not be found in the system." . $go_back;
$_errors[$_err_login] = "Invalid user id or password." . $go_home;
$_errors[$_err_session] = "The current session has expired." . $go_home;
$_errors[$_err_unauthorized] = "You are unauthorized to view this page." . $go_home;
$_errors[$_err_page_not_found] = "The requested page is not found." . $go_back;
$_errors[$_err_bs] = "We encountered an error while auto saving bluesheet. Please notify erahelpdesk@uta.edu and we will fix this for you.";
$_errors[$_err_blocked_account] = "Sorry, your account has been blocked due to too many unsuccessful login attempts. Please try again one hour AFTER the first time you received this message.";
$_errors[$_err_session_error] = "Session error." . $contact_admin;
$_errors[$_err_ldap] = "LDAP error." . $contact_admin;
$_filter_tags = array("script");
$_login_id = "Net ID";
$_browse_search_rows_per_page = 10;

/* * *************************************************************************************
  function: real_filter
  description: converts input to UTF-8 encoding and filters html tags and entities
  params:
  $text - string to be changed
  returns: UTF-8 string without html tags or entities
 * created by Jose
 * ************************************************************************************** */

function real_filter($text){
    $text = Encoding::toUTF8($text);
    $text = strip_html_tags($text);
    $text = html_entity_decode($text, ENT_QUOTES, "UTF-8");
    return $text;
}

/* * *************************************************************************************
  function: real_mysql_specialchars
  description: prepends \ to ', ", \, and other mysql special characters
  params:
  $value - string to be changed
  $bnumberic - true if the $value is numeric
  returns: string with escaped mysql special characters
 * ************************************************************************************** */
function real_mysql_specialchars($value, $bnumeric) {
    if (get_magic_quotes_gpc ()) {
        $value = stripslashes($value);
    }
    $value = real_filter($value);
    $value1 = mysql_real_escape_string($value);
    if ($bnumeric == false) {
        $value1 = "'" . trim($value1) . "'";
    }else {
        if (is_numeric($value1) == false) {
            $value1 = 0;
        }
    }
    return $value1;
}
/* * *************************************************************************************
  function: real_rte_specialchars
  description: escapes single quotes, double quotes, returns and line feeds
  params:
  $value - string to be changed
  returns: string with escaped mysql special characters
 * ************************************************************************************** */
function real_rte_specialchars($value) {
    $tmpString = $value;

    //convert all types of single quotes
    $tmpString = str_replace(chr(145), chr(39), $tmpString);
    $tmpString = str_replace(chr(146), chr(39), $tmpString);
    $tmpString = str_replace("'", "&#39;", $tmpString);

    //convert all types of double quotes
    $tmpString = str_replace(chr(147), chr(34), $tmpString);
    $tmpString = str_replace(chr(148), chr(34), $tmpString);

    //replace carriage returns & line feeds
    $tmpString = str_replace(chr(10), " ", $tmpString);
    $tmpString = str_replace(chr(13), " ", $tmpString);


    return $tmpString;
}
/* * *************************************************************************************
  function: real_unescape
  description: strips the slashes prepended to ', ", and \
  params:	$value - string to be changed
  returns: string with unescaped special characters
 * ************************************************************************************** */
function real_unescape($value) {
    if (get_magic_quotes_gpc ()) {
        $value = stripslashes($value);
    }
    return $value;
}
/* * *************************************************************************************
  function: real_log_error
  description: logs the error in the gen_error_log table.
  params:
  $db_conn - database link
  $message - error message maximum of 255 characters
  $info - additional information like query
  returns: nothing
  on error: redirects to the error page
 * ************************************************************************************** */
function real_log_error($db_conn, $message, $info) {
    global $_err_msg, $_err_info;
    $err_query = "INSERT INTO gen_error_log ( message, info, datetime, login_id ) VALUES " .
        " ( " . real_mysql_specialchars(substr($message, 0, 255), false) .
        ", " . real_mysql_specialchars($info, false) .
        ", NOW(), '" . $_SESSION['UID'] . "' )";
    mysql_query($err_query, $db_conn);
    $_err_msg = $message;
    $_err_info = $info;
}
/* * *************************************************************************************
  function : real_check_error
  description: checks for error in the recent function call
  params: nothing
  returns: true if error
 * ************************************************************************************** */
function real_check_error() {
    //global $_err_code;
    if ($_SESSION['err_code'] == -1) return false;
    else return true;
}
/* * *************************************************************************************
  function: real_error
  description: gets the error message for the specified error code
  params:	$err_code - error code for the error
  returns: string corresponding to the error code
 * ************************************************************************************** */
function real_error($err_code) {
    global $_errors;
    return $_errors[$err_code];
}
/* * *************************************************************************************
  function: real_set_error
  description: sets the error code for the recent error
  params: $err_code - error code of the recent error
  returns: nothing
 * ************************************************************************************** */
function real_set_error($err_code) {
//	global $_err_code;
//	$_err_code = $err_code;
    $_SESSION['err_code'] = $err_code;
}
/* * *************************************************************************************
  function: real_get_error
  description: gets the error code for the recent error and sets default error if not set
  params: none
  returns: nothing
 * ************************************************************************************** */
function real_get_error() {
    global $_err_fatal;

    if (!isset($_SESSION['err_code'])) {
        real_set_error($_err_fatal);
    }

    return $_SESSION['err_code'];
}
/* * *************************************************************************************
  function: real_reset_error
  description: resets the error code to -1
  params: nothing
  returns: nothing
 * ************************************************************************************** */
function real_reset_error() {
//	global $_err_code;
//	$_err_code = -1;
    $_SESSION['err_code'] = -1;
}
/* * *************************************************************************************
  function: real_db_connect
  description: connects the specified database
  params:
  $dbserver - databse server name
  $dbusername - database user name
  $dbpassword - database password
  $dbname - database name
  returns: database link
  on error: redirects to the error page
 * ************************************************************************************** */
function real_db_connect($dbserver, $dbusername, $dbpassword, $dbname) {
    global $_err_db_connect;
    global $_err_page;
    real_reset_error();
    $db_conn = mysql_connect($dbserver, $dbusername, $dbpassword);
    if (!$db_conn) {
        real_set_error($_err_db_connect);
        real_redirect_onerror($_err_page, "", $db_conn);
    }else {
        mysql_query("SET NAMES 'utf8'",$db_conn);   //added to make connection's charset utf8;
        $db_select = mysql_select_db($dbname, $db_conn);
        if (!$db_select) {
            real_set_error($_err_db_connect);
            real_redirect_onerror($_err_page, "", $db_conn);
        }
    }
    return $db_conn;
}
/* * *************************************************************************************
  function: real_execute_query
  description: executes the specified query with the specified link
  params:
  $query - query to be executed
  $db_conn - database link
  returns: results of the query
  on error: logs the error message and redirects to the error page
 * ************************************************************************************** */
function real_execute_query($query, $db_conn) {
    global $_err_fatal;
    global $_err_page;
    real_reset_error();
    $result = mysql_query($query, $db_conn);
    $error_msg = mysql_error($db_conn);
    if ($error_msg != "") {
        real_log_error($db_conn, $error_msg, $query);
        real_set_error($_err_fatal);
        real_redirect_onerror($_err_page, "", $db_conn);
    }
    return $result;
}
function real_execute_bs_query($query, $db_conn) {
    global $_err_fatal;
    global $_err_page;
    real_reset_error();
    $result = mysql_query($query, $db_conn);
    $error_msg = mysql_error($db_conn);
    if ($error_msg != "") {
        real_log_error($db_conn, $error_msg, $query);
        real_set_error($_err_bs);
        real_redirect_onerror($_err_page, "", $db_conn);
    }
    return $result;
}
/* * *************************************************************************************
  function: real_prune_old_sessions
  description: deletes all old sessions which are older than $_session_time_out value
  params: $db_conn - database link
  returns: nothing
  on error: redirects to the error page
 * ************************************************************************************** */
function real_prune_old_sessions($db_conn) {
    global $_session_time_out;
    real_reset_error();
    $query = "DELETE FROM gen_login_session WHERE ADDDATE( datetime, INTERVAL $_session_time_out MINUTE ) < NOW()";
    $result = real_execute_query($query, $db_conn);
}
/* * *************************************************************************************
  function: real_check_valid_session
  description: checks if the specified session is valid and updates the timestamp if valid
  params:
  $db_conn - database link
  $uid - user login id
  $sessionid - session id
  $remoteip - ipaddress of the user
  returns: nothing
  on error: redirects to the error page even if the session is invalid
 * ************************************************************************************** */
function real_check_valid_session($db_conn, $uid, $sessionid, $remoteip) {
    global $_err_session;
    global $_err_page;
    real_reset_error();
    real_prune_old_sessions($db_conn);
    $query = " SELECT session_id, remote_ip, datetime FROM gen_login_session" .
        " WHERE login_id = " . real_mysql_specialchars($uid, false) .
        " AND session_id = " . real_mysql_specialchars($sessionid, false) .
        " AND remote_ip = " . real_mysql_specialchars($remoteip, false);
    $result = real_execute_query($query, $db_conn);
    if (mysql_num_rows($result) == 0) {
        real_set_error($_err_session);
//		session_destroy();
        real_redirect_onerror($_err_page, "", $db_conn);
    }else {
        $query = " UPDATE gen_login_session SET datetime = NOW() " .
            " WHERE login_id = " . real_mysql_specialchars($uid, false) .
            " AND session_id = " . real_mysql_specialchars($sessionid, false) .
            " AND remote_ip = " . real_mysql_specialchars($remoteip, false);
        $result = real_execute_query($query, $db_conn);
    }
}
/* * *************************************************************************************
  function: real_update_valid_session
  description: updates the session timestamp if the specified session is valid
  params:
  $db_conn - database link
  $uid - user login id
  $sessionid - session id
  $remoteip - ipaddress of the user
  returns: nothing
  on error: redirects to the error page even if the session is invalid
 * ************************************************************************************** */
function real_update_valid_session($db_conn, $uid, $sessionid, $remoteip) {
    global $_err_session;
    global $_err_page;
    real_reset_error();
    real_prune_old_sessions($db_conn);
    $query = " SELECT session_id, remote_ip, datetime FROM gen_login_session" .
        " WHERE login_id = " . real_mysql_specialchars($uid, false) .
        " AND session_id = " . real_mysql_specialchars($sessionid, false) .
        " AND remote_ip = " . real_mysql_specialchars($remoteip, false);

    $result = real_execute_query($query, $db_conn);
    if (mysql_num_rows($result) > 0) {
        $query = " UPDATE gen_login_session SET datetime = NOW() " .
            " WHERE login_id = " . real_mysql_specialchars($uid, false) .
            " AND session_id = " . real_mysql_specialchars($sessionid, false) .
            " AND remote_ip = " . real_mysql_specialchars($remoteip, false);
        $result = real_execute_query($query, $db_conn);
    }
}
/* * *************************************************************************************
  function: real_check_session
  description: checks if the user has a session entry
  params:
  $db_conn - database link
  $uid - user login id
  returns: true if the user has an entry in the gen_login_session table
 * ************************************************************************************** */
function real_check_session($db_conn, $uid) {
    real_reset_error();
    $query = " SELECT session_id, remote_ip, datetime FROM gen_login_session" .
        " WHERE login_id = " . real_mysql_specialchars($uid, false);

    $result = real_execute_query($query, $db_conn);
    if (mysql_num_rows($result) > 0) return true;
    else return false;
}
/* * *************************************************************************************
  function: real_login_session
  description: logs the session info in gen_login_session table during login. updates the
  existing session (relogin before the current session expires or logoff)
  or adds a new session
  params:
  $db_conn - database link
  $uid - user login id
  $sessionid - current session id
  $remoteip = remote ip address
  returns: true
  on error : redirects to error page
 * ************************************************************************************** */
function real_login_session($db_conn, $uid, $sessionid, $remoteip) {
    $query = "";
    real_reset_error();
    $exists = real_check_session($db_conn, $uid);
    if ($exists == true) {
        $query = "UPDATE gen_login_session SET" .
            " session_id = " . real_mysql_specialchars($sessionid, false) .
            ", remote_ip = " . real_mysql_specialchars($remoteip, false) .
            ", datetime = NOW() " .
            " WHERE login_id = " . real_mysql_specialchars($uid, false);
    }else {
        $query = "INSERT INTO gen_login_session (login_id, session_id, remote_ip, datetime) VALUES" .
            " ( " . real_mysql_specialchars($uid, false) .
            ", " . real_mysql_specialchars($sessionid, false) .
            ", " . real_mysql_specialchars($remoteip, false) .
            ", NOW() )";
    }
    $result = real_execute_query($query, $db_conn);
    if (mysql_affected_rows($db_conn) > 0) return true;
    else return false;
}
/* * *************************************************************************************
  function: real_logoff_session
  description: deletes the session for the specified login id
  params:
  $db_conn - database link
  $uid - user login id
  returns: nothing
  on error: redirects to error page
 * ************************************************************************************** */
function real_logoff_session($db_conn, $uid) {
    real_reset_error();
    $query = "DELETE FROM gen_login_session WHERE login_id = " . real_mysql_specialchars($uid, false);
    $result = real_execute_query($query, $db_conn);
    session_destroy();
}
/* * *************************************************************************************
  function: real_redirect
  description: redirects to the specififed page
  params:
  $page - page to be redirected
  $querystring - querystring to be appended
  $db_conn - database link to be closed
  returns: nothing
 * ************************************************************************************** */
function real_redirect($page, $querystring, $db_conn) {

    $redirect = "Location: $page";
    if ($querystring != "") {
        $redirect = "$redirect?$querystring";
    }
    header($redirect);
    if ($db_conn != NULL) mysql_close($db_conn);
    exit();
}
/* * *************************************************************************************
  function: real_redirect_onerror
  description: redirects to the specified page with the error code
  params:
  $page - page to be redirected
  $querystring - query string to be appended
  $db_conn - database link to be closed
  returns: nothing
 * ************************************************************************************** */
function real_redirect_onerror($page, $querystring, $db_conn) {
    //global $_err_code;
    $redirect = "Location: $page?$querystring";
    header($redirect);
    if ($db_conn != NULL) mysql_close($db_conn);
    exit();
}
/* * *************************************************************************************
  function: real_can_user_edit
  description: checks whether the logged in user has edit permissions for the profile
  params:
  $db_conn - database link
  $pid - profile id
  returns: true if the user has edit rights, else false
  on error: logs the error message and redirects to the error page
 * ************************************************************************************** */
function real_can_user_edit($db_conn, $pid) {

    if ($_SESSION["UID"] == "") return false;
    if (real_check_user_groupid($db_conn, "admin")) return true;

    $profile_exists_query = "SELECT owner_login_id, user1_login_id, user2_login_id, type_id FROM gen_profile_info WHERE pid = " . real_mysql_specialchars($pid, true);
    $profile_exists_results = real_execute_query($profile_exists_query, $db_conn);
    if (mysql_num_rows($profile_exists_results) > 0) {
        $rows = mysql_fetch_row($profile_exists_results);
        if ($rows[3] == 3 && real_check_user_groupid($db_conn, "tech_admin")) {
            return true;
        }
        if (strcasecmp($rows[0], $_SESSION["UID"]) == 0 ||
            strcasecmp($rows[1], $_SESSION["UID"]) == 0 ||
            strcasecmp($rows[2], $_SESSION["UID"]) == 0) {
            return true;
        }
    }
    return false;
}
/* * *************************************************************************************
  function: real_check_user_groupid
  description: checks whether the logged in user belongs to the specified group
  params:
  $db_conn - database link
  $grpid - group id
  returns: true if the user belongs to the specified group, else false
  on error: logs the error message and redirects to the error page
 * ************************************************************************************** */
function real_check_user_groupid($db_conn, $grpid) {
    if ($_SESSION["UID"] == "") return false;
    $grpid_query = "SELECT login_id FROM gen_admin_info WHERE type = " . real_mysql_specialchars($grpid, false) . " AND login_id = " . real_mysql_specialchars($_SESSION["UID"], false);
    $grpid_results = real_execute_query($grpid_query, $db_conn);
    if (mysql_num_rows($grpid_results) > 0) {
        return true;
    }else {
        return false;
    }
}
/* * *************************************************************************************
  function: real_update_last_modified_timestamp
  description: checks whether the logged in user belongs to the specified group
  params:
  $db_conn - database link
  $pid - profile id
  returns: updates the last modified time stamp and the login id of the user
  on error: logs the error message and redirects to the error page
 * ************************************************************************************** */
function real_update_last_modified_timestamp($db_conn, $pid) {
    $user_query = "SELECT owner_login_id, user1_login_id, user2_login_id, type_id FROM gen_profile_info WHERE pid = " . real_mysql_specialchars($pid, true);
    $user_results = real_execute_query($user_query, $db_conn);
    $user_rows = mysql_fetch_array($user_results);
    $user_id = $_SESSION["UID"];
    $field = $user_id == $user_rows[2] ? "user2_datetime" : "";
    $field = $user_id == $user_rows[1] ? "user1_datetime" : "";
    $field = $user_id == $user_rows[0] ? "owner_datetime" : "";
    if ($field == "" && ( real_check_user_groupid($db_conn, "admin") || ( real_check_user_groupid($db_conn, "tech_admin") && $user_rows[3] == 3 ) )) $field = "admin_datetime";
    if ($field != "") {
        $update_query = "UPDATE gen_profile_info SET last_modifier = " . real_mysql_specialchars($user_id, false) . ", " . $field . " = NOW() WHERE pid = " . real_mysql_specialchars($pid, true);
        $update_results = real_execute_query($update_query, $db_conn);
    }
}
function real_check_dept_admin($db_conn) {
    $query = "SELECT * from gen_dept_admin where loginid = '" . $_SESSION['UID'] . "'";
    //echo $query;
    //exit;
    //$results = mysql_query($query, $db_conn) or die("0 - " . mysql_error());
    $results = real_execute_query($query, $db_conn);
    if (mysql_num_rows($results) > 0) {
        if ($rows = mysql_fetch_array($results)) {
            return $rows["hid"];
        }
    }
    return false;
}
function isOGCSAdmin($db_conn, $l_id) {
    $query = "SELECT * from gen_admin_info where type='ogcs_admin' AND login_id = '" . $l_id . "'";
    //$results = mysql_query($query, $db_conn) or die("0 - " . mysql_error());
    $results = real_execute_query($query, $db_conn);
    if (mysql_num_rows($results) > 0) {
        return true;
    }
    return false;
}
function isOGCSSuperAdmin($l_id) {
    if (($l_id == "000000010")/* VP Research */ || ($l_id == "000000011") /* OGCS Director */) {
        return true;
    }
    return false;
}
function real_validate_url($url) {

    $urlcomponents = parse_url($url);
    if ($urlcomponents['scheme'] == "" && $url != "" && $urlcomponents['domain'] != "") return "http://" . $url;
    else if ($urlcomponents['scheme'] != "http" || $urlcomponents['domain'] == "") return "";
    else return $url;
}
function rps_check_has_info($uid, $db_conn) {
    // find if the user has already entered basic info.
    $query = "SELECT fname, lname, email_id FROM gen_login_info WHERE login_id = " . real_mysql_specialchars($uid, false);
    $results = real_execute_query($query, $db_conn);
    // if the user has not entered basic info redirect him to f_info else to his profiles.
    if (mysql_num_rows($results) == 0) {
        real_redirect("f_info.php", "", $db_conn);
    }
}
?>
