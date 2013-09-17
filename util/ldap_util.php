<?php
include_once '../utils.php';

$rps_ldap_conn_url = "ldaps://matrix.txstate.edu"; //ldap connection url
$rps_ldap_search_dn = "ou=Txstate Users,dc=matrix,dc=txstate,dc=edu"; //distinguished name for ldap search 
$rps_ldap_filter_prefix = "(&(objectCategory=person)(sAMAccountName="; //.$uid."))"; //ldap search filter
$rps_ldap_attributes = array("cn", "displayname", "mail", "title",
    "department", "telephonenumber", "givenname", "sn",
    "physicaldeliveryofficename", "streetaddress", "l", "st",
    "postalcode", "facsimileTelephoneNumber"); //ldap search attributes
$rps_ldap_attribute_cn = "cn"; //ldap search attribute: common name / txstate net id
$rps_ldap_attribute_dname = "displayname"; //ldap search attribute: display name / full names
$rps_ldap_attribute_email = "mail"; //ldap search attribute: email address
$rps_ldap_attribute_title = "title"; //ldap search attribute: title
$rps_ldap_attribute_dept = "department"; //ldap search attribute: department
$rps_ldap_attribute_phone = "telephonenumber"; //ldap search attribute: telephone number
$rps_ldap_attribute_f_name = "givenname"; //ldap search attribute: given name / firstname
$rps_ldap_attribute_m_name = "midname"; //ldap search attribute: given name / firstname
$rps_ldap_attribute_l_name = "sn"; //ldap search attribute: surname / lastname
$rps_ldap_attribute_office = "physicaldeliveryofficename"; //ldap search attribute: office building and room number
$rps_ldap_attribute_street = "streetaddress"; //ldap search attribute: street address
$rps_ldap_attribute_city = "l"; //ldap search attribute: city
$rps_ldap_attribute_state = "st"; //ldap search attribute: state code
$rps_ldap_attribute_zip = "postalcode"; //ldap search attribute: postal (zip) code
$rps_ldap_attribute_fax = "facsimileTelephoneNumber";
//ldap search attribute: fax

/* Constructs and returns the rdn based on the given $uid.
 *  
 * @return - string - $uid . "@matrix.txstate.edu" */
function rps_get_ldap_rdn($userID) {
    return $userID . "@matrix.txstate.edu";
}
function rps_get_user_info_ldap($userID, $userPass, $db_conn) {
    global $_err_ldap_connect;
    global $_err_uid_null;
    global $_err_login;
    global $_err_page;
    global $rps_ldap_conn_url;
    global $rps_ldap_search_dn;
    global $rps_ldap_filter_prefix;
    global $rps_ldap_attributes;
    global $rps_ldap_attribute_cn;
    global $rps_ldap_attribute_dname;
    global $rps_ldap_attribute_email;
    global $rps_ldap_attribute_title;
    global $rps_ldap_attribute_dept;
    global $rps_ldap_attribute_phone;
    global $rps_ldap_attribute_f_name;
    global $rps_ldap_attribute_m_name;
    global $rps_ldap_attribute_l_name;
    global $rps_ldap_attribute_office;
    global $rps_ldap_attribute_street;
    global $rps_ldap_attribute_city;
    global $rps_ldap_attribute_state;
    global $rps_ldap_attribute_zip;
    global $rps_ldap_attribute_fax;

    if ($userID == "") {
        real_set_error($_err_uid_null);
        real_redirect_onerror($_err_page, "", $db_conn);
    }
    $conn = ldap_connect($rps_ldap_conn_url); //connect to the LDAP server
    if ($conn) {
        //bind to the LDAP server
//Start FOR TEST////////////////////////////////////////////////////////////////
    //$bind = ldap_bind($conn, rps_get_ldap_rdn($userID), $userPass);
     //$bind = ldap_bind($conn, "fprofile-adpull@matrix.txstate.edu", "3RajukAg"); //old password, can ignore
    $bind = ldap_bind($conn, "fprofile-adpull@matrix.txstate.edu", "7tq876gf"); // new password , uncomment to remove password criteria
//End FOR TEST//////////////////////////////////////////////////////////////////
        //Querying..............................................................
        if ($bind) {
            $filter = $rps_ldap_filter_prefix . "$userID))";
            $search = ldap_search($conn, $rps_ldap_search_dn, $filter, $rps_ldap_attributes);
            if ($search) {
                $entries = ldap_get_entries($conn, $search);
                if ($entries) {
                    $f_name = trim($entries[0][$rps_ldap_attribute_f_name][0]);
                    $arr_name = explode(" ", $f_name, 2);
                    if (count($arr_name) <= 1) {
                        $first_name = $f_name;
                    }else {
                        $first_name = $arr_name[0];
                        $middle_name = $arr_name[1];
                    }
                    return array($rps_ldap_attribute_cn => $entries[0][$rps_ldap_attribute_cn][0],
                        $rps_ldap_attribute_dname => $entries[0][$rps_ldap_attribute_dname][0],
                        $rps_ldap_attribute_email => $entries[0][$rps_ldap_attribute_email][0],
                        $rps_ldap_attribute_title => $entries[0][$rps_ldap_attribute_title][0],
                        $rps_ldap_attribute_dept => $entries[0][$rps_ldap_attribute_dept][0],
                        $rps_ldap_attribute_phone => $entries[0][$rps_ldap_attribute_phone][0],
                        $rps_ldap_attribute_f_name => $first_name,
                        $rps_ldap_attribute_m_name => $middle_name,
                        $rps_ldap_attribute_l_name => $entries[0][$rps_ldap_attribute_l_name][0],
                        $rps_ldap_attribute_office => $entries[0][$rps_ldap_attribute_office][0],
                        $rps_ldap_attribute_street => $entries[0][$rps_ldap_attribute_street][0],
                        $rps_ldap_attribute_city => $entries[0][$rps_ldap_attribute_city][0],
                        $rps_ldap_attribute_state => $entries[0][$rps_ldap_attribute_state][0],
                        $rps_ldap_attribute_zip => $entries[0][$rps_ldap_attribute_zip][0],
                        $rps_ldap_attribute_fax => $entries[0][$rps_ldap_attribute_fax][0]);
                }else {
                    real_set_error($_err_ldap);
                    real_redirect_onerror($_err_page, "", $db_conn);
                }
            }else {
                real_set_error($_err_ldap);
                real_redirect_onerror($_err_page, "", $db_conn);
            }
        }else {
            real_set_error($_err_login);
            real_redirect_onerror($_err_page, "", $db_conn);
        }
    }else {
        real_set_error($_err_ldap_connect);
        real_redirect_onerror($_err_page, "", $db_conn);
    }
}
?>
