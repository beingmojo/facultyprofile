<?php
include '../utils.php';
include '../fileutils.php';
require_once("../inputfilter.php");
session_start();
$filedir = './syllabi/';
$fileuploaddir = '/opt/www/html'.$_home.'/syllabi/';
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$course_id = real_unescape( $_POST["course_id"] );
$view = real_unescape( $_POST["view"] );

if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$hid = substr( real_unescape( $_POST["ppl_teaching_course_dept"] ), 0, 4 );
	$course_number = real_unescape( $_POST["ppl_teaching_course_number"] );
	$section_number = real_unescape( $_POST["ppl_teaching_section_number"] );	
	$course_title = substr( real_unescape( $_POST["ppl_teaching_course_title"] ), 0, 255 );
	$days = substr( real_unescape( $_POST["ppl_teaching_days"] ), 0, 20 );
	$times = substr( real_unescape( $_POST["ppl_teaching_times"] ), 0, 20 );
	$location = substr( real_unescape( $_POST["ppl_teaching_location"] ), 0, 255 );	
	$ipFilter = new InputFilter(array( "script" ),"",1,1,1);
	$description = $ipFilter->process( $_POST["ppl_teaching_description"] );
	$url_name = substr( real_unescape( $_POST["ppl_teaching_url_name"] ), 0, 50 );
	$course_url = substr( real_unescape( $_POST["ppl_teaching_course_url"] ), 0, 255 );
	$course_url = real_validate_url($course_url);
	$course_goal = $ipFilter->process( $_POST["ppl_teaching_course_goal"] );

	$semester = substr( real_unescape( $_POST["ppl_teaching_semester"] ), 0, 50 );
	$year = real_unescape( $_POST["ppl_teaching_year"] );
	
	$status = ($_POST["ppl_teaching_status"]=="on")?"1":"0";
	$ppl_teaching_remove_syllabus_file = ($_POST["ppl_teaching_remove_syllabus_file"]=="on")?"1":"0";
	$default_address = substr( real_unescape( $_POST["ppl_teaching_edit_default_address"] ), 0, 1 );

	$office_location = substr( real_unescape( $_POST["ppl_teaching_office_location"] ), 0, 25 );
	$room_no = substr( real_unescape( $_POST["ppl_teaching_room_number"] ), 0, 16 );
	$phone_no_1 = substr( real_unescape( $_POST["ppl_teaching_office_phone"] ), 0, 32 );	
	$email_id = substr( real_unescape( $_POST["ppl_teaching_email_id"] ), 0, 255 );	
	$office_hours = substr( real_unescape( $_POST["ppl_teaching_office_hours"] ), 0, 50 );
	
	if($course_number!="" || $course_title!="")
	{
	
	if(basename($_FILES['ppl_teaching_syllabus_file']['name'])!="")
	{	
		$file_id = real_unescape( $_POST["ppl_teaching_file_id"] );
		if($file_id != 0)
			real_delete_file( $db_conn, $file_id );
		
		$ext = explode(".", basename($_FILES['ppl_teaching_syllabus_file']['name']));
		$ext = array_pop($ext);
		$file_name = $pid."_".$course_dept."_".$course_number."_syllabus.".$ext;

		$file_type = $_FILES['ppl_teaching_syllabus_file']["type"];	
		$file_size = $_FILES['ppl_teaching_syllabus_file']["size"];
		$file_id = real_insert_file($db_conn, $pid, $section_id, $file_type, $file_size, $file_name, $filedir );
		$file_name = $file_id . "_" . $file_name;		
		$uploadfile = $fileuploaddir . $file_name;

		if (!move_uploaded_file($_FILES['ppl_teaching_syllabus_file']['tmp_name'], $uploadfile)) 
		{
			$msg = "There was a problem uploading your Syllabus file";
//			print_r($_FILES);
			$redirect = "Location:ppl_teaching_add_box_submit.php?msg=".$msg;
			header($redirect);
		}
	}
	else{
		$file_id = real_unescape( $_POST["ppl_teaching_file_id"] );
	}

	if( $ppl_teaching_remove_syllabus_file == "1" )
	{
		if( $file_id != 0 )
		{
			real_delete_file( $db_conn, $file_id);
			$file_id = 0;
		}
	}
	else
	{
		if( $file_id == 0 || $file_id == "" )
		{
	//		$cur_file_id = real_insert_file(  $db_conn, $pid, $section_id, $file_type, $file_size, $file_name, $fileuploaddir );
			if( $cur_file_id != 0 ) $file_id = $cur_file_id;
		}
		else{
		//	real_update_file( $db_conn, $file_name, $file_id, $fileuploaddir );
		}
	}	
	if( $pid != "" )
	{
		$query = "UPDATE ppl_teaching SET " .
					" hid=". real_mysql_specialchars( $hid, false ) .
					", course_number=" . real_mysql_specialchars( $course_number, false ) .
					", section_number=" . real_mysql_specialchars( $section_number, false ) .
					", course_title=" . real_mysql_specialchars( $course_title, false ) .
					", days=" . real_mysql_specialchars( $days, false ) .
					", times=" . real_mysql_specialchars( $times, false ) .					
					", location=" . real_mysql_specialchars( $location, false ) .
					", description=" . real_mysql_specialchars( $description, false ) .
					", url_name=" . real_mysql_specialchars( $url_name, false ) .					
					", course_url=" . real_mysql_specialchars( $course_url, false ) .
					", course_goal=" . real_mysql_specialchars( $course_goal, false ) .
					", semester=" . real_mysql_specialchars( $semester, false ) .
					", year=" . real_mysql_specialchars( $year, false ) .
					", status=" . real_mysql_specialchars( $status, true ) .
					", default_address=" . real_mysql_specialchars( $default_address, true ) .
					", office_location=" . real_mysql_specialchars( $office_location, false ) .
					", room_no=" . real_mysql_specialchars( $room_no, false ) .
					", phone_no_1=" . real_mysql_specialchars( $phone_no_1, false ) .
					", email_id=" . real_mysql_specialchars( $email_id, false ) .
					", office_hours=" . real_mysql_specialchars( $office_hours, false ) .
					", file_id=" . real_mysql_specialchars( $file_id, true ) .
					" WHERE pid=". real_mysql_specialchars( $pid, true ) .
					" AND course_id=" . real_mysql_specialchars( $course_id, true );
//		print("<br>Query:".$query);	
		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
	}
}

real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );

?>