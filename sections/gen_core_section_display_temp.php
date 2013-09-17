<?php
$gen_core_sections_num_rows = mysql_num_rows( $gen_core_sections_results );

print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_core_section_view_box' class='visiblebox'>" );
	print( "<tr class='table_background'>" );
		print( "<td>" );		
		print("<table width='100%' border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td><span class='form_elements_section_header'>&nbsp;Core Sections</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
				print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"gen_core_section\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'><span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	print( "<tr>" );
		print( "<td>" );		
		print("<table width='100%'  border='1' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td width='50%'>" );
				print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
				for( $gen_core_sections_itr = 1; $gen_core_sections_itr <= ceil($gen_core_sections_num_rows/2); $gen_core_sections_itr++ )
				{
					$row = mysql_fetch_array( $gen_core_sections_results ); 
					print( "<tr>" );
						print( "<td ><span class='form_elements_section_subheader'>" . htmlspecialchars($row["name"], ENT_QUOTES) . "</span></td>"); 
						$status = $row["status"] == 0 ? "Show" : "Hide" ;
						$img = $row["status"] == 0 ? "<img alt='show' src='images/icons/show.gif'>" : "<img alt='hide' src='images/icons/hide.gif'>";
						print( "<td width='20%' >$img&nbsp;<span class='form_elements_text'>$status</span></td>" );
					print( "</tr>" );
				}
				print( "</table>" );
				print( "</td>" );
				
				print( "<td width='50%'>" );
				print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
				for( $gen_core_sections_itr = ceil($gen_core_sections_num_rows/2) + 1; $gen_core_sections_itr <= $gen_core_sections_num_rows; $gen_core_sections_itr++ )
				{
					$row = mysql_fetch_array( $gen_core_sections_results ); 
					print( "<tr>" );
						print( "<td><span class='form_elements_section_subheader'>" . htmlspecialchars( $row["name"], ENT_QUOTES ) . "</span></td>" );
						$status = $row["status"] == 0 ? "Show" : "Hide";
						$img = $row["status"] == 0 ? "<img alt='show' src='images/icons/show.gif'>" : "<img alt='hide' src='images/icons/hide.gif'>";
						print( "<td width='20%'>$img&nbsp;<span class='form_elements_text'>$status</span></td>" );
					print( "</tr>" );
				}
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );

		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
print( "</table>" );

//Edit Box for Core Section 
print("<table width='100%' border='0' cellspacing='0' cellpadding='0' id='gen_core_section_edit_box' class='hiddenbox'>" );
	print( "<form id='gen_core_section_edit_form' name='gen_core_section_edit_form' action='sections/gen_core_section_edit_box_submit.php' method='post'>" );
	print( "<input type='hidden' name='pid' value='$pid'  />" );
	print( "<input type='hidden' name='clicked' value='0' id='clicked' />" );
	print( "<tr class='table_background'>" );
		print( "<td>" );		
		print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td><span class='form_elements_section_header'>&nbsp;Core Sections</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"gen_core_section\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"gen_core_section\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	mysql_data_seek($gen_core_sections_results, 0 );
	print( "<tr>" );
		print( "<td>" );		
		print("<table width='100%'  border='1' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td width='50%'>" );
				print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
				for( $gen_core_sections_itr = 1; $gen_core_sections_itr <= ceil($gen_core_sections_num_rows/2); $gen_core_sections_itr++ )
				{
					$row = mysql_fetch_array( $gen_core_sections_results ); 
					print( "<tr>" );
						print( "<td><span class='form_elements_section_subheader'>" . htmlspecialchars($row["name"], ENT_QUOTES) . "</span></td>" );
						$checked = $row["status"] == 0 ? "" : "checked";
							print( "<td width='20%'><input type='checkbox' name='hide_" . $row["section_id"] . "' value='1' $checked ><span class='form_elements_text'>Hide</span></td>" );
					print( "</tr>" );
				}
				print( "</table>" );
				print( "</td>" );
				
				print( "<td width='50%'>" );
				print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
				for( $gen_core_sections_itr = ceil($gen_core_sections_num_rows/2) + 1; $gen_core_sections_itr <= $gen_core_sections_num_rows; $gen_core_sections_itr++ )
				{
					$row = mysql_fetch_array( $gen_core_sections_results ); 
					print( "<tr>" );
						print( "<td><span class='form_elements_section_subheader'>" . htmlspecialchars( $row["name"] , ENT_QUOTES ) . "</span></td>" );
						$checked = $row["status"] == 0 ? "" : "checked";
							print( "<td width='20%'><input type='checkbox' name='hide_" . $row["section_id"] . "' value='1' $checked ><span class='form_elements_text'>Hide</span></td>" );
					print( "</tr>" );
				}
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );

		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	print( "</form>" );	
print( "</table>" );


//Edit Box for Core Section 
print("<table width='100%' border='0' cellspacing='0' cellpadding='0' id='gen_core_section_edit_box' class='hiddenbox'>" );
	print( "<form id='gen_core_section_edit_form' name='gen_core_section_edit_form' action='sections/gen_core_section_edit_box_submit.php' method='post'>" );
	print( "<input type='hidden' name='pid' value='$pid'  />" );
	print( "<input type='hidden' name='clicked' value='0' id='clicked' />" );
	print( "<tr class='table_background'>" );
		print( "<td>" );		
		print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td><span class='form_elements_section_header'>&nbsp;Core Sections</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"gen_core_section\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"gen_core_section\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	mysql_data_seek($gen_core_sections_results, 0 );
	print( "<tr>" );
		print( "<td>" );		
		print("<table width='100%'  border='1' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td width='50%'>" );
				print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
				for( $gen_core_sections_itr = 1; $gen_core_sections_itr <= ceil($gen_core_sections_num_rows/2); $gen_core_sections_itr++ )
				{
					$row = mysql_fetch_array( $gen_core_sections_results ); 
					print( "<tr>" );
						print( "<td><span class='form_elements_section_subheader'>" . htmlspecialchars($row["name"], ENT_QUOTES) . "</span></td>" );
						$checked = $row["status"] == 0 ? "" : "checked";
							print( "<td width='20%'><input type='checkbox' name='hide_" . $row["section_id"] . "' value='1' $checked ><span class='form_elements_text'>Hide</span></td>" );
					print( "</tr>" );
				}
				print( "</table>" );
				print( "</td>" );
				
				print( "<td width='50%'>" );
				print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
				for( $gen_core_sections_itr = ceil($gen_core_sections_num_rows/2) + 1; $gen_core_sections_itr <= $gen_core_sections_num_rows; $gen_core_sections_itr++ )
				{
					$row = mysql_fetch_array( $gen_core_sections_results ); 
					print( "<tr>" );
						print( "<td><span class='form_elements_section_subheader'>" . htmlspecialchars( $row["name"] , ENT_QUOTES ) . "</span></td>" );
						$checked = $row["status"] == 0 ? "" : "checked";
							print( "<td width='20%'><input type='checkbox' name='hide_" . $row["section_id"] . "' value='1' $checked ><span class='form_elements_text'>Hide</span></td>" );
					print( "</tr>" );
				}
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );

		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	print( "</form>" );	
print( "</table>" );
?>