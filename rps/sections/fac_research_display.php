<?php
$fac_research_num_rows = mysql_num_rows( $fac_research_results );
if($fac_research_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_research_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			//if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='fac_research_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"fac_research\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='fac_research_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"fac_research\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Research / Services</span></td>" );
			print( "<form name='fac_research_delete_form' id='fac_research_delete_form' method='post' action='sections/fac_research_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#facil_research&service' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );
	
				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"fac_research\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"fac_research\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_research_add_box' class='hiddenbox'>" );
		$fac_research_max_id_rows = mysql_fetch_row( $fac_research_max_id_results );
		$max_resch_id = $fac_research_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form enctype='multipart/form-data' id='fac_research_add_form' method='post' action='sections/fac_research_add_box_submit.php' >" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "<input type='hidden' name='clicked' value='0' />" );
			print( "<input type='hidden' name='max_resch_id' value='$max_resch_id' />" );
			print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
			print( "<td>" );
			print( "<span class='form_elements_text'>" );
			print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td width='10%'>Name</td>" );
					print( "<td><input class='form_elements_edit' type='text' name='fac_research_name' value='' maxlength='255' size='60'></td>" );
					print( "<td align='right'>" );
					print( "<input type='checkbox' name='fac_research_status'><span class='form_elements_row_action'>Hide&nbsp;&nbsp;&nbsp;</span>" );		
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"fac_research_description\" ); return submit_box( \"fac_research\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"fac_research\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr>" );
					print( "<td>WebSite</td>" );
					print( "<td colspan='2'><input class='form_elements_edit' type='text' name='fac_research_url_name' value='' maxlength='255' size='22'>" );
					print( "&nbsp; &nbsp; URL" );
					print( "&nbsp; &nbsp; <input class='form_elements_edit' type='text' name='fac_research_url' value='' maxlength='255' size='22'>" );
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
					print( "writeRichText('fac_research_description', 'fac_research_description', '', 600, 150, true, false, true);" );
					print( "</script>" );
//					print( "<textarea class='form_elements_text' name='fac_research_description' cols='120' rows='5'></textarea>" );
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
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_research_view_box' class='visiblebox'>" );
		if( $fac_research_num_rows > 0 )
			mysql_data_seek( $fac_research_results, 0 );
		$fac_research_rows_itr = 0;
		while( $fac_research_rows = mysql_fetch_array( $fac_research_results ) )
		{
			
			$fac_research_rows_itr ++;
			$resch_id = $fac_research_rows["resch_id"];
			print( "<tr id='fac_research_" . $fac_research_rows_itr . "_view_row' class='visiblerow'>" );
				print( "<td width='5'></td>" );
				if( $editable == true )
				{
					print( "<form id='fac_research_" . $fac_research_rows_itr . "_delete_form' method='post' action='sections/fac_research_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='resch_id' value='$resch_id' />" );
					print( "<input type='hidden' name='fac_research_image_id' value='" . $fac_research_rows["image_id"] . "' />" );						
					print( "</form>" );
				}
				if( $fac_research_rows["status"] == 0 || $editable == true )
				{
					print( "<td>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td>" );
							if( $fac_research_rows["status"] == 0 )
								$span = "<span class='form_elements_section_subheader'>";
							else
								$span = "<span class='form_elements_section_subheader_disabled'>";
							print( "$span". htmlspecialchars($fac_research_rows["name"], ENT_QUOTES). "</span>" );
							print( "</td>" );
							print( "<td width='20%' align='right'>" );
							if( $editable == true )
							{
								print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"fac_research\", \"$fac_research_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
								print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"fac_research\", \"$fac_research_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );
							}
							print( "</td>" );
						print( "</tr>" );
						print( "<tr><td colspan='2'>&nbsp;</td></tr>" );
						print( "<tr>" );
							print( "<td colspan='2'>" );
							print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
								print( "<tr>" );
									print( "<td >" );
									if( $fac_research_rows["image_id"] != 0 )
										print( "<a href='images/0/" . $pid . "_" . $section_id . "_" . $fac_research_rows["image_id"] . ".jpg' target='_blank'><image align='left' src='images/128/" . $pid . "_" . $section_id . "_" . $fac_research_rows["image_id"] . ".jpg' width='128' height='128' HSPACE='5', VSPACE='5' border='0'></a>" );

									if( $fac_research_rows["status"] == 0 )
										$span = "<span class='form_elements_text'>";
									else
										$span = "<span class='form_elements_text_disabled'>";
										if( $fac_research_rows["url"] != "" )
										{
											$urlname = $fac_research_rows["url_name"] == "" ? "Web Link" : htmlspecialchars( $fac_research_rows["url_name"], ENT_QUOTES );
											print( "$span<a href='" . htmlspecialchars( $fac_research_rows["url"], ENT_QUOTES). "' target=_blank>" . $urlname . "</a></span><BR>" );
										}
										print( "$span". real_rte_specialchars($fac_research_rows["description"]) . "</span>" );
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
				print( "<tr id='fac_research_" . $fac_research_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<td width='5'></td>" );
				print( "<form enctype='multipart/form-data' id='fac_research_" . $fac_research_rows_itr . "_edit_form' method='post' action='sections/fac_research_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='resch_id' value='$resch_id' />" );
					print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
					print( "<input type='hidden' name='fac_research_image_id' value='" . $fac_research_rows["image_id"] . "' />" );

					print( "<td>" );
					print( "<span class='form_elements_text'>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td width='10%'>Name</td>" );
							print( "<td><input class='form_elements_edit' type='text' name='fac_research_name' value='". htmlspecialchars( $fac_research_rows["name"], ENT_QUOTES ).  "' maxlength='255' size='60'></td>" );
							print( "<td align='right'>" );							
							$checkboxvalue = $fac_research_rows[ "status" ] == 1 ? "checked" : "" ;
							print( "<input type='checkbox' name='fac_research_status' $checkboxvalue><span class='form_elements_row_action'>Hide&nbsp;&nbsp;&nbsp;</span>" );		
							print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"fac_research_description_" . $fac_research_rows_itr . "\" ); return submit_row( \"fac_research\", \"$fac_research_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
							print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"fac_research\", \"$fac_research_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>WebSite</td>" );
							print( "<td colspan='2'><input class='form_elements_edit' type='text' name='fac_research_url_name' value='". htmlspecialchars( $fac_research_rows["url_name"], ENT_QUOTES ).  "' maxlength='255' size='22'>" );
							print( "&nbsp; &nbsp; URL" );
							print( "&nbsp; &nbsp; <input class='form_elements_edit' type='text' name='fac_research_url' value='". htmlspecialchars( $fac_research_rows["url"], ENT_QUOTES).  "' maxlength='255' size='22'>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>Image</td>" );
							print( "<td colspan='2'><input name='imagefile' type='file' size='37'/>" );
							print( "&nbsp;&nbsp;<input type='checkbox' name='fac_research_remove_image' > <span class='form_elements_edit'> Remove </span>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td colspan='3'>" );
							print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
							print( "writeRichText('fac_research_description_" . $fac_research_rows_itr . "', 'fac_research_description', '" . real_rte_specialchars( $fac_research_rows["description"] ) . "', 600, 150, true, false, true);" );
							print( "</script>" );
							
							//print( "<textarea class='form_elements_text' name='fac_research_description' cols='120' rows='5'>" . htmlspecialchars( $fac_research_rows["description"], ENT_QUOTES ) . "</textarea>" );
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
