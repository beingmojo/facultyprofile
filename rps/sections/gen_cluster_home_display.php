<?php
print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_home_cluster_view_box' class='visiblebox'>" );
	print( "<tr class='table_background'>" );
		print( "<td>" );		
		print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td><span class='form_elements_section_header'>&nbsp;Homeland Security Clusters</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
				print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"gen_home_cluster\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	print( "<tr>" );
		print( "<td>" );		
		print("<table width='100%'  border='1' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td>" );
				print("<table width='100%'  border='1' cellspacing='0' cellpadding='0'>" );
					print( "<tr>" );
						print "<td>";
						//////////////tree structure //////////////////////////////////
						print"<ul class='mktree' id='tree2'>";
						$start = 1;
						while($rowhc = mysql_fetch_array($reshc))
						{
							$noofzeros = 0;
							$c[1]=$rowhc["c1"];
							$c[2]=$rowhc["c2"]; 
							$c[3]=$rowhc["c3"];
							$chd=$rowhc["cluster_id"];
							$img = $home[$chd] == 1 ? "<img alt='show' src='images/icons/show.gif'>" : "<img alt='hide' src='images/icons/hide.gif'>";
							for($k=1;$k<=3;$k++)
							{
								if($c[$k]==0)
									$noofzeros = $noofzeros + 1;
							}
							if($start==1)
							{
								print "<li>";
								print $img."&nbsp;".$rowhc["name"];
								$start = 0;	
								$prevzeros = $noofzeros;					
							}
							else
							{
								if($noofzeros < $prevzeros)
									print "<ul><li>".$img."&nbsp;".$rowhc["name"];
								if($noofzeros == $prevzeros)
									print "</li><li>".$img."&nbsp;".$rowhc["name"];
								if($noofzeros > $prevzeros)
								{
									$l = $noofzeros - $prevzeros;
									for($k=1;$k<=$l;$k++)
										print "</li></ul>";
									print "</li><li>".$img."&nbsp;".$rowhc["name"];
								}
								$prevzeros = $noofzeros;
							}
						}
						print "</li>";
						print "</ul>";
						print "</td>";
					print( "</tr>" );
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
print( "</table>" );

print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_home_cluster_edit_box' class='hiddenbox'>" );
	print( "<form id='gen_home_cluster_edit_form' name='gen_home_cluster_edit_form' action='sections/gen_home_cluster_edit_box_submit.php' method='post'>" );
	print( "<input type='hidden' name='pid' value='$pid'  />" );
	print( "<input type='hidden' name='clicked' value='0' />" );
	print( "<tr class='table_background'>" );
		print( "<td>" );		
		print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td><span class='form_elements_section_header'>&nbsp;Homeland Security Clusters</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"gen_home_cluster\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"gen_home_cluster\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	mysql_data_seek($reshc, 0 );
	print( "<tr>" );
		print( "<td>" );		
		print("<table width='100%'  border='1' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td>" );
				print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
					print( "<tr>" );
						print "<td>";
						//////////////tree structure //////////////////////////////////
						print"<ul class='mktree' id='tree2'>";
						$start = 1;
						while($rowhc = mysql_fetch_array($reshc))
						{
							$noofzeros = 0;
							$c[1]=$rowhc["c1"];
							$c[2]=$rowhc["c2"]; 
							$c[3]=$rowhc["c3"];
							$chd=$rowhc["cluster_id"];
							$check = $home[$chd] == 1 ? "<input name='h".$chd."' type='checkbox' id='h".$chd."' value='1' checked='checked' />" : "<input name='h".$chd."' type='checkbox' id='h".$chd."' value='1' />";							
							for($k=1;$k<=3;$k++)
							{
								if($c[$k]==0)
									$noofzeros = $noofzeros + 1;
							}
							if($start==1)
							{
								print "<li>";
								print $check.$rowhc["name"];
								$start = 0;	
								$prevzeros = $noofzeros;					
							}
							else
							{
								if($noofzeros < $prevzeros)
									print "<ul><li>".$check.$rowhc["name"];
								if($noofzeros == $prevzeros)
									print "</li><li>".$check.$rowhc["name"];
								if($noofzeros > $prevzeros)
								{
									$l = $noofzeros - $prevzeros;
									for($k=1;$k<=$l;$k++)
										print "</li></ul>";
									print "</li><li>".$check.$rowhc["name"];
								}
								$prevzeros = $noofzeros;
							}
						}
						print "</li>";
						print "</ul>";
						print "</td>";
					print( "</tr>" );
				print( "</table>" );
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	print( "</form>" );	
print( "</table>" );
?>