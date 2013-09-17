<?php require_once('../Connections/con3.php');
session_start();
require_once('../variables/variables.php');
$restrictGoTo = "../unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT `user`.Email FROM `user` where User_Type = 'IRB Staff'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);



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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$today=date("m/d/y H:i:s");
  
  $ID = mt_rand(0000, 10000);
 
$ID = chr(rand(65,90)).$ID;
$ID= "CON".date("Y").$ID;
  
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$errmsg = "";
   
   
     if(trim($_POST['App_Number']) =="" )
   {
      $errmsg = $errmsg.'Original IRB Application Number is required\r';
   }
   if(trim($_POST['IRBDecisionHardCopy']) =="" )
   {
      $errmsg = $errmsg.'Do you require a signed hard copy of the IRB decision for your records?\r';
   } 
     if(trim($_POST['StudyStatus']) =="")
   {
      $errmsg = $errmsg.'Section 2, Question 1 is required\r';
	    
	}
   if((trim($_POST['StudyStatus']) =="Other" ) && (trim($_POST['StudyStatusExplanation']) =="" ))
   {
      $errmsg = $errmsg. 'Section 2, Question 1: Study Status Explanation is required\r';
	
	  
   } 
   if(trim($_POST['NumberOfParticipantsApproved']) =="")
   {
      $errmsg = $errmsg.'Section 2, Question 2 is required\r';
	    
	}
   
     if(trim($_POST['ParticipantsEnrolledSinceLastReview']) =="" )
   {
      $errmsg = $errmsg.'Section 2, Question 3 is required\r';
	   
	}
   
     if(trim($_POST['ParticipantsEnrolledToDate']) =="" )
   {
      $errmsg = $errmsg.'Section 2, Question 4 is required\r';
	     
	}
	
	    if(trim($_POST['RelationshipChange']) =="" ){
      
      $errmsg = $errmsg.'Section 2, Question 6 is required\r';
	   
	}
	 if($_POST['PIChange']=="")
	 	$errmsg = $errmsg.'Section 2, Question 7 is required\r';
     if(($_POST['PIChange']=="Yes") &&($_POST['PIChangeExplanation']==""))
		$errmsg = $errmsg.'Section 2, Question 7: Explanation is required\r';
     
	 
	 if($_POST['ResultsSummary']=="")
	 $errmsg = $errmsg.'Section 2, Question 8 is required\r';
	 
     if($_POST['UnanticpatedProblems']=="")
	 $errmsg = $errmsg.'Section 2, Question 9 is required\r';
      if($_POST['RiskBenefitChange']=="")
	  $errmsg = $errmsg.'Section 2, Question 10 is required\r';
	  
      if(($_POST['RiskBenefitChange']=="Yes") && ($_POST['RiskBenefitChangedExplanation']==""))
	  $errmsg = $errmsg.'Section 2, Question 10, Explanation  is required\r';
    
	if (strlen($errmsg)>1) {

//echo "<font color='red'>Following errors occured:</font><br>".$errmsg;
?>

<?php
include "irb_continuation_change_form_back.php";
?><script language="JavaScript">
alert("<?php echo $errmsg;?>");
</script>
<?php
}

else


