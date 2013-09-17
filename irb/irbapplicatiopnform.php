<html>
<head>
<title>IRB Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
<!-- Begin
function getRandomNum(lbound, ubound) {
return (Math.floor(Math.random() * (ubound - lbound)) + lbound);
}
//   End -->

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
				rErrList += " - The "+cForm.elements[i].name.substr(4)+" radio button must be checked YES or NO.\n"
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
		//a required drop down list does not have a selection made from it at all:
		else if ( cForm.elements[i].type == "select-one" && cForm.elements[i].value == "none" && cForm.elements[i].name.indexOf('r') == 0)
			sErrList += '- The '+cForm.elements[i].name.substr(1)+' selection list must have a selection made from the drop down menu.\n';
		//a drop down list does not have a selection made from it. 
		//this drop down list requires a selection because of the user's response of 'yes' to the radio button question lying immediately before this question
		else if ( cForm.elements[i].type == "select-one" && cForm.elements[i].value == "none" && cForm.elements[i].name.indexOf('c') == 0 && cForm.elements[i-2].checked == true)
			cErrList += '- The '+cForm.elements[i].name.substr(1)+' selection list must have a selection made from the drop down menu since you answered YES to the '+cForm.elements[i-2].name.substr(1)+' radio button.\n';
		//a text box is empty that needs to have text in it
		//this textarea requires text to be entered because of the user's response of 'no' to the radio button question lying immediately before this question
		else if ( cForm.elements[i].type == "textarea" && cForm.elements[i].value == "" && cForm.elements[i].name.indexOf("rText_") != -1 && cForm.elements[i-1].checked == true)
			tErrList += '- The '+cForm.elements[i].name.substr(6)+' text field must be filled in since you answered NO to the '+cForm.elements[i-2].name.substr(1)+' radio button.\n';
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
	//    if ( errors != '' )  alert('The following required text field(s) were not filled out properly:\n'+errors+'\n\n**The above errors (indicated by a "-") must be corrected before this form can be submitted.\n');
}
//-->
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
<h6>This is an ELECTRONIC submission form. Applications must be submitted electronically.</h6>
<h6>&nbsp;</h6>
<h6>Printed IRB applications will not be accepted.</h6>
<p>&nbsp;</p>
<p> If you experience difficulty 
  with the form, try quitting your browser application and starting over. Contact 
  OSP at 245-2102 if you require assistance. </p>
<h2 align="center">&nbsp;</h2>
<h2 align="center">IRB Application Data Sheet</h2>
<hr>
<p><i>Please Note: Required Fields are marked with an asterisk</i><font color="#000000"><font size="+1"> 
  <font color="#FF0000">*</font></font></font><i>.</i> </p>
