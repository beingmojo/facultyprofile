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
.style45 {
	font-size: 18px;
	font-weight: bold;
	color: #FF0000;
}
.style46 {font-size: medium}
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
    <td height="70" colspan="2" ><div align="center" class="style44">APPLICANT - <?php echo $_SESSION['name']; ?></div></td>
    <tr>
    <td colspan="2" ><div align="center">
         <p class="style45">STOP!</p>
         

         <blockquote>
           <p align="left" class="style21 style46"> If you have submitted an IRB exemption request for this same project, DO NOT proceed with an regular IRB application. <a href="LogOut.php">Exit Here</a> </p>
           <p align="left" class="style21 style46">Otherwise,<a href="irbform.php"> click here</a> to continue. </p>
         </blockquote>
         <p align="center" class="style21 style46">&nbsp;</p>
      </div>
      <p align="center" class="style21 style46" >&nbsp;</p>
      <p class="style46">&nbsp;</p>
      <p align="center" class="style21">&nbsp;</p></td>
    <tr><td colspan="2" height="70"><div align="center">
    
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


