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
    <td style="background-color:#480000;color:#CCCCCC;" height="10px"><span style="margin-top:2px;margin-left:10px;font-family:times,san-serif;font-weight:bold;font-size:16px">Browse Courses</span></td>
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
    /*Horizontal Rule*/
    hr {
        color:#CCCCCC;
        height:1px;
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

<!--SECTION: Start of page-specific items -->
<script type="text/javascript">
    function courseBrowse(field_id) {
        var courseSearch = new ajaxCourseBrowse();
        var searchHint = new ajaxCourseBrowseHints(field_id);
    }
    function ajaxCourseBrowse()
    {
        var xmlHttpReq = false;
        var self = this;
        // Mozilla/Safari

        if (window.XMLHttpRequest)
        {
            self.xmlHttpReq = new XMLHttpRequest();
        }
        // IE
        else
            if (window.ActiveXObject)
        {
            self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
        }
        //var course_acronym = document.getElementById("course_acronym").value;
        var course_number = document.getElementById("course_number").value;
        var course_semester = document.getElementById("course_semester").value;
        var course_year = document.getElementById("course_year").value;
        var course_title = document.getElementById("course_title").value;
        var course_description = document.getElementById("course_description").value;
        var prof_fname = document.getElementById("prof_fname").value;
        var prof_lname = document.getElementById("prof_lname").value;
        var page = document.getElementById("page");
        page = (page)?page.value:"1";
        var url = "browse_search_course.php?session="+Math.random();

        if (course_number)
            url+="&course_number="+course_number;
        if (course_semester)
            url+="&course_semester="+course_semester;
        if (course_year)
            url+="&course_year="+course_year;
        if (course_title)
            url+="&course_title="+course_title;
        if (course_description)
            url+="&course_description="+course_description;
        if (prof_fname)
            url+="&prof_fname="+prof_fname;
        if (prof_lname)
            url+="&prof_lname="+prof_lname;
        if (page)
            url+="&page="+page;
        self.xmlHttpReq.open('GET', url, true);
        self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        self.xmlHttpReq.onreadystatechange = function()
        {
            if (self.xmlHttpReq.readyState == 4)
            {
                document.getElementById("searchCourseResults").innerHTML = self.xmlHttpReq.responseText;
                page = document.getElementById("page");
                if (page)
                    document.getElementById("page").value = "1";
            }
        }

        self.xmlHttpReq.send(null);
        document.getElementById("searchCourseResults").innerHTML = "<h2>Searching...</h2>";
    }

    function ajaxCourseBrowseHints(field_id, sender)
    {
        var xmlHttpReq = false;
        var self = this;
        // Mozilla/Safari

        if (window.XMLHttpRequest)
        {
            self.xmlHttpReq = new XMLHttpRequest();
        }
        // IE
        else
            if (window.ActiveXObject)
        {
            self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
        }
        field = document.getElementById(field_id);
        fieldValue = document.getElementById(field_id).value;
        var url = "browse_search_course_hints.php?session="+Math.random();
        url += "&" + field_id + "=" + fieldValue;

        self.xmlHttpReq.open('GET', url, true);
        self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        self.xmlHttpReq.onreadystatechange = function()
        {
            if (self.xmlHttpReq.readyState == 4)
            {
                if(self.xmlHttpReq.responseText != "")
                    document.getElementById("searchHint").style.display = "inline";
                document.getElementById("searchHint").innerHTML = self.xmlHttpReq.responseText;
                document.getElementById("searchHint").style.top = field.offsetTop + 20 + "px";
                document.getElementById("searchHint").style.left = field.offsetLeft + "px";
            }
        }

        self.xmlHttpReq.send(null);
        document.getElementById("searchHint").style.display = "none";
    }
    function hideHint() {
        document.getElementById("searchHint").style.display = "none";
    }
    function selectHint(field_id,hint) {
        document.getElementById(field_id).value = hint;
        ajaxCourseBrowse();
        hideHint();
    }
    function sortSearchResults(column,direction) {
        var rows = document.getElementById("searchCourseResults").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
        var sortColumn = new Array();
        for(var i=0;i<rows.length;i++) {
            sortColumn[i] = new Array(i,rows[i].getElementsByTagName("td")[column].innerHTML);
        }
        if(direction == "asc") {
            sortColumn = columnSortAsc(sortColumn);
            document.getElementById("sort"+column).onclick = function() {sortSearchResults(column,"desc");}
            document.getElementById("sort"+column).innerHTML="Sort&nbsp;&uarr;";
        }
        if(direction == "desc") {
            sortColumn = columnSortDesc(sortColumn);
            document.getElementById("sort"+column).onclick = function() {sortSearchResults(column,"asc");}
            document.getElementById("sort"+column).innerHTML="Sort&nbsp;&darr;";
        }
        //Does not work with IE
        /*
        var sortedRows = new Array();
        for (var i=0;i<sortColumn.length;i++)
                sortedRows[i] = rows[sortColumn[i][0]].innerHTML;
        for (var i=0;i<sortedRows.length;i++)
                rows[i].innerHTML = sortedRows[i];
         */

        //Does work with IE
        var sortedRows = new Array();
        var numColumns = rows[0].getElementsByTagName("td").length;
        var newCell;
        for (var i=0;i<sortColumn.length;i++) {
            for(var ii=0;ii<numColumns;ii++) {
                if(!sortedRows[i])
                    sortedRows[i] = new Array();
                sortedRows[i][ii] = rows[sortColumn[i][0]].cells[ii].innerHTML;
            }
        }
        for (var i=0;i<sortedRows.length;i++) {
            for(var ii=0;ii<numColumns;ii++) {
                rows[i].cells[ii].innerHTML = sortedRows[i][ii];
            }
        }
    }
    function columnSortAsc(column) {
        var holder = new Array();
        var hasSwapped = true;
        while (hasSwapped == true) {
            hasSwapped = false;
            for (var i=0;i<column.length-1;i++) {
                holder = column[i+1];
                if (column[i][1] > column[i+1][1]) {
                    column[i+1] = column[i];
                    column[i] = holder;
                    hasSwapped = true;
                }
            }
        }
        return column;
    }
    function columnSortDesc(column) {
        var holder = new Array();
        var hasSwapped = true;
        while (hasSwapped == true) {
            hasSwapped = false;
            for (var i=0;i<column.length-1;i++) {
                holder = column[i+1];
                if (column[i][1] < column[i+1][1]) {
                    column[i+1] = column[i];
                    column[i] = holder;
                    hasSwapped = true;
                }
            }
        }
        return column;
    }
    //-->
</script>
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
        ajaxCourseBrowse();
    }

    //-->
