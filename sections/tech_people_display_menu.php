<?php
$tech_people_num_rows = mysql_num_rows( $tech_people_results );
if($tech_people_num_rows != 0 || $editable==true)
{
	print( "<li><a href='#" .  $current_sections_row[0] . "'>$current_sections_row[1]</a></li>");
}

?>
