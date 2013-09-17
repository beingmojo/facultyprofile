<?php
include 'utils.php';
session_start();
$_err_page = "../" . $_err_page;

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);

list($course_acronym, $course_number) = split(" ",$_GET['course_number']);
$course_semester = strtoupper(substr($_GET['course_semester'],0,1)).substr($_GET['course_semester'],1);
$course_year = $_GET['course_year'];
$course_title = $_GET['course_title'];
$course_titleUpper = strtoupper($_GET['course_title']);
$course_titleArr = split(" ",$_GET['course_title']);
$course_titleFUpper = each($course_titleArr);
$course_titleFUpper = strtoupper(substr($course_titleFUpper[1],0,1)).substr($course_titleFUpper[1],1);
while($course_titleWord = each($course_titleArr))
	$course_titleFUpper = $course_titleFUpper . " " . strtoupper(substr($course_titleWord[1],0,1)).substr($course_titleWord[1],1);
$course_description = $_GET['course_description'];
$prof_fname = $_GET['prof_fname'];
$prof_lname = $_GET['prof_lname'];

if ($course_acronym && $course_number) {
	$hintSQL = "SELECT t1.course_number,t2.acronym,t2.name 
				FROM ppl_teaching as t1 
					LEFT JOIN gen_hierarchy_types as t2 USING(hid)
					LEFT JOIN gen_profile_info as t3 ON(t1.pid=t3.pid)
				WHERE t2.acronym LIKE '$course_acronym%' AND t1.course_number LIKE '$course_number%' AND t3.status=0
				GROUP BY t2.acronym,t1.course_number
				ORDER BY t2.acronym,t1.course_number ASC 
				LIMIT 0,5";
	$hintQuery = real_execute_query($hintSQL,$db_conn);
	while($hintRow = mysql_fetch_array($hintQuery))
		printf("<p style=\"cursor:pointer;\" onclick=\"selectHint('course_number','%s %s')\">%s [%s] %s</p>",$hintRow['acronym'],$hintRow['course_number'],$hintRow['name'],$hintRow['acronym'],$hintRow['course_number']);
}
elseif ($course_acronym) {
	$hintSQL = "SELECT t1.course_number,t2.acronym,t2.name 
				FROM ppl_teaching as t1 
					LEFT JOIN gen_hierarchy_types as t2 USING(hid)
					LEFT JOIN gen_profile_info as t3 ON(t1.pid=t3.pid)
				WHERE t2.acronym LIKE '$course_acronym%' AND t3.status=0
				GROUP BY t2.acronym,t1.course_number
				ORDER BY t2.acronym,t1.course_number ASC
				LIMIT 0,5";
	$hintQuery = real_execute_query($hintSQL,$db_conn);
	while($hintRow = mysql_fetch_array($hintQuery))
		printf("<p style=\"cursor:pointer;\" onclick=\"selectHint('course_number','%s %s')\">%s [%s] %s</p>",$hintRow['acronym'],$hintRow['course_number'],$hintRow['name'],$hintRow['acronym'],$hintRow['course_number']);
}
elseif ($course_number) {
	$hintSQL = "SELECT t1.course_number,t2.acronym,t2.name 
				FROM ppl_teaching as t1 
					LEFT JOIN gen_hierarchy_types as t2 USING(hid)
					LEFT JOIN gen_profile_info as t3 ON(t1.pid=t3.pid)
				WHERE t1.course_number LIKE '$course_number%' AND t3.status=0
				GROUP BY t2.acronym,t1.course_number
				ORDER BY t2.acronym,t1.course_number ASC
				LIMIT 0,5";
	$hintQuery = real_execute_query($hintSQL,$db_conn);
	while($hintRow = mysql_fetch_array($hintQuery))
		printf("<p style=\"cursor:pointer;\" onclick=\"selectHint('course_number','%s %s')\">%s [%s] %s</p>",$hintRow['acronym'],$hintRow['course_number'],$hintRow['name'],$hintRow['acronym'],$hintRow['course_number']);
}
elseif ($course_semester) {
	$hintSQL = "SELECT semester 
				FROM ppl_teaching
					LEFT JOIN gen_profile_info as t2 USING(pid)
				WHERE semester LIKE '$course_semester%' AND t2.status=0
				GROUP BY semester
				ORDER BY semester ASC
				LIMIT 0,5";
	$hintQuery = real_execute_query($hintSQL,$db_conn);
	while($hintRow = mysql_fetch_array($hintQuery))
		printf("<p style=\"cursor:pointer;\" onclick=\"selectHint('course_semester','%s')\">%s</p>",$hintRow['semester'],$hintRow['semester']);
}
elseif ($course_year) {
	$hintSQL = "SELECT year 
				FROM ppl_teaching
					LEFT JOIN gen_profile_info as t2 USING(pid)
				WHERE year LIKE '$course_year%' AND t2.status=0
				GROUP BY year
				ORDER BY year ASC
				LIMIT 0,5";
	$hintQuery = real_execute_query($hintSQL,$db_conn);
	while($hintRow = mysql_fetch_array($hintQuery))
		printf("<p style=\"cursor:pointer;\" onclick=\"selectHint('course_year','%s')\">%s</p>",$hintRow['year'],$hintRow['year']);
}
elseif ($course_title) {
	$hintSQL =	"SELECT course_title 
				FROM ppl_teaching 
					LEFT JOIN gen_profile_info as t2 USING(pid)
				WHERE course_title LIKE '$course_title%' OR course_title LIKE '$course_titleUpper%' OR course_title LIKE '$course_titleFUpper%' AND t2.status=0
				GROUP BY course_title
				ORDER BY course_title ASC
				LIMIT 0,5";
	$hintQuery = real_execute_query($hintSQL,$db_conn);
	while($hintRow = mysql_fetch_array($hintQuery))
		printf("<p style=\"cursor:pointer;\" onclick=\"selectHint('course_title','%s')\">%s</p>",$hintRow['course_title'],$hintRow['course_title']);
}
elseif ($course_description) {
	$hintSQL; 
}
elseif ($prof_fname) {
	$hintSQL = "SELECT t2.f_name 
				FROM ppl_teaching as t1 
					LEFT JOIN ppl_general_info as t2 USING (pid)
					LEFT JOIN gen_profile_info as t3 ON(t1.pid=t3.pid)
				WHERE t2.f_name LIKE '$prof_fname%' AND t3.status=0
				GROUP BY f_name
				ORDER BY t2.f_name ASC
				LIMIT 0,5";
	$hintQuery = real_execute_query($hintSQL,$db_conn);
	while($hintRow = mysql_fetch_array($hintQuery))
		printf("<p style=\"cursor:pointer;\" onclick=\"selectHint('prof_fname','%s')\">%s</p>",$hintRow['f_name'],$hintRow['f_name']);
}
elseif ($prof_lname) {
	$hintSQL = "SELECT t2.l_name 
				FROM ppl_teaching as t1 
					LEFT JOIN ppl_general_info as t2 USING (pid)
					LEFT JOIN gen_profile_info as t3 ON(t1.pid=t3.pid)
				WHERE t2.l_name LIKE '$prof_lname%' AND t3.status=0
				GROUP BY l_name
				ORDER BY t2.l_name ASC
				LIMIT 0,5";
	$hintQuery = real_execute_query($hintSQL,$db_conn);
	while($hintRow = mysql_fetch_array($hintQuery))
		printf("<p style=\"cursor:pointer;\" onclick=\"selectHint('prof_lname','%s')\">%s</p>",$hintRow['l_name'],$hintRow['l_name']);
}
?>