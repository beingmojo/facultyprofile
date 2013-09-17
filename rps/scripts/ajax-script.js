//var addrow = "";
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

function OpenPage(id)
{
	var uri = "viewfunding.php?id="+id;
	var xmlhttp = getHTTPObject();
	var fieldname = "viewfunding"+id;
	var imagename = "arrow"+id;
	xmlhttp.open("GET", uri, true);
	xmlhttp.onreadystatechange = function() 
	{
		if (xmlhttp.readyState==4) 
		{
			if( xmlhttp.status == 200 )
			{
				if(document.getElementById(fieldname).style.display=='none')
				{
					document.getElementById(fieldname).innerHTML = xmlhttp.responseText;
					document.getElementById(fieldname).style.display='';
				}
				else
					document.getElementById(fieldname).style.display='none';
			}
			else
			{
				alert( "Unable to show funding opportunity details : " + xmlhttp.status );
			}
		}
	}
	xmlhttp.send(null)
}
function ShowOptions(div,divtext,status)
{
	if( status == 1)
	{
		document.getElementById(div).style.display='';
		if(div =='cat2')
		{
			var field1 = "'cat1'";
			var field2 = "'cat2'";
			var divtext1="'cattext'";
			var functionname= "ShowOptions("+field1+","+divtext1+",0);";
			functionname = functionname+"ShowOptions("+field2+","+divtext1+",0);";
			document.getElementById(divtext).innerHTML = "[ <a onclick="+functionname+" style=\"cursor:pointer\">Collapse</a> ]";
		}
	}
	else
	{
		document.getElementById(div).style.display='none';
		if(div =='cat2')
		{
			var field1 = "'cat1'";
			var field2 = "'cat2'";
			var divtext1="'cattext'";
			var functionname= "ShowOptions("+field1+","+divtext1+",1);";
			functionname = functionname+"ShowOptions("+field2+","+divtext1+",1);";
			document.getElementById(divtext).innerHTML = "[ <a onclick="+functionname+" style=\"cursor:pointer\">Expand</a> ]";

		}
	}
}

function putFocus(id) 
{
	document.getElementById(id).focus();
}

function textCounter(field, cntfield, maxlimit) 
{
	rem_length = maxlimit - document.getElementById(field).value.length
	document.getElementById(cntfield).innerHTML = rem_length + " characters left.";
}

function GoBack()
{
	document.getElementById("form_preview_page").style.display = 'none';
	document.getElementById("form_preview").style.display = 'none';
	document.getElementById("main_form").style.display = '';
	window.scroll(0,0);
}

function SignUp()
{
	var emailtype = "";
	var email = document.getElementById('Email').value;
	var radios = document.getElementsByTagName('input');
	for(i=0;i<radios.length;i++)
		if (radios[i].type == 'radio')
			if (radios[i].checked == true)
				emailtype = radios[i].value;

	if (CheckForEmail(email))
	{
		alert("Please wait a few seconds while the records are updated...");
		var uri = "funding/funding_signup.php?fullname="+document.getElementById('FullName').value+"&email="+document.getElementById('Email').value+"&role="+document.getElementById('Role').value+"&solution="+document.getElementById('Solutions').value+"&emailupdates="+document.getElementById('EmailUpdates').checked+"&emailtype="+emailtype+"&fon="+document.getElementById("FundingOppNumber").value+"&discloseinfo="+document.getElementById('disclosePref').value+"&loginId="+document.getElementById('LoginID').value;
		var xmlhttp = getHTTPObject();
		xmlhttp.open("GET", uri, true);
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState==4) 
			{
				if( xmlhttp.status == 200 )
				{
					if (xmlhttp.responseText == "1")
						document.getElementById("innerSignUpRow").innerHTML = '<table border="0" id="innerSignUpTable"><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td>Thank you. You have successfully signed up to receive updates on this funding opportunity.<br><br></td></tr></table>';
					else
					{
						document.getElementById("innerSignUpRow").innerHTML = '<table border="0" id="innerSignUpTable"><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td>'+xmlhttp.responseText+'<br><br></td></tr></table>';							
					}
				}
				else
				{
					alert( "Unable to signup for this funding opportunity right now. Error Code: " + xmlhttp.status );
				}
			}
		}
		xmlhttp.send(null)
	}
	else
	{
		alert("Invalid email address");
		document.getElementById('Email').value = "";
		document.getElementById('Email').focus();
	}
}

