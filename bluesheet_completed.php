<?
$is_ogcs_admin = real_check_user_groupid($db_conn, "ogcs_admin");
$blue_view = 3;
include "bluesheet_header.php";
$main_view = $_GET['view'];
?>
<script type="text/javascript">
    function sort()
    {

    }
</script>

<table width="90%"  border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
        <td >
            <table border="0" width="100%">
                <tr>
                    <td>
                        <span class="form_elements"><b><?php print( $_SESSION['ULNAME'] . ", " . $_SESSION['UFNAME']);?></b></span>
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
                <tr >
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
                                                <span class='font_topic'>Completed BlueSheets</span>
                                            </td>
                                            <td width="300" align="right">

                                                <?php
                                                if ($is_ogcs_admin) {
                                                    $page = $_GET['page'];
                                                    $query = "SELECT count(*) as no_rec FROM bs_info WHERE bs_status='Completed'";
                                                    /* if(no_rec>15)
                                                      echo "<span style=font-weight:bold;>Page</span>";
                                                      $results5 = real_execute_query($query, $db_conn);
                                                      if (mysql_num_rows($results5) > 0)
                                                      {
                                                      while($rows5 = mysql_fetch_array($results5))
                                                      {
                                                      $no_rec = $rows5['no_rec'];
                                                      }
                                                      }
                                                      if($no_rec > 15 )
                                                      {
                                                      $count=0;
                                                      $prev= $page-15;
                                                      $next=$page+15;
                                                      echo "<a href='researchspace.php?view=2&blue_view=3&page=0'><<</a>&nbsp;&nbsp;";
                                                      echo "<a href='researchspace.php?view=2&blue_view=3&page=$prev'><</a>&nbsp;&nbsp;";
                                                      for($i=0;$i<$no_rec;$i=$i+15)
                                                      {
                                                      $count++;
                                                      if($page==$i)
                                                      echo "$count&nbsp;&nbsp;";
                                                      else
                                                      echo "<a href='researchspace.php?view=2&blue_view=3&page=$i'>$count</a>&nbsp;&nbsp;";

                                                      }
                                                      $last=$i-15;
                                                      if($next==$i)
                                                      $next=$next-15;
                                                      echo "<a href='researchspace.php?view=2&blue_view=3&page=$next'>></a>&nbsp;&nbsp;";
                                                      echo "<a href='researchspace.php?view=2&blue_view=3&page=$last'>>></a>&nbsp;&nbsp;";


                                                      } */
                                                    include "bluesheet_sort.php";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" >
                                    <div style="font-size:11px;">
						This section shows the bluesheets that have been completed, i.e. these have gone through submission and routing
					process.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="border-bottom:1px solid #000000;" width="35%" class="form_elements_text"><b><a href='researchspace.php?view=<?php echo $main_view?>&blue_view=3&investigator=<?php echo $order?>'>Investigator</a></b></td>
                                        <td style="border-bottom:1px solid #000000;" width="30%" class="form_elements_text"><b>Status</b></td>
                                        <td style="border-bottom:1px solid #000000;" width="23%" class="form_elements_text"><b><a href='researchspace.php?view=<?php echo $main_view?>&blue_view=3&submiton=<?php echo $order?>'>Submitted On</a></b></td>
                                        <td style="border-bottom:1px solid #000000;" width="12%" class="form_elements_text"><b>Actions</b></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table width="100%" border="0">
<?php
                                                if ($is_ogcs_admin) {
                                                    $page = $_GET['page'];
                                                    if (!($page > 0)) {
                                                        $page = 0;
                                                    }



                                                    $order_by = $_SESSION['sort_orderby'];
                                                    if ($order_by == "ASC") $order_by = "DESC";
                                                    else if ($order_by == "DESC") $order_by = "ASC";
                                                    else $order_by = "DESC";

                                                    $query = "SELECT *, DATE_FORMAT(bs_timestamp,'%m/%d/%Y %r') as bs_timestamp1 FROM bs_info bsi ,bs_i_info info WHERE bs_status='Completed' and bsi.bs_id=info.bs_id and info.i_id = 1 order by $sort_view $order_by limit $page,15";
?>


                            <?php
                                                    $results = real_execute_query($query, $db_conn);
                                                    if (mysql_num_rows($results) > 0) {
                                                        while ($rows = mysql_fetch_array($results)) {
                                                            $query = "SELECT name FROM bs_i_info WHERE bs_id=" . $rows["bs_id"] . " AND i_id = " . $rows["pi_id"];
                                                            $results2 = real_execute_query($query, $db_conn);
                                                            if ($rows2 = mysql_fetch_array($results2)) {
                                                                if ($last_bs_id != $rows["bs_id"]) {
                                                                    $query = "SELECT  distinct(loginid),status FROM bs_routing WHERE bs_id =" . $rows["bs_id"];
                                                                    $results3 = real_execute_query($query, $db_conn);
                                                                    $approve_count = 0;
                                                                    $pending_count = 0;
                                                                    while ($rows3 = mysql_fetch_array($results3)) {
                                                                        if ($rows3["status"] == 'Approved') $approve_count++;
                                                                        else if ($rows3["status"] == 'Pending') $pending_count++;
                                                                    }
                                                                    if ($rows["copi_flag"] == "0") $man_route = "<img src='bluesheet/images/redflag.PNG' alt='Needs manual routing'>";
                                                                    else $man_route = " &nbsp; &nbsp; ";
                                                                    //echo "<tr><td><table width ='100%' border='0' cellspacing='2' cellpadding='2' align='left'>".
                                                                    echo "<tr style='font-size:9pt;font-family:Tahoma;background-color:#F3F3F3;'>" .
                                                                    "<td width=35% style=cursor:pointer; onmouseover=\"document.getElementById('r" . $rows["bs_id"] .
                                                                    "').style.textDecoration = 'underline';\" onmouseout=\"document.getElementById('r" . $rows["bs_id"] . "').style.textDecoration = 'none';\" " . "onclick=\"toggle('route" . $rows["bs_id"] . "');\"><b>" . "<img src=\"images/arrow_up.jpg.png\"> <span id='r" . $rows["bs_id"] . "'>" . $rows2["name"] . "</span></b></td><td width='30%'  align='left'>" . $man_route . " ";
//			 echo "<a href= prof_review.php?bs_id=59>what</a>";
                                                                    $last_bs_id = $rows["bs_id"];
                                                                    echo $rows["bs_status"] . " - <span style='font-size:8pt;'>Approved: $approve_count, Pending: $pending_count</span></td><td width=23%>" . $rows["bs_timestamp1"] . "</td>";
                                                                    echo "<td width='12%'><a href=\"bluesheet/review.php?id=" . $rows["bs_id"] . "-" . $_SESSION['UID'] . "\">View</a> &nbsp; &nbsp; " . "<a href=\"bluesheet/bs_template.php?pid=" . $rows["pid"] . "&edit=1&bs_id=" . $rows["bs_id"] . "\">Edit</a>";
                                                                    $login_id = $_SESSION['UID'];
                                                                }
                                                                else {
                                                                    echo "<tr style='font-size:9pt;font-family:Tahoma;'><td>&nbsp; &nbsp; &nbsp;" . $rows2["name"] . "</td><td colspan=3>";
                                                                }
                                                                echo "</td></tr>";
                                                                //echo "</td></tr></table></td></tr>";
                                                                echo "<tr><td colspan=4 style=\"font-size:9pt;font-family:Tahoma;display:none;\" id=\"route" . $rows["bs_id"] . "\" >";
                                                                echo "0<u>Proposal Title:</u> " . $rows["proposal_title"] . "<br>";
                                                                //echo "</td></tr>";
                                                                /*
                                                                  echo "<tr><td><table  border='0' cellspacing='2' cellpadding='2' align='left'><tr ><td style=\"font-size:9pt;font-family:Tahoma;display:none;\" id=\"route". $rows["bs_id"] . "\" >";
                                                                  echo  "0<u>Proposal Title:</u> ". $rows["proposal_title"]."<br>";
                                                                  echo "</td></tr></table>";
                                                                 */
                                                            }
                                                        }
                                                        echo "</td></tr>";

                                                        // echo "<tr><td id='whatd'></td></tr>";
                                                    }else {
                            ?>
                                                        <tr>
                                                            <td colspan="5"><b>No bluesheets completed.</b></td>
                                                        </tr>
                            <?php
                                                    }
                            ?>

                            <?php
                                                }else {
                            ?>
                                                    <tr>
                                                        <td colspan="5"><b>No bluesheets completed.</b></td>
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