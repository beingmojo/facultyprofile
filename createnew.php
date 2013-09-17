<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

include_once 'util/randompass.php';
include_once 'imageutils.php';
require_once("inputfilter.php");

//getting the type from the post request
$type = $_POST["profiletype"];
// checking weather the person has the appropriate rights to create the profile
$user_id = $_SESSION["UID"];
$is_admin = real_check_user_groupid( $db_conn, "admin" );
$is_tech_admin = real_check_user_groupid( $db_conn, "tech_admin" );
$ipFilter = new InputFilter($_filter_tags,"",1,1,1);
// if type is faculty create the scratch profile
if( $type == "faculty" ) {
    if( $is_admin == true ) {
        $user_id = substr( real_unescape( $_POST["ppl_general_info_login_id"] ), 0, 255 );
    }
//Texas State Customizations - Start:///////////////////////////////////////////
    $loginid_query="select max(login_id) as loginid from db_authentication";
    $result = mysql_query($loginid_query);
    if(mysql_num_rows($result) == 0) {
    }else {
        if (list($loginid) = mysql_fetch_array($result)) {
            $loginid_query = $loginid + 1;
        }
    }
    $loginid_query = (string)$loginid_query;
    while (strlen($loginid_query) < 10) {
        $loginid_query = "0".$loginid_query;
    }
    $user_id = $loginid_query;
//Texas State Customizations - End:///////////////////////////////////////////
    $type_id = 1;
    $title = substr( real_unescape( $_POST["ppl_general_info_title"] ), 0, 255 );
    $f_name = substr( real_unescape( $_POST["ppl_general_info_f_name"] ), 0, 255 );
    $l_name = substr( real_unescape( $_POST["ppl_general_info_l_name"] ), 0, 255 );
    $m_name = substr( real_unescape( $_POST["ppl_general_info_m_name"] ), 0, 255 );
    $pri_designation = substr( real_unescape( $_POST["ppl_general_info_pri_designation"] ), 0, 255 );
    $designation = substr( real_unescape( $_POST["ppl_general_info_designation"] ), 0, 255 );
    $pri_hid = real_unescape( $_POST["ppl_general_info_pri_hid"] );
    $hid = substr( real_unescape( $_POST["ppl_general_info_hid_list"] ), 0, 255 );
    $address_1 = substr( real_unescape( $_POST["ppl_general_info_address_1"] ), 0, 255 );
    $address_2 = substr( real_unescape( $_POST["ppl_general_info_address_2"] ), 0, 255 );
    $mailbox = substr( real_unescape( $_POST["ppl_general_info_mailbox"] ), 0, 8 );
    $city = substr( real_unescape( $_POST["ppl_general_info_city"] ), 0, 32 );
    $state = substr( real_unescape( $_POST["ppl_general_info_state"] ), 0, 32 );
    $zipcode = substr( real_unescape( $_POST["ppl_general_info_zipcode"] ), 0, 16 );
    $office_location = substr( real_unescape( $_POST["ppl_general_info_office_location"] ), 0, 255 );
    $room_no = substr( real_unescape( $_POST["ppl_general_info_room_no"] ), 0, 16 );
    $email_id = substr( real_unescape( $_POST["ppl_general_info_email_id"] ), 0, 255 );
    $phone_no_1 = substr( real_unescape( $_POST["ppl_general_info_phone_no_1"] ), 0, 32 );
    $phone_no_2 = substr( real_unescape( $_POST["ppl_general_info_phone_no_2"] ), 0, 32 );
    $cell_no = substr( real_unescape( $_POST["ppl_general_info_cell_no"] ), 0, 32 );
    $fax_no = substr( real_unescape( $_POST["ppl_general_info_fax_no"] ), 0, 32 );
    $url_name_1 = substr( real_unescape( $_POST["ppl_general_info_url_name_1"] ), 0, 255 );
    $url_1 = real_validate_url(substr( real_unescape( $_POST["ppl_general_info_url_1"] ), 0, 255 ));
    $url_name_2 = substr( real_unescape( $_POST["ppl_general_info_url_name_2"] ), 0, 255 );
    $url_2 = real_validate_url(substr( real_unescape( $_POST["ppl_general_info_url_2"] ), 0, 255 ));
    $url_name_3 = substr( real_unescape( $_POST["ppl_general_info_url_name_3"] ), 0, 255 );
    $url_3 = real_validate_url(substr( real_unescape( $_POST["ppl_general_info_url_3"] ), 0, 255 ));
    $keywords = substr( real_unescape( $_POST["ppl_general_info_keywords"] ), 0, 255 );
    $rank_changed = $_POST["ppl_general_info_rank_changed"];
    $pri_rank_changed = $_POST["ppl_general_info_pri_rank_changed"];
//Texas State Customizations - Start:///////////////////////////////////////////
    $r_int = substr( real_unescape( $_POST["txst_fac_profl_r_int"] ), 0, 255 );
    $f_hist = substr( real_unescape( $_POST["txst_fac_profl_f_hist"] ), 0, 255 );
    $patent = substr( real_unescape( $_POST["txst_fac_profl_patent"] ), 0, 255 );
//Texas State Customizations - End:///////////////////////////////////////////
    if( $f_name != "" && $l_name !="" ) {
        $faculty_sections = array( "1","2","3","4","5","6","7","8","10","11" );
        $name = $title;
        $profile_query = "INSERT INTO gen_profile_info ( type_id, name, owner_login_id, status ) VALUES ( " .
                $type_id .
                ", " . real_mysql_specialchars(
                substr(
                $title .
                ( $title == "" ? "" : " " ) . $l_name .
                ( $f_name == "" ? "" : ", " ) . $f_name .
                ( $m_name == "" ? "" : " " ) . $m_name  ,
                0, 255 )
                , false ) .
                ", " . real_mysql_specialchars($user_id, false) .
                ", 1 )";

        real_execute_query( $profile_query, $db_conn );
        $pid = mysql_insert_id( $db_conn );

        $image_id = real_insert_image( $db_conn, $pid, 0, "imagefile", "images" );

        $profile_query = "INSERT INTO ppl_general_info ( pid, login_id, title, f_name, m_name, l_name,
							pri_designation, pri_hid, designation, hid, 
							address_1, address_2, mailbox, city, state, zipcode, 
							office_location, room_no, 
							phone_no_1, phone_no_2, cell_no, email_id, fax_no, 
							url_name_1, url_1, url_name_2, url_2, url_name_3, url_3, 
							keywords, image_id ) VALUES ( $pid" .
                ", " . real_mysql_specialchars($user_id, false) .
                ", " . real_mysql_specialchars( $title, false ) .
                ", " . real_mysql_specialchars( $f_name, false ) .
                ", " . real_mysql_specialchars( $m_name, false ) .
                ", " . real_mysql_specialchars( $l_name, false ) .
                ", " . real_mysql_specialchars( $pri_designation, false ) .
                ", " . real_mysql_specialchars( $pri_hid, true) .
                ", " . real_mysql_specialchars( $designation, false ) .
                ", " . real_mysql_specialchars( $hid, false ) .
                ", " . real_mysql_specialchars( $address_1, false ) .
                ", " . real_mysql_specialchars( $address_2, false ) .
                ", " . real_mysql_specialchars( $mailbox, false ) .
                ", " . real_mysql_specialchars( $city, false ) .
                ", " . real_mysql_specialchars( $state, false ) .
                ", " . real_mysql_specialchars( $zipcode, false ) .
                ", " . real_mysql_specialchars( $office_location, false ) .
                ", " . real_mysql_specialchars( $room_no, false ) .
                ", " . real_mysql_specialchars( $phone_no_1, false ) .
                ", " . real_mysql_specialchars( $phone_no_2, false ) .
                ", " . real_mysql_specialchars( $cell_no, false ) .
                ", " . real_mysql_specialchars( $email_id, false ) .
                ", " . real_mysql_specialchars( $fax_no, false ) .
                ", " . real_mysql_specialchars( $url_name_1, false ) .
                ", " . real_mysql_specialchars( $url_1, false ) .
                ", " . real_mysql_specialchars( $url_name_2, false ) .
                ", " . real_mysql_specialchars( $url_2, false ) .
                ", " . real_mysql_specialchars( $url_name_3, false ) .
                ", " . real_mysql_specialchars( $url_3, false ) .
                ", " . real_mysql_specialchars( $keywords, false ) .
                ", " . real_mysql_specialchars( $image_id, true ) .
                " )";
        real_execute_query( $profile_query, $db_conn );

        $section_query = "INSERT INTO gen_profile_section (pid, section_id) SELECT $pid, section_id FROM gen_section_types WHERE type_id = $type_id";
        real_execute_query( $section_query, $db_conn );

        if( $rank_changed == "1" || $pri_rank_changed == "1" ) {
            $query = "DELETE FROM gen_profile_hierarchy WHERE pid = $pid";
            real_execute_query( $query, $db_conn );
            $query = "INSERT INTO gen_profile_hierarchy (pid, hid) VALUES ($pid, $pri_hid)";
            real_execute_query( $query, $db_conn );
            $hid_list = explode( "|", $hid );
            foreach( $hid_list as $curr_hid ) {
                if( $curr_hid != "" ) {
                    $query = "INSERT INTO gen_profile_hierarchy (pid, hid) VALUES ($pid, $curr_hid)";
                    real_execute_query( $query, $db_conn );
                }
            }
        }
//Texas State Customizations - Start:///////////////////////////////////////////
        //process CV file
        $cvContent = "";
        $pubcContent = "";
        if( is_uploaded_file( $_FILES["txst_fac_profl_cv"]["tmp_name"] ) ) {
            //get details of CV file
            $cvFileName = $_FILES['txst_fac_profl_cv']['name'];
            $cvTmpName  = $_FILES['txst_fac_profl_cv']['tmp_name'];
            $cvFileSize = $_FILES['txst_fac_profl_cv']['size'];
            $cvFileType = $_FILES['txst_fac_profl_cv']['type'];
            //get content of CV file
            $fp = fopen($cvTmpName, 'r'); //fopen -- file open, r -- read flag
            $cvContent = fread($fp, filesize($cvTmpName)); //fread -- file read
            fclose($fp); //fclose -- file close
            if(!get_magic_quotes_gpc()) {
                $cvFileName = addslashes($cvFileName); //escape the file's name
                $cvContent = addslashes($cvContent); //escape the file's content
            }
        }
        //process Publications file
        if( is_uploaded_file( $_FILES["txst_fac_profl_pubc"]["tmp_name"] ) ) {
            //get details of Publications file
            $pubcFileName = $_FILES['txst_fac_profl_pubc']['name'];
            $pubcTmpName  = $_FILES['txst_fac_profl_pubc']['tmp_name'];
            $pubcFileSize = $_FILES['txst_fac_profl_pubc']['size'];
            $pubcFileType = $_FILES['txst_fac_profl_pubc']['type'];
            //get content of Publications file
            $fp = fopen($pubcTmpName, 'r'); //fopen -- file open, r -- read flag
            $pubcContent = fread($fp, filesize($pubcTmpName));//fread -file read
            fclose($fp); //fclose -- file close
            if(!get_magic_quotes_gpc()) {
                $pubcFileName = addslashes($pubcFileName); //escape the file's name
                $pubcContent = addslashes($pubcContent); //escape the file's content
            }
        }
        //insert into db
        $randompass = generatePassword();
        $uname = substr($email_id, 0, (strlen($email_id) -
                        strlen(substr($email_id,
                        strpos(strtolower($email_id), "@txstate.edu")))));
        $unamesub = $uname;
        $pass =  substr($randompass, 0, 2);
        while (strlen($unamesub) > 1 && strlen($randompass) > 1) {
            $pass .= substr($unamesub, 0, 1);
            $pass .= substr($randompass, 0, 1);
            $unamesub = substr($unamesub, 1);
            $randompass = substr($randompass, 1);
        }
        $pass .= ($unamesub . $randompass);
        $login_query = "insert into db_authentication(login_name, login_id, ".
                "password)values('".$uname."',  ".real_mysql_specialchars(
//                $user_id, false).", '".md5($pass)."')";
                $user_id, false).", '".md5("profilesystem")."')";
        real_execute_query( $login_query, $db_conn );
        $rank = substr($pri_designation, 0, strpos($pri_designation, "-"));
        $dept = substr($pri_designation, strpos($pri_designation, "-") + 1);
        $userinfo_query = "insert into db_user_info(rank, dept, login_id, ".
                "l_name, f_name, m_name, phone, email, room, building, box)values(
            ".real_mysql_specialchars($rank, false).", ".
                real_mysql_specialchars($dept, false).", ".
                real_mysql_specialchars($user_id, false).", ".
                real_mysql_specialchars($l_name, false).", ".
                real_mysql_specialchars($f_name, false).", ".
                real_mysql_specialchars($m_name, false).", ".
                real_mysql_specialchars($phone_no_1, false).", ".
                real_mysql_specialchars($email_id, false).", ".
                real_mysql_specialchars($room_no, false).", ".
                real_mysql_specialchars($office_location, false).", ".
                real_mysql_specialchars($mailbox, false).")";
        real_execute_query( $userinfo_query, $db_conn );
        $profile_query = "INSERT INTO txst_fac_profl ( pid, login_id, cv, ".
                "r_int, pubc, f_hist, patent ) VALUES ( $pid" . ", " .
                real_mysql_specialchars($user_id, false) . ", '" .
                $cvContent . "', " .
                real_mysql_specialchars($r_int, false) . ", '" .
                $pubcContent . "', " .
                real_mysql_specialchars($f_hist, false) . ", " .
                real_mysql_specialchars($patent, false) . " )";
        real_execute_query( $profile_query, $db_conn );
//Texas State Customizations - End://///////////////////////////////////////////
    }else {
        real_redirect( "createfaculty.php", "", $db_conn );
    }
    real_redirect( "editprofile.php", "pid=$pid", $db_conn );
}

