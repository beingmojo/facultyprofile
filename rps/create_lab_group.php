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
    <td style="background-color:#480000;color:#CCCCCC;" height="10px"><span style="margin-top:2px;margin-left:10px;font-family:times,san-serif;font-weight:bold;font-size:16px">Create Lab/Group Profile</span></td>
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
    function validatefields()
    {

        if( document.frmNewProfile.labgroup_general_info_login_id != null )
        {
            if ( document.frmNewProfile.labgroup_general_info_login_id.value == "" )
            {
                alert( "Please find the person from the user directory." );
                document.frmNewProfile.labgroup_general_info_login_id.focus();
                return false;
            }
        }
        if ( Trim(document.frmNewProfile.profiletype.value) == "" )
        {
            alert( "Please choose a profile type." );
            document.frmNewProfile.profiletype.focus();
            return false;
        }
        if ( Trim(document.frmNewProfile.labgroup_general_info_name.value) == "" )
        {
            alert( "Please enter name for the Lab / Group." );
            document.frmNewProfile.labgroup_general_info_name.focus();
            return false;
        }

        return true;
    }

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

    var tableToggle = false;

    function enable_location() {
        var which_type = document.frmNewProfile.profiletype.value;
        if (which_type=='lab'&&tableToggle==false) {
            document.getElementById('contact_row').className = "visiblerow";
            tableToggle = true;
        } else {
            document.getElementById('contact_row').className = "hiddenrow";
            tableToggle = false;
        }
    }

    function new_labgroup_enter_info( boxname, results )
    {
        if( results.length > 0 )
        {
            document.getElementById( 'labgroup_general_info_login_name' ).value = results[0][0];
            document.getElementById( 'labgroup_general_info_login_id' ).value = results[0][3];
        }
        cancelFindProfile( boxname );
    }
    -->
