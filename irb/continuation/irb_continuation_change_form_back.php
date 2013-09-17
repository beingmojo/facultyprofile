<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="../irbstyle.css" rel="stylesheet" type="text/css">


  <style type="text/css">
<!--
.style42 {color: #FFFFFF}
.style43 {font-size: large}
.style44 {	color: #990000;
	font-weight: bold;
}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td valign="top"><p align="left" class="style6 style24"><img src="../banner2.jpg" height="160"></td>
            <td valign="middle" background="../tbbg.gif"><p align="center" class="tsu">Texas State University</p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
          
            </span></td>
 
  </tr>
</tbody></table>
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
      <div align="center"><a class="irb" href="../<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42">|</span> <a href="irb_listContinuation_app.php" class="irb">My IRB Continuation/Change Applications</a> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a></div></td>
  </tr>
  <tr><td colspan="4"><div align="center">
  
      <br>
      <?php echo $_SESSION['name'];?></div></td>
  </tr><tr><td colspan="4">
    <tr><td>
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="style46">
    <p align="center" class="style47">&nbsp;</p>
    <p align="center" class="style47"><strong>APPLICATION FOR IRB CONTINUATION/CHANGE </strong></p>
	 <p>This is your IRB Continuation/Change Application Number: <font color="#CC0033"><?php echo $_POST['ID'];?></font></p><hr />
    <p class="style48"><span class="style44">Is this application is a change to the original IRB application or a continuation to the original IRB application?</span>
      <label>
      <input type="radio" name="conOrChange" value="Continuation" <?php if ($_POST['conOrChange'] =="Continuation") echo "checked";?>>
Continuation</label>
      <label>
      <input type="radio" name="conOrChange" value="Change" <?php if ($_POST['conOrChange'] =="Change") echo "checked";?>>
Change</label>
</p>
    <hr>
    <p class="style48"><strong>Section 1    </strong></p>
    <p class="style47">&nbsp;1.&nbsp;	Original IRB Reference Number&nbsp;&nbsp;&nbsp;
      <input name="App_Number" type="text" id="App_Number" value="<?php echo $_POST['App_Number'];?>" size="35" />
    </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	State the grant ID number (N/A if not funded):&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="GrantIDNumber" type="text" id="GrantIDNumber" value="<?php echo $_POST['GrantIDNumber'];?>" size="30" />
  </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; State the length of project period (N/A if not funded):&nbsp;
      <input name="LengthOfProject" type="text" id="LengthOfProject" value="<?php echo $_POST['LengthOfProject'];?>" size="30" />
  </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Do you require a signed hard copy of the IRB's decision for your records?&nbsp;&nbsp;&nbsp;
      <input name="IRBDecisionHardCopy" type="radio" value="Yes" <?php if ($_POST['IRBDecisionHardCopy'] == "Yes") echo "checked";?>/>
      Yes&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="IRBDecisionHardCopy" type="radio" value="No" <?php if ($_POST['IRBDecisionHardCopy'] == "No") echo "checked";?>/>
    No</p>
  <p class="style48"><strong>Section 2 </strong></p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp; What is the status of your study?</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <select name="StudyStatus" id="StudyStatus">
        <option value="">Choose One</option>
        <option <?php if ($_POST['StudyStatus']=="Data Analysis Only") echo "selected";?> value="Data Analysis Only">Data Analysis Only</option>
        <option <?php if ($_POST['StudyStatus']=="Study on Hold") echo "selected";?> value="Study on Hold">Study on Hold</option>
        <option <?php if ($_POST['StudyStatus']=="Study Not Begun") echo "selected";?> value="Study Not Begun">Study Not Begun</option>
        <option <?php if ($_POST['StudyStatus']=="Following Subjects") echo "selected";?> value="Following Subjects">Following Subjects</option>
   <option <?php if ($_POST['StudyStatus']=="Recruiting Subjects") echo "selected";?> value="Recruiting Subjects">Recruiting Subjects</option>
        <option <?php if ($_POST['StudyStatus']=="Other") echo "selected";?> value="Other">Other</option>
        </select>
&nbsp;&nbsp;&nbsp; </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; If you chose &quot;Other&quot;, please provide an explanation (N/A if &quot;Other&quot; is not chosen as the status of the study): </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="StudyStatusExplanation" cols="55" id="StudyStatusExplanation"><?php echo $_POST['StudyStatusExplanation'];?></textarea>
  </p>
  <p class="style47">&nbsp;2. Total number of participants <em><strong>approved</strong></em> for the study:
    <input name="NumberOfParticipantsApproved" type="text" id="NumberOfParticipantsApproved" value="<?php echo $_POST['NumberOfParticipantsApproved'];?>" size="15" />
  </p>
  <p class="style47">&nbsp;3. Number of participants <em><strong>enrolled since last IRB review (continuing or initial)</strong></em>:&nbsp;
      <input name="ParticipantsEnrolledSinceLastReview" type="text" id="ParticipantsEnrolledSinceLastReview" value="<?php echo $_POST['ParticipantsEnrolledSinceLastReview'];?>" size="15" />
  </p>
  <p class="style47">&nbsp;4. Number of participants <em><strong>enrolled in the study to date </strong></em>:&nbsp;
      <input name="ParticipantsEnrolledToDate" type="text" id="ParticipantsEnrolledToDate" value="<?php echo $_POST['ParticipantsEnrolledToDate'];?>" size="15" />
      </p>
  <p class="style47">&nbsp;5. If actual total enrollment is different from the original project enrollment, provide an explanation (N/A if there is no difference in total enrollment):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;
      <textarea name="DifferentEnrollmentExplanation" cols="65" id="DifferentEnrollmentExplanation"><?php echo $_POST['DifferentEnrollmentExplanation'];?></textarea>
  </p>
  <p class="style47">&nbsp;6.&nbsp; Has your relationship with the study sponsor changed since the IRB review in any way which might require conflict of interest disclosure (e.g. stock purchases, royalty payments, patents, Board position, etc.)?</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="RelationshipChange" type="radio" value="Yes" <?php if ($_POST['RelationshipChange']=="Yes") echo "checked";?>/>
    Yes</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="RelationshipChange" type="radio" value="No" <?php if ($_POST['RelationshipChange']=="No") echo "checked";?>/>
    No</p>
  <p class="style47">&nbsp;7.&nbsp; Have there been any changes in Principal Investigator, Co-Investigators or staff?</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="PIChange" type="radio" value="Yes" <?php if ($_POST['PIChange']=="Yes") echo "checked";?>/>
    Yes</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;
    &nbsp;
         <input name="PIChange" type="radio" value="No" <?php if ($_POST['PIChange']=="No") echo "checked";?>/>
    No</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> If yes,</strong> please explain (N/A if answer above is &quot;No&quot;):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp; &nbsp;
      <textarea name="PIChangeExplanation" cols="65" id="PIChangeExplanation"><?php echo $_POST['PIChangeExplanation'];?></textarea>
  </p>
  <p class="style47">&nbsp;8.&nbsp; Summarize preliminary information about any results and/or trends (DO NOT LEAVE BLANK):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="ResultsSummary" cols="65" rows="6" id="ResultsSummary" ><?php echo $_POST['ResultsSummary'];?></textarea>
  </p>
  <p class="style47">&nbsp;9.&nbsp; Describe any unanticipated problems in the conduct of the study (if none, state &quot;None&quot;):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="UnanticpatedProblems" cols="65" rows="6" id="UnanticpatedProblems"><?php echo $_POST['UnanticpatedProblems'];?></textarea>
  </p>
  <p class="style47">10.&nbsp; Has the risk/benefit relationship for subjects changed from the initial expectation?</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="RiskBenefitChange" type="radio" value="Yes" <?php if ($_POST['RiskBenefitChange']=="Yes") echo "checked";?>/>
    Yes</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;
    &nbsp;
        <input name="RiskBenefitChange" type="radio" value="No" <?php if ($_POST['RiskBenefitChange']=="No") echo "checked";?>/>
    No</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>If yes,</strong> describe what has changed from the initial expectations (N/A if &quot;No&quot; is chosen above):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp; &nbsp;
      <textarea name="RiskBenefitChangedExplanation" cols="65" rows="6" id="RiskBenefitChangedExplanation"><?php echo $_POST['RiskBenefitChangedExplanation'];?></textarea>
  </p>
  <p class="style47">11.&nbsp; List and explain any other changes in the study or study period originally approved by the IRB (if none, state &quot;none&quot;):</p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="ChangesInStudySinceApproval" cols="65" rows="6" id="ChangesInStudySinceApproval"><?php echo $_POST['ChangesInStudySinceApproval'];?></textarea>
  </p>
  <span class="style47"><br />
  Please check your answers carefully before submitting. </span>
  <input type="hidden" name="ID" value="<?php echo $_POST['ID'];?>">
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" id = "emailAdd" name="emailAdd" value="<?php echo $row_Recordset1['Email'];?>">
  <p align="center">
    <input name="Submit" type="submit" value="Submit Application" />
    </form>
    </td>
    </tr></table><tr><td><br><br></br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table>
</td></tr></table>
</body>
</html>
<?php
//mysql_free_result($Recordset1);
//mysql_free_result($Recordset2);
?>
