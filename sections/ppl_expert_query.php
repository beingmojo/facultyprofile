<?php
	if( $editable == true )
		$ppl_expert_query = "SELECT * FROM ppl_expert WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ppl_expert_query = "SELECT * FROM ppl_expert WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) ;
	$ppl_expert_results = real_execute_query ( $ppl_expert_query, $db_conn );

	if( $editable == true )
	{
		$ppl_expert_max_id_query = "SELECT MAX( exp_id ) FROM ppl_expert WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_expert_max_id_results = real_execute_query ( $ppl_expert_max_id_query, $db_conn );
	}

?>