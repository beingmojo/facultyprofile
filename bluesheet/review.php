<?php
include '../utils.php';
include 'includes/bs_ldaputils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
$connect1 = $db_conn;

function GetEmailText($bs_id) {
    global $connect1;
    $connect = $connect1;
    $query = "SELECT * FROM bs_info where bs_id='$bs_id'";
    $result_i = mysql_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
    if ($row = mysql_fetch_array($result_i)) {
        $proposal_title = $row["proposal_title"];
        $query = "SELECT * FROM bs_sponsor_info where bs_id='$bs_id' and sp_id=" . $row["sp_id"];
        $result_i1 = mysql_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
        if ($row1 = mysql_fetch_array($result_i1)) {
            $sponsor = $row1["sponsor"];
        }
    }
    $copis = "";
    $query = "SELECT * FROM bs_i_info WHERE bs_id = $bs_id";
    $result_i = mysql_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
    while($row = mysql_fetch_array($result_i)) {
        if ($row["i_id"] == "1")
            $pi = $row["name"];
        else {
            if ($copis == "")
                $copis = $row["name"];
            else
                $copis .=  ", " . $row["name"];
        }
    }

    $email_text = "A previously submitted bluesheet has been returned and you no longer need to approve it. \n You will receive another email when this bluesheet becomes available again for approval. \n ";
    if ($proposal_title != "")
        $email_text .= "Title: $proposal_title \n";
    $email_text .= 	"PI: $pi \n";
    if ($sponsor != "")
        $email_text .= 	"Sponsor: $sponsor \n";
    if($copis != "")
        $email_text .= 	"CoPIs: $copis \n";
    $email_text .= 	" " .
            "\n ------------------------------------------------------------------------------- \n" .
             "Looking for help? Check out blue sheet quick start guide: \n" .
            "Word Document: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.doc \n" .
            "PDF: http://{$_SERVER['HTTP_HOST']}{$_home}/help/bluesheet_quickstart_guide.pdf \n" .
            "Other Blue-sheet related questions contact your specialist (http://www.txstate.edu/research/osp.html). \n\n" .
            "If you are receiving multiple emails for the same bluesheet, please submit a preferred email address to sv1117@txstate.edu & we will add it for future routing.";
    return $email_text;
}

