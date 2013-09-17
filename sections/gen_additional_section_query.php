<?php
$gen_additional_sections_query = "SELECT section_id, name, status FROM gen_profile_section_additional WHERE pid = $pid";
$gen_additional_sections_results = real_execute_query( $gen_additional_sections_query, $db_conn );
$gen_additional_sections_maxid_query = "SELECT MAX(section_id) FROM gen_profile_section_additional WHERE pid = $pid";
$gen_additional_sections_maxid_results = real_execute_query( $gen_additional_sections_maxid_query, $db_conn );
$gen_additional_sections_maxid_rows = mysql_fetch_row( $gen_additional_sections_maxid_results ); 
?>