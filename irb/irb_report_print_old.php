<?php require_once('Connections/dbc.php');
session_start();

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
?>
<?php
$today=date("m/d/y H:i:s");

//all application up to date
//$query_Recordset1 = "SELECT application.App_Number, application.ProjectTitle, application.Status, submissionFinishedDate, application.ReviewDate, application.ApprovedDate, username FROM application ORDER BY submissionFinishedDate DESC, Status ASC";
//$query_Recordset1 = "SELECT ActionFlag, application.App_Number, application.ProjectTitle, application.Status, submissionFinishedDate, application.ReviewDate, application.ApprovedDate, username FROM application where submissionFinishedDate < '".$today."' ORDER BY submissionFinishedDate DESC, Status ASC";

//defautl: last six months
$timePeriod = strtotime($today) - 183 * 60*60*24;
$indate = date("m/d/y H:i:s:", $timePeriod);
$query_Recordset1 = "SELECT application.App_Number, application.ProjectTitle, application.Status, submissionFinishedDate, application.ReviewDate, application.ApprovedDate, username FROM application where (submissionFinishedDate > '".$indate."') ORDER BY submissionFinishedDate DESC, Status ASC";

//
if($_GET['period']){
if($_GET['period'] =="All"){
$timePeriod = strtotime($today);
$indate = date("m/d/y H:i:s:", $timePeriod);
$query_Recordset1 = "SELECT application.App_Number, application.ProjectTitle, application.Status, submissionFinishedDate, application.ReviewDate, application.ApprovedDate, username FROM application ORDER BY submissionFinishedDate DESC, Status ASC";
}

else{
$timePeriod = strtotime($today) - $_GET['period'] * 60*60*24;
$indate = date("m/d/y H:i:s:", $timePeriod);
$query_Recordset1 = "SELECT application.App_Number, application.ProjectTitle, application.Status, submissionFinishedDate, application.ReviewDate, application.ApprovedDate, username FROM application where (submissionFinishedDate > '".$indate."') ORDER BY submissionFinishedDate DESC, Status ASC";
}
	}

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



  <style type="text/css">
<!--
.style44 {color: #FFFFFF}
.style45 {font-siz: x-small}
.style46 {
	font-size: large;
	font-weight: bold;
}
.style47 {font-size: medium}
-->
  </style>
</head>
<body>
<table width="850" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
   <tr><td><div align="center">
     <p class="style46">IRB Application Report</p>
     <p>&nbsp;</p>
   </div></td>
   </tr>
  <tr><td>

	  
	  <?php
if($totalRows_Recordset1>0)
?><tr><td ><div align="center" class="style47">Time Period: 
	    <?php echo date("m/d/y", $timePeriod);?> - <?php echo date("m/d/y",strtotime($today));?></div></td></tr>
<tr><td ><div align="center">
  <p class="style47">Total Number of Applications: 
    <?php echo $totalRows_Recordset1;?></p>
 
</div></td></tr><tr><td colspan="3"><table border="1" cellspacing="-1"><td bgcolor="#000000" class="style44" ><div align="center"><strong>Application Number</strong></div></td><td bgcolor="#000000" class="style44" ><div align="center"><strong>Status
      
        </strong></div></td>
   <td bgcolor="#000000" class="style44" ><div align="center"><strong>Submission Date
        
   </strong></div></td><td bgcolor="#000000" class="style44" ><div align="center"><strong>Approval Date
    
   </strong></div></td>

     <td bgcolor="#000000" class="style44" > <div align="center"><strong><span class="body">Applicant Name</span></strong></div></td>
 <td bgcolor="#000000" class="style44" > <div align="center"><strong><span class="body">Department / Office</span></strong></div></td><td bgcolor="#000000" class="style44" > <div align="center"><strong><span class="body">Appicant Is</span></strong></div></td><td bgcolor="#000000" class="style44" > <div align="center"><strong><span class="body">Rank</span></strong></div></td>
<td bgcolor="#000000" class="style44" ><div align="center"><strong>Project Title 
</strong></div></td>

</tr>
     <?php 
	 $i=0; 
	 $count=$_GET['page']*10;
do{
	//echo $count.",";
	$count = $count-1;
	if ($count>=0)
		{
		}

	else 
  	{ 
  	$i=$i+1;
	 ?>
	<tr> <td ><span class="style45"><?php echo $row_Recordset1['App_Number'];?>&nbsp;</span></td>
<td ><span class="style45"><?php echo $row_Recordset1['Status'];?>&nbsp;</span></td>
  <td ><span class="style45"><?php echo $row_Recordset1['submissionFinishedDate'];?>&nbsp;</span></td>



<td ><span class="style45"><?php echo $row_Recordset1['ApprovedDate'];?>&nbsp;</span></td>

   <?php
   $applicant = $row_Recordset1['username'];
  
  if (!get_magic_quotes_gpc()) {
$applicant = addslashes($applicant);
		}

   $sql2 = sprintf("SELECT * FROM user WHERE username = '%s'", $applicant);
$appUser = mysql_query($sql2, $con) or die(mysql_error());
$rs_User = mysql_fetch_assoc($appUser);
?>
   </div>
   
     <td > <span class="style45"><?php echo $rs_User['FirstName']; ?> <?php echo $rs_User['LastName']; ?></td>
	    <td > <span class="style45"><?php echo $rs_User['Department']; ?> &nbsp;</td>
		   <td > <span class="style45"><?php echo $rs_User['User_Type']; ?></td>
		      <td > <span class="style45"><?php echo $rs_User['Rank']; ?>&nbsp;</td>
	
 <?php 
	 // mysql_free_result($appUser);
	  ?>
<td ><span class="style45"> 
  <?php
  echo $row_Recordset1['ProjectTitle']; ?></span></td>
</tr>
 <?php 
	  mysql_free_result($appUser);
	}
	}while (($row_Recordset1 = mysql_fetch_assoc($Recordset1)) & ($i<10))
	
	?>
	</table>
	
	  <?php

	if ($totalRows_Recordset1>10){
	echo "<tr><td><div align='right'>";
	$page=$_GET['page'] -1;
	if ($page>=0){
		echo "<a href='".$_SERVER['PHP_SELF']."?period=".$_GET['period']."&page=".$page."'>Previous page</a> ";
		}
		$page=$_GET['page'] +1;
		if (($totalRows_Recordset1 - $page*10)>0){
	echo "<a href='".$_SERVER['PHP_SELF']."?period=".$_GET['period']."&page=".$page."'>Next Page</a>"; 
	}
	echo "</div>";
   }
   ?>
	  
	   </td></tr><tr><td><br><br><br><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr>
   </table>
   
  <?php
mysql_free_result($Recordset1);
?>
   
