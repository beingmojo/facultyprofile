<?php require_once('Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}



if (!($_SESSION['User_Type'] == "IRB Staff")) { 
  
 if (!($_SESSION['User_Type'] == "IRB Chair")){
  header("Location: ". $restrictGoTo); 
  exit;
  }
}
?>
<?php
if($_GET['appNum']) 
$appNum=$_GET['appNum'];

else
$appNum=$_POST['appnumber'];
$query_Recordset1 = "SELECT username, ActionFlag, application.App_Number, application.ProjectTitle, application.Status, facultyCertified, application.ReviewerID, application.submissionFinishedDate, requestHSPActionDate, application.ReceivedDate, application.ReviewDate, application.RevisionRequestDate, application.ApprovedDate, lastApprovalDate, continuationID, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate, application.irbActionLog, application.revActionLog, application.appActionLog, ChairReviewDate, submissionFinishedDate, application.irbEmails, numContinued, facultyReviewDate FROM application where App_Number = '".$appNum."'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$reviewerAssigned = "no";
	
    $applicant = $row_Recordset1['username'];
  
  if (!get_magic_quotes_gpc()) {
$applicant = addslashes($applicant);
		}

   $sql2 = sprintf("SELECT * FROM user WHERE username = '%s'", $applicant);
$appUser = mysql_query($sql2, $con) or die(mysql_error());
$rs_User = mysql_fetch_assoc($appUser);
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
      <table border="0" cellpadding="0" cellspacing="5" width="100%"><tr><td colspan="3"><div align="center">
	    
	    <p><p align="center"><span class="style3"> <br>
	      SEARCH IRB APPLICATIONS </span>        </p>
	    <form name="form1" method="post" action="searchApp.php">
            <label>
            <div align="left">Search  by Application Number:

              <input type="text" name="appnumber">
           
              <input type="submit" name="Submit" value="Search Application">
            </div>
           </form>
		    <form name="form3" method="post" action="searchbyUser.php">
            
            
            <div align="left">Search by Applicant's Username:

              <input type="text" name="username">
             
              <input type="submit" name="Submit" value="Search Application">
            </div>
	    </form>
		
         <form name="form2" method="post" action="irb_listAppbyStatus.php">
			<p align="left">Search by Status:			  
			<?php include("statusSelect.php"); ?>
			<input type="submit" name="Submit" value="Search Application">
			</form>
		
   <form name="form5" method="post" action="searchbyLastName.php">
            <label>
            
       
            <div align="left">Search by Applicant's Last Name:
              
              <input type="text" name="LastName">
              
              <input type="submit" name="Submit" value="Search Application">
               </div></form>
		</td></tr>

 <tr>
     <td colspan="3"><hr>
       <div align="center"><strong>SEARCH RESULTS</strong><br>
       </div></td>
 </tr>
<?php
if ($totalRows_Recordset1 >0)
{
?>
   <tr>
     <td colspan="3"> <strong>Name</strong>: <?php echo $rs_User['FirstName']; ?>&nbsp;<?php echo $rs_User['LastName']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Department/Admin Office</strong>: <?php echo $rs_User['Department']; 
	
	  ?></td>
   </tr>
<tr><td colspan="3"><span class="style23"><strong>Application Title:</strong> 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td></tr>
<tr><td colspan="3"><span class="style23"><strong>Application Number:</strong> <?php echo $row_Recordset1['App_Number'];
if($row_Recordset1['continuationID']<>""){ 
echo "     <strong>Last Continuation/Change Request ID:</strong> ".$row_Recordset1['continuationID'];

}
?></span></td></tr>
  
<tr><td colspan="3"><p align="left"><span class="style23"><strong>Status:</strong> <?php echo $row_Recordset1['Status'];?></span></p>
<p align="left"><span class="style23"><strong>Last Approval Date:</strong> <?php echo $row_Recordset1['lastApprovalDate'];?></span></p>
 <p align="left"><span class="style23"><strong>Faculty Approved Submission? </strong> <?php echo $row_Recordset1['facultyCertified'];?> </span></p><hr>
<tr><td colspan="3"><p align="left"><span class="style23">
<?php
if (($row_Recordset1['Status'] == "Application in Process") || ($row_Recordset1['Status'] == "IRB Admin Requests Revision") || ($row_Recordset1['Status'] == "IRB Chair Requests Revision")){
echo " <a href='Uploader.php?appNum=".$row_Recordset1['App_Number']."'>Upload Documents</a>";
	echo " | <a href='appUpdate_applicant.php?appNum=".$row_Recordset1['App_Number']."'>Update Application Form</a>";
	}
	?></span></p></td></tr>
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
		        <tr>
          <td>Date of Application Approved by IRB Chairs</td>
          <td>&nbsp;<?php echo $row_Recordset1['ApprovedDate'];?></td>
        </tr>
				        <tr>
          <td>Last Approval Date</td>
          <td>&nbsp;<?php echo $row_Recordset1['lastApprovalDate'];?></td>
        </tr>
      </table>
   
    </blockquote></td>
</tr><tr><td colspan="3"><span class="style25"></span><br>
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
<strong>Reviewers' Evaluation</strong><br>
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

<hr>
<p><b>Action Log</b><br><br>
    <?php
echo $row_Recordset1['irbActionLog'];

?>
</p>

<hr>
<b>Reviewers' Comments Log</b><br>
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
<hr>
<b>IRB Administrator/Chairs Email Messages to Applicant</b><br>
<?php
if ($row_Recordset1['irbEmails']){
echo "<br><textarea cols='80' rows='10'>";
echo $row_Recordset1['irbEmails'];
echo "</textarea>";
}
}
else
echo "<tr><td colspan='3'>No application found.";
?>
<hr></td> 
</tr>



  <?php
 // mysql_free_result($rev);
   
   ?>
   </table></td></tr><tr><td><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr></table>
   
  <?php
mysql_free_result($Recordset1);
$rs_User = mysql_fetch_assoc($appUser);
?>
   

