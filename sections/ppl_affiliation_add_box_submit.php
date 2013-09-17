<?php
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );
if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$max_aff_id = real_unescape( $_POST["max_aff_id"] );
	$itr = 0;
	for( $i = 1; $i <= 3; $i++ )
	{
		$category = substr( real_unescape( $_POST["ppl_affiliation_category".$i] ), 0, 100 );
		if( $category == "" )
			$type = substr( real_unescape( $_POST["ppl_affiliation_type".$i] ), 0, 100 );
		else
			$type = $category;
		$name = substr( real_unescape( $_POST["ppl_affiliation_name".$i] ), 0, 255 );
		$list_of_ppl = real_unescape( $_POST["ppl_affiliation_list_of_ppl".$i] );
		$status = ($_POST["ppl_affiliation_status".$i]=="on")?"1":"0";
		if( $name != "" && $list_of_ppl != "" )
		{ 
			$itr ++;
			$query = "INSERT INTO ppl_affiliation ( pid, aff_id, type, name, list_of_ppl, status ) VALUES( " .
					real_mysql_specialchars($pid, true) .
					", " . ($max_aff_id + $itr) . 
					", " . real_mysql_specialchars( $type, false ) .
					", " . real_mysql_specialchars( $name, false ) .
					", " . real_mysql_specialchars( $list_of_ppl, false ) .
					", " . real_mysql_specialchars( $status, true ) .
					"  )";
	
			real_execute_query( $query, $db_conn );
			real_update_last_modified_timestamp( $db_conn, $pid );
		}
	}
}
real_redirect( "../editprofile.php", "pid=$pid&view=$view#$section_id", $db_conn );

?>