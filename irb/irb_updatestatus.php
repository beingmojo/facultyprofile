<?php require_once('Connections/con3.php'); 
require_once('Connections/dbc.php');
session_start();
require_once('variables/variables.php');

?>
 <?php

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "IRB Staff")) {
	if (!($_SESSION['User_Type'] == "IRB Chair")) {
   
 
  header("Location: ". $restrictGoTo); 
  exit;
  }
}




 

//echo "<p>Application Numer: ".$appNumber."</p>";


$appNum = $_GET['appNum'];

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

if(isset($_POST['insert']) && $_POST['insert'] == "formInsert")
 {
 $appNum = trim($_POST['appNum']);
 $today=date("m/d/y H:i:s");
  $newaction=$_POST['irbActionLog']."<br><br>".$today."  ".$_SESSION['username'].":<br>";
  $subject="";
//echo $_POST["newstatus"];
  //******************************************************
 /* if (($_POST['trainingFinished'] =="yes") && ($_POST['newstatus'] != "Application Submitted to IRB Chairs for Review")){
  die("You did not check the Application Submitted to IRB Chairs for Review status. <a href='irb_updatestatus.php?appNum=".$_POST['appNum']."'>Back</a>");
  }
  */
 
  if(($_POST['newstatus'] == "Application Submitted")&& ($_POST['facultyCertified']=="Yes")) {

      $newaction=$newaction."IRB administrator/chair Certified the application on behalf of the faculty member.";
 
  $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, facultyCertified=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['facultyCertified'], "text"), GetSQLValueString($appNum, "text"));
  	if (strtoupper($_POST['User_Type']) == "STUDENT")
	{
	$body = "\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. Do not reply.\r\rIRB Admin has certified your student's IRB Application on behalf of you. The Application number is ".$_POST['appNum']. ". Faculty members' certifications are required for all student applications. \r\rAfter IRB admin verifies that you have completed the CITI Human Subjects Protection Training program, your application will be forwarded for assignment to reviewers. \r\rWhile under review, your application is locked but is available as read-only.  You may log in to the IRB Online Application System at any time at:\r". $irbadd."?appNum=".$_POST['appNum']."\r\nYou will receive notification emails when your application status changes.  If the IRB requests changes or additions, your application will be unlocked and you will be able to modify it. \r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";
		
	$subject = "IRB Application Certification Confirmation: ".$_POST['appNum'];
	$to=$_SESSION['Email'];
	mail($to,$subject,$body, $headers);
	$to = $_POST['FacultyEmail'];
	
 $subject = "Your your student's application - IRB Application ". $_POST['appNum'];
	mail($to,$subject,$body, $headers);
	}
  

  
  }

  if($_POST['newstatus'] == "Application in Process") {
$newaction=$newaction."IRB administrator/chair changed the application status to Application in Process.";
 $subject = "IRB Application ". $_POST['appNum'].": IRB administrator/chair changed the application status into Application in Process";
  $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, Status=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($appNum, "text"));
 $body = "\r\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program.\r\rIRB administrator/chair changed the application status to Application in Process. Applicant can make changes to the application form and upload documents at:".$irbadd.".\r\rIf you have questions, please submit an IRB Inquiry form at\rhttp://www.txstate.edu/research/irb/irb_inquiry.html.\r\n";
 
 $body = $body.$emailSig;
 
     $to = $_POST['emailAdd'];	
 //$subject = "RE: IRB Application ". $_POST['appNum'];
 
mail($to,$subject,$body, $headers);

	// copy to faculty
	if ($_POST['FacultyEmail'] !="")
	{ $subject = "This is a copy of an email message sent to your student ".$_POST['applicantName']."! IRB Application ". $_POST['appNum'];
	$to = $_POST['FacultyEmail'];
	mail($to,$subject,$body, $headers);
	}
	

//irb staff will receive the same email

