
<?php require_once('Connections/dbc.php');




//check security code
$codecheck = mysql_query("SELECT SecurityCode FROM security where ID= 'osp_irb'") or die(mysql_error());
$info = mysql_fetch_array( $codecheck ))

echo $info['SecurityCode'];


?>
