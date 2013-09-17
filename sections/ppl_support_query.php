<?php
	if( $editable == true )
		$ppl_support_query = "SELECT * FROM ppl_support WHERE pid = " . real_mysql_specialchars( $pid, true ) . " ORDER BY RIGHT(e_date, 4) DESC, RIGHT(s_date, 4 ) DESC";
	else
		$ppl_support_query = "SELECT * FROM ppl_support WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) . " ORDER BY RIGHT(e_date, 4) DESC, RIGHT(s_date, 4 ) DESC";
	$ppl_support_results = real_execute_query ( $ppl_support_query, $db_conn );
	if( $editable == true )
	{
		$ppl_support_max_id_query = "SELECT MAX( sup_id ) FROM ppl_support WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_support_max_id_results = real_execute_query ( $ppl_support_max_id_query, $db_conn );
	}

?>