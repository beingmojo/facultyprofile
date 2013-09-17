<?php require_once('Connections/con3.php'); 
session_start();?>
<style type="text/css">
<!--
.style47 {color: #FFFFFF}
.style48 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
</head>
<?php




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

 $appNum = $_GET['appNum'];
 ?>
<html>
<head>
<title>IRB Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript">





</script>


<link href="../css/forms.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.style6 {
	font-family: Arial, Helvetica, sans-serif;
	color: #333399;
	font-weight: bold;
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
font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;

}
a.irb:visited {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;
}
-->
  </style>
  <style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style21 {
	color: #000066;
	font-size: 16px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style44 {color: #000099; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;}
-->
  </style>
</head>

   
<body text="#000000">
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" ><tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
 <tbody>
    <tr>
      <td height="150" valign="top" width="800">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tbody>
          <tr>
            <td valign="top" bgcolor="#330000"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a><br>  </td>
            <td bgcolor="#330000">
              <div class="style5" align="right"><span class="style7"><a href="LogOut.php"><span class="style37 style47">Log
Out</span></a></span><font color="#336699"><br>
</font></div></td>
            </tr>
          
          
          <tr>
            <td colspan="2" height="21" valign="top">
            <div align="center">
              <p class="style6">&nbsp;</p>
              <p><span class="style17"><a class="irb" href="index.php"
><span class="style21">Institutional Review Board</span><span class="style17"></a></p>
              <p class="style6">Online Application</p>
            </div>            </td>
          </tr>
          <tr>
            <td colspan="2" height="19" valign="top">&nbsp;</td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
</tbody></table>
<table width="800" height="300" border="0" align="center" bgcolor="#eeeeee">
  <tr><td> <div align="center"> <span class="style44"><a class="style44" href="irbform.php" title="IRB Application"><hr>Start a new IRB Application </a>| <a href="appUpdate_applicant.php?appNum=<?php echo $appNum?>"><span class="style44">Edit Application & Upload Supporting Document(s)</span></a><span class="style44"> | <a href="appSummary_applicant.php?appNum=<?php echo $appNum?>">Review Application</a> | <a href="applicant_home.php">Applicant Home</a></span></span> </div>
      <hr></td></tr>

	 <?php

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "IRBForm")) {

//form validation
$appNum = $_POST["appNum"];
$errmsg="";
   
   if(trim($_POST['ProjectTitle']) =="" )
   {
      $errmsg = 'Please enter Project Title <br>';
   } 
   if(trim($_POST['four_Project_Type']) =="" )
   {
      $errmsg = $errmsg. 'Project Type is required <br>';
   } 
   
   if(trim($_POST['four_Project_Type']) =="Academic/Class" ){
      if(trim($_POST['Course_Number']) =="" )
   {
      $errmsg = $errmsg.'Please enter course number <br>';
	     } 
	}
   
     if(trim($_POST['four_Project_Type']) !="Academic/Class" ){
      if(trim($_POST['Course_Number']) !="" )
   {
      $errmsg = $errmsg.'Course number cannot be entered<br>';
	     } 
	}
   
     if(trim($_POST['four_Project_Type']) =="Funded Research" ){
      if(trim($_POST['Funder_Name_Other']) =="" )
   {
      $errmsg = $errmsg.'Please enter the name of the funder <br>';
	     } 
	}
   
   	    if(trim($_POST['four_Project_Type']) !="Funded Research" ){
      if(trim($_POST['Funder_Name_Other']) !="" )
   {
      $errmsg = $errmsg.'The name of the funder is not required <br>';
	     } 
	}
	
	
   
      if(trim($_POST['ProjectTitle']) =="" )
   {
      $errmsg = $errmsg.'Please enter Project Title <br>';
   } 

      if(trim($_POST['two_Signed_Hard_Copy_Required']) =="" )
   {
      $errmsg = $errmsg.'Signed Hard Copy field field needs to be checked <br>';
   } 
     if(trim($_POST['two_Using_ChildrenUnderEighteen']) =="" )
   {
      $errmsg = $errmsg.'Using Children Under Eighteen needs to be checked.<br>';
   } 
  
     if(trim($_POST['two_Using_NursingHomePatients']) =="" )
   {
      $errmsg = $errmsg.'Using Nursing Home Patients field needs to be checked.<br>';
   }
       if(trim($_POST['two_Using_Prisoners']) =="" )
   {
      $errmsg = $errmsg.'Using Prisoners field needs to be checked.<br>';
   }

      if(trim($_POST['two_Using_PregnantWomenOrFetuses']) =="" )
   {
      $errmsg = $errmsg.'Using Pregnant Women Or Fetuses field needs to be checked.<br>';
   }

      if(trim($_POST['two_Using_PersonsWithIllnessInjoryOrDisability']) =="" )
   {
      $errmsg = $errmsg.'Using Persons With Illness Injury Or Disability field needs to be checked.<br>';
   }
      if(trim($_POST['two_Using_MentallyOrPsychologicallyImpairedPersons']) =="" )
   {
      $errmsg = $errmsg.'Using Mentally Or Psychologically Impaired Persons field needs to be checked.<br>';
   }

     if(trim($_POST['two_Using_Incentives_For_Participation']) =="" )
   {
      $errmsg = $errmsg.'Using Incentives For Participation field needs to be checked.<br>';
   }


if(trim($_POST['requestingNone']) =="Yes" )
{
    
if(trim($_POST['requestingName']) =="Yes" | trim($_POST['requestingSSN']) =="Yes" | trim($_POST['requestingPhoneNum']) =="Yes" | trim($_POST['requestingAddress']) =="Yes" | trim($_POST['requestingMedicalInfo']) =="Yes")
{
$errmsg = $errmsg.'You have checked that I will NOT be asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info.<br>';
   }

}

if(trim($_POST['requestingName']) =="Yes" | trim($_POST['requestingSSN']) =="Yes" | trim($_POST['requestingPhoneNum']) =="Yes" | trim($_POST['requestingAddress']) =="Yes" | trim($_POST['requestingMedicalInfo']) =="Yes")

{
	if(trim($_POST['requestingNone']) =="Yes" ){

	$errmsg = $errmsg.'Error in whether you asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info<br>';}
}

    if(trim($_POST['Risk_Rating']) =="" )
   {
      $errmsg = $errmsg.'Risk Rating field is required.<br>';
   }
   if(trim($_POST['Benefit_Rating']) =="" )
   {
      $errmsg = $errmsg.'Benefit Rating is required.<br>';
   }
  if(trim($_POST['Risk_Asses_Method_Expl']) =="" )
   {
      $errmsg = $errmsg.'Risk_Assessment Method Description is required.<br>';
   }

  if(trim($_POST['two_Using_Informed_Consent_Document']) =="" )
   {
      $errmsg = $errmsg.'Using Informed Consent Document needs to be checked.<br>';
   }

if(trim($_POST['two_Using_Informed_Consent_Document']) =="No" ){
	if(trim($_POST['rText_noInformedConsentExplanation']) =="" )
		{$errmsg = $errmsg.'No Informed Consent Explanation field is required.<br>';}

	}

else{

  if(trim($_POST['two_Appropriate_Language']) =="" )
   {
      $errmsg = $errmsg.'Using appropriate Language for informed consent document needs to be checked.<br>';
   }

  if(trim($_POST['two_Other_Languages']) =="" )
   {
      $errmsg = $errmsg.'Using Language Other Than English for informed consent document field needs to be checked.<br>';
   }
  if(trim($_POST['two_Arrange_For_Translators']) =="" )
   {
      $errmsg = $errmsg.'Using Arrange For Translators for informed consent document field needs to be checked.<br>';
   }
  if(trim($_POST['two_Translators_Understand_Meaning']) =="" )
   {
      $errmsg = $errmsg.'Translators Understand Meaning of informed consent document field needs to be checked.<br>';
   }
  if(trim($_POST['two_Obtaining_Subjects_Signature']) =="" )
   {
      $errmsg = $errmsg.'Obtaining Subjects Signature for informed consent document field needs to be checked.<br>';
   }

  if(trim($_POST['two_Providing_Copy_of_Consent_Doc']) =="" )
   {
      $errmsg = $errmsg.'Providing Copy of Consent Document field needs to be checked.<br>';
   }

  if(trim($_POST['two_Liability_Release']) =="" )
   {
      $errmsg = $errmsg.'Liability Release field needs to be checked.<br>';
   }

  if(trim($_POST['two_Research_Involvment_Statement']) =="" )
   {
      $errmsg = $errmsg.'Research Involvment Statement field needs to be checked.<br>';
   }
  if(trim($_POST['two_Explanation_of_Purpose']) =="" )
   {
      $errmsg = $errmsg.'Explanation of Purpose field needs to be checked.<br>';
   }
  if(trim($_POST['two_Expected_Duration']) =="" )
   {
      $errmsg = $errmsg.'Expected Duration field needs to be checked.<br>';
   }
  if(trim($_POST['two_Identification_of_Experimental_Procedures']) =="" )
   {
      $errmsg = $errmsg.'Identification of Experimental Procedures field needs to be checked.<br>';
   }
 if(trim($_POST['two_Description_of_Risks']) =="" )
   {
      $errmsg = $errmsg.'two_Description_of_Risks field needs to be checked.<br>';
   }
 if(trim($_POST['two_Expected_Benefit']) =="" )
   {
      $errmsg = $errmsg.'Expected Benefit field needs to be checked.<br>';
   }
if(trim($_POST['two_Alternatives_Disclosure']) =="" )
   {
      $errmsg = $errmsg.'Alternatives Disclosure field needs to be checked.<br>';
   }
if(trim($_POST['two_Explanation_of_Compensation']) =="" )
   {
      $errmsg = $errmsg.'Explanation of Compensation field needs to be checked.<br>';
   }
if(trim($_POST['two_Contact_Info']) =="" )
   {
      $errmsg = $errmsg.'Contact Information field needs to be checked.<br>';
   }
if(trim($_POST['two_Voluntary_Participation_Statement']) =="" )
   {
      $errmsg = $errmsg.'Voluntary Participation Statement field needs to be checked.<br>';
   }


	}//end if consent document

if (strlen($errmsg)>1) {die($errmsg);}


  $updateSQL = sprintf("UPDATE application SET ProjectTitle=%s, ProjectType=%s, CourseNumber=%s, FunderName=%s, SignedHardCopy=%s, ChildrenUnder18=%s, NursingHomePatients=%s, Prisoner=%s, PregnantWomenOrFetuses=%s, IllnessInjoryOrDisability=%s, MentallyOrPsychologicallyImpaired=%s, IncentiveForParticipation=%s, RequestName=%s, RequestSSN=%s, RequestPhoneNum=%s, RequestAddress=%s, RequestMedicalInfo=%s, RequestNone=%s, RiskRating=%s, BenefitRating=%s, RiskAssesMethod=%s, InformedConsentDoc=%s, NoInformedConsentExp=%s, AppropriateLanguage=%s, OtherLanguage=%s, ArrangeForTranslators=%s, TranslatorUnderstand=%s, ObtainSubjectsSignature=%s, ProvideCopyOfConsentDoc=%s, LiabilityRelease=%s, ResearchInvolvementStatement=%s, ExplanationOfPurpose=%s, ExpectDuration=%s, IdentificationOfExperimentalProc=%s, DescriptionOfRisk=%s, ExpectedBenefit=%s, AlternativesOfDisclosure=%s, ExplanationOfCompensation=%s, ContactInfo=%s, VoluntaryParticipationStatement=%s WHERE App_Number=%s",
                       GetSQLValueString($_POST['ProjectTitle'], "text"),
                       GetSQLValueString($_POST['four_Project_Type'], "text"),
                       GetSQLValueString($_POST['Course_Number'], "text"),
                       GetSQLValueString($_POST['Funder_Name_Other'], "text"),
                       GetSQLValueString($_POST['two_Signed_Hard_Copy_Required'], "text"),
                       GetSQLValueString($_POST['two_Using_ChildrenUnderEighteen'], "text"),
                       GetSQLValueString($_POST['two_Using_NursingHomePatients'], "text"),
                       GetSQLValueString($_POST['two_Using_Prisoners'], "text"),
                       GetSQLValueString($_POST['two_Using_PregnantWomenOrFetuses'], "text"),
                       GetSQLValueString($_POST['two_Using_PersonsWithIllnessInjoryOrDisability'], "text"),
                       GetSQLValueString($_POST['two_Using_MentallyOrPsychologicallyImpairedPersons'], "text"),
             GetSQLValueString($_POST['two_Using_Incentives_For_Participation'], "text"),
           GetSQLValueString($_POST['requestingName'], "text"),
          GetSQLValueString($_POST['requestingSSN'], "text"),
         GetSQLValueString($_POST['requestingPhoneNum'], "text"),
         GetSQLValueString($_POST['requestingAddress'], "text"),
      GetSQLValueString($_POST['requestingMedicalInfo'], "text"),
             GetSQLValueString($_POST['requestingNone'], "text"),
                       GetSQLValueString($_POST['Risk_Rating'], "text"),
                       GetSQLValueString($_POST['Benefit_Rating'], "text"),
                       GetSQLValueString($_POST['Risk_Asses_Method_Expl'], "text"),
                       GetSQLValueString($_POST['two_Using_Informed_Consent_Document'], "text"),
                       GetSQLValueString($_POST['rText_noInformedConsentExplanation'], "text"),
                       GetSQLValueString($_POST['two_Appropriate_Language'], "text"),
                       GetSQLValueString($_POST['two_Other_Languages'], "text"),
                       GetSQLValueString($_POST['two_Arrange_For_Translators'], "text"),
                       GetSQLValueString($_POST['two_Translators_Understand_Meaning'], "text"),
                       GetSQLValueString($_POST['two_Obtaining_Subjects_Signature'], "text"),
                       GetSQLValueString($_POST['two_Providing_Copy_of_Consent_Doc'], "text"),
                       GetSQLValueString($_POST['two_Liability_Release'], "text"),
                       GetSQLValueString($_POST['two_Research_Involvment_Statement'], "text"),
                       GetSQLValueString($_POST['two_Explanation_of_Purpose'], "text"),
                       GetSQLValueString($_POST['two_Expected_Duration'], "text"),
                       GetSQLValueString($_POST['two_Identification_of_Experimental_Procedures'], "text"),
                       GetSQLValueString($_POST['two_Description_of_Risks'], "text"),
                       GetSQLValueString($_POST['two_Expected_Benefit'], "text"),
                       GetSQLValueString($_POST['two_Alternatives_Disclosure'], "text"),
                       GetSQLValueString($_POST['two_Explanation_of_Compensation'], "text"),
                       GetSQLValueString($_POST['two_Contact_Info'], "text"),
                       GetSQLValueString($_POST['two_Voluntary_Participation_Statement'], "text"),
                       GetSQLValueString($_POST['appNum'], "text"));

  mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($updateSQL, $con3) or die(mysql_error());
 //  header("Location: ". "applicant_home.php"); 
//exit;
 //echo "Application updated.";
 }
