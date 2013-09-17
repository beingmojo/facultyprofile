<?php require_once('Connections/con3.php'); ?>
<?php session_start();
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT application.App_Number, application.ProjectTitle, application.Status, application.ApprovedDate FROM application order by App_Number";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "IRB Support")) { 
if (!($_SESSION['User_Type'] == "IRB Staff")) { 
  
 if (!($_SESSION['User_Type'] == "IRB Chair")){
  header("Location: ". $restrictGoTo); 
  exit;
  }
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

$today = date("m/d/y");


?>

<?php

if (isset($_POST["appNum"])){
$today = date("m/d/y");
  //declare a session variable and assign it (as is done in the login behavior)
	    $appNum = $_POST['appNum'];

$query_rsProposal = sprintf("DELETE FROM application WHERE App_Number = '%s'", $appNum);
mysql_select_db($database_con3, $con3);
$rsProposal = mysql_query($query_rsProposal, $con3) or die(mysql_error());
//echo "Application".$appNum."Deleted.";

// Path to application doc directory to delete
$directory = "appdoc/".$appNum;

// Delete it



if ($dh = @ opendir($directory)){

	while (($file = readdir($dh)) !== false)
	{
	if (is_file("$directory/$file")) unlink("$directory/$file");

	}
	
}
if(is_dir($directory))
	@rmdir($directory);

$activity = "Delete Application: ". $appNum;
$activityType = "Delete";
$insertSQL = sprintf("INSERT INTO adminlog (date, activity, username, activityType) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($today, "text"),
					    GetSQLValueString($activity, "text"),
						 GetSQLValueString($_SESSION['username'], "text"), 
						 GetSQLValueString($activityType, "text")
						   );
		 mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($insertSQL, $con3) or die(mysql_error());
  }
  


//************ delete through get method
if (isset($_GET['id'])&& $_GET['id'] !=""){
	    $appNum = $_GET['id'];

$query_rsProposal = sprintf("DELETE FROM application WHERE App_Number = '%s'", $appNum);
mysql_select_db($database_con3, $con3);
$rsProposal = mysql_query($query_rsProposal, $con3) or die(mysql_error());

///////////////////
$query= sprintf("DELETE FROM reviewlog WHERE appNum = '%s'", $appNum);
mysql_select_db($database_con3, $con3);
$rs = mysql_query($query, $con3) or die(mysql_error());

$query= sprintf("DELETE FROM notelog WHERE appNum = '%s'", $appNum);
mysql_select_db($database_con3, $con3);
$rs = mysql_query($query, $con3) or die(mysql_error());
// Path to application doc directory to delete
$directory = "appdoc/".$appNum;

// Delete it


if ($dh = @ opendir($directory)){

	while (($file = readdir($dh)) !== false)
	{
	if (is_file("$directory/$file")) unlink("$directory/$file");

	}
}
if (is_dir($directory))
//if (rmdir($directory))
{
	rmdir($directory);
//echo "Documents related to the application have been deleted";
}


$activity = "Delete Application: ". $appNum;
$activityType = "Delete";
$insertSQL = sprintf("INSERT INTO adminlog (date, activity, username, activityType) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($today, "text"),
					    GetSQLValueString($activity, "text"),
						 GetSQLValueString($_SESSION['username'], "text"), 
						 GetSQLValueString($activityType, "text")
						   );
		 mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($insertSQL, $con3) or die(mysql_error());
  }
  

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
 
 <LINK href="irbstyle.css" rel="stylesheet" type="text/css">

  <style type="text/css">
<!--
.style43 {font-size: large}
-->
  </style>
  
<script>
function deleteConfirm(a)
{
if (confirm('Are you sure you want to delete this application from the system permanently? Doing so, the uploaded documents will also be deleted.')){
dirlocation="deleteApplication.php?id="+a;
document.location.href=dirlocation;
}
}
</script>

</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </a></p>
           
            </p>
            </span></td>
   </tr>
</tbody></table></td></tr></table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
				
          <tr>
            <td valign="top" bgcolor="#000000">
			  <div align="center"><a class="irb" href="osp_irb_home.php">My IRB Home </a> <span class="style39">|</span><span class="irb"><a class="irb" href="irb_listApp.php">List All IRB Applications</a> <span class="style39">|</span> <a class="irb" href="listReviewers.php" >List All Reviewers </a> <span class="style39">|</span> <a class="irb" href="listApplicants.php" >List All Applicants</a>  <span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a> </div></td>
          </tr>
  
  				
    <tr>
      <td valign="top">
<table width="100%" align="center" border="0">
  <tr><td>
 <?PHP if (isset($_POST["appNum"]) || isset($_GET['id'])){
 
 echo "<font color = 'RED'>Application deleted.";
 echo " Documents uploaded for the application have also been deleted</font>";
 }
 ?>
<form id="form2" name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  <label>
  <p>&nbsp;</p>
  <p align="center" class="style3">DELETE IRB APPLICATION </p>
    <p align="left">You can delete an IRB application by either enter the application number below or click on the &quot;Delete Application&quot; button next to the application you want to delete.
    <p align="center">Enter Application Number: <input type="text" name="appNum" /> 
        <input type="submit" name="Submit" onclick="return confirm('Are you sure you want to delete the application from the system permanently?')" value="Delete Application" />
    </form>
</p></td></tr></table></td></tr>
<tr>
  <td align="center"><b><br>IRB APPLICATIONS</b></td>
</tr><tr><td align="center"><table border="1" WIDTH="800" cellspacing="-1"><tr><td><strong>Application Number</strong></td><td><strong>Project Title</strong></td>
        <td><strong>Status</strong></td>
  <td><strong>Date of Approval</strong> </td>
<td>&nbsp;</td></tr>
<?php
do{

?>
<tr><td><?php echo $row_Recordset1['App_Number']; ?></td>
<td><?php echo $row_Recordset1['ProjectTitle']; ?></td>
<td><?php echo $row_Recordset1['Status']; ?></td>
<td>&nbsp;<?php echo $row_Recordset1['ApprovedDate']; ?></td>
<td><input type="button" onclick="deleteConfirm('<?php echo $row_Recordset1['App_Number'];?>')" value="Delete Application"></td></tr>
<?php
 }while($row_Recordset1 = mysql_fetch_assoc($Recordset1))
?>
</table></td></tr>
<tr><td><br><br>
           
            <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>
</td></tr></table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
