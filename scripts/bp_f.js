var fpResultsSearch;

function processXML(obj, tbl)
{
    //alert("obj in proccess:"+obj);
    var root = obj.getElementsByTagName('pplc').item(0);
    fpMaxPageSearch = root.getAttribute('maxpage');
    fpPageSearch = root.getAttribute('pageno');

    fpResultsSearch.length = root.childNodes.length;
    if (fpResultsSearch.length < 1)
    {
        document.getElementById(tbl + "Row").innerHTML = "No results found for this search.";
        //document.getElementById(tbl + "Row").style.display = 'none';
        document.getElementById('actualTable').style.display = 'none';
           return;
    }


    var searchResultsTable = "<table style='border: 0px' width=100% cellspacing='0' cellpadding='0'>";
    // alert("after if");
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
 //alert("im here");
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
    //alert(searchResultsTable+" :search results table");
    //alert("fpResultsSearch :" +fpResultsSearch);
    document.getElementById(tbl+ "Row").innerHTML = searchResultsTable;
    document.getElementById(tbl + "Row").style.display = '';
    document.getElementById('actualTable').style.display = 'none';
}

function Find(firstname, lastname, dept, pageno, tbl)
{

    
    
  // var uri = "https://facultyprofile.txstate.edu/sections/gen_browse_search_profile.php?type=pplc&fname=" + firstname+"&lname=" + lastname;
	var uri  = "sections/gen_browse_search_profile.php?type=pplc&pageno="+pageno;

         
	if (firstname!= ""){
		uri += "&fname=" + firstname;
                	}
	if (lastname!= ""){
		uri += "&lname=" + lastname;
	}
	if(dept!= "" ){
		uri += "&deptsearch="+dept;
	}
       
    var xmlhttp;
 //alert("uri:"+uri);
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  //alert("inside if "+ xmlhttp);
// alert("xml start"+xmlhttp.responseText);
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   //alert("inside else "+ xmlhttp);
  }
    //xmlhttp.open("POST", uri, true);
        //xmlhttp.send(null);
       xmlhttp.open("GET", uri, true);

    xmlhttp.onreadystatechange = function()
    {

        if (xmlhttp.readyState==4)
        {
            //alert("xml state 4"+xmlhttp.responseText);

            if( xmlhttp.status == 200 )
            {
                          // alert("xml state 200"+xmlhttp.responseText);
                          // alert("inside state 200");
                fpResultsSearch = new Array();
                                //alert("fpresults:"+fpResultsSearch);
                //alert("xml end"+xmlhttp.responseText);
                //alert("tb1 is:"+tbl);
                   //alert("before process xml:"+xmlhttp.responseXML);
                processXML(xmlhttp.responseXML, tbl);


                //alert("x is: "+x);
                //alert("after process xml:"+xmlhttp.responseXML);

            }
            else
            {

                //alert( "Unable to perform search. HTTP response code : " + xmlhttp.status );
            }
        }
    }
         //xmlhttp.open("GET", uri, true);
    xmlhttp.send(null);
}
function FindProfiles()
{
    firstname = document.getElementById("bpFName").value;
    lastname = document.getElementById("bpLName").value;
    deptsearch=document.getElementById("deptsearch").value;

    firstname = firstname.replace(/^\s*|\s*$/g,"");
    lastname = lastname.replace(/^\s*|\s*$/g,"");
    deptsearch = deptsearch.replace(/^\s*|\s*$/g,"");

    if ((firstname != "") || (lastname != "") || deptsearch != "")
        {
       // alert("in find profiles");
        Find(firstname, lastname, deptsearch, 0, "bpResults");
         }
     /* if((firstname != "") || (lastname != "") ||(deptsearch!=""))
         {
          Find(firstname, lastname, deptsearch, 0, "bpResults");
         }*/

    else
    {
        //alert("none");
        document.getElementById("bpNameResultsRow").innerHTML = "";
        document.getElementById("bpNameResultsRow").style.display = 'none';
        document.getElementById("actualTable").style.display = '';
    }
}

function FindDepartment()
{
   // alert("in department function");
    deptsearch=document.getElementById("deptsearch").value;
	deptsearch = deptsearch.replace(/^\s*|\s*$/g,"");
    if(deptsearch!="")
    {
      // alert("deptsearch="+deptsearch);
        Find("", "", deptsearch, 0, "bpResults");
    }
    else
    {
        //alert("none");
        document.getElementById("bpResultsRow").innerHTML = "";
        document.getElementById("bpResultsRow").style.display = 'none';
        document.getElementById("actualTable").style.display = '';
    }
}

/*function FindDept(deptsearch, pageno, tbl)
{
    //var uri="https://facultyprofile.txstate.edu/sections/Names.php?hid=16";

    var uri= "https://facultyprofile.txstate.edu/sections/gen_browse_search_profile.php?type=pplc&deptsearch="+deptsearch;

   // alert(uri+ "uri");

var xmlhttp;

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  //alert("inside if "+ xmlhttp);
  //alert("xml start"+xmlhttp.responseText);
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  // alert("inside else "+ xmlhttp);
  }
    //xmlhttp.open("POST", uri, true);
        //xmlhttp.send(null);
       xmlhttp.open("GET", uri, true);

    xmlhttp.onreadystatechange = function()
    {

        if (xmlhttp.readyState==4)
        {
            //alert("xml state 4"+xmlhttp.responseText);

            if( xmlhttp.status == 200 )
            {
                           //alert("xml state 200"+xmlhttp.responseText);
                          // alert("inside state 200");
                fpResultsSearch = new Array();
                                //alert("fpresults:"+fpResultsSearch);
                //alert("xml end"+xmlhttp.responseText);
                //alert("tb1 is:"+tbl);
                   //alert("before process xml:"+xmlhttp.responseXML);
                processXML(xmlhttp.responseXML, tbl);
                                //alert("after process xml:"+xmlhttp.responseXML);
                       //alert("deptsearch="+deptsearch);
            }
            else
            {

                //alert( "Unable to perform search. HTTP response code : " + xmlhttp.status );
            }
        }
    }
         //xmlhttp.open("GET", uri, true);
    xmlhttp.send(null);
}*/