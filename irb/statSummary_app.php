<?php require_once('Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


?>
<?php

$query_Recordset1 = "SELECT ActionFlag, application.App_Number, username, application.ProjectTitle, application.Status, facultyCertified, application.ReviewerID, application.submissionFinishedDate,requestHSPActionDate, application.ReceivedDate, ChairReviewDate, application.ReviewDate, application.RevisionRequestDate, application.ApprovedDate, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate, application.irbActionLog, application.revActionLog, application.appActionLog, application.irbEmails FROM application where App_Number = '".$_GET['appNum']."'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
if($row_Recordset1['username'] != $_SESSION['username']){
  header("Location: ". $restrictGoTo); 
  exit;
  }
$reviewerAssigned = "no";
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
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff">
  <tr>
<td bgcolor="#000000"><div align="center"><a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42">|</span> <a class="irb" href="statSummary_app.php?appNum=<?php echo $row_Recordset1['App_Number']?>">Application Status</a> <span class="style42">|</span> <a class="irb" href="appSummary_applicant.php?appNum=<?php echo $row_Recordset1['App_Number'];?>">Review Application Data</a><?php 
	if (($row_Recordset1['Status'] == "Application in Process") || ($row_Recordset1['Status'] == "IRB Admin Requests Revision") || ($row_Recordset1['Status'] == "IRB Chair Requests Revision"))
	echo " <span class='style42'>|</span> <a class='irb' href='appUpdate_applicant.php?appNum=".$row_Recordset1['App_Number']."'>Update Application Form</a>"; ?>
	
 <?php 
if (($row_Recordset1['Status'] == "Application in Process") || ($row_Recordset1['Status'] == "IRB Admin Requests Revision") || ($row_Recordset1['Status'] == "IRB Chair Requests Revision"))
	echo " <span class='style42'>|</span> <a class='irb' href='uploader.php?appNum=".$row_Recordset1['App_Number']."'>Upload Documents</a>";
	
	?>

    <?php if ($row_Recordset1['Status'] == "Approved"){
	echo " <span class='style42'>|</span> <a class='irb' href='continuation/irb_continuation_change_form.php?appNum=".$row_Recordset1['App_Number']."'>Apply for Continuation/Change</a>"; }?>
	<span class="style42">|</span>  <a href="LogOut.php" class="irb">Log
        Out</a>
    <?php if ($row_Recordset1['Status'] == "Approved") echo " <span class='style42'><br></span> <a class='irb' href='certificate.php?appNum=".$row_Recordset1['App_Number']."'>Print Out Certificate</a>";?></div></td>
	  
  </tr>
  <tr><td colspan="4"><div align="center">
  
      <br><strong>
      <?php echo $_SESSION['name'];?></strong></div></td>
  </tr><tr><td>
      <table border="0" cellpadding="0" cellspacing="5" width="100%"><tr><td colspan="3"><div align="center"><span class="style17"><strong>IRB Application Status</strong></span><br><br>
       
      </div></td></tr>
 

<tr><td colspan="3"><span class="style23"><strong>Application Title:</strong> 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td></tr>
<tr><td colspan="3"><span class="style23"><strong>Application Number:</strong> <?php echo $row_Recordset1['App_Number'];?></span></td></tr>

<tr><td colspan="3"><p align="left"><span class="style23"><strong>Status:</strong> <?php echo $row_Recordset1['Status'];?></span></p>
   <p align="left"><span class="style23"><strong>Faculty Approved Submission? </strong><?php echo $row_Recordset1['facultyCertified'];?> </span></p>
    <hr>
    <blockquote>

      <table width="670" border="1" border="1" cellpadding="0" cellspacing="-1">
        <tr>
          <td width="400">Application Submitted Date</td>
          <td>&nbsp;<?php echo $row_Recordset1['submissionFinishedDate'];?> </td>
        </tr>
        <tr>
          <td>IRB Administrator Sent Request for HSP Training Date</td>
          <td>&nbsp;<?php echo $row_Recordset1['requestHSPActionDate'];?></td>
        </tr>
        <tr>
          <td>Application Sent to IRB Chair for Review Date</td>
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

 
 if ($row_Recordset1['rev1ID'] !=""||$row_Recordset1['rev2ID']!=""||$row_Recordset1['rev3ID']!="")
 {

$reviewerAssigned="yes";
 
 }
?></td></tr><tr><td colspan="3">
<hr><b>Reviewers' Evaluation</b><br>
<table width = "500" border="0" cellspacing="6"><tr><td>Reviewers</td>
<?php 
if ($reviewerAssigned != "yes") echo "<td colspan='2'>No Reviewer Assigned</td>";
if ($reviewerAssigned == "yes") 
echo "<td>Reviewer 1</td><td>Reviewer 2</td>";

?><td><?php if($reviewerID3) echo "Reviewer 3";?></td></tr>
<?php if ($reviewerAssigned == "yes") {?>
<tr><td>Approved?</td><td><?php echo $row_Recordset1['rev1Approved'];?></td><td><?php echo $row_Recordset1['rev2Approved'];?></td><td><?php echo $row_Recordset1['rev3Approved'];?></td></tr>
<tr>
  <td>Date of Approval </td><td><?php echo $row_Recordset1['rev1ApprovedDate'];?></td><td><?php echo $row_Recordset1['rev2ApprovedDate'];?></td><td><?php echo $row_Recordset1['rev3ApprovedDate'];?></td></tr>
 <?php
 }
 ?> 
  </table>



<?php
/*echo "<hr><b>Reviewers' Comments Log</b><br>";

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
 
*/
?>

<?php
echo "<hr><b>Action Log</b><br>";
echo substr($row_Recordset1['irbActionLog'], 0, (strpos($row_Recordset1['irbActionLog'],"The applicant and the IRB Chairs were informed that the applicantion was sent for review.") + strlen("The applicant and the IRB Chairs were informed that the applicantion was sent for review.")));

?>
<hr><b>IRB Administrator/Chairs Email Messages to Applicant</b><br>
<?php
if ($row_Recordset1['irbEmails']){
echo "<br><textarea cols='80' rows='10'>";
echo $row_Recordset1['irbEmails'];
echo "</textarea><br>";
}
else echo "None";
?></td> 
</tr>


<tr>

<td colspan="3"><div align="center"><span class="style23"> <b></b></span></div></td>
</tr>
</table> <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>
	  </td></tr>
  <?php
 // mysql_free_result($rev);
   
   ?>
   </table>
   
  <?php
mysql_free_result($Recordset1);
?>
   

