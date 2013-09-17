<?php
if (mysql_num_rows($ppl_general_info_results) > 0) {
    mysql_data_seek($ppl_general_info_results, 0);
}
$generalrows = mysql_fetch_array($ppl_general_info_results);
$association_no_rows = mysql_num_rows($gen_association_results);
print("<table width='100%'  border='0' cellspacing='0' cellpadding='0' id='ppl_general_info_view_box' class='visiblebox'>");
print( "<tr>");
if ($generalrows["image_id"] != 0) {
    print( "<td align='center' valign='middle' width='128' style='border:1px solid black'>");
    print( "<a href='images/0/" . $pid . "_0_" . $generalrows["image_id"] . ".jpg' target='_blank'><img src='images/128/" . "$pid" . "_0_" . $generalrows["image_id"] . ".jpg" . "' border='0' alt='" . htmlspecialchars($generalrows["title"], ENT_QUOTES) . " " . htmlspecialchars($generalrows["f_name"], ENT_QUOTES) . " " . htmlspecialchars($generalrows["m_name"], ENT_QUOTES) . " " . htmlspecialchars($generalrows["l_name"], ENT_QUOTES) . "' ></a>");
    print( "</td>");
    print( "<td width='5'></td>");
}
print( "<td align='left' valign='top'>");
print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >");
print( "<tr class='table_background'>");
print( "<td><span class='form_elements_section_header'>&nbsp;Contact Information</span></td>");
print( "<td align='right' height='20' width='15%'>");
if ($editable == true) {

    print( "<a href='{$_home}/help/index.php#facul_contactinfo' target='_blank' style='text-decoration:none' ><img alt='help' border='0' src='images/bullets/help.gif'  > <span class='form_elements_section_action'>Help&nbsp;&nbsp;</span></a>");

    print( "<a href='{$_home}/f_info.php' style='text-decoration:none'><img alt='edit' border='0' src='images/buttons/edit.gif'  > <span class='form_elements_section_action'>Edit &nbsp;</span></a>");
}
print( "</td>");
print( "</tr>");
print( "<tr>");
print( "<td id='name' align='left' >");
if ($generalrows["title"] != "") {
    echo htmlspecialchars($generalrows["title"]) . ". ";
}
echo htmlspecialchars($generalrows["f_name"]) . " " . htmlspecialchars($generalrows["m_name"]) . " " . htmlspecialchars($generalrows["l_name"]);
print( "</td>");
print( "<td align='right'>");
if ($association_no_rows > 0) print( "<a href='#' style='text-decoration:none' onclick='show_popup( \"gen_association\",\"sections/gen_association_display.php?&pid=" . $pid . "\",400,635)'><img alt='view' border='0' src='images/buttons/view.png'  > <span class='form_elements_text'>Associated Profiles&nbsp;</span></a>");
print( "</td");
print( "</tr>");
print( "<tr>");
print( "<td align='left' colspan='2'>");
print( "<span class='form_elements_text'>");
print( htmlspecialchars($generalrows["pri_designation"]));
if ($generalrows["designation"] != "" && $generalrows["pri_designation"] != "") print( ", ");
print( htmlspecialchars($generalrows["designation"]));
print( "</span>");
print( "</td>");
print( "</tr>");
print( "<tr >");
print( "<td colspan='2'> &nbsp;");
print( "</td>");
print( "</tr>");
print( "<tr >");
print( "<td colspan='2'>");
if ($generalrows["status_address"] == 0) print( "<span class='form_elements_text'>");
else print( "<span class='form_elements_text_disabled'>");
if ($editable == true || $generalrows["status_address"] == 0) {
    $address = "";

    if ($generalrows["address_1"] != "") {
        if ($address != "") $address .= ", ";
        $address .= htmlspecialchars($generalrows["address_1"]);
    }
    if ($generalrows["address_2"] != "") {
        if ($address != "") $address .= ", ";
        $address .= htmlspecialchars($generalrows["address_2"]);
    }
    if ($generalrows["city"] != "") {
        if ($address != "") $address .= ", ";
        $address .= htmlspecialchars($generalrows["city"]);
    }
    if ($generalrows["state"] != "") {
        if ($address != "") $address .= ", ";
        $address .= htmlspecialchars($generalrows["state"]);
    }
    if ($generalrows["zipcode"] != "") {
        if ($address != "") $address .= " ";
        $address .= htmlspecialchars($generalrows["zipcode"]);
    }
    if ($address != "") print( "<img src='images/icons/address.png' width='12' height='12' border='0' alt='Contact address' /> &nbsp; $address &nbsp;&nbsp;&nbsp;&nbsp;");
}
print( "</span>");
if ($generalrows["status_mail_address"] == 0) print( "<span class='form_elements_text'>");
else print( "<span class='form_elements_text_disabled'>");



if ($editable == true || $generalrows["status_mail_address"] == 0) {
    $address = "";
    if ($generalrows["mailbox"] != "") {
        if ($address != "") $address .= ", ";
        $address .= "Mail Box: " . htmlspecialchars($generalrows["mailbox"]);
    }
    if ($generalrows["office_location"] != "") {
        if ($address != "") $address .= ", ";
        $address .= htmlspecialchars($generalrows["office_location"]);
    }
    if ($generalrows["room_no"] != "") {
        if ($address != "") $address .= ", ";
        $address .= "Room No.: " . htmlspecialchars($generalrows["room_no"]);
    }

    if ($address != "") {
        print( "<img src='images/icons/office.png' width='12' height='12' border='0' alt='Office Location' />$address&nbsp;");
    }
}
print( "</span>");
print( "</td>");
print( "</tr>");

