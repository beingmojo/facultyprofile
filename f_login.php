<?php
include_once 'utils.php';
include_once 'util/ldap_util.php';

$uid = substr(real_unescape($_POST["uid"]), 0, 255);
$passwd = substr(real_unescape($_POST["passwd"]), 0, 255);

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$sessionid = rps_login($db_conn, $uid, $passwd);
error_log($sessionid, 3, "C:\\tmp\\php-errors.log");
if ($sessionid == "") {
    real_set_error($_err_session_error);
    real_redirect_onerror($_err_page, "", $db_conn);
}
$view = $_GET['view'];

// find if the user has already entered basic info.
$query = "SELECT fname, lname, email_id FROM gen_login_info WHERE login_id = " . real_mysql_specialchars($uid, false);
$results = real_execute_query($query, $db_conn);
//get user information from ldap
$info = rps_get_user_info_ldap($uid, $passwd, $db_conn);
rps_set_session_variables($db_conn, session_id(), $info[$rps_ldap_attribute_f_name], $info[$rps_ldap_attribute_l_name], $info[$rps_ldap_attribute_email]);
$_SESSION['USER_LDAP_INFO'] = $info;
// if the user has not entered basic info redirect him to f_info else to his profiles.
if (mysql_num_rows($results) == 0) {
    real_redirect("f_info.php", "view=$view", $db_conn);
}else {
    rps_set_last_login_datetime($db_conn, $uid);
    real_redirect("f_after_login.php", "view=$view", $db_conn);
}
function rps_login($db_conn, $uid, $passwd) {
    global $_ldap_server;
    global $_err_ldap_connect;
    global $_err_uid_null;
    global $_err_login;
    global $_err_page;

    session_start ();
    real_reset_error();
    if ($uid == "") {
        real_set_error($_err_uid_null);
        real_redirect_onerror($_err_page, "", $db_conn);
    }
    $ldapConn = ldap_connect($_ldap_server);
    if ($ldapConn) {
        //$uid = rps_get_ldap_rdn($uid);
        //Start FOR TEST////////////////////////////////////////////////////////////////
        $ldap_dn = $uid . "@" . $_ldap_server;
        //$ldap_dn = "fprofile-adpull@matrix.txstate.edu";
        //$passwd = "3RajukAg"; //old password , can ignore
        //$passwd="7tq876gf"; // new password (uncomment to remove pasword criteria
        //End FOR TEST//////////////////////////////////////////////////////////////////
        if (!($res = @ldap_bind($ldapConn, $ldap_dn, $passwd))) {
            real_set_error($_err_login);
            real_redirect_onerror($_err_page, "", $db_conn);
        }else {
            $old_sessid = session_id();
            session_regenerate_id();
            $new_sessid = session_id();
            session_id($old_sessid);
            session_destroy();

            $old_session = $_SESSION;
            session_id($new_sessid);
            session_start();
            $_SESSION = $old_session;

            $_SESSION['UID'] = $uid;
            $sessionid = session_id();
            $remoteip = $_SERVER['REMOTE_ADDR'];
            $log = real_login_session($db_conn, $uid, $sessionid, $remoteip);
            if ($log == false) {
                real_set_error($_err_login);
                real_redirect_onerror($_err_page, "", $db_conn);
            }else {
                return $sessionid;
            }
        }
    }else {
        real_set_error($_err_ldap_connect);
        real_redirect_onerror($_err_page, "", $db_conn);
    }
    return "";
}
function rps_set_session_variables($db_conn, $sessionid, $fname, $lname, $email) {
    $query = "UPDATE gen_login_session SET " .
        " fname = " . real_mysql_specialchars($fname, false) .
        ", lname = " . real_mysql_specialchars($lname, false) .
        ", email = " . real_mysql_specialchars($email, false) .
        " WHERE session_id = " . real_mysql_specialchars($sessionid, false);
    real_execute_query($query, $db_conn);
}
function rps_set_last_login_datetime($db_conn, $uid) {
    $query = "UPDATE gen_login_info SET last_datetime = NOW()" .
        " WHERE login_id = " . real_mysql_specialchars($uid, false);
    real_execute_query($query, $db_conn);
    //ADDED TO KEEP A RECORD OF WHEN USERS LOGIN
    $query = "INSERT INTO login_record(user_id) Values(" . real_mysql_specialchars($uid, false) . ")";
    real_execute_query($query, $db_conn);
}
?>
