<?php
print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_ind_cluster_view_box' class='visiblebox'>" );
	print( "<tr class='table_background'>" );
		print( "<td>" );		
		print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td><span class='form_elements_section_header'>&nbsp;Industry Clusters</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
				print( "<a href='#' style='text-decoration:none' onclick='return edit_box( \"gen_ind_cluster\" )'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>" );
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
						print"<ul class='mktree' id='tree1'>";
						$start = 1;
						while($rowic = mysql_fetch_array($resic))
						{
							$noofzeros = 0;
							$c[1]=$rowic["c1"];
							$c[2]=$rowic["c2"]; 
							$c[3]=$rowic["c3"];
							$c[4]=$rowic["c4"];
							$c[5]=$rowic["c5"];
							$cid=$rowic["cluster_id"];
							$img = $ind[$cid] == 1 ? "<img alt='show' src='images/icons/show.gif'>" : "<img alt='hide' src='images/icons/hide.gif'>";
							for($k=1;$k<=5;$k++)
							{
								if($c[$k]==0)
									$noofzeros = $noofzeros + 1;
							}
							if($start==1)
							{
								print "<li>";
								print $img."&nbsp;".$rowic["name"];
								$start = 0;	
								$prevzeros = $noofzeros;					
							}
							else
							{
								if($noofzeros < $prevzeros)
									print "<ul><li>".$img."&nbsp;".$rowic["name"];
								if($noofzeros == $prevzeros)
									print "</li><li>".$img."&nbsp;".$rowic["name"];
								if($noofzeros > $prevzeros)
								{
									$l = $noofzeros - $prevzeros;
									for($k=1;$k<=$l;$k++)
										print "</li></ul>";
									print "</li><li>".$img."&nbsp;".$rowic["name"];
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

print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='gen_ind_cluster_edit_box' class='hiddenbox'>" );
	print( "<form id='gen_ind_cluster_edit_form' name='gen_ind_cluster_edit_form' action='sections/gen_ind_cluster_edit_box_submit.php' method='post'>" );
	print( "<input type='hidden' name='pid' value='$pid'  />" );
	print( "<input type='hidden' name='clicked' value='0' />" );
	print( "<tr class='table_background'>" );
		print( "<td>" );		
		print("<table width='100%'  border='0' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td><span class='form_elements_section_header'>&nbsp;Industry Clusters</span></td>" );
				print( "<td align='right' height='20' width='15%'>" );
					print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"gen_ind_cluster\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>" );
					print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"gen_ind_cluster\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>" );
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	mysql_data_seek($resic, 0 );
	print( "<tr>" );
		print( "<td>" );		
		print("<table width='100%'  border='1' cellspacing='0' cellpadding='0'>" );
			print( "<tr>" );
				print( "<td>" );
				print("<table width='100%'  border='0' cellspacing='5' cellpadding='0'>" );
					print( "<tr>" );
						print "<td>";
						//////////////tree structure //////////////////////////////////
						print"<ul class='mktree' id='tree1'>";
						$start = 1;
						while($rowic = mysql_fetch_array($resic))
						{
							$noofzeros = 0;
							$c[1]=$rowic["c1"];
							$c[2]=$rowic["c2"]; 
							$c[3]=$rowic["c3"];
							$c[4]=$rowic["c4"];
							$c[5]=$rowic["c5"];
							$cid=$rowic["cluster_id"];
							$check = $ind[$cid] == 1 ? "<input name='i".$cid."' type='checkbox' id='i".$cid."' value='1' checked='checked' />" : "<input name='i".$cid."' type='checkbox' id='i".$cid."' value='1' />";							
							for($k=1;$k<=5;$k++)
							{
								if($c[$k]==0)
									$noofzeros = $noofzeros + 1;
							}
							if($start==1)
							{
								print "<li>";
								print $check.$rowic["name"];
								$start = 0;	
								$prevzeros = $noofzeros;					
							}
							else
							{
								if($noofzeros < $prevzeros)
									print "<ul><li>".$check.$rowic["name"];
								if($noofzeros == $prevzeros)
									print "</li><li>".$check.$rowic["name"];
								if($noofzeros > $prevzeros)
								{
									$l = $noofzeros - $prevzeros;
									for($k=1;$k<=$l;$k++)
										print "</li></ul>";
									print "</li><li>".$check.$rowic["name"];
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