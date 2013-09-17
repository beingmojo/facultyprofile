<?php
if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
}else {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["file"]["tmp_name"];
}
/* By using the global PHP $_FILES array you can upload files from a client
 * computer to the remote server.
 * The first parameter is the form's input name and the second index can be
 * either "name", "type", "size", "tmp_name" or "error". Like this:
 * $_FILES["file"]["name"] - the name of the uploaded file
 * $_FILES["file"]["type"] - the type of the uploaded file
 * $_FILES["file"]["size"] - the size in bytes of the uploaded file
 * $_FILES["file"]["tmp_name"] - the name of the temporary copy of the file
 * stored on the server $_FILES["file"]["error"] - the error code resulting from
 * the file upload. This is a very simple way of uploading files. For security
 * reasons, you should add restrictions on what the user is allowed to upload.
 * Restrictions on Upload:
 * =======================
 * In this script we add some restrictions to the file upload. The user may only
 * upload .gif or .jpeg files and the file size must be under 100 kb: *
 * Note:
 * =====
 * For IE to recognize jpg files the type must be pjpeg, for FireFox it must be
 * jpeg. */
echo "<br /><br />";
if ((($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/pjpeg"))
        && ($_FILES["file"]["size"] < 100000)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
    }else {
        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
        echo "Type: " . $_FILES["file"]["type"] . "<br />";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        echo "Stored in: " . $_FILES["file"]["tmp_name"];
    }
}else {
    echo "Invalid file";
}
/*Saving the Uploaded File:
 *=========================
 * The examples above create a temporary copy of the uploaded files in the PHP
 * temp folder on the server. The temporary copied files disappears when the
 * script ends. To store the uploaded file we need to copy it to a different
 * location: */
echo "<br /><br />";
//Path where all uploaded files are going to be placed
$_target_path = "C:/Program Files/Apache Software Foundation/Apache2.2/" .
                "htdocs/rps/uploads/";
if ((($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/pjpeg"))
        && ($_FILES["file"]["size"] < 100000)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }else {
        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
        echo "Type: " . $_FILES["file"]["type"] . "<br />";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
        if (file_exists($_target_path . $_FILES["file"]["name"])) {
            echo $_FILES["file"]["name"] . " already exists. ";
        }else {
            move_uploaded_file($_FILES["file"]["tmp_name"],
                    $_target_path . $_FILES["file"]["name"]);
            echo "Stored in: " . $_target_path . $_FILES["file"]["name"];
        }
    }
}else {
    echo "Invalid file";
}
?>
<p><input type="button" name="back" value="Go Back" onclick="history.go(-1);return true;"></p>
