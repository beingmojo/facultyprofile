<?php
if( mysql_num_rows( $gen_activate_profile_results ) > 0 )
{
	$gen_activate_profile_rows = mysql_fetch_array( $gen_activate_profile_results );
	
	print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_activate_profile_view_box' class='visiblebox'>" );
		print( "<tr class='table_background'>" );
			print( "<td colspan='2'>" );		
			print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td><span class='form_elements_section_header'>&nbsp;Activate / Inactivate Profile</span></td>" );
					print( "<td align='right' height='20' width='15%'>" );
					print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"gen_activate_profile\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
			print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
		
		print( "<tr height='5'></tr>" );
		print( "<tr>" );
			print( "<td width='5'></td>" );
			print( "<td align='left'>" );
			if( $gen_activate_profile_rows["status"] == 1 )
				print( "<img alt='inactive' src='images/icons/inactive.gif' align='left'> &nbsp;&nbsp;&nbsp;<span class='form_elements_section_subheader'>This profile is currently inactive </span>" );
			else
				print( "<img alt='active' src='images/icons/active.gif' align='left'> &nbsp;&nbsp;&nbsp;<span class='form_elements_section_subheader'>This profile is currently active </span>" );
			print( "</td>" );
		print( "</tr>" );

		print( "<tr height='5'></tr>" );
	print( "</table>" );
	
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_activate_profile_edit_box' class='hiddenbox'>" );
		print( "<form id='gen_activate_profile_edit_form' name='gen_activate_profile_edit_form' action='sections/gen_activate_profile_edit_box_submit.php' method='post'>" );
		print( "<input type='hidden' name='pid' value='$pid'  />" );
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<tr class='table_background'>" );
			print( "<td colspan='2'>" );		
			print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td><span class='form_elements_section_header'>&nbsp;Activate / Inactivate Profile</span></td>" );
					print( "<td align='right' height='20' width='15%'>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"gen_activate_profile\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"gen_activate_profile\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
			print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
		print( "<tr height='5'></tr>" );		
		print( "<tr >" );
			print( "<td width='5'></td>" );
			print( "<td align='left'>" );
			if( $gen_activate_profile_rows["status"] == 1 )
				print( "<span class='form_elements_section_subheader'>Activate this profile </span> <input type='checkbox' name='gen_activate_profile_status' id='gen_activate_profile_status' value='0' >" );
			else
				print( "<span class='form_elements_section_subheader'>Inactivate this profile </span> <input type='checkbox' name='gen_activate_profile_status' id='gen_activate_profile_status' value='1'>" );
			print( "</td>" );
		print( "</tr>" );
		print( "<tr height='5'></tr>" );
		print( "</form>" );
	print( "</table>" );
}
?>