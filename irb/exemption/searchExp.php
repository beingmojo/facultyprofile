<?php require_once('../Connections/con3.php');
session_start();

$restrictGoTo = "../unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!(($_SESSION['User_Type'] == "IRB Staff")||($_SESSION['User_Type'] == "IRB Staff") )) {
 
  header("Location: ". $restrictGoTo); 
  exit;
}
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT * from exemption where exemption.expNum ='".$_POST['expNum']."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
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
   <p><a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="irb_listExpApp.php" class="irb">My IRB Exemption Applications</a> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a>
     
      </td></tr>
		<tr><td> 
      </td>
        </tr>
	     <tr>
      <td valign="top">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
        
            <td colspan="5"><P><BR><p>
            <label>
			<form name="form1" method="post" action="searchExp.php">
            <p><P>Search IRB Exemption Application by Applicaiton Number: 
         
              <input type="text" name="expNum" id="expNum"> 
              <input name="submit" type="submit" value="Search">
            </p></p>
         
            </form>
          </label><P><HR><P></td>
        </tr>
			
       <tr><td><strong>Applicant Name</strong></td><td><strong>Department</strong></td><td><strong>Application Number</strong></td><td></td><td></td></tr><tr ><td colspan="5">&nbsp;</td></tr>

 <tr><td>
  <?php
  if(!$totalRows_Recordset1<1){
  mysql_select_db($database_con3, $con3);
 $query_Recordset2 = "SELECT Department, FirstName, LastName FROM user where username='".$row_Recordset1['username']."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
  ?><tr><td>
  <?php
  echo $row_Recordset2['FirstName']." ".$row_Recordset2['LastName'];?></td><td>
  <?php
  echo $row_Recordset2['Department'];?></td><td><?php echo $row_Recordset1['expNum'];?></td>
    <td>
  <?php echo "<a href='status_summary.php?expNum=". $row_Recordset1['expNum']."'>Status Summary</a></td><td>";
echo "<a href='exemption_summary.php?expNum=". $row_Recordset1['expNum']."'>Review Application Data</a>"; 

	?>
  </td></tr><td colspan="5">&nbsp;<P><HR><P></P><BR><P></td></tr>
  <?php
  mysql_free_result($Recordset2);
}
else
echo "<br><font color='red'>No application found with the number entered.</font><br><br>";
	
	?>
 </td></tr>

   </table></td></tr></table>
   
  <?php
mysql_free_result($Recordset1);
?>
   
