<?php
include 'utils.php';
session_start();
$_err_page = "../" . $_err_page;

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);

list($course_acronym, $course_number) = split(" ", $_GET['course_number']);
$course_semester = strtoupper(substr($_GET['course_semester'], 0, 1)) . substr($_GET['course_semester'], 1);
$course_year = $_GET['course_year'];
$course_title = $_GET['course_title'];
$course_titleUpper = strtoupper($_GET['course_title']);
$course_titleArr = split(" ", $_GET['course_title']);
$course_titleFUpper = each($course_titleArr);
$course_titleFUpper = strtoupper(substr($course_titleFUpper[1], 0, 1)) . substr($course_titleFUpper[1], 1);
while ($course_titleWord = each($course_titleArr)) $course_titleFUpper = $course_titleFUpper . " " . strtoupper(substr($course_titleWord[1], 0, 1)) . substr($course_titleWord[1], 1);
$course_description = $_GET['course_description'];
$prof_fname = $_GET['prof_fname'];
$prof_lname = $_GET['prof_lname'];

$page = $_GET['page'];

/* * ****************************
  SELECT * FROM (ppl_teaching as t1 LEFT JOIN gen_hierarchy_types as t2 USING (hid)) LEFT JOIN ppl_general_info as t3 ON (t1.pid=t3.pid)
 * **************************** */

$searchSQL = "SELECT t1.pid,t2.acronym,t1.course_number,t3.title,t3.f_name,t3.l_name,t1.course_title,
					t1.course_id,t1.description,t1.semester,t1.year,t1.course_url,t1.url_name,t3.image_id,
					t1.file_id,t4.file_size,t4.upload_location,t4.file_name,t4.upload_time
				FROM ((ppl_teaching as t1 LEFT JOIN gen_hierarchy_types as t2 USING (hid))
					LEFT JOIN ppl_general_info as t3 ON (t1.pid=t3.pid))
					LEFT JOIN gen_file_info t4 ON (t1.file_id=t4.file_id), gen_profile_info t5 ";
$searchSQL = $searchSQL . "WHERE ";
if ($course_acronym || $course_number || $course_semester || $course_year || $course_title || $course_description || $prof_fname || $prof_lname) {
    if ($course_acronym) $searchSQL = $searchSQL . "t2.acronym LIKE '$course_acronym%' AND ";
    if ($course_number) $searchSQL = $searchSQL . "t1.course_number LIKE '$course_number%' AND ";
    if ($course_semester) $searchSQL = $searchSQL . "t1.semester LIKE '$course_semester%' AND ";
    if ($course_year) $searchSQL = $searchSQL . "t1.year LIKE '$course_year%' AND ";
    if ($course_title) $searchSQL = $searchSQL . "(t1.course_title LIKE '$course_title%' OR t1.course_title LIKE '$course_titleUpper%' OR t1.course_title LIKE '$course_titleFUpper%') AND ";
    if ($course_description) $searchSQL = $searchSQL . "MATCH (t1.description) AGAINST ('\"$course_description\"' IN BOOLEAN MODE) AND ";
    if ($prof_fname) $searchSQL = $searchSQL . "t3.f_name LIKE '$prof_fname%' AND ";
    if ($prof_lname) $searchSQL = $searchSQL . "t3.l_name LIKE '$prof_lname%' AND ";
    //$searchSQL = substr($searchSQL,0,-4);
}
$searchSQL = $searchSQL . " t5.pid=t1.pid and t5.status=0 ORDER BY t2.acronym,t1.course_number,t3.l_name, t3.f_name,t1.course_title ASC ";
$totalRows = mysql_num_rows(real_execute_query($searchSQL, $db_conn));

