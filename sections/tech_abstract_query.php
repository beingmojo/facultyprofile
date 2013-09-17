<?php
	$tech_abstract_query = "SELECT * FROM tech_abstract WHERE pid = " . real_mysql_specialchars( $pid, true ) ;
	$tech_abstract_results = real_execute_query ( $tech_abstract_query, $db_conn );
?>