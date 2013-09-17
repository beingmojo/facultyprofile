<?php
session_start();

include_once 'utils.php';
include_once 'imageutils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$view = $_GET['view'];
$uid = real_unescape($_SESSION['UID']);
$lname = substr(real_unescape($_POST["lname"]), 0, 255);
$fname = substr(real_unescape($_POST["fname"]), 0, 255);
$mname = substr(real_unescape($_POST["mname"]), 0, 255);
$email = substr(real_unescape($_POST["email"]), 0, 255);
$phone = substr(real_unescape($_POST["phone"]), 0, 32);
$title = substr(real_unescape($_POST["title"]), 0, 255);
$dept = substr(real_unescape($_POST["dept"]), 0, 255);
$rankdept = substr(real_unescape($_POST["rankdept"]), 0, 255);
$fax = substr(real_unescape($_POST["fax"]), 0, 32);
$office = substr(real_unescape($_POST["office"]), 0, 255);
$street = substr(real_unescape($_POST["street"]), 0, 255);
$city = substr(real_unescape($_POST["city"]), 0, 32);
$state = substr(real_unescape($_POST["state"]), 0, 255);
$zip = substr(real_unescape($_POST["zip"]), 0, 16);
$website = substr(real_unescape($_POST["website"]), 0, 255);
$website = trim($website);
$keywords = substr(real_unescape($_POST["keywords"]), 0, 255);
$keywords = trim($keywords);
$_SESSION["UFNAME"] = $fname;
$_SESSION["ULNAME"] = $lname;
$_SESSION["UEMAIL"] = $email;
$type_id = 1;
error_log($keywords, 3, "C:\\tmp\\php-errors.log");
$r_int = $_POST["r_int"];
$r_int = trim($r_int);

//process Curriculum Vitae file
if (is_uploaded_file($_FILES["c_v"]["tmp_name"])) {
    //get details of Curriculum Vitae file
    $cvFileName = $_FILES['c_v']['name'];
    $cvTmpName = $_FILES['c_v']['tmp_name'];
    $cvFileSize = $_FILES['c_v']['size'];
    $cvFileType = $_FILES['c_v']['type'];
    //get content of Curriculum Vitae file
    $fp = fopen($cvTmpName, 'r'); //fopen -- file open, r -- read flag
    $c_v = fread($fp, filesize($cvTmpName)); //fread -file read
    fclose($fp); //fclose -- file close
    if (!get_magic_quotes_gpc()) {
        $cvFileName = addslashes($cvFileName); //escape the file's name
        $c_v = addslashes($c_v); //escape the file's content
    }
}
//process Publications file
if (is_uploaded_file($_FILES["publc"]["tmp_name"])) {
    //get details of Publications file
    $pubcFileName = $_FILES['publc']['name'];
    $pubcTmpName = $_FILES['publc']['tmp_name'];
    $pubcFileSize = $_FILES['publc']['size'];
    $pubcFileType = $_FILES['publc']['type'];
    //get content of Publications file
    $fp = fopen($pubcTmpName, 'r'); //fopen -- file open, r -- read flag
    $publc = fread($fp, filesize($pubcTmpName)); //fread -file read
    fclose($fp); //fclose -- file close
    if (!get_magic_quotes_gpc()) {
        $pubcFileName = addslashes($pubcFileName); //escape the file's name
        $publc = addslashes($publc); //escape the file's content
    }
}
//process Funding History file
if (is_uploaded_file($_FILES["f_hist"]["tmp_name"])) {
    //get details of Funding History file
    $f_histFileName = $_FILES['f_hist']['name'];
    $f_histTmpName = $_FILES['f_hist']['tmp_name'];
    $f_histFileSize = $_FILES['f_hist']['size'];
    $f_histFileType = $_FILES['f_hist']['type'];
    //get content of Funding History file
    $fp = fopen($f_histTmpName, 'r'); //fopen -- file open, r -- read flag
    $f_hist = fread($fp, filesize($f_histTmpName)); //fread -file read
    fclose($fp); //fclose -- file close
    if (!get_magic_quotes_gpc()) {
        $f_histFileName = addslashes($f_histFileName); //escape the file's name
        $f_hist = addslashes($f_hist); //escape the file's content
    }
}
//process Patents file
if (is_uploaded_file($_FILES["patents"]["tmp_name"])) {
    //get details of Patents file
    $patentsFileName = $_FILES['patents']['name'];
    $patentsTmpName = $_FILES['patents']['tmp_name'];
    $patentsFileSize = $_FILES['patents']['size'];
    $patentsFileType = $_FILES['patents']['type'];
    //get content of Patents file
    $fp = fopen($patentsTmpName, 'r'); //fopen -- file open, r -- read flag
    $patents = fread($fp, filesize($patentsTmpName)); //fread -file read
    fclose($fp); //fclose -- file close
    if (!get_magic_quotes_gpc()) {
        $patentsFileName = addslashes($patentsFileName); //escape the file's name
        $patents = addslashes($patents); //escape the file's content
    }
}

