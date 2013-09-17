<?php require_once('../Connections/dbc.php');
session_start();

$restrictGoTo = "../unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


?>
<?php

$query_Recordset1 = "SELECT exemption.expNum, ReceiveDate, Approval FROM exemption where username = '".$_SESSION['username']."' order by ReceiveDate DESC";
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
   <a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a><br>
     
      </td></tr>
		<tr><td colspan="2"> 
      <p align="center">&nbsp;</p>
      <p align="center"><?php echo $_SESSION['name'];?></p></td>
        </tr>
       
    <tr>
      <td valign="top">
      <table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td colspan="3"><div align="center">
        <p><b>IRB Exemption Applications</b></p>
        <p>&nbsp;</p>
      </div></td></tr>

<?php

  if ($totalRows_Recordset1>0){
  do
  { 
  ?><tr><td>
  <div align="center"><?php echo $row_Recordset1['expNum'];?></div></td>
  <td>
      <div align="center"><?php echo "<a href='status_summary_app.php?expNum=". $row_Recordset1['expNum']."'>Application Status</a>";?> 
  <td>
      <div align="center"><?php echo "<a href='exemption_summary_app.php?expNum=". $row_Recordset1['expNum']."'>Review Application Data</a>"; 
	if ($row_Recordset1['Approval']=='Yes')
	echo "</td><td><a href='certificate_exp.php?expNum=". $row_Recordset1['expNum']."'>Print Certificate</a></td><td>";
	?>
          </div></td></tr><tr><td>&nbsp;</td></tr>
  <?php
    }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	}
	else
	echo "<tr><td colspan='3'><font color='red'>No application found.</font></td></tr>";
   ?>
   <tr><td colspan="3"><p><br></p></td></tr>
   </table>
   <tr><td><br><br><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table>	</td></tr></table>
   
  <?php
mysql_free_result($Recordset1);
?>
   
