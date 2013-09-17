<?php
$ppl_publication_num_rows = mysql_num_rows( $ppl_publication_results );
if($ppl_publication_num_rows != 0 || $editable==true)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_publication_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
//			if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ppl_publication_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ppl_publication\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ppl_publication_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ppl_publication\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;Publications</span></td>" );
			print( "<form name='ppl_publication_delete_form' id='ppl_publication_delete_form' method='post' action='sections/ppl_publication_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{
				print( "<a href='{$_home}/help/index.php#facul_pub' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_publication\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ppl_publication\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );


	if( $editable == true )
	{
		$ppl_publication_max_id_rows = mysql_fetch_row( $ppl_publication_max_id_results );
		$max_pub_id = $ppl_publication_max_id_rows[0];
		print( "<table width='100%'  border='1' cellspacing='0' cellpadding='0' id='ppl_publication_add_box' class='hiddenbox'>" );

		print( "<form id='ppl_publication_add_form' method='post' action='sections/ppl_publication_add_box_submit.php' >" );
		print( "<input type='hidden' name='clicked' value='0' />" );
		print( "<input type='hidden' name='pid' value='$pid' />" );
		print( "<input type='hidden' name='section_id' value='$section_id' />" );
		print( "<input type='hidden' name='view' value='$view' />" );
		print( "<input type='hidden' name='max_pub_id' value='$max_pub_id' />" );
			print( "<tr class='table_background_other'>" );
				print( "<td align='center'><span class='form_elements_text'>Year</span></td>" );
				print( "<td align='center'><span class='form_elements_text'>Publication</span></td>" );
				//print( "<td align='center'><span class='form_elements_text'>Category</span></td>" );
				print( "<td align='center' colspan='2'><span class='form_elements_text'>Type</span></td>" );
				print( "<td align='center'><span class='form_elements_text'>Status</span></td>" );
				print( "<td align='center'><span class='form_elements_text'>Rank</span></td>" );
				print( "<td align='center'><span class='form_elements_text'>Hide</span></td>" );
				print( "<td align='right'>" );
				print( "<a href='#' style='text-decoration:none' onclick='updateRTE(\"ppl_publication_name1\"); updateRTE(\"ppl_publication_name2\"); updateRTE(\"ppl_publication_name3\"); return submit_box( \"ppl_publication\", \"add\" )'><img border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ppl_publication\" )'><img border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td align='center'><input class='form_elements_edit'type='text' name='ppl_publication_year1' value='' maxlength='16' size='3'></td>" );
				print( "<td align='center'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "writeRichText('ppl_publication_name1', 'ppl_publication_name1', '', 250, 50, true, false, false);" );
				print( "</script>" );
				
//				print( "<textarea class='form_elements_text' name='ppl_publication_name1' cols='50' rows='3'></textarea>" );
//				print( "<BR>URL &nbsp; <input class='form_elements_text' type='text' name='ppl_publication_url1' value='' maxlength='32' size='42' >" );
				print( "</td>" );
				
				/*print( "<td align='center'>" );
				print( "<select class='form_elements_edit_combo' name='ppl_publication_category1' style='width:100px'>" );
				if( mysql_num_rows( $ppl_publication_category_results ) > 0 )
					mysql_data_seek( $ppl_publication_category_results, 0 );
				print( "<option value='1' >" );
				while( $ppl_publication_category_rows = mysql_fetch_array( $ppl_publication_category_results ) )
				{
					if( $ppl_publication_category_rows["group_by"] != '' )
						print( "<option value='". htmlspecialchars( real_mysql_specialchars($ppl_publication_category_rows["group_by"], false), ENT_QUOTES ) ."'  >" . htmlspecialchars( real_mysql_specialchars($ppl_publication_category_rows["group_by"], false), ENT_QUOTES ) );
				}

				print( "</select>" );
				
				print( "<BR><input class='form_elements_edit' type='text' name='ppl_publication_group_by1' value='' maxlength='32' style='width:100px'></td>" );
                                 
				*/
				print( "<td align='center' colspan='2'>");
				print("<select class='form_elements_edit_combo' name='ppl_publication_type_id1'>");	
				$publicationTypeSql = "SELECT * FROM ppl_publication_types ORDER BY type_id ASC";
				$publicationTypeQuery = real_execute_query($publicationTypeSql, $db_conn);
				while ($publicationTypeRow = mysql_fetch_array($publicationTypeQuery)) {
					printf("<option value=\"%d\">%s</option>",$publicationTypeRow["type_id"],$publicationTypeRow["type"]);
				}
				print("</select>");
				print( "</td>"); 
				print( "<td align='left'>");
				$publicationPubStatusSql = "SELECT * FROM ppl_publication_pub_status ORDER BY pub_status_id ASC";
				$publicationPubStatusQuery = real_execute_query($publicationPubStatusSql, $db_conn);
				$publicationPubStatusRow = mysql_fetch_array($publicationPubStatusQuery);
				printf("<input class='form_elements_edit_combo' type='radio' name='ppl_publication_pub_status_id1' value=\"%d\" checked=\"checked\"/>%s<br />",$publicationPubStatusRow["pub_status_id"],$publicationPubStatusRow["pub_status"]);
				while ($publicationPubStatusRow = mysql_fetch_array($publicationPubStatusQuery)) {
					printf("<input class='form_elements_edit_combo' type='radio' name='ppl_publication_pub_status_id1' value=\"%d\" />%s<br />",$publicationPubStatusRow["pub_status_id"],$publicationPubStatusRow["pub_status"]);
				}
				print( "</td>"); 
				
				print( "<td align='center'><select class='form_elements_edit_combo' name='ppl_publication_ranking1' style='width:10mm' >" );
				for( $i=10; $i>=1; $i-- )
				{
					print( "<option value='$i'> $i " );
				}
				print ( "</select>" );
				print("</td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_publication_status1' >" );
				print( "<td >&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td  align='center'>&nbsp;<input class='form_elements_edit'type='text' name='ppl_publication_year2' value='' maxlength='16' size='3'></td>" );
				print( "<td align='center'>" );

				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "writeRichText('ppl_publication_name2', 'ppl_publication_name2', '', 250, 50, true, false, false);" );
				print( "</script>" );
				
//				print( "<textarea class='form_elements_text' name='ppl_publication_name2' cols='50' rows='3'></textarea>" );
//				print( "<BR>URL &nbsp; <input class='form_elements_text' type='text' name='ppl_publication_url2' value='' maxlength='32' size='42' >" );
				print( "</td>" );
				
				/*print( "<td align='center'>" );
				print( "<select class='form_elements_edit_combo' name='ppl_publication_category2' style='width:100px'>" );
				if( mysql_num_rows( $ppl_publication_category_results ) > 0 )
					mysql_data_seek( $ppl_publication_category_results, 0 );
				print( "<option value='2' >" );
				while( $ppl_publication_category_rows = mysql_fetch_array( $ppl_publication_category_results ) )
				{
					if( $ppl_publication_category_rows["group_by"] != '' )
						print( "<option value='". htmlspecialchars( $ppl_publication_category_rows["group_by"], ENT_QUOTES ) ."'  >" . htmlspecialchars( $ppl_publication_category_rows["group_by"], ENT_QUOTES ) );
				}
				print( "</select>" );
				
				print( "<BR><input class='form_elements_edit' type='text' name='ppl_publication_group_by2' value='' maxlength='32' style='width:100px'></td>" );
				*/
				print( "<td align='center' colspan='2'>");
				print("<select class='form_elements_edit_combo' name='ppl_publication_type_id2'>");	
				$publicationTypeSql = "SELECT * FROM ppl_publication_types ORDER BY type_id ASC";
				$publicationTypeQuery = real_execute_query($publicationTypeSql, $db_conn);
				while ($publicationTypeRow = mysql_fetch_array($publicationTypeQuery)) {
					printf("<option value=\"%d\">%s</option>",$publicationTypeRow["type_id"],$publicationTypeRow["type"]);
				}
				print("</select>");
                                print( "</td>");
				print( "<td align='left'>");
				$publicationPubStatusSql = "SELECT * FROM ppl_publication_pub_status ORDER BY pub_status_id ASC";
				$publicationPubStatusQuery = real_execute_query($publicationPubStatusSql, $db_conn);
				$publicationPubStatusRow = mysql_fetch_array($publicationPubStatusQuery);
				printf("<input class='form_elements_edit_combo' type='radio' name='ppl_publication_pub_status_id2' value=\"%d\" checked=\"checked\"/>%s<br />",$publicationPubStatusRow["pub_status_id"],$publicationPubStatusRow["pub_status"]);
				while ($publicationPubStatusRow = mysql_fetch_array($publicationPubStatusQuery)) {
					printf("<input class='form_elements_edit_combo' type='radio' name='ppl_publication_pub_status_id2' value=\"%d\" />%s<br />",$publicationPubStatusRow["pub_status_id"],$publicationPubStatusRow["pub_status"]);
				}
				print( "</td>");
				
				print( "<td align='center'><select class='form_elements_edit_combo' name='ppl_publication_ranking2' style='width:10mm' >" );
				for( $i=10; $i>=1; $i-- )
				{
					print( "<option value='$i'> $i " );
				}
				print( "</select>" );
				print("</td>" );
				print( "<td align='center'><input type='checkbox' name='ppl_publication_status2' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td  align='center'>&nbsp;<input class='form_elements_edit'type='text' name='ppl_publication_year3' value='' maxlength='16' size='3'></td>" );
				print( "<td align='center'>" );
				print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
				print( "writeRichText('ppl_publication_name3', 'ppl_publication_name3', '', 250, 50, true, false, false);" );
				print( "</script>" );

//				print( "<textarea class='form_elements_text' name='ppl_publication_name3' cols='50' rows='3'></textarea>" );
//				print( "<BR>URL &nbsp; <input class='form_elements_text' type='text' name='ppl_publication_url3' value='' maxlength='32' size='42' >" );
				print( "</td>" );
				
				/*print( "<td align='center'>" );
				print( "<select class='form_elements_edit_combo' name='ppl_publication_category3' style='width:100px'>" );
				if( mysql_num_rows( $ppl_publication_category_results ) > 0 )
					mysql_data_seek( $ppl_publication_category_results, 0 );
				print( "<option value='3' >" );
				while( $ppl_publication_category_rows = mysql_fetch_array( $ppl_publication_category_results ) )
				{
					if( $ppl_publication_category_rows["group_by"] != '' )
						print( "<option value='". htmlspecialchars( $ppl_publication_category_rows["group_by"], ENT_QUOTES ) ."'  >" . htmlspecialchars( $ppl_publication_category_rows["group_by"], ENT_QUOTES ) );
				}
				print( "</select>" );
				
				print( "<BR><input class='form_elements_edit' type='text' name='ppl_publication_group_by3' value='' maxlength='32' style='width:100px'></td>" );
				
				*/
				print( "<td align='center' colspan='2'>");
				print("<select class='form_elements_edit_combo' name='ppl_publication_type_id3'>");	
				$publicationTypeSql = "SELECT * FROM ppl_publication_types ORDER BY type_id ASC";
				$publicationTypeQuery = real_execute_query($publicationTypeSql, $db_conn);
				while ($publicationTypeRow = mysql_fetch_array($publicationTypeQuery)) {
					printf("<option value=\"%d\">%s</option>",$publicationTypeRow["type_id"],$publicationTypeRow["type"]);
				}
				print("</select>");
				print( "</td>");
				print( "<td align='left'>");
				$publicationPubStatusSql = "SELECT * FROM ppl_publication_pub_status ORDER BY pub_status_id ASC";
				$publicationPubStatusQuery = real_execute_query($publicationPubStatusSql, $db_conn);
				$publicationPubStatusRow = mysql_fetch_array($publicationPubStatusQuery);
				printf("<input class='form_elements_edit_combo' type='radio' name='ppl_publication_pub_status_id3' value=\"%d\" checked=\"checked\"/>%s<br />",$publicationPubStatusRow["pub_status_id"],$publicationPubStatusRow["pub_status"]);
				while ($publicationPubStatusRow = mysql_fetch_array($publicationPubStatusQuery)) {
					printf("<input class='form_elements_edit_combo' type='radio' name='ppl_publication_pub_status_id3' value=\"%d\" />%s<br />",$publicationPubStatusRow["pub_status_id"],$publicationPubStatusRow["pub_status"]);
				}
				print( "</td>");
				
				print( "<td align='center'><select class='form_elements_edit_combo' name='ppl_publication_ranking3' style='width:10mm' >" );
				for( $i=10; $i>=1; $i-- )
				{
					print( "<option value='$i'> $i " );
				}
				print( "</select>" );
				print("</td>" );
				print( "<td  align='center'><input type='checkbox' name='ppl_publication_status3' >" );
				print( "<td>&nbsp;</td>" );
			print( "</tr>" );
			print( "<tr>" );
				print( "<td colspan='6' align='right'>" );
				print( "</td>" );				
			print( "</tr>" );
		print( "</form>" );
		print( "</table>" );
	}
	
	print( "<table width='100%'  border='1' cellspacing='0' cellpadding='0' id='ppl_publication_view_box' class='visiblebox'>" );
		if( $ppl_publication_num_rows > 0 )
		{
			print( "<tr>" );
				print( "<td colspan='6'>" );
				print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
					print( "<form id = 'ppl_publication_sort_form' method='get' action='editprofile.php#$section_id' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='ppl_pub_year_sort_order' id='ppl_pub_year_sort_order' value='$ppl_pub_year_sort_order' >" );
					print( "<input type='hidden' name='ppl_pub_rank_sort_order' id='ppl_pub_rank_sort_order' value='$ppl_pub_rank_sort_order' >" );
					print( "<input type='hidden' name='ppl_pub_type_sort_order' id='ppl_pub_type_sort_order' value='$ppl_pub_type_sort_order' >" );
					print( "<input type='hidden' name='ppl_pub_curr_sort_field' id='ppl_pub_curr_sort_field' value='$ppl_pub_curr_sort_field' >" );
					print( "</form>" );
					print( "<tr>" );
						print( "<form id = 'ppl_publication_pages_form' method='get' action='editprofile.php#$section_id' >" );
						print( "<input type='hidden' name='pid' value='$pid' >" );
						print( "<input type='hidden' name='view' value='$view' >" );
						print( "<input type='hidden' name='onlyview' value='". $_GET["onlyview"] ."' >" );
						print( "<input type='hidden' name='highlight' value='". $_GET["highlight"] ."' >" );
						print( "<input type='hidden' name='section_id' value='$section_id' >" );
						print( "<input type='hidden' name='ppl_pub_year_sort_order' id='ppl_pub_year_sort_order' value='$ppl_pub_year_sort_order' >" );
						print( "<input type='hidden' name='ppl_pub_rank_sort_order' id='ppl_pub_rank_sort_order' value='$ppl_pub_rank_sort_order' >" );
						print( "<input type='hidden' name='ppl_pub_type_sort_order' id='ppl_pub_type_sort_order' value='$ppl_pub_type_sort_order' >" );
						print( "<input type='hidden' name='ppl_pub_curr_sort_field' id='ppl_pub_curr_sort_field' value='$ppl_pub_curr_sort_field' >" );
						print( "<input type='hidden' name='ppl_pub_page' id='ppl_pub_page' value='$ppl_pub_page' >" );
						
						print( "<td colspan='2'>" );
							/*print( "&nbsp; <span class='form_elements_section_subheader'>Category </span>" );
							print( "&nbsp;<select class='form_elements_edit_combo' name='ppl_pub_category' >" );
							print( "<option value='' >All" );
							if( mysql_num_rows( $ppl_publication_category_results ) > 0 )
								mysql_data_seek( $ppl_publication_category_results, 0 );
							while( $ppl_publication_category_rows = mysql_fetch_array( $ppl_publication_category_results ) )
							{
								if( $ppl_publication_category_rows["group_by"] != '' )
								{
									print( "<option value='". $ppl_publication_category_rows["group_by"] ."' ");
									if( $ppl_pub_category == $ppl_publication_category_rows["group_by"] )
										print( " selected " );
									print( " >" . $ppl_publication_category_rows["group_by"] );
								}
							}
							print( "</select>" ); 
							//////////////////////////////////////
							//////////////////////////////////////

                                                         */
							print( "&nbsp; <span class='form_elements_section_subheader'>Type </span>" );
							print("<select class='form_elements_edit_combo' name='ppl_pub_type_id'>");	
							print( "<option value=\"\" >All</option>" );
							$publicationTypeSql = 	"SELECT DISTINCT t1.type_id, type 
													FROM ppl_publication AS t1 LEFT JOIN ppl_publication_types AS t2 USING (type_id) 
													WHERE pid='$pid' AND t1.type_id <> 0
													ORDER BY t1.type_id ASC";
							$publicationTypeQuery = real_execute_query($publicationTypeSql, $db_conn);
							while ($publicationTypeRow = mysql_fetch_array($publicationTypeQuery)) {
								if ($ppl_pub_type_id == $publicationTypeRow["type_id"])
									printf("<option selected=\"selected\" value=\"%d\">%s</option>",$publicationTypeRow["type_id"],$publicationTypeRow["type"]);
								else
									printf("<option value=\"%d\">%s</option>",$publicationTypeRow["type_id"],$publicationTypeRow["type"]);
							}
							print("</select>");	
                                                        
                                                        


                                                    	print( "&nbsp;<span class='form_elements_section_subheader'>Publications per page </span>" );
							print( "&nbsp;<input class='form_elements_edit' type='text' id='ppl_pub_recs' name='ppl_pub_recs' size='2' value='$ppl_pub_recs'>" );
							print( "&nbsp;<input type='submit' name='ppl_pub_pages_submit' value='Go' size='10'>" );

                                                     
                                                   

						print( "</td>" );
						print( "<td align='right'>" );
							if($ppl_pub_max_pages > 10) {
								if($ppl_pub_page > 1) {
									printf( "<a href=\"javascript:set_field('ppl_pub_page', '1'); submit_box( 'ppl_publication', 'pages');\" >");
									print( "<span class='form_elements_text'>&lt;&lt;1</span>" );
									print( "</a>&nbsp;" );
									$ppl_pub_prev_page = ($ppl_pub_page>11?$ppl_pub_page-10:1);
									printf( "<a href=\"javascript:set_field('ppl_pub_page', '$ppl_pub_prev_page'); submit_box( 'ppl_publication', 'pages');\" >");
									print( "<span class='form_elements_text'>&lt;&lt;Previous</span>" );
									print( "</a>&nbsp;" );
								}
								$ppl_pub_end_page = ($ppl_pub_max_pages-$ppl_pub_page>10?$ppl_pub_page+9:$ppl_pub_max_pages);
								$ppl_pub_start_page = ($ppl_pub_end_page>$ppl_pub_max_pages-10?$ppl_pub_end_page-9:$ppl_pub_page);
								for( $i=$ppl_pub_start_page; $i<=$ppl_pub_end_page; $i++ )
								{
									if( $i != $ppl_pub_page )
									{
										printf( "<a href=\"javascript:set_field('ppl_pub_page', '$i'); submit_box( 'ppl_publication', 'pages');\" >");
										print( "<span class='form_elements_text'>$i</span>" );
										print( "</a>&nbsp;" );
									}
									else
									{
										print( "<span class='form_elements_section_subheader'>$i&nbsp;</span>" );
									}
								}
								if($ppl_pub_max_pages - $ppl_pub_end_page > 1) {
									$ppl_pub_nextpage = $ppl_pub_end_page + 1;
									printf( "<a href=\"javascript:set_field('ppl_pub_page', '$ppl_pub_nextpage'); submit_box( 'ppl_publication', 'pages');\" >");
									print( "<span class='form_elements_text'>Next&gt;&gt;</span>" );
									print( "</a>&nbsp;" );
									printf( "<a href=\"javascript:set_field('ppl_pub_page', '$ppl_pub_max_pages'); submit_box( 'ppl_publication', 'pages');\" >");
									print( "<span class='form_elements_text'>$ppl_pub_max_pages&gt;&gt;</span>" );
									print( "</a>&nbsp;" );
								}
							}	
							else {
								for( $i=1; $i<=$ppl_pub_max_pages; $i++ )
								{
									if( $i != $ppl_pub_page )
									{
										printf( "<a href=\"javascript:set_field('ppl_pub_page', '$i'); submit_box( 'ppl_publication', 'pages');\" >");
										print( "<span class='form_elements_text'>$i</span>" );
										print( "</a>&nbsp;" );
									}
									else
									{
										print( "<span class='form_elements_section_subheader'>$i &nbsp;</span>" );
									}
								}
							}
						print( "</td>" );
						print( "</form>" );
                                               
					print( "</tr>" );
                                          print( "<tr> <td>" );
                      
                                          $ppl_pub_total_query = "SELECT totalPub FROM ppl_publication_total  where pid = " . real_mysql_specialchars( $pid, true );
		                                        $ppl_publication_max_id_results = real_execute_query (  $ppl_pub_total_query, $db_conn );

                                                        if (mysql_fetch_array( $ppl_publication_max_id_results))
                                                            $pubTotal= mysql_result( $ppl_publication_max_id_results, 0);
                                                        //echo "pub total value is:".$pubTotal;

                                                        $ppl_publication_max_id_query = "SELECT MAX( pub_id ) FROM ppl_publication WHERE pid = " . real_mysql_specialchars( $pid, true );
		                                        $ppl_publication_max_id_results = real_execute_query ( $ppl_publication_max_id_query, $db_conn );
                                                        if (mysql_num_rows($ppl_publication_max_id_results) > 0)
                                                            $ppl_pub_count= mysql_result($ppl_publication_max_id_results, 0);

                                          if( $editable == true )
			                       {
                                                    print( "<form id = 'ppl_publication_'  method='post' action='sections/ppl_publication_total_edit_row_submit.php' >" );
                                                      
                                                }
                                                  print( "&nbsp;<span class='form_elements_section_subheader'>Selected</span>" );
                                                  print( "<span class='form_elements_text'><b> $ppl_pub_count</b></span>" );
                                                



                                                     print( "&nbsp;<span class='form_elements_section_subheader'>publications out of </span>" );
                                                    
                                               if( $editable == true )
			                       {
                                                   print("&nbsp; <input name=\"pubTotal\" type=\"text\" class=\"form_elements_edit\" id='pubTotal' size=\"2\" value='$pubTotal'>");
                                                    print("&nbsp; <input name=\"pid\" type=\"hidden\" class=\"form_elements_edit\" id='pidPubTotal' value='$pid'>");
                                                     print( "&nbsp;<input type='submit'  value='Save' size='10' name='ppl_totalPub_submit'>" );
                                             
				//	print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ppl_publication_" . $ppl_publication_rows_itr . "\" );
                                              //  return submit_row( \"ppl_publication_\", \"$ppl_publication_rows_itr\", \"edit\" )'><img border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );


                                                     print("</form >");
                                               }
                                               else{
                                                   print("<span class='form_elements_text'><b>$pubTotal</b></span>");
                                               }
                                                //till here added
                                               
                        print( "</td></tr>" );
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );
                       
			print( "<tr class='table_background_other'>" );
				if( $ppl_pub_year_sort_order == "desc" ) $next_year_sort_order = "asc";
				else $next_year_sort_order = "desc";
					
				print( "<td width='10%' align='center'>&nbsp; <span class='form_elements_text'><a href='#' onclick='set_field(\"ppl_pub_curr_sort_field\", \"year\"); set_field(\"ppl_pub_year_sort_order\", \"$next_year_sort_order\"); document.getElementById(\"ppl_publication_sort_form\").submit();' >Year</a></span></td>" );

				if( $ppl_pub_sort_order == "desc" ) $next_sort_order = "asc";
				else $next_sort_order = "desc";

				print( "<td align='center'><span class='form_elements_text'>Publication</span></td>" );
				if( $ppl_pub_type_sort_order == "desc" ) $next_type_sort_order = "asc";
				else $next_type_sort_order = "desc";
				print( "<td width='10%' align='center'>&nbsp; <span class='form_elements_text'><a href='#' onclick='set_field(\"ppl_pub_curr_sort_field\", \"type\"); set_field(\"ppl_pub_type_sort_order\", \"$next_type_sort_order\"); document.getElementById(\"ppl_publication_sort_form\").submit();' >Type</a></span></td>" );
				//print( "<td width='15%' align='center'><span class='form_elements_text'>Type</span></td>" );

/*						
				print( "<td width='10%' align='center'>
					<a href='#' onclick='
						set_field(\"ppl_pub_curr_sort_field\", \"rank\"); 
						set_field(\"ppl_pub_rank_sort_order\", \"$next_sort_order\"); 
						document.getElementById(\"ppl_publication_sort_form\").submit()' ><span class='form_elements_text'>Rank</span></a></td>" );
*/		

				
				if( $editable == true )
				{
					print( "<td width='25%'>&nbsp;</td>" );
				}

			print( "</tr>" );
                        
		}
		if( $ppl_publication_num_rows > 0 )
			mysql_data_seek( $ppl_publication_results, 0 );
		$ppl_publication_rows_itr = 0;
		while( $ppl_publication_rows = mysql_fetch_array( $ppl_publication_results ) )
		{
			
			$ppl_publication_rows_itr ++;
			$pub_id = $ppl_publication_rows["pub_id"];
			print( "<tr id='ppl_publication_" . $ppl_publication_rows_itr . "_view_row' class='visiblerow'>" );
			
			if( $ppl_publication_rows["status"] == 0 )
				$span = "<span class='form_elements_text'>";
			else
				$span = "<span class='form_elements_text_disabled'>";

				if( $ppl_publication_rows["status"] == 0 || $editable == true )
				{
					print( "<td align='center'>$span". ($ppl_publication_rows["year"] == "" ? "&nbsp;" : htmlspecialchars($ppl_publication_rows["year"], ENT_QUOTES) ). "</span></td>" );
					print( "<td >" );
					print( "<table>" );
						print( "<tr>" );
							print( "<td>" );
							print(($ppl_publication_rows["pub_status"] =="" || $ppl_publication_rows["pub_status_id"] == 1 ? "" : "$span<b>".htmlspecialchars($ppl_publication_rows["pub_status"], ENT_QUOTES). "</b></span><br />"));
							print( "$span". ($ppl_publication_rows["name"] =="" ? "&nbsp;" : real_rte_specialchars($ppl_publication_rows["name"]) ). "</span>" );
//							if( $ppl_publication_rows["url"] != "" )
//								print( "&nbsp;&nbsp;<a href= '" . htmlspecialchars($ppl_publication_rows["url"], ENT_QUOTES) . "' target='_blank'><img src = 'images/buttons/view.png' border='0' valign='bottom'></a>" );
							print("<br />");
							print(($ppl_publication_rows["group_by"] =="" ? "" : "<b>$span Category:&nbsp;".htmlspecialchars($ppl_publication_rows["group_by"], ENT_QUOTES) ). "</b></span>");
							print( "</td>" );
						print( "</tr>" );
					print( "</table>" );
					print( "</td>" );
					print( "<td align='center'>$span". ($ppl_publication_rows["type"] =="" ? "&nbsp;" : htmlspecialchars($ppl_publication_rows["type"], ENT_QUOTES) ). "</span></td>" );
/*
					print( "<td align='center'>$span". htmlspecialchars($ppl_publication_rows["ranking"]).  "</span></td>" );
*/
					if( $editable == true )
					{
						print( "<form id='ppl_publication_" . $ppl_publication_rows_itr . "_delete_form' method='post' action='sections/ppl_publication_delete_row_submit.php' >" );
						print( "<input type='hidden' name='pid' value='$pid' />" );
						print( "<input type='hidden' name='section_id' value='$section_id' />" );
						print( "<input type='hidden' name='view' value='$view' />" );
						print( "<input type='hidden' name='pub_id' value='$pub_id' />" );
						print( "</form>" );
						print( "<td align='right' > <a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_publication\", \"$ppl_publication_rows_itr\", \"delete\" )'><img border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
						print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ppl_publication\", \"$ppl_publication_rows_itr\" )'><img border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a></td>" );
					}
				}
			print( "</tr>" );
                       
			if( $editable == true )
			{
				print( "<tr id='ppl_publication_" . $ppl_publication_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<form id='ppl_publication_" . $ppl_publication_rows_itr . "_edit_form' method='post' action='sections/ppl_publication_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='pub_id' value='$pub_id' />" );
                                     	print( "<td align='center'>&nbsp;<input class='form_elements_edit'type='text' name='ppl_publication_year' value='". htmlspecialchars( $ppl_publication_rows["year"], ENT_QUOTES). "' maxlength='16' size='3'></td>" );
					print( "<td align='left'>" );
					print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
					print( "writeRichText( 'ppl_publication_name_" . $ppl_publication_rows_itr . "', 'ppl_publication_name', '" . real_rte_specialchars( $ppl_publication_rows["name"] ) . "', 350, 50, true, false, false);" );
					print( "</script>" );
                                        /* commented for category
					print( "Category:&nbsp;<select class='form_elements_edit_combo' name='ppl_publication_category' style='width:100px'>" );
					if( mysql_num_rows( $ppl_publication_category_results ) > 0 )
						mysql_data_seek( $ppl_publication_category_results, 0 );
					print( "<option value='' >" );
					while( $ppl_publication_category_rows = mysql_fetch_array( $ppl_publication_category_results ) )
					{
						if( $ppl_publication_category_rows["group_by"] != '' )
						{
							print( "<option value='". htmlspecialchars( $ppl_publication_category_rows["group_by"], ENT_QUOTES) ."' ");
							if( $ppl_publication_rows["group_by"] == $ppl_publication_category_rows["group_by"] )
								print( " selected " );
							print( " >" . htmlspecialchars($ppl_publication_category_rows["group_by"], ENT_QUOTES) );
						}
					}
					print( "</select>" );
					print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_publication_group_by' value='' maxlength='32' style='width:100px'>" );
					print("<br />");
					*/
					print( "Rank:&nbsp;<select class='form_elements_edit_combo' name='ppl_publication_ranking' style='width:10mm' >" );
					for( $i=10; $i>=1; $i-- )
					{
						print( "<option value='$i' " );
						if( $i == htmlspecialchars( $ppl_publication_rows["ranking"], ENT_QUOTES) )
							print( " selected " );
						print( "> $i " );
					}
					print( "</select>" );
                                    	if( $ppl_publication_rows[ "status" ] == 0 )
						$checkboxvalue = "";
					else
						$checkboxvalue = "checked";	
					print( "<input type='checkbox' name='ppl_publication_status' $checkboxvalue><span class='form_elements_edit'> Hide &nbsp;</span>" );
					print( "</td>" );
					
					print( "<td align='left'>" );
						print("<select class='form_elements_edit_combo' name='ppl_publication_type_id'>");	
						$publicationTypeSql = "SELECT * FROM ppl_publication_types ORDER BY type_id ASC";
						$publicationTypeQuery = real_execute_query($publicationTypeSql, $db_conn);
						while ($publicationTypeRow = mysql_fetch_array($publicationTypeQuery)) {
							if ($ppl_publication_rows["type_id"] == $publicationTypeRow["type_id"])
								printf("<option selected=\"selected\" value=\"%d\">%s</option>",$publicationTypeRow["type_id"],$publicationTypeRow["type"]);
							else
								printf("<option value=\"%d\">%s</option>",$publicationTypeRow["type_id"],$publicationTypeRow["type"]);
						}
						print("</select>");
						print("<br />");	
						$publicationPubStatusSql = "SELECT * FROM ppl_publication_pub_status ORDER BY pub_status_id ASC";
						$publicationPubStatusQuery = real_execute_query($publicationPubStatusSql, $db_conn);
						while ($publicationPubStatusRow = mysql_fetch_array($publicationPubStatusQuery)) {
							if ($ppl_publication_rows["pub_status_id"] == $publicationPubStatusRow["pub_status_id"])
								printf("<input class='form_elements_edit_combo' type='radio' name='ppl_publication_pub_status_id' value=\"%d\" checked=\"checked\"/>%s<br />",$publicationPubStatusRow["pub_status_id"],$publicationPubStatusRow["pub_status"]);
							else
								printf("<input class='form_elements_edit_combo' type='radio' name='ppl_publication_pub_status_id' value=\"%d\" />%s<br />",$publicationPubStatusRow["pub_status_id"],$publicationPubStatusRow["pub_status"]);
						}
						
					print( "</td>" );

					print( "<td align='right'>" );
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ppl_publication_name_" . $ppl_publication_rows_itr . "\" ); return submit_row( \"ppl_publication\", \"$ppl_publication_rows_itr\", \"edit\" )'><img border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ppl_publication\", \"$ppl_publication_rows_itr\" )'><img border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</form>" );
				print( "</tr>" );
			}
		}
	print( "<tr><td colspan='6' height='10'></td></tr>" );
	print( "</table>" );
}	
?>
