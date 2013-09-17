<?php  
include 'utils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$query = "SELECT lname, fname, email_id, phone_no, DATE_FORMAT( datetime, ' %r %a, %e %b %Y') as datetime  FROM gen_login_info WHERE login_id = " . real_mysql_specialchars( $_SESSION['UID'], false ) ;
$results = real_execute_query( $query, $db_conn );
if( mysql_num_rows( $results ) > 0 ) {
    $rows = mysql_fetch_array( $results );
    $lname = $rows["lname"];
    $fname = $rows["fname"];
    $email_id = $rows["email_id"];
    $phone_no = $rows["phone_no"];
    $datetime = $rows["datetime"];
    $_SESSION["UFNAME"] = $fname;
    $_SESSION["ULNAME"] = $lname;
    $_SESSION["UEMAIL"] = $email_id;
}

$query = "SELECT pri_designation FROM ppl_general_info WHERE login_id=" . real_mysql_specialchars( $_SESSION['UID'], false );
$results = real_execute_query( $query, $db_conn );
if( mysql_num_rows( $results ) > 0 ) {
    $rows = mysql_fetch_array( $results );
    $rankdept = $rows["pri_designation"];
}

$profile_exists = false;

$query = "SELECT pid FROM gen_profile_info WHERE type_id=1 AND owner_login_id=".$_SESSION['UID'];
$results = real_execute_query($query, $db_conn);
while( $rows = mysql_fetch_array( $results ) ) {
    $profile_exists = true;
}

$view = $_GET['view'];

?>
<?php
include 'includes/txstate/page-top.html';
?>
<tr>
    <td style="background-color:#480000;color:#CCCCCC;" height="10px"><span style="margin-top:2px;margin-left:10px;font-family:times,san-serif;font-weight:bold;font-size:16px">User Account Information</span></td>
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
<script language="JavaScript" type="text/JavaScript">
    <!--
    function MM_findObj(n, d) { //v4.01
        var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
        if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
        for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
        if(!x && d.getElementById) x=d.getElementById(n); return x;
    }

    function MM_validateForm() { //v4.0
        var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
        for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
            if (val) { nm=val.name; if ((val=val.value)!="") {
                    if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
                        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
                    } else if (test!='R') { num = parseFloat(val);
                        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
                        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
                            min=test.substring(8,p); max=test.substring(p+1);
                            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
                        } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
        }
        if (document.getElementById("tnc").checked != true)
            errors += '- You must agree to the terms & conditions before proceeding.\n' ;
        if (errors) alert('The following error(s) occurred:\n'+errors);
        document.MM_returnValue = (errors == '');
    }

    function ChangeRank( rank, hid_list, type )
    {
        if( type == 'Other' )
        {
            hide_popup( "ppl_general_info_rank" );
            document.ppl_general_info_edit_form.ppl_general_info_designation.value=rank;
            document.ppl_general_info_edit_form.ppl_general_info_rank_changed.value='1';
            document.ppl_general_info_edit_form.ppl_general_info_hid_list.value=hid_list;
        }
        else
        {
            hide_popup( "ppl_general_info_pri_rank" );
            document.getElementById("rankdept").value = rank;
            //document.ppl_general_info_edit_form.ppl_general_info_pri_designation.value=rank;
            //document.ppl_general_info_edit_form.ppl_general_info_pri_rank_changed.value='1';
            //document.ppl_general_info_edit_form.ppl_general_info_pri_hid.value=hid_list;
        }
    }
    function CancelChangeRank( type )
    {
        if( type == 'Other' )
            hide_popup( "ppl_general_info_rank" );
        else
            hide_popup( "ppl_general_info_pri_rank" );
    }
    //-->
