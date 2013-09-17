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

<html>
<head>
<title>IRB Application Summary</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript">



</script>




<style type="text/css">
<!--
.style3 {font-size: 12px}
.style5 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; }
.style8 {
	color: #000000;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
</head>
<body>

<span class="style3">
<html>
<head>
</span>
<title>IRB Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<span class="style3">
<script language="JavaScript">





</script>
</span>
<link href="../css/forms.css" rel="stylesheet" type="text/css">
<span class="style3">
<style type="text/css">
<style type="text/css">
<!--
.style4 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 40px;
	color: #333399;
}
.style6 {
	font-family: Arial, Helvetica, sans-serif;
	color: #333399;
	font-weight: bold;
}
a.navbar:link {
	color: #4d3319;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
}
a.navbar:visited {
	color: #4d3319;
	text-decoration: none;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
a.navbar:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	text-decoration: underline;
}
a.body:link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #336699;
	text-decoration: underline;
}
a.body:visited {
	font-family: Arial, Helvetica, sans-serif;
	color: #4D3319;
	text-decoration: underline;
}

a.irb:link{
font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;

}
a.irb:visited {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;
}
-->
  </style>
  <style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style21 {
	color: #000066;
	font-size: 16px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style40 {color: #000066; font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; }
.style41 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: x-small;
}
.style43 {color: #000099;}
.style44 {color: #000099; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;}
.style45 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; font-weight: bold; }
.style46 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #000099;
}
-->
  </style>
</head>

   
<body text="#000000">
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
</span>
<tr><td class="style3">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
 <tbody>
    <tr>
      <td height="150" valign="top" width="800">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tbody>
          <tr>
            <td valign="top" bgcolor="#330000"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a><br>  </td>
            <td bgcolor="#330000">
              <div class="style5" align="right"><font color="#336699"><br>
              </font></div></td>
            </tr>
          
          
          <tr>
            <td colspan="2" height="21" valign="top">
            <div align="center">
              <p class="style6">&nbsp;</p>
              <p><span class="style17"><a class="irb" href="index.php"
><span class="style21">Institutional Review Board</span><span class="style17"></a></p>
              <p class="style5">Online Application
              <hr></p>
            </div>            </td>
          </tr>
          <tr>
            <td colspan="2" height="19" valign="top"><div align="center"><span class="style7"><A href="irbform.php">Submit  IRB Application </A>| <a href="applicant_reviewer_app.php">IRB Applications You Submitted</a> | <A href="reviewer_app.php">Review Applications </A> | <a href="rev_listApp.php">List All Applications</a><br>
              <A href="update_reviewer_userInfo.php">Updatge Personal Information  </A>| <A href="LogOut.php">Log Out</A></span><A href="LogOut.php">
            </A></div>
              <A href="LogOut.php">
              <hr></A></td>
          </tr>
        </tbody>
      </table>      </td>
    </tr>
</tbody></table><table width="800"><tr><td>


<span class="style5">
<?php
   
   $applicant = $row_Recordset1['username'];
  mysql_select_db($database_con3, $con3);
  if (!get_magic_quotes_gpc()) {
$applicant = addslashes($applicant);
}
$usercheck = $_POST['username'];
$sql="SELECT username FROM user WHERE username = '".$usercheck."'";
   $sql2 = sprintf("SELECT * FROM user WHERE username = '%s'", $applicant);
$appUser = mysql_query($sql2, $con3) or die(mysql_error());
$rs_User = mysql_fetch_assoc($appUser);
?>
</span>
<p class="style5">&nbsp;</p>
<div align="center" class="style5">
  <h3><strong>Application Summary 
    
    
  </strong></h3>
</div>
<h3 class="style5">&nbsp;</h3>
<h3 class="style5">APPLICATION REFERENCE NUMBER:<u> <font color = "red"><?php echo($appNum); ?></font></u>
    </h5>
    <span class="style10"><a href="evaluation.php?appNum=<?php echo($appNum); ?>">Application Evaluation</a></span></h3>
<h3 class="style5"><strong>Applicant Data Sheet </strong></h3>
  <blockquote class="style5">
    <p class="style3">Name: <u><?php echo $rs_User['FirstName']; ?> &nbsp; <?php echo $rs_User['LastName']; ?></u><br>
      <br>
      Phone Number: <u>&nbsp;<?php echo $rs_User['Phone']; ?></u><br>
      <br>
      E-mail: <u><?php echo $rs_User['Email']; ?></u><br>
      <br>
      Department/Admin Office: <u><?php echo $rs_User['Department']; ?></u><br>
      <br>
      Applicant is: <u><?php echo $rs_User['User_Type']; ?></u> <br>
      <br>
      Rank: <u><?php echo $rs_User['Rank']; ?></u><br>
      <br>
      Major: <u><?php echo $rs_User['Major']; ?></u><br>
      <br>
      Have you taken the required Human Subjects Protection Training?&nbsp;<u> <?php echo $rs_User['Training']; ?></u><br>
      <br>
    </p>
  </blockquote>
  <hr>
  <h3 class="style8">SECTION 1:</h3>
<p class="style10"> <strong>Title of project:<u> <?php echo $row_Recordset1['ProjectTitle']; ?></u>
    
        </strong>    </p>
  <p class="style10">Project type: </p>

    <blockquote class="style10">
      <p> <u><?php echo $row_Recordset1['ProjectType']; ?></u>        </p>
      <p>If Academic/Class, Course #: <u><?php echo $row_Recordset1['CourseNumber']; ?></u> </p>
      <p>If funded research, complete name of funder: </p>
      <p><u><?php echo $row_Recordset1['FunderName']; ?></u> </p>
    </blockquote>
    <p class="style10">
  Do you require a signed hard copy of the IRB's decision?<u> <?php echo $row_Recordset1['SignedHardCopy']; ?></u>
  <hr>
  <h3 class="style5">SECTION 2:</h3>
 

  <p class="style10">Does your project involve the use of the following 
    as research subjects:</p>
  <blockquote class="style10"> 
    <p> Children under the age of 18:<u> <?php echo $row_Recordset1['ChildrenUnder18']; ?></u>
    <p> Nursing home patients:  <u><?php echo $row_Recordset1['NursingHomePatients']; ?></u>
    <p>Prisoners:<u> <?php echo $row_Recordset1['Prisoner']; ?></u>
    <p>Pregnant women or fetuses: <u><?php echo $row_Recordset1['PregnantWomenOrFetuses']; ?></u>
    <p>Persons with a physical illness, injury , or disability: <u><?php echo $row_Recordset1['IllnessInjoryOrDisability']; ?></u>
    <p>Mentally or psychologically impaired persons: <u><?php echo $row_Recordset1['MentallyOrPsychologicallyImpaired']; ?></u> </p>
  </blockquote>
  <p class="style10">Are you offering any incentives to subjects in return for participation? <u><?php echo $row_Recordset1['IncentiveForParticipation']; ?></u>
  <p class="style10">Will you be asking subjects to provide:</p>
  <blockquote class="style10"> 
    <p> 
      
      Name? <u><?php echo $row_Recordset1['RequestName']; ?></u><br>
      <br>
     
      Social Security #? <u><?php echo $row_Recordset1['RequestSSN']; ?></u><br>
      <br>
      
      Phone #? <u><?php echo $row_Recordset1['RequestPhoneNum']; ?></u><br>
      <br>
      
      Address? <u><?php echo $row_Recordset1['RequestAddress']; ?></u><br>
      <br>
      
      Medical/health info? <u><?php echo $row_Recordset1['RequestMedicalInfo']; ?></u><br>
      <br>
     I will NOT be asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info: <u><?php echo $row_Recordset1['RequestNone']; ?></u><br>
    </p>
  </blockquote>
  <p class="style10"> <b>Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study</b>.<br>
    On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, overall risk to subjects in your project. 
    <u><?php echo $row_Recordset1['RiskRating']; ?>  </u></p>
  <p class="style10">&nbsp;</p>
  <p class="style10"><b>Benefit: A valued or desired outcome; an advantage.<br>
    </b>On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project. 
    <u><?php echo $row_Recordset1['BenefitRating']; ?>  </u></p>
  <p class="style10">&nbsp;</p>
  <p class="style10"> In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.<br>
    <u><?php echo $row_Recordset1['RiskAssesMethod']; ?></u> </p>
  <hr>
  <h3 class="style5">SECTION 3:</h3>
  <p class="style10">Will you be using an informed consent document? 
      <u><?php echo $row_Recordset1['InformedConsentDoc']; ?></u></p>
  <blockquote class="style5"> 
    <p class="style10">If &nbsp;you answered &#145;no&#148; above, please explain here:<br>
        <u><?php echo $row_Recordset1['NoInformedConsentExp']; ?>    </u></p>
  </blockquote>
  <p class="style10">If you are using an informed consent document, answer the following questions 
    about your informed consent document(s): <br>
    Note: if you answered &quot;No&quot; 
    above, then you may leave all of the below Yes / No questions blank.</p>
  <blockquote class="style5"> 
    <p class="style10">Is the language in the document appropriately 
      matched to the comprehension level of your intended subject pool? 
        <u><?php echo $row_Recordset1['AppropriateLanguage']; ?></u><br>
        <br>
      Will the document be provided in language(s) 
      other than English? <u><?php echo $row_Recordset1['OtherLanguage']; ?></u>
      <br>
      <br>
      Will you arrange in advance for translators 
      for non-English speakers? <u><?php echo $row_Recordset1['ArrangeForTranslators']; ?>
      </u><br>
      <br>
Are you 100% sure that these translators 
      fully understand the exact meaning of the consent document? <u><?php echo $row_Recordset1['TranslatorUnderstand']; ?>
      </u><br>
      <br>
      Will you be obtaining the subject's signature? 
      <u><?php echo $row_Recordset1['ObtainSubjectsSignature']; ?></u><br>
      <br>
      Will you be providing subjects a copy of 
      their consent document? <u><?php echo $row_Recordset1['ProvideCopyOfConsentDoc']; ?>
      </u><br>
      <br>
     Does your document in any way ask or imply 
      that subjects are waiving any right or releasing you from any liability? 
     <u><?php echo $row_Recordset1['LiabilityRelease']; ?></u></p>
  </blockquote>
  <p class="style10"> If you are using an informed consent document, does your informed consent 
    document contain:</p>
  <blockquote class="style5"> 
    <p><span class="style10">A statement that the study involves research? 
        <u><?php echo $row_Recordset1['ResearchInvolvementStatement']; ?></u><br>
        <br>
      An explanation of the purposes of the research? 
      <u><?php echo $row_Recordset1['ExplanationOfPurpose']; ?></u><br>
      <br>
      The expected duration of the subject's participation? 
      <u><?php echo $row_Recordset1['ExpectDuration']; ?></u><br>
      <br>
      Identification of any procedures which are 
      experimental? <u><?php echo $row_Recordset1['IdentificationOfExperimentalProc']; ?>
      </u><br>
      <br> 
      A description of any reasonably foreseeable 
      risks or discomforts to the subject? 
      <u><?php echo $row_Recordset1['DescriptionOfRisk']; ?></u><br>
      <br>
      A description of any benefits to the subject 
      or to others which may reasonably be expected from the research? 
      <u><?php echo $row_Recordset1['ExpectedBenefit']; ?></u><br>
      <br>
      A disclosure of appropriate alternative procedures 
      or courses of treatment, if any, that might be advantageous to the subject? 
      <u><?php echo $row_Recordset1['AlternativesOfDisclosure']; ?></u><br>
      <br>
      For research involving more than minimal 
      risk, an explanation as to whether any compensation, and an explanation 
      as to whether any medical treatments are available, if injury occurs and, 
      if so, what they consist of, or where further information may be obtained? 
      <u><?php echo $row_Recordset1['ExplanationOfCompensation']; ?></u><br>
      <br>
      An explanation of whom to contact for answers 
      to pertinent questions about the research and research subjects' rights, 
      and whom to contact in the event of a research-related injury to the subject? 
      <u><?php echo $row_Recordset1['ContactInfo']; ?></u><br>
      <br>
      A statement that participation is voluntary, 
      refusal to participate will involve no penalty or loss of benefits to which 
      the subject is otherwise entitled, and the subject may discontinue participation 
      at any time without penalty or loss of benefits, to which the subject is 
      otherwise entitled?	        
      <u><?php echo $row_Recordset1['VoluntaryParticipationStatement']; ?></u></span> 
    </u>
         <hr>
      
          
         <div align="center" class="style10">
           <p>&nbsp;</p>
           <p align="left"><strong>View/Download Project Documents</strong></p>
         </div>
       <p align="left">
     

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
echo "<hr>";
?>
        
          </u></span>
        <hr>
      </p>
  </blockquote>
  
    <strong class="style47">Reviewer(s):<p class="style48">
    </strong>
     <?php 
$reviewerID1  = $row_Recordset1['rev1ID'];
   if($reviewerID1){ 
   if (!get_magic_quotes_gpc()){$reviewerID1=addslashes($reviewerID1);}}
  // echo "Reviewers: ".$reviewerIDs."<p>";
//$arrReviewerID = explode(",", $reviewerIDs);
//echo "Number of reviewer:".count($arrReviewerID);

$reviewerID2  = $row_Recordset1['rev2ID'];
if($reviewerID2){ 
if (!get_magic_quotes_gpc()){$reviewerID2=addslashes($reviewerID2);}}

$reviewerID3  = $row_Recordset1['rev3ID'];
if($reviewerID3){ 
if (!get_magic_quotes_gpc()){$reviewerID3=addslashes($reviewerID3);}}

if($reviewerID1){ 
$sqlRev=sprintf("SELECT * FROM user where username='%s'", $reviewerID1);

$rev = mysql_query($sqlRev, $con3) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev);
echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName']."<br>";
$rev1Name = $rs_rev['FirstName']." ".$rs_rev['LastName'];
mysql_free_result($rev);
}
if($reviewerID2){ 
$sqlRev=sprintf("SELECT * FROM user where username='%s'", $reviewerID2);

$rev = mysql_query($sqlRev, $con3) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev);
echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName']."<br>";
$rev2Name = $rs_rev['FirstName']." ".$rs_rev['LastName'];
mysql_free_result($rev);
}

