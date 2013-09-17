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
    <td style="background-color:#480000;color:#CCCCCC;" height="10px"><span style="margin-top:2px;margin-left:10px;font-family:times,san-serif;font-weight:bold;font-size:16px">About RPS</span></td>
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
                                        <p class="font_orange"><strong>The ReSearch Profile (RSP) system provides: </strong></p>
                                        <ul>
                                            <li class="over"><img src="images/bullets/blue.png" alt="" width="12" height="12" />&nbsp;Individuals and Organizations easy access to innovation, knowledge, technologies and know-how.</li>
                                            <li class="over"><img src="images/bullets/blue.png" alt="" width="12" height="12" />&nbsp;Industry access to ideas, talent, and geographic proximity to skilled labor pools and R&amp;D facilities.</li>
                                            <li class="over"><img src="images/bullets/blue.png" alt="" width="12" height="12" />&nbsp;an infrastructure of opportunities for members to get to know one another, share ideas, and learn and develop trust with increased efficiency. </li>
                                        </ul>
                                        <p class="font_orange"><strong>Enhancing our Economy: </strong></p>
                                        <p>The ReSearch Profile system (RSP) is a response to the Texas Industry and Technology clusters in order to facilitate problem solving, collaboration, and technology transfer among research experts and organizations in Academia, Industry and Government. The goal of RSP is to become a synergistic marketplace to transfer knowledge, provide experts to solve problems, and expand innovation capacity in order to build new or expand existing markets, provide job growth and develop wealth. </p>
                                        <p class="font_orange"><strong>Academia&rsquo;s new role: </strong></p>
                                        <p>RSP is a method to transform the culture of Academia to becoming sellers and marketers of research and ideas. The role of academia is catalyzing the transfer of knowledge and creating an environment for the rapid deployment of that knowledge by speeding the movement of ideas, innovation and information throughout the marketplace and the economy. <strong>Universities are the nation&rsquo;s greatest &ldquo;untapped&rdquo; resources for spurring economic growth!</strong></p>
                                        <p class="font_orange"><strong>Understanding your community: </strong></p>
                                        <p>Industry Clusters serve communities and economic regions best within their geographic proximity. Industry Clusters should specifically identify not only companies, but also the knowledge experts at universities, intellectual property and technologies, research centers and laboratories, and access to specialized equipment and R&amp;D facilities. All of these resources need to be at the fingertips of individuals to drive innovation and global competitiveness.</p>
                                        <p class="font_orange"><strong>The Academia, Industry and Government Partnership: </strong></p>
                                        <p>Universities produce new knowledge, typically through basic or innovative research funded by the federal government; entrepreneurs and venture Capitalists transform basic research into commercialization opportunities; Companies, transform this knowledge into new services or products and distributes and delivers these products to the consumer. </p>
                                        <p> Partnerships of Academia, Industry, and State and Local Governments are interconnected in making effective Industry Clusters. With this successful exchange, states and the nation will enjoy higher average wages, productivity, rates of business formation and innovation. Through clustering and the innovation engine it creates, companies, states and the nation will continue to effectively compete in the global economy. The value of clustering is directly related to individual and industry access to specialized services and resources.</p>
                                        <p class="font_orange"><strong>Industry Clustering &ndash; knowledge transfer:</strong></p>
                                        <p>Successful regions are home to academic research (Tier I Research) institutions, individuals, and organizations that serve as storehouses and disseminators of undocumented knowledge. The knowledge resides in research and technology centers and their staff, education institutions and their faculty, and companies and their employees. It extends well beyond whatever may be recorded. Those that develop and work with new systems, techniques, and technologies know far more about how these systems, techniques, and technologies work under different circumstances than is ever documented. The ability to organize and connect people with this knowledge is an extremely valuable tool. </p>
                                        <p class="font_orange"><strong>Strengthen networking and associative behavior: </strong></p>
                                        <p>One of the most important attributes of a successful cluster is an associative infrastructure that provides opportunities for members to get to know one another, share ideas, learn, and develop trust. The relational assets, or &ldquo;social capital,&rdquo; of a cluster depend on trust and the frequency and depth of personal exchanges. RSP relates these assets intelligently and is a virtual &ldquo;storefront&rdquo; providing easy access to provide the contact information of a network of resources.</p>
                                        <p class="font_orange"><strong>Automating and synergizing technology transfer: </strong></p>
                                        Technology Transfer is a &ldquo;contact sport&rdquo; and only succeeds when a network of linkages is established between university researchers and the business community. To become an economic engine, technology transfer offices, individuals, and universities cannot operate on an island. Technologies must be easily identified, searchable for bundling, and marketed to industry for commercialization in any demanded capacity.
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
                <a href="http://www.uta.edu/research/collaborate/" target="_blank" class="rsp">powering - The Partnership</a><br />
                &copy; 2006 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>
