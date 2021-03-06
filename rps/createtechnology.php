
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
    <td style="background-color:#480000;color:#CCCCCC;" height="10px"><span style="margin-top:2px;margin-left:10px;font-family:times,san-serif;font-weight:bold;font-size:16px">Create New Technology Profile</span></td>
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
            <script type="text/javascript" language="javascript">
                function validatefields()
                {
                    if ( document.frmNewProfile.tech_general_info_title == "" )
                    {
                        alert( "Please enter a title for the Technology before proceeding." );
                        document.frmNewProfile.tech_general_info_title.focus();
                        return false;
                    }
                    return true;
                }
            </script>

            <form action="createnew.php" method="post" name="frmNewProfile" enctype='multipart/form-data' onSubmit='return validatefields()'>
                <?php
                print( "<input name='profiletype' type='hidden' value='technology' />" );
                $readonly = "readonly=true";
                print( "<table width='100%' cellspacing='1' cellpadding='1'>" );
                if( real_check_user_groupid( $db_conn, "tech_admin" ) == true ||
                        real_check_user_groupid( $db_conn, "admin" ) == true ) {
                    print( "<tr>" );
                    print( "<td>&nbsp;<span class='form_elements_text'><B>Owner Name</B></span></td>" );
                    print( "<td>&nbsp;".
                                    "<input class='form_elements_text' type='text' name='tech_general_info_login_name' ".
                                    "size='10' maxlength='15' value='Tech Admin' $readonly>" .
                                    "<input class='form_elements_text' type='hidden' name='tech_general_info_login_id' ".
                                    "size='10' maxlength='15' value='0000000007' $readonly> </td>" );
                    print( "</tr>" );
                }

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Title</B></span></td>" );
                print( "<td>&nbsp;<input class='form_elements_text' type='text' ".
                                "name='tech_general_info_title' size='100' maxlength='255'> </td>" );
                print( "</tr>" );

                print( "<tr>" );
                print( "<td>&nbsp;<span class='form_elements_text'><B>Abstract</B></span></td>" );
                print( "<td>&nbsp;<textarea name='abstract' cols='100' rows='10' class='form_elements_text'>"."</textarea>".
                                "</td>" );
                print( "</tr>" );



                print( "<tr><td colspan='2'><hr></td></tr>" );

                print( "<tr><td  colspan='2'>
	<input name='Submit' type='submit' class='form_elements' value='Create' style='margin-left:200px'/>
	<input name='cancel' type='button' class='form_elements' value='Cancel' onclick='location.href=\"researchspace.php?#createnew\"'/>
	</td></tr>" );
                ?>
            </form>

            <script type='text/javascript'>
                function ChangeRank( rank, hid_list )
                {
                    hide_popup( "ppl_general_info_rank" );
                    document.frmNewProfile.ppl_general_info_designation.value=rank;
                    document.frmNewProfile.ppl_general_info_rank_changed.value='1';
                    document.frmNewProfile.ppl_general_info_hid_list.value=hid_list;
                }

                function CancelChangeRank( )
                {
                    hide_popup( "ppl_general_info_rank" );
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
                &copy; 2006 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>
    