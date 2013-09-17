<?php
	if( $editable == true ){
	$ppl_teaching_query = "select t.pid, t.course_id, t.hid, t.course_number, t.section_number, t.course_title, t.days, t.times, t.location, t.description, t.file_id, t.course_goal, t.url_name, t.course_url, t.semester, t.year, t.status, t.archive, t.default_address,
if(t.default_address=1, t.office_location, p.office_location) as office_location,
if(t.default_address=1, t.room_no, p.room_no) as room_no,
if(t.default_address=1, t.phone_no_1, p.phone_no_1) as phone_no_1,
if(t.default_address=1, t.email_id, p.email_id) as email_id, t.office_hours,
g.section_id as section_id, g.file_type as file_type, g.file_size as file_size, g.upload_location as upload_location, g.file_name as file_name, g.upload_time as upload_time,
h.acronym as course_dept
FROM ppl_teaching AS t left join  gen_file_info AS g on t.file_id=g.file_id ,ppl_general_info AS p, gen_hierarchy_types AS h
WHERE t.pid =".real_mysql_specialchars( $pid, true )."  AND t.pid=p.pid AND t.hid=h.hid ORDER BY t.archive";

	}else
	$ppl_teaching_query = "select t.pid, t.course_id, t.hid, t.course_number, t.section_number, t.course_title, t.days, t.times, t.location, t.description, t.file_id, t.course_goal, t.url_name, t.course_url, t.semester, t.year, t.status, t.archive, t.default_address,
if(t.default_address=1, t.office_location, p.office_location) as office_location,
if(t.default_address=1, t.room_no, p.room_no) as room_no,
if(t.default_address=1, t.phone_no_1, p.phone_no_1) as phone_no_1,
if(t.default_address=1, t.email_id, p.email_id) as email_id, t.office_hours,
g.section_id as section_id, g.file_type as file_type, g.file_size as file_size, g.upload_location as upload_location, g.file_name as file_name, g.upload_time as upload_time,
h.acronym as course_dept
FROM ppl_teaching AS t left join  gen_file_info AS g on t.file_id=g.file_id ,ppl_general_info AS p, gen_hierarchy_types AS h
WHERE t.pid =".real_mysql_specialchars( $pid, true )."  AND t.pid=p.pid AND t.hid=h.hid AND t.status=0 AND t.archive=0";
	
	$ppl_teaching_results = real_execute_query ( $ppl_teaching_query, $db_conn );

$semester_query = "SELECT semester FROM gen_semester";
$semester_result = real_execute_query ($semester_query, $db_conn);

$contact_information_query = "SELECT office_location, room_no, phone_no_1, email_id FROM ppl_general_info where pid=".$pid;
$contact_information_result = real_execute_query ($contact_information_query, $db_conn);

$filequery = "SELECT file_name, upload_location, file_size FROM gen_file_info where file_id=".$file_id;

/*	if( $editable == true )
	{
		$ppl_teaching_max_id_query = "SELECT MAX( resch_id ) FROM ppl_teaching WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_teaching_max_id_results = real_execute_query ( $ppl_teaching_max_id_query, $db_conn );
	}
*/
?>