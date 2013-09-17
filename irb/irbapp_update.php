
<?php require_once('Connections/dbc.php'); ?>

<?php

session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

///////////////////////////////////////////////////////////////////////
$username = $_SESSION['username'];
echo $_SESSION['username']."<br>";
echo $_POST['App_Number']."<br>";
echo $_POST['ProjectTitle']."<br>";
$appNumber =$_POST['App_Number'];

 
 if (!get_magic_quotes_gpc()) {
$username = addslashes($username);
$_POST['ProjectTitle'] = addslashes($_POST['ProjectTitle']);
$_POST['Course_Number'] = addslashes($_POST['Course_Number']);
$_POST['Funder_Name_Other'] = addslashes($_POST['Funder_Name_Other']);
$_POST['four_Project_Type'] = addslashes($_POST['four_Project_Type']);
$_POST['Risk_Asses_Method_Expl'] = addslashes($_POST['Risk_Asses_Method_Expl']);
$_POST['rText_noInformedConsentExplanation'] = addslashes($_POST['rText_noInformedConsentExplanation']);
}
 
 
 
$sql="UPDATE application SET ProjectTitle='".$_POST['ProjectTitle']."',
ProjectType='".$_POST['four_Project_Type']."', 
CourseNumber='".$_POST['Course_Number']."',
FunderName='".$_POST['Funder_Name_Other']."',
SignedHardCopy='".$_POST['two_Signed_Hard_Copy_Required']."',
ChildrenUnder18='".$_POST['two_Using_ChildrenUnderEighteen']."',
 NursingHomePatients='".$_POST['two_Using_NursingHomePatients']."',
 Prisoner='".$_POST['two_Using_Prisoners']."',
 PregnantWomenOrFetuses='".$_POST['two_Using_PregnantWomenOrFetuses']."',
 IllnessInjoryOrDisability='".$_POST['two_Using_PersonsWithIllnessInjoryOrDisability']."',
 MentallyOrPsychologicallyImpaired='".$_POST['two_Using_MentallyOrPsychologicallyImpairedPersons']."',
 IncentiveForParticipation='".$_POST['two_Using_Incentives_For_Participation']."',
 RequestName='".$_POST['requestingName']."',
 RequestSSN='".$_POST['requestingSSN']."',
 RequestPhoneNum='".$_POST['requestingPhoneNum']."',
 RequestAddress='".$_POST['requestingAddress']."',
 RequestMedicalInfo='".$_POST['requestingMedicalInfo']."',
 RequestNone='".$_POST['requestingNone']."',
 RiskRating='".$_POST['Risk_Rating']."',
 BenefitRating='".$_POST['Benefit_Rating']."',
 RiskAssesMethod='".$_POST['Risk_Asses_Method_Expl']."',
 InformedConsentDoc='".$_POST['two_Using_Informed_Consent_Document']."',
 NoInformedConsentExp='".$_POST['rText_noInformedConsentExplanation']."',
 AppropriateLanguage='".$_POST['two_Appropriate_Language']."',
 OtherLanguage='".$_POST['two_Other_Languages']."',
 ArrangeForTranslators='".$_POST['two_Arrange_For_Translators']."',
 TranslatorUnderstand='".$_POST['two_Translators_Understand_Meaning']."',
 ObtainSubjectsSignature='".$_POST['two_Obtaining_Subjects_Signature']."',
 ProvideCopyOfConsentDoc='".$_POST['two_Providing_Copy_of_Consent_Doc']."',
 LiabilityRelease='".$_POST['two_Liability_Release']."',
 ResearchInvolvementStatement='".$_POST['two_Research_Involvment_Statement']."',
 ExplanationOfPurpose='".$_POST['two_Explanation_of_Purpose']."',
 ExpectDuration='".$_POST['two_Expected_Duration']."',
 IdentificationOfExperimentalProc='".$_POST['two_Identification_of_Experimental_Procedures']."',
 DescriptionOfRisk='".$_POST['two_Description_of_Risks']."', 
 ExpectedBenefit='".$_POST['two_Expected_Benefit']."',
 AlternativesOfDisclosure='".$_POST['two_Alternatives_Disclosure']."',
 ExplanationOfCompensation='".$_POST['two_Explanation_of_Compensation']."',
 ContactInfo='".$_POST['two_Contact_Info']."',
 VoluntaryParticipationStatement='".$_POST['two_Voluntary_Participation_Statement']."' where App_Number ='".$_POST['App_Number']."'";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
else
{
echo "1 record added";
mysql_close($con);
}


?> 


Use this form to upload supporting document(s), the document(s) you uploaded will not be overwritten.<p>
 <form action="uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input type="hidden" name="fileUp" value="yes" id="fileUp">

<input type="hidden" name="appNum" value="<?php echo $appNumber ?>" id="appNum">
  <label> Upload File: <br /> 
  <input type="file" name="file" /> 
  </label>
   <input type="submit" name="Submit" value="Submit" /></form>


