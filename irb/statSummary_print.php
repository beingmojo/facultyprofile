<?php require_once('Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

if (!($_SESSION['User_Type'] == "IRB Support")) { 
if (!($_SESSION['User_Type'] == "IRB Staff")) { 
  
 if (!($_SESSION['User_Type'] == "IRB Chair")){
  header("Location: ". $restrictGoTo); 
  exit;
  }
}
}

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



$appNum=$_GET['appNum'];
if (isset($_POST['s1'])){ 
$today=date("m/d/y H:i:s");  
 $notes=$_POST['prenotes']."<br><br>".$today." ".$_SESSION['username']."<br>".$_POST['notes'];
 $appNum = $_POST['appNum'];
   $insertSQL = sprintf("UPDATE application SET notes=%s WHERE App_Number=%s", GetSQLValueString($notes, "text"), GetSQLValueString($_POST['appNum'], "text"));
}

$query_Recordset1 = "SELECT ActionFlag, application.App_Number, application.ProjectTitle, application.Status, application.ReviewerID, application.submissionFinishedDate, requestHSPActionDate, application.ReceivedDate, application.ReviewDate, ChairReviewDate, application.RevisionRequestDate, application.ApprovedDate, application.RevisionDate, notes, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate, application.irbActionLog, application.revActionLog, application.appActionLog, ChairReviewDate, submissionFinishedDate, application.irbEmails, notes FROM application where App_Number = '".$appNum."'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$reviewerAssigned = "no";

////////////
 $query = "select * from reviewlog where appNum='".$_GET['appNum']."' order by reviewNum";
  
  $result = mysql_query($query, $con);
  $row = mysql_fetch_assoc($result);
  $numrows=mysql_num_rows($result);
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>

  <style type="text/css">
<!--
.style44 {color: #660000}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
  </td>
  </tr>
    <tr>
      <td height="348" valign="top">
      <table border="0" cellpadding="0" cellspacing="5" width="100%"><tr><td colspan="5"><div align="center">
        <p>&nbsp;</p>
        <p><span class="style3">SUMMARY OF APPLICATION STATUS, EVALUATIONS AND ACTION LOGS</span></p>
        <p><br>
          </p>
      </div></td></tr>
 
<tr><td colspan="3"><span class="style23"><strong>Application Title:</strong> 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td></tr>
<tr><td colspan="3"><span class="style23"><strong>Application Number:</strong> <?php echo $row_Recordset1['App_Number'];?></span></td></tr>

<tr><td colspan="3"><p align="left"><span class="style23"><strong>Status:</strong> <?php echo $row_Recordset1['Status'];?></span></p>
    <blockquote>
      <table width="672" border="1" cellpadding="0" cellspacing="-1">
        <tr>
          <td width="250">Application Submitted Date</td>
          <td width="234">&nbsp;<?php echo $row_Recordset1['submissionFinishedDate'];?></td>
        </tr>
        <tr>
          <td>IRB Administrator Sent Request for HSP Training Date</td>
          <td>&nbsp;<?php echo $row_Recordset1['requestHSPActionDate'];?></td>
        </tr>
        <tr>
          <td>Application Sent to IRB Chairs for Review Date</td>
          <td>&nbsp;<?php echo $row_Recordset1['ChairReviewDate'];?></td>
        </tr>
        <tr>
          <td>Application Sent to Reviewers for Review Date</td>
          <td>&nbsp;<?php echo $row_Recordset1['ReviewDate'];?></td>
        </tr>
        <tr>
          <td>Last Request for Revision Date</td>
          <td>&nbsp;<?php echo $row_Recordset1['RevisionRequestDate'];?></td>
        </tr>
        <tr>
          <td>Last Application Revision/Update Received Date</td>
          <td>&nbsp;<?php echo $row_Recordset1['RevisionDate'];?></td>
        </tr>
        <tr>
          <td>Date of Application Approved by IRB Chairs</td>
          <td>&nbsp;<?php echo $row_Recordset1['ApprovedDate'];?></td>
        </tr>
      </table>
   
    </blockquote></td>
</tr><tr><td colspan="3">
  <strong>Admin/Chair Notes</strong>
<p class="style44">
<?php echo $row_Recordset1['notes'];?>

</td></tr>
<tr><td colspan="3"><span class="style25"> </span><br>
<?php

   $reviewerID1  = $row_Recordset1['rev1ID'];
   if($reviewerID1){ 
   if (!get_magic_quotes_gpc()){$reviewerID1=addslashes($reviewerID1);}}
  // echo "Reviewers: ".$reviewerIDs."<p>";
//$arrReviewerID = explode(",", $reviewerIDs);
//echo "Number of reviewer:".count($arrReviewerID);

$reviewerID2  = $row_Recordset1['rev2ID'];
if($reviewerID2){ 
if (!get_magic_quotes_gpc()){$reviewerID2=addslashes($reviewerID2);}}

$reviewerID3  = $row_Recordset1['rev3ID'];
if($reviewerID3){ 
if (!get_magic_quotes_gpc()){$reviewerID3=addslashes($reviewerID3);}}

////////////////////////////////////////////
if($reviewerID1){ 
$sqlRev=sprintf("SELECT * FROM user where username='%s'", $reviewerID1);

$rev = mysql_query($sqlRev, $con) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev);
//echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName']." / ";
$rev1Name = $rs_rev['FirstName']." ".$rs_rev['LastName'];
mysql_free_result($rev);
}

if($reviewerID2){ 
$sqlRev=sprintf("SELECT * FROM user where username='%s'", $reviewerID2);

$rev = mysql_query($sqlRev, $con) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev);
//echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName']." / ";
$rev2Name = $rs_rev['FirstName']." ".$rs_rev['LastName'];
mysql_free_result($rev);
}

