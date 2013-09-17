<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Search";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
?>

<script language="JavaScript" type="text/JavaScript">
    <!--
    function change(id)
    {
        var fieldNames = new Array('faculty','researchcenter','technology','facility','equipment','labgroup');
        var i=0;
        var count=0;
        if(id!='all')
        {
            if(document.getElementById(id).checked==true)
            {
                document.getElementById('all').checked=false;
            }

            else
            {
                for(i=0;i<6;i++)
                {
                    if(document.getElementById(fieldNames[i]).checked==true)
                        count=count+1;
                }
                if(count<6)
                    document.getElementById('all').checked=false;
                else if (count==6)
                    document.getElementById('all').checked=true;
            }
        }
        if(id=='all')
        {
            if(document.getElementById(id).checked==true)
            {
                for(i=0;i<6;i++)
                {
                    document.getElementById(fieldNames[i]).checked=true;
                }
            }
            else
            {
                if(document.getElementById(id).checked==false)
                {
                    for(i=0;i<6;i++)
                    {
                        document.getElementById(fieldNames[i]).checked=false;
                    }
                }
            }
        }
    }

    //-->
</script>
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

    //-->
</script>
<!-- InstanceEndEditable -->
<style type="text/css">
    <!--
    .style1 {font-size: 18px}
    .style2 {font-size: 14px}
    .style3 {
        font-size: 12px;
        font-weight: bold;
    }
    -->
</style>
<!-- InstanceEndEditable -->
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="box" id="details" bgcolor="#FFFFFF">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td background="images/tabblue.gif0" height="33" width="111" valign="bottom" align="center"><span class="tab_menu">Basic</span></td>
                                <!--<td background="images/tabsilver.gif0" width="111" valign="bottom" align="center" ><a href="clustersearch.php"><span class="tab_menu">Clusters</span></a></td>
                                <td background="images/tabsilver.gif0" width="111" valign="bottom" align="center" ><a href="advsearch.php"><span class="tab_menu">Advanced</span></a></td> -->
                                <td width="111" valign="bottom">&nbsp;</td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td height="5" bgcolor="#580000"></td>
                </tr>
                <tr>
                    <td height="16" valign="top"  ><br>
                        <span class="style1">Search Profiles</span><br>
                        &nbsp;</td>
                </tr>
                <tr>
                    <td height="196" valign="top" >
                        <form action="searchresults.php" name="searchform" method="get" >
                            <label for="searchbox"><input type="hidden" name="searchtype" id="searchbox" value="basic"></label>
                            <table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" class="searchBox">
                                <tr class="submit">
                                    <td width="22%"><div align="left" class="form_elements">
                                            <div >
                                                <label for="faculty"><input name="faculty" type="checkbox" id="faculty" onClick="change(this.id);" value="true" checked></label>
                                                <img src="images/bullets/faculty.gif" alt="&gt; " width="12" height="12" />&nbsp;<span class="profilerules">Faculty / Expertise</span></div>
                                        </div></td>
                                    <td width="78%"><div align="left" class="form_elements">
                                            <div >
                                                <label for="researchcenter"><input name="researchcenter" type="checkbox" id="researchcenter" onClick="change(this.id);" value="true" checked></label>
                                                <span class="profilerules"><img src="images/bullets/center.gif" alt="&gt; " width="12" height="12" /> Research Centers</span></div>
                                        </div></td>
                                <tr class="submit">
                                    <td width="22%"><div align="left" class="form_elements">
                                            <div >
                                                <label for="technology"><input name="technology" type="checkbox" id="technology" onClick="change(this.id);" value="true" checked></label>
                                                <img src="images/bullets/technology.gif" alt="&gt; " width="12" height="12" />&nbsp;<span class="profilerules">Technologies and Patents</span></div>
                                        </div></td>
                                   <!-- <td width="78%"><div align="left" class="form_elements">
                                            <div >
                                                <label for="facility"><input name="facility" type="checkbox" id="facility" onClick="change(this.id);" value="true" checked></label>
                                                <span class="profilerules"><img src="images/bullets/facility.gif" alt="&gt; " width="12" height="12" /> Research Facilities</span></div>
                                        </div></td>
                                </tr>
                                <tr class="submit">-->
                                    <td width="22%"><div align="left" class="form_elements">
                                            <div >
                                                <label for="equipment"><input name="equipment" type="checkbox" id="equipment" onClick="change(this.id);" value="true" checked></label>
                                                <span class="profilerules"><img src="images/bullets/equipment.gif" alt="&gt; " width="12" height="12" /> Equipment</span></div>
                                        </div></td>
                                   <!-- <td width="78%"><div align="left" class="form_elements">
                                            <div >
                                                <label for="labgroup"><input name="labgroup" type="checkbox" id="labgroup" onClick="change(this.id);" value="true" checked></label>
                                                <img src="images/bullets/labgroup.gif" alt="&gt; " width="12" height="12" /> <span class="profilerules">Laboratories &amp; Research Groups </span></div>
                                        </div></td>-->
                                </tr>
                                <tr class="style15">
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr >
                                    <td colspan="4"><div class="form_elements">
                                            <div >
                                                <span class="form_elements">
                                                    <label for="expression"><input name="expression" type="checkbox" id="expression" value="true"></label>
                                                    <span class="form_elements">Strict Search</span></span> </div>
                                        </div></td>
                                </tr>
                                <tr >
                                    <td colspan="4"><div class="form_elements">
                                            <div >
                                                <span class="form_elements">
                                                    <label for="all"><input name="all" type="checkbox" id="all" value="true" checked onClick="change(this.id);"></label>
                                                    <span class="form_elements">Search in Everything</span></span> </div>
                                        </div></td>
                                </tr>
                                <tr class="style15">
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><table width="100%"  border="0" cellspacing="1" cellpadding="1">
                                            <tr class="style15">
                                                <td colspan="3"><hr class="form_elements" width="100%"></td>
                                            </tr>
                                            <tr class="style15">
                                                <td colspan="4">&nbsp;</td>
                                            </tr>
                                            <tr class="form_elements" bgcolor="#CDAF95">
                                                <td width="22%"><div class="style2" ><span class="style3">Enter search text here </span>&nbsp; </div></td>
                                                <td width="53%" bgcolor="#CDAF95"><div align="left">
                                                        <label for="searchbox2"><input name="search" id="searchbox2" type="text" size="70"></label>
                                                    </div></td>
                                                <td width="25%" ><div >
                                                        <input name="Submit" type="submit" class="form_elements" value="Search" ></div></td>
                                            </tr>
                                        </table></td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                                <td></td>
                            </table>
                        </form>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p></td>
                </tr>

            </table>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr><!-- Page footer -->
        <td width="20%"></td>
        <td colspan="3" width="60%" align="center">
            <p align="center"><img src="images/line.jpg" alt="" width="700" height="1"/></p>
            <p>
                <a href="http://www.txstate.edu/research/" target="_blank" class="rsp">powering - The Partnership</a><br />
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
        <td width="20%"></td>
    </tr>
</table>
</body>
<!-- InstanceEnd -->
</html>