// if type is equipment then create the scratch equipment profile
if( $type == "equipment" ) {
    if( $is_admin ) {
        $user_id = substr( real_unescape( $_POST["eqp_general_info_login_id"] ), 0, 255 );
    }
    $type_id = 5;
    $name=substr( real_unescape( $_POST["eqp_general_info_name"] ), 0, 255 );
    $description= $ipFilter->process( $_POST["eqp_general_info_description"]);

    if( $name != "" && $user_id != "" ) {
        $equipment_sections = array( "1","2" );
        $profile_query = "INSERT INTO gen_profile_info ( type_id, name, owner_login_id, status ) VALUES ( " .
                $type_id .
                ", " . real_mysql_specialchars(substr($name,0,255), false).
                ", " . real_mysql_specialchars($user_id, false) .
                ", 1 )";
        real_execute_query( $profile_query, $db_conn );
        $pid = mysql_insert_id( $db_conn );

        $profile_query = "INSERT INTO eqp_info ( pid, name, description ) VALUES ( $pid " .
                ", " . real_mysql_specialchars($name, false).
                ", " . real_mysql_specialchars($description, false).
                " )";

        real_execute_query( $profile_query, $db_conn );

        $section_query = "INSERT INTO gen_profile_section (pid, section_id) SELECT $pid, section_id FROM gen_section_types WHERE type_id = $type_id";
        real_execute_query( $section_query, $db_conn );
    }
    else {
        real_redirect( "createequipment.php", "", $db_conn );
    }

    real_redirect( "editprofile.php", "pid=$pid", $db_conn );
}
// if type is technology then create a scratch profile of technology
if( $type == "technology" && ( $is_admin || $is_tech_admin ) ) {
    $user_id = substr( real_unescape( $_POST["tech_general_info_login_id"] ), 0, 255 );
    $type_id = 3;
    $title=substr( real_unescape( $_POST["tech_general_info_title"] ), 0, 255 );
    $abstract=$ipFilter->process( $_POST["abstract"]);
    if( $title != "" && $user_id != "" ) {
        $profile_query = "INSERT INTO gen_profile_info ( type_id, name, owner_login_id, status) VALUES ( " .
                $type_id .
                ", " . real_mysql_specialchars( substr( $title, 0, 255 ), false ) .
                ", " . real_mysql_specialchars($user_id, false) .
                ", 1)";
        real_execute_query( $profile_query, $db_conn );
        $pid = mysql_insert_id( $db_conn );

        $profile_query = "INSERT INTO tech_gen_info ( pid, name ) VALUES ( ".
                real_mysql_specialchars($pid, true ) .
                ", " . real_mysql_specialchars($title, false ) .
                " )";
        real_execute_query( $profile_query, $db_conn );

        $profile_query = "INSERT INTO tech_abstract ( pid, description ) VALUES ( ".
                real_mysql_specialchars($pid, true ) .
                ", " . real_mysql_specialchars($abstract, false ) .
                " )";
        real_execute_query( $profile_query, $db_conn );

        $section_query = "INSERT INTO gen_profile_section (pid, section_id) SELECT $pid, section_id FROM gen_section_types WHERE type_id = $type_id";
        real_execute_query( $section_query, $db_conn );

    }
    else {
        real_redirect( "createtechnology.php", "", $db_conn );
    }

    real_redirect( "editprofile.php", "pid=$pid", $db_conn );
}
// if type is center then create the scratch center profile
if( $type == "center" && $is_admin ) {
    $user_id = substr( real_unescape( $_POST["ctr_general_info_login_id"] ), 0, 255 );
    $type_id = 2;

    $name=substr( real_unescape( $_POST["ctr_general_info_name"] ), 0, 255 );
    $description=$ipFilter->process( $_POST["ctr_general_info_description"]);
    if( $name != "" && $user_id != "" ) {

        $profile_query = "INSERT INTO gen_profile_info ( type_id, name, owner_login_id ) VALUES ( " .
                $type_id .
                ", " . real_mysql_specialchars( substr( $name, 0, 255 ), false ) .
                ", " . real_mysql_specialchars($user_id, false) .
                " )";
        real_execute_query( $profile_query, $db_conn );
        $pid = mysql_insert_id( $db_conn );


        $profile_query = "INSERT INTO ctr_info ( pid, name, description ) VALUES ( ".
                real_mysql_specialchars($pid, true ) .
                ", " . real_mysql_specialchars($name, false ) .
                ", " . real_mysql_specialchars($description, false ) .
                " )";

        real_execute_query( $profile_query, $db_conn );

        $profile_query = "INSERT INTO ctr_gen_info ( pid, contact_login_id ) VALUES ( " .
                real_mysql_specialchars($pid, true ) .
                ", " . real_mysql_specialchars($user_id, false) .
                " )";

        real_execute_query( $profile_query, $db_conn );

        $section_query = "INSERT INTO gen_profile_section (pid, section_id) SELECT $pid, section_id FROM gen_section_types WHERE type_id = $type_id";
        real_execute_query( $section_query, $db_conn );
    }
    else {
        real_redirect( "createcenter.php", "", $db_conn );
    }

    real_redirect( "editprofile.php", "pid=$pid", $db_conn );
}
// if type is facility then create the scratch facility profile
if( $type == "facility" && $is_admin ) {
    $user_id = substr( real_unescape( $_POST["fac_general_info_login_id"] ), 0, 255 );
    $type_id = 4;
    $title=substr( real_unescape( $_POST["fac_general_info_title"] ), 0, 255 );
    $abstract=$ipFilter->process( $_POST["abstract"]);
    if( $title != "" && $user_id != "" ) {
        $profile_query = "INSERT INTO gen_profile_info ( type_id, name, owner_login_id, status) VALUES ( " .
                $type_id .
                ", " . real_mysql_specialchars( substr( $title, 0, 255 ), false ) .
                ", " . real_mysql_specialchars($user_id, false) .
                ", 1)";
        real_execute_query( $profile_query, $db_conn );
        $pid = mysql_insert_id( $db_conn );

        $profile_query = "INSERT INTO fac_info ( pid, name, description ) VALUES ( ".
                real_mysql_specialchars($pid, true ) .
                ", " . real_mysql_specialchars($title, false ) .
                ", " . real_mysql_specialchars($abstract, false ) .
                " )";
        real_execute_query( $profile_query, $db_conn );

        $profile_query = "INSERT INTO fac_gen_info ( pid) VALUES ( ".
                real_mysql_specialchars($pid, true ) .
                " )";
        real_execute_query( $profile_query, $db_conn );

        $section_query = "INSERT INTO gen_profile_section (pid, section_id) SELECT $pid, section_id FROM gen_section_types WHERE type_id = $type_id";
        real_execute_query( $section_query, $db_conn );

    }
    else {
        real_redirect( "createfacility.php", "", $db_conn );
    }

    real_redirect( "editprofile.php", "pid=$pid", $db_conn );
}
// if type is lab/group then create a scratch lab/group profile
if( $type == "group") {
    $user_id = substr( real_unescape( $_POST["labgroup_general_info_login_id"] ), 0, 255 );
    $type_id = 6;

    $name=substr( real_unescape( $_POST["labgroup_general_info_name"] ), 0, 255 );
    $description=$ipFilter->process( $_POST["abstract"]);
    if( $name != "" && $user_id != "" ) {

        $profile_query = "INSERT INTO gen_profile_info ( type_id, name, owner_login_id ) VALUES ( " .
                $type_id .
                ", " . real_mysql_specialchars( substr( $name, 0, 255 ), false ) .
                ", " . real_mysql_specialchars($user_id, false) .
                " )";
        real_execute_query( $profile_query, $db_conn );
        $pid = mysql_insert_id( $db_conn );


        $profile_query = "INSERT INTO ctr_info ( pid, name, description ) VALUES ( ".
                real_mysql_specialchars($pid, true ) .
                ", " . real_mysql_specialchars($name, false ) .
                ", " . real_mysql_specialchars($description, false ) .
                " )";

        real_execute_query( $profile_query, $db_conn );

        $profile_query = "INSERT INTO ctr_gen_info ( pid, contact_login_id ) VALUES ( " .
                real_mysql_specialchars($pid, true ) .
                ", " . real_mysql_specialchars($user_id, false) .
                " )";

        real_execute_query( $profile_query, $db_conn );

        $section_query = "INSERT INTO gen_profile_section (pid, section_id) SELECT $pid, section_id FROM gen_section_types WHERE type_id = $type_id";
        real_execute_query( $section_query, $db_conn );
    }
    else {
        real_redirect( "create_lab_group.php", "", $db_conn );
    }

    real_redirect( "editprofile.php", "pid=$pid", $db_conn );
}
real_redirect( "researchspace.php", "", $db_conn );
?>
