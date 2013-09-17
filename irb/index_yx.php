<?php require_once('Connections/dbc.php'); ?>
<?php
session_start();


 function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

//if the login form is submitted
if (isset($_POST['submit'])) { 

// makes sure they filled it in
if(!$_POST['username'] || !$_POST['pass']) {
die("You did not fill in a required field.");

}
// checks it against the database
$username = (get_magic_quotes_gpc()) ? $_POST['username'] : addslashes($_POST['username']);

$query = sprintf("SELECT * FROM user WHERE username = '%s' ", $username);
//echo $query;
$check = mysql_query($query,$con) or die(mysql_error());
$info = mysql_fetch_assoc($check);
$check2 = mysql_num_rows($check);
//Gives error if user dosen't exist

if ($check2 == 0) {
die("The user does not exist in our database. <a href='index.php'>Click Here to Register</a>");
}


//gives error if the password is wrong
if ($_POST['pass'] != $info['password']) {
die("Incorrect password, please try again.");

}
else 
{ 

 $lastLogin = date("l dS \of F Y h:i:s A");

////////////////////////////////////////////////////
$_SESSION['User_Type']=$info['User_Type'];
$_SESSION['username']=$info['username'];
$_SESSION['Email']=$info['Email'];
$_SESSION['name']=$info['FirstName']." ".$info['LastName'];
$usertype = $info['User_Type'];

////////////////////////////////////
 $insertSQL = sprintf("UPDATE user SET lastLogin=%s WHERE username=%s", GetSQLValueString($lastLogin, "text"), GetSQLValueString($_SESSION['username'], "text"));

$Result1 = mysql_query($insertSQL, $con) or die(mysql_error()); 
 
 //////////////////////////////////

if($_POST['asApp']=="Yes"){
$_SESSION['myhome']="./applicant_home.php";
	header("Location: ./applicant_home.php");
	exit;
	}
elseif (($usertype == "IRB Staff") || ($usertype == "IRB Chair")){ 
	$_SESSION['myhome']="./osp_irb_home.php";
	header("Location: ./osp_irb_home.php");
	exit;
	}
 if ($usertype == "faculty/staff" || $usertype == "student")
	{
		$_SESSION['myhome']="./applicant_home.php";
		header("Location: ./applicant_home.php");
		
		exit;
	}
 if ($usertype == "reviewer")
	{
		$_SESSION['myhome']="./rev_home.php";
		header("Location: ./rev_home.php");
		exit;
	}

  if ($usertype == "IRB Support")
	{
		$_SESSION['myhome']="./osp_irb_home.php";
		header("Location: ./osp_irb_home.php");
		exit;
	}
//} //end while
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
      <a class="irb" href="registration_chair.php">OSP IRB Chair Registration </a> <span class="style42">|</span> <a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42">|</span> <a class="irb" href="LogOut.php">Log Out</a></span> <span class="style42">| </span><a href="http://www.txstate.edu/research/irb/" target="_blank" class="irb">IRB Web Site</a></div></td>
</tr>
    <tr>
      <td> <div align="left">
       <br> <p align="center"><strong>        <br>
        NOTE: </strong>ALL FIRST TIME USERS MUST <strong>REGISTER</strong> BY USING ONE OF THE LINKS ABOVE. </p>
        </div></td>
</tr>
    <tr>
      <th scope="row">&nbsp;</th>
    </tr>
  <tr><td>
  <form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
<table border="0" bgcolor="#FFFFFF" > 
<tr><td width="788"><div align="center"><strong>LOG IN</strong></div></td>
</tr> 
<tr><td><div align="center">
  <table width="235" border="0">
    <tr>
      <td width="84"><div align="left"><span class="style17">Username</span>:</div></td>
      <td width="147"><div align="left">
        <input name="username" type="text" size="25" maxlength="40">
      </div></td>
    </tr>
    <tr>
      <td><div align="left"><span class="style17">Password:</span></div></td>
      <td><div align="left">
        <input name="pass" type="password" size="25" maxlength="40">
      </div></td>
    </tr>
  </table>
  </div>
  <div align="center"></div></td>
</tr> 
<tr><td><div align="center">
  <p><br>
      *Username and password are case sensitive.</p>
  <p>If you forget your password, click here to<a href="passwordRET.php"> retrieve</a>.</p>
  <p>For IRB Chairs and Administrator, please check the box if you want to login as 
    an applicant to see your own application(s):
    <input name="asApp" type="checkbox" id="asApp" value="Yes">
    <br>
      <br>
      <input type="submit" name="submit" value="Login">
  </p>
  </div></td>
</tr>
      <tr><td colspan="2"><div align="center"></div>
      <br><ul><li>
     </div> 
     You will need a browser that has Javascript
          and Cookies enabled. Call the Computing Help Desk at 245-HELP if you
          need assistance enabling Javascript or Cookies. </li>
        <li>The pages are designed for a monitor resolution
          of 800 x 600 or greater. </li>
      </ul>
          <div align="left">
      <input type="hidden" name="insert" maxlength="50" value="inserted">  
    </div></td>
      </tr> 
<tr><td align="right"> 
  
    <div align="left"></div></td></tr> 
</table> 
</form> 

</td></tr><tr><td><br><br>
           
            <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr></table>


</body>
</html>
