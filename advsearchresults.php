<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$_POST['page-title'] = "RPS Advanced Search";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';

$section_filter = array();
if ($_POST['section_filter']) $section_filter = $_POST['section_filter'];
elseif ($_GET['search']) {
    $sectionsSQL = "SELECT table_name
					FROM gen_section_types 
					WHERE table_exists='1'
					ORDER BY type_id ASC";
    $sectionsQuery = real_execute_query($sectionsSQL, $db_conn);
    while ($section = mysql_fetch_array($sectionsQuery)) $section_filter[] = htmlspecialchars($section['table_name']);
}

$field_filter = $_POST['field_filter'];

//Create search string for SQL query and comma-separated string of search words
$search_str = "";
$searchWords = "";
if ($_POST['search_str_some']) {
    $search_str = $search_str . eregi_replace('([a-zA-Z]+[^* ])([ ]|$)', ' \\1*\\2', $_POST['search_str_some']) . " ";
    $searchWords = $searchWords . $_POST['search_str_some'] . " ";
}
if ($_POST['search_str_all']) {
    $search_str = $search_str . eregi_replace('([^+ ][a-zA-Z]+[^* ])([ ]|$)', ' +\\1*\\2', $_POST['search_str_all']) . " ";
    $searchWords = $searchWords . $_POST['search_str_all'] . " ";
}
$searchWords = str_replace("  ", " ", $searchWords);
$searchWords = str_replace(" ", ",", $searchWords);
if ($_POST['search_str_exact']) {
    $search_str = $search_str . "\"" . $_POST['search_str_exact'] . "\" ";
    $searchWords = $searchWords . $_POST['search_str_exact'] . ",";
}
if ($_POST['search_str_less']) $search_str = $search_str . eregi_replace('([^- ][a-zA-Z]+)([ ]|$)', ' -\\1\\2', $_POST['search_str_less']) . " ";
$searchWords = substr($searchWords, 0, -1);

if ($search_str == "" && $_GET['search']) {
    $search_str = $_GET['search'];
    $searchWords = eregi_replace('[^[:alnum:][:space:]]', '', $_GET['search']);
    $searchWords = trim($searchWords);
    $searchWords = eregi_replace('[[:space:]]+', ',', $searchWords);
}

/* * ************For testing************************************
  echo "Search Query:&nbsp;&nbsp;<b>" . $search_str . "</b>";//For testing
  echo "<br />Highlight String:&nbsp;&nbsp;<b>" . $searchWords . "</b>";//For testing
 * *********************************************************** */

