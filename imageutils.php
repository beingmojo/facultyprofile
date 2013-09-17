<?php
function real_update_image( $db_conn, $pid, $section_id, $fieldname, $image_id, $rel_path ) {
    return real_update_image_type( $db_conn, $pid, $section_id, $fieldname, $image_id, $rel_path, "all" );
}

function real_insert_image( $db_conn, $pid, $section_id, $fieldname, $rel_path ) {
    return real_insert_image_type( $db_conn, $pid, $section_id, $fieldname, $rel_path, "all" );
}

/***************************************************************************************
function: real_update_image_type
description: Converts all updadted images to jpeg or png and resizes with resampling
params: 
	$db_conn - database link
	$pid - profile id	
	$section_id - Section id of the section to which it belongs
	$fieldname - Field name of the upload field in the form
	$image_id - The ID of the image which needs to be updated
	$type - "all", "banner", or "logo"
returns: true if the user has edit rights, else false
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_update_image_type( $db_conn, $pid, $section_id, $fieldname, $image_id, $rel_path, $type ) {
    if( $_FILES ) {
        if( is_uploaded_file( $_FILES[$fieldname]["tmp_name"] ) ) {
            $tempname = $_FILES[$fieldname]['tmp_name'];
            $imagefile = addslashes( fread( fopen( $_FILES[$fieldname]["tmp_name"], "r" ), filesize( $_FILES[$fieldname]["tmp_name"] ) ) );
            $file_name = $_FILES[$fieldname]["name"];
            $file_size = $_FILES[$fieldname]["size"];
            $file_type = $_FILES[$fieldname]["type"];

            //retrieve image info
            $imginfo = getimagesize($tempname);

            //handle image according to type
            switch ($imginfo[2]) {
                case 1: //gif
                //set image type to gif
                    $srcimg=imagecreatefromgif($tempname);
                    break;
                case 2: //jpeg
                    $srcimg=imagecreatefromjpeg($tempname);
                    break;
                case 3: //png
                    $srcimg=imagecreatefrompng($tempname);
                    break;
                default:
                    return 0;
            }
            //set new sizes as you want them
            $imagesx = imagesx( $srcimg );
            $imagesy = imagesy( $srcimg );
            if( $type == "all" || $type == "logo" ) {
                $new_width_1 = $imagesx > $imagesy ? 128 : intval( $imagesx * 128 / $imagesy );
                $new_height_1 = $imagesx > $imagesy ? intval( $imagesy * 128 / $imagesx ) : 128;
            }
            if( $type == "banner" ) {
                $new_width_1 = ( $imagesx / 468 ) > ( $imagesy / 60 ) ? 468 : intval( $imagesx * 60 / $imagesy );
                $new_height_1 = ( $imagesx / 468 ) > ( $imagesy / 60 ) ? intval( $imagesy * 468 / $imagesx ) : 60;
            }
            if( $type == "all" ) {
                $new_width_2 = $imagesx > $imagesy ? 48 : intval($imagesx * 48 / $imagesy );
                $new_height_2 = $imagesx > $imagesy ? intval( $imagesy * 48 / $imagesx ) : 48;
            }
            $quality = 100;
            $image_name = $pid."_" .$section_id."_".$image_id.".";
            $file_type= "jpg";

            if( $type == "all" ) {
                imagejpeg($srcimg,"$rel_path/0/".$image_name.$file_type);

                $destimg2=imagecreatetruecolor($new_width_2,$new_height_2);
                imagecopyresampled($destimg2,$srcimg,0,0,0,0,$new_width_2,$new_height_2,imagesx($srcimg),imagesy($srcimg));
                imagejpeg($destimg2,"$rel_path/48/".$image_name.$file_type);
                imagedestroy( $destimg2 );
            }
            if( $type == "all" || $type == "logo" ) {
                $destimg1=imagecreatetruecolor($new_width_1,$new_height_1);
                imagecopyresampled($destimg1,$srcimg,0,0,0,0,$new_width_1,$new_height_1,imagesx($srcimg),imagesy($srcimg));
                imagejpeg($destimg1,"$rel_path/128/".$image_name.$file_type);
                imagedestroy( $destimg1 );
            }
            if( $type == "banner" ) {
                $destimg1=imagecreatetruecolor($new_width_1,$new_height_1);
                imagecopyresampled($destimg1,$srcimg,0,0,0,0,$new_width_1,$new_height_1,imagesx($srcimg),imagesy($srcimg));
                imagejpeg($destimg1,"$rel_path/0/".$image_name.$file_type);
                imagedestroy( $destimg1 );
            }

            imagedestroy( $srcimg );
            return true;
        }
    }
    return false;
}

/***************************************************************************************
function: real_insert_image_type
description: inserts the image into the database
params: 
	$db_conn - database link
	$pid - profile id
	$fieldname - image file field name specified in the html file
	$type - "all", "banner", or "logo"
returns: image id on success and 0 or failure
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_insert_image_type( $db_conn, $pid, $section_id, $fieldname, $rel_path, $type ) {
    if( $_FILES ) {
        if( is_uploaded_file( $_FILES[$fieldname]["tmp_name"] ) ) {
////////////////////////////altered to include 'image' /////////////////////////
            $image_query = "INSERT INTO gen_image_info(pid, section_id, image)
								VALUES(". 
                    real_mysql_specialchars($pid, true ) .
                    ", " . real_mysql_specialchars($section_id, true ) .
                    ", 0)";
            real_execute_query( $image_query, $db_conn );
            $image_id = mysql_insert_id( $db_conn ) ;

            if( real_update_image_type( $db_conn, $pid, $section_id, $fieldname, $image_id, $rel_path, $type ) == true )
                return $image_id;
            else
                return 0;
        }
    }
    return 0;
}

/***************************************************************************************
function: real_delete_image
description: deletes the image from the database
params: 
	$db_conn - database link
	$pid - profile id
	$section_id - section id
	$image_id - image id
returns: nothing
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_delete_image( $db_conn, $pid, $section_id, $image_id, $rel_path ) {
    $image_query = "DELETE FROM gen_image_info WHERE image_id = " .
            real_mysql_specialchars($image_id, true );
    real_execute_query( $image_query, $db_conn );
    foreach( glob( "$rel_path/128/".$pid."_".$section_id."_".$image_id.".jpg" ) as $fn ) {
        print( "$rel_path/128/".$pid."_".$section_id."_".$image_id.".jpg" );
        unlink( $fn );
    }
    foreach( glob( "$rel_path/48/".$pid."_".$section_id."_".$image_id.".jpg" ) as $fn ) {
        unlink( $fn );
    }
    foreach( glob( "$rel_path/0/".$pid."_".$section_id."_".$image_id.".jpg" ) as $fn ) {
        unlink( $fn );
    }
}

/***************************************************************************************
function: real_delete_section_images
description: deletes the image from the database
params: 
	$db_conn - database link
	$pid - profile id
	$section_id - section id
returns: nothing
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_delete_section_images( $db_conn, $pid, $section_id, $rel_path ) {
    $query = "DELETE FROM gen_image_info
				WHERE pid= " . real_mysql_specialchars( $pid, true ) .
            " AND section_id = " . real_mysql_specialchars( $section_id, true ) ;
    real_execute_query( $query, $db_conn );

    foreach( glob( "$rel_path/128/" . $pid . "_" . $section_id . "*.jpg" ) as $fn ) {
        unlink( $fn );
    }
    foreach( glob( "$rel_path/48/" . $pid . "_" . $section_id . "*.jpg" ) as $fn ) {
        unlink( $fn );
    }
    foreach( glob( "$rel_path/0/" . $pid . "_" . $section_id . "*.jpg" ) as $fn ) {
        unlink( $fn );
    }

}

/***************************************************************************************
function: real_delete_images
description: deletes the image from the database
params: 
	$db_conn - database link
	$pid - profile id
returns: nothing
on error: logs the error message and redirects to the error page
****************************************************************************************/
function real_delete_profile_images( $db_conn, $pid, $rel_path ) {
    $query = "DELETE FROM gen_image_info
				WHERE pid= " . real_mysql_specialchars( $pid, true ) ;
    real_execute_query( $query, $db_conn );

    foreach( glob( "$rel_path/128/" . $pid . "_*.jpg" ) as $fn ) {
        unlink( $fn );
    }
    foreach( glob( "$rel_path/48/" . $pid . "_*.jpg" ) as $fn ) {
        unlink( $fn );
    }
    foreach( glob( "$rel_path/0/" . $pid . "_*.jpg" ) as $fn ) {
        unlink( $fn );
    }

}

?>