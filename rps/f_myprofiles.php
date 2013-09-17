<?php
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
$createfaculty = true;
$createcenter = true;
$createfacility = true;
if( $is_admin != true ) {
    $ppl_profile_query = "SELECT COUNT(1) FROM ppl_general_info WHERE login_id = ". real_mysql_specialchars($uid, false);
    $ppl_profile_results = real_execute_query( $ppl_profile_query , $db_conn );
    $ppl_profile_rows = mysql_fetch_row( $ppl_profile_results );
    if( $ppl_profile_rows[0] > 0 ) {
        $createfaculty = false;
    }
    $createcenter = false;
    $createfacility = false;
}
$createtechnology = false;
if( $is_admin == true ||  $is_tech_admin == true ) {
    $createtechnology = true;
}
?>
<script language="JavaScript" type="text/javascript" src="scripts/section_and_menu.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/findprofile.js"></script>
<script type="text/javascript">
    startList = function() {
        if (document.all&&document.getElementById) {
            navRoot = document.getElementById("nav");
            for (i=0; i<navRoot.childNodes.length; i++) {
                node = navRoot.childNodes[i];
                if (node.nodeName=="LI") {
                    node.onmouseover=function() {
                        this.className+=" over";
                    }
                    node.onmouseout=function() {
                        this.className=this.className.replace(" over", "");
                    }
                }
            }
        }
    }
    window.onload=function() {	startList(); }
    function goYourProfilesHREF() {
        var pid = document.getElementById("your_profiles_options");
        pid = pid.options[pid.selectedIndex].id;
        pid = pid.substring(pid.lastIndexOf("_") + 1);
        document.location="editprofile.php?pid=" + pid;
    }
