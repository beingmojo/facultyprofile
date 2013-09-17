<?php
	$blue_view = 5;
	$is_dept_admin = real_check_dept_admin( $db_conn );
	include "bluesheet_header.php";
	$main_view = $_GET['view'];
?>

<table width="90%"  border="0" cellspacing="0" cellpadding="0" align="left">
	  	<tr>
			<td>
			<table width="100%">
			 <tr>
			 <td>
				<span class="form_elements"><b><?php print( $_SESSION['ULNAME'] . ", " . $_SESSION['UFNAME'] ); ?></b></span>
				&nbsp;&nbsp;
				<a href='f_firstlogin.php?view=2' style="text-decoration:none"><span class="details">(Account Info </span></a>
				<span class="details">|</span>
				<a href='logoff.php' style="text-decoration:none"><span class="details">Logoff)</span></a>
			</td>
			<td align="right" >
				<span class="form_elements"><b>
				<img alt="Help" src="images/bullets/help.gif" />
				Looking for help? Check out blue sheet quick start guide:</b>
				<a href="help/bluesheet_quickstart_guide.doc">DOC</a> | 
				<a href="help/bluesheet_quickstart_guide.pdf">PDF</a>
				</span>
			</td>			
		  	</tr>
		    </table>
			</td>
		</tr>		
		<tr>
		  <td colspan="2">
			  <table width="100%" border="0"  cellspacing="2" cellpadding="2" align="left">
			   <tr>
			 	  <td colspan="5" class='table_content'>
					<?php include "new_bluesheet.php";?>
				  </td>
			   </tr>
			  </table>
		  </td>
		</tr>
		<tr>
		  <td colspan="2">
			  <table width="100%" cellspacing="2" cellpadding="2" align="left">
				   <tr>
					   <td colspan="5" class='table_content'>
					   <table width="100%">
						<tr>
							<td>
						 	   <span class='font_topic'>Department BlueSheets</span>
							 </td>
							 <td width="300" align="right">
							
<?php
 if ($is_dept_admin != false)
{
		$page=$_GET['page'];
		$query = "SELECT count(*) as no_rec FROM bs_info WHERE bs_status!='Saved' AND bs_id IN (select distinct(bs_id) from bs_routing where loginid IN (select login_id from gen_dept_hierarchy where hid=$is_dept_admin))";	
		include "bluesheet_sort.php";
	 }
?>	  
</td>
						</tr>
					  </table>
					</td>
				</tr>
		 		 <tr>
				 <td colspan="5">
					   		   <div style="font-size:11px;">
				   			 This section shows your blue sheets that are submitted, routed and/or completed for your department.
							</div>
					    </td>
					</tr>
  				    <tr>
					   <td style="border-bottom:1px solid #000000;" width="25%" class="form_elements_text">
					   		<b><a href='researchspace.php?view=<?php echo $main_view?>&blue_view=5&investigator=<?php echo $order?>'>Investigator</a></b>
						</td>
						<td style="border-bottom:1px solid #000000;" width="35%" class="form_elements_text">
							<b>Status</b>
						</td>
						<td style="border-bottom:1px solid #000000;" width="25%" class="form_elements_text">
							<b><a href='researchspace.php?view=<?php echo $main_view?>&blue_view=5&submiton=<?php echo $order?>'>Last Saved</a></b>
						</td>
						<td style="border-bottom:1px solid #000000;" width="15%" class="form_elements_text">
							<b>Actions</b>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%">
<?php

