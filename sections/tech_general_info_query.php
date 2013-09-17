<?
	$tech_general_info_query = "SELECT * FROM tech_gen_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$tech_general_info_results = real_execute_query ( $tech_general_info_query, $db_conn );

	$tech_general_contact_info_query = "SELECT * FROM gen_tech_office_info";
	$tech_general_contact_info_results = real_execute_query ($tech_general_contact_info_query, $db_conn);

	$gen_keywords_query = "SELECT keywords FROM tech_gen_info WHERE pid = " . real_mysql_specialchars( $pid, true );
	$gen_keywords_results = real_execute_query ( $gen_keywords_query, $db_conn );	
	$gen_keywords_rows = mysql_fetch_array( $gen_keywords_results );

?>