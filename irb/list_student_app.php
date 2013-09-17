<?php require_once('Connections/con3.php');
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
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT application.App_Number, application.Status, application.ProjectTitle, submissionFinishedDate FROM application WHERE application.FacultyEmail='".$_SESSION["Email"]."' ORDER BY submissionFinishedDate DESC";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);




/////////////////////////////////////////////////////////////////////


//echo $_SESSION['username']."<br>";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="irbstyle.css" rel="stylesheet" type="text/css">


  <style type="text/css">
<!--
.style42 {color: #FFFFFF}
.style43 {font-size: large}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left" class="style6 style24"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
            </p>
            </span></td>
   </tr>
          
       
        </tbody>
      </table>
      </td>
  </tr>
</tbody></table>
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
      <div align="center"><a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42">|</span><a class="irb" href="applicant_app.php"> IRB Applications I Submitted</a> <span class="style42">|</span> <a class="irb" href="irbform.php" title="IRB Application">Start a New IRB Application</a> <span class="style42">|</span><a href="LogOut.php" class="irb"> Log
        Out</a></div></td>
  </tr>
  <tr><td colspan="5"><div align="center">
  
      <br>
      <?php echo $_SESSION['name'];?></div></td>
  </tr>
  <tr><td colspan="5"><p class="style34">
      <div align="center"><span class="style36"> <b>IRB Applications Submitt</b><strong>ed</strong> </span><strong>by Student(s)  </strong></div>
      <hr></td></tr>
  <td ></p>
      <p>
        <?php

  if($totalRows_Recordset1 = mysql_num_rows($Recordset1)<1)
echo "<tr><td colspan='2' ><font color='red'>No IRB application has been submitted by your students.</font></td></tr>";
else{
  do
  { 
  ?>
  <tr><td colspan="4"><div align="left">
 
    <?php
  echo "<b>Project Title:</b> ".$row_Recordset1['ProjectTitle']. "<br><b>Application Number:</b> ".$row_Recordset1['App_Number']; 
  ?>
   
</div></td></tr><tr><td colspan="4">
  <div align="left"><?php echo "<b>Status:</b> ";
  
  if (($row_Recordset1['Status'] == "Application Submitted to Reviewers for Review") || ($row_Recordset1['Status'] == "Application Submitted to IRB Chairs for Review"))
  echo "Application in Review";
  
  else  
  echo $row_Recordset1['Status']; ?>  </div></td></tr>
  
  
  <tr>
  <td  colspan="4"><br><?php echo "<a href='statSummary_faculty.php?appNum=".$row_Recordset1['App_Number']."'>Application Status</a>"; ?>      
 <?php echo "<a href='appSummary_faculty.php?appNum=".$row_Recordset1['App_Number']."'>Review Application and Certify Application</a>"; ?>      


 
    

    <?php if ($row_Recordset1['Status'] == "Approved" || $row_Recordset1['Status'] == "Application Approved - Exempt") echo "      <a href='certificate.php?appNum=".$row_Recordset1['App_Number']."'>Print Out Certificate</a>";?></td></tr>
    <tr><td colspan="4">
  </div>
  <hr align="center" /></td></tr>
	
	
  <?php
    }while($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	}
   ?>

   <tr><td><br><br><br>  
 <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr>
</table>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
