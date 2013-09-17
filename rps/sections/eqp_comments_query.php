<?php
	$eqp_comments_query = "SELECT comments FROM eqp_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$eqp_comments_results = real_execute_query ( $eqp_comments_query, $db_conn );
?>