<?php
include '../utils.php';
include '../imageutils.php';
session_start();
$_err_page = "../" . $_err_page;

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true ) {
    $title = substr( real_unescape( $_POST["ppl_general_info_title"] ), 0, 255 );
    $f_name = substr( real_unescape( $_POST["ppl_general_info_f_name"] ), 0, 255 );
    $l_name = substr( real_unescape( $_POST["ppl_general_info_l_name"] ), 0, 255 );
    $m_name = substr( real_unescape( $_POST["ppl_general_info_m_name"] ), 0, 255 );
    $designation = substr( real_unescape( $_POST["ppl_general_info_designation"] ), 0, 255 );
    $pri_designation = substr( real_unescape( $_POST["ppl_general_info_pri_designation"] ), 0, 255 );
    $hid = substr( real_unescape( $_POST["ppl_general_info_hid_list"] ),0, 255 );
    $pri_hid = real_unescape( $_POST["ppl_general_info_pri_hid"] );
    $address_1 = substr( real_unescape( $_POST["ppl_general_info_address_1"] ), 0, 255 );
    $address_2 = substr( real_unescape( $_POST["ppl_general_info_address_2"] ), 0, 255 );
    $mailbox = substr( real_unescape( $_POST["ppl_general_info_mailbox"] ), 0, 8 );
    $city = substr( real_unescape( $_POST["ppl_general_info_city"] ), 0, 32 );
    $state = substr( real_unescape( $_POST["ppl_general_info_state"] ), 0, 32 );
    $zipcode = substr( real_unescape( $_POST["ppl_general_info_zipcode"] ), 0, 16 );
    $status_address = ($_POST["ppl_general_info_status_address"]=="on")?"1":"0";
    $designation = substr( real_unescape( $_POST["ppl_general_info_designation"] ), 0, 255 );
    $office_location = substr( real_unescape( $_POST["ppl_general_info_office_location"] ), 0, 255 );
    $room_no = substr( real_unescape( $_POST["ppl_general_info_room_no"] ), 0, 16 );
    $status_mail_address = ($_POST["ppl_general_info_status_mail_address"]=="on")?"1":"0";
    $email_id = substr( real_unescape( $_POST["ppl_general_info_email_id"] ), 0, 255 );
    $status_email_id = ($_POST["ppl_general_info_status_email_id"]=="on")?"1":"0";
    $phone_no_1 = substr( real_unescape( $_POST["ppl_general_info_phone_no_1"] ), 0, 32 );
    $status_phone_no_1 = ($_POST["ppl_general_info_status_phone_no_1"]=="on")?"1":"0";
    $phone_no_2 = substr( real_unescape( $_POST["ppl_general_info_phone_no_2"] ), 0, 32 );
    $status_phone_no_2 = ($_POST["ppl_general_info_status_phone_no_2"]=="on")?"1":"0";
    $cell_no = substr( real_unescape( $_POST["ppl_general_info_cell_no"] ), 0, 32 );
    $status_cell_no = ($_POST["ppl_general_info_status_cell_no"]=="on")?"1":"0";
    $fax_no = substr( real_unescape( $_POST["ppl_general_info_fax_no"] ), 0, 32 );
    $status_fax_no = ($_POST["ppl_general_info_status_fax_no"]=="on")?"1":"0";
    $url_name_1 = substr( real_unescape( $_POST["ppl_general_info_url_name_1"] ), 0, 255 );
    $url_1 = substr( real_unescape( $_POST["ppl_general_info_url_1"] ), 0, 255 );
    $url_1 = real_validate_url($url_1);
    $url_name_2 = substr( real_unescape( $_POST["ppl_general_info_url_name_2"] ), 0, 255 );
    $url_2 = substr( real_unescape( $_POST["ppl_general_info_url_2"] ), 0, 255 );
    $url_2 = real_validate_url($url_2);
    $url_name_3 = substr( real_unescape( $_POST["ppl_general_info_url_name_3"] ), 0, 255 );
    $url_3 = substr( real_unescape( $_POST["ppl_general_info_url_3"] ), 0, 255 );
    $url_3 = real_validate_url($url_3);
    $keywords = substr( real_unescape( $_POST["ppl_general_info_keywords"] ), 0, 255 );
    $remove_image = ($_POST["ppl_general_info_remove_image"]=="on")?"1":"0";
    $rank_changed = $_POST["ppl_general_info_rank_changed"] ;
    $pri_rank_changed = $_POST["ppl_general_info_pri_rank_changed"] ;
    $image_id = real_unescape( $_POST["ppl_general_info_image_id"] );

    if( $remove_image == "1" ) {
        if( $image_id != 0 ) {
            real_delete_image( $db_conn, $pid, 0, $image_id, "../images" );
            $image_id = 0;
        }
    }
    else {
        if( $image_id == 0 || $image_id == "" ) {
            $cur_image_id = real_insert_image( $db_conn, $pid, 0, "imagefile", "../images" );
            if( $cur_image_id != 0 ) $image_id = $cur_image_id;
        }
        else
            real_update_image( $db_conn, $pid, 0, "imagefile", $image_id, "../images" );
    }
    if ( $l_name != "" && $f_name != "" ) {
        $query = "UPDATE ppl_general_info SET " .
                " title=" . real_mysql_specialchars( $title, false ) .
                ", f_name=" . real_mysql_specialchars( $f_name, false ) .
                ", m_name=" . real_mysql_specialchars( $m_name, false ) .
                ", l_name=" . real_mysql_specialchars( $l_name, false ) .
                ", pri_designation=" . real_mysql_specialchars( $pri_designation, false ) .
                ", designation=" . real_mysql_specialchars( $designation, false ) .
                ", pri_hid=" .real_mysql_specialchars(stripslashes($pri_hid), true ) .
                ", hid=" . real_mysql_specialchars( $hid, false ) .
                ", address_1=" . real_mysql_specialchars( $address_1, false ) .
                ", address_2=" . real_mysql_specialchars( $address_2, false ) .
                ", mailbox=" . real_mysql_specialchars( $mailbox, false ) .
                ", city=" . real_mysql_specialchars( $city, false ) .
                ", state=" . real_mysql_specialchars( $state, false ) .
                ", zipcode=" . real_mysql_specialchars( $zipcode, false ) .
                ", status_address=" . real_mysql_specialchars( $status_address, true ) .
                ", office_location=" . real_mysql_specialchars( $office_location, false ) .
                ", room_no=" . real_mysql_specialchars( $room_no, false ) .
                ", status_mail_address=" . real_mysql_specialchars( $status_mail_address, true ) .
                ", email_id=" . real_mysql_specialchars( $email_id, false ) .
                ", status_email_id=" . real_mysql_specialchars( $status_email_id, true ) .
                ", phone_no_1=" . real_mysql_specialchars( $phone_no_1, false ) .
                ", status_phone_no_1=" . real_mysql_specialchars( $status_phone_no_1, true ) .
                ", phone_no_2=" . real_mysql_specialchars( $phone_no_2, false ) .
                ", status_phone_no_2=" . real_mysql_specialchars( $status_phone_no_2, true ) .
                ", cell_no=" . real_mysql_specialchars( $cell_no, false ) .
                ", status_cell_no=" . real_mysql_specialchars( $status_cell_no, true ) .
                ", fax_no=" . real_mysql_specialchars( $fax_no, false ) .
                ", status_fax_no=" . real_mysql_specialchars( $status_fax_no, true ) .
                ", url_1=" . real_mysql_specialchars( $url_1, false ) .
                ", url_name_1=" . real_mysql_specialchars( $url_name_1, false ) .
                ", url_2=" . real_mysql_specialchars( $url_2, false ) .
                ", url_name_2=" . real_mysql_specialchars( $url_name_2, false ) .
                ", url_3=" . real_mysql_specialchars( $url_3, false ) .
                ", url_name_3=" . real_mysql_specialchars( $url_name_3, false ) .
                ", keywords=" . real_mysql_specialchars( $keywords, false ) .
                ", image_id = " . real_mysql_specialchars( $image_id, true ) .
                " WHERE pid=" . real_mysql_specialchars( $pid, false ) ;
        real_execute_query( $query, $db_conn );


        $query = "UPDATE gen_profile_info SET name = " .
                real_mysql_specialchars(
                substr(
                $title .
                ( $title == "" ? "" : " " ) . $l_name .
                ( $f_name == "" ? "" : ", " ) . $f_name .
                ( $m_name == "" ? "" : " " ) . $m_name  ,
                0, 255 )
                ) .
                " WHERE pid=" . real_mysql_specialchars( $pid, false ) ;
        real_execute_query( $query, $db_conn );
        if( $rank_changed == "1" || $pri_rank_changed == "1" ) {
            $query = "DELETE FROM gen_profile_hierarchy WHERE pid =" . real_mysql_specialchars($pid, true);
            real_execute_query( $query, $db_conn );
            $query = "INSERT INTO gen_profile_hierarchy (pid, hid) VALUES (" . real_mysql_specialchars($pid, true) . ",". real_mysql_specialchars($pri_hid, true) . ")";
            real_execute_query( $query, $db_conn );
            $hid_list = explode( "|", $hid );
            foreach( $hid_list as $curr_hid ) {
                if( $curr_hid != "" ) {
                    $query = "INSERT INTO gen_profile_hierarchy (pid, hid) VALUES (" . real_mysql_specialchars($pid, true) . "," . real_mysql_specialchars($curr_hid, true) . ")";
                    real_execute_query( $query, $db_conn );
                }
            }
        }
        real_update_last_modified_timestamp( $db_conn, $pid );
    }
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view", $db_conn );

?>