//$sender = $_SESSION['Email'];
	//mail($sender,$subject,$body, $headers);
 	}
  //************************************************************
	if($_POST['newstatus'] == "IRB Admin Requests Applicant and/or Supervising Faculty Complete HSP Training") {
	
	$ActionFlag = "Yes";
	
$newaction=$newaction."IRB administrator informed the applicant that Training on Protection of Human Research Subjects was needed";
 $subject = "IRB Application ". $_POST['appNum'].": CITI Course completion required. DO NOT REPLY to this message.
";
  $insertSQL = sprintf("UPDATE application SET ActionFlag=%s, ActionRequestDate=%s, requestHSPActionDate = %s, irbActionLog=%s, Status=%s, ReceivedDate=%s WHERE App_Number=%s", GetSQLValueString($ActionFlag, "text"), GetSQLValueString($today, "text"), GetSQLValueString($today, "text"), GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($today, "text"), GetSQLValueString($_POST['appNum'], "text"));
 $body = "DO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program.\r\rThe IRB Administrator has halted the submission of your IRB Application ".$_POST['appNum']." because there is no record of your completion of the CITI Course in the Protection of Human Subjects.  The CITI course can be found at the following link: \rhttps://www.citiprogram.org/default.asp?language=english\r\rPLEASE NOTE: When you complete the CITI training, a completion report will automatically be sent to the IRB Administrator, and your application will be forwarded for review. \r\rYour application is currently locked but is available as read-only.  You may log into the IRB Online Application System at any time to monitor application status. \r\rIf you have questions, please submit an IRB Inquiry form at:\r  http://www.txstate.edu/research/irb/irb_inquiry.html\r\n";
$body = $body.$emailSig;
  $to = $_POST['emailAdd'];	
  
mail($to,$subject,$body, $headers);
    
	// copy to faculty
	if ($_POST['FacultyEmail'] !="")
	{
	  $subject = "This is a copy of an email message sent to your student ".$_POST['applicantName']."! IRB Application ". $_POST['appNum'];
	$to = $_POST['FacultyEmail'];
	mail($to,$subject,$body, $headers);
	}
	
 	}
	
	
 //*********************************************************
 if($_POST['newstatus'] == "Application Submitted to IRB Chairs for Review") {
if(strtoupper($_POST['trainingFinished'])!= "YES"){ 
die("You did not check the Human Subject Protection Training Finished box. <a href='irb_updatestatus.php?appNum=".$_POST['appNum']."'>Back</a>");
}
else{
   mysql_select_db($database_con3, $con3);
$query_Recordset3 = "SELECT `user`.Email, User_Type FROM `user` where User_Type='IRB Chair'";
$Recordset3 = mysql_query($query_Recordset3, $con3) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

$ActionFlag = "No";
$newaction=$newaction."IRB administrator confirmed HSP Training being finished. The applicant and the IRB Chairs were informed that the applicantion was sent for review.";
  $insertSQL = sprintf("UPDATE application SET ActionFlag=%s, irbActionLog=%s, trainingFinished=%s, Status=%s, ChairReviewDate=%s  WHERE App_Number=%s", GetSQLValueString($ActionFlag, "text"),GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['trainingFinished'], "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($today, "text"), GetSQLValueString($appNum, "text"));
  $subject = "IRB Application ". $_POST['appNum'].": Application Submitted for Review";
  
  $body = "DO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program.\r\rIRB administrator has confirmed that the applicant has finished the required HSP Training. The applicantion is now ready for review. The application number is: ". trim($_POST['appNum']).".\r\rYou may log into the IRB Online Application System to review the application:\r\n".$irbadd."?appNum=".$_POST['appNum']."\r\n";
  
  $body = $body.$emailSig;


do { 
//$i=0;
$chairEmail=$row_Recordset3['Email'];
//echo $chairEmail;
//$to=$chairEmail[$i];
mail($chairEmail,$subject,$body,$headers);

} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
 
	
//applicant gets the email
 $subject = "IRB Application ". $_POST['appNum'].": Application Submitted for Review";
  
  $body = "DO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program.\r\rIRB administrator has confirmed that the applicant has finished the required HSP Training. The applicantion is now ready for review. The application number is: ". trim($_POST['appNum']).".\r\rPlease click the following link to log into IRB Online Application System:\r\n".$irbadd."?appNum=".$_POST['appNum']."\r\n";
  
  $body = $body.$emailSig;
 $toapp = $_POST['emailAdd'];	
mail($toapp,$subject,$body, $headers);

	// copy to faculty
if ($_POST['FacultyEmail'] !="")
	{
	 $subject = "This is a copy of an email message sent to your student ".$_POST['applicantName']."! IRB Application ". $_POST['appNum'];
	$to = $_POST['FacultyEmail'];
	mail($to,$subject,$body, $headers);
	}
	

//copy to oneself
//$sender = $_SESSION['Email'];
	//mail($sender,$subject,$body, $headers);
	 mysql_free_result($Recordset3);
 }
 }
 //*************************************************************

/*
  if($_POST['newstatus'] == "Application Submitted to Reviewers for Review") {
$newaction=$newaction."IRB informed the applicant that IRB sent the applicantion to reviewers for review.";
  $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, Status=%s, ReviewDate=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($today, "text"), GetSQLValueString($appNum, "text"));
  */
  
  /*
  $subject = "IRB Application ". $_POST['appNum'].": Application Submitted to IRB reviewers for Review";
  $body = "\r\rThis email message is generated by the IRB online application program. Do not reply.\r\rAn IRB application has been sent to IRB reviewers for review. Should your application be deemed incomplete by IRB, you will receive another email requesting additional information and/or documents. The application number is: ". $_POST['appNum'];
   
 }
 */ 
 
 //*******************************************************************
  if($_POST['newstatus'] == "IRB Admin Requests Revision") {
  $ActionFlag = "Yes";
  $newaction = $newaction." IRB Admin requests additional information and/or supporting documents.";
  $insertSQL = sprintf("UPDATE application SET ActionFlag=%s, ActionRequestDate=%s, irbActionLog=%s, Status=%s, RevisionRequestDate=%s WHERE App_Number=%s", GetSQLValueString($ActionFlag, "text"), GetSQLValueString($today, "text"), GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($today, "text"), GetSQLValueString($appNum, "text"));
  $subject = "IRB Application ". $_POST['appNum'].": IRB administrator notice. DO NOT REPLY to this message.";
  $body = "\r\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\rThe IRB Administrator has halted the submission of your IRB Application ". $_POST['appNum'].". You will shortly be receiving an email from the IRB detailing the reason for this delay and explaining what you need to do next. Your application is currently unlocked and is available for modification. Please log into the IRB Online Application System to make revisions.\r".$irbadd."\r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";
  $body = $body.$emailSig;
  
    //applicant gets the email
 $to = $_POST['emailAdd'];	
mail($to,$subject,$body, $headers);

	// copy to faculty
if ($_POST['FacultyEmail'] !="")
	{
	 $subject = "This is a copy of an email message sent to your student ".$_POST['applicantName']."! IRB Application ". $_POST['appNum'];
	$to = $_POST['FacultyEmail'];
	mail($to,$subject,$body, $headers);
	}
	
/*
$sender = $_SESSION['Email'];
	mail($sender,$subject,$body, $headers);
	*/
 }
 
   if($_POST['newstatus'] == "IRB Chair Requests Revision") {
   
   $ActionFlag = "Yes";
  $newaction = $newaction." IRB Chair requests additional information and/or supporting documents.";
  $insertSQL = sprintf("UPDATE application SET ActionFlag=%s, ActionRequestDate=%s, irbActionLog=%s, Status=%s, RevisionRequestDate=%s WHERE App_Number=%s", GetSQLValueString($ActionFlag, "text"), GetSQLValueString($today, "text"), GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($today, "text"), GetSQLValueString($appNum, "text"));
  $subject = "Message from IRB: IRB Application ". $_POST['appNum']." halted. DO NOT REPLY to this message.";
  $body = "\r\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\rThe IRB has halted the submission of your IRB Application ". $_POST['appNum']." due to an error or a request for revisions. You will shortly be receiving an email from the IRB detailing the reason for this delay and explaining what you need to do next. Your application is currently unlocked and is available for modification. Please log into the IRB Online Application System to make revisions.\r".$irbadd. "\r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";
$body = $body.$emailSig;
    //applicant gets the email
 $to = $_POST['emailAdd'];	
mail($to,$subject,$body, $headers);

	// copy to faculty
	if ($_POST['FacultyEmail'] !="")
	{
	 $subject = "This is a copy of an email message sent to your student ".$_POST['applicantName']."! IRB Application ". $_POST['appNum'];
	$to = $_POST['FacultyEmail'];
	mail($to,$subject,$body, $headers);
	}
	

/*
$sender = $_SESSION['Email'];
	mail($sender,$subject,$body, $headers);
	*/
 }
 
 //**************************************************************
  if($_POST['newstatus'] == "Application Revision Received (In Response to Request Made by IRB Chair)" || $_POST['newstatus'] == "Application Revision Received (In Response to Request Made by IRB Admin)") {
  $ActionFlag = "No";
$newaction = $newaction. "IRB Online Application informed applicant that the additional information and/or supporting documents requested was received.";
//	$from = "From: ospinfo@txstate.edu";
	$body = "DO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program.\r\rYour IRB Application revision has been submitted for review. The Application number is ".$_POST['appNum']. "\r\rWhile under review, your application is locked but is available as read-only.  You may log into the IRB Online Application System at any time to monitor review status at:\r".$irbadd."\r\rYou will receive notification emails when your application status changes.  If the IRB requests more changes or additions, your application will be unlocked and you will be able to modify it. \r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";
    
  $insertSQL = sprintf("UPDATE application SET ActionFlag=%s, irbActionLog=%s,Status=%s, RevisionDate=%s WHERE App_Number=%s", GetSQLValueString($ActionFlag, "text"), GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($today, "text"), GetSQLValueString($appNum, "text"));
$body = $body.$emailSig;
$subject = "IRB Application Revision Confirmation: ".$appNum;
   $to = $_POST['emailAdd'];	
mail($to,$subject,$body, $headers);
	// copy to faculty
if ($_POST['FacultyEmail'] !="")
	{
	$to = $_POST['FacultyEmail'];
	 $subject = "This is a copy of an email message sent to your student ".$_POST['applicantName']."! IRB Application ". $_POST['appNum'];
	mail($to,$subject,$body, $headers);
	}
	
//copy to oneself
//$sender = $_SESSION['Email'];
//	mail($sender,$subject,$body, $headers);
 }
 
 //*********************************************************
   if($_POST['newstatus'] == "Approved") {
   $newaction = $newaction. "Approved the application. IRB Online Application informed applicant that the application was approved.";
   
  $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, Status=%s, ApprovedDate=%s, lastApprovalDate=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($today, "text"), GetSQLValueString($today, "text"), GetSQLValueString($appNum, "text"));
  $body = "\r\rThis email message is generated by the IRB online application program. Do not reply.\r\r"."Your IRB Application Number ". $_POST['appNum']." has been Approved. The approval is for a one-year period only. You may log into the IRB Online Application System to print out a detailed hard copy of your IRB approval certificate.\r".$irbadd."\r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";

//
if(strtoupper($_POST['User_Type']) == "STUDENT"){


 $body = "\r\rThis email message is generated by the IRB online application program. Do not reply.\r\r"."RB Application Number ". $_POST['appNum']." by ".$_SESSION['name']." under the supervision of Facaulty Member ". $_POST['FacultyFirstName']." ".$_POST['FacultyLastName']. " has been Approved. The approval is for a one-year period only. You may log into the IRB Online Application System to print out a detailed hard copy of your IRB approval certificate.\r".$irbadd."\r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";

}

  $body = $body.$emailSig;
    $subject = "Confirmation of Approval: IRB Application ". $_POST['appNum'].". DO NOT REPLY to this message.";


     $to = $_POST['emailAdd'];	
mail($to,$subject,$body, $headers);
	// copy to faculty
	if ($_POST['FacultyEmail'] !="")
	{
 $subject = "This is a copy of an email message sent to your student ".$_POST['applicantName']."! IRB Application ". $_POST['appNum'];
	$to = $_POST['FacultyEmail'];
	mail($to,$subject,$body, $headers);
	}
	

  }
  
  //*********************************************************
   if($_POST['newstatus'] == "Application Approved - Exempt") {
   $newaction = $newaction. "Approved the application. IRB Online Application informed applicant that the application is exempt from IRB review.";
   
  $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, Status=%s, ApprovedDate=%s, lastApprovalDate=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($today, "text"), GetSQLValueString($today, "text"), GetSQLValueString($appNum, "text"));
 $body = "\r\rThis email message is generated by the IRB online application program. Do not reply.\r\r"."The reviewers have determined that your IRB Application Number ". $appNum." is exempt from IRB review. The project is approved.\r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";

  $body = $body.$emailSig;
    $subject = "Confirmation of Approval: IRB Application ". $_POST['appNum'].". DO NOT REPLY to this message.";


     $to = $_POST['emailAdd'];	
