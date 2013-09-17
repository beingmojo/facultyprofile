


<?php require_once('connections/dbc.php'); 
session_start();

// Connects to IRB Database 

//if the login form is submitted
if (isset($_POST['submit'])) { // if form has been submitted

// makes sure they filled it in
if(!$_POST['username'] | !$_POST['pass']) {
die('You did not fill in a required field.');
exit;
}
// checks it against the database

sprintf("SELECT username_prop, pw_prop FROM rep_proposal_prop WHERE username_prop='%s' AND pw_prop='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
if(!get_magic_quotes_gpc())
$check = mysql_query("SELECT * FROM user WHERE username = '".addslashes($_POST['username'])."'") or die(mysql_error());
else
$check = mysql_query("SELECT * FROM user WHERE username = '".$_POST['username'])."'") or die(mysql_error());
//Gives error if user dosen't exist
$check2 = mysql_num_rows($check);
if ($check2 == 0) {
die("That user does not exist in our database. <a href='home.php'>Click Here to Register</a>");
}
while($info = mysql_fetch_array( $check )) 
{
//$_POST['pass'] = stripslashes($_POST['pass']);
$info['password'] = stripslashes($info['password']);
//$_POST['pass'] = md5($_POST['pass']);

//gives error if the password is wrong
if ($_POST['pass'] != $info['password']) {
die('Incorrect password, please try again.');

}
else 
{ 

// if login is ok then we add a cookie 
$_POST['username'] = stripslashes($_POST['username']); 
$hour = time() + 3600; 
setcookie(ID_my_site, $_POST['username'], $hour); 
setcookie(Key_my_site, $_POST['pass'], $hour); 

$UID=$info['username']; 

$_SESSION['loginmsg']="ok" 
 $_SESSION['username']=$info['username']; 
$_SESSION['User_Type']=$info['User_Type'];

$usertype = $info['User_Type'];
if ($usertype == 'IRB Staff'){ 
	header("Location: irbstaffhome.php?UID=$UID");
	}
 elseif ($usertype == 'faculty/staff' || $usertype == 'student')
	{
		header("Location: applicantshome.php?UID=$UID");
	}
 elseif ($usertype == 'reviewer')
	{
		header("Location: reviewerhome.php?UID=$UID");
	}
}
} 
} 
else 
{ 

// if they are not logged in 
?> 
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
<table border="0"> 
<tr><td colspan=2><h1>Login</h1></td></tr> 
<tr><td>Username:</td><td> 
<input type="text" name="username" maxlength="40"> 
</td></tr> 
<tr><td>Password:</td><td> 
<input type="password" name="pass" maxlength="50"> 
</td></tr> 
<tr><td colspan="2" align="right"> 
<input type="submit" name="submit" value="Login"> 
</td></tr> 
</table> 
</form> 
<?php 
} 

?> 