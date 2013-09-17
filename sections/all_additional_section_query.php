<?php
	if( $editable == true )
		$all_additional_section_query = "SELECT * FROM all_additional_section 
										WHERE pid = " . real_mysql_specialchars( $pid, true ) .
										" AND section_id = " . real_mysql_specialchars( $current_sections_row[0], true ) ;
	else
		$all_additional_section_query = "SELECT * FROM all_additional_section 
								WHERE status = 0 
								AND pid = " . real_mysql_specialchars( $pid, true ) .
								" AND section_id = " . real_mysql_specialchars( $current_sections_row[0], true ) ;
										
	$all_additional_section_results[$current_sections_row[0]] = real_execute_query ( $all_additional_section_query, $db_conn );

	if( $editable == true )
	{
		$all_additional_section_max_id_query = "SELECT MAX( sub_section_id ) FROM all_additional_section 
												WHERE pid = " . real_mysql_specialchars( $pid, true ) .
												" AND section_id = " . real_mysql_specialchars( $current_sections_row[0], true ) ;
		$all_additional_section_max_id_results[$current_sections_row[0]] = real_execute_query ( $all_additional_section_max_id_query, $db_conn );
	}
?>