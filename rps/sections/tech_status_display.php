<?php
if( mysql_num_rows( $tech_status_results ) > 0 )
	mysql_data_seek( $tech_status_results, 0 );
$tech_status_rows = mysql_fetch_array( $tech_status_results );
$numrows=mysql_num_rows($tech_status_results);
if($editable==true || $numrows==1)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='tech_status_view_box' class='visiblebox'>" );
		print( "<tr class='table_background'>" );
			print( "<td id='name'><span class='form_elements_section_header'>&nbsp;Development Stage/IP Status</span></td>" );
			print( "<td align='right' height='20' width='15%'>" );
			if( $editable == true )
			{	
				print( "<a href='{$_home}/help/index.php#techn_ipstatus' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"tech_status\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
		print( "<tr>" );
			print( "<td colspan='2'>" );
			print( "<table>" );
					print("<tr>");
						print( "<td width='5'></td>" );
							print( "<td align='left'>" );
							if($tech_status_rows[ "type"] != 0)						
							{
								print( "<span class='form_elements_section_subheader'>IP Status:</span>" );
								print("<span class='form_elements_text'>");
								if($tech_status_rows["type"]==1) print " Patent - # ";
								if($tech_status_rows["type"]==2) print " Patent in Application - # ";
								print htmlspecialchars($tech_status_rows["type_no"]);
								print("</span>");								
							}
							print( "</td>" );
					print("</tr>");
					print( "<tr>" );
						print( "<td width='5'></td>" );
						print( "<td align='left'>" );
						if( $tech_status_rows[ "stage_status" ] != "")					
						{
							print( "<span class='form_elements_text'>" );
							print real_rte_specialchars( $tech_status_rows[ "stage_status" ] );				
							print( "</span>" );
						}
						print ("</td>");
				print( "</tr>" );
			print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
		print( "<tr><td height='10'></td></tr>" );		
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='tech_status_edit_box' class='hiddenbox'>" );
			print( "<tr class='table_background'>" );
				print( "<td id='name' align='left'><span class='form_elements_section_header'>&nbsp;Development Stage/IP Status</span></td>" );
				print( "<td align='right' height='20' width='20%'>" );
				if( $editable == true )
				{
					print( "<a href='{$_home}/help/index.php#techn_generalinfo' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"tech_status_abstract\" );return submit_box( \"tech_status\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"tech_status\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );					
				}
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='2'>" );
				print( "<table>" );
				print( "<form id='tech_status_edit_form' method='post' action='sections/tech_status_edit_box_submit.php' >" );
					print("<tr>");
						print( "<td width='5'></td>" );
						print( "<td colspan='2' class='form_elements_section_subheader'>" );
						print( "IP Status: <select class='form_elements_edit_combo' name='tech_status_type' style='width:200px'>" );
							print( "<option value='1'" );
							if($tech_status_rows["type"]==1) print " selected";
							print( ">Patent</option>");
							print( "<option value='2'" );
							if($tech_status_rows["type"]==2) print " selected";
							print( ">Patent in Application</option>");
						print( "</select>");
						print("&nbsp;&nbsp;#: <input class='form_elements_edit' type='text' name='tech_status_no' value='".$tech_status_rows["type_no"]."' maxlength='100' style='width:100px'>");
						print( "</td>" );
					print("</tr>");
					print( "<tr>" );
						print( "<td width='5'></td>" );
						print( "<input type='hidden' name='clicked' value='0' />" );						
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<td colspan='2'>" );
						print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
						print( "writeRichText('tech_status_abstract', 'tech_status_abstract', '" . real_rte_specialchars( $tech_status_rows["stage_status"] ) . "', 600, 150, true, false, true);" );
						print( "</script>" );						
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