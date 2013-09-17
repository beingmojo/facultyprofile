<?php require_once('Connections/con3.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "reviewer")) {   
 
  header("Location: ". $restrictGoTo); 
  exit;
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
  <LINK href="irbstyle.css" rel="stylesheet" type="text/css">


  <style type="text/css">
<!--
.style42 {color: #FFFFFF}
.style43 {font-size: large}
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
          
       
        </tbody>
      </table>
      </td>
  </tr>
</tbody></table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
			  <div align="center"><span class="style46">
			  <div align="center" class="style6"><span class="style2"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a> </span><span class="style42">| </span><span class="style2"><a href="reviewer_app.php" class="irb">Evaluate Applications Assigned </a> </span><span class="style42">| </span><span class="style2"><a href="rev_listApp.php" class="irb">List All IRB Applications</a> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a></span></div></td>
          </tr>
  
    <tr bgcolor="#FFFFFF">
      <td  valign="top" bgcolor="#FFFFFF">
         
        <p align="center"><br><?php echo $_SESSION['name'];?></p> 
		<table width="800"><tr><td>


<span class="style5">
<?php
   
   $applicant = $row_Recordset1['username'];
  mysql_select_db($database_con3, $con3);
  if (!get_magic_quotes_gpc()) {
$applicant = addslashes($applicant);
		}

   $sql2 = sprintf("SELECT * FROM user WHERE username = '%s'", $applicant);
$appUser = mysql_query($sql2, $con3) or die(mysql_error());
$rs_User = mysql_fetch_assoc($appUser);
?>
</span>

<div align="center" class="style5">
  <h5><strong>IRB APPLICATION SUMMARY</strong></h5>
</div>

APPLICATION REFERENCE NUMBER: <font color = "red"><?php echo($appNum); ?></font><br><br>
    
	<?
	mysql_select_db($database_con3, $con3);
	 $theValue = (!get_magic_quotes_gpc()) ? addslashes($_SESSION['username']) : $_SESSION['username'];
$query = "SELECT * FROM application where App_Number='".$appNum."' && (rev1ID='".$theValue."' || rev2ID='".$theValue."' || rev3ID='".$theValue."')";
$usercheck = mysql_query($query, $con3) or die(mysql_error());
$row_usercheck = mysql_fetch_assoc($usercheck);
$totalRows_usercheck = mysql_num_rows($usercheck);
if(!($totalRows_usercheck<1)){
?>


    <span class="style10"><a href="evaluation.php?appNum=<?php echo($appNum); ?>">Evaluate Application</a> | <?php echo "<a href='deny_reviewer.php?appNum=". $row_Recordset1['App_Number']."'>Decline Review of the Application</a>"; ?>  |  <?php echo "<a href='statSummary_rev.php?appNum=". $row_Recordset1['App_Number']."'>Summary of Status,  Evaluation and Action Log</a><br>";?></span>
	
<?php
//}
mysql_free_result($usercheck);
?>

<h5><strong>Applicant Information</strong></h5>
  <blockquote>
    <p>Name: <u><?php echo $rs_User['FirstName']; ?>&nbsp;<?php echo $rs_User['LastName']; ?></u><br>
    
      Phone Number: <u><?php echo $rs_User['Phone']; ?></u><br>
     
      E-mail: <u><?php echo $rs_User['Email']; ?></u><br>
  
      Department/Admin Office: <u><?php echo $rs_User['Department']; ?></u><br>

      Applicant is: <u><?php echo $rs_User['User_Type']; ?></u> <br>
   
      Rank: <u><?php echo $rs_User['Rank']; ?></u><br>
  
      Major: <u><?php echo $rs_User['Major']; ?></u><br>

      Have you taken the required Human Subjects Protection Training?&nbsp;<u> <?php echo $rs_User['Training']; ?></u>
      <br>
    </p>
  </blockquote>
  <hr>
  <h5 class="style8">SECTION 1:</h5>
<p class="style10"> <strong>Title of project: <u><?php echo $row_Recordset1['ProjectTitle']; ?></u>
    
        </strong>    </p>
  <p class="style10">Project type: <u><?php echo $row_Recordset1['ProjectType']; ?></u>        </p>

    <blockquote>
    <p>If Academic/Class, Course #: <u><?php echo $row_Recordset1['CourseNumber']; ?></u> </p>
      <p>If funded research, complete name of funder: <u><?php echo $row_Recordset1['FunderName']; ?></u> </p>
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
      <td colspan="4">Is  the faculty member aware of the project? 
        <u><?php if($row_Recordset1['FacultyApproval']=="Yes") echo "Yes";?></u>
        <u><?php if($row_Recordset1['FacultyApproval']=="No") echo "No";?></u>        </td>
      </tr>
  </table>
	  
    <p class="style10">
  Do you require a signed hard copy of the IRB's decision? <u><?php echo $row_Recordset1['SignedHardCopy']; ?></u>
  <hr>
  <h5 class="style5">SECTION 2:</h5>
 

  <p class="style10">Does your project involve the use of the following 
    as research subjects:</p>
  <blockquote class="style10"> 
    <p> Children under the age of 18: <u><?php echo $row_Recordset1['ChildrenUnder18']; ?></u>
    <p> Nursing home patients:
      <u><?php echo $row_Recordset1['NursingHomePatients']; ?></u>
    <p>Prisoners: <u><?php echo $row_Recordset1['Prisoner']; ?></u>
    <p>Pregnant women or fetuses: 
      <u><?php echo $row_Recordset1['PregnantWomenOrFetuses']; ?></u>
    <p>Persons with a physical illness, injury , or disability: 
      <u><?php echo $row_Recordset1['IllnessInjoryOrDisability']; ?></u>
    <p>Mentally or psychologically impaired persons: 
      <u><?php echo $row_Recordset1['MentallyOrPsychologicallyImpaired']; ?></u> </p>
  </blockquote>
  <p class="style10">Are you offering any incentives to subjects in return for participation? 
    <u><?php echo $row_Recordset1['IncentiveForParticipation']; ?></u>
  <p class="style10">Will you be asking subjects to provide:</p>
  <blockquote class="style10"> 
    <p> 
      
      Name? <u>
      <?php 
	  
	  	  	   if ($row_Recordset1['RequestName'])
	 		echo $row_Recordset1['RequestName']; 
	 	else 
	 		echo "No";
	  ?></u><br>
      <br>
     
      Social Security #? 
      <u>
      <?php 
	  	   if ($row_Recordset1['RequestSSN'])
	 		echo $row_Recordset1['RequestSSN']; 
	 	else 
	 		echo "No";
	
	   ?></u><br>
      <br>
      
      Phone #? 
      <u>
      <?php 
	   if ($row_Recordset1['RequestPhoneNum'])
	 		echo $row_Recordset1['RequestPhoneNum']; 
	 	else 
	 		echo "No";
	   ?></u><br>
      <br>
      
      Address? 
      <u>
      <?php 
	  
	  if ($row_Recordset1['RequestAddress'])
	 	echo $row_Recordset1['RequestAddress']; 
	 else echo "No";
	   ?></u><br>
      <br>
      
      Medical/health info?<u>
      <?php 
	  
	 if ($row_Recordset1['RequestMedicalInfo'])
	 	echo $row_Recordset1['RequestMedicalInfo']; 
	 else echo "No";
	   ?></u><br>
      <br>
     I will NOT be asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info: 
     <u>
     <?php 
	 if ($row_Recordset1['RequestNone'])
	 	echo $row_Recordset1['RequestNone']; 
	 else echo "No";
	 
	 ?></u><br>
    </p>
  </blockquote>
  <p class="style10"> <em>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study</em>.<br>
    On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, overall risk to subjects in your project. 
    <u><?php echo $row_Recordset1['RiskRating']; ?></u></p>
  <p class="style10"><em>Benefit: A valued or desired outcome; an advantage.<br>
    </em>On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. <u><?php echo $row_Recordset1['BenefitRating']; ?>  </u></p>
  <p class="style10">In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.</p>
  <blockquote>
    <p class="style10"><em>    <?php echo $row_Recordset1['RiskAssesMethod']; ?> </em></p>
  </blockquote>
  <hr>
  <h5>SECTION 3:</h5>
  <p class="style10">Will you be using a Consent Form? 
      
      <u><?php echo $row_Recordset1['InformedConsentDoc']; ?></u></p>
  <blockquote class="style5"> 
    <p class="style10">If &nbsp;you answered &#145;no&#148; above, please explain here:<br>
        <em><?php echo $row_Recordset1['NoInformedConsentExp']; ?></em> </p>
  </blockquote>
  <p><strong>Please Note: if you are using a Consent Form, it must include all the items listed in the <a href="http://www.txstate.edu/research/orc/humans-in-research/checklist.html" target="_blank">Requirements Checklist for Consent Forms</a>. The checklist was attached to the email you received after registration. It can also be downloaded from the IRB Website. </strong></p>
  <p><strong>If your Consent Form does not include the items on the Checklist, your application will not be approved.</strong></p>

<hr>
      
          
         <div align="center" class="style10">
           <p><strong>View/Download Project Documents</strong></p>
           </div>
       <p align="center">
     

	<?php

$path = "appdoc/".$appNum;
$dh = @ opendir($path);
$i=1;
$k=0;
while (($file = @ readdir($dh)) !== false) {
    if($file != "." && $file != "..") {
        echo "$i. <a href='$path/$file'>$file </a><br />";
        $i++;
		$k=$k+1;
    }
}
@ closedir($dh);
if ($k==0)
echo "No Document uploaded";

?>
</p>

    
<?php
mysql_free_result($Recordset1);

    

mysql_free_result($appUser);

?>
   </p>
  </p>
  </td>
</tr><tr><td> </table></td></tr><tr><td><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></table>
</body>
</html>