//insert into or update: gen_profile_info, ppl_general_info, gen_profile_section, gen_profile_hierarchy, txst_fac_profl, db_user_info, gen_image_info
$query = "SELECT pid FROM gen_profile_info WHERE owner_login_id = " . real_mysql_specialchars($uid, false) . " and type_id = " . $type_id;
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) { //user already has info in DB, do updates
    $pid = mysql_result($result, 0);
    $query = "SELECT image_id from gen_image_info WHERE pid = " . $pid;
    $result = real_execute_query($query, $db_conn);
    if (mysql_num_rows($result) > 0) {
        $image_id = mysql_result($result, 0);
    }
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
        echo "yes";
        real_delete_image($db_conn, $pid, 0, $image_id, $_home_images);
        $image_id = real_insert_image($db_conn, $pid, 0, "image", $_home_images);
    }
    $query = "UPDATE ppl_general_info SET title = " . real_mysql_specialchars($title, false) . ",
        f_name = " . real_mysql_specialchars($fname, false) . ",
        m_name = " . real_mysql_specialchars($mname, false) . ",
        l_name = " . real_mysql_specialchars($lname, false) . ",
        pri_designation = " . real_mysql_specialchars($rankdept, false) . ",
        designation = '',
        email_id = " . real_mysql_specialchars($email, false) . ",
        status_email_id = " . real_mysql_specialchars(0, true) . ",
        phone_no_1 = " . real_mysql_specialchars($phone, false) . ",
        status_phone_no_1 = " . real_mysql_specialchars(0, true) . ",
        phone_no_2 = '',
        status_phone_no_2 = " . real_mysql_specialchars(0, true) . ",
        fax_no = " . real_mysql_specialchars($fax, false) . ",
        status_fax_no = " . real_mysql_specialchars(0, true) . ",
        cell_no = '',
        status_cell_no = " . real_mysql_specialchars(0, true) . ",
        url_name_1 = " . real_mysql_specialchars($uid . "-website", false) . ",";
    if ($website != "") {
        $query = $query . "url_1 = " . real_mysql_specialchars($website, false) . ",";
    }
    $query = $query . "url_name_2 = '',
        url_2 = '',
        url_name_3 = '',
        url_3 = '',
        address_1 = " . real_mysql_specialchars($street, false) . ",
        address_2 = '',
        city = " . real_mysql_specialchars($city, false) . ",
        state = " . real_mysql_specialchars($state, false) . ",
        zipcode = " . real_mysql_specialchars($zip, false) . ",
        country = 'USA',
        status_address = " . real_mysql_specialchars(0, true) . ",
        mailbox = '',
        office_location = " . real_mysql_specialchars($office, false) . ",
        room_no = '',
        status_mail_address = " . real_mysql_specialchars(0, true) . ",
        pri_hid = " . real_mysql_specialchars(16, true) . ",
        hid = '',
        image_id = " . real_mysql_specialchars($image_id, false) . " ";
    if ($keywords != "") {
        $query = $query . ", keywords = " . real_mysql_specialchars($keywords, false) . " ";
        $query = $query . "WHERE pid = $pid and login_id = " . real_mysql_specialchars($uid, false);
    }else {
        $query = $query . "WHERE pid = $pid and login_id = " . real_mysql_specialchars($uid, false);
    }
    real_execute_query($query, $db_conn);
    $query = "UPDATE db_user_info SET rank = " . real_mysql_specialchars($title, false) . ",
        dept = " . real_mysql_specialchars($dept, false) . ",
        l_name = " . real_mysql_specialchars($lname, false) . ",
        f_name = " . real_mysql_specialchars($fname, false) . ",
        m_name = " . real_mysql_specialchars($mname, false) . ",
        phone = " . real_mysql_specialchars($phone, false) . ",
        email = " . real_mysql_specialchars($email, false) . ",
        room = '',
        building = " . real_mysql_specialchars($office, false) . ",
        box = '' 
        WHERE login_id = " . real_mysql_specialchars($uid, false);
    real_execute_query($query, $db_conn);
    if ($r_int != "") {
        $query = "UPDATE txst_fac_profl SET r_int = " .
            real_mysql_specialchars($r_int, false) . " ";
        echo "here it is". $query;
    }
    if ($c_v != "" || $publc != "" || $f_hist != "" || $patents != "") {
        if ($r_int != "") {

        }else {
            $query = "UPDATE txst_fac_profl SET ";
        }
        if ($c_v != "") {
            $query = $query . "cv = " . $c_v . " ";
            if ($publc != "") {
                $query = $query . ", pubc = " . $publc . " ";
            }
            if ($f_hist != "") {
                $query = $query . ", f_hist = " . $f_hist . " ";
            }
            if ($patents != "") {
                $query = $query . ", patent = " . $patents . " ";
            }
        }else if ($publc != "") {
            $query = $query . "pubc = " . $publc . " ";
            if ($c_v != "") {
                $query = $query . ", cv = " . $c_v . " ";
            }
            if ($f_hist != "") {
                $query = $query . ", f_hist = " . $f_hist . " ";
            }
            if ($patents != "") {
                $query = $query . ", patent = " . $patents . " ";
            }
        }else if ($f_hist != "") {
            $query = $query . "f_hist = " . $f_hist . " ";
            if ($c_v != "") {
                $query = $query . ", cv = " . $c_v . " ";
            }
            if ($publc != "") {
                $query = $query . ", pubc = " . $publc . " ";
            }
            if ($patents != "") {
                $query = $query . ", patent = " . $patents . " ";
            }
        }else if ($patents != "") {
            $query = $query . "patent = " . $patents . " ";
            if ($c_v != "") {
                $query = $query . ", cv = " . $c_v . " ";
            }
            if ($f_hist != "") {
                $query = $query . ", f_hist = " . $f_hist . " ";
            }
            if ($publc != "") {
                $query = $query . ", pubc = " . $publc . " ";
            }
        }
    }
    if ($r_int != "" || $c_v != "" || $publc != "" || $f_hist != "" || $patents != "") {
        $query = $query . "WHERE pid = $pid and login_id = " . real_mysql_specialchars($uid, false);
        real_execute_query($query, $db_conn);
    }
    rps_update_login_info($db_conn, $_SESSION['UID'], $lname, $fname, $email, $phone);
}else { //user does not already have info in DB, do inserts
    $query = "INSERT INTO gen_profile_info(name, type_id, no_of_hits, status,
        owner_login_id, owner_login_id_old, user1_login_id, user1_name,
        user2_login_id, user2_name, last_modifier, admin_datetime,
        owner_datetime, user1_datetime, user2_datetime)values(" .
        real_mysql_specialchars($lname . ", " . $fname, false) . "," .
        real_mysql_specialchars(1, true) . "," .
        real_mysql_specialchars(0, true) . "," .
        real_mysql_specialchars(0, true) . "," .
        real_mysql_specialchars($uid, false) . "," .
        real_mysql_specialchars($uid, false) . ", '', '', '', ''," .
        real_mysql_specialchars($uid, false) . "," .
        real_mysql_specialchars(0, true) . "," .
        real_mysql_specialchars(0, true) . "," .
        real_mysql_specialchars(0, true) . "," .
        real_mysql_specialchars(0, true) . ")";
    real_execute_query($query, $db_conn);
    $pid = mysql_insert_id($db_conn);
    $image_id = real_insert_image($db_conn, $pid, 0, "image", $_home_images);
    $query = "INSERT INTO ppl_general_info(pid, login_id, title, f_name, m_name,
        l_name, pri_designation, designation, email_id, status_email_id,
        phone_no_1, status_phone_no_1, phone_no_2, status_phone_no_2, fax_no,
        status_fax_no, cell_no, status_cell_no, url_name_1, url_1, url_name_2,
        url_2, url_name_3, url_3, address_1, address_2, city, state, zipcode,
        country, status_address, mailbox, office_location, room_no,
        status_mail_address, pri_hid, hid, image_id, keywords)values(" .
        real_mysql_specialchars($pid, true) . "," .
        real_mysql_specialchars($uid, false) . "," .
        real_mysql_specialchars($title, false) . "," .
        real_mysql_specialchars($fname, false) . "," .
        real_mysql_specialchars($mname, false) . "," .
        real_mysql_specialchars($lname, false) . "," .
        real_mysql_specialchars($rankdept, false) . ",''," .
        real_mysql_specialchars($email, false) . "," .
        real_mysql_specialchars(0, true) . "," .
        real_mysql_specialchars($phone, false) . "," .
        real_mysql_specialchars(0, true) . ",''," .
        real_mysql_specialchars(0, true) . "," .
        real_mysql_specialchars($fax, false) . "," .
        real_mysql_specialchars(0, true) . ",''," .
        real_mysql_specialchars(0, true) . "," .
        real_mysql_specialchars($uid . "-website", false) . "," .
        real_mysql_specialchars($website, false) . ",'','','',''," .
        real_mysql_specialchars($street, false) . ",''," .
        real_mysql_specialchars($city, false) . "," .
        real_mysql_specialchars($state, false) . "," .
        real_mysql_specialchars($zip, false) . ",'USA'," .
        real_mysql_specialchars(0, true) . ",''," .
        real_mysql_specialchars($office, false) . ",''," .
        real_mysql_specialchars(0, true) . "," .
        real_mysql_specialchars(16, true) . ",''," .
        real_mysql_specialchars($image_id, false) . "," .
        real_mysql_specialchars($keywords, false) . ")";
    real_execute_query($query, $db_conn);
    $query = "INSERT INTO gen_profile_section (pid, section_id) SELECT $pid, section_id FROM gen_section_types WHERE type_id = 1";
    real_execute_query($query, $db_conn);
    $query = "INSERT INTO db_user_info(rank, dept, login_id, l_name, f_name,
        m_name, phone, email, room, building, box)values(" .
        real_mysql_specialchars($title, false) . "," .
        real_mysql_specialchars($dept, false) . "," .
        real_mysql_specialchars($uid, false) . "," .
        real_mysql_specialchars($lname, false) . "," .
        real_mysql_specialchars($fname, false) . "," .
        real_mysql_specialchars($mname, false) . "," .
        real_mysql_specialchars($phone, false) . "," .
        real_mysql_specialchars($email, false) . ",''," .
        real_mysql_specialchars($office, false) . ",'')";
    real_execute_query($query, $db_conn);
    $query = "INSERT INTO txst_fac_profl(pid, login_id, cv, r_int, pubc, f_hist, patent)
    values(" . real_mysql_specialchars($pid, true) . "," .
        real_mysql_specialchars($uid, false) . ",'" .
        $c_v . "'," .
        real_mysql_specialchars($r_int, false) . ",'" .
        $publc . "','" .
        $f_hist . "','" .
        $patents . "')";
    real_execute_query($query, $db_conn);
    rps_add_login_info($db_conn, $_SESSION['UID'], $lname, $fname, $email, $phone);
}
real_redirect("researchspace.php", "view=$view", $db_conn);
function rps_add_login_info($db_conn, $uid, $lname, $fname, $email, $phone) {
    $query = "INSERT INTO gen_login_info ( login_id, fname, lname, email_id, phone_no, datetime, last_datetime ) VALUES " .
        " (" . real_mysql_specialchars($uid, false) .
        ", " . real_mysql_specialchars($fname, false) .
        ", " . real_mysql_specialchars($lname, false) .
        ", " . real_mysql_specialchars($email, false) .
        ", " . real_mysql_specialchars($phone, false) .
        ", NOW(), NOW() ) ";
    real_execute_query($query, $db_conn);
}
function rps_update_login_info($db_conn, $uid, $lname, $fname, $email, $phone) {
    $query = "UPDATE gen_login_info SET fname = " .
        real_mysql_specialchars($fname, false) . ", lname = " .
        real_mysql_specialchars($lname, false) . ", email_id = " .
        real_mysql_specialchars($email, false) . ", phone_no = " .
        real_mysql_specialchars($phone, false) . ", last_datetime = NOW()
            where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
    real_execute_query($query, $db_conn);
    
    //added to keep track of login times
    $query = "INSERT INTO login_record(user_id) Values(" . real_mysql_specialchars($uid, false) . ")";
    real_execute_query($query, $db_conn);
}
?>