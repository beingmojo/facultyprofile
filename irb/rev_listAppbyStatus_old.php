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
$theValue = (!get_magic_quotes_gpc()) ? addslashes($_POST['selectStatus']) : $_POST['selectStatus'];
$query_Recordset1 = "SELECT ActionFlag, application.App_Number, application.ProjectTitle, application.Status, application.ReviewerID, application.submissionFinishedDate,requestHSPActionDate, application.ReceivedDate, application.ReviewDate, application.RevisionRequestDate, application.ApprovedDate, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate FROM application where Status = '".$theValue."' ORDER BY submissionFinishedDate DESC";
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
            <td width="248" valign="middle" background="tbbg.gif"><p align="center" class="tsu">Texas State University</p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           
            </p>
            </span></td>
   </tr>
          
       
        </tbody>
      </table>
      </td>
  </tr>
</tbody></table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
			  <div align="center"><span class="style46">
			  <div align="center" class="style6"><span class="style2"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a> </span><span class="style42">| </span><span class="style2"><a href="reviewer_app.php" class="irb">Evaluate Applications Assigned </a> </span><span class="style42">| </span><span class="style2"><a href="rev_listApp.php" class="irb">List All IRB Applications</a> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a></span></div></td>
          </tr>
  
    <tr bgcolor="#FFFFFF">
      <td  valign="top" bgcolor="#FFFFFF">
          <p>&nbsp;</p>
        <p align="center"><?php echo $_SESSION['name'];?></p>
      <table border="0" cellpadding="0" cellspacing="5" width="100%">
   
	  <tr><td colspan="5"><div align="center"><span class="style17"><strong>Search IRB Applications by Status </strong></span><br>
       
			
         <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<p align="center">
			  <select name="selectStatus">
			    <option selected>Select One</option>
				<option value="Application in Process">Application in Process</option>
	<option value="Application Submitted">Application Submitted</option>
	               <option value="IRB Admin Requests Applicant to Complete HSP Training">IRB Admin Requests Applicant to Complete HSP Training</option>
	<option value="Application Submitted to IRB Chairs for Review">Application Submitted to IRB Chair for Review</option>
       
			    <option value="Application Submitted to Reviewers for Review">Application Submitted to Reviewers for Review</option>
				<option value="IRB Admin Requests Revision">IRB Admin Requests Revision</option>
			    <option value="IRB Chair Requests Revision">IRB Chair Requests Revision</option>
			    <option value="Revision Received">Revision Received</option>
			    <option value="Approved">Application Approved</option>
			    <option value="Applicant requested continuation">Applicant requested continuation</option>
			    </select>
			  <input type="submit" name="Submit" value="Search Application">
			</p>
			
			  <div align="center"></div>
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
        <tr><td><div align="center">Application Submitted Date</div></td>
               <td>IRB Administrator Sent Request for HSP Training Date</td>
		  <td><div align="center">Application Sent to IRB Chairs for Review Date</div></td>
          <td><div align="center">Application Sent to Reviewers for Review Date</div></td>
          <td><div align="center">Last Request for Revision Date</div></td>
          <td><div align="center">Last Application Revision/Update Received Date</div></td>
          <td><div align="center">Date of Application Approved by IRB Chairs </div></td>
        </tr>
        <tr>
		<td><div align="center"><?php echo $row_Recordset1['submissionFinishedDate'];?> </div></td>
          <td><?php echo $row_Recordset1['requestHSPActionDate'];?></td>
		  <td><div align="center"><?php echo $row_Recordset1['ChairReviewDate'];?></div></td>
          <td><div align="center"><?php echo $row_Recordset1['ReviewDate'];?></div></td>
          <td><div align="center"><?php echo $row_Recordset1['RevisionRequestDate'];?> </div></td>
          <td><div align="center"><?php echo $row_Recordset1['RevisionDate'];?></div></td>
          <td><div align="center"><?php echo $row_Recordset1['ApprovedDate'];?> </div></td>
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

<table width="600"><tr><td>Names of the Reviewers: </td><td><?php echo $rev1Name;?></td><td><?php echo $rev2Name;?></td><td><?php echo $rev3Name;?></td></tr>
<tr><td>Approved?</td>
<td><?php echo $row_Recordset1['rev1Approved'];?></td>
<td><?php echo $row_Recordset1['rev2Approved'];?></td>
<td><?php echo $row_Recordset1['rev3Approved'];?></td>
</tr>
<tr>
  <td>Date of Approval </td>
<td><?php echo $row_Recordset1['rev1ApprovedDate'];?></td>
<td><?php echo $row_Recordset1['rev2ApprovedDate'];?></td>
<td><?php echo $row_Recordset1['rev3ApprovedDate'];?></td>
</tr>
 </table>



<?php
 

?></td> 
</tr>


<tr>

<td colspan="2"><div align="center"><span class="style23"> </span></div></td>
</tr>
<tr>
 <td>
  <?php 
  
 echo "<a href='appSummary_reviewer.php?appNum=". $row_Recordset1['App_Number']."'>Review Application Data</a></td><td>";
   echo "<a href='statSummary_rev.php?appNum=". $row_Recordset1['App_Number']."'>Summary of Status,  Evaluations and Action Log</a></td></tr>";
	?>  <tr><td colspan="2"><hr></td></tr>
  <?php
  //mysql_free_result($rev);
    }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	
	//end if number of record
   ?>
   </table></td></tr></table>
   
  <?php
mysql_free_result($Recordset1);
?>
   
