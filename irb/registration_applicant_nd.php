<html>
<head>
<title>IRB Registration Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function trainingyes() {
Div0.style.visibility='visible';
Div1.style.visibility='visible';

}
function trainingno() {

Div1.style.visibility='hidden';
Div0.style.visibility='hidden';
}

function studentYes() {
DivStudent.style.visibility = 'visible';
}
function facultyYes(){
DivStudent.style.visibility = 'hidden';
}

</script>

<?php 
$con = mysql_connect("localhost", "root", "mypass") or die(mysql_error()); 
mysql_select_db("irbdb", $con) or die(mysql_error()); 


//This code runs if the form has been submitted
if (isset($_POST['submit'])) { 

//This makes sure they did not leave any fields blank
if (!$_POST['username'] || !$_POST['pass'] || !$_POST['pass2'] ) {
die('You did not complete all of the required fields');
}

//check if this person has already registered

$namecheck = mysql_query("SELECT FirstName, LastName FROM users WHERE FirstName = '".$_POST['FirstName']."' && LastName = '".$_POST['LastName']."'") or die(mysql_error());
$check2 = mysql_num_rows($namecheck);

//if user exists gives an error
if ($check2 != 0) {
die('Sorry, the user with name'.$_POST['FirstName'].$_POST['LastName'].' has already registered.');
}

// checks if the username is in use
if (!get_magic_quotes_gpc()) {
$_POST['username'] = addslashes($_POST['username']);
}
$usercheck = $_POST['username'];
$check = mysql_query("SELECT username FROM users WHERE username = '$usercheck'") 
or die(mysql_error());
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
$_POST['pass'] = md5($_POST['pass']);
if (!get_magic_quotes_gpc()) {
$_POST['pass'] = addslashes($_POST['pass']);
$_POST['username'] = addslashes($_POST['username']);
}

// now we insert it into the database
$insert = "INSERT INTO users (FirstName, LastName, Phone, Email, User_Type, Department, Rank, Major, TrainingType, HSP_Number, username, password) VALUES 
('".$_POST['FirstName']."', '".$_POST['LastName']."', '".$_POST['Phone']."', '".$_POST['Email']."', '".$_POST['User_Type']."', '".$_POST['Department']."', '".$_POST['Rank']."', '".$_POST['Major']."', '".$_POST['TrainingType']."', '".$_POST['HSP_Number']."', '".$_POST['username']."', '".$_POST['password']."')";
$add_member = mysql_query($insert);
?>


<h1>Registered</h1>
<p>Thank you, you have registered - you may now login</a>.</p>

<?php 
} //end of if submit
else 
{ 
?>



<form name="mainform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<div align="center"><table width="600" border="0">

<tr><td>
First Name: </td><td><input type="text" name="FirstName">
      </td></tr>
      <tr><td > Last Name: </td><td><input type="text" name="LastName">
</td></tr>
<tr><td > Phone: </td><td><input type="text" name="Phone">
      </td></tr>
     <tr> <td >Email: </td><td><input type="text" name="Email">
      </td></tr>
<tr><td > Department / Admin Office:</td><td> <input type="text" name="Department">
      </td>
    </tr>


<tr><td colspan="2">Are you:</td></tr>
<tr><td colspan="2">
 
    <input type="radio" name="User_Type" value="faculty/staff" onClick="facultyYes();">
    a faculty/staff member?<br>
<input type="radio" name="User_Type" value="student" onClick="studentYes();">
    a student?
</td></tr><tr><td colspan="2">
<DIV ID="DivStudent" style="visibility:hidden">
<LABEL > Rank: <INPUT TYPE="TEXT" ID="Rank">  Major: <input type="text" name="Major">

</LABEL>
</DIV>
</td></tr>

<tr><td colspan = 2><hr>
<h6>NOTE:&nbsp; If you have not taken a Human Subjects Protection Training, you must complete the CITI Course before your application can be processed.</h6>
  </td></tr>

<tr><td colspan = 2>
<font color="#FF0000">*</font>  Have you taken the required Human Subjects Protection Training? </td></tr>
   <tr><td colspan = 2> <input name="training" type="radio" value="Yes" onClick="trainingyes();">
  Yes&nbsp; 
  <input name="training" type="radio" value="No" onClick="trainingno();">No
 </td></tr>
<tr><td colspan = 2>
<DIV ID="Div0" style="visibility:hidden">
  <font color="#FF0000">*</font> Which of the following trainings did you take? :  
    <select name="trainingType" visible="false">
      <option value="Choose One">Choose One</option>
      <option value="Not Applicable">Not Applicable</option>
      <option value="CITI Course">CITI Course</option>
      <option value="Previous Texas State HSP Training">Previous Texas State HSP Training</option>
    </select>  
  
</DIV>  </td></tr>
<tr><td colspan="2">
<DIV ID="Div1" style="visibility:hidden">
<LABEL FOR="HSP_Number"> HSP Certification Number: 
<INPUT TYPE="TEXT" ID="HSP_Number">
</LABEL>
</DIV>
  </td></tr>
<tr><td colspan = 2><hr></td></tr>
<tr><td>Create Username:</td><td>
<input type="text" name="username" maxlength="60">
</td></tr>
<tr><td>Create Password:</td><td>
<input type="password" name="pass" maxlength="10">
</td></tr>
<tr><td>Confirm Password:</td><td>
<input type="password" name="pass2" maxlength="10">
</td></tr>
<tr><th colspan=2><input type="submit" name="submit" value="Register"></th></tr> </table></div>
</form>
<?php
}
?> 