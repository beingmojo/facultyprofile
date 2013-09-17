<?php
/*TUTORIAL LINK:
    http://www.javascriptkit.com/javatutors/externalphp2.shtml
    http://www.javascriptkit.com/javatutors/externalphp.shtml
*/
//PHP SCRIPT: getimages.php
//Header("content-type: application/x-javascript");

//This function gets the file names of all images in the current directory
//and ouputs them as a JavaScript array
function returnimages($dirname="../images/128") {
    $db_conn = mysql_connect("tag306380","rpsadmin","rpsadminpass","rps");
    mysql_select_db( "rps", $db_conn );
    $queryDesignation = "select name from gen_profile_info where pid = '";
    $queryInterests = "select r_int from txst_fac_profl where pid = '";
    $pattern="(\.jpg$)|(\.JPG$)|(\.jpeg$)|(\.JPEG$)|(\.gif$)|(\.GIF$)|" .
            "(\.png$)|(\.PNG$)"; //valid image extensions
    $files = array();
    $curimage=0;
    if($handle = opendir($dirname)) {
        while(false !== ($file = readdir($handle))) {
            $pid = "";
            $echoString = "";
            $query = "";
            $result = "";
            $errmsg = "";
            if(eregi($pattern, $file)) { //if this file is a valid image
                //get the pid:
                $pid = substr($file, 0, strpos($file, "_"));
                $echoString = 'galleryarray['.$curimage.']="' . $file . ",";
                $query = $queryDesignation . $pid . "'";
                $result = mysql_query( $query );
                $errmsg = mysql_error( $db_conn );
                if ($errmsg == "") {
                }else {
                    $echoString = $errmsg;
                }
                if(mysql_num_rows($result) == 0) {
                    $echoString .= "";
                }else {
                    if (list($name) = mysql_fetch_array($result)) {
                        $echoString .= str_replace  ( ",", "", $name );
                    }else {
                        $echoString .= "";
                    }
                }
                $echoString .= ",";
                $query = $queryInterests . $pid . "'";
                $result = mysql_query($query);
                $errmsg = mysql_error( $db_conn );
                if ($errmsg == "") {
                }else {
                    $echoString = $errmsg;
                }
                if(mysql_num_rows($result) == 0) {
                    $echoString .= "";
                }else {
                    if (list($r_int) = mysql_fetch_array($result)) {
                        $echoString .= str_replace  (",", "", $r_int );
                    }else {
                        $echoString .= "";
                    }
                }
                //Output it as a JavaScript array element
                echo $echoString . '";';
                $curimage++;
            }
        }
        closedir($handle);
    }
    //close database connection
    mysql_close($db_conn);
    return($files);
}
echo 'var galleryarray=new Array();'; //Define array in JavaScript
returnimages() //Output the array elements containing the image file names
        ?>
