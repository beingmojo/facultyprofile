<?php
	if( $editable == true )
		$ppl_course_query = "SELECT * FROM ppl_course WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ppl_course_query = "SELECT * FROM ppl_course WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) ;
	$ppl_course_results = real_execute_query ( $ppl_course_query, $db_conn );

	if( $editable == true )
	{
		$ppl_course_max_id_query = "SELECT MAX( course_id ) FROM ppl_course WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_course_max_id_results = real_execute_query ( $ppl_course_max_id_query, $db_conn );
	}

?>