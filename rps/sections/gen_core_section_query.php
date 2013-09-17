<?php
$gen_core_sections_query = "SELECT T1.section_id, T2.name, T1.status 
							FROM gen_profile_section T1, gen_section_types T2, gen_profile_info T3  
							WHERE  T1.section_id = T2.section_id 
									AND T2.type_id = T3.type_id 
									AND T1.pid = T3.pid 
									AND T1.pid = $pid
							ORDER BY T2.order_no";

$gen_core_sections_results = real_execute_query( $gen_core_sections_query, $db_conn );


?>