{

mysql_select_db($database_con3, $con3);
/* wait for a year later
$query_Recordset2 = "SELECT App_Number FROM application where App_Number = '".$_POST['App_Number']."' and (Status = 'Approved' || Status='Applicant requested continuation')";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

if ($totalRows_Recordset2 <1){
echo "Your application cannot be proceeded. It is either because the system could not find your application with the application number you provided, or your original IRB application has not been approved. <a href='irb_continuation_change_form.php'>Back</a>";
exit;
mysql_free_result($Recordset2);
	}
	*/

//Good for this year
$query_Recordset2 = "SELECT App_Number FROM application where App_Number = '".$_POST['App_Number']."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
	
//number of continuation times
mysql_select_db($database_con3, $con3);
$query_Recordset3 = "SELECT * FROM continuation where App_Number = '".$_POST['App_Number']."'";
$Recordset3 = mysql_query($query_Recordset3, $con3) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
if ($totalRows_Recordset3 >=2){
echo "You have applied for continuation/change for this project two times. You can not make this request anymore. <a href='javascript:history.back()'>Back</a>";
mysql_free_result($Recordset3);
exit;
}

$appFinished= "No";
$approval="No";
  $insertSQL = sprintf("INSERT INTO continuation (appFinished, ID, App_Number, GrantIDNumber, LengthOfProject, IRBDecisionHardCopy, StudyStatus, StudyStatusExplanation, NumberOfParticipantsApproved, ParticipantsEnrolledSinceLastReview, ParticipantsEnrolledToDate, DifferentEnrollmentExplanation, RelationshipChange, PIChange, PIChangeExplanation, ResultsSummary, UnanticpatedProblems, RiskBenefitChange, RiskBenefitChangedExplanation, ChangesInStudySinceApproval, ReceiveDate,Approval, username) VALUES (%s, %s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s)",
  					GetSQLValueString($appFinished, "text"),
    					GetSQLValueString($_POST['ID'], "text"),
                       GetSQLValueString($_POST['App_Number'], "text"),
                       GetSQLValueString($_POST['GrantIDNumber'], "text"),
                       GetSQLValueString($_POST['LengthOfProject'], "text"),
                       GetSQLValueString($_POST['IRBDecisionHardCopy'], "text"),
                       GetSQLValueString($_POST['StudyStatus'], "text"),
                       GetSQLValueString($_POST['StudyStatusExplanation'], "text"),
                       GetSQLValueString($_POST['NumberOfParticipantsApproved'], "text"),
                       GetSQLValueString($_POST['ParticipantsEnrolledSinceLastReview'], "text"),
                       GetSQLValueString($_POST['ParticipantsEnrolledToDate'], "text"),
                       GetSQLValueString($_POST['DifferentEnrollmentExplanation'], "text"),
                       GetSQLValueString($_POST['RelationshipChange'], "text"),
                       GetSQLValueString($_POST['PIChange'], "text"),
                       GetSQLValueString($_POST['PIChangeExplanation'], "text"),
                       GetSQLValueString($_POST['ResultsSummary'], "text"),
                       GetSQLValueString($_POST['UnanticpatedProblems'], "text"),
                       GetSQLValueString($_POST['RiskBenefitChange'], "text"),
                       GetSQLValueString($_POST['RiskBenefitChangedExplanation'], "text"),
                       GetSQLValueString($_POST['ChangesInStudySinceApproval'], "text"),
					   GetSQLValueString($today, "text"),
					   GetSQLValueString($approval, "text"),
					   GetSQLValueString($_SESSION['username'], "text")
					   );

  mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($insertSQL, $con3) or die(mysql_error());
 
 ///////////////////////// /////////////////////////////////////////
 if ($totalRows_Recordset2 >0){
  $status = "Applicant Requested Continuation";
  $insertSQL = sprintf("UPDATE application SET Status=%s WHERE App_Number=%s", GetSQLValueString($status, "text"), GetSQLValueString($_POST['App_Number'], "text"));
   mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($insertSQL, $con3) or die(mysql_error());
  }
  /////////////////////////////////////////////////////////////////////
  $body = "DO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\rYour Continuation/Change request has been submitted for review. Your continuation application number is ".$_POST['ID']. ". Your original IRB Application Number is ".$_POST['App_Number'].". While under review, your application is locked but is available as read-only.  You may log into the IRB application module at any time to monitor review status. \r\rYou will receive notification emails when your application status changes.  \r\rIf you have questions, please submit an IRB Inquiry form: http://www.txstate.edu/research/irb/irb_inquiry.html\r";

   $to = $_POST['emailAdd'];	
 $subject = "Confirmation: IRB Application Continuation/Change ".$_POST['ID']." -  submitted for review";

mail($_SESSION['Email'],$subject,$body, $headers);

//email to IRB
$subject = "IRB Application Continuation/Change ".$_POST['ID']." -  submitted for review";
  $body = "DO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\rA IRB Continuation/Change request has been submitted for review. Application number: ".$_POST['ID']. ". The original IRB Application Number: ".$_POST['App_Number'].".";
  $body = $body.$emailSig;
mail($to,$subject,$body, $headers);
$to = $irbchairemail;
mail($to,$subject,$body, $headers);

mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="../irbstyle.css" rel="stylesheet" type="text/css">


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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td valign="top"><p align="left" class="style6 style24"><img src="../banner2.jpg" height="160"></td>
            <td valign="middle" background="../tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
          
            </span></td>
 
  </tr>
</tbody></table> 

</td></tr><tr><td><table width="100%" bgcolor="#FFFFFF" border="0">

 <tr>
    <td bgcolor="#000000" align="center">
   <a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="irb_listContinuation_app.php" class="irb">My IRB Continuation/Change Applications</a><span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a><br>
     
      </td></tr>
		<tr><td> 
      <p align="center">&nbsp;</p>
      <p align="center"><?php echo $_SESSION['name'];?></p></td>
        </tr>
<?php
 echo "<td><br><br><br>You have submitted an IRB Continuation/Change application. Application number: ".$_POST['ID']. ". A confirmation message has been sent to you. Your application has been submitted for review. While under review, your application is locked but is available as read-only.  You may log into the IRB application system at any time to monitor review status. <br><br><br></td></tr>";
 
 ?>
 <tr><td><br><br></br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table>
<?php
}

}


