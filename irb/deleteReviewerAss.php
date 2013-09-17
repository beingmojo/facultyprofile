<?php require_once('Connections/dbc.php');
session_start();
require_once('variables/variables.php');

$restrictGoTo = "unauthorized.php";

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



if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "IRB Staff")) {   
 

	if (!($_SESSION['User_Type'] == "IRB Chair")) {   
 
  	header("Location: ". $restrictGoTo); 
 	 exit;
	}
}


//catch info from assign reviewer page

 $appNum = $_GET['appNum'];

$rev=$_GET['id'];
$oldID=$_GET['oldID'];

$query_Recordset = "SELECT irbActionLog, Status, username FROM application WHERE App_Number = '".$appNum."'";
$Recordset = mysql_query($query_Recordset, $con) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);
if(trim($row_Recordset) == "Approved")
die("The application has been approved. You cannot make any changes on the revieweres.");


 $theValue = (!get_magic_quotes_gpc()) ? addslashes($oldID) : $oldID;
$query_Recordset1 = "SELECT `user`.username,`user`.FirstName, `user`.LastName,`user`.Department, `user`.User_Type, `user`.Email FROM `user` WHERE `user`.username = '".$theValue."'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//***********************************************

$today=date("m/d/y H:i:s");
  $newaction=$row_Recordset['irbActionLog']."<br>".$today."  ".$_SESSION['username'].":<br>";
 
 $newaction = $newaction."Removed reviewer <em>".$row_Recordset1['FirstName']." ".$row_Recordset1['LastName']."</em> from the application.<br>";
 //echo "Reviewer has been changed from <em>".$revChange."</em> to <em> ".$revID.".<br>";
 if ($rev=='rev1ID'){
 $query_Recordset2 = "SELECT rev2ID, rev3ID, rev2Comments, rev2Approved, rev2ApprovedDate, rev3Comments, rev3Approved, rev3ApprovedDate FROM application WHERE App_Number = '".$appNum."'";
$Recordset2 = mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset = mysql_num_rows($Recordset2);
 
 $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, rev1ID=%s,rev1Comments=%s, rev1Approved=%s, rev1ApprovedDate=%s, rev2ID=%s, rev2Comments=%s, rev2Approved=%s, rev2ApprovedDate=%s,rev3ID=%s, rev3Comments=%s, rev3Approved=%s, rev3ApprovedDate=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), 
 GetSQLValueString($row_Recordset2['rev2ID'],"text"), 
 GetSQLValueString(str_replace("'", " ", $row_Recordset2['rev2Comments']),"text"), 
 GetSQLValueString($row_Recordset2['rev2Approved'],"text"),
 GetSQLValueString($row_Recordset2['rev2ApprovedDate'],"text"),
 GetSQLValueString($row_Recordset2['rev3ID'],"text"),
 GetSQLValueString(str_replace("'", " ",$row_Recordset2['rev3Comments']),"text"),
 GetSQLValueString($row_Recordset2['rev3Approved'],"text"),
 GetSQLValueString($row_Recordset2['rev3ApprovedDate'],"text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString($appNum, "text"));
 if ($Recordset2)
 mysql_free_result($Recordset2);

 }
 
  if ($rev=='rev2ID'){
   $query_Recordset2 = "SELECT rev3ID, rev3Comments, rev3Approved, rev3ApprovedDate FROM application WHERE App_Number = '".$appNum."'";
$Recordset2 = mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset = mysql_num_rows($Recordset2);
 
 $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, rev2ID=%s, rev2Comments=%s, rev2Approved=%s, rev2ApprovedDate=%s, rev3ID=%s, rev3Comments=%s, rev3Approved=%s, rev3ApprovedDate=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), 
 GetSQLValueString($row_Recordset2['rev3ID'],"text"),
 GetSQLValueString(str_replace("'", " ",$row_Recordset2['rev3Comments']),"text"),
 GetSQLValueString($row_Recordset2['rev3Approved'],"text"),
 GetSQLValueString($row_Recordset2['rev3ApprovedDate'],"text"),
  GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString($appNum, "text"));
 if ($Recordset2){
 	mysql_free_result($Recordset2);
  
		}
 }
  if ($rev=='rev3ID'){
  $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, rev3ID=%s, rev3Comments=%s, rev3Approved=%s, rev3ApprovedDate=%s WHERE App_Number=%s", 
  GetSQLValueString($newaction, "text"), 
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString($appNum, "text"));
 
 }
 
 $Result1 = mysql_query($insertSQL, $con) or die(mysql_error());
 $subject = "Review IRB Application: ". $appNum;
// $headers = "From: ospinfo@txstate.edu";
$body = "\r\nThis email message is generated by the IRB online application program. Do not reply.\r\nYou do not need to evaluate the IRB Application that was assigned to you earlier. The application number is ".$appNum.". If you have any questions please contact IRB chair(s) immediately.";
$body = $body.$emailSig;

	$to=$row_Recordset1['Email'];
		//$substring = "@txstate.edu"; 
mysql_free_result($Recordset);
	mysql_free_result($Recordset1);
//if (strpos($to, $substring) == true) {
   // '$substring' is found in '$string';

	mail($to,$subject,$body,$headers);
	
	header("Location: assignReviewer.php?appNum=".$appNum); 
  exit;
//}

/*
else
 {
 ?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="irbstyle.css" rel="stylesheet" type="text/css">


  <style type="text/css">
<!--
.style43 {font-size: large}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="tbbg.gif" >

   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left" class="style6 style24"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           
            </p>
            </span></td>
   </tr>
</table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
          <tr>
            <td colspan="3" height="19" valign="top" bgcolor="#000000">
			  <div align="center"><span class="style46"><a href='osp_irb_home.php' class="irb">My IRB Home</a> </span><span class="style39">|</span><span class="style46"> <a href="appSummary_irb.php?appNum=<?php echo $appNum;?>" class="irb">Review Application Data</a> </span><span class="style39">|</span><span class="style46"> <a href="statSummary.php?appNum=<?php echo $appNum;?>" class="irb">Summary of Status, Evaluations and Action Logs</a></span><br>
			  <a href="assignReviewer.php?appNum=<?php echo $appNum;?>" class="irb">Assign/Change Reviewer(s)</a> </span><span class="style39">|</span><span class="style46"> <a href="irb_updatestatus.php?appNum=<?php echo $appNum;?>" class="irb"> Update Application Status</a> </span><span class="style39">|</span> <a href="irb_emailApp.php?appNum=<?php echo $appNum;?>" class="irb">Send Comments/Requests to Applicant </a> <span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a> </div></td>
          </tr>

      </table>
      </td>
  </tr>
  <tr><td align="center"><div align="center" class="style3">
    <p>&nbsp;</p>
    <p>ADD A REVIEWER TO IRB APPLICATION</p>
  </div></td>
</tr>
<tr><td align="center" class="style49"><div align="center" class="style46">
  <p>&nbsp;</p>
  <p>Application Number: <?php echo $appNum;?>
    </p>
</div>
<tr><td class="style49">
<?php

   // '$substring' is not found in '$string';

   echo("<p><br>The reviewer removed does not have a Texas State University email address. Click Notice Reviewer to inform him/her about the change. <a href='mailto:".$to."?subject=Review IRB application: ".$appNum."&body=You do not need to review the IRB Application that was assigned to you previously. The application number is ".$appNum.".'>Notice Reviewer</a><br><br>");
   }
   */
?>
