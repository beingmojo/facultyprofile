<?php
if( mysql_num_rows( $ctr_general_info_results ) > 0 )
	mysql_data_seek( $ctr_general_info_results, 0 );
$generalrows = mysql_fetch_array( $ctr_general_info_results );
print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_general_info_view_box' class='visiblebox'>" );
	print( "<tr >" );
		print( "<td id='name' align='center' colspan='3'>".$generalrows[ "name" ]."</td>" );
	print( "</tr>" );

	print( "<tr>" );
		if( $generalrows["image_id"] != 0 )
		{
			print( "<td align='center' valign='middle' width='128' style='border:1px solid black'>" );
			print( "<img src='images/128/". "$pid" . "_0_" . $generalrows["image_id"] . ".jpg" . "' alt='" . $generalrows["title"] ." ". $generalrows["f_name"] ." ". $generalrows["m_name"] ." ". $generalrows["l_name"] . "' >" );
			print( "</td>" );
			print( "<td width='5'></td>" );
		}
		print( "<td align='left' valign='top'>" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
			print( "<tr class='table_background'>" );
				print( "<td id='name'><span class='form_elements_section_header'>&nbsp;Contact Information</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
				if( $editable == true )
				{
					print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"ctr_general_info\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
				}
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='left' >" );
				if( $generalrows[ "contact_id" ]  == "" )
				{
					print( "<span class='form_elements_text'>" );
					if( $generalrows[ "contact_pid" ] != 0 && $generalrows[ "contact_pid" ] != "" )
						print( "<a href='editprofile.php?pid=".$generalrows[ "contact_pid" ] ."'>" );
					print htmlspecialchars($generalrows[ "contact_name" ]) . " ";				
					if( $generalrows[ "contact_pid" ] != 0 && $generalrows[ "contact_pid" ] != "" )
						print( "</a>" );
					print( "</span>" );
				}
				print( "</td>" );
				print( "<td align='right'>" );
					print( "<a href='#' style='text-decoration:none' onclick='show_popup( \"gen_association\",\"sections/gen_association_display.php?&pid=" . $pid . "\",400,635)'><img alt='view' border='0' src='images/buttons/view.png'  > <span class='form_elements_text'>Associated Profiles&nbsp;</span></a>" );					
				print( "</td" );
			print( "</tr>" );
			print( "<tr >" );
				print( "<td colspan='2'> &nbsp;" );
				print( "</td>" );
			print( "</tr>" );			
			print( "<tr >" );
				print( "<td colspan='2'>" );
				print( "<span class='form_elements_text'>" );
				if( $generalrows[ "address_1" ] != "" || $generalrows[ "address_2" ] != "" || $generalrows[ "city" ] != ""
					|| $generalrows[ "state" ] != "" || $generalrows[ " zipcode "] != "" || $generalrows[ "country" ] != "")
					echo "<img alt='address' src='images/icons/address.png' width='12' height='12' border='0' alt='Contact address' /> &nbsp;";
				if( $generalrows[ "address_1" ] != "")
				{
					echo htmlspecialchars($generalrows[ "address_1" ]);
					if( $generalrows[ "address_2" ] != "")
						echo ", ";
				}
				if( $generalrows[ "address_2" ] != "")
				{
					echo htmlspecialchars($generalrows[ "address_2"]);
					if( $generalrows[ "city" ] != "")
						echo ", ";
				}
				if( $generalrows[ "city" ] != "")
				{
					echo htmlspecialchars($generalrows[ "city" ]);
					if( $generalrows[ "state" ] != "")
						echo ", ";
				}
				if( $generalrows[ "state" ] != "")
					echo htmlspecialchars($generalrows[ "state"]);
				if( $generalrows[ "zipcode" ] != "")
					echo "&nbsp;" . htmlspecialchars($generalrows[ "zipcode" ]);
				if( $generalrows[ "mailbox" ] != "")
				{
					echo "&nbsp;&nbsp;Mail Box No: " . htmlspecialchars($generalrows[ "mailbox" ]) ;
				}

				print( "</span>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr >" );
				print( "<td colspan='2'>" );
				print( "<span class='form_elements_text'>" );
		
				if( $generalrows[ "location" ] != "" || $generalrows[ "room_no" ] != "")
					echo "<img alt='office' src='images/icons/office.png' width='12' height='12' border='0' alt='Office Location' />&nbsp;";
				if( $generalrows[ "location" ] != "")
				{
					echo htmlspecialchars($generalrows[ "location"]);
					if( $generalrows[ "room_no" ] != "")
						echo ", ";
				}
				if( $generalrows[ "room_no" ] != "")
				{
					echo "Room No: " . htmlspecialchars($generalrows[ "room_no" ]);
				}
				print( "</span>" );
				print( "</td>" );
			print( "</tr>" );
		
			print( "<tr >" );
				print( "<td colspan='2'>" );
				print( "<span class='form_elements_text'>" );
				if ( $generalrows[ "contact_email" ] != "" )
					echo "<img alt='mail' src='images/icons/mail.png' width='12' height='12' border='0' alt='Email' />" .
					 "&nbsp;&nbsp;<a href='mailto:". htmlspecialchars($generalrows[ "contact_email" ]) . "'>" . htmlspecialchars($generalrows[ "email_id" ]) . "</a> &nbsp;&nbsp; ";
		
				if( $generalrows[ "contact_phone" ] != "" )
					echo "<img alt='office phone' src='images/icons/phone_office.gif' width='12' height='12' border='0' alt='Contact Number' />" .
						"&nbsp;". htmlspecialchars($generalrows[ "contact_phone" ]) . " &nbsp;&nbsp; ";
					
				if ( $generalrows[ "contact_fax" ] != "" )
					echo "<img alt='fax' src='images/icons/fax.png' width='12' height='12' border='0' alt='Fax No:' />" .
						"&nbsp;". htmlspecialchars($generalrows[ "contact_fax" ]) . " &nbsp;&nbsp; ";


				if ( $generalrows[ "url" ] != "")
				{
					$urlname = $generalrows[ "url_name" ] == "" ? "Web Link" : $generalrows[ "url_name" ];
					echo "<img alt='web' src='images/icons/web.gif' width='12' height='12' border='0' alt='$urlname' /> ";
					echo "<span class='form_elements_text'><a href='" . htmlspecialchars($generalrows[ "url" ]) . "' target='_blank'>" . $urlname ."</a></span>" ;
					print( "&nbsp; &nbsp;" );
				}
				print( "</span>" );						
				print( "</td>" );
			print( "</tr>" );

			print( "<tr>" );
				print( "<td colspan='2'>" );
				if ( $generalrows[ "hours" ] != "")
				{
					echo "<img alt='timings' src='images/icons/hours.gif' width='12' height='12' border='0' alt='Keywords' /> ";
					echo "<span class='form_elements_text'>" . htmlspecialchars($generalrows[ "hours" ]) ."</span></a>" ;
					print( "&nbsp; &nbsp;" );
				}
				print( "</td>" );
			print( "</tr>" );

			print( "<tr>" );
				print( "<td colspan='2'>" );
				if ( $generalrows[ "cost" ] != "")
				{
					echo "<img alt='key' src='images/icons/key.gif' width='12' height='12' border='0' alt='Keywords' /> ";
					echo "<span class='form_elements_text'>" . htmlspecialchars($generalrows[ "cost" ]) ."</span></a>" ;
					print( "&nbsp; &nbsp;" );
				}
				print( "</td>" );
			print( "</tr>" );

		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
print( "<table>" );

print( "<script type='text/javascript'>" );
	print( "function ShowProfile( url )" );
	print( "{" );
		print( "hide_popup( \"gen_association\" );" );
		print( "location.href=url" );
	print( "}" );
print( "</script>" );



print( "<div id='gen_association_box' style='display:none;z-index:100' onSelectStart='return false'>" );
	print( "<div id='gen_association_header' >" );
		print( "<span id='gen_association_caption' >" );
			print( "Associated Profiles" );
		print( "</span>" );
		print( "<span id='gen_association_close' >" );
			print( "<img alt='close' src='images/buttons/close.gif' onClick='hide_popup(\"gen_association\")'>" );
		print( "</span>" );
	print( "</div>" );
	print( "<div id='gen_association_content' >" );
		print( "<iframe id='gen_association_frame'></iframe>" );
	print( "</div>" );
print( "</div>" );

?>
