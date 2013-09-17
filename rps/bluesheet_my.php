<?php
		$blue_view = 4;
		include "bluesheet_header.php";
		$main_view=$_GET['view'];
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
		  <td colspan="2" >
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
		<td>
			<table width="100%">
				<tr>
			    <td colspan="2">
				  <table width ="100%" cellspacing="2" cellpadding="2" align="left">
				   <tr>
	    	   		<td colspan="5" class='table_content'>
					  <table width="100%">
						<tr>
							<td>
									   <span class='font_topic'>My BlueSheets</span>
									   </td>							
										<td width="300" align="right">
	
<?php
	$page=$_GET['page'];

	$query = "SELECT count(*) as no_rec FROM bs_info WHERE started_by='".$_SESSION['UID']."'";
	if(no_rec>15)
		echo "<span style=font-weight:bold;>Page</span>";
	 include "bluesheet_sort.php";
?>					
							</td>
						</tr>
					  </table>
					</td>
					</tr>									
					<tr>
					<td colspan="5">
					   	   <div style="font-size:11px;">
				   			  This section shows your blue sheets that are saved, submitted, routed and/or completed.
							</div>
					    </td>
					</tr>
  				    <tr>
					   <td style="border-bottom:1px solid #000000;" width="25%" class="form_elements_text">
					   		<b><a href='researchspace.php?view=<?php echo $main_view; ?>&blue_view=4&investigator=<?php echo $order; ?>'>Name</a></b>
						</td>
						<td style="border-bottom:1px solid #000000;" width="25%" class="form_elements_text">
							<b>Status</b>
						</td>
						<td style="border-bottom:1px solid #000000;" width="25%" class="form_elements_text">
							<b><a href='researchspace.php?view=<?php echo $main_view?>&blue_view=4&submiton=<?php echo $order?>'>Last Saved</a></b>
						</td>
						<td style="border-bottom:1px solid #000000;" width="25%" class="form_elements_text">
							<b>Actions</b>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table width="100%" border="0">
  <?php
		// Blue Sheet Manage Page that gets included from the researchspace.php page		
		//$pid = "0";
		$page=$_GET['page'];
		if(!($page>0))
		{
			$page=0;
		}
		if($sort_view=='name')
			$sort_view = 'bs_name';
		$order_by = $_SESSION['sort_orderby'];
					
		$query = "SELECT bs_id, bs_name, bs_comments, ret_comments, ret_by, DATE_FORMAT(bs_timestamp,'%m/%d/%Y %r') as bs_timestamp, bs_status, pid, copi_flag FROM bs_info WHERE pid=$pid OR started_by='".$_SESSION['UID']."' order by $sort_view $order_by limit $page,15";
		$results = real_execute_query($query, $db_conn);
		
		if ((mysql_num_rows($results)>0) && ($pid!=0))
		{
			while($rows = mysql_fetch_array($results))
			{
				if ($rows["copi_flag"] == "0")
					$man_route = "<img src='bluesheet/images/redflag.PNG' alt='Needs manual routing'> ";
				else
					$man_route = " &nbsp; &nbsp; ";
					
				echo "<tr style='font-size:9pt;font-family:Tahoma;background-color:#F3F3F3;'>" .
				 "<td width='25%' style=cursor:pointer; onmouseover=\"document.getElementById('n" . $rows["bs_id"] .
					"').style.textDecoration = 'underline';\" onmouseout=\"document.getElementById('n" . $rows["bs_id"]."').style.textDecoration = 'none';\" " .
					"onclick=\"toggle('route". $rows["bs_id"] . "');\"><b>" . "<img src=\"images/arrow_up.jpg.png\"> <span id=n" . $rows["bs_id"] . 
					">" .$rows["bs_name"] . "</span></b></td>";
					
				echo "<td width='25%' align=left>" . $man_route;
				
				if ($rows["bs_status"] != "Saved")
				{
					$query = "SELECT distinct(loginid), status, bs_id, description FROM bs_routing WHERE bs_id = " . $rows["bs_id"];
					$results_1 = real_execute_query($query, $db_conn);
					if (mysql_num_rows($results_1) > 0)
					{
						$approve_count = 0;
						$deny_count = 0;
						$pending_count = 0;
						while($rows_1 = mysql_fetch_array($results_1))
						{
							if ($rows_1["status"] == "Approved")
								$approve_count++;
							else if ($rows_1["status"] == "Denied")
								$deny_count++;
							else if ($rows_1["status"] == "Pending")
								$pending_count++;
						}
					}
					if ($rows["bs_status"] != "Submitted")
					{
						echo $rows["bs_status"] . " - <span style=font-size:8pt;>Approved: $approve_count, Pending: $pending_count</span></td>";
					}
					else
					{
						echo $rows["bs_status"] . " - <span style=font-size:8pt;>Pending on GCS to route</span></td>";
					}
					
				}
				else
				{
					echo $rows["bs_status"];
					if ($rows["ret_by"] == "")
						echo "</td>";
					else
						echo " - <span style=font-size:8pt;>Returned By " . $rows["ret_by"] . "</span></td>";
				}
				
				echo  "<td width='25%' align=left>".$rows["bs_timestamp"] . "</td>";
				
				if ($rows["bs_status"] != "Saved")
				{
					echo "<td width='25%' ><a href=\"bluesheet/review.php?pid=".$rows["pid"]."&bs_id=" . $rows["bs_id"] . "\">View</a> &nbsp; &nbsp; " ."<a href=\"bluesheet/bs_template.php?pid=".$rows["pid"]."&edit=1&createnew=1&bs_id=". $rows["bs_id"] . "\" title=\"Create new bluesheet from this\">Copy</a></td></tr>";
				}
				else
				{
					echo "<td width='25%'><a href=\"bluesheet/bs_template.php?pid=".$rows["pid"]."&edit=1&view=1&bs_id=" . $rows["bs_id"] . "\">View</a> &nbsp; &nbsp; " . "<a href=\"bluesheet/bs_template.php?pid=".$rows["pid"]."&edit=1&createnew=1&bs_id=". $rows["bs_id"] . "\" title=\"Create new bluesheet from this\">Copy</a> &nbsp; &nbsp; " ."<a  href=\"bluesheet/bs_template.php?pid=". $rows["pid"]."&edit=1&bs_id=" . $rows["bs_id"] . "\">Edit</a>  &nbsp; &nbsp; " ."<a onclick='return ConfirmDelete();' href=\"bluesheet/bs_delete.php?bs_id=". $rows["bs_id"] . "\">Delete</a>  &nbsp; &nbsp; " . 
"</td></tr>";
				}
				echo "<tr  >" . "<td style=\"font-size:9pt;font-family:Tahoma;border-bottom:1px dotted #000000;display:none\" colspan=4 id=\"route". $rows["bs_id"] . "\">" ."0<u>Project Title</u>: " . $rows["bs_name"]."<br>";
				if ($rows["bs_status"] == "Saved")
				{
					if ($rows["ret_comments"] != "")
								echo "<u>Comments</u>: " . $rows["ret_comments"]."<br>";
				}
				echo "</td></tr>";
			}
		
		}
		else
		{
	?>
	<tr>
		<td colspan ="4" class="form_elements_text">
		You do not have any bluesheets saved currently.</td>
	</tr>
	<?php
	}
	  echo "<input type='hidden' id= 'hiddenbs_id' >";
	  echo "<input type='hidden' id= 'hidden_content' >";
	?>
		</table>
	 	</td>
	  </tr>
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

function ConfirmDelete()
{
	var answer = confirm("Are you sure to delete the application?")
	if (answer){
		return true;
	}
return false;
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
</script>