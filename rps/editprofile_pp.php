<?php  
//� 2006 The University of Texas at Arlington 
//Page created by: Kumaravel Senthivel
//Edited by : Farhan
//Edited Dates  : 21th April 2006
//Change made : commenting
//Edited by : Rajat Mittal
//Edited Date : June 09, 2006
//Change made : DC Core Meta Tags added.
//Edited by : Jonathan Baltazar
//Edited Date : October 06, 2006
//Change made : Javascript text highlighting for search

// include the utils.php which has ldap and database helper functions
include 'utils.php';
// start the session
session_start();
//making a connection to database. for more information about (real_db_connect) function see 'utils.php'
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
// check the session variable
if( $_SESSION["UID"] != "" )
    real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
$pid = $_GET["pid"];
$view = 0;
// set what view we are in
/* view == 1 ----> Query for Faculty profiles.
   view == 2 ----> Query for Center profiles.
   view == 3 ----> Query for Technology profiles.
   view == 4 ----> Query for Facility profiles.
   view == 5 ----> Query for Equipment profiles.
   view == 6 ----> Query for Labs & Groups profiles.
*/
if( $_GET["view"] == 1 || $_GET["view"] == 2 || $_GET["view"] == 3 || $_GET["view"] == 4 )
    $view = $_GET["view"];
if( $_GET["onlyview"] != "" )
    $onlyview = "1";

// some page variables
$user_has_edit_rights = false;
$editable=false;
$type_id = 0;
$profile_name = "";
$last_modified_time = "";
// check if the user is an admin
$is_admin = real_check_user_groupid( $db_conn, "admin" );
// check if the user is a tech admin
$is_tech_admin = real_check_user_groupid( $db_conn, "tech_admin" );

