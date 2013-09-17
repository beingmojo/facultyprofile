<?php
$ppl_presentation_project_num_rows = mysql_num_rows( $ppl_presentation_project_results );
if($ppl_presentation_project_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_presentation_project_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
//			if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ppl_presentation_project_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ppl_presentation_project\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ppl_presentation_project_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ppl_presentation_project\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Presentations and Projects</span></td>" );
			print( "<form name='ppl_presentation_project_delete_form' id='ppl_presentation_project_delete_form' method='post' action='sections/ppl_presentation_project_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{	
			
				print( "<a href='{$_home}/help/index.php#facul_p&p' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_presentation_project\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ppl_presentation_project\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );


	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_presentation_project_add_box' class='hiddenbox'>" );
		$ppl_presentation_project_max_id_rows = mysql_fetch_row( $ppl_presentation_project_max_id_results );
		$max_pr_id = $ppl_presentation_project_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form enctype='multipart/form-data' id='ppl_presentation_project_add_form' method='post' action='sections/ppl_presentation_project_add_box_submit.php' >" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "<input type='hidden' name='clicked' value='0' />" );
			print( "<input type='hidden' name='max_pr_id' value='$max_pr_id' />" );
			print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
			print( "<td>" );
			print( "<span class='form_elements_text'>" );
			print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td width='10%'>Name</td>" );
					print( "<td><input class='form_elements_edit' type='text' name='ppl_presentation_project_name' value='' maxlength='255' size='60'></td>" );
					print( "<td align='right'>" );							
					print( "<input type='checkbox' name='ppl_presentation_project_status'><span class='form_elements_row_action'>Hide</span>&nbsp;&nbsp;" );
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ppl_presentation_project_description\" ); return submit_box( \"ppl_presentation_project\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ppl_presentation_project\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
				
				print( "<tr>" );
					print( "<td>Duration</td>" );
					print( "<td colspan='2'>" );
					print("<select class='form_elements_edit_combo' name='ppl_presentation_project_s_mm'>");
						print("<option>mm</option>");
						for($i = 1; $i <= 12; $i++)
							printf("<option>%02d</option>",$i);
					print("</select>");
					print("<select class='form_elements_edit_combo' name='ppl_presentation_project_s_dd'>");
						print("<option>dd</option>");
						for($i = 1; $i <= 31; $i++)
							printf("<option>%02d</option>",$i);
					print("</select>");
					print("<select class='form_elements_edit_combo' name='ppl_presentation_project_s_yyyy'>");
						print("<option>yyyy</option>");
						$genYearsSQL = "SELECT * FROM gen_years";
						$genYearsQuery =  real_execute_query($genYearsSQL, $db_conn);
						$genYearsRow = mysql_fetch_array($genYearsQuery);
						for($i = $genYearsRow['end_year']; $i >= $genYearsRow['start_year']; $i--)
							printf("<option>%d</option>",$i);	
					print("</select>");
					print( "&nbsp; to &nbsp;" );
					print("<select class='form_elements_edit_combo' name='ppl_presentation_project_e_mm'>");
						print("<option>mm</option>");
						for($i = 1; $i <= 12; $i++)
							printf("<option>%02d</option>",$i);
					print("</select>");
					print("<select class='form_elements_edit_combo' name='ppl_presentation_project_e_dd'>");
						print("<option>dd</option>");
						for($i = 1; $i <= 31; $i++)
							printf("<option>%02d</option>",$i);
					print("</select>");
					print("<select class='form_elements_edit_combo' name='ppl_presentation_project_e_yyyy'>");
						print("<option>yyyy</option>");
						$genYearsSQL = "SELECT * FROM gen_years";
						$genYearsQuery =  real_execute_query($genYearsSQL, $db_conn);
						$genYearsRow = mysql_fetch_array($genYearsQuery);
						for($i = $genYearsRow['end_year']; $i >= $genYearsRow['start_year']; $i--)
							printf("<option>%d</option>",$i);	
					print("</select>");
					print( "</td>" );
				print( "</tr>" );
				/*******************
				backup
				********************
				print( "<tr>" );
					print( "<td>Duration</td>" );
					print( "<td colspan='2'>" );
					print("<input class='form_elements_edit' type='text' name='ppl_presentation_project_s_date' value='' maxlength='16' size='6'>");
					print( "&nbsp; - &nbsp;" );
					print( "<input class='form_elements_edit' type='text' name='ppl_presentation_project_e_date' value='' maxlength='16' size='6'>" );
					print( "</td>" );
				print( "</tr>" );
				********************
				end backup
				*******************/
				print( "<tr>" );
					print( "<td>WebSite</td>" );
					print( "<td colspan='2'><input class='form_elements_edit' type='text' name='ppl_presentation_project_url_name' value='' maxlength='255' size='22'>" );
					print( "&nbsp; &nbsp; URL" );
					print( "&nbsp; &nbsp; <input class='form_elements_edit' type='text' name='ppl_presentation_project_url' value='' maxlength='255' size='22'>" );
					print( "</td>" );
				print( "</tr>" );
/*
				print( "<tr>" );
					print( "<td>Image</td>" );
					print( "<td colspan='2'><input name='imagefile' type='file' size='37'/>" );
					print( "</td>" );
				print( "</tr>" );
*/
				print( "<tr>" );
					print( "<td colspan='3'>" );
					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
					print( "writeRichText('ppl_presentation_project_description', 'ppl_presentation_project_description', '', 600, 150, true, false, true);" );
					print( "</script>" );
//					print( "<textarea class='form_elements_text' name='ppl_presentation_project_description' cols='120' rows='5'></textarea>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr><td colspan='3'><HR></tr></td>" );						
			print( "</table>" );
			print( "</span>" );
			print( "</td>" );
		print( "</form>" );
		print( "</tr>" );
		print( "</table>" );
	}
	
	print( "<table width='100%' border='1' cellspacing='0' cellpadding='1' id='ppl_presentation_project_view_box' class='visiblebox'>" );
		if( $ppl_presentation_project_num_rows > 0 )
			mysql_data_seek( $ppl_presentation_project_results, 0 );
		$ppl_presentation_project_rows_itr = 0;
		
		//Print paging row
		if( $ppl_presentation_project_num_rows > 0 ) {
			print( "<tr>" );
				if( $editable == true )
					print("<td colspan=\"4\">");
				else
					print("<td colspan=\"3\">");
				print( "<form id = 'ppl_presentation_project_pages_form' method='get' action='editprofile.php#$section_id' style='margin:0px;' >" );
				print( "<input type='hidden' name='pid' value='$pid' >" );
				print( "<input type='hidden' name='view' value='$view' >" );
				print( "<input type='hidden' name='onlyview' value='". $_GET["onlyview"] ."' >" );
				print( "<input type='hidden' name='section_id' value='$section_id' >" );
				print( "<input type='hidden' name='ppl_pres_proj_s_date_sort_order' id='ppl_pres_proj_s_date_sort_order' value='$ppl_pres_proj_s_date_sort_order' >" );
				print( "<input type='hidden' name='ppl_pres_proj_e_date_sort_order' id='ppl_pres_proj_e_date_sort_order' value='$ppl_pres_proj_e_date_sort_order' >" );
				print( "<input type='hidden' name='ppl_pres_proj_curr_sort_field' id='ppl_pres_proj_curr_sort_field' value='$ppl_pres_proj_curr_sort_field' >" );
				print( "<input type='hidden' name='ppl_pres_proj_page' id='ppl_pres_proj_page' value='$ppl_pres_proj_page' >" );
				print("<table width='100%' style='margin:0px;' border='0' cellspacing='0' cellpadding='0'>");
					print("<tr>");	
						print( "<td>" );
							print( "<span class='form_elements_section_subheader'>&nbsp;&nbsp;Presentations/Projects per page </span>" );
							print( "&nbsp;<input class='form_elements_edit' type='text' id='ppl_pres_proj_recs' name='ppl_pres_proj_recs' size='2' value='$ppl_pres_proj_recs'>" );
							print( "&nbsp;<input type='submit' name='ppl_pres_proj_pages_submit' value='Go' size='10'>" );
						print( "</td>" );
						print( "<td align='right'>" );
							for( $i=1; $i<=$ppl_pres_proj_max_pages; $i++ )
							{
								if( $i != $ppl_pres_proj_page )
								{
									print( "<a href='#' onclick='set_field(\"ppl_pres_proj_page\", \"$i\"); submit_box( \"ppl_presentation_project\", \"pages\");' >" );
									print( "<span class='form_elements_text'>$i</span>" );
									print( "</a>&nbsp;" );
								}
								else
								{
									print( "<span class='form_elements_section_subheader'>$i &nbsp;</span>" );
								}
							}	
						print( "</td>" );
					print("</tr>");
				print("</table>");
				print( "</form>" );
				print("</td>");
			print("</tr>");
		}
			
		//Print table header row
		if (mysql_num_rows($ppl_presentation_project_results) > 0) {
			print("<tr class='table_background_other'>");
				if( $ppl_pres_proj_s_date_sort_order == "desc" ) $next_s_date_sort_order = "asc";
				else $next_s_date_sort_order = "desc";
				if( $ppl_pres_proj_e_date_sort_order == "desc" ) $next_e_date_sort_order = "asc";
				else $next_e_date_sort_order = "desc";
				
				print("<td width=\"7%\" align=\"center\"><span class='form_elements_text'><a href='#' onclick='set_field(\"ppl_pres_proj_curr_sort_field\", \"s_date\"); set_field(\"ppl_pres_proj_s_date_sort_order\", \"$next_s_date_sort_order\"); document.getElementById(\"ppl_presentation_project_pages_form\").submit();' >Start Date</a></span></td>");
				print("<td width=\"7%\" align=\"center\"><span class='form_elements_text'><a href='#' onclick='set_field(\"ppl_pres_proj_curr_sort_field\", \"e_date\"); set_field(\"ppl_pres_proj_e_date_sort_order\", \"$next_e_date_sort_order\"); document.getElementById(\"ppl_presentation_project_pages_form\").submit();' >End Date</a></span></td>");
				if( $editable == true ) {
					print("<td width=\"66%\"align=\"center\"><span class='form_elements_text'>Presentation/Project</span></td>");
					print("<td width=\"20%\"></td>");
				}
				else
					print("<td width=\"86%\"align=\"center\"><span class='form_elements_text'>Presentation/Project</span></td>");
			print("</tr>");
		}
		//Print presentations/projects
		while( $ppl_presentation_project_rows = mysql_fetch_array( $ppl_presentation_project_results ) )
		{
			
			$ppl_presentation_project_rows_itr ++;
			$pr_id = $ppl_presentation_project_rows["pr_id"];	
			print( "<tr id='ppl_presentation_project_" . $ppl_presentation_project_rows_itr . "_view_row' class='visiblerow'>" );
				if( $editable == true )
				{
					print( "<form id='ppl_presentation_project_" . $ppl_presentation_project_rows_itr . "_delete_form' method='post' action='sections/ppl_presentation_project_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='pr_id' value='$pr_id' />" );
					print( "<input type='hidden' name='ppl_presentation_project_image_id' value='" . $ppl_presentation_project_rows["image_id"] . "' />" );						
					print( "</form>" );
				}
				if( $ppl_presentation_project_rows["status"] == 0 )
					$span = "<span class='form_elements_text'>";
				else
					$span = "<span class='form_elements_text_disabled'>";
				//Print start date
				print("<td align=\"center\">");
					print($span.htmlspecialchars($ppl_presentation_project_rows["s_date"], ENT_QUOTES)."&nbsp;</span>");
				print("</td>");
				//Print end date
				print("<td align=\"center\">");
					print($span.htmlspecialchars($ppl_presentation_project_rows["e_date"], ENT_QUOTES)."&nbsp;</span>");
				print("</td>");
				//Print other presentation/project information
				print("<td>");	
					print($span);
						//Print name
						if ($ppl_presentation_project_rows["name"] != "") {
							print("<b>".htmlspecialchars($ppl_presentation_project_rows["name"], ENT_QUOTES)."</b>");
							if ($ppl_presentation_project_rows["url"] != "")
								print(" | ");
						}
						//Print web link
						if ($ppl_presentation_project_rows["url"] != "") {
							print("<a href=\"".htmlspecialchars($ppl_presentation_project_rows["url"], ENT_QUOTES)."\">");
							if ($ppl_presentation_project_rows["url_name"] != "") 
								print(htmlspecialchars($ppl_presentation_project_rows["url_name"], ENT_QUOTES));
							else
								print("Read More...");
							print("</a>");
						}
						print("<br />");
						//Print description
						print(real_rte_specialchars($ppl_presentation_project_rows["description"], ENT_QUOTES));
					print("</span>");
				print("</td>");
				//Print editing tools
				if( $editable == true )
				{
					print("<td align=\"right\">");
					print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_presentation_project\", \"$ppl_presentation_project_rows_itr\", \"delete\" )'><img border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ppl_presentation_project\", \"$ppl_presentation_project_rows_itr\" )'><img border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );
					print("</td>");	
				}			
			print( "</tr>" );
			if( $editable == true )
			{	
				print( "<tr id='ppl_presentation_project_" . $ppl_presentation_project_rows_itr . "_edit_row' class='hiddenrow'>" );
					print( "<form enctype='multipart/form-data' id='ppl_presentation_project_" . $ppl_presentation_project_rows_itr . "_edit_form' method='post' action='sections/ppl_presentation_project_edit_row_submit.php' >" );
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<input type='hidden' name='pr_id' value='$pr_id' />" );
						print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
						print( "<input type='hidden' name='ppl_presentation_project_image_id' value='" . $ppl_presentation_project_rows["image_id"] . "' />" );
						print( "<span class='form_elements_text'>" );
							print("<td width=\"7%\" align=\"center\">");
								print( "<input class='form_elements_edit' type='text' name='ppl_presentation_project_s_date' value='". htmlspecialchars( $ppl_presentation_project_rows["s_date"], ENT_QUOTES).  "' maxlength='16' size='6'>" );
							print("</td>");
							print("<td width=\"7%\" align=\"center\">");
								print( "<input class='form_elements_edit' type='text' name='ppl_presentation_project_e_date' value='". htmlspecialchars($ppl_presentation_project_rows["e_date"], ENT_QUOTES).  "' maxlength='16' size='6'>" );
							print("</td>");
							print("<td width=\"60%\">");
								print("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:&nbsp;&nbsp;");
								print("<input class='form_elements_edit' type='text' name='ppl_presentation_project_name' value='". htmlspecialchars( $ppl_presentation_project_rows["name"], ENT_QUOTES).  "' maxlength='255' size='103'>");
								print("<br /><br />");
								print("URL Name:&nbsp;&nbsp;");
								print( "<input class='form_elements_edit' type='text' name='ppl_presentation_project_url_name' value='". htmlspecialchars( $ppl_presentation_project_rows["url_name"], ENT_QUOTES).  "' maxlength='255' size='22'>" );
								print("&nbsp;&nbsp;");
								print( "URL:&nbsp;&nbsp;" );
								print( "<input class='form_elements_edit' type='text' name='ppl_presentation_project_url' value='". htmlspecialchars( $ppl_presentation_project_rows["url"], ENT_QUOTES).  "' maxlength='255' size='68'>" );
								print("<br /><br />");
								print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
								print( "writeRichText('ppl_presentation_project_description_" . $ppl_presentation_project_rows_itr . "', 'ppl_presentation_project_description', '" . real_rte_specialchars( $ppl_presentation_project_rows["description"] ) . "', 600, 150, true, false, true);" );
								print( "</script>" );
							print("</td>");
							print("<td width=\"20%\" align=\"right\">");
								$checkboxvalue = $ppl_presentation_project_rows[ "status" ] == 1 ? "checked" : "" ;
								print( "<input type='checkbox' name='ppl_presentation_project_status' $checkboxvalue><span class='form_elements_row_action'>Hide</span>&nbsp;&nbsp;" );
								print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ppl_presentation_project_description_" . $ppl_presentation_project_rows_itr . "\" ); return submit_row( \"ppl_presentation_project\", \"$ppl_presentation_project_rows_itr\", \"edit\" )'><img border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
								print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ppl_presentation_project\", \"$ppl_presentation_project_rows_itr\" )'><img border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
							print("</td>");
						print("</span>");
					print("</form>");
				print("</tr>");
			}
		}
	print( "<tr><td colspan='4' height='10'></td></tr>" );
	print( "</table>" );
}	
?>