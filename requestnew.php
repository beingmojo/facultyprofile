<?php
session_start();
include 'utils.php';
include 'imageutils.php';
require_once("inputfilter.php");

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$type = $_POST["profiletype"];
$user_id = $_SESSION["UID"];
//$is_admin = real_check_user_groupid( $db_conn, "admin" );
//$is_tech_admin = real_check_user_groupid( $db_conn, "tech_admin" );
$ipFilter = new InputFilter($_filter_tags, "", 1, 1, 1);

$requester_id = substr(real_unescape($_SESSION["UID"]), 0, 255);
$requester_fname = substr(real_unescape($_SESSION["UFNAME"]), 0, 50);
$requester_lname = substr(real_unescape($_SESSION["ULNAME"]), 0, 50);
$requester_email = substr(real_unescape($_SESSION["UEMAIL"]), 0, 50);

if ($type == "center") {
    $user_id = substr(real_unescape($_POST["ctr_general_info_login_id"]), 0, 255);
    $login_name = substr(real_unescape($_POST["ctr_general_info_login_name"]), 0, 255);

    $type_id = 2;

    $title = substr(real_unescape($_POST["ctr_general_info_name"]), 0, 255);
    $description = $ipFilter->process($_POST["ctr_general_info_description"]);

    if ($title != "" && $user_id != "") {

        $request_query = "INSERT INTO gen_profile_req ( owner_id,owner_name,profile_title,profile_desc,profile_type" .
            "requester_id,requester_fname,requester_lname,requester_email,request_date,approve_date,status )" .
            " VALUES ( " .
            real_mysql_specialchars($user_id, false) .
            ", " . real_mysql_specialchars(substr($login_name, 0, 255), false) .
            ", " . real_mysql_specialchars($title, false) .
            ", " . real_mysql_specialchars(substr($description, 0, 255), false) .
            ", '$type_id'" .
            ", " . real_mysql_specialchars(substr($requester_id, 0, 255), false) .
            ", " . real_mysql_specialchars(substr($requester_fname, 0, 255), false) .
            ", " . real_mysql_specialchars(substr($requester_lname, 0, 255), false) .
            ", " . real_mysql_specialchars(substr($requester_email, 0, 255), false) .
            ", NOW()" .
            ", 'NULL'" .
            ", '1'" .
            " )";
        echo $request_query;
        echo '<pre>';
        print_r($_POST);
        //real_execute_query( $request_query, $db_conn );
    }else {
        real_redirect("requestcenter.php", "", $db_conn);
    }
}


if ($type == "technology") {
    $user_id = substr(real_unescape($_POST["tech_general_info_login_id"]), 0, 255);
    $login_name = substr(real_unescape($_POST["ctr_general_info_login_name"]), 0, 255);

    $type_id = 3;

    $title = substr(real_unescape($_POST["tech_general_info_title"]), 0, 255);
    $description = $ipFilter->process($_POST["abstract"]);

    if ($title != "" && $user_id != "") {

        $request_query = "INSERT INTO gen_profile_req ( owner_id,owner_name,profile_title,profile_desc,profile_type" .
            "requester_id,requester_fname,requester_lname,requester_email,request_date,approve_date,status )" .
            " VALUES ( " .
            real_mysql_specialchars($user_id, false) .
            ", " . real_mysql_specialchars(substr($name, 0, 255), false) .
            ", " . real_mysql_specialchars(substr($description, 0, 255), false) .
            ", '$type_id'" .
            ", " . real_mysql_specialchars(substr($requester_id, 0, 255), false) .
            ", " . real_mysql_specialchars(substr($requester_fname, 0, 255), false) .
            ", " . real_mysql_specialchars(substr($requester_lname, 0, 255), false) .
            ", " . real_mysql_specialchars(substr($requester_email, 0, 255), false) .
            ", NOW()" .
            ", 'NULL'" .
            ", '1'" .
            " )";
        echo $request_query;
        //real_execute_query( $request_query, $db_conn );
    }else {
        real_redirect("requesttechnology.php", "", $db_conn);
    }
}
exit();
real_redirect("myprofiles.php", "", $db_conn);
?>