<?php
	$gen_editor_info_id_query = "SELECT user1_login_id, user2_login_id, user1_name, user2_name FROM gen_profile_info WHERE pid=".real_mysql_specialchars( $pid, true );
	$gen_editor_info_id_results = mysql_query($gen_editor_info_id_query, $db_conn);
	$gen_editor_info_id_rows = mysql_fetch_array($gen_editor_info_id_results);
	
?>