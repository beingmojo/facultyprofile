<?php
	if( $editable == true )
		$ppl_additional_query = "SELECT * FROM ppl_additional WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ppl_additional_query = "SELECT * FROM ppl_additional WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) ;
	$ppl_additional_results = real_execute_query ( $ppl_additional_query, $db_conn );

	if( $editable == true )
	{
		$ppl_additional_max_id_query = "SELECT MAX( add_id ) FROM ppl_additional WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_additional_max_id_results = real_execute_query ( $ppl_additional_max_id_query, $db_conn );
	}

?>