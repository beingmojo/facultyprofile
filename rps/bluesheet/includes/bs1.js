function d(el)
{
	return document.getElementById(el);
}

function ShowFind(el_id)
{
	d('find').style.display = '';
	var p = findPos(d('ciRank'));
	d('find').style.top = p[1] + 25 + 'px';
	d('find').style.left = p[0] + d(el_id).clientWidth + 'px';
	//d('find').style.top = (document.documentElement.clientHeight/2)- (d('find').clientHeight/2) + 300 + 'px';
	//d('find').style.left = (document.documentElement.clientWidth/2)- (d('find').clientWidth/2) + 'px';
    d('find').setAttribute('for', el_id);
}

 function findPos(obj) 
 {
 	var curleft = curtop = 0;
 	if (obj.offsetParent) 
 	{
 		curleft = obj.offsetLeft
 		curtop = obj.offsetTop
 		while (obj = obj.offsetParent) 
 		{
 			curleft += obj.offsetLeft
 			curtop += obj.offsetTop
 		}
 	}
 	return [curleft,curtop];
 }
 
 function searchKeyUp(event)
 {
	 if (event.keyCode==13)
	 {
		 FindPerson();
	 }
 }

function FindPerson()
 {
	 d('kp_name_l').focus();
	 d('result_view').innerHTML = "";
	 var firstname = d('kp_name_f').value;
	 var lastname = d('kp_name_l').value;
 	if ((firstname != "") || (lastname != ""))
	{
		d('result_view').innerHTML = "Searching...";
 		Find(firstname, lastname, 0, "FindPerson");
	}
 	else
 	{
 		document.getElementById("result_view").innerHTML = "";
 	}
 }
 
  function processXML1(obj, tbl)
 {
 	var root = obj.getElementsByTagName('pplb').item(0);
 	fpMaxPageSearch = root.getAttribute('maxpage');
 
 	fpResultsSearch.length = root.childNodes.length;
 	//fpNoOfRowsSearch = root.childNodes.length;
 	
 	if (fpResultsSearch.length < 1)
 	{
 		//alert("No results found for this search.");
 		d('result_view').innerHTML = "";
 		return;
 	}
 	
 	var searchResultsTable = "<table border=0 style='font-family: Tahoma; font-size: 8pt; width: 100%;cursor: pointer;' id='rv1'>";
 
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
 		searchResultsTable += "<tr onMouseOver=Over1(this) onMouseOut=Out1(this) id='qwe" + //tbl + 
 			i + "' onclick=Selected('copiResults" + /*tbl.id +*/ "'," + i + ")>";
 		searchResultsTable += "<td>" + fpResultsSearch[i][0] + "</td>" + 
 			"<td style='display: none;'>" + fpResultsSearch[i][3] + "</td>";
 		searchResultsTable += "</tr>";
 	}
 	searchResultsTable += "</table>";
  	d('result_view').innerHTML = searchResultsTable;
 }

 
function Over1(obj)
{
	obj.style.background = "#F0F0F0";
}

function Out1(obj)
{
	obj.style.background = "#ffffff";
}

function StartASTimer()
{
	autoSaveTimer = setTimeout("AutoSave()", 60 * 1000);
}

var startX = 0;
var startY = 0;

function window_onresize()
{
	var p = findPos(document.getElementById('budget_section'));
	startX = p[0] + document.getElementById('budget_section').clientWidth + 20;
}

function JSFX_FloatTopLeft()
{
	window.onresize = window_onresize;
	var p = findPos(document.getElementById('budget_section'));
	//var startX = document.body.clientWidth - 235;
	startX = p[0] + document.getElementById('budget_section').clientWidth + 20;
	startY = 20;
	var ns = (navigator.appName.indexOf("Netscape") != -1);
	var d = document;
	var px = document.layers ? "" : "px";
	function ml(id)
	{
		var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
		if(d.layers)el.style=el;
		el = document.getElementById("divStayTopLeft");
		el.sP=function(x,y){this.style.left=x+px;this.style.top=y+px;};
		el.x = startX; el.y = startY;
		return el;
	}
	window.stayTopLeft=function()
	{
		var pY = ns ? pageYOffset : document.documentElement && document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
		var dY = (pY > startY) ? pY : startY;
		ftlObj.y += (dY + 40 - ftlObj.y)/8;
		ftlObj.sP(startX, ftlObj.y);
		setTimeout("stayTopLeft()", 20);
	}
	ftlObj = ml("divStayTopLeft");
	stayTopLeft();
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

var fpResultsSearch;
function FindCoPi()
{
	fullname = document.getElementById("ciFullName").value;
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
	
	document.getElementById("ciLoginID").value = "";
	
	if ((firstname != "") || (lastname != ""))
		Find(firstname, lastname, 1, "copiResults");
	else
	{
		document.getElementById("copiResults").innerHTML = "";
		document.getElementById("copiResultsRow").style.display = 'none';
	}
}

function Find(firstname, lastname, pageno, tbl)
{
	//alert("inside find");
	var uri = "../sections/gen_browse_search_user.php?type=pplb&fname=" + firstname + "&lname=" + lastname + "&pageno=" + pageno;
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
				if (tbl=="FindPerson")
					processXML1(xmlhttp.responseXML, tbl);
				else
					processXML(xmlhttp.responseXML, tbl);
			}
			else
			{
				alert( "Unable to perform search. HTTP response code : " + xmlhttp.status );
			}
		}
	}
	xmlhttp.send(null)
}

function processXML(obj, tbl)
{
	var root = obj.getElementsByTagName('pplb').item(0);
	fpMaxPageSearch = root.getAttribute('maxpage');
	fpPageSearch = root.getAttribute('pageno');

	fpResultsSearch.length = root.childNodes.length;
	//fpNoOfRowsSearch = root.childNodes.length;
	
	if (fpResultsSearch.length < 1)
	{
		//alert("No results found for this search.");
		document.getElementById(tbl).innerHTML = "";
		document.getElementById(tbl + "Row").style.display = 'none';	
		return;
	}
	
	var searchResultsTable = "<table style='border: 1px dotted #0000CC' width=100%>";

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
		searchResultsTable += "<tr onMouseOver=\"Over(this)\" onMouseOut =\"Out(this)\" id=\"" + tbl + i + "\" onclick='javascript:Selected(\"" + tbl + "\"," + i + ")'>";
		searchResultsTable += "<td>" + fpResultsSearch[i][0] + "</td>" + 
								"<td>" + fpResultsSearch[i][1] + "</td>" + 
								"<td>" + fpResultsSearch[i][8] + "</td>" + 
								"<td>" + fpResultsSearch[i][9] + "</td>" +
								"<td>" + fpResultsSearch[i][12] + "</td>" +
								"<td style=\"display:none\">" + fpResultsSearch[i][13] + "</td>" +
								"<td style=\"display:none\">" + fpResultsSearch[i][3] + "</td>";
		searchResultsTable += "</tr>";
	}
	searchResultsTable += "</table>";
	//alert(searchResultsTable);
	document.getElementById(tbl).innerHTML = searchResultsTable;
	document.getElementById(tbl + "Row").style.display = '';
} 

