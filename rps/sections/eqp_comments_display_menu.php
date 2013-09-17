<?php
$eqp_comments_rows = mysql_fetch_array( $eqp_comments_results );
if($eqp_comments_rows["comments"] != "" || $editable==true)
{
//	if( $activesection == $current_sections_row[0] )
//		print( "<li id='sideactive'>$current_sections_row[1]</li>");
//	else
		print( "<li><a href='#" .  $current_sections_row[0] . "'>$current_sections_row[1]</a></li>");
}

?>
