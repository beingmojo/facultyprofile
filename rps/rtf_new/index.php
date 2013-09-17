<?php
	$pid=$_GET["pid"];
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Generate RTF File</title>
<style type="text/css">
body {
	font-family: Arial;
}

td, p, font, iframe {
	font-family: Arial;
}

#editor {
	border: 1px outset threedface;
}

#editor td {
	background-color: threedface;
	color: menutext;
	cursor: Default;
	font-family: MS Sans Serif;
	font-size: 8pt;
}

#controls img.button {
	padding: 1px;
	background-color: buttonface;
	border: 1px solid buttonface;
}

#controls img.buttonOn {
	padding: 1px;
	background-color: buttonhighlight;
	border: 1px inset; 
}

#controls select {
	margin: 4px 0;
	font-family: MS Sans Serif;
	font-size: 8pt;
}
</style>

</head>
<script>
function PostForm() {
	var rtf = wysiwyg.document.body.innerHTML;
	alert(rtf);
	document.form.text.value = rtf;
	return true; 
} 
</script>
<body >

<iframe id="wysiwyg" style="width: 700px; height:400px" scrolling="yes" src="new_rtfdata.php?pid=<?php print $pid; ?>">
</iframe>
<form name="form" action="new_getrtf.php" method="POST" onSubmit="return PostForm()">
<input type="hidden" name="text" value="" />
		
		<table>
		<tr><td>	<input style="margin: 5px 0;" type="submit" value="Generate RTF File" />
		</td>
	</tr>
</table>
</form>
</body>
</html>