<?php
	if( $editable == true )
		$ctr_research_query = "SELECT * FROM ctr_research WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ctr_research_query = "SELECT * FROM ctr_research WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) ;
	$ctr_research_results = real_execute_query ( $ctr_research_query, $db_conn );

	if( $editable == true )
	{
		$ctr_research_max_id_query = "SELECT MAX( resch_id ) FROM ctr_research WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ctr_research_max_id_results = real_execute_query ( $ctr_research_max_id_query, $db_conn );
	}
?>