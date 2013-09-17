var ie5=document.all&&document.getElementById;
var ns6=document.getElementById&&!document.all;
var timer;

function iecompattest(){
return (!window.opera && document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
}

function add_row( boxname, rownum )
{
	document.getElementById(boxname+"_"+rownum+"_add_row").className="visiblerow";
	return false;
}
function cancel_add_row( boxname, rownum )
{
	document.getElementById(boxname+"_"+rownum+"_add_row").className="hiddenrow";
	document.getElementById(boxname+"_"+rownum+"_add_form").reset();
	return false;
}

function edit_row( boxname, rownum )
{
	document.getElementById(boxname+"_"+rownum+"_view_row").className="hiddenrow";
	document.getElementById(boxname+"_"+rownum+"_edit_row").className="visiblerow";
	return false;
}
function cancel_edit_row( boxname, rownum )
{
	document.getElementById(boxname+"_"+rownum+"_edit_row").className="hiddenrow";
	document.getElementById(boxname+"_"+rownum+"_view_row").className="visiblerow";
	document.getElementById(boxname+"_"+rownum+"_edit_form").reset();
	return false;
}

function add_box( boxname )
{
	document.getElementById(boxname+"_add_form").clicked.value = '1';
	document.getElementById(boxname+"_add_box").className="visiblebox";
	return false;
}
function cancel_add_box( boxname )
{
	document.getElementById(boxname+"_add_form").clicked.value = '0';
	document.getElementById(boxname+"_add_box").className="hiddenbox";
	document.getElementById(boxname+"_add_form").reset();
	return false;
}

function edit_box( boxname )
{
/*	var inputs = document.getElementsByTagName("input");
	for(var i = 0; i<inputs.length; i++)
	{
		if(inputs[i].name=="clicked")
		{
			alert(inputs[i].name);
			alert(inputs[i].value);
		}
	}
*/
	/*
	if( boxname == "gen_core_section")
		alert("Currently under construction");
	else
	*/
	{
		document.getElementById(boxname+"_edit_form").clicked.value = '1';
		document.getElementById(boxname+"_view_box").className="hiddenbox";
		document.getElementById(boxname+"_edit_box").className="visiblebox";
	}
	return false;
}
function cancel_edit_box( boxname )
{
	document.getElementById(boxname+"_edit_form").clicked.value = '0';
	document.getElementById(boxname+"_edit_box").className="hiddenbox";
	document.getElementById(boxname+"_view_box").className="visiblebox";
	document.getElementById(boxname+"_edit_form").reset();
	return false;
}
function submit_box( boxname, type )
{
	ans = true;	
	// type can be "add", "edit" or "delete"
	if( type == "delete" )
		ans = confirm( "Are you sure to delete this section?\r\n\r\nIf you are sure press OK, else press Cancel." );
	if( ans == true )
		document.getElementById(boxname+"_"+type+"_form").submit();
	return false;
}

function set_field( field, val )
{
	document.getElementById( field ).value = val;
}
 
function submit_row( boxname, rownum, type )
{
	ans = true;	
	// type can be "add", "edit" or "delete"
	if( type == "delete" )
		ans = confirm( "Are you sure to delete this record?\r\n\r\nIf you are sure press OK, else press Cancel." );
	if( ans == true )
		document.getElementById(boxname+"_"+rownum+"_"+type+"_form").submit();
	return false;
}

function show_box( boxname )
{
	if( document.getElementById(boxname+"_add_box") != null )
	{
		if( document.getElementById(boxname+"_add_form").clicked.value == '1' )
			document.getElementById(boxname+"_add_box").className="visiblebox";
	}

	if( document.getElementById(boxname+"_edit_box") != null )
	{
		if( document.getElementById(boxname+"_edit_form").clicked.value == '1' )
			document.getElementById(boxname+"_edit_box").className="visiblebox";
	}

	document.getElementById(boxname+"_view_box").className="visiblebox";
	document.getElementById(boxname+"_show_cell").className="hiddencell";
	document.getElementById(boxname+"_hide_cell").className="visiblecell";
	return false;
}

function hide_box( boxname )
{
	if( document.getElementById(boxname+"_add_box") != null )
		document.getElementById(boxname+"_add_box").className="hiddenbox";

	if( document.getElementById(boxname+"_edit_box") != null )
		document.getElementById(boxname+"_edit_box").className="hiddenbox";

	document.getElementById(boxname+"_view_box").className="hiddenbox";
	document.getElementById(boxname+"_show_cell").className="visiblecell";
	document.getElementById(boxname+"_hide_cell").className="hiddencell";
	return false;
}

function show_popup( windowname, url, win_height, win_width )
{
	var top, left, height, width;
	top = ns6? window.pageYOffset : iecompattest().scrollTop;
	left = ns6? window.pageXOffset : iecompattest().scrollLeft;
	width = ns6? window.innerWidth : iecompattest().clientWidth;
	height = ns6? window.innerHeight : iecompattest().clientHeight;

	if (!ie5&&!ns6)
		window.open(url,"","width=width,height=height,scrollbars=1")
	else
	{
		document.getElementById(windowname+"_header").style.height = 22 + "px";
		document.getElementById(windowname+"_header").style.background = "ActiveCaption";

		document.getElementById(windowname+"_caption").style.position = "absolute";
		document.getElementById(windowname+"_caption").style.left = "5px";
		document.getElementById(windowname+"_caption").style.top = "0px";
		document.getElementById(windowname+"_caption").style.color = "CaptionText";
		document.getElementById(windowname+"_caption").style.fontFamily = "Arial";
		document.getElementById(windowname+"_caption").style.fontSize = "14px";
		document.getElementById(windowname+"_caption").style.fontWeight = "bold";
		document.getElementById(windowname+"_caption").align = "left";
		
		document.getElementById(windowname+"_close").style.position = "absolute";
		document.getElementById(windowname+"_close").style.left = win_width - 21 + "px";
		document.getElementById(windowname+"_close").style.top = 0 + "px";
		document.getElementById(windowname+"_close").align = "right";

		document.getElementById(windowname+"_frame").src=url;
		border = ns6?4:0;
		document.getElementById(windowname+"_frame").width=win_width - border + "px";
		border = ns6?25:22;
		document.getElementById(windowname+"_frame").height=win_height - border + "px";

		document.getElementById(windowname+"_box").style.position = "absolute";
		document.getElementById(windowname+"_box").style.border = "3px ActiveCaption solid";
		document.getElementById(windowname+"_box").style.width=win_width+"px";
		document.getElementById(windowname+"_box").style.height=win_height+"px";
		document.getElementById(windowname+"_box").style.left=left*1 + width/2 - win_width/2 +"px";
		document.getElementById(windowname+"_box").style.top=top*1 + height/2 - win_height/2+"px";
		document.getElementById(windowname+"_box").style.display='';
		
	}	
}

function hide_popup( windowname )
{
	document.getElementById(windowname+"_box").style.display="none";
}

scrollmenutoposition = function()
{
	var top;
	top = ns6? window.pageYOffset : iecompattest().scrollTop;
	if( top > document.getElementById('scrollmenuholder').offsetTop )
		document.getElementById('scrollmenu').style.top = top+"px";
	else
		document.getElementById('scrollmenu').style.top  = document.getElementById('scrollmenuholder').offsetTop+"px";
}

initialize = function()
{
	startList();
	scrollmenutoposition();
	timer = setInterval("scrollmenutoposition()", 500);
}

finalize = function()
{
	clearInterval( timer );
}

function Trim(s) 
{
	// Remove leading spaces and carriage returns
	while ((s.substring(0,1) == ' ') || (s.substring(0,1) == '\n') || (s.substring(0,1) == '\r'))
	{ s = s.substring(1,s.length); }
	
	// Remove trailing spaces and carriage returns
	while ((s.substring(s.length-1,s.length) == ' ') || (s.substring(s.length-1,s.length) == '\n') || (s.substring(s.length-1,s.length) == '\r'))
	{ s = s.substring(0,s.length-1); }
	
	return s;
}

window.onload=initialize;
window.onunload = finalize;
