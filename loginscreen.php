<?php
session_start();
$_POST['page-title'] = "Login";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
include_once 'utils.php';
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
            <br />

            <div align="center">
                <form action="<?php echo $_home; ?>/f_login.php" method="post" enctype="application/x-www-form-urlencoded" name="login" id="login">
                    <p class="font_topic">User Login Page </p>
                    <table width="283" border="0"  align="center" cellpadding="5" cellspacing="6" class="table">
                        <tr  class="rsp" align="left">
                            <td width="119" class="rsp" align="right">
                               Net ID:</td>
                            <td width="129"><input name="uid" type="text" class="rsp" id="uid" size="15" /></td>
                            <td></td>
                        </tr>
                        <tr  class="rsp" align="left">
                            <td class="rsp" align="right">Password: </td>
                            <td><input name="passwd" type="password" class="rsp" id="passwd" size="15" />
                            </td>
                            <td>
                                <img class="rsp"  src="images/real/search_arrow.gif" style="cursor:pointer" alt="Search UT Arlington" align="bottom" width="12" height="18" onclick="document.login.submit();" /></td>
                    </table>
                </form>
                <script>
                    var qs = new Querystring()
                    var v1 = qs.get("view");
                    if (v1!=null)
                        document.login.action = "<?php echo $_home; ?>/f_login.php?view=" + v1;
                </script>
                <br /><br /><br />
                <table align="center" cellspacing="2">
                    <tr>
                        <td align="left" style="font-family: Arial, Helvetica, sans-serif; font-size: 9pt;">
	 	By logging in and using reSearch Profiles service you agree to comply with the all university <a style="font-family: Arial, Helvetica, sans-serif; font-size: 9pt;" href="http://www.txstate.edu/">Computer Usage Policies</a> and <a href="https://facultyprofile.txstate.edu/privacypolicy.php"
                        <?php echo $_SERVER['HTTP_HOST'] . $_home; ?>/privacypolicy.php" style="font-family: Arial, Helvetica, sans-serif; font-size: 9pt;">Privacy Policy</a>.
                            <br /><br />
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="font-family: Arial, Helvetica, sans-serif;">
                            <a href="https://catsweb.txstate.edu/app/auth?/app/password">[ Forgot Password ]</a> &nbsp;
                            <a href="https://facultyprofile.txstate.edu/help/#login<?php echo $_SERVER['HTTP_HOST'] . $_home; ?>/help/#login">[ Need More Help ] </a>
                            <br /><br />
                        </td>
                    <tr>
                        <td align="left"><!--b>For more information regarding NetId </b> <a href="http://oit.uta.edu/cs/accounts/student/netid/netid.html">click here</a-->
                        </td></tr>
                </table>
            </div>
        </td>
    </tr>

    <!-- InstanceEndEditable -->
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
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
