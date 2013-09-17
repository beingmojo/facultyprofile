<?php
$tech_applications_num_rows = mysql_fetch_array( $tech_applications_results );
if($tech_applications_num_rows["description"] != "" || $editable==true)
{
	print( "<li><a href='#" .  $current_sections_row[0] . "'>$current_sections_row[1]</a></li>");
}

?>