if (isset($_GET['s'])) {
    $sstatus = $_GET['s'];
    if (isset($_GET['id'])) {
        $guid = $_GET['id'];
        list($bs_id, $login_id) = split('[/.-]', $guid);
        if ( isOGCSSuperAdmin($login_id) ) {
            $query = "SELECT * FROM bs_routing where bs_id=$bs_id AND loginid='9999999999'";
            $result = mysql_query($query, $connect1);
            while($row = mysql_fetch_array($result)) {
                if ($row["status"] == "Pending") {
                    if ($sstatus=="Approved") {
                        if (isset($_GET['reason']))
                            $denyreason = $_GET['reason'];
                        else
                            $denyreason = "";
                        $query = "UPDATE bs_routing SET timestamp=NOW(), status='$sstatus', description='$denyreason' where bs_id=$bs_id AND loginid='9999999999'";
                    }
                    else {
                        if (isset($_GET['reason']))
                            $denyreason = $_GET['reason'];
                        else
                            $denyreason = "";
                        $query = "UPDATE bs_routing SET timestamp=NOW(), status='Denied', description='$denyreason' where bs_id=$bs_id AND loginid='9999999999'";
                    }
                    $result1 = mysql_query($query, $connect1);
                }
            }
        }

        $query = "SELECT * FROM bs_routing where bs_id=$bs_id AND loginid='$login_id'";
        $result = mysql_query($query, $connect1);
        while($row = mysql_fetch_array($result)) {
            if ($row["status"] == "Pending") {
                if ($sstatus=="Approved") {
                    if (isset($_GET['reason']))
                        $denyreason = $_GET['reason'];
                    else
                        $denyreason = "";
                    $query = "UPDATE bs_routing SET timestamp=NOW(), status='$sstatus', description='$denyreason' where bs_id=$bs_id AND loginid='$login_id'";
                }
                else {
                    if (isset($_GET['reason']))
                        $denyreason = $_GET['reason'];
                    else
                        $denyreason = "";
                    $query = "UPDATE bs_routing SET timestamp=NOW(), status='Denied', description='$denyreason' where bs_id=$bs_id AND loginid='$login_id'";
                }
                $result1 = mysql_query($query, $connect1);
            }
        }

        // check if there are any denials, if yes then cancel routing and return bluesheet back to user.
        $query = "SELECT * FROM bs_routing where bs_id=$bs_id AND status='Denied'";
        $result2 = mysql_query($query, $connect1);
        while($row2 = mysql_fetch_array($result2)) {
            // send an alert mail to all pending signatories that they no longer need to sign this bluesheet
            $query = "SELECT * FROM bs_routing where bs_id=$bs_id AND status='Pending'";
            $result3 = mysql_query($query, $connect1);
            while($row3 = mysql_fetch_array($result3)) {
                $dataset = real_get_pplc('utaID', $row3["loginid"], $_ldap_search_dn_ppl);
                $a_name = $dataset[0][22];
                $a_email = $dataset[0][30];
                $message = "Dear " . $a_name . ": \n\n" . GetEmailText($bs_id);
                mail( $a_email, "Bluesheet returned", $message, "From: OSP<sv1117@txstateG.edu>" );
            }

            $query = "delete from bs_routing where bs_id=$bs_id";
            $result_dummy = mysql_query($query, $connect1);
            $dataset = real_get_pplc('utaID', $row2["loginid"], $_ldap_search_dn_ppl);
            $ret_name = $dataset[0][22];
            $query = "update bs_info set ret_by='$ret_name', ret_comments='".$row2["description"]."', bs_status='Saved' where bs_id=$bs_id";
            $result_dummy = mysql_query($query, $connect1);
            // redirect to bs_manage page again.
            real_redirect("../researchspace.php", "view=2", $connect1);
            return;
        }

        //check if everyone is done with signing bluesheet and only last signatory is left
        $query = "select * from bs_routing where bs_id=$bs_id and status='Pending' and loginid!='9999999999'";
        $result2 = mysql_query($query, $connect1);
        $alldone = true;
        while($row2 = mysql_fetch_array($result2)) {
            $alldone = false;
        }
        if ($alldone == true) {
            //alert last signatories now!!
            $message = "Dear Sir/Madam: \n\n" .
                    "A Internal Routing Form (bluesheet) is pending review from you.\n" .
                    "Please login to research space portal at http://{$_SERVER['HTTP_HOST']}{$_home}/loginscreen.php?view=2 to approve/return this bluesheet.\n\n" .
                    "Thank you.\n-------------------------\nElectronic Research Administration";
            mail( "sv1117@txstate.edu", "Pending Bluesheet Final Review", $message, "From: OSP<sv1117@txstate.edu>" );

            $message = "Dear Sir/Madam: \n\n" .
                    "A Internal Routing Form (bluesheet) is pending review from you.\n" .
                    "Please login to research space portal at http://{$_SERVER['HTTP_HOST']}{$_home}/loginscreen.php?view=2 to approve/return this bluesheet.\n\n" .
                    "Thank you.\n-------------------------\nElectronic Research Administration";
            mail( "sv1117@txstate.edu", "Pending Bluesheet Final Review", $message, "From: OSP<sv1117@txstate.edu>" );

        }

        // check if everyone has reviewed the bluesheet for this user, if yes, then email the user with alert
        $query = "SELECT * FROM bs_routing WHERE bs_id=$bs_id";
        $result2 = mysql_query($query, $connect1);
        $complete = true;
        while($row2 = mysql_fetch_array($result2)) {
            if (($row2["status"]=="Approved") || ($row2["status"]=="Denied")) {
            }
            else {
                $complete = false;
            }
        }
        if ($complete == true) {
            $query = "SELECT email FROM bs_i_info WHERE bs_id=$bs_id AND i_id=1";
            $result3 = mysql_query($query, $connect1);
            if($row3 = mysql_fetch_array($result3)) {
                $message = "Dear Sir/Madam: \n\n " .
                        "Your Internal Routing Form (bluesheet) has been reviewed.\n" .
                        "Please login to research space portal at http://{$_SERVER['HTTP_HOST']}{$_home}/loginscreen.php?view=2 to check " .
                        "the status of your bluesheet.\n\n" .
                        "Thank you.\n-------------------------\nElectronic Research Administration";
                mail( $row3["email"], "Bluesheet Reviewed", $message, "From: OSP<sv1117@txstate.edu>\r\nCc: ys11@txstate.edu\r\n" );
            }
            $query = "UPDATE bs_info set bs_status='Completed' WHERE bs_id=$bs_id";
            $result2 = mysql_query($query, $connect1);
        }
        // redirect to bs_manage page again.
        real_redirect("../researchspace.php", "view=2", $connect1);
        return;
    }
    else
        return;
}

