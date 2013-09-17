<?php
include 'utils.php';

if(isset($_GET['pid']) && isset($_GET['section_id']) &&
        isset($_GET['image_id'])) {
/*    $pid = $_GET['pid'];
    $section_id = $_GET['section_id'];
    $image_id = $_GET['image_id'];
    header("Content-length: 1024000");
    header("Content-type: image/jpeg");
    header("Content-Disposition: attachment; filename=image.jpg");
    echo $content;
  */

    $path = $_SERVER['DOCUMENT_ROOT'] . "/rps/images/128";
    echo $path;
    echo "<br />";

    $dh = opendir($path);
    while (($file = readdir($dh)) != false) {
        echo "<a href=\"" . "/rps/images/128/" . $file . "\">$file</a><br />\n";
    }
    closedir($dh);
}else {
    echo "isset(GET['...']) returned false";
}
print"<p><input type=\"button\" name=\"back\" value=\"Go Back\" onclick=\"history.go(-1);return true;\"></p>";
?>
