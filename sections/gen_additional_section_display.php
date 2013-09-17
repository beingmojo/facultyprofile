
<?php
$gen_additional_sections_num_rows = mysql_num_rows( $gen_additional_sections_results );


print( "\r\n\r\n<script type=\"text/javascript\">" );
print( "function confirmRemove() " );
print( "{" );
	
	print( "var rmv = false; " );
	if( $gen_additional_sections_num_rows > 0 )
	{
		print( "if ( " );
		for( $gen_additional_sections_itr = 1; $gen_additional_sections_itr <= $gen_additional_sections_num_rows; $gen_additional_sections_itr++ )
		{
			$row = mysql_fetch_array( $gen_additional_sections_results ); 
			if( $gen_additional_sections_itr > 1 )
				print( " || " );
			print( "document.getElementById(\"gen_additional_section_edit_form\").remove_" . $row["section_id"] . ".checked == true" );
		}
		print( " ) " );
		print( "{" );
			print( "rmv = true; " );
		print( "}" );
	}
	print( "if( rmv == true )" );
	print( "{" );
		print( "ans = confirm( \"You have chosen to remove some additional sections. All data related to those sections will be deleted. Do you really want to continue?\\r\\n\\r\\nClick OK to continue or Cancel to abort this operation.\" );" );
		print( "if( ans == true )" );
			print( "return submit_box( \"gen_additional_section\", \"edit\" );" );
		print( "return false;" );
	print( "}" );
	print( "else" );
	print( "{" );
			print( "submit_box( \"gen_additional_section\", \"edit\" );" );
			print( "return false; " );
	print( "}" );	
print( "}" );
print( "</script>" );


if( $gen_additional_sections_num_rows  > 0 )
	mysql_data_seek( $gen_additional_sections_results, 0 );
