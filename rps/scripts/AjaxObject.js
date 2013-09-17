//
// Ajax Objects
// AjaxPOST, AjaxGET
// Declare as object for multiple AJAX requests at the same time
// 
// Change log:
// 04/02/2007 Jonathan Baltazar - file created 


//
// AjaxPOST(String url, String parameters, function onIdle, function onResult, String [responseType 'XML' || 'text'])
// 
// Ex:
// var url = 'page.php';
// var parameters  = 'id=1&name=one';
// var onIdle = function() {
//		alert('waiting for response...');
// }
// var onResponse = function(responseXML) {
//		alert(responseXML.getElementsByTagName('name')[0].firstChild.data);
// }
// var responseType = 'XML';
// var ajaxPost = new AjaxPOST( url, parameters, onIdle, onResult, responseType );
//

function AjaxPOST( url, parameters, onIdle, onResult, responseType ) 
{
    var xmlHttpReq = false;
    var self = this;
    // Mozilla/Safari

    if (window.XMLHttpRequest) 
	{
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else 
		if (window.ActiveXObject) 
		{
			self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
		}
    self.xmlHttpReq.open('POST', url, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	self.xmlHttpReq.setRequestHeader("Content-length", parameters.length);
	self.xmlHttpReq.send(parameters);	
    self.xmlHttpReq.onreadystatechange = function() 
	{
		if (self.xmlHttpReq.readyState == 4) 
		{
			if(onResult)
			{
				if(responseType == "text")
					if(self.xmlHttpReq.responseText)
					{
						onResult(self.xmlHttpReq.responseText);
					}
				if(responseType == "XML")
					if(self.xmlHttpReq.responseXML)
					{
						
						onResult(self.xmlHttpReq.responseXML);
					}
			}
		}
    }
	
	if(onIdle)
		onIdle();
}


//
// AjaxGET(String uri, function onIdle, function onResult, String [responseType 'XML' || 'text'])
// 
// Ex:
// var uri = 'page.php?id=1&name=one';
// var onIdle = function() {
//		alert('waiting for response...');
// }
// var onResponse = function(responseXML) {
//		alert(responseXML.getElementsByTagName('name')[0].firstChild.data);
// }
// var responseType = 'XML';
// var ajaxGet = new AjaxGET( uri, onIdle, onResult, responseType );
//

function AjaxGET( uri, onIdle, onResult, responseType ) 
{
    var xmlHttpReq = false;
    var self = this;
    // Mozilla/Safari

    if (window.XMLHttpRequest) 
	{
        self.xmlHttpReq = new XMLHttpRequest();
    }
    // IE
    else 
		if (window.ActiveXObject) 
		{
			self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
		}
    self.xmlHttpReq.open('GET', uri, true);
    self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	self.xmlHttpReq.send(null);
    self.xmlHttpReq.onreadystatechange = function() 
	{
		if(onResult)
		{
			if (self.xmlHttpReq.readyState == 4) 
			{
				if(responseType == "text")
					if(self.xmlHttpReq.responseText)
					{
						onResult(self.xmlHttpReq.responseText);
					}
				if(responseType == "XML")
					if(self.xmlHttpReq.responseXML)
					{
						onResult(self.xmlHttpReq.responseXML);
					}
			}
		}
    }
	
	if(onIdle)
		onIdle();
}