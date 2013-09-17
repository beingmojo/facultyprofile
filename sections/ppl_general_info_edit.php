<?php
print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_general_info_edit_box' class='hiddenbox'>");

if (mysql_num_rows($ppl_general_info_results) > 0) mysql_data_seek($ppl_general_info_results, 0);
$generalrows = mysql_fetch_array($ppl_general_info_results);

print( "<form id='ppl_general_info_edit_form' name='ppl_general_info_edit_form' action='sections/ppl_general_info_edit_box_submit.php' method='post' enctype='multipart/form-data'>");
print( "<input type='hidden' name='clicked' value='0' />");
print( "<input type='hidden' name='pid' value='$pid'  />");
print( "<input type='hidden' name='view' value='$view' />");
print( "<input type='hidden' name='ppl_general_info_image_id' value='" . $generalrows["image_id"] . "'  />");
print( "<input type='hidden' name='ppl_general_info_rank_changed' value='0' />");
print( "<input type='hidden' name='ppl_general_info_hid_list' value='" . $generalrows["hid"] . "' />");
print( "<input type='hidden' name='ppl_general_info_pri_rank_changed' value='0' />");
print( "<input type='hidden' name='ppl_general_info_pri_hid' value='" . $generalrows["pri_hid"] . "' />");

print( "<tr class='table_background' height='20' >");
print( "<td ><span class='form_elements_section_header'>&nbsp;Contact Information</span></td>");
print( "<td align='right' >");
if ($editable == true) {
    print( "<a href='#' style='text-decoration:none' onclick='return submit_box( \"ppl_general_info\", \"edit\" )'><img alt='save' border='0' src='images/buttons/save.gif' > <span class='form_elements_section_action'>Save &nbsp;</span></a>");
    print( "<a href='#' style='text-decoration:none' onclick='return cancel_edit_box( \"ppl_general_info\" )'><img alt='cancel' border='0' src='images/buttons/cancel.gif' > <span class='form_elements_section_action'>Cancel &nbsp;</span></a>");
}

print( "</td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2'>");
print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >");
print( "<tr>");
print( "<td colspan='7' class='table_background_other' height='1'></td> ");
print( "</tr>");

