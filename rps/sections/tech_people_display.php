<?php
$tech_people_num_rows = mysql_num_rows( $tech_people_results );
if($tech_people_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='tech_people_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			//if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='tech_people_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"tech_people\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='tech_people_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"tech_people\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Researchers</span></td>" );
			print( "<form name='tech_people_delete_form' id='tech_people_delete_form' method='post' action='sections/tech_people_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#techn_researchers' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"tech_people\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"tech_people\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='tech_people_add_box' class='hiddenbox'>" );
		$tech_people_max_id_rows = mysql_fetch_row( $tech_people_max_id_results );
		$max_ppl_id = $tech_people_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form id='tech_people_add_form' method='post' action='sections/tech_people_add_box_submit.php' >" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='view' value='$view' />" );
		print( "<input type='hidden' name='max_ppl_id' value='$max_ppl_id' />" );		
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<td>" );
		print( "<span class='form_elements_text'>" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td> &nbsp; Find existing profiles to add them to the list of Researchers</td>" );
				print( "<td width='20%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='fpUpdateRows( \"tech_people_add_form\", \"tech_people_find\" ); return submit_box( \"tech_people\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"tech_people\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr >" );
				print( "<td colspan='2'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "createFindProfileTable('tech_people_find', 'ppl', -1);" );
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
	
	print( "<table width='100%'  border='1' cellspacing='0' cellpadding='2' id='tech_people_view_box' class='visiblebox'>" );
		if( $tech_people_num_rows > 0 )
			mysql_data_seek( $tech_people_results, 0 );
		$tech_people_rows_itr = 0;
		while( $tech_people_rows = mysql_fetch_array( $tech_people_results ) )
		{
			
			$tech_people_rows_itr ++;
			$ppl_id = $tech_people_rows["ppl_id"];
			print( "<tr id='tech_people_" . $tech_people_rows_itr . "_view_row' class='visiblerow'>" );
				if( $editable == true )
				{
					print( "<form id='tech_people_" . $tech_people_rows_itr . "_delete_form' method='post' action='sections/tech_people_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='ppl_id' value='$ppl_id' />" );
					print( "<input type='hidden' name='tech_people_image_id' value='" . $tech_people_rows["image_id"] . "' />" );						
					print( "</form>" );
				}
				print( "<td align='left' width='20%'>" );
					$span = "<span class='form_elements_section_subheader'>";
					if( $tech_people_rows["ppl_pid"] != 0 )
						print( "$span<a href='editprofile.php?loginid=" . $tech_people_rows["login_id"] ."'>". htmlspecialchars($tech_people_rows["name"], ENT_QUOTES). "</a></span>" );
					else
						print( $span . htmlspecialchars($tech_people_rows["name"], ENT_QUOTES) . "</span>" );
				print( "</td>" );
				print( "<td align='left'>" );
					$span = "<span class='form_elements_text'>";
					$rank = ($tech_people_rows["rank"]=="" ? "&nbsp;" : htmlspecialchars( $tech_people_rows["rank"], ENT_QUOTES ));
					print( "$span". $rank . "</span>" );
				print( "</td>" );
				if( $editable == true )
				{
					print( "<td width='20%' align='right'>" );
					
					print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"tech_people\", \"$tech_people_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
					//if( $tech_people_rows["ppl_pid"] == 0 )
					//	print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"tech_people\", \"$tech_people_rows_itr\" )'><img border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );
					print( "</td>" );
				}
			print( "</tr>" );
			if( $editable == true && $tech_people_rows["ppl_pid"] == 0 )
			{
				print( "<tr id='tech_people_" . $tech_people_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<form enctype='multipart/form-data' id='tech_people_" . $tech_people_rows_itr . "_edit_form' method='post' action='sections/tech_people_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='ppl_id' value='$ppl_id' />" );
					print( "<td colspan='2'><table width='100%' cellpadding='0'><tr>" );
					print( "<td><span class='form_elements_text'>Title</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='tech_people_title' value='". htmlspecialchars( $tech_people_rows["title"], ENT_QUOTES ).  "' maxlength='255' size='5'>" );
					print( "<td><span class='form_elements_text'>First Name</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='tech_people_f_name' value='". htmlspecialchars( $tech_people_rows["f_name"], ENT_QUOTES ).  "' maxlength='255' size='20'>" );
					print( "<td><span class='form_elements_text'>Last Name</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='tech_people_l_name' value='". htmlspecialchars( $tech_people_rows["l_name"], ENT_QUOTES ).  "' maxlength='255' size='20'></td>" );
					print( "</tr>" );
					print( "<tr>" );
					print( "<td><span class='form_elements_text'>Middle Name</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='tech_people_m_name' value='". htmlspecialchars( $tech_people_rows["m_name"], ENT_QUOTES ).  "' maxlength='255' size='20'>" );
					print( "<td><span class='form_elements_text'>Rank</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='tech_people_rank' value='". htmlspecialchars( $tech_people_rows["rank"], ENT_QUOTES ).  "' maxlength='255' size='20'></td>" );
					print( "<td><span class='form_elements_text'>$_login_id</span></td>" );
					print( "<td><input class='form_elements_edit' type='text' name='tech_people_login_id' value='". htmlspecialchars( $tech_people_rows["login_id"], ENT_QUOTES ).  "' maxlength='255' size='10'></td>" );
					print( "</tr></table></td>" );			
					print( "<td align='right'>" );							
					print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"tech_people\", \"$tech_people_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"tech_people\", \"$tech_people_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );

				print( "</form>" );
				print( "</tr>" );
			
			}

		}
	print( "<tr><td colspan='3' height='10'></td></tr>" );
	print( "</table>" );
}

?>
