<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Toolbox";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-link4'] = "<link rel='stylesheet' href='styles/mktree.css' type='text/css'>";
$_POST['page-script1'] = "<SCRIPT LANGUAGE='JavaScript' SRC='scripts/mktree.js'></SCRIPT>";
$_POST['page-script2'] = "<script language='JavaScript' type='text/javascript' src='scripts/section_and_menu.js'></script>";
$_POST['page-script3'] = "<script language='JavaScript' type='text/javascript' src='scripts/findprofile.js'></script>";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';

$view = real_unescape($_GET['view']);
if ($view == "" || $view == '3') $view = '1';
$user_has_edit_rights = false;
$editable = false;
$pid = real_mysql_specialchars(real_unescape($_GET["pid"]), true);

$checkrights = real_can_user_edit($db_conn, $pid);
$qtype = "SELECT type_id FROM gen_profile_info WHERE pid='$pid'";
$rtype = real_execute_query($qtype, $db_conn);
$rowtype = mysql_fetch_array($rtype);
if ($rowtype["type_id"] != 1 && $view == '4') $view = '1';
if ($checkrights == false) real_redirect('editprofile.php', $pid, $db_conn);
else {
    $user_has_edit_rights = true;
    $view1 = array('Activate / Inactivate', 'Core Sections', 'Additional Sections', 'Assign Editors', '0');
    $view2 = array('Industry Clusters', 'Technology Clusters', 'Homeland Security Clusters', 'Disciplines', '0');
    $view3 = array('Add Sections', 'Remove Sections', 'Create New Sections', 'Edit Views', '0');
    $view4 = array('National Science Foundation', 'National Institute for Health', 'University Format', '0');
    include "sections/gen_activate_profile_query.php";
    include "sections/gen_editor_info_query.php";
    include "sections/gen_core_section_query.php";
    include "sections/gen_additional_section_query.php";
    include "sections/gen_cluster_info_query.php";
}
?>

