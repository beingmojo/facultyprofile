<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Advanced Search 2";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-link4'] = "<link rel='stylesheet' href='styles/mktree.css' type='text/css'>";
$_POST['page-script1'] = "<SCRIPT LANGUAGE='JavaScript' SRC='scripts/mktree.js'></SCRIPT>";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
?>

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
<script type="text/javascript">
    function checkedOffType(typeNumber) {
        var typeCheck = document.getElementById("typeCheck" + typeNumber);
        typeCheck.onclick = function() { checkedOnType(typeNumber); }
        var typeRows = document.getElementById("type" + typeNumber).getElementsByTagName("tr");
        for (var i = 0; i < typeRows.length; i++) {
            var masterCheck = typeRows[i].getElementsByTagName("td")[0].getElementsByTagName("input")[0];
            var regEx = /^([a-z]+)(\d+)$/gi;
            var sectionNumber = masterCheck.getAttribute("id").replace(regEx,'$2');
            checkedOff(sectionNumber);
            masterCheck.checked="";
            masterCheck.disabled="disabled";
        }
    }
    function checkedOnType(typeNumber) {
        var typeCheck = document.getElementById("typeCheck" + typeNumber);
        typeCheck.onclick = function() { checkedOffType(typeNumber); }
        var typeRows = document.getElementById("type" + typeNumber).getElementsByTagName("tr");
        for (var i = 0; i < typeRows.length; i++) {
            var masterCheck = typeRows[i].getElementsByTagName("td")[0].getElementsByTagName("input")[0];
            var regEx = /^([a-z]+)(\d+)$/gi;
            var sectionNumber = masterCheck.getAttribute("id").replace(regEx,'$2');
            checkedOn(sectionNumber);
            masterCheck.checked="checked";
            masterCheck.disabled="";
            if (masterCheck.value == "equipment")
                showFields(sectionNumber);
        }
    }
    function checkedOff(sectionNumber) {
        var masterCheck = document.getElementById("masterCheck" + sectionNumber);
        masterCheck.onclick = function() {checkedOn(sectionNumber);}
        var checks = document.getElementById("fields" + sectionNumber).getElementsByTagName("input");
        for(var i = 0; i < checks.length; i++) {
            checks[i].checked = "";
            checks[i].disabled = "disabled";
        }
        hideFields(sectionNumber);
    }
    function checkedOn(sectionNumber) {
        var masterCheck = document.getElementById("masterCheck" + sectionNumber);
        masterCheck.onclick = function() {checkedOff(sectionNumber);}
        var checks = document.getElementById("fields" + sectionNumber).getElementsByTagName("input");
        for(var i = 0; i < checks.length; i++) {
            checks[i].checked = "checked";
            checks[i].disabled = "";
        }
    }
    function checkAll() {
<?php
if (!stristr($_SERVER['HTTP_USER_AGENT'], 'msie')) {
?>
                var rows = document.getElementById("searchBox").childNodes[1].childNodes;
<?php
}else {
?>
                var rows = document.getElementById("searchBox").childNodes[0].childNodes;
<?php
}
?>
        for (var i = 1; i < rows.length; i++) {
            if(rows[i].tagName == "TR") {
                var typeCheck = rows[i].getElementsByTagName("td")[0].getElementsByTagName("input")[0];
                var regEx = /^([a-z]+)(\d+)$/gi;
                var typeNumber = typeCheck.id.replace(regEx,'$2');
                checkedOnType(typeNumber);
                typeCheck.checked="checked";
            }
        }
    }
    function showFields(sectionNumber) {
        var fields = document.getElementById("fields" + sectionNumber);
        fields.style.display="inline";
        var fieldSwitch = document.getElementById("fieldSwitch" + sectionNumber);
        fieldSwitch.href = "javascript:hideFields('" + sectionNumber + "')";
        var fieldSwitchText = fieldSwitch.getElementsByTagName("div");
        fieldSwitchText[0].innerHTML = "Confirm";
    }
    function hideFields(sectionNumber) {
        var fields = document.getElementById("fields" + sectionNumber);
        fields.style.display="none";
        var fieldSwitch = document.getElementById("fieldSwitch" + sectionNumber);
        fieldSwitch.href = "javascript:showFields('" + sectionNumber + "')";
        var fieldSwitchText = fieldSwitch.getElementsByTagName("div");
        fieldSwitchText[0].innerHTML = "Select Specific Fields &gt;&gt;";
    }
