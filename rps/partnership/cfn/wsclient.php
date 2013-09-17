<?php
require_once('../lib/nusoap.php'); 
require_once('wsconfig.php');
header("Content-Type: text/xml");



$client=new soapclient($wsdl_url, 'wsdl');

//Changes for XML input starts
$param=array(
'qstr'=>$_GET['qstr']
);
//Changes for XML input ends

$result =  $client->call('Search', $param);

//$result = "<error><msg>Invalid Key</msg></error>";
echo $result;
?>


