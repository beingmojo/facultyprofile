<?php
session_start();
include_once 'utils.php';

if(isset($_GET['self'])){
    $_POST['page-title'] = "Edit Profile";
    $_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
    $_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
    $_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
    $_POST['page-link4'] = "<link rel='icon' href='favicon.ico' type='image/ico' />";
    $_POST['page-script1'] = "<script language='JavaScript' type='text/javascript' src='rteresources/html2xhtml.js'></script>";
    $_POST['page-script2'] = "<script language='JavaScript' type='text/javascript' src='rteresources/richtext.js'></script>";
    $_POST['page-script3'] = "<script language='JavaScript' type='text/javascript' src='scripts/section_and_menu.js'></script>";
    $_POST['page-script4'] = "<script language='JavaScript' type='text/javascript' src='scripts/findprofile.js'></script>";

    $_POST['page-include-page-top2'] = "true";
    include_once 'includes/page-top.php';
    include_once 'includes/page-top2.php';
}

$pid = "0";
$query1 = "SELECT pid FROM gen_profile_info WHERE type_id=1 AND owner_login_id='".$_SESSION['UID']."'";

$results = real_execute_query($query1, $db_conn);

while( $rows = mysql_fetch_array( $results ) ) {
	$pid = $rows["pid"];
}

				
print "<p>";
print "<span id='secname'>Biosketches</span>";
print "<table border=0 align=center width=90%><tr><td>";
print "<span id='secname'>National Science Foundation (NSF) Vitae</span><br>";
//print "<span id='secdetail'><a href='./rtf_new/publications.php?pid=" . $pid . "&target=nsf' target='_blank'>One Click Generation of Biographical Sketch </a> &nbsp;&nbsp; | Step by Step Builder (under construction) </span>";
print "<span id='secdetail'><a href='./rtf_new/publications.php?pid=" . $pid . "&target=nsf' target='_blank'>One Click Generation of Biographical Sketch </a> &nbsp;&nbsp;</span>";

print "</td></tr><tr><td></td></tr><tr><td>";
print "<span id='secname'>National Institutes of Health (NIH) Biographical Sketch</span><br>";
//print "<span id='secdetail'><a href='./rtf_new/publications.php?pid=" . $pid . "&target=nih&relevant=1' target='_blank'>One Click Generation of Curriculum vitae </a> &nbsp;&nbsp; | <a href='nih.php?pid=" . $pid . "' target='blank'>Step by Step builder (under construction)</a></span>";
print "<span id='secdetail'><a href='./rtf_new/publications.php?pid=" . $pid . "&target=nih&relevant=1' target='_blank'>One Click Generation of Curriculum vitae </a> &nbsp;&nbsp;</span>";
print "</td></tr>";
print "</table>";
print "</p>";
//university format
print "<p>";
print "<span id='secname'>Vitas</span>";
print "<table border=0 align=center width=90%><tr><td>";
print "<span id='secname'>University Vita Format</span><br>";
print "<span id='secdetail'><a href='./rtf_new/vita.php?pid=" . $pid . "'>One Click Generation of Vita in Word Format (Auto Fill)</a>  &nbsp;&nbsp; | <a href='nih4rtf.php?pid=" . $pid . "' target='blank'>Step by Step builder</a></span>";
print "</td></tr>";
print "</table>";
print "</p>";
?>
