<?php require_once('Connections/dbc.php');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<?php
$Recordset1 = mysql_query("select * from adminlog order by date DESC"); 

$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?><table border="1">
<?php do{ ?>
<tr>

<td width="361"><?php echo $row_Recordset1['username']; ?>&nbsp;<?php echo $row_Recordset1['LastName']; ?></td></tr><tr><td>User Name:</td><td>
<?php echo $row_Recordset1['username']; ?></td></tr>
<tr><td>Activity:</td><td><?php echo $row_Recordset1['activity']; ?></td></tr>

<tr><td>Activity Type:</td><td><?php echo $row_Recordset1['activityType']; ?></td></tr>
<tr><td>Time:</td><td><?php echo $row_Recordset1['date']; ?></td></tr>
</td></tr>
<?php }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) 
?></table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>

<body>
</body>
</html>