mail($to,$subject,$body, $headers);
	// copy to faculty
	if ($_POST['FacultyEmail'] !="")
	{
 $subject = "This is a copy of an email message sent to your student ".$_POST['applicantName']."! IRB Application ". $_POST['appNum'];
	$to = $_POST['FacultyEmail'];
	mail($to,$subject,$body, $headers);
	}
	

  }
  
  //*************************************************************************************
    if(($_POST['newstatus'] == "Applicant Requested Continuation") || ($_POST['newstatus'] == "Applicant Requested Change")){
	   $newaction = $newaction. "An IRB project continuation/change request was received.";
  $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, Status=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($appNum, "text"));
  
  $body = "\r\rThis email message is generated by the IRB online application program. Do not reply.\r\r"."An IRB project continuation/change request was received. The original IRB application number is: ". $_POST['appNum'];
  $body = $body.$emailSig;
   $subject = "IRB Application ". $_POST['appNum']." continuation request was received.";
  
     $to = $_POST['emailAdd'];	
mail($to,$subject,$body, $headers);
	// copy to faculty
if ($_POST['FacultyEmail'] !="")
	{
 $subject = "This is a copy of an email message sent to your student ".$_POST['applicantName']."! IRB Application ". $_POST['appNum'];
	$to = $_POST['FacultyEmail'];
	mail($to,$subject,$body, $headers);
	}
	}
	//**************************************************************
	 //*************************************************************************************
 if($_POST['newstatus'] == "Application Discontinued") {
$newaction=$newaction."discontinued the application.";

  $insertSQL = sprintf("UPDATE application SET irbActionLog=%s, Status=%s WHERE App_Number=%s", GetSQLValueString($newaction, "text"), GetSQLValueString($_POST['newstatus'], "text"), GetSQLValueString($appNum, "text"));
 //echo $_POST['newstatus'];
  // echo $appNum; 
 }
