<?php
	print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
	print( "function gen_change_editor1( boxname, results )" );
	print( "{" );
		print( "if( results.length > 0 )" );
		print( "{" );
			print( "document.getElementById( 'user1_name' ).value = results[0][0];" );
			print( "document.getElementById( 'user1_login_id' ).value = results[0][3];" );
		print( "}" );
		print( "cancelFindProfile( 'gen_editor1_find' );" );
	print( "}" );
	print( "function gen_change_editor2( boxname, results )" );
	print( "{" );
		print( "if( results.length > 0 )" );
		print( "{" );
			print( "document.getElementById( 'user2_name' ).value = results[0][0];" );
			print( "document.getElementById( 'user2_login_id' ).value = results[0][3];" );
		print( "}" );
		print( "cancelFindProfile( 'gen_editor2_find' );" );
	print( "}" );
	print( "</script>" );
/*	print ("<span class='error_message'>".
	       "We are currently fixing a bug in this area. Please beare with us while we do so</span>");*/
	print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_editor_info_view_box' class='visiblebox'>" );
		print( "<tr class='table_background'>" );
			print( "<td colspan='2'>" );		
			print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td><span class='form_elements_section_header'>&nbsp;Assign Editors</span></td>" );
					print( "<td align='right' height='20' width='15%'>" );
					print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"gen_editor_info\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
			print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
		
		print( "<tr height='5'></tr>" );
		print( "<tr>" );
			print( "<td width='5'></td>" );
			print( "<td>" );
			$span = "";
			$name = ($gen_editor_info_id_rows[2] == "")? "<unassigned>" : ucwords( $gen_editor_info_id_rows[2] );
			print( "<span class='form_elements_section_subheader'>Editor 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>" );
			print( "<span class='form_elements_text'>" . htmlspecialchars($name). "</span>" );
			print( "</td>" );
		print( "</tr>" );

		print( "<tr height='5'></tr>" );
		print( "<tr>" );
			print( "<td width='5'></td>" );
			print( "<td>" );
			$span = "<span class='form_elements_section_subheader'>";			
			$name = ($gen_editor_info_id_rows[3] == "") ? "<unassigned>" : ucwords($gen_editor_info_id_rows[3]);
			print( "<span class='form_elements_section_subheader'>Editor 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>" );
			print( "<span class='form_elements_text'>" . htmlspecialchars($name). "</span>" );
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );
	
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_editor_info_edit_box' class='hiddenbox'>" );
		print( "<form id='gen_editor_info_edit_form' name='gen_editor_info_edit_form' action='sections/gen_editor_info_edit_box_submit.php' method='post'>" );
		print( "<input type='hidden' name='pid' value='$pid'  />" );
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<tr class='table_background'>" );
			print( "<td colspan='2'>" );		
			print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td><span class='form_elements_section_header'>&nbsp;Assign Editors</span></td>" );
					print( "<td align='right' height='20' width='15%'>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"gen_editor_info\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"gen_editor_info\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
			print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
		print( "<tr height='5'></tr>" );		
		print( "<tr >" );
			print( "<td width='5'></td>" );
			print( "<td>" );
			print( "<span class='form_elements_section_subheader'>Editor 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>" );
			print( "<input class='form_elements_edit' type='text' readonly name='user1_name' id='user1_name' value='". htmlspecialchars($gen_editor_info_id_rows[2], ENT_QUOTES) .  "' maxlength='255' size='30'>" );
			print( "<input class='form_elements_edit' type='hidden' name='user1_login_id' id='user1_login_id' value='". htmlspecialchars($gen_editor_info_id_rows[0], ENT_QUOTES) .  "' maxlength='255'> &nbsp;" );
			print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
			print( "createFindProfileRow('gen_editor1_find', 'ppl', 'gen_change_editor1', 0, 1 );" );
			print( "</script>" ); 
			print( "</td>" );
		print( "</tr>" );
		print( "<tr height='5'></tr>" );
		print( "<tr >" );
			print( "<td width='5'></td>" );
			print( "<td>" );
			print( "<span class='form_elements_section_subheader'>Editor 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>" );
			print( "<input class='form_elements_edit' type='text' readonly name='user2_name' id='user2_name' value='". htmlspecialchars($gen_editor_info_id_rows[3], ENT_QUOTES) .  "' maxlength='255' size='30'>" );
			print( "<input class='form_elements_edit' type='hidden' name='user2_login_id' id='user2_login_id' value='". htmlspecialchars($gen_editor_info_id_rows[1], ENT_QUOTES) .  "' maxlength='255' >&nbsp;" );
			print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
			print( "createFindProfileRow('gen_editor2_find', 'ppl', 'gen_change_editor2', 0, 1 );" );
			print( "</script>" );
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );
?>