<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
//form validation
/*
$errmsg="";
   
   if(trim($_POST['ProjectTitle']) =="" )
   {
      $errmsg = 'Please enter Project Title <br>';
   } 
   if(trim($_POST['four_Project_Type']) =="" )
   {
      $errmsg = $errmsg. 'Project Type is required <br>';
   } 
      if(trim($_POST['ProjectTitle']) =="" )
   {
      $errmsg = $errmsg.'Please enter Project Title <br>';
   } 

      if(trim($_POST['two_Signed_Hard_Copy_Required']) =="" )
   {
      $errmsg = $errmsg.'Signed Hard Copy field field needs to be checked <br>';
   } 
     if(trim($_POST['Using_ChildrenUnderEighteen']) =="" )
   {
      $errmsg = $errmsg.'Using Children Under Eighteen needs to be checked.<br>';
   } 
     if(trim($_POST['two_Using_NursingHomePatients']) =="" )
   {
      $errmsg = $errmsg.'Using Nursing Home Patients field needs to be checked.<br>';
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

if(trim($_POST['two_Using_Informed_Consent_Document']) =="no" ){
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
  if(trim($_POST['Obtaining_Subjects_Signature']) =="" )
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
      $errmsg = $errmsg."Voluntary Participation Statement field needs to be checked.<br>";
   }


	}//end if consent document
 
if (strlen($errmsg)>1) {die($errmsg);}
*/
<?php
/*

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "IRBForm")) {
echo "submitted"; 
echo "<a href='applicant_home.php'>Back to Application Home</a>";

  
}
*/
?>


 $insertSQL = sprintf("INSERT INTO application (App_Number, username, ProjectTitle, ProjectType, CourseNumber, FunderName, SignedHardCopy, ChildrenUnder18, NursingHomePatients, Prisoner, PregnantWomenOrFetuses, IllnessInjoryOrDisability, MentallyOrPsychologicallyImpaired, IncentiveForParticipation, RequestName, RequestSSN, RequestPhoneNum, RequestAddress, RequestMedicalInfo, RequestNone, RiskRating, BenefitRating, RiskAssesMethod, InformedConsentDoc, NoInformedConsentExp, AppropriateLanguage, OtherLanguage, ArrangeForTranslators, TranslatorUnderstand, ObtainSubjectsSignature, ProvideCopyOfConsentDoc, LiabilityRelease, ResearchInvolvementStatement, ExplanationOfPurpose, ExpectDuration, IdentificationOfExperimentalProc, DescriptionOfRisk, ExpectedBenefit, AlternativesOfDisclosure, ExplanationOfCompensation, ContactInfo, VoluntaryParticipationStatement) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString(isset($_POST['requestingName']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['requestingSSN']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['requestingPhoneNum']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['requestingAddress']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['requestingMedicalInfo']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['requestingNone']) ? "true" : "", "defined","'Y'","'N'"),
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
                       GetSQLValueString($_POST['two_Voluntary_Participation_Statement'], "text"));

  mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($insertSQL, $con3) or die(mysql_error());
  ?>
   
  Use this form to upload supporting document(s)<p>
 <form action="uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input type="hidden" name="fileUp" value="yes" id="fileUp">
<input type="hidden" name="appNum" value="<?php echo $appNumber; ?>" id="appNum">

  <label> Upload File: <br /> 
  <input type="file" name="file" /> 
  </label>
   <input type="submit" name="Submit" value="Upload File" /></form>