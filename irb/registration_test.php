<html>
<head>
<title>IRB Registration Form - IRB Reviewer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function validate(form) {
var e = form.elements, m = '';

if(e['username'].value) {m += '- User Name is required.\n';}
if(!e['Department'].value) {m += '- Department is required.\n';}
if(!e['Phone'].value) {m += '- Phone Number is required.\n';}
if(!/.+@[^.]+(\.[^.]+)+/.test(e['username'].value)) {
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
.style6 {
	font-family: Arial, Helvetica, sans-serif;
	color: #333399;
	font-weight: bold;
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

a.irb:link{
font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;

}
a.irb:visited {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;
}
-->
  </style>
  <style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style21 {
	color: #000066;
	font-size: 16px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style23 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
.style15 {font-weight: bold}
-->
  </style>
</head>
<body text="#000000">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >

    <tr>
      <td height="150" valign="top" width="800">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

          <tr>
            <td valign="top" bgcolor="#330000"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a><br>  </td>
            <td bgcolor="#330000">
              <div align="right"><a href="LogOut.php" class="style33"></a><font color="#336699"><br>
</font></div></td>
        </tr>
          
          
          <tr>
            <td colspan="2" height="21" valign="top">
            <div align="center">
              <p class="style6">&nbsp;</p>
              <p><span class="style17"><a class="irb" href="index.php"
><span class="style21">Institutional Review Board</span><span class="style17"></a></p>
              <p class="style6">Online Application<hr /></p>
              </div>            </td>
          </tr>
          <tr>
           <td colspan="2" height="19" valign="top"><div align="center"><span class="style1"><A href="irbform.php"><hr /></A></span><span class="style15"><a href="registration_applicant.php" class="body">IRB Applicant Rregistration </a> | <a href="registration_Reviewer.php" class="body">IRB Reviewer Registration</a> | <a href="registration_IRB.php" class="body">OSP IRB Administrator Registration </a>| <a href="LogOut.php" class="body">Log Out</a></span></div>
              <A href="LogOut.php">
          <hr></A></td>
          </tr>
     
      </table>
      </td>
    </tr>
<table width="800" align="center" bgcolor="#FFFFFF">
  <tr><td>

<?php 


//This code runs if the form has been submitted
if (isset($_POST['submit'])) { 
$str=$_POST['username'];
if(strpos($str,"'")!== false ||strpos($str,'"')!== false||strpos($str,'\\')!== false||strpos($str,'%')!== false||strpos($str,'%')!== false||strpos($str,'_')!== false||strpos($str,'||')!== false||strpos($str,'&&')!== false||strpos($str,'!')!== false||strpos($str,'&')!== false||strpos($str,'|')!== false||strpos($str,'*')!== false||strpos($str,'$')!== false||strpos($str,')')!== false||strpos($str,')')!== false||strpos($str,'>')!== false||strpos($str,'<')!== false||strpos($str,'?')!== false||strpos($str,'~')!== false||strpos($str,'`')!== false||strpos($str,'^')!== false||strpos($str,'*')!== false||strpos($str,'/')!== false||strpos($str,';')!== false||strpos($str,',')!== false)

echo "You've used invalid character(s) in your user name.";

}
?>
<form name="mainform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return validate(this)">
<div><align=center>
<div align="center"><span class="style15"> IRB Registration</span></div>


  <div align="left">User Name:</div>
    
      <div align="left">
        <input type="text" name="username"> 
<input type="submit" name="submit" value="Register">
</form></div>
 
</body>