?>
 

<?php

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

 mysql_select_db($database_con3, $con3);
 $sql = sprintf("SELECT * FROM application WHERE App_Number = '%s'", $appNum);
$app = mysql_query($sql, $con3) or die(mysql_error());
$rs_app = mysql_fetch_assoc($app);
 if ($rs_app['Status']==NULL || $rs_app['Status'] == "Application in Process" ||$rs_app['Status'] == "Request Revision")
 {
?>

    <tr> 
      <td align="center"> <?php
	  if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "IRBForm")){
	  echo "<font color='red'>Application Updated<p></font>";?>
Use this form to upload supporting document(s)<p>
 <form action="uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input type="hidden" name="fileUp" value="Yes" id="fileUp">
<input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">

  <label> Upload File: <br /> 
  <input type="file" name="file" /> 
  </label>
   <input type="submit" name="Submit" value="Upload File" /><p>*You will have to browse and upload each document at a time.
      <br>Click "Application Submission Finished" button if you have finished your IRB application submission. Once this button is clicked, you will not be able to make changes on your application form data. However, you can upload supporting documents for your application. IRB office will not process your application until you have indicated that you have finished your application submission by clicking this button.<br> 
	  <form name ="form2" id="form2" method="post" action="submissionFinished.php">
	  <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	    <input type="hidden" name="appsub" value="Application Submitted" id="appsub">
	  <input type="submit" name="Submit2" value="Submit Application" onClick="alert ('Are you sure you have completed uploading all supporting documents and would like to submit your application for review by IRB?')" />
   
   </form><hr>
   <?php
   }
   ?>
