<?php
$tech_benefits_num_rows = mysql_fetch_array( $tech_benefits_results );
if($tech_benefits_num_rows["description"] != "" || $editable==true)
{
	print( "<li><a href='#" .  $current_sections_row[0] . "'>$current_sections_row[1]</a></li>");
}

?>

