<?php
$ctr_equipment_num_rows = mysql_num_rows( $ctr_equipment_results );
if($ctr_equipment_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_equipment_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			//if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ctr_equipment_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ctr_equipment\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ctr_equipment_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ctr_equipment\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Equipment</span></td>" );
			print( "<form name='ctr_equipment_delete_form' id='ctr_equipment_delete_form' method='post' action='sections/ctr_equipment_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{	
				print( "<a href='{$_home}/help/index.php#recen_equipment' target='_blank' style='text-decoration:none' ><img alt='Help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ctr_equipment\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ctr_equipment\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_equipment_add_box' class='hiddenbox'>" );
		$ctr_equipment_max_id_rows = mysql_fetch_row( $ctr_equipment_max_id_results );
		$max_eqp_id = $ctr_equipment_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form id='ctr_equipment_add_form' method='post' action='sections/ctr_equipment_add_box_submit.php' >" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='view' value='$view' />" );
		print( "<input type='hidden' name='max_eqp_id' value='$max_eqp_id' />" );		
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<td>" );
		print( "<span class='form_elements_text'>" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td> &nbsp; Find existing profiles to add them to the list of Equipment</td>" );
				print( "<td width='20%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='fpUpdateRows( \"ctr_equipment_add_form\", \"ctr_equipment_find\" ); return submit_box( \"ctr_equipment\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ctr_equipment\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr >" );
				print( "<td colspan='2'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "createFindProfileTable('ctr_equipment_find', 'eqp', -1);" );
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
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_equipment_view_box' class='visiblebox'>" );
		if( $ctr_equipment_num_rows > 0 )
			mysql_data_seek( $ctr_equipment_results, 0 );
		$ctr_equipment_rows_itr = 0;
		while( $ctr_equipment_rows = mysql_fetch_array( $ctr_equipment_results ) )
		{
			
			$ctr_equipment_rows_itr ++;
			$eqp_id = $ctr_equipment_rows["eqp_id"];
			print( "<tr id='ctr_equipment_" . $ctr_equipment_rows_itr . "_view_row' class='visiblerow'>" );
				print( "<td width='5'></td>" );
				if( $editable == true )
				{
					print( "<form id='ctr_equipment_" . $ctr_equipment_rows_itr . "_delete_form' method='post' action='sections/ctr_equipment_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='eqp_id' value='$eqp_id' />" );
					print( "<input type='hidden' name='ctr_equipment_image_id' value='" . $ctr_equipment_rows["image_id"] . "' />" );						
					print( "</form>" );
				}
				print( "<td>" );
				print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
					print( "<tr>" );
						print( "<td>" );
						$span = "<span class='form_elements_section_subheader'>";
						$anchor_name = "ctr_eqp".htmlspecialchars($ctr_equipment_rows["eqp_id"]);
						if( $ctr_equipment_rows["eqp_pid"] == 0 )
							print( "<a name=\"".$anchor_name."\">$span". htmlspecialchars($ctr_equipment_rows["name"], ENT_QUOTES). "</span></a>" );
						else
							print( "$span<a href='editprofile.php?pid=" . $ctr_equipment_rows["eqp_pid"] ."'>". htmlspecialchars($ctr_equipment_rows["name"], ENT_QUOTES). "</a></span>" );
						print( "</td>" );
						print( "<td width='20%' align='right'>" );
						if( $editable == true )
						{		
						
							print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ctr_equipment\", \"$ctr_equipment_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
								if( $ctr_equipment_rows["eqp_pid"] == 0 )
									print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ctr_equipment\", \"$ctr_equipment_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );
						}
						print( "</td>" );
					print( "</tr>" );
					if( $ctr_equipment_rows["cost"] != "" )
					{
						print( "<tr>" );
							print( "<td>" );
							print( "Value: " . htmlspecialchars( $ctr_equipment_rows["cost"], ENT_QUOTES) );
							print( "</td>" );
						print( "</tr>" );
					}
					print( "<tr><td colspan='2'>&nbsp;</td></tr>" );
					print( "<tr>" );
						print( "<td colspan='2'>" );
						print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
							print( "<tr>" );
								print( "<td >" );
								if( $ctr_equipment_rows["image_id"] != 0 )
								{
									if( $ctr_equipment_rows["eqp_pid"] != 0 )
										print( "<a href='images/0/" . $ctr_equipment_rows["eqp_pid"] . "_0_" . $ctr_equipment_rows["image_id"] . ".jpg' target='_blank'><image align='left' src='images/128/" . $ctr_equipment_rows["eqp_pid"] . "_0_" . $ctr_equipment_rows["image_id"] . ".jpg' HSPACE='5', VSPACE='5' border='0'></a>" );
									else
										print( "<a href='images/0/" . $pid . "_" . $section_id . "_" . $ctr_equipment_rows["image_id"] . ".jpg' target='_blank'><image align='left' src='images/128/" . $pid . "_" . $section_id . "_" . $ctr_equipment_rows["image_id"] . ".jpg' HSPACE='5', VSPACE='5' border='0'></a>" );																				
								}
								if( $ctr_research_rows["status"] == 0 )
									$span = "<span class='form_elements_text'>";
								else
									$span = "<span class='form_elements_text_disabled'>";
									if( $ctr_equipment_rows["url"] != "" )
									{
										$urlname = $ctr_equipment_rows["url_name"] == "" ? "Web Link" : htmlspecialchars( $ctr_equipment_rows["url_name"], ENT_QUOTES );
										print( "$span<a href='" . htmlspecialchars( $ctr_equipment_rows["url"], ENT_QUOTES). "' target=_blank>" . $urlname . "</a></span><BR>" );
									}

								print( "$span". real_rte_specialchars($ctr_equipment_rows["description"]) . "</span>" );
								print( "</td>" );
							print( "</tr>" );
						print( "</table>" );
					print( "</tr>" );

					print( "<tr><td colspan='3'><HR></td></tr>" );
				print( "</table>" );
				print( "</td>" );					
			print( "</tr>" );
			if( $editable == true && $ctr_equipment_rows["eqp_pid"] == 0 )
			{
				print( "<tr id='ctr_equipment_" . $ctr_equipment_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<td width='5'></td>" );
				print( "<form enctype='multipart/form-data' id='ctr_equipment_" . $ctr_equipment_rows_itr . "_edit_form' method='post' action='sections/ctr_equipment_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='eqp_id' value='$eqp_id' />" );
					print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
					print( "<input type='hidden' name='ctr_equipment_image_id' value='" . $ctr_equipment_rows["image_id"] . "' />" );

					print( "<td>" );
					print( "<span class='form_elements_text'>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td width='10%'>Name</td>" );
							print( "<td><input class='form_elements_edit' type='text' name='ctr_equipment_name' value='". htmlspecialchars( $ctr_equipment_rows["name"], ENT_QUOTES ).  "' maxlength='255' size='60'></td>" );
							print( "<td align='right'>" );		
							$checkboxvalue = $ctr_equipment_rows[ "status" ] == 1 ? "checked" : "" ;
							print( "<input type='checkbox' name='ctr_equipment_status' $checkboxvalue><span class='form_elements_row_action'>Hide&nbsp;&nbsp;&nbsp;</span>" );		
							print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ctr_equipment_description_" . $ctr_equipment_rows_itr . "\" ); return submit_row( \"ctr_equipment\", \"$ctr_equipment_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
							print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ctr_equipment\", \"$ctr_equipment_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>WebSite</td>" );
							print( "<td colspan='2'><input class='form_elements_edit' type='text' name='ctr_equipment_url_name' value='". htmlspecialchars( $ctr_equipment_rows["url_name"], ENT_QUOTES ).  "' maxlength='255' size='22'>" );
							print( "&nbsp; &nbsp; URL" );
							print( "&nbsp; &nbsp; <input class='form_elements_edit' type='text' name='ctr_equipment_url' value='". htmlspecialchars( $ctr_equipment_rows["url"], ENT_QUOTES).  "' maxlength='255' size='22'>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>Image</td>" );
							print( "<td colspan='2'><input name='imagefile' type='file' size='37'/>" );
							print( "&nbsp;&nbsp;<input type='checkbox' name='ctr_equipment_remove_image' > <span class='form_elements_edit'> Remove </span>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>Value</td>" );
							print( "<td colspan='2'><input class='form_elements_edit' name='ctr_equipment_cost' type='text' size='10' maxlenth='32' style='text-align:right' value='". htmlspecialchars( $ctr_equipment_rows["cost"], ENT_QUOTES) ."'>" );
							$selected = $ctr_equipment_rows["value"] == 0 ? "checked" : "";
							print( "&nbsp;&nbsp;<input type='radio' name='ctr_equipment_value' value='0' $selected>Less than $100,000" );
							$selected = $ctr_equipment_rows["value"] == 1 ? "checked" : "";
							print( "&nbsp;&nbsp;<input type='radio' name='ctr_equipment_value' value='1' $selected>Greater than or equal to $100,000 " );
							print( "</td>" );
						print( "</tr>" );

						print( "<tr>" );
							print( "<td colspan='3'>" );
							print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
							print( "writeRichText('ctr_equipment_description_" . $ctr_equipment_rows_itr . "', 'ctr_equipment_description', '" . real_rte_specialchars( $ctr_equipment_rows["description"] ) . "', 600, 150, true, false, true);" );
							print( "</script>" );
							
							//print( "<textarea class='form_elements_text' name='ctr_equipment_description' cols='120' rows='5'>" . htmlspecialchars( $ctr_equipment_rows["description"], ENT_QUOTES ) . "</textarea>" );
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
