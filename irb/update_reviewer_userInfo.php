<?php require_once('Connections/con3.php'); 
session_start();?>

<?php


$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "reviewer")) {   
 
  header("Location: ". $restrictGoTo); 
  exit;
}
?>
<?php
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "mainform")) {
/*
$substring = "@txstate.edu"; 

if (strpos($_POST['Email'], $substring) !== false) {
   // Yes, '$substring' is found in '$string';
   
} 
else {
   die("Registrion failed! You need to use your Texas State University email address. <a href='javascript:history.back()'>Back</a>");
}
*/

  $updateSQL = sprintf("UPDATE user SET password=%s, FirstName=%s, LastName=%s, Phone=%s, Email=%s, User_Type=%s, Department=%s WHERE username=%s",
                       GetSQLValueString($_POST['pass'], "text"),
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['Phone'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['User_Type'], "text"),
                       GetSQLValueString($_POST['Department'], "text"),
                       GetSQLValueString($_POST['username'], "text"));

  mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($updateSQL, $con3) or die(mysql_error());
 
}

//else{
mysql_select_db($database_con3, $con3);
$theValue = (!get_magic_quotes_gpc()) ? addslashes($_SESSION['username']) : $_SESSION['username'];
$query_Recordset1 = "SELECT `user`.password, `user`.FirstName, `user`.LastName, `user`.Phone, `user`.Email, `user`.User_Type, `user`.Department FROM `user` where username='".$theValue."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
if(!e['Phone'].value) {m += '- Phone Number is required.\n';}
if(!e['Department'].value) {m += '- Department field is required.\n';}
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
<table width="800" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
			  <div align="center"><span class="style46">
			  <div align="center" class="style6"><span class="style2"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a></span></div></td>
          </tr></TABLE>
  
  <table width="800" border="0" align="center" bgcolor="#ffffff"><tr><td><table width="650" border="0" align="center" bgcolor="#ffffff">  <tr><td colspan=2> <P align="center"><strong>PERSONAL INFORMATION UPDATE</strong></P></td>
  </tr>
	<?php
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "mainform"))
    echo "<tr><td colspan='2'><font color='red'>Your personal information has been updated.</font></td><tr>";
?> 

<form name="mainform" action="<?php echo $editFormAction; ?>" method="POST"  onsubmit="return validate(this)">

  
    <tr><td colspan=2><input type="hidden" name="User_Type" value="reviewer"></td></tr>

<tr><td>First Name: </td><td ><input type="text" name="FirstName" value="<?php echo $row_Recordset1['FirstName']; ?>">
      
    <tr><td>Last Name: </td><td ><input type="text" name="LastName" value="<?php echo $row_Recordset1['LastName']; ?>"></td></tr>

      </td></tr > 
<tr><td>Phone: </td><td class="style23"><input type="text" name="Phone" value="<?php echo $row_Recordset1['Phone']; ?>">
      </td></tr>
     <tr><td >Email: </td><td ><input type="text" name="Email" value="<?php echo $row_Recordset1['Email']; ?>">
      </td></tr>
  <tr><td class="style23"> Department/Institute:</td><td ><input type="text" name="Department" value="<?php echo $row_Recordset1['Department']; ?>">
      </td></tr>
<tr><td colspan=2 class="style23"><hr></td></tr>
<input type="hidden" name="username" maxlength="60" value="<?php echo $_SESSION['username'];?>">
</td></tr>

<tr><td class="style23">Create Password(Maximum length 10):</td><td><input type="password" name="pass" maxlength="10">
</td></tr>
<tr><td class="style23">Confirm Password:</td><td><input type="password" name="pass2" maxlength="10">
</td></tr>
<tr><TD></TD><td><input type="submit" name="submit" value="Update">
</td></tr> 
<input type="hidden" name="MM_update" value="mainform">
</form>
</table>
<tr><td><br>
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
mysql_free_result($Recordset1);
?>
<p align="center">
<div align="center"><span class="style23">
</span></div>
<span class="style23"><hr align="center" />
             <p>&nbsp;</p>

</td></tr></table></body>
</html>