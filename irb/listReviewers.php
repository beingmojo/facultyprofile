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

$query_Recordset1 = "SELECT `user`.username, `user`.password, `user`.FirstName, `user`.LastName, `user`.Phone, `user`.Email, `user`.Department FROM `user` WHERE  `user`.User_Type='reviewer' ORDER BY `user`.LastName";
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
 
 <LINK href="irbstyle.css" rel="stylesheet" type="text/css">

  <style type="text/css">
<!--
.style43 {font-size: large}
-->
  </style>
  

<script>
function deleteConfirm(str)
{
if (confirm("Are you sure you want to remove this reviewer permanently?")){
dirlocation="deleteReviewer.php?ID="+str;
document.location.href=dirlocation;
}
}
</script>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center" class="tsu">Texas State University</p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </a></p>
           
            </p>
            </span></td>
   </tr>
</tbody></table></td></tr></table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
				
          <tr>
            <td valign="top" bgcolor="#000000">
			  <div align="center"><a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home </a> <span class="style39">|</span><span class="irb"><a class="irb" href="irb_listApp.php">List All IRB Applications</a> <span class="style39">|</span> <a class="irb" href="listReviewers.php" >List All Reviewers </a> <span class="style39">|</span> <a class="irb" href="listApplicants.php" >List All Users</a> <span class="style39">|</span> <a href="LogOut.php" class="irb">Log Out</a></div></td>
          </tr>
  
  				
    <tr>
      <td valign="top">  <div align="center" class="style3">
    <p>&nbsp;</p>
    <p>IRB REVIEWERS  </p>
  </div></td></tr><tr><td>
<table width="100%" align="center" border="1" cellspacing="-1" cellpadding="6">
<tr><td colspan="2" >
</td>
</tr>

<?php do{ ?>
<tr><td colspan = "2" align="center">

<Strong><?php echo $row_Recordset1['FirstName']; ?>&nbsp;<?php echo $row_Recordset1['LastName']; ?>
 </Strong>&nbsp; &nbsp;&nbsp;&nbsp;<input name="button" type='button' onClick="deleteConfirm('<?php echo addslashes($row_Recordset1['username'])?>')" value='Remove Reviewer'></td>

</tr>
<tr><td>User Name:</td><td>
<?php echo $row_Recordset1['username']; ?></td>
  
</tr>


<tr><td>Phone:</td><td><?php echo $row_Recordset1['Phone']; ?></td>
 
</tr>
<tr><td>Email:</td><td><?php echo $row_Recordset1['Email']; ?></td>
 
</tr>
<tr><td>Department:</td><td><?php echo $row_Recordset1['Department']; ?></td>
  
</tr>
<tr><td>Number of Active Reviews:</td><td> 
<?php 

$theValue = $row_Recordset1['username'];


$query_Recordset3 = "SELECT application.App_Number, application.ProjectTitle, application.Status FROM application WHERE ((application.rev1ID = '".$theValue."' || application.rev2ID = '".$theValue."' || application.rev3ID = '".$theValue."') && (Status != 'Approved' && Status != 'Applicant Requested Continuation' && Status != 'Application Approved - Exempt'))";
$Recordset3 = mysql_query($query_Recordset3, $con) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
echo $totalRows_Recordset3. "</td></tr><tr><td>Application Information:</td><td>";

do{

echo "Application Number: ".$row_Recordset3['App_Number']."<br>Project Title: ". $row_Recordset3['ProjectTitle']."<br>Status: ". $row_Recordset3['Status']."<br><br>";

}while($row_Recordset3 = mysql_fetch_assoc($Recordset3));
mysql_free_result($Recordset3);
?></td>
  
</tr>
<tr><td colspan="2" height="3">
<?php }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) 
?></td></tr></table>
<tr><td><br><br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>

</table>

</td></tr></table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
