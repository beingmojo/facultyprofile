<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!--TUTORIAL LINK:
    http://www.php-mysql-tutorial.com/wikis/mysql-tutorials/uploading-files-to-mysql-database.aspx
-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>rps.test: File DB Download RPS</title>
    </head>
    <body>
        <?php
        $db_conn = mysql_connect("tag305871", "rpsadmin", "rpsadminpass");
        mysql_select_db( "rps", $db_conn ); //select database
        $query = "SELECT pid FROM gen_image_info";
        $result = mysql_query($query); // or die('Error, query failed');
        $errmsg = mysql_error( $db_conn );
        if ($errmsg == "") {
        }else {
            echo "<br /> $errmsg";
        }
        if(mysql_num_rows($result) == 0) {
            echo "Database is empty <br>";
        }
        else {
            while(list($id) = mysql_fetch_array($result)) {
                print("<a href=\"file_db_download_rps_image2.php?id=" . $id ."\">".
                                "Load Image</a>");
                print("<br />");
            }
        }
        //close database connection
        mysql_close($db_conn);
        ?>
    </body>
</html>
