<html>
<head>
<title>IRB Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
$appNumber = mt_rand(000000, 10000000);
 
$appNumber = chr(rand(65,90)).$appNumber;
//echo("random number is ".$appNumber);
?>
<script language="JavaScript">


<!--
function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') {
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (val<min || max<val) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } errors = errors + otherValidation();
    if ( errors != '' )  alert('The following required text field(s) were not filled out properly:\n'+errors+'\n\n**The above errors (indicated by a "-") must be corrected before this form can be submitted.\n');
  document.MM_returnValue = (errors == '');
}
//-->
</script>

<script language="JavaScript">
<!--
var hingeQuestion1 = 53


function otherValidation()
{
	var cForm = document.forms[0] 
	var rErrList = ''
	var tErrList = ''
	var sErrList = ''
	var cErrList = ''


//alert ( cForm.elements[hingeQuestion1].name )
	
	for (var i = 0; i < cForm.elements.length; i++)
	{
			
		//one out of a group of 2 radio buttons must be checked
		if ( cForm.elements[i].type == "radio" && cForm.elements[i].name.indexOf('two_') == 0 && (i < hingeQuestion1 || cForm.elements[hingeQuestion1].checked == true) ) 
		{
			if (cForm.elements[i].checked == false && cForm.elements[i+1].checked == false)
			{
				rErrList += " - The "+cForm.elements[i].name.substr(4)+" radio button must be checked Yes or No.\n"
			}
			i++ //skip next radio button since there are two per group
		}
		//one out of a group of 4 radio buttons must be checked:
		else if ( cForm.elements[i].type == "radio" && cForm.elements[i].name.indexOf('four_') == 0 )
		{
			if (cForm.elements[i].checked == false && cForm.elements[i+1].checked == false && cForm.elements[i+2].checked == false && cForm.elements[i+3].checked == false)
			{
				rErrList += " - The "+cForm.elements[i].name.substr(5)+" list must have a selection made from the 4 choices.\n"
			}
			i += 3 //skip next 2 radio buttons since there are three in this group
		}
		//a required drop down list does Not have a selection made from it at all:
		else if ( cForm.elements[i].type == "select-one" && cForm.elements[i].value == "None" && cForm.elements[i].name.indexOf('r') == 0)
			sErrList += '- The '+cForm.elements[i].name.substr(1)+' selection list must have a selection made from the drop down menu.\n';
		//a drop down list does Not have a selection made from it. 
		//this drop down list requires a selection because of the user's response of 'Yes' to the radio button question lying immediately before this question
		else if ( cForm.elements[i].type == "select-one" && cForm.elements[i].value == "None" && cForm.elements[i].name.indexOf('c') == 0 && cForm.elements[i-2].checked == true)
			cErrList += '- The '+cForm.elements[i].name.substr(1)+' selection list must have a selection made from the drop down menu since you answered Yes to the '+cForm.elements[i-2].name.substr(1)+' radio button.\n';
		//a text box is empty that needs to have text in it
		//this textarea requires text to be entered because of the user's response of 'No' to the radio button question lying immediately before this question
		else if ( cForm.elements[i].type == "textarea" && cForm.elements[i].value == "" && cForm.elements[i].name.indexOf("rText_") != -1 && cForm.elements[i-1].checked == true)
			tErrList += '- The '+cForm.elements[i].name.substr(6)+' text field must be filled in since you answered No to the '+cForm.elements[i-2].name.substr(1)+' radio button.\n';
	}
	
	if (rErrList != '')
		rErrList = '\nThe following required radio button(s) were not selected:\n' + rErrList
	if (tErrList != '')
		tErrList = '\nThe following required text field(s) were not completed:\n' + tErrList
	if (sErrList != '')
		sErrList = '\nThe following required drop down selection list(s) were not selected:\n' + sErrList
	if (cErrList != '')
		cErrList = '\nThe following drop down selection list(s) need to be filled in based upon a previous selection:\n' + cErrList
	
	return (rErrList + tErrList + sErrList + cErrList)
	//webmaster: copy and paste the following line into the 2nd and last lines of the MM_validateForm() function generated by dreamweaver:
	//  } errors = errors + otherValidation;
	//    if ( errors != '' )  alert('The following required text field(s) were Not filled out properly:\n'+errors+'\n\n**The above errors (indicated by a "-") must be corrected before this form can be submitted.\n');
}
//-->
</script>
<link href="../css/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-attachment: fixed;
	background-image:     url(../images/donotprint.gif);
	background-repeat: No-repeat;
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