</script>
<link href="styles/style1.css" rel="stylesheet" type="text/css" />
<link href="styles/list.css" rel="stylesheet" type="text/css" />
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

    window.onload=function()
    {
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
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <div align="center">
                <form name="frmFirstLogin" method="post" action="f_submitlogin.php?view=<?php print($view); ?>">
                    <p class="font_topic">User Account Information </p>
		Last Modified Date: <?php print( $datetime ); ?>
                    <table width="46%"  border="0" cellpadding="0" cellspacing="2" class="table_content">
                        <tr>
                            <td width="31%" class="form_elements">&nbsp;</td>
                            <td width="69%">&nbsp; </td>
                        </tr>
                        <tr >
                            <td class="form_elements" align='left'>First Name:</td>
                            <td class="details" align='left'>
                                <input name="fname" type="text" class="form_elements" id="fname" maxlength='255' size="30" value="<?php print htmlspecialchars( $fname, ENT_QUOTES );?>"/>
                            </td>
                        </tr>
                        <tr >
                            <td class="form_elements" align='left'>Last Name:</td>
                            <td class="details" align='left'>
                                <input name="lname" type="text" class="form_elements" id="lname" maxlength='255' size="30" value="<?php print htmlspecialchars( $lname, ENT_QUOTES );?>"/>
                            </td>
                        </tr>
                        <tr >
                            <td class="form_elements" align='left'>Email Address:</td>
                            <td class="details" align='left'>
                                <input name="email" type="text" class="form_elements" id="email" maxlength='255' size="30" value="<?php print htmlspecialchars( $email_id, ENT_QUOTES );?>"/>
                            </td>
                        </tr>
                        <tr >
                            <td class="form_elements" align='left'>Phone Number:</td>
                            <td  align='left'>
                                <input name="phone" type="text" class="form_elements" id="phone" maxlength="32" size='15' value="<?php print htmlspecialchars( $phone_no, ENT_QUOTES );?>"/>
                            </td>
                        </tr>
                        <tr >
                            <td class="form_elements" align='left'>Primary Rank & Dept:</td>
                            <td  align='left'>
                                <input name="rankdept" type="text" class="form_elements" readonly="true" id="rankdept" maxlength="64" size='30' value="<?php print htmlspecialchars( $rankdept, ENT_QUOTES );?>"/>
                                <a onmouseover='style.cursor="pointer";style.cursor="hand"' style='text-decoration:none'
                                   onclick='show_popup("ppl_general_info_pri_rank", "sections/ppl_general_info_rank_edit.php?&type=Primary",450,650)'>
                                    <img border='0' src='images/buttons/edit.gif'><span class='form_elements_text'>Edit</span></a>
                            </td>
                        </tr>
                        <?php/*
                        if ($profile_exists == false) {
                            echo '<tr><td colspan="2" valign="middle">';
                            echo '<input type="checkbox" value="1" id="autoprofile" name="autoprofile" /> Check this if you are faculty and want your profile to be created automatically.</td></tr>';
                        }
                        */?>
                        <!--tr >
                            <td class="form_elements" align='left'>Department:</td>
                            <td  align='left'>
                                <input name="dept" type="text" class="form_elements" id="dept" maxlength="32" size='30' value="<?php print htmlspecialchars( $dept, ENT_QUOTES );?>"/>
                            </td>
                        </tr-->
                        <tr>
                            <td colspan="2">
                                <input type="checkbox" id="tnc" onclick='document.getElementById("submit1").disabled = !document.getElementById("tnc").checked' /> I agree to the <a href="privacypolicy.php">Privacy Policy</a>.
                                <br />
                                By logging in and using reSearch Profiles service you agree to comply with the all university <a href="http://oit.uta.edu/oit/qa/policies/index.php">"Computer Usage Policies"</a>
                                <br /><br />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><div align="center">
                                    <input id="submit1" disabled name="Submit" type="submit" class="table_background_other" onclick="MM_validateForm('lname','','R','fname','','R','email','','RisEmail');return document.MM_returnValue" value="Submit and Proceed to My Profiles" />
                                </div></td>
                        </tr>
                    </table>
                </form>
                <br />
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
    <tr>
        <td bgcolor="#D7CFCD" class="form_elements_row_action"> <div align="center"><span class="error_message">Important Disclaimer: </span><strong>The responsibility for the accuracy of the information contained on these pages lies with the authors and user providing such information. </strong></div></td>
    </tr>
</table>
</body>
</html>