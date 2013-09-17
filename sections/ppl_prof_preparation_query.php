<?php
	if( $editable == true )
		$ppl_prof_preparation_query = "SELECT * FROM ppl_prof_preparation WHERE pid = " . real_mysql_specialchars( $pid, true ) . " ORDER BY year DESC";
	else
		$ppl_prof_preparation_query = "SELECT * FROM ppl_prof_preparation WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) . " ORDER BY year DESC";
	$ppl_prof_preparation_results = real_execute_query ( $ppl_prof_preparation_query, $db_conn );

	if( $editable == true )
	{
		$ppl_prof_preparation_max_id_query = "SELECT MAX( pp_id ) FROM ppl_prof_preparation WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_prof_preparation_max_id_results = real_execute_query ( $ppl_prof_preparation_max_id_query, $db_conn );
	}
?>