<?php  
include 'utils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
$view=real_unescape($_GET['view']);
if($view=="" || $view=='3')
    $view='1';
$user_has_edit_rights = false;
$editable=false;
$pid = real_mysql_specialchars(real_unescape( $_GET[ "pid" ] ), true);

$checkrights=real_can_user_edit( $db_conn, $pid );
$qtype="SELECT type_id FROM gen_profile_info WHERE pid='$pid'";
$rtype=real_execute_query($qtype,$db_conn);
$rowtype = mysql_fetch_array($rtype);
if($rowtype["type_id"]!=1 && $view=='4')
    $view='1';
if($checkrights==false)
    real_redirect( 'editprofile.php', $pid, $db_conn );
else {
    $user_has_edit_rights = true;
    $view1 = array('Activate / Inactivate','Core Sections','Additional Sections','Assign Editors','0');
    $view2 = array('Industry Clusters','Technology Clusters','Homeland Security Clusters','Disciplines','0');
    $view3 = array('Add Sections','Remove Sections','Create New Sections','Edit Views','0');
    $view4 = array('National Science Foundation','National Institute for Health','University Format','Vita Builder','0');
    include "sections/gen_activate_profile_query.php";
    include "sections/gen_editor_info_query.php";
    include "sections/gen_core_section_query.php";
    include "sections/gen_additional_section_query.php";
    include "sections/gen_cluster_info_query.php";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/level1.dwt.php" codeOutsideHTMLIsLocked="false" -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <!-- InstanceBeginEditable name="title" -->
        <SCRIPT LANGUAGE="JavaScript" SRC="scripts/mktree.js">
        </SCRIPT>
        <link rel="stylesheet" href="styles/mktree.css" type="text/css">
            <title>Research Profile System - (Toolbox) - Texas State University - San Marcos</title>
            <!-- InstanceEndEditable -->
            <link href="styles/style1.css" rel="stylesheet" type="text/css" />
            <link href="styles/list.css" rel="stylesheet" type="text/css" />
            <!-- InstanceBeginEditable name="script" -->
            <script language="JavaScript" type="text/javascript" src="scripts/section_and_menu.js"></script>
            <script language="JavaScript" type="text/javascript" src="scripts/findprofile.js"></script>

            </SCRIPT>
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
            <!-- InstanceEndEditable -->
            <!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
    </head>
    <body>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
            <tr>
                <td height="3" colspan="2" class="table_background">
                    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><div align="left"><img src="images/rspbanner.jpg" alt="Research Profile" width="751" height="95" align="left" /></div>
                            </td>
                            <td>
                                <form action="searchresults.php" method="get" enctype="application/x-www-form-urlencoded">
                                    <label for="search"><span style="visibility:hidden">label</span><input name="search" type="text" class="form_elements" id="search" size="15" /></label>
                                    <label for="submitbutton"><span style="visibility:hidden">label</span><input name="Submit" id="submitbutton" type="submit" class="form_elements_row_action" value="Quick Search" /></label>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width='30%' align="left" class="table_background_other"><!-- InstanceBeginEditable name="pagename" -->
                    <div align="left" class="page_heading">&nbsp;Toolbox</div>
                    <!-- InstanceEndEditable --></td>
                <td valign="top" class="table_background_other" align='right'>
                    <div id="menu">
                        <ul id="nav">
                            <li>
<?php
                                print( "<a href='{$_home}/index.php'>Home</a>" );
                                if( $_SESSION["UID"] != "" ) {
                                    print( "<ul><li><a href='researchspace.php'>Research Space</a></li>");
                                    print( "<li><a href='logoff.php'>Logoff</a></li></ul>" );
                                }
                                ?>
                            </li>
                            <li><a href="browseprofiles.php?view=1">Browse </a>
                                <ul>
                                    <li><a href="browseprofiles.php?view=1">Faculty</a></li>
                                    <li><a href="browseprofiles.php?view=2">Center</a></li>
                                    <li><a href="browseprofiles.php?view=3">Technology</a></li>
                                    <li><a href="browseprofiles.php?view=4">Facility</a></li>
                                    <li><a href="browseprofiles.php?view=5">Equipment</a></li>
                                    <li><a href="browseprofiles.php?view=6">Labs &amp; Groups</a></li>
                                    <li><a href="courses.php">Courses</a></li>
                                </ul>
                            </li>
                            <li><a href="newsearch.php">Search </a>
                                <ul>
                                    <li><a href="newsearch.php">Basic</a></li>
                                    <li><a href="clustersearch.php">Cluster</a></li>
                                    <li><a href="advsearch.php">Advanced</a></li>
                                </ul>
                            </li>
                            <li><a href="aboutrsp.php">Support</a>
                                <ul>
                                    <li><a href="aboutrsp.php">About rSp</a></li>
                                    <li><a href="help/index.php">Help and FAQ's</a></li>
                                    <li><a href="feedback.php">Contact Us</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>

                </td>
            </tr>
            <!-- content goes here -->
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <!-- InstanceBeginEditable name="content" -->
<?php
                    if( $user_has_edit_rights == true ) {
                        print( "<table width='100%' border='0' cellspacing='0' cellpadding='0'> " );
                        print( "<tr >" );
                        print( "<td background='images/tabsil.gif' height='12' width='111' valign='bottom' align='center' ><a href='editprofile.php?pid=$pid' style='text-decoration:none'><span class='tab_menu'>Edit</span></a></td>" );
                        print( "<td background='images/tabsil.gif' height='12' width='111' valign='bottom' align='center'><a href='editprofile.php?pid=$pid&onlyview=1&view=$view' style='text-decoration:none'><span class='tab_menu'>View</span></a></td>" );
                        print( "<td background='images/tabblu.gif' height='12' width='111' valign='bottom' align='center' ><span class='tab_menu'>Toolbox</span></td>" );
                        print( "<td>&nbsp;</td>" );
                        print( "</tr>" );
                        print( "<tr>" );
                        print( "<td colspan='4' height='5' bgcolor='#8DB0D3'> </td>" );
                        print( "</tr>" );
                        print( "<tr>" );
                        print( "<td colspan='4' height='5' > </td>" );
                        print( "</tr>" );

                        print( "</table>" );
                    }
                    ?>
                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr class="table_background_viewedit">
                            <td colspan="2" valign="top">
                                <div id="navcontainer">
                                    <ul id="navlist">
<?php
switch($view) {
                                            case 1:
                                                print "<li id='active'>Profile Settings</li>";
                                                print "<li><a href='customize_profile.php?pid=".$pid."&view=2'>Assign Profiles to Disciplines</a></li>";
                                                if($rowtype["type_id"]==1)
                                                    print "<li><a href='customize_profile.php?pid=".$pid."&view=4'>Biosketches & Vitas</a></li>";
                                                break;
                                            case 2:
                                                print "<li><a href='customize_profile.php?pid=".$pid."&view=1'>Profile Settings</a></li>";
                                                print "<li id='active'>Assign Profiles to Disciplines</li>";
                                                if($rowtype["type_id"]==1)
                                                    print "<li><a href='customize_profile.php?pid=".$pid."&view=4'>Biosketches & Vitas</a></li>";
                                                break;
                                            case 4:
                                                if($rowtype["type_id"]==1) {
                                                    print "<li><a href='customize_profile.php?pid=".$pid."&view=1'>Profile Settings</a></li>";
                                                    print "<li><a href='customize_profile.php?pid=".$pid."&view=2'>Assign Profiles to Disciplines</a></li>";
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
$i=0;
switch($view) {
    case 1:
                                                while($view1[$i]!='0') {
                                                    print( "<li" );
                                                    print("><a href='#" . $i ."'>" . $view1[$i] . "</a></li>" );
                                                    $i++;
                                                }
                                                break;
                                            case 2:
                                                while($view2[$i]!='0') {
                                                    print( "<li" );
                                                    print("><a href='#" . $i ."'>" . $view2[$i] . "</a></li>" );
                                                    $i++;
                                                }
                                                break;

                                            case 4:
                                                while($view4[$i]!='0') {
                                                    print( "<li" );
                                                    print("><a href='#" . $i ."'>" . $view4[$i] . "</a></li>" );
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
                                        $i=0;
                                        switch($view) {
    case 1:
        while($view1[$i]!='0') {
            print "<a name='".$i."' id='" .$i. "'></a>";
            switch($i) {
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
                                        while($view2[$i]!='0') {
                                            print "<a name='".$i."' id='" .$i. "'></a>";
                                            switch($i) {
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
                                        print "<span id='secdetail'><a href='./rtf_new/nsf_rtfdata.php?pid=".$pid."'>One Click Generation of Biographical Sketch (under construction)</a> &nbsp;&nbsp; | Step by Step Builder (under construction) </span>";
                                        print "</td></tr><tr><td></td></tr><tr><td>";
                                        print "<span id='secname'>National Institutes of Health (NIH) Biographical Sketch</span><br>";
                                        print "<span id='secdetail'><a href='./rtf_new/nih_rtfdata.php?pid=".$pid."'>One Click Generation of Curriculum vitae (under construction)</a> &nbsp;&nbsp; | <a href='nih.php?pid=".$pid."' target='blank'>Step by Step builder</a></span>";
                                        print "</td></tr>";
                                        print "</table>";
                                        print "</p>";
                                        //university format
                                        print "<p>";
                                        print "<span id='secname'>Vitas</span>";
                                        print "<table border=0 align=center width=90%><tr><td>";
                                        print "<span id='secname'>University Vita Format</span><br>";
                                        print "<span id='secdetail'><a href='./rtf_new/new_rtfdata.php?pid=".$pid."'>One Click Generation of Vita in Word Format (Auto Fill)</a>  &nbsp;&nbsp; | <a href='nih4rtf.php?pid=".$pid."' target='blank'>Step by Step builder</a>(under construction)</span>";
                                        print "</td></tr>";
                                        print "</table>";
                                        print "</p>";
                                        //performance evaluation
                                        print "<p>";
                                        print "<span id='secname'>Performance Evaluation</span>";
                                        print "<table border=0 align=center width=90%><tr><td>";
                                        print "<span id='secdetail'><a href='rtf_new/performance_evaluation'>One Click Generation </a>(under construction)  &nbsp;&nbsp; | <a href='#'>Step by Step builder</a>(under construction)</span>";
                                        print "</td></tr>";
                                        print "</table>";
                                        print "</p>";

                                        while($view4[$i]!='0') {
                                            print "<a name='".$i."' id='" .$i. "'></a>";
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
    <!-- InstanceEnd --></html>