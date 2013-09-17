<?php require_once('Connections/dbc.php'); ?>
<?php
session_start();

// Connects to IRB Database 

//if the login form is submitted
if (isset($_POST['submit'])) { 
 
// makes sure they filled it in
if(!$_POST['username'] || !$_POST['pass']) {
die("You did not fill in a required field.");

}
// checks it against the database
$username = (get_magic_quotes_gpc()) ? $_POST['username'] : addslashes($_POST['username']);

$query = sprintf("SELECT * FROM user WHERE username = '%s' ", $username);
echo $query;
$check = mysql_query($query,$con) or die(mysql_error());
$info = mysql_fetch_assoc($check);
$check2 = mysql_num_rows($check);
//Gives error if user dosen't exist
$check2 = mysql_num_rows($check);
if ($check2 == 0) {
die("The user does not exist in our database. <a href='index.php'>Click Here to Register</a>");
}


//gives error if the password is wrong
if ($_POST['pass'] != $info['password']) {
die("Incorrect password, please try again.");

}
else 
{ 


//$UID=$info['username']; 
    //register the session variables
	$_SESSION["username"]=$info['username'];
    session_register("username");
   	echo "User Name:".$info['username'];
//$_SESSION['loginmsg']="ok" 
 //$_SESSION['username']=$info['username']; 
//$_SESSION['User_Type']=$info['User_Type'];

$usertype = $info['User_Type'];
if ($usertype == "IRB Staff"){ 
	header("Location: osp_irb_home.php");
	exit;
	}
 if ($usertype == "faculty/staff" || $usertype == "student")
	{
		header("Location: applicanthome.php");
		exit;
	}
 if ($usertype == "reviewer")
	{
		header("Location: reviewerhome.php");
		exit;
	}
} //end else
 
//} //end while
}
?>