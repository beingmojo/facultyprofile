<?php
	$fac_people_query = "SELECT T1.ppl_id, CONCAT( T1.title, IF(T1.title<>'', ' ', '') , T1.l_name, IF(T1.f_name<>'', ', ', '') , 	T1.f_name, IF(T1.m_name<>'', ' ', '') , T1.m_name ) as name,
						T1.rank, T1.ppl_login_id as login_id, 0 AS ppl_pid, T1.title, T1.l_name, T1.f_name, T1.m_name FROM fac_people T1 WHERE ppl_login_id = '' AND T1.pid = " . real_mysql_specialchars( $pid, true ) .
						" UNION
						SELECT T1.ppl_id, CONCAT( T2.title, IF(T2.title<>'', ' ', '') , T2.l_name, IF(T2.f_name<>'', ', ', '') , 	T2.f_name, IF(T2.m_name<>'', ' ', '') , T2.m_name ) as name,
						T2.designation as rank, T2.login_id, T3.pid, T2.title, T2.l_name, T2.f_name, T2.m_name FROM fac_people T1, ppl_general_info T2, gen_profile_info T3
						WHERE T1.ppl_login_id = T2.login_id AND T2.pid = T3.pid AND T3.status = 0 AND T1.pid= " . real_mysql_specialchars( $pid, true ) .
						" UNION
						SELECT T1.ppl_id, CONCAT( T1.title, IF(T1.title<>'', ' ', '') , T1.l_name, IF(T1.f_name<>'', ', ', '') , 	T1.f_name, IF(T1.m_name<>'', ' ', '') , T1.m_name ) as name,
						T1.rank, T1.ppl_login_id as login_id, 0 AS ppl_pid, T1.title, T1.l_name, T1.f_name, T1.m_name FROM fac_people T1
						LEFT JOIN ppl_general_info T2 ON T1.ppl_login_id =T2.login_id
						WHERE ppl_login_id <> '' AND T2.login_id IS NULL AND T1.pid = " . real_mysql_specialchars( $pid, true ) .
						" ORDER BY l_name";
	$fac_people_results = real_execute_query ( $fac_people_query, $db_conn );

	if( $editable == true )
	{
		$fac_people_max_id_query = "SELECT MAX( ppl_id ) FROM fac_people WHERE pid = " . real_mysql_specialchars( $pid, true );
		$fac_people_max_id_results = real_execute_query ( $fac_people_max_id_query, $db_conn );
	}
?>
