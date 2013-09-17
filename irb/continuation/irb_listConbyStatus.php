<?php require_once('../Connections/con3.php');
session_start();

$restrictGoTo = "../unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

if (!($_SESSION['User_Type'] == "IRB Staff")) { 
  
 if (!($_SESSION['User_Type'] == "IRB Chair")){
  header("Location: ". $restrictGoTo); 
  exit;
  }
}
mysql_select_db($database_con3, $con3);
if($_POST['selectStatus'] =='Finished'){
$query_Recordset1 = "SELECT * FROM continuation where (appFinished ='Yes' && Approval ='No') order by ReceiveDate";
}
else
{
$query_Recordset1 = "SELECT * FROM continuation where (Approval ='".$_POST['selectStatus']."') order by ReceiveDate";
}

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
    <td bgcolor="#000000" align="center" colspan="6">
   <a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="irb_listContinuation.php" class="irb">List All Continuation/Change Application </a> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a><br>
     
      </td></tr>
		<tr><td colspan="6"> 
    
      </td>
        </tr>
       <tr><td colspan="6"><div align="center">
         <p><br><strong>IRB CONTINUATION/CHANGE APPLICATION</strong></p>
         <p>&nbsp;</p>
       </div></td>
       </tr><tr><td colspan="6">
            <label><form name="form1" method="post" action="searchCon.php">
            <p>Search Continuation Application by Continuation Applicaiton Number:  
              <input type="text" name="ID" id="ID"> 
              <input name="submit" type="submit" value="Search">
            </p>
         
            </form>
          </label></td>
        </tr> <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<tr> <td colspan="6" valign="top"><p>Search Continuation Application by Status:  
			 
              <select name="selectStatus">
                <option selected>Select One</option>
                <option value="No">Application in Process (not approved yet)</option>
                <option value="Finished">Application Not Approved and Application Finished/Closed</option>
             <option value="Yes">Application Approved</option>
               
              </select>
			 <input name="submit" type="submit" value="Search">
              <hr></td></tr>
         
        
   


 <?php echo "<tr><td colspan='6'><b>"; 
 
 if ($_POST['selectStatus'] == "Yes") echo "Application Approved";
  if ($_POST['selectStatus'] == "No") echo "Application Not Approved";
   if ($_POST['selectStatus'] == "Finished") echo "Application Not Approved and Application Closed";
 echo "</b></td></tr>";
  if($totalRows_Recordset1>0){
  ?>
 <tr><td>Continuation Application ID Number</td><td>IRB Application Number</td><td>Applicant Name</td><td>This Application is a </td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan="6">&nbsp;</td></tr>
  <?php
  do
  { 
  ?><tr><td>
  <?php
  echo $row_Recordset1['ID'];?></td><td><?php
  echo $row_Recordset1['App_Number'];?>
 
  </td>
  
   <td><?php
  //echo $row_Recordset1['username'];
 mysql_select_db($database_con3, $con3);
$query = "SELECT FirstName, LastName FROM user where username='".$row_Recordset1['username']."'";
$rec = mysql_query($query, $con3) or die(mysql_error());
$row_rec= mysql_fetch_assoc($rec);
$totalRows = mysql_num_rows($rec);
echo $row_rec['FirstName']." ".$row_rec['LastName'];
mysql_free_result($rec);
?>
  </td><td><?php echo $row_Recordset1['conOrChange']; ?></td>
  <td> <?php echo "<a href='irb_status_summary.php?ID=".$row_Recordset1['ID']."'>Application Status</td>";?>
  <td>
  <?php echo "<a href='irb_continuation_summary.php?ID=".$row_Recordset1['ID']."'>Review Application Data</a></td>"; 
 	
	?>
	 <td>
  <?php 
 if ($row_Recordset1['Approval'] == "Yes"){
  echo "<a href='certificate_con.php?ID=".$row_Recordset1['ID']."'>Print Certificate</a></td>"; 
 	}
	?>
  <tr><td colspan='6'><hr></td></tr>
  <?php
    }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	}
	else
	echo "<tr><td colspan='6'><font color='red'>No application found.</font><br><br></td></tr>";
   ?>
   </table></td></tr><tr><td> <br><br><br> 
 <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table>
   </table></td></tr>
   </table>
   
  <?php
mysql_free_result($Recordset1);
?>
   
