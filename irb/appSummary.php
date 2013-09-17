 <?php require_once('connection/dbc.php'); ?>
<html>
<head>
<title>IRB Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

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
<?php
   $appNumber = $_GET['appNum'];
   
 
$sql = sprintf("SELECT * FROM application WHERE App_Number = %s", $appNumber);
$app = mysql_query($sql, $con) or die(mysql_error());
$rs_app = mysql_fetch_assoc($app);
   
   
<body text="#000000">
<p>&nbsp;</p>

 
  
  <h3>SECTION 1: </h3>
  <h5> APPLICATION REFERENCE NUMBER: <font color = "red"><?php echo($appNumber) ?></font>  </h5>
  
  <h5>
   
</h5>
  
  
  <h6><font color="#FF0000">*</font> Title of project:</h6>
  <h6>
  <?php echo $rs_app['ProjectTitle']; ?>
  </h6>
  <p><font color="#FF0000">*</font> Project type: </p>
  <blockquote> 
    <p> 
      <?php echo $rs_app['ProjectType']; ?>
  </blockquote>
  <p>&nbsp;</p>
  <p>If Academic/Class, Course #: 
 <b>  <?php echo $rs_app['CourseNumber']; ?></b>
  </p>

  <p><font color="#FF0000">*</font> If funded research, name of funder: <br>
 <b> <?php echo $rs_app['FunderName']; ?></b>
  </p>

  <p><font color="#FF0000">*</font><strong>Do you require a signed hard copy of the IRB's decision? <?php echo $rs_app['SignedHardCopy']; ?>
  <hr>
  <h3>SECTION 2:</h3>
 

  <p><font color="#FF0000">*</font> Does the project involve the use of the following 
    as research subjects:</p>
  <blockquote> 
    <p> Children under the age of 18: 
      <?php echo $rs_app['PChildrenUnder18']; ?>
     <p> Nursing home patients:  
      <?php echo $rs_app['NursingHomePatients']; ?>
      <p>Prisoners: 
     <?php echo $rs_app['Prisoner']; ?>
      <p>Pregnant women or fetuses: 
      <?php echo $rs_app['PregnantWomenOrFetuses']; ?>
      <p>Persons with a physical illness, injury , or disability 
    <?php echo $rs_app['IllinessInjoryOrDisability']; ?>
	
      <p>Mentally or psychologically impaired persons 
      <?php echo $rs_app['MentallyOrPsychologicallyImpaired']; ?>
    </p>
  </blockquote>
  <p> <font color="#FF0000">*</font> Are you offering any incentives to subjects in return for participation? 
    <?php echo $rs_app['IncentiveForParticipation']; ?>
  <p><font color="#FF0000">*</font> Will you be asking subjects to provide:</p>
  <blockquote> 
    <p> 
      
      Name? <?php echo $rs_app['RequestName']; ?><br>
     
      Social Security #?<?php echo $rs_app['RequestSSN']; ?><br>
      
      Phone #? <?php echo $rs_app['RequestPhoneNum']; ?><br>
      
      Address? <?php echo $rs_app['RequestAddress']; ?><br>
      
      Medical/health info? <?php echo $rs_app['RequestMedicalInfo']; ?><br>
     I will NOT be asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info: <?php echo $rs_app['RequestNone']; ?><br>
    </p>
  </blockquote>
  <p> <b>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study</b>.<br>
    <font color="#FF0000">*</font> On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, overall risk to subjects in your project. 
    <?php echo $rs_app['RiskRating']; ?>
  </p>
  <p>&nbsp;</p>
  <p><b>Benefit: A valued or desired outcome; an advantage.<br>
    </b><font color="#FF0000">*</font> On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <?php echo $rs_app['BenefitRating']; ?>
  </p>
  <p>&nbsp;</p>
  <p><font color="#FF0000">*</font> In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.<br>
    <?php echo $rs_app['RiskAssesMethod']; ?>
  </p>
  <hr>
  <h3>SECTION 3:</h3>
  <p><font color="#FF0000">*</font> Will you be using an informed consent document? 
   <?php echo $rs_app['InformedConsentDoc']; ?></p>
  <blockquote> 
    <p>If &nbsp;you answered &#145;no&#148; above, please explain here:<br>
      <?php echo $rs_app['NoInformedConsentExp']; ?>
    </p>
  </blockquote>
  <p>If you are using an informed consent document, answer the following questions 
    about your informed consent document(s): Note: if you answered &quot;No&quot; 
    above, then you may leave all of the below Yes / No questions blank.</p>
  <blockquote> 
    <p><font color="#FF0000">*</font> Is the language in the document appropriately 
      matched to the comprehension level of your intended subject pool? 
      <?php echo $rs_app['AppropriatedLanguage']; ?><br>
      <font color="#FF0000">*</font> Will the document be provided in language(s) 
      other than English? 
      <?php echo $rs_app['OtherLanguage']; ?><br>
      <font color="#FF0000">*</font> Will you arrange in advance for translators 
      for non-English speakers? 
 <?php echo $rs_app['ArrangeForTranslators']; ?><br>
      <font color="#FF0000">*</font> Are you 100% sure that these translators 
      fully understand the exact meaning of the consent document? 
      <?php echo $rs_app['TranslatorUnderstand']; ?><br>
      <font color="#FF0000">*</font> Will you be obtaining the subject's signature? 
      <?php echo $rs_app['ObtainSubjectsSignature']; ?><br>
      <font color="#FF0000">*</font> Will you be providing subjects a copy of 
      their consent document? 
      <?php echo $rs_app['ProvideCopyOfConsentDoc']; ?><br>
      <font color="#FF0000">*</font> Does your document in any way ask or imply 
      that subjects are waiving any right or releasing you from any liability? 
     <?php echo $rs_app['LiabilityRelease']; ?></p>
  </blockquote>
  <p> If you are using an informed consent document, does your informed consent 
    document contain:</p>
  <blockquote> 
    <p><font color="#FF0000">*</font> A statement that the study involves research? 
      <?php echo $rs_app['ResearchInvolvementStatement']; ?><br>
      <font color="#FF0000">*</font> An explanation of the purposes of the research? 
      <?php echo $rs_app['ExplanationOfPurpose']; ?><br>
      <font color="#FF0000">*</font> The expected duration of the subject's participation? 
      <?php echo $rs_app['ExpectDuration']; ?><br>
      <font color="#FF0000">*</font> Identification of any procedures which are 
      experimental? 
      <?php echo $rs_app['IdentificationOfExperimentalProc']; ?><br>
      <font color="#FF0000">*</font> A description of any reasonably foreseeable 
      risks or discomforts to the subject? 
      <?php echo $rs_app['DescriptionOfRisk']; ?><br>
      <font color="#FF0000">*</font> A description of any benefits to the subject 
      or to others which may reasonably be expected from the research? 
      <?php echo $rs_app['ExpectedBenefit']; ?><br>
      <font color="#FF0000">*</font> A disclosure of appropriate alternative procedures 
      or courses of treatment, if any, that might be advantageous to the subject? 
      <?php echo $rs_app['AlternativeOfDisclosure']; ?><br>
      <br>
      <font color="#FF0000">*</font> For research involving more than minimal 
      risk, an explanation as to whether any compensation, and an explanation 
      as to whether any medical treatments are available, if injury occurs and, 
      if so, what they consist of, or where further information may be obtained? 
      <?php echo $rs_app['ExplanationOfCompensation']; ?><br>
      <br>
      <font color="#FF0000">*</font> An explanation of whom to contact for answers 
      to pertinent questions about the research and research subjects' rights, 
      and whom to contact in the event of a research-related injury to the subject? 
      <?php echo $rs_app['ContactInfo']; ?><br>
      <br>
      <font color="#FF0000">*</font> A statement that participation is voluntary, 
      refusal to participate will involve no penalty or loss of benefits to which 
      the subject is otherwise entitled, and the subject may discontinue participation 
      at any time without penalty or loss of benefits, to which the subject is 
      otherwise entitled? 
    <?php echo $rs_app['VoluntaryParticipationStatement']; ?></p>
  <hr>
  Update application status
  <hr>
<p>&nbsp;</P>
</blockquote>
  <table width="100%" border="0">
    <tr> 
      <td align="center">View/Download Project Documents;</td>
     
    </tr>
	<tr><td>
	<?php

$path = "appdoc/".$appNum;
$dh = opendir($path);
$i=1;
while (($file = readdir($dh)) !== false) {
    if($file != "." && $file != "..") {
        echo "$i. <a href='$path/$file'>$file</a><br />";
        $i++;
    }
}
closedir($dh);
?></td></tr>
  </table>

</body>
</html>
