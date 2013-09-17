<?php
$fac_equipment_num_rows = mysql_num_rows( $fac_equipment_results );
if($fac_equipment_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_equipment_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			//if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='fac_equipment_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"fac_equipment\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='fac_equipment_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"fac_equipment\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Equipment(s)</span></td>" );
			print( "<form name='fac_equipment_delete_form' id='fac_equipment_delete_form' method='post' action='sections/fac_equipment_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{	
				print( "<a href='{$_home}/help/index.php#facil_euipment' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				
	
				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"fac_equipment\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"fac_equipment\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_equipment_add_box' class='hiddenbox'>" );
		$fac_equipment_max_id_rows = mysql_fetch_row( $fac_equipment_max_id_results );
		$max_eqp_id = $fac_equipment_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form id='fac_equipment_add_form' method='post' action='sections/fac_equipment_add_box_submit.php' >" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='view' value='$view' />" );
		print( "<input type='hidden' name='max_eqp_id' value='$max_eqp_id' />" );		
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<td>" );
		print( "<span class='form_elements_text'>" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td> &nbsp; Find existing profiles to add them to the list of Equipments</td>" );
				print( "<td width='20%' align='right'>" );
				
				
				print( "<a href='#' style='text-decoration:none' onclick='fpUpdateRows( \"fac_equipment_add_form\", \"fac_equipment_find\" ); return submit_box( \"fac_equipment\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"fac_equipment\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr >" );
				print( "<td colspan='2'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "createFindProfileTable('fac_equipment_find', 'eqp', -1);" );
				print( "</script>" );

				print( "</td>" );
			print( "</tr>" );
			print( "<tr><td colspan='2'><HR></td></tr>" );						
			print( "</table>" );
			print( "</span>" );
			print( "</td>" );
		print( "</form>" );
		print( "</tr>" );
	print( "</table>" );
	}
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_equipment_view_box' class='visiblebox'>" );
		if( $fac_equipment_num_rows > 0 )
			mysql_data_seek( $fac_equipment_results, 0 );
		$fac_equipment_rows_itr = 0;
		while( $fac_equipment_rows = mysql_fetch_array( $fac_equipment_results ) )
		{
			
			$fac_equipment_rows_itr ++;
			$eqp_id = $fac_equipment_rows["eqp_id"];
			print( "<tr id='fac_equipment_" . $fac_equipment_rows_itr . "_view_row' class='visiblerow'>" );
				print( "<td width='5'></td>" );
				if( $editable == true )
				{
					print( "<form id='fac_equipment_" . $fac_equipment_rows_itr . "_delete_form' method='post' action='sections/fac_equipment_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='eqp_id' value='$eqp_id' />" );
					print( "<input type='hidden' name='fac_equipment_image_id' value='" . $fac_equipment_rows["image_id"] . "' />" );						
					print( "</form>" );
				}
				print( "<td>" );
				print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
					print( "<tr>" );
						print( "<td>" );
						$span = "<span class='form_elements_section_subheader'>";
						$anchor_name = "fac_eqp".htmlspecialchars($fac_equipment_rows["eqp_id"]);
						if( $fac_equipment_rows["eqp_pid"] == 0 )
							print( "<a name=\"".$anchor_name."\">$span". htmlspecialchars($fac_equipment_rows["name"], ENT_QUOTES). "</span></a>" );
						else
							print( "$span<a href='editprofile.php?pid=" . $fac_equipment_rows["eqp_pid"] ."'>". htmlspecialchars($fac_equipment_rows["name"], ENT_QUOTES). "</a></span>" );
						print( "</td>" );
						print( "<td width='20%' align='right'>" );
						if( $editable == true )
						{
								print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"fac_equipment\", \"$fac_equipment_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
								if( $fac_equipment_rows["eqp_pid"] == 0 )
									print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"fac_equipment\", \"$fac_equipment_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );
						}
						print( "</td>" );
					print( "</tr>" );
					if( $fac_equipment_rows["cost"] != "" )
					{
						print( "<tr>" );
							print( "<td>" );
							print( "Value: " . htmlspecialchars( $fac_equipment_rows["cost"], ENT_QUOTES) );
							print( "</td>" );
						print( "</tr>" );
					}
					
					print( "<tr><td colspan='2'>&nbsp;</td></tr>" );
					print( "<tr>" );
						print( "<td colspan='2'>" );
						print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
							print( "<tr>" );
								print( "<td >" );
								if( $fac_equipment_rows["image_id"] != 0 )
									print( "<a href='images/0/" . $fac_equipment_rows["eqp_pid"] . "_" . $section_id . "_" . $fac_equipment_rows["image_id"] . ".jpg' target='_blank'><image align='left' src='images/128/" . $fac_equipment_rows["eqp_pid"] . "_" . $section_id . "_" . $fac_equipment_rows["image_id"] . ".jpg' width='128' height='128' HSPACE='5', VSPACE='5' border='0'></a>" );
								$span = "<span class='form_elements_text'>";
								print( "$span". real_rte_specialchars($fac_equipment_rows["description"]) . "</span>" );
								print( "</td>" );
							print( "</tr>" );
						print( "</table>" );
					print( "</tr>" );

					print( "<tr><td colspan='3'><HR></td></tr>" );
				print( "</table>" );
				print( "</td>" );					
			print( "</tr>" );
			if( $editable == true && $fac_equipment_rows["eqp_pid"] == 0 )
			{
				print( "<tr id='fac_equipment_" . $fac_equipment_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<td width='5'></td>" );
				print( "<form enctype='multipart/form-data' id='fac_equipment_" . $fac_equipment_rows_itr . "_edit_form' method='post' action='sections/fac_equipment_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='eqp_id' value='$eqp_id' />" );
					print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
					print( "<input type='hidden' name='fac_equipment_image_id' value='" . $fac_equipment_rows["image_id"] . "' />" );

					print( "<td>" );
					print( "<span class='form_elements_text'>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td width='10%'>Name</td>" );
							print( "<td><input class='form_elements_edit' type='text' name='fac_equipment_name' value='". htmlspecialchars( $fac_equipment_rows["name"], ENT_QUOTES ).  "' maxlength='255' size='60'></td>" );
							print( "<td align='right'>" );		
							$checkboxvalue = $fac_equipment_rows[ "status" ] == 1 ? "checked" : "" ;
							print( "<input type='checkbox' name='fac_equipment_status' $checkboxvalue><span class='form_elements_row_action'>Hide&nbsp;&nbsp;&nbsp;</span>" );		
							print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"fac_equipment_description_" . $fac_equipment_rows_itr . "\" ); return submit_row( \"fac_equipment\", \"$fac_equipment_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
							print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"fac_equipment\", \"$fac_equipment_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>WebSite</td>" );
							print( "<td colspan='2'><input class='form_elements_edit' type='text' name='fac_equipment_url_name' value='". htmlspecialchars( $fac_equipment_rows["url_name"], ENT_QUOTES ).  "' maxlength='255' size='22'>" );
							print( "&nbsp; &nbsp; URL" );
							print( "&nbsp; &nbsp; <input class='form_elements_edit' type='text' name='fac_equipment_url' value='". htmlspecialchars( $fac_equipment_rows["url"], ENT_QUOTES).  "' maxlength='255' size='22'>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>Image</td>" );
							print( "<td colspan='2'><input name='imagefile' type='file' size='37'/>" );
							print( "&nbsp;&nbsp;<input type='checkbox' name='fac_equipment_remove_image' > <span class='form_elements_edit'> Remove </span>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>Value</td>" );
							print( "<td colspan='2'><input class='form_elements_edit' name='fac_equipment_cost' type='text' size='10' maxlenth='32' style='text-align:right' value='". htmlspecialchars( $fac_equipment_rows["cost"], ENT_QUOTES) ."'>" );
							$selected = $fac_equipment_rows["value"] == 0 ? "checked" : "";
							print( "&nbsp;&nbsp;<input type='radio' name='fac_equipment_value' value='0' $selected>Less than $100,000" );
							$selected = $fac_equipment_rows["value"] == 1 ? "checked" : "";
							print( "&nbsp;&nbsp;<input type='radio' name='fac_equipment_value' value='1' $selected>Greater than or equal to $100,000 " );
							print( "</td>" );
						print( "</tr>" );						
						print( "<tr>" );
							print( "<td colspan='3'>" );
							print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
							print( "writeRichText('fac_equipment_description_" . $fac_equipment_rows_itr . "', 'fac_equipment_description', '" . real_rte_specialchars( $fac_equipment_rows["description"] ) . "', 600, 150, true, false, true);" );
							print( "</script>" );
							
							//print( "<textarea class='form_elements_text' name='fac_equipment_description' cols='120' rows='5'>" . htmlspecialchars( $fac_equipment_rows["description"], ENT_QUOTES ) . "</textarea>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr><td colspan='3'><HR></tr></td>" );						
					print( "</table>" );
					print( "</span>" );
					print( "</td>" );
				print( "</form>" );
				print( "</tr>" );
			
			}

		}
	print( "<tr><td height='10'></td></tr>" );
	print( "</table>" );
}

?>