if (isset($_GET['id']) || isset($_GET['bs_id'])) {
    if (isset($_GET['bs_id'])) {
        $bs_id = $_GET['bs_id'];
    }
    else {
        $guid = $_GET['id'];
        list($bs_id, $login_id) = split('[/.-]', $guid);
        if ( isOGCSSuperAdmin($login_id) ) {
            $query = "SELECT * FROM bs_routing where bs_id = $bs_id AND (loginid='$login_id' or loginid='9999999999')";
        }
        else
            $query = "SELECT * FROM bs_routing where bs_id = $bs_id AND loginid='$login_id'";
        $result = mysql_query($query, $connect1);
        echo mysql_error($connect1);
        $pending = false;
        while($row = mysql_fetch_array($result)) {
            if ($row["status"] == "Pending")
                $pending = true;
        }
    }

    // get all the fields from database and populate into variables so that they can
    // be displayed in the form.
    $query = "SELECT * FROM bs_info where bs_id = " . $bs_id;
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
        $prj_period_from = $row["prj_period_from"];
        $prj_period_to = $row["prj_period_to"];
        $abstract = $row["abstract"];
        $prev_acct_number = $row["prev_acct_number"];
        $proposal_type = $row["proposal_type"];
        $proposal_title = $row["proposal_title"];
        $sp_id = $row["sp_id"];
        $pi_id = $row["pi_id"];
        $bs_name = $row["bs_name"];
        $bs_comments = $row["bs_comments"];
        $routed_by = $row["routed_by"];
        $bu_reqMTDC = $row["bu_reqMTDC"];
        $bu_lIDC = $row["bu_lIDC"];
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
        $copiCount++;
    }
    // get the sponsor information for this bluesheet
    $query = "SELECT * FROM bs_sponsor_info where bs_id=".$bs_id." AND sp_id=" . $sp_id;
    $result = mysql_query($query, $connect1);
    while($row = mysql_fetch_array($result)) {
        //print_r($row);
        $sp_deadline = $row["deadline"];
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
        $ei_dept[$eiCount] = $row["dept"];
        $ei_box_number[$eiCount] = $row["box_number"];
        $ei_phone[$eiCount] = $row["phone"];
        $ei_email[$eiCount] = $row["email"];
        $ei_rank[$eiCount] = $row["rank"];
        $ei_citizenship[$eiCount] = $row["citizenship"];
        $ei_funding[$eiCount] = $row["funding"];
        $eiCount++;
    }

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
        $budgetTotal[$budgetCount] = $row["bTotal"];
        $budgetName[$budgetCount] = $row["name"];
        $budgetTypeID[$budgetCount] = $row["type_id"];
        $budgetID[$budgetCount] = $row["id"];
        $budgetCount++;
    }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>Electronic Research Profile System - (Blue Sheet - View) - Texas State University - San Marcos</title>
        <link href="includes/wforms.css" rel="stylesheet" type="text/css" />
    </head>
    <body>

        <input type="button" value="Back to Main Page" onClick="../researchspace.php?view=2';">
        <!--input type="button" value="Print this Blue Sheet" onClick=""--><br><br>

        <table width="630" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><center>
                        PROPOSAL REVIEW AND CERTIFICATION FORM (Blue Sheet)<br>
	  GRANT &amp; CONTRACT SERVICES -  TEXAS STATE UNIVERSITY AT SAN MARCOS<br>
	  PHONE 512-245-2102 - WEB: <a href="http://www.txstate.edu/research/osp.html" target="_blank">http://www.txstate.edu/research/osp.html</a>	  </center>
                    <br>
                    <table width="99%"  style="border:1px solid #000000" bordercolor="#000000" cellspacing="0" cellpadding="5">
                        <tr>
                            <td colspan="3" valign="top" style="border-bottom: 1px dashed #000000">
                                <span class="sectionHeader1">1. Principal Investigator</span>
                                <table width="100%" border=0 id="piTable">
                                    <tr>
                                        <td width="18%">Full Name: </td>
                                        <td colspan="3"><?php print($pi_name);?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Department: </td>
                                        <td colspan="3"><?php print($pi_dept);?></td>
                                    </tr>
                                    <tr>
                                        <td>Email: </td>
                                        <td><?php print($pi_email);?></td>
                                        <td width="15%">Phone #: </td>
                                        <td width="23%"><?php print($pi_phone);?></td>
                                    </tr>
                                    <tr>
                                        <td>Rank: </td>
                                        <td><?php print($pi_rank);?></td>
                                        <td>Other:</td>
                                        <td><piRankopt></td>
                                        </tr>
                                        <tr>
                                            <td> Citizenship: </td>
                                            <td><?php print($pi_citizenship);?></td>
                                            <td>Box #:</td>
                                            <td><?php print($pi_box_number);?></td>
                                        </tr>
                                </table>
                            </td>
                            <td width="30%" align="left" valign="top" style="border-bottom: 1px dashed #000000;border-left: 1px dashed #000000">
                                <span class="sectionHeader1"><center>For OSP Use Only</center></span>
                                <table>
                                    <tr>
                                        <td>OSP#: _________________________</td>
                                    </tr>
                                    <tr><tD>Date Recieved:___________________</td></tr>
                                    <tr><tD>Date Submitted:__________________</td></tr>
                                    <tr><tD>CFDA#:_________________________</td></tr>
                                    <tr><td><input type="checkbox"> UBIT<input type="checkbox"> Foreign Funds</td></tr>
                                    <tr><td>RATS:__________________________	</td></tr>
                                    <tr><td>Routed By: <?php print($routed_by);?></td></tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" valign="top" style="border-bottom: 1px dashed #000000"><span class="sectionHeader1">2. Sponsor Information</span>
                                <table width="100%" border=0>
                                    <tr>
                                        <td width="20%">Deadline: </td>
                                        <td width="38%"><?php print($sp_deadline);?></td>
                                        <td width="20%">Submission Method: </td>
                                        <td><?php print($sp_submission_method);?></td>
                                    </tr>
                                    <tr>
                                        <td>Sponsor: </td>
                                        <td><?php print($sp_sponsor);?></td>
                                        <td><span id="si1">Shipment Method: </span> </td>
                                        <td valign="top" rowspan="3">
