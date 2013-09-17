<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php
$mon1=7;
$mon2=12;
$y2=2007;
$y1=2007;
$t1=$mon1."/".$y1;
$t2=$mon2."/".$y2;

$str="06/14/06 18:32:37";

	$timestampe=strtotime($str);
	$t1Date=date("m/y",strtotime($t1));
	$t2Date=date("m/y",strtotime($t2));
	echo $t1."<br>";
	echo $t2."<br>";
	echo $str."<br>";
	$timestampe1=strtotime($t1);
	$timestampe2=strtotime($t2);
	if($timestampe1>$timestampe2)
	echo "t1 is older than t1";
	else 
	echo "t2 is older than t2";
		if($timestampe1<$timestampe)
	echo "<br>str is older than t1";
	else 
	echo "<br>t1 is older";
			if($timestampe2>$timestampe)
	echo "<br>t2 is older time";
	else 
	echo "<br>str is older";
	$query = "select * from applicatin where `SubmissionFinishedDate` >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
		$query2 = "select * from applicatin where `SubmissionFinishedDate` >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
?>
</body>
</html>
