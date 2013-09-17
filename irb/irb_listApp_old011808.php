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

$query_Recordset1 = "SELECT application.App_Number, application.ProjectTitle, application.Status, application.ReviewerID, application.ReceivedDate, application.ReviewDate, application.RevisionRequestDate, application.ApprovedDate, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate, ChairReviewDate, submissionFinishedDate FROM application ORDER BY App_Number";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

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
.style15 {font-weight: bold}
body {
	background-color: #cccccc;
}
.style16 {
	color: #FFFFFF;
	font-weight: bold;
}
.style17 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style21 {font-size: 12px}
.style23 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; }
.style25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
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
			  <div align="center"><span class="style15 style14"><a class="irb" href="irb_listApp.php" >Retrive Applications </a>| <a class="irb" href="listReviewers.php" >List All Reviewers </a>| <a class="irb" href="listApplicants.php" >List All Applicants</a> | <a class="irb" href="update_irb_userInfo.php" >Update Personal Information </a>| <a class="irb" href="osp_irb_home.php" >IRB Home </a></span></div></td>
          </tr>
  </tbody>
      </table>
      </td>
  </tr>
    <tr>
      <td height="348" valign="top">
      <table border="0" cellpadding="0" cellspacing="5" width="100%">
	  <tr><td colspan="5"><div align="center"><span class="style17">Current IRB Applications</span><br>
          <form name="form1" method="post" action="searchApp.php">
            <label>Search Individual  Application by Applicaiton Number:

              <input type="text" name="appnumber">
              </label>
            <label> 
            <input type="submit" name="Submit" value="Search Application">
            </label></form>
          <br>
             		
         <form name="form2" method="post" action="irb_listAppbyStatus.php">
			<p align="center">Search Applications by Status:			  
			<select name="selectStatus">
                <option selected>Select One</option>
				<option value="Application in Process">Application in Process</option>
	<option value="Application Submitted">Application Submitted</option>
	       
	<option value="Application Submitted to IRB Chair for Review">Application Submitted to IRB Chair for Review</option>
       
			    <option value="Application Submitted to Reviewers for Review">Application Submitted to Reviewers for Review</option>
			    <option value="Request Revision">Request Revision</option>
			    <option value="Revision Received">Revision Received</option>
			    <option value="Approved">Application Approved</option>
			    <option value="Applicant requested continuation">Applicant requested continuation</option>
              </select><input type="submit" name="Submit" value="Search Application"></p>
			</form><hr>
      </div></td></tr><?php
if($totalRows_Recordset1>0)
  
  do
  { 
 

?>
 
<tr><td colspan="3"><span class="style23"><strong>Application Title</strong>: 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td>
</tr>
<tr><td colspan="3"><span class="style23"><strong>Application Number</strong>: <?php echo $row_Recordset1['App_Number'];?></span></td>
<tr><td colspan="3"><p align="left"><span class="style23"><strong>Status</strong>: <?php echo $row_Recordset1['Status'];?></span></p>
    <blockquote>
    
      <table width="750" border="1">
        <tr><td>Application Submission Date</td>
      
		  <td>Application Sent to Chair for Review Date</td>
          <td>Application Sent to Reviewer for Review Date</td>
          <td>Last Request for Revision Date</td>
          <td>Last Application Revision/Update Received Date</td>
          <td>Application Approved Date by IRB</td>
        </tr>
        <tr>
		<td><?php echo $row_Recordset1['submissionFinishedDate'];?> </td>
         
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
<hr><blockquote>
<table width="750" border="1"><tr><td>Reviewer Name: </td><td><?php echo $rev1Name;?></td><td>  <?php echo $rev2Name;?></td><td><?php echo $rev3Name;?></td></tr>
<tr><td>Application Approved by Reviewer?</td><td><?php echo $row_Recordset1['rev1Approved'];?></td><td><?php echo $row_Recordset1['rev2Approved'];?></td><td><?php echo $row_Recordset1['rev3Approved'];?></td></tr>
<tr><td>Date of Approval</td><td><?php echo $row_Recordset1['rev1ApprovedDate'];?></td><td><?php echo $row_Recordset1['rev2ApprovedDate'];?></td><td><?php echo $row_Recordset1['rev3ApprovedDate'];?></td>
</tr><tr><td>IRB Chair Approved?</td><td>

<?php if ($row_Recordset1['Status'] == "Approved") 
echo "Yes";
else echo "No";
?></td></tr>
<tr><td>IRB Chair Approved Date</td><td>

<?php echo $row_Recordset1['ApprovedDate'];?></td></tr>
</table>
</blockquote>


<?php
 

?></td> 
</tr>


<tr>

<td colspan="3"><div align="center"><span class="style23"> <b>Actions</b></span></div></td>
</tr>

<tr>
 <td>
  <?php 
  
  echo "<a href='appSummary_irb.php?appNum=". $row_Recordset1['App_Number']."'>Review Application Data</a></td><td>";
   echo "<a href='statSummary.php?appNum=". $row_Recordset1['App_Number']."'>Summary of Status,  Evaluation and Action Log</a></td><td>";
    echo "<a href='assignReviewer.php?appNum=". $row_Recordset1['App_Number']."'>Assign/Change Reviewer(s) to Application</a></td></tr><tr><td>"; 
	
	    echo "<a href='irb_updatestatus.php?appNum=". $row_Recordset1['App_Number']."'>Update Status(s) to Application</a></td><td>"; 
	  echo "<a href='irb_emailApp.php?appNum=". $row_Recordset1['App_Number']."'>Email Comments to Applicant</a></td></tr><tr><td colspan='3'><hr></td></tr>";
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
   
