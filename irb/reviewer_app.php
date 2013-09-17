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
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($_SESSION['username']) : $_SESSION['username'];

//$query_Recordset1 = "SELECT username, submissionFinishedDate, ActionFlag, application.App_Number, application.ProjectTitle, application.Status FROM application WHERE ((application.rev1ID = '".$theValue."' || application.rev2ID = '".$theValue."' || application.rev3ID = '".$theValue."') && (Status != 'Approved' && Status != 'Applicant Requested Continuation' && Status != 'Application Approved - Exempt' && Status != 'Applicant Requested Change' && Status != 'Application Discontinued')) ORDER BY submissionFinishedDate DESC, App_Number ASC";

$query_Recordset1 = "SELECT username, submissionFinishedDate, ActionFlag, application.App_Number, application.ProjectTitle, application.Status FROM application WHERE ((application.rev1ID = '".$theValue."' || application.rev2ID = '".$theValue."' || application.rev3ID = '".$theValue."') && (Status != 'Approved' && Status != 'Applicant Requested Continuation' && Status != 'Application Approved - Exempt' && Status != 'Applicant Requested Change' && Status != 'Application Discontinued' && Status != 'IRB Chair Requests Revision')) ORDER BY submissionFinishedDate DESC, App_Number ASC";

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
           </a>
            </p>
            </span></td>
   </tr>
          
       
        </tbody>
      </table>
      </td>
  </tr>
<tr><td>
<table width="800" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
			  <div align="center"><span class="style46">
			  <div align="center" class="style6"><span class="style2"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a> </span><span class="style42">| </span><span class="style2"><a href="reviewer_app.php" class="irb">Evaluate Applications Assigned </a> </span><span class="style42">| </span><span class="style2"><a href="rev_listApp.php" class="irb">List All IRB Applications</a> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a></span></div></td>
    </tr>
  
   <tr><td colspan="4"><br><div align="center"><?php echo $_SESSION['name'];?></div></td></tr>
<table width="800" border="0" align="center" cellpadding="6" cellspacing="0" bgcolor="#FFFFFF">

<tr><td><div align="left" class="style23">
  <div align="center"><br><strong>APPLICATIONS FOR YOU TO REVIEW</strong></div>
</div></td>
</tr><tr><td ><hr>
</td>
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
     <td><a href="reviewer_appList.php">Review Status For All Active Applications Assigned </a></td>
   </tr><tr><td><hr></td></tr>
   <tr>
     <td> <p align="left"><span class="body"><strong>Applicant Name</strong></span>: <?php echo $rs_User['FirstName']; ?>&nbsp;<?php echo $rs_User['LastName']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Department/Admin Office</strong>: <?php echo $rs_User['Department']; 
	  mysql_free_result($appUser);
	  ?></td>
   </tr>

<tr><td ><p align="left"><span class="style23"><strong>Application Title</strong>: 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td>
</tr>
<tr><td><p align="left"><span class="style23"><strong>Application Number</strong>: <?php echo $row_Recordset1['App_Number'];?></span></td></tr>

  
<tr><td><p align="left"><span class="style23"><strong>Status</strong>: <?php echo $row_Recordset1['Status'];?></span></p>
   </td>
</tr> 
<tr><td colspan="3"><p align="left"><span class="style23"><strong>Age of the application</strong>: <?php 

$timestamp =strtotime($row_Recordset1['submissionFinishedDate']);
$date2 = strtotime(date("m/d/y H:i:s")) - $timestamp;
$dates = number_format($date2/(60*60*24));

echo " ".$dates. " days";
?>
</td></tr>
<tr>
  <td><p align="left"> <?php 
  
  echo "<a href='appSummary_reviewer.php?appNum=". $row_Recordset1['App_Number']."'>Review Application Data</a>  |  ";
   echo "<a href='statSummary_rev.php?appNum=". $row_Recordset1['App_Number']."'>Summary of Status,  Evaluation and Action Log</a>  |  ";
   echo "<a href='evaluation.php?appNum=".$row_Recordset1['App_Number']."'>Evaluate Application </a>  |  <a href='deny_reviewer.php?appNum=". $row_Recordset1['App_Number']."'>Decline Review of the Application</a>"; ?>
<hr></td></tr>
   <?php 
   } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1))
  
   ?>
 <tr><td>

   <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td>&nbsp;</td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;">
	  <?php include("footer.php"); ?>
      </td>
    </tr>

</table>

</body>
</html>
<?php
mysql_free_result($Recordset1);

?>
