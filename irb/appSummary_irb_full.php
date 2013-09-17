<?php require_once('Connections/con3.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "IRB Staff")) {   
 
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
  <title>Texas State University-San Marcos | IRB Application</title>
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
.style7 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #4d3319;
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
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #336699;
	text-decoration: underline;
}
a.body:visited {
	font-family: Verdana, Arial, Helvetica, sans-serif;
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
	background-color: #cccccc;
}
.style21 {
	color: #000066;
	font-size: 16px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style41 {color: #000099}
.style43 {color: #000099; font-weight: bold; }
.style46 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style47 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: small;
}
.style48 {font-weight: bold; color: #333399;}
.style49 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: medium; }
.style52 {color: #000000; font-style: italic; }
.style53 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" >
 <tbody>
    <tr>
            <td valign="top" bgcolor="#330000"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a></td>
            <td width="99" valign="top" bgcolor="#330000" class="style4"><br>            </td>
            <td bgcolor="#330000">
              <div align="right" class="style7"><a href="LogOut.php" ><strong><font color="white">Log
Out</font></strong></a></div></td>
    </tr>
          
         
          <tr>
            <td colspan="3" height="21" valign="top">
            <div align="center">
              <p class="style6">&nbsp;</p>
              <p><span class="style17"><a class="irb" href="index.php"
></span><span class="style21">Institutional Review Board</span><span class="style17"></a></span></p>
              <p class="style6">Online Application</p>
              </div>            </td>
          </tr>
          <tr>
            <td colspan="3" height="19" valign="top"><hr>
              <div align="center"><span class="style46"><a href='osp_irb_home.php'>OSP IRB Home</a> | <a href="assignReviewer.php?appNum=<?php echo $appNum;?>">Assign Reviewer(s)</a> | <a href="irb_updatestatus.php?appNum=<?php echo $appNum;?>"> Update Application Status</a></span><hr></div></td>
          </tr>
  </tbody>
</table>
      </td>
    </tr>
</tbody></table>
<table width="800" height="300" border="0" align="center" bgcolor="#eeeeee" table>
  <tr>
<td bgcolor="#FFFFFF">
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

<p>&nbsp;</p>
<div align="center">
  <h3 class="style53">Application Summary  </h3>
</div>
<h3 class="style47">&nbsp;</h3>
  <h6>
  <h4 class="style47"><span class="style48">APPLICATION REFERENCE NUMBER:</span> <font color = "red"><?php echo($appNum) ?></font>
    </h5>
  </h4>
  <h4 class="style49"><strong>Applicant Information </strong></h4>
  <blockquote class="style47">    Name:<span class="style41"> <?php echo $rs_User['FirstName']; ?> &nbsp; <?php echo $rs_User['LastName']; ?><br>
      </span>Phone Number:<span class="style41"> <?php echo $rs_User['Phone']; ?><br>
        </span>E-mail:<span class="style41"> <?php echo $rs_User['Email']; ?><br>
        </span>Department/Admin Office:<span class="style41"> <?php echo $rs_User['Department']; ?><br>
        </span>Applicant is<span class="style41">: <?php echo $rs_User['User_Type']; ?> <br>
        </span>Rank:<span class="style41"> <?php echo $rs_User['Rank']; ?><br>
        </span>Major:<span class="style41"> <?php echo $rs_User['Major']; ?><br>
        </span>Have you taken the required Human Subjects Protection Training?<span class="style41">&nbsp; <?php echo $rs_User['Training']; ?><br>
        </span><span class="style41"><br>
      </span></blockquote>
  <hr>
  <h4 class="style49">SECTION 1</h4>
  <p class="style47"><strong>Title of project:<span class="style41"> <?php echo $row_Recordset1['ProjectTitle']; ?></span>
    
        </strong>    </p>
  <p class="style47"> <strong>Project type:</strong> <span class="style43"><?php echo $row_Recordset1['ProjectType']; ?></span> </p>

    <blockquote class="style47">
      <p class="style47">If Academic/Class, Course #: <span class="style43"><?php echo $row_Recordset1['CourseNumber']; ?></span> </p>
    <p> If funded research, complete name of funder: <br>
      <b class="style41"> <?php echo $row_Recordset1['FunderName']; ?></b>  </p>
  </blockquote>
  <p class="style47"><strong>Do you require a signed hard copy of the IRB's decision?</strong> <span class="style43"><?php echo $row_Recordset1['SignedHardCopy']; ?></span>
  <hr>
  <h3 class="style49">SECTION 2</h3>
 

  <p class="style47">Does your project involve the use of the following 
    as research subjects?</p>
  <blockquote class="style47"> 
    <p> Children under the age of 18: <span class="style43"><?php echo $row_Recordset1['ChildrenUnder18']; ?></span>
    <p> Nursing home patients:  <span class="style43"><?php echo $row_Recordset1['NursingHomePatients']; ?></span>
    <p>Prisoners: <span class="style43"><?php echo $row_Recordset1['Prisoner']; ?></span>
    <p>Pregnant women or fetuses: <span class="style43"><?php echo $row_Recordset1['PregnantWomenOrFetuses']; ?></span>
    <p>Persons with a physical illness, injury , or disability <span class="style43"><?php echo $row_Recordset1['IllnessInjoryOrDisability']; ?></span>
    <p>Mentally or psychologically impaired persons <span class="style43"><?php echo $row_Recordset1['MentallyOrPsychologicallyImpaired']; ?></span> </p>
  </blockquote>
  <p class="style47">Are you offering any incentives to subjects in return for participation? <span class="style43"><?php echo $row_Recordset1['IncentiveForParticipation']; ?></span>
  <p class="style47">Will you be asking subjects to provide:</p>
  <blockquote class="style47"> 
    <p> 
      
      Name?<span class="style43"> <?php echo $row_Recordset1['RequestName']; ?></span><br>
      <br>
     
      Social Security #?<span class="style43"> <?php echo $row_Recordset1['RequestSSN']; ?></span><br>
      <br>
      
      Phone #? <span class="style43"><?php echo $row_Recordset1['RequestPhoneNum']; ?></span><br>
      <br>
      
      Address?<span class="style43"> <?php echo $row_Recordset1['RequestAddress']; ?></span><br>
      <br>
      
      Medical/health info? <span class="style43"><?php echo $row_Recordset1['RequestMedicalInfo']; ?></span><br>
      <br>
     I will NOT be asking subjects to provide their Name, Social Security #, Phone #, Address, or Medical/health info: <span class="style43"><?php echo $row_Recordset1['RequestNone']; ?></span><br>
    </p>
  </blockquote>
  <p class="style47"> <span class="style52">Risk: The probability of harm or injury -physical, psychological, social, 
    or economic -occurring as a result of participation in a research study.</span><br>
    <strong>On a scale of 1-10, with 1 being no risk and 
    10 being significant risk, overall risk to subjects in your project.</strong>    <br>
    <br>
    <span class="style43"><?php echo $row_Recordset1['RiskRating']; ?></span> </p>
  <p class="style47">&nbsp;</p>
  <p class="style47"><span class="style52">Benefit: A valued or desired outcome; an advantage.</span><b><br>
    </b> <strong>On a scale of 1-10, with 1 being no benefit 
    and 10 being significant benefit, rate the overall benefits to subjects in 
    your project.</strong><br>
    <br> 
    <span class="style43"><?php echo $row_Recordset1['BenefitRating']; ?></span> </p>
  <p class="style47">&nbsp;</p>
  <p class="style47"><strong>In the space below, briefly describe the method 
    you used to assess risks and benefits associated with your research project.</strong><br>
    <br>
    <span class="style43"><?php echo $row_Recordset1['RiskAssesMethod']; ?></span> </p>
  <hr>
  <h3 class="style49">SECTION 3</h3>
  <p class="style47"> <strong>Will you be using an informed consent document?</strong>    <span class="style43"><?php echo $row_Recordset1['InformedConsentDoc']; ?></span></p>
  <blockquote class="style47"> 
    <p>If &nbsp;you answered &#145;no&#148; above, please explain here:<br>
      <span class="style43"><?php echo $row_Recordset1['NoInformedConsentExp']; ?></span> </p>
    <blockquote>
      <p class="style47">If you are using an informed consent document, answer the following questions 
        about your informed consent document(s): <br>
        (Note: if you answered &quot;No&quot; 
        above, then you may leave all of the below Yes / No questions blank.)</p>
      <p>Is the language in the document appropriately 
        matched to the comprehension level of your intended subject pool? 
        <span class="style43"><?php echo $row_Recordset1['AppropriateLanguage']; ?></span><br>
        <br>
        Will the document be provided in language(s) 
        other than English? <span class="style43"><?php echo $row_Recordset1['OtherLanguage']; ?></span><br>
        <br>
        Will you arrange in advance for translators 
        for non-English speakers? <span class="style43"><?php echo $row_Recordset1['ArrangeForTranslators']; ?></span>
        <br>
        <br> 
        Are you 100% sure that these translators 
        fully understand the exact meaning of the consent document? <span class="style43"><?php echo $row_Recordset1['TranslatorUnderstand']; ?></span>
        <br>
        <br> 
        Will you be obtaining the subject's signature? 
        <span class="style43"><?php echo $row_Recordset1['ObtainSubjectsSignature']; ?></span><br>
        <br>
        Will you be providing subjects a copy of 
        their consent document? <span class="style43"><?php echo $row_Recordset1['ProvideCopyOfConsentDoc']; ?></span>
        <br>
        <br>
        Does your document in any way ask or imply 
        that subjects are waiving any right or releasing you from any liability? 
        <span class="style43"><?php echo $row_Recordset1['LiabilityRelease']; ?></span></p>
    </blockquote>
    <p class="style47"> If you are using an informed consent document, does your informed consent 
      document contain:</p> 
    <blockquote>
      <p> A statement that the study involves research? 
        <span class="style43"><?php echo $row_Recordset1['ResearchInvolvementStatement']; ?></span><br>
        <br> 
        An explanation of the purposes of the research? 
        <span class="style43"><?php echo $row_Recordset1['ExplanationOfPurpose']; ?></span><br>
        <br>
        The expected duration of the subject's participation? 
        <span class="style43"><?php echo $row_Recordset1['ExpectDuration']; ?></span><br>
        <br> 
        Identification of any procedures which are 
        experimental? <span class="style43"><?php echo $row_Recordset1['IdentificationOfExperimentalProc']; ?></span>
        <br>
        <br> 
        A description of any reasonably foreseeable 
        risks or discomforts to the subject? 
        <span class="style43"><?php echo $row_Recordset1['DescriptionOfRisk']; ?></span><br>
        <br>
        A description of any benefits to the subject 
        or to others which may reasonably be expected from the research? 
        <span class="style43"><?php echo $row_Recordset1['ExpectedBenefit']; ?></span><br>
        <br>
        A disclosure of appropriate alternative procedures 
        or courses of treatment, if any, that might be advantageous to the subject? 
        <span class="style43"><?php echo $row_Recordset1['AlternativesOfDisclosure']; ?></span><br>
        <br>
        For research involving more than minimal 
        risk, an explanation as to whether any compensation, and an explanation 
        as to whether any medical treatments are available, if injury occurs and, 
        if so, what they consist of, or where further information may be obtained? 
        <span class="style48"><?php echo $row_Recordset1['ExplanationOfCompensation']; ?></span><br>
        <br>
        An explanation of whom to contact for answers 
        to pertinent questions about the research and research subjects' rights, 
        and whom to contact in the event of a research-related injury to the subject? 
        <span class="style48"><?php echo $row_Recordset1['ContactInfo']; ?></span><br>
        <br>
        A statement that participation is voluntary, 
        refusal to participate will involve no penalty or loss of benefits to which 
        the subject is otherwise entitled, and the subject may discontinue participation 
        at any time without penalty or loss of benefits, to which the subject is 
        otherwise entitled?      </p>
      <p class="style48"><?php echo $row_Recordset1['VoluntaryParticipationStatement']; ?>      </p>
    </blockquote>
    <hr>
      
          <div align="center"><strong>
          <?php
  echo "View/Download Project Documents<hr>";
     
$path = "appdoc/".$appNum;
if(opendir($path)!=false){ 
$dh = opendir($path);


$i=1;
while (($file = readdir($dh)) !== false) {
    if($file != "." && $file != "..") {
        echo "$i. <a href='$path/$file'>$file</a><br />";
        $i++;
    }
}
closedir($dh);

}//end if opendir
echo "<hr>";
?>
          </p>
                </strong></div>
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
echo "Date: ".$row_Recordset1['rev1ApprovedDate'];
echo "<br>".$rev2Name."<br><br>";
echo "Approved? ".$row_Recordset1['rev2Approved'];
echo "Date: ".$row_Recordset1['rev2ApprovedDate'];

echo "<br>".$rev3Name."<br><br>";
echo "Approved? ".$row_Recordset1['rev3Approved'];
echo "Date: ".$row_Recordset1['rev3ApprovedDate'];

?>
<hr>Reviewer Comments<br>

<?php
echo "<br>".$rev1Name."<br>";
echo $row_Recordset1['rev1Comments']."<br><br>";
echo "<br>".$rev2Name."<br>";
echo $row_Recordset1['rev2Comments']."<br><br>";
echo "<br>".$rev3Name."<br>";
echo $row_Recordset1['rev3Comments']."<br><br>";
?>
<hr>
<span class="style47"><strong>Application Status</strong>: 
<span class="style48"><?php echo $row_Recordset1['Status']; ?></span></span>
   <span class="style47"></br>
   <a href="irb_updatestatus.php?appNum=<?php echo $appNum; ?>">Update Application Status</a> </br>
   </span>
  Human Subject Protection Training? <?php echo $row_Recordset1['trainingFinished'];?>
   <hr>
   <span class="style47"><a href='osp_irb_home.php'>OSP IRB Home</a>
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
