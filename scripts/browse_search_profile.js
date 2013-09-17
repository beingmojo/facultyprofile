// JavaScript Document
var fpResultsSearch = false;
var fpResultsSelect= false;
var fpNoOfRowsSearch = 0;
var fpNoOfRowsSelect = 0;
var fpLastIndexSelect = 0;
var fpPageSearch = 0;
var fpMaxPageSearch = 0;
var fpPPLSearchType = '';
var fpChangeRank = 0;
var fpType = "";
var fpBoxName = "";
var fpMaxRows = -1;
var http = false;

function fpSendRequest( ) 
{
	if( ! http )
		http = getHTTPObject();
		
	var url = "gen_browse_search_profile.php";
	var query_link = "";
	if( fpType == 'ppl' || fpType == 'ppla' || fpType == 'pplb' )
	{
		var fname = document.getElementById("fname").value;
		var lname = document.getElementById("lname").value;  
		if( fpPPLSearchType == 'list_and_dir' )
		{
			if( document.getElementById("ppl_user_dir").checked == true ) url = "gen_browse_search_user.php";
		}
		if( fpPPLSearchType == 'dir' ) url = "gen_browse_search_user.php";
		query_link = url + "?type=" + escape(fpType) +"&fname=" + escape(fname) + "&lname=" + escape(lname) + "&pageno=" + fpPageSearch;
	}
	else
	{
		var fullname = document.getElementById("fullname").value;  
		query_link = url + "?type=" + escape(fpType) +"&name=" + escape(fullname) + "&pageno=" + fpPageSearch;
	}
	http.open("GET", query_link , true);
	http.onreadystatechange = handleHttpResponse;
	http.send(null);
	
}

function handleHttpResponse() 
{
	if (http.readyState == 4) 
	{
		document.getElementById('find').disabled=false;
		if( http.status == 200 )
		{
			//alert( http.responseText );
			processXML(http.responseXML);
			fpProcessSearchResults();
		}
		else
		{
			alert( "Unable to perform search. HTTP response code : " + http.status );
		}
	}
}

