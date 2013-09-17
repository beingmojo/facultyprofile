<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <!-- TemplateBeginEditable name="title" -->
        <?php
        include 'utils.php';
        session_start();
        $db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
        real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
        ?>
        <title>Electronic Research Profile System - (Enter Page Title) - Texas State University - San Marcos</title>
        <!-- TemplateEndEditable -->
        <link href="../styles/style1.css" rel="stylesheet" type="text/css" />
        <link href="../styles/list.css" rel="stylesheet" type="text/css" />
        <!-- TemplateBeginEditable name="script" -->
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

            window.onload=function()
            {
                startList();
            }

            //-->
        </script>
        <!-- TemplateEndEditable -->
        <!-- TemplateBeginEditable name="head" --><!-- TemplateEndEditable -->
    </head>
    <body>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
            <tr>
                <td height="3" colspan="2" class="table_background">
                    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><div align="left"><img src="../images/rspbanner.jpg" alt="Research Profile" width="751" height="95" align="left" /></div>
                            </td>
                            <td>
                                <form action="../searchresults.php" method="get" enctype="application/x-www-form-urlencoded">
                                    <label for="search"><span style="visibility:hidden">label</span><input name="search" type="text" class="form_elements" id="search" size="15" /></label>
                                    <label for="submitbutton"><span style="visibility:hidden">label</span><input name="Submit" id="submitbutton" type="submit" class="form_elements_row_action" value="Quick Search" /></label>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width='30%' align="left" class="table_background_other"><!-- TemplateBeginEditable name="pagename" -->
                    <div align="left" class="page_heading">page name</div>
                    <!-- TemplateEndEditable --></td>
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
                            <li><a href="../browseprofiles.php?view=1">Browse </a>
                                <ul>
                                    <li><a href="../browseprofiles.php?view=1">Faculty</a></li>
                                    <li><a href="../browseprofiles.php?view=2">Center</a></li>
                                    <li><a href="../browseprofiles.php?view=3">Technology</a></li>
                                    <li><a href="../browseprofiles.php?view=4">Facility</a></li>
                                    <li><a href="../browseprofiles.php?view=5">Equipment</a></li>
                                    <li><a href="../browseprofiles.php?view=6">Labs &amp; Groups</a></li>
                                    <li><a href="../courses.php">Courses</a></li>
                                </ul>
                            </li>
                            <li><a href="../newsearch.php">Search </a>
                                <ul>
                                    <li><a href="../newsearch.php">Basic</a></li>
                                    <li><a href="../clustersearch.php">Cluster</a></li>
                                    <li><a href="../advsearch.php">Advanced</a></li>
                                </ul>
                            </li>
                            <li><a href="../aboutrsp.php">Support</a>
                                <ul>
                                    <li><a href="../aboutrsp.php">About rSp</a></li>
                                    <li><a href="../help/index.php">Help and FAQ's</a></li>
                                    <li><a href="../feedback.php">Contact Us</a></li>
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
                    <!-- TemplateBeginEditable name="content" -->
	CONTENT GOES HERE
                    <!-- TemplateEndEditable -->
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
                <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy;2006 The University of Texas at Arlington | <a href="http://www.uta.edu/research/webteam">Electronic Research Administration</a>, 219 ATI Box 19145, Arlington, Texas 76019-0145 Voice: 817.272.3896 | Fax: 817.272.5808 | <a href="../feedback.php">Site Feedback</a> | <a href="http://www.uta.edu/research/webteam">Contact Electronic Research Administration - Web Team</a><br />
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
</html>