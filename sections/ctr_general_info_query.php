<?php
	$ctr_general_info_query = "SELECT T1.name, T1.description, T2.* FROM ctr_info T1, ctr_gen_info T2 WHERE T1.pid = T2.pid AND T1.pid = " . real_mysql_specialchars( $pid, true );
	$ctr_general_info_results = real_execute_query ( $ctr_general_info_query, $db_conn );
?>