<?php require_once('Connections/dbc.php');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<?php
$Recordset1 = mysql_query("select * from user"); 

$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?><table border="1">
<?php do{ ?>
<tr><td width="73">Name: </td>

<td width="361"><?php echo $row_Recordset1['FirstName']; ?>&nbsp;<?php echo $row_Recordset1['LastName']; ?></td></tr><tr><td>User Name:</td><td>
<?php echo $row_Recordset1['username']; ?></td></tr>
<tr><td>Password:</td><td><?php echo $row_Recordset1['password']; ?></td></tr>

<tr><td>Phone:</td><td><?php echo $row_Recordset1['Phone']; ?></td></tr>
<tr><td>Email:</td><td><?php echo $row_Recordset1['Email']; ?></td></tr>
<tr><td>User_Type:</td><td><?php echo $row_Recordset1['User_Type']; ?></td></tr>
<tr><td>Department</td><td><?php echo $row_Recordset1['Department']; ?></td></tr><tr><td colspan="2"><hr /></td></tr>
<?php }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) 
?></table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
?>
<body>
</body>
</html>