// if we dont have the PID, then get it from the database by using the login_id
if( $pid == "" ) {
    $profile_login_id = $_GET["loginid"];
    if( $profile_login_id != "" ) {
        $pid_query = "SELECT pid FROM ppl_general_info WHERE login_id = " . real_mysql_specialchars( $profile_login_id, false );
        $pid_results = 	real_execute_query ( $pid_query, $db_conn );
        if( mysql_num_rows($pid_results) > 0 ) {
            $pid_row = mysql_fetch_array( $pid_results );
            $pid = $pid_row[0];
        }
    }
}
// if we have the PID ready now, then continue
if( $pid != "" ) {
    // check if the user has editing rights
    if( real_can_user_edit( $db_conn, $pid ) == true ) {
        $user_has_edit_rights = true;
        $editable = true;
    }
    $profile_exists_query = "SELECT type_id, name,
							DATE_FORMAT( if( owner_datetime > user1_datetime,  owner_datetime, if( user1_datetime > user2_datetime, user1_datetime, if( user2_datetime > admin_datetime, user2_datetime, admin_datetime ))), ' %r %a, %e %b %Y') as last_modified_time
							FROM gen_profile_info WHERE pid = " . real_mysql_specialchars( $pid, true );
    $profile_exists_results = real_execute_query ( $profile_exists_query, $db_conn );
    // check if the profile exists
    if( mysql_num_rows($profile_exists_results) > 0 ) {
        $rows = mysql_fetch_row( $profile_exists_results );
        // get the profile type, name and last modified time
        $type_id = $rows[0];
        $profile_name = $rows[1];
        $last_modified_time = $rows[2];
    }
    else {
        // display error because the profile doesnt exist
        real_set_error( $_err_page_not_found );
        real_redirect_onerror( $_err_page, "", $db_conn );
    }
    // if we are in the view state then set the editable flag to false.
    if( $_GET["onlyview"] != "" )
        $editable = false;
    if( $view == 0 ) {
        $current_sections_query = "SELECT DISTINCT T1.section_id, T1.name , T1.table_name , T1.order_no
				FROM gen_section_types_copy T1, gen_profile_info T2, gen_profile_section T3 
				WHERE T1.type_id = T2.type_id AND T3.pid = T2.pid AND T3.section_id = T1.section_id 
				AND T3.status = 0
				AND T2.pid = " . real_mysql_specialchars( $pid, true ) . 
                " UNION
				SELECT DISTINCT T1.section_id, T1.name , ''  AS table_name, T1.order_no + T1.section_id
				FROM gen_profile_section_additional T1 
				WHERE T1.pid = " . real_mysql_specialchars( $pid, true ) . 
                " AND T1.status = 0 ORDER BY order_no ASC";
    }
    else {
        $current_sections_query = "SELECT DISTINCT T1.section_id, T1.name , T1.table_name , T1.order_no
				FROM gen_section_types_copy T1, gen_profile_info T2, gen_profile_section T3, gen_view_section T4 
				WHERE T1.type_id = T2.type_id 
				AND T3.section_id = T1.section_id 
				AND T3.pid = T2.pid 
				AND T3.section_id = T4.section_id 
				AND T3.status = 0
				AND T2.pid = " . real_mysql_specialchars( $pid, true ). 
                " AND T4.view_id = " . real_mysql_specialchars( $view, true ).
                " UNION
				SELECT DISTINCT T1.section_id, T1.name , '' AS table_name, T1.order_no + T1.section_id
				FROM gen_profile_section_additional T1 
				WHERE T1.pid = " . real_mysql_specialchars( $pid, true ) . 
                " AND T1.view_id = " . real_mysql_specialchars( $view, true ).
                " AND T1.status = 0 ORDER BY order_no ASC";
    }
    $current_sections_results = real_execute_query( $current_sections_query, $db_conn );
    $future_sections_query = "SELECT T1.section_id, T1.name from (gen_section_types_copy T1, gen_profile_info T2)
				LEFT JOIN gen_profile_section  T3 on T1.section_id = T3.section_id AND T3.pid = ".
            real_mysql_specialchars( $pid, true ) .
            " WHERE T3.section_id is NULL AND T1.type_id = T2.type_id AND T2.pid = " .
            real_mysql_specialchars( $pid, true ) .
            " ORDER BY T1.order_no ASC";
    $future_sections_results = real_execute_query( $future_sections_query, $db_conn );

    // include the section according to type of the profile
    if( $type_id == 1 ) {
        $type_image_path="images\bullets\faculty.gif";
        $type_image_alt='Faculty Profile';
        include "sections/ppl_general_info_query.php";
    }
    if( $type_id == 2 ) {
        $type_image_path="images\bullets\center.gif";
        $type_image_alt='Research Center Profile';
        include "sections/ctr_about_query.php";
    }
    if( $type_id == 6) {
        $type_image_path="images\bullets\labgroup.gif";
        $type_image_alt='Lab or Group Profile';
        include "sections/ctr_about_query.php";
    }
    if( $type_id == 3 ) {
        $type_image_path="images/bullets/technology.gif";
        $type_image_alt='Technology/Intellectual Property Profile';
        include "sections/tech_general_info_query.php";
    }
    if( $type_id == 4 ) {
        $type_image_path="images\bullets\facility.gif";
        $type_image_alt='Facility Profile';
        include "sections/fac_about_query.php";
    }
    if( $type_id == 5 ) {
        $type_image_path="images\bullets\equipment.gif";
        $type_image_alt='Equipment Profile';
        include "sections/eqp_general_info_query.php";
    }

    if( mysql_num_rows($current_sections_results) > 0 ) {
        mysql_data_seek( $current_sections_results, 0 );
        while( $current_sections_row = mysql_fetch_row( $current_sections_results ) ) {
            if( $current_sections_row[2] != "" ) {
                //changes made for adding paging to presentation and project section
                if( $current_sections_row[2] == "ppl_presentation_project" )
                    include "sections/" . $current_sections_row[2] . "_copy_query.php";
                //end of changes
                //changes made for addition of new fields and format to publications section
                elseif( $current_sections_row[2] == "ppl_publication" )
                    include "sections/" . $current_sections_row[2] . "_copy_query.php";
                //end of changes
                else
                    include "sections/" . $current_sections_row[2] . "_query.php";
            }
            else {
                include "sections/all_additional_section_query.php";
            }
        }
    }
}
else {
    real_set_error( $_err_page_not_found );
    real_redirect_onerror( $_err_page, "", $db_conn );
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/level1_copy.dwt.php" codeOutsideHTMLIsLocked="false" -->
    <head>
        <title>Research Profile System - (Edit Profile) - Texas State University - San Marcos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <!-- InstanceBeginEditable name="title" -->
        <link rel="icon" href="favicon.ico" type="image/ico" />
        <!-- Meta Keywords Added by Rajat start here -->
        <meta http-equiv="expires" content="14 Feb 06" />
        <meta name="DC.Title" content="<?php print $type_image_alt." of ".$profile_name." at the University of Texas at Arlington";?>" />
        <meta name="DC.Identifier" content="http://www.uta.edu/expertise/" />
        <meta name="DC.Subject.Keyword" content="<?php print $profile_name.", ".$gen_keywords_rows[0];?>" />
        <meta name="DC.Description" content="<?php print $type_image_alt." of ".$profile_name." at the University of Texas at Arlington";?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="DC.Creator" content="UT Arlington" />
        <meta name="DC.Creator" content="Research at UT Arlington" />
        <meta name="DC.Creator" content="<?php print $profile_name; ?>" />
        <meta name="DC.Format.SysReq" content="Internet browser" />
        <meta name="DC.Subject" content="Research Profile" />
        <meta name="DC.Subject" content="Texas" />
        <meta name="DC.Subject" content="India" />
        <meta name="DC.Publisher" content="The University of Texas at Arlington." />
        <meta name="DC.Language" content="en" />
        <meta name="DC.Coverage" content=" Arlington, Texas, Dallas Forth Worth Metroplex" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="-1" />
        <!-- Meta Keywords added by Rajat End Here -->
<?php 
print( "<META name='keywords' content='$gen_keywords_rows[0]'>\r\n" ); 
print( "<title>$profile_name&nbsp;&nbsp;($type_image_alt)</title>\r\n" );
?>

        <!-- InstanceEndEditable -->
        <link href="styles/style1.css" rel="stylesheet" type="text/css">
            <link href="styles/list.css" rel="stylesheet" type="text/css">
                <!-- InstanceBeginEditable name="script" -->
                <script language="JavaScript" type="text/javascript" src="rteresources/html2xhtml.js"></script>
                <script language="JavaScript" type="text/javascript" src="rteresources/richtext.js"></script>
                <script language="JavaScript" type="text/javascript" src="scripts/section_and_menu.js"></script>
                <script language="JavaScript" type="text/javascript" src="scripts/findprofile.js"></script>
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
                    initRTE("rteresources/", "rteresources/", "", true);
                    //-->
                </script>
                <noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
<?php
//Include Text Highlight
if ($_GET['highlight'] && $_GET['onlyview'] == 1) {
    include 'include/highlight_text.php';
    echo "<script type=\"text/javascript\">";
    echo "function initPage() {highlightText();}";
    echo "</script>";
}
?>
                <!-- InstanceEndEditable -->
                <!-- InstanceBeginEditable name="head" -->
                <!-- InstanceEndEditable -->
                </head>
                <body onload="if(typeof initPage != 'undefined')initPage();">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
                        <tr>
                            <td height="3" colspan="2" class="table_background">
                                <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><div align="left"><img src="images/rspbanner.jpg" alt="Research Profile" width="751" height="95" align="left" /></div>
                                        </td>
                                        <td>
                                            <form action="searchresults.php" method="get" enctype="application/x-www-form-urlencoded">
                                                <input name="search" type="text" class="form_elements" id="search" size="15" />
                                                <input name="Submit" type="submit" class="form_elements_row_action" value="Quick Search" />
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width='30%' align="left" class="table_background_other"><!-- InstanceBeginEditable name="pagename" -->
                                <!--  print page heading accordingly View or Edit based on the flag that we set earlier -->
                                <div align="left" class="page_heading"><?php print( "&nbsp;" . ($editable==false?"View " : " Edit " ) . "Profile" ); ?></div>
                                <!-- InstanceEndEditable --></td>
                            <td valign="top" class="table_background_other" align='right'>
                                <div id="menu">
                                    <ul id="nav">
                                        <li>
<?php
print( "<a href='$_home/index.php'>Home</a>" );
if( $_SESSION["UID"] != "" ) {
    print( "<ul><li><a href='myprofiles.php'>My Profiles</a></li>");
    print( "<li><a href='logoff.php'>Logoff</a></li></ul>" );
}
?>
                                        </li>
                                        <li><a href="browseprofiles.php?view=1">Browse </a>
                                            <ul>
                                                <li><a href="browseprofiles.php?view=1">Faculty</a></li>
                                                <li><a href="browseprofiles.php?view=2">Center</a></li>
                                                <li><a href="browseprofiles.php?view=3">Technology</a></li>
                                                <li><a href="browseprofiles.php?view=4">Facility</a></li>
                                                <li><a href="browseprofiles.php?view=5">Equipment</a></li>
                                                <li><a href="browseprofiles.php?view=6">Labs & Groups</a></li>

                                            </ul>
                                        </li>
                                        <li><a href="newsearch.php">Search </a>
                                            <ul>
                                                <li><a href="newsearch.php">Basic</a></li>
                                                <li><a href="clustersearch.php">Texas Clusters</a></li>
                                                <li><a href="advsearch.php">Advanced</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="aboutrsp.php">Support</a>
                                            <ul>
                                                <li><a href="aboutrsp.php">About rSp</a></li>
                                                <li><a href="help/index.php">Help and FAQ's</a></li>
                                                <li><a href="feedback.php">Contact Us</a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <!-- content goes here -->
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <!-- InstanceBeginEditable name="content" -->
<?php
print( "<table width='100%' border='0' cellspacing='0' cellpadding='0'> " );

if( $user_has_edit_rights == true ) {
    print( "<tr >" );
    if( $editable == true ) {
        // if user has rights and editable then highlight the Edit tab
        print( "<td background='images/tabblu.gif' height='12' width='111' valign='bottom' align='center'><span class='tab_menu'>Edit</span></td>" );
        print( "<td background='images/tabsil.gif' height='12' width='111' valign='bottom' align='center'><a href='editprofile.php?pid=$pid&onlyview=1&view=$view' style='text-decoration:none'><span class='tab_menu'>View</span></a></td>" );
    }
    else {
        // if user has rights and editable is false then highlight the View tab
        print( "<td background='images/tabsil.gif' height='12' width='111' valign='bottom' align='center' ><a href='editprofile.php?pid=$pid' style='text-decoration:none'><span class='tab_menu'>Edit</span></a></td>" );
        print( "<td background='images/tabblu.gif' height='12' width='111' valign='bottom' align='center'><span class='tab_menu'>View</span></td>" );
    }
    // create the other Toobox tab
    print( "<td background='images/tabsil.gif' height='12' width='111' valign='bottom' align='center' ><a href='customize_profile.php?pid=$pid' style='text-decoration:none'><span class='tab_menu'>Toolbox</span></a></td>" );
    print( "<td align='right'>Last Modified Time: $last_modified_time&nbsp;</td>" );
    print( "</tr>" );
    print( "<tr>" );
                                    print( "<td colspan='6' height='5' bgcolor='#8DB0D3' align='right'></td>" );
                                    print( "</tr>" );
                                }
                                else {
                                    print( "<tr>" );
                                    print ("<td colspan='2' bgcolor='#8DB0D3' alignt='left' valign='bottom'>".
                                                    "<span class='form_elements_section_subheader'>&nbsp;&nbsp;".
                                                    "<img src='".$type_image_path."' alt='".$type_image_alt."' width='12' height='12' />".
                                                    "&nbsp;&nbsp;<strong>".$type_image_alt."</strong></span></td>");
                                    print( "<td colspan='4' bgcolor='#8DB0D3' align='right'>Last Modified Time: $last_modified_time&nbsp; </td>" );
                                    print( "</tr>" );
                                }
                                print( "</table>" );

                                // include the proper file according to the type of profile
                                if( $type_id == 1 ) {
                                    include 'sections/ppl_general_info_display.php';
                                }
                                if( $type_id == 2 || $type_id == 6) {
                                    include 'sections/ctr_about_display.php';
                                }
                                if( $type_id == 3 ) {
                                    include 'sections/tech_general_info_display.php';
                                }
                                if( $type_id == 4 ) {
                                    include 'sections/fac_about_display.php';
                                }
                                if( $type_id == 5 ) {
                                    include 'sections/eqp_general_info_display.php';
                                }
                                ?>
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <?php
                                if( $_GET["onlyview"] != "" )
                                    $onlyview = "&onlyview=1";
                                else
                                    $onlyview = "";

                                print( "<tr >" );
                                print( "<td colspan='2' valign='top'>" );
                                print( "<div id='navcontainer'>" );
                                print( "<ul id='navlist'>" );
                                /*			if($asprofiles == 0 )
			{
				print "<li><a href='editprofile.php?pid=".$pid."&asp=1".$onlyview."'>Associated Profiles</a></li>";
			}
			else
			{
				print "<li><a href='editprofile.php?pid=".$pid.$onlyview."'>" . ($onlyview==1?"View ":"Edit "). "Profile</a></li>";
			}
			print( "</ul>" );
                                */			print( "</div>" );
                                print( "</td>" );
                                print( "</tr>" );

                                print( "<tr >" );
                                print( "<td colspan='2' height='3'></td>" );
                                print( "</tr>" );

                                ?>
                                </table>
                                <!-- show the side bar which displays a shortcut to all the sections in the profile -->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <div id='scrollmenuholder' style="z-index:90;position:relative" >
                                    </div>

                                    <tr>
                                        <td width="172" class="table_background_other" valign="top" >
                                            <div id='scrollmenu' style='position:absolute'>
                                                <table width='172' class="table_background_other" valign="top" >
                                                    <tr>
                                                        <td>

                                                            <div id="sidenav">
                                                                <ul id="sidenavlist">
                                    <?php
                                    if( mysql_num_rows($current_sections_results) > 0 ) {
                                        mysql_data_seek( $current_sections_results, 0 );
                                        while( $current_sections_row = mysql_fetch_row( $current_sections_results ) ) {
                                            if( $current_sections_row[2] != "" ) {
                                                //changes made for adding paging to presentation and project section
                                                if( $current_sections_row[2] == "ppl_presentation_project" )
                                                    include "sections/" . $current_sections_row[2] . "_copy_display_menu.php";
                                                //end of changes
                                                //changes made for addition of new fields and format to publications section
                                                elseif( $current_sections_row[2] == "ppl_publication" )
                                                    include "sections/" . $current_sections_row[2] . "_copy_display_menu.php";
                                                //end of changes
                                                else
                include "sections/" . $current_sections_row[2] . "_display_menu.php";
        }
        else {
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
                                                                    if( mysql_num_rows($current_sections_results) > 0 ) {
                                                                        mysql_data_seek( $current_sections_results, 0 );
                                                                        while( $current_sections_row = mysql_fetch_row( $current_sections_results ) ) {
                                                                            print "<a name='".$current_sections_row[0]."'></a>";
                                                                            if( $current_sections_row[2] != "" ) {
                                                                                //changes made for adding paging to presentation and project section
                                                                                if( $current_sections_row[2] == "ppl_presentation_project" )
                                                                                    include "sections/" . $current_sections_row[2] . "_copy_display.php";
                                                                                //end of changes
                                                                                //changes made for addition of new fields and format to publications section
                                                                                elseif( $current_sections_row[2] == "ppl_publication" )
                                                                                    include "sections/" . $current_sections_row[2] . "_copy_display.php";
                                                                                //end of changes
                                                                                else

                                                                                    include "sections/" . $current_sections_row[2] . "_display.php";
                                                                            }
                                                                            else {
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
                    </table>
                    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="table_background">&nbsp;</td>
                        </tr>
                        <!-- footer content goes here -->
                        <tr>
                            <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy; 2005<a href="http://www.uta.edu/" target="www.uta.edu">The University of Texas at Arlington</a> |
                                        Research Administration  | Questions or Comments about this site? Email: <a href="feedback.php">webmaster</a>  | Thursday , September 22, 2005<br />
                                    </font></div></td>
                            <!--end of footer -->
                        </tr>
                        <tr>
                            <td bgcolor="#D7CFCD" class="form_elements_row_action"> <div align="center"><span class="details">Important Disclaimer: </span>The responsibility for the accuracy of the information contained on these pages lies with the authors and user providing such information. </div></td>
                        </tr>
                    </table>
                </body>
                <!-- InstanceEnd --></html>