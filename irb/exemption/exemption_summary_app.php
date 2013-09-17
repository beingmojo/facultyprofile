<?php require_once('../Connections/con3.php');
session_start();

$restrictGoTo = "../unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}



mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT * FROM exemption where expNum = '".$_GET['expNum']."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT `user`.FirstName, `user`.LastName, `user`.Phone, `user`.Email, `user`.username FROM `user` where username = '".$row_Recordset1['username']."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

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
.style50 {color: #FF0000}
-->
  </style></head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td valign="top"><p align="left" class="style6 style24"><img src="../banner2.jpg" height="160"></td>
            <td valign="middle" background="../tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
            </p>
            </span></td>
 
  </tr>
</tbody></table> 

</td></tr>  <tr><td>
  <table width="100%" bgcolor="#FFFFFF">
 <tr>
    <td bgcolor="#000000" align="center">
	
       
         <a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="irb_listExpApp_app.php" class="irb">My IRB Exemption Applications</a> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a></td></tr>
	<tr><td>
    
      <p align="center"><br>
      <?php echo $_SESSION['name'];?></p></td>
        </tr>
  
      
	       
  <tr><td><p align="center"><strong>Application for IRB Exemption Data Sheet</strong><hr /></p>
  IRB Exemption Application Number: </span></font><span class="style50"><?php echo $_GET['expNum'];?></span></font><br />
          <h5>Section I </h5>
          </span>
          </div>
          <table width="100%" border="0" cellpadding="5" cellspacing="0" >
       <tr>
      <td class="style48">1.&nbsp; This project is:&nbsp;
        <u><?php echo $row_Recordset1['sponsorship']; ?></u></td>
    </tr>
     
    <tr>
      <td class="style48">2.&nbsp; If you are a student, please provide your supervising faculty member's full name: </td>
    </tr>
    <tr>
      <td class="style48">
        <u><?php echo $row_Recordset1['FacultyName']; ?></u></td>
    </tr>
    <tr>
      <td class="style48"><hr />
        <h5>Section II </h5></td>
    </tr>
    <tr>
      <td class="style48">1.&nbsp; If this is  an academic or classroom project, does the scope extend beyond Texas State University? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;<u>
          <?php echo $row_Recordset1['academic_project']; ?></u>     </p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">2.&nbsp; Would you describe this project as &quot;a systematic investigation, designed to develop or contribute to generalizable knowledge? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;<u>
          <?php echo $row_Recordset1['contribute_knowledge']; ?> </u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">3.&nbsp; Will the results of your project be put on the internet, shared at a conference, published, or otherwise disseminated? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['share_results']; ?>     </u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">4.&nbsp;Will identifiable private information from individuals be collected from contact with research participants ? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['interact_people']; ?></u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">5.&nbsp; Will identifiable private information from individuals be collected from other sources (e.g. medical records)? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;<u><?php echo $row_Recordset1['collect_info']; ?></u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">6.&nbsp; Does the project involve fetuses, pregnant women or human in vitro fertilization? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['involve_pregnant']; ?>  </u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">7.&nbsp; Does the project involve prisoners? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['involve_prisoners']; ?>   </u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">8.&nbsp; Does the project involve any persons who are mentally impaired or homeless  or  who have limited autonomy? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['involve_vulnerable']; ?>  </u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">9.&nbsp; Does the project involve the review of medical records if the information is recorded in such a way that subjects can be indentified, directly or through identifiers linked to the subjects? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['medical_identifiers']; ?> </u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">10. Does the project involve survey or interview techniques which include minors as subjects in which the researcher(s) participate in the activities being observed? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['minor_subjects']; ?> </u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">11. Will a drug, biological product, medical device, or other product regulated by the FDA be used in this project? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['FDAproduct_used']; ?></u> </p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">12. Will the participants be asked to ingest substances of any kind?</td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['ingest_substance']; ?></u> </p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">13. Will the participants be asked to perform any physical tasks? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['physical_tasks']; ?>  </u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">14. Does the research attempt to influence or change participants' behavior, perception, or cognition? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['influence_behavior']; ?></u> </p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">15. Does the project involve questions or discussions of sensitive or deeply personal aspects of the subject's behavior, life experiences or attitudes?&nbsp; Examples include substance abuse, sexual activity, sexual orientation, sexual abuse, criminal behavior, sensitive demographic data, detailed health history, etc. </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['sensitive_discussion']; ?></u> </p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">16. Does the project involve techniques which expose the subject to discomfort, harassment, embarrassment, stigma, alarm or fear beyond levels encountered in the daily life of a healthy individual? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['exposeto_discomfort']; ?></u> </p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">17. Does the project involve the deception of subjects? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['subject_deception']; ?></u> </p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">18. Does the project involve videotaping or audiotaping of subjects? </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;
          <u><?php echo $row_Recordset1['taping_subjects']; ?>     </u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48"><hr />
        <h5>Section III </h5></td>
    </tr>
    <tr>
      <td class="style48"><a name="SectionIIIQuestion2" id="SectionIIIQuestion2"></a>1.&nbsp; If you are choosing one of the <a href="#categories_of_exemption">six federal categories of exemption</a>, which <strong>one</strong> are you choosing?<br />
        <span class="style9">**</span>If your project falls under more than one exemption, choose the one that is most applicable.&nbsp; You may cite the others in #3 below. </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p><u><?php echo $row_Recordset1['exempt_category']; ?></u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48"><p>
        Please note for questions 1, 3, and 4
        :&nbsp; </p>
        <p><br />
          The text areas are  limited to 2000 characters/approximately 300 words.&nbsp; Even though you are allowed to type more than the specified limit, those additional words/characters will be cropped/cut off when you move to the next question.</p></td>
    </tr>
    <tr>
      <td class="style48">2.&nbsp; What is the purpose of the project? (300 words or less)</td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;&nbsp;&nbsp;&nbsp; <u><?php echo $row_Recordset1['project_purpose']; ?></u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">3.&nbsp; Explain how this exemption category pertains to your project: (300 words or less) </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;&nbsp;&nbsp;&nbsp;<u> <?php echo $row_Recordset1['category_pertains']; ?></u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48">4.&nbsp; If you believe your project poses no risk to human participants or should be exempt from IRB review for other reasons, please explain: (300 words or less) </td>
    </tr>
    <tr>
      <td class="style48"><blockquote class="style48">
        <p>&nbsp;&nbsp;&nbsp;&nbsp; <u><?php echo $row_Recordset1['exempt_reason']; ?></u></p>
      </blockquote></td>
    </tr>
    <tr>
      <td class="style48"><div align="center"><span class="style46"><span class="style48"></span></span>
       
      </div></td>
    </tr>
    <tr>
      <td class="style48"><h4><span class="style46"><span class="style48"></span></span></h4></td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="irb_exemption_form">
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><p><a name="categories_of_exemption" id="CategoriesofExemption"></a><span class="style43"><hr />
    </span><strong>Categories of Exemption:</strong> (<a href="#SectionIIIQuestion2">Return to Section III, Question 2</a>)    <br>
    Exempt Categories of Research listed at 45 CFR, Part 46, Sec. 101(b)<br />
          <br />
          (1) Research conducted in established or commonly accepted educational settings, involving normal educational practices, such as&nbsp;&nbsp;&nbsp;&nbsp; 
    </p>
    <dl>
      <dl>
        <dt>(i) research on regular and special education instructional strategies, or &nbsp;&nbsp;&nbsp;&nbsp; </dt>
      </dl>
      <dd>(ii) research on the effectiveness of or the comparison among instructional techniques, curricula, or classroom management methods.</dd>
    </dl>
    <p>(2) Research involving the use of educational tests (cognitive, diagnostic, aptitude, achievement), survey procedures, interview procedures or observation of public behavior, unless:      </p>
      <blockquote>
        <p>(i) information obtained is recorded in such a manner that human subjects can be identified, directly or through identifiers linked to the subjects; and </p>
        <p>(ii) any disclosure of the human subjects' responses outside the research could reasonably place the subjects at risk of criminal or civil liability or be damaging to the subjects' financial standing, employability, or reputation.</p>
      </blockquote>
      <p >(Please note: Surveys on sensitive or personal topics which may cause stress to study participants may not be exempt from IRB review.)</p>
      <p >(Note: The section of this category pertaining to standardized educational tests may be applied to research involving children. This category may also apply to research with children when the investigator observes public behavior but does NOT participate in that behavior or activity. However this  section is NOT applicable to survey or interview research involving children.)</p>
      <p>(3) Research involving the use of educational tests (cognitive, diagnostic, aptitude, achievement), survey procedures, interview procedures, or observation of public behavior that is not exempt under paragraph (2) of this section, if:      </p>
      <blockquote>
        <p>(i) the human subjects are elected or appointed public officials or candidates for public office; or </p>
        <p>(ii) federal statute(s) require(s) without exception that the confidentiality of the personally identifiable information will be maintained throughout the research and thereafter.</p>
      </blockquote>
      <p>(4) Research involving the collection or study of existing data, documents, records, pathological specimens, or diagnostic specimens, if these sources are publicly available or if the information is recorded by the investigator in such a manner that subjects cannot be identified, directly or through identifiers linked to the subjects.      </p>
      <p >(Example: existing data, records review, pathological specimens)</p>
      <p >(Note: This data must be in existence before the project begins)</p>
      <p>(5) Research and demonstration projects which are conducted by or subject to the approval of department or agency heads, and which are designed to study, evaluate, or otherwise examine:      </p>
      <blockquote>
        <p> (i) public benefit or service programs;</p>
        <p> (ii) procedures for obtaining benefits or services under those programs;</p>
        <p>(iii) possible changes in or alternatives to those programs or procedures; or &nbsp;</p>
        <p> (iv) possible changes in methods or levels of payment for benefits or services under those programs.      </p>
      </blockquote>
      <p >(Note: Exemption category refers to federal government research)</p>
      <p >(6) Taste and food quality evaluation and consumer acceptance studies, </p>
      <blockquote>
        <p> (i)&nbsp; if wholesome foods without additives are consumed or</p>
        <p>(ii) if a food is consumed that contains a food ingredient at or below the level and for a use found to be safe, or agricultural chemical or environmental contaminant at or below the level found to be safe, by the Food and Drug Administration or approved by the Environmental Protection Agency or the Food Safety and Inspection Service of the U.S. Department of Agriculture</p>
      </blockquote></td>
  </tr>
	   
</table>
<tr><td><br><br><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table>
</td>
        </tr></table>
</body>


</html>
<?php
mysql_free_result($Recordset1);
?>

</body>
</html>
