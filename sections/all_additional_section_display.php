<?php
$all_additional_section_num_rows[$current_sections_row[0]] = mysql_num_rows( $all_additional_section_results[$current_sections_row[0]] );
if($all_additional_section_num_rows[$current_sections_row[0]] != 0 || $editable==true)
{
	$sectionid = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='all_additional_section_$sectionid_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			//if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='all_additional_section_". $sectionid ."_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"all_additional_section_". $sectionid ."\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='all_additional_section_". $sectionid ."_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"all_additional_section_". $sectionid ."\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;". htmlspecialchars($current_sections_row[1]) . "</span></td>" );
			print( "<form name='all_additional_section_". $sectionid ."_delete_form' id='all_additional_section_". $sectionid ."_delete_form' method='post' action='sections/all_additional_section_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='". $sectionid ."' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"all_additional_section_". $sectionid ."\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"all_additional_section_". $sectionid ."\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='all_additional_section_". $sectionid ."_add_box' class='hiddenbox'>" );
		$all_additional_section_max_id_rows = mysql_fetch_row( $all_additional_section_max_id_results[$current_sections_row[0]] );
		$max_sub_section_id = $all_additional_section_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form enctype='multipart/form-data' id='all_additional_section_". $sectionid ."_add_form' method='post' action='sections/all_additional_section_add_box_submit.php' >" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='". $sectionid ."' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "<input type='hidden' name='clicked' value='0' />" );
			print( "<input type='hidden' name='max_sub_section_id' value='$max_sub_section_id' />" );
			print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
			print( "<td>" );
			print( "<span class='form_elements_text'>" );
			print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td width='10%'>Name</td>" );
					print( "<td><input class='form_elements_edit' type='text' name='all_additional_section_name' value='' maxlength='255' size='60'></td>" );
					print( "<td align='right'>" );
					print( "<input type='checkbox' name='all_additional_section_status'><span class='form_elements_row_action'>Hide&nbsp;&nbsp;&nbsp;</span>" );		
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE(\"all_additional_section_description_" . $sectionid  . "\"); return submit_box( \"all_additional_section_". $sectionid ."\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"all_additional_section_". $sectionid ."\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr>" );
					print( "<td>WebSite</td>" );
					print( "<td colspan='2'><input class='form_elements_edit' type='text' name='all_additional_section_url_name' value='' maxlength='255' size='22'>" );
					print( "&nbsp; &nbsp; URL" );
					print( "&nbsp; &nbsp; <input class='form_elements_edit' type='text' name='all_additional_section_url' value='' maxlength='255' size='22'>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr>" );
					print( "<td>Image</td>" );
					print( "<td colspan='2'><input name='imagefile' type='file' size='37'/>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr>" );
					print( "<td colspan='3'>" );

					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
					print( "writeRichText( 'all_additional_section_description_". $sectionid . "' , 'all_additional_section_description', '', 500, 80, true, false, true);" );
					print( "</script>" );
					
//					print( "<textarea class='form_elements_text' name='all_additional_section_description' cols='120' rows='5'></textarea>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr><td colspan='3'><HR></td></tr>" );						
			print( "</table>" );
			print( "</span>" );
			print( "</td>" );
		print( "</form>" );
		print( "</tr>" );
	print( "</table>" );
	}
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='all_additional_section_". $sectionid ."_view_box' class='visiblebox'>" );
		if( $all_additional_section_num_rows[$sectionid] > 0 )
			mysql_data_seek( $all_additional_section_results[$sectionid], 0 );
		$all_additional_section_rows_itr = 0;
		while( $all_additional_section_rows = mysql_fetch_array( $all_additional_section_results[$sectionid] ) )
		{
			$all_additional_section_rows_itr ++;
			$sub_section_id = $all_additional_section_rows["sub_section_id"];
			print( "<tr id='all_additional_section_". $sectionid ."_" . $all_additional_section_rows_itr . "_view_row' class='visiblerow'>" );
				print( "<td width='5'></td>" );
				if( $editable == true )
				{
					print( "<form id='all_additional_section_". $sectionid ."_" . $all_additional_section_rows_itr . "_delete_form' method='post' action='sections/all_additional_section_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='". $sectionid ."' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='sub_section_id' value='$sub_section_id' />" );
					print( "<input type='hidden' name='all_additional_section_image_id' value='" . $all_additional_section_rows["image_id"] . "' />" );						
					print( "</form>" );
				}
				if( $all_additional_section_rows["status"] == 0 || $editable == true )
				{
					print( "<td>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td>" );
							if( $all_additional_section_rows["status"] == 0 )
								$span = "<span class='form_elements_section_subheader'>";
							else
								$span = "<span class='form_elements_section_subheader_disabled'>";
							print( "$span". htmlspecialchars($all_additional_section_rows["name"], ENT_QUOTES). "</span>" );
							print( "</td>" );
							print( "<td width='20%' align='right'>" );
							if( $editable == true )
							{
								print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"all_additional_section_". $sectionid ."\", \"$all_additional_section_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
								print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"all_additional_section_". $sectionid ."\", \"$all_additional_section_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );
							}
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td colspan='2'>" );
							print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
								print( "<tr>" );
									print( "<td >" );
									if( $all_additional_section_rows["image_id"] != 0 )
										print( "<a href='images/0/" . $pid ."_". $sectionid ."_" . $all_additional_section_rows["image_id"]  . ".jpg' target='_blank'><image src='images/128/" . $pid . "_". $sectionid ."_" . $all_additional_section_rows["image_id"] . ".jpg' align='left' HSPACE='5', VSPACE='5' border='0' ></a>" );

										if( $all_additional_section_rows["status"] == 0 )
											$span = "<span class='form_elements_text'>";
										else
											$span = "<span class='form_elements_text_disabled'>";

											if( $all_additional_section_rows["url"] != "" )
											{
												$urlname = $all_additional_section_rows["url_name"] == "" ? "Web Link" : htmlspecialchars( $all_additional_section_rows["url_name"], ENT_QUOTES );
												print( "$span<a href='" . $all_additional_section_rows["url"]. "' target=_blank>" . $urlname . "</a></span><BR>" );
											}
											print( "$span". real_rte_specialchars($all_additional_section_rows["description"] ). "</span>" );
									print( "</td>" );							
								print( "</tr>" );
							print( "</table>" );
						print( "</tr>" );

						print( "<tr><td colspan='3'><HR></td></tr>" );
					print( "</table>" );
					print( "</td>" );					
				}
			print( "</tr>" );
			if( $editable == true )
			{
				print( "<tr id='all_additional_section_". $sectionid ."_" . $all_additional_section_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<td width='5'></td>" );
				print( "<form enctype='multipart/form-data' id='all_additional_section_". $sectionid ."_" . $all_additional_section_rows_itr . "_edit_form' method='post' action='sections/all_additional_section_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='". $sectionid ."' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='sub_section_id' value='$sub_section_id' />" );
					print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
					print( "<input type='hidden' name='all_additional_section_image_id' value='" . $all_additional_section_rows["image_id"] . "' />" );

					print( "<td>" );
					print( "<span class='form_elements_text'>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td width='10%'>Name</td>" );
							print( "<td><input class='form_elements_edit' type='text' name='all_additional_section_name' value='". htmlspecialchars( $all_additional_section_rows["name"], ENT_QUOTES ) .  "' maxlength='255' size='60'></td>" );
							print( "<td align='right'>" );							
							$checkboxvalue = $all_additional_section_rows[ "status" ] == 1 ? "checked" : "" ;
							print( "<input type='checkbox' name='all_additional_section_status' $checkboxvalue><span class='form_elements_row_action'>Hide&nbsp;&nbsp;&nbsp;</span>" );		
							print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"all_additional_section_description_" . $sectionid . "_" . $all_additional_section_rows_itr . "\" ); return submit_row( \"all_additional_section_". $sectionid ."\", \"$all_additional_section_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
							print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"all_additional_section_". $sectionid ."\", \"$all_additional_section_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>WebSite</td>" );
							print( "<td colspan='2'><input class='form_elements_edit' type='text' name='all_additional_section_url_name' value='". htmlspecialchars( $all_additional_section_rows["url_name"], ENT_QUOTES ) .  "' maxlength='255' size='22'>" );
							print( "&nbsp; &nbsp; URL" );
							print( "&nbsp; &nbsp; <input class='form_elements_edit' type='text' name='all_additional_section_url' value='". htmlspecialchars( $all_additional_section_rows["url"], ENT_QUOTES ) .  "' maxlength='255' size='22'>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>Image</td>" );
							print( "<td colspan='2'><input name='imagefile' type='file' size='37'/>" );
							print( "&nbsp;&nbsp;<input type='checkbox' name='all_additional_section_remove_image' > <span class='form_elements_edit'> Remove </span>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td colspan='3'>" );

							print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
							print( "writeRichText( 'all_additional_section_description_" . $sectionid . "_" . $all_additional_section_rows_itr . "', 'all_additional_section_description', '" . real_rte_specialchars( $all_additional_section_rows["description"] ) . "', 500, 80, true, false, true);" );
							print( "</script>" );
							
//							print( "<textarea class='form_elements_text' name='all_additional_section_description' cols='120' rows='5'>" . htmlspecialchars( $all_additional_section_rows["description"], ENT_QUOTES ) . "</textarea>" );
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
