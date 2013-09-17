<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IRB Exemption Form</title>


<script type="text/JavaScript">
<!--
function stopRKey(evt) {
	var evt  = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if ((evt.keyCode == 13) && (node.type=="text")) { return false; }
}
document.onkeypress = stopRKey;

function checkInputSize(which, maxsize) {
        which.value = which.value.substring(0, maxsize);
    }

function FDK_AddToValidateArray(FormName,FormElement,Validation,SetFocus)
{
    var TheRoot=eval("document."+FormName);
 
    if (!TheRoot.ValidateForm) 
    {
        TheRoot.ValidateForm = true;
        eval(FormName+"NameArray = new Array()")
        eval(FormName+"ValidationArray = new Array()")
        eval(FormName+"FocusArray = new Array()")
    }
    var ArrayIndex = eval(FormName+"NameArray.length");
    eval(FormName+"NameArray[ArrayIndex] = FormElement");
    eval(FormName+"ValidationArray[ArrayIndex] = Validation");
    eval(FormName+"FocusArray[ArrayIndex] = SetFocus");
 
}

function FDK_ValidateRadio(RadioGroup,ErrorMsg)
{
	var msg = ErrorMsg;

    for (x=0;x<RadioGroup.length;x++)  {
		if (RadioGroup[x].checked)  {
			msg=""
		} 
	}
	return msg;
}

function FDK_AddRadioValidation(FormName,FormElementName,SetFocus,ErrorMsg)  {
  var ValString = "FDK_ValidateRadio("+FormElementName+","+ErrorMsg+")"
  FDK_AddToValidateArray(FormName,eval(FormElementName + '[0]'),ValString,SetFocus)
}

function FDK_ValidateSelectionMade(FormElement,ErrorMsg)
{
  msg = "";

  var iPos = FormElement.selectedIndex;
  if ((iPos<=0 && FormElement.size<=1) || (iPos<0))
  {
    msg = ErrorMsg;
  }

  return msg;
}

function FDK_AddSelectionMadeValidation(FormName,FormElementName,SetFocus,ErrorMsg)  {
  var ValString = "FDK_ValidateSelectionMade("+FormElementName+","+ErrorMsg+")"
  FDK_AddToValidateArray(FormName,eval(FormElementName),ValString,SetFocus)
}

function FDK_Validate(FormName, stopOnFailure, AutoSubmit, ErrorHeader)
{
 var theFormName = FormName;
 var theElementName = "";
 if (theFormName.indexOf(".")>=0)  
 {
   theElementName = theFormName.substring(theFormName.indexOf(".")+1)
   theFormName = theFormName.substring(0,theFormName.indexOf("."))
 }
 var ValidationCheck = eval("document."+theFormName+".ValidateForm")
 if (ValidationCheck)  
 {
  var theNameArray = eval(theFormName+"NameArray")
  var theValidationArray = eval(theFormName+"ValidationArray")
  var theFocusArray = eval(theFormName+"FocusArray")
  var ErrorMsg = "";
  var FocusSet = false;
  var i
  var msg
    
 
        // Go through the Validate Array that may or may not exist
        // and call the Validate function for all elements that have one.
  if (String(theNameArray)!="undefined")
  {
   for (i = 0; i < theNameArray.length; i ++)
   {
    msg="";
    if (theNameArray[i].name == theElementName || theElementName == "")
    {
      msg = eval(theValidationArray[i]);
    }
    if (msg != "")
    {
     ErrorMsg += "\n"+msg;                   
     if (stopOnFailure == "1") 
     {
       if (theFocusArray[i] && !FocusSet)  
      {
       FocusSet=true;
       theNameArray[i].focus();
      }
      alert(ErrorHeader+ErrorMsg);
      document.MM_returnValue = false; 
      break;
     }
     else  
     {
      if (theFocusArray[i] && !FocusSet)  
      {
       FocusSet=true;
       theNameArray[i].focus();
      }
     }
    }
   }
  }
  if (ErrorMsg!="" && stopOnFailure != "1") 
  {
   alert(ErrorHeader+ErrorMsg);
  }
  document.MM_returnValue = (ErrorMsg==""); 
  if (document.MM_returnValue && AutoSubmit)  
  {
   eval("document."+FormName+".submit()")
  }
 }
}

