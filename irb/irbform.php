<?php require_once('Connections/con3.php');
session_start();
require_once('variables/variables.php');
	
$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


$editFormAction = $_SERVER['PHP_SELF'];
$appNumber = mt_rand(0000, 10000);
 
$appNumber = chr(rand(65,90)).$appNumber;
$appNumber= date("Y").$appNumber;
$_SESSION['appNum']=$appNumber;
//echo("random number is ".$appNumber);
?>

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "IRBForm")) {

 $theValue = (!get_magic_quotes_gpc()) ? addslashes($_SESSION['username']) : $_SESSION['username'];

mysql_select_db($database_con3, $con3);


$errmsg = "";
   
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
      $errmsg = $errmsg.'Please enter course number \n';
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
      $errmsg = $errmsg.'Please enter the name of the funder \n';
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
      $errmsg = $errmsg.'Please enter Project Title \n';
	     } 

      if(trim($_POST['two_Signed_Hard_Copy_Required']) =="" )
   {
      $errmsg = $errmsg.'Signed Hard Copy field field needs to be checked \n';
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
      $errmsg = $errmsg.'Using Persons With Illness Injury Or Disability field needs to be checked.\n';
   }
      if(trim($_POST['two_Using_MentallyOrPsychologicallyImpairedPersons']) =="" )
   {
      $errmsg = $errmsg.'Using Mentally Or Psychologically Impaired Persons field needs to be checked.\n';
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
//user is a student
if (strtoupper($_SESSION['User_Type']) == "STUDENT")
	{
          
	if(trim($_POST['FacultyFirstName']) =="" )
		{$errmsg = $errmsg.'You need to provide the first name of the faculty member that has approved your project.\n';
		}
		
			if(trim($_POST['FacultyLastName']) =="" )
		{$errmsg = $errmsg.'You need to provide the last name of the faculty member that has approved your project.\n';
		}
			if(trim($_POST['FacultyPhone']) =="" )
		{$errmsg = $errmsg.'You need to provide the phone number of the faculty member that has approved your project.\n';
		}
			if(trim($_POST['FacultyEmail']) =="" )
		{$errmsg = $errmsg.'You need to provide the email address of the faculty member that has approved your project.\n';
		}
			if(trim($_POST['FacultyDepartment']) =="" )
		{$errmsg = $errmsg.'You need to provide the department name of the faculty member that has approved your project.\n';
		}
			if(trim($_POST['FacultyApproval']) =="" )
			{
			$errmsg = $errmsg.'Please check whether the faculty member has approved your project or not.\n';
			}
	} //if student


 
if (strlen($errmsg)>1) {

//echo "<font color='red'>Following errors occured:</font><br>".$errmsg;
?>

<?php
include "irbform_back.php";
?>
<script language="JavaScript">
alert("<?php echo $errmsg;?>");
</script>
<?php
}
else{
$status = "Application in Process";
$appNum= $_POST['App_Number'];
$insertSQL = sprintf("INSERT INTO application (App_Number, username, ProjectTitle, ProjectType, CourseNumber, FunderName, SignedHardCopy, ChildrenUnder18, NursingHomePatients, Prisoner, PregnantWomenOrFetuses, IllnessInjoryOrDisability, MentallyOrPsychologicallyImpaired, IncentiveForParticipation, RequestName, RequestSSN, RequestPhoneNum, RequestAddress, RequestMedicalInfo, RequestNone, RiskRating, BenefitRating, RiskAssesMethod, InformedConsentDoc, NoInformedConsentExp,FacultyFirstName, FacultyLastName, FacultyPhone, FacultyEmail,FacultyDepartment, FacultyApproval,Status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['App_Number'], "text"),
                       GetSQLValueString($_SESSION['username'], "text"),
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
                       GetSQLValueString($_POST['requestingAddress'],"text"),
                       GetSQLValueString($_POST['requestingMedicalInfo'], "text"),
                       GetSQLValueString($_POST['requestingNone'], "text"),
                       GetSQLValueString($_POST['Risk_Rating'], "text"),
                       GetSQLValueString($_POST['Benefit_Rating'], "text"),
                       GetSQLValueString($_POST['Risk_Asses_Method_Expl'], "text"),
                       GetSQLValueString($_POST['two_Using_Informed_Consent_Document'], "text"),
                       GetSQLValueString($_POST['rText_noInformedConsentExplanation'], "text"),


                       GetSQLValueString($_POST['FacultyFirstName'], "text"),
                       GetSQLValueString($_POST['FacultyLastName'], "text"),
                       GetSQLValueString($_POST['FacultyPhone'], "text"),
                       GetSQLValueString($_POST['FacultyEmail'], "text"),
                       GetSQLValueString($_POST['FacultyDepartment'], "text"),
                       GetSQLValueString($_POST['FacultyApproval'], "text"),

					      GetSQLValueString($status, "text"));

  mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($insertSQL, $con3) or die(mysql_error());
   
	$to = $_SESSION['Email'];
//	$from = "From: ospinfo@txstate.edu";



	$body = "DO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\rYou have started an IRB Application. Application number: ".$_POST['App_Number'].".";
 $body = $body."\rEvery IRB application must contain a synopsis document that summarizes the project being reviewed. If you do not include one, your application will not be processed.\r\rIf you are using a consent form in your project, it must include all of the items listed in the Consent Form Checklist. If it does not, the IRB reviewers may require revisions, which could delay processing of your application.\r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";



$body = $body.$emailSig;
	$subject = "Confirmation: IRB Application ".$_POST['App_Number']." initiated. DO NOT REPLY to this message.";

	mail($to,$subject,$body, $headers);
	
	//copy to faculty member
	$subject = "Confirmation: Student IRB Application ".$_POST['App_Number']." initiated. DO NOT REPLY to this message.";
	$body = "DO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\r".$_SESSION['name']." have started an IRB Application. Application number: ".$_POST['App_Number'].". You will receive copies of email messages that are sent from IRB to the applicant. ";
 $body = $body."\r\rEvery IRB application must contain a synopsis document that summarizes the project being reviewed. If the applicant does not include one, the application will not be processed.\r\rIf a consent form is used in your project, it must include all of the items listed in the Consent Form Checklist. If it does not, the IRB reviewers may require revisions, which could delay processing of your application.\r\rIf you have questions, please submit an IRB Inquiry form at: \rhttp://www.txstate.edu/research/irb/irb_inquiry.html\r\n";



$body = $body.$emailSig;
	$to=$_POST['FacultyEmail']."@txstate.edu";
	mail($to,$subject,$body, $headers);
//	$goto="uploader.php";
 //header("Location: ". $goto);
 //exit;
  //echo "<br><a href='applicant_home.php'>Back to Application Home</a><br>";
  
  ?>
   
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>

<script language="JavaScript">
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



 function returnHome()
 {
 location.href="<?php echo $_SESSION['myhome'];?>";
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
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
            </p>
            </span></td>
 
  </tr>
</tbody></table> 
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff" table>
  <tr>
    <td bgcolor="#000000"><div align="center">
      <span class="style33"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a>
      </strong></div></td>
  </tr><tr>
    <td>
      <p align="center"><strong><br></strong><strong><?php echo $_SESSION['name'];?></strong>
	<hr>IRB Application Number: <?php echo $appNum; ?>
  
<p>
<strong>Upload Supporting Document(s) (</strong><span class="style44">Maximum allowed file size: 2M</span><strong>)</strong>
  <p>At a minimum, your supporting documentation must include a Synopsis and if applicable, a Consent Form.  

In addition, other types of supporting documents include surveys or questionnaires, subject recruitment materials, approvals from other IRBs or from external sites, etc. 
<p>
 <form action="uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input type="hidden" name="fileUp" value="Yes" id="fileUp">
<input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">

  <label> Upload File: <br /> 
  <input type="file" name="file" /> 
  </label>
   
     <input type="submit" name="Submit" value="Upload File" />
     </p>
   <p>*You will have to browse and upload one document  at a time.
   </p>
 </form><!--
   <hr>If you believe that you have completed the  application form correctly and you are finished uploading all supporting  documents, click Submit Application button below.&nbsp; Once you click the Submit Application button,  you will not be able to make changes, and your application will be forwarded  for review.
   <p>If you are not yet finished with your form or  uploading your documents but want to exit, click on the Save Application and Return Home button  below. This will allow you to return to your application later.
   </p>-->
   
   <?php
 
$directory = "appdoc/".$appNum;

$i=0;
if (!is_dir($directory))
{
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
<!--
   <form name ="form2" id="form2" method="post" action="submissionFinished.php">
	  <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
<input name="save" type="button" value="Save Application and Return Home" onClick="returnHome()">
	    <input type="hidden" name="appsub" value="Application Submitted" id="appsub" >
	  <input type="submit" name="Submit2" value="Submit Application and Return Home" onclick="return confirmSubmission(<?php echo $i;?>)"/>
   
   </form>
   -->
 
</td></tr></table><tr><td>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>
<?php
	}//end else
}
else{
?>

  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>


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
      <span class="style33"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a>
      </strong></div></td>
  </tr><tr>
    <td>
      <p align="center"><strong><br></strong><strong><?php echo $_SESSION['name'];?></strong>
      <h4 align="center"><strong>  IRB APPLICATION FORM</strong></h4>
<p>This is an ELECTRONIC submission form. Applications must be submitted electronically. Printed IRB applications will not be accepted. If you experience difficulty with the form, try quitting your browser application and starting over. Use the <a href="http://www.osp.txstate.edu/irb/irb_inquiry.html" target="_blank">IRB INQUIRY REQUEST FORM</a> on the IRB website or  contact IRB administration at 512 245-2314 if you require assistance.</p>

<p>Also note that the information you enter here will be used AS IS to generate your electronic IRB approval certificate online. If you do not use proper spelling and/or capitalization for your name and the title of your project, it will show up that way on your approval certificate. <br>
</p>
<form name="IRBForm" method="POST" action = "<?php echo $_SERVER['PHP_SELF']; ?>"  >
 
  
  <h5>SECTION 1: </h5>
  <p>This is your application REFERENCE NUMBER:<span class="style44"> <font color="red">
    <?php echo $appNumber; ?></font> </span></p>
  <p>This Application Number will be used to identify your application. You will receive an email notification of this number once you submit this application form.&nbsp;  </p>
  <p align="center" class="randomnumbers" >
  
     <input name="App_Number" type="hidden" value = "<?php echo $appNumber; ?>" >
	  <input name="username" type="hidden" value = "<?php echo $_SESSION['username']; ?>" >
</p>
  
  <h5>Title of project:
      <input type="text" name="ProjectTitle" value="<?php echo $_POST['ProjectTitle']; ?>" size="75">
</h5>
  <p>Project type: </p>
  <blockquote> 
    <p> 
      <input type="radio" name="four_Project_Type" value="Academic/Class" <?php if($_POST['four_Project_Type']=="Academic/Class") echo "checked";?>>
      Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Funded Research" <?php if($_POST['four_Project_Type']=="Funded Research") echo "checked";?>>
      Funded Research<br>
      <input type="radio" name="four_Project_Type" value="Non-Funded Research" <?php if($_POST['four_Project_Type']=="Non-Funded Research") echo "checked";?>>
      Non-Funded Research and Non-Academic/Class <br>
      <input type="radio" name="four_Project_Type" value="Institutional/Admin" <?php if($_POST['four_Project_Type']=="Institutional/Admin") echo "checked";?>>
      Institutional/Admin.</p>
  </blockquote>
  <p>If Academic/Class, Course #: 
    <input type="text" name="Course_Number" value="<?php echo $_POST['Course_Number']; ?>">
  </p>
  <p> If funded research, complete name of funder: 
    <input type="text" name="Funder_Name_Other" value="<?php echo $_POST['Funder_Name_Other']; ?>">
  </p>
  <?php
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
      <td>Faculty Texas Sate NetID:        </td>
      <td><input name="FacultyEmail" type="text" id="FacultyEmail" value="<?php echo $_POST['FacultyEmail']; ?>"></td>
      <td>Faculty Phone Number:        </td>
      <td><input name="FacultyPhone" type="text" id="FacultyPhone" value="<?php echo $_POST['FacultyPhone']; ?>"></td>
    </tr>
    <tr>
      <td colspan="4">Department/Office: 
        <input name="FacultyDepartment" type="text" id="FacultyDepartment" size="50" value="<?php echo $_POST['FacultyDepartment']; ?>"></td>
      </tr>
    <tr>
    
      <td colspan="4">Is the faculty member aware of the project?     
       </td>
      </tr> 
	  <tr><td colspan="4">
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
    records? 
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
Nursing home patients <br>
<input type="radio" name="two_Using_NursingHomePatients" value="Yes" <?php if($_POST['two_Using_NursingHomePatients']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_NursingHomePatients" value="No" <?php if($_POST['two_Using_NursingHomePatients']=="No") echo "checked";?>>
      No<br>
Prisoners <br>
<input type="radio" name="two_Using_Prisoners" value="Yes" <?php if($_POST['two_Using_Prisoners']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_Prisoners" value="No" <?php if($_POST['two_Using_Prisoners']=="No") echo "checked";?>>
      No<br>
Pregnant women or fetuses <br>
  <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="Yes" <?php if($_POST['two_Using_PregnantWomenOrFetuses']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_PregnantWomenOrFetuses" value="No" <?php if($_POST['two_Using_PregnantWomenOrFetuses']=="No") echo "checked";?>>
      No<br>
Persons with a physical illness, injury , or disability <br>
<input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="Yes" <?php if($_POST['two_Using_PersonsWithIllnessInjoryOrDisability']=="Yes") echo "checked";?>>
      Yes 
      <input type="radio" name="two_Using_PersonsWithIllnessInjoryOrDisability" value="No" <?php if($_POST['two_Using_PersonsWithIllnessInjoryOrDisability']=="No") echo "checked";?>>
      No<br>
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
  <p><em>Benefit: A valued or desired outcome; an advantage.</em><b><br>
    </b>On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <input type="text" name="Benefit_Rating" size="2" maxlength="2" value="<?php echo $_POST['Benefit_Rating'];?>">
  </p>
  <p>In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.<br>
    <textarea name="Risk_Asses_Method_Expl" cols="75" rows="4"><?php echo $_POST['Risk_Asses_Method_Expl'];?></textarea>
  </p>
  <hr>
  <h5>SECTION 3:</h5>
  <p>Will you be using a Consent Form?<br>
  <input type="radio" name="two_Using_Informed_Consent_Document" value="Yes" <?php if($_POST['two_Using_Informed_Consent_Document']=="Yes") echo "checked";?> >
    Yes 
    <input type="radio" name="two_Using_Informed_Consent_Document" value="No" <?php if($_POST['two_Using_Informed_Consent_Document']=="No") echo "checked";?>>
    No </p>
  <blockquote> 
    <p>If &nbsp;you answered &#145;No&#148; above, please explain here:<br>
      <textarea name="rText_noInformedConsentExplanation" cols="70" rows="5"><?php echo $_POST['rText_noInformedConsentExplanation'];?></textarea>
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
  </table> <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>
  <input type="hidden" name="MM_insert" value="IRBForm">
</form>
<?php
}
?></tr></td></table>
</body>
</html>
