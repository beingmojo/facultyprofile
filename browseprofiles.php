<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Browse Profiles";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-script1'] = "<script type='text/javascript' src='scripts/bp_f.js'></script>";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';


$view = real_unescape($_GET['view']);
$hid = real_unescape($_GET['hid']);
$type = real_unescape($_GET['type']);
$views = array(1, 2, 3, 4, 5, 6);
if (!in_array($view, $views)) {
    $view = $views[0];
}
// displaying filter by department
$querydept = "SELECT * FROM gen_hierarchy_types ORDER BY hid ASC";
$resultdept = real_execute_query($querydept, $db_conn);
// how many rows to show per page
$rowsPerPage = 20;
// by default we show first page
$pageNum = 1;
// if $_GET['page'] defined, use it as page number
if (isset($_GET['page'])) {
    $pageNum = real_unescape($_GET['page']);
}
// counting the offset
//$offset = ($pageNum * $maxpages) - $maxpage;
$offset = ($pageNum - 1) * $rowsPerPage;
$hid_list = "";
if ($hid != "") {
    $hid = real_mysql_specialchars($hid, true);
    $hidquery = "SELECT T1.hid FROM gen_hierarchy_types T1, gen_hierarchy_types T2 WHERE T2.hid = $hid  AND T2.h1 = T1.h1 AND ( T2.h2 = 0 OR T2.h2 = T1.h2 ) AND (T2.h3 = 0 OR T2.h3 = T1.h3) ORDER BY T1.hid";
    $hidresults = real_execute_query($hidquery, $db_conn);
    while ($hidrows = mysql_fetch_array($hidresults)) {
        if ($hid_list == "") $hid_list = $hidrows["hid"];
        else $hid_list .= "," . $hidrows["hid"];
    }
}
// how many rows we have in database.(for pagination)
$querynumrows = "SELECT DISTINCT T1.pid FROM gen_profile_info T1 ";
if ($hid_list != "") {
    $querynumrows .= " , gen_profile_hierarchy T3 ";
}
$querynumrows .= " WHERE T1.status = 0 AND T1.type_id=" . real_mysql_specialchars($view, true);
if ($hid_list != "") {
    $querynumrows .= " AND T1.pid = T3.pid AND T3.hid IN ( $hid_list ) ";
}
$resultnumrows = real_execute_query($querynumrows, $db_conn);
$numrows = mysql_num_rows($resultnumrows);
// how many pages we will have when using paging?
$maxPage = ceil($numrows / $rowsPerPage);
/* The Switch control takes view as input, and depending on the view value it executes that particular view query.
  view == 1 ----> Query for Faculty profiles.
  view == 2 ----> Query for Center profiles.
  view == 3 ----> Query for Technology profiles.
  view == 4 ----> Query for Facility profiles.
  view == 5 ----> Query for Equipment profiles.
  view == 6 ----> Query for Labs & Groups profiles. */