function Over(obj)
{
	for (i=0;i<obj.cells.length;i++)
	{
		obj.cells(i).className = "tdHiLite";
	}
}

function Out(obj)
{
	for (i=0;i<obj.cells.length;i++)
	{
		obj.cells(i).className = "tdLoLite";
	}
}

function Selected(tbl, i)
{
	if (tbl == "copiResults")
	{
		d('result_view').innerHTML = "";
		d('find').style.display = 'none';
		document.getElementById("ciFullName").value = fpResultsSearch[i][0];
		document.getElementById("ciEmail").value = fpResultsSearch[i][9];
		document.getElementById("ciPhoneNumber").value = fpResultsSearch[i][8];
		document.getElementById("ciBox#").value =  fpResultsSearch[i][12];
		document.getElementById("ciLoginID").value = fpResultsSearch[i][3];
		document.getElementById(tbl).innerHTML = "";
		document.getElementById(tbl + "Row").style.display = 'none';
		//document.getElementById("deptcolor").style.color = "Red";		
		var rank = fpResultsSearch[i][1];
		var hid = fpResultsSearch[i][13];
		
		var ciDept = document.getElementById("ciDept");
		for(var i=0; i<ciDept.options.length; i++)
		{
			if (ciDept.options[i].id == hid)
			{
				ciDept.options[i].selected = true;
				break;
			}
		}
		
		var ciRank = document.getElementById("ciRank");
		var matchFound = false;
		for(var i=0; i<ciRank.options.length; i++)
		{
			if (ciRank.options[i].value == rank)
			{
				matchFound = true;
				ciRank.value = rank;
				break;
			}
		}
		if (matchFound ==false)
		{
			ciRank.value = 'Other-';
			document.getElementById("ciRankopt").value = rank;
			Hide('other', false, 'ciRankOther1', 'ciRankOther2');
		}
	}
	else if (tbl == "extResults")
	{
		document.getElementById(tbl).innerHTML = "";
		document.getElementById(tbl + "Row").style.display = 'none';	
	}
}

function putFocus(id) 
{
	document.getElementById(id).focus();
}

function adjust(subConNo)
{
	var theAmount = 25000;
	for(var i=1; i<=5; i++)
	{
		var amtFieldName = 'amt'+subConNo+i;
		var subConFieldName = 'subCon' + subConNo + i;
		//alert(amtFieldName + "\n" + subConFieldName);
		var amt;
		var subConValue = parseInt(document.getElementById(subConFieldName).value);
		if(subConValue <= theAmount)
		{
			theAmount = theAmount - subConValue;
			document.getElementById(amtFieldName).value = '0';
		}
		else
		{
			amt = subConValue - theAmount;
			theAmount = 0;
			document.getElementById(amtFieldName).value = amt.toString();
		}		
	}
}		

function mtdc(year)
{
	var mtdc = 0, mtdcTotal = 0;
	var idc = 0, idcTotal = 0;
	var tc = 0, tcTotal = 0;
	var Rate = parseInt(document.getElementById('pifAPercentage').value)/100;
	var stdRate = 0.48;
	var fieldNames = new Array('bu_ss','bu_tuition','bu_equip', 'bu_ps', 'bu_pTrav', 'bu_stem');
	var field;
	var reqMTDC;

			mtdc = parseInt(document.getElementById('bu_tdc'+year).value);
			tc = parseInt(document.getElementById('bu_tdc'+year).value);
			for(i=0; i<fieldNames.length; i++)
			{
				field = fieldNames[i] + year;
				mtdc = mtdc - parseInt(document.getElementById(field).value);
			}
			for(i=1; i<=subConNo; i++)
			{
				var amt = document.getElementById("amt" + i + "" + year);
				if ( amt!=null )
				{
					mtdc = mtdc - parseInt(amt.value);
				}
				else
					alert("amt" + i + "" + year);
			}
			/*
			for (i=100; i <=customStartAt; i++)
			{
				field = "custom" + i + casevalue;
				fieldTotal = "custom" + i + "Total";
				tdc += parseInt(document.getElementById(field).value);
				tdcTotal += parseInt(document.getElementById(fieldTotal).value);
			}*/
			document.getElementById('bu_mtdc'+year).value = mtdc.toString();
			idc = parseInt(document.getElementById('bu_mtdc'+year).value)*Rate;
			idc = Math.round(idc*100)/100; // not there in case == 5
			document.getElementById('bu_idc'+year).value = idc.toString();
			tc = tc + idc;
			tc = Math.round(tc*100)/100;
			document.getElementById('bu_tc'+year).value = tc.toString();
			for(var k=1; k<=5; k++)
			{
				mtdcTotal += parseInt(document.getElementById('bu_mtdc'+k).value);
				idcTotal += parseInt(document.getElementById('bu_idc'+k).value);
				tcTotal += parseInt(document.getElementById('bu_tc'+k).value);
			}
			reqMTDC = mtdcTotal*stdRate;
			reqMTDC = Math.round(reqMTDC*100)/100;
			idcTotal=Math.round(idcTotal*100)/100;
			document.getElementById('bu_reqMTDC').value = Math.round(reqMTDC).toString();
			document.getElementById('bu_mtdcTotal').value = mtdcTotal.toString();
			document.getElementById('bu_idcTotal').value = idcTotal.toString();
			tcTotal = Math.round(tcTotal*100)/100;
			document.getElementById('bu_tcTotal').value = Math.round(tcTotal).toString();
			document.getElementById('bu_lIDC').value = Math.round(reqMTDC-idcTotal).toString();
}

function total(id)
{
    var total = 0;
	for (var i=1; i<=5; i++)
		total += parseInt(document.getElementById(id+i).value);
		//total += parseFloat(document.getElementById(id+i).value);
	total = Math.round(total*100)/100;
	document.getElementById(id+'Total').value = total.toString();
}

