
<?php require_once('Connections/dbc.php'); ?>

<?php
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


$username = $_SESSION['username'];
$appNumber=$_POST['App_Number'];
echo($_POST['App_Number']."<br>");
echo($_POST['ProjectTitle']);
 if (!get_magic_quotes_gpc()) {
$username = addslashes($username);
$_POST['ProjectTitle'] = addslashes($_POST['ProjectTitle']);
$_POST['Course_Number'] = addslashes($_POST['Course_Number']);
$_POST['Funder_Name_Other'] = addslashes($_POST['Funder_Name_Other']);
$_POST['four_Project_Type'] = addslashes($_POST['four_Project_Type']);
$_POST['Risk_Asses_Method_Expl'] = addslashes($_POST['Risk_Asses_Method_Expl']);
$_POST['rText_noInformedConsentExplanation'] = addslashes($_POST['rText_noInformedConsentExplanation']);
}
 
 
 
$sql="INSERT INTO application (
username, App_Number, ProjectTitle, ProjectType, CourseNumber, FunderName, SignedHardCopy, ";
$sql = $sql . "ChildrenUnder18, NursingHomePatients, Prisoner, PregnantWomenOrFetuses, ";
$sql = $sql . "IllnessInjoryOrDisability, MentallyOrPsychologicallyImpaired, IncentiveForParticipation, RequestName, RequestSSN, RequestPhoneNum, RequestAddress, RequestMedicalInfo, RequestNone, RiskRating, BenefitRating, RiskAssesMethod, InformedConsentDoc, NoInformedConsentExp, AppropriateLanguage, OtherLanguage, ArrangeForTranslators, TranslatorUnderstand, ObtainSubjectsSignature, ProvideCopyOfConsentDoc, LiabilityRelease, ResearchInvolvementStatement, ExplanationOfPurpose, ExpectDuration, IdentificationOfExperimentalProc, DescriptionOfRisk, ExpectedBenefit, AlternativesOfDisclosure, ExplanationOfCompensation, ContactInfo, VoluntaryParticipationStatement) VALUES ('".$username."', '".$_POST['App_Number']."', '".$_POST['ProjectTitle']."', '".$_POST['four_Project_Type']."', '".$_POST['Course_Number']."', '".$_POST['Funder_Name_Other']."', '".$_POST['two_Signed_Hard_Copy_Required']."', '".$_POST['two_Using_ChildrenUnderEighteen']."', '".$_POST['two_Using_NursingHomePatients']."', '".$_POST['two_Using_Prisoners']."', '".$_POST['two_Using_PregnantWomenOrFetuses']."', '".$_POST['two_Using_PersonsWithIllnessInjoryOrDisability']."', '".$_POST['two_Using_MentallyOrPsychologicallyImpairedPersons']."', '".$_POST['two_Using_Incentives_For_Participation']."', '".$_POST['requestingName']."', '".$_POST['requestingSSN']."', '".$_POST['requestingPhoneNum']."', '".$_POST['requestingAddress']."', '".$_POST['requestingMedicalInfo']."', '".$_POST['requestingNone']."', '".$_POST['Risk_Rating']."', '".$_POST['Benefit_Rating']."', '".$_POST['Risk_Asses_Method_Expl']."', '".$_POST['two_Using_Informed_Consent_Document']."', '".$_POST['rText_noInformedConsentExplanation']."', '".$_POST['two_Appropriate_Language']."', '".$_POST['two_Other_Languages']."', '".$_POST['two_Arrange_For_Translators']."', '".$_POST['two_Translators_Understand_Meaning']."', '".$_POST['two_Obtaining_Subjects_Signature']."', '".$_POST['two_Providing_Copy_of_Consent_Doc']."', '".$_POST['two_Liability_Release']."', '".$_POST['two_Research_Involvment_Statement']."', '".$_POST['two_Explanation_of_Purpose']."', '".$_POST['two_Expected_Duration']."', '".$_POST['two_Identification_of_Experimental_Procedures']."', '".$_POST['two_Description_of_Risks']."', '".$_POST['two_Expected_Benefit']."', '".$_POST['two_Alternatives_Disclosure']."', '".$_POST['two_Explanation_of_Compensation']."', '".$_POST['two_Contact_Info']."', '".$_POST['two_Voluntary_Participation_Statement']."')";

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


Use this form to upload supporting document(s)<p>
 <form action="uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input type="hidden" name="fileUp" value="yes" id="fileUp">
<input type="hidden" name="appNum" value="<?php echo $appNumber ?>" id="appNum">

  <label> Upload File: <br /> 
  <input type="file" name="file" /> 
  </label>
   <input type="submit" name="Submit" value="Submit" /></form>

<p><hr /><a href="applicant_home.php">Back to Application Home</a>