<p>Also note that the information you enter here will be used AS IS to print your hard copy IRB approval certificate. �If you do not use proper spelling and/or capitalization for your name, your faculty member�s name and the title of your project, it will show up that way on your approval certificate.
<br></p>
<form name="IRBForm" ENCTYPE="multipart/form-data" method="post" action = "irbformUpload.php" >
 
  
  <h3>SECTION 1: </h3>
  <h5>This is your APPLICATION REFERENCE NUMBER: <font color = "red"><?php echo($appNumber) ?></font>  </h5>
  
  <h5>This Application Reference Number will be used to identify your application. Write this number down for future reference.   &nbsp;</h5>
  
  
  <p align="center" class="randomnumbers" >
  
     <input name="App_Number" type="hidden" value = "<?php echo($appNumber);?>" >
</p>
  
  <h6>NOTE:&nbsp; If you have not taken a Human Subjects Protection Training, you must complete the CITI Course before your application can be processed.</h6>
    <p><font color="#FF0000">*</font> Title of project: 
    <input type="text" name="ProjectTitle" value="" size="75">
  </p>
  <p><font color="#FF0000">*</font> Project type: </p>
  <blockquote> 
    <p> 
      <input type="radio" name="four_Project_Type" value="Academic/Class">
      Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Funded Research">
      Funded Research<br>
      <input type="radio" name="four_Project_Type" value="Non-Funded Research">
      Non-Funded Research <br>
      <input type="radio" name="four_Project_Type" value="Continuation/Renewal">
      Institutional/Admin.</p>
  </blockquote>
  <p>&nbsp;</p>
  <p>If Academic/Class, Course #: 
    <input type="text" name="Course_Number">
  </p>

  <p><font color="#FF0000">*</font> If funded research, complete name of funder: 
    <input type="text" name="Funder_Name_Other">
  </p>

  
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font><strong>You will be informed of the IRB's decision 
    via email. Do you require a signed hard copy of the IRB's decision for your 
    records? 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="Yes">
    Yes 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="No">
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
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="Yes">
      Yes 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="No">
      No<br>
      Nursing home patients 
      <input type="radio" name="two_Using_NursingHomePatients" value="Yes">
      Yes 
      <input type="radio" name="two_Using_NursingHomePatients" value="No">
      No<br>
      Prisoners 
      <input type="radio" name="two_Using_Prisoners" value="Yes">
      Yes 
      <input type="radio" name="two_Using_Prisoners" value="No">
      No<br>
      Pregnant women or fetuses 
      <input type="radio" name="two_Using_PregnantWomenorFetuses" value="Yes">
      Yes 
      <input type="radio" name="two_Using_PregnantWomenorFetuses" value="No">
      No<br>
      Persons with a physical illness, injury , or disability 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="Yes">
      Yes 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="No">
      No<br>
      Mentally or psychologically impaired persons 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="Yes">
      Yes 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="No">
      No<br>
    </p>
  </blockquote>
  <p> <font color="#FF0000">*</font> Are you offering any incentives to subjects 
    in return for participation? 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="Yes">
    Yes 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="No">
    No</p>
  <p><font color="#FF0000">*</font> Will you be asking subjects to provide:</p>
  <blockquote> 
    <p> 
      <input type="checkbox" name="requestingName" value="Yes">
      Name<br>
      <input type="checkbox" name="requestingSSN" value="Yes">
      Social Security #<br>
      <input type="checkbox" name="requestingPhoneNum" value="Yes">
      Phone #<br>
      <input type="checkbox" name="requestingAddress" value="Yes">
      Address<br>
      <input type="checkbox" name="requestingMedicalInfo" value="Yes">
      Medical/health info<br>
      <input type="checkbox" name="requestingNone" value="Yes">
      I will not be asking subjects to provide their Name, Social Security #, 
      Phone #, Address, or Medical/health info<br>
    </p>
  </blockquote>
  <p> <b>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study</b>.<br>
    <font color="#FF0000">*</font> On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, rate the overall risk to subjects in your project. 
    <input type="text" name="Risk_Rating" maxlength="2" size="2">
  </p>
  <p>&nbsp;</p>
  <p><b>Benefit: A valued or desired outcome; an advantage.<br>
    </b><font color="#FF0000">*</font> On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <input type="text" name="Benefit_Rating" size="2" maxlength="2">
  </p>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font> In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.<br>
    <textarea name="Risk_Asses_Method_Expl" cols="75" rows="4"></textarea>
  </p>
  <hr>
  <h3>SECTION 3:</h3>
  <p><font color="#FF0000">*</font> Will you be using an informed consent document? 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="Yes" >
    Yes 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="No">
    No </p>
  <blockquote> 
    <p>If &nbsp;you answered &#145;No&#148; above, please explain here:<br>
      <textarea name="rText_noInformedConsentExplanation" cols="70" rows="3"></textarea>
    </p>
  </blockquote>
  <p>If you are using an informed consent document, answer the following questions 
    about your informed consent document(s): Note: if you answered &quot;No&quot; 
    above, then you may leave all of the below Yes / No questions blank.</p>
  <blockquote> 
    <p><font color="#FF0000">*</font> Is the language in the document appropriately 
      matched to the comprehension level of your intended subject pool? 
      <input type="radio" name="two_Appropriate_Language" value="Yes">
      Yes 
      <input type="radio" name="two_Appropriate_Language" value="No">
      No<br>
      <font color="#FF0000">*</font> Will the document be provided in language(s) 
      other than English? 
      <input type="radio" name="two_Other_Languages" value="Yes">
      Yes 
      <input type="radio" name="two_Other_Languages" value="No">
      No<br>
      <font color="#FF0000">*</font> Will you arrange in advance for translators 
      for non-English speakers? 
      <input type="radio" name="two_Arrange_For_Translators" value="Yes">
      Yes 
      <input type="radio" name="two_Arrange_For_Translators" value="No">
      No<br>
      <font color="#FF0000">*</font> Are you 100% sure that these translators 
      fully understand the exact meaning of the consent document? 
      <input type="radio" name="two_Translators_Understand_Meaning" value="Yes">
      Yes 
      <input type="radio" name="two_Translators_Understand_Meaning" value="No">
      No<br>
      <font color="#FF0000">*</font> Will you be obtaining the subject's signature? 
      <input type="radio" name="two_Obtaining_Subjects_Signature" value="Yes">
      Yes 
      <input type="radio" name="two_Obtaining_Subjects_Signature" value="No">
      No<br>
      <font color="#FF0000">*</font> Will you be providing subjects a copy of 
      their consent document? 
      <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="Yes">
      Yes 
      <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="No">
      No<br>
      <font color="#FF0000">*</font> Does your document in any way ask or imply 
      that subjects are waiving any right or releasing you from any liability? 
      <input type="radio" name="two_Liability_Release" value="Yes">
      Yes 
      <input type="radio" name="two_Liability_Release" value="No">
      No</p>
  </blockquote>
  <p> If you are using an informed consent document, does your informed consent 
    document contain:</p>
  <blockquote> 
    <p><font color="#FF0000">*</font> A statement that the study involves research? 
      <input type="radio" name="two_Research_Involvment_Statement" value="Yes">
      Yes 
      <input type="radio" name="two_Research_Involvment_Statement" value="No">
      No<br>
      <font color="#FF0000">*</font> An explanation of the purposes of the research? 
      <input type="radio" name="two_Explanation_of_Purpose" value="Yes">
      Yes 
      <input type="radio" name="two_Explanation_of_Purpose" value="No">
      No<br>
      <font color="#FF0000">*</font> The expected duration of the subject's participation? 
      <input type="radio" name="two_Expected_Duration" value="Yes">
      Yes 
      <input type="radio" name="two_Expected_Duration" value="No">
      No<br>
      <font color="#FF0000">*</font> Identification of any procedures which are 
      experimental? 
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="Yes">
      Yes 
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="No">
      No<br>
      <font color="#FF0000">*</font> A description of any reasonably foreseeable 
      risks or discomforts to the subject? 
      <input type="radio" name="two_Description_of_Risks" value="Yes">
      Yes 
      <input type="radio" name="two_Description_of_Risks" value="No">
      No<br>
      <font color="#FF0000">*</font> A description of any benefits to the subject 
      or to others which may reasonably be expected from the research? 
      <input type="radio" name="two_Expected_Benefit" value="Yes">
      Yes 
      <input type="radio" name="two_Expected_Benefit" value="No">
      No<br>
      <font color="#FF0000">*</font> A disclosure of appropriate alternative procedures 
      or courses of treatment, if any, that might be advantageous to the subject? 
      <input type="radio" name="two_Alternatives_Disclosure" value="Yes">
      Yes 
      <input type="radio" name="two_Alternatives_Disclosure" value="No">
      No<br>
      <br>
      <font color="#FF0000">*</font> For research involving more than minimal 
      risk, an explanation as to whether any compensation, and an explanation 
      as to whether any medical treatments are available, if injury occurs and, 
      if so, what they consist of, or where further information may be obtained? 
      <input type="radio" name="two_Explanation_of_Compensation" value="Yes">
      Yes 
      <input type="radio" name="two_Explanation_of_Compensation" value="No">
      No<br>
      <br>
      <font color="#FF0000">*</font> An explanation of whom to contact for answers 
      to pertinent questions about the research and research subjects' rights, 
      and whom to contact in the event of a research-related injury to the subject? 
      <input type="radio" name="two_Contact_Info" value="Yes">
      Yes 
      <input type="radio" name="two_Contact_Info" value="No">
      No<br>
      <br>
      <font color="#FF0000">*</font> A statement that participation is voluntary, 
      refusal to participate will involve no penalty or loss of benefits to which 
      the subject is otherwise entitled, and the subject may discontinue participation 
      at any time without penalty or loss of benefits, to which the subject is 
      otherwise entitled? 
      <input type="radio" name="two_Voluntary_Participation_Statement" value="Yes">
      Yes 
      <input type="radio" name="two_Voluntary_Participation_Statement" value="No">
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