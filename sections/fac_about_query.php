<?php

	$fac_about_query = "SELECT T1.name, T1.description, T2.* FROM fac_info T1, fac_gen_info T2 WHERE T1.pid = T2.pid AND T1.pid = " . real_mysql_specialchars( $pid, true );
	$fac_about_results = real_execute_query ( $fac_about_query, $db_conn );

	$fac_general_contact_info_query = "SELECT T1.pid, T1.login_id, T1.title, T1.l_name, T1.f_name, T1.m_name, T1.designation, T1.phone_no_1, T1.phone_no_2, T1.email_id, T1.status_phone_no_1, T1.status_phone_no_2, T1.status_email_id 
										FROM ppl_general_info T1, fac_gen_info T2 WHERE T1.login_id = T2.contact_login_id AND T2.pid = " . real_mysql_specialchars( $pid, true );
	$fac_general_contact_info_results = real_execute_query ( $fac_general_contact_info_query, $db_conn );
	
?>