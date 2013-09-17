/***************************************************
              Message scroller script
      Written by Mark Wilton-Jones, 5/2002
Revised 19/02/2003 - NOT COMPATIBLE WITH ORIGINAL!!!
    - initial iframe page no longer required -
****************************************************

Please see http://www.howtocreate.co.uk/jslibs/ for details and a demo of this script
Please see http://www.howtocreate.co.uk/jslibs/termsOfUse.html for terms of use

This script uses clipping on browsers that support it and iframes on browsers that
do not.

You can have an unlimited number of scrollers on the page, although Netscape 4 has a
habit of ignoring inline stylesheets in all except the last scroller when you do,
instead inheriting the non css link style from the main document. You can still
style the text with normal HTML, although you will have no control over underlines, eg.
<a href="blah"><b><font color="#007700">Link text</font></b></a>

This script requires access to the window onload event so you will not be able to
do <body onload="whatever">. I did program this without that requirement, but I hit
bugs in both Netscape 4 and Opera.

To use:
_________________________________________________________________________

Inbetween the <head> tags, put:

	<script src="PATH TO SCRIPT/msgscroll.js" type="text/javascript" language="javascript1.2"></script>
_________________________________________________________________________

Wherever you want to put a scroller, add the following:

	<script type="text/javascript" language="javascript1.2"><!--

//firstly, tell my script what you want the scroller to look like
var myScrollerThing = new msgScroller(
	50, //height of the scroller (the scrolling part of it, not the border)
	400, //width of the scroller (the scrolling part of it, not the border)
	20, //height required by the text in the scroller, usually about 20 per line
	    //(if the text wraps onto the line beneath it, you will need 40 etc.)
	10, //thickness of the border around the scroller
	'#ff0000', //colour of the border around the scroller
	75, //scrolling delay - 75 is about right
	3000, //pause time (set to same as scrolling delay for no pause)
	0, //distance from the top that you want the scroller to pause
	'#0000ff' //background colour for the scroller
);

//then define all messages. You can add to these as you go along if you like. You can even use images . . .
//Use target="_top" or target="_blank" to avoid loading into the iframe
//ALL styling must be done here. Browsers may or may not inherit stylesheets from your page - don't rely on it
myScrollerThing.msgArray[0] = '<a href="http://www.howtocreate.co.uk" target="_top" style="text-decoration:none;color:#000077;font-weight:bold;">HTML, CSS, JavaScript and website design tutorials</a>';
myScrollerThing.msgArray[1] = '<a href="http://www.ukcaves.co.uk" target="_top" style="text-decoration:none;color:#000077;font-weight:bold;">Database of British caves</a>';
myScrollerThing.msgArray[2] = '<a href="http://www.freegames.uk.eu.org" target="_top" style="text-decoration:none;color:#000077;font-weight:bold;">Free (to play) JavaScript games</a>';
myScrollerThing.msgArray[3] = '<a href="http://www.cavinguk.co.uk" target="_top" style="text-decoration:none;color:#000077;font-weight:bold;">Caving in Britain and especially South Wales</a>';

//finally, tell the browser to create the scroller
myScrollerThing.buildScroller();

	//--></script>
_________________________________________________________________________*/

//an array containing information about all scrollers
var MWJScrollers = new Array();
//Opera 5, 6 and iCab are special - they use an iframe
var MWJ_isOpera6 = ( navigator.userAgent.toLowerCase().indexOf( 'opera' ) + 1 && !document.childNodes ) || ( window.ScriptEngine && ScriptEngine().indexOf( 'InScript' ) + 1 );

function getRefToDivNest( divID, oDoc ) {
	if( !oDoc ) { oDoc = document; }
	if( document.layers ) {
		if( oDoc.layers[divID] ) { return oDoc.layers[divID]; } else {
		for( var x = 0, y; !y && x < oDoc.layers.length; x++ ) {
			y = getRefToDivNest(divID,oDoc.layers[x].document); }
			return y; } }
	if( document.getElementById ) { return document.getElementById(divID); }
	if( document.all ) { return document.all[divID]; }
	return document[divID];
}

function reWriteSCRL(oDiv,oFrame,oString) {
	if( MWJ_isOpera6 ) {
		//Opera 5 & 6 and iCab do not allow layers to be re-written / clipped, so I use an iframe - location about:blank
		var oContent = window.opera ? window.open('',oFrame) : window.frames[oFrame].window; //this makes a small flicker - if I don't do this it won't work in Op 6
		oContent.document.open('text/html','replace'); //iframe syntax - do not add to history
		oContent.document.write('<html><head><title>Dynamic content</title></head><body>'+oString+'</body></html>');
		oContent.document.close();
	} else {
		//I use layers (NS && DOM) to provide re-writing and clipping.
		//Konq2 cannot scroll iframes or clip so it should produce a moving layer, but does not.
		var oContent = getRefToDivNest(oDiv); if( !oContent ) { oContent = new Object(); }
		if( oContent.document && oContent.document != document ) {
			oContent.document.open(); //Separate contents syntax
			oContent.document.write('<html><head><title>Dynamic content</title></head><body>'+oString+'</body></html>');
			oContent.document.close();
		} else {
			oContent.innerHTML = oString;
		}
	}
}