function FDK_StripChars(theFilter,theString)
{
	var strOut,i,curChar

	strOut = ""
	for (i=0;i < theString.length; i++)
	{		
		curChar = theString.charAt(i)
		if (theFilter.indexOf(curChar) < 0)	// if it's not in the filter, send it thru
			strOut += curChar		
	}	
	return strOut
}

function FDK_ValidateNonBlank(FormElement,ErrorMsg)
{
  var msg = ErrorMsg;
  var val = FormElement.value;  

  if (!(FDK_StripChars(" \n\t\r",val).length == 0))
  {
     msg="";
  }

  return msg;
}

function FDK_AddNonBlankValidation(FormName,FormElementName,SetFocus,ErrorMsg)  {
  var ValString = "FDK_ValidateNonBlank("+FormElementName+","+ErrorMsg+")"
  FDK_AddToValidateArray(FormName,eval(FormElementName),ValString,SetFocus)
}

function FDK_AllInRange(x,y,theString)
{
	var i, curChar
	
	for (i=0; i < theString.length; i++)
	{
		curChar = theString.charAt(i)
		if (curChar < x || curChar > y) //the char is not in range
			return false
	}
	return true
}

function FDK_reformat(s)
{
    var arg;
    var sPos = 0;
    var resultString = "";

    for (var i = 1; i < FDK_reformat.arguments.length; i++) {
       arg = FDK_reformat.arguments[i];
       if (i % 2 == 1) 
           resultString += arg;
       else 
       {
           resultString += s.substring(sPos, sPos + arg);
           sPos += arg;
       }
    }
    return resultString;
}

function FDK_ValidateEmail(FormElement,Required,ErrorMsg)
{
   var msg = "";
   var val = FormElement.value;
   var msgInvalid = ErrorMsg;

   var theLen = FDK_StripChars(" ",val).length
   if (theLen == 0)	     {
     if (!Required) return "";
     else return msgInvalid;
   }

   if (val.indexOf("@",0) < 0 || val.indexOf(".")<0) 
   {
      msg = msgInvalid;
   }
   return msg;
}