if ($section_filter && $search_str) {
    $search_str = mysql_real_escape_string($search_str);

    //Set tables to include in search
    $tables = array();
    foreach ($section_filter as $table_name) {
        if (!in_array($table_name, $tables)) $tables[] = $table_name;
    }

    //Create main search queries
    $searchQueries = array();
    for ($i = 0; $i < count($tables); $i++) {
        if ($tables[$i] != "equipment") { //Exception for equipment search
            //Create queries for normal search
            $fulltextFields = "";
            $searchSQL = "";
            if ($field_filter[$tables[$i]]) {
                foreach ($field_filter[$tables[$i]] as $field) $fulltextFields = $fulltextFields . $field . ",";
                $fulltextFields = substr($fulltextFields, 0, -1);
                $defaultFields = false;
            }else {
                $fulltextFieldsSQL = "SELECT index_fields FROM gen_section_types WHERE table_name='$tables[$i]'";
                $fulltextFieldsQuery = real_execute_query($fulltextFieldsSQL, $db_conn);
                $fulltextFields = mysql_result($fulltextFieldsQuery, 0);
                $defaultFields = true;
            }
            //Use non-boolean fulltext search if default fields are selected for better score.
            if ($defaultFields === true) $searchSQL = "SELECT pid, MATCH($fulltextFields) AGAINST ('$search_str') AS score, ";
            else $searchSQL = "SELECT pid, SUM(MATCH($fulltextFields) AGAINST ('$search_str' IN BOOLEAN MODE)) AS score, ";
            $searchSQL = $searchSQL . $fulltextFields . " FROM $tables[$i] ";
            $searchSQL = $searchSQL . "WHERE MATCH($fulltextFields) AGAINST ('$search_str' IN BOOLEAN MODE) ";

            //Check if status field exists in table
            $statusQuery = real_execute_query("EXPLAIN $tables[$i]", $db_conn);
            while ($statusRow = mysql_fetch_array($statusQuery)) {
                if ($statusRow['Field'] == "status") {
                    $searchSQL .= "AND status=0 ";
                    break;
                }
            }

            $searchSQL = $searchSQL . "GROUP BY pid ";
            $searchSQL = $searchSQL . "ORDER BY score DESC";
            $searchQueries[$i]['query'] = real_execute_query($searchSQL, $db_conn);
            $searchQueries[$i]['table_name'] = $tables[$i];
            $searchQueries[$i]['sql'] = $searchSQL; // For testing
        }
        //Exception for equipment search
        //Match all selected equipment fields with designated tables and create queries
        elseif ($tables[$i] == "equipment" && $field_filter[$tables[$i]]) {
            $equipmentSearchQueries = array();
            $equipmentQueriesCounter = 0;
            foreach ($field_filter[$tables[$i]] as $field) {
                $tablesSQL = "SELECT table_name FROM gen_section_searchfields WHERE field_name='$field' AND type_id='5'";
                $tablesQuery = real_execute_query($tablesSQL, $db_conn);
                $tables = split(",", mysql_result($tablesQuery, 0));
                foreach ($tables as $table) {
                    $equipmentSearchSQL = "SELECT pid, SUM(MATCH($field) AGAINST ('$search_str' IN BOOLEAN MODE)) AS score, $field
											FROM $table 
											WHERE MATCH($field) AGAINST ('$search_str' IN BOOLEAN MODE)
											GROUP BY pid
											ORDER BY score DESC";
                    $equipmentSearchQueries[$equipmentQueriesCounter]['query'] = real_execute_query($equipmentSearchSQL, $db_conn);
                    $equipmentSearchQueries[$equipmentQueriesCounter]['table_name'] = $table;
                    $equipmentSearchQueries[$equipmentQueriesCounter]['sql'] = $equipmentSearchSQL; // For testing
                    $equipmentQueriesCounter++;
                }
            }
        }
    }
    //Exception for equipment search
    //Add equipment search queries to main search queries
    if ($equipmentSearchQueries) {
        $searchQueriesCounter = count($searchQueries);
        foreach ($equipmentSearchQueries as $equipmentSearchQuery) {
            $searchQueries[$searchQueriesCounter]['query'] = $equipmentSearchQuery['query'];
            $searchQueries[$searchQueriesCounter]['table_name'] = $equipmentSearchQuery['table_name'];
            $searchQueries[$searchQueriesCounter]['sql'] = $equipmentSearchQuery['sql']; // For testing
            $searchQueriesCounter++;
        }
    }
}
//Set variables used to retrieve information to be printed
$pids = array();
$pidScores = array();
$pidMatchedString = array();
$pidSectionIds = array();
$pidSectionNames = array();
//Go through all queries
for ($i = 0; $i < count($searchQueries); $i++) {
    if (mysql_num_rows($searchQueries[$i]['query']) > 0) {
        while ($pidResult = mysql_fetch_row($searchQueries[$i]['query'])) {
            $pid = $pidResult[0];
            //Set pid for output
            if (!in_array($pid, $pids)) {
                $pids[] = $pid;
                $pidScores[] = $pidResult[1];
            }
            //Go through all the fields returned in fetched array except pid and score
            for ($fieldCounter = 2; $fieldCounter < count($pidResult); $fieldCounter++) {
                //Go through all search words to find a match in a field
                $searchWordsSplit = split(',', $searchWords);
                for ($wordCounter = 0; $wordCounter < count($searchWordsSplit); $wordCounter++) {
                    //Format and set the matched string for output
                    $matchedString = strip_tags($pidResult[$fieldCounter]);
                    $regMatch = eregi($searchWordsSplit[$wordCounter], $matchedString);
                    if ($regMatch != false && $pidMatchedString[$pid] == false) {
                        $position = strpos(strtoupper($matchedString), strtoupper($searchWordsSplit[$wordCounter]));
                        if ($position < 40) $startPos = 0;
                        else $startPos = $position - 40;
                        if (strlen($matchedString) - $startPos < 200) $maxLength = strlen($matchedString) - $startPos;
                        else $maxLength = 200;
                        $pidMatchedString[$pid] = substr($matchedString, $startPos, $maxLength);
                        //Strip partial words from matched string
                        if ($startPos != 0) {
                            $pidMatchedString[$pid] = eregi_replace('(^[ [:cntrl:]]*[^ ]+[ ]+)([^ ].+[^ ])([ ][^ ]+[ [:cntrl:]]*$)', '\\2', $pidMatchedString[$pid]);
                            $pidMatchedString[$pid] = "..." . $pidMatchedString[$pid] . "...";
                        }elseif ($startPos == 0 && $maxLength == 200) {
                            $pidMatchedString[$pid] = eregi_replace('(^[ [:cntrl:]]*[^ ].+[^ ])([ ][^ ]+[ [:cntrl:]]*$)', '\\1', $pidMatchedString[$pid]);
                            $pidMatchedString[$pid] = $pidMatchedString[$pid] . "...";
                        }
                        //Make matched word bold.
                        $pidMatchedString[$pid] = eregi_replace('(^|[^[:alnum:]])(' . $searchWordsSplit[$wordCounter] . ')', '\\1<b>\\2</b>', $pidMatchedString[$pid]);
                    }
                }
            }
            //Get section information for output
            $tableName = $searchQueries[$i]['table_name'];
            $sectionSQL = "SELECT name, section_id FROM gen_section_types WHERE table_name='$tableName'";
            $sectionQuery = real_execute_query($sectionSQL, $db_conn);
            $sectionResult = mysql_fetch_array($sectionQuery);
            //Set section name for output
            if (!$pidSectionNames[$pid]) $pidSectionNames[$pid] = array();
            if (!in_array($sectionResult['name'], $pidSectionNames[$pid])) $pidSectionNames[$pid][] = $sectionResult['name'];
            //Set section ID for output
            if (!$pidSectionIds[$pid]) $pidSectionIds[$pid] = array();
            if (!in_array($sectionResult['section_id'], $pidSectionIds[$pid])) $pidSectionIds[$pid][] = $sectionResult['section_id'];
        }
    }
}
//Sort matches by score
if (count($pids) != 0) {
    arsort($pidScores);
    $sortedPids = array();
    foreach ($pidScores as $index => $pidScore) $sortedPids[] = $pids[$index];
    $pids = $sortedPids;
}
?>

