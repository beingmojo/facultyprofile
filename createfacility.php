<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Create New Facility Profile";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-script1'] = "<script language='JavaScript' type='text/javascript' src='scripts/findprofile.js'></script>";
$_POST['page-script1'] = "<script language='JavaScript' type='text/javascript' src='scripts/section_and_menu.js'></script>";
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
                function validatefields()
                {
                            //changed...........................................
                            document.frmNewProfile.fac_general_info_login_id.value =
                                document.frmNewProfile.fac_general_info_login_name.value;
                    if ( document.frmNewProfile.fac_general_info_title == "" )
                    {
                        alert( "Please enter a title for the Facility before proceeding." );
                        document.frmNewProfile.fac_general_info_title.focus();
                        return false;
                    }
                    return true;
                }
            </script>

            <form action="createnew.php" method="post" name="frmNewProfile" enctype='multipart/form-data' onSubmit='return validatefields()'>
                <?php
                print( "<input name='profiletype' type='hidden' value='facility' />");
                print( "<input class='form_elements_text' type='hidden' id='fac_general_info_login_id' name='fac_general_info_login_id' />");
                $readonly = "readonly=true";
                print( "<table width='100%' cellspacing='1' cellpadding='1'>");
                if (real_check_user_groupid($db_conn, "admin") == true) {
                    print( "<tr>");
                    //print( "<td>&nbsp;<span class='form_elements_text'><B>Owner Name *</B></span></td>");
                    print( "<td>&nbsp;<span class='form_elements_text'><B>Owner Login ID *</B></span></td>");
                    print( "<td>&nbsp;<input class='form_elements_edit' type='text' id='fac_general_info_login_name' name='fac_general_info_login_name' size='30' maxlength='255' value=''> ");
                    print( "&nbsp;&nbsp;<!--script language=\"JavaScript\" type=\"text/javascript\">");
                    print( "createFindProfileRow('new_facility_find', 'ppl', 'new_facility_enter_info', 0, 1, 'dir' );");
                    print( "</script-->");
                    print( "</td>");
                    print( "</tr>");
                }

                print( "<tr>");
                print( "<td>&nbsp;<span class='form_elements_text'><B>Facility Title</B></span></td>");
                print( "<td>&nbsp;<input class='form_elements_text' type='text' " .
                    "name='fac_general_info_title' size='100' maxlength='255'> </td>");
                print( "</tr>");

                print( "<tr>");
                print( "<td>&nbsp;<span class='form_elements_text'><B>Facility Abstract</B></span></td>");
                print( "<td>&nbsp;<textarea name='abstract' cols='100' rows='10' class='form_elements_text'>" . "</textarea>" .
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
                function new_facility_enter_info( boxname, results )
                {
                    if( results.length > 0 )
                    {
                        document.getElementById( 'fac_general_info_login_name' ).value = results[0][0];
                        document.getElementById( 'fac_general_info_login_id' ).value = results[0][3];
                    }
                    cancelFindProfile( boxname );
                }
            </script>


            <div id='ppl_general_info_rank_box' style='display:none;z-index:100' onSelectStart='return false'>
                <div id='ppl_general_info_rank_header' >
                    <span id='ppl_general_info_rank_caption' >
                        Edit Rank
                    </span>
                    <span id='ppl_general_info_rank_close' >
                        <img src='images/buttons/close.gif' onClick='hide_popup("ppl_general_info_rank")'>
                    </span>
                </div>
                <div id='ppl_general_info_rank_content' >
                    <iframe id='ppl_general_info_rank_frame'></iframe>
                </div>
            </div>
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
