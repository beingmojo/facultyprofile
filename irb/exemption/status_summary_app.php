<?php require_once('../Connections/con3.php');
session_start();

$restrictGoTo = "../unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}



mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT * FROM exemption where expNum = '".$_GET['expNum']."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT `user`.FirstName, `user`.LastName, `user`.Phone, `user`.Email, `user`.username FROM `user` where username = '".$row_Recordset1['username']."'";
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
.style50 {color: #FF0000}
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
            </p>
            </span></td>
 
  </tr>
</tbody></table> 

</td></tr>  <tr><td>
  <table width="100%" bgcolor="#FFFFFF">
 <tr>
    <td bgcolor="#000000" align="center">
	
       
        <a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="irb_listExpApp_app.php" class="irb">My IRB Exemption Applications</a> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a></td></tr>
	<tr><td>
    
      <p align="center"><br>
      <?php echo $_SESSION['name'];?></p></td>
        </tr>
  
		<tr><td>
	       <div align="center"><strong> <A href="" name="result"></A>APPLICATION STATUS<p></strong></div><hr></td></tr>
		   <tr>
		     <td>
      </p>
      <p>IRB Exemption Application Number: <span class="style50"><?php echo $_GET['expNum'];?></span><blockquote><table width="670" border="1" cellspacing="-1">
  <tr>
    <td><strong>Application Submitted Date</strong></td>
    <td><strong>Approved?</strong></td>
    <td><strong>Last Evaluation Date</strong></td>
  </tr>
  <tr>
    <td><?php echo $row_Recordset1['ReceiveDate']; ?> </td>
    <td>&nbsp;<?php echo $row_Recordset1['Approval']; ?></td>
    <td>&nbsp;<?php echo $row_Recordset1['ApprovalDate']; ?></td>
  </tr>
</table></blockquote>

   
        <hr><strong>IRB Comments</strong>
  <?php echo $row_Recordset1['Comments']; ?></p>
  <hr><strong>IRB Actions</strong><?php echo $row_Recordset1['irbActionLog']; ?></p>
  </td></tr>
</table><tr><td><br><br></br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table>
</td>
        </tr></table>
</body>


</html>
<?php
mysql_free_result($Recordset1);
?>

</body>
</html>