<script type="text/javascript">
    <!--
    var timer;
    startList = function()
    {
        if (document.all&&document.getElementById)
        {
            navRoot = document.getElementById("nav");
            for (i=0; i<navRoot.childNodes.length; i++)
            {
                node = navRoot.childNodes[i];
                if (node.nodeName=="LI")
                {
                    node.onmouseover=function()
                    {
                        this.className+=" over";
                    }
                    node.onmouseout=function()
                    {
                        this.className=this.className.replace(" over", "");
                    }
                }
            }
        }
    }

    window.onload=function()
    {
        startList();
    }

    //-->
</script>
<style type="text/css">
    table#searchResults td {
        border-top:1px solid #CCCCCC;
        font-size:12px;
    }
</style>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <!-- content goes here -->
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
<?php
//Print search results
echo "<table width='100%' cellpadding='0' cellspacing='0' id=\"searchResults\">";
foreach ($pids as $pid) {
    $profileInfoSQL = "SELECT t1.name, t1.type_id, t1.owner_login_id, t2.name AS type, t3.image_id
						FROM (gen_profile_info AS t1 LEFT JOIN gen_profile_types AS t2 USING (type_id))
							LEFT JOIN gen_image_info as t3 ON (t1.pid=t3.pid) 
						WHERE t1.pid='$pid'";
    $profileInfoQuery = real_execute_query($profileInfoSQL, $db_conn);
    $profileInfoResult = mysql_fetch_array($profileInfoQuery);
    echo "<tr>";
    //Print image cell
    echo "<td valign=\"middle\" align=\"center\" width=\"5%\">";
    $imgSrc = sprintf("images/48/%s_0_%s.jpg", $pid, $profileInfoResult['image_id']);
    if ($profileInfoResult['image_id'] != 0 && file_exists($_SERVER['DOCUMENT_ROOT'] . "/ra/real/" . $imgSrc)) printf("<img src=\"%s\" alt=\"%s\"/>", $imgSrc, htmlspecialchars($profileInfoResult['name'], ENT_QUOTES));
    else echo "&nbsp;";
    echo "</td>";
    //Print information cell
    echo "<td valign=\"middle\" align=\"left\" width=\"85%\">";
    echo "<b>" . htmlspecialchars($profileInfoResult['type']) . "</b><br />";
    printf("<a href=\"editprofile.php?pid=%s&highlight=%s&onlyview=1\"><span class=\"font_topic\">%s</span></a><br />",
        $pid, urlencode($searchWords), htmlspecialchars($profileInfoResult['name']));
    echo $pidMatchedString[$pid] . "<br />";
    $sections = "";
    foreach ($pidSectionIds[$pid] as $index => $pidSectionId) {
        $link = sprintf("<a href=\"editprofile.php?pid=%s&highlight=%s&onlyview=1#%d\">%s</a>",
                $pid, urlencode($searchWords), urlencode($pidSectionId),
                htmlspecialchars($pidSectionNames[$pid][$index]));
        $sections = $sections . $link . ", ";
    }
    $sections = substr($sections, 0, -2);
    printf("<b>Results found in:</b> %s", $sections);
    echo "</td>";
    //Print type icon cell
    echo "<td valign=\"middle\" align=\"right\"  width=\"5%\">";
    $imgsrc = "";
    $alt = "";
    switch ($profileInfoResult['type_id']) {
        case 1:$imgsrc = "images/bullets/faculty.gif";
            $alt = "Faculty";
            break;
        case 2:$imgsrc = "images/bullets/center.gif";
            $alt = "Research Center";
            break;
        case 3:$imgsrc = "images/bullets/technology.gif";
            $alt = "Technology";
            break;
        case 4:$imgsrc = "images/bullets/facility.gif";
            $alt = "Facility";
            break;
        case 5:$imgsrc = "images/bullets/equipment.gif";
            $alt = "Equipment";
            break;
        case 6:$imgsrc = "images/bullets/labgroup.gif";
            $alt = "Labs & Groups";
            break;
    }
    if ($imgsrc != "") printf("<img src=\"%s\" alt=\"%s\" />", $imgsrc, $alt);
    echo "</td>";
    //Print institution icon cell
    echo "<td valign=\"middle\" align=\"right\"  width=\"5%\">";
    if ($profileInfoResult['owner_login_id'] == "other1" || $profileInfoResult['owner_login_id'] == "other2") echo "<img src=\"images/unt_logo.gif\" alt=\"UNT\" />";
    else echo "<img src=\"images/uta_logo_black.gif\" alt=\"UTA\" />";
    echo "</td>";
    echo "</tr>";
}
if (count($pids) == 0) {
    echo "<tr><td>";
    echo "<h2>No Results.</h2>";
    //Suggest a recent search
    $searchWordsSplit = split(",", $searchWords);
    $recentSearchWords = "";
    $totalWords = count($searchWordsSplit);
    for ($i = 0; $i < count($searchWordsSplit); $i++) {
        $subWords = "";
        for ($ii = 0; $ii < $totalWords; $ii++) $subWords = $subWords . "+" . substr($searchWordsSplit[$ii], 0, 4) . "* ";
        $recentSearchSQL = "SELECT search_words, MATCH(search_words) AGAINST ('$subWords') AS score
							FROM gen_recent_search
							WHERE MATCH(search_words) AGAINST ('$subWords' IN BOOLEAN MODE)
							ORDER BY score DESC";
        $recentSearchQuery = real_execute_query($recentSearchSQL, $db_conn);
        if (mysql_num_rows($recentSearchQuery) > 0) {
            $recentSearchWords = mysql_result($recentSearchQuery, 0);
            break;
        }
        else $totalWords--;
    }
    $suggest = eregi_replace('[^[:alnum:][:space:]]', '', $recentSearchWords);
    if (strlen($suggest) > 0) printf("<p style=\"font-size:16px;margin-bottom:5px;\">Did you mean <a href=\"advsearchresults.php?search=%s\">%s</a>?</p>",
            urlencode(mysql_result($recentSearchQuery, 0)), htmlspecialchars($suggest));
    echo "</td></tr>";
}
else {
    //Insert recent search information
    $user_ip = $_SERVER['REMOTE_ADDR'] . ":" . getenv('HTTP_CLIENT_IP');
    //Don't insert if ip matches
    $noInsertIp = array("0.0.0.0:0.0.0.0");
    $search_str_esc = mysql_real_escape_string($search_str);
    $user_ip_esc = mysql_real_escape_string($user_ip);
    if (!in_array($user_ip, $noInsertIp) && !$_GET['search']) $insertRecentSearch = real_execute_query("INSERT INTO gen_recent_search VALUES (now(),'$search_str_esc','$user_ip_esc')", $db_conn);
    //Clean up recent search information
    $recentSearchSQL = "SELECT search_datetime FROM gen_recent_search ORDER BY search_datetime DESC LIMIT 30,1";
    $recentSearchQuery = real_execute_query($recentSearchSQL, $db_conn);
    if (mysql_num_rows($recentSearchQuery) > 0) {
        $recentSearchDate = mysql_result($recentSearchQuery, 0);
        $cleanupRecentSearch = real_execute_query("DELETE FROM gen_recent_search WHERE search_datetime<'$recentSearchDate'", $db_conn);
    }
}
echo "</table>";

