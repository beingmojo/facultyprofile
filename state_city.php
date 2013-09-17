<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "About RPS : State, City";
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

    -->
</script>
<table width="100%" border="0">
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
                                            <li><img alt="Blue Bullet" src="images/bullets/blue.png" width="12" height="12" />&nbsp;Industry Clustering builds innovation growth to drive prosperity and justify higher wages and taxable bases.</li>
                                            <li class="form_elements"><img alt="Blue Bullet" src="images/bullets/blue.png" width="12" height="12" />&nbsp;To maintain technological and innovation dominance, we must stay ahead of the increasingly rapid and global diffusion of knowledge and know-how.</li>
                                            <ul>
                                                <li><br /><img alt="Blue Bullet" src="images/bullets/blue.png" width="12" height="12" />&nbsp;States must identify its economic resources (those with know-how, technologies, and key R&amp;D facilities) geographically and into economic regions to foster Industry Clusters. By doing so, State and City Governments can strategically plan, organize, budget, address legislation, and measure performance to encourage economic development and create wealth. </li>
                                                <li><br /><img alt="Blue Bullet" src="images/bullets/blue.png" width="12" height="12" />                Clusters represent an effective way for states to analyze, organize, and catalyze their science and technology platform. Cluster&rsquo;s are incubators of innovation and enhance the ability of state and local economies to build prosperity.</li>
                                                <li><br /><img alt="Blue Bullet" src="images/bullets/blue.png" width="12" height="12" />                For states or cities to create a vision for its&rsquo; economic future, a comprehensive, integrated inventory is needed for benchmarking and examining industrial assets, technologies, research competencies and talent. Through the RPS, cities and states can identify these resources for retaining, expanding, creating, or attracting companies into their economic future. Overtime, through benchmarking and economic planning, a strategy may be developed that attracts high-value strategic planning and high wage jobs.</li>
                                            </ul>
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
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>