function CheckForEmail(email)
{
	if ((email==null)||(email=="")){
		return false
	}
	if (echeck(email)==false){
		return false
	}
	return true
}

function echeck(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID")
	   return false
	}

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   return false
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		return false
	}

	 if (str.indexOf(at,(lat+1))!=-1){
		return false
	 }

	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		return false
	 }

	 if (str.indexOf(dot,(lat+2))==-1){
		return false
	 }
	
	 if (str.indexOf(" ")!=-1){
		return false
	 }
	 return true					
}
function BulkSignOff()
{
	document.getElementById('BulkSignUp').style.display='none';
}

function AddEmail(tblName)
{
	var tbl = document.getElementById(tblName);
	var newRow = tbl.insertRow(tbl.rows.length - 7);
	var newCell = newRow.insertCell(0);
	newCell.innerHTML = "";
	var newCell = newRow.insertCell(1);
	newCell.align = "left";
	newCell.innerHTML = "<strong>Name: </strong><input type=\"text\" name=\"AddName\" id=\"AddEmail\" size=\"30\" /><br /><strong>Email: &nbsp;</strong><input type=\"text\" name=\"AddEmail\" id=\"AddEmail\" size=\"30\" />";
	var newCell = newRow.insertCell(2);
	newCell.align = "left";
	newCell.innerHTML = "<textarea rows=\"3\" cols=\"35\" name=\"AddRole\" id=\"AddEmail\"></textarea>";
	var newCell = newRow.insertCell(3);
	newCell.innerHTML ="";
}

