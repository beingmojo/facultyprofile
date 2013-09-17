<?php
	if( $editable == true )
		$ppl_appointment_query = "SELECT * FROM ppl_appointment WHERE pid = " . real_mysql_specialchars( $pid, true ) . " ORDER BY e_date DESC, s_date DESC";
	else
		$ppl_appointment_query = "SELECT * FROM ppl_appointment WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) . " ORDER BY e_date DESC, s_date DESC" ;
	$ppl_appointment_results = real_execute_query ( $ppl_appointment_query, $db_conn );

	if( $editable == true )
	{
		$ppl_appointment_max_id_query = "SELECT MAX( app_id ) FROM ppl_appointment WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_appointment_max_id_results = real_execute_query ( $ppl_appointment_max_id_query, $db_conn );
	}

?>