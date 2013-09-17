<?php
mysql_data_seek( $ctr_accomplishment_results, 0 );
$ctr_accomplishment_rows = mysql_fetch_array( $ctr_accomplishment_results );
if($ctr_accomplishment_rows["accomplishment"] != "" || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_accomplishment_view_box' class='visiblebox'>" );
		print( "<tr class='table_background'>" );
			print( "<td id='name'><span class='form_elements_section_header'>&nbsp;" .$current_sections_row[1]. "</span></td>" );
			print( "<td align='right' height='20' width='15%'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#recen_accomplishments' target='_blank' style='text-decoration:none' ><img alt='Help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"ctr_accomplishment\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
		print( "<tr>" );
			print( "<td colspan='2'>" );
			print( "<table>" );
				print( "<tr>" );
					print( "<td width='5'></td>" );
					print( "<td align='left'>" );
					if( $ctr_accomplishment_rows[ "accomplishment" ] != "" )
					{
						print( "<span class='form_elements_text'>" );
						echo real_rte_specialchars($ctr_accomplishment_rows["accomplishment"]);				
						print( "</span>" );
					}
				print( "</tr>" );
			print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
		print( "<tr><td height='10'></td></tr>" );		
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_accomplishment_edit_box' class='hiddenbox'>" );
			print( "<tr class='table_background'>" );
				print( "<td id='name' align='left'><span class='form_elements_section_header'>&nbsp;".$current_sections_row[1]."</span></td>" );
				print( "<td align='right' height='20' width='20%'>" );
				if( $editable == true )
				{	
   					print( "<a href='{$_home}/help/index.php#recen_accomplishments' target='_blank' style='text-decoration:none' ><img alt='Help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

					print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ctr_accomplishment\" ); return submit_box( \"ctr_accomplishment\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"ctr_accomplishment\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );					
				}
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='2'>" );
				print( "<table>" );
					print( "<tr>" );
						print( "<td width='5'></td>" );
						print( "<form id='ctr_accomplishment_edit_form' method='post' action='sections/ctr_accomplishment_edit_box_submit.php' >" );
						print( "<input type='hidden' name='clicked' value='0' />" );						
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<td colspan='2'>" );
						print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
						print( "writeRichText('ctr_accomplishment', 'ctr_accomplishment', '" . real_rte_specialchars( $ctr_accomplishment_rows[ "accomplishment" ] ) . "', 600, 150, true, false, true);" );
						print( "</script>" );
//						print( "<textarea class='form_elements_text' name='ctr_accomplishment' cols='120' rows='10'>" . htmlspecialchars( $ctr_accomplishment_rows[ "accomplishment" ], ENT_QUOTES ) . "</textarea>" );
						print( "</td>" );
						print( "</form>" );
					print( "</tr>" );
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr><td height='10'></td></tr>" );		
		print( "</table>" );
	}
}
?>