function SendSignUpInfo(type)
{
	totalProfiles = document.getElementById("profileCount").value;

	//alert (totalProfiles);
	var inputs = document.getElementsByTagName("input");
	var roles = document.getElementsByTagName("textarea");

	var addemail = new Array();
	var moreprof = 0;
	var querystring = "";
	var emailtype = "";
//var uri = "funding_signup.php?fullname="+document.getElementById('FullName').value+"&email="+document.getElementById('Email').value+"&role="+document.getElementById('Role').value+"&emailupdates="+document.getElementById('EmailUpdates').checked+"&fon="+document.getElementById("FundingOppNumber").value+"&discloseinfo="+document.getElementById('Disclose').checked;
	for (i=0; i<inputs.length; i++)
	{
		if (inputs[i].name == 'AddName')
		{
			addemail[moreprof] = inputs[i].value;
			moreprof+=3;
		}
		if ((inputs[i].type == 'radio')&&(inputs[i].checked == true))
			emailtype = inputs[i].value;
	}
	moreprof = 1;
	for (i=0; i<inputs.length; i++)
	{
		if (inputs[i].name == 'AddEmail')
		{
			addemail[moreprof] = inputs[i].value;
			moreprof+=3;
		}
	}
	moreprof = 2;
	for (i=0; i<roles.length; i++)
	{
		if (roles[i].name == 'AddRole')
		{
			addemail[moreprof] = roles[i].value;
			moreprof+=3;
		}
	}
	querystring += "&externalemail=" + addemail.length;
	for (i=0; i<addemail.length; i++)
		querystring += "&addemail" + i + "=" + addemail[i];

	querystring += "&fon=" + document.getElementById("FON").value;
	querystring += "&totalProfiles=" + totalProfiles;
	querystring += "&message=" + document.getElementById("message").value;
//	alert (document.getElementById("message").value);
	querystring += "&solution=" + document.getElementById("solutions").value;
//	alert (document.getElementById("addcomments").value);
	querystring += "&discloseinfo=" + document.getElementById("disclosePref").value;
//	alert (document.getElementById("disclosePref").value);
	querystring += "&emailtype=" + emailtype;
//	alert (emailtype);
	for(i=1; i<=totalProfiles; i++)
	{
		//alert (document.getElementById("profileName"+i).value);
		querystring += "&name" + i + "=" + document.getElementById("profileName"+i).value;
		//alert (document.getElementById("profilePID"+i).value);
		querystring += "&pid" + i + "=" + document.getElementById("profilePID"+i).value;
		//alert (document.getElementById("ownerLoginId"+i).value);
		querystring += "&owner" + i + "=" + document.getElementById("ownerLoginId"+i).value;
		//alert (document.getElementById("typeId"+i).value);
		querystring += "&type" + i + "=" + document.getElementById("typeId"+i).value;
		querystring += "&role" + i + "=" + document.getElementById("profileRole"+i).value;
	}
	if (type == "bulk")
		var uri = "funding/funding_signup.php?bulk=1" + querystring;
	else
		var uri = "funding/funding_signup.php?preview=1" + querystring;
	var xmlhttp = getHTTPObject();
	xmlhttp.open("GET", uri, true);
	xmlhttp.onreadystatechange = function() 
	{
		if (xmlhttp.readyState==4) 
		{
			if( xmlhttp.status == 200 )
			{
				if (xmlhttp.responseText == "1")
					document.getElementById("BulkSignUp").innerHTML = '<table border=0 width="100%" style="border: 1px dashed #CCCCCC" class="form_elements"><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td align=center>Thank you. Participants successfully signed up to receive updates on this funding opportunity.<br><br><input type=button value=" Done " onclick="BulkSignOff()"></td></tr></table>';
				else
				{
					//alert(xmlhttp.responseText);
					var prev = document.getElementById("Preview");
					var message = document.getElementById("message").value;
					var solutions = document.getElementById("solutions").value;
					prev.innerHTML = '<table border=0 width="100%" style="border: 1px dashed #CCCCCC" class="form_elements" id=\"Prev\"><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td width=\"20%\">&nbsp;</td><td colspan=\"2\">'+xmlhttp.responseText+'<br /><br /><input type=button value="Done" onclick="Preview()"></td><td width=\"20%\">&nbsp;</td></tr></table>';
					//prev.innerHTML = '<table border=0 width="100%" style="border: 1px dashed #CCCCCC" class="form_elements" id=\"Prev\"><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td width=\"20%\">&nbsp;</td><td colspan=\"2\">Hello,<br />'+message+'<br /><br />You have been successfully signed up for the following funding opportunity by: '+xmlhttp.responseText+'<br /><br />You will receive email updates on this funding opportunity<br /><br />Solutions still needed: '+solutions+'<br /><br /><input type=button value="Done" onclick="Preview()"></td><td width=\"20%\">&nbsp;</td></tr></table>';
					prev.style.display = '';
 					//alert( "Unable to signup for this funding opportunity right now. Error Code: 45");
				}
			}
			else
			{
				alert( "Unable to signup for this funding opportunity right now. Error Code: " + xmlhttp.status );
			}
		}
	}
	xmlhttp.send(null)
}

