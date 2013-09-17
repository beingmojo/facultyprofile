<?php
// *** Logout the current user.
$logoutGoTo = "index.php";
session_start();
unset($_SESSION['username']);
unset($_SESSION['User_Type']);
unset($_SESSION['Email']);
unset($_SESSION['name']);
unset($_SESSION['myhome']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
session_unregister('username');
session_unregister('User_Type');
session_unregister('Email');
session_unregister('name');
session_unregister('myhome');
exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>IRB Online Application</title>
<style type="text/css">
<!--
.style4 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
</head>


<body text="#000000">
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
</span>
<tr><td class="style3">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
 <tbody>
    <tr>
      <td height="150" valign="top" width="800">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tbody>
          <tr>
            <td valign="top" bgcolor="#330000"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a><br>  </td>
            <td bgcolor="#330000">
              <div class="style5" align="right"><font color="#336699"><br>
              </font></div></td>
            </tr>
          </tbody></table></td></tr><tr><td>
<h1 align="center" class="style4">Log Out in Progress </h1></td></tr></tbody></table>
</body>
</html>
