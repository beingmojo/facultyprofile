<?php
/*Upload file into MySQL:
 * ====================== */
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];
    echo "Upload: " . $_FILES["userfile"]["name"] . "<br />";
    echo "Type: " . $_FILES["userfile"]["type"] . "<br />";
    echo "Size: " . ($_FILES["userfile"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["userfile"]["tmp_name"];
    echo "<br />";
    echo "Opening file...<br />";
    $fp      = fopen($tmpName, 'r'); //fopen -- file open, r -- read flag
    $content = fread($fp, filesize($tmpName)); //fread -- file read
    fclose($fp); //fclose -- file close
    if(!get_magic_quotes_gpc()) {
        $fileName = addslashes($fileName); //escape the file's name
        $content = addslashes($content); //escape the file's content
    }
    //connect to database
    $db_conn = mysql_connect("tag305871", "testuser", "testpass");
    mysql_select_db( "test", $db_conn ); //select database
    $query = "INSERT INTO upload (name, size, type, content ) ".
            "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
    mysql_query($query);// or die('Error, query failed');
    $errmsg = mysql_error( $db_conn );
    //close database connection
    mysql_close($db_conn);
    if ($errmsg == "") {
        echo "<br />File $fileName uploaded successfully<br />";
    }else {
        echo "<br /> $errmsg";
    }
}
/*Before you do anything with the uploaded file. You should not assume that the
 * file was uploaded successfully to the server. Always check to see if the file
 * was successfully uploaded by looking at the file size. If it's larger than
 * zero byte then we can assume that the file is uploaded successfully.
 * PHP saves the uploaded file with a temporary name and save the name in
 * $_FILES['userfile']['tmp_name']. Our next job is to read the content of this
 * file and insert the content to database. Always make sure that you use
 * addslashes() to escape the content. Using addslashes() to the file name is
 * also recommended because you never know what the file name would be.
 * That's it now you can upload your files to MySQL. Now it's time to write the
 * script to download those files.
 * Download file from MySQL:
 * =========================
 * See file_db_download.php */
print"<p><input type=\"button\" name=\"back\" value=\"Go Back\" onclick=\"history.go(-1);return true;\"></p>";
?>