function BulkSignUp()
{
	var profileNumber = 0;
	var bsuDiv = document.getElementById("BulkSignUp");
	var html = new String("<table border=0 width='100%' style='border: 1px dashed #CCCCCC' id='collaborateTable' class=\"form_elements\"><radio><tr><td colspan='4'><br></td></tr><tr><td width='20%'>&nbsp;</td><td colspan=2 align=left><strong>General Message and Comments:</strong><br><textarea rows=5 cols=63 id='message'></textarea></td><td width='20%'>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td width='20%'>&nbsp;</td><td width='30%'><b>Name/Center</b></td><td width=30%><b>Suggested Role</b></td><td width='20%'>&nbsp;</td></tr><checkbox><tr><td colspan='3' align='right'><input type='button' onclick='AddEmail(\"collaborateTable\")' value='Add More Email Addresses'/></td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td></td><td colspan=2 align=left><strong>Solutions still needed:</strong><br><textarea rows=4 cols=63 id='solutions'></textarea></td><td></td></tr><tr><td>&nbsp;</td><td colspan='3' align='left'><strong>Display Preference:</strong>&nbsp;<select name=\"disclosePref\" id=\"disclosePref\" size=\"1\"><option value=\"0\">Disclose Publicly</option><option value=\"1\">Private Message</option><option value=\"2\">Disclose to everyone within my university</option><option value=\"3\" disabled=\"disabled\">Disclose to everyone within my university system</option><option value=\"4\" disabled=\"disabled\">Disclose to everyone within my state</option></select></td></tr><tr><td colspan='4'>&nbsp;</td></tr><tr><td>&nbsp;</td><td colspan=\"3\"><strong>Email Type:</strong>&nbsp;<input type=\"radio\" name=\"emailtype\" value=\"0\" checked=\"checked\">HTML&nbsp;<input type=\"radio\" name=\"emailtype\" value=\"1\">Plaintext</td></tr><tr><td>&nbsp;</td></tr><tr><td colspan='4' align=center><input type=button value=' Preview ' onclick='SendSignUpInfo(\"preview\")'>  <input type=button value=' Sign Up ' onclick='SendSignUpInfo(\"bulk\"); alert(\"Please wait a few seconds while the records are updated...\");'> <profileCount> <input type=button value=' Done ' onclick='BulkSignOff()'></td></tr></table>");
	var radio = "";
	var checkbox = "";
	var technical = "";
	var inputs = document.getElementsByTagName("input");
	for(i=0; i<inputs.length; i++)
	{
		if (inputs[i].type == 'radio')
		{
			prefix = inputs[i].id.toString().substring(0,4);
			if (prefix == 'fopp')
			{
				if (inputs[i].checked == true)
				{
					radio += '<tr bgcolor=#CCCCCC><td width=20% bgcolor=#FFFFFF>&nbsp;</td><td colspan=2 align=center><b>Bulk SignUp for FundingOppNumber: ' + inputs[i].value + '<input type=hidden id="FON" value="' + inputs[i].value + '"></td><td width=20% bgcolor=#FFFFFF>&nbsp;</td></tr>';
					//alert(inputs[i].id.toString());
				}
			}
		}
		else if (inputs[i].type == 'checkbox')
		{
			//alert(inputs[i].id.toString());
			prefix = inputs[i].id.toString().substring(0,4);
			if (prefix == 'prof')
			{
				if (inputs[i].checked == true)
				{
					profileNumber++;
					moretech = 0;
					var seperate = inputs[i].alt;
					var result_array = seperate.split("~");
					if ((result_array[0] == inputs[i].name) || (result_array[0] == ""))
						primcontact = "";
					else
					{
						if ((result_array[2] == 3) && (result_array[3])) 
						{
							primcontact = "<br /><img src=\"images/nobullet.gif\"><strong>Primary Contact(s): </strong>";
							for (j=0; j<result_array.length - 1; j+=3)
							{
								primcontact += "<br /><img src=\"images/nobullet.gif\">" +result_array[j];
								moretech++;
								//alert(moretech);
							}
						}
						else
							primcontact = "<br /><img src=\"images/nobullet.gif\"><strong>Primary Contact(s): </strong><br /><img src=\"images/nobullet.gif\">" + result_array[0];
					}
					
					checkbox += "<tr><td></td><td align=left valign=top>"+inputs[i].name+" "+primcontact+"</td><td align=left>";
					if (moretech)
					{
						j = 1;
						while (moretech)
						{
							checkbox += "<input type=hidden id='profileName"+profileNumber+"' value='"+result_array[j-1]+"'><input type=hidden id='profilePID"+profileNumber+"' value='"+inputs[i].value+"'><input type=hidden id='ownerLoginId"+profileNumber+"' value='"+result_array[j]+"'><input type=hidden id='typeId"+profileNumber+"' value='"+result_array[2]+"'><textarea rows=3 cols=35 id='profileRole"+profileNumber+"'></textarea><br>";
							moretech--;
							if (moretech)
								profileNumber++;
							j += 3;
						}
					}
					else
						checkbox += "<input type=hidden id='profileName"+profileNumber+"' value='"+result_array[0]+"'><input type=hidden id='profilePID"+profileNumber+"' value='"+inputs[i].value+"'><input type=hidden id='ownerLoginId"+profileNumber+"' value='"+result_array[1]+"'><input type=hidden id='typeId"+profileNumber+"' value='"+result_array[2]+"'><textarea rows=3 cols=35 id='profileRole"+profileNumber+"'></textarea>";
					
					checkbox += "</td><td></td></tr><tr><td>&nbsp;</td></tr>";
				}
			}
		}
	}
	html = html.replace("<radio>", radio);
	html = html.replace("<checkbox>", checkbox);
	html = html.replace("<profileCount>", "<input type=hidden id='profileCount' value='"+profileNumber+"'>");
	if (radio == "")
	{
		alert("You must select a funding opportunity first.");
	}
	else if (checkbox == "")
	{
		alert("You must select atleast one profile.");
	}
	else
	{
		bsuDiv.innerHTML = html;
		blurr();
		bsuDiv.style.display = '';
	}
}

