<?php
	$tech_features_query = "SELECT * FROM tech_features WHERE pid = ".real_mysql_specialchars( $pid, true ) ;
	$tech_features_results = real_execute_query ( $tech_features_query, $db_conn );
?>