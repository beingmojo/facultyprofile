<?php
	$qic = "SELECT * FROM gen_ind_cluster_types ORDER BY c1 ASC, c2 ASC, c3 ASC, c4 ASC, c5 ASC";
	$qtc = "SELECT * FROM gen_tech_cluster_types ORDER BY c1 ASC, c2 ASC, c3 ASC";
	$qhc = "SELECT * FROM gen_home_cluster_types ORDER BY c1 ASC, c2 ASC, c3 ASC";
	$resic = real_execute_query($qic, $db_conn);
	$restc = real_execute_query($qtc, $db_conn);
	$reshc = real_execute_query($qhc, $db_conn);

	$quic = "SELECT * FROM gen_profile_cluster WHERE pid='$pid' AND type='1' ORDER BY cluster_id ASC";
	$resuic = real_execute_query($quic, $db_conn);
//	$noofic = mysql_num_rows($resuic);
	
	$qutc = "SELECT * FROM gen_profile_cluster WHERE pid='$pid' AND type='2' ORDER BY cluster_id ASC";
	$resutc = real_execute_query($qutc, $db_conn);
//	$nooftc = mysql_num_rows($resutc);

	$quhc = "SELECT * FROM gen_profile_cluster WHERE pid='$pid' AND type='3' ORDER BY cluster_id ASC";
	$resuhc = real_execute_query($quhc, $db_conn);
	
	while($ruic=mysql_fetch_array($resuic))
		$ind[$ruic["cluster_id"]]='1';
		
	while($rutc=mysql_fetch_array($resutc))
		$tech[$rutc["cluster_id"]]='1';
	
	while($ruhc=mysql_fetch_array($resuhc))
		$home[$ruhc["cluster_id"]]='1';	
?>