if($reviewerID3){ 
$sqlRev=sprintf("SELECT * FROM user where username='%s'", $reviewerID3);

$rev = mysql_query($sqlRev, $con3) or die(mysql_error());
$rs_rev = mysql_fetch_assoc($rev);
echo "<br>Reviewer Name: ".$rs_rev['FirstName']."&nbsp;".$rs_rev['LastName']."<br>";
$rev3Name = $rs_rev['FirstName']." ".$rs_rev['LastName'];
mysql_free_result($rev);
}

?>
<hr>Reviewer Evaluation<br>
<?php
echo "<br>".$rev1Name."<br>";
echo "Approved? ".$row_Recordset1['rev1Approved'];
if($row_Recordset1['rev1Approved']=="yes" || $row_Recordset1['rev1Approved']=="Yes")
	echo "Date: ".$row_Recordset1['rev1ApprovedDate'];
echo "<br>".$rev2Name."<br>";
echo "Approved? ".$row_Recordset1['rev2Approved'];
if($row_Recordset1['rev2Approved']=="yes" || $row_Recordset1['rev2Approved']=="Yes")
echo "Date: ".$row_Recordset1['rev2ApprovedDate'];

echo "<br>".$rev3Name."<br>";

echo "Approved? ".$row_Recordset1['rev3Approved'];
if($row_Recordset1['rev3Approved']=="yes" || $row_Recordset1['rev3Approved']=="Yes")
echo "Date: ".$row_Recordset1['rev3ApprovedDate'];

?>
<hr>Reviewer Comments<br>

<?php
echo "<br><em>".$rev1Name."</em><br>";
echo "<br>".$row_Recordset1['rev1Comments']."<br>";

echo "<br><em>".$rev2Name."</em><br>";
echo $row_Recordset1['rev2Comments']."<br>";

echo "<br><em>".$rev3Name."</em><br>";
echo $row_Recordset1['rev3Comments']."<br>";
?>
<hr>
<span class="style47"><strong>Application Status</strong>: 
<span class="style48"><?php echo $row_Recordset1['Status']; ?></span></span>
   <span class="style47"></br>
  
   </span>
   <hr>
   <hr>
   <span class="style47"><a href='osp_irb_home.php'>OSP IRB Home</a>

</span></td>
  </tr></table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

    

mysql_free_result($appUser);

?>
   </p>
  </p>
  <p align="center" class="style7">Office of Sponsored Programs <br>
    For questions regarding application submission contact OSP at <a
 href="mailto:mb29@txstate.edu">sn10@txstate.edu</a> , x 2314 </p></td>
</tr></table>
</body>
</html>

