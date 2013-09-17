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
if( $_GET["ppl_pub_curr_sort_field"] == "year" || $_GET["ppl_pub_curr_sort_field"] == "rank" )
	$_SESSION["ppl_pub_curr_sort_field"] = $_GET["ppl_pub_curr_sort_field"];

if( $_GET["ppl_pub_recs"] != "" && $_GET["ppl_pub_recs"] > 0 )
	$_SESSION["ppl_pub_recs"] = $_GET["ppl_pub_recs"] ;
if( $_GET["ppl_pub_page"] != "" && $_GET["ppl_pub_page"] > 0 )
	$ppl_pub_page = $_GET["ppl_pub_page"] ;
$ppl_pub_category = $_GET["ppl_pub_category"];

$ppl_pub_year_sort_order = $_SESSION["ppl_pub_year_sort_order"];
$ppl_pub_rank_sort_order = $_SESSION["ppl_pub_rank_sort_order"];
$ppl_pub_curr_sort_field = $_SESSION["ppl_pub_curr_sort_field"];

$ppl_pub_recs = $_SESSION["ppl_pub_recs"];

if( $editable == true )
	$fac_publication_query = "SELECT COUNT(1) FROM fac_publication WHERE pid = " . real_mysql_specialchars( $pid, true );
else
	$fac_publication_query = "SELECT COUNT(1) FROM fac_publication WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, false ) ;

if( $ppl_pub_category != "" )
		$fac_publication_query = $fac_publication_query . " AND group_by = '$ppl_pub_category' " ;


$fac_publication_results = real_execute_query ( $fac_publication_query, $db_conn );
$row = mysql_fetch_row( $fac_publication_results );

$ppl_pub_max_pages = ceil( $row[0] / $ppl_pub_recs ) ;

if( $row[0] <=  ( ($ppl_pub_page - 1) * $ppl_pub_recs ) )
{
	$ppl_pub_page =  $ppl_pub_max_pages ;
}

	if( $editable == true )
		$fac_publication_query = "SELECT * FROM fac_publication WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$fac_publication_query = "SELECT * FROM fac_publication WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, false ) ;

	if( $ppl_pub_category != "" )
		$fac_publication_query = $fac_publication_query . " AND group_by = '$ppl_pub_category' " ;

	$fac_publication_query = $fac_publication_query . " ORDER BY  ";
	
	if( $ppl_pub_curr_sort_field == "year" )
		$fac_publication_query = $fac_publication_query . " year $ppl_pub_year_sort_order, ranking  $ppl_pub_rank_sort_order ";

	if( $ppl_pub_curr_sort_field == "rank" )
		$fac_publication_query = $fac_publication_query . " ranking $ppl_pub_rank_sort_order, year  $ppl_pub_year_sort_order ";

	if( $ppl_pub_page > 0 )
		$fac_publication_query = $fac_publication_query . " LIMIT " . ( $ppl_pub_page - 1 ) * $ppl_pub_recs . ", " . $ppl_pub_recs;

	$fac_publication_results = real_execute_query ( $fac_publication_query, $db_conn );

	if( $editable == true )
		$fac_publication_category_query = "SELECT DISTINCT group_by FROM fac_publication WHERE pid = " . real_mysql_specialchars( $pid, true ) . " ORDER BY group_by ";
	else
		$fac_publication_category_query = "SELECT DISTINCT group_by FROM fac_publication WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, false ) . " ORDER BY group_by ";
		
	$fac_publication_category_results = real_execute_query ( $fac_publication_category_query, $db_conn );

	if( $editable == true )
	{
		$fac_publication_max_id_query = "SELECT MAX( pub_id ) FROM fac_publication WHERE pid = " . real_mysql_specialchars( $pid, true );
		$fac_publication_max_id_results = real_execute_query ( $fac_publication_max_id_query, $db_conn );
	}
		
?>