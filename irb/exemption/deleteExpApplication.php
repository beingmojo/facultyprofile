<?php require_once('../Connections/dbc.php');
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


if (isset($_GET["expNum"]) || isset($_POST["expNum"])){
	if (isset($_POST["expNum"])){
	$expNum = $_POST['expNum'];
	}
	elseif (isset($_GET["expNum"])){
		$expNum = $_GET['expNum'];
	}
	    
$today=date("m/d/y H:i:s");
	 
	 $newaction = "Deleted Application:" . $expNum;
$activityType = "Delete";
 $insertSQL = sprintf("INSERT INTO adminlog (date, activity, username, activityType) VALUES (%s, %s, %s, %s)",
  						GetSQLValueString($today, "text"),
  						GetSQLValueString($newaction, "text"),
                       GetSQLValueString($_SESSION['username'], "text"),
                       GetSQLValueString($activityType, "text"));

 
  $Result1 = mysql_query($insertSQL, $con) or die(mysql_error());


$query = sprintf("DELETE FROM exemption WHERE expNum = '%s'", $expNum);
$rs = mysql_query($query, $con) or die(mysql_error());
//echo "Application".$appNum."Deleted.";
}
$query_Recordset1 = "SELECT username, exemption.expNum, FirstName, LastName, ReceiveDate FROM exemption ORDER BY ReceiveDate DESC";
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
dirlocation="deleteExpApplication.php?expNum="+str;
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
          
            </span></td>
 
  </tr>
</tbody></table> 

</td></tr><tr><td><table width="100%" bgcolor="#FFFFFF" border="0">

 <tr>
    <td bgcolor="#000000" align="center">
 <a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span><span class="style42">|</span> <a href="irb_listExpApp.php" class="irb">All IRB Exemption Applications</a> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a><br> 
     
      </td></tr>
		<tr><td> 
      
      </td>
        </tr>
       
      <TR><TD>
<?php
if (isset($_GET["expNum"]) || isset($_POST["expNum"])){
	if (isset($_POST["expNum"])){
	$expNum = $_POST['expNum'];
	}
	elseif (isset($_GET["expNum"])){
		$expNum = $_GET['expNum'];
	}
	    
 
 echo "<font color = 'RED'>Application ".$expNum." deleted.</font>";
 }
 ?>
<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
 
  <p align="center" ><strong><br>DELETE IRB EXEMPTION APPLICATION </strong></p>
    <p align="center">
    Enter Application Number <br />
    <br />
    <input type="text" name="expNum" />
 
 
    <input type="submit" name="Submit" value="Delete Application" onClick="return confirmSubmit()">
  </p>
</form>
<hr><p align="center">All IRB Exemption Applications
<table width="100%" border="1" cellspacing="-1"><tr><td>
<?php
if($totalRows_Recordset1>0){
?>
 <tr><td>Applicant Username</td><td>Application Number</td><td>&nbsp;</td></tr>
 <?php
  do
  { 
  ?><tr><td>
  <?php
  echo $row_Recordset1['username'];?></td><td><?php echo $row_Recordset1['expNum'];?></td>
 
  <td> <input name="button" type='button' onClick="deleteConfirm('<?php echo addslashes($row_Recordset1['expNum'])?>')" value='Delete Application'></td>
  
  
  </tr>
  <?php
    }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	echo "</table>";
	}
	else
	echo "<font color = 'red'>No Application found.</font></td></tr>";
   ?>


</td></tr></table><tr><td><br><br></br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table></td></tr></table>
</body>
</html>
  <?php
mysql_free_result($Recordset1);
?>
  