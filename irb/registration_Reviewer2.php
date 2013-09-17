<?php require_once('Connections/dbc.php'); 
require_once('variables/variables.php'); 

//This code runs if the form has been submitted
if (isset($_POST['submit'])) { 

//check security code
$query_Recordset1 = "SELECT * FROM security where ID='reviewer_irb'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);



{
//echo $_POST['SecurityCode']." = ".$row_Recordset1['SecurityCode']."<br>";
if ($_POST['SecurityCode'] != $row_Recordset1['SecurityCode']) 
{
echo("You are not authorized to register as an IRB reviewer.");
exit;
}
else
{
	$_POST['username']=trim($_POST['username']);
	$str=$_POST['username'];
	if(strpos($str,"'")!== false ||strpos($str,'"')!== false||strpos($str,'\\')!== false||strpos($str,'%')!== false||strpos($str,'%')!== false||strpos($str,'#')!== false||strpos($str,'||')!== false||strpos($str,'&&')!== false||strpos($str,'!')!== false||strpos($str,'&')!== false||strpos($str,'|')!== false||strpos($str,'*')!== false||strpos($str,'$')!== false||strpos($str,')')!== false||strpos($str,')')!== false||strpos($str,'>')!== false||strpos($str,'<')!== false||strpos($str,'?')!== false||strpos($str,'~')!== false||strpos($str,'`')!== false||strpos($str,'^')!== false||strpos($str,'*')!== false||strpos($str,'/')!== false||strpos($str,';')!== false||strpos($str,',')!== false)
	{
	die("<font color='red'>You've used invalid character(s) for your user name. Registration failed.");
	
	}

//check if this person has already registered
$last = (get_magic_quotes_gpc()) ? $_POST['LastName'] : addslashes($_POST['LastName']);
$first = (get_magic_quotes_gpc()) ? $_POST['FirstName'] : addslashes($_POST['FirstName']);
$query = "SELECT FirstName, LastName FROM user WHERE FirstName = '".$first."' && LastName = '".$last."'";
//echo $query;
$namecheck = mysql_query($query,$con) or die(mysql_error());

$check2 = mysql_num_rows($namecheck);

//if user exists gives an error
if ($check2 != 0) {
die('Sorry, the user with name <font color=red>'.$_POST['FirstName'].' '.$_POST['LastName'].'</font> has already registered.');
}

// checks if the username is in use
if (!get_magic_quotes_gpc()) {
$_POST['username'] = addslashes($_POST['username']);
}
$usercheck = $_POST['username'];
$sql="SELECT username FROM user WHERE username = '".$usercheck."'";
$check = mysql_query($sql, $con) or die(mysql_error());
$check2 = mysql_num_rows($check);

//if the name exists it gives an error
if ($check2 != 0) {
die('Sorry, the username '.$_POST['username'].' is already in use.');
}

// this makes sure both passwords entered match
if ($_POST['pass'] != $_POST['pass2']) {
die('Your passwords did not match.');
}

// encrypt the password and add slashes if needed
//$_POST['pass'] = md5($_POST['pass']);
if (!get_magic_quotes_gpc()) {
$_POST['pass'] = addslashes($_POST['pass']);
$_POST['username'] = addslashes($_POST['username']);
$_POST['FirstName'] = addslashes($_POST['FirstName']);
$_POST['LastName'] = addslashes($_POST['LastName']);
$_POST['Email'] = addslashes($_POST['Email']);
$_POST['Department'] = addslashes($_POST['Department']);
}

// now we insert it into the database
$insert = "INSERT INTO user (FirstName, LastName, Phone, Email, Department, User_Type, username, password)
VALUES ('".$_POST['FirstName']."', '".$_POST['LastName']."', '".$_POST['Phone']."', '".$_POST['Email']."', '".$_POST['Department']."', '".$_POST['User_Type']."', '".$_POST['username']."', '".$_POST['pass']."')";
$add_member = mysql_query($insert, $con) or die(mysql_error());

$to=$_POST['Email'];
$subject="Your IRB login information";
$body = "Thank you for using IRB Online Application System. Your login username is: ".$_POST['username'].". Your password is: ".$_POST['pass'].".\r\n";
  $body = $body.$emailSig;
mail($to, $subject, $body, $headers);

	}// end security check
	} //end while
	mysql_free_result($Recordset1);
} //end of if submit