function tdc(casevalue)
{
	var tdc = 0, tdcTotal = 0;
	var fieldNames = new Array('bu_sal','bu_fb','bu_mo','bu_conServ','bu_ss','bu_tuition','bu_ps','bu_tDom','bu_tFor','bu_pTrav','bu_equip', 'bu_stem');
	var field, fieldTotal;
			for(i=0; i<fieldNames.length; i++)
			{
				field = fieldNames[i] + casevalue;
				fieldTotal = fieldNames[i] + 'Total';

				field = field.toString();
				fieldTotal = fieldTotal.toString();
				//alert(field + "\n" + fieldTotal + "\n" + "i = " + i);
				tdc += parseInt(document.getElementById(field).value);
				tdcTotal += parseInt(document.getElementById(fieldTotal).value);
			}
			for (i=100; i <=customStartAt; i++)
			{
				field = "custom" + i + casevalue;
				fieldTotal = "custom" + i + "Total";
				tdc += parseInt(document.getElementById(field).value);
				tdcTotal += parseInt(document.getElementById(fieldTotal).value);
			}
			for (i=1; i<=subConNo; i++)
			{
				var subCon = document.getElementById("subCon" + i + casevalue);
				if (subCon != null)
				{
					//field = "custom" + i + casevalue;
					//fieldTotal = "custom" + i + "Total";
					tdc += parseInt(subCon.value);
					tdcTotal += parseInt(document.getElementById("subCon" + i + "Total").value);
				}
			}
			document.getElementById('bu_tdc'+casevalue).value = tdc.toString();
			//if (casevalue == '1')
				tdcTotal = Math.round(tdcTotal*100)/100;
			document.getElementById('bu_tdcTotal').value = tdcTotal.toString();
}

function textCounter(field, cntfield, maxlimit) 
{
	rem_length = maxlimit - document.getElementById(field).value.length
	document.getElementById(cntfield).innerHTML = rem_length + " characters left.";
}

function CheckEHApproval()
{	
	if ((document.getElementById("ccradioMaterials").checked) ||
		(document.getElementById("cccSubstances").checked) ||
		(document.getElementById("ccrpMachines").checked) ||
		(document.getElementById("cclDevices").checked))
		document.getElementById("EHApprovalSpace").style.display = '';
	else
		document.getElementById("EHApprovalSpace").style.display = 'none';
}

function Hide(obj, val, s1, s2)
{
	if (obj == "other")
	{
		if (val == true)
		{
			document.getElementById(s1).style.display = 'none';
			document.getElementById(s2).style.display = 'none';
		}
		else
		{
			document.getElementById(s1).style.display = '';
			document.getElementById(s2).style.display = '';
		}
	}
	else
	{
			document.getElementById(s1).style.display = 'none';
			document.getElementById(s2).style.display = 'none';
	}
}

var customStartAt = 99;
var subConNo = 0;

