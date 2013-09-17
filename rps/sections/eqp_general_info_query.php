<?php
	$eqp_general_info_query = "SELECT * FROM eqp_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$eqp_general_info_results = real_execute_query ( $eqp_general_info_query, $db_conn );

	$eqp_general_contact_info_query = "SELECT T1.pid, T1.login_id, T1.title, T1.l_name, T1.f_name, T1.m_name, T1.pri_designation, T1.phone_no_1, T1.phone_no_2, T1.email_id, T1.status_phone_no_1, T1.status_phone_no_2, T1.status_email_id 
										FROM ppl_general_info T1, eqp_info T2 WHERE T1.login_id = T2.contact_login_id AND T2.pid = " . real_mysql_specialchars( $pid, true );
	$eqp_general_contact_info_results = real_execute_query ( $eqp_general_contact_info_query, $db_conn );


	$gen_association_query = 	"SELECT T1.assoc_pid, T2.type_id FROM gen_association T1, gen_profile_info T2 WHERE T1.assoc_pid = T2.pid AND T1.pid = " . real_mysql_specialchars( $pid, true ) . 
								"	UNION
								SELECT T1.pid, T2.type_id FROM gen_association T1, gen_profile_info T2 WHERE T1.pid = T2.pid AND T1.assoc_pid = " . real_mysql_specialchars( $pid, true );
	$gen_association_results = real_execute_query ( $gen_association_query, $db_conn );	

	$gen_keywords_query = "SELECT keywords FROM eqp_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$gen_keywords_results = real_execute_query ( $gen_keywords_query, $db_conn );	
	$gen_keywords_rows = mysql_fetch_array( $gen_keywords_results );

?>