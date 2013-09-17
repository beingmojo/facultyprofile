<?php require_once('Connections/dbc.php'); ?>
<?php require_once('variables/variables.php'); ?>

<?php 


//This makes sure they did not leave any fields blank
if ($_POST['submit'])
{


//check if this person has already registered


 $_POST['username'] = trim($_POST['username']);
$str=$_POST['username'];
if(strpos($str,"'")!== false ||strpos($str,'"')!== false||strpos($str,'\\')!== false||strpos($str,'%')!== false||strpos($str,'%')!== false||strpos($str,'#')!== false||strpos($str,'||')!== false||strpos($str,'&&')!== false||strpos($str,'!')!== false||strpos($str,'&')!== false||strpos($str,'|')!== false||strpos($str,'*')!== false||strpos($str,'$')!== false||strpos($str,')')!== false||strpos($str,')')!== false||strpos($str,'>')!== false||strpos($str,'<')!== false||strpos($str,'?')!== false||strpos($str,'~')!== false||strpos($str,'`')!== false||strpos($str,'^')!== false||strpos($str,'*')!== false||strpos($str,'/')!== false||strpos($str,';')!== false||strpos($str,',')!== false)
	{
	die("You've used invalid character(s) for your user name. Registration failed.");
	
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

$_POST['Email'] = addslashes($_POST['Email']);
}

// now we insert it into the database
$insert = "INSERT INTO user (Email, User_Type, username, password)
VALUES ('".$_POST['Email']."', '".$_POST['User_Type']."', '".$_POST['username']."', '".$_POST['pass']."')";
//echo $insert."<br>";
$add_member = mysql_query($insert, $con) or die(mysql_error());

$to=$_POST['Email'];
$subject="Your IRB login information";
$body = "Thank you for using IRB Online Application System. Your login username is: ".$_POST['username'].". Your password is: ".$_POST['pass'].".";
mail($to, $subject, $body, $headers);


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

if(!e['username'].value) {m += '- User Name is required.\n';}

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
          </span><a href="index.php" class="irb">Log In</a> <span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a> </div>
        
        </div></td>
      </tr></table>
	  <table width='800' align="center" bgcolor="#FFFFFF"><tr><td><table width='650' align="center" bgcolor="#FFFFFF">
      <tr>
        <td colspan="2"><div align="center" class="style3">IRB CHAIR REGISTRATION
        </div>
          <P class="style46">
		  		<?php
		if (isset($_POST['submit'])) { 
		
				echo "<P class='style46'>You have successfully registered. You can now <a href='index.php'>log in</a>. Your username is <em>".$_POST['username']."</em>, your password is <em>". $_POST['pass']."</em>.";
				exit;
				}
				?>
		  Following characters are not allowed for your username: ', !, #, $, %, ^, &, *, (, ), <, >, ", ;, ?, ~, `, |, \, /           
          <P></td></tr>
		<form name="mainform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return validate(this)">
            <div>
            <div align="center">
             
                
                  <tr>
                    <td><span class="style7">
                      <div align="left">
                        <input type="hidden" name="User_Type" value="IRB Support">
                        </div></td></tr>
                
                
                <tr>
                  <td><div align="center" class="style7">
                    <div align="left">Email Address: </div>
                  </div></td>
                    <td><input type="text" name="Email">                </td>
                  </tr>
                  <tr>
                    <td colspan=2><hr align="left"></td>
                  </tr>
                  <tr>
                    <td ><div align="center" class="style7">
                      <div align="left">Create User Name: </div>
                    </div></td>
                    <td><input type="text" name="username" value="IRB Support">                </td>
                  </tr>
                <tr>
                  <td ><div align="center" class="style7">
                    <div align="left">Create Password (Maximum Length 10):</div>
                  </div></td>
                    <td><input type="password" name="pass" maxlength="10">                </td>
                  </tr>
                <tr>
                  <td><div align="center" class="style7">
                    <div align="left">Confirm Password:</div>
                  </div></td>
                    <td><input type="password" name="pass2" maxlength="10">                </td>
                  </tr>
                <tr>
                  <td><div align="center" class="style5">
                    <div align="left">                    </div>
                  </div></td> <td><div align="center" class="style5">
                    <div align="left">
                      <input type="submit" name="submit" value="Register">
                    </div>
                  </div></td>
                  </tr>
              </table>
            </div>
        </form>
            <div align="center">              </div>
            </div></td>
      </tr><tr><td>
	  <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>
    </table>
    <?php
//}
?>
