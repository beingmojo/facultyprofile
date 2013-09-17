<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Clustered Search";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-link4'] = "<link rel='stylesheet' href='styles/mktree.css' type='text/css'>";
$_POST['page-script1'] = "<SCRIPT LANGUAGE='JavaScript' SRC='scripts/mktree.js'></SCRIPT>";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
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
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="searchBox" id="details" bgcolor="#FFFFFF">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" background="images/tabsilver.gif0" height="33" width="111" valign="bottom"><a href="newsearch.php"><span class="tab_menu" >Basic</span></a></td>
                                <td align="center" background="images/tabblue.gif0" width="111" valign="bottom"><span class="tab_menu" >Clusters</span></td>
                                <td align="center" background="images/tabsilver.gif0" width="111" valign="bottom"><a href="advsearch.php"><span class="tab_menu">Advanced</span></a></td>
                                <td width="111" valign="bottom">&nbsp;</td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td height="5" bgcolor="#580000"></td>
                </tr>
                <tr>
                    <td height="16" valign="top" bgcolor="#580000" class="font_topic_other"><br>
                        Search Profiles in Clusters <span class="form_elements">(under construction)</span><br>
                        &nbsp;</td>
                </tr>
                <tr>
                    <td height="270" valign="top" bgcolor="#580000">
                        <form action="searchresults.php" name="searchform" method="get" >
                            <table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" class="searchBox">
                                <tr bgcolor="#CDAF95" >
                                    <td bgcolor="#CDAF95"> <span class="font_topic">Technology Clusters </span></td>
                                    <td width="6" bgcolor="#FFFFFF">&nbsp;</td>
                                    <td width="427" bgcolor="#CDAF95"><span class="font_topic">Industry Clusters</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<a href="#" onClick="expandTree('tree1'); return false;"><span class="form_elements">Expand All</span></a>&nbsp;&nbsp;&nbsp; <a href="#" onClick="collapseTree('tree1'); return false;"><span class="form_elements">Collapse All</span></a>)</td>
                                </tr>
                                <tr class="font_topic">
                                    <td width="200"></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr class="form_elements">
                                    <td><label for="t1"><input name="t1" type="checkbox" id="t1" value="true" checked></label>
                                        Advanced Energy Technologies </td>
                                    <td>&nbsp;</td>
                                    <td rowspan="6"><!-- **************************tree structure **************************-->
                                        <ul class="mktree" id="tree1">
                                            <li>
                                                <label for="c1"><input name="c1" type="checkbox" id="c1" value="true" checked></label>
                                                Advanced Manufacturing
                                                <ul>
                                                    <li>
                                                        <label for="c2"><input name="c2" type="checkbox" id="c2" value="true" checked></label>
                                                        Nanotechnology and Materials</li>
                                                    <li>
                                                        <label for="c3"><input name="c3" type="checkbox" id="c3" value="true" checked></label>
                                                        MEMS Manufacturin</li>
                                                    <li>
                                                        <label for="c4"><input name="c4" type="checkbox" id="c4" value="true" checked></label>
                                                        Automotive Manufacturing</li>
                                                    <li>
                                                        <label for="c17"><input name="c17" type="checkbox" id="c17" value="true" checked></label>
                                                        Semiconductor Manufacturing</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <label for="c5"><input name="c5" type="checkbox" id="c5" value="true" checked></label>
                                                Aerospace and Defense
                                                <ul>
                                                    <li>
                                                        <label for="c6"><input name="c6" type="checkbox" id="c6" value="true" checked></label>
                                                        Composite Advanced Materials</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <label for="c7"><input name="c7" type="checkbox" id="c7" value="true" checked></label>
                                                Biotechnology and Life Science</li>
                                            <li>
                                                <label for="c8"><input name="c8" type="checkbox" id="c8" value="true" checked></label>
                                                Energy
                                                <ul>
                                                    <li>
                                                        <label for="c9"><input name="c9" type="checkbox" id="c9" value="true" checked></label>
                                                        Oil and Gas Production</li>
                                                    <li>
                                                        <label for="c10"><input name="c10" type="checkbox" id="c10" value="true" checked></label>
                                                        Power Generation and Transportation</li>
                                                    <li>
                                                        <label for="c11"><input name="c11" type="checkbox" id="c11" value="true" checked></label>
                                                        Manufactured Energy Systems</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <label for="c12"><input name="c12" type="checkbox" id="c12" value="true" checked></label>
                                                Information and Computer Technology
                                                <ul>
                                                    <li>
                                                        <label for="c13"><input name="c13" type="checkbox" id="c13" value="true" checked></label>
                                                        Communication Equipment</li>
                                                    <li>
                                                        <label for="c14"><input name="c14" type="checkbox" id="c14" value="true" checked></label>
                                                        Computing Equipment</li>
                                                    <li>
                                                        <label for="c15"><input name="c15" type="checkbox" id="c15" value="true" checked></label>
                                                        Information Technology</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <label for="c16"><input name="c16" type="checkbox" id="c16" value="true" checked></label>
                                                Petroleum Refining and Chemical Products</li>
                                        </ul></td>
                                </tr>
                                <tr class="form_elements">
                                    <td><label for="t2"><input name="t2" type="checkbox" id="t2" value="true" checked></label>
                                        Biotechnology</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td><label for="t3"><input name="t3" type="checkbox" id="t3" value="true" checked></label>
                                        MEMS Technologies </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td><label for="t4"><input name="t4" type="checkbox" id="t4" value="true" checked></label>
                                        Nanotechnologies</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td><label for="t5"><input name="t5" type="checkbox" id="t5" value="true" checked></label>
                                        Semiconductor Technologies </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td><label for="t6"><input name="t6" type="checkbox" id="t6" value="true" checked></label>
                                        Software Technology/Wireless </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td colspan="3"><hr class="form_elements" width="95%"></td>
                                </tr>
                                <tr class="form_elements">
                                    <td width="200"><div align="right">
                                            <label for="searchtype"><input name="searchtype" type="hidden" id="searchtype" value="cluster"></label>
                                            Enter search text here &nbsp; </div></td>
                                    <td colspan="2" bgcolor="#FFFFFF"><div align="left">
                                            <label for="searchbox3"><input name="search" id="searchbox3" type="text" size="70"></label>
                                        </div></td>
                                </tr>
                                <tr class="form_elements">
                                    <td colspan="3"><div align="center">
                                            <input name="Submit" type="submit" class="form_elements" value="Search">
                                        </div></td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td height="19" valign="top"><hr width="100%" class="form_elements"></td>
                </tr>
            </table>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
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
<!-- InstanceEnd -->
</html>