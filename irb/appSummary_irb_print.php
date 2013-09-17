<?php require_once('Connections/con3.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "IRB Staff")) {   
 
	if (!($_SESSION['User_Type'] == "IRB Chair")) {
   
 
  header("Location: ". $restrictGoTo); 
  exit;
  }
}
?>


<?php
$appNum = $_GET['appNum'];

//////////////////////////////////
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT * FROM application where App_Number='".$appNum."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>



  <style type="text/css">
<!--
.style43 {font-size: large}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>


      </td>
  </tr>

  <tr>
<td bgcolor="#FFFFFF">
<?php
   
   $applicant = $row_Recordset1['username'];
  mysql_select_db($database_con3, $con3);
  if (!get_magic_quotes_gpc()) {
$applicant = addslashes($applicant);
}
//$usercheck = $_POST['username'];
//$sql="SELECT username FROM user WHERE username = '".$usercheck."'";
   $sql2 = sprintf("SELECT * FROM user WHERE username = '%s'", $applicant);
$appUser = mysql_query($sql2, $con3) or die(mysql_error());
$rs_User = mysql_fetch_assoc($appUser);
?>

<div align="center" class="style3"><br><br>
  APPLICATION DATA</div>
</td></tr><TD><TABLE cellpadding="10"><tr><td>
  <span class="style48"><p>APPLICATION REFERENCE NUMBER:</span> <font color = "red"><?php echo($appNum) ?></font>
    
  <h5 class="style49"><strong>APPLICANT INFORMATION </strong></h5>
  <blockquote class="style47">    Name:<span class="style41"> <u><?php echo $rs_User['FirstName']; ?>&nbsp;<?php echo $rs_User['LastName']; ?></u><br>
      </span>Phone Number:<span class="style41"> <u><?php echo $rs_User['Phone']; ?></u><br>
        </span>E-mail:<span class="style41"> <u><?php echo $rs_User['Email']; ?></u><br>
        </span>Department/Admin Office:<span class="style41"> <u><?php echo $rs_User['Department']; ?></u><br>
        </span>Applicant is<span class="style41">: <u><?php echo $rs_User['User_Type']; ?></u> <br>
        </span>Rank:<span class="style41"> <u><?php echo $rs_User['Rank']; ?></u><br>
        </span>Major:<span class="style41"> <u><?php echo $rs_User['Major']; ?></u><br>
        </span>Have you taken the required Human Subjects Protection Training?<span class="style41">&nbsp; <u><?php echo $rs_User['Training']; ?></u>
        </span>      </blockquote>
  <hr>
  <h5 class="style49">SECTION 1</h5>
  <p class="style47"><strong>Title of the project:</strong><span class="style41"> <u><?php echo $row_Recordset1['ProjectTitle']; ?></u></span>      </p>
  <p class="style47"> <strong>Project type:</strong> <u><?php echo $row_Recordset1['ProjectType']; ?></u> </p>

    <blockquote class="style47">
      <p class="style47">If Academic/Class, Course #: <u><?php echo $row_Recordset1['CourseNumber']; ?></u> </p>
    <p> If funded research, complete name of funder: <br>
       <u><?php echo $row_Recordset1['FunderName']; ?></u> </p>
  </blockquote>
  
  <p>If you are a student, please provide the following informaiton about the faculty member that you work with on this project: </p>
  <table width="690" border="0" align="center" bgcolor="#ccddcc">
    <tr>
      <td>Faculty First Name:        </td>
      <td><u><?php echo $row_Recordset1['FacultyFirstName']; ?></u></td>
      <td>Faculty Last Name:        </td>
      <td><u><?php echo $row_Recordset1['FacultyLastName']; ?></u></td>
    </tr>
    <tr>
      <td>Faculty Email Address:        </td>
      <td><u><?php echo $row_Recordset1['FacultyEmail']; ?></u></td>
      <td>Faculty Phone Number:        </td>
      <td><u><?php echo $row_Recordset1['FacultyPhone']; ?></u></td>
    </tr>
     <tr>
      <td colspan="4">Department/Office: 
        <u><?php echo $row_Recordset1['FacultyDepartment']; ?></u></td>
      </tr>
    <tr>
      <td colspan="4">Has this project been approved by the faculty member? <u>
      <?php if($row_Recordset1['FacultyApproval']=="Yes") echo "Yes";?>
        <?php if($row_Recordset1['FacultyApproval']=="No") echo "No";?></u></td>
      </tr>
  </table>
  <p class="style47">Do you require a signed hard copy of the IRB's decision? <u><?php echo $row_Recordset1['SignedHardCopy']; ?></u>
  <hr>
  <h5 class="style49">SECTION 2</h5>
  <p class="style47">Does your project involve the use of the following 
    as research subjects?</p>
  <blockquote class="style47"> 
    <p> Children under the age of 18: 
        <u><?php echo $row_Recordset1['ChildrenUnder18']; ?></u>
    <p> Nursing home patients:  <u><?php echo $row_Recordset1['NursingHomePatients']; ?></u>
    <p>Prisoners: <u><?php echo $row_Recordset1['Prisoner']; ?></u>
    <p>Pregnant women or fetuses: 
        <u><?php echo $row_Recordset1['PregnantWomenOrFetuses']; ?></u>
    <p>Persons with a physical illness, injury , or disability: 
        <u><?php echo $row_Recordset1['IllnessInjoryOrDisability']; ?></u>
    <p>Mentally or psychologically impaired persons: 
        <u><?php echo $row_Recordset1['MentallyOrPsychologicallyImpaired']; ?></u> </p>
  </blockquote>
  <p class="style47">Are you offering any incentives to subjects in return for participation? 
      <u><?php echo $row_Recordset1['IncentiveForParticipation']; ?></u>
  <p class="style47">Will you be asking subjects to provide:</p>
  <blockquote class="style47"> 
    <p> 
      
      Name? 
      <u><?php echo $row_Recordset1['RequestName']; ?></u><br>
      <br>
     
      Social Security #? 
      <u><?php echo $row_Recordset1['RequestSSN']; ?></u><br>
      <br>
      
      Phone #? 
      <u><?php echo $row_Recordset1['RequestPhoneNum']; ?></u><br>
      <br>
      
      Address? 
      <u><?php echo $row_Recordset1['RequestAddress']; ?></u><br>
      <br>
      
      Medical/health info? 
      <u><?php echo $row_Recordset1['RequestMedicalInfo']; ?></u><br>
      <br>
     I will NOT be asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info: 
     <u><?php echo $row_Recordset1['RequestNone']; ?></u><br>
    </p>
  </blockquote>
  <p class="style47"> <span class="style52"><em>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study.</em></span><br>
    On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, overall risk to subjects in your project.    
    <u><?php echo $row_Recordset1['RiskRating']; ?></u> </p>
  <p class="style47"><span class="style52"><em>Benefit: A valued or desired outcome; an advantage.</em></span><b><br>
    </b> On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <u><?php echo $row_Recordset1['BenefitRating']; ?></u> </p>
  <p class="style47">In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.</p>
  <blockquote>
    <p class="style47"><em>    <?php echo $row_Recordset1['RiskAssesMethod']; ?> </em></p>
  </blockquote>
  <hr>
  <h5 class="style49">SECTION 3</h5>
  <p class="style47"> Will you be using a Consent Form? <u><?php echo $row_Recordset1['InformedConsentDoc']; ?></u></p>
  <blockquote class="style47">
    <p>If &nbsp;you answered &#145;no&#148; above, please explain here:<br>
      <br>
        <em><?php echo $row_Recordset1['NoInformedConsentExp']; ?></em> <br>
    </p>
    </blockquote>
    <p><strong>Please Note: if you are using a Consent Form, it must include all the items listed in the <a href="http://www.txstate.edu/research/irb/irb_checklist.php" target="_blank">Requirements Checklist for Consent Forms</a>. The checklist was attached to the email you received after registration. It can also be downloaded from the IRB Website. </strong></p>
    <p><strong>If your Consent Form does not include the items on the Checklist, your application will not be approved.</strong>                </p>
    <hr>
       
          <div align="center"><strong>
         
  View/Download Project Documents</strong>
  <p align='center'>
<form name="fileform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" >
 <?php
$path = "appdoc/".$appNum;
$dh = @ opendir($path);
$i=1;
$k=0;
while (($file = @ readdir($dh)) !== false) {
    if($file != "." && $file != "..") {
        echo "$i. <a href='$path/$file'>$file</a>  ";
		?>
		
		<input name='button' type='button' onClick="deleteConfirm('<?php echo $file;?>', '<?php echo $appNum; ?>')" value='Delete File'><br>
	<?php
        $i++;
		$k=$k+1;
    }
}
@ closedir($dh);
if ($k==0)
echo "No Document uploaded";

?>
</form>
</div>
  </p></td>
</tr><tr><td>
  
   </table></td></tr><tr><td><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr>
  </table> 
<?php

mysql_free_result($appUser);

?>
</span></td>
  </tr></table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