if ($is_dept_admin != false)
{
?>

<?php
		// Blue Sheet Manage Page that gets included from the researchspace.php page
		//$pid = "0";
		$page=$_GET['page'];
		if(!($page>0))
		{
			$page=0;
		}
		$order_by = $_SESSION['sort_orderby'];
		
		//$query = "SELECT A.bs_id, B.name as piname,bs_comments, A.proposal_title, A.ret_comments, A.ret_by, DATE_FORMAT(A.bs_timestamp,'%m/%d/%Y %r') as bs_timestamp, A.bs_status, A.pid, A.copi_flag FROM bs_info A, bs_i_info B WHERE B.bs_id=A.bs_id AND B.i_id=A.pi_id AND bs_status!='Saved' AND A.bs_id IN (select distinct(bs_id) from bs_routing where loginid IN (select login_id from gen_dept_hierarchy where hid=$is_dept_admin)) order by $sort_view $order_by limit $page,15 ";
		$query = "SELECT A.bs_id, B.name as piname,bs_comments, A.proposal_title, A.ret_comments, A.ret_by, DATE_FORMAT(A.bs_timestamp,'%m/%d/%Y %r') as bs_timestamp, A.bs_status, A.pid, A.copi_flag FROM bs_info A, bs_i_info B WHERE B.bs_id=A.bs_id AND B.i_id=A.pi_id AND bs_status!='Saved' AND A.bs_id IN (select distinct(bs_id) from bs_routing bs, gen_dept_hierarchy gen where gen.login_id = bs.loginid and hid=$is_dept_admin) order by $sort_view $order_by limit $page,15 ";
		$results = real_execute_query($query, $db_conn);
		
		if (mysql_num_rows($results)>0)
		{
			while($rows = mysql_fetch_array($results))
			{
				if ($rows["copi_flag"] == "0")
					$man_route = "<img src='bluesheet/images/redflag.PNG' alt='Needs manual routing'> ";
				else
					$man_route = " &nbsp; &nbsp; ";
				//echo  "<tr><td><table width ='100%' border='1' cellpadding=2 rowpadding=2 align='left'>";
				echo "<tr style='font-size:9pt;font-family:Tahoma;background-color:#F3F3F3;'>" .
					"<td width='25%' style=cursor:pointer; onmouseover=\"document.getElementById('n" . $rows["bs_id"] .
					"').style.textDecoration = 'underline';\" onmouseout=\"document.getElementById('n" . $rows["bs_id"].
					"').style.textDecoration = 'none';\" onclick=\"toggle('route". $rows["bs_id"] . "');\"><b>" . 
					"<img src=\"images/arrow_up.jpg.png\"> <span id=n" . $rows["bs_id"] . ">" . $rows["piname"] . 
					"</span></b></td><td width=35%>" . $man_route;

				if ($rows["bs_status"] != "Saved")
				{
					$query = "SELECT distinct(loginid), status, bs_id, description FROM bs_routing WHERE bs_id = " . $rows["bs_id"];
					$results_1 = real_execute_query($query, $db_conn);
					if (mysql_num_rows($results_1) > 0)
					{
						$approve_count = 0;
						$deny_count = 0;
						$pending_count = 0;
						$approve_comments="";
						while($rows_1 = mysql_fetch_array($results_1))
						{
							if ($rows_1["status"] == "Approved")
							{
								$approve_count++;
								if ($rows_1["description"] != "")
								{
									$approve_comments .= "<u>Comment </u>: " . $rows_1["description"]."<br>";
								}
							}
							else if ($rows_1["status"] == "Denied")
								$deny_count++;
							else if ($rows_1["status"] == "Pending")
								$pending_count++;
						}
					}
					//echo "<td width='25%'>";
					if ($rows["bs_status"] != "Submitted")
					{
						echo $rows["bs_status"] . " - <span style=font-size:8pt;>Approved: $approve_count, Pending: $pending_count</span>";
					}
					else
					{
						echo $rows["bs_status"] . " - <span style=font-size:8pt;>Pending on GCS to route</span>";
					}
					echo "</td>";							
				}
				else
				{
					//echo "<td width='25%'>".$rows["bs_status"];
					echo $rows["bs_status"];
					if ($rows["ret_by"] == "")
						echo "</td>";
					else
						echo " - <span style=font-size:8pt;>Returned By " . $rows["ret_by"] . "</span></td>";
				}
				
				echo  "<td width='25%'>".$rows["bs_timestamp"] . "</td>";
				
				if ($rows["bs_status"] != "Saved")
				{
					echo "<td width='15%'><a href=\"bluesheet/review.php?pid=".$rows["pid"]."&bs_id=" . $rows["bs_id"] . "\">View</a> &nbsp; &nbsp; ";
				}
				else
				{
					echo "<td width='25%'><a href=\"bluesheet/bs_template.php?pid=".$rows["pid"]."&edit=1&view=1&bs_id=". $rows["bs_id"] .
					 "\">View</a> &nbsp; &nbsp; " . "<a href=\"bluesheet/bs_template.php?pid=".$rows["pid"]."&edit=1&createnew=1&bs_id=".
					  $rows["bs_id"] . "\" title=\"Create new bluesheet from this\">Copy</a> &nbsp; &nbsp; " .	
					  "<a href=\"bluesheet/bs_template.php?pid=".$rows["pid"]."&edit=1&bs_id=" . $rows["bs_id"] . "\">Edit</a>  &nbsp; &nbsp; " .
					  "<a onclick='return ConfirmDelete();' href=\"bluesheet/bs_delete.php?bs_id=". $rows["bs_id"] . "\">Delete</a>  &nbsp; &nbsp; " ;
				}
				echo "</td></tr>";				
				//echo "</td></tr></table></td></tr>";
				echo "<tr id='routetr".$rows["bs_id"]."' style='display:none'><td style=\"font-size:9pt;font-family:Tahoma;display:none;\" id=\"route" .
					$rows["bs_id"] . "\" colspan=4>";
				echo  "0<u>Proposal Title:</u> ". $rows["proposal_title"]."<br>";	
				//echo "<u>Description</u>: " . $rows["bs_comments"]."<br>";
				echo $approve_comments;
				echo "</td></tr>";
				//echo "</td></tr></table></td></tr>";
			}
		  echo "<input type='hidden' id= 'hiddenbs_id' >";
		  echo "<input type='hidden' id= 'hidden_content' >";	
		}
		else
		{
	?>
	<tr>
		<td class="form_elements_text">
		<b>You do not have any bluesheets for your department currently.</b></td>
	</tr>
	<?php
	}}
	?>
		</table>
	 	</td>
	  </tr>
