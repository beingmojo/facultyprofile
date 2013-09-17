


<html>
<head>
<title>IRB Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}
?>


<?php
 $appNumber = $_GET['appNum'];
 
 $sql = sprintf("SELECT * FROM application WHERE App_Number = %s", $appNumber);
$app = mysql_query($sql, $con) or die(mysql_error());
$rs_app = mysql_fetch_assoc($app);
 
 
 
 
 
?>
<script language="JavaScript">



<script language="JavaScript">
<!--


function validate(form) {
var e = form.elements, m = '';
if(!e['four_Project_Type'].value) {m += '- Project Type is required.\n';}
if(!e['two_Signed_Hard_Copy_Required'].value) {m += '- Signed_Hard_Copy_Required field is required.\n';}

if(!e['Using_ChildrenUnderEighteen'].value) {m += '- Using Children Under Eighteen is required.\n';}
if(!e['two_Using_NursingHomePatients'].value) {m += '- Using_NursingHomePatients is required.\n';}
if(!e['two_Using_Prisoners'].value) {m += '- Using_Prisoners is required.\n';}

if(!e['two_Using_PregnantWomenOrFetuses'].value) {m += '- Using PregnantWomenOrFetuses is required.\n';}
if(!e['two_Using_PersonsWithIllnessInjoryOrDisability'].value) {m += '- Using Persons With Illness, Injory Or Disability is required.\n';}
if(!e['two_Using_MentallyOrPsychologicallyImpairedPersons'].value)  {
m += '- Using Mentally Or Psychologically Impaired Persons is required.\n';
}

if(!e['two_Using_Incentives_For_Participation'].value) {m += '- Use Incentives For_Participation is required.\n';}
if(!e['Risk_Rating'].value) {m += '- Risk_Rating is required.\n';}
if(!e['Benefit_Rating'].value) {m += '- Benefit_Rating is required.\n';}
if(!e['Risk_Asses_Method_Expl'].value) {m += '- Risk_Assessment Method Description is required.\n';}
if(!e['two_Using_Informed_Consent_Document'].value) {m += '- Using_Informed_Consent_Document is required.\n';}

if(e['two_Using_Informed_Consent_Document'].value=="no"){
if(!e['rText_noInformedConsentExplanation'].value) {m += '- No Informed Consent Explanation field is required.\n';}
}

else{
if(!e['two_Appropriate_Language'].value) {m += '- Appropriate Language for informed consent document field is required.\n';}
if(!e['two_Other_Languages'].value) {m += '- Language Other Than English field is required.\n';}
if(!e['two_Arrange_For_Translators'].value) {m += '- Arrange For Translators for informed consent document field is required.\n';}
if(!e['two_Translators_Understand_Meaning'].value) {m += '- Translators_Understand_Meaning of the informed consent document field is required.\n';}
if(!e['Obtaining_Subjects_Signature'].value) {m += '- Obtaining_Subjects_Signature field is required.\n';}
if(!e['two_Providing_Copy_of_Consent_Doc'].value) {m += '- Providing_Copy_of_Consent_Document field is required.\n';}
if(!e['two_Liability_Release'].value) {m += '- Liability_Release field is required.\n';}


if(!e['two_Research_Involvment_Statement'].value) {m += '- Research_Involvment_Statement field required.\n';}
if(!e['two_Explanation_of_Purpose'].value) {m += '- Explanation_of_Purpose field is required.\n';}
if(!e['two_Expected_Duration'].value) {m += '- Expected_Duration field is required.\n';}
if(!e['two_Identification_of_Experimental_Procedures'].value) {m += '- Identification_of_Experimental_Procedures field is required.\n';}

if(!e['two_Description_of_Risks'].value) {m += '- Description_of_Risks field is required.\n';}
if(!e['two_Expected_Benefit'].value) {m += '- Expected_Benefit field is required.\n';}
if(!e['two_Alternatives_Disclosure'].value) {m += '- Alternatives_Disclosure field is required.\n';}
if(!e['two_Explanation_of_Compensation'].value) {m += '- Explanation_of_Compensation field is required.\n';}
if(!e['two_Contact_Info'].value) {m += '- Contact_Info field is required.\n';}
if(!e['two_Voluntary_Participation_Statement'].value) {m += '- Voluntary_Participation_Statement field is required.\n';}

}//end if consnet document


if(m) {
alert('The following error(s) occurred:\n\n' + m);
return false;
}
return true;
}
</script>
<link href="../css/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-attachment: fixed;
	background-image:     url(../images/donotprint.gif);
	background-repeat: no-repeat;
	background-position: center 85%;
	background-color: #EEEEEE;
}
-->
</style>

