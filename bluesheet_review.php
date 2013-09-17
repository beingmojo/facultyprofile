<?php
$is_ogcs_admin = real_check_user_groupid($db_conn, "ogcs_admin");
$blue_view = 2;
include "bluesheet_header.php";
$main_view = $_GET['view'];
?>

<script type="text/javascript">
    function toggle(elID)
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

<table width="90%"  border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
        <td>
            <table width="100%">
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
            <table width="100%"   cellspacing="2" cellpadding="2" align="left">
                <tr>
                    <td colspan="5" class='table_content'>
                        <table width="100%">
                            <tr>
                                <td>
                                    <span class='font_topic'>BlueSheets for Review</span>
                                </td>
                                <td width="300" align="right">

                                    <?php
                                    $page = $_GET['page'];
                                    if ($is_ogcs_admin) {
                                        $query = "SELECT count(*) as no_rec FROM bs_info WHERE bs_status='Submitted'";
                                    }else {
                                        $uid = $_SESSION['UID'];
                                        $query = "SELECT count(*) as no_rec FROM bs_routing WHERE loginid=$uid";
                                    }
                                    include "bluesheet_sort.php";
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                <tr>
                    <td colspan="5">
                        <div style="font-size:11px;">
				  					This section contains bluesheets that need your approval.
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000000;" width="30%" class="form_elements_text"><b><a href='researchspace.php?view=<?php echo $main_view?>&blue_view=2&investigator=<?php echo $order?>'>Investigator</a></b></td>
                            <td style="border-bottom:1px solid #000000;" width="20%" class="form_elements_text"><b>Status</b></td>
                            <td style="border-bottom:1px solid #000000;" width="25%" class="form_elements_text"><b><a href='researchspace.php?view=<?php echo $main_view?>&blue_view=2&submiton=<?php echo $order?>'>Submitted On</a></b></td>
                            <td style="border-bottom:1px solid #000000;" width="25%" class="form_elements_text"><b>Actions</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%" border="0">
