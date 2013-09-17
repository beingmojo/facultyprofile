<?php  
include 'utils.php';

session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
?>
<?php
include 'includes/txstate/page-top.html';
?>
<tr>
    <td style="background-color:#480000;color:#CCCCCC;" height="10px"><span style="margin-top:2px;margin-left:10px;font-family:times,san-serif;font-weight:bold;font-size:16px">Create New Faculty Profile</span></td>
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
<link href="styles/style1.css" rel="stylesheet" type="text/css" />
<link href="styles/list.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="scripts/findprofile.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/section_and_menu.js"></script>
<script type="text/javascript">
    <!--
    var timer;
    startList = function() {
        if (document.all&&document.getElementById) {
            navRoot = document.getElementById("nav");
            for (i = 0; i<navRoot.childNodes.length; i++) {
                node = navRoot.childNodes[i];
                if (node.nodeName == "LI") {
                    node.onmouseover = function() {
                        this.className += " over";
                    }
                    node.onmouseout=function() {
                        this.className=this.className.replace(" over", "");
                    }
                }
            }
        }
    }
    window.onload = function() {
        startList();
    }
    -->
</script>
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
    <tr><!-- Main Content -->
        <td>
            <!-- InstanceBeginEditable name="content" -->
            <script type="text/javascript" language="javascript">
                function validatefields()
                {
                    if ( document.frmNewProfile.ppl_general_info_f_name.value == ""
                        || document.frmNewProfile.ppl_general_info_l_name.value == ""
                        || document.frmNewProfile.ppl_general_info_pri_designation.value == ""
                        || document.frmNewProfile.ppl_general_info_email_id.value == ""
                        || document.frmNewProfile.ppl_general_info_login_id.value == "" )
                    {
                        if( document.frmNewProfile.ppl_general_info_login_id.value == "" )
                        {
                            alert( "Please find the person from the user directory." );
                            return false;
                        }

                        if( document.frmNewProfile.ppl_general_info_f_name.value == "" )
                        {
                            alert( "Please enter First Name." );
                            document.frmNewProfile.ppl_general_info_f_name.focus();
                        }
                        else if( document.frmNewProfile.ppl_general_info_l_name.value == "" )
                        {
                            alert( "Please enter Last Name." );
                            document.frmNewProfile.ppl_general_info_l_name.focus();
                        }
                        else if( document.frmNewProfile.ppl_general_info_pri_designation.value == "" )
                        {
                            alert( "Please enter Primary Rank." );
                            document.frmNewProfile.ppl_general_info_pri_designation.focus();
                        }
                        else if( document.frmNewProfile.ppl_general_info_email_id.value == "" )
                        {
                            alert( "Please enter Email ID." );
                            document.frmNewProfile.ppl_general_info_email_id.focus();
                        }

                        return false;
                    }

                    return true;
                }
            </script>

            <form action="createnew.php" method="post" name="frmNewProfile" enctype='multipart/form-data' onSubmit='return validatefields()'>
                <?php
                print( "<input type='hidden' name='ppl_general_info_rank_changed' value='0' />" );
                print( "<input type='hidden' name='ppl_general_info_hid_list' value='' />" );
                print( "<input type='hidden' name='ppl_general_info_pri_rank_changed' value='0' />" );
                print( "<input type='hidden' name='ppl_general_info_pri_hid' value='' />" );
                print( "<input type='hidden' id='ppl_general_info_login_id' name='ppl_general_info_login_id' value='" . $_SESSION['UID'] . "' />" );

                print( "<input name='profiletype' type='hidden' value='faculty' />" );

                print( "<table width='100%' cellspacing='0' cellpadding='1'>" );
                if( real_check_user_groupid( $db_conn, "admin" ) == true ) {
                    print( "<tr>" );
                    print( "<td>&nbsp;<span class='form_elements_text'><B>Owner Name *</B></span></td>" );
                    print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_name' name='ppl_general_info_name' size='30' maxlength='255' value='' readonly> " );
                    print( "&nbsp;&nbsp;<script language=\"JavaScript\" type=\"text/javascript\">" );
                    print( "createFindProfileRow('new_faculty_find', 'pplb', 'new_faculty_enter_info', 0, 1, 'dir' );" );
                    print( "</script>" );
                    print( "</td>" );
                    print( "</tr>" );
                }

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Title</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_title' name='ppl_general_info_title' size='2' maxlength='8' value='". htmlspecialchars($generalrows[ "title" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>First Name *</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_f_name' name='ppl_general_info_f_name' size='20' maxlength='255' value='". htmlspecialchars($generalrows[ "f_name" ], ENT_QUOTES) ."' $readonly> </td> " );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Middle Name</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_m_name' name='ppl_general_info_m_name' size='10' maxlength='255' value='". htmlspecialchars($generalrows[ "m_name" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Last Name *</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_l_name' name='ppl_general_info_l_name' size='20' maxlength='255' value='". htmlspecialchars($generalrows[ "l_name" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );

                print( "<tr><td colspan='2'><hr></td></tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Image</B></span></td>" );
                print( "<td>" );
                print( "<input type='hidden' name='MAX_FILE_SIZE' value='65555' />" ); //MAX=64KB
                print( "&nbsp;<input type='file' name='imagefile' size='50'>" );
                print( "</td>" );
                print( "</tr>" );

                print( "<tr><td colspan='2'><hr></td></tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Primary Rank *</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_pri_designation' name='ppl_general_info_pri_designation' size='30' maxlength='255' value='". htmlspecialchars($generalrows[ "pri_designation" ], ENT_QUOTES) ."' readonly> " );
                print( "&nbsp;<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='show_popup( \"ppl_general_info_pri_rank\",\"sections/ppl_general_info_rank_edit.php?&type=Primary&rank=".rawurlencode($generalrows["pri_designation"])."&hid=".rawurlencode($generalrows["pri_hid"]). "\",450,650)'><img border='0' src='images/buttons/edit.gif'  > <span class='form_elements_text'>Edit</span></a></td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Other Ranks</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_designation' name='ppl_general_info_designation' size='30' maxlength='255' value='". htmlspecialchars($generalrows[ "designation" ], ENT_QUOTES) ."' readonly> " );
                print( "&nbsp;<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='show_popup( \"ppl_general_info_rank\",\"sections/ppl_general_info_rank_edit.php?&type=Other&rank=".rawurlencode($generalrows["designation"])."&hid=".rawurlencode($generalrows["hid"]). "\",450,650)'><img border='0' src='images/buttons/edit.gif'  > <span class='form_elements_text'>Edit</span></a></td>" );
                print( "</tr>" );

                print( "<tr><td colspan='2'><hr></td></tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Mailbox</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_mailbox' name='ppl_general_info_mailbox' size='3' maxlength='8' value='". htmlspecialchars($generalrows[ "mailbox" ], ENT_QUOTES) ."' $readonly></td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Office </B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_office_location' name='ppl_general_info_office_location' size='20' maxlength='255' value='". htmlspecialchars($generalrows[ "office_location" ], ENT_QUOTES) ."' $readonly></td> " );
                print( "</tr>" );
                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Room No.</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_room_no' name='ppl_general_info_room_no' size='3' maxlength='16' value='". htmlspecialchars($generalrows[ "room_no" ], ENT_QUOTES) ."' $readonly></td> " );
                print( "</tr>" );

                print( "<tr><td colspan='2'><hr></td></tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Street</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_address_1' size='20' maxlength='255' value='". htmlspecialchars($generalrows[ "address_1" ], ENT_QUOTES) ."' $readonly> " );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;</td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_address_2' size='20' maxlength='255' value='". htmlspecialchars($generalrows[ "address_2" ], ENT_QUOTES) ."' $readonly></td> " );
                print( "</tr>" );



                print( "<tr>" );
                print( "<td><span class='form_elements_text'><B>City</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_city' size='10' maxlength='32' value='". htmlspecialchars($generalrows[ "city" ], ENT_QUOTES) ."' $readonly> </td> " );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td><span class='form_elements_text'><B>State</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_state' size='2' maxlength='32' value='". htmlspecialchars($generalrows[ "state" ], ENT_QUOTES) ."' $readonly> </td> " );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td><span class='form_elements_text'><B>Zip</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_zipcode' size='3' maxlength='16' value='". htmlspecialchars($generalrows[ "zipcode" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "<tr>" );

                print( "<tr><td colspan='2'><hr></td></tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Phone</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_phone_no_1' name='ppl_general_info_phone_no_1' size='10' maxlength='32' value='". htmlspecialchars($generalrows[ "phone_no_1" ], ENT_QUOTES) ."' $readonly> </td> " );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Alt. Phone</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_phone_no_2' size='10' maxlength='32' value='". htmlspecialchars($generalrows[ "phone_no_2" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Cell Phone</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_cell_no' size='10' maxlength='255' value='". htmlspecialchars($generalrows[ "cell_no" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Email *</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_email_id' name='ppl_general_info_email_id' size='30' maxlength='255' value='". htmlspecialchars($generalrows[ "email_id" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Fax</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_fax_no' size='10' maxlength='32' value='". htmlspecialchars($generalrows[ "fax_no" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Website 1</B></span></td>" );
                print( "<td>" );
                print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_name_1' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "url_name_1" ], ENT_QUOTES) ."' $readonly> " );
                print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_text'><B>URL</B></span>" );
                print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_1' size='30' maxlength='255' value='". htmlspecialchars($generalrows[ "url_1" ], ENT_QUOTES) ."' $readonly> " );
                print( "</td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Website 2</B></span></td>" );
                print( "<td>" );
                print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_name_2' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "url_name_2" ], ENT_QUOTES) ."' $readonly> " );
                print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_text'><B>URL</B></span>" );
                print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_2' size='30' maxlength='255' value='". htmlspecialchars($generalrows[ "url_2" ], ENT_QUOTES) ."' $readonly> " );
                print( "</td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Website 3</B></span></td>" );
                print( "<td>" );
                print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_name_3' size='15' maxlength='255' value='". htmlspecialchars($generalrows[ "url_name_3" ], ENT_QUOTES) ."' $readonly> " );
                print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_text'><B>URL</B></span>" );
                print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_3' size='30' maxlength='255' value='". htmlspecialchars($generalrows[ "url_3" ], ENT_QUOTES) ."' $readonly> " );
                print( "</td>" );
                print( "</tr>" );

                print( "<tr><td colspan='2'><hr></td></tr>" );
                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Keywords</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_keywords' size='30' maxlength='255' value='". htmlspecialchars($generalrows[ "keywords" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );
//Texas State Customizations - Start:///////////////////////////////////////////
                print( "<tr><td colspan='2'><hr></td></tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Curriculum Vitae</B></span></td>" );
                print( "<td><input type='hidden' name='MAX_FILE_SIZE' value='1030000' />" ); //MAX=1MB
                print( "&nbsp;<input type='file' name='txst_fac_profl_cv' size='50'> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Research Interests</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='txst_fac_profl_r_int' size='60' maxlength='255' value='". htmlspecialchars($generalrows[ "r_int" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Publications</B></span></td>" );
                print( "<td><input type='hidden' name='MAX_FILE_SIZE' value='1030000' />" ); //MAX=1MB
                print( "&nbsp;<input type='file' name='txst_fac_profl_pubc' size='50'> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Funding History</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='txst_fac_profl_f_hist' size='60' maxlength='255' value='". htmlspecialchars($generalrows[ "f_hist" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Patents</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='txst_fac_profl_patent' size='60' maxlength='255' value='". htmlspecialchars($generalrows[ "patent" ], ENT_QUOTES) ."' $readonly> </td>" );
                print( "</tr>" );
//Texas State Customizations - End://///////////////////////////////////////////

                print( "<tr><td colspan='2'><hr></td></tr>" );

                print( "<tr><td  colspan='2' align='center'>
	<input name='Submit' type='submit' value='Create' />
	<input name='cancel' type='button' value='Cancel' onclick='location.href=\"researchspace.php?#createnew\"'/>
	</td></tr></table>" );

                ?>
            </form>

            <script type='text/javascript'>
                function ChangeRank( rank, hid_list, type )
                {
                    if( type == 'Other' )
                    {
                        hide_popup( "ppl_general_info_rank" );
                        document.frmNewProfile.ppl_general_info_designation.value=rank;
                        document.frmNewProfile.ppl_general_info_rank_changed.value='1';
                        document.frmNewProfile.ppl_general_info_hid_list.value=hid_list;
                    }
                    else
                    {
                        hide_popup( "ppl_general_info_pri_rank" );
                        document.frmNewProfile.ppl_general_info_pri_designation.value=rank;
                        document.frmNewProfile.ppl_general_info_pri_rank_changed.value='1';
                        document.frmNewProfile.ppl_general_info_pri_hid.value=hid_list;
                    }
                }
                function CancelChangeRank( type )
                {
                    if( type == 'Other' )
                        hide_popup( "ppl_general_info_rank" );
                    else
                        hide_popup( "ppl_general_info_pri_rank" );
                }


                function new_faculty_enter_info( boxname, results )
                {
                    if( results.length > 0 )
                    {
                        /* //debug code follows by Farhan Khan
                            var t = "";
                            for (var i=0; i<results[0].length; i++)
                            {
                                    t += results[0][i] + "\n";
                            }
                            alert(t);
                         */
                        document.getElementById( 'ppl_general_info_name' ).value = results[0][0];
                        document.getElementById( 'ppl_general_info_login_id' ).value = results[0][3];
                        document.getElementById( 'ppl_general_info_title' ).value = '';
                        document.getElementById( 'ppl_general_info_l_name' ).value = results[0][5];
                        document.getElementById( 'ppl_general_info_f_name' ).value = results[0][6];
                        document.getElementById( 'ppl_general_info_m_name' ).value = results[0][7];
                        document.getElementById( 'ppl_general_info_phone_no_1' ).value = results[0][8];
                        document.getElementById( 'ppl_general_info_email_id' ).value = results[0][9];
                        document.getElementById( 'ppl_general_info_room_no' ).value = results[0][10];
                        document.getElementById( 'ppl_general_info_office_location' ).value = results[0][11];
                        document.getElementById( 'ppl_general_info_mailbox' ).value = results[0][12];

                    }
                    cancelFindProfile( 'new_faculty_find' );
                }



            </script>


            <div id='ppl_general_info_rank_box' style='display:none;z-index:100' onSelectStart='return false'>
                <div id='ppl_general_info_rank_header' >
                    <span id='ppl_general_info_rank_caption' >Edit Other Ranks</span>
                    <span id='ppl_general_info_rank_close' >
                        <img src='images/buttons/close.gif' onClick='hide_popup("ppl_general_info_rank")'>
                    </span>
                </div>
                <div id='ppl_general_info_rank_content' >
                    <iframe id='ppl_general_info_rank_frame'></iframe>
                </div>
            </div>

            <div id='ppl_general_info_pri_rank_box' style='display:none;z-index:100' onSelectStart='return false'>
                <div id='ppl_general_info_pri_rank_header' >
                    <span id='ppl_general_info_pri_rank_caption' >Edit Primary Rank</span>
                    <span id='ppl_general_info_pri_rank_close' >
                        <img src='images/buttons/close.gif' onClick='hide_popup("ppl_general_info_pri_rank")'>
                    </span>
                </div>
                <div id='ppl_general_info_pri_rank_content' >
                    <iframe id='ppl_general_info_pri_rank_frame'></iframe>
                </div>
            </div>


            <!-- InstanceEndEditable -->
        </td>
    </tr>
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
