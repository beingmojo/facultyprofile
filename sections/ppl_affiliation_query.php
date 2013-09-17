<?php
	if( $editable == true )
		$ppl_affiliation_query = "SELECT * FROM ppl_affiliation WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ppl_affiliation_query = "SELECT * FROM ppl_affiliation WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) ;
	$ppl_affiliation_results = real_execute_query ( $ppl_affiliation_query, $db_conn );

	if( $editable == true )
		$ppl_affiliation_category_query = "SELECT DISTINCT type FROM ppl_affiliation WHERE pid = " . real_mysql_specialchars( $pid, true ) . " ORDER BY type ";
	else
		$ppl_affiliation_category_query = "SELECT DISTINCT type FROM ppl_affiliation WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, false ) . " ORDER BY type ";
	$ppl_affiliation_category_results = real_execute_query ( $ppl_affiliation_category_query, $db_conn );

	if( $editable == true )
	{
		$ppl_affiliation_max_id_query = "SELECT MAX( aff_id ) FROM ppl_affiliation WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_affiliation_max_id_results = real_execute_query ( $ppl_affiliation_max_id_query, $db_conn );
	}

?>