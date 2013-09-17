<?php
/*Error Reporting*/
/*error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);
*/
//Includes
session_start();
include_once 'urlLoad.php';
include_once 'utils.php';

//DB Connection
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
rps_check_has_info($_SESSION['UID'], $db_conn);
$is_admin = real_check_user_groupid( $db_conn, "admin" );

/*Styles and Javascript*/
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

//DBQuerys
$uid = $_SESSION['UID'];
$query1 = " SELECT pid, type_id, name, status FROM gen_profile_info WHERE owner_login_id = " . real_mysql_specialchars( $uid, false ). " ORDER BY type_id ASC";
$query2 = " SELECT T1.pid, T1.type_id, T1.name, status, T2.l_name, T2.f_name, T2.m_name FROM gen_profile_info T1, ppl_general_info  T2 WHERE T1.pid = T2.pid AND owner_login_id <> " . real_mysql_specialchars( $uid, false );
if( real_check_user_groupid( $db_conn, "admin" ) == false ) {
    $query2 .= " AND( user1_login_id = " . real_mysql_specialchars( $uid, false )." OR user2_login_id = " . real_mysql_specialchars ( $uid, false)." ) ";
}
$query2 .= " UNION SELECT T1.pid, T1.type_id, T1.name, status, T1.name as l_name, '' AS f_name, '' AS m_name FROM gen_profile_info T1 WHERE T1.type_id <> 1 AND T1.type_id <> 3 AND owner_login_id <> " . real_mysql_specialchars( $uid, false );
if( $is_admin == false ) {
    $query2 .= " AND( user1_login_id = " . real_mysql_specialchars( $uid, false )." OR user2_login_id = " . real_mysql_specialchars ( $uid, false)." ) ";
}
$query2 .= " UNION SELECT T1.pid, T1.type_id, T1.name, status, T1.name AS l_name, '' AS f_name, '' AS  m_name FROM gen_profile_info T1 WHERE T1.type_id = 3 AND owner_login_id <> " . real_mysql_specialchars( $uid, false );
if( $is_admin == false && $is_tech_admin == false ) {
    $query2 .= " AND( user1_login_id = " . real_mysql_specialchars( $uid, false )." OR user2_login_id = " . real_mysql_specialchars ( $uid, false)." ) ";
}
$query2 .= " ORDER BY type_id, l_name ASC, f_name ASC, m_name ASC";
$result1 = real_execute_query( $query1, $db_conn );
$result2 = real_execute_query( $query2, $db_conn );

