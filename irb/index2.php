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


    //register the session variables
	//$username=$info['username'];
 
   	//echo "User Name:".$info['username'];

//$_SESSION['User_Type']=$info['User_Type'];
//$_SESSION['username']=$info['username'];
//$_SESSION['User_Type']="IRB Staff";
$_SESSION['a']="a";
$_SESSION['b']="b";
$usertype = $info['User_Type'];

if ($usertype == "IRB Staff"){ 
echo "<a heref='osp_irb_home.php'>click to redirect</a>";
	//header("Location: osp_irb_home.php");
	//exit;
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos </title>
  <style type="text/css">
<!--
.style4 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 40px;
	color: #333399;
}
.style5 {
	color: #333399;
	font-style: italic;
	font-weight: bold;
}
.style6 {
	font-family: Arial, Helvetica, sans-serif;
	color: #333399;
	font-weight: bold;
}
.style7 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #4d3319;
}
a.navbar:link {
	color: #4d3319;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
}
a.navbar:visited {
	color: #4d3319;
	text-decoration: none;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
a.navbar:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	text-decoration: underline;
}
a.body:link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #336699;
	text-decoration: underline;
}
a.body:visited {
	font-family: Arial, Helvetica, sans-serif;
	color: #4D3319;
	text-decoration: underline;
}
.style13 {color: #4D3319}

a.irb:link{
font-family: Arial, Helvetica, sans-serif;
	color: #336699;
	text-decoration: none;

}
a.irb:visited {
	font-family: Arial, Helvetica, sans-serif;
	color: #336699;
	text-decoration: none;
}
-->
  </style>
  <style type="text/css">
<!--
.style9 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #4D3319;
}
-->
  </style>
</head>
<body>
<table width="650" border="1" align="center" cellpadding="5" cellspacing="0" >
<!--DWLayoutTable--> <tbody>
    <tr>
      <td height="150" valign="top" width="650">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
<!--DWLayoutTable--> <tbody>
          <tr>
            <td width="290" rowspan="3" valign="top"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a></td>
            <td rowspan="3" class="style4" valign="top" width="105"><br>
            </td>
            <td height="38" width="4">&nbsp;</td>
            <td valign="top" width="237">
            <div class="style5" align="right"><a href="index.php"
 class="irb"><font color="#336699">Institutional Review Board </font></a></div>
            </td>
          </tr>
          <tr>
          </tr>
          <tr>
            <td height="18"><br>
            </td>
            <td valign="top">
            <div class="style7" align="right"><a href="LogOut.php">Log
Out </a></div>
            </td>
          </tr>
          <tr>
            <td colspan="4" height="21" valign="top">
            <div align="center">
              <p class="style6"><br>
                Online Application              </p>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="4" height="19" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
    <tr>
      <td height="348" valign="top">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
<!--DWLayoutTable--> <tbody>
          <tr>
            <td height="374" width="650">
            <table style="width: 100%;" border="0" cellpadding="0"
 cellspacing="0">
              <tbody>
                <tr>
                  <th class="style7" scope="row">
                  <div align="left">
                  <p>Application System Requirements</p>
                  <ul>
                    <li> You will need a browser that has Javascript
and Cookies enabled. Call the Computing Help Desk at 245-HELP if you
need assistance enabling Javascript or Cookies. </li>
                    <li>The pages are designed for a monitor resolution
of 800 x 600 or greater. </li>
                  </ul>
                  </div>
                  </th>
                </tr>
                <tr>
                  <th class="style6 style8" scope="row">Log In </th>
                </tr>
              </tbody>
            </table>
<form action="loginaction.php" method="post"> 
<table border="0"> 
<tr><td colspan=2><h1>&nbsp;</h1></td></tr> 
<tr><td>Username:</td><td width="800"><input type="text" name="username" maxlength="40"></td>
</tr> 
<tr><td><div align="center">Password:</div></td><td width="800"> 
  
    <div align="left">
      <input type="password" name="pass" maxlength="50">
	  <input type="hidden" name="insert" maxlength="50" value="inserted">  
      </div></td></tr> 
<tr><td colspan="2" align="right"> 
  
    <div align="left">
      <input type="submit" name="submit" value="Login"> 
      </div></td></tr> 
</table> 
</form> 


           
            <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <th class="style6" scope="row" ><span class="style9 style13">If you don not have a username, useone of the  links below to register </span></th>
                </tr>
                <tr>
                  <th scope="row">
                  <div class="style7" align="left">
                    <p align="center">&nbsp;</p>
                    <p align="center"><a href="registration_applicant.php" class="body">IRB Applicant Rregistration </a></p>
                    <p align="center"><a href="registration_Reviewer.php" class="body">IRB Reviewer Registration</a></p>
                    <p align="center"><a href="registration_IRB.php">OSP IRB Administrator Registration</a> </p>
                    </div>                  </th>
                </tr>
              </tbody>
            </table>
            </td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top; height: 60px;">
      <div align="center"><span class="style7"><br>
        <span class="style7"><br>
Office of Sponsored Programs<br>
For questions regarding application submission contact: OSP at <a href="mailto:ospinfo@txstate.edu">ospinfo@txstate.edu</a> , x 2314 </span></div>
      </td>
    </tr>
  </tbody>
</table>


</body>
</html>
