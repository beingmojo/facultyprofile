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
.style42 {color: #FFFFFF}
.style43 {font-size: large}
.style44 {
	font-size: medium;
	font-weight: normal;
}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="-1" bgcolor="#ffffff" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left" class="style6 style24"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </a></p>
           
            </p>
            </span></td>
 
  </tr><tr><td colspan="2"><div align="right"><a href="LogOut.php" class="style42">Log Out</a></div></td></tr>
</tbody></table> 
<table width="800" height="450" border="1" cellpadding="0" cellspacing="-1" align="center" bgcolor="#ffffff" bordercolorlight="#999999">
  
  <tr>
    <td height="70" colspan="2" ><div align="center" class="style44">APPLICANT HOME - <?php echo $_SESSION['name']; ?></div></td>
    <tr>
    <td height="70" ><div align="center"><a class="homemenu" href="applicant_reaffirm.php" title="IRB Application">Start a Regular IRB Application </a></div></td>
    <td><div align="center"><a href="applicant_app.php" class="homemenu">IRB Applications Submitted by <?php echo $_SESSION['name']; ?></a>
	<?php if ($_SESSION["User_Type"] != "student"){?>
	<p><hr>
	
	
	<a href="list_student_app.php" class="homemenu">Applications Submitted by <?php echo $_SESSION['name']; ?>'s Student(s)
	</a></p>
	<?php } ?>
	</div></td>
  <tr>
    <td height="70" ><div align="center">
      <div align="center"><a class="homemenu" href="exemption/irb_exemption.php">Request for IRB Exemption</a></div>
    </div></td>
    <td><div align="center">
      <p align="center" class="style21"><a href="exemption/irb_listExpApp_app.php" class="homemenu">IRB Exemption Application Submitted</a></p>
      </div></td>
  <tr>
    <td width="400" height="70" ><p align="center" class="style21" ><a href="continuation/irb_continuation_change_form.php" class="homemenu">Application for IRB Continuation/Change</a></p>
      <p>&nbsp;</p></td>
  
 <td width="400">
   <p align="center" class="style21"><a href="continuation/irb_listContinuation_app.php" class="homemenu">IRB Continuation/Change Applications Submitted </a></p>   </td>
  <tr><td colspan="2" height="70"><div align="center">
    <p><a class="homemenu" href="update_userInfo.php">Update Personal Information</a></p>
    </div>      
  <div align="center"></div></td>
  </tr></table>
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