<?php
                                    $page = $_GET['page'];
                                    if (!($page > 0)) {
                                        $page = 0;
                                    }
                                    $order_by = $_SESSION['sort_orderby'];

                                    if ($is_ogcs_admin) {

                                        $query = "SELECT *, DATE_FORMAT(bs_timestamp,'%m/%d/%Y %r') as bs_timestamp1 FROM bs_info bsi ,bs_i_info info WHERE bs_status='Submitted' and bsi.bs_id=info.bs_id and info.i_id = 1 order by $sort_view $order_by limit $page,15";

                                        $results = real_execute_query($query, $db_conn);
                                        if (mysql_num_rows($results) > 0) {
                                            while ($rows = mysql_fetch_array($results)) {
                                                $query = "SELECT name FROM bs_i_info WHERE bs_id=" . $rows["bs_id"] . " AND i_id = " . $rows["pi_id"];
                                                $results2 = real_execute_query($query, $db_conn);
                                                if ($rows2 = mysql_fetch_array($results2)) {
                                                    if ($last_bs_id != $rows["bs_id"]) {
                                                        if ($rows["copi_flag"] == "0") $man_route = "<img src='bluesheet/images/redflag.PNG' alt='Needs manual routing'>";
                                                        else $man_route = " &nbsp; &nbsp; ";
                                                        //echo "<tr><td><table width=100%  cellspacing='2' cellpadding='2' align='left'>" .
                                                        echo "<tr style=font-size:9pt;font-family:Tahoma;background-color:#F3F3F3;>" .
                                                        "<td width=30% style=cursor:pointer; onmouseover=\"document.getElementById('r" . $rows["bs_id"] . "').style.textDecoration = 'underline';\" onmouseout=\"document.getElementById('r" . $rows["bs_id"] . "').style.textDecoration = 'none';\" " . "onclick=\"toggle('route" . $rows["bs_id"] . "');\"><b>" . "<img src=\"images/arrow_up.jpg.png\"> <span id=r" . $rows["bs_id"] . ">" . $rows2["name"] . "</span></b></td><td width=20% style='padding-left: 2px;'>" . $man_route . " ";

                                                        $last_bs_id = $rows["bs_id"];
                                                        echo $rows["bs_status"] . "</td><td width=25%>" . $rows["bs_timestamp1"] . "</td>";
                                                        echo "<td width=25%><a href=\"bluesheet/bs_template.php?pid=" . $rows["pid"] . "&edit=1&view=1&bs_id=" . $rows["bs_id"] . "\">View</a> &nbsp; &nbsp; " . "<a href=\"bluesheet/bs_template.php?pid=" . $rows["pid"] . "&edit=1&bs_id=" . $rows["bs_id"] . "\">Edit</a> &nbsp; &nbsp; " . "<a href=\"bluesheet/bs_save.php?route=1&bs_id=" . $rows["bs_id"] . "\">Route</a>";
                                                        $login_id = $_SESSION['UID'];
                                                    }
                                                    else {
                                                        echo "<tr style=font-size:9pt;font-family:Tahoma;><td>&nbsp; &nbsp; &nbsp;" . $rows2["name"] . "</td><td colspan=3>";
                                                    }
                                                    echo "</td></tr>";
                                                    //echo "</td></tr></table></td></tr>";
                                                    echo "<tr><td colspan=4 style=\"font-size:9pt;font-family:Tahoma;display:none;\" id=\"route" . $rows["bs_id"] . "\">";
                                                    echo "<u>Proposal Title:</u>" . $rows["proposal_title"] . "<br>";
                                                }
                                            }
                                            echo "<input type='hidden' id= 'hiddenbs_id' >";
                                            echo "</td></tr>";
                                            // echo "<tr><td id='whatd'></td></tr>";
                                        }else {
?>
                                            <tr>
                                                <td colspan="5"><b>No bluesheets routed.</b></td>
                                            </tr>
                <?php
                                        }
                ?>
                                    </table>
                                </td>
                            </tr>
                <?php
                                    }else {
                                        if ($sort_view == "bs_timestamp") $sort_view1 = "timestamp";
                                        else $sort_view1 = $sort_view;

                                        $last_bs_id = 0;
                                        $query = "SELECT login_id FROM ppl_general_info WHERE pid=$pid";
                                        $results = real_execute_query($query, $db_conn);
                                        while ($rows = mysql_fetch_array($results)) {
                                            $login_id = $rows["login_id"];
                                        }
                                        $query = "SELECT *,bsi.i_id as numid FROM bs_routing bsi ,bs_i_info info WHERE bsi.loginid='$login_id' and bsi.bs_id=info.bs_id and info.i_id = 1 order by status DESC,$sort_view1 $order_by,bsi.bs_id,bsi.i_id limit $page,15 "; //status desc, bs_id, i_id";
                                        $results = real_execute_query($query, $db_conn);
                                        if (mysql_num_rows($results) > 0) {
                                            while ($rows = mysql_fetch_array($results)) {
                                                // get the bluesheets ID to pull up more information on them so that we
                                                // can display it on the web page.
                                                if ($rows["status"] != "Not Required") {
                                                    $query = "SELECT DATE_FORMAT(bs_timestamp,'%m/%d/%Y %r') as bs_timestamp, pi_id,proposal_title, copi_flag FROM bs_info WHERE bs_id = " . $rows["bs_id"];
                                                    $results1 = real_execute_query($query, $db_conn);
                                                    if ($rows1 = mysql_fetch_array($results1)) {

                                                        $query = "SELECT name FROM bs_i_info WHERE bs_id=" . $rows["bs_id"] . " AND i_id = " . $rows["numid"];
                                                        $results2 = real_execute_query($query, $db_conn);
                                                        if ($rows2 = mysql_fetch_array($results2)) {
                                                            if ($last_bs_id != $rows["bs_id"]) {
                                                                if ($rows1["copi_flag"] == "0") $man_route = "<img src='bluesheet/images/redflag.PNG' alt='Needs manual routing'> ";
                                                                else $man_route = " &nbsp; &nbsp; ";

                                                                echo "<tr style=font-size:9pt;font-family:Tahoma;background-color:#F3F3F3;cursor:pointer;  onmouseover=\"document.getElementById('r" . $rows["bs_id"] . "').style.textDecoration = 'underline';\" onmouseout=\"document.getElementById('r" . $rows["bs_id"] . "').style.textDecoration = 'none';\" " . "onclick=\"toggle('route" . $rows["bs_id"] . "');\"><td width=30%><span id='r" . $rows["bs_id"] . "'>" . $rows2["name"] . "</span></td><td width=21%>" . $man_route;
                                                                $last_bs_id = $rows["bs_id"];

                                                                if ($rows["status"] == "Denied") echo "Returned";
                                                                else echo $rows["status"];
                                                                echo "</td><td width=26%>" . $rows1["bs_timestamp"] . "</td>" . "<td width=25%><a href=\"bluesheet/review.php?id=" . $rows["bs_id"] . "-$login_id\">View</a>";
                                                                //echo "</td></tr></table></td></tr>";
                                                                echo "</td></tr>";
                                                            }
                                                            else {
                                                                echo "<tr style=font-size:9pt;font-family:Tahoma;><td>&nbsp; &nbsp; &nbsp;" . $rows2["name"] . "</td><td colspan=3>";
                                                                echo "</td></tr>";
                                                            }
                                                            //echo "</td></tr></table></td></tr>";
                                                        }
                                                        echo "<tr><td colspan=4><table width=100%  border='0' cellspacing='2' cellpadding='2' align='left'><tr style=\"font-size:9pt;font-family:Tahoma;display:none;\" id=\"route" . $rows["bs_id"] . "\">" . "<td style=\"border-bottom:1px dotted #000000;\" colspan=4>";
                                                        echo "<u>Proposal Title</u>: " . $rows1["proposal_title"] . "<br>";
                                                        echo "</td></tr></table>";
                                                    }
                                                    echo "<input type='hidden' id= 'hiddenbs_id' >";
                                                    echo "</td></tr>";
                                                }else {
                                                    $dataset = real_get_pplc('utaID', $rows["i_loginid"], $_ldap_search_dn_ppl);
                                                    echo "<tr style=font-size:9pt;font-family:Tahoma;background-color:#F3F3F3;><td>" . ucwords($dataset[0][0]) . "</td><td>Not Required</td><td>&nbsp;</td><td>&nbsp;</td>";
                                                }
                                            }
                                        }else {
                ?>
                                            <tr>
                                                <td colspan="5"><b>No bluesheets available for review.</b></td>
                                            </tr>
    <?php
                                        }
                                    }
    ?>
</table>	
</td>
</tr>
</table>