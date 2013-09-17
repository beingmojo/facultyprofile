<?php
if( mysql_num_rows( $ctr_about_results ) > 0 )
	mysql_data_seek( $ctr_about_results, 0 );
$generalrows = mysql_fetch_array( $ctr_about_results );
if( mysql_num_rows( $ctr_general_contact_info_results ) > 0 )
	mysql_data_seek( $ctr_general_contact_info_results, 0 );
$contactrows = mysql_fetch_array( $ctr_general_contact_info_results );

$section_id = $current_sections_row[0];
print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
	print( "<tr>" );
		print( "<td id='name' align='center' >" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
			$bannerheight = 128;
			if( $generalrows["hide_name"] == 0 )
			{
				$bannerheight = 60;
				print( "<tr>" );
					print( "<td id='name' align='center' >".htmlspecialchars($generalrows[ "name" ])."</td>" );
				print( "</tr>" );
			}
			if( $generalrows["banner_image_id"] != 0 )
			{				
				print( "<tr>" );			
					print( "<td id='banner' align='center' height='$bannerheight' >" );
					print( "<img src='images/0/". "$pid" . "_0_" . $generalrows["banner_image_id"] . ".jpg" . "' alt=" . htmlspecialchars($generalrows["name"]) . " >" );
					print( "</td>" );
				print( "</tr>" );
			}
		print( "</table>" );
		print( "</td>" );
		if( $generalrows["logo_image_id"] != 0 )
		{
			$rowspan = $generalrows["banner_image_id"] != 0 ? "2" : "1";
			print( "<td id='logo' valign='middle' align='center' height='128' width='128' rowspan='$rowspan'>" );
			print( "<img alt='image' src='images/128/". "$pid" . "_0_" . $generalrows["logo_image_id"] . ".jpg" . "' >" );
			print( "</td>" );
		}

	print( "</tr>" );
print( "</table>" );
print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_about_view_box' class='visiblebox'>" );
	print( "<tr class='table_background'>" );
		print( "<td id='name'><span class='form_elements_section_header'>&nbsp;About</span></td>" );
		print( "<td align='right' height='20' width='15%'>" );
		if( $editable == true )
		{
		
		print( "<a href='{$_home}/help/index.php#recen_about' target='_blank' style='text-decoration:none' ><img alt='Help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

			print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"ctr_about\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
		}
		print( "</td>" );
	print( "</tr>" );
	print( "<tr>" );
		print( "<td colspan='2'>" );
		print( "<table width='100%'>" );
				if( $generalrows["founded_year"] != "" )
				{
					print( "<tr><td align='right'><span class='form_elements_text'>Founded in " . $generalrows["founded_year"] . "</span></td></tr>" );
				}

			print( "<tr>" );
				print( "<td align='left'>" );
				if( $generalrows["ctr_image_id"] != 0 )
					print( "<a href='images/0/" . $pid . "_0_" . $generalrows["ctr_image_id"] . ".jpg' target='_blank'><img alt='image' align='left' src='images/128/". "$pid" . "_0_" . $generalrows["ctr_image_id"] . ".jpg" . "' HSPACE='5', VSPACE='5' border='0' alt='" . htmlspecialchars($generalrows["name"], ENT_QUOTES) . "' ></a>" );
				if( mysql_num_rows( $ctr_general_contact_info_results ) > 0 )
				{
					$contact_pid = $contactrows["pid"];
					$contact_name = $contactrows["title"] . 
									( $contactrows["l_name"] == "" ? "" : " " . $contactrows["l_name"] ) .
									( $contactrows["f_name"] == "" ? "" : ", " . $contactrows["f_name"] ) .
									( $contactrows["m_name"] == "" ? "" : " " . $contactrows["m_name"] );
									
					$contact_rank = $contactrows["pri_designation"] ;
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
					if( $contact_name != "" )
						$contact = "<b>" . $contact_name . "</b>";
				}
				$contact_name = htmlspecialchars($contact_name);
				$contact_rank = htmlspecialchars($contact_rank);
				$contact_email = htmlspecialchars($contact_email);
				$contact_phone = htmlspecialchars($contact_phone);
				if( $contact_rank != "" )
					$contact .= ", " . $contact_rank;
				if( $contact_phone != "" );
					$contact .= "&nbsp;&nbsp;<img alt='phone' src='images/icons/phone_office.gif' width='12' height='12' border='0' alt='Contact Number' />&nbsp;&nbsp;" . $contact_phone;
				if( $contact_email != "" );
					$contact .= "&nbsp;&nbsp;<img alt='email' src='images/icons/mail.png' width='12' height='12' border='0' alt='Email' />&nbsp;&nbsp;" . "<a href='mailto:" . $contact_email . "'>" . $contact_email . "</a>"; 
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
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_about_edit_box' class='hiddenbox'>" );
		print( "<tr class='table_background'>" );
			print( "<td id='name' align='left'><span class='form_elements_section_header'>&nbsp;About</span></td>" );
			print( "<td align='right' height='20' width='15%'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#recen_members' target='_blank' style='text-decoration:none' ><img alt='Help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ctr_about_description\" ); return submit_box( \"ctr_about\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"ctr_about\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );					
			}
			print( "</td>" );
		print( "</tr>" );
		print( "<tr>" );
			print( "<td colspan='2'>" );
			print( "<table width='100%' >" );
				print( "<form enctype='multipart/form-data' id='ctr_about_edit_form' method='post' action='sections/ctr_about_edit_box_submit.php' >" );
				print( "<input type='hidden' name='clicked' value='0' />" );						
				print( "<input type='hidden' name='pid' value='$pid' />" );
				print( "<input type='hidden' name='section_id' value='$section_id' />" );
				print( "<input type='hidden' name='view' value='$view' />" );
				print( "<input type='hidden' name='ctr_info_ctr_image_id' value='". $generalrows["ctr_image_id"] . "'  />" );
				print( "<input type='hidden' name='ctr_info_banner_image_id' value='". $generalrows["banner_image_id"] . "'  />" );
				print( "<input type='hidden' name='ctr_info_logo_image_id' value='". $generalrows["logo_image_id"] . "'  />" );
					
				print( "<input type='hidden' name='MAX_FILE_SIZE' value='3000000' />" );				
				print( "<tr>" );
					print( "<td>" );
					print( "<span class='form_elements_text'>Name</span>" );
					print( "</td>" );
					print( "<td class='form_elements_text' >" );
					print( "<input type='text' class='form_elements_edit' name='ctr_info_name' id='ctr_info_name' class='form_elements_text_edit' size='34' value= '" . htmlspecialchars( $generalrows[ "name" ], ENT_QUOTES ) . "'></td>" );
					$checked = $generalrows[ "hide_name" ] == 0 ? "" : "checked";
					print( "<td><input type='checkbox' value='1' name='ctr_info_hide_name' $checked>Hide</td>" );
					print( "<td width='20' rowspan='5'></td>" );
					print( "<td rowspan='5'class='form_elements_text' >" );
					print( "<span class='form_elements_text'>Description</span><BR>" );
					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
					print( "writeRichText('ctr_about_description', 'ctr_about_description', '" . real_rte_specialchars( $generalrows[ "description" ] ) . "', 600, 80, true, false, true);" );
					print( "</script>" );
//						print( "<textarea class='form_elements_text' name='ctr_about' cols='120' rows='10'>" . htmlspecialchars( $generalrows[ "description" ], ENT_QUOTES ) . "</textarea>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr>" );				
					print( "<td>" );
					print( "<span class='form_elements_text'>Banner</span>" );
					print( "</td>" );
					print( "<td class='form_elements_text' ><input class='form_elements_edit' name='bannerfile' type='file' /></td>" );
					print( "<td><input type='checkbox' value='1' name='ctr_remove_banner'>Remove" );
					print( "</td>" );
					
				print( "</tr>" );
				print( "<tr>" );									
					print( "<td>" );
					print( "<span class='form_elements_text'>Logo</span>" );
					print( "</td>" );
					print( "<td class='form_elements_text' ><input class='form_elements_edit' name='logofile' type='file' /></td>" );						
					print( "<td><input type='checkbox' value='1' name='ctr_remove_logo'>Remove</td>" );									
				print( "</tr>" );
				print( "<tr>" );									
					print( "<td>" );
					print( "<span class='form_elements_text'>Image</span>" );
					print( "</td>" );
					print( "<td class='form_elements_text' ><input class='form_elements_edit' name='imagefile' type='file' /></td>" );					
					print( "<td><input type='checkbox' value='1' name='ctr_remove_image'>Remove</td>" );					
				print( "</tr>" );
				print( "<tr>" );									
					print( "<td><span class='form_elements_text'>Keywords</span></td>" );
					print( "<td colspan='2' class='form_elements_text'><input class='form_elements_edit' name='ctr_info_keywords' type='text' size='24' maxlength='255' value = '" . htmlspecialchars( $generalrows[ "keywords" ], ENT_QUOTES ) . "' />" );
					print( "&nbsp;&nbsp;<span class='form_elements_text'>Founded in</span>" );
					print( "&nbsp;<select class='form_elements_edit' name='ctr_info_founded_year' />" );					
					$years_rows = mysql_fetch_array($ctr_years_results);
					print( "<option value=''></option>" );
					for( $cntr = $years_rows['start_year']; $cntr <= $years_rows['end_year']; $cntr++ )
					{
						$selected = $generalrows[ "founded_year" ] == $cntr ? "selected" : "";
						print( "<option value='$cntr' $selected>$cntr</option>" );
					}
										
					print( "</td>" );
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
							print( "createFindProfileRow('ctr_about_contact_find', 'ppla', 'ctr_about_change_contact' );" );
							print( "</script>" );
							
							print( "</td>" );

						
						print( "</tr>" );
						print( "<tr>" );
							print( "<td >" );
							print( "<span class='form_elements_text'>Name &nbsp;</span>" );
							print( "<input type='text' name='ctr_info_contact_name' id='ctr_info_contact_name' class='form_elements_edit' size='20' maxlength='255' value='" . $contact_name . "' readonly>" );
							print( "</td>" );

							print( "<td >" );
							print( "<span class='form_elements_text'>Rank &nbsp;</span>" );
							print( "<input type='text' name='ctr_info_contact_rank' id='ctr_info_contact_rank' class='form_elements_edit' size='20' maxlength='255' value='" . $contact_rank . "' readonly>" );
							print( "</td>" );							

							print( "<td >" );
							print( "<span class='form_elements_text'>Phone &nbsp;</span>" );
							print( "<input type='text' name='ctr_info_contact_phone' id='ctr_info_contact_phone' class='form_elements_edit' size='10' maxlength='32' value='". $contact_phone ."' readonly>" );
							print( "</td>" );

							print( "<td >" );
							print( "<span class='form_elements_text'>E-Mail &nbsp;</span>" );
							print( "<input type='text' name='ctr_info_contact_email' id='ctr_info_contact_email' class='form_elements_edit' size='25' maxlength='255' value='". $contact_email ."' readonly>" );
							print( "</td>" );
							
							print( "<input type='hidden' name='ctr_info_contact_login_id' id='ctr_info_contact_login_id' class='form_elements_edit' size='5' value='" . $contact_id . "'>" );

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
	print( "function ctr_about_change_contact( boxname, results )" );
	print( "{" );
		print( "if( results.length > 0 )" );
		print( "{" );
			print( "document.getElementById( 'ctr_info_contact_name' ).value = results[0][0];" );
			print( "document.getElementById( 'ctr_info_contact_rank' ).value = results[0][1];" );
			print( "document.getElementById( 'ctr_info_contact_phone' ).value = results[0][8];" );
			print( "document.getElementById( 'ctr_info_contact_email' ).value = results[0][9];" );
			print( "document.getElementById( 'ctr_info_contact_login_id' ).value = results[0][3];" );
		print( "}" );
		print( "cancelFindProfile( 'ctr_about_contact_find' );" );
	print( "}" );
	print( "</script>" );

}

?>