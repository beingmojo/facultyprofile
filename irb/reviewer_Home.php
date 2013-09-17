<?php require_once('Connections/dbc.php'); ?>
<?php


// *** Validate request to login to this site.
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


if (!($_SESSION['User_Type'] == "reviewer")) {   
 
  header("Location: ". $restrictGoTo); 
  exit;
}


?>
<?php
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($_SESSION['username']) : $_SESSION['username'];

$query_Recordset1 = "SELECT application.App_Number, application.ProjectTitle FROM application WHERE ((application.rev1ID = '".$theValue."' || application.rev2ID = '".$theValue."' || application.rev3ID = '".$theValue."') && Status != 'Approved')";
$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);



$query_Recordset2= sprintf("SELECT application.App_Number, application.ProjectTitle FROM application WHERE application.username='%s'",$theValue);
$Recordset2 = mysql_query($query_Recordset2, $con) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IRB Online Application</title>

<style type="text/css">
<!--
.style6 {
	font-family: Arial, Helvetica, sans-serif;
	color: #333399;
	font-weight: bold;
}
a.navbar:link {
	color: #4d3319;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: normal;
}
a.navbar:visited {
	color: #4d3319;
	text-decoration: none;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
a.navbar:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	text-decoration: underline;
}
a.body:link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #336699;
	text-decoration: underline;
}
a.body:visited {
	font-family: Arial, Helvetica, sans-serif;
	color: #4D3319;
	text-decoration: underline;
}

a.irb:link{
font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;

}
a.irb:visited {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	
	text-decoration: none;
}
-->
  </style>
  <style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style21 {
	color: #000066;
	font-size: 16px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style23 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; }
-->
  </style>
</head>
<body text="#000000">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
 <tbody>
    <tr>
      <td height="150" valign="top" width="800">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tbody>
          <tr>
            <td valign="top" bgcolor="#330000"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a><br>  </td>
            <td bgcolor="#330000">
              <div align="right"><a href="LogOut.php" class="style33"><font color="#FFFFFF"">Log
Out</font></a><font color="#336699"><br>
</font></div></td>
            </tr>
          
          
          <tr>
            <td colspan="2" height="21" valign="top">
            <div align="center">
              <p class="style6">&nbsp;</p>
              <p><span class="style17"><a class="irb" href="index.php"
><span class="style21">Institutional Review Board</span><span class="style17"></a></p>
              <p class="style6">Online Application<hr />
              <div align="center" class="style23"><a href="irbform.php">Submit  IRB Application </a>| <a href="applicant_reviewer_app.php">IRB Applications You Submitted</a> | <a href="reviewer_app.php">Evaluate Applications </a> |<a href="rev_listApp.php">List All  Applications </a><br />
                <a href="update_reviewer_userInfo.php">Updatge Personal Information </a>|<a href="MessageCenter.php">Message Center</a> | <a href="LogOut.php">Log Out</a> </div>
              <a href="LogOut.php">
              <hr />
              </a>
              </p>
              </div>            </td>
          </tr>
          <tr>
            <td colspan="2" height="19" valign="top">&nbsp;</td>
          </tr>
        </tbody>
      </table>
      </td>
    </tr>
</tbody></table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr><td colspan="3"><div align="center"><strong><?php echo $_SESSION['username'];?></strong></div></td>
</tr>
<tr><td colspan="3"><div align="left" class="style23">
  <p>
  
  <form method="post" action="searchApp_rev.php">
  <p>Search IRB applications submitted: <br />
    Enter Application Number:
    <input type="text" name="appnumber" />
    <input type="submit" name="Submit" value="Search Application" />
    <br />
  
  </form>
</p>
<hr />
<strong>Applications for You to Review or You Have Reviewed</strong></div></td>
</tr>
<?php

 if ($totalRows_Recordset1 > 0)
  do
  { 
  ?>
  <tr><td>
    <div align="center" class="style23">
      <?php  echo $row_Recordset1['ProjectTitle']."</td><td>".$row_Recordset1['App_Number']; ?>
    </div></td><td>
      <span class="style23"><?php echo "<a href='appSummary_reviewer.php?appNum=". $row_Recordset1['App_Number']."'>Review Application Data</a><br>"; ?></span><td> </td></tr>
   <?php 
   } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1))
   
    //end if
   ?>
   
   <tr><td colspan="3"><hr /></td>
   </tr>
   
   <tr>
     <td colspan="3"><ul class="style23">
       <li><strong>If you have submitted IRB applications, click the links to review and edit your applications</strong></li>
     </ul></td>
  </tr>
 <?php
  if($totalRows_Recordset2)
  do { 
    ?>
  <tr><td>
  <div align="center" class="style23">
    <?php  echo $row_Recordset2['App_Number']."  ".$row_Recordset2['ProjectTitle']; ?>
  </div>
  </div></td></tr><tr><td>
    <div align="center" class="style23"><?php echo "<a href='appSummary_applicant.php?appNum=". $row_Recordset2['App_Number']."'>Review Application</a><br>"; ?></div></td></tr><tr><td><br>
      <div align="center" class="style23"><?php echo "<a href='appUpdate_applicant.php?appNum=". $row_Recordset2['App_Number']."'>Update Application</a><br>"; ?></div></td></tr> <tr><td></td></tr>
  <?php
    }while($row_Recordset2 = mysql_fetch_assoc($Recordset2))
	
   ?>   
   <tr><td colspan="3"><hr /></td></tr>
   <tr><td colspan="3"><div align="center"><span class="style23">
     <ul>
       <li>
         <div align="left"><a href="update_reviewer_userInfo.php"><strong>Update Personal Information</strong></a></div>
       </li>
       </ul>
     <p><hr />
   </span>
         <p><span class="style23">
          Office of Sponsored Programs 
          
              </span>
             <span class="style23"><br />
             For questions regarding application submission contact OSP at <a
 href="mailto:mb29@txstate.edu">sn10@txstate.edu</a> , x 2314</span> </p>
         <p>&nbsp;</p>
   </div></td>
   </tr>
</table>
   
  
  

</body>
</html>
<?php
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
?>
