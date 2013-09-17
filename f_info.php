<?php
session_start();
include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "User Account Information";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/f_info.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-script1'] = "<script language='JavaScript' type='text/javascript' src='scripts/section_and_menu.js'></script>";
$_POST['page-script2'] = "<script language='JavaScript' type='text/javascript' src='scripts/findprofile.js'></script>";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
include_once 'util/ldap_util.php';

$ldap_info = $_SESSION['USER_LDAP_INFO'];
$title = $ldap_info[$rps_ldap_attribute_title];
$dept = $ldap_info[$rps_ldap_attribute_dept];
$fname = $ldap_info[$rps_ldap_attribute_f_name];
$mname = $ldap_info[$rps_ldap_attribute_m_name];
$lname = $ldap_info[$rps_ldap_attribute_l_name];
$email_id = $ldap_info[$rps_ldap_attribute_email];
$phone_no = $ldap_info[$rps_ldap_attribute_phone];
$fax = $ldap_info[$rps_ldap_attribute_fax];
$office = $ldap_info[$rps_ldap_attribute_office];
$street = $ldap_info[$rps_ldap_attribute_street];
$city = $ldap_info[$rps_ldap_attribute_city];
$state = $ldap_info[$rps_ldap_attribute_state];
$zip = $ldap_info[$rps_ldap_attribute_zip];
$_SESSION["UFNAME"] = $fname;
$_SESSION["ULNAME"] = $lname;
$_SESSION["UEMAIL"] = $email_id;

$query = "SELECT DATE_FORMAT( last_datetime, ' %r %a, %e %b %Y') as datetime  FROM gen_login_info WHERE login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$results = real_execute_query($query, $db_conn);
if (mysql_num_rows($results) > 0) {
    $rows = mysql_fetch_array($results);
    $datetime = $rows["datetime"];
}

$view = $_GET['view'];

$query = "SELECT r_int from txst_fac_profl where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $r_int = mysql_result($result, 0);
}
$query = "SELECT url_1, keywords from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $website = mysql_result($result, 0, 0);
    $keywords = mysql_result($result, 0, 1);
}

$query = "SELECT zipcode from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $zip = mysql_result($result, 0);
    
}
$query = "SELECT title from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $title = mysql_result($result, 0);

}
$query = "SELECT f_name from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $fname = mysql_result($result, 0);

}
$query = "SELECT m_name from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $mname = mysql_result($result, 0);

}
$query = "SELECT l_name from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $lname = mysql_result($result, 0);

}
$query = "SELECT email_id from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $email_id = mysql_result($result, 0);

}
$query = "SELECT phone_no_1 from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $phone_no = mysql_result($result, 0);

}
$query = "SELECT fax_no from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $fax = mysql_result($result, 0);

}
$query = "SELECT office_location from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $office = mysql_result($result, 0);

}
$query = "SELECT address_1 from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $street = mysql_result($result, 0);

}
$query = "SELECT city  from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $city  = mysql_result($result, 0);

}
$query = "SELECT state from ppl_general_info where login_id = " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $state = mysql_result($result, 0);

}
$query = "SELECT a.dept  FROM db_user_info a, ppl_general_info b where a.login_id=b.login_id  and b.login_id= " . real_mysql_specialchars($_SESSION['UID'], false);
$result = real_execute_query($query, $db_conn);
if (mysql_num_rows($result) > 0) {
    $dept = mysql_result($result, 0);

}
?>

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
    -->
</script>
<script type="text/javascript">
    <!--
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
    window.onload=function() {
        startList();
    }
    -->
