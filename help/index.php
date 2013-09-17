<?php
session_start();
$_POST['page-title'] = "RPS - Help Guide - Table of Contents";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='../styles/index.css' />";
$_POST['page-link2'] = "<link href='../styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='../styles/list.css' rel='stylesheet' type='text/css' />";

$_POST['page-script1'] = "<script src='../scripts/ssm.js' language='JavaScript1.2' type='text/javascript'></script>";
$_POST['page-script2'] = "<script src='../scripts/ssmItems.js' language='JavaScript1.2' type='text/javascript'></script>";
$_POST['page-script3'] = "<script src='../scripts/image.js' language='javascript' type='text/javascript'></script>";


$_POST['page-include-page-top2'] = "true";
include_once '../includes/page-top.php';
include_once '../includes/page-top2.php';
include_once '../utils.php';
?>
<style type="text/css">
    <!--
    .style1 {color: #FFFFFF}
    A.ssmItems:link		{color:black;text-decoration:none;}
    A.ssmItems:hover	{color:black;text-decoration:none;}
    A.ssmItems:active	{color:black;text-decoration:none;}
    A.ssmItems:visited	{color:black;text-decoration:none;}

    #showimage{
        position:absolute;
        visibility:hidden;
        border: 1px solid gray;
    }

    #dragbar{
        cursor: hand;
        cursor: pointer;
        background-color: #EFEFEF;
        min-width: 100px; /*NS6 style to overcome bug*/
    }

    #dragbar #closetext{
        font-weight: bold;
        margin-right: 1px;
    }
    .style2 {color: #FF0000}
    -->
</style>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <!-- content goes here -->
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <div align="left" class="page_heading" style="height:auto; width:auto; margin-left: 20px">Help Guide<span class="style2"></span></div>
        </td>
    </tr>
   
    <tr>
        <td>
            <!-- InstanceBeginEditable name="content" -->
            <div style="padding-left:20px; max-width:95em;">
                <!-- INTRODUCTION -->
                <div class="table_background">
                    <a name="intro" id="intro" class="font_topic_other">&nbsp;INTRODUCTION</a>	</div>
                <p class="font_orange">
                    <strong>The Research Profile (RPS) system provides: </strong>
                </p>
                <ul style="list-style:none; list-style-image:url(../images/bullets/green.png);" class="list_others">
                    <li>Individuals and Organizations easy access to innovation, knowledge, technologies and know-how.</li>
                    <li>Industry access to ideas, talent, and geographic proximity to skilled labor pools and R&amp;D facilities.</li>
                    <li>An infrastructure of opportunities for members to get to know one another, share ideas, and learn and develop trust with increased efficiency.</li>
                </ul>
               <br>
                <p class="font_orange"> 
                    <span class="list_others"><strong></strong></span><strong>Enhancing our Economy: </strong>
                </p>
                <p class="list_others">
		The  ReSearch Profile system (RPS) is a response to the Texas Industry and  Technology clusters in order
		to facilitate problem solving,  collaboration, and technology transfer among research experts and  
		organizations in Academia, Industry and Government. The goal of RPS is  to become a synergistic marketplace to
		transfer knowledge, provide  experts to solve problems, and expand innovation capacity in order to  build 
		new or expand existing markets, provide job growth and develop  wealth.
                </p>
                 <br>
                <p class="font_orange">
                    <strong>Academia&rsquo;s new role: </strong>
                </p>
                <p class="list_others">
		RPS  is a method to transform the culture of Academia to becoming sellers  and marketers of research and ideas.
		The role of academia is catalyzing  the transfer of knowledge and creating an environment for the rapid  
		deployment of that knowledge by speeding the movement of ideas,  innovation and information throughout the marketplace 
		and the economy .Universities<strong> are the nation&rsquo;s greatest &ldquo;untapped&rdquo; resources for spurring 
		economic growth!</strong>
                </p>
                 <br>
                <p>
                    <span class="font_orange"><strong>RPS hosts the following profiles:&nbsp;</strong></span>
                    <span class="details">(click on the profile type to learn more about it)</span>
                </p>
                <ul style="list-style:none" class="list_others">
                    <li><img src="../images/bullets/faculty.gif" alt="1." width="12" height="12" />&nbsp;<a href="#faculty">Faculty Profiles</a></li>
                    <li><img src="../images/bullets/center.gif" alt="2." width="12" height="12" />&nbsp;<a href="#researchcenter">Research Center Profiles</a></li>
                    <li><img src="../images/bullets/technology.gif" alt="3." width="12" height="12" />&nbsp;<a href="#technology">Technology/Intellectual Property Profiles</a></li>
                    <li><img src="../images/bullets/equipment.gif" alt="4." width="12" height="12" />&nbsp;<a href="#equipment">Equipment Profiles</a></li>
                    <!--<li><img src="../images/bullets/facility.gif" alt="5." width="12" height="12" />&nbsp;<a href="#facility">Facility Profiles</a></li>
                    <li><img src="../images/bullets/labgroup.gif" alt="6." width="12" height="12" />&nbsp;<a href="#lab&amp;group">Research Labs/Group Profiles</a></li>
                -->
                </ul>
                <hr width="100%" class="font_orange" />

                <!-- LOGIN -->
                <div class="table_background">
                    <a name="login" id="login" class="font_topic_other">&nbsp;LOGIN</a></div>
                
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/login.jpeg" alt="Login Screenshot" width="120" height="82" border="1" /><br />
                    <a href="screenshots/login.jpeg" onclick="return enlarge('screenshots/login.jpeg',event,'center',402,331)">&nbsp;View Screenshot</a>
                </p>
                <p class="list_others">
		All Texas State Employees can login into rps using their NetID and password.
		The Login section is located at the bottom-left corner of the Home screen as shown below.
                <br>
		Type in your NetID and password in the space provided and press enter or click on the arrow to Login.<br />
		Your NetID is the computer username that you use to login to any computer on campus. 
		If you are not sure what your NetID is, contact helpdesk at 52234 or <a href="mailto:sailaja@txstate.edu?subject=Help with NetID&amp;">helpdesk</a>.
                <!--<a href="mailto:helpdesk@txstate.edu?subject=Help with NetID&amp;cc=sailaja@txstate.edu">helpdesk@txstate.edu</a>. -->
                </p>
                <br>
                <p class="list_others">
		[<a href="http://www.tr.txstate.edu/itac/netid.html">Change your NetID password</a>]&nbsp;&nbsp;
		[<a href="https://catsweb.txstate.edu/app/auth?/app/password" >Reset Password</a>]&nbsp;&nbsp;
                </p>
                <p class="list_others">
		For more information regarding NetID, visit: 
                    <a href="http://www.tr.txstate.edu/itac/netid.html">http://www.tr.txstate.edu/itac/netid.html</a>	</p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FIRST LOGIN -->
                <div class="table_background">
                    <a name="firstlogin" id="firstlogin" class="font_topic_other">&nbsp;FIRST LOGIN</a>
                </div>
               
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/account-info.png" alt="Login Screenshot" width="150" height="80" border="1" /><br />
                    <a href="screenshots/account info.png" onclick="return enlarge('screenshots/account info.png',event,'center',530,228)">&nbsp;View Screenshot</a>	</p>
                 <p class="list_others">
		For first time users a Account Information Screen is presented (shown below). On most occasions this screen would be automatically populated from the information
		in the Texas State University User directory.
                <br> <br>
		Complete the missing the missing information and press Enter or Submit and Proceed to 
		My Dashboard.
                 <br>Details on the Account Information can be changed anytime using the Account
		Information Link on your <a href="myprofiles.htm">My Dashboard</a> page
                </p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>


                <!-- MY PROFILES -->
                <div class="table_background">
                    <a name="myprofiles" class="font_topic_other">&nbsp;MY DASHBOARD</a>
                </div>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/myProfiles.jpeg" alt="My Dashboard Screenshot" width="100" height="80" /><br />
                    <a href="screenshots/myProfiles.jpeg" onclick="return enlarge('screenshots/myProfiles.jpeg',event,'center',688,396)">&nbsp;View Screenshot</a>
                </p>
                <p class="list_others">Profiles in My Dashboard fall under two broad categories:</p>
                <ul style="list-style-image:url(../images/bullets/green.png);" class="list_others">
                    <li>YOUR PROFILES</li>
                    <li>EDITOR FOR </li>
                </ul>
                <p class="list_others">&quot;Your Profiles&quot; lists profiles for which you are the owner. These profiles can only be created by you and edited by you.
                    <br />
	Editors for these profiles can be assigned using the Toolbox.</p>
                <p class="list_others">&quot;Editor For&quot; lists all profiles for which you have been assigned an editor.</p>
                <p class="list_others">If your profile is not in the system, you would have the option to create your faculty and other profiles. View <a href="#createnew">Create New Profile</a> for more information. </p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>


                <!-- CREATING A NEW PROFILE -->
                <div class="table_background">
                    <a name="createnew" id="createnew" class="font_topic_other">&nbsp;CREATE NEW PROFILE</a>
                </div>
                <p class="list_others" align="left">
                    <img src="screenshots/thumbnails/profiles.jpeg" alt="create new profile snapshot" width="150" height="80" /><br />
                    <a href="screenshots/profiles.jpeg" onclick="return enlarge('screenshots/profiles.jpeg',event,'center',703,396)">&nbsp;View Screenshot</a>
                </p>
                <p class="list_others">You can create the following profiles as shown above:</p>
                <ul style="list-style:none" class="list_others">
                    <li><img src="../images/bullets/faculty.gif" alt="1." />&nbsp;<strong>Faculty Profiles</strong> </li>
                    <li>This option will be provided only if your Faculty Profile does not exist - <a href="myprofiles.htm">View My Dashboard</a> for more information</li>
                    <li>&nbsp;</li>
                    <li><img src="../images/bullets/equipment.gif" alt="2." />&nbsp;<strong>Equipment Profiles</strong></li>
                    <li>This profile can also be added as a section in your profile.
			If the details are comprehensive, it is advisable to create it as an independent profile.</li>
                    <li>Use the search (<img src="../images/buttons/find.gif" alt="find button" />) button to check if the equipment profile has already been created to avoid duplication. </li>
                    <li>&nbsp;</li>
                   <!-- <li><img src="../images/bullets/labgroup.gif" alt="3."/>&nbsp;<strong>Lab &amp; Group Profiles</strong></li>
                    <li>Any Lab or Research Group can create their profile.
		However you may want to check if the profile has already been created by using the search (<img src="../images/buttons/find.gif" alt="find button" />) button.</li>
                    <li>&nbsp;</li>
                   -->
                    <li><img src="../images/bullets/center.gif" width="12" height="12" alt="4."/>&nbsp;<strong>Research Center Profiles</strong> </li>
                    <li>These profiles require approval to be created and hence can be requested. Search for your center using the search (<img src="../images/buttons/find.gif" alt="find button" border="0" />) button. If you are convinced that the profile does not exist then, use the request button to request the profile. </li>
                    <li>&nbsp;</li>
                   <!--<li><img src="../images/bullets/facility.gif" width="12" height="12" alt="5."/>&nbsp;<strong>Facility Profiles </strong></li>
                    <li>These profiles require approval to be created and hence can be requested. Search for the facility using the search (<img src="../images/buttons/find.gif" alt="find button" border="0" />) button. If you are convinced that the profile does not exist then, use the request button to request the profile. </li>
                    <li>&nbsp;</li>
                   -->
                    <li><img src="../images/bullets/technology.gif" width="12" height="12" alt="6."/>&nbsp;<strong>Technology Profiles</strong> </li>
                    <li>These profiles require approval to be created and hence can be requested. Search for the technology using the search (<img src="../images/buttons/find.gif" alt="find button" border="0" />) button. If you are convinced that the profile does not exist then, use the request button to request the profile from the Office of Intellectual Property and Technology Transfer. </li>
                </ul>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- PROFILE LAYOUT -->
                <div class="table_background">
                    <a name="layout" id="layout" class="font_topic_other">&nbsp;UNDERSTANDING YOUR PROFILE LAYOUT</a>
                </div>
                <p class="list_others">Each profile has different modes it can be worked on. These options are available
	                       only if a user is logged in and is the owner/editor for the profile.	</p>
                <p class="list_others"><img src="screenshots/diff modes.png" alt="layout" width="642" height="23" /></p>
                <ul style="list-style-image:url(../images/bullets/green.png); font-family:Arial, Helvetica, sans-serif; font-size:12px">
                    <li><strong>Edit Mode:</strong> Edit Mode takes you to the Editing view of your profile. All Hidden Content is also visible in the mode.
		    Any content on the page can be added,edited or updated using this mode. See the list of buttons below to learn more
			about how to edit the content		</li>
                    <li><strong>View Mode:</strong> This is a preview mode of how a visitor will see your profile. Any content that has been made
			hidden is not displayed here. Also only sections with content are visible to the visitor.		</li>
                    <li><strong>Toolbox:</strong> Toolbox allows to change the settings for your profile.
                        <a href="#toolbox">Read more about Toolbox.</a>		</li>
                </ul>
                <p class="font_topic">COMMONLY USED BUTTONS </p>
                <ul style="list-style:none" class="list_others">
                    <li><img src="../images/buttons/edit.gif" alt="1." width="12" height="12" />&nbsp;<strong>Edit</strong></li>
                    <li>This allows for editing content of any section/information/details.</li>
                    <li>To use this feature click on the edit button and it would direct you to the editable page or provide editable fields</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/bullets/save.gif" alt="2." width="13" height="12" />&nbsp;<strong>Save</strong></li>
                    <li>This allows to save your current changes. Once all changes are done, click this icon to save the changes and view them.</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/cancel.gif" width="14" height="13" alt="3."/>&nbsp;<strong>Cancel</strong></li>
                    <li>If you are in the middle of editing any section and wish to undo or cancel your changes please use the cancel button.</li>
                    <li>Please remember once any changes are saved they cannot be cancelled. Cancel can be used only while you are editing.</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/add.gif" width="12" height="12" alt="4."/>&nbsp;<strong>Add</strong></li>
                    <li>This button can be used to Add more entries to any section (when applicable). It is also used to add new sections through toolbox</li>
                    <li>On clicking this icon, one or more blank fields are presented to enter new content. Use the save button to add the new fields once done.</li>
                    <li>&nbsp;</li>


                    <li><img src="../images/buttons/delete.gif" width="11" height="13" alt="5."/>&nbsp;<strong>Delete</strong></li>
                    <li>This button deletes the selected row or the entire section.</li>
                    <li>Once clicked it asks for your confirmation. You can cancel the action by saying No. If you pick yes, then the data is permanently deleted</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/addrow.png" width="16" height="16" alt="6."/>&nbsp;<strong>Add Row</strong></li>
                    <li>You would come across this button when you are adding members to centers or equipments to your profile.</li>
                    <li>This button allows you to add a row of data to your selection</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/deleterow.png" width="16" height="16" alt="7."/>&nbsp;<strong>Delete Row</strong></li>
                    <li>You would come across this button when you are editing member/equipment etc's list</li>
                    <li>You can remove a row of data from your selection this button.</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/right-arrow.gif" width="12" height="12" alt="8."/>&nbsp;<strong>Expand Content</strong></li>
                    <li>This button next to content indicates that the content is collapsible.</li>
                    <li>More information can be obtained about the content by clicking on this button located in front of it.</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/down-arrow.gif" width="12" height="12" alt="9."/>&nbsp;<strong>Collapse Content</strong></li>
                    <li>This button shows that the section/information is already expanded.</li>
                    <li>Click on this icon to collapse the content.</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/find.gif" width="16" height="16" alt="10."/>&nbsp;<strong>Find or Search</strong></li>
                    <li>This button is used to search for people/equipments/technologies to add it to a profile.</li>
                    <li>It can also be used to search for existing content in rps.</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/request.gif" width="12" height="12" alt="11."/>&nbsp;<strong>Request</strong></li>
                    <li>Certain profiles cannot be created. They need to be requested. </li>
                    <li>Use this button to request a profile. View <a href="createnew.htm">Create a New profile</a> for more information</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/view.png" width="12" height="12" alt="12."/>&nbsp;<strong>View/Associated Profiles</strong></li>
                    <li>Use this button to view a profile or view Associated Profiles for any profile</li>
                    <li>&nbsp;</li>

                    <li><img src="../images/buttons/close.gif" width="21" height="21" alt="12."/>&nbsp;<strong>Close Window</strong></li>
                    <li>This button closes a window that is open is located in the top right hand corner of the window.</li>
                    <li>&nbsp;</li>
                </ul>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACULTY -->
                <div class="table_background">
                    <a name="faculty" id="faculty" class="font_topic_other">&nbsp;FACULTY</a>
                </div>
                <p class="list_others">Faculty Profile is built to allow Texas State University faculty to create an individual web page.
	Aside from the Core Sections/Data Elements and or Subsections there are data elements that would be 
	necessary for the automatic generation of Biosketches and CV's.
                    <br />
	Faculty Profiles also gives an option to include descriptive links to labs or other group web pages along with keywords eliminating the need to create separate profiles for them if not required and yet making them searchable.</p>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/faculty/sample faculty profile.jpeg" alt="Sample Faculty Profile" width="120" height="80" /><br />
                    <a href="screenshots/faculty/sample faculty profile.jpeg" onclick="return enlarge('screenshots/faculty/sample faculty profile.jpeg',event,'center',703,767)">&nbsp;View Screenshot</a>
                </p>
                <p class="list_others">Here is a sample faculty profile. The core sections for a faculty profile are presented by default. New Section can be customized and added by using the Toolbox.</p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>


                <!-- RESEARCH CENTERS -->
                <div class="table_background">
                    <a name="researchcenter" id="researchcenter" class="font_topic_other">&nbsp;RESEARCH CENTER</a>
                </div>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/research center/sample research center profile.jpeg" alt="Sample Research Center Profile" width="120" height="80" /><br />
                    <a href="screenshots/research center/sample research center profile.jpeg" onclick="return enlarge('screenshots/research center/sample research center profile.jpeg',event,'center',703,772)">&nbsp;View Screenshot</a>
                </p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- TECHNOLOGY PROFILES -->
                <div class="table_background">
                    <a name="technology" id="technology" class="font_topic_other">&nbsp;TECHNOLOGY</a>
                </div>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/technology/sample-technology-profile.jpeg" alt="Sample Technology Profile" width="120" height="100" /><br />
                    <a href="screenshots/technology/sample-technology-profile.jpeg" onclick="return enlarge('screenshots/technology/sample-technology-profile.jpeg',event,'center',703,705)">&nbsp;View Screenshot</a>
                </p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACILITY PROIFLE
                <div class="table_background">
                    <a name="Facility" id="Facility" class="font_topic_other">&nbsp;FACILITY</a>
                </div>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/facility/sample-facility-profile.jpeg" alt="Sample Facility Profile" width="120" height="100" /><br />
                    <a href="screenshots/facility/sample-facility-profile.jpeg" onclick="return enlarge('screenshots/facility/sample-facility-profile.jpeg',event,'center',703,664)">&nbsp;View Screenshot</a>
                </p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>
 -->
                <!-- EQUIPMENT PROFILE -->
                <div class="table_background">
                    <a name="equipment" id="equipment" class="font_topic_other">&nbsp;EQUIPMENT</a>
                </div>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/equipment/sample-equipment-profile.jpeg" alt="Sample Equipment Profile" width="100" height="80" /><br />
                    <a href="screenshots/equipment/sample-equipment-profile.jpeg" onclick="return enlarge('screenshots/equipment/sample-equipment-profile.jpeg',event,'center',986,351)">&nbsp;View Screenshot</a>
                </p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- LABS& GROUP PROFILE
                <div class="table_background">
                    <a name="labs" id="labs" class="font_topic_other">&nbsp;LABORATORIES AND RESEARCH GROUPS</a>
                </div> -->
                <!--INSERT SCREENSHOT -->
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>


                <!-- FACULTY CONTACT INFORMATION -->
                <div class="table_background">
                    <a name="facul_contactinfo" id="facul_contactinfo" class="font_topic_other">&nbsp;FACULTY CONTACT INFORMATION</a>
                </div>
                <p class="list_others">Basic Details like Mailing address, Office Location, Various Descriptive URL's etc can be maintained here. Keywords are an important aspect of the profile. The Keywords constitute the meta tags that enables your profile to be searched by external search engines. </p>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/faculty/contact-info.jpeg" alt="Faculty - Contact Information" width="100" height="50" /><br />
                    <a href="screenshots/faculty/contact-info.jpeg" onclick="return enlarge('screenshots/faculty/contact-info.jpeg',event,'center',990,159)">&nbsp;View Screenshot</a>
                </p>
                <p class="list_others">The picture below is a screenshot of the edit mode for the Contact Information. </p>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/faculty/contact-info-edit.jpeg" alt="Faculty - Editing Contact Information" width="100" height="50" /><br />
                    <a href="screenshots/faculty/contact-info-edit.jpeg" onclick="return enlarge('screenshots/faculty/contact-info-edit.jpeg',event,'center',988,237)">&nbsp;View Screenshot</a>
                </p>
                <p class="list_others">&nbsp;</p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACULTY RESEARCH INTERESTS -->
                <div class="table_background">
                    <a name="facul_re" id="facul_re" class="font_topic_other">&nbsp;RESEARCH &amp; EXPERTISE</a>
                </div>
                <p class="list_others">Describes the areas of research you are involved in or are an expert add. </p>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/faculty/research &amp; expertise edit.jpeg" alt="Faculty - Research Expertise" width="100" height="36" /><br />
                    <a href="screenshots/faculty/research &amp; expertise edit.jpeg" onclick="return enlarge('screenshots/faculty/research &amp; expertise edit.jpeg',event,'center',813,290)">&nbsp;View Screenshot</a>	</p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACULTY APPOINTMENTS -->
                <div class="table_background">
                    <a name="facul_app" id="facul_app" class="font_topic_other">&nbsp;FACULTY - APPOINTMENTS</a>
                </div>
                <p class="list_others">List all of your  previous positions including current positions.</p>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/faculty/appiontments edit.jpg" alt="Faculty - Appointments" width="100" height="60" /><br />
                    <a href="screenshots/faculty/appiontments edit.jpg" onclick="return enlarge('screenshots/faculty/appiontments edit.jpg',event,'center',813,178)">&nbsp;View Screenshot</a>	</p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACULTY PUBLICATIONS -->
                <div class="table_background">
                    <a name="facul_pub" id="facul_pub" class="font_topic_other">&nbsp;FACULTY - PUBLICATIONS</a>
                </div>
                <p class="list_others">List all of your  completed and published works.</p>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/faculty/publication edit.jpg" alt="Faculty - Publications" width="100" height="57" /><br />
                    <a href="screenshots/faculty/publication edit.jpg" onclick="return enlarge('screenshots/faculty/publication edit.jpg',event,'center',810,465)">&nbsp;View Screenshot</a>	</p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACULTY PRESENTATIONS & PROJECTS -->
                <div class="table_background">
                    <a name="facul_pandp" id="facul_pandp" class="font_topic_other">&nbsp;FACULTY - PRESENTATIONS &amp; PROJECTS</a>
                </div>
                <p class="list_others">This sections allows to add your presentations and projects that do not fit in the publication category. </p>
                <p class="list_others" ><img src="screenshots/faculty/presentations & projects edit.jpg" alt="Login Screenshot" width="700" height="500" /></p>&nbsp;
                <p class="list_others" ><img src="screenshots/faculty/presentations & projects edit.jpg" alt="Login Screenshot" width="700" height="500" /></p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACULTY TEACHING -->
                <div class="table_background">
                    <p class="font_topic_other"><a name="faculty_teaching" id="faculty_teaching" class="font_topic_other"></a>&nbsp;FACULTY - TEACHING</p>
                </div>
                <p class="list_others">Add courses taught in the current, previous and/or future semesters and upload syllabi for that course</p>
                <p class="list_others" style="float:left; padding-right:10px;">
                    <img src="screenshots/thumbnails/faculty/teaching.jpg" alt="Faculty - Teaching" width="100" height="135" /><br />
                    <a href="screenshots/faculty/teaching.jpg" onclick="return enlarge('screenshots/faculty/teaching.jpg',event,'center',961,1298)">&nbsp;View Screenshot</a>	</p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACULTY NEWS & ANNOUNCEMENTS -->
                <div class="table_background">
                    <p class="font_topic_other"><a name="facul_nanda" id="facul_nanda" class="font_topic_other"></a>&nbsp;FACULTY - NEWS &amp; ARTICLES</p>
                </div>
                <p class="list_others">Add any news relevant to your profile. Also any news published on Texas State websites/magazines would be automatically provided as a link &quot;Read Other Online News Articles&quot;. </p>
                <p class="list_others" ><img src="screenshots/faculty/news & articles.jpg" alt="Login Screenshot" width="780" height="90" /></p>
                <p class="list_others"><img src="screenshots/faculty/news & articles add.jpg" alt="Login Screenshot" width="813" height="308" /></p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>


                <!-- FACULTY AFFILIATION -->
                <div class="table_background">
                    <a name="facul_aff" id="facul_aff" class="font_topic_other">&nbsp;FACULTY - AFFILIATIONS</a>
                </div>
                <p class="list_others"> content.............. </p>
                <p class="list_others" ><img src="screenshots/faculty/affiliations.jpg" alt="Login Screenshot" width="812" height="90" /></p>
                <p class="list_others" ><img src="screenshots/faculty/affiliations%20edit.jpg" alt="Login Screenshot" width="812" height="329" /></p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACULTY SUPPORT -->
                <div class="table_background">
                    <a name="facul_support" id="facul_support" class="font_topic_other">&nbsp;FACULTY _ SUPPORT</a>
                </div>
                <p class="list_others">List  ongoing, completed or pending research projects in this section.  </p>
                <p class="list_others" ><img src="screenshots/faculty/support.jpg" alt="Login Screenshot" width="815" height="250" /></p>
                <p class="list_others" ><img src="screenshots/faculty/support%20edit.jpg" alt="Login Screenshot" width="814" height="184" /></p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- FACULTY AWARDS & HONORS 
                <div class="table_background">
                    <a name="facul_aandh" id="facul_aandh" class="font_topic_other">&nbsp;FACULTY - AWARDS &amp; HONORS</a>
                </div>
                <p class="list_others" ><img src="screenshots/faculty/Awards%20&%20honors.png" alt="Login Screenshot" width="813" height="145" /></p>
                <p class="list_others" ><img src="screenshots/faculty/Awards%20&%20honors%20edit.png" alt="Login Screenshot" width="813" height="225" /></p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div> -->

                <!-- FACULTY ADDITIONAL INFO -->
                <div class="table_background">
                    <a name="facul_addinfo" id="facul_addinfo" class="font_topic_other">&nbsp;FACULTY - ADDITIONAL INFORMATION</a>
                </div>
                <p class="list_others" ><img src="screenshots/faculty/additional%20info.jpg" alt="Login Screenshot" width="815" height="140" /></p>
                <p class="list_others">&nbsp;</p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- RESEARCH CENTER ABOUT US -->
                <div class="table_background">
                    <a name="recen_about" id="recen_about" class="font_topic_other">&nbsp;RESEARCH CENTER _ ABOUT US</a>
                </div>
                <p class="list_others"><img src="screenshots/research center/about.jpg" alt="Login Screenshot" width="780" height="171" /></p>
                <p class="list_others"><img src="screenshots/research center/about edit.jpg" alt="Login Screenshot" width="800" height="233" /></p>
                <p class="list_others">&nbsp;</p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- RESEARCH CENTER RESEARCH & SERVICES -->
                <div class="table_background">
                    <a name="recen_reservices" id="recen_reservices" class="font_topic_other">&nbsp;RESEARCH CENTER - RESEARCH / SERVICES</a>
                </div>
                <p class="list_others" ><img src="screenshots/research center/research &amp; service.jpg" alt="Login Screenshot" width="800" height="80" /></p>
                <p class="list_others" ><img src="screenshots/research center/research &amp; service edit.jpg" alt="Login Screenshot" width="814" height="250" /></p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>

                <!-- RESEARCH CENTER PUBLICATIONS -->
                <div class="table_background">
                    <a name="recen_publications" id="recen_publications" class="font_topic_other">&nbsp;RESEARCH CENTER - PUBLICATIONS </a>
                </div>
                <p class="list_others"><img src="screenshots/research center/publications.jpg" alt="Login Screenshot" width="813" height="190" /></p>
                <p class="list_others" ><img src="screenshots/research center/publication%20edit.jpg" alt="Login Screenshot" width="810" height="465" /></p>
                <div style="clear:both"><hr width="100%" class="font_orange" /></div>
                <div id="showimage"></div>

                
           <p>
                <a href="https://www.google.com/accounts/ServiceLogin?service=analytics&passive=true&nui=1&hl=en&continue=https://www.google.com/analytics/settings/&followup=https://www.google.com/analytics/settings/&userexp=signup" target="_blank" class="rsp">Traffic check tool</a><br />
            </p>
       
            </div>
            <!-- InstanceEndEditable -->	</td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><!-- Page footer -->
        <td align="center">
            <p align="center"><img src="images/line.jpg" alt="" width="700" height="1"/></p>
           <p>
               <b> <a href="http://www.uta.edu/research/collaborate/" target="_blank" class="rsp">powering - The Partnership</a></b><br />
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</div>
</div>
</body>
<!-- InstanceEnd --></html>
