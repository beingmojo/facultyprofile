<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "About RPS : Industry";
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
                                            <ul>
                                                <li><img src="images/bullets/blue.png" width="12" height="12" />&nbsp;Maintain competitiveness in the global economy through innovation edges and knowledge transfer for problem solving.</li>
                                                <li><img src="images/bullets/blue.png" width="12" height="12" />&nbsp;By clustering, companies can innovate more rapidly because they draw on the local networks that link technology, resources, information and talent. RPS is the necessary link to identify these resources.</li>
                                                <li><img src="images/bullets/blue.png" width="12" height="12" />&nbsp;RPS can act as a science and technology clearinghouse of assets and activities that can be utilized in larger regional development and other cluster related initiatives of the company. </li>
                                                <li><br />
                                                    <img src="images/bullets/blue.png" width="12" height="12" />&nbsp;                RPS is a knowledge and &ldquo;technology pull&rdquo; to solve problems of the company or the individual. </li>
                                                <li><strong><br />
                                                        <img src="images/bullets/blue.png" width="12" height="12" />                The most important advantage to clustering is the access to innovation, knowledge, and know-how.</strong> In the New Economy&mdash; defined by knowledge-intensive traditional and emerging industries&mdash;companies look for their main competitive advantages in access to ideas and talent, which requires geographic proximity to professional colleagues, cutting-edge suppliers, highly skilled labor pools, research and development facilities, and industry leaders. Industry-specific knowledge and know-how accumulate and disperse through entrepreneurial areas and innovative companies. Clustering gives firms quicker information about advances in technologies and changes in customer or consumer preferences. Not incidentally, it reduces transaction costs. RPS will provide instant access to this information. </li>
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
                <a href="http://www.txstate.edu/research/" target="_blank" class="rsp">powering - The Partnership</a><br />
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>
