<?php
function real_update_file( $db_conn, $file_name, $file_id, $upload_location )
{
	return real_update_file_type( $db_conn, $file_name, $file_id, $upload_location );
}
function real_insert_file( $db_conn, $pid, $section_id, $file_type, $file_size, $file_name, $upload_location )
{
	return real_insert_file_type( $db_conn, $pid, $section_id, $file_type, $file_size, $file_name, $upload_location );
}

/***************************************************************************************
function: real_update_file_type
description: Updates the gen_file_info
params: 
	$db_conn - database link
	$pid - profile id	
	$section_id - Section id of the section to which it belongs
	$file_name - Field name of the upload field in the form
	$file_id - The ID of the file which needs to be updated
	$type - File type
returns: true if the user has edit rights, else false
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_update_file_type( $db_conn, $file_name, $file_id, $upload_location )
{
	if( $_FILES )
	{
	//	if( is_uploaded_file( $_FILES[$file_name]["tmp_name"] ) )
		{
	  //      $tempname = $_FILES[$file_name]['tmp_name'];			
		$upload_time = date('l dS, F Y h:i:s A');
			$file_query = "UPDATE gen_file_info SET file_name =" . real_mysql_specialchars($file_name, false) .
												 ", upload_location =" . real_mysql_specialchars($upload_location, false) . 
												 ", upload_time =" . real_mysql_specialchars($upload_time, false) . 
												 " WHERE file_id =".$file_id;
			real_execute_query( $file_query, $db_conn );
           
			return true;
		}
	}
	return false;
}

/***************************************************************************************
function: real_insert_file_type
description: inserts the file into the database. Renames the file with file_id in the begining.
params: 
	$db_conn - database link
	$pid - profile id
	$file_name - file field name specified in the html file
	$type - "all", "banner", or "logo"
returns: file id on success and 0 or failure
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_insert_file_type( $db_conn, $pid, $section_id, $file_type, $file_size, $file_name, $upload_location )
{
	print("<br>Inside real insert file_type");
	if( $_FILES )
	{
		//print("<br>Inside if FILES".$_FILES[$file_name]["tmp_name"]);
		//if( is_uploaded_file( $_FILES[$file_name]["tmp_name"] ) )
		{
			$upload_time = date('l dS, F Y h:i:s A');
				print("<br>Inside is_uploaded<br>");
				print($file_name);
			$file_query = "INSERT INTO gen_file_info ( pid, section_id, file_type, file_size, upload_time )	
								VALUES ( ". 
								real_mysql_specialchars($pid, true ) .
								", " . real_mysql_specialchars($section_id, true ) .
								", " . real_mysql_specialchars($file_type, false ) .
								", " . real_mysql_specialchars($file_size, true ) .																
								", " . real_mysql_specialchars($upload_time, false ) .																								
								" ) ";
			real_execute_query( $file_query, $db_conn );
			$file_id = mysql_insert_id( $db_conn ) ;
			$file_name = $file_id . "_" . $file_name;
			print("<br>$file_name");
			if( real_update_file_type( $db_conn, $file_name, $file_id, $upload_location ) == true )
				return $file_id;
			else
				return 0;
		}
	}
	return 0;
}

/***************************************************************************************
function: real_delete_file
description: deletes the file from the database
params: 
	$db_conn - database link
	$pid - profile id
	$section_id - section id
	$file_id - file id
returns: nothing
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_delete_file( $db_conn, $file_id)
{
global $_home; 
$fileuploaddir = "/opt/www/html".$_home."/";

	$file_info = real_execute_query ("SELECT file_name, upload_location FROM gen_file_info WHERE file_id="
				.real_mysql_specialchars($file_id, true), $db_conn);
	while ($file = mysql_fetch_array ($file_info)) {
		$file_name = $file["file_name"];
		$upload_location = $file["upload_location"];
	}

	$file_query = "DELETE FROM gen_file_info WHERE file_id = " .
						real_mysql_specialchars($file_id, true );
	real_execute_query( $file_query, $db_conn );

	foreach( glob( $fileuploaddir.$upload_location.$file_name ) as $fn )
	{
		unlink( $fn );
	}
}

?>