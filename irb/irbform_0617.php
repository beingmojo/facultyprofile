<?php require_once('Connections/con3.php');
session_start();
require_once('variables/variables.php');
$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


$editFormAction = $_SERVER['PHP_SELF'];
$appNumber = mt_rand(0000, 10000);
 
$appNumber = chr(rand(65,90)).$appNumber;
$appNumber= date("Y").$appNumber;
$_SESSION['appNum']=$appNumber;
//echo("random number is ".$appNumber);
?>

<?php
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "IRBForm")) {

$errmsg = "";
   
   if(trim($_POST['ProjectTitle']) =="" )
   {
      $errmsg = $errmsg.'Please enter Project Title <br>';
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
      $errmsg = $errmsg.'Please enter Project Title \n';
	     } 

      if(trim($_POST['two_Signed_Hard_Copy_Required']) =="" )
   {
      $errmsg = $errmsg.'Signed Hard Copy field field needs to be checked \n';
   } 
     if(trim($_POST['two_Using_ChildrenUnderEighteen']) =="" )
   {
      $errmsg = $errmsg.'Using Children Under Eighteen needs to be checked.\n';
   } 
 
     if(trim($_POST['two_Using_NursingHomePatients']) =="" )
   {
      $errmsg = $errmsg.'Using Nursing Home Patients field needs to be checked.\n';
   }
       if(trim($_POST['two_Using_Prisoners']) =="" )
   {
      $errmsg = $errmsg.'Using Prisoners field needs to be checked.\n';
   }

      if(trim($_POST['two_Using_PregnantWomenOrFetuses']) =="" )
   {
      $errmsg = $errmsg.'Using Pregnant Women Or Fetuses field needs to be checked.\n';
   }

      if(trim($_POST['two_Using_PersonsWithIllnessInjoryOrDisability']) =="" )
   {
      $errmsg = $errmsg.'Using Persons With Illness Injury Or Disability field needs to be checked.\n';
   }
      if(trim($_POST['two_Using_MentallyOrPsychologicallyImpairedPersons']) =="" )
   {
      $errmsg = $errmsg.'Using Mentally Or Psychologically Impaired Persons field needs to be checked.\n';
   }

     if(trim($_POST['two_Using_Incentives_For_Participation']) =="" )
   {
      $errmsg = $errmsg.'Using Incentives For Participation field needs to be checked.\n';
   }

if(trim($_POST['requestingNone']) =="Yes" )
{
    
if(trim($_POST['requestingName']) =="Yes" | trim($_POST['requestingSSN']) =="Yes" | trim($_POST['requestingPhoneNum']) =="Yes" | trim($_POST['requestingAddress']) =="Yes" | trim($_POST['requestingMedicalInfo']) =="Yes")
{
$errmsg = $errmsg.'You have checked that I will NOT be asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info.\n';
   }

}

if(trim($_POST['requestingName']) =="Yes" | trim($_POST['requestingSSN']) =="Yes" | trim($_POST['requestingPhoneNum']) =="Yes" | trim($_POST['requestingAddress']) =="Yes" | trim($_POST['requestingMedicalInfo']) =="Yes")

{
	if(trim($_POST['requestingNone']) =="Yes" ){

	$errmsg = $errmsg.'Error in whether you asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info\n';}
}

    if(trim($_POST['Risk_Rating']) =="" )
   {
      $errmsg = $errmsg.'Risk Rating field is required.\n';
   }
   if(trim($_POST['Benefit_Rating']) =="" )
   {
      $errmsg = $errmsg.'Benefit Rating is required.\n';
   }
  if(trim($_POST['Risk_Asses_Method_Expl']) =="" )
   {
      $errmsg = $errmsg.'Risk Assessment Method Description is required.\n';
   }


  if(trim($_POST['two_Using_Informed_Consent_Document']) =="" )
   {
      $errmsg = $errmsg.'Using Informed Consent Document needs to be checked.\n';
   }

if(trim($_POST['two_Using_Informed_Consent_Document']) =="No" ){
	if(trim($_POST['rText_noInformedConsentExplanation']) =="" )
		{$errmsg = $errmsg.'No Informed Consent Explanation field is required.\n';}

	}

else{

  if(trim($_POST['two_Appropriate_Language']) =="" )
   {
      $errmsg = $errmsg.'Using appropriate Language for informed consent document needs to be checked.\n';
   }

  if(trim($_POST['two_Other_Languages']) =="" )
   {
      $errmsg = $errmsg.'Using Language Other Than English for informed consent document field needs to be checked.\n';
   }
  if(trim($_POST['two_Arrange_For_Translators']) =="" )
   {
      $errmsg = $errmsg.'Using Arrange For Translators for informed consent document field needs to be checked.\n';
   }
  if(trim($_POST['two_Translators_Understand_Meaning']) =="" )
   {
      $errmsg = $errmsg.'Translators Understand Meaning of informed consent document field needs to be checked.\n';
   }
  if(trim($_POST['two_Obtaining_Subjects_Signature']) =="" )
   {
      $errmsg = $errmsg.'Obtaining Subjects Signature for informed consent document field needs to be checked.\n';
   }


  if(trim($_POST['two_Providing_Copy_of_Consent_Doc']) =="" )
   {
      $errmsg = $errmsg.'Providing Copy of Consent Document field needs to be checked.\n';
   }

  if(trim($_POST['two_Liability_Release']) =="" )
   {
      $errmsg = $errmsg.'Liability Release field needs to be checked.\n';
   }

  if(trim($_POST['two_Research_Involvment_Statement']) =="" )
   {
      $errmsg = $errmsg.'Research Involvment Statement field needs to be checked.\n';
   }
  if(trim($_POST['two_Explanation_of_Purpose']) =="" )
   {
      $errmsg = $errmsg.'Explanation of Purpose field needs to be checked.\n';
   }
  if(trim($_POST['two_Expected_Duration']) =="" )
   {
      $errmsg = $errmsg.'Expected Duration field needs to be checked.\n';
   }
  if(trim($_POST['two_Identification_of_Experimental_Procedures']) =="" )
   {
      $errmsg = $errmsg.'Identification of Experimental Procedures field needs to be checked.\n';
   }
 if(trim($_POST['two_Description_of_Risks']) =="" )
   {
      $errmsg = $errmsg.'two_Description_of_Risks field needs to be checked.\n';
   }
 if(trim($_POST['two_Expected_Benefit']) =="" )
   {
      $errmsg = $errmsg.'Expected Benefit field needs to be checked.\n';
   }
if(trim($_POST['two_Alternatives_Disclosure']) =="" )
   {
      $errmsg = $errmsg.'Alternatives Disclosure field needs to be checked.\n';
   }
if(trim($_POST['two_Explanation_of_Compensation']) =="" )
   {
      $errmsg = $errmsg.'Explanation of Compensation field needs to be checked.\n';
   }
if(trim($_POST['two_Contact_Info']) =="" )
   {
      $errmsg = $errmsg.'Contact Information field needs to be checked.\n';
   }
if(trim($_POST['two_Voluntary_Participation_Statement']) =="" )
   {
      $errmsg = $errmsg."Voluntary Participation Statement field needs to be checked.";
   }


	}//end if consent document
 
if (strlen($errmsg)>1) {

//echo "<font color='red'>Following errors occured:</font><br>".$errmsg;
?>

<?php
include "irbform_back.php";
?>
<script language="JavaScript">
alert("<?php echo $errmsg;?>");
</script>
<?php
}
else{
$status = "Application in Process";
$appNum= $_POST['App_Number'];
$insertSQL = sprintf("INSERT INTO application (App_Number, username, ProjectTitle, ProjectType, CourseNumber, FunderName, SignedHardCopy, ChildrenUnder18, NursingHomePatients, Prisoner, PregnantWomenOrFetuses, IllnessInjoryOrDisability, MentallyOrPsychologicallyImpaired, IncentiveForParticipation, RequestName, RequestSSN, RequestPhoneNum, RequestAddress, RequestMedicalInfo, RequestNone, RiskRating, BenefitRating, RiskAssesMethod, InformedConsentDoc, NoInformedConsentExp, AppropriateLanguage, OtherLanguage, ArrangeForTranslators, TranslatorUnderstand, ObtainSubjectsSignature, ProvideCopyOfConsentDoc, LiabilityRelease, ResearchInvolvementStatement, ExplanationOfPurpose, ExpectDuration, IdentificationOfExperimentalProc, DescriptionOfRisk, ExpectedBenefit, AlternativesOfDisclosure, ExplanationOfCompensation, ContactInfo, VoluntaryParticipationStatement, Status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['App_Number'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
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
                       GetSQLValueString($_POST['requestingAddress'],"text"),
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
					      GetSQLValueString($status, "text"));

  mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($insertSQL, $con3) or die(mysql_error());
   
	$to = $_SESSION['Email'];
//	$from = "From: ospinfo@txstate.edu";
	$body = "\r\rThis email message is generated by the IRB online application program. Do not reply.\r\rYou have started an IRB Application. Application number: ".$_POST['App_Number'];
    
	$subject = "RE: New IRB Application";
	mail($to,$subject,$body, $headers);
	
//	$goto="uploader.php";
 //header("Location: ". $goto);
 //exit;
  //echo "<br><a href='applicant_home.php'>Back to Application Home</a><br>";
  
  ?>
   
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>

<script language="JavaScript">

function confirmSubmit()
{
var agree=confirm("Are you sure you wish to continue?");
if (agree)
	return true ;
else
	return false ;
}

</script>

<LINK href="irbstyle.css" rel="stylesheet" type="text/css">


  <style type="text/css">
<!--
.style42 {color: #FFFFFF}
.style43 {font-size: large}
.style44 {color: #FF0000}
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
</tbody></table> 
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff" table>
  <tr>
    <td bgcolor="#000000"><div align="center">
      <p><span class="style33"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a>
      </strong></div></td>
  </tr><tr>
    <td>
      <p align="center"><strong><br>Your Username: </strong><strong><?php echo $_SESSION['username'];?></strong>
	  <p>IRB Application Number: <?php echo $appNum; ?>
  <hr>Use this form to upload supporting document(s) (<Strong>Maximum allowed file size: 2M</Strong>)<p>
 <form action="uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input type="hidden" name="fileUp" value="Yes" id="fileUp">
<input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">

  <label> Upload File: <br /> 
  <input type="file" name="file" /> 
  </label>
   <input type="submit" name="Submit" value="Upload File" />
   </form>
   <p>*You will have to browse and upload each document at a time.
        <p>If you believe that you have submitted the application form correctly and you have completed uploading all supporting documents, click Submit Application button below. Your application will now be forwarded for review.  
   <p>Please note: Should your application be deemed incompleted by the IRB, you will receive another email requesting additional information and/or documents.</p> 
	  <form name ="form2" id="form2" method="post" action="submissionFinished.php">
	  <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	    <input type="hidden" name="appsub" value="Application Submitted" id="appsub" >
	  <input type="submit" name="Submit2" value="Submit Application" onClick=" onClick="return confirmSubmit()"/>
   
   </form>
 
</tr></td></table>
<?php
	}//end else
}
else{
?>

  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>

<script language="JavaScript">

function confirmSubmit()
{
var agree=confirm("Are you sure you wish to continue?");
if (agree)
	return true ;
else
	return false ;
}

</script>

<LINK href="irbstyle.css" rel="stylesheet" type="text/css">


  <style type="text/css">
<!--
.style42 {color: #FFFFFF}
.style43 {font-size: large}
.style44 {color: #FF0000}
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
</tbody></table> 
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff" table>
  <tr>
    <td bgcolor="#000000"><div align="center">
      <p><span class="style33"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a>
      </strong></div></td>
  </tr><tr>
    <td>
      <p align="center"><strong><br>Your Username: </strong><strong><?php echo $_SESSION['username'];?></strong>
      <h4 align="center"><strong>  IRB APPLICATION FORM</strong></h4>
<p>This is an ELECTRONIC submission form. Applications must be submitted electronically. Printed IRB applications will not be accepted. If you experience difficulty with the form, try quitting your browser application and starting over. Contact IRB at 512 245-2102 if you require assistance. </p>

<p>Also note that the information you enter here will be used AS IS to generate your electronic IRB approval certificate online. If you do not use proper spelling and/or capitalization for your name and the title of your project, it will show up that way on your approval certificate. <br>
</p>
<form name="IRBForm" method="POST" action = "<?php echo $_SERVER['PHP_SELF']; ?>"  >
 
  
  <h5>SECTION 1: </h5>
  <p>This is your APPLICATION NUMBER:<span class="style44"> <font color="red">
    <?php echo $appNumber; ?></font> </span></p>
  <p>This Application Number will be used to identify your application. You will receive an email notification of this number once you submit this application form.&nbsp;  </p>
  <p align="center" class="randomnumbers" >
  
     <input name="App_Number" type="hidden" value = "<?php echo $appNumber; ?>" >
	  <input name="username" type="hidden" value = "<?php echo $_SESSION['username']; ?>" >
</p>
  
  <h5>Title of project:
      <input type="text" name="ProjectTitle" value="<?php echo $_POST['ProjectTitle']; ?>" size="75">
</h5>
  <p>Project type: </p>
  <blockquote> 
    <p> 
      <input type="radio" name="four_Project_Type" value="Academic/Class" <?php if($_POST['four_Project_Type']=="Academic/Class") echo "checked";?>>
      Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Funded Research" <?php if($_POST['four_Project_Type']=="Funded Research") echo "checked";?>>
      Funded Research<br>
      <input type="radio" name="four_Project_Type" value="Non-Funded Research" <?php if($_POST['four_Project_Type']=="Non-Funded Research") echo "checked";?>>
      Non-Funded Research and Non-Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Institutional/Admin" <?php if($_POST['four_Project_Type']=="Institutional/Admin") echo "checked";?>>
      Institutional/Admin.</p>
  </blockquote>
  <p>&nbsp;</p>
  <p>If Academic/Class, Course #: 
    <input type="text" name="Course_Number" value="<?php echo $_POST['Course_Number']; ?>">
  </p>

  <p> If funded research, complete name of funder: 
    <input type="text" name="Funder_Name_Other" value="<?php echo $_POST['Funder_Name_Other']; ?>">
  </p>

  
  <p>&nbsp;</p>
  <p>You will be informed of the IRB's decision 
    via email. Do you require a signed hard copy of the IRB's decision for your 
    records? 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="Yes" <?php if($_POST['two_Signed_Hard_Copy_Required']=="Yes") echo "checked";?>>
    Yes 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="No" <?php if($_POST['two_Signed_Hard_Copy_Required']=="No") echo "checked";?>>
    No</p>
  <hr>
  <h5>SECTION 2:</h5>
  <p>This section requires brief answers on topics that 
    should be covered in more detail in your synopsis, consent forms, survey instruments, 
    and other required documents accompanying your application. <em>Please do not 
    assume that your answer below relieves you of the responsibility to cover 
    these issues in detail in your supporting documentation.</em></p>
  <p>Does your project involve the use of the following 
    as research subjects:</p>
  <blockquote> 
    <p> Children under the age of 18 <br>
    <input type="radio" name="two_Using_ChildrenUnderEighteen" value="Yes" <?php if($_POST['two_Using_ChildrenUnderEighteen']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="No" <?php if($_POST['two_Using_ChildrenUnderEighteen']=="No") echo "checked";?>>
      No<br>
Nursing home patients <br>
<input type="radio" name="two_Using_NursingHomePatients" value="Yes" <?php if($_POST['two_Using_NursingHomePatients']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_NursingHomePatients" value="No" <?php if($_POST['two_Using_NursingHomePatients']=="No") echo "checked";?>>
      No<br>
Prisoners <br>
<input type="radio" name="two_Using_Prisoners" value="Yes" <?php if($_POST['two_Using_Prisoners']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_Prisoners" value="No" <?php if($_POST['two_Using_Prisoners']=="No") echo "checked";?>>
      No<br>
Pregnant women or fetuses <br>
  <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="Yes" <?php if($_POST['two_Using_PregnantWomenOrFetuses']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="No" <?php if($_POST['two_Using_PregnantWomenOrFetuses']=="No") echo "checked";?>>
      No<br>
Persons with a physical illness, injury , or disability <br>
<input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="Yes" <?php if($_POST['two_Using_PersonsWithIllnessInjoryOrDisability']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="No" <?php if($_POST['two_Using_PersonsWithIllnessInjoryOrDisability']=="No") echo "checked";?>>
      No<br>
Mentally or psychologically impaired persons <br>
<input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="Yes" <?php if($_POST['two_Using_MentallyOrPsychologicallyImpairedPersons']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="No" <?php if($_POST['two_Using_MentallyOrPsychologicallyImpairedPersons']=="No") echo "checked";?>>
      No<br>
    </p></blockquote>
  <p> Are you offering any incentives to subjects 
    in return for participation? <br>
    <input type="radio" name="two_Using_Incentives_For_Participation" value="Yes" <?php if($_POST['two_Using_Incentives_For_Participation']=="Yes") echo "checked";?>>
    Yes 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="No" <?php if($_POST['two_Using_Incentives_For_Participation']=="No") echo "checked";?>>
    No</p><p> Will you be asking subjects to provide:</p>
  <blockquote> 
    <p> 
      <input type="checkbox" name="requestingName" value="Yes" <?php if($_POST['requestingName']=="Yes") echo "checked";?>>
      Name<br>
      <input type="checkbox" name="requestingSSN" value="Yes" <?php if($_POST['requestingSSN']=="Yes") echo "checked";?>>
      Social Security #<br>
      <input type="checkbox" name="requestingPhoneNum" value="Yes" <?php if($_POST['requestingPhoneNum']=="Yes") echo "checked";?>>
      Phone #<br>
      <input type="checkbox" name="requestingAddress" value="Yes" <?php if($_POST['requestingAddress']=="Yes") echo "checked";?>>
      Address<br>
      <input type="checkbox" name="requestingMedicalInfo" value="Yes" <?php if($_POST['requestingMedicalInfo']=="Yes") echo "checked";?>>
      Medical/health info<br>
      <input type="checkbox" name="requestingNone" value="Yes" <?php if($_POST['requestingNone']=="Yes") echo "checked";?>>
      I will NOT be asking subjects to provide their Name, Social Security #, 
      Phone #, Address, or Medical/health info<br>
    </p>
  </blockquote>
  <p> <em>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study.</em><br>
    On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, rate the overall risk to subjects in your project. 
    <input type="text" name="Risk_Rating" maxlength="2" size="2" value="<?php echo $_POST['Risk_Rating'];?>">
  </p>
  <p><em>Benefit: A valued or desired outcome; an advantage.</em><b><br>
    </b>On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <input type="text" name="Benefit_Rating" size="2" maxlength="2" value="<?php echo $_POST['Benefit_Rating'];?>">
  </p>
  <p>In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.<br>
    <textarea name="Risk_Asses_Method_Expl" cols="75" rows="4"><?php echo $_POST['Risk_Asses_Method_Expl'];?></textarea>
  </p>
  <hr>
  <h5>SECTION 3:</h5>
  <p>Will you be using an informed consent document? <br>
  <input type="radio" name="two_Using_Informed_Consent_Document" value="Yes" <?php if($_POST['two_Using_Informed_Consent_Document']=="Yes") echo "checked";?> >
    Yes 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="No" <?php if($_POST['two_Using_Informed_Consent_Document']=="No") echo "checked";?>>
    No </p><blockquote> 
    <p>If &nbsp;you answered &#145;No&#148; above, please explain here:<br>
      <textarea name="rText_noInformedConsentExplanation" cols="70" rows="5"><?php echo $_POST['rText_noInformedConsentExplanation'];?></textarea>
    </p>
  </blockquote>
  <p>If you are using an informed consent document, answer the following questions 
    about your informed consent document(s): Note: if you answered &quot;No&quot; 
    above, then you may leave all of the below Yes / No questions blank.</p>
  <blockquote> 
    <p>Is the language in the document appropriately 
      matched to the comprehension level of your intended subject pool? <br>
      <input type="radio" name="two_Appropriate_Language" value="Yes" <?php if($_POST['two_Appropriate_Language']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Appropriate_Language" value="No" <?php if($_POST['two_Appropriate_Language']=="No") echo "checked";?>>
      No<br>
Will the document be provided in language(s) 
      other than English? <br>
      <input type="radio" name="two_Other_Languages" value="Yes" <?php if($_POST['two_Other_Languages']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Other_Languages" value="No" <?php if($_POST['two_Other_Languages']=="No") echo "checked";?>>
      No<br>
Will you arrange in advance for translators 
      for non-English speakers? <br>
      <input type="radio" name="two_Arrange_For_Translators" value="Yes" <?php if($_POST['two_Arrange_For_Translators']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Arrange_For_Translators" value="No" <?php if($_POST['two_Arrange_For_Translators']=="No") echo "checked";?>>
      No<br>
Are you 100% sure that these translators 
      fully understand the exact meaning of the consent document? <br>
      <input type="radio" name="two_Translators_Understand_Meaning" value="Yes" <?php if($_POST['two_Translators_Understand_Meaning']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Translators_Understand_Meaning" value="No" <?php if($_POST['two_Translators_Understand_Meaning']=="No") echo "checked";?>>
      No<br>
Will you be obtaining the subject's signature? <br>
<input type="radio" name="two_Obtaining_Subjects_Signature" value="Yes" <?php if($_POST['two_Obtaining_Subjects_Signature']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Obtaining_Subjects_Signature" value="No" <?php if($_POST['two_Obtaining_Subjects_Signature']=="No") echo "checked";?>>
      No<br>
      Will you be providing subjects a copy of 
      their consent document?<br> 
            <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="Yes" <?php if($_POST['two_Providing_Copy_of_Consent_Doc']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="No" <?php if($_POST['two_Providing_Copy_of_Consent_Doc']=="No") echo "checked";?>>
      No<br>
Does your document in any way ask or imply 
      that subjects are waiving any right or releasing you from any liability? <br>
      <input type="radio" name="two_Liability_Release" value="Yes" <?php if($_POST['two_Liability_Release']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Liability_Release" value="No" <?php if($_POST['two_Liability_Release']=="No") echo "checked";?>>
      No</p></blockquote>
  <p> If you are using an informed consent document, does your informed consent 
    document contain:</p>
  <blockquote> 
    <p> A statement that the study involves research? <br>
    <input type="radio" name="two_Research_Involvment_Statement" value="Yes" <?php if($_POST['two_Research_Involvment_Statement']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Research_Involvment_Statement" value="No" <?php if($_POST['two_Research_Involvment_Statement']=="No") echo "checked";?>>
      No<br>
An explanation of the purposes of the research? <br>
<input type="radio" name="two_Explanation_of_Purpose" value="Yes" <?php if($_POST['two_Explanation_of_Purpose']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Explanation_of_Purpose" value="No" <?php if($_POST['two_Explanation_of_Purpose']=="No") echo "checked";?>>
      No<br>
The expected duration of the subject's participation? <br>
<input type="radio" name="two_Expected_Duration" value="Yes" <?php if($_POST['two_Expected_Duration']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Expected_Duration" value="No" <?php if($_POST['two_Expected_Duration']=="No") echo "checked";?>>
      No<br>
Identification of any procedures which are 
      experimental? <br>
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="Yes" <?php if($_POST['two_Identification_of_Experimental_Procedures']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="No" <?php if($_POST['two_Identification_of_Experimental_Procedures']=="No") echo "checked";?>>
      No<br>
A description of any reasonably foreseeable 
      risks or discomforts to the subject? <br>
      <input type="radio" name="two_Description_of_Risks" value="Yes" <?php if($_POST['two_Description_of_Risks']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Description_of_Risks" value="No" <?php if($_POST['two_Description_of_Risks']=="No") echo "checked";?>>
      No<br>
A description of any benefits to the subject 
      or to others which may reasonably be expected from the research? <br>
      <input type="radio" name="two_Expected_Benefit" value="Yes" <?php if($_POST['two_Expected_Benefit']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Expected_Benefit" value="No" <?php if($_POST['two_Expected_Benefit']=="No") echo "checked";?>>
      No<br>
A disclosure of appropriate alternative procedures 
      or courses of treatment, if any, that might be advantageous to the subject? <br>
      <input type="radio" name="two_Alternatives_Disclosure" value="Yes" <?php if($_POST['two_Alternatives_Disclosure']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Alternatives_Disclosure" value="No" <?php if($_POST['two_Alternatives_Disclosure']=="No") echo "checked";?>>
      No<br>
      <br>
For research involving more than minimal 
      risk, an explanation as to whether any compensation, and an explanation 
      as to whether any medical treatments are available, if injury occurs and, 
      if so, what they consist of, or where further information may be obtained? <br>
      <input type="radio" name="two_Explanation_of_Compensation" value="Yes" <?php if($_POST['two_Explanation_of_Compensation']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Explanation_of_Compensation" value="No" <?php if($_POST['two_Explanation_of_Compensation']=="No") echo "checked";?>>
      No<br>
      <br>
An explanation of whom to contact for answers 
      to pertinent questions about the research and research subjects' rights, 
      and whom to contact in the event of a research-related injury to the subject? <br>
      <input type="radio" name="two_Contact_Info" value="Yes" <?php if($_POST['two_Contact_Info']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Contact_Info" value="No" <?php if($_POST['two_Contact_Info']=="No") echo "checked";?>>
      No<br>
      <br>
A statement that participation is voluntary, 
      refusal to participate will involve no penalty or loss of benefits to which 
      the subject is otherwise entitled, and the subject may discontinue participation 
      at any time without penalty or loss of benefits, to which the subject is 
      otherwise entitled? <br>
      <input type="radio" name="two_Voluntary_Participation_Statement" value="Yes" <?php if($_POST['two_Voluntary_Participation_Statement']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Voluntary_Participation_Statement" value="No" <?php if($_POST['two_Voluntary_Participation_Statement']=="No") echo "checked";?>>
      No</p><hr>
</blockquote>
  <table width="100%" border="0">
    <tr> 
      <td width="50%" align="center"><div align="right">
        <input name="SubmitForm" type="submit" value="Submit">
      </div></td>
      <td width="50%" align="left"> 
        <input type="reset" name="ResetForm" value="Clear Form" onClick="return confirm('Are you sure you want to clear the contents of this form and start over? (Click OK to clear form)')">      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="IRBForm">
</form>
<?php
}
?></tr></td></table>
</body>
</html>
