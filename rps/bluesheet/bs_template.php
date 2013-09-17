<?php
include '../utils.php';

session_start();
$connect1 = $connect = $db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);


if (isset($_GET['edit'])) {
    $edit = true;
    $bs_id = $_GET['bs_id'];
}
else
    $edit = false;

if (isset($_GET['pid']))
    $pid = $_GET['pid'];
else
    $pid = -1;

if (isset($_GET['bs_name']))
    $bs_name = $_GET['bs_name'];

if (isset($_GET['bs_comments']))
    $bs_comments = $_GET['bs_comments'];

if (($edit == true) && ($pid == -1)) {
    die("Cannot edit without any pid");
}
else if ($edit == true) {
    //echo "<pre>";

    // get all the fields from database and populate into variables so that they can
    // be displayed in the form.
    $query = "SELECT *, DATE_FORMAT(prj_period_from,'%m/%d/%Y') as prj_period_from1, DATE_FORMAT(prj_period_to,'%m/%d/%Y') as prj_period_to1 FROM bs_info where bs_id = " . $bs_id;
    $result = mysql_query($query, $connect1);
    echo mysql_error($connect1);
    while($row = mysql_fetch_array($result)) {
        //print_r($row);
        $sc1 = $row["special_considerations_1"];
        $sc2 = $row["special_considerations_2"];
        $sc3 = $row["special_considerations_3"];
        $sc4 = $row["special_considerations_4"];
        $sc5 = $row["special_considerations_5"];
        $sc6 = $row["special_considerations_6"];
        $fna = $row["fna_percent"];
        $laser_devices = $row["laser_devices"];
        $radiation_producing_machines = $row["radiation_producing_machines"];
        $controlled_substances = $row["controlled_substances"];
        $radioactive_materials = $row["radioactive_materials"];
        $select_agents = $row["select_agents"];
        $biological_agents = $row["biological_agents"];
        $recombinant_dna = $row["recombinant_dna"];
        $vertebrate_animals = $row["vertebrate_animals"];
        $human_subjects = $row["human_subjects"];
        $prj_period_from = $row["prj_period_from1"];
        $prj_period_to = $row["prj_period_to1"];
        $abstract = $row["abstract"];
        $prev_acct_number = $row["prev_acct_number"];
        $proposal_type = $row["proposal_type"];
        $proposal_title = $row["proposal_title"];
        $sp_id = $row["sp_id"];
        $pi_id = $row["pi_id"];
        $bs_name = $row["bs_name"];
        $bs_comments = $row["bs_comments"];
        $bs_status = $row["bs_status"];

        $bluesheet_exists = true;
    }

    if (!isset($bluesheet_exists)) {
        real_redirect("../researchspace.php", "view=2", $connect1);
    }

    // get the PI
    $query = "SELECT * FROM bs_i_info where bs_id=".$bs_id." AND i_id=" . $pi_id;
    $result = mysql_query($query, $connect1);
    while($row = mysql_fetch_array($result)) {
        //print_r($row);
        $pi_name = $row["name"];
        $pi_dept = $row["dept"];
        $pi_box_number = $row["box_number"];
        $pi_phone = $row["phone"];
        $pi_email = $row["email"];
        $pi_rank = $row["rank"];
        $pi_citizenship = $row["citizenship"];
    }

    // get the Co-PIs
    $copiCount = 0;
    $query = "SELECT * FROM bs_i_info where bs_id = ".$bs_id." AND i_id <> " . $pi_id;
    $result = mysql_query($query, $connect1);
    while($row = mysql_fetch_array($result)) {
        //print_r($row);
        $copi_name[$copiCount] = $row["name"];
        $copi_dept[$copiCount] = $row["dept"];
        $copi_box_number[$copiCount] = $row["box_number"];
        $copi_phone[$copiCount] = $row["phone"];
        $copi_email[$copiCount] = $row["email"];
        $copi_rank[$copiCount] = $row["rank"];
        $copi_citizenship[$copiCount] = $row["citizenship"];
        $copi_login_id[$copiCount] = $row["loginid"];
        $copiCount++;
    }
    // get the sponsor information for this bluesheet
    $query = "SELECT submission_method, sponsor, prime_sponsor, contact_name, phone, email, address, number_of_copies, shipment_method, sponsor_link, DATE_FORMAT(deadline,'%m/%d/%Y') as deadline1 FROM bs_sponsor_info where bs_id=".$bs_id." AND sp_id=" . $sp_id;
    $result = mysql_query($query, $connect1);
    while($row = mysql_fetch_array($result)) {
        //print_r($row);
        $sp_deadline = $row["deadline1"];
        $sp_submission_method = $row["submission_method"];
        $sp_sponsor = $row["sponsor"];
        $sp_prime_sponsor = $row["prime_sponsor"];
        $sp_contact_name = $row["contact_name"];
        $sp_phone = $row["phone"];
        $sp_email = $row["email"];
        $sp_address = $row["address"];
        $sp_number_of_copies = $row["number_of_copies"];
        $sp_shipment_method = $row["shipment_method"];
        $sp_sponsor_link = $row["sponsor_link"];
    }

    // get the external investigators and subcontractors for this bluesheet
    $eiCount = 0;
    $query = "SELECT * FROM bs_ei_info where bs_id=".$bs_id;
    $result = mysql_query($query, $connect1);
    while($row = mysql_fetch_array($result)) {
        //print_r($row);
        $ei_name[$eiCount] = $row["name"];
        $ei_iname[$eiCount] = $row["inst_name"];
        $ei_dept[$eiCount] = $row["dept"];
        $ei_box_number[$eiCount] = $row["box_number"];
        $ei_phone[$eiCount] = $row["phone"];
        $ei_email[$eiCount] = $row["email"];
        $ei_rank[$eiCount] = $row["rank"];
        $ei_citizenship[$eiCount] = $row["citizenship"];
        $ei_funding[$eiCount] = $row["funding"];
        $eiCount++;
    }

    // before getting the actual budget entries, we need to get the type of fields
    // in this particular blue sheet budget table
    /*
	$query = "SELECT * FROM bs_additional_field";
	$query = "SELECT * FROM bs_budget_field";
	$result = mysql_query($query, $connect1);
	while($row = mysql_fetch_array($result))
	{
		$row[""];
		$row[""];
		$row[""];
		$row[""];
	}
    */

    // now we can map the types from previous query into the actual budget values table
    $budgetCount = 0;
    $query = "SELECT * FROM bs_budget where bs_id=".$bs_id;
    $result = mysql_query($query, $connect1);
    while($row = mysql_fetch_array($result)) {
        //print_r($row);
        $budgetYr1[$budgetCount] = $row["Yr1"];
        $budgetYr2[$budgetCount] = $row["Yr2"];
        $budgetYr3[$budgetCount] = $row["Yr3"];
        $budgetYr4[$budgetCount] = $row["Yr4"];
        $budgetYr5[$budgetCount] = $row["Yr5"];
        $budgetName[$budgetCount] = $row["name"];
        $budgetTypeID[$budgetCount] = $row["type_id"];
        $budgetID[$budgetCount] = $row["id"];
        $budgetCount++;
    }
    //echo "</pre>";
}

if ($pid != -1) {
    $query = "SELECT title, f_name, m_name, l_name, pri_designation, email_id, phone_no_1, mailbox, pri_hid from ppl_general_info WHERE pid=$pid";
    $result = mysql_query($query, $connect1) or die(mysql_error());
    while($row = mysql_fetch_array($result)) {
        $fullname = ($row["title"]==""?"":$row["title"]) . $row["l_name"] . ", " . $row["f_name"] . " " . $row["m_name"];
        $phoneno = $row["phone_no_1"];
        $email = $row["email_id"];
        $boxno = $row["mailbox"];
        // Need to work on displaying the primary rank and description. (after we get the LDAP working).
        $pri_designation = $row["pri_designation"];
        $pieces = explode("-", $pri_designation);
        $rank = $pieces[0];
        $dept = $pieces[1];

        $pi_deptcode = $row["pri_hid"];
        //echo $row["pri_designation"];
    }
}

function MakeDeptComboBox($name, $hhid) {
    global $connect;
    $querydept = "SELECT * FROM gen_hierarchy_types ORDER BY h1,h2,h3 ASC";
    $resultdept = mysql_query($querydept, $connect);
    echo "<label><span style='visibility:hidden;'>label</span><select id='$name' name='$name'>";
    //echo "<select id='$name' name='$name' style='width: 208px'>";
    print "<option id='0' value='Select a Department from Below'>Select a Department from Below</option>";
    $i = 0;
    while($rowdept = mysql_fetch_array($resultdept)) {
        //if( $i == 0 )
        if ($rowdept["hid"] == $hhid)
            $selected = "selected";
        else
            $selected = "";
        $i++;
        if($rowdept["h1"]!=0 && $rowdept["h2"]==0)
            print "<option id='".$rowdept["hid"]."' value='".$rowdept["name"]."' $selected>".$rowdept["name"]."</option>";
        else {
            if($rowdept["h1"]!='0' && $rowdept["h2"]!='0' && $rowdept["h3"]=='0')
                print "<option id='".$rowdept["hid"]."' value='".$rowdept["name"]."' $selected>----".$rowdept["name"]."</option>";
        }//end else
    }//end while
    echo "</select></label>";
}

