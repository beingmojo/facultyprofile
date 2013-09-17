<?php
require_once('../Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

if ($_SESSION['User_Type'] != "IRB Staff"){
	if($_SESSION['User_Type'] != "IRB Chair") {   
 
 	 header("Location: ". $restrictGoTo); 
  		exit;
	}
}


function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}


if (isset($_GET["ID"]) || isset($_POST["ID"])){
	if (isset($_POST["ID"])){
	$ID = $_POST['ID'];
	}
	elseif (isset($_GET["ID"])){
		$ID = $_GET['ID'];
	}
	 
 
	    
$today=date("m/d/y H:i:s");
	 
	 $newaction = "Delete Continuation Application:" . $ID;
$activityType = "Delete";
 $insertSQL = sprintf("INSERT INTO adminlog (date, activity, username, activityType) VALUES (%s, %s, %s, %s)",
  						GetSQLValueString($today, "text"),
  						GetSQLValueString($newaction, "text"),
                       GetSQLValueString($_SESSION['username'], "text"),
                       GetSQLValueString($activityType, "text"));

  $Result1 = mysql_query($insertSQL, $con) or die(mysql_error());


$query= sprintf("DELETE FROM continuation WHERE ID = '%s'", $ID);

$rs = mysql_query($query, $con) or die(mysql_error());

}


$query_Recordset1 = "SELECT * FROM continuation order by ReceiveDate DESC";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="../irbstyle.css" rel="stylesheet" type="text/css">


  <style type="text/css">
<!--
.style42 {color: #FFFFFF}
.style43 {font-size: large}
-->
  </style>
<script>
function deleteConfirm(str)
{
if (confirm("Are you sure you want to remove this application permanently?")){
dirlocation="deleteConApplication.php?ID="+str;
document.location.href=dirlocation;
}
}
</script>

</head>


<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td valign="top"><p align="left" class="style6 style24"><img src="../banner2.jpg" height="160"></td>
            <td valign="middle" background="../tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
            </p>
            </span></td>
 
  </tr>
</tbody></table> 

</td></tr><tr><td>
 <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
 <tr>
    <td bgcolor="#000000"><div align="center">
      <p align="center"><span class="style33"><a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a><br>
        </p></td></tr><tr><td>
      <p align="center">&nbsp;</p>
      <p align="center">Your Username:  <?php echo $_SESSION['username'];?></p></td>
        </tr><tr><td>
 <?PHP if (isset($_POST["ID"])){
 
 echo "<font color = 'RED'>Continuation Application ".$_POST["ID"]." deleted</font>";
 }
 ?>
<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <label>
  <p align="center" class="style2 style6"><strong>Delete IRB Continuation/Change Application </strong></p>
    <p align="center">    Enter Continuation Application ID Number (Not IRB Application Number)<br />
    <br />
    <input type="text" name="ID" />
  </div>
  </label>
  <p align="center">
<input type="submit" name="Submit" value="Delete Application" onSubmit="return confirmSubmit();"> 
  </p>
</form>
<hr>
IRB CONTINUATION/CHANGE APPLICATIONS</p>

  <?php
  if($totalRows_Recordset1>0){
  ?>
  <table border="1"><tr><td>Continuation Application ID Number</td><td>IRB Application Number</td><td>Approved?</td><td></td></tr>
  <?php
  do
  { 
  ?><tr><td>
  <?php
  echo $row_Recordset1['ID'];?></td><td><?php
  echo $row_Recordset1['App_Number'];?>
 
  </td><td><?php echo $row_Recordset1['Approval']; ?></td><td>
  <input name="button" type='button' onClick="deleteConfirm('<?php echo addslashes($row_Recordset1['ID'])?>')" value='Delete Application'"; 
 	
	
  <tr><td colspan='4'><hr></td></tr>
  <?php
    }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	echo "</table>";
	}
	
	else
	echo "<tr><td colspan='4'><font color='red'>No application found.</font><br><br></td></tr>";
   ?>


</table></td></tr></table>
</body>
</html>
  <?php
mysql_free_result($Recordset1);
?>
  