</script>
<table width="100%" border="0">
    <tr><!-- Menu Bar -->
        <td colspan="2" style="background-color: #480000;" valign="top" align="right">
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
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><!-- Main Content -->
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <table border=0 cellspacing=1 cellpadding=0 width="85%">
                <form action='createnew.php' method='post' name='frmNewProfile' enctype='multipart/form-data' onSubmit='return validatefields()'>
                    <?php
                    $readonly = "readonly=true";
                    if( real_check_user_groupid( $db_conn, "admin" ) == true ) {
                        print( "<input class='form_elements_text' type='hidden' id='labgroup_general_info_login_id' name='labgroup_general_info_login_id' />" );
                        print( "<tr>" );
                        print( "<td>&nbsp;<span class='form_elements_text'><B>Owner Name *</B></span></td>" );
                        print( "<td><input class='form_elements_edit' type='text' id='labgroup_general_info_login_name' name='labgroup_general_info_login_name' size='30' maxlength='255' value='' readonly> " );
                        print( "&nbsp;&nbsp;<script language=\"JavaScript\" type=\"text/javascript\">" );
                        print( "createFindProfileRow('new_labgroup_find', 'ppl', 'new_labgroup_enter_info', 0, 1, 'dir' );" );
                        print( "</script>" );
                        print( "</td>" );
                        print( "</tr>" );
                    }
                    else {
                        print( "<input class='form_elements_text' type='hidden' id='labgroup_general_info_login_id' name='labgroup_general_info_login_id' value='" . $_SESSION['UID'] . "'/>" );
                    }
                    ?>

                    <!--tr>
                    <td class="Normal">
                            <p><span class=form_elements_text><b>Type</b></span></p>
                    </td>
                    <td width="83%" class="Normal"><p>
                        <SELECT NAME="profiletype" onchange="enable_location()">
                          <OPTION SELECTED>Choose Type
                          <OPTION VALUE="group">Lab / Group
                        </SELECT>
                      </p></td>
                    </tr-->
                    <input type="hidden" name="profiletype" value="group" />

                    <tr>
                        <td class="Normal"><p><span class=form_elements_text><b>Name</b></span></p></td>
                        <td width="83%" class="Normal"><p>
                                <INPUT TYPE="TEXT" MAXLENGTH="100" SIZE="100" NAME="labgroup_general_info_name">
                            </p></td>
                    </tr>
                    <tr>
                        <td class="Normal"><p><span class=form_elements_text><b>About</b></span></p></td>
                        <td width="83%" class="Normal"><p>
                                <TEXTAREA ROWS="10" COLS="78" NAME="abstract"></TEXTAREA>
                            </p></td>
                    </tr>
                    <tr id='contact_row' style="display:none">
                        <td ><p><span class=form_elements_text><b>Contact Information</b></span></p></td>
                        <td  width="83%"><p>
                            <table border=1 cellspacing=0 cellpadding=0 align=left  width="97%">
                                <tr>
                                    <td width="100%" class="form_elements_text"><p><span class="formelementstext"><b>Street </b></span>
                                            <INPUT TYPE="TEXT" MAXLENGTH="255" SIZE="16" NAME="lab_info_address_1">
                                            <INPUT TYPE="TEXT" MAXLENGTH="255" SIZE="16" NAME="lab_info_address_2">
				�<span class="formelementstext"><b>Location �</b></span>
                                            <INPUT TYPE="TEXT" MAXLENGTH="255" SIZE="37" NAME="lab_info_office_location">
                                        </p></td>
                                </tr>
                                <tr>
                                    <td width="100%" class="form_elements_text"><p><span class="formelementstext"><b>City��� �</b></span>
                                            <INPUT TYPE="TEXT" MAXLENGTH="32" SIZE="5" NAME="lab_info_city">
				�<span class="formelementstext"><b>State�� �</b></span>
                                            <INPUT TYPE="TEXT" MAXLENGTH="32" SIZE="2" NAME="lab_info_state">
				��<span class="formelementstext"><b>Zip </b></span>
                                            <INPUT TYPE="TEXT" MAXLENGTH="16" SIZE="3" NAME="lab_info_zipcode">
				�<span class="formelementstext"><b>Mailbox </b></span>
                                            <INPUT TYPE="TEXT" MAXLENGTH="8" SIZE="3" NAME="lab_info_mailbox">
				�<span class="formelementstext"><b>Room No. </b></span><INPUT TYPE="TEXT" MAXLENGTH="16" SIZE="3" NAME="lab_info_room_no">
                                        </p></td>
                                </tr>
                                <tr>
                                    <td width="100%" class="form_elements_text"><p><span class="formelementstext"><b>Website </b></span>
                                            <INPUT TYPE="TEXT" MAXLENGTH="255" SIZE="10" NAME="lab_info_url_name">
				�<span class="formelementstext"><b>Email </b></span><INPUT TYPE="TEXT" MAXLENGTH="255" SIZE="37" NAME="lab_info_email_id">
                                        </p></td>
                                </tr>
                                <tr>
                                    <td width="100%" class="form_elements_text"><p><span class="formelementstext"><b>URL </b></span>
                                            <INPUT TYPE="TEXT" MAXLENGTH="255" SIZE="10" NAME="lab_info_url">
				�<span class="formelementstext"><b>Phone </b></span><INPUT TYPE="TEXT" MAXLENGTH="32" SIZE="10" NAME="lab_info_phone_no_1">
				�<span class="formelementstext"><b>Alt. Phone </b></span><INPUT TYPE="TEXT" MAXLENGTH="32" SIZE="10" NAME="lab_info_phone_no_2">
				�<span class="formelementstext"><b>Fax </b></span><INPUT TYPE="TEXT" MAXLENGTH="32" SIZE="10" NAME="lab_info_fax_no">
                                        </p></td>
                                </tr>
                            </table>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan='2'>
                            <input name='Submit' type='submit' class='form_elements' value='Create' style='margin-left:250px'/>
                            <input name='cancel' type='button' class='form_elements' value='Cancel' onclick='location.href="researchspace.php";' />
                        </td>
                    </tr>
                </form></table><!-- InstanceEndEditable -->
        </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
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
</html>
