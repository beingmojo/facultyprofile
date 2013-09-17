<?php require_once('Connections/dbc.php');
session_start();

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
$appNum=$_GET['appNum'];
$query_Recordset1 = "SELECT ActionFlag, application.App_Number, application.ProjectTitle, application.Status, application.ReviewerID, application.submissionFinishedDate,requestHSPActionDate, application.ReceivedDate, application.ReviewDate, ChairReviewDate, application.RevisionRequestDate, application.ApprovedDate, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate, application.irbActionLog, application.revActionLog, application.appActionLog, application.irbEmails FROM application where App_Number = '".$_GET['appNum']."'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
</table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
			  <div align="center"><span class="style46">
			  <div align="center" class="style6"><span class="style2"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a> </span><span class="style42">| </span><span class="style2"><a href="reviewer_app.php" class="irb">Evaluate Applications Assigned </a> </span><span class="style42">| </span><span class="style2"><a href="rev_listApp.php" class="irb">List All IRB Applications</a> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a></span></div></td>
</tr>
  
    <tr bgcolor="#FFFFFF">
      <td valign="top" bgcolor="#FFFFFF">
   
        <p align="center"><br><?php echo $_SESSION['name'];?></p>
      <table border="0" cellpadding="0" cellspacing="3" width="100%"><tr><td colspan="3"><div align="center"><span class="style17"><strong>IRB APPLICATION STATUS</strong></span><br><br>
       
      </div></td></tr>
 <tr>
 <td>
  <?php 
  echo "<a href='appSummary_reviewer.php?appNum=". $row_Recordset1['App_Number']."'>Review Application Data</a>"; ?>  
  <?php
 if ($row_Recordset1['rev1ID']==$_SESSION['username'] || $row_Recordset1['rev2ID']==$_SESSION['username'] || $row_Recordset1['rev3ID']==$_SESSION['username'])
{?>
  
| <span class="style10"><a href="evaluation.php?appNum=<?php echo $row_Recordset1['App_Number']; ?>">Evaluate Application</a> | <?php echo "<a href='deny_reviewer.php?appNum=".$row_Recordset1['App_Number']."'>Decline Review of the Application</a></td></tr><br>"; ?></span>
  <?php
  }?>
<tr><td colspan="3"><span class="style23"><strong><br>Application Title:</strong> 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td></tr>
<tr><td colspan="3"><span class="style23"><strong>Application Number:</strong> <?php echo $row_Recordset1['App_Number'];?></span></td></tr>
  
<tr><td colspan="3"><p align="left"><span class="style23"><strong>Status:</strong> <?php echo $row_Recordset1['Status'];?></span></p>
    <blockquote>
    
      <table width="670" border="1" cellpadding="0" cellspacing="-1">
        <tr>
          <td>Application Submitted Date</td>
          <td>&nbsp;<?php echo $row_Recordset1['submissionFinishedDate'];?></td>
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

if ($reviewerID1 !=""||$reviewerID2=""||$reviewerID3!="")
 {
	$reviewerAssigned="yes"; 
 }
?></td></tr><tr><td colspan="3">
<hr><b>Reviewers' Evaluation</b><br>
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

<hr><b>Action Log</b><br><br>
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
echo "<br><br>".$rev2Name."<br><textarea cols='80' rows='8'>";

echo $row_Recordset1['rev2Comments']."</textarea><br>";
}
if ($row_Recordset1['rev3Comments']){
echo "br><br>".$rev3Name."<br><textarea cols='80' rows='8'>";
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
?></td> 
</tr>


<tr><td><br><br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
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
   

