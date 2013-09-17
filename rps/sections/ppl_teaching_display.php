<script  language=javascript type="text/javascript">
  function enable(itr) 
  {
	if(itr==0)
	{
		document.getElementById("ppl_teaching_office_location").disabled = 0;
		document.getElementById("ppl_teaching_room_number").disabled = 0;
		document.getElementById("ppl_teaching_office_phone").disabled = 0;
		document.getElementById("ppl_teaching_email_id").disabled = 0;		
	}
	else
	{
		var frmName = "ppl_teaching_"+itr+"_edit_form";
		document.forms[frmName].elements["ppl_teaching_office_location"].disabled = 0;
		document.forms[frmName].elements["ppl_teaching_room_number"].disabled = 0;
		document.forms[frmName].elements["ppl_teaching_office_phone"].disabled = 0;
		document.forms[frmName].elements["ppl_teaching_email_id"].disabled = 0;
	}
  }
  function disable(itr) 
  {
	if(itr==0)
	{
		document.getElementById("ppl_teaching_office_location").disabled = 1;
		document.getElementById("ppl_teaching_room_number").disabled = 1;
		document.getElementById("ppl_teaching_office_phone").disabled = 1;
		document.getElementById("ppl_teaching_email_id").disabled = 1;		
	}
	else
	{
		var frmName = "ppl_teaching_"+itr+"_edit_form";
		document.forms[frmName].elements["ppl_teaching_office_location"].disabled = 1;
		document.forms[frmName].elements["ppl_teaching_room_number"].disabled = 1;
		document.forms[frmName].elements["ppl_teaching_office_phone"].disabled = 1;
		document.forms[frmName].elements["ppl_teaching_email_id"].disabled = 1;
	}
  }
  
  function disablefile(itr, rmvobject)
  {
  	var frmName = "ppl_teaching_"+itr+"_edit_form";
	if(rmvobject.checked==true)
		document.forms[frmName].elements["ppl_teaching_syllabus_file"].disabled=1;
	else
		document.forms[frmName].elements["ppl_teaching_syllabus_file"].disabled=0;		

  }
  
  function show_additional( divprefix, recordno )
  {
	if(document.getElementById(divprefix+recordno).className=='visiblerow')
	{
		document.getElementById(divprefix+'_text_'+recordno).innerHTML = "[ Show Additional Information ]";
		document.getElementById(divprefix+recordno).className="hiddenrow";
	}
	else
	{
		document.getElementById('ppl_teaching_additional_text_'+recordno).innerHTML = "[ Hide Additional Information ]";
		document.getElementById(divprefix+recordno).className="visiblerow";
	}
  }
  function show_archive( divprefix )
  {
	if(document.getElementById(divprefix).className=='visiblerow')
	{
		document.getElementById(divprefix+'_text').innerHTML = "[ Show Archived Courses ]";
		document.getElementById(divprefix).className="hiddenrow";
	}
	else
	{
		document.getElementById(divprefix+'_text').innerHTML = "[ Hide Archived Courses ]";
		document.getElementById(divprefix).className="visiblerow";
	}
  }

function show_combo( divhide, divsrc, divdest, recordno )
  {
	if(document.getElementById(divhide).className=='visiblerow')
	{
		var result = "";
		var separator = "";

	    for(var i = 0;i<document.getElementById(divsrc).length; i++){
	        if(document.getElementById(divsrc).options[i].selected){
	            result+=separator;
				result+=document.getElementById(divsrc).options[i].value;
				separator = ", ";
	        }
	    }
		document.getElementById(divdest+""+recordno).value = result;
		document.getElementById(divdest+"_value"+recordno).value = result;		
		document.getElementById(divdest+'_text'+recordno).innerHTML = "[ Edit Semesters ]";
		document.getElementById(divhide).className="hiddenrow";
	}
	else
	{
		document.getElementById(divdest+'_text'+recordno).innerHTML = "[ Done ]";
		document.getElementById(divhide).className="visiblerow";
	}
  }

