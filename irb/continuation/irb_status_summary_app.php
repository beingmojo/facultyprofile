<?php require_once('../Connections/con3.php');
session_start();

$restrictGoTo = "../unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


$id=$_GET["ID"];
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "Select * FROM continuation where ID='".$id."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$app=$row_Recordset1['username'];

mysql_select_db($database_con3, $con3);
$query_Recordset2 = "Select FirstName, LastName, Email,Phone, Department FROM user where username='".$app."'";;
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

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

</td></tr><tr><td valign="top">
<table width="100%" bgcolor="#FFFFFF" border="0">

 <tr bgcolor="#000000">
    <td bgcolor="#000000" align="center" colspan="4">
      <div align="center"><a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a><br>
        
      </div></td></tr>
		<tr><td colspan="4"> 
      <p align="center"><br><?php echo $_SESSION['name'];?></p>
      </td>
        </tr></table><tr><td>
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" align="center">
  <tr><td>

  <p align="center" class="style49"><br><strong>APPLICATION STATUS, EVALUATION AND ACTION LOG</strong></p>
    <p align="left" class="style47"><a href="irb_continuation_summary_app.php?ID=<?php echo $row_Recordset1['ID']; ?>">Review Application Data</a></p>
	<p><strong>Application Number:</strong> <?php echo $row_Recordset1['ID']; ?>
	
   <p><strong>Application Submission Date:</strong> <?php echo $row_Recordset1['ReceiveDate']; ?>
  <p><strong>Approved?</strong>  <?php echo $row_Recordset1['Approval']; ?></p>
  <p><strong>Last Evaluation Date</strong>:  <?php echo $row_Recordset1['ApprovalDate']; ?></p>
  <p><hr><strong>IRB Comments</strong><p>  
    <?php echo $row_Recordset1['Comments']; ?>
  <p><hr><strong>IRB Actions</strong></p>
  
    <?php echo $row_Recordset1['irbActionLog']; ?></p>
 <p class="style51">&nbsp;</p>
  

 </td>
  </tr></table> 
  </td></tr>
  <tr><td>  <BR><BR><BR>
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
mysql_free_result($Recordset2);
?>
