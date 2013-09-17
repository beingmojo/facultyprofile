<?php
	$fac_researchcenter_add_req_query = "SELECT T1.name, T1.pid FROM fac_info T1, fac_researchcenter T3, gen_profile_info T4 WHERE T3.ctr_pid = T1.pid AND T3.pid = " . real_mysql_specialchars( $pid, true ) . " AND T3.add_req = 1 AND T3.pid = T4.pid AND T4.status = 0";
	$fac_researchcenter_add_req_results = real_execute_query ( $fac_researchcenter_add_req_query, $db_conn );

	//$fac_researchcenter_query = "SELECT T1.name, T1.description, T1.pid, T2.fac_image_id, T3.del_req  FROM fac_info T1, fac_gen_info T2, fac_researchcenter T3, gen_profile_info T4 WHERE T3.ctr_pid = T1.pid AND T1.pid = T2.pid AND T3.pid = " . real_mysql_specialchars( $pid, true ) . " AND T3.add_req = 0 AND T3.pid = T4.pid AND T4.status = 0";
	//$fac_researchcenter_query = "SELECT T1.name, T1.description, T1.pid, T2.ctr_image_id, T3.del_req FROM ctr_info T1, ctr_gen_info T2, fac_researchcenter T3, gen_profile_info T4 WHERE T3.ctr_pid = T1.pid AND T1.pid = T2.pid AND T3.pid = " . real_mysql_specialchars( $pid, true ) . " AND T3.add_req = 0 AND T3.pid = T4.pid AND T4.status = 0";
	$fac_researchcenter_query = "SELECT T1.name, T1.description, T1.pid, T2.ctr_image_id, T3.del_req FROM ctr_info T1, ctr_gen_info T2, fac_researchcenter T3, gen_profile_info T4 WHERE T3.ctr_pid = T1.pid AND T1.pid = T2.pid AND T3.pid = " . real_mysql_specialchars( $pid, true ) . " AND T3.add_req = 0 AND T3.pid = T4.pid";
	$fac_researchcenter_results = real_execute_query ( $fac_researchcenter_query, $db_conn );
?>