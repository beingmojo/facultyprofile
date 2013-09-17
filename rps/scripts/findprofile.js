// JavaScript Document

var fpResults=Array();
var fpNoOfRows=Array();
var fpType=Array();
var fpTypeName=Array();
var fpMaxRows=Array();
var _login_id = "Net ID";

function fpInitialize( boxname, type, maxrows )
{
	fpResults[boxname] = new Array();
	fpNoOfRows[boxname] = 0;
	fpMaxRows[boxname] = maxrows;
	fpType[boxname] = type;
	if ((boxname == 'gen_editor1_find') || (boxname == 'gen_editor2_find'))
	{
		fpTypeName[boxname] = "People";
	}
	else
	{
		if( type == 'ppl' || type == 'ppla' || type == 'pplb')
			fpTypeName[boxname] = "Faculty";
		if( type == 'ctr' )
			fpTypeName[boxname] = "Research Center";
		if( type == 'tech' )
			fpTypeName[boxname]  = "Technology";
		if( type == 'fac' )
			fpTypeName[boxname]  = "Facility";
		if( type == 'eqp' )
			fpTypeName[boxname] = "Equipment";
		if( type == 'lab' )
			fpTypeName[boxname]  = "Lab / Group";
	}
}

function fpWritePopup( boxname )
{
	document.write( "<div id='"+ boxname +"_box' style='display:none;z-index:100' onSelectStart='return false'>" );
		document.write( "<div id='" + boxname + "_header' >" );
			document.write( "<span id='"+ boxname + "_caption' >" );
			document.write( "Find " + fpTypeName[boxname] );
			document.write( "</span>" );
			document.write( "<span id='" + boxname + "_close' >" );
				document.write( "<img src='images/buttons/close.gif' onClick='hide_popup(\"" + boxname + "\")'>" );
			document.write( "</span>" );
		document.write( "</div>" );
		document.write( "<div id='" + boxname + "_content' >" );
			document.write( "<iframe id='"+ boxname +"_frame'></iframe>" );
		document.write( "</div>" );
	document.write( "</div>" );		
}

function fpWriteTable( boxname, onlysearch, nomanualentry, pplsearchtype, changerank  )
{
	document.write( "<table id='" + boxname + "_table' width='100%' border='1' cellspacing='0'>" );
		document.write( "<tr id='" + boxname + "_table_header' class='table_background_other'>" );
			document.write( "<td width='3%'>No.</td>" );
			document.write( "<td align='center'>" + fpTypeName[boxname] + "</td>" );
			document.write( "<td width='10%'>&nbsp;</td>" );
		document.write( "</tr>" );
		document.write( "<tr>" );
			document.write( "<td colspan='2'>&nbsp;</td>" );
			document.write( "<td align='center' valign='middle'><a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='show_popup( \"" + boxname + "\",\"sections/gen_find_profile.php?&maxrows=" + fpMaxRows[boxname] + "&type=" + fpType[boxname] + "&boxname=" + boxname + "&typename=" + escape(fpTypeName[boxname]) + "&onlysearch=" + onlysearch + "&pplsearchtype=" + pplsearchtype + "&nomanualentry=" + nomanualentry + "&changerank=" + changerank + "\",500,750)'><img border='0' src='images/buttons/find.gif'>&nbsp;&nbsp;<span class='form_elements_row_action'>Find</span></a></td>" );							
		document.write( "</tr>" );
	document.write( "</table>" );
}

function fpWriteButton( boxname, funcname, onlysearch, nomanualentry, pplsearchtype, changerank )
{
	document.write( "<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='show_popup( \"" + boxname + "\",\"sections/gen_find_profile.php?&maxrows=" + fpMaxRows[boxname] + "&type=" + fpType[boxname] + "&boxname=" + boxname + "&typename=" + escape(fpTypeName[boxname]) + "&funcname=" + funcname + "&onlysearch=" + onlysearch + "&pplsearchtype=" + pplsearchtype + "&nomanualentry=" + nomanualentry + "&changerank=" + changerank + "\",500,750)'><img border='0' alt=\"Find\" src='images/buttons/find.gif'>" );
	if( onlysearch != 1 )
	{
		document.write( "&nbsp;&nbsp;<span class='form_elements_row_action'>Find</span>" );
	}
	document.write( "</a>" );
}