if($reviewerID3){ 
$sqlRev=sprintf("SELECT * FROM user where username='%s'", $reviewerID3);

$rev = mysql_query($sqlRev, $con) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev);
//echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName'];
$rev3Name = $rs_rev['FirstName']." ".$rs_rev['LastName'];
mysql_free_result($rev);
}
 if ($reviewerID1 !=""||$reviewerID2=""||$reviewerID3!="")
 {

$reviewerAssigned="yes";
 
 }
?>
<hr>
<span class="style3"><strong>Current Reviewers' Evaluation Results</strong></span><br>
<blockquote>
<table cellspacing="-1" border="1" width="550">
  <tr><td>Names of the Reviewers </td>
<?php 
if ($reviewerAssigned == "no") echo "<td colspan='3'><align='center'>No Reviewer Assigned</td>";
else {
?>

<td><div align="left"><?php echo $rev1Name;?></div></td><td><?php echo $rev2Name;?></td><td>&nbsp;<?php echo $rev3Name;?></td>
<?php
}
?>

</tr>
<tr><td>Approved?</td><td><div align="left">&nbsp;<?php echo $row_Recordset1['rev1Approved'];?></div></td><td>&nbsp;<?php echo $row_Recordset1['rev2Approved'];?></td><td>&nbsp;<?php echo $row_Recordset1['rev3Approved'];?></td></tr>
<tr>
  <td>Date of Approval </td>
  <td><div align="left">&nbsp;<?php echo $row_Recordset1['rev1ApprovedDate'];?></div></td><td>&nbsp;<?php echo $row_Recordset1['rev2ApprovedDate'];?></td><td>&nbsp;<?php echo $row_Recordset1['rev3ApprovedDate'];?></td></tr></table></blockquote>
<p><strong><span class="style3">Reviewers' Evaluation Log </strong></p>
<blockquote>
<?php
 echo "<table border = '1'><tr><td>Reviewer 1 Finished</td><td>Reviewer 2 Finished</td><td>Reviewer 3 Finished</td><td>Reviewer 1 Approved?</td><td>Reviewer 2 Approved?</td><td>Reviewer 3 Approved?</td><td>Review Round</td><td>Has Chair Been Notified?</td></tr>";
  do{
  
  echo "<tr><td>&nbsp;".$row['rev1Finished']."</td><td>&nbsp;".$row['rev2Finished']."</td><td>&nbsp;".$row['rev3Finished']."</td><td>&nbsp;".$row['rev1Approved']."</td><td>&nbsp;".$row['rev2Approved']."</td><td>&nbsp;".$row['rev3Approved']."</td><td>&nbsp;".$row['reviewNum']."</td><td>&nbsp;".$row['noticeChair']."</td></tr>";
  
  
  }while ($row = mysql_fetch_assoc($result));
echo "</table>";
mysql_free_result($result);
?></blockquote>

<hr><b>Action Log</b><P>
<?php
echo $row_Recordset1['irbActionLog'];

?>

<hr><b>Reviewers' Comments Log</b><br><br>

<?php
if ($row_Recordset1['rev1Comments']){
echo $rev1Name."<br>";

echo str_replace("\r", "<br>", $row_Recordset1['rev1Comments'])."<br>";
}
if ($row_Recordset1['rev2Comments']){
echo "<br>".$rev2Name."<br>";

echo str_replace("\r", "<br>",$row_Recordset1['rev2Comments'])."<br>";
}
if ($row_Recordset1['rev3Comments']){

echo str_replace("\r", "<br>",$row_Recordset1['rev3Comments']);
 }

?>

<hr><b>IRB Administrator/Chairs Email Messages to Applicant</b><br><br>
<?php
if ($row_Recordset1['irbEmails']){

echo str_replace("\r", "<br>",$row_Recordset1['irbEmails']);

}
?>
<br></td> 
</tr>


  <?php
 // mysql_free_result($rev);
   
   ?>
   </table><tr><td><br><br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr></table>
   
  <?php
mysql_free_result($Recordset1);
?>
   

