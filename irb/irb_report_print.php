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



//defautl: all
$timePeriod = strtotime($today);
$indate = date("m/d/y H:i:s:", $timePeriod);
$query_Recordset1 = "SELECT application.App_Number, application.ProjectTitle, application.Status, submissionFinishedDate, application.ReviewDate, application.ApprovedDate, submissionFinishedDate, username FROM application ORDER BY Status";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if($_GET['period']&&$_GET['period'] != "All"){

$timePeriod = strtotime($today) - $_GET['period'] * 60*60*24;
//echo "Timeperiod: ".$timePeriod;




 ?>
	 
	  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>



  <style type="text/css">
<!--
.style43 {font-size: large}
.style44 {color: #FFFFFF}
.style45 {font-siz: x-small}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>



    <table width="800" border="0" align="center" bgcolor="#ffffff">
	
	  
 <TR><TD>
	  
		
      </div></td></tr> <tr><td colspan="3"><div align="center">
      <p><strong>IRB REPORT</strong></p> 
	  
        <hr>
      </div>
          </td>
 </tr>
<?php
if($totalRows_Recordset1>0)
?><tr><td colspan="3"><div align="center">Time Period: 
	    <?php echo date("m/d/y", $timePeriod);?> - <?php echo date("m/d/y",strtotime($today));?></div></td></tr>
<tr><td colspan="3"><div align="center"> 
	
		
		
		</div></td></tr><tr><td colspan="3">
		<table border="1" cellspacing="-1"><td bgcolor="#000000" class="style44" ><div align="center">Application Number</div></td><td bgcolor="#000000" class="style44" ><div align="center">Status
      
</div></td>
   <td bgcolor="#000000" class="style44" ><div align="center"><span class="body">Submission Date
        
  </div></td><td bgcolor="#000000" class="style44" ><div align="center"><span class="body">Approval Date
    
</div></td>

     <td bgcolor="#000000" class="style44" > <div align="center"><span class="body">Applicant Name</span></div></td>
 <td bgcolor="#000000" class="style44" > <div align="center"><span class="body">Department / Office</span></div></td><td bgcolor="#000000" class="style44" > <div align="center"><span class="body">Appicant Is</span></div></td><td bgcolor="#000000" class="style44" > <div align="center"><span class="body">Rank</span></div></td>
<td bgcolor="#000000" class="style44" ><div align="center"><span class="body">Project Title 
</div></td>

</tr>
     <?php   
	 $count=0;
do
  { 
 if($row_Recordset1['submissionFinishedDate'] !=""){
  $submissiondate = strtotime($row_Recordset1['submissionFinishedDate']);
  $timePeriod = strtotime($today) - $_GET['period'] * 60*60*24;
 // echo "timeperiod:".$timePeriod."<br>submission Date:".$submissiondate."<br>";
  	if ($submissiondate >= $timePeriod){
	$count=$count+1;
	
	 ?>
	<tr> <td ><span class="style45"><?php echo $row_Recordset1['App_Number'];?></span></td>
<td ><span class="style45"><?php echo $row_Recordset1['Status'];?></span></td>
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
	    <td > <span class="style45"><?php echo $rs_User['Department']; ?>&nbsp;</td>
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
	}//if submission date > time period
	}//if there is submission date
	}while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	echo "<tr><td colspan=9><b> Total applications during this period = ".$count;
	?>
	</td></tr></table>
	<?php
	
	
}//end if not all
	


else{

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>



  <style type="text/css">
<!--
.style43 {font-size: large}
.style44 {color: #FFFFFF}
.style45 {font-siz: x-small}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>

	  
	  <?php
if($totalRows_Recordset1>0){
?><tr><td colspan="3"><div align="center">Time Period: 
 - <?php echo date("m/d/y",strtotime($today));?></div></td></tr>
<tr><td colspan="3"><div align="center">Total Number of Applications: 
	    <?php echo $totalRows_Recordset1;?></div></td></tr><tr><td colspan="3">
		<table border="1" cellspacing="-1"><td bgcolor="#000000" class="style44" ><div align="center">Application Number</div></td><td bgcolor="#000000" class="style44" ><div align="center">Status
      
</div></td>
   <td bgcolor="#000000" class="style44" ><div align="center"><span class="body">Submission Date
        
  </div></td><td bgcolor="#000000" class="style44" ><div align="center"><span class="body">Approval Date
    
</div></td>

     <td bgcolor="#000000" class="style44" > <div align="center"><span class="body">Applicant Name</span></div></td>
 <td bgcolor="#000000" class="style44" > <div align="center"><span class="body">Department / Office</span></div></td><td bgcolor="#000000" class="style44" > <div align="center"><span class="body">Appicant Is</span></div></td><td bgcolor="#000000" class="style44" > <div align="center"><span class="body">Rank</span></div></td>
<td bgcolor="#000000" class="style44" ><div align="center"><span class="body">Project Title 
</div></td>

</tr>
     <?php  
do
  { 
	 ?>
	<tr> <td ><span class="style45"><?php echo $row_Recordset1['App_Number'];?></span></td>
<td ><span class="style45"><?php echo $row_Recordset1['Status'];?></span></td>
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
	    <td > <span class="style45"><?php echo $rs_User['Department']; ?>&nbsp;</td>
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
	
	}while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	}
	}
	?>
	</td></tr></table>
<tr><td><br><br><br><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
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
   
