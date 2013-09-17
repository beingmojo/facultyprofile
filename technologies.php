<?php
session_start();
$_POST['page-title'] = "Technologies";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-link4'] = "<link href='css/vp.css' rel='stylesheet' type='text/css'>";
$_POST['page-link5'] = "<link href='css/atigateway_rollover_new.css' rel='stylesheet' type='text/css'>";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);

$view = real_unescape($_GET['view']);
$type = real_unescape($_GET['type']);

if ($view == "") $view = '3';
// how many rows to show per page
$rowsPerPage = 20;
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if (isset($_GET['page'])) $pageNum = real_unescape($_GET['page']);
// counting the offset
//$offset = ($pageNum * $maxpages) - $maxpage;
$offset = ($pageNum - 1) * $rowsPerPage;


switch ($view) {
    case 3: if (($view == 3) && ($type == 1)) {
            $querynumrows = "SELECT DISTINCT T1.pid, T1.name, T1.image_id, T1.keywords, '', 'Keywords' FROM tech_gen_info T1 ,tech_status T2
						WHERE T1.pid = T2.pid  AND T2.type =1 ";

            $resultnumrows = real_execute_query($querynumrows, $db_conn);
            $numrows = mysql_num_rows($resultnumrows);

            $maxPage = ceil($numrows / $rowsPerPage);

            $query = "SELECT DISTINCT T1.pid, T1.name, T1.image_id, T1.keywords, '', 'Keywords' FROM tech_gen_info T1 ,tech_status T2
						WHERE T1.pid = T2.pid  AND T2.type =1 ORDER BY name ASC LIMIT $offset, $rowsPerPage";
        }else if (($view == 3) && ($type == 2)) {
            $querynumrows = "SELECT DISTINCT T1.pid, T1.name, T1.image_id, T1.keywords, '', 'Keywords' FROM tech_gen_info T1 ,tech_status T2
						WHERE T1.pid = T2.pid  AND T2.type = 2";

            $resultnumrows = real_execute_query($querynumrows, $db_conn);
            $numrows = mysql_num_rows($resultnumrows);
            $maxPage = ceil($numrows / $rowsPerPage);

            $query = "SELECT DISTINCT T1.pid, T1.name, T1.image_id, T1.keywords, '', 'Keywords' FROM tech_gen_info T1 ,tech_status T2
						WHERE T1.pid = T2.pid  AND T2.type = 2 ORDER BY name ASC LIMIT $offset, $rowsPerPage";
        }else {
            $querynumrows = "SELECT T1.pid, T1.name, T2.image_id, T2.keywords, '', 'Keywords' FROM gen_profile_info T1," .
                " tech_gen_info T2 WHERE T1.pid = T2.pid AND T1.type_id = 3  AND T1.status = 0 ";

            $resultnumrows = real_execute_query($querynumrows, $db_conn);
            $numrows = mysql_num_rows($resultnumrows);
            $maxPage = ceil($numrows / $rowsPerPage);

            $query = "SELECT T1.pid, T1.name, T2.image_id, T2.keywords, '', 'Keywords' FROM gen_profile_info T1," .
                " tech_gen_info T2 WHERE T1.pid = T2.pid AND T1.type_id=" . real_mysql_specialchars($view, true) .
                " AND T1.status = 0 ORDER BY name ASC LIMIT $offset, $rowsPerPage";
        }
}
$result = real_execute_query($query, $db_conn);
?>

<style media="screen">
    .tdHiLite {
        background-color: #3399FF;
        cursor:pointer;
    }

    .tdLoLite {
        background-color: #D5EAFF;
        cursor:pointer;
    }
</style>
<style type="text/css">
    <!--
    a {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #000000;
    }
    a:link {
        text-decoration: none;
        color: #093576;
    }
    a:visited {
        text-decoration: none;
        color: #093576;
    }
    a:hover {
        text-decoration: underline;
        color: #093576;
    }
    a:active {
        text-decoration: none;
        color: #093576;
    }
    body,td,th {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10px;
    }
    .style1 {font-size: 10px; font-weight: normal; text-align:left; font-family: Verdana, Arial, Helvetica, sans-serif;}
    -->
</style>
<script type="text/javascript">
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