print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_additional_section_view_box' class='visiblebox'>" );
	print( "<tr class='table_background'>" );
		print( "<td>" );		
		print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td><span class='form_elements_section_header'>&nbsp;Additional Sections</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
				if( $gen_additional_sections_num_rows  > 0 )
				{
					print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"gen_additional_section\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
				}
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	if( $gen_additional_sections_num_rows  > 0 )
	{
		print( "<tr>" );
			print( "<td>" );		
			print("<table width='100%'  border='1' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td width='50%'>" );
					print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
					for( $gen_additional_sections_itr = 1; $gen_additional_sections_itr <= ceil($gen_additional_sections_num_rows/2); $gen_additional_sections_itr++ )
					{
						$row = mysql_fetch_array( $gen_additional_sections_results ); 
						print( "<tr>" );
							print( "<td><span class='form_elements_section_subheader'>" . htmlspecialchars( $row["name"], ENT_QUOTES ). "</span></td>" );
							$status = $row["status"] == 0 ? "Show" : "Hide";
							$img = $row["status"] == 0 ? "<img alt='show' src='images/icons/show.gif'>" : "<img alt='hide' src='images/icons/hide.gif'>";							
							print( "<td width='20%'>$img&nbsp;<span class='form_elements_text'>$status</span></td>" );
						print( "</tr>" );
					}
					print( "</table>" );
					print( "</td>" );
					
					print( "<td width='50%'>" );
					print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
					for( $gen_additional_sections_itr = ceil($gen_additional_sections_num_rows/2) + 1; $gen_additional_sections_itr <= $gen_additional_sections_num_rows; $gen_additional_sections_itr++ )
					{
						$row = mysql_fetch_array( $gen_additional_sections_results ); 
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
	}
	else
	{
		print( "<tr><td>&nbsp;</td></tr>" );	
		print( "<tr>" );
			print( "<td>" );
			print( "<span class='form_elements_text'>&nbsp;&nbsp;There are no additional sections</span>" );
			print( "</td>" );
		print( "</tr>" );
		print( "<tr><td><HR></td></tr>" );
	}
print( "</table>" );
print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_additional_section_edit_box' class='hiddenbox'>" );
	print( "<form id='gen_additional_section_edit_form' name='gen_additional_section_edit_form' action='sections/gen_additional_section_edit_box_submit.php' method='post'>" );
	print( "<input type='hidden' name='pid' value='$pid'  />" );
	print( "<input type='hidden' name='clicked' value='0' />" );
	print( "<tr class='table_background'>" );
		print( "<td>" );		
		print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td><span class='form_elements_section_header'>&nbsp;Additional Sections</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
				if( $gen_additional_sections_num_rows  > 0 )
				{
					print( "<a href='#' style='text-decoration:none' onclick='return confirmRemove()'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"gen_additional_section\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );
				}
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	if( $gen_additional_sections_num_rows  > 0 )
	{
		mysql_data_seek( $gen_additional_sections_results, 0 );
		print( "<tr>" );
			print( "<td>" );		
			print("<table width='100%'  border='1' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td width='50%'>" );
					print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
					for( $gen_additional_sections_itr = 1; $gen_additional_sections_itr <= ceil($gen_additional_sections_num_rows/2); $gen_additional_sections_itr++ )
					{
						$row = mysql_fetch_array( $gen_additional_sections_results ); 
						print( "<tr>" );
							print( "<td class='form_elements_edit'><input type='text' name='rename_" . $row["section_id"] . "' value='" . htmlspecialchars($row["name"], ENT_QUOTES ) . "'></td>" );
							$checked = $row["status"] == 0 ? "" : "checked";
							print( "<td width='30%'>" );
							print( "<input type='checkbox' name='hide_" . $row["section_id"] . "' value='1' $checked ><span class='form_elements_text'>Hide</span>" );
							print( "&nbsp;<input type='checkbox' name='remove_" . $row["section_id"] . "' value='1' ><span class='form_elements_text'>Remove</span>" );
							print( "</td>" );
						print( "</tr>" );
					}
					print( "</table>" );
					print( "</td>" );
					
					print( "<td width='50%'>" );
					print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
					for( $gen_additional_sections_itr = ceil($gen_additional_sections_num_rows/2) + 1; $gen_additional_sections_itr <= $gen_additional_sections_num_rows; $gen_additional_sections_itr++ )
					{
						$row = mysql_fetch_array( $gen_additional_sections_results ); 
						print( "<tr>" );
							print( "<td class='form_elements_edit'><input type='text' name='rename_" . $row["section_id"] . "' value='" . htmlspecialchars($row["name"], ENT_QUOTES ) . "'></td>" );
							$checked = $row["status"] == 0 ? "" : "checked";
							print( "<td width='30%'>" );
							print( "<input type='checkbox' name='hide_" . $row["section_id"] . "' value='1' $checked ><span class='form_elements_text'>Hide</span>" );
							print( "&nbsp;<input type='checkbox' name='remove_" . $row["section_id"] . "' value='1' ><span class='form_elements_text'>Remove</span>" );
							print( "</td>" );
						print( "</tr>" );
					}
					print( "</table>" );
					print( "</td>" );
				print( "</tr>" );
	
			print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
	
	}
	print( "</form>" );	
print( "</table>" );
print( "<table width='100%' cellpadding='0' cellspacing='0'>" );
	print( "<tr><td>&nbsp;</td></tr>" );
	print( "<tr>" );
		print( "<td>" );
			print( "<form id='gen_additional_section_add_form' name='gen_additional_section_add_form' action='sections/gen_additional_section_add_box_submit.php' method='post' >" );
			print( "<input type='hidden' name='pid' value='$pid' >" );
			print( "<input type='hidden' name='gen_additional_section_maxid' value='" . $gen_additional_sections_maxid_rows[0] . "'>" );
			print( "<span class='form_elements_section_subheader'>&nbsp;Enter name for the new section</span>" );

			print( "&nbsp; &nbsp;<input type='text' name='new_section_name' value='' size='30' maxlength='255'>" );
			print( "&nbsp; &nbsp;<button type='submit' name='create_section' ><img alt='add' src='images/buttons/add.gif'>&nbsp;Create New Section</button>" );
			print("</form>" );
		print( "</td>" );
	print( "</tr>" );
	print( "<tr><td><HR></td></tr>" );
print( "</table>" );
?>