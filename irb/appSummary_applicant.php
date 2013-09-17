<?php require_once('Connections/dbc.php'); 
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

 
   $appNum = $_GET['appNum'];
   
 //echo "Appnum=".$appNum."<br>";
$sql = sprintf("SELECT * FROM application WHERE App_Number = '%s'", $appNum);
$app = mysql_query($sql, $con) or die(mysql_error());
$rs_app = mysql_fetch_assoc($app);
if($rs_app['username'] != $_SESSION['username']){
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


  <style type="text/css">
<!--
.style42 {color: #FFFFFF}
.style43 {font-size: large}
.style44 {font-weight: bold}
.style45 {font-weight: bold}
-->
  </style>
  <script>
  function confirmSubmission(i)
{

if (i==0) {
	if (confirm("You have not submitted any documentation. You must at least have a synopsis. Once you submit, you will not be able to make changes to your form or your uploaded documents, and your application will be forwarded for review. Are you sure you are ready to submit?")){
	document.form1.submit();
		}
	}
if (i>0) {
if(confirm("Once you submit, you will not be able to make changes to your form or your uploaded documents, and your application will be forwarded for review. Are you sure you are ready to submit?"))
document.form1.submit();
}
return false;
}


  function confirmRevSubmit()
{

if(confirm("Once you submit, you will not be able to make changes to your form or your uploaded documents, and your application will be forwarded for review. Are you sure you are ready to submit?")){

	document.form2.submit();
	}

	return false ;
}
 function returnHome()
 {
 location.href="<?php echo $_SESSION['myhome'];?>";
 }

function deleteConfirm(str, app)
{
if (confirm('Are you sure you want to remove this file from the application?')){
dirlocation="deleteAppFile_app.php?fn="+str+"&appNum="+app;
document.location.href=dirlocation;
}
}

</script>
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
	<span class="style42">|</span>  <a href="LogOut.php" class="irb">Log
        Out</a>
    <?php if ($rs_app['Status'] == "Approved") echo " <span class='style42'><br></span> <a class='irb' href='certificate.php?appNum=".$rs_app['App_Number']."'>Print Out Certificate</a>";?>
	  </div></td>
  </tr>
  <tr><td><div align="center">
  
      <br><strong>
      <?php echo $_SESSION['name'];?></strong></div></td>
  </tr><tr><td>
  
 <P><br>
    APPLICATION REFERENCE NUMBER: <?php echo($appNum); ?>
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
	<?php if ($rs_app['Status']=="Application in Process"){
	if ($i==0)
	echo "<p><font color='red'>You have not submitted any documentation. </font> At a minimum, your supporting documentation must include a Synopsis and if applicable, a Consent Form. In addition, other types of supporting documents include surveys or questionnaires, subject recruitment materials, approvals from other IRBs or from external sites, etc. 
<br>";
	?>
	<?php if ($i > 0){
?>
<p>If you believe that you have completed the  application form correctly and you are finished uploading all supporting  documents, click Submit Application button below.&nbsp; Once you click the Submit Application button,  you will not be able to make changes, and your application will be forwarded  for review.<p>
	<form name="form1" method="post" action="submissionFinished.php">
	
	<input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	    <input type="hidden" name="appsub" value="Application Submitted" id="appsub">
      <input type="submit" name="Submit" value="Submit Application and Return Home" onClick="return confirmSubmission(<?php echo $i;?>)"> 
	  <?php
		}
		?>
	  <input name="save" type="button" value="Save Application and Return Home" onClick="returnHome()">
    
      </label>
      </form>

		<?php 
			}
		?>
 <?php if (($rs_app['Status'] == "IRB Admin Requests Revision") || ($rs_app['Status'] == "IRB Chair Requests Revision")){
 if ($i==0)
	echo "<p><font color='red'>You have not submitted any documentation. You must at least have a synopsis. </font>";
   ?>
   <p>If you believe that you have completed the revision of your application and you have completed uploading all supporting documents requested, click &quot;Submit Revision&quot; button below. Your application will now be forwarded for review. 
   <p><form name="form2" method="post" action="revisionFinished.php"> 
	  <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	  <input type="hidden" name="appsub" value="Revision Submitted" id="appsub">
	  <input name="save" type="button" value="Save Application and Return Home" onClick="returnHome()">
      <input type="submit" name="Submit2" value="Submit Revision and Return Home" onClick="return confirmRevSubmit()">
   </form>
   <?php
	 }?>
		
	
    <hr>
  <span class="style41">  <b>Application status: </b><font color="#CC0000"><?php 
  if ($rs_app['Status'] == "Application Submitted to Reviewers for Review " || $rs_app['Status'] == "Application Submitted to IRB Chairs for Review ") 
  echo "Application in Review";
  
  else  
  echo $rs_app['Status']; ?></font></br>
  </span>
  <hr>
  <strong>SECTION 1 </strong>
<h5 >Title of project: 
  <?php echo $rs_app['ProjectTitle']; ?>  </h6>
  <p >Project type: <?php echo $rs_app['ProjectType']; ?>  </p>
  <blockquote ><span class="style41">If Academic/Class, Course #:</span> <b class="style44">  <?php echo $rs_app['CourseNumber']; ?></b> 
    <p class="style41">If funded research, name of funder:
           <b><span class="style44"> <?php echo $rs_app['FunderName']; ?></span></b>  </p>
  </blockquote>
  
  <p>If you are a student, please provide the following informaiton about the faculty member that you work with on this project: </p>
  <table width="690" border="0" align="center" bgcolor="#ccddcc">
    <tr>
      <td>Faculty First Name:        </td>
      <td><b><?php echo $rs_app['FacultyFirstName']; ?></b></td>
      <td>Faculty Last Name:        </td>
      <td><b><?php echo $rs_app['FacultyLastName']; ?></b></td>
    </tr>
    <tr>
      <td>Faculty Email Address:        </td>
      <td><b><?php echo $rs_app['FacultyEmail']; ?></b></td>
      <td>Faculty Phone Number:        </td>
      <td><b><?php echo $rs_app['FacultyPhone']; ?></b></td>
    </tr>
	   <tr>
      <td colspan="4">Department/Office: 
        <b><?php echo $rs_app['FacultyDepartment']; ?></b></td>
      </tr>
    <tr>
     
      <td colspan="4">Is the faculty member aware of the project? <b>
        <?php if($rs_app['FacultyApproval']=="Yes") echo "Yes";?>
       <?php if($rs_app['FacultyApproval']=="No") echo "No";?></b></td>
      
      </tr>
  </table>
  
  <p class="style41">Do you require a signed hard copy of the IRB's decision? <span class="style44"><?php echo $rs_app['SignedHardCopy']; ?>  </span>
  <hr>
  <strong>SECTION 2</strong>
<p class="style41">Does the project involve the use of the following 
    as research subjects:</p>
  <blockquote class="style41"> 
    <p class="style41"> Children under the age of 18:    <span class="style44">  <?php echo $rs_app['ChildrenUnder18']; ?></span>
     <p class="style41"> Nursing home patients: <span class="style44"> <?php echo $rs_app['NursingHomePatients']; ?> </span>      
       <p>Prisoners: <span class="style44">
     <?php echo $rs_app['Prisoner']; ?></span>
      <p>Pregnant women or fetuses: 
      <span class="style44"><?php echo $rs_app['PregnantWomenOrFetuses']; ?></span>
      <p>Persons with a physical illness, injury , or disability
        <span class="style44"><?php echo $rs_app['IllnessInjoryOrDisability']; ?></span>
      <p>Mentally or psychologically impaired persons 
      <span class="style44"><?php echo $rs_app['MentallyOrPsychologicallyImpaired']; ?> </span>   </p>
  </blockquote>
  <p class="style41">Are you offering any incentives to subjects in return for participation?    <span class="style44"><?php echo $rs_app['IncentiveForParticipation']; ?></span>
  <p> Will you be asking subjects to provide:</p>
  <blockquote class="style41"> 
     
      
      Name? <span class="style44"><?php echo $rs_app['RequestName']; ?> </span><br>
      <br>
     
      Social Security #? <span class="style44"><?php echo $rs_app['RequestSSN']; ?> </span><br>
      <br>
      
      Phone #? <span class="style44"><?php echo $rs_app['RequestPhoneNum']; ?></span><br>
      <br>
      
      Address? <span class="style44"><?php echo $rs_app['RequestAddress']; ?></span><br>
      <br>
      
      Medical/health info? <span class="style44"><?php echo $rs_app['RequestMedicalInfo']; ?></span><br>
      <br>
     I will NOT be asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info: <span class="style44"><?php echo $rs_app['RequestNone']; ?></span><br>
    </p>
  </blockquote>
  <p class="style41"> <em>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study.</em><br>
    On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, overall risk to subjects in your project. 
    <span class="style44"><?php echo $rs_app['RiskRating']; ?> </span> </p>
 
  <p class="style41"><em>Benefit: A valued or desired outcome; an advantage.</em><b><br>
    </b> On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <span class="style44"><?php echo $rs_app['BenefitRating']; ?> </span> </p>
 
  <p class="style41">In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.
  <blockquote>
    <p>
      <span class="style44"><?php echo $rs_app['RiskAssesMethod']; ?> </span> </p>
  </blockquote>
  <hr>
  <strong>SECTION 3:</strong>
<p class="style41">Will you be using a Consent Form?<strong>   <?php echo $rs_app['InformedConsentDoc']; ?></strong></p>
  <blockquote class="style41"> 
    <p>If &nbsp;you answered &#145;no&#148; above, please explain here:<br>
   <span class="style44">   <?php echo $rs_app['NoInformedConsentExp']; ?> </span>   </p>
  </blockquote>
  <p><strong>Please Note: if you are using a Consent Form, it must include all the items listed in the <a href="http://www.txstate.edu/research/orc/humans-in-research/checklist.html" target="_blank">Requirements Checklist for Consent Forms</a>. It can also be downloaded from the IRB Website. </strong></p>
  <p><strong>If your Consent Form does not include the items on the Checklist, your application will not be approved.</strong></p>
 <hr>
  
</blockquote>
  <table width="100%" border="0">
    <tr> 
      <td align="center"><strong class="style45">View/Download Project Documents</strong></td>
    </tr>
	<tr><td align="center">
	<?php

$path = "appdoc/".$appNum;
$dh = @ opendir($path);
$i=1;
$k=0;
while (($file = @ readdir($dh)) !== false) {
    if($file != "." && $file != "..") {
        echo "$i. <a href='$path/$file'>$file</a> ";
		
		if (($rs_app['Status'] == "Application in Process") || ($rs_app['Status'] == "IRB Admin Requests Revision") || ($rs_app['Status'] == "IRB Chair Requests Revision")){
		?>
				<input name='button' type='button' onClick="deleteConfirm('<?php echo $file;?>', '<?php echo $appNum; ?>')" value='Delete File'><br>
		<?php
		}
        $i++;
		$k=$k+1;
    }
}
@ closedir($dh);
if ($k==0)
echo "No Document uploaded";
?>
</td></tr>
  </table></td>
  </tr><tr><td><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>
</td>
  </tr></table> </td><tr></table>
</body>
</html>
<?php
mysql_free_result($app);
?>