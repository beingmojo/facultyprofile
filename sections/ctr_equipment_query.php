<?php
	$ctr_equipment_query = "SELECT T1.eqp_id, T1.eqp_pid, T1.name, T1.description, T1.image_id, T1.url, T1.url_name, T1.cost, T1.value, T1.status FROM ctr_equipment T1 WHERE eqp_pid = 0 AND T1.pid = " . real_mysql_specialchars( $pid, true );
	if( $editable != true )
		$ctr_equipment_query = $ctr_equipment_query . " AND status = 0 ";
	$ctr_equipment_query = $ctr_equipment_query . " UNION
							SELECT T1.eqp_id, T1.eqp_pid, T2.name, T2.description, T2.image_id, T2.url, T2.url_name, T2.cost, T2.value, T3.status FROM ctr_equipment T1, eqp_info T2, gen_profile_info T3 
							WHERE T1.pid="  . real_mysql_specialchars( $pid, true ) . " AND T1.eqp_pid = T2.pid AND T2.pid = T3.pid AND T3.status = 0";

	$ctr_equipment_results = real_execute_query ( $ctr_equipment_query, $db_conn );

	if( $editable == true )
	{
		$ctr_equipment_max_id_query = "SELECT MAX( eqp_id ) FROM ctr_equipment WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ctr_equipment_max_id_results = real_execute_query ( $ctr_equipment_max_id_query, $db_conn );
	}
?>

