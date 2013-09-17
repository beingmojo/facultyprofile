<?php
$db_conn = mysql_connect("tag305871", "rpsadmin", "rpsadminpass");
mysql_select_db( "rps", $db_conn ); //select database
if(isset($_GET['idpubc'])) { //session attribute or so
    $idpubc    = $_GET['idpubc'];
    $query = "SELECT pid, pubc " .
            "FROM txst_fac_profl WHERE pid = '" . $idpubc . "'";
    $result = mysql_query($query);// or die('Error, query failed');
    list($pid, $pubc) =  mysql_fetch_array($result);
    header("Content-length: 900000000"); //just some file size
    //.doc type:
    header("Content-type: application/vnd.openxmlformats-officedocument.".
            "wordprocessingml.document");
    //filename:
    header("Content-Disposition: attachment; filename=". $pid . "-pubc.doc");
    echo $pubc;
}else {
    echo "isset(GET['idpubc']) returned false";
}
//close database connection
mysql_close($db_conn);
?>
