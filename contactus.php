<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "Research Profiles - Feedback Form";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
?>

<script type="text/javascript">
    <!--
    function getCheckedValue(radioObj) {
        if(!radioObj)
            return "";
        var radioLength = radioObj.length;
        if(radioLength == undefined)
            if(radioObj.checked)
                return radioObj.value;
				
        else
            return "";
        for(var i = 0; i < radioLength; i++) {
            if(radioObj[i].checked) {
                return radioObj[i].value;
            }
        }
        return "";
    }
    // set
    function xmlhttpPost(strURL)
    {
        var xmlHttpReq = false;
        var self = this;
        // Mozilla/Safari
        if (window.XMLHttpRequest)
        {
            self.xmlHttpReq = new XMLHttpRequest();
        }
        // IE
        else
            if (window.ActiveXObject)
        {
            self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var word = document.getElementById('comments').value;
        word = '?message='+word;
        var role = getCheckedValue(document.forms['frmFeedback'].elements['role']);
        word = word+'&role='+role;
        var name = document.getElementById('fullname').value;
        word = word+'&name='+name;
        var email = document.getElementById('email').value;
        word = word+'&email='+email;
        strURL = strURL+word;
        self.xmlHttpReq.open('POST', strURL, true);
        self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        self.xmlHttpReq.onreadystatechange = function()
        {
            if (self.xmlHttpReq.readyState == 4)
            {
                updatepage(self.xmlHttpReq.responseText);
            }
        }
        self.xmlHttpReq.send(null);
        // Add temporary feedback that the request has been sent
        //   var loadingImg = document.createElement('img');
        //   loadingImg.src = 'images/working.gif';
        //   loadingImg.class = 'replace';
        //   document.getElementsByTagName('feedback')[0].appendChild(loadingImg);
    }

    function updatepage(str){
        /*
          var loadingImg = frmFeedback.getElementsByTagName('img');
          alert(loadingImg);
      var feedbackText = str;
          alert(str);
      var feedbackSpan = document.createElement('span');
      feedbackSpan.className = 'form_elements_section_subheader';
      feedbackSpan.appendChild(document.createTextNode(feedbackText));
      loadingImg.parentNode.replaceChild(feedbackSpan, loadingImg);
         */
        document.getElementById("comments").value=null;
        document.getElementById("result").innerHTML = str;
    }
    //-->
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <div align="center">
                <div class="font_topic">
                    <div align="left">
                        <blockquote>
                            <blockquote>
                                <blockquote>
							Website Feedback
                                </blockquote>
                            </blockquote>
                        </blockquote>
                    </div>
                </div>
                <form name="frmFeedback">
                    <table width="70%"  border="0" cellpadding="2" cellspacing="0" class="table_content">
                        <tr>
                            <td><div id="result" class="font_orange"></div></td>
                        </tr>
                        <tr>
                            <td class="form_elements_text"><div align="left" class="form_elements_section_subheader">Your Comments </div></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <textarea name="comments" cols="80" rows="10" class="form_elements" id="comments"></textarea>
                                </div>			</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><div align="left" class="form_elements_section_subheader">Your Role in using reSearch Profiles today  </div></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left" class="form_elements">
                                    <input name="role" id="role" type="radio" value="student" />
					Student				</div>			</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left" class="form_elements">
                                    <input name="role" id="role" type="radio" value="faculty" />
					Faculty				</div>			</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left" class="form_elements">
                                    <input name="role" id="role" type="radio" value="staff" />
					Staff				</div>			</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left" class="form_elements">
                                    <input name="role" id="role" type="radio" value="visitor" checked="checked" />
		            Visitor				</div>			</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><div align="left" class="form_elements_section_subheader">Your Name (optional) </div></td>
                        </tr>
                        <tr>
                            <td><div align="left">
                                    <input name="fullname" type="text" class="form_elements" id="fullname" size="40" />
                                </div></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><div align="left" class="form_elements_section_subheader">Your email (optional) </div></td>
                        </tr>
                        <tr>
                            <td>
                                <div align="left">
                                    <input name="email" type="text" class="form_elements" id="email" size="40" />
                                </div>			</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <div align="center">
                                  <input name="Submit" type="button" value="Submit Feedback" onclick='JavaScript:xmlhttpPost("sendfeedback.php")'/>
                                </div>			</td>
                        </tr>
                    </table>
                </form>
            </div>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="table_background">
            <!-- Partnership text in this section with the hyperlink should remain visible on the template page and should not deleted -->
            <div align="right"><a href="http://www.txstate.edu/research/" target="_blank"><span class="font_on_dark_blue"><strong>powering - The Partnership</strong></span></a></div>
            <!-- End of Partnership text -->
        </td>
    </tr>
    <!-- footer content goes here -->
    <tr>
        <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy; 2010 Texas State University - San Marcos| <a href="http://www.txstate.edu/research">Electronic Research Administration</a>, 601 University Drive, San Marcos, Texas 78666 Voice: 512.245.211 |<a href="feedback.php">Site Feedback</a> | <a href="http://www.txstate.edu/research/oera.html">Contact Electronic Research Administration - Web Team</a><br />

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
<!-- InstanceEnd -->
</html>