function FDK_AddEmailValidation(FormName,FormElementName,Required,SetFocus,ErrorMsg)  {
  var ValString = "FDK_ValidateEmail("+FormElementName+","+Required+","+ErrorMsg+")"
  FDK_AddToValidateArray(FormName,eval(FormElementName),ValString,SetFocus)
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>

<link href="../css/forms.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
</head>

<body onload="FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_1_academic_project',true,'\'An answer to Section II, Question 1 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_2_contribute_knowledge',true,'\'An answer to Section II, Question 2 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_3_share_results',true,'\'An answer to Section II, Question 3 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_4_interact_people',true,'\'An answer to Section II, Question 4 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_5_collect_info',true,'\'An answer to Section II, Question 5 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_6_involve_pregnant',true,'\'An answer to Section II, Question 6 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_7_involve_prisoners',true,'\'An answer to Section II, Question 7 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_8_involve_vulnerable',true,'\'An answer to Section II, Question 8 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_9_medical_identifiers',true,'\'An answer to Section II, Question 9 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_10_minor_subjects',true,'\'An answer to Section II, Question 10 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_11_FDAproduct_used',true,'\'An answer to Section II, Question 11 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_12_ingest_substance',true,'\'An answer to Section II, Question 12 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_13_physical_tasks',true,'\'An answer to Section II, Question 13 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_14_influence_behavior',true,'\'An answer to Section II, Question 14 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_15_sensitive_discussion',true,'\'An answer to Section II, Question 15 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_16_exposeto_discomfort',true,'\'An answer to Section II, Question 16 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_17_subject_deception',true,'\'An answer to Section II, Question 17 is required,\\nplease make a selection.\'');FDK_AddRadioValidation('irb_exemption_form','document.irb_exemption_form.II_18_taping_subjects',true,'\'An answer to Section II, Question 18 is required,\\nplease make a selection.\'');FDK_AddSelectionMadeValidation('irb_exemption_form','document.irb_exemption_form.SenderStatus',true,'\'An answer to Section I, Question 1 is required,\\nplease make a selection.\'');FDK_AddSelectionMadeValidation('irb_exemption_form','document.irb_exemption_form.sponsorship',true,'\'An answer to Section I, Question 2 is required,\\nplease make a selection.\'');FDK_AddSelectionMadeValidation('irb_exemption_form','document.irb_exemption_form.III_1_exempt_category',true,'\'An answer to Section III, Question 1 is required,\\nplease make a selection.\'');FDK_AddNonBlankValidation('irb_exemption_form','document.irb_exemption_form.SenderPhoneExt',true,'\'If you do not have a phone extension, please answer N/A in the space provided for Section I, Question 4 - extension.\'');FDK_AddNonBlankValidation('irb_exemption_form','document.irb_exemption_form.FacultyName',true,'\'If you are not a student, please enter N/A into the space provided for Section I, Question 4 - Faculty Name.\'');FDK_AddEmailValidation('irb_exemption_form','document.irb_exemption_form.SenderEmail',true,true,'\'Please enter a valid e-mail address.\\n(a valid e-mail address has an \\\'@\\\' and a \\\'.\\\')\'')" >
<h2>Application for IRB Exemption</h2>
<p>&nbsp;</p>
<form action="" method="post" name="irb_exemption_form" id="irb_exemption_form" onsubmit="FDK_Validate('irb_exemption_form',false,false,'The Form Could Not Be Submitted\n\n');MM_validateForm('SenderFirstName','','R','SenderName','','R','SenderPhone','','R','III_2_project_purpose','','R','III_3_category_pertains','','R','III_4_exempt_reason','','R');return document.MM_returnValue" >
  <input type="hidden" name="DestinationEmail" value="sn10@txstate.edu, ospirb@txstate.edu">
  <input type="hidden" name="thankyoupage"
   value="http://www.txstate.edu/research/irb/irb_exemption_submitted.php">
  <input name="messagesubject" type="hidden" id="messagesubject" value="irb_exemption_form.html">
  
    <h2>Section I </h2>
    <table width="90%" border="0" cellpadding="5" cellspacing="0" >
    <tr>
      <td>1.&nbsp; Are you
        <label for="select"></label>
        <select name="SenderStatus" id="SenderStatus">
          <option value="none" selected="selected">--select one--</option>
          <option value="student">a student</option>
          <option value="faculty">a faculty member</option>
          <option value="staff_member">a staff member</option>
          <option value="other">other</option>
        </select></td>
    </tr>
    <tr>
      <td>2.&nbsp; This project is&nbsp;
        <label for="label"></label>
        <select name="sponsorship" id="sponsorship">
          <option value="none" selected="selected">--select one--</option>
          <option value="funded_research">Funded Research</option>
          <option value="other_spons_progr_contract">Other Sponsored Program/Contract</option>
          <option value="faculty_nonfunded">FACULTY non-funded Research</option>
          <option value="thesis_dissertation">Thesis/Dissertation</option>
          <option value="academic_classrm_project">Academic/Classroom Project</option>
          <option value="Institut_admin_progrm">Institutional/Admin Program</option>
          <option value="other">Other</option>
        </select></td>
    </tr>
    <tr>
      <td>3.&nbsp; Please provide: </td>
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp; First Name
        <input name="SenderFirstName" type="text" id="SenderFirstName" value="" size="20" />
        &nbsp; Last Name
        <input name="SenderName" type="text" id="SenderName" value="" size="20" /></td>
    </tr>
    <tr>
      <td> &nbsp;&nbsp;&nbsp;&nbsp; Phone Number
        <input name="SenderPhone" type="text" id="SenderPhone" value="" size="12" />
&nbsp;&nbsp;&nbsp;Email
<input name="SenderEmail" type="text" id="SenderEmail" value="" size="35" /></td>
    </tr>
    <tr>
      <td><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; **Please check to be sure your phone number and email address are correct. </h6></td>
    </tr>
    <tr>
      <td>4.&nbsp; If you are a student, please provide your supervising faculty member's full name: </td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp; Faculty Name
        <input name="FacultyName" type="text" id="FacultyName" value="-N/A, if not a student-" size="35" /></td>
    </tr>
    <tr>
      <td><h2>Section II </h2></td>
    </tr>
    <tr>
      <td>1.&nbsp; If this is  an academic or classroom project, does the scope extend beyond Texas State University? </td>
    </tr>
    <tr>
      <td>&nbsp;
      <label>
          <input name="II_1_academic_project" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_1_academic_project" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>2.&nbsp; Would you describe this project as &quot;a systematic investigation, designed to develop or contribute to generalizable knowledge? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_2_contribute_knowledge" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_2_contribute_knowledge" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>3.&nbsp; Will the results of your project be put on the internet, shared at a conference, published, or otherwise disseminated? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
<input name="II_3_share_results" type="radio" value="Yes" /> 
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_3_share_results" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>4.&nbsp;Will identifiable private information from individuals be collected from contact with research participants ? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_4_interact_people" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_4_interact_people" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>5.&nbsp; Will identifiable private information from individuals be collected from other sources (e.g. medical records)? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_5_collect_info" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_5_collect_info" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>6.&nbsp; Does the project involve fetuses, pregnant women or human in vitro fertilization? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_6_involve_pregnant" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_6_involve_pregnant" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>7.&nbsp; Does the project involve prisoners? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_7_involve_prisoners" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_7_involve_prisoners" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>8.&nbsp; Does the project involve any persons who are mentally impaired or homeless  or  who have limited autonomy? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_8_involve_vulnerable" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_8_involve_vulnerable" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>9.&nbsp; Does the project involve the review of medical records if the information is recorded in such a way that subjects can be indentified, directly or through identifiers linked to the subjects? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
<input name="II_9_medical_identifiers" type="radio" value="Yes" /> 
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_9_medical_identifiers" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>10. Does the project involve survey or interview techniques which include minors as subjects in which the researcher(s) participate in the activities being observed? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_10_minor_subjects" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_10_minor_subjects" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>11. Will a drug, biological product, medical device, or other product regulated by the FDA be used in this project? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_11_FDAproduct_used" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_11_FDAproduct_used" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>12. Will the participants be asked to ingest substances of any kind?</td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_12_ingest_substance" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_12_ingest_substance" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>13. Will the participants be asked to perform any physical tasks? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_13_physical_tasks" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_13_physical_tasks" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>14. Does the research attempt to influence or change participants' behavior, perception, or cognition? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_14_influence_behavior" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_14_influence_behavior" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>15. Does the project involve questions or discussions of sensitive or deeply personal aspects of the subject's behavior, life experiences or attitudes?&nbsp; Examples include substance abuse, sexual activity, sexual orientation, sexual abuse, criminal behavior, sensitive demographic data, detailed health history, etc. </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_15_sensitive_discussion" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_15_sensitive_discussion" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>16. Does the project involve techniques which expose the subject to discomfort, harassment, embarrassment, stigma, alarm or fear beyond levels encountered in the daily life of a healthy individual? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_16_exposeto_discomfort" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_16_exposeto_discomfort" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>17. Does the project involve the deception of subjects? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_17_subject_deception" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_17_subject_deception" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td>18. Does the project involve videotaping or audiotaping of subjects? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_18_taping_subjects" type="radio" value="Yes" />
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_18_taping_subjects" type="radio" value="No" />
No</label>      </td>
    </tr>
    <tr>
      <td><h2>Section III </h2></td>
    </tr>
    <tr>
      <td><a name="SectionIIIQuestion2" id="SectionIIIQuestion2"></a>1.&nbsp; If you are choosing one of the <a href="#categories_of_exemption">six federal categories of exemption</a>, which <strong>one</strong> are you choosing?<br />
        <span class="style9">**</span>If your project falls under more than one exemption, choose the one that is most applicable.&nbsp; You may cite the others in #3 below. </td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;
        <label>
        <select name="III_1_exempt_category" id="III_1_exempt_category">
          <option value="none" selected="selected">--select one--</option>
          <option value="Category 1(i)">Category 1 (i)</option>
          <option value="Category 1 (ii)">Category 1 (ii)</option>
          <option value="Category 2">Category 2</option>
          <option value="Category 3 (i)">Category 3 (i)</option>
          <option value="Category 3 (ii)">Category 3 (ii)</option>
          <option value="Category 4">Category 4</option>
          <option value="Category 5 (i)">Category 5 (i)</option>
          <option value="Category 5 (ii)">Category 5 (ii)</option>
          <option value="Category 5 (iii)">Category 5 (iii)</option>
          <option value="Category 5 (iv)">Category 5 (iv)</option>
          <option value="Category 6 (i)">Category 6 (i)</option>
          <option value="Category 6 (ii)">Category 6 (ii)</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><h6 class="style1">
	  Please note for questions 1, 3, and 4
	  :&nbsp; </h6>
        <h6 class="style1"><br />
      The text areas are  limited to 2000 characters/approximately 300 words.&nbsp; Even though you are allowed to type more than the specified limit, those additional words/characters will be cropped/cut off when you move to the next question.</h6></td>
    </tr>
    <tr>
      <td>2.&nbsp; What is the purpose of the project? (300 words or less)</td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp; <label>
        <textarea name="III_2_project_purpose" cols="100" rows="10" id="III_2_project_purpose" onchange="checkInputSize(this, 2000)"></textarea>
      </label></td>
    </tr>
    <tr>
      <td>3.&nbsp; Explain how this exemption category pertains to your project: (300 words or less) </td>
    </tr>
    <tr>
      <td><label>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="III_3_category_pertains" cols="100" rows="10" id="III_3_category_pertains" onchange="checkInputSize(this, 2000)"></textarea>
      </label></td>
    </tr>
    <tr>
      <td>4.&nbsp; If you believe your project poses no risk to human participants or should be exempt from IRB review for other reasons, please explain: (300 words or less) </td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp; <label>
        <textarea name="III_4_exempt_reason" cols="100" rows="10" id="III_4_exempt_reason" onchange="checkInputSize(this, 2000)" ></textarea>
      </label></td>
    </tr>
    <tr>
      <td><div align="center">
        <input type="submit" name="Submit" value="Submit" />
      </div></td>
    </tr>
    <tr>
      <td><h4>&nbsp;</h4></td>
    </tr>
  </table>
</form>
<table width="90%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><h6><a name="categories_of_exemption" id="CategoriesofExemption"></a>Categories of Exemption:&nbsp;&nbsp; (<a href="#SectionIIIQuestion2">Return to Section III, Question 2</a>) 
    </h6>
      <p>&nbsp;</p>
      <h6 >Exempt Categories of Research listed at 45 CFR, Part 46, Sec. 101(b)<br />
          <br />
        (1) Research conducted in established or commonly accepted educational settings, involving normal educational practices, such as</h6>
      <p >&nbsp;&nbsp;&nbsp;&nbsp; </p>
      <p >&nbsp;&nbsp;&nbsp;&nbsp; (i) research on regular and special education instructional strategies, or </p>
      <p >&nbsp;&nbsp;&nbsp;&nbsp; </p>
      <p >&nbsp;&nbsp;&nbsp;&nbsp; (ii) research on the effectiveness of or the comparison among instructional techniques, curricula, or classroom management methods.</p>
      <h6 >&nbsp;</h6>
      <h6 >(2) Research involving the use of educational tests (cognitive, diagnostic, aptitude, achievement), survey procedures, interview procedures or observation of public behavior, unless:</h6>
      <p >&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <p >&nbsp;&nbsp;&nbsp;&nbsp; (i) information obtained is recorded in such a manner that human subjects can be identified, directly or through identifiers linked to the subjects; and </p>
      <p >&nbsp;&nbsp;&nbsp;</p>
      <p >&nbsp;&nbsp;&nbsp;&nbsp; (ii) any disclosure of the human subjects' responses outside the research could reasonably place the subjects at risk of criminal or civil liability or be damaging to the subjects' financial standing, employability, or reputation.</p>
      <p >&nbsp;</p>
      <p >(<span class="style7">Please note</span>: Surveys on sensitive or personal topics which may cause stress to study participants may not be exempt from IRB review.)</p>
      <p >&nbsp;</p>
      <p >(<span class="style7">Note</span>: The section of this category pertaining to standardized educational tests may be applied to research involving children. This category may also apply to research with children when the investigator observes public behavior but does NOT participate in that behavior or activity. However this  section is NOT applicable to survey or interview research involving children.)</p>
      <h6 >&nbsp;</h6>
      <h6 >(3) Research involving the use of educational tests (cognitive, diagnostic, aptitude, achievement), survey procedures, interview procedures, or observation of public behavior that is not exempt under paragraph (2) of this section, if:</h6>
      <p >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <p > &nbsp;&nbsp;&nbsp;&nbsp; (i) the human subjects are elected or appointed public officials or candidates for public office; or </p>
      <p >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <p > &nbsp;&nbsp;&nbsp;&nbsp; (ii) federal statute(s) require(s) without exception that the confidentiality of the personally identifiable information will be maintained throughout the research and thereafter.</p>
      <h6 >&nbsp;</h6>
      <h6 >(4) Research involving the collection or study of existing data, documents, records, pathological specimens, or diagnostic specimens, if these sources are publicly available or if the information is recorded by the investigator in such a manner that subjects cannot be identified, directly or through identifiers linked to the subjects.</h6>
      <p >&nbsp;</p>
      <p >(Example: existing data, records review, pathological specimens)</p>
      <p >&nbsp;</p>
      <p >(<span class="style7">Note</span>: This data must be in existence before the project begins)</p>
      <h6 >&nbsp;</h6>
      <h6 >(5) Research and demonstration projects which are conducted by or subject to the approval of department or agency heads, and which are designed to study, evaluate, or otherwise examine:</h6>
      <p >&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <p >&nbsp;&nbsp;&nbsp;&nbsp; (i) Public benefit or service programs;</p>
      <p> <span >&nbsp;&nbsp;&nbsp;&nbsp; (ii) procedures for obtaining benefits or services under those programs;</span></p>
      <p> <span >&nbsp;&nbsp;&nbsp;&nbsp; (iii) possible changes in or alternatives to those programs or procedures; or</span></p>
      <p> <span >&nbsp;&nbsp;&nbsp;&nbsp; (iv) possible changes in methods or levels of payment for benefits or services under those programs.</span></p>
      <p >(<span class="style7">Note</span>: Exemption category refers to federal government research)</p>
      <p >&nbsp;</p>
      <h6 class="style1" >(6) Taste and food quality evaluation and consumer acceptance studies, </h6>
      <p >&nbsp;</p>
      <p > &nbsp;&nbsp;&nbsp;&nbsp; (i)&nbsp; if wholesome foods without additives are consumed or</p>
           (ii) if a food is consumed that contains a food ingredient at or below the level and for a use found to be safe, or agricultural chemical or environmental contaminant at or below the level found to be safe, by the Food and Drug Administration or approved by the Environmental Protection Agency or the Food Safety and Inspection Service of the U.S. Department of Agriculture
      <p class="formheading">&nbsp;</p></td></tr>
</table>
<h4 class="formheading">&nbsp;</h4>
<h4 class="formheading">&nbsp;</h4>
</body>


</html>