</head>

<body text="#000000">
This is an ELECTRONIC submission form. Applications must be submitted electronically. Printed IRB applications will not be accepted. If you experience difficulty with the form, try quitting your browser application and starting over. Contact OSP at 245-2102 if you require assistance. </p>
<h2 align="center">&nbsp;</h2>
<h2 align="center">IRB Application Data Sheet</h2>
<hr>
<p><i>Please Note: Required Fields are marked with an asterisk</i><font color="#000000"><font size="+1"> 
  <font color="#FF0000">*</font></font></font><i>.</i> </p>

<p>Also note that the information you enter here will be used AS IS to print your hard copy IRB approval certificate.  If you do not use proper spelling and/or capitalization for your name, your faculty member’s name and the title of your project, it will show up that way on your approval certificate.
<br></p>
<form name="IRBForm" ENCTYPE="multipart/form-data" method="post" action = "irbapp_update.php"  onsubmit="return validate(this)">
 
  
  <h3>SECTION 1: </h3>
  <h5>This is your APPLICATION REFERENCE NUMBER: <font color = "red"><?php echo($appNumber) ?></font>  </h5>
  
    <input type="hidden" name="App_Number" value="<?php echo($appNumber) ?>" size="75">
</p>
  

  
  <h6>NOTE:&nbsp; If you have not taken a Human Subjects Protection Training, you must complete the CITI Course before your application can be processed.</h6>
    <p><font color="#FF0000">*</font> Title of project:
      <input type="text" name="ProjectTitle" value="<?php echo $rs_app['ProjectTitle']; ?>" size="75">
