<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>rps.test: File Download</title>
    </head>
    <body>
        <?php
        $db_conn = mysql_connect("tag305871", "rpsadmin", "rpsadminpass");
        mysql_select_db( "rps", $db_conn );
        $query = "SELECT pid, section_id, image_id FROM gen_image_info";
        $result = mysql_query($query);
        $errmsg = mysql_error( $db_conn );
        if ($errmsg == "") {
        }else {
            echo "<br /> $errmsg";
        }
        if(mysql_num_rows($result) == 0) {
            echo "Database is empty <br>";
        }else {
            while(list($pid, $section_id, $image_id) =
            mysql_fetch_array($result)) {
                print("<a href=\"file_download2.php?" .
                                "pid=" . $pid .
                                "&section_id=" . $section_id .
                                "&image_id=" . $image_id .
                                "\">" . "Load Image</a> <br />");
            }
        }
        mysql_close($db_conn);
        ?>
    </body>
</html>
