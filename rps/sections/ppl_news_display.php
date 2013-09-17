<?php
$ppl_news_num_rows = mysql_num_rows( $ppl_news_results );
if($ppl_news_num_rows != 0 || $editable==true || $counter==1)
{
	$section_id = $current_sections_row[0];
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_news_header' class='visiblebox'>" );
		print( "<tr class='table_background' height='20'>" );
			//if( $editable==true)
			{
				print( "<td align='center' valign='middle' width='20px' id='ppl_news_hide_cell' class='visiblecell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return hide_box( \"ppl_news\" )'> <img alt='toggle' border='0' src='images/buttons/down-arrow.gif'></a>" );
				print( "</td>" );
				print( "<td align='center' valign='middle' width='20px' id='ppl_news_show_cell' class='hiddencell' >" );
				print( "<a href='#' style='text-decoration:none' onclick='return show_box( \"ppl_news\" )'> <img alt='toggle' border='0' src='images/buttons/right-arrow.gif'></a>" );
				print( "</td>" );
			}
			print( "<td><span class='form_elements_section_header'>&nbsp;News Articles</span></td>" );
			print( "<form name='ppl_news_delete_form' id='ppl_news_delete_form' method='post' action='sections/ppl_news_delete_box_submit.php'>" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "</form>" );
			print( "<td align='right'>" );
			if( $editable == true )
			{	
			
				print( "<a href='{$_home}/help/index.php#facul_n&a' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>" );				

				print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_news\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_section_action'>Delete&nbsp;&nbsp;</span></a>" );
				print( "<a href='#' style='text-decoration:none' onclick='return add_box( \"ppl_news\" )'><img alt='add' border='0' src='images/buttons/add.gif'  > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );
			}
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $editable == true )
	{
		print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_news_add_box' class='hiddenbox'>" );
		$ppl_news_max_id_rows = mysql_fetch_row( $ppl_news_max_id_results );
		$max_news_id = $ppl_news_max_id_rows[0];
		print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<form enctype='multipart/form-data' id='ppl_news_add_form' method='post' action='sections/ppl_news_add_box_submit.php' >" );
			print( "<input type='hidden' name='pid' value='$pid' />" );
			print( "<input type='hidden' name='section_id' value='$section_id' />" );
			print( "<input type='hidden' name='view' value='$view' />" );
			print( "<input type='hidden' name='clicked' value='0' />" );
			print( "<input type='hidden' name='max_news_id' value='$max_news_id' />" );
			print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
			print( "<td>" );
			print( "<span class='form_elements_text'>" );
			print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
				print( "<tr>" );
					print( "<td width='10%'>Title</td>" );
					print( "<td><input class='form_elements_edit' type='text' name='ppl_news_title' value='' maxlength='255' size='60'></td>" );
					print( "<td align='right'>" );							
					print( "<input type='checkbox' name='ppl_news_status'><span class='form_elements_row_action'>Hide</span>&nbsp; &nbsp;" );
					print( "<a href='#' style='text-decoration:none' onclick='updateRTE(\"ppl_news_description\"); return submit_box( \"ppl_news\", \"add\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_add_box( \"ppl_news\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
					print( "</td>" );
				print( "</tr>" );
				print( "<tr>" );
					print( "<td>WebSite</td>" );
					print( "<td colspan='2'><input class='form_elements_edit' type='text' name='ppl_news_url_name' value='' maxlength='255' size='22'>" );
					print( "&nbsp; &nbsp; URL" );
					print( "&nbsp; &nbsp; <input class='form_elements_edit' type='text' name='ppl_news_url' value='' maxlength='255' size='22'>" );
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
					print( "writeRichText( 'ppl_news_description', 'ppl_news_description', '', 500, 80, true, false, true);" );
					print( "</script>" );
					
//					print( "<textarea class='form_elements_text' name='ppl_news_description' cols='120' rows='5'></textarea>" );
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

	
	print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_news_view_box' class='visiblebox'>" );
		if( $ppl_news_num_rows > 0 )
			mysql_data_seek( $ppl_news_results, 0 );
		$ppl_news_rows_itr = 0;
		while( $ppl_news_rows = mysql_fetch_array( $ppl_news_results ) )
		{
			
			$ppl_news_rows_itr ++;
			$news_id = $ppl_news_rows["news_id"];
			print( "<tr id='ppl_news_" . $ppl_news_rows_itr . "_view_row' class='visiblerow'>" );
				print( "<td width='5'></td>" );
				if( $editable == true )
				{
					print( "<form id='ppl_news_" . $ppl_news_rows_itr . "_delete_form' method='post' action='sections/ppl_news_delete_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='news_id' value='$news_id' />" );
					print( "<input type='hidden' name='ppl_news_image_id' value='" . $ppl_news_rows["image_id"] . "' />" );						
					print( "</form>" );
				}
				if( $ppl_news_rows["status"] == 0 || $editable == true )
				{
					print( "<td>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td>" );
							if( $ppl_news_rows["status"] == 0 )
								$span = "<span class='form_elements_section_subheader'>";
							else
								$span = "<span class='form_elements_section_subheader_disabled'>";
							print( "$span". htmlspecialchars($ppl_news_rows["title"], ENT_QUOTES). "</span>" );
							print( "</td>" );
							print( "<td width='20%' align='right'>" );
							if( $editable == true )
							{
								print( "<a href='#' style='text-decoration:none' onclick='return submit_row( \"ppl_news\", \"$ppl_news_rows_itr\", \"delete\" )'><img alt='delete' border='0' src='images/buttons/delete.gif'  > <span class='form_elements_row_action'>Delete &nbsp;</span></a>" );
								print( "<a href='#' style='text-decoration:none' onclick='return edit_row( \"ppl_news\", \"$ppl_news_rows_itr\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_row_action'>Edit &nbsp;</span></a>" );
							}
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td colspan='2'>" );
							print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
								print( "<tr>" );
									if( $ppl_news_rows["image_id"] != 0 )
									{
										print( "<td width='128'><image src='image.php?id=" . $ppl_news_rows["image_id"] . "' width='128' height='128' ></td>" );
										print( "<td width='5'></td>" );
									}								
									print( "<td colspan='$colspan' valign='top'>" );
									if( $ppl_news_rows["status"] == 0 )
										$span = "<span class='form_elements_text'>";
									else
										$span = "<span class='form_elements_text_disabled'>";
									print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
										print( "<tr>" );
											print( "<td align='left'>" );
											if( $ppl_news_rows["url"] != "" )
											{
												$urlname = $ppl_news_rows["url_name"] == "" ? "Read More..." : htmlspecialchars($ppl_news_rows["url_name"], ENT_QUOTES);
												print( "$span<a href='" . htmlspecialchars( $ppl_news_rows["url"], ENT_QUOTES) . "' target='_blank'>" . $urlname . "</a></span>" );
											}
											print( "</td>" );
										print( "</tr>" );

										print( "<tr>" );
											print( "<td >" );
											print( "$span". real_rte_specialchars($ppl_news_rows["description"] ). "</span>" );
											print( "</td>" );
										print( "</tr>" );
									print( "</table>" );
									print( "</td>" );							
								print( "</tr>" );
							print( "</table>" );
						print( "</tr>" );

						print( "<tr><td colspan='3'><HR></td></tr>" );
					print( "</table>" );
					print( "</td>" );					
				}
			if( $editable == true )
			{
				print( "<tr id='ppl_news_" . $ppl_news_rows_itr . "_edit_row' class='hiddenrow'>" );
				print( "<td width='5'></td>" );
				print( "<form enctype='multipart/form-data' id='ppl_news_" . $ppl_news_rows_itr . "_edit_form' method='post' action='sections/ppl_news_edit_row_submit.php' >" );
					print( "<input type='hidden' name='pid' value='$pid' />" );
					print( "<input type='hidden' name='section_id' value='$section_id' />" );
					print( "<input type='hidden' name='view' value='$view' />" );
					print( "<input type='hidden' name='news_id' value='$news_id' />" );
					print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />" );
					print( "<input type='hidden' name='ppl_news_image_id' value='" . $ppl_news_rows["image_id"] . "' />" );

					print( "<td>" );
					print( "<span class='form_elements_text'>" );
					print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
						print( "<tr>" );
							print( "<td width='10%'>Title</td>" );
							print( "<td><input class='form_elements_edit' type='text' name='ppl_news_title' value='". htmlspecialchars( $ppl_news_rows["title"], ENT_QUOTES ).  "' maxlength='255' size='60'></td>" );
							print( "<td align='right'>" );							
							$checkboxvalue = $ppl_news_rows[ "status" ] == 1 ? "checked" : "" ;
							print( "<input type='checkbox' name='ppl_news_status' $checkboxvalue><span class='form_elements_row_action'>Hide</span>&nbsp; &nbsp;" );
							print( "<a href='#' style='text-decoration:none' onclick='updateRTE( \"ppl_news_description_" . $ppl_news_rows_itr . "\" ); return submit_row( \"ppl_news\", \"$ppl_news_rows_itr\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif'  > <span class='form_elements_row_action'>Save &nbsp;</span></a>" );
							print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_row( \"ppl_news\", \"$ppl_news_rows_itr\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif'  > <span class='form_elements_row_action'>Cancel &nbsp;</span></a>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr>" );
							print( "<td>WebSite</td>" );
							print( "<td colspan='2'><input class='form_elements_edit' type='text' name='ppl_news_url_name' value='". htmlspecialchars( $ppl_news_rows["url_name"], ENT_QUOTES).  "' maxlength='255' size='22'>" );
							print( "&nbsp; &nbsp; URL" );
							print( "&nbsp; &nbsp; <input class='form_elements_edit' type='text' name='ppl_news_url' value='". htmlspecialchars( $ppl_news_rows["url"], ENT_QUOTES).  "' maxlength='255' size='22'>" );
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
							print( "writeRichText( 'ppl_news_description_" . $ppl_news_rows_itr . "', 'ppl_news_description', '" . real_rte_specialchars( $ppl_news_rows["description"] ) . "', 500, 80, true, false, true);" );
							print( "</script>" );
							
//							print( "<textarea class='form_elements_text' name='ppl_news_description' cols='120' rows='5'>" . htmlspecialchars( $ppl_news_rows["description"], ENT_QUOTES) . "</textarea>" );
							print( "</td>" );
						print( "</tr>" );
						print( "<tr><td colspan='3'><HR></tr></td>" );						
					print( "</table>" );
					print( "</span>" );
					print( "</td>" );
				print( "</form>" );
				print( "</tr>" );
			}
		}
	print( "</tr>" );
	/* Insert your custom code here for searching other and displaying news articles from other databases
	if($generalrows["f_name"]!="" || $generalrows["l_name"]!="")
		$urlname=$generalrows["f_name"]." ".$generalrows["l_name"];	
	print( "<tr>" );
		print( "<td width='5'></td>" );
		print( "<td>" );
		$res_mag_domain = "http://www.uta.edu/publications/researchmagazine/";
		$uta_mag_domain = "http://www.uta.edu/publications/utamagazine/";

		$research_magazine = "Research Magazine";
		$uta_magazine = "UTA Magazine";
		if($editable == true)
			$class_othernews = "form_elements_text_disabled";	
		else
			$class_othernews = "form_elements_text";
		# If we found at least one related article
		if($counter == 1) 
		{ 					
			if($editable == true)
				print "<div class='form_elements_section_subheader_disabled'>";
			else
				print "<div class='form_elements_section_subheader'>";
			print "Other News Articles";
			if($editable == true)
				print " (This is a live feed from Office of Public Affairs at UT Arlington)";
			print "<br><br>";
			print "</div>";
			$mod_fac_name = strtoupper($fac_name);
			$conn_univ_pub = univ_pub_db_connect ();
			print "<span class='".$class_othernews."'>";
			# Search Research Magazine for any articles related to expert		
			$query1 = "SELECT  * FROM  researchmag_articles  WHERE".
			  		  " MATCH(content) AGAINST('\"$fac_name\"' IN BOOLEAN MODE)".
			          " ORDER by article_id DESC" ;
	
			$result1 = mysql_query($query1, $conn_univ_pub) or die("Cannot execute query");
			  
			while ($record1 = mysql_fetch_array($result1)) 
			{					
				$headline = $record1['headline'];
				$issue_dir = $record1['issue_directory'];
				$article_id = $record1['article_id'];
				
				$sub_query1 = "SELECT  * FROM  researchmag_issues  WHERE issue_directory = '$issue_dir'";
				$sub_result1 = mysql_query($sub_query1, $conn_univ_pub) or die("Cannot execute query");
				while($sub_record1 = mysql_fetch_array($sub_result1)) {
					$issue_name = $sub_record1['issue'];
				} 
				
				# Construct a link to this article
				$page = "index.php?id=$article_id";
				$res_mag_link = $res_mag_domain.$issue_dir."/".$page;
				print "<div class='".$class_othernews."'>";	
				print "<a href ='".$res_mag_link."' target='_blank'>".$headline."</a>";
				print "<span> - ".$research_magazine.", ".$issue_name."</span> </div>";
			}
	
			# Search UTA Magazine for any articles related to expert
			$query2 = "SELECT * FROM  stories  WHERE
			   MATCH(headline,subheadline,content,summary) AGAINST('\"$fac_name\"' IN BOOLEAN MODE)
			   ORDER by id DESC" ;
			   			  		
			$result2 = mysql_query($query2, $conn_univ_pub) or die("Cannot execute query") ;
	
			while ($record2 = mysql_fetch_array($result2)) 
			{
				$edition_id = $record2['edition_id'];
				$headline_mag = $record2['headline'];
				$story_id = $record2['id'];
				
				$sub_query2 = "select * from mag_year where edition_id = '$edition_id'";
				$sub_result2 = mysql_query($sub_query2, $conn_univ_pub) or die("Cannot execute query");
				while($sub_record2 = mysql_fetch_array($sub_result2)) {
					$edition_name = $sub_record2['edition'];
					$edition_dir = $sub_record2['edition_directory'];				
				}	
				
				# Construct a link to this article
				$page = "stories.php?id=$story_id";
				$uta_mag_link = $uta_mag_domain.$edition_dir."/".$page;
				print "<div class='".$class_othernews."'>";	
				print "<a href ='".$uta_mag_link."' target='_blank'>".
					   $headline_mag."</a>";
				print "<span> - ".$uta_magazine.", ".$edition_name."</span> </div>";
			}

			# Search News Releases for any articles related to expert
			$query3 = "SELECT * FROM  stories  WHERE".
					  " MATCH(story_text) AGAINST('\"$fac_name\"' IN BOOLEAN MODE)".
					  " AND pubstatus = 'Y'".
					  " ORDER by published DESC" ;
			   			  		
			$result3 = mysql_query($query3, $conn_pub_affairs) or die("Cannot execute query") ;
			if ($result3)
			{
				print "<u>News Releases</u>";
				while ($record3 = mysql_fetch_array($result3)) 
				{
					# Construct a link to this article
					$page = "page.php?id=$record3[id]";
					//$uta_mag_link = $uta_mag_domain.$edition_dir."/".$page;
					print "<div class='".$class_othernews."'>";	
					print date("d M Y", $record3["published"])." <a ".
						  "href ='http://www.uta.edu/public-affairs/pressreleases/".$page.
						  "' target='_blank'>".$record3["headline"].
						  "</a></div>";
				}
			}						
			print "</span>";
		}	
 		print( "</td>" );
	print( "</tr>" );
	*/
	print( "<tr><td colspan='6' height='10'></td></tr>" );
	print( "</table>" );
}	
?>