function createFindProfileRow( boxname, type, funcname, onlysearch, nomanualentry, pplsearchtype, changerank )
{
	fpInitialize( boxname, type, 1 );
	fpWritePopup( boxname );
	fpWriteButton( boxname, funcname, onlysearch, nomanualentry, pplsearchtype, changerank );
}

function createFindProfileTable( boxname, type, maxrows, onlysearch, nomanualentry, pplsearchtype, changerank )
{
	fpInitialize( boxname, type, maxrows );	
	fpWritePopup( boxname );
	fpWriteTable( boxname, onlysearch, nomanualentry, pplsearchtype, changerank );
}

function fpProcessResults( boxname, results )
{
	var tbl = document.getElementById(boxname+ '_table');
	var lastRow = fpNoOfRows[boxname] ;
	var listofnames = "";
	var iteration;

	if( fpType[boxname] == 'pplb' )
	{
		for( iteration = 0; iteration < results.length; iteration++ )
		{
			var record = results[iteration];
			if( record[13] == 0 )
			{
				listofnames = listofnames + (iteration + 1) + "." + record[0] + "\r\n";
			}
		}
		if( listofnames != "" )
		{
			ans = confirm( "The form cannot be routed electronically because the system cannot determine the department for the follwing people.\r\n" + listofnames + "\r\nPress OK to follow manual routing.\r\nPress Cancel to edit their ranks." );
			if( ans == false )
				return;
		}
	}

	for( iteration = 0; iteration < results.length; iteration++ )
	{
		var row = tbl.insertRow( lastRow + iteration + 1 );
		row.id = 'fpRow_' + boxname + '_' + ( lastRow + iteration );
		var record = results[iteration];

		if( fpType[boxname] == 'ppl' )
			fpResults[ boxname ] [fpNoOfRows[boxname] ] = new Array( record[0], record[1], record[2], record[3], record[4], record[5], record[6], record[7] );
		else if( fpType[boxname] == 'ppla' )
			fpResults[ boxname ] [fpNoOfRows[boxname] ] = new Array( record[0], record[1], record[2], record[3], record[4], record[5], record[6], record[7], record[8], record[9] );
		else if( fpType[boxname] == 'pplb' )
			fpResults[ boxname ] [fpNoOfRows[boxname] ] = new Array( record[0], record[1], record[2], record[3], record[4], record[5], record[6], record[7], record[8], record[9], record[10], record[11], record[12], record[13] );
		else
			fpResults[ boxname] [fpNoOfRows[boxname] ] = new Array( record[0], record[1], record[2] );	

		fpNoOfRows[boxname] ++;
		var cell1 = row.insertCell(0);
		cell1.id = 'fpCell_' + boxname + '_' + ( lastRow + iteration ) + '_0';
		cell1.setAttribute( 'align', 'center' );
		cell1.innerHTML = "<span class='form_elements_text'>" + fpNoOfRows[boxname] + "</span>";
		
		var cell2 = row.insertCell(1);
		cell2.id = 'fpCell_' + boxname + '_' + ( lastRow + iteration ) + '_1';		
		var innerhtml = "<table width='100%'><tr>" ;
		innerhtml = innerhtml + "<td><span class='form_elements_text'><b>";
		if( record[2] != 0 && record[2] != '' )
			innerhtml = innerhtml + "<a href='editprofile.php?pid=" + record[2] + "' target='_blank'>";
		innerhtml = innerhtml + record[0];
		if( record[2] != 0 && record[2] != '' )
			innerhtml = innerhtml + "</a>";		
		innerhtml =  innerhtml  +  "</b>";
		if( ( fpType[boxname] == 'ppl' || fpType[boxname] == 'ppla' || fpType[boxname] == 'pplb' ) && record[1] != '' )
			innerhtml = innerhtml + ", " + record[1];
		var contactinfo = "";
		if( fpType[boxname] == 'ppla' || fpType[boxname] == 'pplb' )
		{
			contactinfo = contactinfo +  ((record[8]=="")?"":"<img src='images/icons/phone_office.gif'>&nbsp;<span class='form_elements_text'>"+record[8]+ "</span>&nbsp;&nbsp;") ;
			contactinfo = contactinfo +  ((record[9]=="")?"":"<img src='images/icons/mail.png'>&nbsp;<span class='form_elements_text'>"+record[9]+ "</span>&nbsp;&nbsp;") ;		
		}
		innerhtml = innerhtml + ( (contactinfo=="") ? "" : "<BR>" + contactinfo );
	
		contactinfo = "";
		if( fpType[boxname] == 'pplb' )
		{
			contactinfo = contactinfo +  ((record[12]=="")?"":"<span class='form_elements_text'>Box: "+record[12]+ "</span>&nbsp;&nbsp;") ;
			contactinfo = contactinfo +  ((record[10]=="")?"":"<span class='form_elements_text'>Room: "+record[10]+ "</span>&nbsp;&nbsp;") ;
			contactinfo = contactinfo +  ((record[11]=="")?"":"<span class='form_elements_text'>"+record[11]+ "</span>") ;		
			contactinfo = ((contactinfo=="")?"":"<img src='images/icons/office.png'>&nbsp;"+contactinfo);
		}
		innerhtml = innerhtml + ( (contactinfo=="") ? "" : "&nbsp;&nbsp;" + contactinfo );
			
		cell2.innerHTML =  innerhtml  +  "</span></td></tr></table>";

		var cellno = 2;
		var lastcell = row.insertCell(cellno);
		lastcell.id = 'fpCell_' + boxname + '_' + ( lastRow + iteration ) + '_' + cellno;
		lastcell.setAttribute( 'align', 'center' );
		lastcell.innerHTML="<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' onclick='fpDeleteFromList( \"" + boxname + "\", " + (lastRow + iteration ) + ")' ><img border='0' alt='Delete' src='images/buttons/deleterow.gif'></a>";
	}
	hide_popup( boxname );
}

