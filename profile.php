<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Browse Profiles";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-script1'] = "<script type='text/javascript' src='<?php echo $_home; ?>/bp_f.js'></script>";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';

//� 2006 The University of Texas at Arlington
//Page created by: Raghavendra 
//Last edited by : Raghavendra
//Last edited    : 2nd March 2006
//Last change made : commenting


/* Info about page : This page takes
  1.'fname' & 'lname' of faculty as input
  2.only 'fname' or only 'lname' as input
  and display all the matching profiles with there
  picture. Depending on the selection the user will be
  directed to that particular profile
 */

// getting fname and lname variables from the url.
// for more information about 'real_unescape' function see 'utils.php'.
$fname = real_unescape($_GET['fname']);
$lname = real_unescape($_GET['lname']);


// how many rows to show per page
$rowsPerPage = 20;
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if (isset($_GET['page'])) $pageNum = real_unescape($_GET['page']);
// counting the offset
//$offset = ($pageNum * $maxpages) - $maxpage;
$offset = ($pageNum - 1) * $rowsPerPage;


/* if both fname and lname are not null then calculate
 */
if (($fname != null) && ($lname != null)) {
    //first query the number of rows for pagination
    $querynumrows = "SELECT DISTINCT T1.pid, T1.name, T2.image_id, T2.keywords, T2.pri_designation, 'Keywords' FROM gen_profile_info T1,
					 ppl_general_info T2 WHERE T2.f_name ='" . $fname . "' AND T2.l_name = '" . $lname . "' AND T1.pid = T2.pid ";

    $resultnumrows = real_execute_query($querynumrows, $db_conn);
    $numrows = mysql_num_rows($resultnumrows);
    $maxPage = ceil($numrows / $rowsPerPage);

    //actual query to retrieve the matching profiles.
    $query = "SELECT DISTINCT T1.pid, T1.name, T2.image_id, T2.keywords, T2.pri_designation, 'Keywords' FROM gen_profile_info T1,
					 ppl_general_info T2 where  T2.f_name ='" . $fname . "' AND T2.l_name = '" . $lname . "' AND T1.pid = T2.pid ";

    //executing the query. for more information about 'real_execute_query' function see 'utils.php'.
    $result = real_execute_query($query, $db_conn);
    $row = mysql_fetch_array($result);
}

/* if fname is null and lname is not null then calculate
 */
if (($fname == null) && ($lname != null)) {
    //first query the number of rows for pagination
    $querynumrows = "SELECT DISTINCT T1.pid, T1.name, T2.image_id, T2.keywords, T2.pri_designation, 'Keywords' FROM gen_profile_info T1,
					 ppl_general_info T2 WHERE T2.l_name = '" . $lname . "' AND T1.pid = T2.pid ";

    $resultnumrows = real_execute_query($querynumrows, $db_conn);
    $numrows = mysql_num_rows($resultnumrows);
    $maxPage = ceil($numrows / $rowsPerPage);
    //actual query to retrieve the matching profiles based on last name.
    $query = "SELECT DISTINCT T1.pid, T1.name, T2.image_id, T2.keywords, T2.pri_designation, 'Keywords' FROM gen_profile_info T1,
					 ppl_general_info T2 WHERE T2.l_name = '" . $lname . "' AND T1.pid = T2.pid ";

    //executing the query. for more information about 'real_execute_query' function see 'utils.php'.
    $result = real_execute_query($query, $db_conn);
    $row = mysql_fetch_array($result);
}

/* if fname is not null and lname is null then calculate
 */
if (($fname != null) && ($lname == null)) {
    //first query the number of rows for pagination
    $querynumrows = "SELECT DISTINCT T1.pid, T1.name, T2.image_id, T2.keywords, T2.pri_designation, 'Keywords' FROM gen_profile_info T1,
					 ppl_general_info T2 WHERE T2.f_name = '" . $fname . "' AND T1.pid = T2.pid ";

    $resultnumrows = real_execute_query($querynumrows, $db_conn);
    $numrows = mysql_num_rows($resultnumrows);
    $maxPage = ceil($numrows / $rowsPerPage);

    $query = "SELECT DISTINCT T1.pid, T1.name, T2.image_id, T2.keywords, T2.pri_designation, 'Keywords' FROM gen_profile_info T1,
					 ppl_general_info T2 WHERE T2.f_name = '" . $fname . "' AND T1.pid = T2.pid ";

    $result = real_execute_query($query, $db_conn);
    $row = mysql_fetch_array($result);
}

// if the result returned by one of the above query has only one row then directly go that profile.
if ($numrows == 1) {
    header("Location: {$_home}/editprofile.php?pid=" . $row[0] . "&onlyview=1"); /* Redirect browser */

    /* Make sure that code below does not get executed when we redirect. */
    exit();
}
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

<table>
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->

