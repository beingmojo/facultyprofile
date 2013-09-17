<?php
require_once('../lib/nusoap.php'); 
require_once('wsconfig.php'); 
header("Content-Type: text/xml");



$client=new nusoap_client($wsdl_url, 'wsdl');


//Changes for XML input starts
$param=array(
'qstr'=>$_REQUEST['qstr']
);
//Changes for XML input ends

if (!$dom = domxml_open_mem($_REQUEST['qstr'])) {
  echo "Error while parsing the document\n";
  exit;
}

$root = $dom->document_element();

$node_array = $root->get_elements_by_tagname('key');


if ($node_array)
{
   if( $node_array[0]->get_content() == "*" || $node_array[0]->get_content() == "")
   {
   	$result =  $client->call('Browse', $param);
   }
   else
   	$result =  $client->call('Search', $param);
   
}
else
{
    echo "Error";
}

echo $result;
?>