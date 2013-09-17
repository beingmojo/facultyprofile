<?php require_once('Connections/con3.php'); 
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="irbstyle.css" rel="stylesheet" type="text/css">
</head>
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

 $appNum = $_GET['appNum'];
 ?>


	 <?php

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "IRBForm")) {
$updated="ok";
//form validation
$appNum = $_POST["appNum"];
$errmsg="";
  if(trim($_POST['ProjectTitle']) =="" )
   {
      $errmsg = $errmsg.'Please enter Project Title \n';
   } 
   if(trim($_POST['four_Project_Type']) =="" )
   {
      $errmsg = $errmsg. 'Project Type is required \n';
	
	  
   } 
   if(trim($_POST['four_Project_Type']) =="Academic/Class" ){
      if(trim($_POST['Course_Number']) =="" )
   {
      $errmsg = $errmsg.'Please enter course number\n';
	     } 
	}
   
     if(trim($_POST['four_Project_Type']) !="Academic/Class" ){
      if(trim($_POST['Course_Number']) !="" )
   {
      $errmsg = $errmsg.'Course number cannot be entered\n';
	     } 
	}
   
     if(trim($_POST['four_Project_Type']) =="Funded Research" ){
      if(trim($_POST['Funder_Name_Other']) =="" )
   {
      $errmsg = $errmsg.'Please enter the name of the funder\n';
	     } 
	}
	
	    if(trim($_POST['four_Project_Type']) !="Funded Research" ){
      if(trim($_POST['Funder_Name_Other']) !="" )
   {
      $errmsg = $errmsg.'The name of the funder is not required \n';
	     } 
	}
	
   
      if(trim($_POST['ProjectTitle']) =="" )
   {
      $errmsg = $errmsg.'Please enter Project Title\n';
	     } 

      if(trim($_POST['two_Signed_Hard_Copy_Required']) =="" )
   {
      $errmsg = $errmsg.'Signed Hard Copy field field needs to be checked\n';
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
      $errmsg = $errmsg.'Using Persons With Illness Injury Or Disability field needs to be checked.<br>';
   }
      if(trim($_POST['two_Using_MentallyOrPsychologicallyImpairedPersons']) =="" )
   {
      $errmsg = $errmsg.'Using Mentally Or Psychologically Impaired Persons field needs to be checked.<br>';
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
      $errmsg = $errmsg.'Will you be using a Consent Form?  You must answer YES or NO.\n';
   }

if(trim($_POST['two_Using_Informed_Consent_Document']) =="No" ){
	if(trim($_POST['rText_noInformedConsentExplanation']) =="" )
		{$errmsg = $errmsg.'You indicated you would not be using a Consent Form. You must explain why.\n';}

	}




if (strlen($errmsg)>1) {

$updated="notok";
?>
<script language="JavaScript">
alert("<?php echo $errmsg;?>");
</script>
<?php
}

else{
  $updateSQL = sprintf("UPDATE application SET ProjectTitle=%s, ProjectType=%s, CourseNumber=%s, FunderName=%s, SignedHardCopy=%s, ChildrenUnder18=%s, NursingHomePatients=%s, Prisoner=%s, PregnantWomenOrFetuses=%s, IllnessInjoryOrDisability=%s, MentallyOrPsychologicallyImpaired=%s, IncentiveForParticipation=%s, RequestName=%s, RequestSSN=%s, RequestPhoneNum=%s, RequestAddress=%s, RequestMedicalInfo=%s, RequestNone=%s, RiskRating=%s, BenefitRating=%s, RiskAssesMethod=%s, InformedConsentDoc=%s, NoInformedConsentExp=%s WHERE App_Number=%s",
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
         GetSQLValueString($_POST['requestingAddress'], "text"),
      GetSQLValueString($_POST['requestingMedicalInfo'], "text"),
             GetSQLValueString($_POST['requestingNone'], "text"),
                       GetSQLValueString($_POST['Risk_Rating'], "text"),
                       GetSQLValueString($_POST['Benefit_Rating'], "text"),
                       GetSQLValueString($_POST['Risk_Asses_Method_Expl'], "text"),
                       GetSQLValueString($_POST['two_Using_Informed_Consent_Document'], "text"),
                       GetSQLValueString($_POST['rText_noInformedConsentExplanation'], "text"),
                      
                       GetSQLValueString($_POST['appNum'], "text"));

  mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($updateSQL, $con3) or die(mysql_error());
 //  header("Location: ". "applicant_home.php"); 
}
 //echo "Application updated.";
 }
?>
 

<?php
$appNum= $_GET['appNum'];
$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

 mysql_select_db($database_con3, $con3);
 $sql = sprintf("SELECT * FROM application WHERE App_Number = '%s'", $appNum);