?>
<html>
    <head>
        
    </head>
    <body>
        <br>
        <table width="100%"  border="0" cellspacing="2" cellpadding="2" align="left">
            <?php
            if( mysql_num_rows( $result1 ) != 0 ) {
                print "<tr><td colspan='8' class='table_content'><span class='font_topic'>Your Profiles</span><br></td><tr>";
                print "<tr><td colspan='8'>&nbsp;</td><tr>";
                while( $rowsowner = mysql_fetch_array( $result1 ) ) {
                    print "<tr class=\"form_elements\">";
                    // $rowsowner["type_id"]=1; //--only for testing
                    if($rowsowner[ "status" ] == 1){
                        $statusimage = "images/icons/inactive.gif";
                        $status = "Inactive";
                        $label = "Activate";
                    }
                    else{
                        $statusimage = "images/icons/active.gif";
                        $status = "Active";
                        $label = "Deactivate";
                    }
                    switch( $rowsowner[ "type_id" ] )//display picture based on profile type
                    {
                        case 1: 
                            print "<td width='5%' align='left'><img src='images/bullets/faculty.gif' alt='Faculty Profile' /></td>";
                            print "<td width='20%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
                                        <td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
					<td width='10%' align='left'>$status</td>
					<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
					<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
					<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                        <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
					</tr>";
                            break;
                        case 2: 
                            print "<td width='5%' align='left'><img src='images/bullets/center.gif' alt='Center Profile' /></td>";
                            print "<td width='20%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
                                        <td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
					<td width='10%' align='left'>$status</td>
					<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
					<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</a></td>
					<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                        <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
					</tr>";
                            break;
                            case 3: print "<td width='5%' align='left'><img src='images/bullets/technology.gif' alt='Technology Profile' /></td>";
                                print "<td width='20%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
								</tr>";
                                break;
                            case 4: print "<td width='5%' align='left'><img src='images/bullets/facility.gif' alt='Facility Profile' /></td>";
                                print "<td width='20%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
								</tr>";
                                break;
                            case 5: print "<td width='5%' align='left'><img src='images/bullets/equipment.gif' alt='Equipment Profile' /></td>";
                                print "<td width='20%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
								</tr>";
                                break;
                            case 6: print "<td width='5%' align='left'><img src='images/bullets/labgroup.gif' alt='Lab / Group Profile' /></td>";
                                print "<td width='20%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
								</tr>";
                                break;

                        }//end select
                        //$rowowner["name"]="Rajat Mittal"; //--only for testing
                    }//end while
                }//end if
                print "<tr><td colspan='8'>&nbsp;</td><tr>";
                ?>
            </table>
        <br>
        <table width="100%"  border="0" cellspacing="2" cellpadding="2">
                <?php
                if( mysql_num_rows( $result2 ) != 0 ) {
                    print "<tr><td colspan='8' class='table_content'><span class='font_topic'>Editor for</span><span style='font-size:10;color:#555555'>&nbsp;&nbsp;(Search by Last Name)</span></td><tr>";
                    print "<tr><td colspan='8'>&nbsp;</td><tr>";
                    $alphabets = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
                            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                    print "<tr><td colspan='8'>";
                    for ($i = 0; $i < 26; $i++) {
                        print "<a href='".$_SERVER['PHP_SELF']."?lnc=".$alphabets[$i]."' style='font-size:20px;font-weight:bold;color:#777777'>".$alphabets[$i]."</a>";
                        if ($i < 25) print " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    print "<tr><td colspan='8'>&nbsp;</td><tr>";
                    while( $rowseditor = mysql_fetch_array( $result2 ) ) {
                        $lastName = $rowseditor["l_name"];
                        $lastNameChar = strtoupper(substr($lastName, 0, 1));
                        print "<tr class=\"form_elements\">";
                        //$rowseditor[ "type_id" ] = 1; //--only for testing
                        if( $rowseditor[ "status" ] == 1 ) {
                            $statusimage = "images/icons/inactive.gif";
                            $status = "Inactive";
                            $label = "Activate";
                        }
                        else {
                            $statusimage = "images/icons/active.gif";
                            $status = "Active";
                            $label = "Deactivate";
                        }
                        if ($lastNameChar == $_GET['lnc'])
                            switch( $rowseditor[ "type_id" ] )//display picture based on profile type
                            {
                                case 1: print "<td width='5%' align='left'><img src='images/bullets/faculty.gif' alt='Faculty Profile' /></td>";
                                    print "<td width='20%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</a></td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
							  	</tr>";
                                    break;
                                case 2: print "<td width='5%' align='left'><img src='images/bullets/center.gif' alt='Center Profile' /></td>";
                                    print "<td width='20%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</a></td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
							  	</tr>";
                                    break;
                                case 3: print "<td width='5%' align='left'><img src='images/bullets/technology.gif' alt='Technology Profile' /></td>";
                                    print "<td width='20%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</a></td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
							  	</tr>";
                                    break;
                                case 4: print "<td width='5%' align='left'><img src='images/bullets/facility.gif' alt='Facility Profile' /></td>";
                                    print "<td width='20%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</a></td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
							  	</tr>";
                                    break;
                                case 5: print "<td width='5%' align='left'><img src='images/bullets/equipment.gif' alt='Equipment Profile' /></td>";
                                    print "<td width='20%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
								</tr>";
                                    break;
                                case 6: print "<td width='5%' align='left'><img src='images/bullets/labgroup.gif' alt='Lab / Group Profile' /></td>";
                                    print "<td width='20%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</td>
								<td width='20%' align='left'><a href='sections/gen_activate_profile_from_researchspace.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>$label</a></td>
                                                                <td width='20%' align='left'><a href='customize_profile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Editors</a></td>
								</tr>";
                                    break;
                        }//end select
                        //$rowseditor["name"]="Kumaravel Senthivel"; //--only for testing
                    }//end while
                }//end if
                print "<tr><td colspan='7'>&nbsp;</td><tr>";
                ?>
            </table>
    </body>
</html>