function createScroller() {
	if( document.layers ) {
		//create the border with an ilayer
		document.write('<ilayer left="0" top="0" height="' + ( this.height + ( this.border[0] * 2 ) ) + '" width="' + ( this.width + ( this.border[0] * 2 ) ) + '" bgcolor="' + this.border[1] + '">\n' );
		//offset the container (clipped) layer to give a border
		document.write('<layer left="' + this.border[0] + '" top="' + this.border[0] + '" height="' + this.height + '" width="' + this.width + '" clip="0,0,' + this.width + ',' + this.height + '">\n' );
		document.write('<layer id="' + this.layer + '" bgcolor="' + this.background + '" height="' + this.height + '" width="' + this.width + '"></layer></layer></ilayer>\n' );
	} else if( MWJ_isOpera6 ) {
		//create the scroller with an iframe (the table creates a border - used instead of stylesheets so iCab also draws it)
		document.write('<table border="0" cellpadding="' + this.border[0] + '" cellspacing="0"><tr><td bgcolor="' + this.border[1] + '"><iframe src="about:blank" name="' + this.iframe + '" marginwidth="0" marginheight="0" frameborder="0" height="' + this.height + '" width="' + this.width + '" scrolling="no"></iframe></td></tr></table>' );
	} else {
		//create the scroller with Div elements
		document.write( '<div style="position:relative;background-color:' + this.border[1] + ';width:' + ( this.width + ( this.border[0] * 2 ) ) + 'px;height:' + ( this.height + ( this.border[0] * 2 ) ) + 'px;">' );
		document.write( '<div style="position:absolute;width:' + this.width + 'px;height:' + this.height + 'px;clip:rect(0px ' + this.width + 'px ' + this.height + 'px 0px);top:' + this.border[0] + 'px;left:' + this.border[0] + 'px;">' );
		//this extra div provides the background colour preventing a Gecko rewrite flicker and allowing the IE5 Mac bug fix (see below)
		document.write( '<div style="position:absolute;background-color:' + this.background + ';left:0px;top:0px;width:' + this.width + 'px;height:' + this.height + 'px;"></div>' );
		document.write( '<div style="position:absolute;left:0px;top:0px;width:' + this.width + 'px;height:' + this.height + 'px;" id="' + this.layer + '"></div></div></div>' );
	}
}

function msgScroller(oH,oW,oTH,oBW,oBC,oSD,oPT,oSP,oBGC) {
	if( arguments.length > 9 ) { window.alert('Incompatible scroller script - see the source'); window.onerror = function () { return true; }; return; }
	this.height = oH; this.width = oW; this.textHeight = oTH; this.border = [ oBW, oBC ];
	this.scrollSpeed = oSD; this.pauseLength = oPT; this.stopOff = oSP; this.background = oBGC;
	this.msgArray = ['']; this.scrollNum = window.MWJScrollers.length; this.buildScroller = createScroller;
	this.layer = 'scLyEr' + window.MWJScrollers.length;
	this.iframe = 'scFrAm' + window.MWJScrollers.length;
	window.MWJScrollers[window.MWJScrollers.length] = this;
}

//now do the bit that works out what to write and how far to scroll
function rotMsg(oNum,sCroll,oUnit) {
	//the size of the div must be 2 * height of scroller + height of writing
	oUnit = MWJScrollers[oUnit];
	if( MWJ_isOpera6 ) { //scroll the iframe
		window.frames[oUnit.iframe].scrollTo(0,sCroll);
	} else {
		var refToDiv = getRefToDivNest(oUnit.layer);
		if( !refToDiv ) { return; } //not supported
		if( refToDiv.style ) { refToDiv = refToDiv.style; }
		//to make up for the lack of offset (used to avoid the IE5 Mac bug - see below), I add it in here
		refToDiv.top = ( ( document.layers ? 0 : oUnit.height ) - sCroll ) + ( document.childNodes ? 'px' : 0 );
	}
	if( sCroll == 0 ) { //next message
		if( MWJ_isOpera6 || document.layers ) {
			//use a table to provide scroller colour and offset
			reWriteSCRL(oUnit.layer,oUnit.iframe,'<table border="0" cellpadding="0" cellspacing="0"><tr><td height="'+oUnit.height+'" bgcolor="' + oUnit.background + '">&nbsp;</td></tr></td><tr><td height="'+oUnit.textHeight+'" width="'+oUnit.width+'" align="center" bgcolor="' + oUnit.background + '"><table border="0" cellpadding="0" cellspacing="0"><tr><td align="left">'+oUnit.msgArray[oNum]+'</td></tr></table></td></tr><tr><td height="'+(oUnit.height+2)+'" bgcolor="' + oUnit.background + '">&nbsp;</td></tr></table>');
		} else {
			//IE5 Mac has horrible rendering bugs when moving layers whose contents are larger than their parent container,
			//so I create no offset here and instead put the offset in when I scroll. The layer behind provides the colour
			reWriteSCRL(oUnit.layer,oUnit.iframe,'<table align="center"><tr><td align="left">'+oUnit.msgArray[oNum]+'</table>');
		}
		oNum++; if( oNum >= oUnit.msgArray.length ) { oNum = 0; }
	}
	if( sCroll >= oUnit.height + oUnit.textHeight ) { sCroll = -3; } //top of travel, reset
	//if it is one or two px away from the stopoff point, push it up just enough to reach it - pause at the stopoff point
	window.setTimeout( 'rotMsg('+oNum+','+(((oUnit.height-oUnit.stopOff)-sCroll==1||(oUnit.height-oUnit.stopOff)-sCroll==2)?oUnit.height-oUnit.stopOff:sCroll+3)+','+oUnit.scrollNum+');', ( sCroll == oUnit.height - oUnit.stopOff ) ? oUnit.pauseLength : oUnit.scrollSpeed );
}

window.onload = function () { for( var x = 0; x < MWJScrollers.length; x++ ) { rotMsg( 0, 0, x ); } }