</table>
	  
<script type="text/javascript">

var request = createXMLHttpRequest();  
 
function createXMLHttpRequest() 
{  
var ua;
if(window.XMLHttpRequest)
{
    	  ua = new XMLHttpRequest(); 		  
}
else if(window.ActiveXObject) 
{     
			ua = new ActiveXObject("Microsoft.XMLHTTP");     
}
return ua;   
}     

function toggle(routebs_id)
{	
	if(document.getElementById(routebs_id).style.display=='none')
	{
		content = document.getElementById(routebs_id).innerHTML ;
		if(content.charAt(0)==0)
		{
		document.getElementById("hidden_content").value = content.substring(1,content.length) ;
		document.getElementById(routebs_id).innerHTML = "----Retreiving information----";
		document.getElementById(routebs_id).style.display='';
		bs_id = routebs_id.substring(routebs_id.indexOf('e')+1,routebs_id.length );	
		routetrbs_id = "routetr"+bs_id;		
		document.getElementById(routetrbs_id).style.display='';
		document.getElementById("hiddenbs_id").value = routebs_id;	
		var uri = "prof_review.php?bs_id=" + bs_id;
		request.open("GET",uri ,true); 	
		request.onreadystatechange = handleResponse;    	
		request.send(null);   
		}
		else
		{
			document.getElementById(routebs_id).style.display='';
		}
	}
	else
	{
		document.getElementById(routebs_id).style.display='none';
		return false; 
	}
}   

function handleResponse() 
{   
	if(request.readyState == 4)
	{
		if(request.status==200)
		{
			var response = request.responseText;    
			routebs_id = document.getElementById("hiddenbs_id").value;
			document.getElementById(routebs_id).innerHTML =document.getElementById("hidden_content").value  + response;
	}
	}
}   

function toggle1(elID)
{
	var el = document.getElementById(elID);
	if (el.style.display == 'none')
	{
		el.style.display = '';
	}
	else
		el.style.display = 'none';
}
	  
function ConfirmDelete()
{
	var ret = confirm("Are you sure you want to delete this bluesheet?");
	if (ret)
		return true;
	else
		return false;
}

</script>