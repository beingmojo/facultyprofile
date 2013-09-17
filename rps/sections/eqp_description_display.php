<?php
mysql_data_seek( $eqp_description_results, 0 );
$eqp_description_rows = mysql_fetch_array( $eqp_description_results );
if($eqp_description_rows["description"] != "" || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='eqp_description_view_box' class='visiblebox'>" );
		print( "<tr class='table_background'>" );
			print( "<td id='name'><span class='form_elements_section_header'>&nbsp;Description</span></td>" );
			print( "<td align='right' height='20' width='15%'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#equip_desc&details' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				
				print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"eqp_description\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
		print( "<tr>" );
			print( "<td colspan='2'>" );
			print( "<table>" );
				if( $eqp_description_rows["cost"] != "" )
				{
					print( "<tr>" );
						print( "<td width='5'></td>" );
						print( "<td>" );
						print( "Value: " . htmlspecialchars( $eqp_description_rows["cost"], ENT_QUOTES) );
						print( "</td>" );
					print( "</tr>" );
				}
			
				print( "<tr>" );
					print( "<td width='5'></td>" );
					print( "<td align='left'>" );
					if( $eqp_description_rows[ "description" ] != "" )
					{
						print( "<span class='form_elements_text'>" );
						echo real_rte_specialchars( $eqp_description_rows[ "description" ] );				
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
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='eqp_description_edit_box' class='hiddenbox'>" );
			print( "<tr class='table_background'>" );
				print( "<td id='name' align='left'><span class='form_elements_section_header'>&nbsp;Description</span></td>" );
				print( "<td align='right' height='20' width='20%'>" );
				if( $editable == true )
				{

					print( "<a href='{$_home}/help/index.php#equip_desc&details' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				
					
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"eqp_description\" ); return submit_box( \"eqp_description\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"eqp_description\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );					
				}
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='2'>" );
				print( "<table>" );
					print( "<form id='eqp_description_edit_form' method='post' action='sections/eqp_description_edit_box_submit.php' >" );
					print( "<input type='hidden' name='clicked' value='0' />" );						
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<tr>" );
						print( "<td width='5'></td>" );
						print( "<td colspan='2'>" );
						print( "Value&nbsp;&nbsp;<input class='form_elements_edit' name='eqp_cost' type='text' size='10' maxlenth='32' style='text-align:right' value='". htmlspecialchars( $eqp_description_rows["cost"], ENT_QUOTES) ."'>" );
						$selected = $eqp_description_rows["value"] == 0 ? "checked" : "";
						print( "&nbsp;&nbsp;<input type='radio' name='eqp_value' value='0' $selected>Less than $100,000" );
						$selected = $eqp_description_rows["value"] == 1 ? "checked" : "";
						print( "&nbsp;&nbsp;<input type='radio' name='eqp_value' value='1' $selected>Greater than or equal to $100,000 " );
						print( "</td>" );
					print( "</tr>" );

					print( "<tr>" );
						print( "<td width='5'></td>" );
						print( "<td colspan='2'>" );
						print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
						print( "writeRichText('eqp_description', 'eqp_description', '" . real_rte_specialchars( $eqp_description_rows[ "description" ] ) . "', 600, 150, true, false, true);" );
						print( "</script>" );
//						print( "<textarea class='form_elements_text' name='eqp_description' cols='120' rows='10'>" . htmlspecialchars( $eqp_description_rows[ "description" ], ENT_QUOTES ) . "</textarea>" );
						print( "</td>" );
					print( "</tr>" );
					print( "</form>" );
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr><td height='10'></td></tr>" );		
		print( "</table>" );
	}
}
?>