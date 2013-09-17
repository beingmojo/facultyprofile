<?php
$fac_researchcenter_num_rows = mysql_num_rows( $fac_researchcenter_results );
if($fac_researchcenter_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_researchcenter_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			//if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='fac_researchcenter_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"fac_researchcenter\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='fac_researchcenter_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"fac_researchcenter\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Research Centers</span></td>" );
			print( "<form name='fac_researchcenter_delete_form' id='fac_researchcenter_delete_form' method='post' action='sections/fac_researchcenter_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#facil_researchcenters' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"fac_researchcenter\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"fac_researchcenter\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_researchcenter_add_box' class='hiddenbox'>" );
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<td>" );
		print( "<span class='form_elements_text'>" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td> &nbsp; Find existing profiles to add them to the list of Research Centers</td>" );
				print( "<td width='20%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='fpUpdateRows( \"fac_researchcenter_add_form\", \"fac_researchcenter_find\" ); return submit_box( \"fac_researchcenter\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"fac_researchcenter\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr >" );
				print( "<form id='fac_researchcenter_add_form' method='post' action='sections/fac_researchcenter_add_box_submit.php' >" );
				print( "<input type='hidden' name='pid' value='$pid' />" );
				print( "<input type='hidden' name='section_id' value='$section_id' />" );
				print( "<input type='hidden' name='view' value='$view' />" );
				print( "<input type='hidden' name='clicked' value='0' />" );
				print( "<td colspan='2'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "createFindProfileTable('fac_researchcenter_find', 'ctr', -1);" );
				print( "</script>" );
				print( "</td>" );
				print( "</form>" );
			print( "</tr>" );
			print( "<tr><td colspan='2'><HR></td></tr>" );
			if( mysql_num_rows( $fac_researchcenter_add_req_results ) > 0 )
			{
				print( "<tr><td colspan='2'>The following research center profiles are already requested to be added</td></tr>" );
				$counter = 0;
				print( "<tr>" );
					print( "<td colspan='2'>" );
					print( "<table width='100%' border='1' cellspacing='0'>" );
						print( "<tr class='table_background_other'>" );
							print( "<form id='fac_researchcenter_add_req_delete_form' method='post' action='sections/fac_researchcenter_req_delete_box_submit.php' >" );
							print( "<input type='hidden' name='pid' value='$pid' />" );
							print( "<input type='hidden' name='section_id' value='$section_id' />" );
							print( "<input type='hidden' name='view' value='$view' />" );
							print( "</form>" );
							print( "<form id='fac_researchcenter_add_req_add_form' method='post' action='sections/fac_researchcenter_req_add_box_submit.php' >" );
							print( "<input type='hidden' name='pid' value='$pid' />" );
							print( "<input type='hidden' name='section_id' value='$section_id' />" );
							print( "<input type='hidden' name='view' value='$view' />" );
							print( "</form>" );
							print( "<td width='20' valign='middle' align='center'>No.</td>" );
							print( "<td align='center'>Research Centers</td>" );
							echo 'i am here';exit();
							if( $is_admin )
							{
								print( "<td align='right'>" );
								print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"fac_researchcenter_add_req\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );						
								print( "&nbsp;&nbsp;<a href='#' style='text-decoration:none' onclick='return submit_box( \"fac_researchcenter_add_req\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );						
								print( "</td>" );
							}
						print( "</tr>" );
						while( $fac_researchcenter_add_req_rows = mysql_fetch_array( $fac_researchcenter_add_req_results ) )
						{
							$counter ++;
							$ctr_pid = $fac_researchcenter_add_req_rows["pid"];
							print( "<form id='fac_researchcenter_add_req_" . $counter . "_delete_form' method='post' action='sections/fac_researchcenter_delete_row_submit.php' >" );
							print( "<input type='hidden' name='pid' value='$pid' />" );
							print( "<input type='hidden' name='section_id' value='$section_id' />" );
							print( "<input type='hidden' name='view' value='$view' />" );
							print( "<input type='hidden' name='ctr_pid' value='$ctr_pid' />" );
							print( "</form>" );
							print( "<form id='fac_researchcenter_add_req_" . $counter . "_add_form' method='post' action='sections/fac_researchcenter_req_add_row_submit.php' >" );
							print( "<input type='hidden' name='pid' value='$pid' />" );
							print( "<input type='hidden' name='section_id' value='$section_id' />" );
							print( "<input type='hidden' name='view' value='$view' />" );
							print( "<input type='hidden' name='ctr_pid' value='$ctr_pid' />" );
							print( "</form>" );
		
							print( "<tr>" );
							print( "<td width='20' valign='middle' align='center'>$counter</td>" );
							print( "<td><a href='editprofile.php?pid=" . $ctr_pid . "' target='_blank'>" . htmlspecialchars($fac_researchcenter_add_req_rows["name"], ENT_QUOTES) . "</td>" );
							if( $is_admin )
							{
								print( "<td width='15%' align='right'>" );
								print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"fac_researchcenter_add_req\", \"$counter\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );						
								print( "&nbsp;&nbsp;<a href='#' style='text-decoration:none' onclick='return submit_row( \"fac_researchcenter_add_req\", \"$counter\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );						
								print( "</td>" );
							}
							print( "</tr>" );
						}
					print( "</table>" );				
					print( "</td>" );
				print( "</tr>" );
				print( "<tr><td colspan='2'><HR></td></tr>" );						
			}

			print( "</table>" );
			print( "</span>" );
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );
	}
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_researchcenter_view_box' class='visiblebox'>" );
		if( $fac_researchcenter_num_rows > 0 )
			mysql_data_seek( $fac_researchcenter_results, 0 );
		$fac_researchcenter_rows_itr = 0;
		while( $fac_researchcenter_rows = mysql_fetch_array( $fac_researchcenter_results ) )
		{
			
			$fac_researchcenter_rows_itr ++;
			$ctr_pid = $fac_researchcenter_rows["pid"];
			print( "<tr id='fac_researchcenter_" . $fac_researchcenter_rows_itr . "_view_row' class='visiblerow'>" );
				print( "<td width='5'></td>" );
				if( $editable == true )
				{
					print( "<form id='fac_researchcenter_" . $fac_researchcenter_rows_itr . "_delete_form' method='post' action='sections/fac_researchcenter_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='ctr_pid' value='$ctr_pid' />" );
					print( "</form>" );
				}
				print( "<td>" );
				print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
					print( "<tr>" );
						print( "<td>" );
						$span = "<span class='form_elements_section_subheader'>";
						print( "$span<a href='editprofile.php?pid=" . $ctr_pid ."' target='_blank'>". htmlspecialchars($fac_researchcenter_rows["name"], ENT_QUOTES). "</a></span>" );
						print( "</td>" );
						print( "<td width='20%' align='right'>" );
						if( $editable == true )
						{
							if( $fac_researchcenter_rows["del_req"] == 0 || $is_admin )
								print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"fac_researchcenter\", \"$fac_researchcenter_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
							else
								print( "<span class='form_elements_row_action'>Deletion Requested &nbsp;</span>" );
						}
						print( "</td>" );
					print( "</tr>" );
					print( "<tr><td colspan='2'>&nbsp;</td></tr>" );
					print( "<tr>" );
						print( "<td colspan='2'>" );
						print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
							print( "<tr>" );
								print( "<td >" );
								if( $fac_researchcenter_rows["image_id"] != 0 )
									print( "<a href='images/0/" . $fac_researchcenter_rows["pid"] . "_" . $section_id . "_" . $fac_researchcenter_rows["image_id"] . ".jpg' target='_blank'><image align='left' src='images/128/" . $pid . "_" . $section_id . "_" . $fac_researchcenter_rows["image_id"] . ".jpg' width='128' height='128' HSPACE='5', VSPACE='5' border='0'></a>" );
								$span = "<span class='form_elements_text'>";
								print( "$span". real_rte_specialchars($fac_researchcenter_rows["description"]) . "</span>" );
								print( "</td>" );
							print( "</tr>" );
						print( "</table>" );
					print( "</tr>" );

					print( "<tr><td colspan='3'><HR></td></tr>" );
				print( "</table>" );
				print( "</td>" );					

			print( "</tr>" );
		}
	print( "<tr><td height='10'></td></tr>" );
	print( "</table>" );
}

?>
