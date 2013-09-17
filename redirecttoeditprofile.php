<?php
include 'utils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_GET["pid"] );
$section_id = real_unescape( $_GET["section_id"] );
$view = real_unescape( $_GET["view"] );
real_redirect( "editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );
?>