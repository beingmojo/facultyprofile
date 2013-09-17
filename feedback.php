<?php

session_start();
include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Feedback";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
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

    -->
</script>
<table width="100%" border="0">
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <div align="center">
                <form name="frmFeedback" action="sendfeedback.php" method="post">
                    <table width="70%"  border="0" cellpadding="2" cellspacing="0" class="table_content">
                        <tr>
                            <td><div id="result" class="form_elements_section_subheader"></div></td>
                        </tr>
                        <tr>
                            <td class="form_elements_text"><div align="left" class="form_elements_section_subheader"><label for="comments">Your Request</label></div></td>
                        </tr>
                        <tr>
                            <td class="form_elements_text">
                                <div align="left">
                                    <?php
                                    if (isset($_GET['comments'])) {
                                        echo htmlspecialchars($_GET['comments']);
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left" ><p style="color:red" >
                                        <textarea name="comments" cols="80" rows="10" class="form_elements" id="comments"><?php if(isset($_GET['rcomments'])) echo $_GET['rcomments'];?></textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><div align="left" class="form_elements_section_subheader"><label for="role">Your role in using RPS today</div></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left" class="form_elements">
                                    <input name="role" id="role_student" type="radio" value="student" <?php if(isset($_GET['role'])) /*if($_GET['role'] == 'student')*/ echo 'checked'; ?>/>
                                    <label for="role_student">Student</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left" class="form_elements">
                                    <input name="role" id="role_faculty" type="radio" value="faculty" <?php if(isset($_GET['role'])) if($_GET['role'] == 'faculty') echo 'checked'; ?>/>
                                    <label for="role_faculty">Faculty</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left" class="form_elements">
                                    <input name="role" id="role_staff" type="radio" value="staff" <?php if(isset($_GET['role'])) if($_GET['role'] == 'staff') echo 'checked'; ?>/>
                                    <label for="role_staff">Staff</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left" class="form_elements">
                                    <input name="role" id="role_visitor" type="radio" value="visitor" checked="checked" <?php if(isset($_GET['role'])) if($_GET['role'] == 'visitor') echo 'checked'; ?>/>
                                    <label for="role_visitor">Visitor</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><div align="left" class="form_elements_section_subheader"><label for="fullname">Your Name (optional)</label></div></td>
                        </tr>
                        <tr>
                            <td><div align="left">
                                    <input name="fullname" type="text" class="form_elements" id="fullname" size="40" <?php if(isset($_GET['fullname'])) echo "value='" . $_GET['fullname'] . "'"; ?>/>
                                </div></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><div align="left" class="form_elements_section_subheader"><label for="email">Your email (optional)</label></div></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <input name="email" type="text" class="form_elements" id="email" size="40" <?php if(isset($_GET['email'])) echo "value='" . $_GET['email'] . "'";?>/><br />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font_orange">we can not reply to questions unless an email address is provided</td>
                        </tr>
                        <?php if(isset($_GET['status'])){ ?>
                        <tr>
                            <td>
                                <label><font color="red">Incorrect code, please try again.</font></label>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td>
                                <img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
                                <input type="text" name="captcha_code" size="10" />
                                <a href="#" onclick="document.getElementById('captcha').src='/securimage/securimage_show.php?' + Math.random(); return false">[Different Image]</a>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="center">
                                    <input name="Submit" type="submit" value="Submit Feedback"/> &nbsp;
                                    <input type="button" name="back" value="Go Back" onclick="history.go(-1);return true;">
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
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
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>
