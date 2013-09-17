<?php
$ppl_activity_num_rows = mysql_num_rows( $ppl_activity_results );
if($ppl_activity_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_activity_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
//			if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ppl_activity_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ppl_activity\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ppl_activity_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ppl_activity\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Synergistic Activities</span></td>" );
			print( "<form name='ppl_activity_delete_form' id='ppl_activity_delete_form' method='post' action='sections/ppl_activity_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#facil_sa' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_activity\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ppl_activity\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_activity_add_box' class='hiddenbox'>" );
		$ppl_activity_max_id_rows = mysql_fetch_row( $ppl_activity_max_id_results );
		$max_act_id = $ppl_activity_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form id='ppl_activity_add_form' method='post' action='sections/ppl_activity_add_box_submit.php' >" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "<input type='hidden' name='clicked' value='0' />" );
			print( "<input type='hidden' name='max_act_id' value='$max_act_id' />" );
			print( "<td>" );
			print( "<span class='form_elements_text'>" );
			print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td>Title <input class='form_elements_edit' type='text' name='ppl_activity_name' value='". htmlspecialchars( $ppl_activity_rows["name"], ENT_QUOTES ) .  "' maxlength='255' size='60'>" );
					print( "</td>" );
					print( "<td align='right'>" );							
					print( "<input type='checkbox' name='ppl_activity_status' $checkboxvalue> <span class='form_elements_row_action'>Hide</span>&nbsp; &nbsp;" );
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE(\"ppl_activity_description\"); return submit_box( \"ppl_activity\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ppl_activity\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr>" );
					print( "<td colspan='2'>" );

					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
					print( "writeRichText( 'ppl_activity_description', 'ppl_activity_description', '', 500, 80, true, false, true);" );
					print( "</script>" );
					
//					print( "<textarea class='form_elements_text' name='ppl_activity_description' cols='120' rows='5'>" . htmlspecialchars( $ppl_activity_rows["description"], ENT_QUOTES ) . "</textarea>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr><td colspan='3'><HR></tr></td>" );						
			print( "</table>" );
			print( "</span>" );
			print( "</td>" );
		print( "</form>" );
		print( "</tr>" );
	print( "</table>" );
	}

	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_activity_view_box' class='visiblebox'>" );
		if( $ppl_activity_num_rows > 0 )
			mysql_data_seek( $ppl_activity_results, 0 );
		$ppl_activity_rows_itr = 0;
		while( $ppl_activity_rows = mysql_fetch_array( $ppl_activity_results ) )
		{
			
			$ppl_activity_rows_itr ++;
			$act_id = $ppl_activity_rows["act_id"];
			print( "<tr id='ppl_activity_" . $ppl_activity_rows_itr . "_view_row' class='visiblerow'>" );
				print( "<td width='5'></td>" );
				if( $ppl_activity_rows["status"] == 0 || $editable == true )
				{
					if( $editable == true )
					{
						print( "<form id='ppl_activity_" . $ppl_activity_rows_itr . "_delete_form' method='post' action='sections/ppl_activity_delete_row_submit.php' >" );
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<input type='hidden' name='act_id' value='$act_id' />" );
						print( "<input type='hidden' name='ppl_activity_image_id' value='" . $ppl_activity_rows["image_id"] . "' />" );						
						print( "</form>" );
					}
					print( "<td>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td colspan='2'>" );
							if( $ppl_activity_rows["status"] == 0 )
								$span = "<span class='form_elements_section_subheader'>";
							else
								$span = "<span class='form_elements_section_subheader_disabled'>";
							print( "$span". htmlspecialchars($ppl_activity_rows["name"], ENT_QUOTES). "</span>" );
							print( "</td>" );
							print( "<td width='20%' align='right'>" );
							if( $editable == true )
							{
								print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_activity\", \"$ppl_activity_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
								print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ppl_activity\", \"$ppl_activity_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );
							}
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td colspan='4' valign='top'>" );
							if( $ppl_activity_rows["status"] == 0 )
								$span = "<span class='form_elements_text'>";
							else
								$span = "<span class='form_elements_text_disabled'>";
							print( "$span". real_rte_specialchars($ppl_activity_rows["description"] ). "</span>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr><td colspan='3'><HR></td></tr>" );
					print( "</table>" );
					print( "</td>" );					
				}
			print( "</tr>" );
			if( $editable == true )
			{
				print( "<tr id='ppl_activity_" . $ppl_activity_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<td width='5'></td>" );
				print( "<form enctype='multipart/form-data' id='ppl_activity_" . $ppl_activity_rows_itr . "_edit_form' method='post' action='sections/ppl_activity_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='act_id' value='$act_id' />" );
					print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
					print( "<input type='hidden' name='ppl_activity_image_id' value='" . $ppl_activity_rows["image_id"] . "' />" );

					print( "<td>" );
					print( "<span class='form_elements_text'>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td><input class='form_elements_edit' type='text' name='ppl_activity_name' value='". htmlspecialchars($ppl_activity_rows["name"], ENT_QUOTES) .  "' maxlength='255' size='60'>" );
							print( "</td>" );
							print( "<td align='right'>" );							
							$checkboxvalue = $ppl_activity_rows[ "status" ] == 1 ? "checked" : "" ;
							print( "<input type='checkbox' name='ppl_activity_status' $checkboxvalue><span class='form_elements_row_action'>Hide</span>&nbsp;&nbsp;" );
							print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ppl_activity_description_" . $ppl_activity_rows_itr . "\" ); return submit_row( \"ppl_activity\", \"$ppl_activity_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
							print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ppl_activity\", \"$ppl_activity_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td colspan='2'>" );

							print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
							print( "writeRichText( 'ppl_activity_description_" . $ppl_activity_rows_itr . "', 'ppl_activity_description', '" . real_rte_specialchars( $ppl_activity_rows["description"] ) . "', 500, 80, true, false, true);" );
							print( "</script>" );
							
//							print( "<textarea class='form_elements_text' name='ppl_activity_description' cols='120' rows='5'>" . htmlspecialchars($ppl_activity_rows["description"], ENT_QUOTES) . "</textarea>" );
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
