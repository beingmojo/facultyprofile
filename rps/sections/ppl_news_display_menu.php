<?php
$ppl_news_num_rows = mysql_num_rows( $ppl_news_results );

if($ppl_news_num_rows != 0 || $editable==true || $counter==1)
{
//	if( $activesection == $current_sections_row[0] )
//		print( "<li id='sideactive'>$current_sections_row[1]</li>");
//	else
		print( "<li><a href='#" .  $current_sections_row[0] . "'>$current_sections_row[1]</a></li>");
}

?>