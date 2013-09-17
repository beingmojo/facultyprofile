<?php
	$ppl_general_info_query = "SELECT * FROM ppl_general_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$ppl_general_info_results = real_execute_query ( $ppl_general_info_query, $db_conn );

	$gen_association_query = 	"SELECT T1.assoc_pid, T2.type_id FROM gen_association T1, gen_profile_info T2 WHERE T1.assoc_pid = T2.pid AND T1.pid = " . real_mysql_specialchars( $pid, true ) . 
								"	UNION
								SELECT T1.pid, T2.type_id FROM gen_association T1, gen_profile_info T2 WHERE T1.pid = T2.pid AND T1.assoc_pid = " . real_mysql_specialchars( $pid, true ) . 
								"	UNION
								SELECT T3.pid, T2.type_id FROM gen_association T1, gen_profile_info T2, ppl_general_info T3 WHERE T3.login_id = T1.assoc_login_id AND T3.pid = T2.pid AND T1.pid = " . real_mysql_specialchars( $pid, true ) . 
								"	UNION
								SELECT T1.pid, T2.type_id FROM gen_association T1, gen_profile_info T2, ppl_general_info T3 WHERE T3.login_id = T1.assoc_login_id AND T1.pid = T2.pid AND T3.pid = " . real_mysql_specialchars( $pid, true );

	$gen_association_results = real_execute_query ( $gen_association_query, $db_conn );	

	$gen_keywords_query = "SELECT keywords FROM ppl_general_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$gen_keywords_results = real_execute_query ( $gen_keywords_query, $db_conn );	
	$gen_keywords_rows = mysql_fetch_array( $gen_keywords_results );
?>