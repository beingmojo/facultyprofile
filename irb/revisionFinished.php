<?php require_once('Connections/con3.php'); 
require_once('variables/variables.php');
session_start();
$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

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

if ($_POST['appsub']){
$appNum=$_POST["appNum"];
mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT Status, irbActionLog from application where App_Number='".$appNum."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

//echo "<br>".$row_Recordset2['Status']."<br>";
$Status=$row_Recordset2['Status'];
$irbActionLog=$row_Recordset2['irbActionLog'];
//echo "<br>actionLog=".$appActionLog;
/////////////////////////////////////////////////////////
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT `user`.Email, `user`.User_Type FROM `user` where User_Type='IRB Staff'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$irbEmail = $row_Recordset1['Email'];

//echo $irbEmail;

  // Reviewers
mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT FacultyEmail, username, application.rev1ID, application.rev2ID, application.rev3ID FROM application where App_Number='".$appNum."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$FacultyEmail=$row_Recordset2['FacultyEmail'];
$applicant = $row_Recordset2['username'];
//////////////////////////////////////////////////

mysql_select_db($database_con3, $con3);
$query = "SELECT FirstName, LastName FROM `user` where username='".$applicant."'";
$record = mysql_query($query, $con3) or die(mysql_error());
$row_record = mysql_fetch_assoc($record);
$totalRows_record = mysql_num_rows($record);
$applicantName = $row_record['FirstName']." ".$row_record['LastName'];
mysql_free_result($record);

//////////////////////
mysql_select_db($database_con3, $con3);
$query_Recordset3 = "SELECT `user`.Email FROM `user` where User_Type='IRB Chair'";
$Recordset3 = mysql_query($query_Recordset3, $con3) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);


///////////////////////////////////////////////////

 $reviewerID1  = $row_Recordset2['rev1ID'];
   if($reviewerID1){ 
   if (!get_magic_quotes_gpc()){$reviewerID1=addslashes($reviewerID1);}}
  // echo "Reviewers: ".$reviewerIDs."<p>";
//$arrReviewerID = explode(",", $reviewerIDs);
//echo "Number of reviewer:".count($arrReviewerID);

$reviewerID2  = $row_Recordset2['rev2ID'];
if($reviewerID2){ 
if (!get_magic_quotes_gpc()){$reviewerID2=addslashes($reviewerID2);}}

$reviewerID3  = $row_Recordset2['rev3ID'];
if($reviewerID3){ 
if (!get_magic_quotes_gpc()){$reviewerID3=addslashes($reviewerID3);}}

////////////////////////////////////////////
if($reviewerID1){ 
mysql_select_db($database_con3, $con3);
$sqlRev=sprintf("SELECT Email FROM user where username='%s'", $reviewerID1);

$rev = mysql_query($sqlRev, $con3) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev);
//echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName']." / ";
$rev1Email = $rs_rev['Email'];
mysql_free_result($rev);
}

if($reviewerID2){ 
mysql_select_db($database_con3, $con3);
$sqlRev=sprintf("SELECT Email FROM user where username='%s'", $reviewerID2);

$rev = mysql_query($sqlRev, $con3) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev);
//echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName']." / ";
$rev2Email = $rs_rev['Email'];
mysql_free_result($rev);
}

if($reviewerID3){ 
mysql_select_db($database_con3, $con3);
$sqlRev=sprintf("SELECT Email FROM user where username='%s'", $reviewerID3);

$rev = mysql_query($sqlRev, $con3) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev);
//echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName'];
$rev3Email = $rs_rev['Email'];
mysql_free_result($rev);
}
////////////////////////////////////
$today=date("m/d/y H:i:s");

  if ($Status == "IRB Admin Requests Revision"){
  		$irbActionLog=$irbActionLog."<br><BR>".$today." ".$_SESSION['username'].":<br>Submitted revision/uploaded supporting document(s) in response to the request made by the IRB Administrator.";
	$to = $irbEmail;
	$body = "\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program.\r\rAn IRB application revision has been submitted for review. The application number is ".$appNum.". \r\rYou may log into the IRB Online Application System to review the application.\r".$irbadd."?appNum=".$appNum."\r\n";
    $body = $body.$emailSig;
	$subject = "IRB application ".$appNum.": Application Revision Submitted";

	mail($to,$subject,$body, $headers);
	
	//////////////////
	$ActionFlag="No";
	$newstatus = "Application Revision Received (In Response to Request made by IRB Admin)";
$insertSQL = sprintf("UPDATE application SET ActionFlag=%s, irbActionLog=%s, Status=%s, RevisionDate=%s WHERE App_Number=%s", GetSQLValueString($ActionFlag, "text"), GetSQLValueString($irbActionLog, "text"),GetSQLValueString($newstatus, "text"), GetSQLValueString($today, "text"), GetSQLValueString($appNum, "text"));
	

	}
	
	///////////////////////////////////////////////////
	if ($Status == "IRB Chair Requests Revision"){

		$irbActionLog=$irbActionLog."<br><BR>".$today." ".$_SESSION['username'].":<br> Submitted revision/uploaded supporting document(s) in response to the request made by IRB Chair/reviewers.";
	//////////Email to Chairs/////////////////////////////////
		$body = "\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program.\r\rAn IRB application revision has been submitted for review. The application number is ".$appNum.". \r\rYou may log into the IRB Online Application System to review the application:\r".$irbadd."\r\n";
    $body = $body.$emailSig;
		$subject = "IRB application ".$appNum.": Application Revision Submitted";
		/////////////////////Email Reviewers/////////////////////////////////////////

 //Email to reviewers
 	if ($rev1Email)
 	{
 		$to = $rev1Email;

		mail($to,$subject,$body,$headers);
 
 	}
 
 	 if ($rev2Email)
 	{
 		$to = $rev2Email;
	
		mail($to,$subject,$body,$headers);
	 }
 
  if ($rev3Email)
 	{
 	$to = $rev3Email;

	mail($to,$subject,$body,$headers);
 	}
 
	/////////////email to chairs
	do { 
		$i=0;
		
		$to=$row_Recordset3['Email'];
		//$to = "ys11@txstate.edu";
		mail($to,$subject,$body,$headers);

		} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));