function checkform ( form , ppl_teaching, row, type)
{
	if (document.getElementById(form).ppl_teaching_course_number.value == "") {
    	alert( "Please enter the Course Number." );
	    document.getElementById(form).ppl_teaching_course_number.focus();

    	return false ;
	}
	if (document.getElementById(form).ppl_teaching_course_title.value == "") {
    	alert( "Please enter the Course Title." );
	    document.getElementById(form).ppl_teaching_course_title.focus();

    	return false ;
	}

	if(row == -1){
		return submit_box( ppl_teaching, type );
	}
	else{
		return submit_row( ppl_teaching, row, type );
	}
}
</script>
<?php
$fileuploaddir = '/opt/www/html'.$_home.'/syllabi/';
function MakeDeptComboBox($name, $hhid, $db_conn)
{
	global $connect;
	$querydept = "SELECT * FROM gen_hierarchy_types where acad_status = 0 and acronym is not null ORDER BY acronym ASC";
	$resultdept = real_execute_query($querydept, $db_conn);
	echo "<select id='$name' name='$name' class='form_elements_edit'>";	
	while($rowdept = mysql_fetch_array($resultdept))
	{
		if (strcmp($rowdept["hid"], $hhid)==0)
			$selected = "selected";
		else
			$selected = "";
		print "<option value='".$rowdept["hid"]."' $selected>".$rowdept["acronym"]."</option>";

	}//end while
	echo "</select>";
}


$ppl_teaching_num_rows = mysql_num_rows( $ppl_teaching_results );