</script>
<style type="text/css">
    span.type {font-size:14px;font-weight:bold;}
    span.section {font-size:12px;}
    td.fields {display:none;}
    td.fields ul {margin:0px;}
    td.fields ul li {list-style:none;font-size:10px;}
    td.equipmentFields ul {margin:-2px 0px 0px 0px;padding:0px;}
    td.equipmentFields ul li {margin:0px;padding:0px;list-style:none;font-size:12px;}
</style>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="box" id="details" bgcolor="#FFFFFF">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td background="images/tabsilver.gif0" height="33" width="111" valign="bottom" align="center"><a href="newsearch.php"><span class="tab_menu">Basic</span></a></td>
                                <td background="images/tabsilver.gif0" width="111" valign="bottom" align="center" ><a href="clustersearch.php"><span class="tab_menu">Clusters</span></a></td>
                                <td background="images/tabsilver.gif0" width="111" valign="bottom" align="center" ><a href="advsearch.php"><span class="tab_menu">Advanced</span></a></td>
                                <td background="images/tabblue.gif0" width="111" valign="bottom" align="center" ><span class="tab_menu">Advanced(Beta)</span></td>
                                <td width="111" valign="bottom">&nbsp;</td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td height="5" bgcolor="#580000"></td>
                </tr>
                <tr>
                    <td height="16" valign="top" bgcolor="#580000" class="font_topic_other"><br>
                        Search Profiles <span class="form_elements">(under construction)</span><br>
                        &nbsp;</td>
                </tr>
                <tr>
                    <td height="270" valign="top" bgcolor="#580000">
                        <form action="advsearchresults.php" name="searchform" method="post" >
                            <table id="searchBox" width="98%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" class="searchBox">
                                <tr>
                                    <td align="center" bgcolor="#CDAF95">Type</td>
                                    <td align="left" bgcolor="#CDAF95">
                                        &nbsp;&nbsp;Section&nbsp;&nbsp;<a href="javascript:checkAll();">Select All</a>
                                    </td>
                                </tr>
