<?php
if( mysql_num_rows( $ctr_general_info_results ) > 0 )
	mysql_data_seek( $ctr_general_info_results, 0 );
$generalrows = mysql_fetch_array( $ctr_general_info_results );
print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
	print( "<tr>" );
		print( "<td id='name' align='center' >" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
			$bannerheight = 128;
			if( $generalrows["hide_name"] == 0 )
			{
				$bannerheight = 60;
				print( "<tr>" );
					print( "<td id='name' align='center' >".$generalrows[ "name" ]."</td>" );
				print( "</tr>" );
			}
			if( $generalrows["banner_image_id"] != 0 )
			{				
				print( "<tr>" );			
					print( "<td id='banner' align='center' height='$bannerheight' >" );
					print( "<img src='images/0/". "$pid" . "_0_" . $generalrows["banner_image_id"] . ".jpg" . "' alt='" . $generalrows["name"] . "' >" );
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
	print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_general_info_view_box' class='visiblebox'>" );
		if( $generalrows["ctr_image_id"] != 0 )
		{
			print( "<td align='center' valign='middle' width='128' style='border:1px solid black'>" );
			print( "<a href='images/0/" . $pid . "_0_" . $generalrows["ctr_image_id"] . ".jpg' target='_blank'><img src='images/128/". "$pid" . "_0_" . $generalrows["ctr_image_id"] . ".jpg" . "' border='0' alt='" . $generalrows["name"] . "' ></a>" );
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
			print( "<tr >" );
			print( "<tr >" );
				print( "<td > &nbsp;" );
				print( "</td>" );
			print( "</tr>" );			

				print( "<td >" );
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
				print( "<td >" );
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
				print( "<td >" );
				if ( $generalrows[ "url" ] != "")
				{
					
					$urlname = $generalrows[ "url_name" ] == "" ? "Web Link" : $generalrows[ "url_name" ];
					echo "<img alt='web' src='images/icons/web.gif' width='12' height='12' border='0' alt='$urlname' /> ";
					echo "<span class='form_elements_text'><a href='" . htmlspecialchars($generalrows[ "url" ]) . "' target='_blank'>" . $urlname ."</a></span>" ;
					print( "&nbsp; &nbsp;" );
				}
				print( "</td>" );

			print( "<tr >" );
				print( "<td > &nbsp;" );
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
			print( "</tr>" );
		
			print( "<tr >" );
				print( "<td >" );
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


				print( "</span>" );						
				print( "</td>" );
			print( "</tr>" );

		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
print( "<table>" );

?>
