<?php
	$gen_activate_profile_query = "SELECT status FROM gen_profile_info WHERE pid=".real_mysql_specialchars( $pid, true );
	$gen_activate_profile_results = mysql_query($gen_activate_profile_query, $db_conn);
?>