function AddRow(tblName)
{
	var tbl = document.getElementById(tblName);
	if (tblName == "CoPis")
	{
		if (document.getElementById("ciLoginID").value == "")
		{
			alert("Please search for a co-investigator first.");
			return;
		}
		else if (document.getElementById("ciDept").value == "Select a Department from Below")
		{
			alert("Please select a department before adding the co investigator.");
			return;
		}
		var newRow = tbl.insertRow(tbl.rows.length);
		var newCell = newRow.insertCell(0);
		newCell.innerHTML = document.getElementById("ciFullName").value;
		var newCell = newRow.insertCell(1);
		newCell.align = "center";
		newCell.innerHTML = document.getElementById("ciEmail").value;
		var newCell = newRow.insertCell(2);
		newCell.align = "center";
		newCell.innerHTML = document.getElementById("ciBox#").value;
		var newCell = newRow.insertCell(3);
		newCell.align = "center";
		newCell.innerHTML = document.getElementById("ciPhoneNumber").value;
		var newCell = newRow.insertCell(4);
		newCell.innerHTML = document.getElementById("ciDept").value;
		newCell.align = "center";
		//newCell.innerHTML = document.getElementById("ciDept").options[document.getElementById("ciDept").selectedIndex].text;
		var newCell = newRow.insertCell(5);
		if (document.getElementById("ciRank").value=="Other-")
			newCell.innerHTML = document.getElementById("ciRankopt").value;
		else
			newCell.innerHTML = document.getElementById("ciRank").value;
		newCell.align = "center";
		var newCell = newRow.insertCell(6);
		newCell.align = "center";
		if (document.getElementById("ciCitizenship1").checked)
			newCell.innerHTML = document.getElementById("ciCitizenship1").value;
		else
			newCell.innerHTML = document.getElementById("ciCitizenship2").value;
		var newCell = newRow.insertCell(7);			
		newCell.innerHTML = document.getElementById("ciLoginID").value;
		var man_route = '';
		if (newCell.innerHTML == "")
			man_route = '<img src="images/redflag1.PNG" alt="Needs manual routing">';
		newCell.style.display = 'none';
		var newCell = newRow.insertCell(8);
		newRow.id = tblName + newRow.rowIndex;
		var id = newRow.id;
		newCell.innerHTML = "<span onclick='RemoveRow(\"" + tblName + "\",\"" + id + "\")'>" + man_route + "<img src=\"images/deleterow.gif\" alt=\"Remove\"></span>" +
		"<input type=\"hidden\" name=\"ciFullName[]\" value=\"" + document.getElementById("ciFullName").value + "\"><input type=\"hidden\" name=\"ciDept[]\" value=\"" + document.getElementById("ciDept").value + "\"><input type=\"hidden\" name=\"ciBox#\" value=\"" + document.getElementById("ciBox#").value + "\"><input type=\"hidden\" name=\"ciEmail[]\" value=\"" + document.getElementById("ciEmail").value + "\"><input type=\"hidden\" name=\"ciPhoneNumber[]\" value=\"" + document.getElementById("ciPhoneNumber").value + "\"><input type=\"hidden\" name=\"ciRank[]\" value=\"" + document.getElementById("ciRankopt").value + "\"><input type=\"hidden\" name=\"ciLoginID[]\" value=\"" + document.getElementById("ciLoginID").value + "\">";
		//newRow.width = "100%";
		tbl.style.display = '';
		document.getElementById("ciFullName").value = "";
		document.getElementById("ciDept").selectedIndex = 0;
		document.getElementById("ciBox#").value = "";
		document.getElementById("ciEmail").value = "";
		document.getElementById("ciPhoneNumber").value = "";
		document.getElementById("ciRank").selectedIndex = 0;
		document.getElementById("ciRankopt").value = "";
		document.getElementById("ciLoginID").value = "";
		//document.getElementById("ciCitizenship").value = "";
		document.getElementById("deptcolor").style.color = "Black";
	}
	else if (tblName == "budgetInnerTable1")
	{
		/// Adding custom Categories
		tbl = document.getElementById("budgetInnerTable");
		var newRow = tbl.insertRow(tbl.rows.length - 9);
		newRow.id = id + "budget";
		var newCell = newRow.insertCell(0);
		newCell.innerHTML = ++customStartAt;
		
		var newCell = newRow.insertCell(1);
		newCell.align = "center";
		newCell.innerHTML = "<input type=\"text\" id=\"customName" + customStartAt + "\" name=\"customName" + customStartAt + "\" size=\"18\">";
		
		var number = tbl.rows.length;

		for (year = 1; year <= 5; year++)
		{
		var newCell = newRow.insertCell(year+1);
		newCell.innerHTML = 
		"<input name=\"custom" + customStartAt + "" + year + "\" type=\"text\" id=\"custom" + 
		customStartAt + "" + year + "\" size=\"8\" value=\"0\" tabindex=\"8\" " +
		"onKeyUp=\"total('custom" + customStartAt + "');tdc('" + year + "');\" onBlur=\"mtdc('" + 
		year + "');\" " +
		"onKeypress=\"if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;\">";
		//alert(newCell.innerHTML);
		}
		var newCell = newRow.insertCell(7);
		newCell.innerHTML = "<input name=\"custom" + customStartAt + "Total\" type=\"text\" " +
		"id=\"custom" +	customStartAt + "Total\" value=\"0\" size=\"10\" tabindex=\"-1\">";

		var newCell = newRow.insertCell(8);
		newCell.innerHTML = "";
	}
	else if (tblName == "budgetInnerTable")
	{
		/// Adding subcontractors from within the budget table
		tbl = document.getElementById("budgetInnerTable");
		var newRow = tbl.insertRow(7);
		newRow.id = id + "budget";
		var newCell = newRow.insertCell(0);
		newCell.align = "right";
		newCell.innerHTML = "Name: ";
		
		var newCell = newRow.insertCell(1);
		newCell.align = "center";
		subConNo++;

		newCell.innerHTML = '<input type="text" id="subCon' + subConNo + 'Name" name="subCon' + subConNo + 'Name" size="18">';
		
		//var number = tbl.rows.length;


		for (year = 1; year <= 5; year++)
		{
			var newCell = newRow.insertCell(year+1);
			newCell.innerHTML = 
				"<input name=\"subCon" + subConNo + "" + year + "\" type=\"text\" id=\"subCon" + subConNo + "" + 
				year + "\" size=\"8\" value=\"0\" tabindex=\"8\" onKeyUp=\"total('subCon" + subConNo + 
				"');tdc('" + year + "');\" onBlur=\"adjust('" + subConNo + "');mtdc('" + year + "');\" " +
				"onKeypress='if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;'>" +
				"<input type=\"hidden\" name=\"amt" + subConNo + year + "\" id=\"amt" + subConNo + year + "\" value=\"0\">";
			//alert(newCell.innerHTML);
		}
		var newCell = newRow.insertCell(7);
		newCell.innerHTML = "<input name=\"subCon" + subConNo + "Total\" type=\"text\" id=\"subCon" +
			subConNo + "Total\" value=\"0\" size=\"10\" tabindex=\"-1\">";

		var newCell = newRow.insertCell(8);
		newCell.innerHTML = "";
	}
	else if (tblName == "extIs")
	{
		var newRow = tbl.insertRow(tbl.rows.length);
		var newCell = newRow.insertCell(0);
		newCell.innerHTML = document.getElementById("extInstName").value;
		var newCell = newRow.insertCell(1);
		newCell.innerHTML = document.getElementById("extFullName").value;
		var newCell = newRow.insertCell(2);
		newCell.align = "center";
		newCell.innerHTML = document.getElementById("extEmail").value;
		var newCell = newRow.insertCell(3);
		newCell.align = "center";
		newCell.innerHTML = document.getElementById("extBox#").value;
		var newCell = newRow.insertCell(4);
		newCell.align = "center";
		newCell.innerHTML = document.getElementById("extPhoneNumber").value;
		var newCell = newRow.insertCell(5);
		newCell.align = "center";
		newCell.innerHTML = document.getElementById("extDept").value;
		//newCell.innerHTML = document.getElementById("ciDept").options[document.getElementById("ciDept").selectedIndex].text;
		var newCell = newRow.insertCell(6);
		newCell.align = "center";
		if (document.getElementById("extRank").value=="Other-")
			newCell.innerHTML = document.getElementById("extRankopt").value;
		else
			newCell.innerHTML = document.getElementById("extRank").value;
		var newCell = newRow.insertCell(7);
		newCell.align = "center";
		if (document.getElementById("extCitizenship1").checked)
			newCell.innerHTML = document.getElementById("extCitizenship1").value;
		else
			newCell.innerHTML = document.getElementById("extCitizenship2").value;
		var newCell = newRow.insertCell(8);
		//newCell.class = "tdSmall";
		newCell.innerHTML = document.getElementById("extFunded1").value;
		var newCell = newRow.insertCell(9);
		newRow.id = tblName + newRow.rowIndex;
		var id = newRow.id;
		if (document.getElementById("extFunded1").value	==	"Subcontractor - Funded through UTA's Budget")
		{
			jsAdd = "RemoveRow(\"budgetInnerTable\", \"" + id + "budget\")";
		}
		else
			jsAdd = "";
		newCell.innerHTML = "<span onclick='RemoveRow(\"" + tblName + "\",\"" + id + "\");" + jsAdd
		+ "'><img src=\"images/deleterow.gif\" alt=\"Remove\">" +
		"</span><input type=\"hidden\" name=\"ciFullName[]\" value=\"" + 
		document.getElementById("extFullName").value + "\"><input type=\"hidden\" name=\"ciDept[]\" " +
		"value=\"" + document.getElementById("extDept").value + "\"><input type=\"hidden\" " + 
		"name=\"ciBox#\" value=\"" + document.getElementById("extBox#").value + "\"><input " + 
		"type=\"hidden\" name=\"ciEmail[]\" value=\"" + document.getElementById("extEmail").value + 
		"\"><input type=\"hidden\" name=\"ciPhoneNumber[]\" value=\"" + 
		document.getElementById("extPhoneNumber").value + "\"><input type=\"hidden\" name=\"ciRank[]\"" +
		" value=\"" + document.getElementById("extRankopt").value + "\">";
		//newRow.width = "100%";
		tbl.style.display = '';
				
				
		if (document.getElementById("extFunded1").value	==	"Subcontractor - Funded through UTA's Budget")
		{
			/// Adding subcontractors from the "External Investigators" Section.
			tbl = document.getElementById("budgetInnerTable");
			var newRow = tbl.insertRow(7);
			newRow.id = id + "budget";
			var newCell = newRow.insertCell(0);
			newCell.innerHTML = "";
			
						subConNo++;
		
			var newCell = newRow.insertCell(1);
			newCell.align = "center";
			newCell.innerHTML = '<input type="hidden" id="subCon' + subConNo + 'Name" name="subCon' + subConNo + 'ID" value="' + document.getElementById("extInstName").value + '">' + document.getElementById("extInstName").value;

			for (year = 1; year <= 5; year++)
			{
				var newCell = newRow.insertCell(year+1);
				newCell.innerHTML = 
					"<input name=\"subCon" + subConNo + "" + year + "\" type=\"text\" id=\"subCon" + subConNo + "" + 
					year + "\" size=\"8\" value=\"0\" tabindex=\"8\" onKeyUp=\"total('subCon" + subConNo + 
					"');tdc('" + year + "');\" onBlur=\"adjust('" + subConNo + "');mtdc('" + year + "');\" " +
					"onKeypress=\"if ((event.keyCode < 45) || (event.keyCode > 57)) event.returnValue = false;\">" +
					"<input type=\"hidden\" name=\"amt" + subConNo + year + "\" id=\"amt" + subConNo + year + "\" value=\"0\">";
					//alert(newCell.innerHTML);
			}
			var newCell = newRow.insertCell(7);
			newCell.innerHTML = "<input name=\"subCon" + subConNo + "Total\" type=\"text\" id=\"subCon" +
				subConNo + "Total\" value=\"0\" size=\"10\" tabindex=\"-1\">";
			var newCell = newRow.insertCell(8);
			newCell.innerHTML = "";
		}
		
		document.getElementById("extFullName").value = "";
		document.getElementById("extDept").selectedIndex = 0;
		document.getElementById("extBox#").value = "";
		document.getElementById("extEmail").value = "";
		document.getElementById("extPhoneNumber").value = "";
		document.getElementById("extRank").selectedIndex = 0;
		document.getElementById("extRankopt").value = "";
		//document.getElementById("ciCitizenship").value = "";
	}
}

