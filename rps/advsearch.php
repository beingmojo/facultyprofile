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
    <td style="background-color:#480000;color:#CCCCCC;" height="10px"><span style="margin-top:2px;margin-left:10px;font-family:times,san-serif;font-weight:bold;font-size:16px">Advanced Search</span></td>
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
<SCRIPT LANGUAGE="JavaScript" SRC="scripts/mktree.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
    <!--
    function change(id) {
        var fieldNames = new Array('keyf','rif','pubf','edf','equipf','rac','intc','extc','desct','prodt','appt','rest','funu','locu');
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
                for(i=0;i<14;i++)
                {
                    if(document.getElementById(fieldNames[i]).checked==true)
                        count=count+1;
                }
                if(count<14)
                    document.getElementById('all').checked=false;
            }
        }
        if(id=='all')
        {
            if(document.getElementById(id).checked==true)
            {
                for(i=0;i<14;i++)
                {
                    document.getElementById(fieldNames[i]).checked=true;
                }
            }
            else
            {
                if(document.getElementById(id).checked==false)
                {
                    for(i=0;i<14;i++)
                    {
                        document.getElementById(fieldNames[i]).checked=false;
                    }
                }
            }
        }
    }
    function changeF()
    {
        var i=0;
        var fieldNames = new Array('keyf','rif','pubf','edf','equipf');
        for(i=0;i<5;i++)
        {
            document.getElementById(fieldNames[i]).checked=true;
        }
        document.getElementById('all').checked=false;
    }
    function changeC()
    {
        var i=0;
        var fieldNames = new Array('rac','intc','extc');
        for(i=0;i<3;i++)
        {
            document.getElementById(fieldNames[i]).checked=true;
        }
        document.getElementById('all').checked=false;
    }

    function changeT()
    {
        var i=0;
        var fieldNames = new Array('desct','prodt','appt','rest');
        for(i=0;i<4;i++)
        {
            document.getElementById(fieldNames[i]).checked=true;
        }
        document.getElementById('all').checked=false;
    }
    function changeU()
    {
        var i=0;
        var fieldNames = new Array('funu','locu');
        for(i=0;i<2;i++)
        {
            document.getElementById(fieldNames[i]).checked=true;
        }
        document.getElementById('all').checked=false;
    }

    function GotoSearch()
    {
        strSearch = escape( document.searchform.search.value );
        location.href = "searchresults.php?search=" + strSearch;
    }
    //-->
