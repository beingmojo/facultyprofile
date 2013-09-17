<?php
if( mysql_num_rows( $tech_general_info_results ) > 0 )
	mysql_data_seek( $tech_general_info_results, 0 );
$generalrows = mysql_fetch_array( $tech_general_info_results );
$contactrows = mysql_fetch_array($tech_general_contact_info_results);
if($editable==true)
	$span="<span class='form_elements_text_disabled'>";
else
	$span = "<span class='form_elements_text'>";
print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='tech_general_info_view_box' class='visiblebox'>" );
	print( "<tr >" );
		print( "<td id='name' align='center' colspan='3'>".htmlspecialchars($generalrows[ "name" ])."</td>" );
	print( "</tr>" );

	print( "<tr>" );
		if( $generalrows["image_id"] != 0 )
		{
			print( "<td align='center' valign='middle' width='128' style='border:1px solid black'>" );
			print( "<img src='images/128/". "$pid" . "_0_" 
			       . $generalrows["image_id"] . ".jpg" . "' alt='" . htmlspecialchars($generalrows["name"], ENT_QUOTES) ."' >" );
			print( "</td>" );
			print( "<td width='5'></td>" );
		}
		print( "<td align='left' valign='top'>" );
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
			print( "<tr class='table_background'>" );
				print( "<td id='name'><span class='form_elements_section_header'>&nbsp;General Information</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
				if( $editable == true )
				{
					print( "<a href='{$_home}/help/index.php#techn_generalinfo' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

					print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"tech_general_info\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
				}
				print( "</td>" );
			print( "</tr>" );
			print( "<tr >" );
				print( "<td colspan='2'> &nbsp;" );
				print( "</td>" );
			print( "</tr>" );					
			print( "<tr>" );
				print( "<td colspan='2'>" );
				if ( $generalrows[ "keywords" ] != "")
				{
					echo "<img src='images/icons/key.gif' width='12' height='12' border='0' alt='Keywords' /> ";
					echo "<span class='form_elements_text'>" . htmlspecialchars($generalrows[ "keywords" ]) ."</span></a>" ;
					print( "&nbsp; &nbsp;" );
				}
				if ( $generalrows[ "url" ] != "")
				{
					$urlname = $generalrows[ "url_name" ] == "" ? "Web Link" : htmlspecialchars($generalrows[ "url_name" ]);
					echo "<img src='images/icons/web.gif' width='12' height='12' border='0' alt='$urlname' /> ";
					echo "<span class='form_elements_text'><a href='" . htmlspecialchars($generalrows[ "url" ]) . "' target='_blank'>" . htmlspecialchars($urlname) ."</a></span>" ;
					print( "&nbsp; &nbsp;" );
				}
				
				print( "</td>" );
			print( "</tr>" );
			
			print( "<tr>" );
				print( "<td align='left' >" );
					print( "<span class='form_elements_text'>" );
						print( "<a href='".htmlspecialchars($contactrows[ "url" ], ENT_QUOTES) ."' target='_blank'>".$span );
						print htmlspecialchars($contactrows[ "office_name" ]) . " ";				
						print( "</span></a>" );
					print( "</span>" );
				print( "</td>" );
				print( "<td align='right'>" );
				print( "</td" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='2'>" );
				print( $span );
					echo "Contact: <a href='mailto:". $contactrows["email_id"]."'>".$span. htmlspecialchars($contactrows["office_name"])."</span></a>&nbsp;";
					echo "<img src='images/icons/office.png' width='12' height='12' border='0' alt='Office Location' />&nbsp;";
					echo htmlspecialchars($contactrows["address"]);
					echo "&nbsp;<img src='images/icons/phone_office.gif' width='12' height='12' border='0' alt='Contact Number' />" .
						"&nbsp;". htmlspecialchars($contactrows[ "phone_no" ]) . " &nbsp;&nbsp; ";
					echo "&nbsp;<img src='images/icons/fax.png' width='12' height='12' border='0' alt='Fax No:' />" .
						"&nbsp;". htmlspecialchars($contactrows[ "fax_no" ]) . " &nbsp;&nbsp; ";
					
				print( "</span>" );
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