function RemoveRow(tblName, rowId)
{
	var tbl = document.getElementById(tblName);
	var row = document.getElementById(rowId);
	tbl.deleteRow(row.rowIndex);
	if (tbl.rows.length < 2)
		tbl.style.display = 'none';
}

function ShowTable(tblName)
{
	var tbl = document.getElementById(tblName);
	tbl.style.display = '';
}

function HideTable(tblName)
{
	var tbl = document.getElementById(tblName);
	tbl.style.display = 'none';
}

function ToggleTable(tblName, obj)
{
	if ((obj.innerHTML == "Collapse") || (obj.innerHTML == "Hide Help"))
	{
		HideTable(tblName);
		if (obj.innerHTML == "Collapse")
			obj.innerHTML = "Expand";
		else
			obj.innerHTML = "Show Help";
	}
	else
	{
		ShowTable(tblName);
		if (obj.innerHTML == "Expand")
			obj.innerHTML = "Collapse";
		else
			obj.innerHTML = "Hide Help";
	}
}
/*
var v, dS, sD, y;

function setVariables()
{
  if (navigator.appName == "Netscape") 
  {
    v = ".top=";
    dS = "document.";
    sD = "";
    y = "window.pageYOffset";
  }
  else 
  {
  	v=".pixelTop=";
	dS="";
	sD=".style";
	y="document.body.scrollTop";
  }
}

function checkLocation()
{
  var object = 'object11';
  var yy = eval(y);
  //alert(dS+object+sD+v+yy);
  eval(dS+object+sD+v+yy);
  setTimeout("checkLocation()",2000);
}
*/
function CollapseAll()
{
}

function ExpandAll()
{
}

function GeneratePrintPreview()
{
	var uri = "bs_preview.php?bs_id=" + document.getElementById('bs_id').value;
	var xmlhttp = getHTTPObject();
	xmlhttp.open("GET", uri, true);
	xmlhttp.onreadystatechange = function() 
	{
		if (xmlhttp.readyState==4) 
		{
			if( xmlhttp.status == 200 )
			{
				HandlePrintPreview(xmlhttp.responseText);
			}
			else
			{
				alert( "Unable to generate preview at this time. HTTP response code : " + xmlhttp.status );
			}
		}
	}
	xmlhttp.send(null)
}