function processXML(obj)
{
	var root = obj.getElementsByTagName(fpType).item(0);
	fpMaxPageSearch = root.getAttribute('maxpage');

	fpPageSearch = root.getAttribute('pageno');

	fpResultsSearch.length = root.childNodes.length;
	fpNoOfRowsSearch = root.childNodes.length;

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

function fpProcessSearchResults( )
{

	var tbl = document.getElementById(fpBoxName+ '_search_table');
	var lastRow = tbl.rows.length;
	var iteration;
//	for( iteration = lastRow - 1; iteration <= lastRow - 2 + noofrows; iteration++ )
	for( iteration = 0; iteration < fpNoOfRowsSearch; iteration++ )
	{
		var row = tbl.insertRow( iteration + 2 );
		
		var record = fpResultsSearch[iteration];
		
		var cell1 = row.insertCell(0);
		cell1.setAttribute( 'align', 'center' );
		cell1.innerHTML = "<span class='form_elements_text'>" + ( (( fpPageSearch - 1 ) * 10 ) + iteration + 1) + "</span>";
		
		var cell2 = row.insertCell(1);
		var innerhtml = "<table width='100%' ><tr>" ;
		if( fpType != 'ppl' && fpType != 'ppla' && fpType != 'pplb')
			innerhtml = innerhtml + "<td width='12px'><img id = '" + fpBoxName + "_search_table_row_img_" + iteration + "' src='../images/buttons/right-arrow.gif' border='0' onclick='fpShowHideDesc(" + iteration + ")' onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' alt='Show Description'></td>";
		innerhtml = innerhtml + "<td><span class='form_elements_text'><b>";
		if( record[2] != 0 && record[2] != '' )
			innerhtml = innerhtml + "<a href='../editprofile.php?pid=" + record[2] + "' target='_blank'>";
		innerhtml = innerhtml + record[0];
		if( record[2] != 0 && record[2] != '' )
			innerhtml = innerhtml + "</a>";		
		innerhtml =  innerhtml  +  "</b>";
		if( (fpType == 'ppl' || fpType == 'ppla' || fpType == 'pplb') && record[1] != '' )
			innerhtml = innerhtml + ", " + record[1];
		var contactinfo = "";
		if( fpType == 'ppla' || fpType == 'pplb' )
		{
			contactinfo = contactinfo +  ((record[8]=="")?"":"<img src='../images/icons/phone_office.gif'>&nbsp;<span class='form_elements_text'>"+record[8]+ "</span>&nbsp;&nbsp;") ;
			contactinfo = contactinfo +  ((record[9]=="")?"":"<img src='../images/icons/mail.png'>&nbsp;<span class='form_elements_text'>"+record[9]+ "</span>&nbsp;&nbsp;") ;		
		}
		innerhtml = innerhtml + ( (contactinfo=="") ? "" : "<BR>" + contactinfo );
		contactinfo = "";
		if( fpType == 'pplb' )
		{
			contactinfo = contactinfo +  ((record[12]=="")?"":"<span class='form_elements_text'>Box: "+record[12]+ "</span>&nbsp;&nbsp;") ;
			contactinfo = contactinfo +  ((record[10]=="")?"":"<span class='form_elements_text'>Room: "+record[10]+ "</span>&nbsp;&nbsp;") ;
			contactinfo = contactinfo +  ((record[11]=="")?"":"<span class='form_elements_text'>"+record[11]+ "</span>") ;		
			contactinfo = ((contactinfo=="")?"":"<img src=../images/icons/office.png>&nbsp;"+contactinfo);
		}
		innerhtml = innerhtml + ( (contactinfo=="") ? "" : "&nbsp;&nbsp;" + contactinfo );
		
		innerhtml = innerhtml + "</span></td></tr>";
		if( fpType != 'ppl' && fpType != 'ppla' && fpType != 'pplb')
			innerhtml =  innerhtml  +  "<tr><td colspan='2'><table width='100%' cellspacing='0' id='" + fpBoxName + "_search_table_row_" + iteration + "' class='hiddenrow'><tr><td><span class='form_elements_text'>" + record[1] +"</span></td></tr></table></td></tr>";
		innerhtml =  innerhtml  +  "</table>";
		cell2.innerHTML =  innerhtml  ;


		if( fpOnlySearch != 1 )
		{
			var cellno = 2;
			var lastcell = row.insertCell(cellno);
			lastcell.setAttribute( 'align', 'center' );
			lastcell.innerHTML="<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' onclick='fpAddToSelectedList(fpResultsSearch[" + iteration + "])' ><img border='0' alt='Add' src='../images/buttons/addrow.gif'></a>";
		}
	}
	
	var footer_cell = document.getElementById( fpBoxName + '_search_table_footer' );
	var innerhtml = "";
	innerhtml = "<table width='100%'><tr><td><span class='form_elements_text'>";
	var counter = 0;
	for( var itr = 1; itr <= fpMaxPageSearch; itr ++ )
	{
		counter ++;
		if( itr == fpPageSearch )
			innerhtml = innerhtml + "&nbsp;<B>" + itr + "</B>&nbsp;";
		else
			innerhtml = innerhtml + "<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' onclick='return fpSearch(\"" + fpBoxName + "\", \"" + fpType + "\", \"" + fpPPLSearchType + "\", " + fpChangeRank + ", " + fpMaxRows + ",  " + itr + ");'>&nbsp;" + itr + "&nbsp;</a>";
		if( counter == 30 )
		{
			innerhtml = innerhtml + "<BR>";
			counter = 0;
		}
	}
	innerhtml = innerhtml + "</span></td><td align='right' width='10%'><span class='form_elements_text'> <a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' onclick='fpClearAllRows( \"search\", true );'>Clear</a></span></td></tr></table>" ;
	footer_cell.innerHTML = innerhtml;
}

function fpShowHideDesc( index )
{
	var td = document.getElementById( fpBoxName + "_search_table_row_" + index );
	var img = document.getElementById( fpBoxName + "_search_table_row_img_" + index );
	if( td.className == 'visiblebox' )
	{
		td.className = 'hiddenbox';
		img.src = "../images/buttons/right-arrow.gif";
		img.alt='Show Description'		
	}
	else
	{
		td.className = 'visiblebox';
		img.src = "../images/buttons/down-arrow.gif";
		img.alt='Hide Description'
	}

}

function fpClearAllRows( boxtype, removerows )
{
	var tbl = document.getElementById( fpBoxName + '_' + boxtype + '_table');
	var lastRow = tbl.rows.length;
	for( var iteration = 2; iteration < lastRow; iteration ++ )
	{
		tbl.deleteRow( 2 );
	}

	if( removerows == true )
	{
		if( boxtype == 'search' )
		{
			fpResultsSearch.length = 0;
			fpPageSearch = 1;
			fpMaxPageSearch = 1;
		}
	}
	var footer_cell = document.getElementById( fpBoxName + '_search_table_footer' );
	footer_cell.innerHTML = "&nbsp;";
	
}
function fpCheckMaxRows()
{
	if( fpMaxRows != -1 && fpNoOfRowsSelect >= fpMaxRows )
	{
		alert( "Please delete existing selected item(s) to add new item(s)." );
		return false;
	}
	else
		return true;

}

function fpAddManualEntry( boxname, type, maxrows )
{
	var record = new Array();
	fpType = type;
	fpBoxName = boxname;
	fpMaxRows = maxrows;
	if( fpCheckMaxRows() == false )
		return false;

	if( fpType == 'ppl' || fpType == 'ppla' || fpType == 'pplb' )
	{	
		record.length = 8;
		title = document.getElementById( 'gen_find_profile_enter_title' ).value;
		lname = document.getElementById( 'gen_find_profile_enter_lname' ).value;
		fname = document.getElementById( 'gen_find_profile_enter_fname' ).value;
		mname = document.getElementById( 'gen_find_profile_enter_mname' ).value;		
		if( lname == "" || fname == "" ) 
		{
			alert("Please provide first & last name.");
			return false;
		}
		record[0] = title + (title != '' ? ' ' : '') + lname + ', ' +  fname + (mname != '' ? ' ' : '') + mname;
		record[1] = document.getElementById( 'gen_find_profile_enter_rank' ).value;		
		record[2] = 0;
		record[3] = '';
		record[4] = title;
		record[5] = lname;
		record[6] = fname;
		record[7] = mname;		

		if( fpType == 'ppla' || fpType == 'pplb' )
		{	
			record.length = 10;
			record[8] = document.getElementById( 'gen_find_profile_enter_phone' ).value;
			record[9] = document.getElementById( 'gen_find_profile_enter_email' ).value;		
		}
		if( fpType == 'pplb' )
		{	
			record.length = 14;
			record[10] = document.getElementById( 'gen_find_profile_enter_roomno' ).value;
			record[11] = document.getElementById( 'gen_find_profile_enter_building' ).value;
			record[12] = document.getElementById( 'gen_find_profile_enter_mailbox' ).value;
			record[13] = document.getElementById( 'gen_find_profile_enter_hid' ).value;
		}

	}
	else
	{
		record.length = 3;
		record[0] = document.getElementById( 'gen_find_profile_enter_name' ).value;
		if( record[0] == "" ) return false;
		updateRTE( 'gen_find_profile_enter_description' );
		record[1] = document.getElementById( 'hdn' + 'gen_find_profile_enter_description' ).value;
		record[2] = 0;
	}
	

	fpAddToSelectedList( record );
	return false;
}

function fpAddToSelectedList( record )
{
	if( fpCheckMaxRows() == false )
		return false;

	if( ! fpResultsSelect )
		fpResultsSelect = new Array();
	
	if( fpType == 'ppl' )
		fpResultsSelect[ fpNoOfRowsSelect ] = new Array( record[0], record[1], record[2], record[3], record[4], record[5], record[6], record[7] );
	else if( fpType == 'ppla' )
		fpResultsSelect[ fpNoOfRowsSelect ] = new Array( record[0], record[1], record[2], record[3], record[4], record[5], record[6], record[7], record[8], record[9] );
	else if( fpType == 'pplb' )
		fpResultsSelect[ fpNoOfRowsSelect ] = new Array( record[0], record[1], record[2], record[3], record[4], record[5], record[6], record[7], record[8], record[9], record[10], record[11], record[12], record[13] );
	else
		fpResultsSelect[ fpNoOfRowsSelect ] = new Array( record[0], record[1], record[2] );	

	var tbl = document.getElementById(fpBoxName+ '_select_table');
	var lastRow = tbl.rows.length;
	fpNoOfRowsSelect++;
	var row = tbl.insertRow( fpNoOfRowsSelect );
	row.id = 'fpRowSelect_' + ( fpNoOfRowsSelect - 1 );
	var record = fpResultsSelect[fpNoOfRowsSelect - 1];
		
	var cell1 = row.insertCell(0);
	cell1.id = 'fpCellSelect_' + ( fpNoOfRowsSelect - 1 ) + "_0" ;
	cell1.setAttribute( 'align', 'center' );
	cell1.innerHTML = "<span class='form_elements_text'>" + fpNoOfRowsSelect + "</span>";
	
	var cell2 = row.insertCell(1);
	cell2.id = 'fpCellSelect_' + ( fpNoOfRowsSelect - 1 ) + "_1" ;
	var innerhtml = "<table width='100%'><tr><td><span class='form_elements_text'><b>";
	if( record[2] != 0 && record[2] != '' )
		innerhtml = innerhtml + "<a href='../editprofile.php?pid=" + record[2] + "' target='_blank'>";
	innerhtml = innerhtml + record[0];
	if( record[2] != 0 && record[2] != '' )
		innerhtml = innerhtml + "</a>";		
	innerhtml = innerhtml + "</b>";
	if( ( fpType == 'ppl' || fpType == 'ppla' || fpType == 'pplb' ) && record[1] != '' )
		innerhtml = innerhtml + ", " + record[1];
	if( fpType == 'pplb' && fpChangeRank == 1 )
	{
		 innerhtml = innerhtml + "&nbsp;<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='show_popup( \"ppl_general_info_pri_rank\",\"ppl_general_info_rank_edit.php?&type=Primary&record="+ (fpNoOfRowsSelect - 1) + "&hid="+record[13]+ "\",450,650)'><img border='0' src='../images/buttons/edit.gif' ></a>" ;
	}
	var contactinfo = "";
	if( fpType == 'ppla' || fpType == 'pplb' )
	{
		contactinfo = contactinfo +  ((record[8]=="")?"":"<img src='../images/icons/phone_office.gif'>&nbsp;<span class='form_elements_text'>"+record[8]+ "</span>&nbsp;&nbsp;") ;
		contactinfo = contactinfo +  ((record[9]=="")?"":"<img src='../images/icons/mail.png'>&nbsp;<span class='form_elements_text'>"+record[9]+ "</span>&nbsp;&nbsp;") ;		
	}
	innerhtml = innerhtml + ( (contactinfo=="") ? "" : "<BR>" + contactinfo );

	contactinfo = "";
	if( fpType == 'pplb' )
	{
		contactinfo = contactinfo +  ((record[12]=="")?"":"<span class='form_elements_text'>Box: "+record[12]+ "</span>&nbsp;&nbsp;") ;
		contactinfo = contactinfo +  ((record[10]=="")?"":"<span class='form_elements_text'>Room: "+record[10]+ "</span>&nbsp;&nbsp;") ;
		contactinfo = contactinfo +  ((record[11]=="")?"":"<span class='form_elements_text'>"+record[11]+ "</span>") ;		
		contactinfo = ((contactinfo=="")?"":"<img src=../images/icons/office.png>&nbsp;"+contactinfo);
	}
	innerhtml = innerhtml + ( (contactinfo=="") ? "" : "&nbsp;&nbsp;" + contactinfo );
		
	cell2.innerHTML =  innerhtml  +  "</span></td></tr></table>";
	
	var cellno = 2;
	var lastcell = row.insertCell(cellno);
	lastcell.id = 'fpCellSelect_' + ( fpNoOfRowsSelect - 1 ) + '_' + cellno;
	lastcell.setAttribute( 'align', 'center' );
	lastcell.innerHTML="<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' onclick='fpDeleteFromSelectedList(" + (fpNoOfRowsSelect - 1) + ")'><img border='0' alt='Delete' src='../images/buttons/deleterow.gif'></a>";
}

function fpDeleteFromSelectedList( index )
{
	var tbl = document.getElementById(fpBoxName+ '_select_table');
	tbl.deleteRow( index + 1 );
	var lastRow = tbl.rows.length;
	for( var itr = index + 1; itr < lastRow - 1; itr ++ )
	{
		var tr = document.getElementById( "fpRowSelect_" + itr  );
		tr.id = "fpRowSelect_" + ( itr - 1 );
		var td = document.getElementById( "fpCellSelect_" + itr + '_0'  );
		td.innerHTML = "<span class='form_elements_text'>" + (itr)+ "</span>";
		td.id = "fpCellSelect_" + (itr - 1 )+ '_0';
		
		td  = document.getElementById( "fpCellSelect_" + itr + '_1'  );
		td.id = "fpCellSelect_" + (itr - 1 )+ '_1';
		
		var cellno =  2;
		td = document.getElementById( "fpCellSelect_" + itr + '_' + cellno);
		td.innerHTML = "<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' onclick='fpDeleteFromSelectedList(" + (itr-1) + ")'><img border='0' alt='Delete' src='../images/buttons/deleterow.gif'></a>";
		td.id = "fpCellSelect_" + (itr - 1 )+ '_' + cellno;		
	}

	fpResultsSelect.splice( index, 1 );
	fpNoOfRowsSelect --;
}

function fpSearch( boxname, type, pplsearchtype, changerank, maxrows, pagenumber )
{
	fpType = type;
	fpBoxName = boxname;
	fpMaxRows = maxrows;
	fpPPLSearchType = pplsearchtype;
	fpChangeRank = changerank;
	if( ! fpResultsSearch )
		fpResultsSearch = new Array();
	fpClearAllRows( 'search', true );	
	fpPageSearch = pagenumber;
	document.getElementById('find').disabled=true;
	fpSendRequest();
	return false;
	//fpProcessSearchResults( );
}

function ChangeRank(rank, hid_list, type, record_no)
{
	if( record_no == "" )
	{
		document.getElementById("gen_find_profile_enter_rank").value = rank;
		document.getElementById("gen_find_profile_enter_hid").value = hid_list;
	}
	else
	{
		fpResultsSelect[ record_no ][1] = rank;
		var cell = document.getElementById("fpCellSelect_" + record_no + '_1');
		
		var record = fpResultsSelect[ record_no ] ;
		var innerhtml = "<table width='100%'><tr><td><span class='form_elements_text'><b>";
		if( record[2] != 0 && record[2] != '' )
			innerhtml = innerhtml + "<a href='../editprofile.php?pid=" + record[2] + "' target='_blank'>";
		innerhtml = innerhtml + record[0];
		if( record[2] != 0 && record[2] != '' )
			innerhtml = innerhtml + "</a>";		
		innerhtml = innerhtml + "</b>";
		if( ( fpType == 'ppl' || fpType == 'ppla' || fpType == 'pplb' ) && record[1] != '' )
			innerhtml = innerhtml + ", " + record[1];
		if( fpType == 'pplb' && fpChangeRank == 1 )
		{
			 innerhtml = innerhtml + "&nbsp;<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='show_popup( \"ppl_general_info_pri_rank\",\"ppl_general_info_rank_edit.php?&type=Primary&record="+ (fpNoOfRowsSelect - 1) + "&hid="+record[13]+ "\",450,650)'><img border='0' src='../images/buttons/edit.gif' ></a>" ;
		}
		var contactinfo = "";
		if( fpType == 'ppla' || fpType == 'pplb' )
		{
			contactinfo = contactinfo +  ((record[8]=="")?"":"<img src='../images/icons/phone_office.gif'>&nbsp;<span class='form_elements_text'>"+record[8]+ "</span>&nbsp;&nbsp;") ;
			contactinfo = contactinfo +  ((record[9]=="")?"":"<img src='../images/icons/mail.png'>&nbsp;<span class='form_elements_text'>"+record[9]+ "</span>&nbsp;&nbsp;") ;		
		}
		innerhtml = innerhtml + ( (contactinfo=="") ? "" : "<BR>" + contactinfo );
	
		contactinfo = "";
		if( fpType == 'pplb' )
		{
			contactinfo = contactinfo +  ((record[12]=="")?"":"<span class='form_elements_text'>Box: "+record[12]+ "</span>&nbsp;&nbsp;") ;
			contactinfo = contactinfo +  ((record[10]=="")?"":"<span class='form_elements_text'>Room: "+record[10]+ "</span>&nbsp;&nbsp;") ;
			contactinfo = contactinfo +  ((record[11]=="")?"":"<span class='form_elements_text'>"+record[11]+ "</span>") ;		
			contactinfo = ((contactinfo=="")?"":"<img src=../images/icons/office.png>&nbsp;"+contactinfo);
		}
		innerhtml = innerhtml + ( (contactinfo=="") ? "" : "&nbsp;&nbsp;" + contactinfo );
			
		cell.innerHTML =  innerhtml  +  "</span></td></tr></table>";
	}
	hide_popup( "ppl_general_info_pri_rank" );
}


function CancelChangeRank(type, record)
{
	hide_popup( "ppl_general_info_pri_rank" );	
}