function toggle(elID)
{
	var el = document.getElementById(elID);
	if (el.style.display == 'none')
	{
		el.style.display = '';
	}
	else
		el.style.display = 'none';
}

function changeDispPref(profile, num, nextnum)
{
	var querystring = "updateinfo=1";
	var inputs = document.getElementsByTagName("input");
	var selects = document.getElementsByTagName("select");
	for (i=0; i<selects.length; i++)
		if (selects[i].name+selects[i].alt+selects[i].id == profile)
		{
			querystring += "&id=" + selects[i].name;
			querystring += "&fon=" + selects[i].alt;
			querystring += "&login=" + selects[i].id;
			querystring += "&selected=" + selects[i].value;
		}
	for (i=0; i<inputs.length; i++)
		if ((inputs[i].type == 'checkbox')&&(inputs[i].id == 'EmailUpdates')&&(inputs[i].name+inputs[i].alt+inputs[i].value == profile))
		{
			var id = inputs[i].name;
			var fon = inputs[i].alt;
			var login = inputs[i].value;
			querystring += "&id=" + inputs[i].name;
			querystring += "&fon=" + inputs[i].alt;
			querystring += "&login=" + inputs[i].value;
			querystring += "&checked=" + inputs[i].checked;
		}
			var uri = "funding/disppref.php?" + querystring;
			var xmlhttp = getHTTPObject();
			xmlhttp.open("GET", uri, true);
			xmlhttp.onreadystatechange = function() 
			{
				if (xmlhttp.readyState==4) 
				{
					if( xmlhttp.status == 200 )
					{
						if (xmlhttp.responseText)
							if (document.getElementById('editpref'+num).style.display == '') 
							{
								document.getElementById('editpref'+num).style.display = 'none'; 
								document.getElementById('editpref'+nextnum).style.display = ''; 
								document.getElementById('changepref'+num).innerHTML = 'Cancel';
							} 
							else 
							{ 
								document.getElementById('editpref'+num).innerHTML = xmlhttp.responseText; 
								document.getElementById('editpref'+num).style.display = ''; 
								document.getElementById('editpref'+nextnum).style.display = 'none'; 
								document.getElementById('changepref'+num).innerHTML = 'Edit'; 
							}
						else
						{
							alert (xmlhttp.responseText);
							alert( "Unable to signup for this funding opportunity right now. Error Code: 45");
						}
					}
					else
					{
						alert( "Unable to signup for this funding opportunity right now. Error Code: " + xmlhttp.status );
					}
				}
			}
			xmlhttp.send(null);
		
}