<?php print($sp_shipment_method);?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Link: </td>
                                        <td><?php print($sp_sponsor_link);?></td>
                                    </tr>
                                    <tr>
                                        <td>Prime Sponsor: </td>
                                        <td><?php print($sp_prime_sponsor);?></td>
                                    </tr>
                                    <tr>
                                        <td>Sponsor Contact:</td>
                                        <td><?php print($sp_contact_name);?></td>
                                        <td><span id="si3">Number of copies:</span> </td>
                                        <td><span id="si4"><?php print($sp_number_of_copies);?>
                                                <span class="tdSmall">(plus 1 for OSP)</span></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Address: </td>
                                        <td colspan="3"><?php print($sp_address);?></td>
                                    </tr>
                                    <tr>
                                        <td>Email Address: </td>
                                        <td><?php print($sp_email);?></td>
                                        <td>Phone Number: </td>
                                        <td><?php print($sp_phone);?></td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" valign="top" style="border-bottom: 1px dashed #000000"><span class="sectionHeader1">3. Proposal Information</span>
                                <table width="100%" border=0>
                                    <tr>
                                        <td width="10%">Title: </td>
                                        <td colspan="3"><?php print($proposal_title);?></td>
                                    </tr>
                                    <tr>
                                        <td>Type: </td>
                                        <td><?php print($proposal_type);?></td>
                                        <td width="25%">Previous Grant Account #:</td>
                                        <td width="22%"><?php print($prev_acct_number);?></td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" valign="top">
                                <span class="sectionHeader1">4. Co-Investigators</span>
                                <b>(Texas State personnel only &ndash; if you have any collaborators who are not Texas State employees,
				please enter their information in the External Collaborators &amp; Subcontractors section 
				below).</b> If PI &amp; Co-PIs are from different Colleges/Administrative 
				Units, Indirect Cost Recovery Percentages may be allocated between the departments/units 
				by using the <a href="http://www.txstate.edu/research/osp.html" target="_blank">Facilities
                                    & Administration Distribution Form</a> (not mandatory). This Form should be
				completed <b>during</b> the Proposal process, <em><b>prior to submission</b></em>.
                            </td>
                        </tr>
                        <!--tr>
                        <td colspan="4">
                        <table border="0"-->
<?
for($i=0; $i<$copiCount; ) {
    if (($i%3) == 0) {
        echo "<tr><td valign=\"top\" width=\"10%\" align=\"left\" class=\"tdSmall\">" .
                "Name:<br>Department:<br>Box:<br>Phone:<br>Email:<br>Rank:<br>Citizenship:<br></td>";
    }
    echo "<td valign=\"top\" align=\"left\" class=\"tdSmall\" width=\"30%\">$copi_name[$i]<br>" .
            "$copi_dept[$i]<br>" .
            "$copi_box_number[$i]<br>" .
            "$copi_phone[$i]<br>" .
            "$copi_email[$i]<br>" .
            "$copi_rank[$i]<br>" .
            "$copi_citizenship[$i]<br></td>";
    $i++;
    if (($i%3) == 0) {
        echo "</tr>";
    }
}
?>
                        <!--/table>
			</td>
			</tr-->
                        <tr>
                            <td colspan="4" align="left" valign="top" style="border-bottom: 1px dashed #000000;border-top: 1px dashed #000000">
                                <div id="b1"></div>
                                <span class="sectionHeader1">5. Project Abstract</span> (briefly summarize the
			  project in lay terms)<br>
                                <table border="0" width="100%"><tr><td><?php print($abstract);?></td></tr></table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" style="border-bottom: 1px dashed #000000">
                                <div id="b2"></div>
                                <span class="sectionHeader1">6. Compliance</span> Please review and attach the Compliance Checklist as necessary. Direct questions to 512-245-2102 Office of Research Compliance: Please choose Yes, No, or Pending.<br>
                                Human Subjects: <b>
<? 
                        if (($human_subjects!="Yes") && ($human_subjects!="No") && ($human_subjects!="Pending")) {
                            echo "Approved Protocol # " . $human_subjects;
                        }
                        else
                            echo $human_subjects;
                        ?></b><br>
				Vertebrate Animals: <b>
                        <?
                        if (($vertebrate_animals!="Yes") && ($vertebrate_animals!="No") && ($vertebrate_animals!="Pending")) {
                            echo "Approved Protocol # " . $vertebrate_animals;
                        }
                        else
                            echo $vertebrate_animals;
                        ?></b><br>

				Recombinant DNA: <b>
                        <?
                        if (($recombinant_dna!="Yes") && ($recombinant_dna!="No") && ($recombinant_dna!="Pending")) {
                            echo "Approved Protocol # " . $recombinant_dna;
                        }
                        else
                            echo $recombinant_dna;
