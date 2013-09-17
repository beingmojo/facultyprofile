<?php require_once('Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "IRB Staff")) {   
 
  //header("Location: ". $restrictGoTo); 
 // exit;
//}

if (!($_SESSION['User_Type'] == "IRB Chair")) {   
 
  header("Location: ". $restrictGoTo); 
  exit;
}
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

//catch info from assign reviewer page

 $appNum = $_GET['appNum'];

$rev=$_GET['id'];
$oldID=$_GET['oldID'];

$query_Recordset = "SELECT irbActionLog, username FROM application WHERE App_Number = '".$appNum."'";
$Recordset = mysql_query($query_Recordset, $con) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);

 
$query_Recordset1 = "SELECT `user`.username,`user`.FirstName, `user`.LastName,`user`.Department, `user`.User_Type, `user`.Email FROM `user` WHERE `user`.username = '".$oldID."'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//**************************submit info from self*********************



  $today = date("m-d-y");
  $newaction=$query_Recordset['irbActionLog']."<br>".$today."  ".$_SESSION['username'].":<br>";
 
 $newaction = $newaction."Removed reviewer <em>".$row_Recordset1['FirstName']." ".$row_Recordset1['LastName']."</em> from the application.<br>";
 //echo "Reviewer has been changed from <em>".$revChange."</em> to <em> ".$revID.".<br>";
 if ($rev=='rev1ID'){
 $query_Recordset2 = "SELECT rev2ID, rev3ID, rev2Comments, rev2Approved, rev2ApprovedDate, rev3Comments, rev3Approved, rev3ApprovedDate FROM application WHERE App_Number = '".$appNum."'";
$Recordset2 = mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset = mysql_num_rows($Recordset2);
 
 $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, rev1ID=%s,rev1Comments=%s, rev1Approved=%s, rev1ApprovedDate=%s, rev2ID=%s, rev2Comments=%s, rev2Approved=%s, rev2ApprovedDate=%s,rev3ID=%s, rev3Comments=%s, rev3Approved=%s, rev3ApprovedDate=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), 
 GetSQLValueString($row_Recordset2['rev2ID'],"text"), 
 GetSQLValueString($row_Recordset2['rev2Comments'],"text"), 
 GetSQLValueString($row_Recordset2['rev2Approved'],"text"),
 GetSQLValueString($row_Recordset2['rev2ApprovedDate'],"text"),
 GetSQLValueString($row_Recordset2['rev3ID'],"text"),
 GetSQLValueString($row_Recordset2['rev3Comments'],"text"),
 GetSQLValueString($row_Recordset2['rev3Approved'],"text"),
 GetSQLValueString($row_Recordset2['rev3ApprovedDate'],"text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString("","text"),
 GetSQLValueString($appNum, "text"));
 if ($Recordset2)
 mysql_free_result($Recordset2);
 /*
  $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, rev1ID=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), GetSQLValueString("","text"), GetSQLValueString($appNum, "text"));
  */
 }
 
  if ($rev=='rev2ID'){
   $query_Recordset2 = "SELECT rev3ID, rev3Comments, rev3Approved, rev3ApprovedDate FROM application WHERE App_Number = '".$appNum."'";
$Recordset2 = mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset = mysql_num_rows($Recordset2);
 
 $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, rev2ID=%s, rev2Comments=%s, rev2Approved=%s, rev2ApprovedDate=%s, rev3ID=%s, rev3Comments=%s, rev3Approved=%s, rev3ApprovedDate=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), 
 GetSQLValueString($row_Recordset2['rev3ID'],"text"),
 GetSQLValueString($row_Recordset2['rev3Comments'],"text"),
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
 
 //email notification to the new reviewer
  $subject = "Review IRB Application: ". $appNum;
 $headers = "From: ospinfo@txstate.edu";
$body = "\r\rThis email message is generated by the IRB online application program. Do not reply.\r\rYou do not need to evaluate the IRB Application that was assigned to you earlier. The application number is ".$appNum.". If you have any questions please contact IRB chair(s) immediately.";


	$to=$row_Recordset1['Email'];
	mail($to,$subject,$body,$headers);
	
	 header("Location: assignReviewer.php"); 
  exit;
//****************************after delete****
 mysql_free_result($Recordset);
$query_Recordset = "SELECT irbActionLog, username, Status, trainingFinished, rev1ID, rev2ID, rev3ID FROM application WHERE App_Number = '".$appNum."'";
$Recordset = mysql_query($query_Recordset, $con) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);