function HandlePrintPreview(data)
{
	copiRowKey = '<td valign="top" width="10%" align="left" class="tdSmall">Name:<br>Department:<br>Box:<br>Phone:<br>Email:<br>Rank:<br>Citizenship:<br></td>';
	copiRowValue = new String('<td valign="top" align="left" class="tdSmall" width="30%"><0><br><4><br><2><br><3><br><1><br><5><br><6><br></td>');
	extiRowKey = '<td width="10%" valign="top" align="left" class="tdSmall">Name:<br>Department:<br>Box:<br>Phone:<br>Email:<br>Rank:<br>Citizenship:<br>Funding:<br></td>';
	extiRowValue = new String('<td align="left" valign="top" class="tdSmall"><0><br><4><br><2><br><3><br><1><br><5><br><6><br><7></td>');
	subConRowValue = new String('<tr><td scope="row" align="left">&nbsp;&nbsp;Name: <name></td><td align="center"><1></td><td align="center"><2></td><td align="center"><3></td><td align="center"><4></td><td align="center"><5></td><td align="center"><total></td></tr>');
	customCatRowValue = new String('<tr><td scope="row" align="left"><catno> <name></td><td align="center"><1></td><td align="center"><2></td><td align="center"><3></td><td align="center"><4></td><td align="center"><5></td><td align="center"><total></td></tr>');
	coinvestigators = "";
	extinvestigators = "";
	subcontracts = "";
	customcategories = "";
	copissig = "";
	copiSigValue = '<tr><td colspan="5"><br><br><br></td></tr><tr><td width="30%"><table style="border-top: 1px solid #000000;" width="100%"><tr><td align="left" width="100%">Co-Investigator</td><td width="20%" align="right">Date</td></tr></table></td><td width="5%"></td><td width="30%"><table style="border-top: 1px solid #000000;" width="100%"><tr><td align="left" width="100%">Chairperson</td><td width="30%" align="right">Date</td></tr></table></td><td width="5%"></td><td width="30%"><table style="border-top: 1px solid #000000;" width="100%"><tr><td align="left" width="100%">Dean/Director</td><td width="30%" align="right">Date</td></tr></table></td></tr>';
	copiColNum = 1;
	extiColNum = 1;
	
	str = new String(data);
	//var generator = window.open('','name','height=400,width=724,scrollbars=yes');
	for(i=0; i<document.frmBS.elements.length; i++)
	{
		prefix = document.frmBS.elements[i].id.toString().substring(0, 2);
		if ((prefix == "pi") ||
			 (prefix == "pr") ||
			 (prefix == "bu") ||
			 (prefix == "si"))
		{
			//if (prefix == "bu")
			//	alert( document.frmBS.elements[i].id.toString());
			if ((document.frmBS.elements[i].id.toString()=="siShipMethod1") || (document.frmBS.elements[i].id.toString()=="siShipMethod2") || (document.frmBS.elements[i].id.toString()=="siNoOfCopies"))
			{
			}
			else if ((document.frmBS.elements[i].id.toString()=="siSubMethod1") || (document.frmBS.elements[i].id.toString()=="siSubMethod2"))
			{
				if (document.frmBS.elements[i].checked == true)
				{
					str = str.replace("<siSubMethod>", document.frmBS.elements[i].value.toString());
					if (document.frmBS.elements[i].value.toString() == "Paper")
					{
						if (document.getElementById("siShipMethod1").checked == true)
						{
							str = str.replace("<siShipMethod>", document.getElementById("siShipMethod1").value.toString());
							str = str.replace("<siNoOfCopies>", document.getElementById("siNoOfCopies").value.toString());
						}
						else
							str = str.replace("<siShipMethod>", document.getElementById("siShipMethod2").value.toString());
					}
				}
			}
			else if (document.frmBS.elements[i].name.toString()=="propinfoType")
			{
				if (document.frmBS.elements[i].checked == true)
				{
					str = str.replace("<propinfoType>", document.frmBS.elements[i].value.toString());
				}
			}			
			else if (document.frmBS.elements[i].id.toString() == "piCitizenship")
			{
				if(document.frmBS.elements[i].checked)
				{
					str = str.replace("<" + document.frmBS.elements[i].id.toString() + ">", document.frmBS.elements[i].value.toString());
				}
			}
			else
				str = str.replace("<" + document.frmBS.elements[i].id.toString() + ">", document.frmBS.elements[i].value.toString());
		}
		else if (prefix == "sc")
		{
			if (document.frmBS.elements[i].checked == true)
			{
				str = str.replace("<" + document.frmBS.elements[i].id.toString() + ">", document.frmBS.elements[i].value.toString());
			}
		}
		else if (prefix == "cc")
		{
			prefix = document.frmBS.elements[i].id.toString().substring(0, 3);
			if (prefix != "ccp")
			{
				if (document.frmBS.elements[i].checked == true)
				{
					str	= str.replace("<" +  document.frmBS.elements[i].id.toString() + ">", document.frmBS.elements[i].value);
					if ((document.frmBS.elements[i].value == "Yes") &&
						(document.frmBS.elements[i].id.toString() != "ccrpMachines") &&
						(document.frmBS.elements[i].id.toString() != "ccselectAgents") &&												 
						(document.frmBS.elements[i].id.toString() != "cclDevices"))
					{
						suffix = document.frmBS.elements[i].id.toString().substring(2, document.frmBS.elements[i].id.toString().length);
						if (document.getElementById("ccp" + suffix + "1").checked == true)
							str = str.replace("<" +  document.frmBS.elements[i].id.toString() + "Optional>", ", Pending");
						else
						{
							if (suffix == "cSubstances")
								str = str.replace("<" +  document.frmBS.elements[i].id.toString() + "Optional>", ", DEA License #: " + document.getElementById("ccp" + suffix + "No").value);
							else if (suffix == "radioMaterials")
								str = str.replace("<" +  document.frmBS.elements[i].id.toString() + "Optional>", ", Approval Date: " + document.getElementById("ccp" + suffix + "No").value);							
							else
								str = str.replace("<" +  document.frmBS.elements[i].id.toString() + "Optional>", ", Approved Protocol Number: " + document.getElementById("ccp" + suffix + "No").value);							
						}
					}
				}
			}
		}
	}
	var rows = document.getElementsByTagName("tr");
	for(i=0; i<rows.length; i++)
	{
		prefix = rows[i].id.toString().substring(0,5);
		if ((prefix == "CoPis") /*&& (document.frmBS.elements[i].id.toString().length > 5)*/)
		{
			k = copiColNum - 1;
			if ((k % 4) == 0)
				coinvestigators = coinvestigators + "<tr>" + copiRowKey;
			copiRowContent = copiRowValue;
			var row = document.getElementById(rows[i].id.toString());
			for (j=0; j<=6; j++)
				copiRowContent = copiRowContent.replace("<" + j + ">", row.cells[j].innerHTML);
			coinvestigators = coinvestigators + copiRowContent;
			copiColNum++
			if ((copiColNum % 4) == 0)
			{
				coinvestigators = coinvestigators + "</tr>";
				copiColNum++;
			}
			copissig = copissig + copiSigValue;
		}
		else if (prefix == "extIs")
		{
			suffix = rows[i].id.toString().substring(rows[i].id.toString().length - 6, rows[i].id.toString().length);
			if (suffix != "budget")
			{
				k = extiColNum - 1;
				if ((k % 4) == 0)
					extinvestigators = extinvestigators + "<tr>" + extiRowKey;
				extiRowContent = extiRowValue;
				var row = document.getElementById(rows[i].id.toString());
				for (j=0; j<=7; j++)
					extiRowContent = extiRowContent.replace("<" + j + ">", row.cells[j].innerHTML);
				extinvestigators = extinvestigators + extiRowContent;
				extiColNum++
				if ((extiColNum % 4) == 0)
				{
					extinvestigators = extinvestigators + "</tr>";
					extiColNum++;
				}
			}
		}
	}

	for (i=100; i <=customStartAt; i++)
	{
		tempcustomCat = customCatRowValue;
		var customCatName = document.getElementById("customName" + i);
		if (customCatName != null)
		{
			tempcustomCat = tempcustomCat.replace("<catno>", i);
			tempcustomCat = tempcustomCat.replace("<name>", customCatName.value);
			for(casevalue=1; casevalue<=5; casevalue++)
			{
				tempcustomCat = tempcustomCat.replace("<" + casevalue + ">", document.getElementById("custom" + i + casevalue).value);
			}
			tempcustomCat = tempcustomCat.replace("<total>", document.getElementById("custom" + i + "Total").value);
			customcategories = customcategories + tempcustomCat;
		}
	}

	for (i=1; i<=subConNo; i++)
	{
		tempsubCon = subConRowValue;
		var subConName = document.getElementById("subCon" + i + "Name");
		if (subConName != null)
		{
			tempsubCon = tempsubCon.replace("<name>", subConName.value);
			for(casevalue=1; casevalue<=5; casevalue++)
			{
				tempsubCon = tempsubCon.replace("<" + casevalue + ">", document.getElementById("subCon" + i + casevalue).value);
			}
			tempsubCon = tempsubCon.replace("<total>", document.getElementById("subCon" + i + "Total").value);
			//alert(tempsubCon);
			subcontracts = subcontracts + tempsubCon;
		}
	}	
	str = str.replace("<copissig>", copissig);
	str = str.replace("<custom-categories>", customcategories);
	str = str.replace("<sub-contracts>", subcontracts);
	str = str.replace("<co-investigators>", coinvestigators);
	str = str.replace("<external-investigators>", extinvestigators);
	
	str = str.replace("<bu_reqMTDC>", document.getElementById('bu_reqMTDC').value);
	str = str.replace("<bu_lIDC>", document.getElementById('bu_lIDC').value);
	//generator.document.write(str);
	//generator.document.close();
	document.getElementById("form_preview").innerHTML = str;
	document.getElementById("form_preview").style.display = '';
	document.getElementById("form_preview_page").style.display = '';
	document.getElementById("main_form").style.display = 'none';
	window.scroll(0,0);
}

function GoBack()
{
	document.getElementById("form_preview_page").style.display = 'none';
	document.getElementById("form_preview").style.display = 'none';
	document.getElementById("main_form").style.display = '';
	window.scroll(0,0);
}

function PrintBS()
{
	window.print();
}

var submitted = false;

