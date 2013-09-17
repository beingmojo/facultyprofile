<?php
	if( $editable == true )
		$ppl_research_query = "SELECT * FROM ppl_research WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ppl_research_query = "SELECT * FROM ppl_research WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) ;
	$ppl_research_results = real_execute_query ( $ppl_research_query, $db_conn );

	if( $editable == true )
	{
		$ppl_research_max_id_query = "SELECT MAX( resch_id ) FROM ppl_research WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_research_max_id_results = real_execute_query ( $ppl_research_max_id_query, $db_conn );
	}
?>