print( "<tr >");
print( "<td colspan='2'>");
if ($generalrows["status_email_id"] == 0) print( "<span class='form_elements_text'>");
else print( "<span class='form_elements_text_disabled'>");
if ($editable == true || $generalrows["status_email_id"] == 0) {
    if ($generalrows["email_id"] != "") echo "<img src='images/icons/mail.png' width='12' height='12' border='0' alt='Email' />" .
        "&nbsp;&nbsp;<a href='mailto:" . htmlspecialchars($generalrows["email_id"], ENT_QUOTES) . "'>" . htmlspecialchars($generalrows["email_id"]) . "</a> &nbsp;&nbsp; ";
}
print( "</span>");

if ($generalrows["status_phone_no_1"] == 0) print( "<span class='form_elements_text'>");
else print( "<span class='form_elements_text_disabled'>");
if ($editable == true || $generalrows["status_phone_no_1"] == 0) {
    if ($generalrows["phone_no_1"] != "") echo "<img src='images/icons/phone_office.gif' width='12' height='12' border='0' alt='Contact Number' />" .
        "&nbsp;" . htmlspecialchars($generalrows["phone_no_1"]) . " &nbsp;&nbsp; ";
}
print( "</span>");

if ($generalrows["status_phone_no_2"] == 0) print( "<span class='form_elements_text'>");
else print( "<span class='form_elements_text_disabled'>");
if ($editable == true || $generalrows["status_phone_no_2"] == 0) {
    if ($generalrows["phone_no_2"] != "") echo "<img src='images/icons/phone_office.gif' width='12' height='12' border='0' alt='Contact Number:' />" .
        "&nbsp;" . htmlspecialchars($generalrows["phone_no_2"]) . "  &nbsp;&nbsp; ";
}
print( "</span>");

if ($generalrows["status_fax_no"] == 0) print( "<span class='form_elements_text'>");
else print( "<span class='form_elements_text_disabled'>");
if ($editable == true || $generalrows["status_fax_no"] == 0) {
    if ($generalrows["fax_no"] != "") echo "<img src='images/icons/fax.png' width='12' height='12' border='0' alt='Fax No:' />" .
        "&nbsp;" . htmlspecialchars($generalrows["fax_no"]) . " &nbsp;&nbsp; ";
}
print( "</span>");

if ($generalrows["status_cell_no"] == 0) print( "<span class='form_elements_text'>");
else print( "<span class='form_elements_text_disabled'>");
if ($editable == true || $generalrows["status_cell_no"] == 0) {

    if ($generalrows["cell_no"] != "") echo "<img src='images/icons/cell.png' width='12' height='12' border='0' alt='Cell Phone' />" .
        "&nbsp;" . htmlspecialchars($generalrows["cell_no"]) . "  &nbsp;&nbsp; ";
}
print( "</span>");
if ($generalrows["url_1"] != "") {
    $urlname = $generalrows["url_name_1"] == "" ? "Web Link" : $generalrows["url_name_1"];
    echo "<img src='images/icons/web.gif' width='12' height='12' border='0' alt='$urlname' /> ";
    echo "<span class='form_elements_text'><a href='" . htmlspecialchars($generalrows["url_1"], ENT_QUOTES) . "' target='_blank'>" . $urlname . "</a></span>";
    print( "&nbsp; &nbsp;");
}
if ($generalrows["url_2"] != "") {
    $urlname = $generalrows["url_name_2"] == "" ? "Web Link" : $generalrows["url_name_2"];
    echo "<img src='images/icons/web.gif' width='12' height='12' border='0' alt='$urlname' /> ";
    echo "<span class='form_elements_text'><a href='" . htmlspecialchars($generalrows["url_2"], ENT_QUOTES) . "' target='_blank'>" . $urlname . "</a></span>";
    print( "&nbsp; &nbsp;");
}
if ($generalrows["url_3"] != "") {
    $urlname = $generalrows["url_name_3"] == "" ? "Web Link" : $generalrows["url_name_3"];
    echo "<img src='images/icons/web.gif' width='12' height='12' border='0' alt='$urlname' />";
    echo "<span class='form_elements_text'><a href='" . htmlspecialchars($generalrows["url_3"], ENT_QUOTES) . "' target='_blank'>" . $urlname . "</a></span>";
    print( "&nbsp; &nbsp;");
}

print( "</td>");
print( "</tr>");

print( "<tr>");
print( "<td colspan='2'>");
if ($generalrows["keywords"] != "") {
    echo "<img src='images/icons/key.gif' width='12' height='12' border='0' alt='Keywords' /> ";
    echo "<span class='form_elements_text'>" . htmlspecialchars($generalrows["keywords"]) . "</span></a>";
    print( "&nbsp; &nbsp;");
}
print( "</td>");
print( "</tr>");

print( "</table>");
print( "</td>");
print( "</tr>");
print( "<table>");

print( "<script type='text/javascript'>");
print( "function ShowProfile( url )");
print( "{");
print( "hide_popup( \"gen_association\" );");
print( "location.href=url");
print( "}");
print( "</script>");



print( "<div id='gen_association_box' style='display:none;z-index:100' onSelectStart='return false'>");
print( "<div id='gen_association_header' >");
print( "<span id='gen_association_caption' >");
print( "Associated Profiles");
print( "</span>");
print( "<span id='gen_association_close' >");
print( "<img alt='close' src='images/buttons/close.gif' onClick='hide_popup(\"gen_association\")'>");
print( "</span>");
print( "</div>");
print( "<div id='gen_association_content' >");
print( "<iframe id='gen_association_frame'></iframe>");
print( "</div>");
print( "</div>");
?>
