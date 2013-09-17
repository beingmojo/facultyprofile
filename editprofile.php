<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
if ($_SESSION["UID"] != "") {
    real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
    rps_check_has_info($_SESSION['UID'], $db_conn);
}

if(!isset($_GET['pt'])){    //if it is not comming from keyword highlight container
    $_POST['page-title'] = "Edit Profile";
    $_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
    $_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
    $_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
    $_POST['page-link4'] = "<link rel='icon' href='favicon.ico' type='image/ico' />";
    $_POST['page-script1'] = "<script language='JavaScript' type='text/javascript' src='rteresources/html2xhtml.js'></script>";
    $_POST['page-script2'] = "<script language='JavaScript' type='text/javascript' src='rteresources/richtext.js'></script>";
    $_POST['page-script3'] = "<script language='JavaScript' type='text/javascript' src='scripts/section_and_menu.js'></script>";
    $_POST['page-script4'] = "<script language='JavaScript' type='text/javascript' src='scripts/findprofile.js'></script>";

    $_POST['page-include-page-top2'] = "true";
    include_once 'includes/page-top.php';
    include_once 'includes/page-top2.php';
}

$pid = $_GET["pid"];
$view = 0;
// set what view we are in
/* view == 1 ----> Query for Faculty profiles.
  view == 2 ----> Query for Center profiles.
  view == 3 ----> Query for Technology profiles.
  view == 4 ----> Query for Facility profiles.
  view == 5 ----> Query for Equipment profiles.
  view == 6 ----> Query for Labs & Groups profiles. */