</script>
<table width="100%" border="0">
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <div align="center">
                <form name="frmFirstLogin" method="post" action="f_submit_info.php?view=<?php print($view);?>" enctype='multipart/form-data'>
                    <p class="font_topic">User Account Information</p>
                    Last Modified Date: <?php print( $datetime);?>
                    <table width="50%" border="0" cellpadding="0" cellspacing="0" class="table_content">
                        <tr>
                            <td width="25%" class="form_elements">&nbsp;</td>
                            <td width="75%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="form_elements3" align='left'>
                                Section I... <br />
                                (<i>This data is generated from the Texas State HR Records</i>)
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td class="form_elements" align='left'>Title:</td>
                            <td class="details" align='left'>
                                <input name="title"  type="text" class="form_elements" id="title" maxlength='255' size="80" value="<?php print htmlspecialchars($title, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>Department:</td>
                            <td class="details" align='left'>
                                <input name="dept"  type="text" class="form_elements" id="dept" maxlength='255' size="80" value="<?php print htmlspecialchars($dept, ENT_QUOTES);?>"/>
                                <!--<input name="title_dept" type="hidden" id="title_dept" maxlength='255' value="<?php print htmlspecialchars($title, ENT_QUOTES) . "-" . htmlspecialchars($dept, ENT_QUOTES);?>"/>-->
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>First Name:</td>
                            <td class="details" align='left'>
                                <input name="fname"  type="text" class="form_elements" id="fname" maxlength='255' size="80" value="<?php print htmlspecialchars($fname, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>Middle Name / Initial:</td>
                            <td class="details" align='left'>
                                <input name="mname"  type="text" class="form_elements" id="mname" maxlength='255' size="80" value="<?php print htmlspecialchars($mname, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>Last Name:</td>
                            <td class="details" align='left'>
                                <input name="lname"  type="text" class="form_elements" id="lname" maxlength='255' size="80" value="<?php print htmlspecialchars($lname, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>Email Address:</td>
                            <td class="details" align='left'>
                                <input name="email"  type="text" class="form_elements" id="email" maxlength='255' size="80" value="<?php print htmlspecialchars($email_id, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>Phone Number:</td>
                            <td  align='left'>
                                <input name="phone" type="text" class="form_elements" id="phone" maxlength="32" size='80' value="<?php print htmlspecialchars($phone_no, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>Fax:</td>
                            <td class="details" align='left'>
                                <input name="fax"  type="text" class="form_elements" id="fax" maxlength='32' size="80" value="<?php print htmlspecialchars($fax, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>Office:</td>
                            <td class="details" align='left'>
                                <input name="office"  type="text" class="form_elements" id="office" maxlength='255' size="80" value="<?php print htmlspecialchars($office, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>Street:</td>
                            <td class="details" align='left'>
                                <input name="street"  type="text" class="form_elements" id="street" maxlength='255' size="80" value="<?php print htmlspecialchars($street, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>City:</td>
                            <td class="details" align='left'>
                                <input name="city"  type="text" class="form_elements" id="city" maxlength='32' size="80" value="<?php print htmlspecialchars($city, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>State:</td>
                            <td class="details" align='left'>
                                <input name="state"  type="text" class="form_elements" id="state" maxlength='255' size="80" value="<?php print htmlspecialchars($state, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements" align='left'>Zip:</td>
                            <td class="details" align='left'>
                                <input name="zip"  type="text" class="form_elements" id="zip" maxlength='16' size="80" value="<?php print htmlspecialchars($zip, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr><td colspan='2'><hr></td></tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr><td colspan="2" class="form_elements3" align='left'>Section II...</td></tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td class="form_elements3" align='left'>Website:</td>
                            <td class="details" align='left'>
                                <input name="website" type="text" class="form_elements2" id="website" maxlength='255' size="80" value="<?php print htmlspecialchars($website, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements3" align='left'>Keywords:</td>
                            <td class="details" align='left'>
                                <input name="keywords" type="text" class="form_elements2" id="keywords" maxlength='255' size="80" value="<?php print htmlspecialchars($keywords, ENT_QUOTES);?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="form_elements3" align='left'>Research Interests:</td>
                            <td class="details" align='left'>
                                <textarea rows="2" cols="77" name="r_int" class="form_elements2" id="r_int"><?php print htmlspecialchars($r_int, ENT_QUOTES);?></textarea>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr><td colspan="2" class="form_elements" align='left' style="font-size: 10px">Image Types: GIF, JPEG, and PNG &nbsp; . &nbsp; Max Image Size: 100KB</td></tr>
                        <tr>
                            <td class="form_elements3" align='left'>Profile Picture:</td>
                            <td class="details" align='left'>
                                <input type='hidden' name='MAX_IMAGE_FILE_SIZE' value='102400' />
                                <input name="image" type="file" class="form_elements2" id="image" size="80"/>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <!--tr><td colspan="2" class="form_elements" align='left' style="font-size: 10px">File Types: PDF, DOC, and DOCX &nbsp; . &nbsp; Max File Size: 1MB</td></tr-->
                        <tr>
                            <!--td class="form_elements3" align='left'>Curriculum Vitae:</td>
                            <td class="details" align='left'>
                                <input type='hidden' name='MAX_CV_FILE_SIZE' value='1024000' /-->
                                <input name="c_v" type="hidden" class="form_elements2" id="c_v" size="80"/>
                            <!--/td-->
                        </tr>
                        <tr>
                            <!--td class="form_elements3" align='left'>Publications:</td>
                            <td class="details" align='left'>
                                <input type='hidden' name='MAX_PUBLICATIONS_FILE_SIZE' value='1024000' /-->
                                <input name="publc" type="hidden" class="form_elements2" id="publc" size="80"/>
                            <!--/td-->
                        </tr>
                        <tr>
                            <!--td class="form_elements3" align='left'>Funding History:</td>
                            <td class="details" align='left'>
                                <input type='hidden' name='MAX_FUNDING_HISTORY_FILE_SIZE' value='1024000' /-->
                                <input name="f_hist" type="hidden" class="form_elements2" id="f_hist" size="80"/>
                            <!--/td-->
                        </tr>
                        <tr>
                            <!--td class="form_elements3" align='left'>Patents:</td>
                            <td class="details" align='left'>
                                <input type='hidden' name='MAX_PATENTS_FILE_SIZE' value='1024000' /-->
                                <input name="patents" type="hidden" class="form_elements2" id="patents" size="80"/>
                            <!--/td-->
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td colspan="2">
                                By logging in and using Research Profile System, (RPS), you agree to comply with the university <a href="http://www.txstate.edu">"Computer Usage Policies"</a>
                                <br /><br />
                                <input type="checkbox" id="tnc" onclick='document.getElementById("submit1").disabled = !document.getElementById("tnc").checked' /> I agree to the <a href="privacypolicy.php">Privacy Policy</a>.
                                <br /><br />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div align="center">
                                    <input id="submit1" disabled name="Submit" type="submit" class="table_background_other" onclick="MM_validateForm('lname','','R','fname','','R','email','','RisEmail');return document.MM_returnValue" value="Submit and Proceed to My Profiles" />
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
                <br />
            </div>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td bgcolor="#D7CFCD" class="form_elements_row_action"> <div align="center"><span class="error_message">Important Disclaimer: </span><strong>The responsibility for the accuracy of the information contained on these pages lies with the authors and user providing such information. </strong></div></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr><!-- Page footer -->
        <td align="center">
            <p align="center"><img src="images/line.jpg" alt="" width="700" height="1"/></p>
            <p>
                <a href="http://www.uta.edu/research/collaborate/" target="_blank" class="rsp">powering - The Partnership</a><br />
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>