<?php
// if no result is found for the queries then 
// display message 'Sorry No matches Found"
// and redirect to browseprofiles.php page after 5 secs.
if ($numrows == 0) {
    print "<table><tr><td><font face=arial size=4>";
    print "Sorry No matches Found</font></td></tr>";
    print "<tr><td><font face=arial size=2>To see all Profiles <a href='{$_home}/browseprofiles.php'>click                here </a>"; /* Redirect browser */

    print "</font></td></tr></table>";
    /* Make sure that code below does not get executed when we redirect. */
}else {
    /* if more than one matching profile are found then display them
      with images.
     */
    print "<table width='100%'  border='0' cellspacing='0' cellpadding='2'>";
    print "<tr>" .
        "<td colspan='2'>&nbsp;</td>" .
        "</tr>";

    print "<table width='100%'  border='0' cellspacing='0' cellpadding='2' id='actualTable'><tr><td>";
    $altrow = 1;
    while ($row = mysql_fetch_array($result)) {
        if ($altrow == 1) $class = 'table_background_other';
        else $class='table_background_viewedit';
        print "\n<tr>";
        print "<td width='48' height='48' valign='middle' align='center' rowspan='2' class='" . $class . "' style='border:1px solid white'>";
        if ($row[2] != 0) print "<a href='{$_home}/editprofile.php?pid=" . $row[0] . "&onlyview=1#" . $jumpto . "'><img src='images/48/" . $row[0] . "_0_" . $row[2] . ".jpg' alt='' border='0'></a>";
        print "</td>";
        print "<td width='95%' class='" . $class . "' style='border-top:1px solid white;border-left:1px solid white;border-right:1px solid white'><span class='font_topic'>";

        print "<a href='{$_home}/editprofile.php?pid=" . $row[0] . "&onlyview=1'>" . $row[1] . "</a>";
        print "</span></td>";
        print "</tr>";
        print "<tr>";
        print "<td id='secdetail' class='" . $class . "' style='border-bottom:1px solid white;border-left:1px solid white;border-right:1px solid white'>";
        if ($row[4] != "") print( "<B>" . $row[4] . "</B><BR>");
        if ($row[3] != "") print( $row[5] . ":&nbsp;" . $row[3]);
        print( "</td>");
        print "</tr>";
        //      print "<tr>".
        //            "<td colspan='2'>&nbsp;</td>".
        //  	  "</tr>";
        if ($altrow == 1) $altrow = 2;
        else $altrow=1;
    }
    print "<tr>" .
        "<td colspan='2'>&nbsp;</td>" .
        "</tr>";
    print "<tr>";
    //pagination if the number of matching profile does not fit on to a single page.

    print "<td colspan='2' align='center' class='pageheading'>";
    $self = $_SERVER['PHP_SELF']; //right now not using it anywhere in the code
    $nav = '';
    for ($page = 1; $page <= $maxPage; $page++) {
        if ($page == $pageNum) {
            $nav .= " $page "; // no need to create a link to current page
        }else {
            $nav .= "<a href=\"profile.php?page=$page\">$page</a> ";
        }
    }


    if ($pageNum > 1) {
        $page = $pageNum - 1;
        $prev = " <a href=\"profile.php?page=$page\">[Prev]</a> ";

        $first = " <a href=\"profile.php?page=1\">[First Page]</a> ";
    }else {
        $prev = '&nbsp;'; // we're on page one, don't print previous link
        $first = '&nbsp;'; // nor the first page link
    }

    if ($pageNum < $maxPage) {
        $page = $pageNum + 1;
        $next = " <a href=\"profile.php?page=$page\">[Next]</a> ";

        $last = " <a href=\"profile.php?page=$maxPage\">[Last Page]</a> ";
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
}
?>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="table_background">
            <!-- Partnership text in this section with the hyperlink should remain visible on the template page and should not deleted -->
            <div align="right"><a href="http://www.txstate.edu/research/" target="_blank"><span class="font_on_dark_blue"><strong>powering - The Partnership</strong></span></a></div>
            <!-- End of Partnership text -->
        </td>
    </tr>
    <!-- footer content goes here -->
    <tr>
        <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy; 2010 Texas State University - San Marcos| <a href="http://www.txstate.edu/research">Electronic Research Administration</a>, 601 University Drive, San Marcos, Texas 78666 Voice: 512.245.211 |<a href="feedback.php">Site Feedback</a> | <a href="http://www.txstate.edu/research/oera.html">Contact Electronic Research Administration - Web Team</a><br />

                </font></div>
            <!-- Start of StatCounter Code
    This spot can be used to enter tracking coutner code. Recommended: http://www.statcounter.com
    End of StatCounter Code -->
        </td>
        <!--end of footer -->
    </tr>
    <tr>
        <td bgcolor="#D7CFCD" class="form_elements_row_action"> <div align="center"><span class="error_message">Important Disclaimer: </span><strong>The responsibility for the accuracy of the information contained on these pages lies with the authors and user providing such information. </strong></div></td>
    </tr>
</table>
</body>
<!-- InstanceEnd --></html>