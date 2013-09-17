<?php
	$fac_info_query = "SELECT * FROM fac_gen_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$fac_info_results = real_execute_query ( $fac_info_query, $db_conn );
	
?>