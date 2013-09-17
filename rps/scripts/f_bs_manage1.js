var pid = 0;
var fpResultsSearch;

function processXML(obj, tbl)
{
	var root = obj.getElementsByTagName('pplc').item(0);
	fpMaxPageSearch = root.getAttribute('maxpage');
	fpPageSearch = root.getAttribute('pageno');

	fpResultsSearch.length = root.childNodes.length;
	//fpNoOfRowsSearch = root.childNodes.length;
	
	if (fpResultsSearch.length < 1)
	{
		//alert("No results found for this search.");
		document.getElementById(tbl).innerHTML = "";
		document.getElementById(tbl).style.display = 'none';	
		return;
	}
	
	var searchResultsTable = "<table style='border: 0px' width=100% cellspacing='0' cellpadding='0'>";

	for (var i = 0; i < root.childNodes.length; i++) 
	{
	    var node = root.childNodes.item(i);
		fpResultsSearch[i] = new Array(node.childNodes.length);
		for (var j = 0; j < node.childNodes.length; j++) 
		{
			var child = node.childNodes.item(j);
			fpResultsSearch[i][j]= (child.childNodes.length == 0 ) ? "" : child.childNodes.item(0).data;
		}
	}
	
	for (var i = 0; i < root.childNodes.length; i++) 
	{
		searchResultsTable += "<tr style='background: #eee; font-family: Verdana; cursor: pointer;'>";
		searchResultsTable += "<td onclick=\"pid=" + fpResultsSearch[i][2] + ";document.getElementById('" + tbl + "').style.display = 'none';document.getElementById('pi_name').value = '" + fpResultsSearch[i][0] + "';\">" +  
				fpResultsSearch[i][0] + "</td>";
		searchResultsTable += "</tr>";
	}
	searchResultsTable += "</table>";
	//alert(searchResultsTable);
	document.getElementById(tbl).innerHTML = searchResultsTable;
	document.getElementById(tbl).style.display = '';
} 

function getHTTPObject() 
{
	var xmlhttp = false;
	var ie5=document.all&&document.getElementById;
	var ns6=document.getElementById&&!document.all;
	
	if( ns6 )
	{
		try 
		{
			xmlhttp = new XMLHttpRequest();
		} 
		catch (e) 
		{
			xmlhttp = false;
		}
	}
	else
	{
		try 
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch (E) 
		{
			xmlhttp = false;
		}
	}
	return xmlhttp;
}

function Find(firstname, lastname, dept, pageno, tbl)
{
	//alert("inside find");
	var uri = "sections/gen_browse_search_profile.php?type=pplc&fname=" + firstname + "&lname=" + lastname;	
	if (dept != '')
		uri += "&dept=" + dept;
	var xmlhttp = getHTTPObject();
	xmlhttp.open("GET", uri, true);
	xmlhttp.onreadystatechange = function() 
	{
		if (xmlhttp.readyState==4) 
		{
			if( xmlhttp.status == 200 )
			{
				fpResultsSearch = new Array();
				//alert(xmlhttp.responseText);
				processXML(xmlhttp.responseXML, tbl);
			}
			else
			{
				alert( "Unable to perform search. HTTP response code : " + xmlhttp.status );
			}
		}
	}
	xmlhttp.send(null);
}

function FindProfiles(dept)
{
	fullname = document.getElementById("pi_name").value;
	var name_array = fullname.split(",");
	if (name_array[1] != null)
		firstname = name_array[1];
	else
		firstname = "";
	if (name_array[0] != null)
		lastname = name_array[0];
	else
		lastname = fullname;
	
	firstname = firstname.replace(/^\s*|\s*$/g,"");
	lastname = lastname.replace(/^\s*|\s*$/g,"");
	
	if ((firstname != "") || (lastname != ""))
		Find(firstname, lastname, dept, 1, "piResults");
	else
	{
		document.getElementById("piResults").innerHTML = "";
		document.getElementById("piResults").style.display = 'none';
	}
}
