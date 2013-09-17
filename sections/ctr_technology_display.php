<?php
$ctr_technology_num_rows = mysql_num_rows( $ctr_technology_results );
if($ctr_technology_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_technology_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			//if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ctr_technology_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ctr_technology\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ctr_technology_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ctr_technology\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Technologies</span></td>" );
			print( "<form name='ctr_technology_delete_form' id='ctr_technology_delete_form' method='post' action='sections/ctr_technology_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{	
			
				print( "<a href='{$_home}/help/index.php#recen_members' target='_blank' style='text-decoration:none' ><img alt='Help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ctr_technology\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ctr_technology\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_technology_add_box' class='hiddenbox'>" );
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<td>" );
		print( "<span class='form_elements_text'>" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td> &nbsp; Find existing profiles to add them to the list of technologies</td>" );
				print( "<td width='20%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='fpUpdateRows( \"ctr_technology_add_form\", \"ctr_technology_find\" ); return submit_box( \"ctr_technology\", \"add\" )'><img alt='request' border='0' src='images/buttons/request.gif'  > <span class='form_elements_row_action'>Request &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ctr_technology\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr >" );
				print( "<form id='ctr_technology_add_form' method='post' action='sections/ctr_technology_add_box_submit.php' >" );
				print( "<input type='hidden' name='pid' value='$pid' />" );
				print( "<input type='hidden' name='section_id' value='$section_id' />" );
				print( "<input type='hidden' name='view' value='$view' />" );
				print( "<input type='hidden' name='clicked' value='0' />" );
				print( "<td colspan='2'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "createFindProfileTable('ctr_technology_find', 'tech', -1);" );
				print( "</script>" );
				print( "</td>" );
				print( "</form>" );
			print( "</tr>" );
			print( "<tr><td colspan='2'><HR></td></tr>" );
			if( mysql_num_rows( $ctr_technology_add_req_results ) > 0 )
			{
				print( "<tr><td colspan='2'>The following technology profiles are already requested to be added	</td></tr>" );			
				$counter = 0;
				print( "<tr>" );
					print( "<td colspan='2'>" );
					print( "<table width='100%' border='1' cellspacing='0'>" );
						print( "<tr class='table_background_other'>" );
							print( "<form id='ctr_technology_add_req_delete_form' method='post' action='sections/ctr_technology_req_delete_box_submit.php' >" );
							print( "<input type='hidden' name='pid' value='$pid' />" );
							print( "<input type='hidden' name='section_id' value='$section_id' />" );
							print( "<input type='hidden' name='view' value='$view' />" );
							print( "</form>" );
							print( "<form id='ctr_technology_add_req_add_form' method='post' action='sections/ctr_technology_req_add_box_submit.php' >" );
							print( "<input type='hidden' name='pid' value='$pid' />" );
							print( "<input type='hidden' name='section_id' value='$section_id' />" );
							print( "<input type='hidden' name='view' value='$view' />" );
							print( "</form>" );
							print( "<td width='20' valign='middle' align='center'>No.</td>" );
							print( "<td align='center'>Technology</td>" );
							if( $is_tech_admin || $is_admin )
							{
								print( "<td width='15%' align='right'>" );
								print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ctr_technology_add_req\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );																
								print( "&nbsp;&nbsp;<a href='#' style='text-decoration:none' onclick='return submit_box( \"ctr_technology_add_req\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );						
								print( "</td>" );
							}
						print( "</tr>" );
						while( $ctr_technology_add_req_rows = mysql_fetch_array( $ctr_technology_add_req_results ) )
						{
							$counter ++;
							$tech_pid = $ctr_technology_add_req_rows["pid"];
							print( "<form id='ctr_technology_add_req_" . $counter . "_delete_form' method='post' action='sections/ctr_technology_delete_row_submit.php' >" );
							print( "<input type='hidden' name='pid' value='$pid' />" );
							print( "<input type='hidden' name='section_id' value='$section_id' />" );
							print( "<input type='hidden' name='view' value='$view' />" );
							print( "<input type='hidden' name='tech_pid' value='$tech_pid' />" );
							print( "</form>" );
							print( "<form id='ctr_technology_add_req_" . $counter . "_add_form' method='post' action='sections/ctr_technology_req_add_row_submit.php' >" );
							print( "<input type='hidden' name='pid' value='$pid' />" );
							print( "<input type='hidden' name='section_id' value='$section_id' />" );
							print( "<input type='hidden' name='view' value='$view' />" );
							print( "<input type='hidden' name='tech_pid' value='$tech_pid' />" );
							print( "</form>" );
		
								print( "<tr>" );
								print( "<td width='20' valign='middle' align='center'>$counter</td>" );
								print( "<td><a href='editprofile.php?pid=" . $tech_pid . "'>" . htmlspecialchars($ctr_technology_add_req_rows["name"], ENT_QUOTES) . "</td>" );
								if( $is_tech_admin || $is_admin )
								{
									print( "<td width='15%' align='right'>" );
									print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ctr_technology_add_req\", \"$counter\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );																
									print( "&nbsp;&nbsp;<a href='#' style='text-decoration:none' onclick='return submit_row( \"ctr_technology_add_req\", \"$counter\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );						
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
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_technology_view_box' class='visiblebox'>" );
		if( $ctr_technology_num_rows > 0 )
			mysql_data_seek( $ctr_technology_results, 0 );
		$ctr_technology_rows_itr = 0;
		while( $ctr_technology_rows = mysql_fetch_array( $ctr_technology_results ) )
		{
			
			$ctr_technology_rows_itr ++;
			$tech_pid = $ctr_technology_rows["tech_pid"];
			print( "<tr id='ctr_technology_" . $ctr_technology_rows_itr . "_view_row' class='visiblerow'>" );
				print( "<td width='5'></td>" );
				if( $editable == true )
				{
					print( "<form id='ctr_technology_" . $ctr_technology_rows_itr . "_delete_form' method='post' action='sections/ctr_technology_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='tech_pid' value='$tech_pid' />" );
					print( "</form>" );
				}
				print( "<td>" );
				print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
					print( "<tr>" );
						print( "<td>" );
						$span = "<span class='form_elements_section_subheader'>";
						print( "$span<a href='editprofile.php?pid=" . $ctr_technology_rows["tech_pid"] ."'>". htmlspecialchars($ctr_technology_rows["name"], ENT_QUOTES). "</a></span>" );
						print( "</td>" );
						print( "<td width='20%' align='right'>" );
						if( $editable == true )
						{
							if( $ctr_technology_rows["del_req"] == 0 || $is_tech_admin || $is_admin )
								print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ctr_technology\", \"$ctr_technology_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
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
								if( $ctr_technology_rows["image_id"] != 0 )
									print( "<a href='images/0/" . $ctr_technology_rows["pid"] . "_" . $section_id . "_" . $ctr_technology_rows["image_id"] . ".jpg' target='_blank'><image align='left' src='images/128/" . $pid . "_" . $section_id . "_" . $ctr_technology_rows["image_id"] . ".jpg' width='128' height='128' HSPACE='5', VSPACE='5' border='0'></a>" );
								$span = "<span class='form_elements_text'>";
								print( "$span". real_rte_specialchars($ctr_technology_rows["description"]) . "</span>" );
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
