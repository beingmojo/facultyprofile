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

//if the login form is submitted
if (isset($_POST['submit'])) { // if form has been submitted


	if (!$_POST['ReviewerCode']) {
		die('You did not complete the required field');
	}
	else
	{
		mysql_query("UPDATE security SET SecurityCode = '".$_POST['ReviewerCode']."' where ID='reviewer_irb'"); 

	}

}

$query_Recordset1 = "SELECT * FROM security where ID='reviewer_irb'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="irbstyle.css" rel="stylesheet" type="text/css">


  <style type="text/css">
<!--
.style43 {font-size: large}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left" class="style6 style24"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           
            </p>
            </span></td>
   </tr>
</tbody></table></table>

<table width="800" border="0" align="center" bgcolor="#ffffff">
				
          <tr>
            <td height="19" valign="top" bgcolor="#000000">
			  <div align="center"><a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home </a> <span class="style39">|</span><span class="irb"><a class="irb" href="irb_listApp.php">List All IRB Applications</a> <span class="style39">|</span> <a class="irb" href="listReviewers.php" >List All Reviewers </a> <span class="style39">|</span> <a class="irb" href="listApplicants.php" >List All Users</a> <span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a></div></td>
          </tr>
  
  </tbody>
      </table>
    <table width="800" border="0" align="center" bgcolor="#ffffff">
	  <tr><td colspan="3"><div align="center">
    <tr><td>
	<?php if (isset($_POST['submit'])) { 
	
	echo "<font color='red'>Reviewers security code has changed.</red> The new code is: ".$_POST['ReviewerCode']."</font>";
	}
	?>
	
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
<div align="center"><table border="0"> 
<tr><td colspan=2><h5 align="center" class="style46"><br>Set Security Code for IRB Reviewers to Register </h5></td></tr> 
 
<tr><td><div align="center">Old Reivewer Security Code:</div></td><td> 
<input type="text" name="dumy" value="<?php echo $row_Recordset1['SecurityCode'];?>" maxlength="50" disabled="disabled"> 
</td></tr> 
<tr><td><div align="center">New Reviewer Security Code:</div></td><td> 
<input type="text" name="ReviewerCode" maxlength="50"> 
</td></tr>
<tr><td colspan="2" align="center"> 
  <div align="center">
    <input type="submit" name="submit" value="submit"> 
  </div></td></tr> 
</table> </div>
</form> </td></tr></table>
<?php 
mysql_free_result($Recordset1);
?>