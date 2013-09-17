



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
          
            </span></td>
 
  </tr>
</tbody></table> 

</td></tr><tr><td><table width="100%" bgcolor="#FFFFFF" border="0">

 <tr>
    <td bgcolor="#000000" align="center">
   <a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a><br>
     
      </td></tr>
		<tr><td> 
      <p align="center">&nbsp;</p>
      <p align="center"><?php echo $_SESSION['name'];?></p></td>
        </tr>
 <tr><td>
     <h5 align="center"><p>APPLICATION FOR IRB EXEMPTION </h5>
     <p>This is your IRB Exemption Application Number: <font color="#CC0033"><?php echo $_POST['expNum'];?></font></p><hr />
<form action="<?php echo $editFormAction; ?>" method="POST" name="irb_exemption_form" id="irb_exemption_form" >

  <input type="hidden" name="expNum" value="<?php echo $_POST['expNum'];?>" />
 
  
    <h5>Section I </h5>
	   <font color = "red"> For classroom project, only one application is required for the whole class. The application MUST be submitted by the faculty member teaching the class! "Academic/Classroom Project" must be selected from the drop-down list For question 1. </font><br>
  </td></tr>
  
    <tr>
      <td>1.&nbsp; This project is&nbsp;
        <label for="label"></label>
        <select name="sponsorship" id="sponsorship">
       <OPTION></OPTION>
          <option <?php if ($_POST['sponsorship']=="Funded Research") echo "selected";?> value="Funded Research">Funded Research 
		  
		  </option>
          <option <?php if ($_POST['sponsorship']=="Other Sponsored Program/Contract") echo "selected";?> value="Other Sponsored Program/Contract">Other Sponsored Program/Contract
		  
		  </option>
          <option <?php if ($_POST['sponsorship']=="FACULTY non-funded Research") echo "selected";?> value="FACULTY non-funded Research">FACULTY non-funded Research
	
		  </option>
          <option <?php if ($_POST['sponsorship']=="Thesis/Dissertation") echo "selected";?> value="Thesis/Dissertation">Thesis/Dissertation</option>
		  	
          <option <?php if ($_POST['sponsorship']=="Academic/Classroom Project") echo "selected";?> value="Academic/classroom project">Academic/Classroom Project
		  
		  </option>
          <option <?php if ($_POST['sponsorship']=="Institutional/Admin Program") echo "selected";?>  value="Institutional/Admin Program">Institutional/Admin Program
		   
		  </option>
          <option <?php if ($_POST['sponsorship']=="Other") echo "selected";?> value="Other">Other
		  
		  </option>
        </select></td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    </tr>
    <tr>
      <td>2.&nbsp; If you are a student, please provide your supervising faculty member's full name: </td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp; Faculty Name (N/A, if not a student)
        <input name="FacultyName" type="text" id="FacultyName" value="<?php echo $_POST['FacultyName' ];?>" size="35" /></td>
    </tr>
    <tr>
      <td><h5><br>
        Section II </h5></td>
    </tr>
    <tr>
      <td>1.&nbsp; If this is  an academic or classroom project, does the scope extend beyond Texas State University? </td>
    </tr>
    <tr>
      <td>&nbsp;
      <label>
          <input name="II_1_academic_project" type="radio" value="Yes" <?php if ($_POST['II_1_academic_project']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_1_academic_project" type="radio" value="No" <?php if ($_POST['II_1_academic_project']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>2.&nbsp; Would you describe this project as &quot;a systematic investigation, designed to develop or contribute to generalizable knowledge? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_2_contribute_knowledge" type="radio" value="Yes" <?php if ($_POST['II_2_contribute_knowledge']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_2_contribute_knowledge" type="radio" value="No" <?php if ($_POST['II_2_contribute_knowledge']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>3.&nbsp; Will the results of your project be put on the internet, shared at a conference, published, or otherwise disseminated? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
<input name="II_3_share_results" type="radio" value="Yes" <?php if ($_POST['II_3_share_results']=="Yes") echo "checked";?>/> 
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_3_share_results" type="radio" value="No" <?php if ($_POST['II_3_share_results']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>4.&nbsp;Will identifiable private information from individuals be collected from contact with research participants ? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_4_interact_people" type="radio" value="Yes" <?php if ($_POST['II_4_interact_people']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_4_interact_people" type="radio" value="No" <?php if ($_POST['II_4_interact_people']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>5.&nbsp; Will identifiable private information from individuals be collected from other sources (e.g. medical records)? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_5_collect_info" type="radio" value="Yes" <?php if ($_POST['II_5_collect_info']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_5_collect_info" type="radio" value="No" <?php if ($_POST['II_5_collect_info']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>6.&nbsp; Does the project involve fetuses, pregnant women or human in vitro fertilization? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_6_involve_pregnant" type="radio" value="Yes" <?php if ($_POST['II_6_involve_pregnant']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_6_involve_pregnant" type="radio" value="No" <?php if ($_POST['II_6_involve_pregnant']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>7.&nbsp; Does the project involve prisoners? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_7_involve_prisoners" type="radio" value="Yes" <?php if ($_POST['II_7_involve_prisoners']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_7_involve_prisoners" type="radio" value="No" <?php if ($_POST['II_7_involve_prisoners']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>8.&nbsp; Does the project involve any persons who are mentally impaired or homeless  or  who have limited autonomy? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_8_involve_vulnerable" type="radio" value="Yes" <?php if ($_POST['II_8_involve_vulnerable']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_8_involve_vulnerable" type="radio" value="No" <?php if ($_POST['II_8_involve_vulnerable']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>9.&nbsp; Does the project involve the review of medical records if the information is recorded in such a way that subjects can be indentified, directly or through identifiers linked to the subjects? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
<input name="II_9_medical_identifiers" type="radio" value="Yes" <?php if ($_POST['II_9_medical_identifiers']=="Yes") echo "checked";?>/> 
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_9_medical_identifiers" type="radio" value="No" <?php if ($_POST['II_9_medical_identifiers']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>10. Does the project involve survey or interview techniques which include minors as subjects in which the researcher(s) participate in the activities being observed? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_10_minor_subjects" type="radio" value="Yes" <?php if ($_POST['II_10_minor_subjects']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_10_minor_subjects" type="radio" value="No" <?php if ($_POST['II_10_minor_subjects']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>11. Will a drug, biological product, medical device, or other product regulated by the FDA be used in this project? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_11_FDAproduct_used" type="radio" value="Yes" <?php if ($_POST['II_11_FDAproduct_used']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_11_FDAproduct_used" type="radio" value="No" <?php if ($_POST['II_11_FDAproduct_used']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>12. Will the participants be asked to ingest substances of any kind?</td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_12_ingest_substance" type="radio" value="Yes" <?php if ($_POST['II_12_ingest_substance']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_12_ingest_substance" type="radio" value="No" <?php if ($_POST['II_12_ingest_substance']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>13. Will the participants be asked to perform any physical tasks? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_13_physical_tasks" type="radio" value="Yes" <?php if ($_POST['II_13_physical_tasks']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_13_physical_tasks" type="radio" value="No" <?php if ($_POST['II_13_physical_tasks']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>14. Does the research attempt to influence or change participants' behavior, perception, or cognition? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_14_influence_behavior" type="radio" value="Yes" <?php if ($_POST['II_14_influence_behavior']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_14_influence_behavior" type="radio" value="No" <?php if ($_POST['II_14_influence_behavior']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>15. Does the project involve questions or discussions of sensitive or deeply personal aspects of the subject's behavior, life experiences or attitudes?&nbsp; Examples include substance abuse, sexual activity, sexual orientation, sexual abuse, criminal behavior, sensitive demographic data, detailed health history, etc. </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_15_sensitive_discussion" type="radio" value="Yes" <?php if ($_POST['II_15_sensitive_discussion']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_15_sensitive_discussion" type="radio" value="No" <?php if ($_POST['II_15_sensitive_discussion']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>16. Does the project involve techniques which expose the subject to discomfort, harassment, embarrassment, stigma, alarm or fear beyond levels encountered in the daily life of a healthy individual? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_16_exposeto_discomfort" type="radio" value="Yes" <?php if ($_POST['II_16_exposeto_discomfort']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_16_exposeto_discomfort" type="radio" value="No" <?php if ($_POST['II_16_exposeto_discomfort']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>17. Does the project involve the deception of subjects? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_17_subject_deception" type="radio" value="Yes" <?php if ($_POST['II_17_subject_deception']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_17_subject_deception" type="radio" value="No" <?php if ($_POST['II_17_subject_deception']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td>18. Does the project involve videotaping or audiotaping of subjects? </td>
    </tr>
    <tr>
      <td>&nbsp;
          <label>
          <input name="II_18_taping_subjects" type="radio" value="Yes" <?php if ($_POST['II_18_taping_subjects']=="Yes") echo "checked";?>/>
Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>
<input name="II_18_taping_subjects" type="radio" value="No" <?php if ($_POST['II_18_taping_subjects']=="No") echo "checked";?>/>
No</label>      </td>
    </tr>
    <tr>
      <td><h5><br>
        Section III </h5></td>
    </tr>
    <tr>
      <td><a name="SectionIIIQuestion2" id="SectionIIIQuestion2"></a>1.&nbsp; If you are choosing one of the <a href="#categories_of_exemption">six federal categories of exemption</a>, which <strong>one</strong> are you choosing?<br />
        <span class="style9">**</span>If your project falls under more than one exemption, choose the one that is most applicable.&nbsp; You may cite the others in #3 below. </td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;
        <label>
        <select name="III_1_exempt_category" id="III_1_exempt_category">
        <OPTION></OPTION>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 1 (i)") echo "selected";?> value="Category 1 (i)">Category 1 (i)
		  
		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 1 (ii)") echo "selected";?>	value="Category 1 (ii)">Category 1 (ii) 
		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 2") echo "selected";?> value="Category 2">Category 2
		  
		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 3 (i)") echo "selected";?> value="Category 3 (i)">Category 3 (i)
			  
		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 3 (ii)") echo "selected";?> value="Category 3 (ii)">Category 3 (ii)

		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 4") echo "selected";?> value="Category 4">Category 4

		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 5 (i)") echo "selected'";?> value="Category 5 (i)">Category 5 (i)
		 
		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 5 (ii)") echo "selected";?> value="Category 5 (ii)">Category 5 (ii)
  
		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 5 (iii)") echo "selected";?> value="Category 5 (iii)">Category 5 (iii)
		  
		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 5 (iv)") echo "selected'";?> value="Category 5 (iv)">Category 5 (iv)
	 	  
		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 6 (i)") echo "selected";?> value="Category 6 (i)">Category 6 (i)
			  
		  </option>
          <option <?php if ($_POST['III_1_exempt_category']=="Category 6 (ii)") echo "selected'";?> value="Category 6 (ii)">Category 6 (ii)
			  
		  </option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td> <strong>Please note for questions 2, 3, and 4
        :&nbsp; The text areas are  limited to 2000 characters/approximately 300 words.&nbsp; Even though you are allowed to type more than the specified limit, those additional words/characters will be cropped/cut off when you move to the next question.</strong></td>
    </tr>
    <tr>
      <td>2.&nbsp; What is the purpose of the project? (300 words or less)</td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp; <label>
        <textarea name="III_2_project_purpose" cols="100" rows="10" id="III_2_project_purpose" onChange="checkInputSize(this, 2000)"><?php echo $_POST['III_2_project_purpose'];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td>3.&nbsp; Explain how this exemption category pertains to your project: (300 words or less) </td>
    </tr>
    <tr>
      <td><label>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="III_3_category_pertains" cols="100" rows="10" id="III_3_category_pertains" onChange="checkInputSize(this, 2000)"><?php echo $_POST['III_3_category_pertains'];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td>4.&nbsp; If you believe your project poses no risk to human participants or should be exempt from IRB review for other reasons, please explain: (300 words or less) </td>
    </tr>
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp; <label>
        <textarea name="III_4_exempt_reason" cols="100" rows="10" id="III_4_exempt_reason" onChange="checkInputSize(this, 2000)" ><?php echo $_POST['III_4_exempt_reason'];?></textarea>
      </label></td>
    </tr>
    <tr>
      <td><div align="center">
	   <input type="hidden" name="username" value="<?php echo $_SESSION['username'];?>" />
        <input type="submit" name="Submit" value="Submit and Return Home" />
      </div></td>
    </tr>
    <tr>
      <td><hr></td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="irb_exemption_form">
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><h5><a name="categories_of_exemption" id="CategoriesofExemption"></a>Categories of Exemption:&nbsp;&nbsp; (<a href="#SectionIIIQuestion2">Return to Section III, Question 2</a>) 
    </h5>
    <p>Exempt Categories of Research listed at 45 CFR, Part 46, Sec. 101(b)<br />
        <br />
        (1) Research conducted in established or commonly accepted educational settings, involving normal educational practices, such as</p>
      <blockquote>
        <p>(i) research on regular and special education instructional strategies, or </p>
        <p>(ii) research on the effectiveness of or the comparison among instructional techniques, curricula, or classroom management methods.</p>
      </blockquote>
      2) Research involving the use of educational tests (cognitive, diagnostic, aptitude, achievement), survey procedures, interview procedures or observation of public behavior, unless:
      <blockquote>
        <p>(i) information obtained is recorded in such a manner that human subjects can be identified, directly or through identifiers linked to the subjects; and </p>
        <p>(ii) any disclosure of the human subjects' responses outside the research could reasonably place the subjects at risk of criminal or civil liability or be damaging to the subjects' financial standing, employability, or reputation.</p>
      </blockquote>
      <p >(<span class="style7">Please note</span>: Surveys on sensitive or personal topics which may cause stress to study participants may not be exempt from IRB review.)</p>
      <p >(<span class="style7">Note</span>: The section of this category pertaining to standardized educational tests may be applied to research involving children. This category may also apply to research with children when the investigator observes public behavior but does NOT participate in that behavior or activity. However this  section is NOT applicable to survey or interview research involving children.)</p>
      (3) Research involving the use of educational tests (cognitive, diagnostic, aptitude, achievement), survey procedures, interview procedures, or observation of public behavior that is not exempt under paragraph (2) of this section, if:
      <blockquote>
        <p>(i) the human subjects are elected or appointed public officials or candidates for public office; or </p>
        <p>(ii) federal statute(s) require(s) without exception that the confidentiality of the personally identifiable information will be maintained throughout the research and thereafter.</p>
      </blockquote>
      (4) Research involving the collection or study of existing data, documents, records, pathological specimens, or diagnostic specimens, if these sources are publicly available or if the information is recorded by the investigator in such a manner that subjects cannot be identified, directly or through identifiers linked to the subjects.
      <p >(Example: existing data, records review, pathological specimens)</p>
      <p >(<span class="style7">Note</span>: This data must be in existence before the project begins)</p>
      (5) Research and demonstration projects which are conducted by or subject to the approval of department or agency heads, and which are designed to study, evaluate, or otherwise examine:
      <blockquote>
        <p>(i) Public benefit or service programs;</p>
        <p><span >(ii) procedures for obtaining benefits or services under those programs;</span></p>
        <p> <span >(iii) possible changes in or alternatives to those programs or procedures; or</span></p>
        <p> <span >(iv) possible changes in methods or levels of payment for benefits or services under those programs.</span></p>
        <p>(<span class="style7">Note</span>: Exemption category refers to federal government research)</p>
      </blockquote>
      <p >(6) Taste and food quality evaluation and consumer acceptance studies.</p>
      <blockquote>
        <p>(i)&nbsp; if wholesome foods without additives are consumed or </p>
        <p>(ii) if a food is consumed that contains a food ingredient at or below the level and for a use found to be safe, or agricultural chemical or environmental contaminant at or below the level found to be safe, by the Food and Drug Administration or approved by the Environmental Protection Agency or the Food Safety and Inspection Service of the U.S. Department of Agriculture</p>
      </blockquote>     
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
</td></tr></table>
</body>

<?php
