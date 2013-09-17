<?php require_once('../Connections/dbc.php');
session_start();

$restrictGoTo = "../unauthorized.php";

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
?>
<?php

$query_Recordset1 = "SELECT exemption.expNum, username, ReceiveDate FROM exemption where ((Approval = 'No') && (appFinished ='Yes')) ORDER BY ReceiveDate DESC";
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
.style50 {font-weight: bold}
.style51 {font-size: small}
-->
  </style></head>


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
<p><a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="irb_listExpApp.php" class="irb">All IRB Exemption Applications</a> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a>
     
      </td></tr>
		
    <tr>
      <td height="348" valign="top">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
	  <tr><td colspan="6"><p>&nbsp;</p>
	    <div align="center">
	      <p><b>IRB EXEMPTION APPLICATIONS - NOT APPROVED AND APPLICATION REVIEW FINISHED (Total: <?php echo $totalRows_Recordset1;?>)</b></p>
	      <p>&nbsp;</p>
	    </div></td></tr> 
		<tr><td><strong>Applicant Name</strong></td><td><strong>Department</strong></td><td><strong>Application Number</strong></td><td><strong>Submission Date</strong></td><td></td><td></td></tr><tr ><td colspan="6">&nbsp;</td></tr>

<?php

  if($totalRows_Recordset1>0){
  do
  { 
  $query_Recordset2 = "SELECT Department, FirstName, LastName FROM user where username='".$row_Recordset1['username']."'";
$Recordset2 = mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
  ?><tr><td>
  <?php
  echo $row_Recordset2['FirstName']." ".$row_Recordset2['LastName'];?></td><td>
  <?php
  echo $row_Recordset2['Department'];?></td><td><?php echo $row_Recordset1['expNum'];?></td>
  <td><?php echo $row_Recordset1['ReceiveDate'];?></td>
    <td>
  <?php echo "<a href='status_summary.php?expNum=". $row_Recordset1['expNum']."'>Status Summary</a></td><td>";
echo "<a href='exemption_summary.php?expNum=". $row_Recordset1['expNum']."'>Review Application Data</a>"; 

	?>
  </td></tr><td colspan="6">&nbsp;</td></tr>
  <?php
  mysql_free_result($Recordset2);
  
    }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	}
	
	else
	echo "<tr><td colspan='5'><font color = 'red'>No Application found.</font></td></tr>";
   ?>

   
   </table><tr><td><br><br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table>
   </td></tr></table>
   
  <?php
mysql_free_result($Recordset1);
?>
   
