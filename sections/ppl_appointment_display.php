<?php
$ppl_appointment_num_rows = mysql_num_rows( $ppl_appointment_results );
if($ppl_appointment_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_appointment_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
//			if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ppl_appointment_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ppl_appointment\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ppl_appointment_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ppl_appointment\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Appointments</span></td>" );
			print( "<form name='ppl_appointment_delete_form' id='ppl_appointment_delete_form' method='post' action='sections/ppl_appointment_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
			
			print( "<a href='{$_home}/help/index.php#facul_app' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_appointment\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ppl_appointment\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		$ppl_appointment_max_id_rows = mysql_fetch_row( $ppl_appointment_max_id_results );
		$max_app_id = $ppl_appointment_max_id_rows[0];
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_appointment_add_box' class='hiddenbox'>" );
		print( "<form id='ppl_appointment_add_form' method='post' action='sections/ppl_appointment_add_box_submit.php' >" );
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='view' value='$view' />" );
		print( "<input type='hidden' name='max_app_id' value='$max_app_id' />" );
			print( "<tr class='table_background_other'>" );
				print( "<td width='15%' align='center'>&nbsp;<span class='form_elements_text'>Duration</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>Rank</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>Department / School</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>College / Office</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>University / Company</span></td>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Hide</span></td>" );
				print( "<td width='15%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_appointment\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ppl_appointment\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_appointment_s_date1' value='' maxlength='16' size='4'>-" );
				print( "<input class='form_elements_edit' type='text' name='ppl_appointment_e_date1' value='' maxlength='16' size='4	'>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_rank1' value='' maxlength='255' size='15'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_dept_school1' value='' maxlength='255' size='15'</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_off_coll1' value='' maxlength='255' size='15'</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_univ_comp1' value='' maxlength='255' size='15'</td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_appointment_status1' >" );
				print( "<td >&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_appointment_s_date2' value='' maxlength='16' size='4'>" );
				print( "-<input class='form_elements_edit' type='text' name='ppl_appointment_e_date2' value='' maxlength='16' size='4'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_rank2' value='' maxlength='255' size='15'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_dept_school2' value='' maxlength='255' size='15'</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_off_coll2' value='' maxlength='255' size='15'</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_univ_comp2' value='' maxlength='255' size='15'</td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_appointment_status2' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_appointment_s_date3' value='' maxlength='16' size='4'>" );
				print( "-<input class='form_elements_edit' type='text' name='ppl_appointment_e_date3' value='' maxlength='16' size='4'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_rank3' value='' maxlength='255' size='15'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_dept_school3' value='' maxlength='255' size='15'</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_off_coll3' value='' maxlength='255' size='15'</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_univ_comp3' value='' maxlength='255' size='15'</td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_appointment_status3' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='6' align='right'>" );
				print( "</td>" );				
			print( "</tr>" );
		print( "</form>" );
		print( "</table>" );
	}
	
	print( "<table width='100%'  border='1' cellspacing='0' cellpadding='0' id='ppl_appointment_view_box' class='visiblebox'>" );
		if( $ppl_appointment_num_rows > 0 )
		{
			print( "<tr class='table_background_other'>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>Duration</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>Rank</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>Department / School</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>College / Office</span></td>" );
				print( "<td align='center'><span class='form_elements_text'>University / Company</span></td>" );
				if( $editable == true )
				{
					print( "<td width='20%' align='right'>&nbsp;</td>" );
				}
			print( "</tr>" );
		}
		if( $ppl_appointment_num_rows > 0 )
			mysql_data_seek( $ppl_appointment_results, 0 );
		$ppl_appointment_rows_itr = 0;
		$rowclass = " class = 'table_background_edit' ";
		while( $ppl_appointment_rows = mysql_fetch_array( $ppl_appointment_results ) )
		{
			$ppl_appointment_rows_itr ++;
			
			$app_id = $ppl_appointment_rows["app_id"];
			print( "<tr id='ppl_appointment_" . $ppl_appointment_rows_itr . "_view_row' class='visiblerow'>" );
			
			if( $ppl_appointment_rows["status"] == 0 )
				$span = "<span class='form_elements_text'>";
			else
				$span = "<span class='form_elements_text_disabled'>";

				if( $ppl_appointment_rows["status"] == 0 || $editable == true )
				{
					$duration = htmlspecialchars($ppl_appointment_rows["s_date"], ENT_QUOTES);
					if( $ppl_appointment_rows["e_date"] != "" && $ppl_appointment_rows["s_date"] != "" ) 
						$duration = $duration . "-" ;
					$duration = $duration . htmlspecialchars($ppl_appointment_rows["e_date"], ENT_QUOTES);
					print( "<td align='center'>$span". ($duration==""?"&nbsp;":$duration) . "</span></td>" );
					print( "<td align='center'>$span". ($ppl_appointment_rows["rank"] == "" ? "&nbsp;" : htmlspecialchars($ppl_appointment_rows["rank"], ENT_QUOTES) ). "</span></td>" );
					print( "<td align='center'>$span". ($ppl_appointment_rows["dept_school"] == "" ? "&nbsp;" : htmlspecialchars($ppl_appointment_rows["dept_school"], ENT_QUOTES) ). "</span></td>" );
					print( "<td align='center'>$span". ($ppl_appointment_rows["off_coll"] == "" ? "&nbsp;" : htmlspecialchars($ppl_appointment_rows["off_coll"], ENT_QUOTES) ). "</span></td>" );
					print( "<td align='center'>$span". ($ppl_appointment_rows["univ_comp"] == "" ? "&nbsp;" : htmlspecialchars($ppl_appointment_rows["univ_comp"], ENT_QUOTES) ). "</span></td>" );
					if( $editable == true )
					{
						print( "<form id='ppl_appointment_" . $ppl_appointment_rows_itr . "_delete_form' method='post' action='sections/ppl_appointment_delete_row_submit.php' >" );
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<input type='hidden' name='app_id' value='$app_id' />" );
						print( "</form>" );
						print( "<td align='right'> <a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_appointment\", \"$ppl_appointment_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
						print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ppl_appointment\", \"$ppl_appointment_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a></td>" );
					}
				}
			print( "</tr>" );
			if( $editable == true )
			{
				print( "<tr id='ppl_appointment_" . $ppl_appointment_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<form id='ppl_appointment_" . $ppl_appointment_rows_itr . "_edit_form' method='post' action='sections/ppl_appointment_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='app_id' value='$app_id' />" );
					
					print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_appointment_s_date' value='". htmlspecialchars( $ppl_appointment_rows["s_date"], ENT_QUOTES). "' maxlength='16' size='4'>" );
					print( "-<input class='form_elements_edit' type='text' name='ppl_appointment_e_date' value='". htmlspecialchars($ppl_appointment_rows["e_date"], ENT_QUOTES). "' maxlength='16' size='4'></td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_rank' value='". htmlspecialchars($ppl_appointment_rows["rank"], ENT_QUOTES). "' maxlength='255' size='15'></td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_dept_school' value='". htmlspecialchars($ppl_appointment_rows["dept_school"], ENT_QUOTES). "' maxlength='255' size='15'</td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_off_coll' value='". htmlspecialchars($ppl_appointment_rows["off_coll"], ENT_QUOTES). "' maxlength='255' size='15'</td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_appointment_univ_comp' value='". htmlspecialchars( $ppl_appointment_rows["univ_comp"], ENT_QUOTES). "' maxlength='255' size='15'</td>" );
					if( $ppl_appointment_rows[ "status" ] == 0 )
						$checkboxvalue = "";
					else
						$checkboxvalue = "checked";					
					print( "<td align='right'>" );
					print( "<input type='checkbox' name='ppl_appointment_status' $checkboxvalue><span class='form_elements_edit'> Hide &nbsp;</span>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_appointment\", \"$ppl_appointment_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ppl_appointment\", \"$ppl_appointment_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</form>" );
				print( "</tr>" );
			}
		}
	print( "<tr><td colspan='6' height='10'></td></tr>" );
	print( "</table>" );
}	
?>
