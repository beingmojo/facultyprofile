<?php
$db_conn = mysql_connect("tag305871", "rpsadmin", "rpsadminpass");
mysql_select_db( "rps", $db_conn ); //select database
if(isset($_GET['idcv'])) { //session attribute or so
    $idcv    = $_GET['idcv'];
    $query = "SELECT pid, cv " .
            "FROM txst_fac_profl WHERE pid = '" . $idcv . "'";
    $result = mysql_query($query);// or die('Error, query failed');
    list($pid, $cv) =  mysql_fetch_array($result);
    header("Content-length: 900000000"); //just some file size
    //.doc type:
    header("Content-type: application/vnd.openxmlformats-officedocument.". 
            "wordprocessingml.document");
    //filename:
    header("Content-Disposition: attachment; filename=". $pid . "-cv.doc");
    echo $cv;
}else {
    echo "isset(GET['idcv']) returned false";
}
//close database connection
mysql_close($db_conn);
?>
