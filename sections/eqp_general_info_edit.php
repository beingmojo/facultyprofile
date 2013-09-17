<?php
print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='eqp_general_info_edit_box' class='hiddenbox'>" );

	if( mysql_num_rows( $eqp_general_info_results ) > 0 )
		mysql_data_seek( $eqp_general_info_results, 0 );
	$generalrows = mysql_fetch_array( $eqp_general_info_results );
	if( mysql_num_rows( $eqp_general_contact_info_results ) > 0 )
		mysql_data_seek( $eqp_general_contact_info_results, 0 );
	$contactrows = mysql_fetch_array( $eqp_general_contact_info_results );
	print( "<tr >" );
		print( "<td id='name' align='center' colspan='7'>".$generalrows[ "name" ]."</td>" );
	print( "</tr>" );

	print( "<form id='eqp_general_info_edit_form' name='eqp_general_info_edit_form' action='sections/eqp_general_info_edit_box_submit.php' method='post' enctype='multipart/form-data'>" );
	print( "<input type='hidden' name='clicked' value='0' />" );
	print( "<input type='hidden' name='pid' value='$pid'  />" );
	print( "<input type='hidden' name='view' value='$view' />" );	
	print( "<input type='hidden' name='eqp_general_info_image_id' value='". $generalrows["image_id"] . "'  />" );
	print( "<tr class='table_background' height='20' >" );
		print( "<td colspan='5' ><span class='form_elements_section_header'>&nbsp;Contact Information</span></td>" );
		print( "<td align='right' colspan='4' >" );
		if( $editable == true )
		{
			print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"eqp_general_info\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
			print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"eqp_general_info\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );
		}

		print( "</td>" );
	print( "</tr>" );

	print( "<tr>" );
		print( "<td colspan='9' class='table_background_other' height='1'></td> " );
	print( "</tr>" );
	
	print( "<tr>" );
		print( "<td class='table_background_other'>&nbsp;<span class='form_elements_text'><B>Name</B></span></td>" );
		print( "<td >&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_name' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "name" ], ENT_QUOTES) ."'> </td> " );
		print( "<td class='table_background_other'>&nbsp;<span class='form_elements_text'><B>Contact Name</B></span></td>" );
		print( "<td>" );
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_contact_name' id='eqp_general_info_contact_name' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "contact_name" ], ENT_QUOTES) ."' readonly>" );
		print( "<input class='form_elements_edit' type='hidden' name='eqp_general_info_contact_login_id' id='eqp_general_info_contact_login_id' maxlength='255' value='". htmlspecialchars($generalrows[ "contact_login_id" ], ENT_QUOTES) ."'> " );
		print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
		print( "createFindProfileRow('eqp_about_contact_find', 'ppla', 'eqp_about_change_contact' );" );
		print( "</script>" );
		print( "</td>" );
		print( "<td class='table_background_other'>&nbsp;<span class='form_elements_text'><B>Keywords</B></span></td>" );
		print( "<td >&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_keywords' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "keywords" ], ENT_QUOTES) ."'> </td> " );
		print( "<td class='table_background_other'>&nbsp;<span class='form_elements_text'><B>Image</B></span></td>" );
		print( "<td>" );
		print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
		print( "&nbsp;<input type='file' name='imagefile' size='10'  > " );
		print( "<input type='checkbox' name='eqp_general_info_remove_image' > <span class='form_elements_edit'> Remove </span>" );						
		print( "</td>" );
		print( "<td width='1' class='table_background_other'></td>" );
	print( "</tr>" );
	print( "<tr>" );
		print( "<td height='1'></td><td colspan='8' class='table_background_other' height='1'></td>" );
	print( "</tr>" );

	print( "<tr>" );
		
		print( "<td class='table_background_other'>&nbsp;<span class='form_elements_text'><B>Address</B></span></td>" );
		print( "<td colspan='7'>" );
		print( "&nbsp;<span class='form_elements_edit'><B>Mailbox</B></span>" );		
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_mailbox' size='3' maxlength='8' value='". htmlspecialchars($generalrows[ "mailbox" ], ENT_QUOTES)  ."'> &nbsp;&nbsp;" );

		print( "<span class='form_elements_edit'><B>Location </B></span>" );
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_location' size='20' maxlength='255' value='". htmlspecialchars($generalrows[ "location" ], ENT_QUOTES) ."'> &nbsp;&nbsp;" );				

		print( "<span class='form_elements_edit'><B>Room No.</B></span>" );
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_room_no' size='3' maxlength='16' value='". htmlspecialchars($generalrows[ "room_no" ], ENT_QUOTES) ."'> &nbsp;&nbsp;" );

		print( "<span class='form_elements_edit'><B>Street</B></span>" );
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_address_1' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "address_1" ], ENT_QUOTES) ."'> " );				
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_address_2' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "address_2" ], ENT_QUOTES)  ."'> &nbsp;&nbsp;" );


		print( "<span class='form_elements_edit'><B>City</B></span>" );
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_city' size='5' maxlength='32' value='".htmlspecialchars($generalrows[ "city" ], ENT_QUOTES)  ."'> &nbsp;&nbsp;" );

		print( "<span class='form_elements_edit'><B>State</B></span>" );
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_state' size='2' maxlength='32' value='". htmlspecialchars($generalrows[ "state" ], ENT_QUOTES)  ."'> &nbsp;&nbsp;" );

		print( "<span class='form_elements_edit'><B>Zip</B></span>" );
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_zipcode' size='3' maxlength='16' value='". htmlspecialchars($generalrows[ "zipcode" ], ENT_QUOTES)  ."'>" );

		print( "</td>" );
		print( "<td width='1' class='table_background_other'></td>" );
	print( "</tr>" );
			
		
	print( "<tr>" );
		print( "<td height='1'></td><td colspan='8' class='table_background_other' height='1'></td>" );
	print( "</tr>" );

	print( "<tr>" );

		print( "<td class='table_background_other'>&nbsp;<span class='form_elements_text'><B>Phone</B></span></td>" );
		print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_contact_phone' id='eqp_general_info_contact_phone' size='10' maxlength='32' value='". htmlspecialchars($generalrows[ "contact_phone" ], ENT_QUOTES)  ."'> </td> " );				
		print( "<td class='table_background_other'>&nbsp;<span class='form_elements_text'><B>Email</B></span></td>" );
		print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_contact_email' id='eqp_general_info_contact_email' size='20' maxlength='255' value='". htmlspecialchars($generalrows[ "contact_email" ], ENT_QUOTES)  ."'> </td>" );				
		print( "<td class='table_background_other'>&nbsp;<span class='form_elements_text'><B>Fax</B></span></td>" );
		print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_contact_fax' size='10' maxlength='32' value='". htmlspecialchars($generalrows[ "contact_fax" ], ENT_QUOTES) ."'> </td> " );				
		print( "<td class='table_background_other'>&nbsp;<span class='form_elements_text'><B>Website</B></span></td>" );
		print( "<td>" );
		print( "&nbsp;<span class='form_elements_text'><B>Name</B></span>" );
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_url_name' size='10' maxlength='255' value='". htmlspecialchars($generalrows[ "url_name" ], ENT_QUOTES) ."'> " );
		print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_text'><B>URL</B></span>" );
		print( "&nbsp;<input class='form_elements_edit' type='text' name='eqp_general_info_url' size='10' maxlength='255' value='". htmlspecialchars($generalrows[ "url" ], ENT_QUOTES)  ."'> " );
		print( "</td>" );
		print( "<td width='1' class='table_background_other'></td>" );
	print( "</tr>" );

	print( "<tr>" );
		print( "<td colspan='9' class='table_background_other' height='1'></td>" );
	print( "</tr>" );


print( "</form>" );
print( "</table>" );

print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
print( "function eqp_about_change_contact( boxname, results )" );
print( "{" );
	print( "if( results.length > 0 )" );
	print( "{" );
		print( "document.getElementById( 'eqp_general_info_contact_name' ).value = results[0][0];" );
		print( "document.getElementById( 'eqp_general_info_contact_phone' ).value = results[0][8];" );
		print( "document.getElementById( 'eqp_general_info_contact_email' ).value = results[0][9];" );
		print( "document.getElementById( 'eqp_general_info_contact_login_id' ).value = results[0][3];" );
	print( "}" );
	print( "cancelFindProfile( 'eqp_about_contact_find' );" );
print( "}" );
print( "</script>" );


?>