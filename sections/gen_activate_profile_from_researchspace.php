<?php

include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_GET["pid"] );
//$status = real_unescape( $_POST["gen_activate_profile_status"] );
$query = "UPDATE gen_profile_info SET status = NOT status WHERE pid = " . real_mysql_specialchars( $pid, true );
real_execute_query( $query, $db_conn );
real_update_last_modified_timestamp( $db_conn, $pid );
real_redirect( "../researchspace.php", "", $db_conn );
?>
