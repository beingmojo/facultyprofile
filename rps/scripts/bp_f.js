
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
		document.getElementById(tbl + "Row").innerHTML = "";
		document.getElementById(tbl + "Row").style.display = 'none';	
		document.getElementById('actualTable').style.display = 'none';
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
		var class1 = '';
		if ((i%2)==0)
			class1='table_background_other';
		 else
			class1='table_background_viewedit';
		searchResultsTable += "<tr id=\"" + tbl + i + "\">";
		searchResultsTable += "<td><table width=100% border='0' cellspacing='0' cellpadding='2'><tr><td width='48' height='48' valign='middle' align='center' rowspan='2' class='" + class1 + "' style='border:1px solid white'>";
		if (fpResultsSearch[i][14] != '0')
		{
		searchResultsTable += "<img src=\"images/48/" + fpResultsSearch[i][2] + "_0_" + fpResultsSearch[i][14] + ".jpg\" border=0>";
		}
		searchResultsTable += "</td><td width='95%' class='" + class1 + "' style='border-top:1px solid white;border-left:1px solid white;border-right:1px solid white'><span class='font_topic'><a href=\"editprofile.php?pid=" + fpResultsSearch[i][2] + 
		"&onlyview=1\">" + fpResultsSearch[i][0] + "</a></span></td></tr><tr>" + 
		"<td id='secdetail' class='"+class1+"' style='border-bottom:1px solid white;border-left:1px solid white;border-right:1px solid white'><B>" + fpResultsSearch[i][1] + 
		"</B><br>Keywords: " + fpResultsSearch[i][15] + "</td></tr></table>" + "</td>";
		searchResultsTable += "</tr>";
	}
	searchResultsTable += "</table>";
	//alert(searchResultsTable);
	document.getElementById(tbl+ "Row").innerHTML = searchResultsTable;
	document.getElementById(tbl + "Row").style.display = '';
	document.getElementById('actualTable').style.display = 'none';
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
function Find(firstname, lastname, pageno, tbl)
{
	//alert("inside find");
	var uri = "sections/gen_browse_search_profile.php?type=pplc&fname=" + firstname + "&lname=" + lastname;
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
function FindProfiles()
{
	firstname = document.getElementById("bpFName").value;
	lastname = document.getElementById("bpLName").value;
	
	firstname = firstname.replace(/^\s*|\s*$/g,"");
	lastname = lastname.replace(/^\s*|\s*$/g,"");
	
	if ((firstname != "") || (lastname != ""))
		Find(firstname, lastname, 1, "bpResults");
	else
	{
		//alert("none");
		document.getElementById("bpResultsRow").innerHTML = "";
		document.getElementById("bpResultsRow").style.display = 'none';
		document.getElementById("actualTable").style.display = '';
	}
}
