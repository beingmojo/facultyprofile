<?php require_once('Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "IRB Staff")) { 
  
 if (!($_SESSION['User_Type'] == "IRB Chair")){
  header("Location: ". $restrictGoTo); 
  exit;
  }
}
?>


<?php

$query_Recordset1 = "SELECT * FROM user where (User_Type <> 'IRB Staff' AND User_Type <> 'reviewer' AND User_Type <> 'IRB Chair') ORDER BY LastName";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<script>
function deleteConfirm(str)
{
if (confirm('Are you sure you want to remove this applicant permanently?')){
dirlocation="deleteApplicant.php?ID="+str;
document.location.href=dirlocation;
}
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos </title>
  <style type="text/css">
<!--
.style4 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 40px;
	color: #333399;
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
font-family: Arial, Helvetica, sans-serif;
	color: #336699;
	text-decoration: none;

}
a.irb:visited {
	font-family: Arial, Helvetica, sans-serif;
	color: #336699;
	text-decoration: none;
}
-->
  </style>
  <style type="text/css">
<!--
.style14 {
	color: #FFFFFF;
	font-weight: bold;
}
.style15 {
	font-size: small;
	font-weight: bold;
}
body {
	background-color: #cccccc;
}
.style16 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style18 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
-->
  </style>
</head>
<body><table width="800" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" ><tr><td>
<table width="800" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" >
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
          </tr><tr>
            <td colspan="4" height="21" valign="top">
            <div align="center">
              <p>&nbsp;</p>
              <p><a class="irb" href="index.php"><span class="style21"><strong>Institutional Review Board</strong></span></a>              </p>
              <p class="style6">Online Application
              <hr>
            </div></td>
          </tr>
          <tr>
            <td colspan="4" height="19" valign="top">
			  <div align="center"><span class="style18"><a class="irb" href="irb_listApp.php" >List IRB Applications </a>| <a class="irb" href="listReviewers.php" >List All Reviewers </a>| <a class="irb" href="listApplicants.php" >List All Applicants</a> | <a class="irb" href="osp_irb_home.php" >My IRB Home </a></span>
		        <hr></div></td>
          </tr>
  </tbody>
</table><table width="800" border="0" align="center">
   
    <tr>
      <td height="348" valign="top" bgcolor="#FFFFFF">
<table align="center">
  <tr><td colspan="3" class="style18"><h3 align="center" class="style16">IRB Applicants
    
  </h3>
  </tr><tr><td colspan="3" class="style18"><hr /></td></tr>
<?php do{ ?>
<tr><td width="194" class="style18" >Name:</td>
<td width="375" class="style18">

  <span class="style16"><?php echo $row_Recordset1['FirstName']; ?>&nbsp;<?php echo $row_Recordset1['LastName']; ?></span></td>
<td width="209" class="style18"><label>
  <input name="button" type='button' onClick="deleteConfirm('<?php echo $row_Recordset1['username']?>')" value='Remove Applicant'>
</label></td>
</tr><tr><td class="style18" >User Name:</td><td class="style18">
    <span class="style16"><?php echo $row_Recordset1['username']; ?></span></td>
  <td class="style18">&nbsp;</td>
</tr>
<tr><td class="style18" >Password:</td><td class="style18"><?php echo $row_Recordset1['password']; ?></td>
  <td class="style18">&nbsp;</td>
</tr>

<tr><td class="style18" >Phone:</td><td class="style18"><?php echo $row_Recordset1['Phone']; ?></td>
  <td class="style18">&nbsp;</td>
</tr>
<tr><td class="style18" >Email:</td><td class="style18"><?php echo $row_Recordset1['Email']; ?></td>
  <td class="style18">&nbsp;</td>
</tr>
<tr><td class="style18" >Department:</td><td class="style18"><?php echo $row_Recordset1['Department']; ?></td>
  <td class="style18">&nbsp;</td>
</tr>
<tr><td class="style18" >Applicant is a:</td><td class="style18"><?php echo $row_Recordset1['User_Type']; ?></td>
  <td class="style18">&nbsp;</td>
</tr>
<tr><td class="style18" >Major:</td><td class="style18"><?php echo $row_Recordset1['Major']; ?></td>
  <td class="style18">&nbsp;</td>
</tr>
<tr><td class="style18" >Rank:</td><td class="style18"><?php echo $row_Recordset1['Rank']; ?></td>
  <td class="style18">&nbsp;</td>
</tr>

<tr><td class="style18" >HSP Training:</td><td class="style18"><?php echo $row_Recordset1['Training']; ?></td>
  <td class="style18">&nbsp;</td>
</tr>

<tr><td colspan="3" class="style18"><hr /></td></tr>
<?php }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) 
?>
</table>
<div align="center" class="style18">Office of Sponsored Programs
    <br>
  For questions regarding application submission contact OSP at sn10@txstate.edu , x 2314</div></td>
    </tr></table></body>
</html>
<?php
mysql_free_result($Recordset1);
?>
