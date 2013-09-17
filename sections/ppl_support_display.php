<?php
$ppl_support_num_rows = mysql_num_rows( $ppl_support_results );
if($ppl_support_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_support_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
//			if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ppl_support_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ppl_support\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ppl_support_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ppl_support\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Support</span></td>" );
			print( "<form name='ppl_support_delete_form' id='ppl_support_delete_form' method='post' action='sections/ppl_support_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#facul_support' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_support\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ppl_support\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		$ppl_support_max_id_rows = mysql_fetch_row( $ppl_support_max_id_results );
		$max_sup_id = $ppl_support_max_id_rows[0];
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_support_add_box' class='hiddenbox'>" );
		print( "<form id='ppl_support_add_form' method='post' action='sections/ppl_support_add_box_submit.php' >" );
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='view' value='$view' />" );
		print( "<input type='hidden' name='max_sup_id' value='$max_sup_id' />" );
			print( "<tr class='table_background_other'>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>Duration</span></td>" );
				print( "<td  align='center'><span class='form_elements_text'>Project Title</span></td>" );
				print( "<td width='20%' align='center'><span class='form_elements_text'>Sponsor</span></td>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Amount</span></td>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Status</span></td>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Hide</span></td>" );
				print( "<td width='15%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_support\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ppl_support\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_support_s_date1' value='' maxlength='16' size='4'>" );
				print( "-<input class='form_elements_edit' type='text' name='ppl_support_e_date1' value='' maxlength='16' size='4	'>" );
				print( "</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_title1' value='' maxlength='255' size='20'></td>" );
				print( "<td  align='center'><input class='form_elements_edit' type='text' name='ppl_support_sponsor1' value='' maxlength='255' size='20'</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_award_amt1' value='' maxlength='32' size='8'</td>" );
				print( "<td align='center'><select class='form_elements_edit_combo' name='ppl_support_prj_status1'>");
				print( "<option value='1'>Current" );
				print( "<option value='2'>Previous" );
				print( "<option value='3'>Pending" );
				print( "</select></td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_support_status1' >" );
				print( "<td >&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_support_s_date2' value='' maxlength='16' size='4'>" );
				print( "-<input class='form_elements_edit' type='text' name='ppl_support_e_date2' value='' maxlength='16' size='4	'>" );
				print( "</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_title2' value='' maxlength='255' size='20'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_sponsor2' value='' maxlength='255' size='20'</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_award_amt2' value='' maxlength='32' size='8'</td>" );
				print( "<td align='center'><select class='form_elements_edit_combo' name='ppl_support_prj_status2'>");
				print( "<option value='1'>Current" );
				print( "<option value='2'>Previous" );
				print( "<option value='3'>Pending" );
				print( "</select></td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_support_status2' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_support_s_date3' value='' maxlength='16' size='4'>" );
				print( "-<input class='form_elements_edit' type='text' name='ppl_support_e_date3' value='' maxlength='16' size='4	'>" );
				print( "</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_title3' value='' maxlength='255' size='20'></td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_sponsor3' value='' maxlength='255' size='20'</td>" );
				print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_award_amt3' value='' maxlength='32' size='8'</td>" );
				print( "<td align='center'><select class='form_elements_edit_combo' name='ppl_support_prj_status3'>");
				print( "<option value='1'>Current" );
				print( "<option value='2'>Previous" );
				print( "<option value='3'>Pending" );
				print( "</select></td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_support_status3' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='6' align='right'>" );
				print( "</td>" );				
			print( "</tr>" );
		print( "</form>" );
		print( "</table>" );
	}
	
	print( "<table width='100%'  border='1' cellspacing='0' cellpadding='0' id='ppl_support_view_box' class='visiblebox'>" );
		if( $ppl_support_num_rows > 0 )
		{
			print( "<tr class='table_background_other'>" );
				print( "<td width='15%' align='center'>&nbsp;<span class='form_elements_text'>Duration</span></td>" );
				print( "<td  align='center'><span class='form_elements_text'>Title</span></td>" );
				print( "<td width='20%' align='center'><span class='form_elements_text'>Sponsor</span></td>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Amount</span></td>" );
				print( "<td width='12%' align='center'><span class='form_elements_text'>Status</span></td>" );
				if( $editable == true )
				{
					print( "<td width='20%' align='right'>&nbsp;</td>" );
				}
			print( "</tr>" );
		}
		if( $ppl_support_num_rows > 0 )
			mysql_data_seek( $ppl_support_results, 0 );
		$ppl_support_rows_itr = 0;
		while( $ppl_support_rows = mysql_fetch_array( $ppl_support_results ) )
		{
			
			$ppl_support_rows_itr ++;
			$sup_id = $ppl_support_rows["sup_id"];
			print( "<tr id='ppl_support_" . $ppl_support_rows_itr . "_view_row' class='visiblerow'>" );
			
			if( $ppl_support_rows["status"] == 0 )
				$span = "<span class='form_elements_text'>";
			else
				$span = "<span class='form_elements_text_disabled'>";

				if( $ppl_support_rows["status"] == 0 || $editable == true )
				{
					$duration = htmlspecialchars($ppl_support_rows["s_date"], ENT_QUOTES);
					if( $ppl_support_rows["e_date"] != "" && $ppl_support_rows["s_date"] != "" ) 
						$duration = $duration . "-" ;
					$duration = $duration . htmlspecialchars($ppl_support_rows["e_date"], ENT_QUOTES);
				
					print( "<td align='center'>$span". ($duration==""?"&nbsp;":$duration). "</span></td>" );
					print( "<td >$span". ($ppl_support_rows["title"] == "" ? "&nbsp;" : htmlspecialchars($ppl_support_rows["title"], ENT_QUOTES) ). "</span></td>" );
					print( "<td align='center'>$span". ($ppl_support_rows["sponsor"] == "" ? "&nbsp" : htmlspecialchars($ppl_support_rows["sponsor"], ENT_QUOTES) ). "</span></td>" );
					print( "<td align='center'>$span". ($ppl_support_rows["award_amt"] == "" ? "&nbsp" : htmlspecialchars($ppl_support_rows["award_amt"], ENT_QUOTES) ). "</span></td>" );
					if( $ppl_support_rows["prj_status"] == 1 ) $prj_status = "Current";
					if( $ppl_support_rows["prj_status"] == 2 ) $prj_status = "Previous";
					if( $ppl_support_rows["prj_status"] == 3 ) $prj_status = "Pending";
					print( "<td align='center'>$span". $prj_status. "</span></td>" );
					if( $editable == true )
					{
						print( "<form id='ppl_support_" . $ppl_support_rows_itr . "_delete_form' method='post' action='sections/ppl_support_delete_row_submit.php' >" );
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<input type='hidden' name='sup_id' value='$sup_id' />" );
						print( "</form>" );
						print( "<td align='right'> <a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_support\", \"$ppl_support_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
						print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ppl_support\", \"$ppl_support_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a></td>" );
					}
				}
			print( "</tr>" );
			if( $editable == true )
			{
				print( "<tr id='ppl_support_" . $ppl_support_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<form id='ppl_support_" . $ppl_support_rows_itr . "_edit_form' method='post' action='sections/ppl_support_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='sup_id' value='$sup_id' />" );
					
					print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_support_s_date' value='". htmlspecialchars($ppl_support_rows["s_date"], ENT_QUOTES). "' maxlength='16' size='4'>" );
					print( "-<input class='form_elements_edit' type='text' name='ppl_support_e_date' value='". htmlspecialchars($ppl_support_rows["e_date"], ENT_QUOTES). "' maxlength='16' size='4'></td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_title' value='". htmlspecialchars($ppl_support_rows["title"], ENT_QUOTES). "' maxlength='255' size='20'></td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_sponsor' value='". htmlspecialchars($ppl_support_rows["sponsor"], ENT_QUOTES). "' maxlength='255' size='20'</td>" );
					print( "<td align='center'><input class='form_elements_edit' type='text' name='ppl_support_award_amt' value='". htmlspecialchars($ppl_support_rows["award_amt"], ENT_QUOTES). "' maxlength='255' size='8'</td>" );
					print( "<td align='center'><select class='form_elements_edit_combo' name='ppl_support_prj_status'>");
					$prj_status =  $ppl_support_rows["prj_status"] == 1? "selected" : "";
					print( "<option value='1' $prj_status>Current" );
					$prj_status =  $ppl_support_rows["prj_status"] == 2? "selected" : "";
					print( "<option value='2' $prj_status>Previous" );
					$prj_status =  $ppl_support_rows["prj_status"] == 3? "selected" : "";
					print( "<option value='3' $prj_status>Pending" );
					print( "</select></td>" );
					if( $ppl_support_rows[ "status" ] == 0 )
						$checkboxvalue = "";
					else
						$checkboxvalue = "checked";					
					print( "<td align='right'>" );
					print( "<input type='checkbox' name='ppl_support_status' $checkboxvalue><span class='form_elements_edit'> Hide &nbsp;</span>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_support\", \"$ppl_support_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ppl_support\", \"$ppl_support_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</form>" );
				print( "</tr>" );
			}
		}
	print( "<tr><td colspan='7' height='10'></td></tr>" );
	print( "</table>" );
}	
?>
