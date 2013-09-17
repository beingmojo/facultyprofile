<?php
//Path where all uploaded files are going to be placed
$_target_path = "C:/Program Files/Apache Software Foundation/Apache2.2/htdocs/rps/uploads/";
/* Add the original filename to our target path. Result is "$_target_path/filename.extension" */
$target_path = $_target_path . basename( $_FILES['uploadedfile']['name']);
/*Now all we have to do is call the move_uploaded_file function and let PHP do its magic.
 *The move_uploaded_file function needs to know 1) The path of the temporary file (check!).
  2) The path where it is to be moved to (check!). */
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "The file ".  basename( $_FILES['uploadedfile']['name']). " has been uploaded";
}else {
    echo "There was an error uploading the file, please try again!";
}
?>