$app = mysql_query($sql, $con3) or die(mysql_error());
$rs_app = mysql_fetch_assoc($app);
$totalRows = mysql_num_rows($app);


?>



  <style type="text/css">
<!--
.style42 {color: #FFFFFF}
.style43 {font-size: large}
-->
  </style>
  <script>
 function confirmSubmission(i)
{

if (i==0) {
	if (confirm("You have not submitted any documentation. You must at least have a synopsis. Once you submit, you will not be able to make changes to your form or your uploaded documents, and your application will be forwarded for review. Are you sure you are ready to submit?")){
	document.form2.submit();
		}
	}
if (i>0) {
if(confirm("Once you submit, you will not be able to make changes to your form or your uploaded documents, and your application will be forwarded for review. Are you sure you are ready to submit?"))
document.form2.submit();
}
return false;
}



  function confirmRevSubmit()
{

if(confirm("Once you submit, you will not be able to make changes to your form or your uploaded documents, and your application will be forwarded for review. Are you sure you are ready to submit?")){

	document.form3.submit();
	}

	return false ;
}
 function returnHome()
 {
 location.href="<?php echo $_SESSION['myhome'];?>";
 }

</script>


<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left" class="style6 style24"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
            </p>
            </span></td>
   </tr>
          
       
        </tbody>
      </table>
      </td>
  </tr>
</tbody></table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td bgcolor="#000000"><div align="center"><a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42">|</span> <a class="irb" href="statSummary_app.php?appNum=<?php echo $rs_app['App_Number']?>">Application Status</a> <span class="style42">|</span> <a class="irb" href="appSummary_applicant.php?appNum=<?php echo $rs_app['App_Number'];?>">Review Application Data</a><?php 
	if (($rs_app['Status'] == "Application in Process") || ($rs_app['Status'] == "IRB Admin Requests Revision") || ($rs_app['Status'] == "IRB Chair Requests Revision"))
	echo " <span class='style42'>|</span> <a class='irb' href='appUpdate_applicant.php?appNum=".$rs_app['App_Number']."'>Update Application Form</a>"; ?>
	
 <?php 
if (($rs_app['Status'] == "Application in Process") || ($rs_app['Status'] == "IRB Admin Requests Revision") || ($rs_app['Status'] == "IRB Chair Requests Revision"))
	echo " <span class='style42'>|</span> <a class='irb' href='uploader.php?appNum=".$rs_app['App_Number']."'>Upload Documents</a>";
	
	?>

    <?php if ($rs_app['Status'] == "Approved"){
	echo " <span class='style42'>|</span> <a class='irb' href='continuation/irb_continuation_change_form.php?appNum=".$rs_app['App_Number']."'>Apply for Continuation/Change</a>"; }?>
	
    <?php if ($rs_app['Status'] == "Approved") echo " <span class='style42'>|</span> <a class='irb' href='certificate.php?appNum=".$rs_app['App_Number']."'>Print Out Certificate</a>";?>
	  <span class="style42">|</span>  <a href="LogOut.php" class="irb">Log
        Out</a></div></td>
  </tr></table><tr><td><table width="800" height="300" border="0"  cellpadding="6" align="center" bgcolor="#ffffff">
  <tr><td><div align="center">
  
      <br><strong>
      <?php echo $_SESSION['name'];?></strong></div></td>
  </tr>
  <?php
if (($rs_app['Status'] == "Application in Process") || ($rs_app['Status'] == "IRB Admin Requests Revision") || ($rs_app['Status'] == "IRB Chair Requests Revision")) {  

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "IRBForm") && ($updated=="ok")) {

echo "<tr><td><font color='red'>Application form updated. </font>";
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "IRBForm") && ($updated!="ok")) {

echo "<tr><td><font color='red'>Application form NOT updated. </font>";
}
?>

   <tr><td> <p>
   <?php if ($rs_app['Status'] == "Application in Process") {
	
   ?>
<p>If you believe that you have completed the  application form correctly and you are finished uploading all supporting  documents, click Submit Application button below. Once you click the Submit Application button, you will not be able to make changes, and your application will be forwarded for review.<p>
<?php
$directory = "appdoc/".$appNum;

$i=0;
if (!is_dir($directory)){
//echo "No file uploaded.";
}
else
{
$dh = @ opendir($directory);

while (($file = @ readdir($dh)) !== false) {
    if($file != "." && $file != "..") {
        
        $i++;
    }
	}
@ closedir($dh);
}
?>

     <label><form method="post" action="submissionFinished.php" name="form2" id="form2">
	 <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	  <input type="hidden" name="appsub" value="Application Submitted" id="appsub">
	  <input name="save" type="button" value="Save Application and Return Home" onClick="returnHome()">
     <input type="submit" name="Submit2" value="Submit Application and Return Home" onclick="return confirmSubmission(<?php echo $i;?>)"></form>
     </label>
   </p>
    <?php
	 }?>
   <?php if (($rs_app['Status'] == "IRB Admin Requests Revision") || ($rs_app['Status'] == "IRB Chair Requests Revision")){
  
   ?>
<p>If you believe that you have completed the  application form correctly and you are finished uploading all supporting  documents, click Submit Revision button below.&nbsp; Once you click the Submit Revision button,  you will not be able to make changes, and your application will be forwarded for review.<p>
   <form method="post" action="revisionFinished.php" name="form3" id="form3">
	 <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	  <input type="hidden" name="appsub" value="Revision Submitted" id="appsub">
	  <input name="save" type="button" value="Save Application and Return Home" onClick="returnHome()">
     <input type="submit" name="Submit2" value="Submit Revision and Return Home" onClick="return confirmRevSubmit()"></form>
	 <?php
	 }