</script>
<link rel="stylesheet" href="styles/mktree.css" type="text/css">
<link href="styles/style1.css" rel="stylesheet" type="text/css" />
<link href="styles/list.css" rel="stylesheet" type="text/css" />
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
   <tr><!-- Menu Bar -->
       <td colspan="2" style="background-color: #480000;" valign="top" align="right">
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
    <tr><td colspan="2">&nbsp;</td></tr>
    <!-- content goes here -->
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="box" id="details" bgcolor="#FFFFFF">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td background="images/tabsilver.gif" height="33" width="111" valign="bottom" align="center"><a href="newsearch.php"><span class="tab_menu">Basic</span></a></td>
                                <td background="images/tabsilver.gif" width="111" valign="bottom" align="center" ><a href="clustersearch.php"><span class="tab_menu">Clusters</span> </a></td>
                                <td background="images/tabblue.gif" width="111" valign="bottom" align="center" ><span class="tab_menu">Advanced</span></td>
                                <td background="images/tabsilver.gif" width="111" valign="bottom" align="center" ><a href="advsearch_copy.php"><span class="tab_menu">Advanced(beta)</span></a></td>
                                <td width="111" valign="bottom">&nbsp;</td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td height="5" bgcolor="#8DB0D3"></td>
                </tr>
                <tr>
                    <td height="16" valign="top" bgcolor="#8DB0D3" class="font_topic_other"><br>
                        Search Profiles <span class="form_elements">(under construction)</span><br>
                        &nbsp;</td>
                </tr>
                <tr>
                    <td height="270" valign="top" bgcolor="#8DB0D3">
                        <form action=" " name="searchform" method="get" >
                            <table width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" class="searchBox">
                                <tr bgcolor="#E4ECF5" class="submit">
                                    <td width="23%"><div align="left"><span class="form_elements"><B>Faculty</B></span> <span class="form_elements"><a href="javascript:void(0)" class="form_elements" onClick="changeF()">(select all)</a></span> </div></td>
                                    <td width="25%"><div align="left"><span class="form_elements"><B>Research Center &amp; Groups</B></span> <span class="form_elements"><a href="javascript:void(0)" class="form_elements" onClick="changeC()">(select all)</a></span></div></td>
                                    <td width="24%"><div align="left"><span class="form_elements"><B>Technology</B></span> <span class="form_elements"><a href="javascript:void(0)" class="form_elements" onClick="changeT()">(select all)</a></span></div></td>
                                    <td width="28%"><div align="left"><span class="form_elements"><B>Facilities &amp; Unique Equipment</B></span> <span class="form_elements"><a href="javascript:void(0)" class="form_elements" onClick="changeU()">(select all)</a></span></div></td>
                                </tr>
                                <tr class="form_elements">
                                    <td class="form_elements"><div align="left">
                                            <label for="keyf"><input name="keyf" type="checkbox" id="keyf" onClick="change(this.id);" value="true" checked></label>
                                            Keywords</div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="rac"><input name="rac" type="checkbox" id="rac" onClick="change(this.id);" value="true" checked></label>
                                            Research Activities </div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="desct"><input name="desct" type="checkbox" id="desct" onClick="change(this.id);" value="true" checked></label>
                                            Abstract</div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="funu"><input name="funu" type="checkbox" id="funu" onClick="change(this.id);" value="true" checked></label>
                                            Function</div></td>
                                </tr>
                                <tr class="form_elements">
                                    <td class="form_elements"><div align="left">
                                            <label for="rif"><input name="rif" type="checkbox" id="rif" onClick="change(this.id);" value="true" checked></label>
                                            Research Interests </div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="intc"><input name="intc" type="checkbox" id="intc" onClick="change(this.id);" value="true" checked></label>
                                            Members</div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="prodt"><input name="prodt" type="checkbox" id="prodt" onClick="change(this.id);" value="true" checked></label>
                                            Problem</div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="locu"><input name="locu" type="checkbox" id="locu" onClick="change(this.id);" value="true" checked></label>
                                            Location</div></td>
                                </tr>
                                <tr class="form_elements">
                                    <td class="form_elements"><div align="left">
                                            <label for="pubf"><input name="pubf" type="checkbox" id="pubf" onClick="change(this.id);" value="true" checked></label>
                                            Publications</div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="extc"><input name="extc" type="checkbox" id="extc" onClick="change(this.id);" value="true" checked></label>
                                            Associated Technology </div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="appt"><input name="appt" type="checkbox" id="appt" onClick="change(this.id);" value="true" checked></label>
                                            Solution</div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="locu"><input name="locu" type="checkbox" id="locu" onclick="change(this.id);" value="true" checked="checked" /></label>
                                            Availability</div></td>
                                </tr>
                                <tr class="form_elements">
                                    <td><div align="left">
                                            &nbsp;
                                            <label for="rif"><input name="rif" type="checkbox" id="rif" onclick="change(this.id);" value="true" checked="checked" /></label>
                                            Year of Publication </div></td>
                                    <td class="form_elements"><label for="extc"><input name="extc" type="checkbox" id="extc" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        About Us </td>
                                    <td class="form_elements"><label for="appt"><input name="appt" type="checkbox" id="appt" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        Benefits</td>
                                    <td class="form_elements">&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td><div align="left">
                                            &nbsp;
                                            <label for="pubf"><input name="pubf" type="checkbox" id="pubf" onclick="change(this.id);" value="true" checked="checked" /></label>
                                            Publication Category </div></td>
                                    <td class="form_elements"><label for="extc"><input name="extc" type="checkbox" id="extc" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        Research Groups </td>
                                    <td class="form_elements"><label for="appt"><input name="appt" type="checkbox" id="appt" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        Features
                                    </td>
                                    <td class="form_elements">&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td class="form_elements"><label for="edf"><input name="edf" type="checkbox" id="edf" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        Professional Preperation</td>
                                    <td class="form_elements">&nbsp;</td>
                                    <td class="form_elements"><label for="rest"><input name="rest" type="checkbox" id="rest" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        Development Stage</td>
                                    <td class="form_elements">&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td class="form_elements"><div align="left">
                                            <label for="edf"><input name="edf" type="checkbox" id="edf" onClick="change(this.id);" value="true" checked></label>
                                            Appointments</div></td>
                                    <td class="form_elements"><div align="left"></div></td>
                                    <td class="form_elements"><div align="left">
                                            <label for="rest"><input name="rest" type="checkbox" id="rest" onclick="change(this.id);" value="true" checked="checked" /></label>
                                            IP Status</div></td>
                                    <td class="form_elements"><div align="left"></div></td>
                                </tr>
                                <tr class="form_elements">
                                    <td class="form_elements"><label for="equipf"><input name="equipf" type="checkbox" id="equipf" onClick="change(this.id);" value="true" checked></label>
                                        Activities</td>
                                    <td class="form_elements">&nbsp;</td>
                                    <td><label for="rest"><input name="rest" type="checkbox" id="rest" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        UT Researchers </td>
                                    <td class="form_elements">&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td class="form_elements"><label for="equipf"><input name="equipf" type="checkbox" id="equipf" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        News Articles </td>
                                    <td class="form_elements">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="form_elements">&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td class="form_elements"><label for="equipf"><input name="equipf" type="checkbox" id="equipf" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        Support</td>
                                    <td class="form_elements">&nbsp;</td>
                                    <td class="form_elements">&nbsp;</td>
                                    <td class="form_elements">&nbsp;</td>
                                </tr>
                                <tr class="form_elements">
                                    <td>&nbsp;
                                        <label for="equipf"><input name="equipf" type="checkbox" id="equipf" onclick="change(this.id);" value="true" checked="checked" /></label>
                                        Only Active Support</td><td class="form_elements">&nbsp;</td>
                                    <td class="form_elements">&nbsp;</td>
                                    <td class="form_elements">&nbsp;</td>
                                </tr>
                                <tr bgcolor="#E4ECF5">
                                    <td colspan="4"><div align="center" class="form_elements">
                                            <div align="center">
                                                <label for="all"><input name="all" type="checkbox" id="all" value="true" checked onClick="change(this.id);"></label>
                                                Search in Everything </div>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><table width="100%"  border="0" cellspacing="1" cellpadding="1">
                                            <tr class="form_elements">
                                                <td colspan="2"><hr class="form_elements" width="95%"></td>
                                            </tr>
                                            <tr class="form_elements">
                                                <td colspan="2"><table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
                                                        <tr bgcolor="#E4ECF5" class="form_elements">
                                                            <td bgcolor="#E4ECF5" class="form_elements"><strong>Technology Clusters </strong></td>
                                                            <td width="6" bgcolor="#FFFFFF">&nbsp;</td>
                                                            <td width="427" bgcolor="#E4ECF5"><span class="form_elements"><strong>Industry Clusters</strong></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( <a href="#" onClick="expandTree('tree1'); return false;"><span class="form_elements">Expand All</span></a>&nbsp;&nbsp;&nbsp; <a href="#" onClick="collapseTree('tree1'); return false;"> <span class="form_elements">Collapse All</span></a>)</td>
                                                        </tr>
                                                        <tr class="form_elements">
                                                            <td width="200"></td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr class="form_elements">
                                                            <td><label for="t1"><input name="t1" type="checkbox" id="t1" value="true" checked></label>
                                                                Advanced Energy Technologies </td>
                                                            <td>&nbsp;</td>
                                                            <td rowspan="6"><!-- **************************tree structure **************************-->
                                                                <ul class="mktree" id="tree1">
                                                                    <li><label for="c1">
                                                                            <input name="c1" type="checkbox" id="c1" value="true" checked>
                                                                            Advanced Manufacturing</label>
                                                                        <ul>
                                                                            <li><label for="c2">
                                                                                    <input name="c2" type="checkbox" id="c2" value="true" checked></label>
                                                                                Nanotechnology and Materials</li>
                                                                            <li><label for="c3">
                                                                                    <input name="c3" type="checkbox" id="c3" value="true" checked></label>
                                                                                MEMS Manufacturin</li>
                                                                            <li><label for="c4">
                                                                                    <input name="c4" type="checkbox" id="c4" value="true" checked></label>
                                                                                Automotive Manufacturing</li>
                                                                            <li><label for="c17">
                                                                                    <input name="c17" type="checkbox" id="c17" value="true" checked></label>
                                                                                Semiconductor Manufacturing</li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><label for="c5">
                                                                            <input name="c5" type="checkbox" id="c5" value="true" checked></label>
                                                                        Aerospace and Defense
                                                                        <ul>
                                                                            <li><label for="c6">
                                                                                    <input name="c6" type="checkbox" id="c6" value="true" checked></label>
                                                                                Composite Advanced Materials</li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><label for="c7">
                                                                            <input name="c7" type="checkbox" id="c7" value="true" checked></label>
                                                                        Biotechnology and Life Science</li>
                                                                    <li><label for="c8">
                                                                            <input name="c8" type="checkbox" id="c8" value="true" checked></label>
                                                                        Energy
                                                                        <ul>
                                                                            <li><label for="c9">
                                                                                    <input name="c9" type="checkbox" id="c9" value="true" checked></label>
                                                                                Oil and Gas Production</li>
                                                                            <li><label for="c10">
                                                                                    <input name="c10" type="checkbox" id="c10" value="true" checked></label>
                                                                                Power Generation and Transportation</li>
                                                                            <li><label for="c11">
                                                                                    <input name="c11" type="checkbox" id="c11" value="true" checked></label>
                                                                                Manufactured Energy Systems</li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><label for="c12">
                                                                            <input name="c12" type="checkbox" id="c12" value="true" checked></label>
                                                                        Information and Computer Technology
                                                                        <ul>
                                                                            <li><label for="c13">
                                                                                    <input name="c13" type="checkbox" id="c13" value="true" checked></label>
                                                                                Communication Equipment</li>
                                                                            <li><label for="c14">
                                                                                    <input name="c14" type="checkbox" id="c14" value="true" checked></label>
                                                                                Computing Equipment</li>
                                                                            <li><label for="c15">
                                                                                    <input name="c15" type="checkbox" id="c15" value="true" checked></label>
                                                                                Information Technology</li>
                                                                        </ul>
                                                                    </li>
                                                                    <li><label for="c16">
                                                                            <input name="c16" type="checkbox" id="c16" value="true" checked></label>
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
                                                    </table></td>
                                            </tr>
                                            <tr class="form_elements">
                                                <td width="23%"><div align="right">with all the words &nbsp; </div></td>
                                                <td width="77%" bgcolor="#FFFFFF"><div align="left">
                                                        <label for="searchbox"><input name="search" id="searchbox" type="text" size="70"></label>
                                                    </div></td>
                                            </tr>
                                            <tr class="form_elements">
                                                <td><div align="right">with any of the words&nbsp;&nbsp; </div></td>
                                                <td bgcolor="#FFFFFF"><label for="searchbox2"><input name="search" id="searchbox2" type="text" size="70"></label></td>
                                            </tr>
                                            <tr class="form_elements">
                                                <td><div align="right">with the phrase&nbsp;&nbsp; </div></td>
                                                <td bgcolor="#FFFFFF"><label for="searchbox3"><input name="search" id="searchbox3" type="text" size="70"></label></td>
                                            </tr>
                                        </table></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><div align="center">
                                            <input name="Submit" type="button" class="form_elements" value="Search" onClick="alert('Under Construction');">
                                        </div></td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td height="19" valign="top" class="form_elements">&nbsp;</td>
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
                &copy; 2006 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>