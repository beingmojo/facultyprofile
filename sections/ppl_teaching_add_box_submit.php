<?php
include '../utils.php';
include '../imageutils.php';
include '../fileutils.php';
require_once("../inputfilter.php");
session_start();
$_err_page = "../" . $_err_page;
$filedir = './syllabi/';
$fileuploaddir = '/opt/www/html/'.$_home."/syllabi/";

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$pid = real_unescape( $_POST["pid"] );
$section_id = real_unescape( $_POST["section_id"] );
$view = real_unescape( $_POST["view"] );

if( real_can_user_edit( $db_conn, $pid ) == true )
{
	$hid = substr( real_unescape( $_POST["ppl_teaching_dept"] ), 0, 4 );
	$course_number = substr( real_unescape( $_POST["ppl_teaching_course_number"] ), 0, 255 );
	$section_number = substr( real_unescape( $_POST["ppl_teaching_section_number"] ), 0, 255 );
	$status = ($_POST["ppl_teaching_status"]=="on")?"1":"0";
	$course_title = substr( real_unescape( $_POST["ppl_teaching_course_title"] ), 0, 255 );
	$office_hours = substr( real_unescape( $_POST["ppl_teaching_office_hours"] ), 0, 50 );
	$days = substr( real_unescape( $_POST["ppl_teaching_days"] ), 0, 20 );
	$times = substr( real_unescape( $_POST["ppl_teaching_times"] ), 0, 20 );
	$location = substr( real_unescape( $_POST["ppl_teaching_location"] ), 0, 255 );
	$ipFilter = new InputFilter(array( "script" ),"",1,1,1);
	$description = $ipFilter->process( $_POST["ppl_teaching_description"] );
	
	if($course_number!="" || $course_title!="")
	{
//	$ipFilter = new InputFilter(array( "script" ),"",1,1,1);
	$course_goal = $ipFilter->process( $_POST["ppl_teaching_course_goal"] );

	if(basename($_FILES['ppl_teaching_syllabus_file']['name'])!="")
	{
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
		$file_id=0;
	}

	$url_name = substr( real_unescape( $_POST["ppl_teaching_url_name"] ), 0, 50 );	
	$course_url = substr( real_unescape( $_POST["ppl_teaching_course_url"] ), 0, 255 );
	$course_url = real_validate_url($course_url);
	$semester = substr( real_unescape( $_POST["ppl_teaching_semester"] ), 0, 50 );
	$year = substr( real_unescape( $_POST["ppl_teaching_year"] ), 0, 25 );
	$default_address = substr( real_unescape( $_POST["ppl_teaching_default_address"] ), 0, 1 );
	$office_location = substr( real_unescape( $_POST["ppl_teaching_office_location"] ), 0, 255 );
	$room_number = substr( real_unescape( $_POST["ppl_teaching_room_number"] ), 0, 25 );
	$office_phone = substr( real_unescape( $_POST["ppl_teaching_office_phone"] ), 0, 25 );
	$email_id = substr( real_unescape( $_POST["ppl_teaching_email_id"] ), 0, 255 );

/*
	$itr = 0;
	$name = substr( real_unescape( $_POST["ppl_teaching_name"] ), 0, 255 );
	$url_name = substr( real_unescape( $_POST["ppl_teaching_url_name"] ), 0, 255 );
	$url = substr( real_unescape( $_POST["ppl_teaching_url"] ), 0, 255 );
	$ipFilter = new InputFilter(array( "script" ),"",1,1,1);
	$description = $ipFilter->process( $_POST["ppl_teaching_description"] );
	$status = ($_POST["ppl_teaching_status"]=="on")?"1":"0";
	$image_id = real_insert_image( $db_conn, $pid, $section_id, "imagefile", "../images" );
*/
/*	if( $name != "" )
*/	{ 
		$itr ++;
/*course_id, hid,*/
		$query = "INSERT INTO ppl_teaching ( pid,  hid, course_number, section_number, course_title, days, times, location, description, file_id, course_goal, url_name, course_url, semester, year, status, archive, default_address, office_location, room_no, phone_no_1, email_id, office_hours) VALUES( " .
				real_mysql_specialchars($pid, true) .
/*				", " . ($course_id) . 
				", " . real_mysql_specialchars( $hid, true ) .
*/				", " . real_mysql_specialchars( $hid, true ) .
				", " . real_mysql_specialchars( $course_number, false ) .
				", " . real_mysql_specialchars( $section_number, false ) .
				", " . real_mysql_specialchars( $course_title, false ) .				
				", " . real_mysql_specialchars( $days, false ) .
				", " . real_mysql_specialchars( $times, false ) .				
				", " . real_mysql_specialchars( $location, false ) .
				", " . real_mysql_specialchars( $description, false ) .
				", " . real_mysql_specialchars( $file_id, true ) .
				", " . real_mysql_specialchars( $course_goal, false ) .
				", " . real_mysql_specialchars( $url_name, false ) .				
				", " . real_mysql_specialchars( $course_url, false ) .
				", " . real_mysql_specialchars( $semester, false ) .
				", " . real_mysql_specialchars( $year, false ) .
				", " . real_mysql_specialchars( $status, true ) .
				", " . real_mysql_specialchars( $archive, true ) .
				", " . real_mysql_specialchars( $default_address, true ) .
				", " . real_mysql_specialchars( $office_location, false ) .
				", " . real_mysql_specialchars( $room_number, false ) .
				", " . real_mysql_specialchars( $office_phone, false ) .
				", " . real_mysql_specialchars( $email_id, false ) .
				", " . real_mysql_specialchars( $office_hours, false ) .
/*				", " . real_mysql_specialchars( $status, true ) .
				", " . $image_id .*/
				"  )";
				
				
	//		print("<br><br><br>Query:".$query);
		real_execute_query( $query, $db_conn );
		real_update_last_modified_timestamp( $db_conn, $pid );
	}
	}
}
//real_redirect("editprofile_teach.php","pid=$pid&view=$view&section_id=$section_id",$db_conn);
real_redirect( "../redirecttoeditprofile.php", "pid=$pid&view=$view&section_id=$section_id", $db_conn );

?>