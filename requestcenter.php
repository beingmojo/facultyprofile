<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Request New Research Center Profile";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-script1'] = "<script language='JavaScript' type='text/javascript' src='scripts/findprofile.js'></script>";
$_POST['page-script2'] = "<script language='JavaScript' type='text/javascript' src='scripts/section_and_menu.js'></script>";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
?>

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
    }

    //-->
</script>
<tr>
    <td colspan="2">
        <!-- InstanceBeginEditable name="content" -->
        <script type="text/javascript" language="javascript">
            function validatefields()
            {
                if( document.frmNewProfile.ctr_general_info_login_id != null )
                {
                    if ( document.frmNewProfile.ctr_general_info_login_id.value == "" )
                    {
                        alert( "Please find the person from the user directory." );
                        document.frmNewProfile.ctr_general_info_login_id.focus();
                        return false;
                    }
                }
                if ( document.frmNewProfile.ctr_general_info_name.value == "" )
                {
                    alert( "Please enter name for the Research Center." );
                    document.frmNewProfile.ctr_general_info_name.focus();
                    return false;
                }
                return true;
            }
        </script>

        <form action="requestnew.php" method="post" name="frmNewProfile" enctype='multipart/form-data' onSubmit='return validatefields()'>
            <?php
            print( "<input name='profiletype' type='hidden' value='center' />");
            print( "<input class='form_elements_text' type='hidden' id='ctr_general_info_login_id' name='ctr_general_info_login_id' value='" . $_SESSION['UID'] . "' />");
            $readonly = "readonly=true";
            print( "<table width='100%' cellspacing='1' cellpadding='1'>");
            if (real_check_user_groupid($db_conn, "admin") == true) {
                print( "<tr>");
                print( "<td>&nbsp;<span class='form_elements_text'><B>Owner Name *</B></span></td>");
                print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='ctr_general_info_login_name' name='ctr_general_info_login_name' size='30' maxlength='255' value='" . $_SESSION['ULNAME'] . " " . $_SESSION['UFNAME'] . "' readonly> ");
                print( "&nbsp;&nbsp;<script language=\"JavaScript\" type=\"text/javascript\">");
                print( "createFindProfileRow('new_center_find', 'ppl', 'new_center_enter_info', 0, 1, 'dir' );");
                print( "</script>");
                print( "</td>");
                print( "</tr>");
            }

            print( "<tr>");
            print( "<td>&nbsp;<span class='form_elements_text'><B>Name</B></span></td>");
            print( "<td>&nbsp;<input class='form_elements_text' type='text' " .
                "name='ctr_general_info_name' size='100' maxlength='255'> </td>");
            print( "</tr>");

            print( "<tr>");
            print( "<td>&nbsp;<span class='form_elements_text'><B>About</B></span></td>");
            print( "<td>&nbsp;<textarea name='ctr_general_info_description' cols='100' rows='10' class='form_elements_text'>" . "</textarea>" .
                "</td>");
            print( "</tr>");



            print( "<tr><td colspan='2'><hr></td></tr>");

            print( "<tr><td  colspan='2' align='center'>
	<input name='Submit' type='submit' class='form_elements' value='Create' />
	<input name='cancel' type='button' class='form_elements' value='Cancel' onclick='location.href=\"myprofiles.php?#createnew\"'/>
	</td></tr>");
            ?>
        </form>

        <script type='text/javascript'>
            function new_center_enter_info( boxname, results )
            {
                if( results.length > 0 )
                {
                    document.getElementById( 'ctr_general_info_login_name' ).value = results[0][0];
                    document.getElementById( 'ctr_general_info_login_id' ).value = results[0][3];
                }
                cancelFindProfile( boxname );
            }
        </script>



        <!-- InstanceEndEditable -->
    </td>
</tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="table_background">
            <!-- Partnership text in this section with the hyperlink should remain visible on the template page and should not deleted -->
            <div align="right"><a href="http://www.uta.edu/collaborate" target="_blank"><span class="font_on_dark_blue"><strong>powering - The Partnership</strong></span></a></div>
            <!-- End of Partnership text -->
        </td>
    </tr>
    <!-- footer content goes here -->
    <tr>
        <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy;2006 The University of Texas at Arlington | <a href="http://www.uta.edu/research/webteam">Electronic Research Administration</a>, 219 ATI Box 19145, Arlington, Texas 76019-0145 Voice: 817.272.3896 | Fax: 817.272.5808 | <a href="feedback.php">Site Feedback</a> | <a href="http://www.uta.edu/research/webteam">Contact Electronic Research Administration - Web Team</a><br />
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