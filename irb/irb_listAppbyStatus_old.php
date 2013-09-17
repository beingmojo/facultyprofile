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
$theValue = (!get_magic_quotes_gpc()) ? addslashes($_POST['selectStatus']) : $_POST['selectStatus'];
$query_Recordset1 = "SELECT ActionFlag, application.App_Number, application.ProjectTitle, application.Status, application.ReviewerID, application.submissionFinishedDate, requestHSPActionDate, application.ReceivedDate, application.ReviewDate, application.RevisionRequestDate, application.ApprovedDate, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate,ChairReviewDate, submissionFinishedDate FROM application where Status = '".$theValue."' ORDER BY submissionFinishedDate DESC";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
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
<script>
function deleteConfirm(a,b,c)
{
if (confirm('Are you sure you want to remove this reviewer from the application? Doing so, the the evaluations/comments that the reviewer ever made to this application will be removed permanently from the record of this application.')){
dirlocation="deleteReviewerAss.php?oldID="+a+"&appNum="+b+"&id="+c;
document.location.href=dirlocation;
}
}
</script>

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
            <td width="248" valign="middle" background="tbbg.gif"><p align="center" class="tsu">Texas State University</p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           
            </p>
            </span></td>
   </tr>
</tbody></table></table>

<table width="800" border="0" align="center" bgcolor="#ffffff">
				
          <tr>
            <td height="19" valign="top" bgcolor="#000000">
			  <div align="center"><a class="irb" href="osp_irb_home.php">My IRB Home</a> <span class="style39">|</span> <span class="irb"><a class="irb" href="irb_listApp.php">List All IRB Applications</a> <span class="style39">| </span><a class="irb" href="listReviewers.php" >List All Reviewers </a><span class="style39">|</span><span class="style15 style14"> <a class="irb" href="listApplicants.php" >List All Applicants</a> </span><span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a> </div></td>
          </tr>
  
  </tbody>
      </table>
  <table border="0" bgcolor="#FFFFFF" width="800" align="center">
    <tr>
      <td height="348" valign="top">
      <table border="0" cellpadding="0" cellspacing="5" width="100%">
	  <tr><td colspan="5"><div align="center"><span class="style17">Search IRB Applications by Status </span><br>
       
			
         <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<p align="center">
			  <select name="selectStatus">
			    <option selected>Select One</option>
				<option value="Application in Process">Application in Process</option>
	<option value="Application Submitted">Application Submitted</option>
	        <option value="IRB Admin Requests Applicant to Complete HSP Training">IRB Admin Requests Applicant to Complete HSP Training</option>
	<option value="Application Submitted to IRB Chairs for Review">Application Submitted to IRB Chairs for Review</option>
       
			    <option value="Application Submitted to Reviewers for Review">Application Submitted to Reviewers for Review</option>
				<option value="IRB Admin Requests Revision">IRB Admin Requests Revision</option>
			    <option value="IRB Chair/Reviewers Requests Revision">IRB Chair Requests Revision</option>
			    <option value="Revision Received">Revision Received</option>
			    <option value="Approved">Application Approved</option>
			    <option value="Applicant requested continuation">Applicant requested continuation</option>
			    </select>
			</p>
			
			  <div align="center">
			    <input type="submit" name="Submit" value="Search Application">
			    </div>
         </form>
			</p>
      </div></td></tr><?php
