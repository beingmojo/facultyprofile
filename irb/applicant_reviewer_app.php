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
mysql_select_db($database_con3, $con3);
$query_Recordset1 = sprintf("SELECT application.App_Number, application.ProjectTitle FROM application WHERE application.username='%s'", $un_Recordset1);
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
  <title>Texas State University-San Marcos | IRB Application</title>
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
.style31 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.style33 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: small; }
.style34 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style36 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; color: #000033; }
.style38 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: small; }
.style41 {color: #ECE9D8}
.style42 {color: #FF0000}
-->
  </style>
</head>
<body>
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
              <div align="right"><a href="LogOut.php" class="style38"><font color="#FFFFFF"">Log
Out</font></a><font color="#336699"><br>
</font></div></td>
            </tr>
          
          
          <tr>
            <td colspan="2" height="21" valign="top">
            <div align="center">
              <p class="style6">&nbsp;</p>
              <p><span class="style17"><a class="irb" href="index.php"
><span class="style21">Institutional Review Board</span><span class="style17"></a></p>
              <p class="style6">Online Application</p>
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
<table width="800" height="300" border="0" align="center" bgcolor="#eeeeee">
  <tr>
    <td colspan="2"><div align="center"><span class="style33"><a class="irb" href="applicant_reviewer_app.php">
      <hr>
      <span class="style7 style41"><a href="LogOut.php" class="irb"><span class="style29"></a></span><span class="style41"><a class="irb" href="applicant_app.php">IRB Applications Submitted </a>| <a class="irb" href="irbform.php" title="IRB Application">Start a New IRB Application</a> | <a class="irb" href="<?php echo $_SESSION['myhome'];?>">Applicant Home</a> |<a href="LogOut.php" class="irb"> Log
        Out</a></span></a></span><strong>
      <hr>
      <br>
      <?php echo $_SESSION['username'];?></strong><br>
      <span class="style42">You are now enter the space for IRB applicants. To see the menu for reviewers, please log out and login again.</span></div></td>
  </tr>
  <tr><td colspan="2"><p class="style34">
      <div align="center"><span class="style36">Current IRB Application</span> </div>
      <hr></td></tr>
  </p>
  <p>
<?php
if($totalRows_Recordset1 = mysql_num_rows($Recordset1)<1)
echo "<tr><td colspan='2' ><font color='red'>You have not submitted any IRB applications.</font></td></tr>";
else{
  do
  { 
  ?><tr><td colspan="2"><div align="center">
 
    <?php
  echo $row_Recordset1['ProjectTitle']; 
  ?>
    </p>
</div></td></tr><tr><td >
  <div align="center"><?php echo "<a href='appSummary_applicant.php?appNum=".$row_Recordset1['App_Number']."'>Review Application Date</a><br>"; ?></div></td><td >
    <div align="center"><?php echo "<a href='appUpdate_applicant.php?appNum=".$row_Recordset1['App_Number']."'>Update Application</a><br>"; ?></div></td></tr> <tr><td colspan="2"><hr /></td></tr>
  <?php
    }while($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	}
   ?>

     
    <tr>
                    <th bgcolor="#eeeeee" scope="row" colspan="2"><hr>
                      <span class="style33">Office of Sponsored Programs <br>
      For questions regarding application submission contact OSP at <a
 href="mailto:mb29@txstate.edu">sn10@txstate.edu</a> , x 2314 
      </p>
                      </span>
      <p class="style31">&nbsp;</p></th>
  </tr>
</table>
   <p>&nbsp;   </p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