else{
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="../irbstyle.css" rel="stylesheet" type="text/css">


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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td valign="top"><p align="left" class="style6 style24"><img src="../banner2.jpg" height="160"></td>
            <td valign="middle" background="../tbbg.gif"><p align="center" class="tsu">Texas State University</p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
          
            </span></td>
 
  </tr>
</tbody></table>
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
      <div align="center"><a class="irb" href="../<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42">|</span> <a href="irb_listContinuation_app.php" class="irb">My IRB Continuation/Change Applications</a> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log
        Out</a></div></td>
  </tr>
  <tr><td colspan="4"><div align="center">
  
      <br>
      <?php echo $_SESSION['name'];?></div></td>
  </tr><tr><td colspan="4">
    <tr><td>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="style46">
    <p align="center" class="style47">&nbsp;</p>
    <p align="center" class="style47"><strong>APPLICATION FOR IRB CONTINUATION/CHANGE </strong></p>
	 <p>This is your IRB Continuation/Change Application Number: <font color="#CC0033"><?php echo $ID;?></font></p><hr />
    <p class="style48"><strong>Section 1    </strong></p>
    <p class="style47">&nbsp;1.&nbsp;	Original IRB Reference Number&nbsp;&nbsp;&nbsp;
      <input name="App_Number" type="text" id="App_Number" value="<?php echo $_GET['appNum'];?>" size="35" />
    </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	State the grant ID number (N/A if not funded):&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="GrantIDNumber" type="text" id="GrantIDNumber" value="" size="30" />
  </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; State the length of project period (N/A if not funded):&nbsp;
      <input name="LengthOfProject" type="text" id="LengthOfProject" value="" size="30" />
  </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Do you require a signed hard copy of the IRB's decision for your records?&nbsp;&nbsp;&nbsp;
      <input name="IRBDecisionHardCopy" type="radio" value="Yes" />
      Yes&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="IRBDecisionHardCopy" type="radio" value="No" />
    No</p>
  <p class="style48"><strong>Section 2 </strong></p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp; What is the status of your study?</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <select name="StudyStatus" id="StudyStatus">
        <option selected="selected">Choose One</option>
        <option value="Data Analysis Only">Data Analysis Only</option>
        <option value="Study on Hold">Study on Hold</option>
        <option value="Study Not Begun">Study Not Begun</option>
        <option value="Following Subjects">Following Subjects</option>
        <option value="Recruiting Subjects">Recruiting Subjects</option>
        <option value="Other - Explain in Next Box">Other - Explain in Next Box</option>
        </select>
&nbsp;&nbsp;&nbsp; </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; If you chose &quot;Other&quot;, please provide an explanation (N/A if &quot;Other&quot; is not chosen as the status of the study): </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="StudyStatusExplanation" cols="55" id="StudyStatusExplanation"></textarea>
  </p>
  <p class="style47">&nbsp;2. Total number of participants <em><strong>approved</strong></em> for the study:
    <input name="NumberOfParticipantsApproved" type="text" id="NumberOfParticipantsApproved" value="" size="15" />
  </p>
  <p class="style47">&nbsp;3. Number of participants <em><strong>enrolled since last IRB review (continuing or initial)</strong></em>:&nbsp;
      <input name="ParticipantsEnrolledSinceLastReview" type="text" id="ParticipantsEnrolledSinceLastReview" value="" size="15" />
  </p>
  <p class="style47">&nbsp;4. Number of participants <em><strong>enrolled in the study to date </strong></em>:&nbsp;
      <input name="ParticipantsEnrolledToDate" type="text" id="ParticipantsEnrolledToDate" value="" size="15" />
      </p>
  <p class="style47">&nbsp;5. If actual total enrollment is different from the original project enrollment, provide an explanation (N/A if there is no difference in total enrollment):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;
      <textarea name="DifferentEnrollmentExplanation" cols="65" id="DifferentEnrollmentExplanation"></textarea>
  </p>
  <p class="style47">&nbsp;6.&nbsp; Has your relationship with the study sponsor changed since the IRB review in any way which might require conflict of interest disclosure (e.g. stock purchases, royalty payments, patents, Board position, etc.)?</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="RelationshipChange" type="radio" value="Yes" />
    Yes</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="RelationshipChange" type="radio" value="No" />
    No</p>
  <p class="style47">&nbsp;7.&nbsp; Have there been any changes in Principal Investigator, Co-Investigators or staff?</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="PIChange" type="radio" value="Yes" />
    Yes</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;
    &nbsp;
         <input name="PIChange" type="radio" value="No" />
    No</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> If yes,</strong> please explain (N/A if answer above is &quot;No&quot;):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp; &nbsp;
      <textarea name="PIChangeExplanation" cols="65" id="PIChangeExplanation"></textarea>
  </p>
  <p class="style47">&nbsp;8.&nbsp; Summarize preliminary information about any results and/or trends (DO NOT LEAVE BLANK):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="ResultsSummary" cols="65" rows="6" id="ResultsSummary"></textarea>
  </p>
  <p class="style47">&nbsp;9.&nbsp; Describe any unanticipated problems in the conduct of the study (if none, state &quot;None&quot;):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="UnanticpatedProblems" cols="65" rows="6" id="UnanticpatedProblems"></textarea>
  </p>
  <p class="style47">10.&nbsp; Has the risk/benefit relationship for subjects changed from the initial expectation?</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="RiskBenefitChange" type="radio" value="Yes" />
    Yes</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;
    &nbsp;
        <input name="RiskBenefitChange" type="radio" value="No" />
    No</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>If yes,</strong> describe what has changed from the initial expectations (N/A if &quot;No&quot; is chosen above):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp; &nbsp;
      <textarea name="RiskBenefitChangedExplanation" cols="65" rows="6" id="RiskBenefitChangedExplanation"></textarea>
  </p>
  <p class="style47">11.&nbsp; List and explain any other changes in the study or study period originally approved by the IRB (if none, state &quot;none&quot;):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="ChangesInStudySinceApproval" cols="65" rows="6" id="ChangesInStudySinceApproval"></textarea>
  </p>
  <span class="style47">
  Please check your answers carefully before submitting.</span>
  <input type="hidden" name="ID" value="<?php echo $ID;?>">
 
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" id = "emailAdd" name="emailAdd" value="<?php echo $row_Recordset1['Email'];?>">
  <p align="center">
    <input name="Submit" type="submit" value="Submit Application and Return Home" />
    </form>
    </td>
    </tr></table><tr><td><br><br></br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table>
</td></tr></table>
</body>
</html>
<?php

mysql_free_result($Recordset1);
}
?>