//else 
//{ 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="irbstyle.css" rel="stylesheet" type="text/css">

<script language="JavaScript">
function validate(form) {
var e = form.elements, m = '';
if(!e['FirstName'].value) {m += '- First Name is required.\n';}
if(!e['LastName'].value) {m += '- Last Name is required.\n';}
if(!e['username'].value) {m += '- User Name is required.\n';}
if(!e['Department'].value) {m += '- Department is required.\n';}
if(!e['Phone'].value) {m += '- Phone Number is required.\n';}
if(!/.+@[^.]+(\.[^.]+)+/.test(e['Email'].value)) {
m += '- E-mail requires a valid e-mail address.\n';
}
if(!e['pass2'].value) {m += '- Password confirm is required.\n';}
if(!e['pass'].value) {m += '- Password is required.\n';}
if(e['pass'].value != e['pass2'].value) {
m += '- Your password and confirmation password do not match.\n';
}
if(m) {
alert('The following error(s) occurred:\n\n' + m);
return false;
}
return true;
}


</script>


  <style type="text/css">
<!--
.style43 {font-size: large}
.style44 {color: #000000}
.style46 {color: #990000}
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
</tbody></table> </td></tr></table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
      <tr>
        <td height="19" valign="top" bgcolor="#000000"><div align="center" class="style9 style44">
          <div align="center"><a href="registration_applicant.php" class="irb">IRB Applicant Registration </a> <span class="style39">|</span> <a href="registration_Reviewer.php" class="irb">IRB Reviewer Registration</a> <span class="style39">|</span> <a href="registration_IRB.php" class="irb">IRB Administrator Registration </a><span class="style39">|<a href="registration_chair.php" class="irb"> IRB Chair Registration</a><br>
          </span><a href="index.php" class="irb">Log In</a> <span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a></div>
          
        
		</td>
      </tr></table>
	  <table width='800' align="center" bgcolor="#FFFFFF">
	  <tr><td><table width='650' align="center" bgcolor="#FFFFFF">
      <tr><td colspan="2"><div align="center" class="style3">
       
        <p>IRB REVIEWER REGISTRATION
        </p>
      </div>
          <P class="style46">
		  		<?php
		if (isset($_POST['submit'])) { 
		
				echo "<P class='style46'>You have successfully registered. You can now <a href='index.php'>log in</a>. Your username is: <em>".$_POST['username']."</em>. Your password is: <em>". $_POST['pass']."</em>.";
				exit;
				}
				?>
		  Following characters are not allowed for your username: ', !, #, $, %, ^, &, *, (, ), <, >, ", ;, ?, ~, `, |, \, /           
          </td></tr>




<TR><TD><form name="mainform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return validate(this)">
  <div align="left">Reviewer Security Code:</div></td><td>
    
      <div align="left">
        <input type="password" name="SecurityCode"> 
        </div></td></tr>
<tr><td>
  <div align="left">
    <input type="hidden" name="User_Type" value="reviewer">
  </div></td></tr>
   

<tr><td>  <div align="left">First Name: </div></td><td>
  <div align="left">
    <input type="text" name="FirstName">
  </div></td></tr>

      
  <tr><td><div align="left">Last Name: </div></td><td> 
    <div align="left">
      <input type="text" name="LastName">
      </div></td></tr><tr><td><div align="left">Phone: </div></td><td> 
        <div align="left">
          <input type="text" name="Phone">
              </div></td></tr><tr><td><div align="left">Email Address: </div></td><td>
                <div align="left">
                  <input type="text" name="Email">
                </div></td></tr>
<tr><td > <div align="left">Department/Administration Office:</div></td><td> 
  <div align="left">
    <input type="text" name="Department">
  </div></td>
    </tr>
<tr><td colspan=2><hr align="left"></td></tr>
<tr><td><div align="left">Create User Name: </div></td><td>
  <div align="left">
    <input type="text" name="username" maxlength="60">
  </div></td></tr><tr><td><div align="left">Create Password (Maximum Length 10):</div></td><td>
    <div align="left">
      <input type="password" name="pass" maxlength="10">
    </div></td></tr><tr><td>Confirm Password:</td><td><input type="password" name="pass2" maxlength="10">

</td></tr><tr><td></td><td><input type="submit" name="submit" value="Register"></form></td></tr></table>
</td></tr>
<tr><td>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr>
</table>

<?php
//}
?> 
</td></tr></table>
</body>