<script type="text/javascript">
    <!--
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

    window.onload=function()
    {
        startList();
    }

    -->
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <?php
            if ($user_has_edit_rights == true) {
                print( "<table width='100%' border='0' cellspacing='0' cellpadding='0'> ");
                print( "<tr >");
                print( "<td background='images/tabsil.gif0' height='12' width='111' valign='bottom' align='center' ><a href='editprofile.php?pid=$pid' style='text-decoration:none'><span class='tab_menu'>Edit</span></a></td>");
                print( "<td background='images/tabsil.gif0' height='12' width='111' valign='bottom' align='center'><a href='editprofile.php?pid=$pid&onlyview=1&view=$view' style='text-decoration:none'><span class='tab_menu'>View</span></a></td>");
                print( "<td background='images/tabblu.gif0' height='12' width='111' valign='bottom' align='center' ><span class='tab_menu'>Vita Toolbox</span></td>");
                print( "<td>&nbsp;</td>");
                print( "</tr>");
                print( "<tr>");
//                print( "<td colspan='4' height='5' bgcolor='#8DB0D3'> </td>");
                print( "<td colspan='4' height='5' bgcolor='#580000'> </td>");
                print( "</tr>");
                print( "<tr>");
                print( "<td colspan='4' height='5' > </td>");
                print( "</tr>");

                print( "</table>");
            }
            ?>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr class="table_background_viewedit">
                    <td colspan="2" valign="top">
                        <div id="navcontainer">
                            <ul id="navlist">
                                <?php
                                switch ($view) {
                                    case 1:
                                        print "<li id='active'>Profile Settings</li>";
                                        print "<li><a href='customize_profile.php?pid=" . $pid . "&view=2'>Assign Profiles to Disciplines</a></li>";
                                        if ($rowtype["type_id"] == 1) print "<li><a href='customize_profile.php?pid=" . $pid . "&view=4'>Biosketches & Vitas</a></li>";
                                        break;
                                    case 2:
                                        print "<li><a href='customize_profile.php?pid=" . $pid . "&view=1'>Profile Settings</a></li>";
                                        print "<li id='active'>Assign Profiles to Disciplines</li>";
                                        if ($rowtype["type_id"] == 1) print "<li><a href='customize_profile.php?pid=" . $pid . "&view=4'>Biosketches & Vitas</a></li>";
                                        break;
                                    case 4:
                                        if ($rowtype["type_id"] == 1) {
                                            print "<li><a href='customize_profile.php?pid=" . $pid . "&view=1'>Profile Settings</a></li>";
                                            print "<li><a href='customize_profile.php?pid=" . $pid . "&view=2'>Assign Profiles to Disciplines</a></li>";
                                            print "<li id='active'>Biosketches & Vitas</li>";
                                        }
                                        break;
                                }
                                ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="172" valign="top" class="table_background_other">
                        <div id="sidenav">
                            <ul id="sidenavlist">
                                <?php
                                $i = 0;
                                switch ($view) {
                                    case 1:
                                        while ($view1[$i] != '0') {
                                            print( "<li");
                                            print("><a href='#" . $i . "'>" . $view1[$i] . "</a></li>");
                                            $i++;
                                        }
                                        break;
                                    case 2:
                                        while ($view2[$i] != '0') {
                                            print( "<li");
                                            print("><a href='#" . $i . "'>" . $view2[$i] . "</a></li>");
                                            $i++;
                                        }
                                        break;

                                    case 4:
                                        while ($view4[$i] != '0') {
                                            print( "<li");
                                            print("><a href='#" . $i . "'>" . $view4[$i] . "</a></li>");
                                            $i++;
                                        }
                                        break;
                                }
                                ?>
                                &nbsp;
                            </ul>
                        </div>
                    </td>
                    <td valign="top" >
                        <?php
                                $i = 0;
                                switch ($view) {
                                    case 1:
                                        while ($view1[$i] != '0') {
                                            print "<a name='" . $i . "' id='" . $i . "'></a>";
                                            switch ($i) {
                                                case 0:
                                                    include "sections/gen_activate_profile_display.php";
                                                    break;
                                                case 3:
                                                    include "sections/gen_editor_info_display.php";
                                                    break;
                                                case 1:
                                                    include "sections/gen_core_section_display.php";
                                                    break;
                                                case 2:
                                                    include "sections/gen_additional_section_display.php";
                                                    break;
                                            }
                                            $i++;
                                        }

                                        break;
                                    case 2:
                                        while ($view2[$i] != '0') {
                                            print "<a name='" . $i . "' id='" . $i . "'></a>";
                                            switch ($i) {
                                                case 0:
                                                    include "sections/gen_cluster_ind_display.php";
                                                    print "<br>";
                                                    break;
                                                case 1:
                                                    include "sections/gen_cluster_tech_display.php";
                                                    print "<br>";
                                                    break;
                                                case 2:
                                                    include "sections/gen_cluster_home_display.php";
                                                    print "<br>";
                                                    break;
                                                case 3:
                                                    include "sections/gen_cluster_disc_display.php";
                                                    print "<br>";
                                                    break;
                                            }
                                            $i++;
                                        }
                                        break;
                                    case 4:
                                        print "<p>";
                                        print "<span id='secname'>Biosketches</span>";
                                        print "<table border=0 align=center width=90%><tr><td>";
                                        print "<span id='secname'>National Science Foundation (NSF) Vitae</span><br>";
                                        //print "<span id='secdetail'><a href='./rtf_new/nsf_rtfdata.php?pid=" . $pid . "'>One Click Generation of Biographical Sketch </a> &nbsp;&nbsp; | Step by Step Builder (under construction) </span>";
                                        print "<span id='secdetail'><a href='./rtf_new/publications.php?pid=" . $pid . "&target=nsf' target='_blank'>One Click Generation of Biographical Sketch </a> &nbsp;&nbsp;</span>";
                                        print "</td></tr><tr><td></td></tr><tr><td>";
                                        print "<span id='secname'>National Institutes of Health (NIH) Biographical Sketch</span><br>";
                                        //print "<span id='secdetail'><a href='./rtf_new/nih_rtfdata.php?pid=" . $pid . "'>One Click Generation of Curriculum vitae </a> &nbsp;&nbsp; | <a href='nih.php?pid=" . $pid . "' target='blank'>Step by Step builder (under construction)</a></span>";
                                        print "<span id='secdetail'><a href='./rtf_new/publications.php?pid=" . $pid . "&target=nih&relevant=1' target='_blank'>One Click Generation of Curriculum vitae </a> &nbsp;&nbsp;</span>";
                                        print "</td></tr>";
                                        print "</table>";
                                        print "</p>";
                                        //university format
                                        print "<p>";
                                        print "<span id='secname'>Vitas</span>";
                                        print "<table border=0 align=center width=90%><tr><td>";
                                        print "<span id='secname'>University Vita Format</span><br>";
                                        print "<span id='secdetail'><a href='./rtf_new/new_rtfdata.php?pid=" . $pid . "'>One Click Generation of Vita in Word Format (Auto Fill)</a>  &nbsp;&nbsp; | <a href='nih4rtf.php?pid=" . $pid . "' target='blank'>Step by Step builder</a></span>";
                                        print "</td></tr>";
                                        print "</table>";
                                        print "</p>";
                                        

                                        while ($view4[$i] != '0') {
                                            print "<a name='" . $i . "' id='" . $i . "'></a>";
                                            $i++;
                                        }
                                        break;
                                }
                        ?>
                    </td>
                </tr>
            </table>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr><!-- Page footer -->
        <td align="center">
            <p align="center"><img src="images/line.jpg" alt="" width="700" height="1"/></p>
            <p>
                <a href="http://www.txstate.edu/research" target="_blank" class="rsp">powering - The Partnership</a><br />
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
<!-- InstanceEnd -->
</html>