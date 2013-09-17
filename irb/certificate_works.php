<?php require_once('Connections/con3.php'); ?>
<?php

session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}
$un_Recordset1 = "";
if (isset($_SESSION['username'])) {
  $un_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['username'] : addslashes($_SESSION['username']);
}


$appNum = $_GET['appNum'];


mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT application.App_Number, application.username, application.ProjectTitle, application.Status, application.rev1ID, application.rev2ID, application.rev3ID, ApprovedDate, application.rev1ApprovedDate, application.rev2ApprovedDate, application.rev3ApprovedDate FROM application WHERE App_Number='".$appNum."' and (Status='Approved' || Status = 'Application Approved - Exempt')";

$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$app=$row_Recordset1['username'];

mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT `user`.username, `user`.FirstName, `user`.LastName FROM `user` where username = '".$app."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$finalDate = "";
$expDate="";
$i=0; //number of reviewers
if ($row_Recordset1['rev1ID']) 
	$i=$i+1;
if ($row_Recordset1['rev2ID']) 
	$i=$i+1;
if ($row_Recordset1['rev3ID']) 
	$i=$i+1;
	$approved=$row_Recordset1['Status'];
//compare approved date	
if ($row_Recordset1['Status'] == "Approved"){
$finalDate = $row_Recordset1['ApprovedDate'];
	$irbDate = $row_Recordset1['ApprovedDate'];
	$forMrev1=str_replace('-', '/', $row_Recordset1['rev1ApprovedDate']); 
	$forMrev1=str_replace('-', '/', $row_Recordset1['rev2ApprovedDate']);
	$forMrev3=str_replace('-', '/', $row_Recordset1['rev3ApprovedDate']);
	$forIRB=str_replace('-', '/', $row_Recordset1['ApprovedDate']);
	
	//$forMrev1= $row_Recordset1['rev1ApprovedDate']; 
	//$forMrev1=$row_Recordset1['rev2ApprovedDate'];
	//$forMrev3=$row_Recordset1['rev3ApprovedDate'];
	$forIRB= $row_Recordset1['ApprovedDate'];
		$timestampeIrb=strtotime($forIRB);
	
	$timestampe1=strtotime($forMrev1);
	$timestampe2=strtotime($forMrev2);
	$timestampe3=strtotime($forMrev3);
	
		
		if($i == 3){
		
		if ($row_Recordset1['rev1ApprovedDate'] && $row_Recordset1['rev2ApprovedDate'] && $row_Recordset1['rev3ApprovedDate'] ) 
			{
		
			if ($timestamp1 >= $timestamp2 && $timestamp1 >= $timestamp3)
				$finalDate = $row_Recordset1['rev1ApprovedDate'];
			if ($timestamp2 >= $timestamp1 && $timestamp2 >= $timestamp3)
				$finalDate = $row_Recordset1['rev2ApprovedDate'];
			if ($timestamp3 >= $timestamp1 && $timestamp3 >= $timestamp2)
				$finalDate = $row_Recordset1['rev3ApprovedDate'];
			}
				else
					$finalDate = $row_Recordset1['ApprovedDate'];
				
		
			}//if i==3
			
			////////////////////////////////////////
			if($i==2){
			
				if ($row_Recordset1['rev1ApprovedDate'] && $row_Recordset1['rev2ApprovedDate']) 
				{
		
			if ($timestamp1 > $timestamp2 ){
				$finalDate = $row_Recordset1['rev1ApprovedDate'];
				
				}
			if ($timestamp2 > $timestamp1){
				$finalDate = $row_Recordset1['rev2ApprovedDate'];
			//	$finalDate = $timestamp2;
				}
			}
				else 
				$finalDate = $row_Recordset1['ApprovedDate'];
			}//if i=2
			
		
			//$finalDate=str_replace('-', '/',$finalDate);
			//$finalDate=date("m/d/y",strtotime($finalDate));
			//$finalDate = date("M-d-Y", $finalDate));
			$expDate=date("m/d/y",strtotime($finalDate) + 365*60*60*24);
			
	} //end if		
	
	
	/////////////exempt
	if ($row_Recordset1['Status'] == "Application Approved - Exempt"){
	
	$expDate="None(Application Approved - Exempt)";	
	$finalDate = $row_Recordset1['ApprovedDate'];	
	}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Texas State University-San Marcos | IRB Online Application</title>
<style type="text/css">
<!--
.style2 {
	font-size: 18px;
	font-weight: bold;
	font-family: Garamond;
}
.style3 {font-family: Garamond}
.style4 {
	font-size: 36px;
	font-family: Garamond;
	font-weight: bold;
}
.style6 {font-size: 24px; font-family: Garamond; font-weight: bold; }
.style8 {
	font-family: Garamond;
	font-size: 36px;
}
.style10 {
	font-family:Garamond;
	font-size: 14px;
	font-weight: bold;
}
.style11 {
	color: #663300;
	font-size: 42px;
	font-family: Garamond;
}
.style12 {font-size: 24px; font-family: Garamond; font-weight: bold; color: #993300; }
.style14 {font-family: Garamond; font-size: small; }
.style15 {font-family:Garamond}
-->
</style>
</head>

<body>
<div align="center">
<table width="650" border="3" cellpadding="0" cellspacing="0" bordercolor="#330000"><tr><td>
    <div align="center">
      <table width="650" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
        <tr><td>
          <div align="center">
            <table>
              <tr>
                <td valign="middle" bgcolor="#FFFFFF"><p align="center" class="style6"><img src="TXST_Primary_3Color_RGB.gif" alt="logo" /></p>
                      <p align="center" class="style12 style15">      Institutional Review Board Application</p>
                      <p align="center" class="style4 style11"> Certificate of Approval</p>
                      <p align="center" class="style2">Applicant: <?php echo $row_Recordset2['FirstName']." ".$row_Recordset2['LastName'];?><br />
                        <br />
                        <strong>Application Number :  <?php echo $row_Recordset1['App_Number'];?></strong></p>
                      <p align="center" class="style10">Project Title: <?php echo $row_Recordset1['ProjectTitle']; ?></p>
                    <p align="center" class="style15"><strong>Date of Approval: <?php echo $finalDate; ?> </strong></p>
                    <p align="center" class="style15"><strong>Expiration Date: <?php echo $expDate; ?></strong></p>
                    <span class="style15"><br />
                    </span></td>
              </tr><tr><td valign="top"><p align="center" class="style3"><img src="sigline.gif" alt="Signature" width="606" height="128" /></p>
                  <div align="center"></div>
                  <br /></td>
                      </tr>
            </table>
          </div></td></tr>
      </table>
  </div></td></tr></table>
<p align="center"><a href="<?php echo $_SESSION['myhome'];?>">Return to IRB Home</a></p>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset2);

mysql_free_result($Recordset1);
?>
