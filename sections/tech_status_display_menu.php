<?php
$tech_status_num_rows = mysql_fetch_array( $tech_status_results );
if($tech_status_num_rows["stage_status"] != "" || $tech_status_num_rows["type"] || $tech_status_num_rows["type_no"] || $editable==true)
{
	print( "<li><a href='#" .  $current_sections_row[0] . "'>$current_sections_row[1]</a></li>");
}

?>

