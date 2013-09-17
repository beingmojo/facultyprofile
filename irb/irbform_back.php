 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>

<script>
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
     <a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a> <span class="style42">| </span><a href="LogOut.php" class="irb">Log Out</a></td> </tr><tr><td>
      <p align="center"><strong><br><?php echo $_SESSION['name'];?></strong></p>
      </strong></div>
 
    <hr>
<h4 align="center"><strong>IRB APPLICATION FORM</strong></h4>
<p>This is an ELECTRONIC submission form. Applications must be submitted electronically. Printed IRB applications will not be accepted. If you experience difficulty with the form, try quitting your browser application and starting over. Use the <a href="http://www.osp.txstate.edu/irb/irb_inquiry.html" target="_blank">IRB INQUIRY REQUEST FORM</a> on the IRB website or  contact IRB administration at 512 245-2314 if you require assistance.</p>

<p>Also note that the information you enter here will be used AS IS to generate your electronic IRB approval certificate online. If you do not use proper spelling and/or capitalization for your name and the title of your project, it will show up that way on your approval certificate. </p>
<p><br>
</p>
<form name="IRBForm" method="POST" action = "<?php echo $_SERVER['PHP_SELF']; ?>"  >  
  <h5>SECTION 1: </h5>
  <p>This is your application REFERENCE NUMBER: <font color = "red">
    <?php echo $_POST['App_Number']; ?></font> </p>
  <p>This Application Number will be used to identify your application. You will receive an email notification of this number once you submit this application form.&nbsp;  </p>
  <p align="center" class="randomnumbers" >
  
     <input name="App_Number" type="hidden" value = "<?php echo $_POST['App_Number']; ?>" >
	  <input name="username" type="hidden" value = "<?php echo $_SESSION['username']; ?>" >
</p>
  
  <p><strong>Title of project</strong>:
      <input type="text" name="ProjectTitle" value="<?php echo $_POST['ProjectTitle']; ?>" size="75">
</p>
  <p>Project type: </p>
  <blockquote> 
    <p> 
      <input type="radio" name="four_Project_Type" value="Academic/Class" <?php if($_POST['four_Project_Type']=="Academic/Class") echo "checked";?>>
      Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Funded Research" <?php if($_POST['four_Project_Type']=="Funded Research") echo "checked";?>>
      Funded Research<br>
      <input type="radio" name="four_Project_Type" value="Non-Funded Research" <?php if($_POST['four_Project_Type']=="Non-Funded Research") echo "checked";?>>
      Non-Funded Research <br>
      <input type="radio" name="four_Project_Type" value="Institutional/Admin" <?php if($_POST['four_Project_Type']=="Institutional/Admin") echo "checked";?>>
      Institutional/Admin.</p>
  </blockquote>
  <p>If Academic/Class, Course #: 
    <input type="text" name="Course_Number" value="<?php echo $_POST['Course_Number']; ?>">
  </p>
  <p> If funded research, complete name of funder: 
    <input type="text" name="Funder_Name_Other" value="<?php echo $_POST['Funder_Name_Other']; ?>">
  </p>  <?php
  if (strtoupper($_SESSION['User_Type']) == "STUDENT")
  {
  ?>
<p>If you are a student, please provide the following informaiton about the faculty member that you work with on this project: </p>
  <table width="690" border="0" align="center" bgcolor="#ccddcc">
    <tr>
      <td>Faculty First Name:        </td>
      <td><input name="FacultyFirstName" type="text" id="FacultyFirstName" value="<?php echo $_POST['FacultyFirstName']; ?>"></td>
      <td>Faculty Last Name:        </td>
      <td><input name="FacultyLastName" type="text" id="FacultyLastName" value="<?php echo $_POST['FacultyLastName']; ?>"></td>
    </tr>
    <tr>
      <td>Faculty Email Address:        </td>
      <td><input name="FacultyEmail" type="text" id="FacultyEmail" value="<?php echo $_POST['FacultyEmail']; ?>"></td>
      <td>Faculty Phone Number:        </td>
      <td><input name="FacultyPhone" type="text" id="FacultyPhone" value="<?php echo $_POST['FacultyPhone']; ?>"></td>
    </tr>
    <tr>
      <td colspan="4">Department/Office: 
        <input name="FacultyDepartment" type="text" id="FacultyDepartment" size="50" value="<?php echo $_POST['FacultyDepartment']; ?>"></td>
      </tr>
    <tr>
      
      <td colspan="4">Is the faculty member aware of the project? <b>
 
	   </td>
      </tr> <tr><td colspan="4">
        <input name="FacultyApproval" type="radio" value="Yes" <?php if($_POST['FacultyApproval']=="Yes") echo "checked";?>>
        Yes 
         <input name="FacultyApproval" type="radio" value="No" <?php if($_POST['FacultyApproval']=="No") echo "checked";?>>
        No</td>
      </tr>
  </table>
   <?php
  }
  ?>
  <p>You will be informed of the IRB's decision 
    via email. Do you require a signed hard copy of the IRB's decision for your 
    records? <br>
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
      <br>
