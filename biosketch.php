<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
if ($_SESSION["UID"] != "") {
    real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
}

$_POST['page-title'] = "NIH Biographical Sketch - Step by Step Builder";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';

$pid = $_GET["pid"];
//$pid=1;
if ($pid != "") {
    //query and result set for general information
    $q1 = "SELECT f_name, m_name, l_name, designation FROM ppl_general_info WHERE pid=" . real_mysql_specialchars($pid, false);
    $res1 = real_execute_query($q1, $db_conn);
    $r1 = mysql_fetch_array($res1);

    //query and result set for education/training
    $q2 = "SELECT * FROM ppl_prof_preparation WHERE pid=" . real_mysql_specialchars($pid, false);
    $res2 = real_execute_query($q2, $db_conn);

    $q3 = "SELECT * FROM ppl_appointment WHERE pid=" . real_mysql_specialchars($pid, false) . " ORDER BY s_date ASC, e_date ASC";
    $res3 = real_execute_query($q3, $db_conn);

    $q4 = "SELECT * FROM ppl_publication WHERE pid=" . real_mysql_specialchars($pid, false) . " ORDER BY group_by ASC, year DESC";
    $res4 = real_execute_query($q4, $db_conn);

    $q5 = "SELECT * FROM ppl_support WHERE pid=" . real_mysql_specialchars($pid, false) . " ORDER BY prj_status ASC";
    $res5 = real_execute_query($q5, $db_conn);
}else {
    exit();
}
?>
<script type="text/javascript">
    <!--
    var timer;
    startList = function()
    {
        if (document.all&&document.getElementById)
        {
            navRoot = document.getElementById("nav");
            for (i=0; i<navRoot.childNodes.length; i++)
            {
                node = navRoot.childNodes[i];
                if (node.nodeName=="LI")
                {
                    node.onmouseover=function()
                    {
                        this.className+=" over";
                    }
                    node.onmouseout=function()
                    {
                        this.className=this.className.replace(" over", "");
                    }
                }
            }
        }
    }
    function enable(no,value)
    {
        alert('hi');
        var fieldname='rank_other_'+no
        if(document.getElementById(fieldname).disabled=true || value='Other')
        {
            document.getElementById(fieldname).disabled=false
            document.getElementById(fieldname).focus();
            document.getElementById(fieldname).select();

        }
        else
        {
            if(document.getElementById(fieldname).disabled=false)
            {
                document.getElementById(fieldname).disabled=true
            }
        }
    }

    window.onload=function()
    {
        startList();
    }


    //-->
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <!-- content goes here -->
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <form name="frmNih" id="frmNih" method="post" action="testfpdfi.php">
                <table width="100%"  border="0" cellpadding="1" cellspacing="1" class="table_content">
                    <tr>
                        <td><div align="center">
                                <table width="95%"  border="0" cellspacing="1" cellpadding="1">
                                    <tr>
                                        <td width="25%"><div align="left">
                                                <input name="l_name" type="text" class="form_elements" id="l_name" value="<?php print($r1["l_name"]);?>" size="30">
                                            </div></td>
                                        <td width="25%"><div align="left">
                                                <input name="f_name" type="text" class="form_elements" id="f_name" value="<?php print($r1["f_name"]);?>" size="30">
                                            </div></td>
                                        <td width="25%"><div align="left">
                                                <input name="m_name" type="text" class="form_elements" id="m_name" value="<?php print($r1["m_name"]);?>" size="30">
                                            </div></td>
                                        <td width="25%"><div align="left">
                                                <input name="era_name" type="text" class="form_elements" id="era_name" size="30" />
                                            </div></td>
                                    </tr>
                                    <tr class="form_elements_section_subheader">
                                        <td><div align="left">Last Name * </div></td>
                                        <td><div align="left">First Name*</div></td>
                                        <td><div align="left">Middle Name </div></td>
                                        <td><div align="left">eRA Commons User Name </div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="font_orange"><div align="left"></div></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"> <div align="left"><span class="form_elements_section_subheader">Designation*</span>:
                                                <input name="designation" type="text" class="form_elements" id="designation" value="<?php print($r1["designation"]);?>" size="70">
                                            </div></td>
                                    </tr>
                                </table>
                            </div></td>
                    </tr>
                    <tr>
                        <td><div align="center">
                                <table width="95%"  border="0" cellspacing="1" cellpadding="1">
                                    <tr class="table_background">
                                        <td colspan="5"><div align="left"><span class="font_on_dark_blue">Education/Training</span></div></td>
                                    </tr>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="2"><div align="left">Institution and Location* </div></td>
                                        <td><div align="left">Degree</div></td>
                                        <td><div align="left">Year(s)</div></td>
                                        <td><div align="left">Field of Study </div></td>
                                    </tr>
                                    <?php
                                    $count2 = 0;
                                    while ($r2 = mysql_fetch_array($res2)) {
                                        $count2 = $count2 + 1;
                                    ?>
                                        <tr>
                                            <td colspan="2"><div align="left">
                                                    <input name="inst_loc_<?php print $count2;?>" type="text" class="form_elements" id="inst_loc_<?php print $count2;?>" value="<?php print($r2["institution"]);?>" size="30" />
                                                </div></td>
                                            <td width="15%"><div align="left">
                                                    <input name="degree_<?php print $count2;?>" type="text" class="form_elements" id="degree_<?php print $count2;?>" value="<?php print($r2["degree"]);?>" size="30" />
                                                </div></td>
                                            <td width="15%"><div align="left">
                                                    <input name="year_<?php print $count2;?>" type="text" class="form_elements" id="year_<?php print $count2;?>" value="<?php print($r2["year"]);?>" size="30" />
                                                </div></td>
                                            <td width="53%"><div align="left">
                                                    <input name="major_<?php print $count2;?>" type="text" class="form_elements" id="major_<?php print $count2;?>" value="<?php print($r2["major"]);?>" size="30" />
                                                </div></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="2"><div align="left">
                                                <input name="count2" type="hidden" value="<?php print $count2;?>" />
                                            </div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                    </tr>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="5"><hr width="100%" class="details" /></td>
                                    </tr>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="5"><div align="left"></div>
                                            <div align="left"></div>
                                            <div align="left">NOTE: The Biographical Sketch may not exceed four pages. Items A and B (together) may not exceed two of the four-page limit. Floolw the formats and instructions on the attached sample. </div></td>
                                    </tr>
                                    <tr class="table_background">
                                        <td colspan="5"><div align="left"><span class="font_on_dark_blue">A. <strong>Positions and Honors.</strong> List in chronological order previous positions, concluding with your present position. List any honors. Include present membership on any Federal Government public advisory committee </span></div></td>
                                    </tr>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="2"><div align="left">Start Date</div></td>
                                        <td><div align="left">End Date</div></td>
                                        <td><div align="left">Rank</div></td>
                                        <td><div align="left">Institution/Organization</div></td>
                                    </tr>
                                    <?php
                                    $count3 = 0;
                                    while ($r3 = mysql_fetch_array($res3)) {
                                        $count3 = $count3 + 1;
                                    ?>
                                        <tr>
                                            <td colspan="2"><div align="left">
                                                    <input name="s_date_<?php print $count3;?>" type="text" class="form_elements" id="inst_loc_<?php print $count3;?>" value="<?php print($r3["s_date"]);?>" size="30" />
                                                </div></td>
                                            <td width="15%"><div align="left">
                                                    <input name="e_date_<?php print $count3;?>" type="text" class="form_elements" id="degree_<?php print $count3;?>" value="<?php print($r3["e_date"]);?>" size="30" />
                                                </div></td>
                                            <td width="15%"><div align="left">
                                                    <input name="rank_<?php print $count3;?>" type="text" class="form_elements" id="year_<?php print $count3;?>" value="<?php print($r3["rank"]);?>" size="30" />
                                                </div></td>
                                            <td width="53%"><div align="left">
                                                    <input name="inst_<?php print $count3;?>" type="text" class="form_elements" id="major_<?php print $count3;?>" value="<?php
                                        print $r3["dept_school"];
                                        if ($r3["dept_school"] != '') print ", ";
                                        print $r3["off_school"];
                                        if ($r3["off_school"] != '') print ", ";
                                        print($r3["univ_comp"]);?>" size="60" />
                                            </div></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="2"><div align="left">
                                                <input name="count3" type="hidden" value="<?php print $count3;?>" />
                                            </div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                    </tr>
                                    <tr class="table_background">
                                        <td colspan="5"><div align="left"><span class="font_on_dark_blue">B. <strong>Selected peer-reviewed publications </strong>(in chronological order) <strong>. </strong>Do not include publications submitted or in preparation. </span></div></td>
                                    </tr>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="2"><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                    </tr>
                                    <?php
                                    $count4 = 0;
                                    while ($r4 = mysql_fetch_array($res4)) {
                                        $count4 = $count4 + 1;
                                        if ($count4 < 10) $padding = "&nbsp;&nbsp;";
                                        else $padding="&nbsp;";
                                    ?>
                                        <tr>
                                            <td colspan="5" valign="top"><div align="left"><span class="form_elements_section_subheader"><?php print($count4 . ")" . $padding);?></span>
                                                    <textarea name="pub_<?php print $count4;?>" cols="165" rows="2" class="form_elements_text"><?php print(strip_tags($r4["name"]));?></textarea>
                                                </div></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="2"><div align="left">
                                                <input name="count4" type="hidden" value="<?php print $count4;?>" />
                                            </div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                    </tr>
                                    <tr class="table_background">
                                        <td colspan="5"><div align="left"><span class="font_on_dark_blue">C. <strong>Research Support . </strong>List selected ongoing or completed (during the last three years) research projects (federal and non-federal support). Begin with projects that are most relevant to the research proposed in this application. Briefly indicate the overall goals of the projects and your role (e.g. PI, Co-Investigator, Consultant) in the research project. Do not list award amounts or percent effort in projects. </span></div></td>
                                    </tr>
                                    <?php
                                    $count5 = 0;
                                    $status = 0;
                                    while ($r5 = mysql_fetch_array($res5)) {
                                        $count5 = $count5 + 1;
                                        $newstatus = $r5["prj_status"];
                                        if ($status != $newstatus) {
                                            $status = $newstatus;
                                            $subcount = $subcount + 1;
                                            if ($status == 1) {
                                                $title = "Ongoing Research Support";
                                            }else {
                                                if ($status == 2) {
                                                    $title = "Completed Research Support";
                                                }else {
                                                    if ($status = 3) {
                                                        $title = "Pending Research Support";
                                                    }
                                                }
                                            }
                                            print "<tr>" .
                                                "<td colspan='4' valign='top'><div align='left'><span class='form_elements_section_subheader'>" . $title . "<span></div></td>" .
                                                "</tr>";
                                        }
                                    ?>
                                        <tr>
                                            <td width="2%" class="form_elements_section_subheader"><?php print $count5 . ")&nbsp;";?>&nbsp;
                                                <div align="left"></div></td>
                                            <td width="15%" class="list_others"><div align="left">Duration:</div></td>
                                            <td colspan="3"><div align="left">
                                                    <input name="duration_<?php print $count5;?>" type="text" class="form_elements_text" id="duration_<?php print $count5;?>" value="<?php print($r5["s_date"] . " - " . $r5["e_date"]);?>" size="30" />
                                                </div></td>
                                        </tr>
                                        <tr>
                                            <td class="form_elements_section_subheader"><div align="left"></div></td>
                                            <td class="list_others"><div align="left">Sponsor:</div></td>
                                            <td colspan="3"><div align="left"></div>
                                                <div align="left"></div>
                                                <div align="left">
                                                    <input name="spon_<?php print $count5;?>" type="text" class="form_elements_text" id="spon_<?php print $count5;?>" value="<?php print($r5["sponsor"]);?>" size="30" />
                                                </div></td>
                                        </tr>
                                        <tr>
                                            <td class="form_elements_section_subheader"><div align="left"></div></td>
                                            <td class="list_others"><div align="left">Title:</div></td>
                                            <td colspan="3"><div align="left">
                                                    <input name="title_<?php print $count5;?>" type="text" class="form_elements_text" id="title_<?php print $count5;?>" value="<?php print($r5["title"]);?>" size="90" />
                                                </div></td>
                                        </tr>
                                        <tr>
                                            <td class="form_elements_section_subheader"><div align="left"></div></td>
                                            <td class="list_others"><div align="left">Abstract/Goal:</div></td>
                                            <td colspan="3"><div align="left">
                                                    <textarea name="goal_<?php print $count5;?>" cols="150" rows="2" class="form_elements_text" id="goal_<?php print $count5;?>"><?php print($r5["prj_abstract"]);?></textarea>
                                                </div></td>
                                        </tr>
                                        <tr>
                                            <td class="form_elements_section_subheader"><div align="left"></div></td>
                                            <td class="list_others"><div align="left">Role:</div></td>
                                            <td colspan="3"><div align="left">
                                                    <input name="role_<?php print $count5;?>" type="radio" value="PI" checked="checked" />
                                                    <span class="form_elements_text">Personal Investigator (PI)&nbsp;&nbsp;
                                                        <input name="role_<?php print $count5;?>" type="radio" value="Co-Investigator" />
                                                        Co - Investigator (Co-PI) &nbsp;&nbsp;
                                                        <input name="role_<?php print $count5;?>" type="radio" value="Consultant" />
                                                        Consultant&nbsp;&nbsp;
                                                        <input name="role_<?php print $count5;?>" type="radio" value="Other" onselect="enable(<?php print $count5;?>,'Other');"/>
                                                        Other
                                                        <input name="role_other_<?php print $count5;?>" type="text" class="form_elements" id="role_other_<?php print $count5;?>" size="30"/>
                                                    </span></div></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" valign="top"><div align="left"><input name="status_<?php print $count5;?>" type="hidden" value="<?php print $r5["prj_status"];?>" /></div></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="2"><div align="left">
                                                <input name="count5" type="hidden" value="<?php print $count5;?>" />
                                            </div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                        <td><div align="left"></div></td>
                                    </tr>
                                    <tr class="form_elements_section_subheader">
                                        <td colspan="5" class="font_orange"><div align="left">
                                                <hr width="100%" class="details" />
                                            </div></td>
                                    </tr>
                                </table>
                            </div></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="table_footer"><div align="center">
                                <input name="Submit" type="submit" class="table_background_viewedit" value="Preview" />
                            </div></td>
                    </tr>
                </table>
            </form>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="table_background">
            <!-- Partnership text in this section with the hyperlink should remain visible on the template page and should not deleted -->
            <div align="right"><a href="http://www.uta.edu/collaborate" target="_blank"><span class="font_on_dark_blue"><strong>powering - The Partnership</strong></span></a></div>
            <!-- End of Partnership text -->
        </td>
    </tr>
    <!-- footer content goes here -->
    <tr>
        <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy;2006 The University of Texas at Arlington | <a href="http://www.uta.edu/research/webteam">Electronic Research Administration</a>, 219 ATI Box 19145, Arlington, Texas 76019-0145 Voice: 817.272.3896 | Fax: 817.272.5808 | <a href="feedback.php">Site Feedback</a> | <a href="http://www.uta.edu/research/webteam">Contact Electronic Research Administration - Web Team</a><br />
                </font></div>
            <!-- Start of StatCounter Code
    This spot can be used to enter tracking coutner code. Recommended: http://www.statcounter.com
    End of StatCounter Code -->
        </td>
        <!--end of footer -->
    </tr>
    <tr>
        <td bgcolor="#D7CFCD" class="form_elements_row_action"> <div align="center"><span class="error_message">Important Disclaimer: </span><strong>The responsibility for the accuracy of the information contained on these pages lies with the authors and user providing such information. </strong></div></td>
    </tr>
</table>
</body>
<!-- InstanceEnd -->
</html>