function fpDeleteFromList( boxname, index )
{
	var tbl = document.getElementById(boxname + '_table');
	tbl.deleteRow( index + 1 );
	var lastRow = tbl.rows.length;
	for( var itr = index + 1; itr < lastRow - 1; itr ++ )
	{
		var tr = document.getElementById( "fpRow_" + boxname + '_' + itr  );
		tr.id = "fpRow_" + boxname + '_' + ( itr - 1 );
		var td = document.getElementById( "fpCell_" + boxname + '_' + itr + '_0'  );
		td.innerHTML = "<span class='form_elements_text'>" + (itr)+ "</span>";
		td.id = "fpCell_" + boxname + '_' +  (itr - 1 )+ '_0';
		
		td  = document.getElementById( "fpCell_" + boxname + '_' + itr + '_1'  );
		td.id = "fpCell_" + boxname + '_' + (itr - 1 )+ '_1';
		
		var cellno = 2;
		td = document.getElementById( "fpCell_" + boxname + '_' + itr + '_' + cellno);
		td.innerHTML = "<a onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' onclick='fpDeleteFromList(\"" + boxname + "\", " + (itr-1) + ")'><img border='0' alt='Delete' src='images/buttons/deleterow.gif'></a>";
		td.id = "fpCell_" + boxname + '_' + (itr - 1 )+ '_' + cellno;		
	}

	fpResults[boxname].splice( index, 1 );
	fpNoOfRows[boxname] --;
}

function fpUpdateRows( formid, boxname )
{
	var form = document.getElementById( formid );
	var results = fpResults[boxname];
	var cellno = ( fpType[boxname] == 'ppl' ) ? 7 : 2;
	cellno = ( fpType[boxname] == 'ppla' ) ? 9 : cellno;
	cellno = ( fpType[boxname] == 'pplb' ) ? 14 : cellno;
	var input = document.createElement( "input" );
	input.type = 'hidden';
	input.id = boxname + "_rows";
	input.name = boxname + "_rows";
	input.value = fpNoOfRows[boxname];
	form.appendChild( input );

	input = document.createElement( "input" );
	input.type = 'hidden';
	input.id = "find_profile_boxname";
	input.name = "find_profile_boxname";
	input.value = boxname;
	form.appendChild( input );

	input = document.createElement( "input" );
	input.type = 'hidden';
	input.id = boxname + "_type";
	input.name = boxname + "_type";
	input.value = fpType[boxname];
	form.appendChild( input );

	for( var row = 0; row < fpNoOfRows[boxname]; row ++ )
	{
		var record = results[row];
		for( var col = 0; col <= cellno; col ++ )
		{
			input = document.createElement( "input" );
			input.type = 'hidden';
			input.id = boxname + "_" + row + "_" + col;
			input.name = boxname + "_" + row + "_" + col;
			input.value = record[col];
			form.appendChild( input );
		}
	}
}

function cancelFindProfile( boxname )
{
	hide_popup( boxname );
}