?>

     </label></p><hr>
     <p align="center"><strong>Update Application Form </strong></p>
     <p>This is an ELECTRONIC submission form. Applications must be submitted electronically. Printed IRB applications will not be accepted. If you experience difficulty with the form, try quitting your browser application and starting over. Contact OSP at 245-2102 if you require assistance. 
       </p>
          </p>
     <p>Also note that the information you enter here will be used AS IS to print your hard copy IRB approval certificate. If you do not use proper spelling and/or capitalization for your name, your faculty member's name and the title of your project, it will show up that way on your approval certificate. <br>
</p>

<form name="IRBForm" ENCTYPE="multipart/form-data" method="POST" action = "<?php echo $editFormAction; ?>" >

  <h5>SECTION 1: </h5>
  <p>This is your APPLICATION REFERENCE NUMBER: <font color = "red"><?php echo $appNum; ?></font>  
    <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" size="75">
  </p>
</p>
  <p>NOTE:&nbsp; If you have not taken a Human Subjects Protection Training, you must complete the CITI Course before your application can be processed. </p>
  <p><strong>Title of project:</strong>
    <input type="text" name="ProjectTitle" value="<?php echo $rs_app['ProjectTitle']; ?>" size="75">
</p>
  <p> Project type: </p>
  <blockquote> 
    <p> 
      <input  type="radio" name="four_Project_Type" value="Academic/Class" <?php if (strcmp($rs_app['ProjectType'],"Academic/Class")==0) {echo "checked";} ?>>
      Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Funded Research" <?php if (strcmp($rs_app['ProjectType'],"Funded Research")==0) {echo "checked";} ?>>
      Funded Research<br>
      <input type="radio" name="four_Project_Type" value="Non-Funded Research" <?php if (strcmp($rs_app['ProjectType'],"Non-Funded Research")==0) {echo "checked";} ?> >
      Non-Funded Research <br>
    <input type="radio" name="four_Project_Type" value="Institutional/Admin" <?php if($_POST['four_Project_Type']=="Institutional/Admin") echo "checked";?>>
      Institutional/Admin.</p>
  </blockquote>
  <p>&nbsp;</p>
  <p>If Academic/Class, Course #: 
    <input type="text" name="Course_Number" value="<?php echo $rs_app['CourseNumber']; ?>" >
  </p>

  <p>If funded research, complete name of funder: 
    <input type="text" name="Funder_Name_Other" value="<?php echo $rs_app['FunderName']; ?>">
  </p>

  
  <p>&nbsp;</p>
  <p>You will be informed of the IRB's decision 
    via email. Do you require a signed hard copy of the IRB's decision for your 
    records? 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="Yes" <?php if (strcmp($rs_app['SignedHardCopy'],"Yes")==0) {echo "checked";} ?>>
    Yes 
    <input type="radio" name="two_Signed_Hard_Copy_Required" value="No" <?php if (strcmp($rs_app['SignedHardCopy'],"No")==0) {echo "checked";} ?>>
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
    <p> Children under the age of 18 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="Yes" <?php if (strcmp($rs_app['ChildrenUnder18'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_ChildrenUnderEighteen" value="No" <?php if (strcmp($rs_app['ChildrenUnder18'],"No")==0) {echo "checked";} ?>>
      No<br>
      Nursing home patients 
      <input type="radio" name="two_Using_NursingHomePatients" value="Yes" <?php if (strcmp($rs_app['NursingHomePatients'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_NursingHomePatients" value="No" <?php if (strcmp($rs_app['NursingHomePatients'],"No")==0) {echo "checked";} ?>>
      No<br>
      Prisoners 
      <input type="radio" name="two_Using_Prisoners" value="Yes" <?php if (strcmp($rs_app['Prisoner'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_Prisoners" value="No" <?php if (strcmp($rs_app['Prisoner'],"No")==0) {echo "checked";} ?>>
      No<br>
      Pregnant women or fetuses 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="Yes" <?php if (strcmp($rs_app['PregnantWomenOrFetuses'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="No" <?php if (strcmp($rs_app['PregnantWomenOrFetuses'],"No")==0) {echo "checked";} ?>>
      No<br>
      Persons with a physical illness, injury , or disability 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="Yes" <?php if (strcmp($rs_app['IllnessInjoryOrDisability'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="No" <?php if (strcmp($rs_app['IllnessInjoryOrDisability'],"No")==0) {echo "checked";} ?>>
      No<br>
      Mentally or psychologically impaired persons 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="Yes" <?php if (strcmp($rs_app['MentallyOrPsychologicallyImpaired'],"Yes")==0) {echo "checked";} ?>>
      Yes 
      <input type="radio" name="two_Using_MentallyOrPsychologicallyImpairedPersons" value="No" <?php if (strcmp($rs_app['MentallyOrPsychologicallyImpaired'],"No")==0) {echo "checked";} ?>>
      No<br>
    </p>
  </blockquote>
  <p>Are you offering any incentives to subjects 
    in return for participation? 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="Yes" <?php if (strcmp($rs_app['IncentiveForParticipation'],"Yes")==0) {echo "checked";} ?>>
    Yes 
    <input type="radio" name="two_Using_Incentives_For_Participation" value="No" <?php if (strcmp($rs_app['IncentiveForParticipation'],"No")==0) {echo "checked";} ?>>
  No</p>
  <p>Will you be asking subjects to provide:</p>
  <blockquote> 
    <p> 
      <input type="checkbox" name="requestingName" value="Yes" <?php if (strcmp($rs_app['RequestName'],"Yes")==0) {echo "checked";} ?>>
      Name<br>
      <input type="checkbox" name="requestingSSN" value="Yes" <?php if (strcmp($rs_app['RequestSSN'],"Yes")==0) {echo "checked";} ?>>
      Social Security #<br>
      <input type="checkbox" name="requestingPhoneNum" value="Yes" <?php if (strcmp($rs_app['RequestPhoneNum'],"Yes")==0) {echo "checked";} ?>>
      Phone #<br>
      <input type="checkbox" name="requestingAddress" value="Yes" <?php if (strcmp($rs_app['RequestAddress'],"Yes")==0) {echo "checked";} ?>>
      Address<br>
      <input type="checkbox" name="requestingMedicalInfo" value="Yes" <?php if (strcmp($rs_app['RequestMedicalInfo'],"Yes")==0) {echo "checked";} ?>>
      Medical/health info<br>
      <input type="checkbox" name="requestingNone" value="Yes" <?php if (strcmp($rs_app['RequestNone'],"Yes")==0) {echo "checked";} ?>>
      I will NOT be asking subjects to provide their Name, Social Security #, 
      Phone #, Address, or Medical/health info<br>
    </p>
  </blockquote>
  <p> <em>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study.</em><br>
    On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, rate the overall risk to subjects in your project. 
    <input type="text" name="Risk_Rating" maxlength="2" size="2" value="<?php echo $rs_app['RiskRating']; ?>">
  </p>
 
  <p><em>Benefit: A valued or desired outcome; an advantage.</em><b><br>
    </b>On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <input type="text" name="Benefit_Rating" size="2" maxlength="2" value="<?php echo $rs_app['BenefitRating']; ?>">
  </p>

  <p>In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.<br>
    <textarea name="Risk_Asses_Method_Expl" cols="70" rows="4"><?php echo $rs_app['RiskAssesMethod']; ?></textarea>
  </p>
  <hr>
  <h5>SECTION 3:</h5>
  <p>Will you be using a Consent Form? 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="Yes" <?php if (strcmp($rs_app['InformedConsentDoc'],"Yes")==0) {echo "checked";} ?> >
    Yes 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="No" <?php if (strcmp($rs_app['InformedConsentDoc'],"No")==0) {echo "checked";} ?>>
  No </p>
  <blockquote> 
    <p>If &nbsp;you answered &#145;No&#148; above, please explain here:<br>
      <textarea name="rText_noInformedConsentExplanation" cols="70" rows="4"><?php echo $rs_app['NoInformedConsentExp']; ?></textarea>
    </p>
  </blockquote>
 
</td></tr><tr><td>
  <table width="100%" border="0">
    <tr> 
      <td align="center"> 
        <input type="submit" name="SubmitForm" value="Update Application Form">
    
      
        <input type="reset" name="ResetForm" value="Clear Form" >
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="IRBForm">
</form></td></tr><tr><td>
  <div align="center" class="style48">
  <?php
  
  
}
else
die("<tr><td><font color='red'>You cannot update your application at this moment.</font></td></tr>");
?>
  <?php
//mysql_free_result($Recordset1);


//
mysql_free_result($app);
?>
</td></tr><tr><td><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>
</td></tr></table>