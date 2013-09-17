<?php
$ppl_prof_preparation_num_rows = mysql_num_rows( $ppl_prof_preparation_results );
if($ppl_prof_preparation_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_prof_preparation_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
//			if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ppl_prof_preparation_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ppl_prof_preparation\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ppl_prof_preparation_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ppl_prof_preparation\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Professional Preparation</span></td>" );
			print( "<form name='ppl_prof_preparation_delete_form' id='ppl_prof_preparation_delete_form' method='post' action='sections/ppl_prof_preparation_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			if( $editable == true )
			{
				print( "<td align='right'>" );
				print( "<a href='{$_home}/help/index.php#facul_pp' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_prof_preparation\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ppl_prof_preparation\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
				print( "</td>" );
			}
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		$ppl_prof_preparation_max_id_rows = mysql_fetch_row( $ppl_prof_preparation_max_id_results );
		$max_pp_id = $ppl_prof_preparation_max_id_rows[0];
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_prof_preparation_add_box' class='hiddenbox'>" );
		print( "<form id='ppl_prof_preparation_add_form' method='post' action='sections/ppl_prof_preparation_add_box_submit.php' >" );
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='max_pp_id' value='$max_pp_id' />" );
			print( "<tr class='table_background_other'>" );
				print( "<td align='center' width='10%'>&nbsp;<span class='form_elements_text'>Degree</span></td>" );
				print( "<td align='center' width='25%'><span class='form_elements_text'>Major</span></td>" );
				print( "<td align='center' width='25%'><span class='form_elements_text'>Institution</span></td>" );
				print( "<td align='center' width='10%'><span class='form_elements_text'>Year</span></td>" );
				print( "<td align='center' width='10%'><span class='form_elements_text'>Hide</span></td>" );
				print( "<td width='20%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_prof_preparation\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ppl_prof_preparation\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_prof_preparation_degree1' value='' maxlength='255' size='3'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_major1' value='' maxlength='255' size='20'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_institution1' value='' maxlength='255' size='20'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_year1' value='' maxlength='16' size='5'</td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_prof_preparation_status1' >" );
				print( "<td >&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_prof_preparation_degree2' value='' maxlength='255' size='3'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_major2' value='' maxlength='255' size='20'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_institution2' value='' maxlength='255' size='20'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_year2' value='' maxlength='16' size='5'</td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_prof_preparation_status2' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_prof_preparation_degree3' value='' maxlength='255' size='3'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_major3' value='' maxlength='255' size='20'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_institution3' value='' maxlength='255' size='20'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_year3' value='' maxlength='16' size='5'</td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_prof_preparation_status3' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='6' align='right'>" );
				print( "</td>" );				
			print( "</tr>" );
		print( "</form>" );
		print( "</table>" );
	}
	
	print( "<table width='100%'  border='1' cellspacing='0' cellpadding='0' id='ppl_prof_preparation_view_box' class='visiblebox'>" );
		if( $ppl_prof_preparation_num_rows > 0 )
		{
			print( "<tr class='table_background_other'>" );
				print( "<td width='20%' align='center'>&nbsp;<span class='form_elements_text'>Degree</span></td>" );
				print( "<td wisth='25%' align='center'><span class='form_elements_text'>Major</span></td>" );
				print( "<td align='center'><span class='form_elements_text'>Institution</span></td>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Year</span></td>" );
				if( $editable == true )
					print( "<td width='20%'>&nbsp;</td>" );

			print( "</tr>" );
		}
		if( $ppl_prof_preparation_num_rows > 0 )
			mysql_data_seek( $ppl_prof_preparation_results, 0 );
		$ppl_prof_preparation_rows_itr = 0;
		
		while( $ppl_prof_preparation_rows = mysql_fetch_array( $ppl_prof_preparation_results ) )
		{
			
			$ppl_prof_preparation_rows_itr ++;
			$pp_id = $ppl_prof_preparation_rows["pp_id"];
			print( "<tr id='ppl_prof_preparation_" . $ppl_prof_preparation_rows_itr . "_view_row' class='visiblerow'>" );
			
			if( $ppl_prof_preparation_rows["status"] == 0 )
				$span = "<span class='form_elements_text'>";
			else
				$span = "<span class='form_elements_text_disabled'>";

				if( $ppl_prof_preparation_rows["status"] == 0 || $editable == true )
				{
					print( "<td align='center'>&nbsp;$span". ($ppl_prof_preparation_rows["degree"]== ""? "&nbsp;" : htmlspecialchars($ppl_prof_preparation_rows["degree"], ENT_QUOTES) ) . "</span></td>" );
					print( "<td align='center'>$span". ($ppl_prof_preparation_rows["major"]=="" ? "&nbsp;" : htmlspecialchars($ppl_prof_preparation_rows["major"], ENT_QUOTES) ).  "</span></td>" );
					print( "<td align='center'>$span". ($ppl_prof_preparation_rows["institution"] == "" ? "&nbsp;" : htmlspecialchars($ppl_prof_preparation_rows["institution"], ENT_QUOTES) ). "</span></td>" );
					print( "<td align='center'>$span". ($ppl_prof_preparation_rows["year"] == "" ? "&nbsp;" : htmlspecialchars($ppl_prof_preparation_rows["year"], ENT_QUOTES) ). "</span></td>" );
					if( $editable == true )
					{
						print( "<form id='ppl_prof_preparation_" . $ppl_prof_preparation_rows_itr . "_delete_form' method='post' action='sections/ppl_prof_preparation_delete_row_submit.php' >" );
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<input type='hidden' name='pp_id' value='$pp_id' />" );
						print( "</form>" );
						print( "<td align='right'> <a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_prof_preparation\", \"$ppl_prof_preparation_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
						print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ppl_prof_preparation\", \"$ppl_prof_preparation_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a></td>" );
					}
				}
			print( "</tr>" );
			if( $editable == true )
			{
				print( "<tr id='ppl_prof_preparation_" . $ppl_prof_preparation_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<form id='ppl_prof_preparation_" . $ppl_prof_preparation_rows_itr . "_edit_form' method='post' action='sections/ppl_prof_preparation_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='pp_id' value='$pp_id' />" );
					print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_prof_preparation_degree' value='". htmlspecialchars( $ppl_prof_preparation_rows["degree"], ENT_QUOTES). "' maxlength='255' size='3'></td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_major' value='". htmlspecialchars( $ppl_prof_preparation_rows["major"], ENT_QUOTES).  "' maxlength='255' size='20'></td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_institution' value='". htmlspecialchars( $ppl_prof_preparation_rows["institution"], ENT_QUOTES). "' maxlength='255' size='20'></td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_prof_preparation_year' value='". htmlspecialchars( $ppl_prof_preparation_rows["year"], ENT_QUOTES). "' maxlength='16' size='5'></td>" );
					if( $ppl_prof_preparation_rows[ "status" ] == 0 )
						$checkboxvalue = "";
					else
						$checkboxvalue = "checked";					
					print( "<td align='right'>" );
					print( "<input type='checkbox' name='ppl_prof_preparation_status' $checkboxvalue><span class='form_elements_edit'> Hide &nbsp;</span>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_prof_preparation\", \"$ppl_prof_preparation_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ppl_prof_preparation\", \"$ppl_prof_preparation_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</form>" );
				print( "</tr>" );
			}
		}
	print( "<tr><td colspan='6' height='10'></td></tr>" );
	print( "</table>" );
}	
?>
