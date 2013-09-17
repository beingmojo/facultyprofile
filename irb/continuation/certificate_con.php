<?php require_once('../Connections/con3.php'); ?>
<?php

session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}
$un_Recordset1 = "";
if (isset($_SESSION['username'])) {
  $un_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['username'] : addslashes($_SESSION['username']);
}


$ID = $_GET['ID'];


mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT ID, App_Number, ApprovalDate, username from continuation WHERE ID='".$ID."'";

$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$app=$row_Recordset1['username'];

mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT `user`.FirstName, `user`.LastName FROM `user` where username = '".$app."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$name = $row_Recordset2['FirstName']." ".$row_Recordset2['LastName'];
$finalDate = "";
$expDate="";

			
				$finalDate = $row_Recordset1['ApprovalDate'];
		
		
			$finalDate=str_replace('-', '/',$finalDate);
			$finalDate=date("m/d/y",strtotime($finalDate));
			$expDate=date("m/d/y",strtotime($finalDate) + 365*60*60*24);
			
	//} //end if		
			
// outputs "The first date is earlier than the second."
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Texas State University-San Marcos | IRB Online Application</title>
<style type="text/css">
<!--
.style2 {
	font-size: 18px;
	font-weight: bold;
	font-family: Garamond;
}
.style3 {font-family: Garamond}
.style4 {
	font-size: 36px;
	font-family: Garamond;
	font-weight: bold;
}
.style6 {font-size: 24px; font-family: Garamond; font-weight: bold; }
.style8 {
	font-family: Garamond;
	font-size: 36px;
}
.style11 {
	color: #663300;
	font-size: 42px;
	font-family: Garamond;
}
.style12 {font-size: 24px; font-family: Garamond; font-weight: bold; color: #993300; }
.style13 {font-family: Garamond}
-->
</style>
</head>

<body>
<div align="center">
<table width="650" border="3" cellpadding="0" cellspacing="0" bordercolor="#330000"><tr><td>
    <div align="center">
      <table width="650" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
        <tr><td>
          <div align="center">
            <table>
              <tr>
                <td width="633" valign="middle" bgcolor="#FFFFFF"><p align="center" class="style6"><img src="../TXST_Primary_3Color_RGB.gif" alt="logo"/></p>
                      <p align="center" class="style12 style13">      Institutional Review Board</p>
                      <p align="center" class="style12">Continuation/Change</p>
                      <p align="center" class="style4 style11"> Certificate of Approval</p>
                      <p align="center" class="style2">Applicant: <?php echo $name;?><br />
                        <br />
                        <strong>Original IRB Application Number :  <?php echo $row_Recordset1['App_Number'];?></strong>
						<br />
                        <strong class="style3"></p>
                      
                    <p align="center" class="style13"><strong>Date of Approval: <?php echo $finalDate; ?> </strong></p>
                    <p align="center" class="style13"><strong>Expiration Date: <?php echo $expDate; ?></strong></p></td>
              </tr><tr><td><p align="right" class="style3"><br />
                      <br />
                      </p>                  
                  <img src="../sigline.gif" alt="Signature" width="606" height="128" /></td>
              </tr>
            </table>
          </div></td></tr>
      </table>
  </div></td></tr></table>
<p align="center"><a href="<?php echo $_SESSION['../myhome'];?>">Return to IRB Home</a></p>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($Recordset1);
?>