<?php
$typeCounter = 0;
$sectionCounter = 0;
$typesSQL = "SELECT name, type_id FROM gen_profile_types WHERE type_id<>'6' ORDER BY type_id ASC";
$typesQuery = real_execute_query($typesSQL, $db_conn);
while ($typesRow = mysql_fetch_array($typesQuery)) {
    $type_id = $typesRow['type_id'];
    if ($type_id == 2) $typesRow['name'] = "Research Centers &amp; Groups";
    echo "<tr>";
    printf("<td width=\"150\" align=\"center\" bgcolor=\"#CDAF95\"><label for=\"typeCheck%d\"><input type=\"checkbox\" id=\"typeCheck%d\" checked=\"checked\" onclick=\"checkedOffType(%d)\" /><span class=\"type\">%s</span></label></td>", $typeCounter, $typeCounter, $typeCounter, $typesRow['name']);
    $sectionsSQL = "SELECT name, table_name
									FROM gen_section_types 
									WHERE type_id='$type_id' AND table_exists='1'
									ORDER BY order_no ASC";
    $sectionsQuery = real_execute_query($sectionsSQL, $db_conn);
    echo "<td align=\"left\" valign=\"top\">";
    printf("<table id=\"type%d\">", $typeCounter);
    if ($typesRow['type_id'] != 5) {
        while ($sectionsRow = mysql_fetch_array($sectionsQuery)) {
            $table_name = $sectionsRow['table_name'];
            echo "<tr>";
            echo "<td width=\"200\"align=\"left\" valign=\"top\">";
            echo "<span class=\"section\">";
            printf("<label for=\"masterCheck%d\"><input id=\"masterCheck%d\" type=\"checkbox\" name=\"section_filter[%d]\" value=\"%s\" checked=\"checked\" onClick=\"checkedOff('%d');\"/></label>%s",
                $sectionCounter, $sectionCounter, $sectionCounter, $table_name, $sectionCounter, $sectionsRow['name']);
            echo "</span>";
            echo "</td>";
            echo "<td width=\"130\" align=\"center\" valign=\"top\">";
            printf("<a id=\"fieldSwitch%d\" href=\"javascript:showFields('%d');checkedOn('%d');\"><div>Select Specific Fields &gt;&gt;</div></a>",
                $sectionCounter, $sectionCounter, $sectionCounter);
            echo "</td>";
            printf("<td width=\"500\" align=\"left\" valign=\"top\" id=\"fields%d\" class=\"fields\">", $sectionCounter);
            echo "<ul>";
            $fieldsSQL = "SELECT field_name, display_name FROM gen_section_searchfields WHERE table_name='$table_name' ORDER BY display_name ASC";
            $fieldsQuery = real_execute_query($fieldsSQL, $db_conn);
            $fieldCounter = 0;
            while ($fieldsResults = mysql_fetch_array($fieldsQuery)) {
                printf("<li><label for=\"field_filter[%s][%d]\"><input type=\"checkbox\" name=\"field_filter[%s][%d]\" id=\"field_filter[%s][%d]\" value=\"%s\"/></label>%s</li>",
                    $table_name, $fieldCounter, $table_name, $fieldCounter, $fieldsResults['field_name'], $fieldsResults['display_name']);
                $fieldCounter++;
            }
            echo "</ul>";
            echo "</td>";
            echo "</tr>";
            $sectionCounter++;
        }
    }else {
        echo "<tr>";
        printf("<td id=\"fields%s\" width=\"200\"align=\"left\" valign=\"top\" class=\"equipmentFields\">", $sectionCounter);
        printf("<label for=\"masterCheck%d\"><input type=\"hidden\" id=\"masterCheck%d\" name=\"section_filter[%d]\" value=\"equipment\" /></label>", $sectionCounter, $sectionCounter, $sectionCounter);
        printf("<a id=\"fieldSwitch%d\" style=\"display:none\"><div></div></a>", $sectionCounter);
        $equipmentFieldsSQL = "SELECT field_name,display_name
													FROM gen_section_searchfields 
													WHERE type_id='5'
													ORDER BY display_name ASC";
        $equipmentFieldsQuery = real_execute_query($equipmentFieldsSQL, $db_conn);
        $fieldCounter = 0;
        echo "<ul>";
        while ($equipmentFieldsRow = mysql_fetch_array($equipmentFieldsQuery)) {
            printf("<li><label for=\"field_filter[equipment][%d]\"><input type=\"checkbox\" name=\"field_filter[equipment][%d]\" id=\"field_filter[equipment][%d]\" value=\"%s\" checked=\"checked\" /></label>%s</li>",
                $fieldCounter, $fieldCounter, $fieldCounter, $equipmentFieldsRow['field_name'], $equipmentFieldsRow['display_name']);
            $fieldCounter++;
        }
        echo "</ul>";
        echo "</td>";
        echo "</tr>";
        $sectionCounter++;
    }
    echo "</table>";
    echo "</td>";
    echo "</tr>";
    $typeCounter++;
}
?>
                            </table>
                            <table>
                                <tr>
                                    <td>With any of the words</td><td><label for="search_str_some"><input type="text" name="search_str_some" id="search_str_some" /></label></td>
                                </tr>
                                <tr>
                                    <td>With all of the words</td><td><label for="search_str_all"><input type="text" name="search_str_all" id="search_str_all" /></label></td>
                                </tr>
                                <tr>
                                    <td>With the exact phrase</td><td><label for="search_str_exact"><input type="text" name="search_str_exact" id="search_str_exact" /></label></td>
                                </tr>
                                <tr>
                                    <td>Without the words</td><td><label for="search_str_less"><input type="text" name="search_str_less" id="search_str_less" /></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input type="submit" name="submit" value="search" /></td>
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
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
<!-- InstanceEnd -->
</html>