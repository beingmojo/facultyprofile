<?php
$db_conn = mysql_connect("tag305871", "rpsadmin", "rpsadminpass");
mysql_select_db( "rps", $db_conn ); //select database
if(isset($_GET['id'])) { //session attribute or so
    $id    = $_GET['id'];
    $query = "SELECT pid, image " .
            "FROM gen_image_info WHERE pid = '" . $id . "'";
    $result = mysql_query($query);// or die('Error, query failed');
    list($pid, $image) =  mysql_fetch_array($result);
    header("Content-length: 65555"); //just some file size
    //.jpg type:
    header("Content-type: image/jpeg");
    //filename:
    header("Content-Disposition: attachment; filename=". $pid . ".jpg");
    echo $image;
}else {
    echo "isset(GET['id']) returned false";
}
//close database connection
mysql_close($db_conn);
?>
