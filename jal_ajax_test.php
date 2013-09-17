<html>
	<head>
	<script type="text/javscript">
		function change(id){
			document.getElementById(id).value = 'new text';
		}
	</script
	</head>
	
	<body>
		<form method="post" action="jal_test.php">
			<input type="text" id="pid" name="pid"></input>
			<input type="text" id="pub_id" name="pub_id"></input>
			<textarea id="area" name="area"></textarea>
			<button onclick="change("area");">Change</button
			<input type="submit" value="Submit" />
		</form>
	</body>
</html>