<p>&nbsp;</p>
<p>Also note that the information you enter here will be used AS IS to print your hard copy IRB approval certificate. �If you do not use proper spelling and/or capitalization for your name, your faculty member�s name and the title of your project, it will show up that way on your approval certificate.
<br></p>
<form name="IRBForm" method="post" action="http://apps.its.txstate.edu/formemailer.pl" onSubmit="MM_validateForm('App_Number','','R','Title_of_Project','','R','Faculty_First_Name','','R','Faculty_Last_Name','','R','Faculty_Phone_Num','','R','Faculty_Email','','RisEmail','Student_Email','','NisEmail','Risk_Rating','','RisNum','Benefit_Rating','','RisNum','Risk_Asses_Method_Expl','','R');return document.MM_returnValue">
  <input type="hidden" name="DestinationEmail" value="ospirb@txstate.edu, ki11@txstate.edu">
  <input type="hidden" name="thankyoupage" value="irbapplicationdataform_submitted.html" >
  <input name="messagesubject" type="hidden" id="messagesubject" value="IRB Application Data Submission Form" />
  <h2>SECTION 1: </h2>
  <h5>The number  below is your APPLICATION REFERENCE NUMBER.  You must do two things with this number:</h5>
  <ol>
    <li>
      <h5>First, cut and paste the number into the field below it. &nbsp;&nbsp;(Question #1) You must manually enter the number in the field. </h5>
    </li>
    <li>
      <h5>Second, write down the   number and save it. </h5>
    </li>
  </ol>
  <h5>This Application Reference Number must be used when you complete the   second step of the application, which is emailing your supporting documentation.   &nbsp;</h5>
  <h5>Make sure the number is in the subject line of the email that contains your   supporting documentation, as well as any subsequent emails regarding this   application.</h5>
  <p>&nbsp;</p>
  <p align="center" class="randomnumbers" ><script language="JavaScript">
today = new Date();
gtoday = today.toGMTString();
mydate = today.getDate();
myyear = today.getFullYear();
<!-- Begin
document.write("Your application reference number is <br><br><B>"+myyear+"-" + getRandomNum(10000,100000) + "</B>");
//   End -->
</script><br /></p>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font>Please enter the application reference number (above) in this field:
    <input name="App_Number" type="text" id="App_Number">
</p>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font> Are you: 
    <input type="radio" name="two_Student_vs_Faculty" value="student">
    a student 
    <input type="radio" name="two_Student_vs_Faculty" value="faculty/staff">
    a faculty/staff member?</p>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font>  Have you taken the required Human Subjects Protection Training? 
    <input name="two_training" type="radio" value="Yes">
  Yes&nbsp; 
  <input name="two_training" type="radio" value="No">
  No</p>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font> Which of the following trainings did you take? :  
    <select name="select">
      <option value="Choose One">Choose One</option>
      <option value="Not Applicable">Not Applicable</option>
      <option value="CITI Course">CITI Course</option>
      <option value="Previous Texas State HSP Training">Previous Texas State HSP Training</option>
    </select>  
  &nbsp; </p>
  <p><br>
    If you answered &quot;Previous Texas State HSP Training,&quot; provide your HSP Certification Number:
    <input name="HSP_Number" type="text" id="HSP_Number">
  </p>
  <p>&nbsp;</p>
  <h6>NOTE:&nbsp; If you have not taken a Human Subjects Protection Training, you must complete the CITI Course before your application can be processed.</h6>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font> Title of project: 
    <input type="text" name="Title_of_Project" value="" size="75">
  </p>
  <p><font color="#FF0000">*</font> Project type: </p>
  <blockquote> 
    <p> 
      <input type="radio" name="four_Project_Type" value="Academic/Class">
      Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Funded/Non-funded Research">
      Funded Research<br>
      <input type="radio" name="four_Project_Type" value="Institutional/Admin">
      Non-Funded Research <br>
      <input type="radio" name="four_Project_Type" value="Continuation/Renewal">
      Institutional/Admin.</p>
  </blockquote>
  <p>&nbsp;</p>
  <p>If Academic/Class, Course #: 
    <input type="text" name="Course_Number">
  </p>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font> If funded research, complete name of funder: 
    <input type="text" name="Funder_Name_Other">
  </p>
  <p>&nbsp;</p>
  <table cellspacing="1" cellpadding="1" border="0" height="196">
    <tr> 
      <td rowspan="6" valign="top" width="125"> 
        <p> Faculty / Staff 
      </td>
      <td width="211"><font color="#FF0000">*</font> First Name:</td>
      <td width="144" align="left"><font color="#FF0000">*</font> Last Name:</td>
    </tr>
    <tr> 
      <td width="211" height="40"> 
        <input type="text" name="Faculty_First_Name">
      </td>
      <td width="144" align="left" height="40"> 
        <input type="text" name="Faculty_Last_Name">
      </td>
    </tr>
    <tr> 
      <td width="211" height="22"><font color="#FF0000">*</font> Phone Number:</td>
      <td height="22" width="144"><font color="#FF0000">*</font> E-mail:</td>
    </tr>
    <tr> 
      <td width="211" height="39"> 
        <input type="text" name="Faculty_Phone_Num">
      </td>
      <td width="144" height="39"> 
        <input type="text" name="Faculty_Email">
      </td>
	  <td width="188">Do not enter more than one email address. Please make
		sure you have entered a complete and correct email address.</td>
    </tr>
      <td width="211" height="21"><font color="#FF0000">*</font> Department / 
        Admin Office:</td>
      <td height="21" width="144">&nbsp; </td>
    </tr>
    <tr> 
      <td colspan="2" height="37"> 
        <input type="text" name="Faculty_Department_Other">
      </td>
    </tr>
  </table>
  <br>
  <table cellspacing="1" cellpadding="1" border="0" height="196">
    <tr> 
      <td rowspan="6" valign="top" width="125"> 
        <p> Student 
      </td>
      <td width="175">First Name:</td>
      <td width="180" align="left">Last Name:</td>
    </tr>
    <tr> 
      <td width="175" height="40"> 
        <input type="text" name="Student_First_Name">
      </td>
      <td width="180" align="left" height="40"> 
        <input type="text" name="Student_Last_Name">
      </td>
    </tr>
    <tr> 
      <td width="175" height="22">Phone Number:</td>
      <td height="22" width="180">E-mail:</td>
    </tr>
    <tr> 
      <td width="175" height="39"> 
        <input type="text" name="Student_Phone_Num">
      </td>
      <td width="180" height="39"> 
        <input type="text" name="Student_Email">
      </td>
	 <td>Do not enter more than one email address. Please make
		sure you have entered a complete and correct email address.</td>
    </tr>
    <tr> 
      <td width="175" height="21">Rank:</td>
      <td height="21" width="180">Major: </td>
    </tr>
    <tr> 
      <td height="37"> 
        <input type="text" name="Student_Class_Rank">
      </td>
      <td height="37"> 
        <input type="text" name="Student_Major">
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font><strong>You will be informed of the IRB's decision 
    via email. Do you require a signed hard copy of the IRB's decision for your 
    records? 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="yes">
    Yes 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="no">
    No</strong></p>
  <hr>
  <h2>SECTION 2:</h2>
  <p>&nbsp;</p>
  <p><font color="#FF0000">This section requires brief answers on topics that 
    should be covered in more detail in your synopsis, consent forms, survey instruments, 
    and other required documents accompanying your application. <b>Please do not 
    assume that your answer below relieves you of the responsibility to cover 
    these issues in detail in your supporting documentation.</b></font></p>
  <p><font color="#FF0000">*</font> Does your project involve the use of the following 
    as research subjects:</p>
  <blockquote> 
    <p> Children under the age of 18 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="yes">
      Yes 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="no">
      No<br>
      Nursing home patients 
      <input type="radio" name="two_Using_NursingHomePatients" value="yes">
      Yes 
      <input type="radio" name="two_Using_NursingHomePatients" value="no">
      No<br>
      Prisoners 
      <input type="radio" name="two_Using_Prisoners" value="yes">
      Yes 
      <input type="radio" name="two_Using_Prisoners" value="no">
      No<br>
      Pregnant women or fetuses 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="yes">
      Yes 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="no">
      No<br>
      Persons with a physical illness, injury , or disability 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="yes">
      Yes 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="no">
      No<br>
      Mentally or psychologically impaired persons 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="yes">
      Yes 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="no">
      No<br>
    </p>
  </blockquote>
  <p> <font color="#FF0000">*</font> Are you offering any incentives to subjects 
    in return for participation? 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="yes">
    Yes 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="no">
    No</p>
  <p><font color="#FF0000">*</font> Will you be asking subjects to provide:</p>
  <blockquote> 
    <p> 
      <input type="checkbox" name="requestingName" value="true">
      Name<br>
      <input type="checkbox" name="requestingSSN" value="true">
      Social Security #<br>
      <input type="checkbox" name="requestingPhoneNum" value="true">
      Phone #<br>
      <input type="checkbox" name="requestingAddress" value="true">
      Address<br>
      <input type="checkbox" name="requestingMedicalInfo" value="true">
      Medical/health info<br>
      <input type="checkbox" name="requestingNone" value="true">
      I will NOT be asking subjects to provide their Name, Social Security #, 
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
  <h2>SECTION 3:</h2>
  <p><font color="#FF0000">*</font> Will you be using an informed consent document? 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="yes" checked>
    Yes 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="no">
    No </p>
  <blockquote> 
    <p>If &nbsp;you answered &#145;no&#148; above, please explain here:<br>
      <textarea name="rText_noInformedConsentExplanation" cols="70" rows="3"></textarea>
    </p>
  </blockquote>
  <p>If you are using an informed consent document, answer the following questions 
    about your informed consent document(s): Note: if you answered &quot;No&quot; 
    above, then you may leave all of the below Yes / No questions blank.</p>
  <blockquote> 
    <p><font color="#FF0000">*</font> Is the language in the document appropriately 
      matched to the comprehension level of your intended subject pool? 
      <input type="radio" name="two_Appropriate_Language" value="yes">
      Yes 
      <input type="radio" name="two_Appropriate_Language" value="no">
      No<br>
      <font color="#FF0000">*</font> Will the document be provided in language(s) 
      other than English? 
      <input type="radio" name="two_Other_Languages" value="yes">
      Yes 
      <input type="radio" name="two_Other_Languages" value="no">
      No<br>
      <font color="#FF0000">*</font> Will you arrange in advance for translators 
      for non-English speakers? 
      <input type="radio" name="two_Arrange_For_Translators" value="yes">
      Yes 
      <input type="radio" name="two_Arrange_For_Translators" value="no">
      No<br>
      <font color="#FF0000">*</font> Are you 100% sure that these translators 
      fully understand the exact meaning of the consent document? 
      <input type="radio" name="two_Translators_Understand_Meaning" value="yes">
      Yes 
      <input type="radio" name="two_Translators_Understand_Meaning" value="no">
      No<br>
      <font color="#FF0000">*</font> Will you be obtaining the subject's signature? 
      <input type="radio" name="two_Obtaining_Subjects_Signature" value="yes">
      Yes 
      <input type="radio" name="two_Obtaining_Subjects_Signature" value="no">
      No<br>
      <font color="#FF0000">*</font> Will you be providing subjects a copy of 
      their consent document? 
      <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="yes">
      Yes 
      <input type="radio" name="two_Providing_Copy_of_Consent_Doc" value="no">
      No<br>
      <font color="#FF0000">*</font> Does your document in any way ask or imply 
      that subjects are waiving any right or releasing you from any liability? 
      <input type="radio" name="two_Liability_Release" value="yes">
      Yes 
      <input type="radio" name="two_Liability_Release" value="no">
      No</p>
  </blockquote>
  <p> If you are using an informed consent document, does your informed consent 
    document contain:</p>
  <blockquote> 
    <p><font color="#FF0000">*</font> A statement that the study involves research? 
      <input type="radio" name="two_Research_Involvment_Statement" value="yes">
      Yes 
      <input type="radio" name="two_Research_Involvment_Statement" value="no">
      No<br>
      <font color="#FF0000">*</font> An explanation of the purposes of the research? 
      <input type="radio" name="two_Explanation_of_Purpose" value="yes">
      Yes 
      <input type="radio" name="two_Explanation_of_Purpose" value="no">
      No<br>
      <font color="#FF0000">*</font> The expected duration of the subject's participation? 
      <input type="radio" name="two_Expected_Duration" value="yes">
      Yes 
      <input type="radio" name="two_Expected_Duration" value="no">
      No<br>
      <font color="#FF0000">*</font> Identification of any procedures which are 
      experimental? 
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="yes">
      Yes 
      <input type="radio" name="two_Identification_of_Experimental_Procedures" value="no">
      No<br>
      <font color="#FF0000">*</font> A description of any reasonably foreseeable 
      risks or discomforts to the subject? 
      <input type="radio" name="two_Description_of_Risks" value="yes">
      Yes 
      <input type="radio" name="two_Description_of_Risks" value="no">
      No<br>
      <font color="#FF0000">*</font> A description of any benefits to the subject 
      or to others which may reasonably be expected from the research? 
      <input type="radio" name="two_Expected_Benefit" value="yes">
      Yes 
      <input type="radio" name="two_Expected_Benefit" value="no">
      No<br>
      <font color="#FF0000">*</font> A disclosure of appropriate alternative procedures 
      or courses of treatment, if any, that might be advantageous to the subject? 
      <input type="radio" name="two_Alternatives_Disclosure" value="yes">
      Yes 
      <input type="radio" name="two_Alternatives_Disclosure" value="no">
      No<br>
      <br>
      <font color="#FF0000">*</font> For research involving more than minimal 
      risk, an explanation as to whether any compensation, and an explanation 
      as to whether any medical treatments are available, if injury occurs and, 
      if so, what they consist of, or where further information may be obtained? 
      <input type="radio" name="two_Explanation_of_Compensation" value="yes">
      Yes 
      <input type="radio" name="two_Explanation_of_Compensation" value="no">
      No<br>
      <br>
      <font color="#FF0000">*</font> An explanation of whom to contact for answers 
      to pertinent questions about the research and research subjects' rights, 
      and whom to contact in the event of a research-related injury to the subject? 
      <input type="radio" name="two_Contact_Info" value="yes">
      Yes 
      <input type="radio" name="two_Contact_Info" value="no">
      No<br>
      <br>
      <font color="#FF0000">*</font> A statement that participation is voluntary, 
      refusal to participate will involve no penalty or loss of benefits to which 
      the subject is otherwise entitled, and the subject may discontinue participation 
      at any time without penalty or loss of benefits, to which the subject is 
      otherwise entitled? 
      <input type="radio" name="two_Voluntary_Participation_Statement" value="yes">
      Yes 
      <input type="radio" name="two_Voluntary_Participation_Statement" value="no">
      No</p>
    <p>&nbsp;</p>
  </blockquote>
  <table width="100%" border="0">
    <tr> 
      <td> 
        <input type="submit" name="SubmitForm" value="Submit">
      </td>
      <td align="right"> 
        <input type="reset" name="ResetForm" value="Clear Form" onClick="return confirm('Are you sure you want to clear the contents of this form and start over? (Click OK to clear form)')">
      </td>
    </tr>
  </table>
</form>
</body>
</html>