<?php
	$ctr_accomplishment_query = "SELECT accomplishment FROM ctr_gen_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$ctr_accomplishment_results = real_execute_query ( $ctr_accomplishment_query, $db_conn );
?>