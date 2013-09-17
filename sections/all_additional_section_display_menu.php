<?php
$all_additional_section_num_rows[$current_sections_row[0]] = mysql_num_rows( $all_additional_section_results[$current_sections_row[0]] );
if($all_additional_section_num_rows[$current_sections_row[0]] != 0 || $editable==true)
{
//	if( $activesection == $current_sections_row[0] )
//		print( "<li id='sideactive'>$current_sections_row[1]</li>");
//	else
		print( "<li><a href='#" .  $current_sections_row[0] . "'>".htmlspecialchars($current_sections_row[1])."</a></li>");
}

?>
