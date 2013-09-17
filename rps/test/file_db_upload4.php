<?php
/*Upload multiple files into MySQL:
 * ================================ */
if(isset($_POST['upload'])) {
    //first file
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];
    echo "Upload: " . $_FILES["userfile"]["name"] . "<br />";
    echo "Type: " . $_FILES["userfile"]["type"] . "<br />";
    echo "Size: " . ($_FILES["userfile"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["userfile"]["tmp_name"]. "<br />";
    //second file
    $fileName2 = $_FILES['userfile2']['name'];
    $tmpName2  = $_FILES['userfile2']['tmp_name'];
    $fileSize2 = $_FILES['userfile2']['size'];
    $fileType2 = $_FILES['userfile2']['type'];
    echo "Upload2: " . $_FILES["userfile2"]["name"] . "<br />";
    echo "Type2: " . $_FILES["userfile2"]["type"] . "<br />";
    echo "Size2: " . ($_FILES["userfile2"]["size"] / 1024) . " Kb<br />";
    echo "Stored in2: " . $_FILES["userfile2"]["tmp_name"]. "<br />";
    //third file
    $fileName3 = $_FILES['userfile3']['name'];
    $tmpName3  = $_FILES['userfile3']['tmp_name'];
    $fileSize3 = $_FILES['userfile3']['size'];
    $fileType3 = $_FILES['userfile3']['type'];
    echo "Upload3: " . $_FILES["userfile3"]["name"] . "<br />";
    echo "Type3: " . $_FILES["userfile3"]["type"] . "<br />";
    echo "Size3: " . ($_FILES["userfile3"]["size"] / 1024) . " Kb<br />";
    echo "Stored in3: " . $_FILES["userfile3"]["tmp_name"]. "<br />";
    //open the files
    echo "Opening files...<br />";
    //first one
    $fp      = fopen($tmpName, 'r'); //fopen -- file open, r -- read flag
    $content = fread($fp, filesize($tmpName)); //fread -- file read
    fclose($fp); //fclose -- file close
    if(!get_magic_quotes_gpc()) {
        $fileName = addslashes($fileName); //escape the file's name
        $content = addslashes($content); //escape the file's content
    }
    //second
    $fp2      = fopen($tmpName2, 'r'); //fopen -- file open, r -- read flag
    $content2 = fread($fp2, filesize($tmpName2)); //fread -- file read
    fclose($fp2); //fclose -- file close
    if(!get_magic_quotes_gpc()) {
        $fileName2 = addslashes($fileName2); //escape the file's name
        $content2 = addslashes($content2); //escape the file's content
    }
    //third
    $fp3      = fopen($tmpName3, 'r'); //fopen -- file open, r -- read flag
    $content3 = fread($fp3, filesize($tmpName3)); //fread -- file read
    fclose($fp3); //fclose -- file close
    if(!get_magic_quotes_gpc()) {
        $fileName3 = addslashes($fileName3); //escape the file's name
        $content3 = addslashes($content3); //escape the file's content
    }
    //connect to database
    $db_conn = mysql_connect("tag305871", "testuser", "testpass");
    mysql_select_db( "test", $db_conn ); //select database
    //insert into database
    //first
    $query = "INSERT INTO upload (name, size, type, content ) ".
            "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";
    mysql_query($query);// or die('Error, query failed');
    $errmsg = mysql_error( $db_conn );
    //second
    $query2 = "INSERT INTO upload (name, size, type, content ) ".
            "VALUES ('$fileName2', '$fileSize2', '$fileType2', '$content2')";
    mysql_query($query2);// or die('Error, query failed');
    $errmsg2 = mysql_error( $db_conn );
    //third
    $query3 = "INSERT INTO upload (name, size, type, content ) ".
            "VALUES ('$fileName3', '$fileSize3', '$fileType3', '$content3')";
    mysql_query($query3);// or die('Error, query failed');
    $errmsg3 = mysql_error( $db_conn );
    //close database connection
    mysql_close($db_conn);
    //first message
    if ($errmsg == "") {
        echo "<br />File $fileName uploaded successfully<br />";
    }else {
        echo "<br /> $errmsg";
    }
    //second
    if ($errmsg2 == "") {
        echo "<br />File $fileName2 uploaded successfully<br />";
    }else {
        echo "<br /> $errmsg2";
    }
    //third
    if ($errmsg3 == "") {
        echo "<br />File $fileName3 uploaded successfully<br />";
    }else {
        echo "<br /> $errmsg3";
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
