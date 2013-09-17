<?php

	$ctr_about_query = "SELECT T1.name, T1.description, T2.* FROM ctr_info T1, ctr_gen_info T2 WHERE T1.pid = T2.pid AND T1.pid = " . real_mysql_specialchars( $pid, true );
	$ctr_about_results = real_execute_query ( $ctr_about_query, $db_conn );

	$ctr_general_contact_info_query = "SELECT T1.pid, T1.login_id, T1.title, T1.l_name, T1.f_name, T1.m_name, T1.pri_designation, T1.phone_no_1, T1.phone_no_2, T1.email_id, T1.status_phone_no_1, T1.status_phone_no_2, T1.status_email_id 
										FROM ppl_general_info T1, ctr_gen_info T2 WHERE T1.login_id = T2.contact_login_id AND T2.pid = " . real_mysql_specialchars( $pid, true );
	$ctr_general_contact_info_results = real_execute_query ( $ctr_general_contact_info_query, $db_conn );

	$ctr_years_query = "SELECT start_year, end_year FROM gen_years";
	$ctr_years_results = real_execute_query ( $ctr_years_query, $db_conn );
	
	$gen_keywords_query = "SELECT keywords FROM ctr_gen_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$gen_keywords_results = real_execute_query ( $gen_keywords_query, $db_conn );	
	$gen_keywords_rows = mysql_fetch_array( $gen_keywords_results );
	
?>