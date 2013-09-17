<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!--TUTORIAL LINK:
    http://www.php-mysql-tutorial.com/wikis/mysql-tutorials/uploading-files-to-mysql-database.aspx
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>rps.test: File DB Download</title>
    </head>
    <body>
        <!--Download file from MySQL:
            =========================
            When we upload a file to database we also save the file type and
            length. These were not needed for uploading the files but is needed
            for downloading the files from the database. This page lists file
            names stored in database. The names are printed as a url.
            The url would look like: file_db_download2.php?id=3
        -->
        <?php
        $db_conn = mysql_connect("tag305871", "testuser", "testpass");
        mysql_select_db( "test", $db_conn ); //select database
        /*When you click the download link, the $_GET['id'] will be set. We
          can use this id in file_db_download2.php to identify which files to
          get from the database. Below is the code for downloading files from
          MySQL Database: */
        $query = "SELECT id, name FROM upload";
        $result = mysql_query($query); // or die('Error, query failed');
        $errmsg = mysql_error( $db_conn );
        if ($errmsg == "") {
//            echo "<br />File $fileName uploaded successfully<br />";
        }else {
            echo "<br /> $errmsg";
        }
        if(mysql_num_rows($result) == 0) {
            echo "Database is empty <br>";
        }
        else {
            while(list($id, $name) = mysql_fetch_array($result)) {
                print("<a href=\"file_db_download2.php?id=" . $id .$name ."\">".
                                "click here</a> <br />");
            }
        }
        //close database connection
        mysql_close($db_conn);
        ?>
        <!--Before sending the file content using echo first we need to set
            several headers. They are :
            1. header("Content-length: $size") -- This header tells the browser
               how large the file is. Some browser need it to be able to
               download the file properly. Anyway it's a good manner telling how
               big the file is. That way anyone who download the file can
               predict how long the download will take.
            2. header("Content-type: $type") -- This header tells the browser
               what kind of file it tries to download.
            3. header("Content-Disposition: attachment; filename=$name"); --
               Tells the browser to save this downloaded file under the
               specified name. If you don't send this header the browser will
               try to save the file using the script's name (download.php).
            After sending the file the script stops executing by calling exit.
            NOTE : When sending headers the most common error message you will
                   see is something like this : Warning: Cannot modify header
                   information - headers already sent by (output started at
                   C:\Webroot\library\config.php:7) in C:\Webroot\download.php
                   on line 13 -- This error happens because some data was
                   already sent before we send the header. As for the error
                   message above it happens because i "accidentally" add one
                   space right after the PHP closing tag ( ?> )  in config.php
                   file. So if you see this error message when you're sending a
                   header just make sure you don't have any data sent before
                   calling header(). Check the file mentioned in the error
                   message and go to the line number specified.
        -->
    </body>
</html>
