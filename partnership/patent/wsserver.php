<?
require_once('../lib/nusoap.php'); 
require_once('wsconfig.php'); 
require_once('wsutils.php'); 



$server = new nusoap_server();
$server->configureWSDL($inst_abbr,$ns_url);
$server->wsdl->schemaTargetNamespace=$ns_url;


$server->register('Search',
			array('qstr'			=> 'xsd:string'),
			array('return'			=> 'xsd:string'),
			$ns_url);
			
function Search($qstr)
{
	$document = wsSearch($qstr);
	
	return new soapval('return','xsd:string',$document);
}



$server->register('Browse',
			array('qstr'			=> 'xsd:string'),
			array('return'			=> 'xsd:string'),
			$ns_url);
			
function Browse($qstr)
{
	$document = wsBrowse($qstr);
	
	return new soapval('return','xsd:string',$document);
}



$server->service($HTTP_RAW_POST_DATA);



?>