/* * ****For testing sql string********
  foreach($searchQueries as $query)
  printf("<p>%s</p>",$query['sql']);
 * ********************************** */
?>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="table_background">
            <!-- Partnership text in this section with the hyperlink should remain visible on the template page and should not deleted -->
            <div align="right"><a href="http://www.txstate.edu/research/" target="_blank"><span class="font_on_dark_blue"><strong>powering - The Partnership</strong></span></a></div>
            <!-- End of Partnership text -->
        </td>
    </tr>
    <!-- footer content goes here -->
    <tr>
        <td bgcolor="#D7CFCD"><div align="center"><font size="2" class="form_elements_row_action">&copy; 2010 Texas State University - San Marcos| <a href="http://www.txstate.edu/research">Electronic Research Administration</a>, 601 University Drive, San Marcos, Texas 78666 Voice: 512.245.211 |<a href="feedback.php">Site Feedback</a> | <a href="http://www.txstate.edu/research/oera.html">Contact Electronic Research Administration - Web Team</a><br />

                </font></div>
            <!-- Start of StatCounter Code
    This spot can be used to enter tracking coutner code. Recommended: http://www.statcounter.com
    End of StatCounter Code -->
        </td>
        <!--end of footer -->
    </tr>
    <tr>
        <td bgcolor="#D7CFCD" class="form_elements_row_action"> <div align="center"><span class="error_message">Important Disclaimer: </span><strong>The responsibility for the accuracy of the information contained on these pages lies with the authors and user providing such information. </strong></div></td>
    </tr>
</table>
</body>
<!-- InstanceEnd -->
</html>
