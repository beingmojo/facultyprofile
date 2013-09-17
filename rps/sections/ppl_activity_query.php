<?php
	if( $editable == true )
		$ppl_activity_query = "SELECT * FROM ppl_activity WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ppl_activity_query = "SELECT * FROM ppl_activity WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) ;
	$ppl_activity_results = real_execute_query ( $ppl_activity_query, $db_conn );

	if( $editable == true )
	{
		$ppl_activity_max_id_query = "SELECT MAX( act_id ) FROM ppl_activity WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_activity_max_id_results = real_execute_query ( $ppl_activity_max_id_query, $db_conn );
	}

?>