if ($_GET["view"] == 1 || $_GET["view"] == 2 || $_GET["view"] == 3 || $_GET["view"] == 4) {
    $view = $_GET["view"];
}
if ($_GET["onlyview"] != "") {
    $onlyview = "1";
}
// some page variables
$user_has_edit_rights = false;
$editable = false;
$type_id = 0;
$profile_name = "";
$last_modified_time = "";
// check if the user is an admin
$is_admin = real_check_user_groupid($db_conn, "admin");
// check if the user is a tech admin
$is_tech_admin = real_check_user_groupid($db_conn, "tech_admin");
// if we dont have the PID, then get it from the database by using the login_id
if ($pid == "") {
    $profile_login_id = $_GET["loginid"];
    if ($profile_login_id != "") {
        $pid_query = "SELECT pid FROM ppl_general_info WHERE login_id = " . real_mysql_specialchars($profile_login_id, false);
        $pid_results = real_execute_query($pid_query, $db_conn);
        if (mysql_num_rows($pid_results) > 0) {
            $pid_row = mysql_fetch_array($pid_results);
            $pid = $pid_row[0];
        }
    }
}
// if we have the PID ready now, then continue
if ($pid != "") {
    // check if the user has editing rights
    if (real_can_user_edit($db_conn, $pid) == true) {
        $user_has_edit_rights = true;
        $editable = true;
    }
    $profile_exists_query = "SELECT type_id, name,DATE_FORMAT( if( owner_datetime > user1_datetime,  owner_datetime," .
        " if( user1_datetime > user2_datetime, user1_datetime, if( user2_datetime > admin_datetime," .
        " user2_datetime, admin_datetime ))), ' %r %a, %e %b %Y') as last_modified_time" .
        " FROM gen_profile_info WHERE pid = " . real_mysql_specialchars($pid, true);
    $profile_exists_results = real_execute_query($profile_exists_query, $db_conn);
    // check if the profile exists
    if (mysql_num_rows($profile_exists_results) > 0) {
        $rows = mysql_fetch_row($profile_exists_results);
        // get the profile type, name and last modified time
        $type_id = $rows[0];
        $profile_name = $rows[1];
        $last_modified_time = $rows[2];
    }else {
        // display error because the profile doesnt exist
        real_set_error($_err_page_not_found);
        real_redirect_onerror($_err_page, "", $db_conn);
    }
    // if we are in the view state then set the editable flag to false.
    if ($_GET["onlyview"] != "") {
        $editable = false;
    }
    if ($view == 0) {
        $current_sections_query = "SELECT DISTINCT T1.section_id, T1.name , T1.table_name , T1.order_no
				FROM gen_section_types T1, gen_profile_info T2, gen_profile_section T3 
				WHERE T1.type_id = T2.type_id AND T3.pid = T2.pid AND T3.section_id = T1.section_id 
				AND T3.status = 0
				AND T2.pid = " . real_mysql_specialchars($pid, true) .
            " UNION
				SELECT DISTINCT T1.section_id, T1.name , ''  AS table_name, T1.order_no + T1.section_id
				FROM gen_profile_section_additional T1 
				WHERE T1.pid = " . real_mysql_specialchars($pid, true) .
            " AND T1.status = 0 ORDER BY order_no ASC";
    }else {
        $current_sections_query = "SELECT DISTINCT T1.section_id, T1.name , T1.table_name , T1.order_no
				FROM gen_section_types T1, gen_profile_info T2, gen_profile_section T3, gen_view_section T4 
				WHERE T1.type_id = T2.type_id 
				AND T3.section_id = T1.section_id 
				AND T3.pid = T2.pid 
				AND T3.section_id = T4.section_id 
				AND T3.status = 0
				AND T2.pid = " . real_mysql_specialchars($pid, true) .
            " AND T4.view_id = " . real_mysql_specialchars($view, true) .
            " UNION
				SELECT DISTINCT T1.section_id, T1.name , '' AS table_name, T1.order_no + T1.section_id
				FROM gen_profile_section_additional T1 
				WHERE T1.pid = " . real_mysql_specialchars($pid, true) .
            " AND T1.view_id = " . real_mysql_specialchars($view, true) .
            " AND T1.status = 0 ORDER BY order_no ASC";
    }
    $current_sections_results = real_execute_query($current_sections_query, $db_conn);
    $future_sections_query = "SELECT T1.section_id, T1.name from (gen_section_types T1, gen_profile_info T2)
	LEFT JOIN gen_profile_section  T3 on T1.section_id = T3.section_id AND T3.pid = " .
        real_mysql_specialchars($pid, true) .
        " WHERE T3.section_id is NULL AND T1.type_id = T2.type_id AND T2.pid = " .
        real_mysql_specialchars($pid, true) .
        " ORDER BY T1.order_no ASC";
    $future_sections_results = real_execute_query($future_sections_query, $db_conn);

    // include the section according to type of the profile
    if ($type_id == 1) {
        $type_image_path = "images\bullets\faculty.gif";
        $type_image_alt = 'Faculty Profile';
        include "sections/ppl_general_info_query.php";
    }
    if ($type_id == 2) {
        $type_image_path = "images\bullets\center.gif";
        $type_image_alt = 'Research Center Profile';
        include "sections/ctr_about_query.php";
    }
    if ($type_id == 6) {
        $type_image_path = "images\bullets\labgroup.gif";
        $type_image_alt = 'Lab or Group Profile';
        include "sections/ctr_about_query.php";
    }
    if ($type_id == 3) {
        $type_image_path = "images/bullets/technology.gif";
        $type_image_alt = 'Technology/Intellectual Property Profile';
        include "sections/tech_general_info_query.php";
    }
   if ($type_id == 4) {
        $type_image_path = "images\bullets\facility.gif";
        $type_image_alt = 'Facility Profile';
        include "sections/fac_about_query.php";
    }
    if ($type_id == 5) {
        $type_image_path = "images\bullets\equipment.gif";
        $type_image_alt = 'Equipment Profile';
        include "sections/eqp_general_info_query.php";
    }
    if (mysql_num_rows($current_sections_results) > 0) {
        mysql_data_seek($current_sections_results, 0);
        while ($current_sections_row = mysql_fetch_row($current_sections_results)) {
            if ($current_sections_row[2] != "") {
                include "sections/" . $current_sections_row[2] . "_query.php";
            }else {
                include "sections/all_additional_section_query.php";
            }
        }
    }
}else {
    real_set_error($_err_page_not_found);
    real_redirect_onerror($_err_page, "", $db_conn);
}
?>

<?php
print( "<META name='keywords' content='" . htmlspecialchars($gen_keywords_rows[0], ENT_QUOTES) . "'>\r\n");
print( "<title>" . htmlspecialchars($profile_name) . "&nbsp;&nbsp;(" . htmlspecialchars($type_image_alt) . ")</title>\r\n");
?>

