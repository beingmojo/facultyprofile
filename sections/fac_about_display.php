<?php

if( mysql_num_rows( $fac_about_results ) > 0 )
	mysql_data_seek( $fac_about_results, 0 );
$generalrows = mysql_fetch_array( $fac_about_results );
if( mysql_num_rows( $fac_general_contact_info_results ) > 0 )
	mysql_data_seek( $fac_general_contact_info_results, 0 );
$contactrows = mysql_fetch_array( $fac_general_contact_info_results );

$section_id = $current_sections_row[0];
print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
	print( "<tr>" );
			if( $generalrows["hide_name"] == 0 )
			{
					print( "<td id='name' align='center' ><p><br>".htmlspecialchars($generalrows[ "name" ])."<br></p></td>" );
			}
	print( "</tr>" );
print( "</table>" );

print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_about_view_box' class='visiblebox'>" );
	print( "<tr class='table_background'>" );
		print( "<td id='name'><span class='form_elements_section_header'>&nbsp;About</span></td>" );
		print( "<td align='right' height='20' width='15%'>" );
		if( $editable == true )
		{	
		
			print( "<a href='{$_home}/help/index.php#facul_contactinfo' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

			print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"fac_about\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
		}
		print( "</td>" );
	print( "</tr>" );
	print( "<tr>" );
		print( "<td colspan='2'>" );
		print( "<table>" );
			print( "<tr>" );
				print( "<td align='left'>" );
				if( $generalrows["fac_image_id"] != 0 )
					print( "<a href='images/0/" . $pid . "_0_" . $generalrows["fac_image_id"] . ".jpg' target='_blank'><img align='left' src='images/128/". "$pid" . "_0_" . $generalrows["fac_image_id"] . ".jpg" . "' HSPACE='5', VSPACE='5' border='0' alt='" . htmlspecialchars($generalrows["name"], ENT_QUOTES) . "' ></a>" );
				if( mysql_num_rows( $fac_general_contact_info_results ) > 0 )
				{
					$contact_pid = $contactrows["pid"];
					$contact_name = $contactrows["title"] . 
									( $contactrows["l_name"] == "" ? "" : " " . $contactrows["l_name"] ) .
									( $contactrows["f_name"] == "" ? "" : ", " . $contactrows["f_name"] ) .
									( $contactrows["m_name"] == "" ? "" : " " . $contactrows["m_name"] );
					$contact_rank = $contactrows["designation"] ;
					$contact_email =  $contactrows["status_email_id"] == 1 ? "" : $contactrows["email_id"];
					$contact_phone =  $contactrows["status_phone_no_1"] == 1 ? "" : $contactrows["phone_no_1"];
					if( $contact_phone == "" )
						$contact_phone =  $contactrows["status_phone_no_2"] == 1 ? "" : $contactrows["phone_no_2"];
					$contact_id = $contactrows["login_id"];
					$contact = "<b><a href='editprofile.php?pid=" . $contact_pid . "'>" . htmlspecialchars($contact_name) . "</a></b>";
				}
				else
				{
					$contact_name = $generalrows["contact_name"];
					$contact_rank = $generalrows["contact_rank"] ;
					$contact_email = $generalrows["contact_email"];
					$contact_phone = $generalrows["contact_phone"] ;
					$contact_id = $generalrows["contact_login_id"] ;
					$contact = "<b>" . htmlspecialchars($contact_name) . "</b>";
				}
				$contact_name = htmlspecialchars($contact_name);
				$contact_rank = htmlspecialchars($contact_rank);
				$contact_email = htmlspecialchars($contact_email);
				$contact_phone = htmlspecialchars($contact_phone);
				$contact_id = htmlspecialchars($contact_id);
				
				if( $contact_rank != "" )
					$contact .= ", " . $contact_rank;
				if( $contact_phone != "" );
					$contact .= "&nbsp;&nbsp;<img src='images/icons/phone_office.gif' width='12' height='12' border='0' alt='Contact Number' />&nbsp;&nbsp;" . $contact_phone;
				if( $contact_email != "" );
					$contact .= "&nbsp;&nbsp;<img src='images/icons/mail.png' width='12' height='12' border='0' alt='Email' />&nbsp;&nbsp;" . "<a href='mailto:" . $contact_email . "'>" . $contact_email . "</a>"; 
				if( $generalrows[ "description" ] != "" )
				{
					print( "<span class='form_elements_text' >" );
					echo real_rte_specialchars($generalrows["description"]);				
					print( "</span>" );
				}
				if( $contact != "" )
				{
					print( "<BR><BR><span class='form_elements_text'>Director / Primary Contact : " . $contact . "</span>" );
				}
				
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	print( "<tr><td height='10'></td></tr>" );		
print( "</table>" );

if( $editable == true )
{
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='fac_about_edit_box' class='hiddenbox'>" );
		print( "<tr class='table_background'>" );
			print( "<td id='name' align='left'><span class='form_elements_section_header'>&nbsp;About</span></td>" );
			print( "<td align='right' height='20' width='15%'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#recen_members' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"fac_about_description\" ); return submit_box( \"fac_about\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"fac_about\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );					
			}
			print( "</td>" );
		print( "</tr>" );
		print( "<tr>" );
			print( "<td colspan='2'>" );
			print( "<table width='100%'>" );
				print( "<form enctype='multipart/form-data' id='fac_about_edit_form' method='post' action='sections/fac_about_edit_box_submit.php' >" );
				print( "<input type='hidden' name='clicked' value='0' />" );						
				print( "<input type='hidden' name='pid' value='$pid' />" );
				print( "<input type='hidden' name='section_id' value='$section_id' />" );
				print( "<input type='hidden' name='view' value='$view' />" );
				print( "<input type='hidden' name='fac_info_fac_image_id' value='". $generalrows["fac_image_id"] . "'  />" );
					
				print( "<input type='hidden' name='MAX_FILE_SIZE' value='3000000' />" );				
				print( "<tr>" );
					print( "<td>" );
					print( "<span class='form_elements_text'>Name</span>" );
					print( "</td>" );
					print( "<td class='form_elements_text'>" );
					print( "<input type='text' class='form_elements_edit' name='fac_info_name' id='fac_info_name' class='form_elements_text_edit' size='34' value= '" . htmlspecialchars( $generalrows[ "name" ], ENT_QUOTES ) . "'>" );
					$checked = $generalrows[ "hide_name" ] == 0 ? "" : "checked";
					print( "<input type='checkbox' value='1' name='fac_info_hide_name' $checked>Hide" );
					print( "</td>" );
					print( "<td width='20' rowspan='3'></td>" );
					print( "<td rowspan='3'class='form_elements_text' >" );
					print( "<span class='form_elements_text'>Description</span><BR>" );
					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
					print( "writeRichText('fac_about_description', 'fac_about_description', '" . real_rte_specialchars( $generalrows[ "description" ] ) . "', 600, 80, true, false, true);" );
					print( "</script>" );
//						print( "<textarea class='form_elements_text' name='fac_about' cols='120' rows='10'>" . htmlspecialchars( $generalrows[ "description" ], ENT_QUOTES ) . "</textarea>" );
					print( "</td>" );
				print( "</tr>" );

				print( "<tr>" );									
					print( "<td>" );
					print( "<span class='form_elements_text'>Image</span>" );
					print( "</td>" );
					print( "<td class='form_elements_text'><input class='form_elements_edit' name='imagefile' type='file' />" );					
					print( "<input type='checkbox' value='1' name='fac_remove_image'>Remove</td>" );					


				print( "</tr>" );
				print( "<tr>" );									
					print( "<td>" );
					print( "<span class='form_elements_text'>Keywords</span>" );
					print( "</td>" );
					print( "<td class='form_elements_text'><input class='form_elements_edit' name='fac_info_keywords' type='text' size='34' maxlength='255' value = '" . htmlspecialchars( $generalrows[ "keywords" ], ENT_QUOTES ) . "' /></td>" );					

				print( "</tr>" );
				print( "<tr>" );									
					print( "<td>" );
					print( "</td>" );
				print( "</tr>" );					
				print( "<tr>" );									
					print( "<td colspan='5'>" );
					print( "<table border='0' width='100%' cellspacing='0'>" );
						print( "<tr class='table_background_other'>" );
							
							print( "<td colspan='1'>" );
							print( "<span class='form_elements_text'>Director / Primary Contact </span>" );
							print( "</td>" );
							print( "<td colspan='4' align='right'>" );
							print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
							print( "createFindProfileRow('fac_about_contact_find', 'ppla', 'fac_about_change_contact' );" );
							print( "</script>" );
							print( "</td>" );	
						print( "</tr>" );
						print( "<tr>" );
							print( "<td >" );
							print( "<span class='form_elements_text'>Name &nbsp;</span>" );
							print( "<input type='text' name='fac_info_contact_name' id='fac_info_contact_name' class='form_elements_edit' size='20' maxlength='255' readonly value='" . $contact_name . "'>" );
							print( "</td>" );

							print( "<td >" );
							print( "<span class='form_elements_text'>Rank &nbsp;</span>" );
							print( "<input type='text' name='fac_info_contact_rank' id='fac_info_contact_rank' class='form_elements_edit' size='20' maxlength='255' readonly value='" . $contact_rank . "'>" );
							print( "</td>" );							

							print( "<td >" );
							print( "<span class='form_elements_text'>Phone &nbsp;</span>" );
							print( "<input type='text' name='fac_info_contact_phone' id='fac_info_contact_phone' class='form_elements_edit' size='10' maxlength='32' readonly value='". $contact_phone ."'>" );
							print( "</td>" );

							print( "<td >" );
							print( "<span class='form_elements_text'>E-Mail &nbsp;</span>" );
							print( "<input type='text' name='fac_info_contact_email' id='fac_info_contact_email' class='form_elements_edit' size='25' maxlength='255' readonly value='". $contact_email ."'>" );
							print( "<input type='hidden' name='fac_info_contact_login_id' id='fac_info_contact_login_id' value='" . $contact_id . "' >" );
							print( "</td>" );
							
						print( "</tr>" );
					print( "</table>" );
					print( "</td>" );
				print( "</tr>" );
				
				print( "</form>" );
			print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
		print( "<tr><td height='10'></td></tr>" );		
	print( "</table>" );
	
	print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
	print( "function fac_about_change_contact( boxname, results )" );
	print( "{" );
		print( "if( results.length > 0 )" );
		print( "{" );
			print( "document.getElementById( 'fac_info_contact_name' ).value = results[0][0];" );
			print( "document.getElementById( 'fac_info_contact_rank' ).value = results[0][1];" );
			print( "document.getElementById( 'fac_info_contact_phone' ).value = results[0][8];" );
			print( "document.getElementById( 'fac_info_contact_email' ).value = results[0][9];" );
			print( "document.getElementById( 'fac_info_contact_login_id' ).value = results[0][3];" );
		print( "}" );
		print( "cancelFindProfile( 'fac_about_contact_find' );" );
	print( "}" );
	print( "</script>" );

}

?>
