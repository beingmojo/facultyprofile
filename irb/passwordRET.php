<?php require_once('Connections/dbc.php'); 
require_once('variables/variables.php');
?>
<?php
$colname = "1";
if (isset($_POST['email'])) {
  $colname = (get_magic_quotes_gpc()) ? $_POST['email'] : addslashes($_POST['email']);


$query = sprintf("SELECT password, username FROM user WHERE Email = '%s'", $colname);
$pwd = mysql_query($query, $con) or die(mysql_error());
$row_pwd = mysql_fetch_assoc($pwd);
$totalRows = mysql_num_rows($pwd);

	$to = $_POST['email'];
//	$from = "From: ospinfo@txstate.edu";
	$body = "Username: " . $row_pwd['username'] . "\rPassword: " . $row_pwd['password'];
	  $body = $body.$emailSig;
    $enterMessage = "Enter the email address you used to register.  If you HAVE entered your email address in error, then we don't have any login information associated with the email address you provided.  Email ospirb@txstate.edu for your login information.";
if ($totalRows > 0) {
	$subject = "RE: Your IRB Online Application System Login Information";

	
	$enterMessage = "We found login information associated with your email address, " . $_POST['email'];
}    
?>
<?php 

 if (mail($to,$subject,$body, $headers)) {
$response = "Your login information has been sent.";
} else {
//$response = "We were not able to send your login information.  Please try again, or contact ospirb@txstate.edu.";
$response = "\r\n " . "Username: " . $row_pwd['username'] . "\r\nPassword: " . $row_pwd['password'];
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
<tbody>
   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left" class="style6 style24"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
            </p>
            </span></td>
   </tr>
          
       
        </tbody>
      </table>
      </td>
  </tr>
</tbody></table>
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff">
  <tr>
      <td colspan="4" bgcolor="#000000"><div align="center" class="style9"><span class="style15"><a class="irb" href="registration_applicant.php">IRB Applicant Registration </a> <span class="style42">|</span> <a class="irb" href="registration_Reviewer.php">IRB Reviewer Registration</a> <span class="style42">|</span> <a class="irb" href="registration_IRB.php">OSP IRB Administrator Registration</a> <br>
            <a class="irb" href="registration_chair.php">OSP IRB Chair Registration </a> <span class="style42">|</span> <a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42">|</span> <a class="irb" href="LogOut.php">Log Out</a></span>
         </div></td>
    </tr>    
      <th class="style6 style8" scope="row"><!--DWLayoutEmptyCell-->&nbsp;</th>
    </tr>
<tr><td>
  <form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
<table border="0" bgcolor="#ffffff"> 
<tr><td width="788"><h4 align="center"><span class="style6 style8">Retrieve Password </span></h4></td></tr> 
<tr><td><div align="left"><span class="style7">If you have forgotten your password, please enter the email address you used to register in the text box below. Your user name and password information will be e-mailed to that email address. </span></div>
<div align="center"></div></td>
</tr> <tr><td><font color="#CC0000"><?php echo $enterMessage; ?>  <br><?php echo $response ?></br></font></td></tr>
<tr><td><div align="center"><span class="style17"><hr>Email Address that you used at registration :
  </span>
      <input type="txt" name="email" maxlength="50"> 
      <input type="submit" name="submit" value="Get Password">
</div> 
  
    <div align="left">
      <input type="hidden" name="insert" maxlength="50" value="inserted">  
    </div></td></tr> 
<tr><td align="right"> 
  
    <div align="left"></div></td></tr> 
</table> 
</form> 


           
            <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td class="style6" scope="row" ><span class="style9 style13">                  If you don not have a username, use one of the  links abover to register </span></td>
                </tr>
				<tr>
      <td style="vertical-align: top; height: 60px;">
      <div align="center"><span class="style7"><br>
        <span class="style18"><hr>Office of Sponsored Programs <br>
For questions regarding application submission contact IRB at <a href="mailto:ospirb@txstate.edu">ospirb@txstate.edu</a> , x 7975</span></div>      </td>
    </tr>
              </tbody>
            </table>            </td>
          </tr>
        </tbody>
      </table>      
</td>
    </tr>
    
  </tbody>
</table>


</body>
</html>