if($totalRows_Recordset1>0)
  
  do
  { 
 

?>
 
<tr><td colspan="3"><span class="style23"><strong>Application Title</strong>: 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td>
</tr>
<tr><td colspan="3"><span class="style23"><strong>Application Number</strong>: <?php echo $row_Recordset1['App_Number'];?></span></td></tr>
<tr>
  <td colspan="3"><span class="style23"><strong>Applicant Action Flag:  <font color="#FF0000"><?php
  echo $row_Recordset1['ActionFlag']; ?></font></strong></span></td></tr>
<tr><td colspan="3"><p align="left"><span class="style23"><strong>Status</strong>: <?php echo $row_Recordset1['Status'];?></span></p>
    <blockquote>
 <table width="700" border="1">
        <tr><td>Application Submitted Date</td>
              <td>IRB Administrator Sent Request for HSP Training Date</td>
		  <td>Application Sent to IRB Chairs for Review Date</td>
          <td>Application Sent to Reviewers for Review Date</td>
          <td>Last Request for Revision Date</td>
          <td>Last Application Revision/Update Received Date</td>
          <td>Date of Application Approved by IRB Chairs </td>
        </tr>
        <tr>
		<td><?php echo $row_Recordset1['submissionFinishedDate'];?> </td>
          <td><?php echo $row_Recordset1['requestHSPActionDate'];?></td>
		  <td><?php echo $row_Recordset1['ChairReviewDate'];?></td>
          <td><?php echo $row_Recordset1['ReviewDate'];?></td>
          <td><?php echo $row_Recordset1['RevisionRequestDate'];?> </td>
          <td><?php echo $row_Recordset1['RevisionDate'];?></td>
          <td><?php echo $row_Recordset1['ApprovedDate'];?> </td>
        </tr>
      </table>
     
    </blockquote></td>
</tr><tr><td colspan="3">
<?php
$rev1Name="";
$rev2Name="";
$rev3Name="";
	$reviewerID1="";
   $reviewerID1  = $row_Recordset1['rev1ID'];
 //  echo "rev1 id: ".$reviewerID1."<br>";
   if($reviewerID1){ 
   if (!get_magic_quotes_gpc()){$reviewerID1=addslashes($reviewerID1);}}
  // echo "Reviewers: ".$reviewerIDs."<p>";
//$arrReviewerID = explode(",", $reviewerIDs);
//echo "Number of reviewer:".count($arrReviewerID);
$reviewerID2="";
$reviewerID2  = $row_Recordset1['rev2ID'];
//echo "rev2 id: ".$reviewerID2."<br>";
if($reviewerID2){ 
if (!get_magic_quotes_gpc()){$reviewerID2=addslashes($reviewerID2);}}

$reviewerID3="";
$reviewerID3  = $row_Recordset1['rev3ID'];
if($reviewerID3){ 
if (!get_magic_quotes_gpc()){$reviewerID3=addslashes($reviewerID3);}}

////////////////////////////////////////////
if($reviewerID1){ 
$sqlRev=sprintf("SELECT * FROM user where username='%s'", $reviewerID1);
$rev1Name="";
$rev1 = mysql_query($sqlRev, $con) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev1);
//echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName']." / ";
$rev1Name = $rs_rev['FirstName']." ".$rs_rev['LastName'];
mysql_free_result($rev1);
}

if($reviewerID2){ 
$rev2Name="";
$sqlRev=sprintf("SELECT * FROM user where username='%s'", $reviewerID2);

$rev2 = mysql_query($sqlRev, $con) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev2);
//echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName']." / ";
$rev2Name = $rs_rev['FirstName']." ".$rs_rev['LastName'];
mysql_free_result($rev2);
}

if($reviewerID3){ 
$sqlRev=sprintf("SELECT * FROM user where username='%s'", $reviewerID3);
$rev3Name="";
$rev3 = mysql_query($sqlRev, $con) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev3);
//echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName'];
$rev3Name = $rs_rev['FirstName']." ".$rs_rev['LastName'];
mysql_free_result($rev3);
}

?>

<table width="500"><tr><td>Names of the Reviewers</td><td><?php echo $rev1Name;?></td><td>  <?php echo $rev2Name;?></td><td><?php echo $rev3Name;?></td></tr>
<tr><td>Approved?</td>
<td><?php echo $row_Recordset1['rev1Approved'];?></td>
<td><?php echo $row_Recordset1['rev2Approved'];?></td>
<td><?php echo $row_Recordset1['rev3Approved'];?></td></tr>

<tr>
  <td>Date of Approval </td>
  <td><?php echo $row_Recordset1['rev1ApprovedDate'];?></td>
<td><?php echo $row_Recordset1['rev2ApprovedDate'];?></td>
<td><?php echo $row_Recordset1['rev3ApprovedDate'];?></td>
</tr></table>



<?php
 

?></td> 
</tr>


<tr>

<td colspan="3"><div align="center"><span class="style23"> <b>Actions</b></span></div></td>
</tr>
<tr>
 <td align="center">
  <?php 
  
  echo "<a href='appSummary_irb.php?appNum=". $row_Recordset1['App_Number']."'>Review Application Data</a> | ";
   echo "<a href='statSummary.php?appNum=". $row_Recordset1['App_Number']."'>Summary of Status,  Evaluations and Action Logs</a> | ";
    echo "<a href='assignReviewer.php?appNum=". $row_Recordset1['App_Number']."'>Assign/Change Reviewer(s)</a><br>"; 
	
	    echo "<a href='irb_updatestatus.php?appNum=". $row_Recordset1['App_Number']."'>Update Status to Application</a> | "; 
	  echo "<a href='irb_emailApp.php?appNum=". $row_Recordset1['App_Number']."'>Send Comments/Requests to Applicant </a>";
	  if ($row_Recordset1['Status'] == "Approved") echo " | <a href='certificate.php?appNum=".$row_Recordset1['App_Number']."'>Print Out Certificate</a>";
	  echo "</td></tr><tr><td colspan='3'><hr></td></tr>";
	?>  </td></tr>
  <?php
  //mysql_free_result($rev);
    }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	
	//end if number of record
   ?>
   </table></td></tr></table>
   
  <?php
mysql_free_result($Recordset1);
?>
   