?>
<script>
function deleteConfirm(a,b,c)
{
if (confirm('Are you sure you want to remove this reviewer from the application? Doing so, the the evaluations/comments that the reviewer ever made to this application will be removed permanently from the record of this application.')){
dirlocation="deleteReviewerAss.php?oldID="+a+"&appNum="+b+"&id="+c;
document.location.href=dirlocation;
}
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Application</title>
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
.style37 {
	color: #FFFFFF;
	font-weight: bold;
}
.style44 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style45 {font-size: small}
.style46 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" >
 <tbody>
    <tr>
      <td height="150" valign="top" width="800">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tbody>
          <tr>
            <td rowspan="3" valign="top"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a></td>
            <td width="113" rowspan="3" valign="top" bgcolor="#330000" class="style4"><br>  </td>
            <td width="45" height="38" bgcolor="#330000">&nbsp;</td>
            <td width="346" valign="top" bgcolor="#330000">
            <div class="style5" align="right"><font color="#336699"><br>
</font></div>            </td>
          </tr>
          <tr>          </tr>
          <tr>
            <td height="18" bgcolor="#330000"><br>            </td>
            <td valign="top" bgcolor="#330000">
            <div class="style7" align="right"><a href="LogOut.php"><span class="style37">Log
Out</span> </a></div>            </td>
          </tr>
          <tr>
            <td colspan="4" height="21" valign="top">
            <div align="center">
              <p class="style6">&nbsp;</p>
              <p><a class="irb" href="index.php"><span class="style21"><strong>Institutional Review Board</strong></span></a> </p>
              <p class="style6">Online Application              </div>            </td>
          </tr>
          <tr>
            <td colspan="4" height="19" valign="top"><hr>
              <div align="center" class="style45"><span class="style46"><a href='osp_irb_home.php'>OSP IRB Home</a> | <a href="assignReviewer.php?appNum=<?php echo $appNum;?>">Assign Reviewer(s)</a> | <a href="irb_updatestatus.php?appNum=<?php echo $appNum;?>"> Update Application Status</a> | <a href="irb_emailApp.php?appNum=<?php echo $appNum;?>" class="style46">Email Applicant Comments/Request </a></span><span class="style44"><br>
              </span>
                <hr>
              </div></td>
          </tr>
        </tbody>
      </table>      </td>
    </tr>
</tbody></table>

<span class="style46">
<table width="800" height="300" border="0" align="center" bgcolor="#eeeeee" table>
</span>
<tr><td> 
  <p>
    <?php
echo "<font color='red'>Reviewer <em>".$row_Recordset1['FirstName']." ".$row_Recordset1['LastName']."</em> removed from the application.</font>" ;

 //echo "<em>".$revChange."</em> was replace by <em> ".$revID."</em><br></font>";

?>
  </p>
  <p><a href="addReviewer.php?appNum=<?php echo $appNum;?>">Add Reviewers</a>  </p></td></tr>
<tr><td> <b>Reviewered Assigned</b></td></tr>
<tr>
<?php
if($row_Recordset['Status'] == "Approved")
die("<font color='red'>The application has been approved. You cannot make any changes on the revieweres of this application.</font>");

if($row_Recordset['rev1ID'] && $row_Recordset['rev1ID']!="Removed")
{
$rev1ID=$row_Recordset['rev1ID'];
$query_Recordset2 = "SELECT `user`.username,`user`.FirstName, `user`.LastName,`user`.Department, `user`.User_Type FROM `user` WHERE `user`.username = '".$rev1ID."'";
$Recordset2 = mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
echo "<tr><td align='center'>".$row_Recordset2['FirstName']." ".$row_Recordset2['LastName'].", ".$row_Recordset2['Department']; 
mysql_free_result($Recordset2);
?>
</td><td><input type='button' value='Change Reviewer' onclick="location.href='changeReviewer.php?oldID=<?php echo $rev1ID;?>&appNum=<?php echo $appNum;?>&id=rev1ID'">

</td>
<td><input type='button' value='Remove Reviewer' onClick="deleteConfirm('<?php echo $rev1ID;?>','<?php echo $appNum;?>','rev1ID')">
 </td></tr>


<?php
}
//********************************
if($row_Recordset['rev2ID'])
{
$rev2ID=$row_Recordset['rev2ID'];
$query_Recordset2 = "SELECT `user`.username,`user`.FirstName, `user`.LastName,`user`.Department, `user`.User_Type FROM `user` WHERE `user`.username = '".$rev2ID."'";
$Recordset2 = mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
echo "<tr><td align='center'>".$row_Recordset2['FirstName']." ".$row_Recordset2['LastName'].", ".$row_Recordset2['Department']; 
mysql_free_result($Recordset2);
?>
</td><td><input type='button' value='Change Reviewer' onclick="location.href='changeReviewer.php?oldID=<?php echo $rev2ID;?>&appNum=<?php echo $appNum;?>&id=rev2ID'">
 
</td>
<td><p>
  <input type='button' value='Remove Reviewer' onClick="deleteConfirm('<?php echo $rev2ID;?>','<?php echo $appNum;?>','rev2ID')">

</p>
  </td></tr>


<?php
}

if($row_Recordset['rev3ID']&&$row_Recordset['rev3ID']!="Removed")
{
$rev3ID=$row_Recordset['rev3ID'];
$query_Recordset2 = "SELECT `user`.username,`user`.FirstName, `user`.LastName,`user`.Department, `user`.User_Type FROM `user` WHERE `user`.username = '".$rev3ID."'";
$Recordset2 = mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
echo "<tr><td align='center'>".$row_Recordset2['FirstName']." ".$row_Recordset2['LastName'].", ".$row_Recordset2['Department']; 
mysql_free_result($Recordset2);
?>
</td><td><input type='button' value='Change Reviewer' onclick="location.href='changeReviewer.php?oldID=<?php echo $rev3ID;?>&appNum=<?php echo $appNum;?>&id=rev3ID'">
</td>
<td><input type='button' value='Remove Reviewer' onClick="deleteConfirm('<?php echo $rev3ID;?>','<?php echo $appNum;?>','rev3ID')"></td></tr>


<?php
}

?>


</body>
</html>
<?php
mysql_free_result($Recordset);
//mysql_free_result($Recordset);
//mysql_free_result($Recordset2);
?>