</script>
<link href="styles/style1.css" rel="stylesheet" type="text/css">
<link href="styles/list.css" rel="stylesheet" type="text/css">
<table width="90%"  border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
        <td>
            <span class="form_elements"><b><?php print( htmlspecialchars($_SESSION['ULNAME']) . ", " . htmlspecialchars($_SESSION['UFNAME']) ); ?></b></span>
            &nbsp;&nbsp;
            <a href='f_firstlogin.php' style="text-decoration:none"><span class="details">(Account Info </span></a>
            <span class="details">|</span>
            <a href='logoff.php' style="text-decoration:none"><span class="details">Logoff)</span></a>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%"  border="0" cellspacing="2" cellpadding="2" align="left">
                <tr><td class="table_content" colspan='2'><a name='createnew'><span class="font_topic">Create a New Profile</span></a></td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td width='5%' align='left'><img src='images/bullets/faculty.gif' alt='Faculty Profile' /></td>
                    <td><span class="form_elements_text">
                            <?php
                            if( $createfaculty == true )
                                print( "<a href='createfaculty.php'>Create Faculty Profile</a>" );
                            else
                                print( "Your Faculty Profile is already created." );
                            ?>
                        </span></td>
                </tr>
                <tr><td height='5'></td></tr>
                <tr>
                    <td width='5%' align='left'><img src='images/bullets/center.gif' alt='Research Center Profile' /></td>
                    <td><span class="form_elements_text">
                            <?php
                            if( $createcenter == true )
                                print( "<a href='createcenter.php'>Create Research Center Profile</a>" );
                            else
                                print( "<a href='feedback.php?comments=This request is for a new Center Profile. Please fill in the center details in this box.'>Request for Research Center Profile</a></span>" );
                            print( "<BR /><span class='form_elements_row_action'>" );
                            print( "Find whether your Research Center's profile already exists.&nbsp;&nbsp; " );
                            print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
                            print( "createFindProfileRow('myprofiles_ctr_find', 'ctr', '', 1 );" );
                            print( "</script>" );
                            ?>
                        </span></td>
                </tr>
                <tr><td height='5'></td></tr>
                <tr>
                    <td width='5%' align='left'><img src='images/bullets/technology.gif' alt='Technology Profile' /></td>
                    <td><span class="form_elements_text">
                            <?php
                            if( $createtechnology == true )
                                print( "<a href='createtechnology.php'>Create Technology Profile</a>" );
                            else
                                print( "<a href='feedback.php?comments=This request is for a new Technology Profile. Please fill in the technology details in this box.'>Request for Technology Profile</a>");
                            print( "<BR /><span class='form_elements_row_action'>" );
                            print( "Find whether your Technology's profile already exists.&nbsp;&nbsp;" );
                            print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
                            print( "createFindProfileRow('myprofiles_tech_find', 'tech', '', 1 );" );
                            print( "</script>" );
                            ?>
                        </span></td>
                </tr>
                <tr><td height='5'></td></tr>
                <tr>
                    <td width='5%' align='left'><img src='images/bullets/facility.gif' alt='Facility Profile' /></td>
                    <td><span class="form_elements_text">
                            <?php
                            if( $createfacility == true )
                                print( "<a href='createfacility.php'>Create Facility Profile</a>" );
                            else
                                print( "<a href='feedback.php?comments=This request is for a new Facility Profile. Please fill in the facility details in this box.'>Request for Facility Profile</a>" );
                            print( "</span><BR /><span class='form_elements_row_action'> Find whether your Facilty's profile already exists.&nbsp;&nbsp;</span>" );
                            print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
                            print( "createFindProfileRow('myprofiles_fac_find', 'fac', '', 1 );" );
                            print( "</script>" );

                            ?>
                        </span></td>
                </tr>
                <tr><td height='5'></td></tr>
                <tr>
                    <td width='5%' align='left'><img src='images/bullets/equipment.gif' alt='Equipment Profile' /></td>
                    <td><span class="form_elements_text"><a href="createequipment.php">Create Equipment Profile</a></span>
                        <BR /><span class="form_elements_edit">If there is not much information about the equipment, then it can be created as a new section.</span>
                        <BR /><span class='form_elements_row_action'>
				Find whether your Equipment's profile already exists.&nbsp;&nbsp;</span>
                        <script language="JavaScript" type="text/javascript">
                            createFindProfileRow('myprofiles_eqp_find', 'eqp', '', 1 );
                        </script>
                    </td>
                </tr>
                <tr><td height='5'></td></tr>
                <tr>
                    <td width='5%' align='left'><img src='images/bullets/labgroup.gif' alt='Lab / Group Profile' /></td>
                    <td><span class="form_elements_text"><a href="create_lab_group.php">Create Lab / Group Profile</a></span>
                        <BR /><span class='form_elements_row_action'>
				Find whether your Lab/Group's profile already exists.&nbsp;&nbsp;</span>
                        <script language="JavaScript" type="text/javascript">
                            createFindProfileRow('myprofiles_lab_find', 'lab', '', 1);
                        </script>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%"  border="0" cellspacing="2" cellpadding="2" align="left">
                <?php
                if( mysql_num_rows( $result1 ) != 0 ) {
                    print "<tr>
				           <td colspan='7' class='table_content'><span class='font_topic'>Your Profiles</span></td>
					       <tr>";
                    while( $rowsowner = mysql_fetch_array( $result1 ) ) {
                        print "<tr class=\"form_elements\">";
                        // $rowsowner["type_id"]=1; //--only for testing
                        if( $rowsowner[ "status" ] == 1 ) {
                            $statusimage = "images/icons/inactive.gif";
                            $status = "Inactive";
                        }
                        else {
                            $statusimage = "images/icons/active.gif";
                            $status = "Active";
                        }
                        switch( $rowsowner[ "type_id" ] )//display picture based on profile type
                        {
                            case 1: print "<td width='5%' align='left'><img src='images/bullets/faculty.gif' alt='Faculty Profile' /></td>";
                                print "<td width='30%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='35%' align='left'>&nbsp;</td>
								</tr>";
                                break;
                            case 2: print "<td width='5%' align='left'><img src='images/bullets/center.gif' alt='Center Profile' /></td>";
                                print "<td width='30%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='35%' align='left'>&nbsp;</td>
								</tr>";
                                break;
                            case 3: print "<td width='5%' align='left'><img src='images/bullets/technology.gif' alt='Technology Profile' /></td>";
                                print "<td width='30%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='35%' align='left'>&nbsp;</td>
								</tr>";
                                break;
                            case 4: print "<td width='5%' align='left'><img src='images/bullets/facility.gif' alt='Facility Profile' /></td>";
                                print "<td width='30%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='35%' align='left'>&nbsp;</td>
								</tr>";
                                break;
                            case 5: print "<td width='5%' align='left'><img src='images/bullets/equipment.gif' alt='Equipment Profile' /></td>";
                                print "<td width='30%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='35%' align='left'>&nbsp;</td>
								</tr>";
                                break;
                            case 6: print "<td width='5%' align='left'><img src='images/bullets/labgroup.gif' alt='Lab / Group Profile' /></td>";
                                print "<td width='30%' align='left'>".htmlspecialchars($rowsowner["name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left'><a href='editprofile.php?pid=".$rowsowner["pid"]."' style='text-decoration:none'>Edit</td>
								<td width='35%' align='left'>&nbsp;</td>
								</tr>";
                                break;

                        }//end select
                        //$rowowner["name"]="Rajat Mittal"; //--only for testing
                    }//end while
                }//end if
                print "<tr><td colspan='7'>&nbsp;</td><tr>";
                ?>
            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
            <table width="100%"  border="0" cellspacing="2" cellpadding="2">
                <?php
                if( mysql_num_rows( $result2 ) != 0 ) {
                    print "<tr><td colspan='7' class='table_content'><span class='font_topic'>Editor for</span><span style='font-size:10;color:#555555'>&nbsp;&nbsp;(Search by Last Name)</span></td><tr>";
                    $alphabets = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
                            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
                    print "<tr><td colspan='7'>";
                    for ($i = 0; $i < 26; $i++) {
                        print "<a href='".$_SERVER['PHP_SELF']."?lnc=".$alphabets[$i]."' style='font-size:20px;font-weight:bold;color:#777777'>".$alphabets[$i]."</a>";
                        if ($i < 25) print " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    print "<tr><td colspan='7'>&nbsp;</td><tr>";
                    while( $rowseditor = mysql_fetch_array( $result2 ) ) {
                        $lastName = $rowseditor["l_name"];
                        $lastNameChar = strtoupper(substr($lastName, 0, 1));
                        print "<tr class=\"form_elements\">";
                        //$rowseditor[ "type_id" ] = 1; //--only for testing
                        if( $rowseditor[ "status" ] == 1 ) {
                            $statusimage = "images/icons/inactive.gif";
                            $status = "Inactive";
                        }
                        else {
                            $statusimage = "images/icons/active.gif";
                            $status = "Active";
                        }
                        if ($lastNameChar == $_GET['lnc'])
                            switch( $rowseditor[ "type_id" ] )//display picture based on profile type
                            {
                                case 1: print "<td width='5%' align='left'><img src='images/bullets/faculty.gif' alt='Faculty Profile' /></td>";
                                    print "<td width='30%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</a></td>
								<td width='35%' align='left'>&nbsp;</td>
							  	</tr>";
                                    break;
                                case 2: print "<td width='5%' align='left'><img src='images/bullets/center.gif' alt='Center Profile' /></td>";
                                    print "<td width='30%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</a></td>
								<td width='35%' align='left'>&nbsp;</td>
							  	</tr>";
                                    break;
                                case 3: print "<td width='5%' align='left'><img src='images/bullets/technology.gif' alt='Technology Profile' /></td>";
                                    print "<td width='30%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</a></td>
								<td width='35%' align='left'>&nbsp;</td>
							  	</tr>";
                                    break;
                                case 4: print "<td width='5%' align='left'><img src='images/bullets/facility.gif' alt='Facility Profile' /></td>";
                                    print "<td width='30%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</a></td>
								<td width='35%' align='left'>&nbsp;</td>
							  	</tr>";
                                    break;
                                case 5: print "<td width='5%' align='left'><img src='images/bullets/equipment.gif' alt='Equipment Profile' /></td>";
                                    print "<td width='30%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</td>
								<td width='35%' align='left'>&nbsp;</td>
								</tr>";
                                    break;
                                case 6: print "<td width='5%' align='left'><img src='images/bullets/labgroup.gif' alt='Lab / Group Profile' /></td>";
                                    print "<td width='30%' align='left' class='form_elements' style='color:#555555'>".htmlspecialchars($lastName).", ".
                                            htmlspecialchars($rowseditor["f_name"])." ".htmlspecialchars($rowseditor["m_name"])."</td>
								<td width='5%' align='right'><img src='$statusimage' alt='$status' /></td>
								<td width='10%' align='left'>$status</td>
								<td width='5%' align='right'><img src='images/buttons/edit.gif' alt='Edit Profile' /></td>
								<td width='10%' align='left' class='form_elements'><a href='editprofile.php?pid=".$rowseditor["pid"]."' style='text-decoration:none;color:#555555'>Edit</td>
								<td width='35%' align='left'>&nbsp;</td>
								</tr>";
                                    break;
                        }//end select
                        //$rowseditor["name"]="Kumaravel Senthivel"; //--only for testing
                    }//end while
                }//end if
                print "<tr><td colspan='7'>&nbsp;</td><tr>";
                ?>
            </table>
        </td>
    </tr>
</table>
