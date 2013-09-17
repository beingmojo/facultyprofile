<?php
include '../utils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );
echo "real_can_user_edit = ".real_can_user_edit( $db_conn, $pid );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
        $totalPub = real_unescape( $_POST["pubTotal"] );
        echo " pubs: ".$totalPub;
        
        $query = "UPDATE ppl_publication_total SET " .
                        " totalPub = " . real_mysql_specialchars( $totalPub, true ) .
                        " WHERE pid=". real_mysql_specialchars( $pid, true ) ;


        real_execute_query( $query, $db_conn );
        real_update_last_modified_timestamp( $db_conn, $pid );
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>