
<?php
$today=date("m/d/y H:i:s");
echo $today;
// A year from now
$expDate=date("m/d/y",strtotime($today) + 365*60*60*24);
echo "<br>".$expDate;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
