

<?php 
// Connects to your Database 
mysql_connect("localhost", "irbadmin", "irbadmin") or die(mysql_error()); 
mysql_select_db("irblog_db") or die(mysql_error()); 

//This code runs if the form has been submitted
if (isset($_POST['submit'])) { 

//This makes sure they did not leave any fields blank
if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] ) {
die('You did not complete all of the required fields');
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
$insert = "INSERT INTO users (username, password)
VALUES ('".$_POST['username']."', '".$_POST['pass']."')";
$add_member = mysql_query($insert);
?>


<h1>Registered</h1>
<p>Thank you, you have registered - you may now login</a>.</p>

<?php 
} //end of if submit
else 
{ 
?>



<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="0">
<tr><td>Are you:</td></tr>
<tr><td>
 <input type="radio" name="User_Type" value="OSP staff">
    a OSP staff member?<br>
 <input type="radio" name="User_Type" value="Reviewer">
    a IRB Reviewer?<br>
    <input type="radio" name="User_Type" value="faculty/staff">
    a faculty/staff member?<br>
<input type="radio" name="User_Type" value="student">
    a student?
</td></tr>
<tr><td>
<input type="text" name="First_Name">
      </td>
      <td > 
        <input type="text" name="Last_Name">
</td></tr>
<tr> 
      <td > 
        <input type="text" name="Phone">
      </td>
      <td > 
        <input type="text" name="Email">
      </td></tr>
<tr><td>For student: </td></tr>
<tr><td> Rank: 
        <input type="text" name="Rank"> </td><td>Major:<input type="text" name="Major">

</td></tr>

<tr><td>

<hr>
<font color="#FF0000">*</font>  Have you taken the required Human Subjects Protection Training? 
    <input name="training" type="radio" value="Yes" onChange="traing()">
  Yes&nbsp; 
  <input name="training" type="radio" value="No">
  No</p>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font> Which of the following trainings did you take? :  
    <select name="trainingType" visible="false">
      <option value="Choose One">Choose One</option>
      <option value="Not Applicable">Not Applicable</option>
      <option value="CITI Course">CITI Course</option>
      <option value="Previous Texas State HSP Training">Previous Texas State HSP Training</option>
    </select>  
  &nbsp; </p>
  <p><br>
    If you answered &quot;Previous Texas State HSP Training,&quot; provide your HSP Certification Number:
    <input name="HSP_Number" type="text" id="HSP_Number">
  </p>
  <p>&nbsp;</p>
  <h6>NOTE:&nbsp; If you have not taken a Human Subjects Protection Training, you must complete the CITI Course before your application can be processed.</h6>
  <p>&nbsp;</p>
</td></tr><hr>
<tr><td>Create Username:</td><td>
<input type="text" name="username" maxlength="60">
</td></tr>
<tr><td>Create Password:</td><td>
<input type="password" name="pass" maxlength="10">
</td></tr>
<tr><td>Confirm Password:</td><td>
<input type="password" name="pass2" maxlength="10">
</td></tr>
<tr><th colspan=2><input type="submit" name="submit" value="Register"></th></tr> </table>
</form>
<?php
}
?> 