function Save(sstatus)
{
	var rtpc= "";
	if (sstatus == 2)
	{
		if ( !(checkSection3() && checkSection6() && checkSection10()) )
		{
			submitted=false;
			return;
		}
		clearTimeout(autoSaveTimer);
		var ret = confirm("Submitted blue sheets are no longer editable.\nAre you sure you want to submit this blue sheet?");
		if (ret == false)
		{
			submitted=false;
			autoSaveTimer = setTimeout("AutoSave()", 60 * 1000);
			return;
		}
	}
	else if (sstatus == 5)
	{
		rtpc = document.getElementById('return_to_pi_comments').value;
	}
	document.getElementById("status_msg").innerHTML = "Saving...";	
	var uri = "bs_save.php";
	var params = "";
	var xmlhttp = getHTTPObject();
	xmlhttp.open("POST", uri, true);
	//xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8');
	
	//build on the params
	var inputs = document.getElementsByTagName("input");
	for(i=0; i<inputs.length; i++)
	{
		prefix = inputs[i].id.toString().substring(0,3);
		if (prefix != "amt") 
		// little optimization, to save on bandwidth when posting data
		// i.e. dont send the fields that are not required
		{
			if (inputs[i].type == "radio")
			{
				if (inputs[i].checked == true)
					params += myescape(inputs[i].name) + "=" + myescape(inputs[i].value) + "&";
			}
			else
				params += myescape(inputs[i].name) + "=" + myescape(inputs[i].value) + "&";
		}
	}
	var inputs = document.getElementsByTagName("select");
	for(i=0; i<inputs.length; i++)
	{
		params += myescape(inputs[i].name) + "=" + myescape(inputs[i].value) + "&";
	}
	var inputs = document.getElementsByTagName("textarea");
	for(i=0; i<inputs.length; i++)
	{
		params += myescape(inputs[i].name) + "=" + myescape(inputs[i].value) + "&";
	}
	var rows = document.getElementsByTagName("tr");
	var copiCount = 0, extiCount = 0;
	for(i=0; i<rows.length; i++)
	{
		prefix = rows[i].id.toString().substring(0,5);
		if ((prefix == "CoPis") /*&& (document.frmBS.elements[i].id.toString().length > 5)*/)
		{
			copiCount++;
			var row = document.getElementById(rows[i].id.toString());
			params += "ci" + copiCount + "Name=" + myescape(row.cells[0].innerHTML) + "&";
			params += "ci" + copiCount + "Email=" + myescape(row.cells[1].innerHTML) + "&";
			params += "ci" + copiCount + "Box#=" + myescape(row.cells[2].innerHTML) + "&";
			params += "ci" + copiCount + "Phone=" + myescape(row.cells[3].innerHTML) + "&";
			params += "ci" + copiCount + "Dept=" + myescape(row.cells[4].innerHTML) + "&";
			params += "ci" + copiCount + "Rank=" + myescape(row.cells[5].innerHTML) + "&";
			params += "ci" + copiCount + "Citizenship=" + myescape(row.cells[6].innerHTML) + "&";
			params += "ci" + copiCount + "LoginID=" + myescape(row.cells[7].innerHTML) + "&";			
		}
		else if (prefix == "extIs")
		{
			suffix = rows[i].id.toString().substring(rows[i].id.toString().length - 6, rows[i].id.toString().length);
			if (suffix != "budget")
			{
				extiCount++;
				var row = document.getElementById(rows[i].id.toString());
				params += "exti" +extiCount + "IName=" + myescape(row.cells[0].innerHTML) + "&";				
				params += "exti" +extiCount + "Name=" + myescape(row.cells[1].innerHTML) + "&";
				params += "exti" + extiCount + "Email=" + myescape(row.cells[2].innerHTML) + "&";
				params += "exti" + extiCount + "Box#=" + myescape(row.cells[3].innerHTML) + "&";
				params += "exti" + extiCount + "Phone=" + myescape(row.cells[4].innerHTML) + "&";
				params += "exti" + extiCount + "Dept=" + myescape(row.cells[5].innerHTML) + "&";
				params += "exti" + extiCount + "Rank=" + myescape(row.cells[6].innerHTML) + "&";
				params += "exti" + extiCount + "Citizenship=" + myescape(row.cells[7].innerHTML) + "&";
				params += "exti" + extiCount + "Funding=" + myescape(row.cells[8].innerHTML) + "&";
			}
		}
	}
	params += "CoPiCount=" + copiCount + "&ExtICount=" + extiCount + "&";

	params += "customCount=" + (customStartAt - 99) + "&";
	params += "sstatus=" + sstatus + "&";
	params += "pid=" + document.getElementById("pid").value + "&";
	params+= "rtpc=" + rtpc;

	xmlhttp.onreadystatechange = function() 
	{
		if (xmlhttp.readyState==4) 
		{
			if( xmlhttp.status == 200 )
			{
				//alert('xmlhttp.responseText: ' + xmlhttp.responseText);
				var responseT = new String(xmlhttp.responseText);
				if (responseT.substring(0, 1) != "0")
				{
					if (responseT.indexOf("<") > 0)
					{
						document.location = "../errorpage.php?err_code=7";
					}
					else
					{
						document.getElementById("bs_id").value = xmlhttp.responseText;
						try
						{
						document.getElementById("btnDelete").disabled = false;
						}
						catch(e) {}
						if (submitted == true)
							document.location = "../researchspace.php?view=2";
						else
						{
							//alert('Form Saved Successfully.');
							document.getElementById("status_msg").innerHTML = "Last Saved on " + Date();
						}
					}
				}
				else
				{
					document.getElementById("status_msg").innerHTML = "";
					alert('There was an error while saving the form.\nError: ' + responseT);
				}
				// test code start-=
				// test code, remove it later
				/*
				document.getElementById("form_preview").innerHTML = xmlhttp.responseText;
				document.getElementById("form_preview").style.display = '';
				document.getElementById("form_preview_page").style.display = '';
				document.getElementById("main_form").style.display = 'none';
				window.scroll(0,0);
				*/
				// test code end-=
			}
			else if( xmlhttp.status == 302 )
			{
					document.location = "errorpage.php?err_code=7";
			}
			else
			{
				document.getElementById("status_msg").innerHTML = "";
				alert( "Unable to save at this moment. HTTP response code : " + xmlhttp.status );
			}
		}
	}
	//alert(params);
	//params = escape(params);
	xmlhttp.send(Utf8.encode(params));
}

function myescape(str)
{
	//return str;
	return new String(encodeURIComponent(str));//.replace(/\&/g, "%26");
	//return new String(str).replace(/\&/g, "%26");
}

function checkSection3()
{
	if (d('propinfoTitle').value == "")
	{
		alert('You must enter the proposal title before submitting.');
		return false;
	}
	else if (d('bu_prjYr1').value == "")
	{
		alert('Please enter the budget start date before submitting.');
		return false;
	}
	else if (d('bu_prjYr2').value == "")
	{
		alert('Please enter the budget end date before submitting.');
		return false;
	}
	return true;
}

