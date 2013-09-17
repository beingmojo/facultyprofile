<?php
require_once('../lib/nusoap.php'); 
require_once('wsconfig.php');
header("Content-Type: text/xml");



$client=new nusoap_client($wsdl_url, 'wsdl');


//Changes for XML input starts
$param=array(
'qstr'=>$_GET['qstr']
);
//Changes for XML input ends


$result =  $client->call('Search', $param);
echo $result;


?>