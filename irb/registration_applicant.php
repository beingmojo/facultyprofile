<?php require_once('Connections/dbc.php'); 
require_once('variables/variables.php'); 

//This code runs if the form has been submitted
if (isset($_POST['submit'])) { 
	if(!$_POST['User_Type'] | !$_POST['training']) {
		die('You did not fill in a required field.');
	}
if($_POST['User_Type']=="student")
{
	if(!$_POST['Major'] | !$_POST['Rank']){
		die('You did not fill in a required field. -- Rank or Major. *Please recheck the student button.');
	}
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
die('Sorry, the user with name '.$_POST['FirstName']." ".$_POST['LastName'].' has already registered.');
}
$_POST['username']=trim($_POST['username']);

$str=$_POST['username'];
if(strpos($str,"'")!== false ||strpos($str,'"')!== false||strpos($str,'\\')!== false||strpos($str,'%')!== false||strpos($str,'%')!== false||strpos($str,'#')!== false||strpos($str,'||')!== false||strpos($str,'&&')!== false||strpos($str,'!')!== false||strpos($str,'&')!== false||strpos($str,'|')!== false||strpos($str,'*')!== false||strpos($str,'$')!== false||strpos($str,')')!== false||strpos($str,')')!== false||strpos($str,'>')!== false||strpos($str,'<')!== false||strpos($str,'?')!== false||strpos($str,'~')!== false||strpos($str,'`')!== false||strpos($str,'^')!== false||strpos($str,'*')!== false||strpos($str,'/')!== false||strpos($str,';')!== false||strpos($str,',')!== false)
	{
	die("<font color='red'>You've used invalid character(s) for your user name. Registration failed.");
	
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


//$substring = "@txstate.edu"; 
/*
if (strpos($_POST['Email'], $substring) !== false) {
   // Yes, '$substring' is found in '$string';
   
} else {
   die("Registrion failed! You need to use your Texas State University email address. <a href='javascript:history.back()'>Back</a>");
}
*/
// encrypt the password and add slashes if needed
//$_POST['pass'] = md5($_POST['pass']);
if (!get_magic_quotes_gpc()) {
$_POST['pass'] = addslashes($_POST['pass']);
$_POST['username'] = addslashes($_POST['username']);
$_POST['FirstName'] = addslashes($_POST['FirstName']);
$_POST['LastName'] = addslashes($_POST['LastName']);
$_POST['User_Type'] = addslashes($_POST['User_Type']);

$_POST['Department'] = addslashes($_POST['Department']);
$_POST['Rank'] = addslashes($_POST['Rank']);
$_POST['Major'] = addslashes($_POST['Major']);
$_POST['Email'] = addslashes($_POST['Email']);
}




// now we insert it into the database
$insert = "INSERT INTO user (FirstName, LastName, Phone, Email, User_Type, Department, Rank, Major, username, password, Training) VALUES 
('".$_POST['FirstName']."', '".$_POST['LastName']."', '".$_POST['Phone']."', '".$_POST['Email']."', '".$_POST['User_Type']."', '".$_POST['Department']."', '".$_POST['Rank']."', '".$_POST['Major']."', '". $_POST['username']."', '".$_POST['pass']."', '".$_POST['training']."')";
$add_member = mysql_query($insert);

$to=$_POST['Email'];
$subject="Your IRB login information";


$mail_body = "DO NOT REPLY TO THIS MESSAGE. Thank you for using IRB Online Application System. Your login username is: ".$_POST['username'].". Your password is: ".$_POST['pass'].".\r\n\r\nEvery IRB application must contain a synopsis document that summarizes the project being reviewed. If you do not include one, your application will not be processed.\r\n\r\nIf you are using a consent form in your project, it must include all of the items listed in the Consent Form Checklist. If it does not, the IRB reviewers may require revisions, which could delay processing of your application.\r\n\r\nIf you have questions, please submit an IRB Inquiry form at: \r\nhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";

$mail_body .= "\r\n\r\n======================================\r\n"."\r\nInstitutional Review Board\r\n"."Office of Research Compliance"."\r\nTexas State University-San Marcos\r\n"."(ph) 512/245-2314 / (fax) 512/245-3847 / ospirb@txstate.edu / JCK 489\r\n"."601 University Drive, San Marcos, TX 78666\r\n"."\r\nTexas State University-San Marcos is a member of the Texas State University System\r\n"."NOTE:  This email, including attachments, may include confidential and/or proprietary information and may be used only by the person or entity to which it is addressed. If the reader of this email is not the intended recipient or his or her agent, the reader is hereby notified that any dissemination, distribution or copying of this email is prohibited.  If you have received this email in error, please notify the sender by replying to this message and deleting this email immediately.  Unless otherwise indicated, all information included within this document and any documents attached should be considered working papers of this office, subject to the laws of the State of Texas.\r\n";


 
// send
 
$ok = @mail($to, $subject, $mail_body, $headers); 
if ($ok) { 
   // echo "<p>mail sent to $to!</p>"; 
} else { 
  //  echo "<p>mail could not be sent!</p>"; 
} 

//

//mail($to, $subject, $body, $headers);
	


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
if(!e['Department'].value) {m += '- Department or Office Name is required.\n';}
if(!e['username'].value) {m += '- User Name is required.\n';}
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



function studentYes() {
DivStudent.style.visibility = 'visible';
}
function facultyYes(){
DivStudent.style.visibility = 'hidden';
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
	 <table width='800' align="center" bgcolor="#FFFFFF"><tr><td><table width='650' align="center" bgcolor="#FFFFFF">
      <tr>
        <td colspan="2"><div align="center" class="style3"><br>IRB APPLICANT REGISTRATION
        </div>
		<?php
		if (isset($_POST['submit'])) { 
		
				echo "<P class='style46'>You have successfully registered. You can now <a href='index.php'>log in</a> to start your IRB online application. Your username is <em>".$_POST['username']."</em>, your password is <em>". $_POST['pass']."</em>.";?>
				</td></tr></table><tr><td><br><br><br><br><br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>
				
				<?php
				exit;
				}
				?>
          <P class="style46">Following characters are not allowed for your username: ', !, #, $, %, ^, &, *, (, ), <, >, ", ;, ?, ~, `, |, \, /           
          <P></td></tr>
      <form name="mainform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  onsubmit="return validate(this)">
<div align="center">

<tr><td align="left"><span class="style47">
First Name: </span></td>
<td><input name="FirstName" type="text">      </td>
</tr>
      <tr><td align="left" ><span class="style47"> Last Name: </span></td>
      <td><input name="LastName" type="text"></td>
      </tr>
<tr><td align="left" ><span class="style47"> Phone: </span></td>
<td><input name="Phone" type="text">      </td>
</tr>
     <tr> <td align="left" ><span class="style47">Email: </span>
	
	 </td>
     <td><input name="Email" type="text">      </td>
     </tr>
<tr><td align="left" ><span class="style47"> Department/Administration Office:</span></td>
<td> <input name="Department" type="text">      </td>
    </tr>


<tr><td colspan="2" align="left"><span class="style47">Are you:</span></td>
</tr>
<tr><td colspan="2" align="left">
 
    <span class="style47">
    <input type="radio" name="User_Type" id="User_Type" value="faculty/staff">
    a faculty/staff member?<br>
    <input type="radio" name="User_Type" id="User_Type" value="student" >
    a student?    </span></td>
</tr><tr><td colspan="2" align="left">

Rank: <INPUT TYPE="TEXT" ID="Rank" name="Rank">  Major: <input type="text" name="Major">


</td>
</tr>

<tr><td colspan = 2 align="left"><hr>

  </td></tr>

<tr>
  <td colspan = 2 align="left">
  <span class="style47">  Have you taken the required Human Subjects Protection training? </span></td>
</tr>
   <tr>
     <td colspan = 2 align="left"><span class="style47">
     <input name="training" type="radio" id="training" value="Yes" >
     Yes&nbsp; 
     <input name="training" type="radio" value="No" id="training" >
     No
   </span></td>
   </tr>
<tr><td colspan = 2 align="left">
<DIV class="style47" ID="Div0" style="visibility:hidden"></DIV>  </td>
</tr>
<tr><td colspan="2" align="left">
<DIV class="style47" ID="Div1" style="visibility:hidden">
<LABEL FOR="HSP_Number"></LABEL>
</DIV>
  </td>
</tr>
<tr><td colspan = 2><hr></td>
</tr>
<tr><td><span class="style47">Create Username:</span></td>
<td>
<input name="username" type="text" maxlength="60"></td>
</tr>
<tr><td><span class="style47">Create Password(Maximum 10):</span></td>
<td>
<input name="pass" type="password" maxlength="10"></td>
</tr>
<tr><td><span class="style47">Confirm Password:</span></td>
<td>
<input name="pass2" type="password" maxlength="10"></td>
</tr>
<tr><th></th><th><input name="submit" type="submit" value="Register"></th>
</tr> </table>
</div>
</form>
<?php
//}
?> 
</td></tr><tr><td>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr>

</table></body>