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
</tbody></table></table>

<table width="800" border="0" align="center" bgcolor="#ffffff">
				
          <tr>
            <td height="19" valign="top" bgcolor="#000000">
			  <div align="center"><a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home </a> <span class="style39">|</span><span class="irb"><a class="irb" href="irb_listApp.php">List All IRB Applications</a> <span class="style39">|</span> <a class="irb" href="listReviewers.php" >List All Reviewers </a> <span class="style39">|</span> <a class="irb" href="listApplicants.php" >List All Users</a> <span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a></div></td>
          </tr>
  
  </tbody>
</table>
    <table width="800" border="0" align="center" bgcolor="#ffffff">
	  <tr><td colspan="3"><div align="center">
	    
	    <p><span class="style3"> <br>
	      SEARCH IRB APPLICATIONS </span>        </p>
	    <form name="form1" method="post" action="searchApp.php">
            <label>
            <div align="left">Search by Application Number:

              <input type="text" name="appnumber">
           
              <input type="submit" name="Submit" value="Search Application">
          </div>
        </form>
     	    <form name="form3" method="post" action="searchbyUser.php">
            <label>
            
            <div align="left">Search by Applicant's Username:

              <input type="text" name="username">
             
              <input type="submit" name="Submit" value="Search Application">
            </div>
	    </form>
         <form name="form2" method="post" action="irb_listAppbyStatus.php">
			<p align="left">Search by Status:<br>			  
			<?php include("statusSelect.php"); ?>
			<input type="submit" name="Submit" value="Search Application">
	    </form>
		<form name="form5" method="post" action="searchbyLastName.php">
            <label>         
           
            <div align="left">Search by Applicant's Last Name:
              
              <input type="text" name="LastName">
              
              <input type="submit" name="Submit" value="Search Application">
            </div>
		</form>
			<form name="form4" method="post" action="searchbyUserType.php">
		     <div align="left">Search by Applicant's Group:			  
		       <label>
		       <input type="radio" name="User_Type" value="student">
Student</label>
               <label>
               <input type="radio" name="User_Type" value="faculty/staff">
Faculty/Staff</label>
               <input type="submit" name="Submit2" value="Search Application">
</div>
		     <label></label>
	    </form>
			<hr>
      </div></td></tr>
      </div></td></tr>
	  <?php




$query_Recordset2 = "select * FROM user where User_Type='".$_POST['User_Type']."' order by LastName";
$Recordset2= mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>
 	<tr><td colspan="3"><strong>IRB Applications Submitted by <font color="#FF0000"><?php echo strtoupper($_POST['User_Type']);?>(s)</font><p></td></tr>
 <?php
do{
$username = $row_Recordset2['username'];
$query_Recordset1 = "SELECT ActionFlag, application.App_Number, application.ProjectTitle, application.Status, application.ReviewerID, application.ReceivedDate, requestHSPActionDate, application.ReviewDate, application.RevisionRequestDate, application.ApprovedDate, lastApprovalDate, continuationID, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate, ChairReviewDate, submissionFinishedDate, numContinued FROM application where username='".$username."'";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


?>


	  <?php
if($totalRows_Recordset1>0)
  
  do
  { 
    ?>
   <tr>
     <td colspan="3"> <span class="body"><strong>Applicant Name</strong></span>: <?php echo $row_Recordset2['FirstName']; ?>&nbsp;<?php echo $row_Recordset2['LastName']; ?>&nbsp;&nbsp;&nbsp;<?php echo $$row_Recordset2['User_Type']; ?>&nbsp;&nbsp;<strong>Department/Admin Office</strong>: <?php echo $row_Recordset2['Department'];  ?></td>
   </tr>
<tr><td colspan="3"><span class="style23"><strong>Application Title</strong>: 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td>
</tr>
<tr><td colspan="3"><span class="style23"><strong>Application Number</strong>: <?php echo $row_Recordset1['App_Number'];
if($row_Recordset1['continuationID']<>"") echo "<br><strong>Last Continuation/Change Request ID:</strong> ".$row_Recordset1['continuationID'];

?></span></td></tr>

  
<tr><td colspan="3"><p align="left"><span class="style23"><strong>Status</strong>: <?php echo $row_Recordset1['Status'];?></span></p>
</td></tr>
<tr><td colspan="3"><p align="left"><span class="style23"><strong>Last Approval Date</strong>: <?php echo $row_Recordset1['lastApprovalDate'];?></span></p>
</td></tr>

<tr><td colspan="3">

   

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

</td> 
</tr>


<tr>
 <td align="center">
  <?php
  echo "<a href='appSummary_irb.php?appNum=". $row_Recordset1['App_Number']."'>Review Application Data</a> | ";
   echo "<a href='statSummary.php?appNum=". $row_Recordset1['App_Number']."'>Summary of Status,  Evaluations and Action Logs</a> | ";
    echo "<a href='assignReviewer.php?appNum=". $row_Recordset1['App_Number']."'>Assign/Change Reviewer(s)</a><br>"; 
	
	    echo "<a href='irb_updatestatus.php?appNum=". $row_Recordset1['App_Number']."'>Update Application Status</a> | "; 
	  echo "<a href='irb_emailApp.php?appNum=". $row_Recordset1['App_Number']."'>Send Comments/Requests to Applicant</a>";
	if ($row_Recordset1['Status'] == "Approved") echo " | <a href='certificate.php?appNum=".$row_Recordset1['App_Number']."'>Print Out Certificate</a>";
	 if (($row_Recordset1['Status'] == "Application in Process") || ($row_Recordset1['Status'] == "IRB Admin Requests Revision") || ($row_Recordset1['Status'] == "IRB Chair Requests Revision")){
	echo " <a href='Uploader.php?appNum=".$row_Recordset1['App_Number']."'>Upload Documents</a>";
	echo " | <a href='appUpdate_applicant.php?appNum=".$row_Recordset1['App_Number']."'>Update Application Form</a>";
	 }
	 echo "</td></tr><tr><td colspan='3'><hr></td></tr>";
	?>  
  </div></td></tr>
  <?php
  //mysql_free_result($rev);
    }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));

	
	}while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
   ?>
   <tr><td><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr></table>
    </table>
   
  <?php
mysql_free_result($Recordset1);
?>
   
