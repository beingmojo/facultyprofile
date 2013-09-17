<?php
include 'utils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
// logoff by removing the entry in the gen_login_session table
$sessionid = real_logoff_session( $db_conn, $_SESSION['UID'] );
// redirect to the the index page
real_redirect( $_index_page, "", $db_conn);
?>
