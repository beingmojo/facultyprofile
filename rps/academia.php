<?php
include 'utils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
?>
<?php
include 'includes/txstate/page-top.html';
?>
<tr>
    <td style="background-color:#480000;color:#CCCCCC;" height="10px"><span style="margin-top:2px;margin-left:10px;font-family:times,san-serif;font-weight:bold;font-size:16px">About RPS : Academia</span></td>
</tr>
</table>
<style>
    body {
        background-color:#FFFFFF;
        font-family:times,sans-serif;
        font-size:12px;
    }
    /*Heading*/
    h1 {
        background-color:#FFFFFF;
        font-family:times,sans-serif;
        color:#580000;
        font-size:20px;
    }
    h2 {
        background-color:#FFFFFF;
        font-family:times,sans-serif;
        color:#580000;
        font-size:18px;
    }
    h3 {
        background-color:#FFFFFF;
        font-family:times,sans-serif;
        color:#580000;
        font-size:16px;
    }
    h4 {
        background-color:#FFFFFF;
        font-family:times,sans-serif;
        color:#580000;
        font-size:15px;
    }
    h5 {
        background-color:#FFFFFF;
        font-family:times,sans-serif;
        color:#580000;
        font-size:14px;
    }
    h6 {
        background-color:#FFFFFF;
        font-family:times,sans-serif;
        color:#580000;
        font-size:13px;
    }
    /*Paragragh*/
    p {
        font-size:12px;
        margin-left:5px;
    }
    /*A-HREF*/
    a {
        font-family:times,sans-serif;
        font-size:12px;
        color:#444444;
    }
    a:link {
        text-decoration:none;
        color:#444444;
    }
    a:visited {
        text-decoration:none;
        color:#444444;
    }
    a:hover {
        text-decoration:underline;
        color:#444444;
    }
    a:active {
        text-decoration:none;
        color:#444444;
    }
</style>

<!--SECTION: Start of page-specific items, center image,etc -->
<link href="styles/style1.css" rel="stylesheet" type="text/css" />
<link href="styles/list.css" rel="stylesheet" type="text/css" />
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

    -->
</script>
<table width="100%" border="0">
    <tr><!-- Menu Bar -->
        <td style="background-color: #480000;" valign="top" align="right">
            <div id="menu">
                <ul id="nav">
                    <li>
                        <?php
                        print( "<a href='{$_home}/index.php' style='color:#FFFFFF'>Home</a>" );
                        if( $_SESSION["UID"] != "" ) {
                            print( "<ul><li><a href='researchspace.php'>Research Space</a></li>");
                            print( "<li><a href='logoff.php'>Logoff</a></li></ul>" );
                        }
                        ?>
                    </li>
                    <li><a href="browseprofiles.php?view=1" style="color:#FFFFFF">Browse </a>
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
                    <li><a href="newsearch.php" style='color:#FFFFFF'>Search </a>
                        <ul>
                            <li><a href="newsearch.php">Basic</a></li>
                            <li><a href="clustersearch.php">Cluster</a></li>
                            <li><a href="advsearch.php">Advanced</a></li>
                        </ul>
                    </li>
                    <li><a href="aboutrsp.php" style='color:#FFFFFF'>Support</a>
                        <ul>
                            <li><a href="aboutrps.php">About RPS</a></li>
                            <li><a href="help/index.php">Help and FAQ's</a></li>
                            <li><a href="feedback.php">Contact Us</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td colspan="2">
                        <table width="100%"  border="0" cellspacing="1" cellpadding="1">
                            <tr>
                                <td colspan="2" valign="top"><div align="right" class="table_background"><span class="font_on_dark_blue">Read More about:&nbsp;&nbsp; <a href="academia.php"><span class="font_on_dark_blue">Academia</span></a>&nbsp; | &nbsp;<a href="industry.php"><span class="font_on_dark_blue">Industry</span></a>&nbsp; | &nbsp;<a href="state_city.php"><span class="font_on_dark_blue">State, City</span></a></span>&nbsp;&nbsp;&nbsp; </div></td>
                            </tr>
                            <tr>
                                <td width="82%" valign="top" class="form_elements">
                                    <br />
                                    <div>
                                        <ul>
                                            <li class="form_elements"><img src="images/bullets/blue.png" alt="Blue Bullet" width="12" height="12" />&nbsp;Universities must become proactive partners for economic development by identifying and associating their resources with industry clusters and then actively market these resources to industry as being available, and willing partners in generating innovation.</li>
                                            <li class="form_elements"><img alt="Blue Bullet" src="images/bullets/blue.png" width="12" height="12" />&nbsp;Links between Industry Clusters and local universities and communities help refine the research agenda, train specialized talent, and enable faster deployment of new knowledge.</li>
                                            <li class="over"></li>
                                            <li class="form_elements"><img alt="Blue Bullet" src="images/bullets/blue.png" width="12" height="12" />&nbsp;Through University business incubators, business and technology partnerships, and development outreach, Universities can leverage alumni networks for involvement in the development activities related to emerging businesses. Universities, by becoming an integral part of the region and local industry clusters they serve, provides more opportunities for University technology to be commercialized, its&rsquo; students to be embedded in local industry, and its employees to create new companies. These alumni, in turn, will be more likely to support university endeavors and bring a higher propensity for sponsored research.</li>
                                        </ul>
                                        <br />
                                        <p><span class="font_orange">Back to:</span><a href="aboutrps.php">&nbsp;&nbsp;About RPS</a></p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><!-- Page footer -->
        <td align="center">
            <p align="center"><img src="images/line.jpg" alt="" width="700" height="1"/></p>
            <p>
                <a href="http://www.uta.edu/collaborate" target="_blank" class="rsp">powering - The Partnership</a><br />
                &copy; 2006 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>