print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;NAME: </B></span></td>");
print( "<td colspan='4'>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Title</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_title' size='2' maxlength='8' value='" . htmlspecialchars($generalrows["title"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>Last Name</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_l_name' size='35' maxlength='255' value='" . htmlspecialchars($generalrows["l_name"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>First Name</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_f_name' size='35' maxlength='255' value='" . htmlspecialchars($generalrows["f_name"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>Middle Name</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_m_name' size='15' maxlength='255' value='" . htmlspecialchars($generalrows["m_name"], ENT_QUOTES) . "'></td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Rank</B></span></td>");
print( "<td colspan='4'>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Primary Rank</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_pri_designation' name='ppl_general_info_pri_designation' size='45' maxlength='255' value='" . htmlspecialchars($generalrows["pri_designation"], ENT_QUOTES) . "' readonly> ");
print( "&nbsp;<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='show_popup( \"ppl_general_info_pri_rank\",\"sections/ppl_general_info_rank_edit.php?&type=Primary&rank=" . rawurlencode($generalrows["pri_designation"]) . "&hid=" . rawurlencode($generalrows["pri_hid"]) . "\",450,650)'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_text'>Edit</span></a></td>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Other Ranks</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' id='ppl_general_info_designation' name='ppl_general_info_designation' size='45' maxlength='255' value='" . htmlspecialchars($generalrows["designation"], ENT_QUOTES) . "' readonly> ");
print( "&nbsp;<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='show_popup( \"ppl_general_info_rank\",\"sections/ppl_general_info_rank_edit.php?&type=Other&rank=" . rawurlencode($generalrows["designation"]) . "&hid=" . rawurlencode($generalrows["hid"]) . "\",450,650)'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_text'>Edit</span></a></td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Office</B></span></td>");
print( "<td colspan='4'>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Mailbox</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_mailbox' size='3' maxlength='8' value='" . htmlspecialchars($generalrows["mailbox"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>Location</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_office_location' size='65' maxlength='255' value='" . htmlspecialchars($generalrows["office_location"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>Room No.</B></span>");
print( "<input class='form_elements_edit' type='text' name='ppl_general_info_room_no' size='3' maxlength='16' value='" . htmlspecialchars($generalrows["room_no"], ENT_QUOTES) . "'>");
$checkboxvalue = ( $generalrows["status_mail_address"] == 0 ) ? "" : "checked";
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_status_mail_address' $checkboxvalue > <span class='form_elements_edit'> Hide </span></td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Address</B></span></td>");
print( "<td colspan='4'>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Street</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_address_1' size='30' maxlength='255' value='" . htmlspecialchars($generalrows["address_1"], ENT_QUOTES) . "'> ");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_address_2' size='30' maxlength='255' value='" . htmlspecialchars($generalrows["address_2"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>City</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_city' size='15' maxlength='32' value='" . htmlspecialchars($generalrows["city"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>State</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_state' size='2' maxlength='32' value='" . htmlspecialchars($generalrows["state"], ENT_QUOTES) . "'> ");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>Zip Code</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_zipcode' size='3' maxlength='16' value='" . htmlspecialchars($generalrows["zipcode"], ENT_QUOTES) . "'>");
$checkboxvalue = ( $generalrows["status_address"] == 0 ) ? "" : "checked";
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_status_address' $checkboxvalue> <span class='form_elements_edit'> Hide </span></td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Phone</B></span></td>");
print( "<td colspan='4'>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Main Phone</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_phone_no_1' size='15' maxlength='32' value='" . htmlspecialchars($generalrows["phone_no_1"], ENT_QUOTES) . "'>");
$checkboxvalue = ( $generalrows["status_phone_no_1"] == 0 ) ? "" : "checked";
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_status_phone_no_1' $checkboxvalue > <span class='form_elements_edit'> Hide </span><td>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Alternate Phone</B></span>&nbsp;");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_phone_no_2' size='15' maxlength='32' value='" . htmlspecialchars($generalrows["phone_no_2"], ENT_QUOTES) . "'>");
$checkboxvalue = ( $generalrows["status_phone_no_2"] == 0 ) ? "" : "checked";
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_status_phone_no_2' $checkboxvalue > <span class='form_elements_edit'> Hide </span><td>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Cell Phone</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_cell_no' size='15' maxlength='32' value='" . htmlspecialchars($generalrows["cell_no"], ENT_QUOTES) . "'>");
$checkboxvalue = ( $generalrows["status_cell_no"] == 0 ) ? "" : "checked";
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_status_cell_no' $checkboxvalue > <span class='form_elements_edit'> Hide </span><td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Email</B></span></td>");
print( "<td>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_email_id' size='45' maxlength='255' value='" . htmlspecialchars($generalrows["email_id"], ENT_QUOTES) . "'> ");
$checkboxvalue = ( $generalrows["status_email_id"] == 0 ) ? "" : "checked";
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_status_email_id' $checkboxvalue > <span class='form_elements_edit'> Hide </span><td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Fax</B></span></td>");
print( "<td>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_fax_no' size='15' maxlength='32' value='" . htmlspecialchars($generalrows["fax_no"], ENT_QUOTES) . "'>");
$checkboxvalue = ( $generalrows["status_fax_no"] == 0 ) ? "" : "checked";
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_status_fax_no' $checkboxvalue > <span class='form_elements_edit'> Hide </span><td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Website</B></span></td>");
print( "<td colspan='4'>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Name</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_name_1' size='15' maxlength='255' value='" . htmlspecialchars($generalrows["url_name_1"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>URL</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_1' size='20' maxlength='255' value='" . htmlspecialchars($generalrows["url_1"], ENT_QUOTES) . "'></td> ");
print( "<td width='1' class='table_background_other'></td>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Name</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_name_2' size='15' maxlength='255' value='" . htmlspecialchars($generalrows["url_name_2"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>URL</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_2' size='20' maxlength='255' value='" . htmlspecialchars($generalrows["url_2"], ENT_QUOTES) . "'></td> ");
print( "<td width='1' class='table_background_other'></td>");
print( "<td>&nbsp;<span class='form_elements_edit'><B>Name</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_name_3' size='15' maxlength='255' value='" . htmlspecialchars($generalrows["url_name_3"], ENT_QUOTES) . "'>");
print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_edit'><B>URL</B></span>");
print( "&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_url_3' size='20' maxlength='255' value='" . htmlspecialchars($generalrows["url_3"], ENT_QUOTES) . "'></td> ");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Image</B></span></td>");
print( "<td>");
print( "<input type='hidden' name='MAX_FILE_SIZE' value='1000000' />");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<input type='file' name='imagefile' size='40'  > ");
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_remove_image' > <span class='form_elements_edit'> Remove </span></td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Keywords</B></span></td>");
print( "<td>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_keywords' size='50' maxlength='255' value='" . htmlspecialchars($generalrows["keywords"], ENT_QUOTES) . "'></td> ");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
//Texas State Customizations - Start:///////////////////////////////////////////
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Curriculum Vitae</B></span></td>");
print( "<td>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<input type='file' name='curriculum_vitae' size='40'  > ");
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_remove_cv' > <span class='form_elements_edit'> Remove </span></td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Research Interests</B></span></td>");
print( "<td>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_research_interests' size='50' maxlength='255' value='" . htmlspecialchars($generalrows["research_interests"], ENT_QUOTES) . "'></td> ");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Publications</B></span></td>");
print( "<td>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<input type='file' name='curriculum_vitae' size='40'  > ");
print( "&nbsp;&nbsp;&nbsp;<input type='checkbox' name='ppl_general_info_remove_publ' > <span class='form_elements_edit'> Remove </span></td>");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Funding History</B></span></td>");
print( "<td>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_research_interests' size='50' maxlength='255' value='" . htmlspecialchars($generalrows["research_interests"], ENT_QUOTES) . "'></td> ");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
print( "<tr>");
print( "<td colspan='2' height='1'></td> <td colspan='5' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "<tr>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'></td>");
print( "<td>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td> ");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "<td class='table_background_other'><span class='form_elements_text' style='color:white; font-weight:bold; background-color:#580000'><B>&nbsp;Patents</B></span></td>");
print( "<td>");
print( "<table cellspacing='0' border='0' cellpadding='0' width='100%'>");
print( "<tr>");
print( "<td>&nbsp;<input class='form_elements_edit' type='text' name='ppl_general_info_patents' size='50' maxlength='255' value='" . htmlspecialchars($generalrows["patents"], ENT_QUOTES) . "'></td> ");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "<td width='1' class='table_background_other'></td>");
print( "</tr>");
//Texas State Customizations - End:///////////////////////////////////////////
print( "<tr>");
print( "<td colspan='7' class='table_background_other' height='1'></td> ");
print( "</tr>");
print( "</table>");
print( "</td>");
print( "</tr>");
print( "</form>");
print( "</table>");
?>

<script type='text/javascript'>
    function ChangeRank( rank, hid_list, type )
    {
        if( type == 'Other' )
        {
            hide_popup( "ppl_general_info_rank" );
            document.ppl_general_info_edit_form.ppl_general_info_designation.value=rank;
            document.ppl_general_info_edit_form.ppl_general_info_rank_changed.value='1';
            document.ppl_general_info_edit_form.ppl_general_info_hid_list.value=hid_list;
        }
        else
        {
            hide_popup( "ppl_general_info_pri_rank" );
            document.ppl_general_info_edit_form.ppl_general_info_pri_designation.value=rank;
            document.ppl_general_info_edit_form.ppl_general_info_pri_rank_changed.value='1';
            document.ppl_general_info_edit_form.ppl_general_info_pri_hid.value=hid_list;
        }
    }
    function CancelChangeRank( type )
    {
        if( type == 'Other' )
            hide_popup( "ppl_general_info_rank" );
        else
            hide_popup( "ppl_general_info_pri_rank" );
    }

</script>


<div id='ppl_general_info_rank_box' style='display:none;z-index:100' onSelectStart='return false'>
    <div id='ppl_general_info_rank_header' >
        <span id='ppl_general_info_rank_caption' >Edit Other Ranks</span>
        <span id='ppl_general_info_rank_close' >
            <img alt='close' src='images/buttons/close.gif' onClick='hide_popup("ppl_general_info_rank")'>
        </span>
    </div>
    <div id='ppl_general_info_rank_content' >
        <iframe id='ppl_general_info_rank_frame'></iframe>
    </div>
</div>

<div id='ppl_general_info_pri_rank_box' style='display:none;z-index:100' onSelectStart='return false'>
    <div id='ppl_general_info_pri_rank_header' >
        <span id='ppl_general_info_pri_rank_caption' >Edit Primary Rank</span>
        <span id='ppl_general_info_pri_rank_close' >
            <img alt='close' src='images/buttons/close.gif' onClick='hide_popup("ppl_general_info_pri_rank")'>
        </span>
    </div>
    <div id='ppl_general_info_pri_rank_content' >
        <iframe id='ppl_general_info_pri_rank_frame'></iframe>
    </div>
</div>