switch ($view) {
    case 1:
        $query = "SELECT DISTINCT T1.pid, T1.name, T2.image_id, T2.keywords, T2.pri_designation, 'Keywords' FROM gen_profile_info T1," .
            " ppl_general_info T2 ";
        if ($hid_list != "") $query .= " , gen_profile_hierarchy T3";
        $query .= " WHERE T1.pid = T2.pid AND type_id=" . real_mysql_specialchars($view, true);
        if ($hid_list != "") $query .= " AND T1.pid = T3.pid AND T3.hid IN ( $hid_list ) ";
        $query .= " AND T1.status = 0 ORDER BY T2.l_name ASC LIMIT $offset, $rowsPerPage";
        break;
    case 2:
        $query = "SELECT T1.pid, T1.name, T2.ctr_image_id, T3.description, '', 'Description' FROM gen_profile_info T1," .
            " ctr_gen_info T2, ctr_info T3 WHERE T1.pid = T2.pid AND type_id=" . real_mysql_specialchars($view, true) .
            " AND T1.status = 0 AND T1.pid = T3.pid ORDER BY name ASC LIMIT $offset, $rowsPerPage";
        break;
    case 3:
        /* view==3 & type==1 -------> Patents
          view==3 & type==2 -------> Patents in Application
          view==3  --------------> all Technology Patents */
        if ($view == 3 & $type == 1) {
            $querynumrows = "SELECT DISTINCT T1.pid, T1.name, T1.image_id, T1.keywords, '', 'Keywords' FROM tech_gen_info T1 ,tech_abstract T2, gen_profile_info T3 WHERE T1.pid = T2.pid and T3.pid=T1.pid  AND T3.type_id=3 and T3.status=1";

            $resultnumrows = real_execute_query($querynumrows, $db_conn);
            $numrows = mysql_num_rows($resultnumrows);
            $maxPage = ceil($numrows / $rowsPerPage);

            $query = "SELECT DISTINCT T1.pid, T1.name, T1.image_id, T1.keywords, '', 'Keywords' FROM tech_gen_info T1 ,tech_status T2 , gen_profile_info T3  WHERE T1.pid = T2.pid  AND T2.type =1 AND T3.pid=T1.pid and T3.status=1 ORDER BY name ASC LIMIT $offset, $rowsPerPage";
        }else if ($view == 3 & $type == 2) {
            $querynumrows = "SELECT DISTINCT T1.pid, T1.name, T1.image_id, T1.keywords, '', 'Keywords' FROM tech_gen_info T1 ,tech_status T2 , gen_profile_info T3	WHERE T3.pid=T1.pid and T3.status=1 and T1.pid = T2.pid  AND T2.type = 2";

            $resultnumrows = real_execute_query($querynumrows, $db_conn);
            $numrows = mysql_num_rows($resultnumrows);
            $maxPage = ceil($numrows / $rowsPerPage);

            $query = "SELECT DISTINCT T1.pid, T1.name, T1.image_id, T1.keywords, '', 'Keywords' FROM tech_gen_info T1 ,tech_status T2, gen_profile_info T3 WHERE T3.pid=T1.pid and T3.status=1 and T1.pid = T2.pid  AND T2.type = 2 ORDER BY name ASC LIMIT $offset, $rowsPerPage";
        }else {
            $query = "SELECT T1.pid, T1.name, T2.image_id, T2.keywords, '', 'Keywords' FROM gen_profile_info T1," .
                " tech_gen_info T2 WHERE T1.pid = T2.pid AND T1.type_id=" . real_mysql_specialchars($view, true) .
                " AND T1.status = 1 ORDER BY name ASC LIMIT $offset, $rowsPerPage";
        }

        break;
    case 4:
        $query = "SELECT T1.pid, T1.name, T2.fac_image_id,
						CONCAT( SUBSTRING( T3.description, 1, 100 ) , '...' ),
						CONCAT( address_1 ,
								IF( address_2 <>'', ', ', '' ) ,
								address_2 ,
								IF( city <>'', ', ', '' ) ,
								city ,
								IF( state <>'', ', ', '' )  ,
								state ,
								IF( zipcode <> '', ' - ', '' )  ,
								zipcode ,
								IF( country<>'', ', ', '' )  ,
								country ,
								IF( mailbox <> '', ', Mail Box: ', '' ) ,
								mailbox  ),
						'Description'
						FROM gen_profile_info T1, fac_gen_info T2, fac_info T3
						WHERE T1.pid = T2.pid AND T1.pid = T3.pid AND type_id=" . real_mysql_specialchars($view, true) .
            " AND T1.status = 0 ORDER BY name ASC LIMIT $offset, $rowsPerPage";
        break;
    case 5:

        $querynumrows = "(select T1.pid,T1.name,T1.image_id from eqp_info T1, gen_profile_info T2 where T1.pid = T2.pid AND status = 0) UNION
						(select pid,name,image_id from ctr_equipment where status=0) UNION
						(select pid,name,image_id from fac_equipment where status=0)";

        $resultnumrows = real_execute_query($querynumrows, $db_conn);
        $numrows = mysql_num_rows($resultnumrows);
        $maxPage = ceil($numrows / $rowsPerPage);

        $query = "(select T1.pid,T1.name,T1.image_id, T1.description, '', 'Description' from eqp_info T1, gen_profile_info T2 where T1.pid = T2.pid AND status = 0) UNION
						(select pid,name,image_id,description,'','Description' from ctr_equipment where status=0) UNION
						(select pid,name,image_id,description,'','Description' from fac_equipment where status=0) order by name asc LIMIT $offset, $rowsPerPage";
        $jumpto = 6;
        break;
    case 6:
        $query = "SELECT DISTINCT T1.pid, T1.name, T2.ctr_image_id,
         			 	CONCAT( SUBSTRING( T3.description, 1, 100 ) , '...' ),
						CONCAT( address_1 ,
								IF( address_2 <>'', ', ', '' ) ,
								address_2 ,
								IF( city <>'', ', ', '' ) ,
								city ,
								IF( state <>'', ', ', '' )  ,
								state ,
								IF( zipcode <> '', ' - ', '' )  ,
								zipcode ,
								IF( country<>'', ', ', '' )  ,
								country ,
								IF( mailbox <> '', ', Mail Box: ', '' ) ,
								mailbox  ),
						'Description'
						 FROM gen_profile_info T1,ctr_gen_info T2, ctr_info T3
					     where T1.pid = T2.pid AND T1.pid = T3.pid AND type_id =" . real_mysql_specialchars($view, true) .
            " AND T1.status = 0 ORDER BY name ASC LIMIT $offset, $rowsPerPage";
        break;
}
//executing the query by using the real_execute_query function in 'utils.php'.
$result = real_execute_query($query, $db_conn);
?>
<style media="screen" type="text/css">
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
    function filterbydept()
    {
        hid = document.filterbydeptform.dept.value;
        view = document.filterbydeptform.view.value;
        window.location = "browseprofiles.php?view=" + view + "&hid=" + hid;
    }
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <?php
            print( "<table width='100%' border='0' cellspacing='0' cellpadding='0'> ");
            print( "<tr >");
            switch ($view) {
                case 1: //specifiying tab actions
                    print( "<td style='background:url(images/tabblue.gif0);' width='111' height='33' valign='bottom' align='center'><span class='tab_menu'>Faculty</span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=2' style='text-decoration:none'>Centers</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=3' style='text-decoration:none'>Technologies</a></span></td>");
                      print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=5' style='text-decoration:none'>Equipment</a></span></td>");
                     /* print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=4' style='text-decoration:none'>Facilities</a></span></td>");
                      print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=6' style='text-decoration:none'>Labs &amp; Groups</a></span></td>");
                      */
                    $topage = 'editprofile.php';
                    break;
                case 2:
                    print( "<td style='background:url(images/tabsilver.gif0);' height='33' width='111' valign='bottom' align='center'><span class='tab_menu'><a href='browseprofiles.php?view=1' style='text-decoration:none'>Faculty</a></span></td>");
                    print( "<td style='background:url(images/tabblue.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'>Centers</span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=3' style='text-decoration:none'>Technologies</a></span></td>");
                   // print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=4' style='text-decoration:none'>Facilities</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=5' style='text-decoration:none'>Equipment</a></span></td>");
                  //  print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=6' style='text-decoration:none'>Labs &amp; Groups</a></span></td>");
                    $topage = 'editprofile.php';
                    break;
                case 3:
                    print( "<td style='background:url(images/tabsilver.gif0);' height='33' width='111' valign='bottom' align='center'><span class='tab_menu'><a href='browseprofiles.php?view=1' style='text-decoration:none'>Faculty</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=2' style='text-decoration:none'>Centers</a></span></td>");
                    print( "<td style='background:url(images/tabblue.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'>Technologies</span></td>");
                    //print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=4' style='text-decoration:none'>Facilities</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=5' style='text-decoration:none'>Equipment</a></span></td>");
                    //print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=6' style='text-decoration:none'>Labs &amp; Groups</a></span></td>");
                    $topage = 'editprofile.php';
                    break;
                case 4:
                    print( "<td style='background:url(images/tabsilver.gif0);' height='33' width='111' valign='bottom' align='center'><span class='tab_menu'><a href='browseprofiles.php?view=1' style='text-decoration:none'>Faculty</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=2' style='text-decoration:none'>Centers</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=3' style='text-decoration:none'>Technologies</a></span></td>");
                   // print( "<td style='background:url(images/tabblue.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'>Facilities</span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=5' style='text-decoration:none'>Equipment</a></span></td>");
                  //  print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=6' style='text-decoration:none'>Labs &amp; Groups</a></span></td>");
                    $topage = 'editprofile.php';
                    break;
                case 5:
                    print( "<td style='background:url(images/tabsilver.gif0);' height='33' width='111' valign='bottom' align='center'><span class='tab_menu'><a href='browseprofiles.php?view=1' style='text-decoration:none'>Faculty</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=2' style='text-decoration:none'>Centers</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=3' style='text-decoration:none'>Technologies</a></span></td>");
                   // print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=4' style='text-decoration:none'>Facilities</a></span></td>");
                    print( "<td style='background:url(images/tabblue.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'>Equipment</span></td>");
                   // print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=6' style='text-decoration:none'>Labs &amp; Groups</a></span></td>");
                    $topage = 'editprofile.php';
                    break;
                case 6:
                    print( "<td style='background:url(images/tabsilver.gif0);' height='33' width='111' valign='bottom' align='center'><span class='tab_menu'><a href='browseprofiles.php?view=1' style='text-decoration:none'>Faculty</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=2' style='text-decoration:none'>Centers</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=3' style='text-decoration:none'>Technologies</a></span></td>");
                   // print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=4' style='text-decoration:none'>Facilities</a></span></td>");
                    print( "<td style='background:url(images/tabsilver.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'><a href='browseprofiles.php?view=5' style='text-decoration:none'>Equipment</a></span></td>");
                   // print( "<td style='background:url(images/tabblue.gif0);' width='111' valign='bottom' align='center' ><span class='tab_menu'>Labs &amp; Groups</span></td>");
                    $topage = 'editprofile.php';
                    break;
            }
            print( "<td>&nbsp;</td>");
            print( "</tr>");
            print( "<tr>");
            //print( "<td colspan='8' height='5' bgcolor='#8DB0D3'> </td>");
            print( "<td colspan='8' height='5' bgcolor='#580000'> </td>");
            print( "</tr>");
            print( "<tr>");
            print( "<td colspan='6' height='5' > </td>");
            print( "</tr>");
            /*
              if($view==4)
              {
              print( "<tr>" );
              print( "<td colspan='5'>&nbsp;</td>" );
              print( "</tr>" );
              print( "<tr>" );
              print( "<td colspan='5'>No Profiles for Facilities are available at the moment</td>" );
              print( "</tr>" );
              print( "</table>" );
              exit();
              }
             */
            print( "</table>");
            ?>

            <?php
            //Printing the results based on the above queries
            print "<table width='100%'  border='0' cellspacing='0' cellpadding='2'>";
            print "<tr>" .
                "<td colspan='2'>&nbsp;</td>" .
                "</tr>";
            //Printing List Department List & view==1 query results. i.e.faculty profiles
            if ($view == 1) {
                print( "<form name='filterbydeptform' id ='filterbydeptform' >");
                print( "<input type='hidden' name='view' id='view' value='$view' />");
                print "<tr>" .
                    "<td colspan='2' id='secdetail'>View By Academic Department:&nbsp;<label for='deptsearch'><select id='deptsearch' name='dept' class='form_elements'>";
                print "\n<option value=''>All Departments</option>";
                while ($rowdept = mysql_fetch_array($resultdept)) {
                    if ($hid == $rowdept["hid"]) $selected = "selected";
                    else $selected = "";
                    if ($rowdept["h1"] != 0 && $rowdept["h2"] == 0) print "\n<option value='" . $rowdept["hid"] . "' $selected>" . $rowdept["name"] . "</option>";
                    else {
                        if ($rowdept["h1"] != '0' && $rowdept["h2"] != '0' && $rowdept["h3"] == '0') print "\n<option value='" . $rowdept["hid"] . "' $selected>----" . $rowdept["name"] . "</option>";
                    }//end else
                }//end while
                print "</select>&nbsp;&nbsp;</label>\n<input name='go' id='go' type='button' value='Go' onclick='FindProfiles()' /></td></tr>";
                print "\n<tr><td colspan='2' id='secdetail'>View By Name: &nbsp; &nbsp; &nbsp; &nbsp;<label for='bpLName'> LastName: <input type='text' id='bpLName' name='bpLName' onkeyup='FindProfiles()' /></label> \n" .
                    "\n &nbsp;<label for='bpFName'> FirstName: <input type='text' id='bpFName' name='bpFName' onkeyup='FindProfiles()' /></label> \n" .
                    "\n<div id='bpResultsRow'></div></td></tr>\n";

                print( "</table></form>");
            }


            if ($view == 3) {
                print("<br>");
                print("<font size='2px'; weight='bold'>");
                print("View Technologies by Type:&nbsp;&nbsp; ");
                if ($type != 1) print("<a href='browseprofiles.php?view=3&amp;type=1'>Patents</a>");
                else print "Patents";
                print("&nbsp; |&nbsp; ");
                if ($type != 2) print("<a href='browseprofiles.php?view=3&amp;type=2'>Patents in Application</a>");
                else print "Patents in Application";
                print("&nbsp; |&nbsp; ");
//		  print("  <img src='images/bullets/blue.png' /> ");
                if ($type != "") print("<a href='browseprofiles.php?view=3'>Browse All</a>");
                else print "Browse All";
                print("</font>");
                print("<br>");
            }

            print "<table width='100%'  border='0' cellspacing='0' cellpadding='2' id='actualTable'><tr><td>";
            $altrow = 1;
            while ($row = mysql_fetch_array($result)) {
                if ($altrow == 1) $class = 'table_background_other';
                else $class='table_background_viewedit';
                print "\n<tr>";
                print "<td width='48' height='48' valign='middle' align='center' rowspan='2' class='" . $class . "' style='border:1px solid white'>";
                if ($row[2] != 0) if ($view == 5) print "<a href='" . $topage . "?pid=" . $row[0] . "&amp;onlyview=1#" . $jumpto . "'><img src='images/48/" . $row[0] . "_6_" . $row[2] . ".jpg' alt='' border='0'></a>";
                    else print "<a href='" . $topage . "?pid=" . $row[0] . "&amp;onlyview=1'><img src='images/48/" . $row[0] . "_0_" . $row[2] . ".jpg' alt='' border='0'></a>";
                print "</td>";
                print "<td width='95%' class='" . $class . "' style='border-top:1px solid white;border-left:1px solid white;border-right:1px solid white'><span class='font_topic'>";
                if ($view == 5) print "<a href='" . $topage . "?pid=" . $row[0] . "&amp;onlyview=1#" . $jumpto . "'>" . htmlspecialchars($row[1]) . "</a>";
                else print "<a href='" . $topage . "?pid=" . $row[0] . "&amp;onlyview=1'>" . htmlspecialchars($row[1]) . "</a>";
                print "</span></td>";
                print "</tr>";
                print "<tr>";
                print "<td id='secdetail' class='" . $class . "' style='border-bottom:1px solid white;border-left:1px solid white;border-right:1px solid white'>";
                if ($row[4] != "") print( "<B>" . htmlspecialchars($row[4]) . "</B><BR>");
                if ($row[3] != "") print( htmlspecialchars($row[5]) . ":&nbsp;" . htmlspecialchars($row[3]));
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
            print "<td colspan='2' align='center' class='pageheading'>";
            $self = $_SERVER['PHP_SELF']; //right now not using it anywhere in the code
            $nav = '';
            for ($page = 1; $page <= $maxPage; $page++) {
                if ($page == $pageNum) {
                    $nav .= " $page "; // no need to create a link to current page
                }else {
                    $nav .= "<a href=\"browseprofiles.php?view=$view&amp;page=$page&amp;hid=$hid&amp;type=$type\">$page</a> ";
                }
            }
//			 $nav.= "<a href=\"browseprofiles.php?view=$view&page=2&hid=$hid&type=$type\">2</a>";
            // creating previous and next link
            // plus the link to go straight to
            // the first and last page

            if ($pageNum > 1) {
                $page = $pageNum - 1;
                $prev = " <a href=\"browseprofiles.php?view=$view&amp;page=$page&amp;hid=$hid&amp;type=$type\">[Prev]</a> ";

                $first = " <a href=\"browseprofiles.php?view=$view&amp;page=1&amp;hid=$hid&amp;type=$type\">[First Page]</a> ";
            }else {
                $prev = '&nbsp;'; // we're on page one, don't print previous link
                $first = '&nbsp;'; // nor the first page link
            }

            if ($pageNum < $maxPage) {
                $page = $pageNum + 1;
                $next = " <a href=\"browseprofiles.php?view=$view&amp;page=$page&amp;hid=$hid&amp;type=$type\">[Next]</a> ";

                $last = " <a href=\"browseprofiles.php?view=$view&page=$maxPage&hid=$hid&type=$type\">[Last Page]</a> ";
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
</html>
