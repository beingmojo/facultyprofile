<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Research Profiles - Privacy Policy";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
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

    window.onload=function()
    {
        startList();
    }

    //-->
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <tr>
        <td height="3" colspan="2" class="table_background">
            <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><div align="left"><img src="images/canoe6.JPG" alt="Research Profile" width="751" height="95" align="left" /></div>
                    </td>
                    <td>
                        <form action="searchresults.php" method="get" enctype="application/x-www-form-urlencoded">
                            <input name="search" type="text" class="form_elements" id="search" size="15" />
                            <input name="Submit" type="submit" class="form_elements_row_action" value="Quick Search" />
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width='30%' align="left" class="table_background_other"><!-- InstanceBeginEditable name="pagename" -->
            <div align="left" class="page_heading">Privacy Policy</div>
            <!-- InstanceEndEditable --></td>
        <td valign="top" class="table_background_other" align='right'>
            <div id="menu">
                <ul id="nav">
                    <li>
                        <?php
                        print( "<a href='{$_home}/index.php'>Home</a>");
                        if ($_SESSION["UID"] != "") {
                            print( "<ul><li><a href='researchspace.php'>Research Space</a></li>");
                            print( "<li><a href='logoff.php'>Logoff</a></li></ul>");
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
                            <li><a href="browseprofiles.php?view=6">Labs & Groups</a></li>
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
            <span class="form_elements">By accessing or using this web site at the Texas State University - San Marcos you agree to the terms of The Office of Research Administration's Internet Privacy Policy, as outlined below. If you do not agree to these terms, please do not access or use this site. The Office of Research Administration reserves the right to change the Internet Privacy Policy from time to time at it's sole discretion. Your use of this site will be subject to the most current version of the Internet Privacy Policy at the time of such use.
                <br /><br />

                You may be entitled to know what information Texas State University (TSU) collects concerning you. You may review and have TSU correct this information according to procedures set forth in TSU System BPM #32. The law is found in sections 552.021, 552.023 and 559.004 of the Texas Government Code.
                <br /><br />
                The Office of Research Administration (RA) at the Texas State University - San Marcos, 601 University Drive, San Marcos, Texas, USA  - 78666 makes the following statement in regards to information gathering and dissemination practices for it's web site: <a href="http://www.txstate.edu/research">http://www.txstate.edu/research</a><br />
                <br /><br />
                <strong>Server Logs/Log Analysis Tools</strong><br />
                RA uses server logs and log analysis tools to create summary statistics about Web site usage to improve site management. The statistics are used for purposes such as assessing what information is of most interest to users, determining technical design specifications, and identifying system performance or problem areas. RA does not report or use this information in any manner that would reveal personally identifiable information, and does not release the information to any outside parties unless required to do so under applicable law. Logs are kept indefinitely. The following information is collected for this analysis:
                <ul>
                    <li>User Client hostname: The hostname (or IP address if DNS is disabled) of the user/client requesting access. </li>
                    <li>HTTP header, "user-agent": The user-agent information includes the type of browser, its version, and the operating system it's running on.</li>
                    <li>HTTP header, "referer": The referer specifies the page from which the client accessed the current page. </li>
                    <li>System date: The date and time of the user/client request. </li>
                    <li>Full request:  The exact request the user/client made.</li>
                    <li>Status: The status code the server returned to the user/client. </li>
                    <li>Method:  The request method used. </li>
                    <li>Universal Resource Identifier (URI) - The location of a resource on the server.</li>
                    <li>Query string of the URI: Anything after the question mark in a URI. </li>
                    <li>Protocol: The transport protocol and version used. </li>
                    <li>Search Keywords: The keywords used to search for a page on this website </li>
                </ul>
                RA monitors network traffic for site security purposes and to ensure that the site remains available to all users. <strong>Unauthorized attempts to upload information, change information on this site, or otherwise cause damage are strictly prohibited and may be punishable under Texas Penal Code Chapters 33 (Computer Crimes) or 33A (Telecommunications Crimes).</strong> Except as may be required for authorized law enforcement investigations, no attempts are made to identify individual users or their usage habits. RA does not use raw data logs for any other purposes.

                <br />
                <br />
                <strong>Cookies and Web Bugs</strong><br />
                When you visit this website, you can surf the site anonymously and access important information without revealing your identity. However for functions/features that require authorization we use "cookies" to track your visit.
                <br />
                A cookie is small amount of data that is transferred to your browser by a Web server and can only be read by the server that gave it to you. They function as your identification card. Cookies cannot be executed as code or deliver viruses. Most browsers are initially set to accept cookies.
                <br /><br />
                <strong>Contacting the Webmasters <br />
                </strong>
                If you have any questions about this privacy statement, the practices of this site, or your dealings with this Web site, you can contact the Webmaster of this site at:

                Electronic Research Adminstration,
                Attn: Manager, Electronic Research Administration,
                601 University Drive,
                San Marcos,
                Texas, USA  - 78666

                Telephone Number : 512-245-2314

                Email : sv1117@txstate.edu.

                Please include your name, address, and/or e-mail address when you contact us.</span>

            <!-- InstanceEndEditable -->
        </td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="table_background">
            <!-- Partnership text in this section with the hyperlink should remain visible on the template page and should not deleted -->
            <div align="right"><a href="http://www.uta.edu/research/collaborate/" target="_blank"><span class="font_on_dark_blue"><strong>powering - The Partnership</strong></span></a></div>
            <!-- End of Partnership text -->
        </td>
    </tr>
    <!-- footer content goes here -->
   <tr>
        <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy; 2010 Texas State University - San Marcos| <a href="http://www.txstate.edu/research">Electronic Research Administration</a>, 601 University Drive, San Marcos, Texas 78666 Voice: 512.245.211 |<a href="feedback.php">Site Feedback</a> | <a href="http://www.txstate.edu/research/oera.html">Contact Electronic Research Administration - Web Team</a><br />

                </font></div>
            <!-- Start of StatCounter Code
    This spot can be used to enter tracking counter code. Recommended: http://www.statcounter.com
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