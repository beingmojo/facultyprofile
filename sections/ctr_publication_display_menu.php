<?php
$ctr_publication_num_rows = mysql_num_rows( $ctr_publication_results );
if($ctr_publication_num_rows != 0 || $editable==true)
{
//	if( $activesection == $current_sections_row[0] )
//		print( "<li id='sideactive'>$current_sections_row[1]</li>");
//	else
		print( "<li><a href='#" .  $current_sections_row[0] . "'>$current_sections_row[1]</a></li>");
}

?>
