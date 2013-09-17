<?php require_once('Connections/con3.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

if (!($_SESSION['User_Type'] == "IRB Chair" || $_SESSION['User_Type'] == "IRB Staff") || $_SESSION['User_Type'] == "reviewer")) {   
 
  header("Location: ". $restrictGoTo); 
  exit;
//THis is the one that will be used for both REV and IRB Admin and IRB Chairs

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

$time = date("m-d-y");


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$appNum=$_POST['appNum'];
	
	//**************************************************************
	$today = date("m-d-y");
	 $newaction=$today."  ".$_SESSION['username'].":<br>";
	 $newaction = $newaction."Email From: ".$_POST['fromEmail']."To:  ".$_POST['toEmail']. "Subject: ".$_POST['subject'];
	
	$msg=$_POST['msg'];
	/*
	if ($_POST['appNum'] !=""){
	
  $updateSQL = sprintf("UPDATE application SET irbActionLog=%s WHERE App_Number=%s",GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['appNum'], "text"));

  mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($updateSQL, $con3) or die(mysql_error());
  
  }
  */
  $headers="From: ".$_POST['fromEmail'];
	$to = $_POST['toEmail'];
$headers = "From: ospinfo@txstate.edu";
	$body = "\r\rThis email message is generated by the IRB online application program. Do not reply.\r\r".$_POST['msg'];
    
	$subject = $_POST['subject'];

	mail($to,$subject,$body,$headers);
	
	// copy to oneself
  $to = $_SESSION['Email'];
	mail($to,$subject,$body, $headers);


  mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($updateSQL, $con3) or die(mysql_error());

$insertSQL = sprintf("INSERT INTO messages (EmailTime, FromEmail, ToEmail, Subject, Msg, appNum, Time) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($today, "text"),
					    GetSQLValueString($_POST['fromEmail'], "text"),
						 GetSQLValueString($_POST['toEmail'], "text"), 
						 GetSQLValueString($_POST['subject'], "text"),
						  GetSQLValueString($_POST['msg'], "text"),
						   GetSQLValueString($_POST['appNum'], "text"), 
						     GetSQLValueString($today, "text"));
						
		 mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($insertSQL, $con3) or die(mysql_error());
  }

//********************************************************************************
mysql_select_db($database_con3, $con3);
$query_Recordset = "SELECT `user`.Email FROM `user` where username='".$_SESSION[['username']."'";
$Recordset = mysql_query($query_Recordset, $con3) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);


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
.style14 {font-size: small}
body {
	background-color: #cccccc;
}
.style16 {
	color: #FFFFFF;
	font-weight: bold;
}
.style21 {font-size: 12px}
.style44 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style46 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
-->
  </style>
</head>
<body><table width="800" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="5" cellspacing="0" >
<tbody>
   <tr>
            <td valign="top" bgcolor="#330000"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a></td>
            <td width="99" valign="top" bgcolor="#330000" class="style4"><br>            </td>
            <td bgcolor="#330000">
              <div class="style7" align="right"><a href="LogOut.php" class="style14 style16">Log
Out</a></div></td>
          </tr>
          
        <tr>
            <td colspan="3" height="21" valign="top">
            <div align="center">
              <p>&nbsp;</p>
              <p><a class="irb" href="index.php"><span class="style21"><strong>Institutional Review Board</strong></span></a>              </p>
              <p class="style6">Online Application
              <hr>
            </div></td>
          </tr>
          <tr>
            <td colspan="3" height="19" valign="top">
			  <div align="center"><span class="style46">
			  <div align="center"><?php if ($_SESSION['User_Type'] == "reviewer") echo "<a href='reviewer_Home.php'>"; ?><?php if ($_SESSION['User_Type'] == "IRB Chair" || $_SESSION['User_Type'] == "IRB Staff") echo "<a href='osp_irb_home.php'>"; ?>OSP IRB Home</a> </div></td>
          </tr>
  </tbody>
      </table>
      </td>
  </tr>
    <tr>
      <td height="348" valign="top"><div align="center">
        <p>IRB Message Center </p>
		<?php
		if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form"))
		echo "<font color='red'>Messeage sent.<br></font>";
		?>
        <p align="left"><b>This is not a dedicated email server.  It is intended to be used for IRB application related communication only. Please write your message as brife as possible.</b></p>
      </div>
	  
        <table width="725"> Send Message<tr><td width="688" > </td></tr>
          <tr><td width="688" >
	   
	    <form name="form1" action="<?php echo $editFormAction; ?>" method="POST">
		<p><br>
		<label>To: 
		<input type="text" name="toEmail">
	        </label>
	      <br>
	      <br>
	      <label>Subject: 
	        <input name="subject" type="text" size="80">
	        </label>
			<br>
			<br>
			Related IRB Application Number: 
			<input name="appNum" ID="appNum" >
	        <br>
	        <br>Message:<br>
	  <textarea name="msg" cols="80" rows="8"><?php echo $time.":\r";?></textarea>
	 
	   
	 <br>
	  <input type="hidden" name="fromEmail" value="<?php echo $row_Recordset['Email']; ?>">
	  <input type="hidden" name="MM_update" value="form1">
	  <input name="submit" type="submit" value="Send Message">
	  </form>
	  
	  
	  </td></tr></table></td>
    </tr></table>
	
	  
</body>
</html>
<?php
mysql_free_result($Recordset);

?>