Nursing home patients <br>
<input type="radio" name="two_Using_NursingHomePatients" value="Yes" <?php if($_POST['two_Using_NursingHomePatients']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_NursingHomePatients" value="No" <?php if($_POST['two_Using_NursingHomePatients']=="No") echo "checked";?>>
      No<br>
      <br>
Prisoners <br>
<input type="radio" name="two_Using_Prisoners" value="Yes" <?php if($_POST['two_Using_Prisoners']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_Prisoners" value="No" <?php if($_POST['two_Using_Prisoners']=="No") echo "checked";?>>
      No<br>
      <br>
Pregnant women or fetuses <br>
  <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="Yes" <?php if($_POST['two_Using_PregnantWomenOrFetuses']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="No" <?php if($_POST['two_Using_PregnantWomenOrFetuses']=="No") echo "checked";?>>
      No<br>
      <br>
Persons with a physical illness, injury , or disability <br>
<input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="Yes" <?php if($_POST['two_Using_PersonsWithIllnessInjoryOrDisability']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="No" <?php if($_POST['two_Using_PersonsWithIllnessInjoryOrDisability']=="No") echo "checked";?>>
      No<br>
      <br>
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
  <p>&nbsp;</p>
  <p><em>Benefit: A valued or desired outcome; an advantage.</em><b><br>
    </b>On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <input type="text" name="Benefit_Rating" size="2" maxlength="2" value="<?php echo $_POST['Benefit_Rating'];?>">
  </p>
  <p>&nbsp;</p>
  <p>In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.<br>
    <textarea name="Risk_Asses_Method_Expl" cols="75" rows="4"><?php echo $_POST['Risk_Asses_Method_Expl'];?></textarea>
  </p>
  <hr>
  <h5>SECTION 3:</h5>
  <p>Will you be using a Consent Form? <br>
  <input type="radio" name="two_Using_Informed_Consent_Document" value="Yes" <?php if($_POST['two_Using_Informed_Consent_Document']=="Yes") echo "checked";?> >
    Yes 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="No" <?php if($_POST['two_Using_Informed_Consent_Document']=="No") echo "checked";?>>
    No </p><blockquote> 
    <p>If &nbsp;you answered &#145;No&#148; above, please explain here:<br>
      <textarea name="rText_noInformedConsentExplanation" cols="70" rows="3"><?php echo $_POST['rText_noInformedConsentExplanation'];?></textarea>
    </p>
  </blockquote>
  <p><strong>Please Note: if you are using a Consent Form, it must include all the items listed in the <a href="http://www.osp.txstate.edu/irb/irb_checklist.php" target="_blank">Requirements Checklist for Consent Forms</a>. The checklist was attached to the email you received after registration. It can also be downloaded from the IRB Website. </strong></p>
  <p><strong>If your Consent Form does not include the items on the Checklist, your application will not be approved.</strong></p>
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
</tr></td></table>
<?php
