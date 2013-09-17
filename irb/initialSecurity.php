<?
//include 'dbc.php' 
$con = mysql_connect("localhost", "irbadmin", "irbadmin") or die(mysql_error()); 
mysql_select_db("irbdb", $con) or die(mysql_error()); 

$sql="INSERT INTO security (ID, SecurityCode) VALUES('irb001','abcdIRB')";
if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record added";mysql_close($con)
?>