<?php

function mysqlConnect(){
    $mysqli = new mysqli("localhost", "ys11", "profilesystempass", "newprofile");

    if($mysqli->connect_errno){
        printf("Connection failed %s\n", $mysqli->connect_error);
        exit();
    }

    if(!$mysqli->set_charset("utf8")){
        echo "Error setting the character set utf8: " . $mysqli->error;
        exit();
    }

    return $mysqli;
}

?>
