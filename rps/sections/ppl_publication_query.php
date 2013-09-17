<?php
//session_start();
if( $_SESSION["ppl_pub_year_sort_order"] == "" )
	$_SESSION["ppl_pub_year_sort_order"] = "desc";
if( $_SESSION["ppl_pub_rank_sort_order"] == "" )
	$_SESSION["ppl_pub_rank_sort_order"]="desc";
if( $_SESSION["ppl_pub_curr_sort_field"] == "" )
	$_SESSION["ppl_pub_curr_sort_field"] = "year";
if( $_SESSION["ppl_pub_recs"] == "" )
	$_SESSION["ppl_pub_recs"]=5;

$ppl_pub_page=1;

if( $_GET["ppl_pub_year_sort_order"] == "asc" || $_GET["ppl_pub_year_sort_order"] == "desc" )
	$_SESSION["ppl_pub_year_sort_order"] = $_GET["ppl_pub_year_sort_order"];
if( $_GET["ppl_pub_rank_sort_order"] == "asc" || $_GET["ppl_pub_rank_sort_order"] == "desc" )
	$_SESSION["ppl_pub_rank_sort_order"] = $_GET["ppl_pub_rank_sort_order"];
if( $_GET["ppl_pub_type_sort_order"] == "asc" || $_GET["ppl_pub_type_sort_order"] == "desc" )
	$_SESSION["ppl_pub_type_sort_order"] = $_GET["ppl_pub_type_sort_order"];
if( $_GET["ppl_pub_curr_sort_field"] == "year" || $_GET["ppl_pub_curr_sort_field"] == "rank" || $_GET["ppl_pub_curr_sort_field"] == "type" )
	$_SESSION["ppl_pub_curr_sort_field"] = $_GET["ppl_pub_curr_sort_field"];

if( $_GET["ppl_pub_recs"] != "" && $_GET["ppl_pub_recs"] > 0 )
	$_SESSION["ppl_pub_recs"] = $_GET["ppl_pub_recs"] ;
if( $_GET["ppl_pub_page"] != "" && $_GET["ppl_pub_page"] > 0 )
	$ppl_pub_page = $_GET["ppl_pub_page"] ;
$ppl_pub_category = $_GET["ppl_pub_category"];
$ppl_pub_type_id = $_GET["ppl_pub_type_id"];

$ppl_pub_year_sort_order = $_SESSION["ppl_pub_year_sort_order"];
$ppl_pub_rank_sort_order = $_SESSION["ppl_pub_rank_sort_order"];
$ppl_pub_type_sort_order = $_SESSION["ppl_pub_type_sort_order"];
$ppl_pub_curr_sort_field = $_SESSION["ppl_pub_curr_sort_field"];

$ppl_pub_recs = $_SESSION["ppl_pub_recs"];

if( $editable == true )
	$ppl_publication_query = "SELECT COUNT(1) FROM ppl_publication WHERE pid = " . real_mysql_specialchars( $pid, true );
else
	$ppl_publication_query = "SELECT COUNT(1) FROM ppl_publication WHERE pid = " . real_mysql_specialchars( $pid, false ) ;

if( $ppl_pub_category != "" )
		$ppl_publication_query = $ppl_publication_query . " AND group_by = '$ppl_pub_category' " ;


$ppl_publication_results = real_execute_query ( $ppl_publication_query, $db_conn );
$row = mysql_fetch_row( $ppl_publication_results );

$ppl_pub_max_pages = ceil( $row[0] / $ppl_pub_recs ) ;

if( $row[0] <=  ( ($ppl_pub_page - 1) * $ppl_pub_recs ) )
{
	$ppl_pub_page =  $ppl_pub_max_pages ;
}

	if( $editable == true )
		$ppl_publication_query = "SELECT * FROM (ppl_publication AS t1 LEFT JOIN ppl_publication_types AS t2 USING (type_id)) LEFT JOIN ppl_publication_pub_status AS t3 ON (t1.pub_status_id = t3.pub_status_id) WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ppl_publication_query = "SELECT * FROM (ppl_publication AS t1 LEFT JOIN ppl_publication_types AS t2 USING (type_id)) LEFT JOIN ppl_publication_pub_status AS t3 ON (t1.pub_status_id = t3.pub_status_id) WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, false ) ;

	if( $ppl_pub_category != "" )
		$ppl_publication_query = $ppl_publication_query . " AND group_by = '$ppl_pub_category' " ;
	if( $ppl_pub_type_id != "" )
		$ppl_publication_query = $ppl_publication_query . " AND t1.type_id = '$ppl_pub_type_id' " ;

	$ppl_publication_query = $ppl_publication_query . " ORDER BY  ";
	
	if( $ppl_pub_curr_sort_field == "year" )
		$ppl_publication_query = $ppl_publication_query . " year $ppl_pub_year_sort_order, ranking  $ppl_pub_rank_sort_order ";
	elseif( $ppl_pub_curr_sort_field == "rank" )
		$ppl_publication_query = $ppl_publication_query . " ranking $ppl_pub_rank_sort_order, year  $ppl_pub_year_sort_order ";
	elseif( $ppl_pub_curr_sort_field == "type" )
		$ppl_publication_query = $ppl_publication_query . " type $ppl_pub_type_sort_order, year  $ppl_pub_year_sort_order ";

	if( $ppl_pub_page > 0 )
		$ppl_publication_query = $ppl_publication_query . " LIMIT " . ( $ppl_pub_page - 1 ) * $ppl_pub_recs . ", " . $ppl_pub_recs;

	$ppl_publication_results = real_execute_query ( $ppl_publication_query, $db_conn );

	if( $editable == true )
		$ppl_publication_category_query = "SELECT DISTINCT group_by FROM ppl_publication WHERE pid = " . real_mysql_specialchars( $pid, true ) . " ORDER BY group_by ";
	else
		$ppl_publication_category_query = "SELECT DISTINCT group_by FROM ppl_publication WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, false ) . " ORDER BY group_by ";
		
	$ppl_publication_category_results = real_execute_query ( $ppl_publication_category_query, $db_conn );

	if( $editable == true )
	{
		$ppl_publication_max_id_query = "SELECT MAX( pub_id ) FROM ppl_publication WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_publication_max_id_results = real_execute_query ( $ppl_publication_max_id_query, $db_conn );
	}
		
?>