function MakeRankComboBox($name, $t) {
    global $connect;
    $queryrank = "SELECT * FROM gen_rank_types";
    $resultrank = mysql_query($queryrank, $connect);
    echo "<label><span style='visibility:hidden'>label</span><select id='$name' name='$name' onchange=\"Hide(frmBS." . $t . "Rank.options[selectedIndex].id, false, '".$t."RankOther1', '".$t."RankOther2');\" >";
    while($rowrank = mysql_fetch_array($resultrank)) {
        print "<option id='".$rowrank["rank"]."' value='".$rowrank["rank"]."'>".$rowrank["rank"]."</option>";
    }//end while
    print "<option value='Other-' id='other'>Other</option>";
    echo "</select></label>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Electronic Research Profile System - (Blue Sheet) - Texas State University - San Marcos</title>
        <link href="includes/wforms.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="includes/wforms-print.css" media="print" rel="stylesheet" type="text/css" />

        <script language="JavaScript" type="text/JavaScript" src="includes/utf8.js"></script>
        <script language="JavaScript" type="text/JavaScript" src="includes/bs1.js"></script>

        <style type="text/css">@import url(includes/calendar-blue.css);</style>
        <script type="text/javascript" src="includes/calendar.js"></script>
        <script type="text/javascript" src="includes/lang/calendar-en.js"></script>
        <script type="text/javascript" src="includes/calendar-setup.js"></script>

    </head>
<?php
if (isset($bs_status) && ($bs_status != "Saved")) {
    if (isset($_GET['view']))
        echo "<body onload='GeneratePrintPreview();JSFX_FloatTopLeft();'>";
    else
        echo "<body onload='JSFX_FloatTopLeft();'>";
}
else {
    if (isset($_GET['view']))
        echo "<body onload='GeneratePrintPreview();JSFX_FloatTopLeft();StartASTimer();'>";
    else
        echo "<body onload='JSFX_FloatTopLeft();StartASTimer();'>";
}
?>
    <div class="main_form">
        <h3>
            <font face="Tahoma, Verdana" color="#0000FF">Internal Routing Form (Blue Sheet)</font>
        </h3>
    </div>
    <form method="post" action="bs_submit.php" name="frmBS" id="frmBS">
    <?php
    if (isset($_GET['createnew']))
        $bs_id = 0;
    ?>
        <label for="bs_id"><span style="visibility:hidden">label</span><input type="hidden" name="bs_id" id="bs_id" value="<?php echo $bs_id; ?>" /></label>
        <label for="pid"><span style="visibility:hidden">label</span><input type="hidden" name="pid" id="pid" value="<?php echo $pid; ?>" /></label>
        <div id="main_form" class="main_form">
            <!--onmouseover='ShowTable("sponsor_table")' onmouseout='HideTable("sponsor_table")' onclick='ToggleSticky()'-->


            <table style="position:absolute; border: 1px solid #0000CC; background: #F0F0F0;
                   height: auto; width: auto; display: none;" id="find">
                <tr>
                    <td colspan="4" style="padding-left:15px;font-size:14px;">
                        <b>Search</b>
                    </td>
                    <td align="center" style="">
                        <label for="button"><span style="visibility:hidden;">label</span><input type="button" value="  X  " onclick="d('find').style.display='none';" id="button" style="font-weight: bold;" /></label>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:15px;">Last Name</td>
                    <td>
                        <label><span style="visibility:hidden;">label</span><input type="text" id="kp_name_l" name="kp_name_l" class="input" style="text-align:left;" size="10" onkeyup="searchKeyUp(event)" /></label>
                    </td>
                    <td style="padding-left:15px;">First Name</td>
                    <td>
                        <label><span style="visibility:hidden;">label</span><input type="text" id="kp_name_f" name="kp_name_f" class="input" style="text-align:left;" size="10" onkeyup="searchKeyUp(event)" /> </label>
                    </td>
                    <td>
                        <!--img src="../images/buttons/find.gif" onclick="FindPerson('kp_name');" style="cursor:pointer;" /-->
                        <label><span style="visibility:hidden;">label</span><input type="button" value=" Find " onclick="FindPerson();" /></label>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="height: 135px;background:#FFFFFF;overflow:auto;" valign="top">
                        <div id="result_view" style="height:135px; overflow:auto;">
                        </div>
                    </td>
                </tr>
            </table>


            <table border="0">
                <tr>
                    <td>
                        <font size=2>
                            Bluesheet Name: </font></td><td><label><span style="visibility:hidden;">label</span><input name="bs_name" type="text" id="bs_name" size="30" <?php if(isset($bs_name)) echo "value=\"$bs_name\""; ?>/></label></td>
                </tr>
                <tr>
                    <td>
                        Description: </td><td><label><span style="visibility:hidden;">label</span><input name="bs_comments" type="text" id="bs_comments" size="55" <?php if(isset($bs_comments)) echo "value=\"$bs_comments\""; ?>/></td></label>
                </tr>
            </table>
            <!-- PI Section-->
            <table width=80% style="border: 1px solid #0000CC;" id="pi_section">
                <tr>
                    <td class="tdHeader" width="80%">
                        <b>1. Principal Investigator</b></td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('piTableHelp', this)" style="cursor:pointer">Show Help</span>
                    </td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('piTable', this)" style="cursor:pointer">Collapse</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top">
                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="piTableHelp">
                            <tr><td class="tdSmall">
	Enter the requested information for the Principal Investigator.<br />
	Typically, the following individuals require approval from the Vice President for Research or 
	Director of GCS to submit proposals through the university: 
                                    <ul>
                                        <li>Undergraduate or graduate students (some programs allow for their inclusion).</li>
                                        <li>Visiting professors (any rank).</li>
                                        <li>Visitors in a post doctoral position (less than one year appointment).</li>
                                        <li>Adjunct Professors.</li>
                                        <li>Anyone not in a permanent employee status (defined to be less than 50% time).</li>
                                    </ul>
	Citizenship: <br />
	Citizenship information is being requested solely for compliance purposes. 
	Citizenship does not affect a PI or Co-I�s eligibility to submit a proposal. 
	This information only serves to help UTA to comply with Export Control laws. 
	If you have any questions, please do not hesitate to contact your specialist 
	or the Office of Research Integrity and Compliance. 
                                </td></tr>

                        </table>
                        <table width="100%" style="border-top: 1px dotted #0000CC" id="piTable">
                            <tr>
                                <td>Full Name: </td>
                                <td colspan="3">
                                    <label><span style="visibility:hidden;">label</span><input name="piFullName" type="text" id="piFullName" size="30" readonly="true"
                                                                                               value="<?php if (isset($pi_name)) echo $pi_name; else if ($pid != -1) echo $fullname; ?>" /></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Department: </td>
                                <td><!--input name="piDept" type="text" id="piDept" size="30"/--><?php MakeDeptComboBox("piDept", $pi_deptcode); ?>
                                    <br /><font size="1">(Department is automatically filled from your profile)</font>
                                </td>
                                <td>Box #:</td>
                                <td><label><span style="visibility:hidden;">label</span><input name="piBox#" type="text" id="piBox#" size="10"
                                                                                               value="<?php if (isset($pi_box_number)) echo $pi_box_number; else if ($pid != -1) echo $boxno; ?>" /></label></td>
                            </tr>
                            <tr>
                                <td>Email Address: </td>
                                <td><input name="piEmail" type="text" id="piEmail" size="30"
                                           value="<?php if (isset($pi_email)) echo $pi_email; else if ($pid != -1) echo $email; ?>" /></td>
                                <td>Phone Number: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="piPhoneNumber" type="text" id="piPhoneNumber" size="20"
                                                                                               value="<?php if (isset($pi_phone)) echo $pi_phone; else if ($pid != -1) echo $phoneno; ?>" /></label></td>
                            </tr>
                            <tr>
                                <td>Rank: </td>
                                <td>
<?php
MakeRankComboBox("piRank", "pi");
?>
                                </td>
                                <td><span id="piRankOther1" style="display:none;">Other:</span></td>
                                <td> <span id="piRankOther2" style="display:none;">
                                        <label><span style="visibility:hidden;">label</span><input name="piRankopt" type="text" id="piRankopt" size="20"/></label>
                                    </span> </td>
                            </tr>
                            <tr>
                                <td>
	Citizenship:
                                </td>
                                <td>
<?php
if (isset($pi_rank) || isset($rank)) {
    if (!isset($pi_rank))
        $pi_rank = $rank;
    ?>
                                    <script>
                                        try
                                        {
                                            if (!frmBS)
                                            {
                                                frmBS = document.getElementById('frmBS');
                                            }
                                        }
                                        catch (e)
                                        {
                                            frmBS = document.getElementById('frmBS');
                                        }
                                        var foundRank = false;
                                        for(i=0; i<frmBS.piRank.options.length; i++)
                                        {
                                            if (frmBS.piRank.options[i].value=="<?php print($pi_rank); ?>")
                                            {
                                                //alert(frmBS.piRank.options[i].value);
                                                //alert("<?php echo $pi_rank; ?>");
                                                frmBS.piRank.options[i].selected = true;
                                                foundRank = true;
                                                break;
                                            }
                                        }
                                        if (foundRank == false)
                                        {
                                            //frmBS.piRank.options[7].selected = true;
                                            frmBS.piRank.value = "Other-";
    <?php
    if (!isset($pi_dept))
        echo "document.getElementById(\"piRankopt\").value = \"" . $pi_rank . "\";";
    else
        echo "document.getElementById(\"piRankopt\").value = \"" . substr($pi_rank,6) . "\";";
    ?>
                                                    Hide('other', false, 'piRankOther1', 'piRankOther2');
                                                }
                                    </script>
    <?php
}

if (isset($pi_dept) || isset($dept)) {
    if (!isset($pi_dept))
        $pi_dept = $dept;
    ?>
                                    <script>
                                        for(var jjj=0; jjj<frmBS.piDept.options.length; jjj++)
                                        {
                                            if (frmBS.piDept.options[jjj].value=="<?php print($pi_dept);?>")
                                            {
                                                frmBS.piDept.options[jjj].selected = true;
                                                break;
                                            }
                                        }
                                    </script>
    <?php
}
?>
                                    <label><span style="visibility:hidden;">label</span><input name="piCitizenship" id="piCitizenship" type="radio" value="U.S. Citizen/Permanent Resident" <?php	if (isset($pi_citizenship)) {
                                        if ($pi_citizenship=="U.S. Citizen/Permanent Resident") echo "checked=\"checked\"";
                                    } else echo "checked=\"checked\"";	?>/></label>
                                    U.S. Citizen/Permanent Resident
                                </td>
                                <td colspan="2">
                                    <label><span style="visibility:hidden;">label</span><input name="piCitizenship" id="piCitizenship" type="radio" value="Non - U.S. Citizen" <?php	if (isset($pi_citizenship)) {
                                        if ($pi_citizenship=="Non - U.S. Citizen") echo "checked=\"checked\"";
}?>/></label>
                                    Non - U.S. Citizen
                                </td>
                            </tr>
                        </table>
                </tr>
            </table>
            <br />
            <!-- Sponsor Information Section-->
            <table width=80% style="border: 1px solid #0000CC;">
                <tr>
                    <td class="tdHeader" width="80%">
                        <b>2. Sponsor Information</b></td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('siTableHelp', this)" style="cursor:pointer">Show Help</span>
                    </td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('siTable', this)" style="cursor:pointer">Collapse</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top">
                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="siTableHelp">
                            <tr><td class="tdSmall">
		Please enter the date the proposal is due and choose a submission method (paper or electronic). 
		The sponsor should be the agency we are submitting the proposal to.
		If this is a collaborative proposal or subcontract, enter the name of the agency who will be 
		receiving the actual award under �Sponsor� (i.e. lead institution). If applicable, enter the 
		name of the agency the joint proposal is being submitted to in the �Prime Sponsor� field. 
		Please provide the name, phone number and email address of a contact point at the Sponsor 
		who will be able to provide information on the submission. If a paper submission is required, 
		provide the street address (overnight couriers will not deliver to PO Boxes) and number of 
		copies the sponsor requires. Choose a shipment method from the radio buttons. All proposals 
		shipped by GCS will be charged to the PI�s departmental UPS number.
                                </td></tr>
                        </table>
                        <table width="100%" style="border-top: 1px dotted #0000CC" id="siTable">
                            <tr>
                                <td>Deadline: </td>

                                <td>
                                    <label><span style="visibility:hidden;">label</span><input onclick="document.getElementById('button3').onclick();" readonly name="siDeadline" type="text" id="siDeadline" size="30" <?php if (isset($sp_deadline)) echo "value=\"$sp_deadline\""; ?>/></label>
                                    <img alt="calender" src="images/calendar.jpg" id="button3" />
                                    <script>
                                        Calendar.setup(
                                        {
                                            inputField  : "siDeadline",         // ID of the input field
                                            ifFormat    : "%m/%d/%Y",    // the date format
                                            button      : "button3"       // ID of the button
                                        }
                                    );
                                    </script>
                                </td>
                                <td>Submission Method: </td>
                                <td>
                                    <label><span style="visibility:hidden;">label</span><input id="siSubMethod1" name="siSubMethod" type="radio" value="Electronic"
                                                                                               onclick="Hide('other', true, 'si1', 'si2');Hide('other', true, 'si3', 'si4')"/></label>Electronic
                                    <label><span style="visibility:hidden;">label</span><input id="siSubMethod2" name="siSubMethod" type="radio" value="Paper" checked="checked"
                                                                                               onclick="Hide('other', false, 'si1', 'si2');Hide('other', false, 'si3', 'si4');frmBS.siShipMethod[0].checked='checked';"/></label>
				Paper
                                </td>
                            </tr>
                            <tr>
                                <td>Sponsor: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="siSponsor" type="text" id="siSponsor" size="30" <?php if (isset($sp_sponsor)) echo "value=\"$sp_sponsor\""; ?>/></td></label>
                                <td><span id="si1">Shipment Method: </span> </td>
                                <td rowspan="3" valign="top">
                                    <span id="si2">	I Prefer<br />
                                        <label><span style="visibility:hidden;">label</span><input id="siShipMethod1" name="siShipMethod" type="radio" value="GCS mails out my proposal" checked="checked"
                                                                                                   onclick="Hide('other', false, 'si3', 'si4')" /></label>
		    GCS to mail out my proposal.<br />
                                        <center><span class="tdSmall">(costs of next day air will be charged to PI's dept)
                                            </span></center>
                                        <label><span style="visibility:hidden;">label</span><input id="siShipMethod2" name="siShipMethod" type="radio" value="I mail out my proposal"
                                                                                                   onclick="Hide('other', true, 'si3', 'si4')" /></label>
		    to mail out my proposal myself.<br />
                                        <center><span class="tdSmall">(must have GCS approval,<BR />
			also GCS must have a copy of full proposal)</span></center>
                                    </span>
                                </td>
<?php
if (isset($sp_submission_method)) {
    echo "<script>";
    if ($sp_submission_method == "Paper") {
        echo "frmBS.siSubMethod[1].checked='checked';";
    }
    else
                                                echo "frmBS.siSubMethod[0].checked='checked';";
    echo "</script>";
}

if (isset($sp_shipment_method)) {
                                            echo "<script>";
    if ($sp_shipment_method == "GCS mails out my proposal") {
                                                        echo "frmBS.siShipMethod[0].checked='checked';";
    }
    else
                                        echo "frmBS.siShipMethod[1].checked='checked';";
                                    echo "</script>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <td>Link: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="siSponsorLink" type="text" id="siSponsorLink" size="30" <?php if (isset($sp_sponsor_link)) echo "value=\"$sp_sponsor_link\""; ?>/></label><br />
                                    <span class="tdSmall">(link to sponsor's solicitation/RFP/guideline)</span></td>
                            </tr>
                            <tr>
                                <td>Prime Sponsor: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="siPrimeSponsor" type="text" id="siPrimeSponsor" size="30" <?php if (isset($sp_prime_sponsor)) echo "value=\"$sp_prime_sponsor\""; ?>/></label></td>
                            </tr>
                            <tr>
                                <td>Sponsor Contact Name:</td>
                                <td><label><span style="visibility:hidden;">label</span><input name="siSponsorContactName" type="text" id="siSponsorContactName" size="30" <?php if (isset($sp_contact_name)) echo "value=\"$sp_contact_name\""; ?>/></label></td>
                                <td><span id="si3">Number of copies:</span> </td>
                                <td><span id="si4"><label><span style="visibility:hidden;">label</span><input name="siNoOfCopies" type="text" id="siNoOfCopies" size="5" <?php if (isset($sp_number_of_copies)) echo "value=\"$sp_number_of_copies\""; ?>/></label>
                                        <span class="tdSmall">(plus 1 for OGCS)</span></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Address: </td>
                                <td colspan="3"><label><span style="visibility:hidden;">label</span><input name="siAddress" type="text" id="siAddress" size="89" <?php if (isset($sp_address)) echo "value=\"$sp_address\""; ?>/></label></td>
                            </tr>
                            <tr>
                                <td>Email Address: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="siEmail" type="text" id="siEmail" size="30" <?php if (isset($sp_email)) echo "value=\"$sp_email\""; ?>/></label></td>
                                <td>Phone Number: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="siPhoneNumber" type="text" id="siPhoneNumber" size="30" <?php if (isset($sp_phone)) echo "value=\"$sp_phone\""; ?>/></label></td>
                            </tr>
                        </table>
                </tr>
            </table>
            <br />
            <!-- Proposal Information  Section-->
            <table width=80% style="border: 1px solid #0000CC;">
                <tr>
                    <td class="tdHeader" width="80%">
                        <b>3. Proposal Information</b></td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('propinfoTableHelp', this)" style="cursor:pointer">Show Help</span>
                    </td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('propinfoTable', this)" style="cursor:pointer">Collapse</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top">
                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="propinfoTableHelp">
                            <tr><td class="tdSmall">
		Please enter the same <b>title</b> that will be used on the proposal itself. <br />
		Choose a <b>type</b> of proposal from the drop-down list. If this is a renewal/continuation of, 
		or a supplement to, an existing award, please enter the account number of the award. 
		If a Human and/or Animal Subject protocol is pending or has been approved, the title 
		MUST match that of the approved protocol (<u>no exceptions</u>).
                                </td></tr>
                        </table>
                        <table width="100%" style="border-top: 1px dotted #0000CC" id="propinfoTable">
                            <tr>
                                <td width="25%">Title: </td>
                                <td>
                                    <label><span style="visibility:hidden;">label</span><input name="propinfoTitle" type="text" id="propinfoTitle" size="50" <?php if (isset($proposal_title)) echo "value=\"$proposal_title\""; ?>/></label> <span class="tdSmall">(required)</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Type: </td>
                                <td>
                                    <label><span style="visibility:hidden;">label</span><input name="propinfoType" id="propinfoType" type="radio" value="New Proposal"
                                                                                               onclick="Hide('other', true, 'pAccount1', 'pAccount2')"
<?php if (isset($proposal_type)) {
    if($proposal_type=="New Proposal") {
                                            echo "checked=\"checked\"";
                                        }
                                    }
                                    else echo "checked=\"checked\""; ?>/></label>
                                    New Proposal
                                    <label><span style="visibility:hidden;">label</span><input name="propinfoType" id="propinfoType" type="radio" value="Supplement"
                                                                                               onclick="Hide('other', false, 'pAccount1', 'pAccount2')"
<?php if (isset($proposal_type)) if($proposal_type=="Supplement") echo "checked=\"checked\""; ?>/></label>
                                    Supplement
                                    <label><span style="visibility:hidden;">label</span><input name="propinfoType" id="propinfoType" type="radio" value="Renewal/Non-competing continuation"
                                                                                               onclick="Hide('other', false, 'pAccount1', 'pAccount2')"
<?php if (isset($proposal_type)) if($proposal_type=="Renewal/Non-competing continuation") echo "checked=\"checked\""; ?>/></label>
                                    Renewal/Non-competing continuation
                                </td>
                            </tr>
                            <tr>
                                <td><span id="pAccount1" style="display:none">Previous Grant Account #: </span></td>
                                <td><span id="pAccount2" style="display:none">
                                        <label><span style="visibility:hidden;">label</span><input name="propinfoPrevAcctNo" type="text" id="propinfoPrevAcctNo" size="30" <?php if (isset($prev_acct_number)) echo "value=\"$prev_acct_number\""; ?>/></label>
                                    </span></td>
                            </tr>
                        </table>
                </tr>
            </table>
            <br />
            <!-- Co Investigators  Section-->
            <table width=80% style="border: 1px solid #0000CC;">
                <tr>
                    <td class="tdHeader" width="80%">
                        <b>4. Co Investigators</b></td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('ciTableHelp', this)" style="cursor:pointer">Show Help</span>
                    </td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('ciTable', this)" style="cursor:pointer">Collapse</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top">
                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="ciTableHelp">
                            <tr><td class="tdSmall">
		Enter the names and all the requested information for any Co-Investigators. 
		The personnel listed here should be UTA employees <b>only</b>. 
		Do not list any collaborators outside of UTA.<Br />
		A red flag with the added Co-Investigator means that electronic routing to that
		investigator is not possible and blue sheet would need to be routed manually.
                                </td></tr>
                        </table>
                        <table width="100%" style="border-top: 1px dotted #0000CC" id="ciTable">
                            <tr>
                                <td colspan="4">
	UTA personnel only � if you have any collaborators who are not UTA employees, please fill in Section on External Collaborators and Subcontractors) If PI and Co-Investigators are from different Colleges or Administrative Units, Indirect Cost Recovery Percentages may be allocated between the departments/units by using the Facilities and Administration Distribution Form.This Form should be completed during the Proposal process, prior to submission.
                                </td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>Full Name: </td>
                                <td colspan="3">
                                    <label><span style="visibility:hidden;">label</span><input name="ciFullName" type="text" id="ciFullName" size="30" readonly="true" value="" style="border-width: 0px;background:#D5EAFF;" onclick="ShowFind('ciFullName');" /></label>
                                    <!--img src="images/find.gif" onclick="FindCoPi();" style="cursor:pointer;" /-->
                                    <label><span style="visibility:hidden;">label</span><input type="button" value="Step 1: Search for CoPI" onclick="ShowFind('ciFullName');" class="button" /></label> &nbsp;
                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='AddRow("CoPis")' value="Step 2: Add selected CoPI"/></label>
                                    <!--span class="tdSmall">(format: lastname, firstname. Click on the search icon to find a person)</span!-->
                                </td>
                            </tr>
                            <tr id="copiResultsRow">
                                <td colspan="4" id="copiResults">

                                </td>
                            </tr>
                            <tr>
                                <td id="deptcolor">Department: </td>
                                <td><!--input name="ciDept" type="text" id="ciDept" size="30"/--><?php MakeDeptComboBox("ciDept", 0); ?></td>
                                <td>Box #:</td>
                                <td>
                                    <label><span style="visibility:hidden;">label</span><input name="ciBox#" type="text" id="ciBox#" size="10"/></label>
                                    <label><span style="visibility:hidden;">label</span><input type="hidden" id="ciLoginID" name="ciLoginID" value="" /></label>
                                </td>
                            </tr>
                            <tr>
                                <td>Email Address: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="ciEmail" type="text" id="ciEmail" size="30"/></label></td>
                                <td>Phone Number: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="ciPhoneNumber" type="text" id="ciPhoneNumber" size="20"/></label></td>
                            </tr>
                            <tr>
                                <td>Rank: </td>
                                <td>
<?php
MakeRankComboBox("ciRank", "ci");
?>
                                </td>
                                <td><span id="ciRankOther1" style="display:none;">Other:</span></td>
                                <td><span id="ciRankOther2" style="display:none;">
                                        <label><span style="visibility:hidden;">label</span><input name="ciRankopt" type="text" id="ciRankopt" size="20"/></label></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Citizenship:</td>
                                <td colspan="2">
                                    <label><span style="visibility:hidden;">label</span><input name="ciCitizenship" id="ciCitizenship1" type="radio" value="U.S. Citizen/Permanent Resident" checked="checked"/></label>
                                    U.S. Citizen/Permanent Resident &nbsp;&nbsp;&nbsp;
                                    <label><span style="visibility:hidden;">label</span><input name="ciCitizenship" id="ciCitizenship2" type="radio" value="Non - U.S. Citizen" /></label>
                                    Non - U.S. Citizen
                                </td>
                                <td align="left">
                                    <input type="button" onclick='AddRow("CoPis")' style="border: 1px solid;background: #FFFFFF" value="Add"/>&nbsp;&nbsp;
                                </td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td colspan="4">
                                    <table class="tdSmall" style="border: 1px dotted #0066FF; display:none;"
                                           id="CoPis" width=100% align="center">
                                        <tr>
                                            <td colspan="8"><b>Added Co Investigators</b><hr style="border: 1px dotted #0066FF;"/></td>
                                        </tr>
                                    </table>
<?php
if (isset($copiCount)) {
    for ($i=0; $i<$copiCount; $i++) {
        ?>
                                    <script>
                                        var tblName = "CoPis";
                                        var tbl = document.getElementById(tblName);
                                        var newRow = tbl.insertRow(tbl.rows.length);
                                        var newCell = newRow.insertCell(0);
                                        newCell.innerHTML = "<?php print($copi_name[$i]); ?>";
                                        var newCell = newRow.insertCell(1);
                                        newCell.align = "center";
                                        newCell.innerHTML = "<?php print($copi_email[$i]); ?>";
                                        var newCell = newRow.insertCell(2);
                                        newCell.align = "center";
                                        newCell.innerHTML = "<?php print($copi_box_number[$i]); ?>";
                                        var newCell = newRow.insertCell(3);
                                        newCell.align = "center";
                                        newCell.innerHTML = "<?php print($copi_phone[$i]); ?>";
                                        var newCell = newRow.insertCell(4);
                                        newCell.innerHTML = "<?php print($copi_dept[$i]); ?>";
                                        newCell.align = "center";
                                        var newCell = newRow.insertCell(5);
                                        newCell.innerHTML = "<?php print($copi_rank[$i]); ?>";
                                        newCell.align = "center";
                                        var newCell = newRow.insertCell(6);
                                        newCell.align = "center";
                                        newCell.innerHTML = "<?php print($copi_citizenship[$i]); ?>";
                                        var newCell = newRow.insertCell(7);
                                        newCell.innerHTML = "<?php print($copi_login_id[$i]); ?>";
                                        var man_route = '';
                                        if (newCell.innerHTML == "")
                                            man_route = '<img src="images/redflag1.PNG" alt="Needs manual routing">';
                                        newCell.style.display = 'none';
                                        var newCell = newRow.insertCell(8);
                                        newRow.id = tblName + newRow.rowIndex;
                                        var id = newRow.id;
                                        newCell.innerHTML = "<span onclick='RemoveRow(\"" + tblName + "\",\"" + id +
                                            "\")'>" + man_route + "<img src=\"images/deleterow.gif\" alt=\"Remove\"></span>" +
                                            "<label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciFullName[]\" value=\"<?php echo $copi_name[$i]; ?>\"><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciDept[]\" value=\"<?php echo $copi_dept[$i]; ?>\"><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciBox#\" value=\"<?php echo $copi_box_number[$i]; ?>\"><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciEmail[]\" value=\"<?php echo $copi_email[$i]; ?>\"><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciPhoneNumber[]\" value=\"<?php echo $copi_phone[$i];?>\"><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciRank[]\" value=\"<?php echo $copi_rank[$i]; ?>\"><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciLoginID[]\" value=\"<?php echo $copi_login_id[$i]; ?> \">";
                                        tbl.style.display = '';
                                    </script>
        <?php
    }
}
?>

                                </td>
                            </tr>
                        </table>
                </tr>
            </table>
            <br />
            <!-- Project Abstract Section -->
            <table width=80% style="border: 1px solid #0000CC;">
                <tr>
                    <td class="tdHeader" width="80%">
                        <b>5. Project Abstract</b></td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('paTableHelp', this)" style="cursor:pointer">Show Help</span>
                    </td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('paTable', this)" style="cursor:pointer">Collapse</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top">
                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="paTableHelp">
                            <tr><td class="tdSmall">
		Please provide a brief description of the work you are proposing.
                                </td></tr>
                        </table>
                        <table width="100%" style="border-top: 1px dotted #0000CC" id="paTable">
                            <tr>
                                <td>
	Briefly summarize the project in lay terms.
                                    <center><label><span style="visibility:hidden">label</span>
                                            <textarea cols="80" rows="15" id="prjAbstractText" name="prjAbstractText" onKeyDown='textCounter("prjAbstractText","prjAbstractTextCounter", 1000)' onKeyUp='textCounter("prjAbstractText","prjAbstractTextCounter", 1000)'><?php if(isset($abstract)) echo $abstract; ?></textarea></label>
                                    </center>
                                    <div align="right" id="prjAbstractTextCounter">1000 characters left.</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br />
            <!-- Compliance Section -->
            <table width=80% style="border: 1px solid #0000CC;">
                <tr>
                    <td class="tdHeader" width="80%">
                        <b>6. Compliance</b></td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('complianceTableHelp', this)" style="cursor:pointer">Show Help</span>
                    </td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('complianceTable', this)" style="cursor:pointer">Collapse</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top">
                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="complianceTableHelp">
                            <tr><td class="tdSmall">
		Please answer the questions in this section and review the 
                                    <a href="Compliance_Checklist.doc">Compliance
		Checklist</a> for guidance as they may apply to this proposal. If you have any questions, 
		please call your specialist or the department responsible for the area you have questions on.
                                </td></tr>
                        </table>
                        <table width="100%" style="border-top: 1px dotted #0000CC" id="complianceTable">
                            <tr>
                                <td colspan="6">
                                    Please review and attach the <a href="Compliance_Checklist.doc">Compliance Checklist</a> as necessary. Direct questions to x3723.<br /><br />
                                    <b>Office of Research Compliance:</b><br />Please choose Yes, No from below. If Yes, then select Pending or provide a Approved Protocol No.
                                </td>
                            </tr>
                            <tr>
<?php
if (isset($human_subjects)) {
    if ($human_subjects=="Yes") {
        $hsY = "checked=\"checked\"";
                                            $hsP = "checked=\"checked\"";
    }
                                            else if ($human_subjects=="No")
                                            $hsN = "checked=\"checked\"";
    else if ($human_subjects=="Pending") {
        $hsY = "checked=\"checked\"";
        $hsP = "checked=\"checked\"";
    }
    else if ($human_subjects=="") {
        $hsY = "";
        $hsP = "";
    }
    else {
        $hsY = "checked=\"checked\"";
                                        $hsA = "checked=\"checked\"";
                                        $hsDT = "value=\"$human_subjects\"";
                                    }
                                }
                                else {
                                    $hsY = "";
                                    $hsP = "";
                                }

                                if (isset($recombinant_dna)) {
                                    if ($recombinant_dna=="Yes") {
                                        $rdY = "checked=\"checked\"";
                                        $rdP = "checked=\"checked\"";
                                    }
                                    else if ($recombinant_dna=="No")
                                        $rdN = "checked=\"checked\"";
                                    else if ($recombinant_dna=="Pending") {
                                        $rdY = "checked=\"checked\"";
                                        $rdP = "checked=\"checked\"";
                                    }
                                    else if ($recombinant_dna=="") {
                                        $rdY = "";
                                        $rdP = "";
                                    }
                                    else {
                                        $rdY = "checked=\"checked\"";
                                        $rdA = "checked=\"checked\"";
                                        $rdDT = "value=\"$recombinant_dna\"";
                                    }
                                }
                                else {
                                    $rdY = "";
                                    $rdP = "";
                                }

                                if (isset($vertebrate_animals)) {
                                    if ($vertebrate_animals=="Yes") {
                                        $vaY = "checked=\"checked\"";
                                        $vaP = "checked=\"checked\"";
                                    }
                                    else if ($vertebrate_animals=="No")
                                        $vaN = "checked=\"checked\"";
                                    else if ($vertebrate_animals=="Pending") {
                                        $vaY = "checked=\"checked\"";
                                        $vaP = "checked=\"checked\"";
                                    }
                                    else if ($vertebrate_animals=="") {
                                        $vaY = "";
                                        $vaP = "";
                                    }
                                    else {
                                        $vaY = "checked=\"checked\"";
                                        $vaA = "checked=\"checked\"";
                                        $vaDT = "value=\"$vertebrate_animals\"";
                                    }
                                }
                                else {
                                    $vaY = "";
                                    $vaP = "";
                                }

                                if (isset($biological_agents)) {
                                    if ($biological_agents=="Yes") {
                                        $baY = "checked=\"checked\"";
                                        $baP = "checked=\"checked\"";
                                    }
                                    else if ($biological_agents=="No")
                                        $baN = "checked=\"checked\"";
                                    else if ($biological_agents=="Pending") {
                                        $baY = "checked=\"checked\"";
                                        $baP = "checked=\"checked\"";
                                    }
                                    else if ($biological_agents=="") {
                                        $baY = "";
                                        $baP = "";
                                    }
                                    else {
                                        $baY = "checked=\"checked\"";
                                        $baA = "checked=\"checked\"";
                                        $baDT = "value=\"$biological_agents\"";
                                    }
                                }
                                else {
                                    $baY = "";
                                    $baP = "";
                                }

                                if (isset($controlled_substances)) {
                                    if ($controlled_substances=="Yes") {
                                        $csY = "checked=\"checked\"";
                                        $csP = "checked=\"checked\"";
                                    }
                                    else if ($controlled_substances=="No")
                                        $csN = "checked=\"checked\"";
                                    else if ($controlled_substances=="Pending") {
                                        $csY = "checked=\"checked\"";
                                        $csP = "checked=\"checked\"";
                                    }
                                    else if ($controlled_substances=="") {
                                        $csY = "";
                                        $csP = "";
                                    }
                                    else {
                                        $csY = "checked=\"checked\"";
                                        $csA = "checked=\"checked\"";
                                        $csDT = "value=\"$controlled_substances\"";
                                    }
                                }
                                else {
                                    $csY = "";
                                    $csP = "";
                                }

                                if (isset($radioactive_materials)) {
                                    if ($radioactive_materials=="Yes") {
                                        $rmY = "checked=\"checked\"";
                                        $rmP = "checked=\"checked\"";
                                    }
                                    else if ($radioactive_materials=="No")
                                        $rmN = "checked=\"checked\"";
                                    else if ($radioactive_materials=="Pending") {
                                        $rmY = "checked=\"checked\"";
                                        $rmP = "checked=\"checked\"";
                                    }
                                    else if ($radioactive_materials=="") {
                                        $rmY = "";
                                        $rmP = "";
                                    }
                                    else {
                                        $rmY = "checked=\"checked\"";
                                        $rmA = "checked=\"checked\"";
                                        $rmDT = "value=\"$radioactive_materials\"";
                                    }
                                }
                                else {
                                    $rmY = "";
                                    $rmP = "";
                                }

                                if (isset($select_agents)) {
                                    if ($select_agents == "Yes") {
                                        $saY = "checked=\"checked\"";
                                    }
                                    else if ($select_agents == "No") {
                                        $saN = "checked=\"checked\"";
                                    }
                                    else {
                                        $saN = "";
                                    }
                                }
                                else {
                                    $saN = "";
                                }

                                if (isset($laser_devices)) {
                                    if ($laser_devices == "Yes") {
                                        $ldY = "checked=\"checked\"";
                                    }
                                    else if ($laser_devices == "No") {
                                        $ldN = "checked=\"checked\"";
                                    }
                                    else {
                                        $ldN = "";
                                    }
                                }
                                else {
                                    $ldN = "";
                                }

                                if (isset($radiation_producing_machines )) {
                                    if ($radiation_producing_machines  == "Yes") {
                                        $rpmY = "checked=\"checked\"";
                                    }
                                    else if ($radiation_producing_machines  == "No") {
                                        $rpmN = "checked=\"checked\"";
                                    }
                                    else {
                                        $rpmN = "";
                                    }
                                }
                                else {
                                    $rpmN = "";
                                }

                                ?>
                                <td>Human Subjects: </td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="cchumanSubjects" name="humanSubjects" type="radio" value="Yes" <?php echo $hsY; ?>
                                                                                               onclick="Hide('other', false, 'phumanSubjects1', 'phumanSubjects2');
                                                                                                   Hide('other', false, 'phumanSubjectsOr', 'phumanSubjectsOr');"/></label>
	Yes</td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="cchumanSubjects" name="humanSubjects" type="radio" value="No" <?php echo $hsN; ?>
                                                                                               onclick="Hide('other', true, 'phumanSubjects1', 'phumanSubjects2');
                                                                                                   Hide('other', true, 'phumanSubjectsOr', 'phumanSubjectsOr');"/></label>
	No</td>
                                <td width="15%">
                                    <span id="phumanSubjects1"><label><span style="visibility:hidden;">label</span><input id="ccphumanSubjects1" name="ccphumanSubjects" type="radio" value="Pending" <?php echo $hsP; ?>/></label>Pending</span>
                                </td>
                                <td width="6%"> <span id="phumanSubjectsOr"><u>or</u></span></td>
                                <td width="35%"> <span id="phumanSubjects2">
                                        <label><span style="visibility:hidden;">label</span><input id="ccphumanSubjects2" name="ccphumanSubjects" type="radio" value="Approved" <?php echo $hsA; ?>/></label>Approved
		Protocol #: <label><span style="visibility:hidden;">label</span><input name="phumanSubjectsNo" type="text" id="ccphumanSubjectsNo" size="6" <?php echo $hsDT; ?>/></label></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Vertebrate Animals: </td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="ccvAnimals" name="vAnimals" type="radio" value="Yes" <?php echo $vaY; ?>
                                                                                               onclick="Hide('other', false, 'pvAnimals1', 'pvAnimals2');
                                                                                                   Hide('other', false, 'pvAnimalsOr', 'pvAnimalsOr');"/></label>
	Yes</td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="ccvAnimals" name="vAnimals" type="radio" value="No" <?php echo $vaN; ?>
                                                                                               onclick="Hide('other', true, 'pvAnimals1', 'pvAnimals2');
                                                                                                   Hide('other', true, 'pvAnimalsOr', 'pvAnimalsOr');"/></label>
	No</td>
                                <td width="15%"> <span id="pvAnimals1">
                                        <label><span style="visibility:hidden;">label</span><input id="ccpvAnimals1" name="pvAnimals" type="radio" value="Pending" <?php echo $vaP; ?> /></label>
		Pending</span>
                                </td>
                                <td width="6%"> <span id="pvAnimalsOr"><u>or</u></span></td>
                                <td width="35%"> <span id="pvAnimals2">
                                        <label><span style="visibility:hidden;">label</span><input id="ccpvAnimals2" name="pvAnimals" type="radio" value="Approved" <?php echo $vaA; ?> /></label>Approved
			Protocol #: <label><span style="visibility:hidden;">label</span><input name="pvAnimalsNo" type="text" id="ccpvAnimalsNo" size="6" <?php echo $vaDT; ?> /></label>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Recombinant DNA: </td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="ccrDNA" name="rDNA" type="radio" value="Yes" <?php echo $rdY; ?>
                                                                                               onclick="Hide('other', false, 'prDNA1', 'prDNA2');
                                                                                                   Hide('other', false, 'prDNAOr', 'prDNAOr');"/></label>
	Yes</td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="ccrDNA" name="rDNA" type="radio" value="No" <?php echo $rdN; ?>
                                                                                               onclick="Hide('other', true, 'prDNA1', 'prDNA2');
                                                                                                   Hide('other', true, 'prDNAOr', 'prDNAOr');"/></label>
	No</td>
                                <td width="15%"> <span id="prDNA1">
                                        <label><span style="visibility:hidden;">label</span><input id="ccprDNA1" name="prDNA" type="radio" value="Pending" <?php echo $rdP; ?> /></label>
		Pending</span>
                                </td>
                                <td width="6%"> <span id="prDNAOr"><u>or</u></span></td>
                                <td width="35%"> <span id="prDNA2">
                                        <label><span style="visibility:hidden;">label</span><input id="ccprDNA2" name="prDNA" type="radio" value="Approved" <?php echo $rdA; ?> /></label>Approved
		Protocol #: <label><span style="visibility:hidden;">label</span><input name="prDNANo" type="text" id="ccprDNANo" size="6" <?php echo $rdDT; ?> /></label></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Biological Agents(BSL2+): </td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="ccbAgents" name="bAgents" type="radio" value="Yes" <?php echo $baY; ?>
                                                                                               onclick="Hide('other', false, 'pbAgents1', 'pbAgents2');/*CheckEHApproval();*/
                                                                                                   Hide('other', false, 'pbAgentsOr', 'pbAgentsOr');"/></label>
	Yes</td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="ccbAgents" name="bAgents" type="radio" value="No" <?php echo $baN; ?>
                                                                                               onclick="Hide('other', true, 'pbAgents1', 'pbAgents2');/*CheckEHApproval();*/
                                                                                                   Hide('other', true, 'pbAgentsOr', 'pbAgentsOr');"/></label>
	No</td>
                                <td width="15%"> <span id="pbAgents1">
                                        <label><span style="visibility:hidden;">label</span><input id="ccpbAgents1" name="pbAgents" type="radio" value="Pending" <?php echo $baP; ?> /></label>
		Pending</span>
                                </td>
                                <td width="6%"> <span id="pbAgentsOr"><u>or</u></span></td>
                                <td width="35%"> <span id="pbAgents2">
                                        <label><span style="visibility:hidden;">label</span><input id="ccpbAgents2" name="pbAgents" type="radio" value="Approved" <?php echo $baA; ?> /></label>Approved
		Protocol #: <label><span style="visibility:hidden;">label</span><input name="pbAgentsNo" type="text" id="ccpbAgentsNo" size="6" <?php echo $baDT; ?> /></label></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Select Agents: </td>
                                <td><input id="ccselectAgents" name="selectAgents" type="radio" value="Yes" <?php print($saY); ?>/>Yes</td>
                                <td colspan="4"><input id="ccselectAgents" name="selectAgents" type="radio" value="No" <?php print($saN); ?>/>No</td>
                            </tr>
                            <tr></tr><tr></tr><tr></tr>

                            <tr>
                                <td colspan="6">
                                    <b>Environment Health & Safety: </b> EH & S can be reached at x2-2185.
                                </td>
                            </tr>
                            <tr>
                                <td>Radioactive Materials: </td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="ccradioMaterials" name="ccradioMaterials" type="radio" value="Yes" <?php echo $rmY; ?>
                                                                                               onclick="Hide('other', false, 'pradioMaterials1', 'pradioMaterials2');CheckEHApproval();
                                                                                                   Hide('other', false, 'pradioMaterialsOr', 'pradioMaterialsOr');"/></label>
	Yes</td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="ccradioMaterials" name="ccradioMaterials" type="radio" value="No" <?php echo $rmN; ?>
                                                                                               onclick="Hide('other', true, 'pradioMaterials1', 'pradioMaterials2');CheckEHApproval();
                                                                                                   Hide('other', true, 'pradioMaterialsOr', 'pradioMaterialsOr');"/></label>
	No</td>
                                <td width="15%"> <span id="pradioMaterials1">
                                        <label><span style="visibility:hidden;">label</span><input id="ccpradioMaterials1" name="pradioMaterials" type="radio" value="Pending" <?php echo $rmP; ?> /></label>
		Pending</span>
                                </td>
                                <td width="6%"> <span id="pradioMaterialsOr"><u>or</u></span></td>
                                <td width="35%"> <span id="pradioMaterials2">
                                        <label><span style="visibility:hidden;">label</span><input id="ccpradioMaterials2" name="pradioMaterials" type="radio" value="Approved" <?php echo $rmA; ?> /></label>Approval
		Date: <label><span style="visibility:hidden;">label</span><input name="pradioMaterialsNo" type="text" id="ccpradioMaterialsNo" size="10" <?php echo $rmDT; ?> /></label></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Controlled Substances: </td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="cccSubstances" name="cSubstances" type="radio" value="Yes" <?php echo $csY; ?>
                                                                                               onclick="Hide('other', false, 'pcSubstances1', 'pcSubstances2');CheckEHApproval();
                                                                                                   Hide('other', false, 'pcSubstancesOr', 'pcSubstancesOr');"/></label>
	Yes</td>
                                <td width="12%">
                                    <label><span style="visibility:hidden;">label</span><input id="cccSubstances" name="cSubstances" type="radio" value="No" <?php echo $csN; ?>
                                                                                               onclick="Hide('other', true, 'pcSubstances1', 'pcSubstances2');CheckEHApproval();
                                                                                                   Hide('other', true, 'pcSubstancesOr', 'pcSubstancesOr');"/></label>
	No</td>
                                <td width="15%"> <span id="pcSubstances1">
                                        <label><span style="visibility:hidden;">label</span><input id="ccpcSubstances1" name="pcSubstances" type="radio" value="Pending" <?php echo $csP; ?> /></label>
		Pending</span>
                                </td>
                                <td width="6%"> <span id="pcSubstancesOr"><u>or</u></span></td>
                                <td width="35%"> <span id="pcSubstances2">
                                        <label><span style="visibility:hidden;">label</span><input id="ccpcSubstances2" name="pcSubstances" type="radio" value="Approved" <?php echo $csA; ?> /></label>DEA
		License #: <label><span style="visibility:hidden;">label</span><input name="pcSubstancesNo" type="text" id="ccpcSubstancesNo" size="10" <?php echo $csDT; ?> /></label></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Radiation Producing Machines:</td>
                                <td><label><span style="visibility:hidden;">label</span><input id="ccrpMachines" name="rpMachines" type="radio" value="Yes" <?php echo $rpmY; ?>
                                                                                               onclick="CheckEHApproval();"/></label>Yes</td>
                                <td><label><span style="visibility:hidden;">label</span><input id="ccrpMachines" name="rpMachines" type="radio" value="No" <?php echo $rpmN; ?> onClick="CheckEHApproval();"/></label>No</td>
                                <td colspan="3" rowspan="2">
                                    <center>
                                        <span id="EHApprovalSpace"><b>EH & S Required Approval Space</b></span>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>Laser Devices:</td>
                                <td><label><span style="visibility:hidden;">label</span><input id="cclDevices" name="lDevices" type="radio" value="Yes" <?php echo $ldY; ?>
                                                                                               onclick="CheckEHApproval();"/></label>Yes</td>
                                <td><label><span style="visibility:hidden;">label</span><input id="cclDevices" name="lDevices" type="radio" value="No" <?php echo $ldN; ?> onClick="CheckEHApproval();"/></label>No</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br />
            <!-- External Collaborators & Subcontractors Section -->
            <table width=80% style="border: 1px solid #0000CC;">
                <tr>
                    <td class="tdHeader" width="80%">
                        <b>7. External Collaborators & Subcontractors</b></td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('extITableHelp', this)" style="cursor:pointer">Show Help</span>
                    </td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('extITable', this)" style="cursor:pointer">Collapse</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top">
                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="extITableHelp">
                            <tr><td class="tdSmall">
		This section is optional, but is helpful for setting up budgets and managing 
		collaborations and should be used if there is a subcontract.<br />
		This section is reserved for the lead investigator at any external institution. 
		For example, if a group from UTSW were participating in the research, the lead investigator 
		would be listed here. Choose the method of funding for the collaborative institution. 
		If they will be paid from funds awarded to UTA, they are considered �Subcontractors�. 
		If they will be submitting a linked proposal, they are �Collaborators�. If they are not 
		receiving any funding at all please select �Unfunded�. 
		Please see help in "Budget" section, below, for an explanation of consultants. 
                                </td></tr>
                        </table>
                        <table width="100%" style="border-top: 1px dotted #0000CC" id="extITable">
                            <tr>
                                <td colspan="4">
	This section is for external, non-involved, non-UTA  personnel that will be listed on the proposal.  Please list only the lead investigator for each separate institution.  For method of funding, please select the option that applies to this proposal.
                                </td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>Institution Name: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="extInstName" type="text" id="extInstName" size="30"/></label></td>
                                <td>Contact Full Name: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="extFullName" type="text" id="extFullName" size="30"/></label></td>
                            </tr>
                            <tr>
                                <td>Department: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="extDept" type="text" id="extDept" size="30" /></label><!--? MakeDeptComboBox("extDept"); ?--></td>
                                <td>Box #:</td>
                                <td><label><span style="visibility:hidden;">label</span><input name="extBox#" type="text" id="extBox#" size="10"/></label></td>
                            </tr>
                            <tr>
                                <td>Email Address: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="extEmail" type="text" id="extEmail" size="30"/></label></td>
                                <td>Phone Number: </td>
                                <td><label><span style="visibility:hidden;">label</span><input name="extPhoneNumber" type="text" id="extPhoneNumber" size="20"/></label></td>
                            </tr>
                            <tr>
                                <td>Rank: </td>
                                <td>
<?php
MakeRankComboBox("extRank", "ext");
?>
                                </td>
                                <td><span id="extRankOther1" style="display:none;">Other:</span></td>
                                <td><span id="extRankOther2" style="display:none;">
                                        <label><span style="visibility:hidden;">label</span><input name="extRankopt" type="text" id="extRankopt" size="20"/></label>
                                    </span></td>
                            </tr>
                            <tr>
                                <td>Citizenship:</td>
                                <td colspan="3">
                                    <label><span style="visibility:hidden;">label</span><input name="extCitizenship" id="extCitizenship1" type="radio" value="U.S. Citizen/Permanent Resident" checked="checked"/></label>
                                    U.S. Citizen/Permanent Resident &nbsp;&nbsp;&nbsp;
                                    <label><span style="visibility:hidden;">label</span><input name="extCitizenship" id="extCitizenship2" type="radio" value="Non - U.S. Citizen" /></label>
                                    Non - U.S. Citizen
                                </td>
                            </tr>
                            <tr>
                                <td>Funding:</td>
                                <td colspan="2"><label><span style="visibility:hidden">label</span>
                                        <select name="extFunded1" size="1" id="extFunded1">
                                            <option value="Subcontractor - Funded through UTA's Budget">
		Subcontractor - Funded through UTA's Budget</option>
                                            <option value="Consultant - Funded through UTA's Budget">
		Consultant - Funded through UTA's Budget</option>
                                            <option value="Collaborator - Funded through simultaneously submitted proposal">
		Collaborator - Funded through simultaneously submitted proposal</option>
                                            <option value="Unfunded Consultant/Collaborator">
		Unfunded Consultant/Collaborator</option>
                                        </select></label>
                                </td>
                                <td align="left">
                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='AddRow("extIs")' style="border: 1px solid;background: #FFFFFF" value="Add"/>&nbsp;&nbsp;</label>
                                </td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td colspan="4">
                                    <table class="tdSmall" style="border: 1px dotted #0066FF; display:none;"
                                           id="extIs" width=100% align="center">
                                        <tr>
                                            <td colspan="9"><b>Added External Investigators</b><hr style="border: 1px dotted #0066FF;"/></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                </tr>
            </table>
            <br />
            <!--  Facilities & Administrative Cost (Indirect Cost) Calculations Section -->
            <table width=80% style="border: 1px solid #0000CC;">
                <tr>
                    <td class="tdHeader" width="80%">
                        <b>8. Facilities & Administrative Cost (Indirect Cost) Calculations</b></td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('faccTableHelp', this)" style="cursor:pointer">Show Help</span>
                    </td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('faccTable', this)" style="cursor:pointer">Collapse</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top">
                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="faccTableHelp">
                            <tr><td class="tdSmall">
		The University of Texas at Arlington has in place a negotiated Indirect Cost (IDC) Agreement with
		 the federal government through the Department of Health and Human Services (DHHS). 
		 The university�s standard rate is 48% of Modified Total Direct Costs. This rate should be 
		 used for all proposals unless the sponsor limits IDC or prohibits it altogether. For a 
		 reduced rate to be proposed the sponsor must specifically state the limitation <b>in writing</b>
		 and it must be the stated policy for the company/agency for all sponsored research. 
		 If the research is conducted off-campus <b>and</b> rent is paid for the facilities as a 
		 direct cost to the project, the off-campus rate of 26% is applied. This rate does not apply 
		 to subcontracts.<br />
		If it is in the university�s best interest, a portion of IDC may be waived. 
		Such a waiver must be sought and approved <b>prior</b> to submission of the proposal. 
		Approval of a waiver may only be granted by the Vice President for Research or the 
		Director of GCS. A reduction in IDC requires an adequate justification for the waiver 
		to determine if it is in the best interests of the university. Documentation of such 
		a waiver must be provided <b>prior</b> to submission. Sufficient time must be given for the 
		consideration of the request. The form for a reduced IDC rate may be found here � 
                                    <a href="idcwaiverform2006.doc">IDC Waiver Form</a>.
                                    <br />
		Choose the IDC option applicable to your proposal from the drop-down list. 
		Enter the applicable percentage rate in the �F&A Percentage Rate� field.
                                </td></tr>
                        </table>
                        <table width="100%" style="border-top: 1px dotted #0000CC" id="faccTable">
                            <tr>
                                <td>
	Is the Standard University Rate allowed by the Sponsor? Please read the Descriptions located <a href="Instructions.htm#7">here</a> and choose from the list below.<br />
                                    <a href="idccost_distribfinal2006.doc"> IDC Cost Distribution Form</a>
                                    <br /><Br /><label><span style="visibility:hidden">label</span>
                                        <select name="stdUnivRate" id="stdUnivRate"
                                                onchange='if ((options[selectedIndex].id == "4") || (options[selectedIndex].id == "5")) {frmBS.fAPercentage.readOnly = false; frmBS.fAPercentage.value = "0";} else {frmBS.fAPercentage.value = options[selectedIndex].id;frmBS.fAPercentage.readOnly = true;}'>
                                            <option id="48" value="Standard University rate of 48% MTDC" >
			Standard University rate of 48% MTDC</option>
                                            <option id="26" value="Off Campus rate * of 26% MTDC">
			Off Campus rate * of 26% MTDC</option>
                                            <option id="0" value="F &amp; A/IDC not allowed by Sponsor">
			F &amp; A/IDC not allowed by Sponsor</option>
                                            <option id="4" value="Sponsor Limits F&amp; A/IDC to">
			Sponsor Limits F&amp; A/IDC to (enter below)%</option>
                                            <option id="5" value="Other approved rate by VP Research. (Documentation of waiver must be provided.">
			Other approved rate by VP Research **. (Documentation of waiver must be provided.)</option>
                                        </select></label>
                                    <br />
	F &amp; A percentage rate: 
                                    <label><span style="visibility:hidden;">label</span><input name="fAPercentage" type="text" id="pifAPercentage" value="49.5" size="4" maxlength="5" readonly="true" />%</label>
<?php 
if (isset($fna)) {
    ?>
                                    <script>
                                        //document.getElementById("<?php echo $fna; ?>").selected = true;
                                        if ("<?php print($fna); ?>" == "48")
                                        document.getElementById("stdUnivRate").options[0].selected = true;
                                        else if ("<?php print($fna); ?>" == "26")
                                        document.getElementById("stdUnivRate").options[1].selected = true;
                                        else if ("<?php print($fna); ?>" == "0")
                                        document.getElementById("stdUnivRate").options[2].selected = true;
                                        else if ("<?php print($fna); ?>" == "4")
                                        document.getElementById("stdUnivRate").options[3].selected = true;
                                        else if ("<?php print($fna); ?>" == "5")
                                        document.getElementById("stdUnivRate").options[4].selected = true;
                                        document.getElementById("pifAPercentage").value = "<?php print($fna); ?>";
                                    </script>
    <?php
}
?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br />
            <!-- Budget Section -->
            <A NAME="budget" style="visibility:hidden;">Budget</A>
            <table width=80% style="border: 1px solid #0000CC;" id="budget_section">
                <tr>
                    <td class="tdHeader" width="80%">
                        <b>9. Budget</b></td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('budgetTableHelp', this)" style="cursor:pointer">Show Help</span>
                    </td>
                    <td align="right" class="tdSmall" width="10%">
                        <span onClick="ToggleTable('budgetTable', this)" style="cursor:pointer">Collapse</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top">
                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="budgetTableHelp">
                            <tr><td class="tdSmall">
		Enter the proposed start and end dates. Fill in the budget information based upon your request to the sponsor. </SPAN>
                                    <UL>
                                        <LI>Salary consists of payments made to all faculty, staff, and students. Pay scales should be consistent for those used within your department and with Human Resources policies.
                                            <LI>Fringe rates are as follows: (insert estimated percentages when known)
                                                <LI>M&amp;O consists of all materials and supplies that cost less than $5,000 per unit or have a useful life of less than a year.
                                                    <LI>Consultants are individuals not employed by UTA providing a service to the project. Human Subjects participating in research provide a service and are paid as consultants.
                                                        <LI>Sub-Contracts may require some additional information. Please contact your specialist if you anticipate using subcontractors.
                                                            <LI>Scholarships can only be provided under certain circumstances. Please contact your specialist before budgeting funds for scholarships.
                                                                <LI>Tuition is not permitted on any federal research proposals and only in certain situations on other proposals. Again, please contact your specialist before budgeting funds in this area.
                                                                    <LI>Participant Support is provided to individuals not employed by UTA who may be participating in the research proposed. Participants are not required to provide services or receive payment contingent on an event. ONLY Students currently enrolled may be paid as Participant Support.
                                                                        <LI>Funds may be budgeted for 34>travel as either foreign or domestic depending on sponsor limitations.
                                                                            <LI>Participant travel is generally used to reimburse people participating in the research for their travel costs to and from the research site.
                                                                                <LI>Equipment consists only of items with a per unit price of $5,000 or greater <STRONG>and</STRONG> a useful life of one year or longer.
                                                                                    <LI>Modified Total Direct Costs (MTDC) consist of the Total Direct Costs (TDC) less any fund for scholarships, tuition, equipment, participant support, participant travel, and the amount of each subcontract that exceeds $25,000.
                                                                                        <LI>Facilities and Administration costs (F&amp;A or IDC) are calculated by multiplying the MTDC by the percentage of IDC.
                                                                                            <LI>Total Costs are the sum of the Total Direct Costs and the IDC. </LI>
                                                                                            </UL>
                                                                                            </td></tr>
                                                                                            </table>

                                                                                            <table width="100%" style="border-top: 1px dotted #0000CC" id="budgetTable">
                                                                                                <tr>
                                                                                                    <td>

                                                                                                        <table width="99%"  border="0" cellpadding="0" cellspacing="3" id="budgetInnerTable">
                                    <?
                                    /*
  if (isset($_GET['stopec']))
  {
  	$query = "delete from bs_ec_mapping where bs_id=$bs_id";
	$result = mysql_query($query, $connect1);// or die("199 - " . mysql_error() . " -- " . $query);
	unset($_GET['ec_id']);
  }
  if (isset($_GET['ec_id']))
  {
	$ec_id = $_GET['ec_id'];
	$query = "select ec_id from ec_main where ec_id=$ec_id";
	$result = mysql_query($query, $connect1);// or die("199 - " . mysql_error() . " -- " . $query);	
	//$num_rows = mysql_num_rows($result);
	//if ($num_rows > 0)
	if ($result != null)
	{
		$query = "delete from bs_ec_mapping where bs_id=$bs_id";
		$result = mysql_query($query, $connect1);// or die("199 - " . mysql_error() . " -- " . $query);	
		$query = "insert into bs_ec_mapping VALUES($bs_id, $ec_id)";
		$result = mysql_query($query, $connect1);// or die("199 - " . mysql_error() . " -- " . $query);
	}
	else
	{
		unset($_GET['ec_id']);
		unset($ec_id);
	}
  }
  else
  {
	$query = "select * from bs_ec_mapping where bs_id=" . (($bs_id=="")?"0":$bs_id);
	$result = mysql_query($query, $connect1) or die("198 - " . mysql_error() . " -- " . $query);
	if ($row = mysql_fetch_array($result))
	{
		$query = "select ec_id from ec_main where ec_id=" . $row["ec_id"];
		$result1 = mysql_query($query, $connect1);// or die("199 - " . mysql_error() . " -- " . $query);	
		if ($result1 != null)
		{	
			$_GET['ec_id'] = $row["ec_id"];
			$ec_id = $row["ec_id"];
		}
	}
  }
  if (isset($_GET['ec_id']))
  {	
	// Get the project durations from here...
	$query = "select * from ec_main where ec_id=$ec_id";
	$result = mysql_query($query, $connect1) or die("100 - " . mysql_error() . " -- " . $query);
	if ($row = mysql_fetch_array($result))
	{
		$prj_period_from = $row["start_date"];
		$prj_period_to = $row["end_date"];
		$ec_name = $row["name"];
	}
  }
*/
?>
                                                                                                            <tr>
                                                                                                                <td colspan="9" align="center">
                                                                                                                    <!--
		<b>
		Import budget from saved Effort Calculators: </b><label><span style="visibility:hidden">label</span>
                                                                                                                    <select name="get_ec_id" id="get_ec_id" class="input">
<?
/*
				$calc_avail = false;
				$query = "SELECT ec_id, name FROM ec_main WHERE login_id='" . $_SESSION['UID'] . "'";
				$result = mysql_query($query, $connect1) or die("030 - " . mysql_error() . " -- " . $query);
				while($row = mysql_fetch_array($result))
				{
					echo "<option value='" . $row["ec_id"] . "'>" . $row["name"] . "</option>";
					$calc_avail = true;
				}
				if (!$calc_avail)
				{
					echo "<option value='-1'>No saved calculators found.</option>";
					$calc_avail = "disabled=\"disabled\"";
				}
				else
					$calc_avail = "";
                                                                                                            */
                                                                                                            ?>
	      </select></label>
	    <label><span style="visibility:hidden;">label</span><input type="button" value=" Import " <?php echo $calc_avail; ?> onclick="self.location=self.location.href.replace('#budget','').replace('&stopec=true','').replace('&ec_id=<?php echo $_GET['ec_id']; ?>','') + '&ec_id=' + d('get_ec_id').value + '#budget';" /> </label>
		&nbsp; &nbsp; 
                                                                                                            <?
                                                                                                            /*
			if (isset($_GET['ec_id']))
			{
				?>
				<label><span style="visibility:hidden;">label</span><input type="button" value=" Stop using Effort Calculator " onclick="self.location = self.location.href.replace('#budget','').replace('&ec_id=<?php echo $_GET['ec_id']; ?>','') + '&stopec=true#budget';" /></label>
				<br /><br />
				<b>Currently using: <a href="../effort_calc/effort_calc.php?ec_id=<?php echo $_GET['ec_id']?>"><?php echo $ec_name?></a></b>
				<br />
				(Budget values cannot be changed, Use effort calculator to make changes)
				<?
			}
                                                                                                            */
                                                                                                            ?>
		<br /><br />
		-->
		Total Project Period: 
                                                                                                                    <label><span style="visibility:hidden;">label</span><input readonly onclick="document.getElementById('button1').onclick();" name="bu_prjYr1" type="text" id="bu_prjYr1" tabindex="1" size="10" <?php if (isset($prj_period_from)) echo "value=\"$prj_period_from\""; ?>/> <img alt="calender" src="images/calendar.jpg" id="button1" /></label>
                                                                                                                    &nbsp;  to &nbsp;
                                                                                                                    <label><span style="visibility:hidden;">label</span><input readonly onclick="document.getElementById('button2').onclick();" name="bu_prjYr2" type="text" id="bu_prjYr2" tabindex="2" size="10" <?php if (isset($prj_period_to)) echo "value=\"$prj_period_to\""; ?>/> <img alt="calender" src="images/calendar.jpg" id="button2" /></label>
                                                                                                                    <!--span class="tdSmall">(enter date in mm/dd/yy format)</span-->
                                                                                                                    <script type="text/javascript">
                                                                                                                        Calendar.setup(
                                                                                                                        {
                                                                                                                            inputField  : "bu_prjYr1",         // ID of the input field
                                                                                                                            ifFormat    : "%m/%d/%Y",    // the date format
                                                                                                                            button      : "button1"       // ID of the button
                                                                                                                        }
                                                                                                                    );

                                                                                                                        Calendar.setup(
                                                                                                                        {
                                                                                                                            inputField  : "bu_prjYr2",         // ID of the input field
                                                                                                                            ifFormat    : "%m/%d/%Y",    // the date format
                                                                                                                            button      : "button2"       // ID of the button
                                                                                                                        }
                                                                                                                    );
                                                                                                                    </script>

                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2" width="38%"><b>Direct Costs</b></td>
                                                                                                                <td width="7%" align="center"><b>Year 1</b></td>
                                                                                                                <td width="7%" align="center"><b>Year 2</b></td>
                                                                                                                <td width="7%" align="center"><b>Year 3</b></td>
                                                                                                                <td width="7%" align="center"><b>Year 4</b></td>
                                                                                                                <td width="7%" align="center"><b>Year 5</b></td>
                                                                                                                <td width="7%"><b>Project Total</b></td>
                                                                                                                <td width="13%">&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                    <?php $k=3;?>
                                                                                                                <td colspan="2">12 Salary</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_sal1" type="text" id="bu_sal1" tabindex="<?php echo($k);?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_sal');tdc('1');" value="0" size=8 /></label></td>
                                                                                                                    <?php $j = $k+11+(2*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_sal2" type="text" id="bu_sal2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_sal');tdc('2');" value="0" size="8" /></label></td>
                                                                                                                    <?php $j = $k+22+(3*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_sal3" type="text" id="bu_sal3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_sal');tdc('3');" value="0" size="8" /></label></td>
                                                                                                                    <?php $j = $k+33+(4*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_sal4" type="text" id="bu_sal4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_sal');tdc('4');" value="0" size="8" /></label></td>
                                                                                                                    <?php $j = $k+44+(5*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_sal5" type="text" id="bu_sal5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_sal');tdc('5');" value="0" size="8" /></label></td>
                                                                                                                    <?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_salTotal" type="text" id="bu_salTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">14 Fringe Benefits</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_fb1" type="text" id="bu_fb1" tabindex="<?php echo($k);?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_fb');tdc('1');" value="0" size="8" /></label></td>
                                                                                                                    <?php $j = $k+11+(2*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_fb2" type="text" id="bu_fb2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_fb');tdc('2');" value="0" size="8" /></label></td>
                                                                                                                    <?php $j = $k+22+(3*$subConNo);?>
                                                                                                                <td> <label><span style="visibility:hidden;">label</span><input name="bu_fb3" type="text" id="bu_fb3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_fb');tdc('3');" value="0" size="8" /></label>    </td>
                                                                                                                    <?php $j = $k+33+(4*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_fb4" type="text" id="bu_fb4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_fb');tdc('4');" value="0" size="8" /></label></td>
                                                                                                                    <?php $j = $k+44+(5*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_fb5" type="text" id="bu_fb5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_fb');tdc('5');" value="0" size="8" /></label></td>
                                                                                                                    <?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_fbTotal" type="text" id="bu_fbTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td height="24" colspan="2">50 M&amp;O - Materials</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mo1" type="text" id="bu_mo1" tabindex="<?php echo($k);?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_mo');tdc('1');" value="0" size="8" /></label></td>
                                                                                                                    <?php $j = $k+11+(2*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mo2" type="text" id="bu_mo2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_mo');tdc('2');" value="0" size="8" /></label></td>
<?php $j = $k+22+(3*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mo3" type="text" id="bu_mo3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_mo');tdc('3');" value="0" size="8" /></label></td>
<?php $j = $k+33+(4*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mo4" type="text" id="bu_mo4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_mo');tdc('4');" value="0" size="8" /></label></td>
<?php $j = $k+44+(5*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mo5" type="text" id="bu_mo5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_mo');tdc('5');" value="0" size="8" /></label></td>
<?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_moTotal" type="text" id="bu_moTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">60 Consulting Services <span class="tdSmall">(non-UTA)</span></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_conServ1" type="text" id="bu_conServ1" tabindex="<?php echo($k);?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_conServ');tdc('1');" value="0" size="8" /></label></td>
<?php $j = $k+11+(2*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_conServ2" type="text" id="bu_conServ2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_conServ');tdc('2');" value="0" size="8" /></label></td>
<?php $j = $k+22+(3*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_conServ3" type="text" id="bu_conServ3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_conServ');tdc('3');" value="0" size="8" /></label></td>
<?php $j = $k+33+(4*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_conServ4" type="text" id="bu_conServ4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_conServ');tdc('4');" value="0" size="8" /></label></td>
<?php $j = $k+44+(5*$subConNo);?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_conServ5" type="text" id="bu_conServ5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_conServ');tdc('5');" value="0" size="8" /></label></td>
<?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_conServTotal" type="text" id="bu_conServTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="5">61 Sub-Contracts</td>
                                                                                                                <td colspan="3" align="right">
                                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='AddRow("budgetInnerTable")' style="border: 1px solid;background: #FFFFFF" value="Add Sub-Contracts" id="addSubCo"/></label>
                                                                                                                </td>
                                                                                                                <td></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">70 Scholarships/Stipend</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ss1" type="text" id="bu_ss1" tabindex="<?php echo($k); ?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ss');tdc('1');" value="0" size="8" /></label></td>
                                                                                                                <?php $j=$k+11+(2*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ss2" type="text" id="bu_ss2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ss');tdc('2');" value="0" size="8" /></label></td>
<?php $j=$k+22+(3*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ss3" type="text" id="bu_ss3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ss');tdc('3');" value="0" size="8" /></label></td>
<?php $j=$k+33+(4*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ss4" type="text" id="bu_ss4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ss');tdc('4');" value="0" size="8" /></label></td>
<?php $j=$k+44+(5*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ss5" type="text" id="bu_ss5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ss');tdc('5');" value="0" size="8" /></label></td>
<?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ssTotal" type="text" id="bu_ssTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">71 Tuition</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tuition1" type="text" id="bu_tuition1" tabindex="<?php echo($k); ?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tuition');tdc('1');" value="0" size="8" /></label></td>
<?php $j=$k+11+(2*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tuition2" type="text" id="bu_tuition2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tuition');tdc('2');" value="0" size="8" /></label></td>
<?php $j=$k+22+(3*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tuition3" type="text" id="bu_tuition3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tuition');tdc('3');" value="0" size="8" /></label></td>
<?php $j=$k+33+(4*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tuition4" type="text" id="bu_tuition4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tuition');tdc('4');" value="0" size="8" /></label></td>
<?php $j=$k+44+(5*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tuition5" type="text" id="bu_tuition5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tuition');tdc('5');" value="0" size="8" /></label></td>
<?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tuitionTotal" type="text" id="bu_tuitionTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">72 Participant Support</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ps1" type="text" id="bu_ps1" tabindex="<?php echo($k); ?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ps');tdc('1');" value="0" size="8" /></label></td>
<?php $j=$k+11+(2*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ps2" type="text" id="bu_ps2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ps');tdc('2');" value="0" size="8" /></label></td>
<?php $j=$k+22+(3*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ps3" type="text" id="bu_ps3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ps');tdc('3');" value="0" size="8" /></label></td>
<?php $j=$k+33+(4*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ps4" type="text" id="bu_ps4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ps');tdc('4');" value="0" size="8" /></label></td>
<?php $j=$k+44+(5*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_ps5" type="text" id="bu_ps5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_ps');tdc('5');" value="0" size="8" /></label></td>
<?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_psTotal" type="text" id="bu_psTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">75 Travel (Domestic)</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tDom1" type="text" id="bu_tDom1" tabindex="<?php echo($k); ?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tDom');tdc('1');" value="0" size="8" /></label></td>
<?php $j=$k+11+(2*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tDom2" type="text" id="bu_tDom2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tDom');tdc('2');" value="0" size="8" /></label></td>
<?php $j=$k+22+(3*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tDom3" type="text" id="bu_tDom3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tDom');tdc('3');" value="0" size="8" /></label></td>
<?php $j=$k+33+(4*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tDom4" type="text" id="bu_tDom4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tDom');tdc('4');" value="0" size="8" /></label></td>
<?php $j=$k+44+(5*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tDom5" type="text" id="bu_tDom5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tDom');tdc('5');" value="0" size="8" /></label></td>
<?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tDomTotal" type="text" id="bu_tDomTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">76 Travel (Foreign)</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tFor1" type="text" id="bu_tFor1" tabindex="<?php echo($k);?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tFor');tdc('1');" value="0" size="8" /></label></td>
<?php $j=$k+11+(2*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tFor2" type="text" id="bu_tFor2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tFor');tdc('2');" value="0" size="8" /></label></td>
<?php $j=$k+22+(3*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tFor3" type="text" id="bu_tFor3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tFor');tdc('3');" value="0" size="8" /></label></td>
<?php $j=$k+33+(4*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tFor4" type="text" id="bu_tFor4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tFor');tdc('4');" value="0" size="8" /></label></td>
<?php $j=$k+44+(5*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tFor5" type="text" id="bu_tFor5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_tFor');tdc('5');" value="0" size="8" /></label></td>
<?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tForTotal" type="text" id="bu_tForTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2"><div align="left">77 Participant Travel</div></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_pTrav1" type="text" id="bu_pTrav1" tabindex="<?php echo($k);?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_pTrav');tdc('1');" value="0" size="8" /></label></td>
<?php $j=$k+11+(2*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_pTrav2" type="text" id="bu_pTrav2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_pTrav');tdc('2');" value="0" size="8" /></label></td>
<?php $j=$k+22+(3*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_pTrav3" type="text" id="bu_pTrav3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_pTrav');tdc('3');" value="0" size="8" /></label></td>
<?php $j=$k+33+(4*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_pTrav4" type="text" id="bu_pTrav4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_pTrav');tdc('4');" value="0" size="8" /></label></td>
<?php $j=$k+44+(5*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_pTrav5" type="text" id="bu_pTrav5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_pTrav');tdc('5');" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_pTravTotal" type="text" id="bu_pTravTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">78 STEM Tuition </td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_stem1" type="text" id="bu_stem1" tabindex="<?php echo($k);?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_stem');tdc('1');" value="0" size="8" /></label></td>
                                                                                                                <?php $j=$k+11+(2*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_stem2" type="text" id="bu_stem2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_stem');tdc('2');" value="0" size="8" /></label></td>
                                                                                                                <?php $j=$k+22+(3*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_stem3" type="text" id="bu_stem3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_stem');tdc('3');" value="0" size="8" /></label></td>
                                                                                                                <?php $j=$k+33+(4*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_stem4" type="text" id="bu_stem4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_stem');tdc('4');" value="0" size="8" /></label></td>
<?php $j=$k+44+(5*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_stem5" type="text" id="bu_stem5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_stem');tdc('5');" value="0" size="8" /></label></td>
<?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_stemTotal" type="text" id="bu_stemTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">80 Equipment</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_equip1" type="text" id="bu_equip1" tabindex="<?php echo($k);?>" onBlur="mtdc('1');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_equip');tdc('1');" value="0" size="8" /></label></td>
                                                                                                                <?php $j=$k+11+(2*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_equip2" type="text" id="bu_equip2" tabindex="<?php echo($j);?>" onBlur="mtdc('2');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_equip');tdc('2');" value="0" size="8" /></label></td>
                                                                                                                <?php $j=$k+22+(3*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_equip3" type="text" id="bu_equip3" tabindex="<?php echo($j);?>" onBlur="mtdc('3');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_equip');tdc('3');" value="0" size="8" /></label></td>
                                                                                                                <?php $j=$k+33+(4*$subConNo)-$subConNo;?>
                                                                                                                <td> <label><span style="visibility:hidden;">label</span><input name="bu_equip4" type="text" id="bu_equip4" tabindex="<?php echo($j);?>" onBlur="mtdc('4');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_equip');tdc('4');" value="0" size="8" /></label>
                                                                                                                </td>
<?php $j=$k+44+(5*$subConNo)-$subConNo;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_equip5" type="text" id="bu_equip5" tabindex="<?php echo($j);?>" onBlur="mtdc('5');" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" onKeyUp="total('bu_equip');tdc('5');" value="0" size="8" /></label></td>
<?php $k=$k+1;?>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_equipTotal" type="text" id="bu_equipTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="9" align="center">
                                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='AddRow("budgetInnerTable1")' style="border: 1px solid;background: #FFFFFF" value="Add Custom Categories" id="addCustomCa"/></label>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="9"><hr width="100%" style="border: 1px dotted #0066FF;"/></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">Total Direct Cost</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tdc1" type="text" id="bu_tdc1" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tdc2" type="text" id="bu_tdc2" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tdc3" type="text" id="bu_tdc3" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tdc4" type="text" id="bu_tdc4" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tdc5" type="text" id="bu_tdc5" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tdcTotal" type="text" id="bu_tdcTotal" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">Modified TDC</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mtdc1" type="text" id="bu_mtdc1" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mtdc2" type="text" id="bu_mtdc2" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mtdc3" type="text" id="bu_mtdc3" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mtdc4" type="text" id="bu_mtdc4" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mtdc5" type="text" id="bu_mtdc5" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_mtdcTotal" type="text" id="bu_mtdcTotal" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">90 Total Facilities &amp; Administration (IDC)</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_idc1" type="text" id="bu_idc1" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_idc2" type="text" id="bu_idc2" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_idc3" type="text" id="bu_idc3" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_idc4" type="text" id="bu_idc4" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_idc5" type="text" id="bu_idc5" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_idcTotal" type="text" id="bu_idcTotal" tabindex="-1" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="2">91 Total Costs (TC)</td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tc1" type="text" id="bu_tc1" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td> <label><span style="visibility:hidden;">label</span><input name="bu_tc2" type="text" id="bu_tc2" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label>
                                                                                                                </td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tc3" type="text" id="bu_tc3" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tc4" type="text" id="bu_tc4" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tc5" type="text" id="bu_tc5" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="8" /></label></td>
                                                                                                                <td><label><span style="visibility:hidden;">label</span><input name="bu_tcTotal" type="text" id="bu_tcTotal" tabindex="-1" onKeyPress="if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;" value="0" size="10" /></label></td>
                                                                                                                <td>&nbsp;</td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="9"><hr width="100%" style="border: 1px dotted #0066FF;"/></td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="5">Requested MTDC x Standard University Rate (48%) = </td>
                                                                                                                <td colspan="4">
                                                                                                                    <label><span style="visibility:hidden;">label</span><input name="bu_reqMTDC" type="text" id="bu_reqMTDC" value="0" size="10" readonly="true" /></label>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td colspan="5">Less Sponsor IDC (=<?php print($idcTotal);?> ) = Unrecovered IDC = </td>
                                                                                                                <td colspan="2">
                                                                                                                    <label><span style="visibility:hidden;">label</span><input name="bu_lIDC" type="text" id="bu_lIDC" value="0" size="10" readonly="true" /></label>
                                                                                                                </td>
                                                                                                                <td colspan="2">
                                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onClick="tdc('1');tdc('2');tdc('3');tdc('4');tdc('5');mtdc('1');mtdc('2');mtdc('3');mtdc('4');mtdc('5');" style="border: 1px solid;background: #FFFFFF" value="Re calculate budget"/></label>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </table>
<?
/*
if (isset($_GET['ec_id']))
{
	$ec_id = $_GET['ec_id'];
	$budgetCount = 0;
		
	// Salary
	//$query = "select ec_id, sum(Yr1) as Yr1, sum(Yr2) as Yr2, sum(Yr3) as Yr3, sum(Yr4) as Yr4, sum(Yr5) as Yr5 from ec_section_a where ec_id=$ec_id group by ec_id";
	$query = "SELECT SUM(IF(Year=1,amount,0)) AS Yr1, SUM(IF(Year=2,amount,0)) AS Yr2, SUM(IF(Year=3,amount,0)) AS Yr3, SUM(IF(Year=4,amount,0)) AS Yr4, SUM(IF(Year=5,amount,0)) AS Yr5 FROM ec_section_a1 where ec_id=$ec_id";
	$result = mysql_query($query, $connect1) or die("100 - " . mysql_error() . " -- " . $query);
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
	}
	$query = "select ec_id, sum(Yr1) as Yr1, sum(Yr2) as Yr2, sum(Yr3) as Yr3, sum(Yr4) as Yr4, sum(Yr5) as Yr5 from ec_section_b where ec_id=$ec_id group by ec_id";
	$result = mysql_query($query, $connect1) or die("101 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] += $row["Yr1"];
		$budgetYr2[$budgetCount] += $row["Yr2"];
		$budgetYr3[$budgetCount] += $row["Yr3"];
		$budgetYr4[$budgetCount] += $row["Yr4"];
		$budgetYr5[$budgetCount] += $row["Yr5"];
		$budgetName[$budgetCount] = "Salary";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "1";
		$budgetCount++;
	}	
	
	// Fringe Benefits
	$query = "select ec_id, sum(Yr1) as Yr1, sum(Yr2) as Yr2, sum(Yr3) as Yr3, sum(Yr4) as Yr4, sum(Yr5) as Yr5 from ec_section_c where ec_id=$ec_id group by ec_id";
	$result = mysql_query($query, $connect1) or die("102 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "Fringe Benefits";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "2";
		$budgetCount++;
	}	
	
	// Equipment
	$query = "select ec_id, sum(Yr1) as Yr1, sum(Yr2) as Yr2, sum(Yr3) as Yr3, sum(Yr4) as Yr4, sum(Yr5) as Yr5 from ec_section_defg where ec_id=$ec_id " . 
		"and row_id in (select row_id from ec_rows where section='d') group by ec_id";
	$result = mysql_query($query, $connect1) or die("103 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "Equipment";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "12";
		$budgetCount++;
	}			
		
	// STEM Tuition
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id " . 
		"and row_id in (select row_id from ec_rows where name='STEM Tuition') group by ec_id";
	$result = mysql_query($query, $connect1) or die("104 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "STEM Tuition";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "11";
		$budgetCount++;
	}	
	
	// Participant Travel
	$query = "select ec_id, sum(Yr1) as Yr1, sum(Yr2) as Yr2, sum(Yr3) as Yr3, sum(Yr4) as Yr4, sum(Yr5) as Yr5 from ec_section_defg where ec_id=$ec_id " .
		"and row_id in (select row_id from ec_rows where (name='Travel' or name='Subsistence') and section='f') group by ec_id";
	$result = mysql_query($query, $connect1) or die("105 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "Participant Travel";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "10";
		$budgetCount++;
	}
	
	// Travel Domestic
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id and row_id=28 group by ec_id";
	$result = mysql_query($query, $connect1) or die("106 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "Travel (Domestic)";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "8";
		$budgetCount++;
	}
	
	// Travel Foreign
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id and row_id=29 group by ec_id";
	$result = mysql_query($query, $connect1) or die("107 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "Travel (Foreign)";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "9";
		$budgetCount++;
	}	
	
	// Participant Support
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id " .
		"and row_id in (select row_id from ec_rows where name='Other' and section='f') group by ec_id";
	$result = mysql_query($query, $connect1) or die("108 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "Participant Support";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "7";
		$budgetCount++;
	}
			
	// Tuition
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id " . 
		"and row_id in (select row_id from ec_rows where name='Tuition' and section='f') group by ec_id";
	$result = mysql_query($query, $connect1) or die("109 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "Tuition";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "6";
		$budgetCount++;
	}
		
	// Scholarships/Stipend
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id " . 
		"and row_id in (select row_id from ec_rows where name='Stipend' and section='f') group by ec_id";
	$result = mysql_query($query, $connect1) or die("109 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "Scholarships/Stipend";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "5";
		$budgetCount++;
	}	
		
	// Materials & Supplies
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id " . 
		"and row_id in (select row_id from ec_rows where name='Material & Supplies' and section='g') group by ec_id";
	$result = mysql_query($query, $connect1) or die("109 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "M&O - Materials";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "3";
		$budgetCount++;
	}
		
	// Consulting Services
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id " .	
		"and row_id in (select row_id from ec_rows where name='Consultant Services' and section='g') group by ec_id";
	$result = mysql_query($query, $connect1) or die("110 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = $row["Yr1"];
		$budgetYr2[$budgetCount] = $row["Yr2"];
		$budgetYr3[$budgetCount] = $row["Yr3"];
		$budgetYr4[$budgetCount] = $row["Yr4"];
		$budgetYr5[$budgetCount] = $row["Yr5"];
		$budgetName[$budgetCount] = "Consulting Services (non-UTA)";
		$budgetTypeID[$budgetCount] = "4";
		$budgetID[$budgetCount] = "4";
		$budgetCount++;
	}
	
	// Subcontracts
	for ($z=1; $z<=15; $z++)
	{
		$query = "select ec_id, sum(Yr1) as Yr1, sum(Yr2) as Yr2, sum(Yr3) as Yr3, sum(Yr4) as Yr4, sum(Yr5) as Yr5, add_info from ec_section_defg " . 
			"where ec_id=$ec_id and row_id in (select row_id from ec_rows where name like '%Subaward " . $z . "%' and section='g') group by ec_id";
		$result = mysql_query($query, $connect1) or die("113 - " . mysql_error() . " -- " . $query);
		if ($row = mysql_fetch_array($result))
		{
			if ( ($row["Yr1"]!="0") || ($row["Yr2"]!="0") || ($row["Yr3"]!="0") || ($row["Yr4"]!="0") || ($row["Yr5"]!="0") || ($row["add_info"]!="") )
			{
				$budgetYr1[$budgetCount] = ($row["Yr1"]=="")?"0":$row["Yr1"];
				$budgetYr2[$budgetCount] = ($row["Yr2"]=="")?"0":$row["Yr2"];
				$budgetYr3[$budgetCount] = ($row["Yr3"]=="")?"0":$row["Yr3"];
				$budgetYr4[$budgetCount] = ($row["Yr4"]=="")?"0":$row["Yr4"];
				$budgetYr5[$budgetCount] = ($row["Yr5"]=="")?"0":$row["Yr5"];
				$budgetName[$budgetCount] = $row["add_info"];
				$budgetTypeID[$budgetCount] = "2";
				$budgetID[$budgetCount] = $z;
				$budgetCount++;
			}
		}
	}
		
	// Custom Categories
	// Publication Costs
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id and row_id=12 group by ec_id";
	$result = mysql_query($query, $connect1) or die("111 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = ($row["Yr1"]=="")?"0":$row["Yr1"];
		$budgetYr2[$budgetCount] = ($row["Yr2"]=="")?"0":$row["Yr2"];
		$budgetYr3[$budgetCount] = ($row["Yr3"]=="")?"0":$row["Yr3"];
		$budgetYr4[$budgetCount] = ($row["Yr4"]=="")?"0":$row["Yr4"];
		$budgetYr5[$budgetCount] = ($row["Yr5"]=="")?"0":$row["Yr5"];
		$budgetName[$budgetCount] = "Publication Costs";
		$budgetTypeID[$budgetCount] = "3";
		$budgetID[$budgetCount] = "100";
		$budgetCount++;
	}
	
	// Computer Services
	$query = "select ec_id, Yr1, Yr2, Yr3, Yr4, Yr5 from ec_section_defg where ec_id=$ec_id and row_id=14 group by ec_id";
	$result = mysql_query($query, $connect1) or die("112 - " . mysql_error() . " -- " . $query);	
	if ($row = mysql_fetch_array($result))
	{
		$budgetYr1[$budgetCount] = ($row["Yr1"]=="")?"0":$row["Yr1"];
		$budgetYr2[$budgetCount] = ($row["Yr2"]=="")?"0":$row["Yr2"];
		$budgetYr3[$budgetCount] = ($row["Yr3"]=="")?"0":$row["Yr3"];
		$budgetYr4[$budgetCount] = ($row["Yr4"]=="")?"0":$row["Yr4"];
		$budgetYr5[$budgetCount] = ($row["Yr5"]=="")?"0":$row["Yr5"];
		$budgetName[$budgetCount] = "Computer Services";
		$budgetTypeID[$budgetCount] = "3";
		$budgetID[$budgetCount] = "101";
		$budgetCount++;
	}	
}
                                                                                                        */
                                                                                                        if (isset($budgetCount)) {
                                                                                                            $mapping[1] = "bu_sal";
                                                                                                            $mapping[2] = "bu_fb";
                                                                                                            $mapping[3] = "bu_mo";
                                                                                                            $mapping[4] = "bu_conServ";
                                                                                                            $mapping[5] = "bu_ss";
                                                                                                            $mapping[6] = "bu_tuition";
                                                                                                            $mapping[7] = "bu_ps";
                                                                                                            $mapping[8] = "bu_tDom";
                                                                                                            $mapping[9] = "bu_tFor";
                                                                                                            $mapping[10] = "bu_pTrav";
                                                                                                            $mapping[11] = "bu_stem";
                                                                                                            $mapping[12] = "bu_equip";
                                                                                                            $mapping[13] = "bu_tdc";
                                                                                                            $mapping[14] = "bu_mtdc";
                                                                                                            $mapping[15] = "bu_idc";
                                                                                                            $mapping[16] = "bu_tc";

                                                                                                            echo "<script>";

                                                                                                            $disabled = "";
                                                                                                            /*
	if (isset($_GET['ec_id']))
	{
		$disabled = "readonly";
		for ($i=1; $i<17; $i++)
		{
			?>
			document.getElementById("<?php echo $mapping[$i]?>1").readOnly = true;
			document.getElementById("<?php echo $mapping[$i]?>2").readOnly = true;
			document.getElementById("<?php echo $mapping[$i]?>3").readOnly = true;
			document.getElementById("<?php echo $mapping[$i]?>4").readOnly = true;
			document.getElementById("<?php echo $mapping[$i]?>5").readOnly = true;
			document.getElementById("<?php echo $mapping[$i]?>Total").readOnly = true;			
			<?
		}
		?>
		document.getElementById('bu_prjYr1').readOnly = true;
		document.getElementById('bu_prjYr2').readOnly = true;
		document.getElementById('addSubCo').disabled = "disabled";
		document.getElementById('addCustomCa').disabled = "disabled";
		<?
	}
                                                                                                            */

                                                                                                            for ($i=0; $i<$budgetCount; $i++) {
                                                                                                                if ($budgetTypeID[$i] == "4") // Regular Categories
                                                                                                                {
                                                                                                                    ?>
			document.getElementById("<?php print($mapping[$budgetID[$i]]);?>1").value = "<?php ($budgetYr1[$i]=="")?print("0"):print($budgetYr1[$i]); ?>";
			document.getElementById("<?php print($mapping[$budgetID[$i]]);?>2").value = "<?php ($budgetYr2[$i]=="")?print("0"):print($budgetYr2[$i]); ?>";
			document.getElementById("<?php print($mapping[$budgetID[$i]]);?>3").value = "<?php ($budgetYr3[$i]=="")?print("0"):print($budgetYr3[$i]); ?>";
			document.getElementById("<?php print($mapping[$budgetID[$i]]);?>4").value = "<?php ($budgetYr4[$i]=="")?print("0"):print($budgetYr4[$i]); ?>";
			document.getElementById("<?php print($mapping[$budgetID[$i]]);?>5").value = "<?php ($budgetYr5[$i]=="")?print("0"):print($budgetYr5[$i]); ?>";
			total("<?php print($mapping[$budgetID[$i]]); ?>");
                                                                                                                    <?
                                                                                                                }
                                                                                                                else if ($budgetTypeID[$i] == "3") // Custom Categories
                                                                                                                {
                                                                                                                    // first of all add the custom categories row in the budget table, then worry about filling in the values
                                                                                                                    ?>
			var cYr = new Array(5) 
			cYr[0] = <?php print($budgetYr1[$i]);?>;
			cYr[1] = <?php print($budgetYr2[$i]);?>;
			cYr[2] = <?php print($budgetYr3[$i]);?>;
			cYr[3] = <?php print($budgetYr4[$i]);?>;
			cYr[4] = <?php print($budgetYr5[$i]);?>;
			var tbl = document.getElementById("budgetInnerTable");
			var newRow = tbl.insertRow(tbl.rows.length - 9);
			//newRow.id = id + "budget";
			var newCell = newRow.insertCell(0);
			newCell.innerHTML = ++customStartAt;

			var newCell = newRow.insertCell(1);
			newCell.align = "center";
			newCell.innerHTML = "<label><span style=\"visibility:hidden;\">label</span><input type=\"text\" <?php echo $disabled; ?> id=\"customName" + customStartAt + "\" name=\"customName" + customStartAt + "\" size=\"18\" value=\"<?php echo $budgetName[$i]; ?>\"></label>";

			var number = tbl.rows.length;

			for (year = 1; year <= 5; year++)
			{
				var newCell = newRow.insertCell(year+1);
				newCell.innerHTML = 
					"<label><span style=\"visibility:hidden;\">label</span><input <?php echo $disabled; ?> name=\"custom" + customStartAt + "" + year + "\" type=\"text\" id=\"custom" + 
					customStartAt + "" + year + "\" size=\"8\" tabindex=\"8\" " +
					"onKeyUp=\"total('custom" + customStartAt + "');tdc('" + year + "');\" onBlur=\"mtdc('" + 
					year + "');\" value=" + cYr[year-1] + " " + 
					"onKeypress=\"if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;\"></label>";
				//alert(newCell.innerHTML);
			}
			var newCell = newRow.insertCell(7);
			newCell.innerHTML = "<label><span style=\"visibility:hidden;\">label</span><input <?php echo $disabled; ?> name=\"custom" + customStartAt + "Total\" type=\"text\" " +
			"id=\"custom" +	customStartAt + "Total\" value=\"0\" size=\"10\" tabindex=\"-1\"></label>";

			var newCell = newRow.insertCell(8);
			newCell.innerHTML = "";
			total("custom" + customStartAt);
                                                                                                                    <?php
                                                                                                                }
                                                                                                                else if ($budgetTypeID[$i] == "2") // Sub contractors
                                                                                                                {
                                                                                                                    ?>
			var cYr = new Array(5) 
			cYr[0] = <?php print($budgetYr1[$i]);?>;
			cYr[1] = <?php print($budgetYr2[$i]);?>;
			cYr[2] = <?php print($budgetYr3[$i]);?>;
			cYr[3] = <?php print($budgetYr4[$i]);?>;
			cYr[4] = <?php print($budgetYr5[$i]);?>;
			/// Adding subcontractors from within the budget table
			tbl = document.getElementById("budgetInnerTable");
			var newRow = tbl.insertRow(7);
			//newRow.id = id + "budget";
			var newCell = newRow.insertCell(0);
			newCell.align = "right";
			newCell.innerHTML = "Name: ";

			var newCell = newRow.insertCell(1);
			newCell.align = "center";
			subConNo++;

			newCell.innerHTML = '<label><span style="visibility:hidden;">label</span><input type="text" <?php echo $disabled; ?> id="subCon' + subConNo + 'Name" name="subCon' + subConNo + 'Name" size="18" value="<?php echo $budgetName[$i]; ?>"></label>';

			for (year = 1; year <= 5; year++)
			{
				var newCell = newRow.insertCell(year+1);
				newCell.innerHTML = 
					"<label><span style=\"visibility:hidden;\">label</span><input <?php echo $disabled; ?> name=\"subCon" + subConNo + "" + year + "\" type=\"text\" id=\"subCon" + subConNo + "" + 
					year + "\" size=\"8\" value=" + cYr[year-1] + " tabindex=\"8\" onKeyUp=\"total('subCon" + subConNo + 
					"');tdc('" + year + "');\" onBlur=\"adjust('" + subConNo + "');mtdc('" + year + "');\" " +
					"onKeypress='if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;'></label>" +
					"<label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"amt" + subConNo + year + "\" id=\"amt" + subConNo + year + "\" value=\"0\"></label>";
				//alert(newCell.innerHTML);
			}
			var newCell = newRow.insertCell(7);
			newCell.innerHTML = "<label><span style=\"visibility:hidden;\">label</span><input <?php echo $disabled; ?>  name=\"subCon" + subConNo + "Total\" type=\"text\" id=\"subCon" +
				subConNo + "Total\" value=\"0\" size=\"10\" tabindex=\"-1\"></label>";

			var newCell = newRow.insertCell(8);
			newCell.innerHTML = "";
			total("subCon" + subConNo);
			adjust(subConNo);
                                                                                                                    <?php
                                                                                                                }
                                                                                                                //$budgetName[$budgetCount]
        //$budgetID[$budgetCount]
                                                                                                            }
                                                                                                            echo "</script>";
                                                                                                        }
?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            </td>
                                                                                            </tr>
                                                                                            </table>
                                                                                                        <?php
                                                                                                                                                                                               if (isset($eiCount)) {
                                                                                                                                                                                                   for($i=0; $i<$eiCount; $i++) {
                                                                                                                                                                                                       ?>
                                                                                            <script>
                                                                                                var tblName = "extIs";
                                                                                                var tbl = document.getElementById(tblName);
                                                                                                var newRow = tbl.insertRow(tbl.rows.length);
                                                                                                var newCell = newRow.insertCell(0);
                                                                                                newCell.innerHTML = "<?php print($ei_iname[$i]);?>";
                                                                                                var newCell = newRow.insertCell(1);
                                                                                                newCell.innerHTML = "<?php print($ei_name[$i]);?>";
                                                                                                var newCell = newRow.insertCell(2);
                                                                                                newCell.align = "center";
                                                                                                newCell.innerHTML = "<?php print($ei_email[$i]);?>";
                                                                                                var newCell = newRow.insertCell(3);
                                                                                                newCell.align = "center";
                                                                                                newCell.innerHTML = "<?php print($ei_box_number[$i]);?>";
                                                                                                var newCell = newRow.insertCell(4);
                                                                                                newCell.align = "center";
                                                                                                newCell.innerHTML = "<?php print($ei_phone[$i]);?>";
                                                                                                var newCell = newRow.insertCell(5);
                                                                                                newCell.align = "center";
                                                                                                newCell.innerHTML = "<?php print($ei_dept[$i]);?>";
                                                                                                var newCell = newRow.insertCell(6);
                                                                                                newCell.align = "center";
                                                                                                newCell.innerHTML = "<?php print($ei_rank[$i]);?>";
                                                                                                var newCell = newRow.insertCell(7);
                                                                                                newCell.align = "center";
                                                                                                newCell.innerHTML = "<?php print($ei_citizenship[$i]);?>";
                                                                                                var newCell = newRow.insertCell(8);
                                                                                                //newCell.class = "tdSmall";
                                                                                                newCell.innerHTML = "<?php print($ei_funding[$i]);?>";
                                                                                                var newCell = newRow.insertCell(9);
                                                                                                newRow.id = tblName + newRow.rowIndex;
                                                                                                var id = newRow.id;
                                                                                                if ("<?php print($ei_funding[$i]);?>" == "Subcontractor - Funded through UTA's Budget")
                                                                                                {
                                                                                                    jsAdd = "RemoveRow(\"budgetInnerTable\", \"" + id + "budget\")";
                                                                                                }
                                                                                                else
                                                                                                    jsAdd = "";
                                                                                                newCell.innerHTML = "<span onclick='RemoveRow(\"" + tblName + "\",\"" + id + "\");" + jsAdd
                                                                                                    + "'><img src=\"images/deleterow.gif\" alt=\"Remove\">" +
                                                                                                    "</span><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciFullName[]\" value=\"<?php echo $ei_name[$i]; ?>\"></label>" +
                                                                                                    "<label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciDept[]\" value=\"<?php echo $ei_dept[$i]; ?>\"></label><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" " +
                                                                                                    "name=\"ciBox#\" value=\"<?php echo $ei_box_number[$i]; ?>\"></label><label><span style=\"visibility:hidden;\">label</span><input " +
                                                                                                    "type=\"hidden\" name=\"ciEmail[]\" value=\"<?php echo $ei_email[$i]; ?>\"></label><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" " +
                                                                                                    "name=\"ciPhoneNumber[]\" value=\"<?php echo $ei_phone[$i]; ?>\"></label><label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"ciRank[]\"" +
                                                                                                    " value=\"<?php echo $ei_rank[$i]; ?>\"></label>";
                                                                                                //newRow.width = "100%";
                                                                                                tbl.style.display = '';


                                                                                                if ("<?php print($ei_funding[$i]);?>" == "Subcontractor - Funded through UTA's Budget")
                                                                                                {
                                                                                                    /// Adding subcontractors from the "External Investigators" Section.
                                                                                                    tbl = document.getElementById("budgetInnerTable");
                                                                                                    var newRow = tbl.insertRow(7);
                                                                                                    newRow.id = id + "budget";
                                                                                                    var newCell = newRow.insertCell(0);
                                                                                                    newCell.innerHTML = "";

                                                                                                    subConNo++;

                                                                                                    var newCell = newRow.insertCell(1);
                                                                                                    newCell.align = "center";
                                                                                                    newCell.innerHTML = '<label><span style="visibility:hidden;">label</span><input type="hidden" id="subCon' + subConNo + 'Name" name="subCon' + subConNo + 'ID" value="<?php echo $ei_iname[$i]; ?><?php echo $ei_name[$i]; ?>"></label>' + '<?php echo $ei_iname[$i]; ?>';
        <?php
        for ($j=0; $j<$budgetCount; $j++) {
            if ($budgetTypeID[$j] == "1") {
                if ($budgetName[$j] == $ei_iname[$i]) {
                                                                                                                ?>
                                                                                                                                    var cYr = new Array(5)
                                                                                                                                    cYr[0] = <?php print($budgetYr1[$j]);?>;
                                                                                                                                    cYr[1] = <?php print($budgetYr2[$j]);?>;
                                                                                                                                    cYr[2] = <?php print($budgetYr3[$j]);?>;
                                                                                                                                    cYr[3] = <?php print($budgetYr4[$j]);?>;
                                                                                                                                    cYr[4] = <?php print($budgetYr5[$j]);?>;
                    <?
                }
            }
        }
        ?>
                                                                                                            for (year = 1; year <= 5; year++)
                                                                                                            {
                                                                                                                var newCell = newRow.insertCell(year+1);
                                                                                                                newCell.innerHTML =
                                                                                                                    "<label><span style=\"visibility:hidden;\">label</span><input name=\"subCon" + subConNo + "" + year + "\" type=\"text\" id=\"subCon" + subConNo + "" +
                                                                                                                    year + "\" size=\"8\" value=" + cYr[year-1] + " tabindex=\"8\" onKeyUp=\"total('subCon" + subConNo +
                                                                                                                    "');tdc('" + year + "');\" onBlur=\"adjust('" + subConNo + "');mtdc('" + year + "');\" " +
                                                                                                                    "onKeypress=\"if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;\"></label>" +
                                                                                                                    "<label><span style=\"visibility:hidden;\">label</span><input type=\"hidden\" name=\"amt" + subConNo + year + "\" id=\"amt" + subConNo + year + "\" value=\"0\"></label>";
                                                                                                                //alert(newCell.innerHTML);
                                                                                                            }
                                                                                                            var newCell = newRow.insertCell(7);
                                                                                                            newCell.innerHTML = "<label><span style=\"visibility:hidden;\">label</span><input name=\"subCon" + subConNo + "Total\" type=\"text\" id=\"subCon" +
                                                                                                                subConNo + "Total\" value=\"0\" size=\"10\" tabindex=\"-1\"></label>";
                                                                                                            var newCell = newRow.insertCell(8);
                                                                                                            newCell.innerHTML = "";
                                                                                                            total("subCon" + subConNo);
                                                                                                            adjust(subConNo);
                                                                                                        }
                                                                                            </script>
        <?php
    }
}
?>
                                                                                            <br />
<?php
if ($edit == true) {
    ?>
                                                                                            <script>
                                                                                                tdc('1');tdc('2');tdc('3');tdc('4');tdc('5');
                                                                                                mtdc('1');mtdc('2');mtdc('3');mtdc('4');mtdc('5');
                                                                                            </script>
    <?php
}
?>
                                                                                            <!--  Special Considerations Section -->
                                                                                            <table width=80% style="border: 1px solid #0000CC;">
                                                                                                <tr>
                                                                                                    <td class="tdHeader" width="80%">
                                                                                                        <b>10. Special Considerations</b></td>
                                                                                                    <td align="right" class="tdSmall" width="10%">
                                                                                                        <span onClick="ToggleTable('scTableHelp', this)" style="cursor:pointer">Show Help</span>
                                                                                                    </td>
                                                                                                    <td align="right" class="tdSmall" width="10%">
                                                                                                        <span onClick="ToggleTable('scTable', this)" style="cursor:pointer">Collapse</span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="3" valign="top">
                                                                                                        <table width="100%" style="border-top: 1px dotted #0000CC; display:none;" id="scTableHelp">
                                                                                                            <tr><td class="tdSmall">
                                                                                                                    <a href="http://www.uta.edu/testrsp/RC/Forms/InternalForms/COI_DISCLOSURE_FORM.doc">Conflict of
		Interest (COI)</a> forms must be filled out by each PI and Co-I and filed with the Office 
		of Research Integrity & Compliance every fiscal year. COI forms must be submitted for 
		proposals or persons actively engaged in research. Any awards resulting from this proposal 
		will not be entered into the system until current COI forms are received.
                                                                                                                </td></tr>
                                                                                                        </table>
                                                                                                        <table width="100%" style="border-top: 1px dotted #0000CC" id="scTable">
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <ul>
                                                                                                                        <li>
	Have all investigators filed a Conflict of Interest Policy form for the current fiscal/academic year?</li>
                                                                                                                        <br />
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="scmgmtPlan" name="scmgmtPlan" type="radio" value="Yes" <?php if ($sc1=="Yes") echo "checked=\"checked\""; ?>/>Yes</label>
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="scmgmtPlan" name="scmgmtPlan" type="radio" value="No" <?php if ($sc1=="No") echo "checked=\"checked\""; ?>/>No</label>
                                                                                                                        <br /><br />
                                                                                                                        <li>Are matching funds or cost share included in the Proposal? If yes, attach a completed cost share form.</li><br />
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="sccostShare" name="sccostShare" type="radio" value="Yes" <?php if ($sc2=="Yes") echo "checked=\"checked\""; ?>/>Yes</label>
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="sccostShare" name="sccostShare" type="radio" value="No" <?php if ($sc2=="No") echo "checked=\"checked\""; ?>/>No</label>
                                                                                                                        <br /><br />
                                                                                                                        <li>Does the Sponsor require publishing restrictions, ownership of Intellectual Property of Copyrighted materials?</li><br />
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="scIPCmaterials" name="scIPCmaterials" type="radio" value="Yes" <?php if ($sc3=="Yes") echo "checked=\"checked\""; ?>/>Yes</label>
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="scIPCmaterials" name="scIPCmaterials" type="radio" value="No" <?php if ($sc3=="No") echo "checked=\"checked\""; ?>/>No</label>
                                                                                                                        <br /><br />
                                                                                                                        <li>Does this proposal involve one or more subcontracts or cooperative agreements, MOUs, or Teaming Agreements?</li><br />
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="sccoopAgreements" name="sccoopAgreements" type="radio" value="Yes" <?php if ($sc4=="Yes") echo "checked=\"checked\""; ?>/>Yes</label>
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="sccoopAgreements" name="sccoopAgreements" type="radio" value="No" <?php if ($sc4=="No") echo "checked=\"checked\""; ?>/>No</label>
                                                                                                                        <br /><br />
                                                                                                                        <li>Will this project involve collaborating with foreign colleagues or foreign institutions?</li><br />
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="sccollabf" name="sccollabf" type="radio" value="Yes" <?php if ($sc5=="Yes") echo "checked=\"checked\""; ?>/>Yes</label>
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="sccollabf" name="sccollabf" type="radio" value="No" <?php if ($sc5=="No") echo "checked=\"checked\""; ?>/>No</label>
                                                                                                                        <br /><br />
                                                                                                                        <li>Will this project involve shipping equipment to foreign countries or training persons in its use (regardless of location)?</li><br />
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="scshipf" name="scshipf" type="radio" value="Yes" <?php if ($sc6=="Yes") echo "checked=\"checked\""; ?>/>Yes</label>
                                                                                                                        <label><span style="visibility:hidden;">label</span><input id="scshipf" name="scshipf" type="radio" value="No" <?php if ($sc6=="No") echo "checked=\"checked\""; ?>/>No</label>
                                                                                                                    </ul>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <BR />

                                                                                            <!-- *********************************************************
                                                                                         * You may use this code for free on any web page provided that
                                                                                         * these comment lines and the following credit remain in the code.
                                                                                         * TopLeft Floating Div from http://www.javascript-fx.com
                                                                                         ********************************************************  -->
                                                                                            <!-- *** START - Here is the floating layer, make it as fancy as you like *** --->
                                                                                            <DIV id="divStayTopLeft" STYLE="position:absolute;left:10;top:200;width:200px;background-color:transparent; border: 1px solid blue;">
                                                                                                <center>
                                                                                                    <br />
                                                                                                    <div id="status_msg" style="font-size:12px;color:blue;font-weight:bold;"></div>
                                                                                                    <br />
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='GeneratePrintPreview()' style="border: 1px solid;background: #FFFFFF" value="Print Preview"/></label><br /><br />
<?php
if (isOGCSAdmin($connect1, $_SESSION['UID'])) {
                                                                                                if (isset($bs_status)) {
                                                                                                    if (($bs_status == "Submitted") && (!isset($_GET['createnew']))) {
                                                                                                        ?>
                                                                                                    <font size="1">Return comments:</font><br /><label><span style="visibility:hidden">label</span>
                                                                                                        <textarea rows="6" cols="15" id="return_to_pi_comments"></textarea></label>
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='submitted=true;Save(5)' style="border: 1px solid;background: #FFFFFF" value="Return to PI"/></label><br /><br />
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='submitted=true;Save(4)' style="border: 1px solid;background: #FFFFFF" value="Save & Route"/></label><br /><br />
            <?php
        }
        else if (($bs_status == "Saved") || (isset($_GET['createnew']))) {
            ?>
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='Delete()' style="border: 1px solid;background: #FFFFFF" value="Delete" id="btnDelete"/></label><br /><br />
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='submitted=true;Save(2)' style="border: 1px solid;background: #FFFFFF" value="Submit all forms"/></label><br /><br />
            <?php
        }
    }
    else {
        ?>
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='Delete()' style="border: 1px solid;background: #FFFFFF" value="Delete" id="btnDelete" disabled /></label><br /><br />
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='submitted=true;Save(2)' style="border: 1px solid;background: #FFFFFF" value="Submit all forms"/></label><br /><br />
                                                                                                                                <?php
                                                                                                                        }
                                                                                                                        ?>
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='Save(3)' style="border: 1px solid;background: #FFFFFF" value="  Save  "/></label><br /><br />
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='submitted=true;Save(3)' style="border: 1px solid;background: #FFFFFF" value="Save & Goto Activity Page"/></label><br /><br />
                                                                                                    <script>
                                                                                                        function AutoSave()
                                                                                                        {
                                                                                                            Save(3);
                                                                                                            autoSaveTimer = setTimeout("AutoSave()", 60 * 1000);
                                                                                                        }
                                                                                                    </script>
    <?php
}
else {
    $btnDelDis = "";
    if (($bs_id == "") || ($bs_id==0)) {
        $btnDelDis = "disabled";
    }
    ?>
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='Save(1)' style="border: 1px solid;background: #FFFFFF" value="Save" /></label><br /><br />
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='Delete()' style="border: 1px solid;background: #FFFFFF" value="Delete" id="btnDelete" <?php echo $btnDelDis; ?> /></label><br /><br />
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='submitted=true;Save(2)' style="border: 1px solid;background: #FFFFFF" value="Submit"/></label><br /><br />
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='submitted=true;Save(1)' style="border: 1px solid;background: #FFFFFF" value="Save & Return"/></label><br /><br />
                                                                                                    <script>
                                                                                                        function AutoSave()
                                                                                                        {
                                                                                                            Save(1);
                                                                                                            autoSaveTimer = setTimeout("AutoSave()", 60 * 1000);
                                                                                                        }
                                                                                                    </script>
    <?php
}
?>
                                                                                                    <label><span style="visibility:hidden;">label</span><input type="button" onclick='document.location="../researchspace.php?view=2"' style="border: 1px solid;background: #FFFFFF" value="Return"/></label><br /><br />
                                                                                                    <span style="font-size:9px">Bluesheet is autosaved every minute.</span>
                                                                                                </center>
                                                                                            </DIV>
                                                                                            <!-- *** END   - the floating layer, make is as fancy as you like *** --->


                                                                                            </div>

                                                                                            <div id="form_preview_page" style="display:none;" class="main_form">
                                                                                                <table border="0" width="680" style="border-bottom: 1px solid;">
                                                                                                    <tr>
                                                                                                        <td align="center">
                                                                                                            <font color="#FF0000" size="2">Don't use the back button to go back to form.</font><br />
                                                                                                            <label><span style="visibility:hidden;">label</span><input type="button" onclick='document.location="../researchspace.php?view=2"' style="border: 1px solid;background: #FFFFFF" value="Return to Bluesheet Action Page"/></label>
                                                                                                            &nbsp; &nbsp;
                                                                                                            <label><span style="visibility:hidden;">label</span><input type="button" onclick='GoBack()' style="border: 1px solid;background: #FFFFFF" value="Go back to form" /></label>
                                                                                                            &nbsp; &nbsp;
                                                                                                            <label><span style="visibility:hidden;">label</span><input type="button" onclick='PrintBS()' style="border: 1px solid;background: #FFFFFF" value="Print Blue Sheet" /></label>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                                <br />
                                                                                            </div>
                                                                                            <div id="form_preview" style="display:none" class="form_preview">
                                                                                            </div>

                                                                                            </form>

                                                                                            <div class="tdSmall" align="center">
		Best Viewed in Internet Explorer, Firefox on Microsoft Windows & Firefox, Netscape on Mac.
                                                                                                <br /><br />
		"You may be entitled to know what information UT Arlington collects concerning you. You may review and 
		have UT Arlington correct this information according to procedures set forth in UT System BPM #32. The 
		law is found in sections 552.021, 552.023 and 559.004 of the Texas Government Code. For more information, 
		see our <a href="http://www.uta.edu/uta/wwwteam/privacy.html">Privacy Policy</a>."
                                                                                            </div>

                                                                                            </body>
                                                                                            </html>