<?php
	$eqp_description_query = "SELECT description, cost, value FROM eqp_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$eqp_description_results = real_execute_query ( $eqp_description_query, $db_conn );
?>