</script>
<?php
print "<table width='100%'  border='0' cellspacing='0' cellpadding='2'>";
print "<tr>" .
    "<td colspan='2'>&nbsp;</td>" .
    "</tr><tr><td colspan='2'>";

if ($view == 3) {
    print("<br>");
    print("<font size=2px; weight=bold >");
    print("View Technologies by Type:&nbsp;&nbsp; ");
    if ($type != 1) print("<a href='technologies.php?view=3&type=1'>Patents</a>");
    else print "Patents";
    print("&nbsp; |&nbsp; ");
    if ($type != 2) print("<a href='technologies.php?view=3&type=2'>Patents in Application</a>");
    else print "Patents in Application";
    print("&nbsp; |&nbsp; ");
//		  print("  <img src='images/bullets/blue.png' /> ");
    if ($type != "") print("<a href='technologies.php?view=3'>View All</a>");
    else print "View All";
    print("</font>");
    print("<br></td></tr><tr><td colspan='2' >");
}
// printing of actual data begins
print "<table width='100%'  border='0' cellspacing='0' cellpadding='2' id='actualTable' >
		   <tr>
		   		<td>";
$altrow = 1;

while ($row = mysql_fetch_array($result)) {
    if ($altrow == 1) $class = '';
    else $class='';
    print "\n<tr>";
    print "<td width='48' height='48' valign='middle' align='left' rowspan='2' class='" . $class . "' style='border:1px solid black'>";
    if ($row[2] != 0) print "<a href='{$_home}/editprofile.php" . "?pid=" . $row[0] . "&onlyview=1'><img src='images/48/" . $row[0] . "_0_" . $row[2] . ".jpg' alt='' border='0'></a>";
    print "</td>";
    print "<td width='95%' class='" . $class . "' style='border-top:1px solid black;border-left:1px black;border-right:1px black'><span class='font_topic'>";
    print "<a href='{$_home}/editprofile.php" . "?pid=" . $row[0] . "&onlyview=1' target='_parent'>" . $row[1] . "</a>";
    print "</span></td>";
    print "</tr>";
    print "<tr>";
    print "<td id='secdetail' class='" . $class . "' style='border-bottom:1px black;border-left:1px black;border-right:1px black'>";
    if ($row[4] != "") print( "<B>" . $row[4] . "</B><BR>");
    if ($row[3] != "") print( $row[5] . ":&nbsp;" . $row[3]);
    print( "</td>");
    print "</tr>";
    if ($altrow == 1) $altrow = 2;
    else $altrow=1;
}
print "<tr>" .
    "<td colspan='2'>&nbsp;</td>" .
    "</tr>";
print "<tr>";

// page navigation code

print "<td colspan='2' align='center' class='pageheading'>";
$self = $_SERVER['PHP_SELF']; //right now not using it anywhere in the code
$nav = '';
for ($page = 1; $page <= $maxPage; $page++) {
    if ($page == $pageNum) {
        $nav .= " $page "; // no need to create a link to current page
    }else {
        $nav .= "<a href=\"technologies.php?view=$view&page=$page&type=$type\">$page</a> ";
    }
}
//			 $nav.= "<a href=\"browseprofiles.php?view=$view&page=2&hid=$hid&type=$type\">2</a>";
// creating previous and next link
// plus the link to go straight to
// the first and last page

if ($pageNum > 1) {
    $page = $pageNum - 1;
    $prev = " <a href=\"technologies.php?view=$view&page=$page&type=$type\">[Prev]</a> ";

    $first = " <a href=\"technologies.php?view=$view&page=1&type=$type\">[First Page]</a> ";
}else {
    $prev = '&nbsp;'; // we're on page one, don't print previous link
    $first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $maxPage) {
    $page = $pageNum + 1;
    $next = " <a href=\"technologies.php?view=$view&page=$page&type=$type\">[Next]</a> ";

    $last = " <a href=\"technologies.php?view=$view&page=$maxPage&type=$type\">[Last Page]</a> ";
}else {
    $next = '&nbsp;'; // we're on the last page, don't print next link
    $last = '&nbsp;'; // nor the last page link
}

// print the navigation link
echo $first . $prev . $nav . $next . $last;
print "</td>";
print "</tr>";
print "</table>";
print "</td></tr></table>";
?>

</body>
</html>
