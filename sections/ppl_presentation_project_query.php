<?php
if( $_SESSION["ppl_pres_proj_s_date_sort_order"] == "" )
	$_SESSION["ppl_pres_proj_s_date_sort_order"] = "desc";
if( $_SESSION["ppl_pres_proj_e_date_sort_order"] == "" )
	$_SESSION["ppl_pres_proj_e_date_sort_order"] = "desc";
if( $_SESSION["ppl_pres_proj_curr_sort_field"] == "" )
	$_SESSION["ppl_pres_proj_curr_sort_field"] = "s_date";
if( $_SESSION["ppl_pres_proj_recs"] == "" )
	$_SESSION["ppl_pres_proj_recs"]=5;

$ppl_pres_proj_page=1;

if( $_GET["ppl_pres_proj_s_date_sort_order"] == "asc" || $_GET["ppl_pres_proj_s_date_sort_order"] == "desc" )
	$_SESSION["ppl_pres_proj_s_date_sort_order"] = $_GET["ppl_pres_proj_s_date_sort_order"];
if( $_GET["ppl_pres_proj_e_date_sort_order"] == "asc" || $_GET["ppl_pres_proj_e_date_sort_order"] == "desc" )
	$_SESSION["ppl_pres_proj_e_date_sort_order"] = $_GET["ppl_pres_proj_e_date_sort_order"];
if( $_GET["ppl_pres_proj_curr_sort_field"] == "s_date" || $_GET["ppl_pres_proj_curr_sort_field"] == "e_date" )
	$_SESSION["ppl_pres_proj_curr_sort_field"] = $_GET["ppl_pres_proj_curr_sort_field"];

if( $_GET["ppl_pres_proj_recs"] != "" && $_GET["ppl_pres_proj_recs"] > 0 )
	$_SESSION["ppl_pres_proj_recs"] = $_GET["ppl_pres_proj_recs"] ;
if( $_GET["ppl_pres_proj_page"] != "" && $_GET["ppl_pres_proj_page"] > 0 )
	$ppl_pres_proj_page = $_GET["ppl_pres_proj_page"] ;

$ppl_pres_proj_s_date_sort_order = $_SESSION["ppl_pres_proj_s_date_sort_order"];
$ppl_pres_proj_e_date_sort_order = $_SESSION["ppl_pres_proj_e_date_sort_order"];
$ppl_pres_proj_curr_sort_field = $_SESSION["ppl_pres_proj_curr_sort_field"];

$ppl_pres_proj_recs = $_SESSION["ppl_pres_proj_recs"];

if( $editable == true )
	$ppl_presentation_project_query = "SELECT COUNT(1) FROM ppl_presentation_project WHERE pid = " . real_mysql_specialchars( $pid, true );
else
	$ppl_presentation_project_query = "SELECT COUNT(1) FROM ppl_presentation_project WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, false ) ;



$ppl_presentation_project_results = real_execute_query ( $ppl_presentation_project_query, $db_conn );
$row = mysql_fetch_row( $ppl_presentation_project_results );

$ppl_pres_proj_max_pages = ceil( $row[0] / $ppl_pres_proj_recs ) ;

if( $row[0] <=  ( ($ppl_pres_proj_page - 1) * $ppl_pres_proj_recs ) )
{
	$ppl_pres_proj_page =  $ppl_pres_proj_max_pages ;
}

	if( $editable == true )
		$ppl_presentation_project_query = "SELECT * FROM ppl_presentation_project WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ppl_presentation_project_query = "SELECT * FROM ppl_presentation_project WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, false ) ;


	$ppl_presentation_project_query = $ppl_presentation_project_query . " ORDER BY  ";
	
	if( $ppl_pres_proj_curr_sort_field == "s_date" )
	{
		$ppl_presentation_project_query = $ppl_presentation_project_query . 
			" s_date $ppl_pres_proj_s_date_sort_order, e_date $ppl_pres_proj_e_date_sort_order";
	}
	elseif( $ppl_pres_proj_curr_sort_field == "e_date" )
	{
		$ppl_presentation_project_query = $ppl_presentation_project_query . 
			" e_date $ppl_pres_proj_e_date_sort_order, s_date $ppl_pres_proj_s_date_sort_order";
	}

	if( $ppl_pres_proj_page > 0 )
		$ppl_presentation_project_query = $ppl_presentation_project_query . " LIMIT " . ( $ppl_pres_proj_page - 1 ) * $ppl_pres_proj_recs . ", " . $ppl_pres_proj_recs;

	$ppl_presentation_project_results = real_execute_query ( $ppl_presentation_project_query, $db_conn );

	if( $editable == true )
	{
		$ppl_presentation_project_max_id_query = "SELECT MAX( pr_id ) FROM ppl_presentation_project WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_presentation_project_max_id_results = real_execute_query ( $ppl_presentation_project_max_id_query, $db_conn );
	}
?>