function roleedit(profile, num, nextnum)
{
	var querystring = "updateinfo=1";
	var textareas = document.getElementsByTagName("textarea");
	for (i=0; i<textareas.length; i++)
		if (textareas[i].name+textareas[i].alt+textareas[i].id == profile)
		{
			querystring += "&id=" + textareas[i].name;
			querystring += "&fon=" + textareas[i].alt;
			querystring += "&login=" + textareas[i].id;
			querystring += "&role=" + textareas[i].value;
		}

	var uri = "funding/editrole.php?" + querystring;
//	alert (querystring);
	var xmlhttp = getHTTPObject();
	xmlhttp.open("GET", uri, true);
	xmlhttp.onreadystatechange = function() 
	{
		if (xmlhttp.readyState==4) 
		{
			if( xmlhttp.status == 200 )
			{
				if (xmlhttp.responseText)
				{
					if (document.getElementById('editrole'+num).style.display == '') 
					{
						document.getElementById('editrole'+num).style.display = 'none'; 
						document.getElementById('editrole'+nextnum).style.display = ''; 
						document.getElementById('rolechange'+num).innerHTML = 'Cancel';
					} 
					else 
					{ 
						document.getElementById('editrole'+num).innerHTML = xmlhttp.responseText; 
						document.getElementById('editrole'+num).style.display = ''; 
						document.getElementById('editrole'+nextnum).style.display = 'none'; 
						document.getElementById('rolechange'+num).innerHTML = 'Edit'; 
					}
				}
				else
				{
					alert (xmlhttp.responseText);
					alert( "Unable to signup for this funding opportunity right now. Error Code: 45");
				}
			}
			else
			{
				alert( "Unable to signup for this funding opportunity right now. Error Code: " + xmlhttp.status );
			}
		}
	}
	xmlhttp.send(null);
}

function Preview()
{
	document.getElementById('Preview').style.display='none';
}

window.onload = function blurr()
{
	if (document.getElementsByTagName) 
	{
		var s = document.getElementsByTagName("select");
		if (s.length > 0)
		{
			window.select_current = new Array();
			for (var i=0, select; select = s[i]; i++)
			{
				select.onfocus = function(){ window.select_current[this.id] = this.selectedIndex; }
				select.onchange = function(){ restore(this); }
				emulate(select);
			}
		}
	}
}

function restore(e)
{
	if (e.options[e.selectedIndex].disabled)
		e.selectedIndex = window.select_current[e.id];
}
function emulate(e)
{
	for (var i=0, option; option = e.options[i]; i++)
		if (option.disabled)
			option.style.color = "graytext";
		else
			option.style.color = "menutext";
}

/*function confirmdel(id, fon, login)
{
	var response = confirm("Are you sure you want to remove this funding opportunity");
	if (response == true)
	{
		var uri = "funding/deletefopp.php?del_id=id&fon=fon&login=login";
		var xmlhttp = getHTTPObject();
		xmlhttp.open("GET", uri, true);
		xmlhttp.onreadystatechange = function() 
		{
			if (xmlhttp.readyState==4) 
			{
				if( xmlhttp.status == 200 )
				{
					if (xmlhttp.responseText == "1")
						toggle("displayPref"+id+fon+login);
					else
					{
						alert (xmlhttp.responseText);
						alert( "Unable to signup for this funding opportunity right now. Error Code: 45");
					}
				}
				else
				{
					alert( "Unable to signup for this funding opportunity right now. Error Code: " + xmlhttp.status );
				}
			}
		}
		xmlhttp.send(null);
	}
}*/