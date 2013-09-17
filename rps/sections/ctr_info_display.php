<?php
$ctr_info_num_rows = mysql_num_rows( $ctr_info_results );
if($ctr_info_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_info_view_box' class='visiblebox'>" );
			print( "<tr class='table_background'>" );
				print( "<td id='name'><span class='form_elements_section_header'>&nbsp;Contact Information</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
				if( $editable == true )
				{
					
					print( "<a href='{$_home}/help/index.php#recen_contactinfo' target='_blank' style='text-decoration:none' ><img alt='Help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

					print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"ctr_info\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
				}
				print( "</td>" );
			print( "</tr>" );
	
		if( $ctr_info_num_rows > 0 )
			mysql_data_seek( $ctr_info_results, 0 );
		while( $ctr_info_rows = mysql_fetch_array( $ctr_info_results ) )
		{
			print( "<tr>" );
				print( "<td colspan='2'>" );
				print( "<table width='100%'  border='0' cellspacing='0' >" );
					print( "<tr>" );
						print( "<td width='5' rowspan='4'></td>" );
						print( "<td >" );
						print( "<span class='form_elements_text'>" );
						if( $ctr_info_rows[ "address_1" ] != "" || $ctr_info_rows[ "address_2" ] != "" || $ctr_info_rows[ "city" ] != ""
							|| $ctr_info_rows[ "state" ] != "" || $ctr_info_rows[ " zipcode "] != "" || $ctr_info_rows[ "country" ] != "")
							echo "<img alt='address' src='images/icons/address.png' width='12' height='12' border='0' alt='Contact address' /> &nbsp;";
						if( $ctr_info_rows[ "address_1" ] != "")
						{
							echo htmlspecialchars($ctr_info_rows[ "address_1" ]);
							if( $ctr_info_rows[ "address_2" ] != "")
								echo ", ";
						}
						if( $ctr_info_rows[ "address_2" ] != "")
						{
							echo htmlspecialchars($ctr_info_rows[ "address_2"]);
							if( $ctr_info_rows[ "city" ] != "")
								echo ", ";
						}
						if( $ctr_info_rows[ "city" ] != "")
						{
							echo htmlspecialchars($ctr_info_rows[ "city" ]);
							if( $ctr_info_rows[ "state" ] != "")
								echo ", ";
						}
						if( $ctr_info_rows[ "state" ] != "")
							echo htmlspecialchars($ctr_info_rows[ "state"]);
						if( $ctr_info_rows[ "zipcode" ] != "")
							echo "&nbsp;" . htmlspecialchars($ctr_info_rows[ "zipcode" ]);
						if( $ctr_info_rows[ "mailbox" ] != "")
						{
							echo "&nbsp;&nbsp;Mail Box No: " . htmlspecialchars($ctr_info_rows[ "mailbox" ]) ;
						}
		
						print( "</span>" );
						print( "</td>" );
					print( "</tr>" );
					print( "<tr >" );
						print( "<td >" );
						print( "<span class='form_elements_text'>" );
				
						if( $ctr_info_rows[ "location" ] != "" || $ctr_info_rows[ "room_no" ] != "")
							echo "<img alt='office' src='images/icons/office.png' width='12' height='12' border='0' alt='Office Location' />&nbsp;";
						if( $ctr_info_rows[ "office_location" ] != "")
						{
							echo htmlspecialchars($ctr_info_rows[ "office_location"]);
							if( $ctr_info_rows[ "room_no" ] != "")
								echo ", ";
						}
						if( $ctr_info_rows[ "room_no" ] != "")
						{
							echo "Room No: " . htmlspecialchars($ctr_info_rows[ "room_no" ]);
						}
						print( "</span>" );
						print( "</td>" );
					print( "</tr>" );
			
					print( "<tr >" );
						print( "<td >" );
						print( "<span class='form_elements_text'>" );
				
						if( $ctr_info_rows[ "phone_no_1" ] != "" )
							echo "<img alt='phone' src='images/icons/phone_office.gif' width='12' height='12' border='0' alt='Contact Number' />" .
								"&nbsp;". htmlspecialchars($ctr_info_rows[ "phone_no_1" ]) . " &nbsp;&nbsp; ";
		
						if( $ctr_info_rows[ "phone_no_2" ] != "" )
							echo "<img alt='phone' src='images/icons/phone_office.gif' width='12' height='12' border='0' alt='Contact Number' />" .
								"&nbsp;". htmlspecialchars($ctr_info_rows[ "phone_no_2" ]) . " &nbsp;&nbsp; ";
		
							
						if ( $ctr_info_rows[ "fax_no" ] != "" )
							echo "<img alt='fax' src='images/icons/fax.png' width='12' height='12' border='0' alt='Fax Number' />" .
								"&nbsp;". htmlspecialchars($ctr_info_rows[ "fax_no" ]) . " &nbsp;&nbsp; ";
						print( "</span>" );						
						print( "</td>" );
					print( "</tr>" );
					print( "<tr >" );
						print( "<td >" );
						print( "<span class='form_elements_text'>" );
		
						if ( $ctr_info_rows[ "email_id" ] != "" )
							echo "<img alt='mail' src='images/icons/mail.png' width='12' height='12' border='0' alt='Email' />" .
							 "&nbsp;&nbsp;<a href='mailto:". htmlspecialchars($ctr_info_rows[ "email_id" ]) . "'>" . htmlspecialchars($ctr_info_rows[ "email_id" ]) . "</a> &nbsp;&nbsp; ";
		
						if ( $ctr_info_rows[ "url" ] != "" )
						{
							$weblink = $ctr_info_rows[ "url_name" ] == "" ? "Web Link" : $ctr_info_rows[ "url_name" ];
							echo "<img alt='web' src='images/icons/web.gif' width='12' height='12' border='0' alt='Email' />" .
							 "&nbsp;&nbsp;<a href='". htmlspecialchars($ctr_info_rows[ "url" ]) . "'>" . htmlspecialchars($weblink) . "</a> &nbsp;&nbsp; ";
						}
						print( "</span>" );						
						print( "</td>" );
					print( "</tr>" );
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );
		}
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_info_edit_box' class='hiddenbox'>" );
		
			if( mysql_num_rows( $ctr_info_results ) > 0 )
				mysql_data_seek( $ctr_info_results, 0 );
			$generalrows = mysql_fetch_array( $ctr_info_results );
			print( "<tr >" );
				print( "<td id='name' align='center' colspan='7'>".$generalrows[ "name" ]."</td>" );
			print( "</tr>" );
		
			print( "<form id='ctr_info_edit_form' name='ctr_info_edit_form' action='sections/ctr_info_edit_box_submit.php' method='post' enctype='multipart/form-data'>" );
			print( "<input type='hidden' name='clicked' value='0' />" );
			print( "<input type='hidden' name='pid' value='$pid'  />" );
			print( "<input type='hidden' name='view' value='$view' />" );	
			print( "<input type='hidden' name='section_id' value='$section_id' />" );			
			print( "<input type='hidden' name='ctr_info_image_id' value='". $generalrows["image_id"] . "'  />" );
			print( "<tr class='table_background' height='20' >" );
				print( "<td colspan='3' ><span class='form_elements_section_header'>&nbsp;Contact Information</span></td>" );
				print( "<td align='right' colspan='7' >" );
				if( $editable == true )
				{
					print( "<a href='{$_home}/help/index.php#recen_about' target='_blank' style='text-decoration:none' ><img alt='Help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				
				

					print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ctr_info\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"ctr_info\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );
				}
		
				print( "</td>" );
			print( "</tr>" );
		
			print( "<tr>" );
				print( "<td colspan='10' class='table_background_other' height='1'></td> " );
			print( "</tr>" );
			
		
			print( "<tr>" );
				
				print( "<td width='1' class='table_background_other'></td>" );
				print( "<td>" );
				print( "&nbsp;<span class='form_elements_text'><B>Street</B></span>" );
				print( "</td>" );
				print( "<td>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_address_1' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "address_1" ], ENT_QUOTES) ."'> " );				
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_address_2' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "address_2" ], ENT_QUOTES)  ."'> &nbsp;&nbsp;&nbsp; " );
				print( "</td>" );
				print( "<td colspan='6'>" );
				print( "<span class='form_elements_text'><B>Mailbox</B></span>" );		
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_mailbox' size='3' maxlength='8' value='". htmlspecialchars($generalrows[ "mailbox" ], ENT_QUOTES)  ."'> &nbsp;&nbsp;&nbsp; " );
		
				print( "<span class='form_elements_text'><B>City</B></span>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_city' size='5' maxlength='32' value='".htmlspecialchars($generalrows[ "city" ], ENT_QUOTES)  ."'> &nbsp;&nbsp;&nbsp; " );
		
				print( "<span class='form_elements_text'><B>State</B></span>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_state' size='2' maxlength='32' value='". htmlspecialchars($generalrows[ "state" ], ENT_QUOTES)  ."'> &nbsp;&nbsp;&nbsp;  " );
		
				print( "<span class='form_elements_text'><B>Zip</B></span>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_zipcode' size='3' maxlength='16' value='". htmlspecialchars($generalrows[ "zipcode" ], ENT_QUOTES)  ."'> &nbsp;&nbsp;&nbsp;  " );
		
				print( "</td>" );
				print( "<td width='1' class='table_background_other'></td>" );
			print( "</tr>" );
			
		
			print( "<tr>" );
				print( "<td colspan='10' class='table_background_other' height='1'></td>" );
			print( "</tr>" );
		
			print( "<tr>" );
		
				print( "<td width='1' class='table_background_other'></td>" );
				print( "<td>" );
				print( "&nbsp;<span class='form_elements_text'><B>Location </B></span>" );
				print( "</td>" );
				print( "<td>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_office_location' size='37' maxlength='255' value='". htmlspecialchars($generalrows[ "office_location" ], ENT_QUOTES) ."'> &nbsp;&nbsp;&nbsp; " );				
				print( "</td>" );		
				print( "<td colspan='2'>" );
				print( "<span class='form_elements_text'><B>Room No.</B></span>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_room_no' size='3' maxlength='16' value='". htmlspecialchars($generalrows[ "room_no" ], ENT_QUOTES) ."'> &nbsp;&nbsp;&nbsp; " );
				print( "</td>" );
		
				print( "<td width='1' class='table_background_other'></td>" );		
		
				print( "<td colspan='3'>" );
				print( "&nbsp;<span class='form_elements_text'><B>Website</B></span>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_url_name' size='10' maxlength='255' value='". htmlspecialchars($generalrows[ "url_name" ], ENT_QUOTES) ."'> " );
				print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_text'><B>URL</B></span>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_url' size='10' maxlength='255' value='". htmlspecialchars($generalrows[ "url" ], ENT_QUOTES)  ."'> " );
				print( "</td>" );
				
				print( "<td width='1' class='table_background_other'></td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='10' class='table_background_other' height='1'></td>" );
			print( "</tr>" );			
			print( "<tr>" );
				print( "<td width='1' class='table_background_other'></td>" );

				print( "<td>" );
				print( "&nbsp;<span class='form_elements_text'><B>Email</B></span>" );
				print( "</td>" );
				print( "<td>" );								
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_email_id' size='37' maxlength='255' value='". htmlspecialchars($generalrows[ "email_id" ], ENT_QUOTES)  ."'> &nbsp;" );				
				print( "</td>" );
				
				print( "<td width='1' class='table_background_other'></td>" );
				
				print( "<td>" );
				print( "&nbsp;<span class='form_elements_text'><B>Phone</B></span>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_phone_no_1' size='10' maxlength='32' value='". htmlspecialchars($generalrows[ "phone_no_1" ], ENT_QUOTES)  ."'> &nbsp; " );				
				print( "</td>" );
				print( "<td width='1' class='table_background_other'></td>" );				
				print( "<td>" );
				print( "&nbsp;<span class='form_elements_text'><B>Alt. Phone</B></span>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_phone_no_2' size='10' maxlength='32' value='". htmlspecialchars($generalrows[ "phone_no_2" ], ENT_QUOTES)  ."'> &nbsp; " );				
				print( "</td>" );
				print( "<td width='1' class='table_background_other'></td>" );				
				print( "<td>" );								
				print( "&nbsp;<span class='form_elements_text'><B>Fax</B></span>" );
				print( "&nbsp;<input class='form_elements_edit' type='text' name='ctr_info_fax_no' size='10' maxlength='32' value='". htmlspecialchars($generalrows[ "fax_no" ], ENT_QUOTES) ."'> &nbsp; " );				
				print( "</td>" );
				
				print( "<td width='1' class='table_background_other'></td>" );
		
			print( "</tr>" );
		
			print( "<tr>" );
				print( "<td colspan='10' class='table_background_other' height='1'></td>" );
			print( "</tr>" );
		
	
		
		print( "</form>" );
		print( "</table>" );
		
	
	}
}
?>