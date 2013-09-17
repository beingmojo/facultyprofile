<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once '../utils.php';
echo 'start</br>';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
$qry = "show variables like 'char%'";
$result = real_execute_query($qry, $db_conn);

echo "<table>";
while ($row = mysql_fetch_array($result)) {
    echo "<tr>";
    echo "<td>";
    echo $row[0];
    echo "</td>";
    echo "<td>";
    echo $row[1];
    echo "</td>";
    echo "</tr>";
}
echo "</table>";

echo "</br>";
$text = "&<p>First <strong>J</strong>oined paragraph</p><p>Second <strong>J</strong>oined paragraph</p>";
echo "$text</br>";
echo real_filter($text)."</br>";
echo real_mysql_specialchars($text, false)."</br>";
?>