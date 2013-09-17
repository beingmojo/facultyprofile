<?php
$fac_people_num_rows = mysql_num_rows( $fac_people_results );
if($fac_people_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_people_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			//if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='fac_people_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"fac_people\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='fac_people_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"fac_people\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Participating Faculty</span></td>" );
			print( "<form name='fac_people_delete_form' id='fac_people_delete_form' method='post' action='sections/fac_people_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#facil_participatingfaculty' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"fac_people\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"fac_people\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_people_add_box' class='hiddenbox'>" );
		$fac_people_max_id_rows = mysql_fetch_row( $fac_people_max_id_results );
		$max_ppl_id = $fac_people_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form id='fac_people_add_form' method='post' action='sections/fac_people_add_box_submit.php' >" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='view' value='$view' />" );
		print( "<input type='hidden' name='max_ppl_id' value='$max_ppl_id' />" );		
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<td>" );
		print( "<span class='form_elements_text'>" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td> &nbsp; Find existing profiles to add them to the list of Equipments</td>" );
				print( "<td width='20%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='fpUpdateRows( \"fac_people_add_form\", \"fac_people_find\" ); return submit_box( \"fac_people\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"fac_people\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr >" );
				print( "<td colspan='2'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "createFindProfileTable('fac_people_find', 'ppla', -1);" );
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
	
	print( "<table width='100%'  border='1' cellspacing='0' cellpadding='2' id='fac_people_view_box' class='visiblebox'>" );
		if( $fac_people_num_rows > 0 )
			mysql_data_seek( $fac_people_results, 0 );
		$fac_people_rows_itr = 0;
		while( $fac_people_rows = mysql_fetch_array( $fac_people_results ) )
		{
			
			$fac_people_rows_itr ++;
			$ppl_id = $fac_people_rows["ppl_id"];
			print( "<tr id='fac_people_" . $fac_people_rows_itr . "_view_row' class='visiblerow'>" );
				if( $editable == true )
				{
					print( "<form id='fac_people_" . $fac_people_rows_itr . "_delete_form' method='post' action='sections/fac_people_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='ppl_id' value='$ppl_id' />" );
					print( "<input type='hidden' name='fac_people_image_id' value='" . $fac_people_rows["image_id"] . "' />" );						
					print( "</form>" );
				}
				print( "<td align='left' width='20%'>" );
					$span = "<span class='form_elements_section_subheader'>";
					if( $fac_people_rows["ppl_pid"] != 0 )
						print( "$span<a href='editprofile.php?loginid=" . $fac_people_rows["login_id"] ."'>". htmlspecialchars($fac_people_rows["name"], ENT_QUOTES). "</a></span>" );
					else
						print( $span . htmlspecialchars($fac_people_rows["name"], ENT_QUOTES) . "</span>" );
				print( "</td>" );
				print( "<td align='left'>" );
					$span = "<span class='form_elements_text'>";
					print( "$span". htmlspecialchars($fac_people_rows["rank"]) . "</span>" );
				print( "</td>" );
				if( $editable == true )
				{
					print( "<td width='20%' align='right'>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"fac_people\", \"$fac_people_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
					if( $fac_people_rows["ppl_pid"] == 0 )
						print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"fac_people\", \"$fac_people_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );
					print( "</td>" );
				}
			print( "</tr>" );
			if( $editable == true && $fac_people_rows["ppl_pid"] == 0 )
			{
				print( "<tr id='fac_people_" . $fac_people_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<form enctype='multipart/form-data' id='fac_people_" . $fac_people_rows_itr . "_edit_form' method='post' action='sections/fac_people_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='ppl_id' value='$ppl_id' />" );
					print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
					print( "<input type='hidden' name='fac_people_image_id' value='" . $fac_people_rows["image_id"] . "' />" );
					print( "<td colspan='2'><table width='100%' cellpadding='0'><tr>" );
					print( "<td><span class='form_elements_text'>Title</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='fac_people_title' value='". htmlspecialchars( $fac_people_rows["title"], ENT_QUOTES ).  "' maxlength='255' size='5'>" );
					print( "<td><span class='form_elements_text'>First Name</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='fac_people_f_name' value='". htmlspecialchars( $fac_people_rows["f_name"], ENT_QUOTES ).  "' maxlength='255' size='20'>" );
					print( "<td><span class='form_elements_text'>Last Name</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='fac_people_l_name' value='". htmlspecialchars( $fac_people_rows["l_name"], ENT_QUOTES ).  "' maxlength='255' size='20'></td>" );
					print( "</tr>" );
					print( "<tr>" );
					print( "<td><span class='form_elements_text'>Middle Name</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='fac_people_m_name' value='". htmlspecialchars( $fac_people_rows["m_name"], ENT_QUOTES ).  "' maxlength='255' size='20'>" );
					print( "<td><span class='form_elements_text'>Rank</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='fac_people_rank' value='". htmlspecialchars( $fac_people_rows["rank"], ENT_QUOTES ).  "' maxlength='255' size='20'></td>" );
					print( "<td><span class='form_elements_text'>$_login_id</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='fac_people_login_id' value='". htmlspecialchars( $fac_people_rows["login_id"], ENT_QUOTES ).  "' maxlength='255' size='10'></td>" );
					print( "</tr></table></td>" );			
					print( "<td align='right'>" );							
					print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"fac_people\", \"$fac_people_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"fac_people\", \"$fac_people_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );

				print( "</form>" );
				print( "</tr>" );
			
			}

		}
	print( "<tr><td colspan='3' height='10'></td></tr>" );
	print( "</table>" );
}

?>
