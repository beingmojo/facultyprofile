<?php
include 'utils.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <!-- TemplateBeginEditable name="doctitle" -->
        <title>Electronic Research Profile System - (ERPS Help Guide) - Texas State University - San Marcos</title>
        <!-- TemplateEndEditable -->
        <link href="../styles/style1.css" rel="stylesheet" type="text/css" />
        <link href="../styles/list.css" rel="stylesheet" type="text/css" />
        <!-- TemplateBeginEditable name="head" -->
        <!-- TemplateEndEditable -->
    </head>
    <body>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
            <tr>
                <td height="3" class="table_background">
                    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><div align="left"><img src="../images/rspbanner.jpg" alt="Research Profile" width="751" height="95" align="left" /></div>          </td>
                            <td>
                                <form action="../real/searchresults.php" method="get" enctype="application/x-www-form-urlencoded">
                                    <label for="search"><span style="visibility:hidden">label</span><input name="search" type="text" class="form_elements" id="search" size="15" /></label>
                                    <label for="submitbutton"><span style="visibility:hidden">label</span><input name="Submit" id="submitbutton" type="submit" class="form_elements_row_action" value="Quick Search" /></label>
                                </form>
                            </td>
                        </tr>
                    </table>    </td>
            </tr>
            <tr>
                <td width='30%' align="left" class="table_background_other">
                    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><!-- TemplateBeginEditable name="pagename" -->
                                <div align="left" class="page_heading">page name</div>
                                <!-- TemplateEndEditable -->
                            </td>
                            <td>
                                <div id="menu">
                                    <ul id="nav">
                                        <li>
                                            <?php
                                            print( "<a href='../index.php'>Home</a>" );
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
                    </table>
                </td>
            </tr>
            <!-- content goes here -->
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <!-- TemplateBeginEditable name="content" -->
	CONTENT GOES HERE<!-- TemplateEndEditable -->	</td>
            </tr>
        </table>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="table_background">&nbsp;</td>
            </tr>
            <!-- footer content goes here -->
            <tr>
                <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy; 2005<a href="http://www.uta.edu/" target="www.uta.edu">The University of Texas at Arlington</a> |
                            Research Administration | Questions or Comments about this site? Email: <a href="http://www.uta.edu/ra/siteHelp.html">webmaster</a>  | Wednesday , February 01, 2006<br />
                        </font></div></td>
                <!--end of footer -->
            </tr>
        </table>
    </body>
</html>
