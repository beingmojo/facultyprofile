<?php
print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='tech_general_info_edit_box' class='hiddenbox'>" );
if( mysql_num_rows( $tech_general_info_results ) > 0 )
	mysql_data_seek( $tech_general_info_results, 0 );
$generalrows = mysql_fetch_array( $tech_general_info_results );
print( "<tr >" );
	print( "<td id='name' align='center' colspan='7'>".$generalrows[ "name" ]."</td>" );
print( "</tr>" );

print( "<form id='tech_general_info_edit_form' name='tech_general_info_edit_form'".
       " action='sections/tech_general_info_edit_box_submit.php' method='post' enctype='multipart/form-data'>" );
print( "<input type='hidden' name='clicked' value='0' />" );
print( "<input type='hidden' name='pid' value='$pid'  />" );
print( "<input type='hidden' name='view' value='$view' />" );	
print( "<input type='hidden' name='tech_general_info_image_id' value='". $generalrows["image_id"] . "'  />" );
print( "<tr class='table_background' height='20' >" );
	print( "<td colspan='3' ><span class='form_elements_section_header'>&nbsp;General Information</span></td>" );
	print( "<td align='right' colspan='4' >" );
		if( $editable == true )
		{
			print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"tech_general_info\", \"edit\" )'>".
			       "<img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>".
				   "Save &nbsp;</span></a>" );
			print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"tech_general_info\" )'>".
			       "<img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>".
				   "Cancel &nbsp;</span></a>" );
		}
		print( "</td>" );
	print( "</tr>" );

	print( "<tr>" );
		print( "<td width='1' class='table_background_other'></td>" );
		print( "<td colspan='3'>" );
			print( "&nbsp;<span class='form_elements_text'><B>Technology Title</B></span>" );
			print( "&nbsp;<input class='form_elements_edit' type='text' name='tech_general_info_name'".
			       " size='60' maxlength='255' 	value='". 
				   htmlspecialchars($generalrows[ "name" ], ENT_QUOTES) ."'> &nbsp;&nbsp;&nbsp; " );
		print( "</td>");
		print( "<td colspan='4'>" );
			print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
			print( "&nbsp;<span class='form_elements_text'><B>Image</B></span>" );
			print( "&nbsp;<input type='file' name='imagefile' size='10'  > " );
			print( "<input type='checkbox' name='tech_general_info_remove_image' > <span class='form_elements_edit'>".
			       " Remove </span>" );						
		print( "</td>" );
	print( "</tr>" );
	print( "<tr>" );
		print( "<td colspan='7' class='table_background_other' height='1'></td>" );
	print( "</tr>" );
	print( "<tr>" );
		print( "<td width='1' class='table_background_other'></td>" );	
		print( "<td colspan='3'>" );
			print( "&nbsp;<span class='form_elements_text'><B>Keywords </B></span>" );
			print( "&nbsp;<input class='form_elements_edit' type='text' name='tech_general_info_keywords'".
				   " size='60' maxlength='255' value='".
					htmlspecialchars($generalrows[ "keywords" ], ENT_QUOTES) ."'> &nbsp;&nbsp;&nbsp; " );				
		print( "</td>" );
		print( "<td colspan='4'>" );
			print( "&nbsp;<span class='form_elements_text'><B>Website</B></span>" );
			print( "&nbsp;<input class='form_elements_edit' type='text' name='tech_general_info_url_name'".
				   " size='20' maxlength='255' value='". htmlspecialchars($generalrows[ "url_name" ], ENT_QUOTES) ."'> " );
			print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_text'><B>URL</B></span>" );
			print( "&nbsp;<input class='form_elements_edit' type='text' name='tech_general_info_url'".
				   " size='25' maxlength='255' value='". htmlspecialchars($generalrows[ "url" ], ENT_QUOTES)  ."'> " );
		print( "</td>" );
	print( "</tr>" );
print( "</form>" );
print( "</table>" );
?>

