<?php
	if( $editable == true )
		$fac_research_query = "SELECT * FROM fac_research WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$fac_research_query = "SELECT * FROM fac_research WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) ;
	$fac_research_results = real_execute_query ( $fac_research_query, $db_conn );

	if( $editable == true )
	{
		$fac_research_max_id_query = "SELECT MAX( resch_id ) FROM fac_research WHERE pid = " . real_mysql_specialchars( $pid, true );
		$fac_research_max_id_results = real_execute_query ( $fac_research_max_id_query, $db_conn );
	}
?>