<?php require_once('../Connections/con3.php');
session_start();

$restrictGoTo = "../unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


$id=$_GET["ID"];
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT continuation.App_Number, continuation.GrantIDNumber, continuation.LengthOfProject, continuation.IRBDecisionHardCopy, continuation.StudyStatus, continuation.StudyStatusExplanation, continuation.NumberOfParticipantsApproved, continuation.ParticipantsEnrolledSinceLastReview, continuation.ParticipantsEnrolledToDate, continuation.DifferentEnrollmentExplanation, continuation.RelationshipChange, continuation.PIChange, continuation.PIChangeExplanation, continuation.ResultsSummary, continuation.UnanticpatedProblems, continuation.RiskBenefitChange, continuation.RiskBenefitChangedExplanation, continuation.ChangesInStudySinceApproval FROM continuation where ID='".$id."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style46 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: medium;
}
.style47 {font-size: small}
.style48 {	font-size: 14px;
	font-weight: bold;
}
.style49 {	font-size: 16px;
	font-weight: bold;
}
.style50 {color: #0000CC}
.style51 {font-size: small; color: #0000CC; }
.style52 {color: #3300CC}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" class="style46" id="form1">
  <p align="center" class="style47"><span class="style49">Application for IRB Continuation/Change</span>
      <input type="hidden" name="DestinationEmail" value="ys11@txstate.edu" />
      <input type="hidden" name="thankyoupage"  value= ""/>
      <input name="messagesubject" type="hidden" id="messagesubject" value="Confirmation-IRB Continuation/Change" />
      <input type="hidden" name="options" value="send-to-sender" />
  </p>
  <p class="style48">Section 1 </p>
  <p class="style47">&nbsp;1.&nbsp;	Original IRB Reference Number:&nbsp;&nbsp;<span class="style50">&nbsp;</span></p>
  <blockquote>
    <p class="style47"><span class="style52"><?php echo $row_Recordset1['App_Number']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	State the grant ID number:&nbsp;&nbsp;&nbsp;&nbsp;</p>
  <blockquote>
    <p class="style47"><span class="style52"><?php echo $row_Recordset1['GrantIDNumber']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; State the length of project period:&nbsp;</p>
  <blockquote>
    <p class="style47"><span class="style52">	<?php echo $row_Recordset1['LengthOfProject']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Do you require a signed hard copy of the IRB's decision for your records?&nbsp;&nbsp;&nbsp;</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['IRBDecisionHardCopy']; ?></p>
  </blockquote>
  <p class="style47"><span class="style48">Section 2 </span></p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp; What is the status of your study?</p>
  <blockquote>
    <p align="left" class="style47">&nbsp; <span class="style52"><?php echo $row_Recordset1['StudyStatus']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; If you chose &quot;Other&quot;, please provide an explanation: </p>
  <blockquote>
    <p class="style47"><span class="style52"><?php echo $row_Recordset1['StudyStatusExplanation']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;2. Total number of participants <em><strong>approved</strong></em> for the study:</p>
  <blockquote>
    <p class="style51">  <?php echo $row_Recordset1['NumberOfParticipantsApproved']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;3. Number of participants <em><strong>enrolled since last IRB review (continuing or initial):</strong></em></p>
  <blockquote>
    <p class="style47"><span class="style52"><?php echo $row_Recordset1['ParticipantsEnrolledSinceLastReview']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;4. Number of participants <em><strong>enrolled in the study to date </strong></em>: </p>
  <blockquote>
    <p class="style47"><span class="style52"><?php echo $row_Recordset1['ParticipantsEnrolledToDate']; ?></span>&nbsp;</p>
  </blockquote>
  <p class="style47">&nbsp;5. If actual total enrollment is different from the original project enrollment, provide an explanation:</p>
  <blockquote>
    <p class="style47"><span class="style52"><?php echo $row_Recordset1['DifferentEnrollmentExplanation']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;6.&nbsp; Has your relationship with the study sponsor changed since the IRB review in any way which might require conflict of interest disclosure (e.g. stock purchases, royalty payments, patents, Board position, etc.)??</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['RelationshipChange']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;7.&nbsp; Have there been any changes in Principal Investigator, Co-Investigators or staff?</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['PIChange']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> If yes,</strong> please explain:</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['PIChangeExplanation']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;8.&nbsp; Summarize preliminary information about any results and/or trends (DO NOT LEAVE BLANK):</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['ResultsSummary']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;9.&nbsp; Describe any unanticipated problems in the conduct of the study (if none, state &quot;none&quot;):</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['UnanticpatedProblems']; ?></p>
  </blockquote>
  <p class="style47">10.&nbsp; Has the risk/benefit relationship for subjects changed from the initial expectation?</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['RiskBenefitChange']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>If yes,</strong> describe what has changed from the initial expectations:</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['RiskBenefitChangedExplanation']; ?></p>
  </blockquote>
  <p class="style47">11.&nbsp; List and Explain any other changes in the study or study period originally approved by the IRB (if none, state &quot;none&quot;):</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['ChangesInStudySinceApproval']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;**Please note:  All current consent/assent forms, even if unchanged from original submission, should be submitted directly to the OSP IRB administrator, via email or hard copy. Please include your name and IRB reference number on all documents. <br />
    <br />
      Please check your answers carefully before submitting.Completed submissions will result in a confirmation email which will contain your data as submitted to the email address you provided. If you do not receive a confirmation, please contact OSP at 245-2102. &nbsp;Wait until the server acknowledges processing your form before leaving this page. Thank you for your cooperation. </span>  </p>
                                                                                                                                                                                      <p align="center">
    <input type="submit" name="Submit" value="Submit Form" />
  </p>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
 
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
