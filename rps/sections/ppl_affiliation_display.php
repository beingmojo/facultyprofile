<?php
$ppl_affiliation_num_rows = mysql_num_rows( $ppl_affiliation_results );
if($ppl_affiliation_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_affiliation_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
//			if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ppl_affiliation_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ppl_affiliation\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ppl_affiliation_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ppl_affiliation\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Affiliations</span></td>" );
			print( "<form name='ppl_affiliation_delete_form' id='ppl_affiliation_delete_form' method='post' action='sections/ppl_affiliation_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{	
			
				print( "<a href='{$_home}/help/index.php#facul_aff' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_affiliation\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ppl_affiliation\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		$ppl_affiliation_max_id_rows = mysql_fetch_row( $ppl_affiliation_max_id_results );
		$max_aff_id = $ppl_affiliation_max_id_rows[0];
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_affiliation_add_box' class='hiddenbox'>" );

		print( "<form id='ppl_affiliation_add_form' method='post' action='sections/ppl_affiliation_add_box_submit.php' >" );
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='view' value='$view' />" );
		print( "<input type='hidden' name='max_aff_id' value='$max_aff_id' />" );
			print( "<tr class='table_background_other'>" );
				print( "<td width='20%' align='center'><span class='form_elements_text'>Name</span></td>" );
				print( "<td align='center'><span class='form_elements_text'>List of people</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>Type</span></td>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Hide</span></td>" );
				print( "<td width='15%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_affiliation\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ppl_affiliation\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );

				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_affiliation_name1' value='' maxlength='100' size='20'></td>" );
				print( "<td align='center'><textarea class='form_elements_text' name='ppl_affiliation_list_of_ppl1' cols='50' rows='3'> </textarea></td>" );
				print( "<td align='center'>" );
				print( "<select class='form_elements_edit_combo' name='ppl_affiliation_category1' style='width:100px'>" );
				if( mysql_num_rows( $ppl_affiliation_category_results ) > 0 )
					mysql_data_seek( $ppl_affiliation_category_results, 0 );
				print( "<option value='' >" );
				while( $ppl_affiliation_category_rows = mysql_fetch_array( $ppl_affiliation_category_results ) )
				{
					if( $ppl_affiliation_category_rows["type"] != '' )
						print( "<option value='". htmlspecialchars( $ppl_affiliation_category_rows["type"], ENT_QUOTES ) ."'  >" . htmlspecialchars( $ppl_affiliation_category_rows["type"], ENT_QUOTES) );
				}
				print( "</select>" );
				print( "<BR><input class='form_elements_edit' type='text' name='ppl_affiliation_type1' value='' maxlength='100' style='width:100px'></td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_affiliation_status1' >" );
				print( "<td >&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );

				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_affiliation_name2' value='' maxlength='100' size='20'></td>" );
				print( "<td align='center'><textarea class='form_elements_text' name='ppl_affiliation_list_of_ppl2' cols='50' rows='3'> </textarea></td>" );
				print( "<td align='center'>" );
				print( "<select class='form_elements_edit_combo' name='ppl_affiliation_category2' style='width:100px'>" );
				if( mysql_num_rows( $ppl_affiliation_category_results ) > 0 )
					mysql_data_seek( $ppl_affiliation_category_results, 0 );
				print( "<option value='' >" );
				while( $ppl_affiliation_category_rows = mysql_fetch_array( $ppl_affiliation_category_results ) )
				{
					if( $ppl_affiliation_category_rows["type"] != '' )
						print( "<option value='". htmlspecialchars( $ppl_affiliation_category_rows["type"], ENT_QUOTES) ."'  >" . htmlspecialchars( $ppl_affiliation_category_rows["type"]) );
				}
				print( "</select>" );
				print( "<BR><input class='form_elements_edit' type='text' name='ppl_affiliation_type2' value='' maxlength='100' style='width:100px'></td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_affiliation_status2' >" );
				print( "<td >&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_affiliation_name3' value='' maxlength='100' size='20'></td>" );
				print( "<td align='center'><textarea class='form_elements_text' name='ppl_affiliation_list_of_ppl3' cols='50' rows='3'> </textarea></td>" );
				print( "<td align='center'>" );
				print( "<select class='form_elements_edit_combo' name='ppl_affiliation_category3' style='width:100px'>" );
				if( mysql_num_rows( $ppl_affiliation_category_results ) > 0 )
					mysql_data_seek( $ppl_affiliation_category_results, 0 );
				print( "<option value='' >" );
				while( $ppl_affiliation_category_rows = mysql_fetch_array( $ppl_affiliation_category_results ) )
				{
					if( $ppl_affiliation_category_rows["type"] != '' )
						print( "<option value='". htmlspecialchars( $ppl_affiliation_category_rows["type"], ENT_QUOTES) ."'  >" . htmlspecialchars($ppl_affiliation_category_rows["type"]) );
				}
				print( "</select>" );
				print( "<BR><input class='form_elements_edit' type='text' name='ppl_affiliation_type3' value='' maxlength='100' style='width:100px'></td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_affiliation_status3' >" );
				print( "<td >&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='6' align='right'>" );
				print( "<HR>" );
				print( "</td>" );				
			print( "</tr>" );
		print( "</form>" );
		print( "</table>" );
	}
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_affiliation_view_box' class='visiblebox'>" );
		if( $ppl_affiliation_num_rows > 0 )
			mysql_data_seek( $ppl_affiliation_results, 0 );
		$ppl_affiliation_rows_itr = 0;
		$prev_ppl_affiliation_type = "";
		while( $ppl_affiliation_rows = mysql_fetch_array( $ppl_affiliation_results ) )
		{			
			$ppl_affiliation_rows_itr ++;
			$aff_id = $ppl_affiliation_rows["aff_id"];
			
			$curr_ppl_affiliation_type = $prev_ppl_affiliation_type == $ppl_affiliation_rows["type"]?"":$ppl_affiliation_rows["type"];
			$prev_ppl_affiliation_type = $ppl_affiliation_rows["type"];	
			
			if( $ppl_affiliation_rows["status"] == 0 )
				$span = "<span class='form_elements_section_subheader'>";
			else
				$span = "<span class='form_elements_section_subheader_disabled'>";

			if( $curr_ppl_affiliation_type != "" )
				print( "<tr><td colspan='5'>$span&nbsp;". htmlspecialchars( $curr_ppl_affiliation_type) . "</span></td></tr>" );

			if( $ppl_affiliation_rows["status"] == 0 )
				$span = "<span class='form_elements_text'>";
			else
				$span = "<span class='form_elements_text_disabled'>";

			print( "<tr id='ppl_affiliation_" . $ppl_affiliation_rows_itr . "_view_row' class='visiblerow'>" );
			

				if( $ppl_affiliation_rows["status"] == 0 || $editable == true )
				{
					print( "<td width='10'></td>" );
					print( "<td align='left' colspan='3'>" );
					print( "<table>" );
						print( "<tr>" );
							print( "<td colspan='2' align='left'>$span". htmlspecialchars($ppl_affiliation_rows["name"]).  "</span></td>" );
						print( "</tr>" );	
						print( "<tr>" );
							print( "<td width='10'></td>" );
							print( "<td align='left'>$span". nl2br(htmlspecialchars($ppl_affiliation_rows["list_of_ppl"])) . "</span></td>" );
						print( "</tr>" );
					print( "</table>" );
					print( "</td>" );
					
					if( $editable == true )
					{
						print( "<form id='ppl_affiliation_" . $ppl_affiliation_rows_itr . "_delete_form' method='post' action='sections/ppl_affiliation_delete_row_submit.php' >" );
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<input type='hidden' name='aff_id' value='$aff_id' />" );
						print( "</form>" );
						print( "<td align='right' > <a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_affiliation\", \"$ppl_affiliation_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
						print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ppl_affiliation\", \"$ppl_affiliation_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a></td>" );
					}
				}
			print( "</tr>" );
			if( $editable == true )
			{
				print( "<tr id='ppl_affiliation_" . $ppl_affiliation_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<form id='ppl_affiliation_" . $ppl_affiliation_rows_itr . "_edit_form' method='post' action='sections/ppl_affiliation_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='aff_id' value='$aff_id' />" );
					print( "<td width='10'></td>" );
					print( "<td width='20%'>&nbsp;<input class='form_elements_edit'type='text' name='ppl_affiliation_name' value='". htmlspecialchars( $ppl_affiliation_rows["name"], ENT_QUOTES). "' maxlength='100' size='20'></td>" );
					print( "<td  ><textarea class='form_elements_text' name='ppl_affiliation_list_of_ppl' cols='60' rows='3'> " . htmlspecialchars( $ppl_affiliation_rows["list_of_ppl"], ENT_QUOTES). "</textarea></td>" );
					print( "<td align='center' width='15%'>" );
					print( "<select class='form_elements_edit_combo' name='ppl_affiliation_category' style='width:100px'>" );
					if( mysql_num_rows( $ppl_affiliation_category_results ) > 0 )
						mysql_data_seek( $ppl_affiliation_category_results, 0 );
					print( "<option value='' >" );
					while( $ppl_affiliation_category_rows = mysql_fetch_array( $ppl_affiliation_category_results ) )
					{
						if( $ppl_affiliation_category_rows["type"] != '' )
						{
							print( "<option value='". htmlspecialchars($ppl_affiliation_category_rows["type"], ENT_QUOTES) ."' ");
							if( $ppl_affiliation_rows["type"] == $ppl_affiliation_category_rows["type"] )
								print( " selected " );
							print( " >" . htmlspecialchars( $ppl_affiliation_category_rows["type"]) );
						}
					}
					print( "</select>" );
					print( "<BR><input class='form_elements_edit' type='text' name='ppl_affiliation_type' value='' maxlength='100' style='width:100px'></td>" );
					
					if( $ppl_affiliation_rows[ "status" ] == 0 )
						$checkboxvalue = "";
					else
						$checkboxvalue = "checked";					
					print( "<td align='right' width='20%'>" );
					print( "<input type='checkbox' name='ppl_affiliation_status' $checkboxvalue><span class='form_elements_edit'> Hide &nbsp;</span>" );
					

					print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_affiliation\", \"$ppl_affiliation_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ppl_affiliation\", \"$ppl_affiliation_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</form>" );
				print( "</tr>" );
			}
		}
	print( "<tr><td colspan='6' height='10'></td></tr>" );
	print( "</table>" );
}	
?>