<script type="text/javascript">
    <!--
    startList = function() {
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
    initRTE("rteresources/", "rteresources/", "", true);
    -->
</script>

</head>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <?php
            print( "<table width='100%' border='0' cellspacing='0' cellpadding='0'> ");

            if ($user_has_edit_rights == true) {
                print( "<tr >");
                if ($editable == true) {
                    // if user has rights and editable then highlight the Edit tab
                    print( "<td style=\"color: #111111; font-size: 14px; font-weight: bold\" height='33' height='12' width='111' valign='bottom' align='center'>Edit</td>");
                    print( "<td style=\"color: #eeeeee; font-size: 14px;\" height='12' width='111' valign='bottom' align='center'><a href='editprofile.php?pid=$pid&onlyview=1&view=$view' style='text-decoration:none'>View</a></td>");
                }else {
                    // if user has rights and editable is false then highlight the View tab
                    print( "<td style=\"color: #eeeeee; font-size: 14px;\" height='12' width='111' valign='bottom' align='center' ><a href='editprofile.php?pid=$pid' style='text-decoration:none'>Edit</a></td>");
                    print( "<td style=\"color: #111111; font-size: 14px; font-weight: bold\" height='12' width='111' valign='bottom' align='center'>View</td>");
                }
                // create the other Toobox tab
                print( "<td style=\"color: #555555; font-size: 14px; font-weight: bold\" height='12' width='111' valign='bottom' align='center' ><a href='customize_profile.php?pid=$pid' style='text-decoration:none'>Toolbox</a></td>");
                print( "<td align='right'>Last Modified Time: $last_modified_time&nbsp;</td>");
                print( "</tr>");
                print( "<tr>");
                print( "<td colspan='6' height='5' bgcolor='#CDAF95' align='right'></td>");
                print( "</tr>");
            }else {
                print( "<tr>");
                print ("<td colspan='2' bgcolor='#CDAF95' alignt='left' valign='bottom'>" .
                    "<span class='form_elements_section_subheader'>&nbsp;&nbsp;" .
                    "<img src='" . $type_image_path . "' alt='" . $type_image_alt . "' width='12' height='12' />" .
                    "&nbsp;&nbsp;<strong>" . $type_image_alt . "</strong></span></td>");
                print( "<td colspan='4' bgcolor='#CDAF95' align='right'>Last Modified Time: $last_modified_time&nbsp; </td>");
                print( "</tr>");
            }
            print( "</table>");

// include the proper file according to the type of profile
            if ($type_id == 1) {
                include 'sections/ppl_general_info_display.php';
            }
            if ($type_id == 2 || $type_id == 6) {
                include 'sections/ctr_about_display.php';
            }
            if ($type_id == 3) {
                include 'sections/tech_general_info_display.php';
            }
            if ($type_id == 4) {
                include 'sections/fac_about_display.php';
            }
            if ($type_id == 5) {
                include 'sections/eqp_general_info_display.php';
            }
            ?>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <?php
                if ($_GET["onlyview"] != "") $onlyview = "&onlyview=1";
                else $onlyview = "";

                print( "<tr >");
                print( "<td colspan='2' valign='top'>");
                print( "<div id='navcontainer'>");
                print( "<ul id='navlist'>");
                print( "</div>");
                print( "</td>");
                print( "</tr>");

                print( "<tr >");
                print( "<td colspan='2' height='3'></td>");
                print( "</tr>");
                ?>
            </table>
            <!-- show the side bar which displays a shortcut to all the sections in the profile -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <div id='scrollmenuholder' style="z-index:90;position:relative" ></div>
                <tr>
                    <td width="172" valign="top" >
                        <div id='scrollmenu' style='position:absolute'>
                            <table width='172' valign="top" >
                                <tr>
                                    <td>

                                        <div id="sidenav">
                                            <ul id="sidenavlist">
                                                <?php
                                                if (mysql_num_rows($current_sections_results) > 0) {
                                                    mysql_data_seek($current_sections_results, 0);
                                                    while ($current_sections_row = mysql_fetch_row($current_sections_results)) {
                                                        if ($current_sections_row[2] != "") {
                                                            include "sections/" . $current_sections_row[2] . "_display_menu.php";
                                                        }else {
                                                            include "sections/all_additional_section_display_menu.php";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td valign='top'>
                        <?php
                                                if (mysql_num_rows($current_sections_results) > 0) {
                                                    mysql_data_seek($current_sections_results, 0);
                                                    while ($current_sections_row = mysql_fetch_row($current_sections_results)) {
                                                        print "<a name='" . $current_sections_row[0] . "'></a>";
                                                        if ($current_sections_row[2] != "") {
                                                            include "sections/" . $current_sections_row[2] . "_display.php";
                                                        }else {
                                                            include "sections/all_additional_section_display.php";
                                                        }
                                                    }
                                                }
                        ?>
                    </td>

                </tr>
            </table>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><!-- Page footer -->
        <td colspan="2" align="center">
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