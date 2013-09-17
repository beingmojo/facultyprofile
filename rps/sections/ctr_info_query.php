<?php
	$ctr_info_query = "SELECT * FROM ctr_gen_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$ctr_info_results = real_execute_query ( $ctr_info_query, $db_conn );
	
?>