$ActionFlag="No";
	$newstatus = "Application Revision Received (In Response to Request Made by IRB Chair)";
$insertSQL = sprintf("UPDATE application SET ActionFlag=%s, irbActionLog=%s, Status=%s, RevisionDate=%s WHERE App_Number=%s", GetSQLValueString($ActionFlag, "text"), GetSQLValueString($irbActionLog, "text"),GetSQLValueString($newstatus, "text"), GetSQLValueString($today, "text"), GetSQLValueString($appNum, "text"));
	
	} //if chairs request revision


	/////////////////////Confirmation to applicant ////////////////////////////
	
$body = "\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\rYour IRB Application revision has been submitted for review. The Application number is ".$_POST['appNum']. ".\r\rWhile under review, your application is locked but is available as read-only.  You may log into the IRB Online Application System at any time to monitor review status at:\r".$irbadd."\r\rYou will receive notification emails when your application status changes.  If the IRB requests more changes or additions, your application will be unlocked and you will be able to modify it. \r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";
	
	$body = $body.$emailSig;
	
	$subject = "IRB Application Revision Confirmation: ".$_POST['appNum'];
	$to=$_SESSION['Email'];
	mail($to,$subject,$body, $headers);
	
	// copy to faculty
	if (strtoupper($_SESSION['User_Type']) == "STUDENT")
	{
	 $subject = "This is a copy of an email message sent to your student ".$applicantName."! IRB Application ". $_POST['appNum'];
	$to = $FacultyEmail;
	mail($to,$subject,$body, $headers);
	}
	
////////////////Update Database///////////////////////////////////


 mysql_select_db($database_con3, $con3);
$Result1 = mysql_query($insertSQL, $con3) or die(mysql_error());

////////////// if chair request revision /////////////////
	if ($Status == "IRB Chair Requests Revision"){
	$recordset = mysql_query("select rev1Approved, rev2Approved, rev3Approved from application where App_Number = '".$appNum."'", $con3);
$rowset = mysql_fetch_assoc($recordset);
$rev1Approved = $rowset['rev1Approved'];
$rev2Approved = $rowset['rev2Approved'];
$rev3Approved = $rowset['rev3Approved'];
 mysql_free_result($recordset);
 
///////////////////
$recordset = mysql_query("select reviewNum from reviewlog where appNum = '".$appNum."'", $con3);
$rowset = mysql_fetch_assoc($recordset);
$reviewnum=1;
do{
$reviewnum = max($reviewnum, $rowset['reviewNum']);

}while($rowset = mysql_fetch_assoc($recordset));
$reviewnum = $reviewnum + 1;
//echo $reviewnum."<br>";
////////////////////
 mysql_select_db($database_con3, $con3);

 
$insertSQL = "insert into reviewlog (appNum, noticeChair, reviewNum,reviewRequestingDate) values ('".$appNum."', 'No','".$reviewnum."', '".$today."')";
$result = mysql_query($insertSQL, $con3);
////////////////////////////////////////////////////////////////////////

 if (strtoupper($rev1Approved) == 'YES')
 $updateSQL = "update reviewlog set rev1Finished = 'Yes' where (reviewNum = '".$reviewnum."' && appNum ='".$appNum."')";
 $result = mysql_query($updateSQL, $con3);
  if (strtoupper($rev2Approved) == 'YES')
 $updateSQL = "update reviewlog set rev2Finished = 'Yes' where (reviewNum = '".$reviewnum."' && appNum ='".$appNum."')";
 $result = mysql_query($updateSQL, $con3);
 if (strtoupper($rev3Approved) == 'YES')
 $updateSQL = "update reviewlog set rev3Finished = 'Yes' where (reviewNum = '".$reviewnum."' && appNum ='".$appNum."')";
 $result = mysql_query($updateSQL, $con3);
 mysql_free_result($recordset);
 }//end if chair request revision
 
    mysql_free_result($Recordset1);
	 mysql_free_result($Recordset2);
    mysql_free_result($Recordset3);
	
 header("Location: ". $_SESSION['myhome']); 
exit;

}
?>
