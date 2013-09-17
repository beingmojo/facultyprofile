<?php
	$ctr_technology_add_req_query = "SELECT T1.name, T1.pid FROM tech_gen_info T1, ctr_technology T3, gen_profile_info T4 WHERE T3.tech_pid = T1.pid AND T3.pid = " . real_mysql_specialchars( $pid, true ) . " AND T3.add_req = 1 AND T3.pid = T4.pid AND T4.status = 0 ORDER BY T1.name";
	$ctr_technology_add_req_results = real_execute_query ( $ctr_technology_add_req_query, $db_conn );

	$ctr_technology_query = "SELECT T1.name, T2.description, T1.pid as tech_pid, T1.image_id, T3.del_req  FROM tech_gen_info T1, tech_abstract T2, ctr_technology T3, gen_profile_info T4 WHERE T3.tech_pid = T2.pid  AND T2.pid = T1.pid AND T3.pid = " . real_mysql_specialchars( $pid, true ) . " AND T3.add_req = 0 AND T3.pid = T4.pid AND T4.status = 0 ORDER BY T1.name";
	$ctr_technology_results = real_execute_query ( $ctr_technology_query, $db_conn );
	
?>