?></b><br>
			    Biological Agents: <b>
                        <?
if (($biological_agents!="Yes") && ($biological_agents!="No") && ($biological_agents!="Pending")) {
    echo "Approved Protocol # " . $biological_agents;
}
else
                                    echo $biological_agents;
?></b><br>
				Select Agents: <b><?php print($select_agents);?> </b><br>
                                <a href="http://www.fss.txstate.edu/ehsrm/" target="_blank">Environmental Health &amp; Safety</a> - EH &amp; S can be reached at (512) 245-3616 <br>
                                Radioactive Materials: <b>
<?
if (($radioactive_materials!="Yes") && ($radioactive_materials!="No") && ($radioactive_materials!="Pending")) {
    echo "Approved Date - " . $radioactive_materials;
}
                                    else
                                        echo $radioactive_materials;

                                    ?></b><br>
                                Controlled Substances: <b>
                                    <?
                                    if (($controlled_substances!="Yes") && ($controlled_substances!="No") && ($controlled_substances!="Pending")) {
                                        echo "DEA License # " . $controlled_substances;
                                }
                                    else
                                        echo $controlled_substances;
                                    ?></b><br>
				  Laser Devices: <b><?php print($laser_devices);?></b><br>
                                Radiation Producing Machines: <b><?php print($radiation_producing_machines);?></b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left"><span class="sectionHeader1">7. External Collaborators and Subcontractors</span>
			  This section is for <b>non-Texas State</b> external personnel that will be  listed on the proposal. Please list only
			  the <b>lead investigator</b> for each separate institution.&nbsp; For method of  funding, please select the option
			  that applies to this proposal.</td>
                        </tr>
                                    <?
                                    for($i=0; $i<$eiCount; ) {
                                        if (($i%3) == 0) {
                                            echo "<tr><td width=\"10%\" valign=\"top\" align=\"left\" class=\"tdSmall\">Name:<br>Department:<br>Box:<br>Phone:<br>Email:<br>Rank:<br>Citizenship:<br>Funding:<br></td>";
                                        }
                                    echo "<td valign=\"top\" align=\"left\" class=\"tdSmall\" width=\"30%\">$ei_name[$i]<br>" .
                                                "$ei_dept[$i]<br>" .
                                                "$ei_box_number[$i]<br>" .
                                                "$ei_phone[$i]<br>" .
                                                "$ei_email[$i]<br>" .
                                                "$ei_rank[$i]<br>" .
                                                "$ei_citizenship[$i]<br>" .
                                                "$ei_funding[$i]</td>";
                                        $i++;
                                    if (($i%3) == 0) {
        echo "</tr>";
    }
                                    }
                                    ?>
                        <tr>
                            <td colspan="4" align="left" style="border-bottom: 1px dashed #000000;border-top: 1px dashed #000000">
                                <span class="sectionHeader1">8. Facilities &amp; Administrative Cost (Indirect Cost) Calculations</span><br>
                                Standard University Rate allowed by the Sponsor. <br>
                                <br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;F&amp;A Percentage Rate: <?php print($fna);?>%</td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left">
                                <div id="b3"></div>
                                <span class="sectionHeader1">9. Budget</span><br>
                                <center>Total Project Period: <?php print($prj_period_from);?> to <?php print($prj_period_to);?></center>
                                <table width="100%"  border="1" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="18%" scope="col"><div align="left" >Direct Costs </div></td>
                                        <td width="12%" scope="col"><div align="center">Year 1 </div></td>
                                        <td width="14%" scope="col"><div align="center">Year 2 </div></td>
                                        <td width="14%" scope="col"><div align="center">Year 3 </div></td>
                                        <td width="14%" scope="col"><div align="center">Year 4 </div></td>
                                        <td width="14%" scope="col"><div align="center">Year 5 </div></td>
                                        <td width="14%" scope="col"><div align="center">Project Total </div></td>
                                    </tr>
                                <?
                                for($i=0; $i<$budgetCount; $i++) {
                                    if (($budgetName[$i] == "tdc") ||
            ($budgetName[$i] == "mtdc")||
                                    ($budgetName[$i] == "idc") ||
                                    ($budgetName[$i] == "tc")) {
                            }
                            else {
                                echo "<tr>";
                                echo "  <td scope=\"row\"><div align=\"left\" > $budgetName[$i] </div></td>";
                                echo "  <td align=\"center\">$budgetYr1[$i]</td>";
                                echo "  <td align=\"center\">$budgetYr2[$i]</td>";
                                echo "  <td align=\"center\">$budgetYr3[$i]</td>";
                                echo "  <td align=\"center\">$budgetYr4[$i]</td>";
                                echo "  <td align=\"center\">$budgetYr5[$i]</td>";
                                echo "  <td align=\"center\">$budgetTotal[$i]</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                                    <tr>
                                        <td scope="row"><div align="left" >Total Direct Cost </div></td>
                        <?
                        for($i=0; $i<$budgetCount; $i++) {
                            if ($budgetName[$i] == "tdc") {
                                echo "  <td align=\"center\">$budgetYr1[$i]</td>";
        echo "  <td align=\"center\">$budgetYr2[$i]</td>";
        echo "  <td align=\"center\">$budgetYr3[$i]</td>";
        echo "  <td align=\"center\">$budgetYr4[$i]</td>";
        echo "  <td align=\"center\">$budgetYr5[$i]</td>";
        echo "  <td align=\"center\">$budgetTotal[$i]</td>";
    }
}
?>
                                    </tr>
                                    <tr>
                                        <td scope="row"><div align="left" >Modified TDC </div></td>
<?
for($i=0; $i<$budgetCount; $i++) {
    if ($budgetName[$i] == "mtdc") {
        echo "  <td align=\"center\">$budgetYr1[$i]</td>";
        echo "  <td align=\"center\">$budgetYr2[$i]</td>";
        echo "  <td align=\"center\">$budgetYr3[$i]</td>";
        echo "  <td align=\"center\">$budgetYr4[$i]</td>";
        echo "  <td align=\"center\">$budgetYr5[$i]</td>";
        echo "  <td align=\"center\">$budgetTotal[$i]</td>";
    }
}
                                    ?>
                                    </tr>
                                    <tr>
                                        <td scope="row"><div align="left" >90 Total Facilities &amp; Administration (IDC) </div></td>
                                    <?
                                    for($i=0; $i<$budgetCount; $i++) {
                                        if ($budgetName[$i] == "idc") {
                                            echo "  <td align=\"center\">$budgetYr1[$i]</td>";
                                            echo "  <td align=\"center\">$budgetYr2[$i]</td>";
                                            echo "  <td align=\"center\">$budgetYr3[$i]</td>";
                                            echo "  <td align=\"center\">$budgetYr4[$i]</td>";
                                            echo "  <td align=\"center\">$budgetYr5[$i]</td>";
                                            echo "  <td align=\"center\">$budgetTotal[$i]</td>";
                                        }
                                    }
                                    ?>
                                    </tr>
                                    <tr>
                                        <td scope="row"><div align="left" >91 Total Costs (TC) </div></td>
                                    <?
                                    for($i=0; $i<$budgetCount; $i++) {
                                        if ($budgetName[$i] == "tc") {
                                            echo "  <td align=\"center\">$budgetYr1[$i]</td>";
        echo "  <td align=\"center\">$budgetYr2[$i]</td>";
        echo "  <td align=\"center\">$budgetYr3[$i]</td>";
                                                echo "  <td align=\"center\">$budgetYr4[$i]</td>";
                                                echo "  <td align=\"center\">$budgetYr5[$i]</td>";
                                                echo "  <td align=\"center\">$budgetTotal[$i]</td>";
                                            }
                                        }
                                        ?>                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left"><a href="/bluesheet/Instructions.doc" target="_blank" style="cursor:help"><b>Unrecovered Facilities &amp; Administration (IDC)</b></a> (reserved for OSP use) <br>
                                <br>
                                Requested MTDC &nbsp; X &nbsp; Standard Univesity Rate = <?php print($bu_reqMTDC);?><br>
                                Less Sponsor IDC (= ) = Unrecovered IDC = <?php print($bu_lIDC);?></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" style="border-bottom: 1px dashed #000000;border-top: 1px dashed #000000;"><span class="sectionHeader1">
                                    10. Special Considerations</span><br>
				Have all investigators filed a Conflict of Interest Policy form for the current fiscal/academic year? <b><?php print($sc1);?></b><br>
				Are matching funds or cost share included in the Proposal? If yes, attach a completed cost share form. <b><?php print($sc2);?></b><br>
				Does the Sponsor require publishing restrictions, ownership of Intellectual Property of Copyrighted materials? <b><?php print($sc3);?></b><br>
				Does this proposal involve one or more subcontracts or cooperative agreements, MOUs, or Teaming Agreements? <b><?php print($sc4);?></b><br>
				Will this project involve collaborating with foreign colleagues or foreign institutions? <b><?php print($sc5);?></b><br>
				Will this project involve shipping equipment to foreign countries or training persons in its use (regardless of location)? <b><?php print($sc6);?></b><br>
                            </td>
                        </tr>

                        <!--p style="page-break-before: always"></p-->

                        <tr>
                            <td colspan="4" align="left"><span class="sectionHeader1">Investigator's Certification:</span><br>
                                My signature on the Proposal Review and Certification Form  (Blue Sheet) certifies that all of the following are correct and true:
                                <ol type="a">
                                    <li>I  understand that, due to evolving laws and regulations, these certifications may  change from time to time and I am responsible for reviewing them at the time of  proposal submission and at the time of grant award.</li>
                                    <li>I  am not:
                                        <ul>
                                            <li>Delinquent on any federal debt such as taxes,  student loans, etc.;</li>
                                            <li>Debarred , suspended, proposed for debarment,  declared ineligible or voluntarily excluded from any current transactions by a  federal department or agency;</li>
                                        </ul>
                                    </li>
                                    <li>I  will be responsible for technical conduct of the work, for submission of  technical reports, and for compliance with award terms and conditions.</li>
                                    <li>No  Federal appropriated funds have, or will, be paid to influence, or attempt to  influence, the granting of this proposal.</li>

                                    <li>I  have reviewed and understood the <a href="https://facultyprofile.txstate.edu/bluesheet/Compliance_Checklist.doc">Compliance  Checklist</a>.</li>
                                    <li>I have reviewed and understood the <a href="http://www.txstate.edu/research/orc/export-control.html">Export Control  Regulations</a>.</li>
                                    <li>I  understand the following terms and conditions shall apply should an award  result from this proposal:
                                        <ul>
                                            <li> I am responsible for managing the grant or  contract funds.&nbsp; I understand that it is  my responsibility to not overspend my grant/contract budget.</li>
                                            <li> I will comply with all University regulations as  well as with the funding agency&rsquo;s terms and conditions.</li>
                                            <li>I understand that I am responsible for  certifying time-and-effort salary reports.</li>
                                            <li>I understand I am responsible for managing my  effort in accordance to commitments made in proposals and fluctuations of other  activities related to my total effort (e.g. other sponsored projects, teaching  duties, administrative functions etc.)</li>
                                            <li>I understand that I am responsible for  overseeing any subcontracts or subawards that may result from this award.</li>
                                            <li>I understand that I am responsible for complying  with United States Export Control laws with respect to foreign/non-U. S.  citizen employees I supervise, access to controlled equipment or data that I or  my employees may produce or be given access to.</li>
                                        </ul>
                                    </li>
                                </ol></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" style="border-top: 1px dashed #000000;"><span class="sectionHeader1">Department Chairperson's and Dean's Assurance</span><br>
                                <b>My signature below certifies that all the following are correct:<br>
                                </b>I have reviewed this Proposal Review/Certification form and the attached proposal and the
				  effort proposed is in keeping with College/Department/Unit educational Objectives and is beneficial 
				  to the University. I am aware of all the requirements for this project and am committed to providing 
				  them, except as noted. I have reviewed the proposal for compliance with 
                                <a href="http://www.txstate.edu/research/orc/export-control.html">Export Control Regulations</a> and
                                <a href="http://www.txstate.edu/research/orc.html">Research Compliance Policies</a>
                            </td>
                        </tr>
<?
function GetAuthority($dept, $authority_type, $c) {
    global $_ldap_search_dn_ppl;
    $query = "SELECT hid FROM gen_hierarchy_types WHERE name='$dept'";
    $result_i1 = mysql_query($query, $c) or die("01 - " . mysql_error() . "==" . $query);
    if ($row1 = mysql_fetch_array($result_i1)) {
        $hid = $row1["hid"];
        // get the dean
        $query = "SELECT * FROM gen_dept_hierarchy WHERE hid=$hid AND authority_type=" . $authority_type;
                                        $result_i2 = mysql_query($query, $c) or die("01 - " . mysql_error() . "==" . $query);
                                        if ($row2 = mysql_fetch_array($result_i2)) {
                                            $dean_login_id = $row2["login_id"];
                                            // get information of authority from ldap based on their login id.
                                            $dataset = real_get_pplc('utaID', $dean_login_id, $_ldap_search_dn_ppl);
                                            //echo "<pre>"; print_r($dataset); echo "</pre>";
            return $dataset;
        }
    }
}

function ApprovalStatus($loginid, $bsid) {
    global $connect1;
    $query = "SELECT *,DATE_FORMAT(timestamp,'%m/%d/%Y %r') as ts FROM bs_routing WHERE bs_id='$bsid' AND loginid='$loginid'";
    $result_i1 = mysql_query($query, $connect1) or die("01 - " . mysql_error() . "==" . $query);
    if ($row1 = mysql_fetch_array($result_i1)) {
        $ts = $row1["ts"];
        if ($ts == "00/00/0000 12:00:00 AM")
            $ts = "";
        if ($row1["status"] == "Approved")
            return "<b>Approved</b> (" . $ts . ")";
        else if ($row1["status"] == "Denied")
            return "<b>Returned</b> (" . $ts . ")";
    }
    else
        return "";
}

$copissig = '';
if (isset($bs_id)) {
    $query = "SELECT * FROM bs_i_info WHERE bs_id = $bs_id";
    $result_i = mysql_query($query, $connect1) or die("01 - " . mysql_error() . "==" . $query);
    while($row = mysql_fetch_array($result_i)) {
        if ($row["i_id"] == "1") {
            $desig = "PI: ";
            $query = "select A.login_id from ppl_general_info A, bs_info B where A.pid=B.pid and B.bs_id=$bs_id and B.started_by!=A.login_id";
            $result_i1 = mysql_query($query, $connect1) or die("03 - " . mysql_error() . " -- " . $query);
            if($row2 = mysql_fetch_array($result_i1)) {
                $i_approval = ApprovalStatus($row2['login_id'], $bs_id);
            }
            else
                $i_approval = 'Approved';
        }
                                        else {
                                            $desig = "Co-PI: ";
                                            $i_approval = ApprovalStatus($row['loginid'], $bs_id);
        }
        $ds = GetAuthority($row["dept"], 2, $connect1);
        $chair = $ds[0][22];
        $chair_approval = ApprovalStatus($ds[0][3], $bs_id);
                                $ds = GetAuthority($row["dept"], 1, $connect1);
                                $dean = $ds[0][22];
                                $dean_approval = ApprovalStatus($ds[0][3], $bs_id);
                                $copissig .= '<tr><td colspan="4"><br><br><br></td></tr>' .
                                        '<tr>' .
                                        '	<td width="30%" colspan="2"><b>' . $i_approval . ' </b><br>' .
                                        '		<table style="border-top: 1px solid #000000;" width="100%">' .
                                        '			<tr><td align="left" width="100%">' . $desig . $row["name"] . '</td></tr>' .
                                        '		</table>' .
                                        '	</td>' .
                                        '	<!--td width="5%"></td-->' .
                                        '	<td width="30%">' . $chair_approval . '<br>' .
                                        '		<table style="border-top: 1px solid #000000;" width="100%">' .
                                        '			<tr><td align="left" width="100%">Chair: ' . $chair . '</td></tr>' .
                                        '		</table>' .
                                        '	</td>' .
                                        '	<!--td width="5%"></td-->' .
                                        '	<td width="30%">' . $dean_approval . '<br>' .
                                        '		<table style="border-top: 1px solid #000000;" width="100%">' .
                                        '			<tr><td align="left" width="100%">Dean: ' . $dean . '</td></tr>' .
                                        '		</table>' .
                                        '	</td>' .
                                        '</tr>';
                            }
                            $vp = ApprovalStatus("9999999999", $bs_id) . "<br>";
                            $ehs = ApprovalStatus("000000000", $bs_id) . "<br>";
                            $query = "SELECT routed_by, DATE_FORMAT(routed_time,'%m/%d/%Y %r') as rt FROM bs_info WHERE bs_id = $bs_id";
                            $result_i = mysql_query($query, $connect1) or die("01 - " . mysql_error() . "==" . $query);
                            $gcs = "";
                            while($row = mysql_fetch_array($result_i)) {
                                $rt = $row["rt"];
                                if ($rt == "00/00/0000 12:00:00 AM")
                                    $rt = "";
                                $gcs = "<center><b>" . $row["routed_by"] . "</b> (" . $rt . ")</center>";
                            }
                        }
                        echo $copissig;
                        ?>
                        <tr>
                            <td colspan="4">
                                <br><br><br>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3">
                        <?
                        echo $vp;
                        ?>
                                <table style="border-top: 1px solid #000000;" width="100%"><tr>
                                        <td align="left" width="90%">VP for Research / Director, Grant &amp; Contract Services</td>
                                        <td width="10%" align="right">Date</td>
                                    </tr></table>
                            </td>
                            <!--td width="5%"></td-->
                            <td>
                        <?
                        echo $gcs;
                        ?>
                                <table style="border-top: 1px solid #000000;" width="100%"><tr>
                                        <td align="center" width="100%">OSP Initials</td>
                                    </tr></table>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <br><br><br>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
                        <?
                        echo $ehs;
                        ?>
                                <table style="border-top: 1px solid #000000;" width="100%">
                                    <tr>
                                        <td align="left" width="90%">Environment Health & Safety</td>
                                        <td width="10%" align="right">Date</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?
                        if (isset($_GET['id'])) {
                            if ($pending == true) {
                                ?>
                        <tr>
                            <td colspan="4"  style="border-bottom: 1px dashed #000000">&nbsp;</td>
                        </tr>
                        <tr>
                        <script>
                            function Deny()
                            {
                                if (document.getElementById("denyreason").value != "")
                                    document.location=document.location+'&s=Denied&reason=' + document.getElementById("denyreason").value;
                                else
                                    alert("You must enter a comment to return this blue sheet to PI.");
                            }
                        </script>
                        <td colspan="4" valign="top">
						Comments: <br /><center><textarea id="denyreason" name="" rows=6 cols=60></textarea></center>
                        </td>
            </tr>
            <tr>
                <td  colspan="4" valign="top" align="center">
			By approving, you are electronically signing the document and agreeing to the certificates and assurances made above.
                    <br><br>
                    <input type="button" value="Approve" onClick="document.location=document.location+'&s=Approved&reason='+document.getElementById('denyreason').value">
                    <input type="button" value="Return to PI" onClick="Deny();">
                </td>
            </tr>
        <?
    }
}
                                ?>
        </table>
    </td>
</tr>
</table>		
<br><br>
<input type="button" value="Back to Main Page" onClick="document.location='../researchspace.php?view=2';">
<!--input type="button" value="Print this Blue Sheet" onClick=""-->
</body>
</html>