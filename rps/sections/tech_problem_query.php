<?php
	$tech_problem_query = "SELECT * FROM tech_problem WHERE pid = " . real_mysql_specialchars( $pid, true ) ;
	$tech_problem_results = real_execute_query ( $tech_problem_query, $db_conn );
/*
	if( $editable == true )
	{
		$ppl_abstract_max_id_query = "SELECT MAX( resch_id ) FROM ppl_research WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_research_max_id_results = real_execute_query ( $ppl_research_max_id_query, $db_conn );
	}
*/
?>