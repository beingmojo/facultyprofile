<?php
function returnimages($dirname=".") {
    $db_conn = mysql_connect("tag305871","rpsadmin","rpsadminpass","rps");
    mysql_select_db( "rps", $db_conn );
    $queryDesignation = "select name from gen_profile_info6q where pid = '";
    $queryInterests = "select r_int from txst_fac_profl where pid = '";
    $pattern="(\.jpg$)|(\.JPG$)|(\.jpeg$)|(\.JPEG$)|(\.gif$)|(\.GIF$)|" .
            "(\.png$)|(\.PNG$)"; //valid image extensions
    $files = array();
    $curimage=0;
    if($handle = opendir($dirname)) {
        while(false !== ($file = readdir($handle))) {
            if(eregi($pattern, $file)) { //if this file is a valid image
                //get the pid:
                $pid = substr($file, 0, strpos($file, "_"));
                $echoString = 'galleryarray['.$curimage.']="' . $file . ",";
                $query = $queryDesignation . $pid . "'";
                $result = mysql_query($query);
                $errmsg = mysql_error( $db_conn );
                if ($errmsg == "") {
                    $echoString = "no";
                }else {
                    $echoString = $errmsg;
                }
                if(mysql_num_rows($result) == 0) {
                    $echoString .= $query;
                }else {
                    if (list($name) = mysql_fetch_array($result)) {
                        $echoString .= $name;
                    }else {
                        $echoString .= "as";
                    }
                }
                $echoString .= ",";
                $query = $queryInterests . $pid . "'";
                $result = mysql_query($query);
                $errmsg = mysql_error( $db_conn );
                if ($errmsg == "") {
                }else {
//                    echo "<br /> $errmsg";
                }
                if(mysql_num_rows($result) == 0) {
                    $echoString .= "";
                }else {
                    if (list($r_int) = mysql_fetch_array($result)) {
                        $echoString .= "<br />" . $r_int;
                    }else {
                        $echoString .= "";
                    }
                }
                //close database connection
                mysql_close($db_conn);
                //Output it as a JavaScript array element
                echo $echoString . '";';
                $curimage++;
            }
        }
        closedir($handle);
    }
    return($files);
}
echo 'var galleryarray=new Array();'; //Define array in JavaScript
returnimages() //Output the array elements containing the image file names
        ?>
