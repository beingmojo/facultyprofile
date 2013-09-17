<?php
$ctr_publication_num_rows = mysql_num_rows( $ctr_publication_results );
if($ctr_publication_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_publication_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
//			if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ctr_publication_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ctr_publication\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ctr_publication_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ctr_publication\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Publications</span></td>" );
			print( "<form name='ctr_publication_delete_form' id='ctr_publication_delete_form' method='post' action='sections/ctr_publication_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
				
				print( "<a href='{$_home}/help/index.php#recen_publications' target='_blank' style='text-decoration:none' ><img alt='Help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ctr_publication\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ctr_publication\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );


	if( $editable == true )
	{
		$ctr_publication_max_id_rows = mysql_fetch_row( $ctr_publication_max_id_results );
		$max_pub_id = $ctr_publication_max_id_rows[0];
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ctr_publication_add_box' class='hiddenbox'>" );

		print( "<form id='ctr_publication_add_form' method='post' action='sections/ctr_publication_add_box_submit.php' >" );
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='view' value='$view' />" );
		print( "<input type='hidden' name='max_pub_id' value='$max_pub_id' />" );
			print( "<tr class='table_background_other'>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Year</span></td>" );
				print( "<td align='center'><span class='form_elements_text'>Publication</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>Category</span></td>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Rank</span></td>" );
				print( "<td width='10%' align='center'><span class='form_elements_text'>Hide</span></td>" );
				print( "<td width='15%' align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='updateRTE(\"ctr_publication_name1\"); updateRTE(\"ctr_publication_name2\"); updateRTE(\"ctr_publication_name3\"); return submit_box( \"ctr_publication\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ctr_publication\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ctr_publication_year1' value='' maxlength='16' size='3'></td>" );
				print( "<td align='center'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "writeRichText('ctr_publication_name1', 'ctr_publication_name1', '', 250, 50, true, false, false);" );
				print( "</script>" );
				
//				print( "<textarea class='form_elements_text' name='ctr_publication_name1' cols='50' rows='3'></textarea>" );
//				print( "<BR>URL &nbsp; <input class='form_elements_text' type='text' name='ctr_publication_url1' value='' maxlength='32' size='42' >" );
				print( "</td>" );
				
				print( "<td align='center'>" );
				print( "<select class='form_elements_edit_combo' name='ctr_publication_category1' style='width:100px'>" );
				if( mysql_num_rows( $ctr_publication_category_results ) > 0 )
					mysql_data_seek( $ctr_publication_category_results, 0 );
				print( "<option value='' >" );
				while( $ctr_publication_category_rows = mysql_fetch_array( $ctr_publication_category_results ) )
				{
					if( $ctr_publication_category_rows["group_by"] != '' )
						print( "<option value='". htmlspecialchars( $ctr_publication_category_rows["group_by"], ENT_QUOTES ) ."'  >" . htmlspecialchars( $ctr_publication_category_rows["group_by"]) );
				}

				print( "</select>" );
				
				print( "<BR><input class='form_elements_edit' type='text' name='ctr_publication_group_by1' value='' maxlength='32' style='width:100px'></td>" );
				print( "<td align='center'><select class='form_elements_edit_combo' name='ctr_publication_ranking1' style='width:10mm' >" );
				for( $i=10; $i>=1; $i-- )
				{
					print( "<option value='$i'> $i " );
				}
				print ( "</select>" );
				print("</td>" );
				print( "<td align='center'><input type='checkbox' name='ctr_publication_status1' >" );
				print( "<td >&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td  align='center'>&nbsp;<input class='form_elements_edit'type='text' name='ctr_publication_year2' value='' maxlength='16' size='3'></td>" );
				print( "<td align='center'>" );

				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "writeRichText('ctr_publication_name2', 'ctr_publication_name2', '', 250, 50, true, false, false);" );
				print( "</script>" );
				
//				print( "<textarea class='form_elements_text' name='ctr_publication_name2' cols='50' rows='3'></textarea>" );
//				print( "<BR>URL &nbsp; <input class='form_elements_text' type='text' name='ctr_publication_url2' value='' maxlength='32' size='42' >" );
				print( "</td>" );
				
				print( "<td align='center'>" );
				print( "<select class='form_elements_edit_combo' name='ctr_publication_category2' style='width:100px'>" );
				if( mysql_num_rows( $ctr_publication_category_results ) > 0 )
					mysql_data_seek( $ctr_publication_category_results, 0 );
				print( "<option value='' >" );
				while( $ctr_publication_category_rows = mysql_fetch_array( $ctr_publication_category_results ) )
				{
					if( $ctr_publication_category_rows["group_by"] != '' )
						print( "<option value='". htmlspecialchars( $ctr_publication_category_rows["group_by"], ENT_QUOTES ) ."'  >" . htmlspecialchars( $ctr_publication_category_rows["group_by"]) );
				}
				print( "</select>" );
				
				print( "<BR><input class='form_elements_edit' type='text' name='ctr_publication_group_by2' value='' maxlength='32' style='width:100px'></td>" );
				print( "<td align='center'><select class='form_elements_edit_combo' name='ctr_publication_ranking2' style='width:10mm' >" );
				for( $i=10; $i>=1; $i-- )
				{
					print( "<option value='$i'> $i " );
				}
				print( "</select>" );
				print("</td>" );
				print( "<td align='center'><input type='checkbox' name='ctr_publication_status2' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td  align='center'>&nbsp;<input class='form_elements_edit'type='text' name='ctr_publication_year3' value='' maxlength='16' size='3'></td>" );
				print( "<td align='center'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "writeRichText('ctr_publication_name3', 'ctr_publication_name3', '', 250, 50, true, false, false);" );
				print( "</script>" );

//				print( "<textarea class='form_elements_text' name='ctr_publication_name3' cols='50' rows='3'></textarea>" );
//				print( "<BR>URL &nbsp; <input class='form_elements_text' type='text' name='ctr_publication_url3' value='' maxlength='32' size='42' >" );
				print( "</td>" );
				
				print( "<td align='center'>" );
				print( "<select class='form_elements_edit_combo' name='ctr_publication_category3' style='width:100px'>" );
				if( mysql_num_rows( $ctr_publication_category_results ) > 0 )
					mysql_data_seek( $ctr_publication_category_results, 0 );
				print( "<option value='' >" );
				while( $ctr_publication_category_rows = mysql_fetch_array( $ctr_publication_category_results ) )
				{
					if( $ctr_publication_category_rows["group_by"] != '' )
						print( "<option value='". htmlspecialchars( $ctr_publication_category_rows["group_by"], ENT_QUOTES ) ."'  >" . htmlspecialchars( $ctr_publication_category_rows["group_by"]) );
				}
				print( "</select>" );
				
				print( "<BR><input class='form_elements_edit' type='text' name='ctr_publication_group_by3' value='' maxlength='32' style='width:100px'></td>" );
				print( "<td align='center'><select class='form_elements_edit_combo' name='ctr_publication_ranking3' style='width:10mm' >" );
				for( $i=10; $i>=1; $i-- )
				{
					print( "<option value='$i'> $i " );
				}
				print( "</select>" );
				print("</td>" );
				print( "<td  align='center'><input type='checkbox' name='ctr_publication_status3' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='6' align='right'>" );
				print( "</td>" );				
			print( "</tr>" );
		print( "</form>" );
		print( "</table>" );
	}
	
	print( "<table width='100%'  border='1' cellspacing='0' cellpadding='0' id='ctr_publication_view_box' class='visiblebox'>" );
		if( $ctr_publication_num_rows > 0 )
		{
			print( "<tr>" );
				print( "<td colspan='6'>" );
				print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
					print( "<form id = 'ctr_publication_sort_form' method='get' action='editprofile.php#$section_id' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='ppl_pub_year_sort_order' id='ppl_pub_year_sort_order' value='$ppl_pub_year_sort_order' >" );
					print( "<input type='hidden' name='ppl_pub_rank_sort_order' id='ppl_pub_rank_sort_order' value='$ppl_pub_rank_sort_order' >" );
					print( "<input type='hidden' name='ppl_pub_curr_sort_field' id='ppl_pub_curr_sort_field' value='$ppl_pub_curr_sort_field' >" );
					print( "</form>" );
					print( "<tr>" );
						print( "<form id = 'ctr_publication_pages_form' method='get' action='editprofile.php#$section_id' >" );
						print( "<input type='hidden' name='pid' value='$pid' >" );
						print( "<input type='hidden' name='view' value='$view' >" );
						print( "<input type='hidden' name='onlyview' value='". $_GET["onlyview"] ."' >" );
						print( "<input type='hidden' name='section_id' value='$section_id' >" );
						print( "<input type='hidden' name='ppl_pub_year_sort_order' id='ppl_pub_year_sort_order' value='$ppl_pub_year_sort_order' >" );
						print( "<input type='hidden' name='ppl_pub_rank_sort_order' id='ppl_pub_rank_sort_order' value='$ppl_pub_rank_sort_order' >" );
						print( "<input type='hidden' name='ppl_pub_curr_sort_field' id='ppl_pub_curr_sort_field' value='$ppl_pub_curr_sort_field' >" );
						print( "<input type='hidden' name='ppl_pub_page' id='ppl_pub_page' value='$ppl_pub_page' >" );
						

						print( "<td>" );
							print( "&nbsp; <span class='form_elements_section_subheader'>Category </span>" );
							print( "&nbsp;<select class='form_elements_edit_combo' name='ppl_pub_category' >" );
							print( "<option value='' >All" );
							if( mysql_num_rows( $ctr_publication_category_results ) > 0 )
								mysql_data_seek( $ctr_publication_category_results, 0 );
							while( $ctr_publication_category_rows = mysql_fetch_array( $ctr_publication_category_results ) )
							{
								if( $ctr_publication_category_rows["group_by"] != '' )
								{
									print( "<option value='". htmlspecialchars($ctr_publication_category_rows["group_by"], ENT_QUOTES) ."' ");
									if( $ppl_pub_category == $ctr_publication_category_rows["group_by"] )
										print( " selected " );
									print( " >" . htmlspecialchars($ctr_publication_category_rows["group_by"]) );
								}
							}
							print( "</select>" );
							print( "&nbsp; &nbsp; &nbsp; <span class='form_elements_section_subheader'>Publications per page </span>" );
							print( "&nbsp;<input class='form_elements_edit' type='text' id='ppl_pub_recs' name='ppl_pub_recs' size='2' value='$ppl_pub_recs'>" );
							print( "&nbsp;<input type='submit' name='ppl_pub_pages_submit' value='Go' size='10'>" );
						print( "</td>" );
						print( "<td align='right'>" );
							for( $i=1; $i<=$ppl_pub_max_pages; $i++ )
							{
								if( $i != $ppl_pub_page )
								{
									print( "<a href='#' onclick='set_field(\"ppl_pub_page\", \"$i\"); submit_box( \"ctr_publication\", \"pages\");' >" );
									print( "<span class='form_elements_text'>$i</span>" );
									print( "</a>&nbsp;" );
								}
								else
								{
									print( "<span class='form_elements_section_subheader'>$i &nbsp;</span>" );
								}
							}	
						print( "</td>" );
						print( "</form>" );
					print( "</tr>" );
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr class='table_background_other'>" );
				if( $ppl_pub_year_sort_order == "desc" ) $next_sort_order = "asc";
				else $next_sort_order = "desc";
					
				print( "<td width='10%' align='center'>&nbsp; <span class='form_elements_text'><a href='#' onclick='set_field(\"ppl_pub_curr_sort_field\", \"year\"); set_field(\"ppl_pub_year_sort_order\", \"$next_sort_order\"); document.getElementById(\"ctr_publication_sort_form\").submit();' >Year</a></span></td>" );

				if( $ppl_pub_rank_sort_order == "desc" ) $next_sort_order = "asc";
				else $next_sort_order = "desc";

				print( "<td align='center'><span class='form_elements_text'>Publication</span></td>" );
				print( "<td width='15%' align='center'><span class='form_elements_text'>Category</span></td>" );

/*						
				print( "<td width='10%' align='center'>
					<a href='#' onclick='
						set_field(\"ppl_pub_curr_sort_field\", \"rank\"); 
						set_field(\"ppl_pub_rank_sort_order\", \"$next_sort_order\"); 
						document.getElementById(\"ctr_publication_sort_form\").submit()' ><span class='form_elements_text'>Rank</span></a></td>" );
*/		

				
				if( $editable == true )
				{
					print( "<td width='25%'>&nbsp;</td>" );
				}

			print( "</tr>" );
		}
		if( $ctr_publication_num_rows > 0 )
			mysql_data_seek( $ctr_publication_results, 0 );
		$ctr_publication_rows_itr = 0;
		while( $ctr_publication_rows = mysql_fetch_array( $ctr_publication_results ) )
		{
			
			$ctr_publication_rows_itr ++;
			$pub_id = $ctr_publication_rows["pub_id"];
			print( "<tr id='ctr_publication_" . $ctr_publication_rows_itr . "_view_row' class='visiblerow'>" );
			
			if( $ctr_publication_rows["status"] == 0 )
				$span = "<span class='form_elements_text'>";
			else
				$span = "<span class='form_elements_text_disabled'>";

				if( $ctr_publication_rows["status"] == 0 || $editable == true )
				{
					print( "<td align='center'>$span". ($ctr_publication_rows["year"] == "" ? "&nbsp;" : htmlspecialchars($ctr_publication_rows["year"], ENT_QUOTES) ). "</span></td>" );
					print( "<td >" );
					print( "<table>" );
						print( "<tr>" );
							print( "<td>" );
							print( "$span". ($ctr_publication_rows["name"] =="" ? "&nbsp;" : real_rte_specialchars($ctr_publication_rows["name"]) ). "</span>" );
//							if( $ctr_publication_rows["url"] != "" )
//								print( "&nbsp;&nbsp;<a href= '" . htmlspecialchars($ctr_publication_rows["url"], ENT_QUOTES) . "' target='_blank'><img src = 'images/buttons/view.png' border='0' valign='bottom'></a>" );
							print( "</td>" );
						print( "</tr>" );
					print( "</table>" );
					print( "</td>" );
					print( "<td align='center'>$span". ($ctr_publication_rows["group_by"] =="" ? "&nbsp;" : htmlspecialchars($ctr_publication_rows["group_by"], ENT_QUOTES) ). "</span></td>" );
/*
					print( "<td align='center'>$span". htmlspecialchars($ctr_publication_rows["ranking"]).  "</span></td>" );
*/
					if( $editable == true )
					{
						print( "<form id='ctr_publication_" . $ctr_publication_rows_itr . "_delete_form' method='post' action='sections/ctr_publication_delete_row_submit.php' >" );
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<input type='hidden' name='pub_id' value='$pub_id' />" );
						print( "</form>" );
						print( "<td align='right' > <a href='#' style='text-decoration:none' onclick='return submit_row( \"ctr_publication\", \"$ctr_publication_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
						print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ctr_publication\", \"$ctr_publication_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a></td>" );
					}
				}
			print( "</tr>" );
			if( $editable == true )
			{
				print( "<tr id='ctr_publication_" . $ctr_publication_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<form id='ctr_publication_" . $ctr_publication_rows_itr . "_edit_form' method='post' action='sections/ctr_publication_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='pub_id' value='$pub_id' />" );
					print( "<td align='center'>&nbsp;<input class='form_elements_edit'type='text' name='ctr_publication_year' value='". htmlspecialchars( $ctr_publication_rows["year"], ENT_QUOTES). "' maxlength='16' size='3'></td>" );
					print( "<td align='center'>" );

					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
					print( "writeRichText( 'ctr_publication_name_" . $ctr_publication_rows_itr . "', 'ctr_publication_name', '" . real_rte_specialchars( $ctr_publication_rows["name"] ) . "', 350, 50, true, false, false);" );
					print( "</script>" );
					
//					print( "<textarea class='form_elements_text' name='ctr_publication_name' cols='60' rows='3'>" . htmlspecialchars($ctr_publication_rows["name"], ENT_QUOTES). "</textarea>" );
//					print( "<BR>URL &nbsp; <input class='form_elements_text' type='text' name='ctr_publication_url' value='" . htmlspecialchars($ctr_publication_rows["url"], ENT_QUOTES) ."' maxlength='32' size='52' >" );
					print( "</td>" );
					
					print( "<td align='center'>" );
					print( "<select class='form_elements_edit_combo' name='ctr_publication_category' style='width:100px'>" );
					if( mysql_num_rows( $ctr_publication_category_results ) > 0 )
						mysql_data_seek( $ctr_publication_category_results, 0 );
					print( "<option value='' >" );
					while( $ctr_publication_category_rows = mysql_fetch_array( $ctr_publication_category_results ) )
					{
						if( $ctr_publication_category_rows["group_by"] != '' )
						{
							print( "<option value='". htmlspecialchars( $ctr_publication_category_rows["group_by"], ENT_QUOTES) ."' ");
							if( $ctr_publication_rows["group_by"] == $ctr_publication_category_rows["group_by"] )
								print( " selected " );
							print( " >" . htmlspecialchars($ctr_publication_category_rows["group_by"], ENT_QUOTES) );
						}
					}
					print( "</select>" );
					
					print( "<BR><input class='form_elements_edit' type='text' name='ctr_publication_group_by' value='' maxlength='32' style='width:100px'></td>" );


					if( $ctr_publication_rows[ "status" ] == 0 )
						$checkboxvalue = "";
					else
						$checkboxvalue = "checked";					
					print( "<td align='right'>" );

					print( "<select class='form_elements_edit_combo' name='ctr_publication_ranking' style='width:10mm' >" );
					for( $i=10; $i>=1; $i-- )
					{
						print( "<option value='$i' " );
						if( $i == htmlspecialchars( $ctr_publication_rows["ranking"], ENT_QUOTES) )
							print( " selected " );
						print( "> $i " );
					}
					print( "</select>" );
					print( "<input type='checkbox' name='ctr_publication_status' $checkboxvalue><span class='form_elements_edit'> Hide &nbsp;</span>" );
					

					print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ctr_publication_name_" . $ctr_publication_rows_itr . "\" ); return submit_row( \"ctr_publication\", \"$ctr_publication_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ctr_publication\", \"$ctr_publication_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</form>" );
				print( "</tr>" );
			}
		}
	print( "<tr><td colspan='6' height='10'></td></tr>" );
	print( "</table>" );
}	
?>
