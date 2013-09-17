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


$query_Recordset1 = "SELECT application.App_Number, application.ProjectTitle, application.Status, submissionFinishedDate, application.ReviewDate, application.ApprovedDate, username FROM application ORDER BY Status";


$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if($totalRows_Recordset1>0){


if($_GET['period']&&$_GET['period'] != "All"){

$timePeriod = strtotime($today) - $_GET['period'] * 60*60*24;

///////////////////////////////////////////////
   $csv_output = "App_Number,Status,Submission_Date,Approved_Date,Applicant_Name, Department/Office,Applicant_Is,Rank,Project_Title"; 
   $csv_output .= "\n"; 
  ////////////////////////////////////////////////////

do
  { 
 if($row_Recordset1['submissionFinishedDate'] !=""){
  $submissiondate = strtotime($row_Recordset1['submissionFinishedDate']);
  $timePeriod = strtotime($today) - $_GET['period'] * 60*60*24;
 // echo "timeperiod:".$timePeriod."<br>submission Date:".$submissiondate."<br>";
  	if ($submissiondate >= $timePeriod){
  
  $csv_output .= $row_Recordset1['App_Number'].",".$row_Recordset1['Status'].",". $row_Recordset1['submissionFinishedDate'].",".$row_Recordset1['ApprovedDate'];
/////////////////////////////////
$applicant = $row_Recordset1['username'];
  
  if (!get_magic_quotes_gpc()) {
		$applicant = addslashes($applicant);
		}

   $sql2 = sprintf("SELECT * FROM user WHERE username = '%s'", $applicant);
	$appUser = mysql_query($sql2, $con) or die(mysql_error());
	$rs_User = mysql_fetch_assoc($appUser);
		/////////////////////////////////////
	$name=$rs_User[FirstName] ." ".$rs_User[LastName];
	
	/////////////////////////////////////////////////////////////////
 	$csv_output .= ",".$name.",". $rs_User['Department'].",".$rs_User['User_Type'].",".$rs_User['Rank'].",".$row_Recordset1['ProjectTitle']."\n";
	
	
	///////////////////////////////////////////////////////////////////
	 mysql_free_result($appUser);
	 }
	 }
       }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 

/////////////////////////////////////////
   $csv_output .= "\n";

   $filename = "rpt_".date("m/d/y", $timePeriod)."_to_".date("m/d/y",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
mysql_free_result($Recordset1);
exit;
 
}
//if all or no time specified
else{

///////////////////////////////////////////////
   $csv_output = "App_Number,Status,Submission_Date,Approved_Date,Applicant_Name, Department/Office,Applicant_Is,Rank,Project_Title"; 
   $csv_output .= "\n"; 
  ////////////////////////////////////////////////////



  
  do{ 
  $csv_output .= $row_Recordset1['App_Number'].",".$row_Recordset1['Status'].",". $row_Recordset1['submissionFinishedDate'].",".$row_Recordset1['ApprovedDate'];
/////////////////////////////////
$applicant = $row_Recordset1['username'];
  
  if (!get_magic_quotes_gpc()) {
		$applicant = addslashes($applicant);
		}

   $sql2 = sprintf("SELECT * FROM user WHERE username = '%s'", $applicant);
	$appUser = mysql_query($sql2, $con) or die(mysql_error());
	$rs_User = mysql_fetch_assoc($appUser);
		/////////////////////////////////////
	$name=$rs_User[FirstName] ." ".$rs_User[LastName];
	
	/////////////////////////////////////////////////////////////////
 	$csv_output .= ",".$name.",". $rs_User['Department'].",".$rs_User['User_Type'].",".$rs_User['Rank'].",".$row_Recordset1['ProjectTitle']."\n";
	
	
	///////////////////////////////////////////////////////////////////
	 mysql_free_result($appUser);
		 
       }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
	    

/////////////////////////////////////////
   $csv_output .= "\n";
 //$filename = "rpt_export"."_".date("m/d/Y",time());
   $filename = "rpt_all_".date("m/d/y",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;

mysql_free_result($Recordset1);
   exit;  
}
}
?>
  

   
