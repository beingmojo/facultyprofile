<?php
$db_conn = mysql_connect("tag305871", "testuser", "testpass");
mysql_select_db( "test", $db_conn ); //select database
if(isset($_GET['id'])) { //session attribute or so
    $id    = $_GET['id'];
    $query = "SELECT name, type, size, content " .
            "FROM upload WHERE id = '" . $id . "'";
    $result = mysql_query($query);// or die('Error, query failed');
    list($name, $type, $size, $content) =  mysql_fetch_array($result);
    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=$name");
    echo $content;
}else {
    echo "isset(GET['id']) returned false";
}
//close database connection
mysql_close($db_conn);
?>
