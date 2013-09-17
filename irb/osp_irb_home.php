<?php require_once('Connections/dbc.php'); ?>
<?php
// *** Validate request to login to this site.
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

if (!($_SESSION['User_Type'] == "IRB Support")) { 
if (!($_SESSION['User_Type'] == "IRB Staff")) { 
  
 if (!($_SESSION['User_Type'] == "IRB Chair")){
  header("Location: ". $restrictGoTo); 
  exit;
  }
}
}

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
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="tbbg.gif" >

   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left" class="style6 style24"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
            </p>
            </span></td>
 
  </tr><tr><td colspan="2"><div align="right"><a href="LogOut.php" class="style42">Log Out</a></div></td></tr>
</table>             
 <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
               
				<tr>
				  <td width="813" class="style14" scope="row">
				    <p>&nbsp;</p>
				    <p align="center"><strong>IRB ADMINISTRATOR/CHAIR</strong> - <span class="style6 style8 style23"><span class="style8  style26"><?php echo $_SESSION['name']; ?></span></span></p>
				    <table width="750" border="1" align="center" cellspacing="-2">
                      <tr>
                        <td width="300" height="70"><div align="center"><a class="homemenu" href="irb_listApp.php">List IRB Applications</a></div></td>
                        <td width="300"><div align="center"><a class="homemenu" href="deleteApplication.php" >Delete IRB Applications</a></div></td>
                      </tr>
                      <tr>
                        <td height="50"><div align="center"><a class="homemenu" href="exemption/irb_listExpApp.php" >List IRB Exemption Applications </a></div></td>
                        <td ><div align="center" ><a class="homemenu" href="exemption/deleteExpApplication.php" >Delete IRB Exemption Applications </a></span></div></td>
                      </tr>
                      <tr>
                        <td height="50"><div align="center"><a href="continuation/irb_listContinuation.php" class="homemenu">List Continuation/Change Applications</a></div></td>
                        <td><div align="center"><a href="continuation/deleteConApplication.php" class="homemenu">Delete Continuation/Change Applications</a></div></td>
                      </tr>
                      <tr>
                        <td height="50"><div align="center"><a href="listApplicants.php" class="homemenu">List All Users</a></div></td>
                        <td><div align="center"><a href="listReviewers.php" class="homemenu" >List All Reviewers</a></div></td>
                      </tr>
                      <tr>
                        <td height="50"><div align="center">
                          <p><a href="irb_report.php" class="homemenu">IRB Report</a><a href="irb_report.php"></a></p>
                          <p><a href="listnotelog.php" class="homemenu">Admin - Chair Notes </a> </p>
                        </div>                        </td>
                        <td height="50"><div align="center"><a href="update_irb_userInfo.php" class="homemenu">Update Personal Information</a></div></td>
                      </tr>
                        <tr><td height="50"><div align="center"><a href="setSecurity_reviewer.php" class="homemenu">Assign Security Code for IRB Reviewers to Register</a></div></td>
                          <td height="50"><div align="center"><a href="setSecurity_chair.php" class="homemenu">Assign Security Code for IRB Chairs to Register</a></div></td>
                        </tr>
						<?php if ($_SESSION['User_Type'] == "IRB Staff") { ?><?php }?>
                    </table>
				    <p>&nbsp;</p>			      </th>
				  </tr>
				
                  <tr><td><br><br>
                    <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;">
	  <?php include("footer.php"); ?>
      </td>
    </tr>

</table>
              </tr>
            
              </table>
              </td>
              </tr>
<tr>
      <td style="vertical-align: top; height: 60px;">
      <div align="center"><br>
      </div>
      </td>
</tr>

</table></td></tr></table>
</body>
</html>
