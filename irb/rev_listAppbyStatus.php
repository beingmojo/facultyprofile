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
if($_POST['selectStatus'] == "Application Submitted to Reviewers for Review"){
$query_Recordset1 = "SELECT username, ActionFlag, application.App_Number, application.ProjectTitle, application.Status, application.ReviewerID, application.submissionFinishedDate, requestHSPActionDate, application.ReceivedDate, application.ReviewDate, application.RevisionRequestDate, application.ApprovedDate, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate,ChairReviewDate, submissionFinishedDate FROM application where (rev1ID !='' || rev1ID !='' || rev1ID !='') ORDER BY submissionFinishedDate DESC";
}
else
{
$theValue = (!get_magic_quotes_gpc()) ? addslashes($_POST['selectStatus']) : $_POST['selectStatus'];
$query_Recordset1 = "SELECT username, ActionFlag, application.App_Number, application.ProjectTitle, application.Status, application.ReviewerID, application.submissionFinishedDate,requestHSPActionDate, application.ReceivedDate, application.ReviewDate, application.RevisionRequestDate, application.ApprovedDate, application.RevisionDate, application.rev1ID, application.rev2ID,application.rev3ID, application.rev1Comments, application.rev2Comments, application.rev3Comments, application.rev1Approved, application.rev2Approved, application.rev3Approved, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate FROM application where Status = '".$theValue."' ORDER BY submissionFinishedDate DESC";
}

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
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
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
         
        <p align="center"><br><?php echo $_SESSION['name'];?></p>
      <table border="0" cellpadding="0" cellspacing="5" width="100%"> <tr><td colspan="5"><div align="center"><strong>
        SEARCH IRB APPLICATIONS <br><br></strong></div></td>
      </tr>
   <tr><td colspan="3"><form name="form1" method="post" action="searchApp_rev.php">
            <span class="style27">Search by Applicaiton Number:</span>

              <input type="text" name="appnumber">
 
            <input type="submit" name="Submit" value="Search Application">
           </form></TD></TR>
	      
 <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	  <tr><td colspan="3"><div align="left"><span class="style17">Search by Status </span>
	         <?php include("statusSelect.php"); ?>
	          <input type="submit" name="Submit" value="Search Application">
	         
		    </form>	      
      </td>
	  </tr>  <tr><td colspan="3"><div align="center"><hr><strong>SEARCH RESULTS</strong></div><BR></td>
 </tr>
	  
	  <?php
if($totalRows_Recordset1>0)
  
  do
  { 
 
  $applicant = $row_Recordset1['username'];
  
  if (!get_magic_quotes_gpc()) {
$applicant = addslashes($applicant);
		}

   $sql2 = sprintf("SELECT * FROM user WHERE username = '%s'", $applicant);
$appUser = mysql_query($sql2, $con) or die(mysql_error());
$rs_User = mysql_fetch_assoc($appUser);
?>
 <tr>
     <td colspan="3"> <strong>Name</strong>: <?php echo $rs_User['FirstName']; ?>&nbsp;<?php echo $rs_User['LastName']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Department/Admin Office</strong>: <?php echo $rs_User['Department']; 
	  mysql_free_result($appUser);
	  ?><br></td>
   </tr>
<tr><td colspan="3"><span class="style23"><strong>Application Title</strong>: 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td>
</tr>
<tr><td colspan="3"><span class="style23"><strong>Application Number</strong>: <?php echo $row_Recordset1['App_Number'];?></span></td></tr>
<tr><td colspan="3"><p align="left"><span class="style23"><strong>Status</strong>: <?php echo $row_Recordset1['Status'];?></span></p>
    </td>
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


</td> 
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
   ?><tr><td colspan="2"><br><br><br>
   
   <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr>
   </table></td></tr></table>
   
  <?php
mysql_free_result($Recordset1);
?>
   