</p>

<?php if ($rs_app['Status']==NULL || $rs_app['Status'] == "Application in Process") {?>
<tr><td>
    <p><p>Once you have completed uploading all supporting documents, click Submit Application button below. Your application will now be forwarded for review. You will receive an email from IRB varifying that your application has been received. 
   <p>Please note: Should your application be deemed incompleted by the IRB, you will receive another email requesting additional information and/or documents.</p> 
     <label><form method="post" action="submissionFinished.php" name="form3" id="form3">
	 <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	  <input type="hidden" name="appsub" value="Application Submitted" id="appsub">
     <input type="submit" name="Submit2" value="Submit Application" onClick="alert ('Are you sure you have completed uploading all supporting documents and would like to submit your application for review by IRB?')"></form>
     </label></p>
This is an ELECTRONIC submission form. Applications must be submitted electronically. Printed IRB applications will not be accepted. If you experience difficulty with the form, try quitting your browser application and starting over. Contact OSP at 245-2102 if you require assistance. </p>
<h2 align="center">&nbsp;</h2>
<h2 align="center">IRB Application Data Sheet</h2>
<hr>
<p>Also note that the information you enter here will be used AS IS to print your hard copy IRB approval certificate.  If you do not use proper spelling and/or capitalization for your name, your faculty member’s name and the title of your project, it will show up that way on your approval certificate. <br>
</p>

<form name="IRBForm" ENCTYPE="multipart/form-data" method="POST" action = "<?php echo $editFormAction; ?>" >
  <div align="center"><strong><?php echo $_SESSION['username']; ?>  </strong></div>
  <h3>SECTION 1: </h3>
  <h5>This is your APPLICATION REFERENCE NUMBER: <font color = "red"><?php echo $appNum; ?></font>  </h5>
  
    <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" size="75">
</p>
  

  
  <h6>NOTE:&nbsp; If you have not taken a Human Subjects Protection Training, you must complete the CITI Course before your application can be processed.</h6>
    <p>Title of project:
      <input type="text" name="ProjectTitle" value="<?php echo $rs_app['ProjectTitle']; ?>" size="75">
</p>
  <p> Project type: </p>
  <blockquote> 
    <p> 
      <input  type="radio" name="four_Project_Type" value="Academic/Class" <?php if (strcmp($rs_app['ProjectType'],"Academic/Class")==0) {echo "checked";} ?>>
      Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Funded Research" <?php if (strcmp($rs_app['ProjectType'],"Funded Research")==0) {echo "checked";} ?>>
      Funded Research<br>
      <input type="radio" name="four_Project_Type" value="Non-Funded Research" <?php if (strcmp($rs_app['ProjectType'],"Non-Funded Research")==0) {echo "checked";} ?> >
      Non-Funded Research <br>
      <input type="radio" name="four_Project_Type" value="Institutional/Admin" <?php if (strcmp($$rs_app['ProjectType'],"Institutional/Admin")==0) {echo "checked";} ?> >
      Institutional/Admin.</p>
  </blockquote>
  <p>&nbsp;</p>
  <p>If Academic/Class, Course #: 
    <input type="text" name="Course_Number" value="<?php echo $rs_app['CourseNumber']; ?>" >
  </p>

  <p>If funded research, complete name of funder: 
    <input type="text" name="Funder_Name_Other" value="<?php echo $rs_app['FunderName']; ?>">
  </p>

  
  <p>&nbsp;</p>
  <p><strong>You will be informed of the IRB's decision 
    via email. Do you require a signed hard copy of the IRB's decision for your 
    records? 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="Yes" <?php if (strcmp($rs_app['SignedHardCopy'],"Yes")==0) {echo "checked";} ?>>
    Yes 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="No" <?php if (strcmp($rs_app['SignedHardCopy'],"No")==0) {echo "checked";} ?>>
  No</strong></p>
  <hr>
  <h3>SECTION 2:</h3>
 
  <p>This section requires brief answers on topics that 
    should be covered in more detail in your synopsis, consent forms, survey instruments, 
    and other required documents accompanying your application. <b>Please do not 
    assume that your answer below relieves you of the responsibility to cover 
    these issues in detail in your supporting documentation.</b></p>
  <p>Does your project involve the use of the following 
    as research subjects:</p>
  <blockquote> 
    <p> Children under the age of 18 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="Yes" <?php if (strcmp($rs_app['ChildrenUnder18'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="No" <?php if (strcmp($rs_app['ChildrenUnder18'],"No")==0) {echo "checked";} ?>>
      No<br>
      Nursing home patients 
      <input type="radio" name="two_Using_NursingHomePatients" value="Yes" <?php if (strcmp($rs_app['NursingHomePatients'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_NursingHomePatients" value="No" <?php if (strcmp($rs_app['NursingHomePatients'],"No")==0) {echo "checked";} ?>>
      No<br>
      Prisoners 
      <input type="radio" name="two_Using_Prisoners" value="Yes" <?php if (strcmp($rs_app['Prisoner'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_Prisoners" value="No" <?php if (strcmp($rs_app['Prisoner'],"No")==0) {echo "checked";} ?>>
      No<br>
      Pregnant women or fetuses 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="Yes" <?php if (strcmp($rs_app['PregnantWomenOrFetuses'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="No" <?php if (strcmp($rs_app['PregnantWomenOrFetuses'],"No")==0) {echo "checked";} ?>>
      No<br>
      Persons with a physical illness, injury , or disability 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="Yes" <?php if (strcmp($rs_app['IllnessInjoryOrDisability'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="No" <?php if (strcmp($rs_app['IllnessInjoryOrDisability'],"No")==0) {echo "checked";} ?>>
      No<br>
      Mentally or psychologically impaired persons 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="Yes" <?php if (strcmp($rs_app['MentallyOrPsychologicallyImpaired'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="No" <?php if (strcmp($rs_app['MentallyOrPsychologicallyImpaired'],"No")==0) {echo "checked";} ?>>
      No<br>
    </p>
  </blockquote>
  <p>Are you offering any incentives to subjects 
    in return for participation? 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="Yes" <?php if (strcmp($rs_app['IncentiveForParticipation'],"Yes")==0) {echo "checked";} ?>>
    Yes 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="No" <?php if (strcmp($rs_app['IncentiveForParticipation'],"No")==0) {echo "checked";} ?>>
  No</p>
  <p>Will you be asking subjects to provide:</p>
  <blockquote> 
    <p> 
      <input type="checkbox" name="requestingName" value="Yes" <?php if (strcmp($rs_app['RequestName'],"Yes")==0) {echo "checked";} ?>>
      Name<br>
      <input type="checkbox" name="requestingSSN" value="Yes" <?php if (strcmp($rs_app['RequestSSN'],"Yes")==0) {echo "checked";} ?>>
      Social Security #<br>
      <input type="checkbox" name="requestingPhoneNum" value="Yes" <?php if (strcmp($rs_app['RequestPhoneNum'],"Yes")==0) {echo "checked";} ?>>
      Phone #<br>
      <input type="checkbox" name="requestingAddress" value="Yes" <?php if (strcmp($rs_app['RequestAddress'],"Yes")==0) {echo "checked";} ?>>
      Address<br>
      <input type="checkbox" name="requestingMedicalInfo" value="Yes" <?php if (strcmp($rs_app['RequestMedicalInfo'],"Yes")==0) {echo "checked";} ?>>
      Medical/health info<br>
      <input type="checkbox" name="requestingNone" value="Yes" <?php if (strcmp($rs_app['RequestNone'],"Yes")==0) {echo "checked";} ?>>
      I will NOT be asking subjects to provide their Name, Social Security #, 
      Phone #, Address, or Medical/health info<br>
    </p>
  </blockquote>
  <p> <b>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study</b>.<br>
    On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, rate the overall risk to subjects in your project. 
    <input type="text" name="Risk_Rating" maxlength="2" size="2" value="<?php echo $rs_app['RiskRating']; ?>">
  </p>
  <p>&nbsp;</p>
  <p><b>Benefit: A valued or desired outcome; an advantage.<br>
    </b>On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <input type="text" name="Benefit_Rating" size="2" maxlength="2" value="<?php echo $rs_app['BenefitRating']; ?>">
  </p>
  <p>&nbsp;</p>
  <p>In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.<br>
    <textarea name="Risk_Asses_Method_Expl" cols="70" rows="4"><?php echo $rs_app['RiskAssesMethod']; ?></textarea>
  </p>
  <hr>
  <h3>SECTION 3:</h3>
  <p>Will you be using an informed consent document? 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="Yes" <?php if (strcmp($rs_app['InformedConsentDoc'],"Yes")==0) {echo "checked";} ?> >
    Yes 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="No" <?php if (strcmp($rs_app['InformedConsentDoc'],"No")==0) {echo "checked";} ?>>
  No </p>
  <blockquote> 
    <p>If &nbsp;you answered &#145;No&#148; above, please explain here:<br>
      <textarea name="rText_noInformedConsentExplanation" cols="70" rows="3"><?php echo $rs_app['NoInformedConsentExp']; ?></textarea>
    </p>
  </blockquote>
  <p>If you are using an informed consent document, answer the following questions 
    about your informed consent document(s): Note: if you answered &quot;No&quot; 
    above, then you may leave all of the below Yes / No questions blank.</p>
  <blockquote> 
    <p>Is the language in the document appropriately 
      matched to the comprehension level of your intended subject pool? 
      <input type="radio" name="two_Appropriate_Language" value="Yes" <?php if (strcmp($rs_app['AppropriateLanguage'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Appropriate_Language" value="No" <?php if (strcmp($rs_app['AppropriateLanguage'],"No")==0) {echo "checked";} ?>>
      No<br>
      Will the document be provided in language(s) 
      other than English? 
      <input type="radio" name="two_Other_Languages" value="Yes" <?php if (strcmp($rs_app['OtherLanguage'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Other_Languages" value="No" <?php if (strcmp($rs_app['OtherLanguage'],"No")==0) {echo "checked";} ?>>
      No<br>
      Will you arrange in advance for translators 
      for non-English speakers? 
      <input type="radio" name="two_Arrange_For_Translators" value="Yes" <?php if (strcmp($rs_app['ArrangeForTranslators'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Arrange_For_Translators" value="No" <?php if (strcmp($rs_app['ArrangeForTranslators'],"No")==0) {echo "checked";} ?>>
      No<br>
      Are you 100% sure that these translators 
      fully understand the exact meaning of the consent document? 
      <input type="radio" name="two_Translators_Understand_Meaning" value="Yes" <?php if (strcmp($rs_app['TranslatorUnderstand'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Translators_Understand_Meaning" value="No" <?php if (strcmp($rs_app['TranslatorUnderstand'],"No")==0) {echo "checked";} ?>>
      No<br> 
      Will you be obtaining the subject's signature? 
      <input type="radio" name="two_Obtaining_Subjects_Signature" value="Yes" <?php if (strcmp($rs_app['ObtainSubjectsSignature'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Obtaining_Subjects_Signature" value="No" <?php if (strcmp($rs_app['ObtainSubjectsSignature'],"No")==0) {echo "checked";} ?>>
      No<br>
      Will you be providing subjects a copy of 
      their consent document? 
      <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="Yes" <?php if (strcmp($rs_app['ProvideCopyOfConsentDoc'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="No" <?php if (strcmp($rs_app['ProvideCopyOfConsentDoc'],"No")==0) {echo "checked";} ?>>
      No<br>
      Does your document in any way ask or imply 
      that subjects are waiving any right or releasing you from any liability? 
      <input type="radio" name="two_Liability_Release" value="Yes" <?php if (strcmp($rs_app['LiabilityRelease'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Liability_Release" value="No" <?php if (strcmp($rs_app['LiabilityRelease'],"No")==0) {echo "checked";} ?>>
    No</p>
  </blockquote>
  <p> If you are using an informed consent document, does your informed consent 
    document contain:</p>
  <blockquote> 
    <p> A statement that the study involves research? 
      <input type="radio" name="two_Research_Involvment_Statement" value="Yes" <?php if (strcmp($rs_app['ResearchInvolvementStatement'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Research_Involvment_Statement" value="No" <?php if (strcmp($rs_app['ResearchInvolvementStatement'],"No")==0) {echo "checked";} ?>>
      No<br>
      An explanation of the purposes of the research? 
      <input type="radio" name="two_Explanation_of_Purpose" value="Yes" <?php if (strcmp($rs_app['ExplanationOfPurpose'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Explanation_of_Purpose" value="No" <?php if (strcmp($rs_app['ExplanationOfPurpose'],"No")==0) {echo "checked";} ?>>
      No<br>
      The expected duration of the subject's participation? 
      <input type="radio" name="two_Expected_Duration" value="Yes" <?php if (strcmp($rs_app['ExpectDuration'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Expected_Duration" value="No" <?php if (strcmp($rs_app['ExpectDuration'],"No")==0) {echo "checked";} ?>>
      No<br> 
      Identification of any procedures which are 
      experimental? 
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="Yes" <?php if (strcmp($rs_app['IdentificationOfExperimentalProc'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="No" <?php if (strcmp($rs_app['IdentificationOfExperimentalProc'],"No")==0) {echo "checked";} ?>>
      No<br> 
      A description of any reasonably foreseeable 
      risks or discomforts to the subject? 
      <input type="radio" name="two_Description_of_Risks" value="Yes" <?php if (strcmp($rs_app['DescriptionOfRisk'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Description_of_Risks" value="No" <?php if (strcmp($rs_app['DescriptionOfRisk'],"No")==0) {echo "checked";} ?>>
      No<br>
      A description of any benefits to the subject 
      or to others which may reasonably be expected from the research? 
      <input type="radio" name="two_Expected_Benefit" value="Yes" <?php if (strcmp($rs_app['ExpectedBenefit'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Expected_Benefit" value="No" <?php if (strcmp($rs_app['ExpectedBenefit'],"No")==0) {echo "checked";} ?>>
      No<br> 
      A disclosure of appropriate alternative procedures 
      or courses of treatment, if any, that might be advantageous to the subject? 
      <input type="radio" name="two_Alternatives_Disclosure" value="Yes" <?php if (strcmp($rs_app['AlternativesOfDisclosure'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Alternatives_Disclosure" value="No" <?php if (strcmp($rs_app['AlternativesOfDisclosure'],"No")==0) {echo "checked";} ?>>
      No<br>
      <br>
      For research involving more than minimal 
      risk, an explanation as to whether any compensation, and an explanation 
      as to whether any medical treatments are available, if injury occurs and, 
      if so, what they consist of, or where further information may be obtained? 
      <input type="radio" name="two_Explanation_of_Compensation" value="Yes" <?php if (strcmp($rs_app['ExplanationOfCompensation'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Explanation_of_Compensation" value="No" <?php if (strcmp($rs_app['ExplanationOfCompensation'],"No")==0) {echo "checked";} ?>>
      No<br>
      <br>
      An explanation of whom to contact for answers 
      to pertinent questions about the research and research subjects' rights, 
      and whom to contact in the event of a research-related injury to the subject? 
      <input type="radio" name="two_Contact_Info" value="Yes" <?php if (strcmp($rs_app['ContactInfo'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Contact_Info" value="No" <?php if (strcmp($rs_app['ContactInfo'],"No")==0) {echo "checked";} ?>>
      No<br>
      <br> 
      A statement that participation is voluntary, 
      refusal to participate will involve no penalty or loss of benefits to which 
      the subject is otherwise entitled, and the subject may discontinue participation 
      at any time without penalty or loss of benefits, to which the subject is 
      otherwise entitled? 
      <input type="radio" name="two_Voluntary_Participation_Statement" value="Yes" <?php if (strcmp($rs_app['VoluntaryParticipationStatement'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Voluntary_Participation_Statement" value="No" <?php if (strcmp($rs_app['VoluntaryParticipationStatement'],"No")==0) {echo "checked";} ?>>
    No</p>
  <hr>
<p>&nbsp;</P>
</blockquote></td></tr><tr><td>
  <table width="100%" border="0">
    <tr> 
      <td align="center"> 
        <input type="submit" name="SubmitForm" value="Update Application Form">
    
      
        <input type="reset" name="ResetForm" value="Clear Form" >
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="IRBForm">
</form><hr></td></tr><tr><td>
  <div align="center" class="style48">
  <?php
  
  }
  
  else
  {
  
  ?>
  <tr><td>
  Use this form to upload supporting document(s)<p>
 <form action="uploadRevision_applicant.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input type="hidden" name="fileUp" value="Yes" id="fileUp">
<input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">

  <label> Upload File: <input type="file" name="file" /> 
  </label><br>
   <input type="submit" name="Submit" value="Upload File" /></form><hr>
   <?php
   }

  
  echo "View/Download Project Documents<hr>";
     

	

$path = "appdoc/".$appNum;
$dh = @ opendir($path);
$i=1;
while (($file = @ readdir($dh)) !== false) {
    if($file != "." && $file != "..") {
        echo "$i. <a href='$path/$file'>$file</a><br />";
        $i++;
    }
}
@ closedir($dh);
echo "<hr>";
}
else
die("You cannot update your application at this moment.");
?>
  <?php
//mysql_free_result($Recordset1);


//
mysql_free_result($app);
?>
  </div>