if($ppl_teaching_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_teaching_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			if( $editable==true)//
			{
				print( "<td align='center' valign='middle' width='20px' id='ppl_teaching_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ppl_teaching\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ppl_teaching_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ppl_teaching\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Teaching</span></td>" );
			print( "<form name='ppl_teaching_delete_form' id='ppl_teaching_delete_form' method='post' action='sections/ppl_teaching_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{	
			
				print( "<a href='{$_home}/help/index.php#facul_r&e' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_teaching\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ppl_teaching\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_teaching_add_box' class='hiddenbox'>" );
//		$ppl_teaching_max_id_rows = mysql_fetch_row( $ppl_teaching_max_id_results );
//		$max_resch_id = $ppl_teaching_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form enctype='multipart/form-data' name='ppl_teaching_add_form' id='ppl_teaching_add_form' method='post' action='sections/ppl_teaching_add_box_submit.php' >" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "<input type='hidden' name='clicked' value='0' />" );
			print( "<input type='hidden' name='max_resch_id' value='$max_resch_id' />" );
			print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
			print( "<td>" );
			print( "<span class='form_elements_text'>" );
			print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' bordercolor=gray>" );
				print( "<tr>" );
					print( "<td>Course #:</td><td colspan=3>" );
					MakeDeptComboBox("ppl_teaching_dept", "", $db_conn);
					print( "<input class='form_elements_edit' type='text' name='ppl_teaching_course_number' id='ppl_teaching_course_number' value='' maxlength='4' size='15'><span class='error_message'> &nbsp; * &nbsp;Course Number Format: 4-digit (example: 5432)</span></td>" );

//					print("<td>Section #:</td>");
//					print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_section_number' value='' maxlength='3' size='30'></td>");
					print( "<td align='right'>" );
					print( "<input type='checkbox' name='ppl_teaching_status'><span class='form_elements_row_action'>Hide&nbsp;&nbsp;&nbsp;</span>" );		
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ppl_teaching_description\" ); updateRTE(\"ppl_teaching_course_goal\" ); return checkform(\"ppl_teaching_add_form\",\"ppl_teaching\", -1, \"add\" ); '><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ppl_teaching\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
								print( "<tr>" );
					print ("<td>&nbsp;</td>");
					print( "<td colspan='2'></td>" );

					print("<td>&nbsp;</td><td>&nbsp;</td>" );
				print( "</tr>" );
				print( "<tr>" );
					print( "<td>Course Title</td>" );
					print( "<td><input class='form_elements_edit' type='text' name='ppl_teaching_course_title' id='ppl_teaching_course_title' value='' maxlength='255' size='40'><span class='error_message'>&nbsp; *</span>" );
					print( "</td>" );
					print("<td>Semester:</td>");
					print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_semester_value' id='ppl_teaching_semester_value' value='' maxlength='255' size='20' disabled /><input type='hidden' id='ppl_teaching_semester' name='ppl_teaching_semester' value='' />");
					
					$today = date("Y");
					print("<select id='ppl_teaching_year' name='ppl_teaching_year' class='form_elements_edit'>");
					for ( $counter = -10; $counter <= 10; $counter += 1) {
					if($counter ==0){
						print("<option value='".($today+$counter)."' selected>".($today+$counter)."</option>");
					}else{
						print("<option value='".($today+$counter)."'>".($today+$counter)."</option>");					
					}
					}
					print("</select>");
print( "<a style='text-decoration:underline; cursor:pointer;'". 
								   "onclick='return show_combo( \"ppl_teaching_choose_semesters\",\"ppl_teaching_select_semesters_add\",\"ppl_teaching_semester\", \"\" )'>".//" <img border='0' src='images/buttons/right-arrow.gif'>".
								    "<div name='ppl_teaching_semester_text' id='ppl_teaching_semester_text' class = 'details'>[ Add Semesters ]</div></a>" );
					print("</td><td>&nbsp;</td>");
				print( "</tr>" );
				print( "<tr id='ppl_teaching_choose_semesters' name='ppl_teaching_choose_semesters' class=\"hiddenrow\">" );
				print("<td colspan=3></td>");
				print("<td colspan=2>");
				print("<select id='ppl_teaching_select_semesters_add' name='ppl_teaching_select_semesters_add'  class='form_elements_edit' multiple>");
					//$semester_result = real_execute_query ("SELECT semester FROM gen_semester", $db_conn);
					while ($semester = mysql_fetch_array ($semester_result)) {
 					  printf("<option value='".$semester["semester"]."'>". $semester["semester"]."</option>");
					}					
					mysql_free_result($semester_result);
					print("</select>");
					
				print("</td>");
				print( "</tr>" );
								
				print( "<tr>" );
					print( "<td colspan='5'>Brief Description for the Course:<br>" );
					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
					print( "writeRichText('ppl_teaching_description', 'ppl_teaching_description', '', 600, 70, true, false, true);" );
					print( "</script>" );
					print( "</td>" );
				print( "</tr>" );
				
				print( "<tr>" );
					print( "<td>Upload Syllabus File:</td>" );
					print( "<td colspan='4'><input id='ppl_teaching_syllabus_file' name='ppl_teaching_syllabus_file' type='file' size='37'/> <br>(Preferred file types: <img alt='MSWord' border='0' src='images/bullets/WordIcon.jpg' width=20 height=20> MS Word(.doc), <img alt='rtf' border='0' src='images/bullets/rtf_icon.gif' width=20 height=20>Richtext(.rtf), <img alt='Text' border='0' src='images/bullets/txt_icon.gif' width=20 height=20>Plaintext(.txt), <img alt='pdf' border='0' src='images/bullets/pdf_icon.jpg' width=20 height=20>Adobe (.pdf))" );
					print( "</td>" );
				print( "</tr>" );

				print( "<tr>" );
					print( "<td colspan='5'>Use the space below to enter additional details:<br>" );
					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
					print( "writeRichText('ppl_teaching_course_goal', 'ppl_teaching_course_goal', '', 600, 150, true, false, true);" );
					print( "</script>" );
					print( "</td>" );
				print( "</tr>" );

				print( "<tr>" );
					print("<td>Course URL Name:</td>");
					print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_url_name' value='' maxlength='30' size='30'></td>");
					print( "<td>Course URL:</td>" );
					print( "<td colspan='2'><input class='form_elements_edit' type='text' name='ppl_teaching_course_url' value='' maxlength='255' size='60'>" );					
					print( "</td>" );
				print("</tr>");
				print("<tr>");
					print("<td>Office Hours:</td>");
					print("<td colspan='4'><input class='form_elements_edit' type='text' name='ppl_teaching_office_hours' value='' maxlength='255' size='30'>");
					print("</td>");
				print( "</tr>" );
				print("<tr>");
					print("<td colspan='5'>");
					print("<input name='ppl_teaching_default_address' type='radio' onclick='disable(\"0\");' value='0' checked />Use my default Contact information&nbsp;&nbsp;&nbsp;&nbsp;<u>OR</u>&nbsp;&nbsp;&nbsp;&nbsp;");
					print("<input name='ppl_teaching_default_address' type='radio' onclick='enable(\"0\");' value='1'/>I wish to enter a different Contact Information for this Course");
					print("</td>");
				print("</tr>");
			//	print("<tr><td colspan=5>");
				//	print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_teaching_contact_information'>");
						
//						$contact_information_result = real_execute_query ("SELECT office_location, room_no, phone_no_1, email_id FROM ppl_general_info where pid=".$pid, $db_conn);
						$ppl_teaching_contact_information_num_rows = mysql_num_rows( $contact_information_result );
						if($ppl_teaching_contact_information_num_rows == 1){
						$contact_information = mysql_fetch_array ($contact_information_result);
						print("<tr>");
							print("<td>Office Location:</td>");
							print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_office_location' id='ppl_teaching_office_location' value='".$contact_information["office_location"]."' maxlength='255' size='30' disabled>");
							print("</td>");
							print("<td>Room Number:</td>");
							print("<td colspan=2><input class='form_elements_edit' type='text' name='ppl_teaching_room_number' id='ppl_teaching_room_number' value='".$contact_information["room_no"]."' maxlength='255' size='30' disabled>");
							print("</td>");
						print("</tr>");
						
						print("<tr>");
							print("<td>Office Phone:</td>");
							print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_office_phone' id='ppl_teaching_office_phone' value='".$contact_information["phone_no_1"]."' maxlength='255' size='30' disabled>");
							print("</td>");
							print("<td>Email Address:</td>");
							print("<td colspan=2><input class='form_elements_edit' type='text' name='ppl_teaching_email_id' id='ppl_teaching_email_id' value='".$contact_information["email_id"]."' maxlength='255' size='30' disabled>");
							print("</td>");
						print("</tr>");
						}
				//	print("</table>");
			//	print("</td></tr>");
				print( "<tr><td colspan='5'><HR></td></tr>" );						
			print( "</table>" );
			print( "</span>" );
			print( "</td>" );
		print( "</form>" );
		print( "</tr>" );
	print( "</table>" );
	}
	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_teaching_view_box' class='visiblebox'>" );
		if( $ppl_teaching_num_rows > 0 )
			mysql_data_seek( $ppl_teaching_results, 0 );
		$ppl_teaching_rows_itr = 0;
		$archiveCount=0;
		while( $ppl_teaching_rows = mysql_fetch_array( $ppl_teaching_results ) )
		{
//			$file_id = $ppl_teaching_rows["file_id"];		
			if ($ppl_teaching_rows["archive"] == 1){
				$bgcolor="#CCCCCC";
				$archiveCount++;
			}
			else
				$bgcolor="#FFFFFF";		
			
			if($archiveCount ==1){
				print( "<tr><td></td><td align=center><a style='text-decoration:underline; cursor:pointer;' onclick='return show_archive( \"ppl_teaching_show_archive\" )'> <div name='ppl_teaching_show_archive_text' id='ppl_teaching_show_archive_text' class='details'>[ Show Archived Courses ]</div></a></td></tr>" );
				print( "<tr id='ppl_teaching_show_archive' name='ppl_teaching_show_archive' class=\"hiddenrow\">" );
				print( "<td width='5'>&nbsp;</td>" );
				print("<td>");
				print("<table width=95% >");

			}
			
			$ppl_teaching_rows_itr++;
			$course_id = $ppl_teaching_rows["course_id"];
			print( "<tr id='ppl_teaching_" . $ppl_teaching_rows_itr . "_view_row' class='visiblerow'>" );
				print( "<td width='5'>&nbsp;</td>" );
	
				if( $editable == true )
				{
					print( "<form id='ppl_teaching_" . $ppl_teaching_rows_itr . "_delete_form' method='post' action='sections/ppl_teaching_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='course_id' value='$course_id' />" );
					print( "<input type='hidden' name='ppl_teaching_file_id' value='" . $ppl_teaching_rows["file_id"] . "' />" );					
					print( "</form>" );

					print( "<form id='ppl_teaching_" . $ppl_teaching_rows_itr . "_copyAndArchive_form' method='post' action='sections/ppl_teaching_copy_and_archive.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='course_id' value='$course_id' />" );
					print( "</form>" );
					
					print( "<form id='ppl_teaching_" . $ppl_teaching_rows_itr . "_Copy_form' method='post' action='sections/ppl_teaching_copy_and_archive.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='course_id' value='$course_id' />" );
					print( "</form>" );
				}
				if( $ppl_teaching_rows["status"] == 0 || $editable == true )
				{
					print( "<td>" );
					
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' bgcolor=$bgcolor> " );
						print( "<tr>" );
							print( "<td>" );
							if( $ppl_teaching_rows["status"] == 0 )
								$span = "<span class='form_elements_section_subheader'>";
							else
								$span = "<span class='form_elements_section_subheader_disabled'>";
							print( "<a name='".$ppl_teaching_rows["course_id"]."' id='".$ppl_teaching_rows["course_id"]."'> $span"  . htmlspecialchars($ppl_teaching_rows["course_title"], ENT_QUOTES) ." - ".$ppl_teaching_rows["course_dept"]." ".$ppl_teaching_rows["course_number"] );
					//		if($ppl_teaching_rows["section_number"]!="")
					//			print( " (".strval($ppl_teaching_rows["section_number"]).")");
							print( "</span></a>");
							print( "</td>" );
							print( "<td width='20%' align='right'>" );
							if( $editable == true )
							{
								print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_teaching\", \"$ppl_teaching_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
								print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ppl_teaching\", \"$ppl_teaching_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif' > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );

								if ($ppl_teaching_rows["archive"] == 1){
									print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_teaching\", \"$ppl_teaching_rows_itr\", \"Copy\" )' ><img alt='new' border='0' src='images/icons/new.gif' alt='Copy from Archive' > <span class='form_elements_row_action'>Copy &nbsp;</span></a>" );
								}else
									print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_teaching\", \"$ppl_teaching_rows_itr\", \"copyAndArchive\" )' ><img alt='Copy and Archive' border='0' src='images/icons/new.gif' alt='Copy and Archive' > <span class='form_elements_row_action'>Copy & Archive &nbsp;</span></a>" );

							}
							print( "</td>" );
						print( "</tr>" );
						
						print( "<tr><td colspan='2'>$span".$ppl_teaching_rows["semester"]. 
								" " .$ppl_teaching_rows["year"] . "</span></td></tr>" );
						if( $ppl_teaching_rows["status"] == 0 )
							$span = "<span class='form_elements_text'>";
						else
							$span = "<span class='form_elements_text_disabled'>";
						if($ppl_teaching_rows["days"]!="" || $ppl_teaching_rows["location"]!="")
						{
							print( "<tr>" );
							print( "<td colspan='2'>".$span );
									if($ppl_teaching_rows["days"]!="")
										print( $ppl_teaching_rows["days"]." ".$ppl_teaching_rows["times"]."<br />" );
									if($ppl_teaching_rows["location"]!="")
										print( $ppl_teaching_rows["location"] );
							print ( "&nbsp;</span></td>" );
							print ("</tr>" );
						}
						if($ppl_teaching_rows["description"] != "")
						{
							print ( "<tr>" );
							print ( "<td colspan='2'>" );
								print( $span. real_rte_specialchars($ppl_teaching_rows["description"]) . "</span><br />" ); 											
							print ( "</td>" );
							print ( "</tr>" );
						}
									$file_name = $ppl_teaching_rows["file_name"];
									$fileuploaddir = $ppl_teaching_rows["upload_location"];
									$file_size = $ppl_teaching_rows["file_size"];
								if($file_size!=0 || $ppl_teaching_rows["course_url"]!="")
								{
									print( "<tr>" );
										print( "<td colspan=2>" );
										if( $ppl_teaching_rows["file_id"] != 0 )
											print( "$span<a href='$fileuploaddir" . $file_name . "'  target='_blank'>Download Syllabus</a><font class='details'> (".round($file_size/1024,2)."KB. This syllabus was uploaded ".$ppl_teaching_rows["upload_time"]." and is subject to change.)</font></span><br>" );
																			
										if( $ppl_teaching_rows["course_url"] != "" )
										{
											$url_name = $ppl_teaching_rows["url_name"] == "" ? "Course URL" : htmlspecialchars( $ppl_teaching_rows["url_name"], ENT_QUOTES );
											print( "$span <a href='" . htmlspecialchars( $ppl_teaching_rows["course_url"], ENT_QUOTES). "' target=_blank> ".$url_name."</a></span><BR>" );
										}
										print( "</td>" );
									print( "</tr>" );
								}								
								if($ppl_teaching_rows["course_goal"]!="")
								{
								   print "<tr><td colspan='2'>";
								   print( "<a style='text-decoration:underline; cursor:pointer;'". 
								   "onclick='return show_additional( \"ppl_teaching_additional\", \"$ppl_teaching_rows_itr\" )'>".// <img border='0' src='images/buttons/right-arrow.gif'>".
								   "<div name='ppl_teaching_additional_text_".$ppl_teaching_rows_itr."' id='ppl_teaching_additional_text_".$ppl_teaching_rows_itr."' class='details'>[ Show Additional Information ]</div></a>" );
								   print "</td></tr>";
								print( "<tr id='ppl_teaching_additional" . $ppl_teaching_rows_itr . "' name='ppl_teaching_additional" . $ppl_teaching_rows_itr . "' class=\"hiddenrow\">".
									"<td colspan=2>" );
									print( "$span". real_rte_specialchars($ppl_teaching_rows["course_goal"]) . "</span>" );
								print( "<br></td></tr>" );
								}
								if($ppl_teaching_rows["office_hours"] != "" || $ppl_teaching_rows["office_location"]!=""
										|| $ppl_teaching_rows["room_no"] !="" || $ppl_teaching_rows["phone_no_1"]!="" 
										|| $ppl_teaching_rows["email_id"]!="")
								{								
									print( "<tr>" );
									print( "<td colspan='2'>".$span );
										print ( "<u>Contact Information</u><br />");
										if($ppl_teaching_rows["office_location"]!="")
											print( $ppl_teaching_rows["office_location"]);
										if($ppl_teaching_rows["room_no"]!="")
											print (",&nbsp;#".$ppl_teaching_rows["room_no"]);
										if($ppl_teaching_rows["office_hours"]!="")
											print ("&nbsp;&nbsp;Hours: ".htmlspecialchars($ppl_teaching_rows["office_hours"]));
										if($ppl_teaching_rows["office_hours"] != "" || $ppl_teaching_rows["office_location"]!=""
										   || $ppl_teaching_rows["room_no"] !="")
										   	print "<br />";
										if($ppl_teaching_rows["phone_no_1"]!="")
											print( "Phone:&nbsp;".$ppl_teaching_rows["phone_no_1"]."&nbsp;&nbsp;" );
										if($ppl_teaching_rows["email_id"]!="")
											print( "Email: <a href='mailto:".$ppl_teaching_rows["email_id"]."'>".
												   $ppl_teaching_rows["email_id"]."</a>" );
									print( "</span></td>" );
									print( "</tr>" );
								}
						print( "<tr><td colspan='3'><HR></td></tr>" );
					print( "</table>" );
					print( "</td>" );					
				}
			print( "</tr>" );
			if( $editable == true )
			{
				print( "<tr id='ppl_teaching_" . $ppl_teaching_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<td width='5'></td>" );
				print( "<form enctype='multipart/form-data' name='ppl_teaching_" . $ppl_teaching_rows_itr . "_edit_form' id='ppl_teaching_" . $ppl_teaching_rows_itr . "_edit_form' method='post' action='sections/ppl_teaching_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='course_id' value='$course_id' />" );
					print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
					print( "<input type='hidden' name='ppl_teaching_file_id' value='" . $ppl_teaching_rows["file_id"] . "' />" );

					print( "<td>" );
					print( "<span class='form_elements_text'>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' bordercolor=gray>" );
					print( "<tr>" );
					print( "<td>Course #:</td><td colspan=3>" );
					MakeDeptComboBox("ppl_teaching_course_dept", htmlspecialchars( $ppl_teaching_rows["hid"], ENT_QUOTES ), $db_conn);
					print( "<input class='form_elements_edit' type='text' name='ppl_teaching_course_number' id='ppl_teaching_course_number' value='". htmlspecialchars( $ppl_teaching_rows["course_number"], ENT_QUOTES ).  "' maxlength='4' size='15'><span class='error_message'>&nbsp; * &nbsp;Course Number Format: 4-digit (example: 5432)</span></td>" );
//					print("<td>Section #:</td>");
//					print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_section_number' value='". htmlspecialchars( $ppl_teaching_rows["section_number"], ENT_QUOTES ).  "' maxlength='3' size='30'></td>");
					print( "<td align='right'>" );
					$checkboxvalue = $ppl_teaching_rows[ "status" ] == 1 ? "checked" : "" ;
							print( "<input type='checkbox' name='ppl_teaching_status' $checkboxvalue><span class='form_elements_row_action'>Hide&nbsp;&nbsp;&nbsp;</span>" );	
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ppl_teaching_description_" . $ppl_teaching_rows_itr . "\" ); updateRTE(\"ppl_teaching_course_goal_" . $ppl_teaching_rows_itr . "\" ); return checkform(\"ppl_teaching_".$ppl_teaching_rows_itr."_edit_form\",\"ppl_teaching\", \"$ppl_teaching_rows_itr\", \"edit\" );'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
							print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ppl_teaching\", \"$ppl_teaching_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
							print( "</td>" );
				print( "</tr>" );
				print( "<tr>" );
				print( "<tr>" );
					print ("<td>&nbsp;</td>");
					print( "<td colspan='2'></td>" );

					print("<td></td>" );
				print( "</tr>" );
					print( "<td>Course Title</td>" );
					print( "<td><input class='form_elements_edit' type='text' name='ppl_teaching_course_title' id='ppl_teaching_course_title' value='". htmlspecialchars( $ppl_teaching_rows["course_title"], ENT_QUOTES ).  "' maxlength='255' size='40'><font class='error_message'>&nbsp;*</font>" );
					print( "</td>" );
					print("<td>Semester:</td>");
					print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_semester_value' id='ppl_teaching_semester_value".$ppl_teaching_rows_itr."' value='". htmlspecialchars( $ppl_teaching_rows["semester"], ENT_QUOTES ).  "' maxlength='255' size='20' disabled ><input type=hidden name='ppl_teaching_semester' id='ppl_teaching_semester".$ppl_teaching_rows_itr."' value='". htmlspecialchars( $ppl_teaching_rows["semester"], ENT_QUOTES ).  "' />");
					
					$today = date("Y");
					print("<select name='ppl_teaching_year' id='ppl_teaching_year' class='form_elements_edit'>");
					for ( $counter = -10; $counter <= 10; $counter += 1) {
					if(($today+$counter) == $ppl_teaching_rows["year"]){
						print("<option selected>".($today+$counter)."</option>");
					}else{
						print("<option>".($today+$counter)."</option>");					
					}
					}
					print("</select>");
					print( "<a style='text-decoration:underline; cursor:pointer;'". 
								   "onclick='return show_combo( \"ppl_teaching_choose_semesters_". $ppl_teaching_rows_itr ."\",\"ppl_teaching_select_semesters_". $ppl_teaching_rows_itr ."\",\"ppl_teaching_semester\",  $ppl_teaching_rows_itr  )'>".//" <img border='0' src='images/buttons/right-arrow.gif'>".
								    "<div name='ppl_teaching_semester_text". $ppl_teaching_rows_itr ."' id='ppl_teaching_semester_text". $ppl_teaching_rows_itr ."' class = 'details'>[ Edit Semesters ]</div></a>" );
					print("</td><td>&nbsp;</td>");
				print( "</tr>" );
		
				print( "<tr id='ppl_teaching_choose_semesters_". $ppl_teaching_rows_itr ."' name='ppl_teaching_choose_semesters_". $ppl_teaching_rows_itr ."'  class=\"hiddenrow\">" );
				print("<td colspan=3></td>");
				print("<td colspan=2>");
				print("<select id='ppl_teaching_select_semesters_".$ppl_teaching_rows_itr ."' name='ppl_teaching_select_semesters_".$ppl_teaching_rows_itr ."' class='form_elements_edit' multiple>");
					$semester_result = real_execute_query($semester_query, $db_conn);
					while ($semester = mysql_fetch_array ($semester_result)) {
						printf("<option value='".$semester["semester"]."'>". $semester["semester"]."</option>"); 					
					}					
					mysql_free_result($semester_result);
					print("</select>");
				print("</td>");
				print( "</tr>" );				
				

				print( "<tr>" );
					print( "<td colspan='5'>Brief Description for the Course:<br>" );
					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
							print( "writeRichText('ppl_teaching_description_" . $ppl_teaching_rows_itr . "', 'ppl_teaching_description', '" . real_rte_specialchars( $ppl_teaching_rows["description"] ) . "', 600, 70, true, false, true);" );
							print( "</script>" );
					print( "</td>" );
				print( "</tr>" );
				
				print( "<tr>" );
					print( "<td>Upload Syllabus File:</td>" );
					print( "<td colspan='4'><input id='ppl_teaching_syllabus_file' name='ppl_teaching_syllabus_file' id='ppl_teaching_syllabus_file' type='file' size='37'/>" );
					print( "&nbsp;&nbsp;<input type='checkbox' name='ppl_teaching_remove_syllabus_file' id='ppl_teaching_remove_syllabus_file' onClick='disablefile(" . $ppl_teaching_rows_itr . ", this);'> <span  class='form_elements_edit'> Remove </span>" ); 
				$file_name = $ppl_teaching_rows["file_name"];
				$fileuploaddir = $ppl_teaching_rows["upload_location"];
				$file_size = $ppl_teaching_rows["file_size"];
									
				if( $ppl_teaching_rows["file_id"] != 0 )
					print( "$span(<a href='$fileuploaddir" . $file_name . "'  target='_blank'>Download Syllabus </a><font class='details'>(".round($file_size/1024,2)."KB)</font>)" );
		
					print( "</span></td>" );
				print( "</tr>" );
				
				print( "<tr>" );
					print( "<td colspan='5'>Use the space below to enter additional details:<br>" );
					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
							print( "writeRichText('ppl_teaching_course_goal_" . $ppl_teaching_rows_itr . "', 'ppl_teaching_course_goal', '" . real_rte_specialchars( $ppl_teaching_rows["course_goal"] ) . "', 600, 150, true, false, true);" );
					print( "</script>" );

					print( "</td>" );
				print( "</tr>" );
				print( "<tr>" );
					print("<td>Course URL Name:</td>");
					print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_url_name' value='". htmlspecialchars( $ppl_teaching_rows["url_name"], ENT_QUOTES ).  "' maxlength='50' size='30'></td>");
					print( "<td>Course URL:</td>" );
					print( "<td colspan='2'><input class='form_elements_edit' type='text' name='ppl_teaching_course_url' value='". htmlspecialchars( $ppl_teaching_rows["course_url"], ENT_QUOTES ).  "' maxlength='255' size='60'>" );					
					print( "</td>" );
				print("</tr>");
				print("<tr>");
					print("<td>Office hours: </td>");
					print("<td colspan='4'><input class='form_elements_edit' type='text' name='ppl_teaching_office_hours' value='". htmlspecialchars( $ppl_teaching_rows["office_hours"], ENT_QUOTES ).  "' maxlength='255' size='30'>");					
					print("</td>");
				print( "</tr>" );
				print("<tr>");
					print("<td colspan='5'>");
					if($ppl_teaching_rows["default_address"]==0){
						$checked="checked";
						$disabled="disabled";
					}
					else 
						$checked="";
					print("<input name='ppl_teaching_edit_default_address' type='radio' onclick='disable(" . $ppl_teaching_rows_itr . ");' value='0' ".$checked." />Use my default Contact information&nbsp;&nbsp;&nbsp;&nbsp;<u>OR</u>&nbsp;&nbsp;&nbsp;&nbsp;");
					if($ppl_teaching_rows["default_address"]==1){
						$checked="checked";
						$disabled="";
					}
					else
						$checked="";
					print("<input name='ppl_teaching_edit_default_address' type='radio' onclick='enable(" . $ppl_teaching_rows_itr . ");' value='1' ".$checked." />I wish to enter a different Contact Information for this Course");
					print("</td>");
				print("</tr>");
		//		print("<tr><td colspan=5>");
			//		print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_teaching_contact_information' >");
					
						print("<tr>");
							print("<td>Office Location:</td>");
							print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_office_location' id='ppl_teaching_office_location' value='".$ppl_teaching_rows["office_location"]."' maxlength='255' size='30' $disabled>");
							print("</td>");
							print("<td>Room Number:</td>");
							print("<td colspan='2'><input class='form_elements_edit' type='text' name='ppl_teaching_room_number' id='ppl_teaching_room_number' value='".$ppl_teaching_rows["room_no"]."' maxlength='255' size='30' $disabled>");
							print("</td>");
						print("</tr>");
						
						print("<tr>");
							print("<td>Office Phone:</td>");
							print("<td><input class='form_elements_edit' type='text' name='ppl_teaching_office_phone' id='ppl_teaching_office_phone' value='".$ppl_teaching_rows["phone_no_1"]."' maxlength='255' size='30' $disabled>");
							print("</td>");
							print("<td>Email Address:</td>");
							print("<td colspan='2'><input class='form_elements_edit' type='text' name='ppl_teaching_email_id' id='ppl_teaching_email_id' value='".$ppl_teaching_rows["email_id"]."' maxlength='255' size='30' $disabled>");
							print("</td>");
						print("</tr>");
				//	print("</table>");
			//	print("</td></tr>");		
				print( "<tr><td colspan='5'><HR></tr></td>" );						
				print( "</table>" );
				print( "</span>" );
				print( "</td>" );
				print( "</form>" );
				print( "</tr>" );
			}

		}
						if($archiveCount>0){
					print("</table>");				
					print("</td");
					print("</tr>");
				}									

//	print("<tr><td></td><td><hr></td></tr>");
//	$span = "<span class='font_orange'>";
//	print( "<tr><td></td><td colspan='4'>".$span."For the Official List of Courses for registration, please visit".
//			" <a href='https://epprd.uta.edu/psp/EP89PRD/EMPLOYEE/HRMS/c/ESTABLISH_COURSES.CLASS_SEARCH.GBL?pslnkid=UTA_PS_CLASS_SCHEDULE_LINK&PORTALPARAM_PTCNAV=UTA_PS_CLASS_SCHEDULE_LINK&EOPP.SCNode=EMPL&EOPP.SCPortal=EMPLOYEE&EOPP.SCName=ADMN_CATALOGS_AND_CLASSES&EOPP.SCLabel=Catalogs%20and%20Classes&EOPP.SCPTcname=&FolderPath=PORTAL_ROOT_OBJECT.PORTAL_BASE_DATA.CO_NAVIGATION_COLLECTIONS.ADMN_CATALOGS_AND_CLASSES.ADMN_S200603031559376762596514&IsFolder=false'>
//			MyMav - Schedule of Classes</a></span></td></tr>" );
	print( "<tr><td height='10'></td></tr>" );
	print( "</table>" );
}	
?>