</script>
<style type="text/css">
    #frmSearchCourse input {
        background-color:none;
    }
    #frmSearchCourse tr td:first-child {
        text-align:right;
    }
    #frmSearchCourse tr td:first-child + td + td {
        text-align:right;
    }
    #frmSearchCourse input {position:relative;}
    div#searchHint {position:absolute;padding:5px;display:none;background-color:#FFFFB7;color:black;z-index:1;}
    div#searchHint p {padding:0px;margin:0px;font-size:13px;}
</style>
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
            <td colspan="2">
                <!-- InstanceBeginEditable name="content" -->
                <div id="searchHint"></div>
                <form id="frmSearchCourse" target="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                    <table width="60%">
                        <tr>
                            <td><span class="form_elements_text">Course Number:&nbsp;</span></td>
                            <td>
                                <input type="text" id="course_number" maxlength="9" size="20" onkeyup="courseBrowse('course_number')" onfocus="hideHint()" />
                            </td>
                            <td><span class="form_elements_text">Course Semester and Year:&nbsp;</span></td>
                            <td>
                                <input type="text" id="course_semester" maxlength="16" size="13" onkeyup="courseBrowse('course_semester')" onfocus="hideHint()" />
                                <input type="text" id="course_year" maxlength="4" size="2" onkeyup="courseBrowse('course_year')" onfocus="hideHint()" />
                            </td>
                        </tr>
                        <tr>
                            <td><span class="form_elements_text">Course Title:&nbsp;</span></td>
                            <td><input type="text" id="course_title" maxlength="40" size="20" onkeyup="courseBrowse('course_title')" onfocus="hideHint()" /></td>
                            <td><span class="form_elements_text">Course Description:&nbsp;</span></td>
                            <td><input type="text" id="course_description" maxlength="40" size="20" onkeyup="courseBrowse('course_description')" onfocus="hideHint()" /></td>
                        </tr>
                        <tr>
                            <td><span class="form_elements_text">Professor's Last Name:&nbsp;</span></td>
                            <td><input type="text" id="prof_lname" maxlength="20" size="20" onkeyup="courseBrowse('prof_lname')" onfocus="hideHint()" /></td>
                            <td><span class="form_elements_text">Professor's First Name:&nbsp;</span></td>
                            <td><input type="text" id="prof_fname" maxlength="20" size="20" onkeyup="courseBrowse('prof_fname')" onfocus="hideHint()" /></td>
                        </tr>
                    </table>
                </form>
                <br /><br /><br /><div style="margin-left:20px" id="searchCourseResults"></div>

                <!-- InstanceEndEditable -->
            </td>
        </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><!-- Page footer -->
        <td colspan="2" align="center">
            <p align="center"><img src="images/line.jpg" alt="" width="700" height="1"/></p>
            <p>
                <a href="http://www.uta.edu/collaborate" target="_blank" class="rsp">powering - The Partnership</a><br />
                &copy; 2006 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
    </table>
</body>
<!-- InstanceEnd --></html>