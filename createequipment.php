<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Create New Equipment Profile";
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
<table width="100%" border="0">
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><!-- Main Content -->
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <script type="text/javascript" language="javascript">
                //validation function for the form fields
                function validatefields()
                {
                    if( document.frmNewProfile.eqp_general_info_login_id != null )
                    {
                        if ( document.frmNewProfile.eqp_general_info_login_id.value == "" )
                        {
                            //changed...........................................
                            document.frmNewProfile.eqp_general_info_login_id.value =
                                document.frmNewProfile.eqp_general_info_login_name.value;
                            /*alert( "Please find the person from the user directory." );
                            document.frmNewProfile.eqp_general_info_login_id.focus();
                            return false;*/
                        }
                    }
                    if ( document.frmNewProfile.eqp_general_info_name.value == "" )
                    {
                        alert( "Please enter name for the Equipment Profile." );
                        document.frmNewProfile.eqp_general_info_name.focus();
                        return false;
                    }
                    return true;
                }
            </script>

            <form action="createnew.php" method="post" name="frmNewProfile" enctype='multipart/form-data' onSubmit='return validatefields()'>
                <?php
                print( "<input name='profiletype' type='hidden' value='equipment' />");

                $readonly = "readonly=true";
                print( "<table width='100%' cellspacing='1' cellpadding='1'>");
                if (real_check_user_groupid($db_conn, "admin") == true) {
                    print( "<input class='form_elements_text' type='hidden' id='eqp_general_info_login_id' name='eqp_general_info_login_id' />");
                    print( "<tr>");
                    //print( "<td>&nbsp;<span class='form_elements_text'><B>Owner Name *</B></span></td>");
                    print( "<td>&nbsp;<span class='form_elements_text'><B>Owner Login ID *</B></span></td>");
                    print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='eqp_general_info_login_name' name='eqp_general_info_login_name' size='30' maxlength='255' value=''> ");
                    print( "&nbsp;&nbsp;<!--script language=\"JavaScript\" type=\"text/javascript\">");
                    print( "createFindProfileRow('new_equipment_find', 'ppl', 'new_equipment_enter_info', 0, 1, 'dir' );");
                    print( "</script-->");
                    print( "</td>");
                    print( "</tr>");
                }else {
                    print( "<input class='form_elements_text' type='hidden' value='" . $_SESSION['UID'] . "' id='eqp_general_info_login_id' name='eqp_general_info_login_id' />");
                }

                print( "<tr>");
                print( "<td>&nbsp;<span class='form_elements_text'><B>Equipment Name</B></span></td>");
                print( "<td>&nbsp;<input class='form_elements_text' type='text' " .
                    "name='eqp_general_info_name' size='100' maxlength='255'> </td>");
                print( "</tr>");

                print( "<tr>");
                print( "<td>&nbsp;<span class='form_elements_text'><B>Equipment Description</B></span></td>");
                print( "<td>&nbsp;<textarea name='eqp_general_info_description' cols='100' rows='10' class='form_elements_text'>" . "</textarea>" .
                    "</td>");
                print( "</tr>");



                print( "<tr><td colspan='2'><hr></td></tr>");

                print( "<tr><td  colspan='2'>
	<input name='Submit' type='submit' class='form_elements' value='Create' style='margin-left:200px'/>
	<input name='cancel' type='button' class='form_elements' value='Cancel' onclick='location.href=\"researchspace.php?#createnew\"'/>
	</td></tr>");
                ?>
            </form>

            <script type='text/javascript'>
                function new_equipment_enter_info( boxname, results )
                {
                    if( results.length > 0 )
                    {
                        document.getElementById( 'eqp_general_info_login_name' ).value = results[0][0];
                        document.getElementById( 'eqp_general_info_login_id' ).value = results[0][3];
                    }
                    cancelFindProfile( boxname );
                }
            </script>


            <!-- InstanceEndEditable -->
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
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>
