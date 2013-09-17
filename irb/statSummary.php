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
 
$Result1 = mysql_query($insertSQL, $con) or die(mysql_error());

////////////////////////////
   $insertSQL = sprintf("insert into notelog (appNum, enterTime, msg) values (%s,%s,%s)", GetSQLValueString($appNum, "text"), GetSQLValueString($today, "text"), GetSQLValueString($_POST['notes'], "text"));
 
$Result1 = mysql_query($insertSQL, $con) or die(mysql_error());
}

$query_Recordset1 = "SELECT ActionFlag, application.App_Number, application.ProjectTitle, application.Status, facultyCertified, application.ReviewerID, application.submissionFinishedDate, requestHSPActionDate, application.ReceivedDate, application.ReviewDate, ChairReviewDate, application.RevisionRequestDate, application.ApprovedDate, lastApprovalDate, continuationID, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate, application.irbActionLog, application.revActionLog, application.appActionLog, ChairReviewDate, submissionFinishedDate, application.irbEmails, application.notes, numContinued, facultyReviewDate FROM application where App_Number = '".$appNum."'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$reviewerAssigned = "no";

  /////////////////////////////////
  
 $query = "select * from reviewlog where appNum='".$_GET['appNum']."' order by reviewNum";
  
  $result = mysql_query($query, $con);
  $row = mysql_fetch_assoc($result);
  $numrows=mysql_num_rows($result);
 // echo $numrows."<br>";
	 

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="irbstyle.css" rel="stylesheet" type="text/css">
  <script>
function showT(c,f){
if(c.checked){
f.notes.style.visibility="visible"
f.s1.style.visibility = "visible"
}
else{f.notes.style.visibility="hidden"
f.s1.style.visibility = "hidden"
}
}
</script>
  <style type="text/css">
<!--
.style43 {font-size: large}
.style45 {color: #990000}
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
           
            </p>
            </span></td>
   </tr>
</tbody></table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
          <tr>
            <td colspan="3" height="19" valign="top" bgcolor="#000000">
			  <div align="center"><span class="style46"><a href='osp_irb_home.php' class="irb">My IRB Home</a> </span><span class="style39">|</span><span class="style46"> <a href="appSummary_irb.php?appNum=<?php echo $appNum;?>" class="irb">Review Application Data</a> </span><span class="style39">|</span><span class="style46"> <a href="statSummary.php?appNum=<?php echo $appNum;?>" class="irb">Summary of Status, Evaluations and Action Logs</a></span><br>
			  <a href="assignReviewer.php?appNum=<?php echo $appNum;?>" class="irb">Assign/Change Reviewer(s)</a> </span><span class="style39">|</span><span class="style46"> <a href="irb_updatestatus.php?appNum=<?php echo $appNum;?>" class="irb"> Update Application Status</a> </span><span class="style39">|</span> <a href="irb_emailApp.php?appNum=<?php echo $appNum;?>" class="irb">Send Comments/Requests to Applicant </a> <span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a> </div></td>
          </tr>
  </tbody>
      </table>
      </td>
  </tr>
    <tr>
      <td height="348" valign="top">
      <table border="0" cellpadding="0" cellspacing="5" width="100%"><tr><td colspan="5"><div align="center">
        <p>&nbsp;</p>
        <p><span class="style3">SUMMARY OF APPLICATION STATUS, EVALUATIONS AND ACTION LOGS</span></p>
        <p><a href="statSummary_print.php?appNum=<?php echo $appNum;?>" target="_blank">Print Current Page</a> </p>
        <p><br>
          </p>
      </div></td></tr>
 
<tr><td colspan="3"><span class="style23"><strong>Application Title:</strong> 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td></tr>
<tr><td colspan="3"><span class="style23"><strong>Application Number:</strong> <?php echo $row_Recordset1['App_Number'];?></span></td></tr>

<tr><td colspan="3"><p align="left"><span class="style23"><strong>Status:</strong> <?php echo $row_Recordset1['Status'];?></span></p>
<p align="left"><span class="style23"><strong>Last Approval Date:</strong> <?php echo $row_Recordset1['lastApprovalDate'];?></span></p>
<?php if($row_Recordset1['continuationID']<>"") 
{
echo "     <strong>Last Continuation/Change Request ID:</strong> ".$row_Recordset1['continuationID'];
}
?>
   <p align="left"><span class="style23"><strong>Faculty Approved Submission? </strong><?php echo $row_Recordset1['facultyCertified'];?> </span></p>
    <hr>
    <blockquote>
      <table width="672" border="1" cellpadding="0" cellspacing="-1">
        <tr>
          <td width="250">Application Submitted Date</td>
          <td width="234">&nbsp;<?php echo $row_Recordset1['submissionFinishedDate'];?></td>
        </tr>
		 <?php if ($row_Recordset1['facultyReviewDate']) {
		  ?><tr>
         
		  <td width="250">Faculty Review Date</td>
          <td width="234">&nbsp;<?php echo $row_Recordset1['facultyReviewDate'];?></td>
        </tr>
		<?php }?>
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

  <span class="style45"><?php echo $row_Recordset1['notes'];?></span>
<p><form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<input type="hidden" name="appNum" id="appNum" value="<?php echo $appNum;?>">
<input type="hidden" name="prenotes" id="prenotes" value="<?php echo $row_Recordset1['notes'];?>">
Add notes to the application? <input type="checkbox" onclick="showT(this,this.form)">
<textarea name = "notes" cols="80" rows="2" style="visibility:hidden" ></textarea>
<br><input name="s1" type="submit" style="visibility:hidden" value="Add Notes">
</form>
</td></tr>
<tr><td colspan="3">
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
<span class="style3">Current Reviewers' Evaluation Results</span><br>
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
  <td><div align="left">&nbsp;<?php echo $row_Recordset1['rev1ApprovedDate'];?></div></td><td>&nbsp;<?php echo $row_Recordset1['rev2ApprovedDate'];?></td><td>&nbsp;<?php echo $row_Recordset1['rev3ApprovedDate'];?></td></tr></table>

</blockquote><p><span class="style3">Reviewers' Evaluation Log </span></p>
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
echo $rev1Name."<br><textarea cols='80' rows='8'>";

echo $row_Recordset1['rev1Comments']."</textarea><br>";
}
if ($row_Recordset1['rev2Comments']){
echo "<br>".$rev2Name."<br><textarea cols='80' rows='8'>";

echo $row_Recordset1['rev2Comments']."</textarea><br>";
}
if ($row_Recordset1['rev3Comments']){
echo "<br>".$rev3Name."<br><textarea cols='80' rows='8'>";
echo $row_Recordset1['rev3Comments']."</textarea><br>";
 }

?>

<hr><b>IRB Administrator/Chairs Email Messages to Applicant</b><br><br>
<?php
if ($row_Recordset1['irbEmails']){
echo "<br><textarea cols='80' rows='10'>";
echo $row_Recordset1['irbEmails'];
echo "</textarea><br>";
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
   