if($insertSQL!=""){
 mysql_select_db($database_con3, $con3);
$Result1 = mysql_query($insertSQL, $con3) or die(mysql_error()); 
}
  

}
////////////////////////////////////////////////////////////////////////////////////////
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT irbActionLog, FacultyEmail, FacultyFirstName, FacultyLastName, application.ProjectTitle, application.username, facultyCertified, application.ProjectTitle, Status, ReceivedDate, ReviewDate, RevisionRequestDate, RevisionDate, ApprovedDate, trainingFinished, irbActionLog FROM application where App_Number='".$appNum."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$applicant=$row_Recordset1['username'];

mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT `user`.Email, FirstName, LastName, User_Type FROM `user` where username='".$applicant."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$emailAdd=$row_Recordset2['Email'];
$applicantName = $row_Recordset2['FirstName']." ".$row_Recordset2['LastName'];
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
.style45 {color: #000000; }
.style46 {font-weight: bold}
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
			  <div align="center"><a href='osp_irb_home.php' class="irb">My IRB Home</a> </span><span class="style39">|</span> <a href="appSummary_irb.php?appNum=<?php echo $appNum;?>" class="irb">Review Application Data</a> </span><span class="style39">|</span> <a href="statSummary.php?appNum=<?php echo $appNum;?>" class="irb">Summary of Status, Evaluations and Action Logs</a></span><br>
			  <a href="assignReviewer.php?appNum=<?php echo $appNum;?>" class="irb">Assign/Change Reviewer(s)</a> </span><span class="style39">|</span> <a href="irb_updatestatus.php?appNum=<?php echo $appNum;?>" class="irb"> Update Application Status</a> </span><span class="style39">|</span> <a href="irb_emailApp.php?appNum=<?php echo $appNum;?>" class="irb">Send Comments/Requests to Applicant </a> <span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a> </div></td>
          </tr>
  </tbody>
      </table>
      </td>
  </tr><tr><td><table width="100%" bgcolor="#ffffff" cellpadding="6" border="0">
<td valign="top" >
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']."?appNum=".$appNum; ?>">
 
  <div align="center" class="style38">
    <br>
    <strong>APPLICATION STATUS CONTROL CENTER    </strong></div>      
  <div align="left">
   
      <p>
        <?php
//$appNum = $_GET['appNum'];
echo "<p><strong>Application Number:</strong><font color='red'> ".$appNum."</font>";
echo "<br><strong>Project Title:</strong>";
 echo " ".$row_Recordset1['ProjectTitle'];
?>
        <br>
        <strong>Current Status:</strong> <span class="style6"><?php echo $row_Recordset1['Status'];?></span>
        </p>
        </p>
    <?php if(isset($_POST['insert']) && $_POST['insert'] == "formInsert") echo "<font color='red'>Application status updated.</font>";?>
    <div align="center">
 <p><hr><strong>Update Application Status </strong><br>
          
        </p></div>
    <div align="center">
  <table cellpadding="5" cellspacing="-1" border="1">
 
 
<tr>
	<td><div align="left" class="style45">
	    <input name="newstatus" type="radio" value="Application in Process" <?php if($row_Recordset1['Status']== "Application in Process") echo "Checked";?>/>
	    Application in Process </div></td>
      <td class="style38"><div align="left">
        <input name="newstatus" type="radio" value="Application Submitted to Reviewers for Review" <?php if($row_Recordset1['Status']== "Application Submitted to Reviewers for Review") echo "Checked";?>/>
Application Submitted to Reviewers for Review</div></td>
    </tr>
	
	<tr>
	  <td width="359"><div align="left" class="style45">
	    <input name="newstatus" type="radio" value="Application Submitted" <?php if($row_Recordset1['Status']== "Application Submitted") echo "Checked";?>/>
	    Application Submitted </div></td>
      <td width="363" class="style38"><div align="left">
        <input name="newstatus" type="radio" value="IRB Chair Requests Revision" <?php if($row_Recordset1['Status']== "IRB Chair Requests Revision") echo "Checked";?> />
IRB Chair Requests Revision</div></td>
    </tr>
		    <tr>
		      <td><div align="left" class="style45">
		        <input name="newstatus" type="radio" value="IRB Admin Requests Revision" <?php if($row_Recordset1['Status']== "IRB Admin Requests Revision") echo "Checked";?> />
	          IRB Admin Requests Revision</div></td>
		      <td class="style38"><div align="left">
		        <input name="newstatus" type="radio" value="Application Revision Received (In Response to Request Made by IRB Chair)" <?php if($row_Recordset1['Status']== "Application Revision Received (In Response to Request Made by IRB Chair)") echo "Checked";?>>
Application Revision Received <br>
(In Response to Request Made by IRB Chair) </div></td>
	      </tr>
		    <tr>
		      <td><div align="left"><span class="style45">
		        <input name="newstatus" type="radio" value="Application Revision Received 
(In Response to Request Made by IRB Admin)" <?php if($row_Recordset1['Status']== "Application Revision Received 
(In Response to Request Made by IRB Admin)") echo "Checked";?>>
		        Application Revision Received <br>
		        (In Response to  Request Made by IRB Admin) </span></div></td>
		      <td class="style38"><div align="left">
                  <input name="newstatus" type="radio" value="Application Approved - Exempt" <?php if($row_Recordset1['Status']== "Application Approved - Exempt") echo "Checked";?>/>
		        Application Approved - Exempt  </div></td>
		    </tr>
		    <tr>
		      <td><div align="left" class="style45">
		        <input name="newstatus" type="radio" value="IRB Admin Requests Applicant and/or Supervising Faculty Complete HSP Training" <?php if($row_Recordset1['Status']== "IRB Admin Requests Applicant and/or Supervising Faculty Complete HSP Training") echo "Checked";?> />
IRB Admin Requests Applicant and/or Supervising Faculty Complete HSP Training </div></td>
      <td class="style38"><div align="left">
        <input name="newstatus" type="radio" value="Approved" <?php if($row_Recordset1['Status']== "Approved") echo "Checked";?>/>
Application Approved</div></td>
    </tr>
	<tr>
	  <td bgcolor="#E9EBEF"><div align="left" class="style45">
	    <p><strong>Following two fields need to be checked together:</strong>	   
	    <br>
	      <input name="trainingFinished" type="checkbox" id="trainingFinished" value="yes" 
		<?php if(strtoupper($row_Recordset1['trainingFinished'])== "YES") echo "Checked";?>>
	      Human Subject Protection Training Finished 
	      <br>
	      <input name="newstatus" type="radio" value="Application Submitted to IRB Chairs for Review" <?php if($row_Recordset1['Status']== "Application Submitted to IRB Chairs for Review") echo "Checked";?>/>
Application Submitted to IRB Chairs for Review<br>
	              <br>
	        </p>
	  </div></td>
      <td class="style38"><div align="left">
        <input name="newstatus" type="radio" value="Applicant Requested Continuation" <?php if($row_Recordset1['Status']== "Applicant Requested Continuation") echo "Checked";?>/>
Applicant Requested Continuation<p>

        <input name="newstatus" type="radio" value="Applicant Requested Change" <?php if($row_Recordset1['Status']== "Applicant Requested Change") echo "Checked";?>/>
Applicant Requested Change</div></td></tr><tr>
	<td >
	     <input name="newstatus" type="radio" value="Application Discontinued" <?php if($row_Recordset1['Status']== "Application Discontinued") echo "Checked";?>/>
Application Discontinued</div></td>
<td >
    <input name="Certified" type="checkbox" disabled ="true" value="Yes" <?php if($row_Recordset1['facultyCertified']== "Yes") echo "Checked";?>/>
Application Certified by Faculty Member<br>
<?php
if($row_Recordset1['facultyCertified'] <> "Yes"){
    ?>
 <input name="facultyCertified" type="checkbox" value="Yes" />
Approve Application On Behalf of Faculty Member
<?php
}
?>
  </div>
</td>
    </tr>
	 </td></tr></table></td></tr> 
	
   
	<tr>
	  <td colspan="2" class="style38"><input name="appNum" type="hidden" value="<?php echo $appNum; ?>" />	    <input name="irbActionLog" type="hidden" value="<?php echo $row_Recordset1['irbActionLog']; ?> " />
        <input type="hidden" id="emailAdd" name="emailAdd" value="<?php echo $row_Recordset2['Email']; ?>">
		<input type="hidden" id="FacultyEmail" name="FacultyEmail" value="<?php echo $row_Recordset1['FacultyEmail']; ?>">
		<input type="hidden" id="FacultyFirstName" name="FacultyFirstName" value="<?php echo $row_Recordset1['FacultyFirstName']; ?>">
		<input type="hidden" id="FacultyLastName" name="FacultyLastName" value="<?php echo $row_Recordset1['FacultyLastName']; ?>">
			<input type="hidden" id="applicantName" name="applicantName" value="<?php echo $applicantName; ?>">
		<input type="hidden" id="User_Type" name="User_Type" value="<?php echo $row_Recordset2['User_Type']; ?>">
	    <input name="insert" id="insert" type="hidden" value="formInsert" /></td>
	  </tr>
	
      <tr>
        <td colspan="2" class="style38">
        
            <div align="center">
              <input name="Submit" type="submit" id="Submit" value="Update Application Status" />    
              
              </p>
            </div>
        </form></td>
</tr><tr><td><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>

</table>
</body>
</html>


<?php
mysql_free_result($Recordset2);
//

mysql_free_result($Recordset1);


?>