//////////Paging////////////////////
if ($page > 1) $startRecord = $page * 10 - 10;
else $startRecord = 0;
$numRows = 10;
$searchSQL = $searchSQL . "LIMIT $startRecord,$numRows";
$searchQuery = real_execute_query($searchSQL, $db_conn);
function printPageLinks($totalRows, $rowsPerPage, $currPage) {
    if ($totalRows % $rowsPerPage == 0) $pages = $totalRows / $rowsPerPage;
    else $pages = $totalRows / $rowsPerPage + 1;
    for ($i = 1; $i <= $pages; $i++) if ($i == $currPage) echo "<span style=\"font-size:14px;font-weight:bold;color:#000000;\">" . $i . "</span> ";
        else printf("<a class=\"font_topic\" href=\"javascript:document.getElementById('page').value='%d';ajaxCourseBrowse();\">%d</a> ",
                $i, $i);
}
$bgColor = "#CCCCCC";
$rowCounter = 0;
echo "<table width=\"100%\" >";
if ($totalRows > 0) {
    //Table head
    echo "<thead>";
    //Paging row
    echo "<tr>";
    echo "<td colspan=\"6\" style=\"text-align:center;font-size:12px;\">";
    echo "<input type=\"hidden\" id=\"page\" value=\"$page\" />";
    printPageLinks($totalRows, $numRows, $page);
    echo "</td>";
    echo "</tr>";
    //Column titles row
    echo "<tr class=\"table_background\">";
    echo "<td style=\"text-align:center;cursor:pointer;\" class=\"form_elements_section_header\" id=\"sort0\" onclick=\"sortSearchResults(0,'desc');\" >Sort&nbsp;&uarr;</td>";
    echo "<td style=\"text-align:center;cursor:pointer;\" class=\"form_elements_section_header\" id=\"sort1\" onclick=\"sortSearchResults(1,'desc');\">Sort&nbsp;&uarr;</td>";
    echo "<td colspan=\"2\" style=\"text-align:center;\" class=\"form_elements_section_header\">Course Instructor</td>";
    echo "<td style=\"text-align:center;\" class=\"form_elements_section_header\">Course Information</td>";
    echo "<td style=\"text-align:center;\" class=\"form_elements_section_header\">Course Links | Syllabi<span style=\"color:red\">*</span></td>";
    echo "</tr>";
    echo "</thead>";
    //Table footer
    echo "<tfoot>";
    $disclaimer = "<span style=\"color:red\">*Syllabi subject to change.</span>";
    echo "<tr class=\"table_background\">";
    echo "<td style=\"text-align:center;\" class=\"form_elements_section_header\">&nbsp;</td>";
    echo "<td style=\"text-align:center;\" class=\"form_elements_section_header\">&nbsp;</td>";
    echo "<td colspan=\"2\" style=\"text-align:center;\" class=\"form_elements_section_header\">&nbsp;</td>";
    echo "<td style=\"text-align:center;\" class=\"form_elements_section_header\">&nbsp;</td>";
    echo "<td style=\"text-align:center\" class=\"form_elements_section_header\">$disclaimer</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td colspan=\"6\" style=\"text-align:center;\">";
    printPageLinks($totalRows, $numRows, $page);
    echo "</td>";
    echo "</tr>";
    echo "</tfoot>";
}
//Table body
echo "<tbody>";
//Set styles for columns
$styleAcronym = "padding:5px;font-size:12px;text-align:center;";
$styleCourseNumber = "padding:5px;font-size:12px;text-align:center;";
$styleImage = "padding:5px;font-size:12px;text-align:center;";
$styleProfessor = "padding:5px;font-size:12px;text-align:center;";
$styleCourseInfo = "padding:5px;font-size:12px;text-align:left;vertical-align:top;";
$styleLinks = "padding:5px;font-size:12px;text-align:center;";
while ($searchRow = mysql_fetch_array($searchQuery)) {
    //Format results for print
    $searchRow['acronym'] = $searchRow['acronym'] ? $searchRow['acronym'] : "&nbsp;";
    $searchRow['course_number'] = $searchRow['course_number'] ? $searchRow['course_number'] : "&nbsp;";
    $searchRow['title'] = $searchRow['title'] ? $searchRow['title'] : "";
    $searchRow['f_name'] = $searchRow['f_name'] ? $searchRow['f_name'] : "";
    $searchRow['l_name'] = $searchRow['l_name'] ? $searchRow['l_name'] : "&nbsp;";
    $searchRow['semester'] = $searchRow['semester'] ? $searchRow['semester'] : "";
    $searchRow['year'] = $searchRow['year'] ? $searchRow['year'] : "&nbsp";
    $searchRow['course_title'] = $searchRow['course_title'] ? strip_tags($searchRow['course_title']) : "&nbsp;";
    $searchRow['description'] = $searchRow['description'] ? eregi_replace('(^[ [:cntrl:]]*[^ ].+[^ ])([ ][^ ]+[ [:cntrl:]]*$)', '\\1', substr(strip_tags($searchRow['description']), 0, 200)) : "&nbsp;";
    if ($searchRow['course_url']) $courseLink = sprintf("<a href=\"%s\" target=\"_blank\">Course Homepage</a>%s", $searchRow['course_url'], $searchRow['file_name'] ? " | " : "");
    else $courseLink = "";
    if ($searchRow['file_name']) $syllabusLink = sprintf("<a href=\"%s%s\" target=\"_blank\">Course Syllabus</a><br />[Uploaded:%s | File size:%.2fkb]",
                $searchRow['upload_location'], $searchRow['file_name'], $searchRow['upload_time'], $searchRow['file_size'] * .001);
    else $syllabusLink = "";
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $_home . "/images/48/" . $searchRow['pid'] . "_0_" . $searchRow['image_id'] . ".jpg")) $imageSrc = "images/48/" . $searchRow['pid'] . "_0_" . $searchRow['image_id'] . ".jpg";
    else $imageSrc = "images/icons/silhouette_small.jpg";
    $courseHref = "editprofile.php?pid=" . $searchRow['pid'] . "#" . $searchRow['course_id'];
    $profileHref = "editprofile.php?pid=" . $searchRow['pid'];

    //Begin printing
    if ($rowCounter % 2 !== 0) echo "<tr>";
    else echo "<tr bgcolor=\"$bgColor\">";
    //Print course_number cells
    printf("<td width=\"5%%\" style=\"%s\">%s</td><td width=\"5%%\" style=\"%s\">%s</td>",
        $styleAcronym, $searchRow['acronym'], $styleCourseNumber, $searchRow['course_number']);
    //Print image cell
    printf("<td width=\"5%%\" style=\"%s\"><a href=\"%s\" target=\"_blank\"><img src=\"%s\" border=\"0\" /></a></td>",
        $styleImage, $profileHref, $imageSrc);
    //Print professor name cell
    printf("<td width=\"15%%\" style=\"%s\"><a href=\"%s\" target=\"_blank\">%s %s %s</a></td>",
        $styleProfessor, $profileHref, $searchRow['title'], $searchRow['f_name'], $searchRow['l_name']);
    //Print information cell
    printf("<td width=\"50%%\" style=\"%s\">%s %s<br /><a href=\"%s\" target=\"_blank\" class=\"font_topic\">%s</a><br />%s...</td>",
        $styleCourseInfo, $searchRow['semester'], $searchRow['year'], $courseHref, $searchRow['course_title'], $searchRow['description']);
    //Print links cell
    printf("<td width=\"20%%\" style=\"%s\">%s%s</td>",
        $styleLinks, $courseLink, $syllabusLink);
    echo "</tr>";
    $rowCounter++;
}
if ($rowCounter === 0) echo "<tr><td style=\"font-size:12px;\">No Matches Found.</td></tr>";
echo "</tbody>";
echo "</table>";
?>