function checkSection10()
{
	var checkFlag = false;
	for (i=0; i<document.frmBS.scmgmtPlan.length; i++)
	{
		if (document.frmBS.scmgmtPlan[i].checked==true)
		{
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Special Considerations section before submitting.');
		return false;
	}
	
	checkFlag = false;
	for (i=0; i<document.frmBS.sccostShare.length; i++)
	{
		if (document.frmBS.sccostShare[i].checked==true)
		{
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Special Considerations section before submitting.');
		return false;
	}
	
	checkFlag = false;
	for (i=0; i<document.frmBS.scIPCmaterials.length; i++)
	{
		if (document.frmBS.scIPCmaterials[i].checked==true)
		{
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Special Considerations section before submitting.');
		return false;
	}
	
	checkFlag = false;
	for (i=0; i<document.frmBS.sccoopAgreements.length; i++)
	{
		if (document.frmBS.sccoopAgreements[i].checked==true)
		{
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Special Considerations section before submitting.');
		return false;
	}
	
	checkFlag = false;
	for (i=0; i<document.frmBS.sccollabf.length; i++)
	{
		if (document.frmBS.sccollabf[i].checked==true)
		{
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Special Considerations section before submitting.');
		return false;
	}
	
	checkFlag = false;
	for (i=0; i<document.frmBS.scshipf.length; i++)
	{
		if (document.frmBS.scshipf[i].checked==true)
		{
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Special Considerations section before submitting.');
		return false;
	}
	
	return true;	
}

function checkSection6()
{
	var checkFlag = false;
	var cValue = "";
	for (i=0; i<document.frmBS.humanSubjects.length; i++)
	{
		if (document.frmBS.humanSubjects[i].checked==true)
		{
			cValue = document.frmBS.humanSubjects[i].value;
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Compliance section before submitting.');
		return false;
	}
	else if ((checkFlag == true) && (cValue=="Yes"))
	{
		checkFlag = false;
		for (i=0; i<document.frmBS.ccphumanSubjects.length; i++)
		{
			if (document.frmBS.ccphumanSubjects[i].checked==true)
			{
				checkFlag = true;
				break;
			}
		}
		if (checkFlag == false)
		{
			alert('You must answer all questions in Compliance section before submitting.');
			return false;
		}
	}
	
	
	checkFlag = false;
	for (i=0; i<document.frmBS.vAnimals.length; i++)
	{
		if (document.frmBS.vAnimals[i].checked==true)
		{
			cValue = document.frmBS.vAnimals[i].value;
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Compliance section before submitting.');
		return false;
	}
	else if ((checkFlag == true) && (cValue=="Yes"))
	{
		checkFlag = false;
		for (i=0; i<document.frmBS.pvAnimals.length; i++)
		{
			if (document.frmBS.pvAnimals[i].checked==true)
			{
				checkFlag = true;
				break;
			}
		}
		if (checkFlag == false)
		{
			alert('You must answer all questions in Compliance section before submitting.');
			return false;
		}
	}
	
	
	checkFlag = false;
	for (i=0; i<document.frmBS.rDNA.length; i++)
	{
		if (document.frmBS.rDNA[i].checked==true)
		{
			cValue = document.frmBS.rDNA[i].value;
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Compliance section before submitting.');
		return false;
	}
	else if ((checkFlag == true) && (cValue=="Yes"))
	{
		checkFlag = false;
		for (i=0; i<document.frmBS.prDNA.length; i++)
		{
			if (document.frmBS.prDNA[i].checked==true)
			{
				checkFlag = true;
				break;
			}
		}
		if (checkFlag == false)
		{
			alert('You must answer all questions in Compliance section before submitting.');
			return false;
		}
	}
	
	
	checkFlag = false;
	for (i=0; i<document.frmBS.bAgents.length; i++)
	{
		if (document.frmBS.bAgents[i].checked==true)
		{
			cValue = document.frmBS.bAgents[i].value;
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Compliance section before submitting.');
		return false;
	}
	else if ((checkFlag == true) && (cValue=="Yes"))
	{
		checkFlag = false;
		for (i=0; i<document.frmBS.pbAgents.length; i++)
		{
			if (document.frmBS.pbAgents[i].checked==true)
			{
				checkFlag = true;
				break;
			}
		}
		if (checkFlag == false)
		{
			alert('You must answer all questions in Compliance section before submitting.');
			return false;
		}
	}
	
	
	checkFlag = false;
	for (i=0; i<document.frmBS.ccradioMaterials.length; i++)
	{
		if (document.frmBS.ccradioMaterials[i].checked==true)
		{
			cValue = document.frmBS.ccradioMaterials[i].value;
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Compliance section before submitting.');
		return false;
	}
	else if ((checkFlag == true) && (cValue=="Yes"))
	{
		checkFlag = false;
		for (i=0; i<document.frmBS.pradioMaterials.length; i++)
		{
			if (document.frmBS.pradioMaterials[i].checked==true)
			{
				checkFlag = true;
				break;
			}
		}
		if (checkFlag == false)
		{
			alert('You must answer all questions in Compliance section before submitting.');
			return false;
		}
	}
	
	
	checkFlag = false;
	for (i=0; i<document.frmBS.cSubstances.length; i++)
	{
		if (document.frmBS.cSubstances[i].checked==true)
		{
			cValue = document.frmBS.cSubstances[i].value;
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Compliance section before submitting.');
		return false;
	}
	else if ((checkFlag == true) && (cValue=="Yes"))
	{
		checkFlag = false;
		for (i=0; i<document.frmBS.pcSubstances.length; i++)
		{
			if (document.frmBS.pcSubstances[i].checked==true)
			{
				checkFlag = true;
				break;
			}
		}
		if (checkFlag == false)
		{
			alert('You must answer all questions in Compliance section before submitting.');
			return false;
		}
	}
	
	
	checkFlag = false;
	for (i=0; i<document.frmBS.rpMachines.length; i++)
	{
		if (document.frmBS.rpMachines[i].checked==true)
		{
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Compliance section before submitting.');
		return false;
	}
	
	checkFlag = false;
	for (i=0; i<document.frmBS.lDevices.length; i++)
	{
		if (document.frmBS.lDevices[i].checked==true)
		{
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Compliance section before submitting.');
		return false;
	}
	
	checkFlag = false;
	for (i=0; i<document.frmBS.selectAgents.length; i++)
	{
		if (document.frmBS.selectAgents[i].checked==true)
		{
			checkFlag = true;
			break;
		}
	}
	if (checkFlag == false)
	{
		alert('You must answer all questions in Compliance section before submitting.');
		return false;
	}
	
	
	return true;	
}

function Delete()
{
	var bsid = document.getElementById("bs_id").value;
	document.location = "bs_delete.php?bs_id=" + bsid;
}