</p>
  <p><font color="#FF0000">*</font> Project type: </p>
  <blockquote> 
    <p> 
      <input  type="radio" name="four_Project_Type" value="Academic/Class" <?php if (strcmp($row_rsPI['ProjectType'],"Academic/Class")==0) {echo "checked";} ?>>
      Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Funded/Non-funded Research" <?php if (strcmp($row_rsPI['ProjectType'],"Funded/Non-funded Research")==0) {echo "checked";} ?>>
      Funded Research<br>
      <input type="radio" name="four_Project_Type" value="Institutional/Admin" <?php if (strcmp($row_rsPI['ProjectType'],"Institutional/Admin")==0) {echo "checked";} ?> >
      Non-Funded Research <br>
      <input type="radio" name="four_Project_Type" value="Continuation/Renewal" <?php if (strcmp($row_rsPI['ProjectType'],"Continuation/Renewal")==0) {echo "checked";} ?> >
      Institutional/Admin.</p>
  </blockquote>
  <p>&nbsp;</p>
  <p>If Academic/Class, Course #: 
    <input type="text" name="Course_Number" value="<?php echo $rs_app['CourseNumber']; ?>">
  </p>

  <p><font color="#FF0000">*</font> If funded research, complete name of funder: 
    <input type="text" name="Funder_Name_Other" value="<?php echo $rs_app['FunderName']; ?>">
  </p>

  
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font><strong>You will be informed of the IRB's decision 
    via email. Do you require a signed hard copy of the IRB's decision for your 
    records? 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="yes" <?php if (strcmp($row_rsPI['SignedHardCopy'],"yes")==0) {echo "checked";} ?>>
    Yes 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="no" <?php if (strcmp($row_rsPI['SignedHardCopy'],"no")==0) {echo "checked";} ?>>
    No</strong></p>
  <hr>
  <h3>SECTION 2:</h3>
 
  <p>This section requires brief answers on topics that 
    should be covered in more detail in your synopsis, consent forms, survey instruments, 
    and other required documents accompanying your application. <b>Please do not 
    assume that your answer below relieves you of the responsibility to cover 
    these issues in detail in your supporting documentation.</b></p>
  <p><font color="#FF0000">*</font> Does your project involve the use of the following 
    as research subjects:</p>
  <blockquote> 
    <p> Children under the age of 18 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="yes" <?php if (strcmp($row_rsPI['ChildrenUnder18'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="no" <?php if (strcmp($row_rsPI['ChildrenUnder18'],"no")==0) {echo "checked";} ?>>
      No<br>
      Nursing home patients 
      <input type="radio" name="two_Using_NursingHomePatients" value="yes" <?php if (strcmp($row_rsPI['NursingHomePatients'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_NursingHomePatients" value="no" <?php if (strcmp($row_rsPI['NursingHomePatients'],"no")==0) {echo "checked";} ?>>
      No<br>
      Prisoners 
      <input type="radio" name="two_Using_Prisoners" value="yes" <?php if (strcmp($row_rsPI['Prisoner'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_Prisoners" value="no" <?php if (strcmp($row_rsPI['Prisoner'],"no")==0) {echo "checked";} ?>>
      No<br>
      Pregnant women or fetuses 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="yes" <?php if (strcmp($row_rsPI['PregnantWomenOrFetuses'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="no" <?php if (strcmp($row_rsPI['PregnantWomenOrFetuses'],"no")==0) {echo "checked";} ?>>
      No<br>
      Persons with a physical illness, injury , or disability 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="yes" <?php if (strcmp($row_rsPI['IllnessInjoryOrDisability'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="no" <?php if (strcmp($row_rsPI['IllnessInjoryOrDisability'],"no")==0) {echo "checked";} ?>>
      No<br>
      Mentally or psychologically impaired persons 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="yes" <?php if (strcmp($row_rsPI['MentallyOrPsychologicallyImpaired'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="no" <?php if (strcmp($row_rsPI['MentallyOrPsychologicallyImpaired'],"no")==0) {echo "checked";} ?>>
      No<br>
    </p>
  </blockquote>
  <p> <font color="#FF0000">*</font> Are you offering any incentives to subjects 
    in return for participation? 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="yes" <?php if (strcmp($row_rsPI['IncentiveForParticipation'],"yes")==0) {echo "checked";} ?>>
    Yes 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="no" <?php if (strcmp($row_rsPI['IncentiveForParticipation'],"no")==0) {echo "checked";} ?>>
    No</p>
  <p><font color="#FF0000">*</font> Will you be asking subjects to provide:</p>
  <blockquote> 
    <p> 
      <input type="checkbox" name="requestingName" value="yes" <?php if (strcmp($row_rsPI['RequestName'],"yes")==0) {echo "checked";} ?>>
      Name<br>
      <input type="checkbox" name="requestingSSN" value="yes" <?php if (strcmp($row_rsPI['RequestSSN'],"yes")==0) {echo "checked";} ?>>
      Social Security #<br>
      <input type="checkbox" name="requestingPhoneNum" value="yes" <?php if (strcmp($row_rsPI['RequestPhoneNum'],"yes")==0) {echo "checked";} ?>>
      Phone #<br>
      <input type="checkbox" name="requestingAddress" value="yes" <?php if (strcmp($row_rsPI['RequestAddress'],"yes")==0) {echo "checked";} ?>>
      Address<br>
      <input type="checkbox" name="requestingMedicalInfo" value="yes" <?php if (strcmp($row_rsPI['RequestMedicalInfo'],"yes")==0) {echo "checked";} ?>>
      Medical/health info<br>
      <input type="checkbox" name="requestingNone" value="yes" <?php if (strcmp($row_rsPI['RequestNone'],"yes")==0) {echo "checked";} ?>>
      I will NOT be asking subjects to provide their Name, Social Security #, 
      Phone #, Address, or Medical/health info<br>
    </p>
  </blockquote>
  <p> <b>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study</b>.<br>
    <font color="#FF0000">*</font> On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, rate the overall risk to subjects in your project. 
    <input type="text" name="Risk_Rating" maxlength="2" size="2" value="<?php echo $rs_app['RiskRating']; ?>">
  </p>
  <p>&nbsp;</p>
  <p><b>Benefit: A valued or desired outcome; an advantage.<br>
    </b><font color="#FF0000">*</font> On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <input type="text" name="Benefit_Rating" size="2" maxlength="2" value="<?php echo $rs_app['BenefitRating']; ?>">
  </p>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font> In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.<br>
    <textarea name="Risk_Asses_Method_Expl" cols="75" rows="4"><?php echo $rs_app['RiskAssesMethod']; ?></textarea>
  </p>
  <hr>
  <h3>SECTION 3:</h3>
  <p><font color="#FF0000">*</font> Will you be using an informed consent document? 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="yes" <?php if (strcmp($row_rsPI['InformedConsentDoc'],"yes")==0) {echo "checked";} ?> >
    Yes 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="no" <?php if (strcmp($row_rsPI['InformedConsentDoc'],"no")==0) {echo "checked";} ?>>
    No </p>
  <blockquote> 
    <p>If &nbsp;you answered &#145;no&#148; above, please explain here:<br>
      <textarea name="rText_noInformedConsentExplanation" cols="70" rows="3"><?php echo $rs_app['NoInformedConsentExp']; ?></textarea>
    </p>
  </blockquote>
  <p>If you are using an informed consent document, answer the following questions 
    about your informed consent document(s): Note: if you answered &quot;No&quot; 
    above, then you may leave all of the below Yes / No questions blank.</p>
  <blockquote> 
    <p><font color="#FF0000">*</font> Is the language in the document appropriately 
      matched to the comprehension level of your intended subject pool? 
      <input type="radio" name="two_Appropriate_Language" value="yes" <?php if (strcmp($row_rsPI['AppropriateLanguage'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Appropriate_Language" value="no" <?php if (strcmp($row_rsPI['AppropriateLanguage'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> Will the document be provided in language(s) 
      other than English? 
      <input type="radio" name="two_Other_Languages" value="yes" <?php if (strcmp($row_rsPI['OtherLanguage'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Other_Languages" value="no" <?php if (strcmp($row_rsPI['OtherLanguage'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> Will you arrange in advance for translators 
      for non-English speakers? 
      <input type="radio" name="two_Arrange_For_Translators" value="yes" <?php if (strcmp($row_rsPI['ArrangeForTranslators'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Arrange_For_Translators" value="no" <?php if (strcmp($row_rsPI['ArrangeForTranslators'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> Are you 100% sure that these translators 
      fully understand the exact meaning of the consent document? 
      <input type="radio" name="two_Translators_Understand_Meaning" value="yes" <?php if (strcmp($row_rsPI['TranslatorUnderstand'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Translators_Understand_Meaning" value="no" <?php if (strcmp($row_rsPI['TranslatorUnderstand'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> Will you be obtaining the subject's signature? 
      <input type="radio" name="two_Obtaining_Subjects_Signature" value="yes" <?php if (strcmp($row_rsPI['ObtainSubjectsSignature'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Obtaining_Subjects_Signature" value="no" <?php if (strcmp($row_rsPI['ObtainSubjectsSignature'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> Will you be providing subjects a copy of 
      their consent document? 
      <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="yes" <?php if (strcmp($row_rsPI['ProvideCopyOfConsentDoc'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="no" <?php if (strcmp($row_rsPI['ProvideCopyOfConsentDoc'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> Does your document in any way ask or imply 
      that subjects are waiving any right or releasing you from any liability? 
      <input type="radio" name="two_Liability_Release" value="yes" <?php if (strcmp($row_rsPI['LiabilityRelease'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Liability_Release" value="no" <?php if (strcmp($row_rsPI['LiabilityRelease'],"no")==0) {echo "checked";} ?>>
      No</p>
  </blockquote>
  <p> If you are using an informed consent document, does your informed consent 
    document contain:</p>
  <blockquote> 
    <p><font color="#FF0000">*</font> A statement that the study involves research? 
      <input type="radio" name="two_Research_Involvment_Statement" value="yes" <?php if (strcmp($row_rsPI['ResearchInvolvementStatement'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Research_Involvment_Statement" value="no" <?php if (strcmp($row_rsPI['ResearchInvolvementStatement'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> An explanation of the purposes of the research? 
      <input type="radio" name="two_Explanation_of_Purpose" value="yes" <?php if (strcmp($row_rsPI['ExplanationOfPurpose'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Explanation_of_Purpose" value="no" <?php if (strcmp($row_rsPI['ExplanationOfPurpose'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> The expected duration of the subject's participation? 
      <input type="radio" name="two_Expected_Duration" value="yes" <?php if (strcmp($row_rsPI['ExpectDuration'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Expected_Duration" value="no" <?php if (strcmp($row_rsPI['ExpectDuration'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> Identification of any procedures which are 
      experimental? 
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="yes" <?php if (strcmp($row_rsPI['IdentificationOfExperimentalProc'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="no" <?php if (strcmp($row_rsPI['IdentificationOfExperimentalProc'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> A description of any reasonably foreseeable 
      risks or discomforts to the subject? 
      <input type="radio" name="two_Description_of_Risks" value="yes" <?php if (strcmp($row_rsPI['DescriptionOfRisk'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Description_of_Risks" value="no" <?php if (strcmp($row_rsPI['DescriptionOfRisk'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> A description of any benefits to the subject 
      or to others which may reasonably be expected from the research? 
      <input type="radio" name="two_Expected_Benefit" value="yes" <?php if (strcmp($row_rsPI['ExpectedBenefit'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Expected_Benefit" value="no" <?php if (strcmp($row_rsPI['ExpectedBenefit'],"no")==0) {echo "checked";} ?>>
      No<br>
      <font color="#FF0000">*</font> A disclosure of appropriate alternative procedures 
      or courses of treatment, if any, that might be advantageous to the subject? 
      <input type="radio" name="two_Alternatives_Disclosure" value="yes" <?php if (strcmp($row_rsPI['AlternativesOfDisclosure'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Alternatives_Disclosure" value="no" <?php if (strcmp($row_rsPI['AlternativesOfDisclosure'],"no")==0) {echo "checked";} ?>>
      No<br>
      <br>
      <font color="#FF0000">*</font> For research involving more than minimal 
      risk, an explanation as to whether any compensation, and an explanation 
      as to whether any medical treatments are available, if injury occurs and, 
      if so, what they consist of, or where further information may be obtained? 
      <input type="radio" name="two_Explanation_of_Compensation" value="yes" <?php if (strcmp($row_rsPI['ExplanationOfCompensation'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Explanation_of_Compensation" value="no" <?php if (strcmp($row_rsPI['ExplanationOfCompensation'],"no")==0) {echo "checked";} ?>>
      No<br>
      <br>
      <font color="#FF0000">*</font> An explanation of whom to contact for answers 
      to pertinent questions about the research and research subjects' rights, 
      and whom to contact in the event of a research-related injury to the subject? 
      <input type="radio" name="two_Contact_Info" value="yes" <?php if (strcmp($row_rsPI['ContactInfo'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Contact_Info" value="no" <?php if (strcmp($row_rsPI['ContactInfo'],"no")==0) {echo "checked";} ?>>
      No<br>
      <br>
      <font color="#FF0000">*</font> A statement that participation is voluntary, 
      refusal to participate will involve no penalty or loss of benefits to which 
      the subject is otherwise entitled, and the subject may discontinue participation 
      at any time without penalty or loss of benefits, to which the subject is 
      otherwise entitled? 
      <input type="radio" name="two_Voluntary_Participation_Statement" value="yes" <?php if (strcmp($row_rsPI['VoluntaryParticipationStatement'],"yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Voluntary_Participation_Statement" value="no" <?php if (strcmp($row_rsPI['VoluntaryParticipationStatement'],"no")==0) {echo "checked";} ?>>
      No</p>
  <hr>
<p>&nbsp;</P>
</blockquote>
  <table width="100%" border="0">
    <tr> 
      <td align="center"> 
        <input type="submit" name="SubmitForm" value="Submit">
      </td>
      <td align="left"> 
        <input type="reset" name="ResetForm" value="Clear Form" onClick="return confirm('Are you sure you want to clear the contents of this form and start over? (Click OK to clear form)')">
      </td>
    </tr>
  </table>
</form>
</body>
</html>
