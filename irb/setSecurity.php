<html><head><title>IRB Application</title></head> 
 
 <?php require_once('Connections/dbc.php'); ?>

<?php
 session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "IRB Staff")) {   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

//if the login form is submitted
if (isset($_POST['submit'])) { // if form has been submitted

//This makes sure they did not leave any fields blank
if (!$_POST['SecurityCode'] | !$_POST['SecurityCode'] | !$_POST['SecurityCodeNew'] ) {
die('You did not complete all of the required fields');
}

$sql="select security where ID = '".$_POST[SecurityID]."' AND SecurityCode = '".$_POST['SecurityCode']."'";

$check = mysql_query($sql,$con);
  
$check2 = mysql_num_rows($check);
if ($check2 != 0)
{
mysql_query("UPDATE security SET SecurityCode = '".$POST['SecurityCodeNew']."' WHERE ID = '". $POST['SecurityID']. "'", $con); 

echo "Security Code changed";
}
else
{
echo "You are not authorized to change the security code.";
}
}
else //form not submitted
{
?>

<style type="text/css">
<!--
.style4 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 40px;
	color: #333399;
}
.style5 {
	color: #333399;
	font-style: italic;
	font-weight: bold;
}
.style6 {
	font-family: Arial, Helvetica, sans-serif;
	color: #333399;
	font-weight: bold;
}
.style7 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #4d3319;
}
a.navbar:link {
	color: #4d3319;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
}
a.navbar:visited {
	color: #4d3319;
	text-decoration: none;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
a.navbar:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	text-decoration: underline;
}
a.body:link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #336699;
	text-decoration: underline;
}
a.body:visited {
	font-family: Arial, Helvetica, sans-serif;
	color: #4D3319;
	text-decoration: underline;
}

a.irb:link{
font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;

}
a.irb:visited {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;
}
-->
  </style>
  <style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style21 {
	color: #000066;
	font-size: 16px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style37 {
	color: #FFFFFF;
	font-weight: bold;
}
.style44 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style45 {font-size: small}
.style46 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
-->
  </style>
<body>
<table width="800" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" >
<!--DWLayoutTable--> 
<tbody>
    <tr>
      <td height="150" valign="top" width="800">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<!--DWLayoutTable--> 
<tbody>
          <tr>
            <td valign="top" bgcolor="#330000"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a></td>
            <td width="99" valign="top" bgcolor="#330000" class="style4"><br>            </td>
            <td bgcolor="#330000">
              <div class="style7" align="right"><a href="LogOut.php" class="style14 style16">Log
Out</a></div></td>
          </tr>
         
          <tr>
            <td colspan="4" height="21" valign="top">
            <div align="center">
              <p>&nbsp;</p>
              <p><a class="irb" href="index.php"><span class="style21"><strong>Institutional Review Board</strong></span><span class="style17"></a>              </p>
              <p class="style6">Online Application<hr></p>
              </div>            </td>
          </tr>
          <tr>
            <td colspan="4" valign="top"><div align="center" class="style7"><strong><a class="irb" href="irb_listApp.php" >Retrive Applications </a>| <a class="irb" href="listReviewers.php" >List All Reviewers </a>| <a class="irb" href="listApplicants.php" >List All Applicants</a> | <a class="irb" href="update_irb_userInfo.php" >Update Personal Information </a>| <a class="irb" href="osp_irb_home.php" >IRB Home </a></strong></div></td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
    <tr><td>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"> 
<table border="0"> 
<tr><td colspan=2><h1>Set Security Code for OSP - IRB Administrator </h1></td></tr> 
<tr><td>Security ID:</td><td> 
<input type="text" name="SecurityID" maxlength="40"> 
</td></tr> 
<tr><td>Old Security Code:</td><td> 
<input type="text" name="SecurityCode" maxlength="50"> 
</td></tr> 
<tr><td>New Security Code:</td><td> 
<input type="text" name="SecurityCodeNew" maxlength="50"> 
</td></tr>
<tr><td colspan="2" align="center"> 
<input type="submit" name="submit" value="submit"> 
</td></tr> 
</table> 
</form> </td></tr></table>
<?php 
 }

mysql_close($con);
?>