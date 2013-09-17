<?php require_once('Connections/con3.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}




/////////////////////////////////////////////////////////////////////


//echo $_SESSION['username']."<br>";

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
.style44 {
	font-size: medium;
	font-weight: bold;
}
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
   <tr><td colspan="2"><div align="right"><a href="LogOut.php"><font color="#FFFFFF">Log Out</font></a></div></td></tr>
</tbody></table>
<table width="800" border="1" cellspacing="-1" align="center" bgcolor="#ffffff">
  
  <tr>
    <td height="70" colspan="2" ><div align="center" class="style44">REVIEWER'S HOME - <?php echo $_SESSION['name']; ?></div></td>
    <tr>
    <td height="70" ><p align="center"><a href="reviewer_app.php" class="homemenu">IRB Applications Assigned to Evaluate </a></p>    </td>
    <td><div align="center"><a href="rev_listApp.php" class="homemenu">List All  IRB Applications</a></div></td>
  <tr>
    <td height="70" colspan="2" ><div align="center"><a href="MessageCenter.php" class="homemenu"></a> </div>      <div align="center"><a class="homemenu" href="update_userInfo.php">Update Personal Information</a></div></td>
  <tr>
    <td height="70" ><div align="center"><a class="homemenu" href="irbform.php" title="IRB Application">Start a New IRB Application </a></div></td>
    <td><div align="center"><a href="applicant_app.php" class="homemenu">IRB Applications You Submitted</a>
	<?php if ($_SESSION["User_Type"] != "student"){?>
	<p><hr>
	
	
	<a href="list_student_app.php" class="homemenu">Applications Submitted by Your Student(s)
	</a></p>
	<?php } ?></div></td>
  <tr>
    <td height="70" ><div align="center"><a href="continuation/irb_continuation_change_form.php" class="homemenu">Application for IRB Continuation/Change</a></div></td>
    <td><div align="center"><span class="style21"><a href="continuation/irb_listContinuation_app.php" class="homemenu">IRB Continuation/Change Applications Submitted </a></span></div></td>
  <tr>
    <td width="400" height="70" ><p align="center" class="style21" ><a class="homemenu" href="exemption/irb_exemption.php">Application for IRB Exemption</a></p>    </td>
  
 <td width="400">
   <p align="center" class="style21"><a href="exemption/irb_listExpApp_app.php" class="homemenu">IRB Exemption Applications Submitted </a></p>   </td>
</table>
<div align="center">
   <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td>&nbsp;</td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;">
	  <?php include("footer.php"); ?>
      </td>
    </tr>

</table></td>
  </tr></table>


