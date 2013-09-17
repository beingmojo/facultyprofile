<?php require_once('Connections/con3.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

if ((isset($_POST["searchEmail"])) && ($_POST["searchEmail"] == "IRBForm")){
mysql_select_db($database_con3, $con3);

$appNum=$_POST['appNum'];
$order=$_POST['order'];
$query_Recordset1 = "SELECT messages.`EmailTime`, messages.`FromEmail`, messages.`ToEmail`, messages.Subject, messages.ID, messages.Msg, messages.appNum FROM messages where appNum ='".$appNum."' order by ".$order;
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos </title>
  <style type="text/css">
<!--
.style4 {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 40px;
	color: #333399;
}
.style6 {
	font-family: Arial, Helvetica, sans-serif;
	color: #333399;
	font-weight: bold;
}
.style7 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #4d3319;
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
font-family: Arial, Helvetica, sans-serif;
	color: #336699;
	text-decoration: none;

}
a.irb:visited {
	font-family: Arial, Helvetica, sans-serif;
	color: #336699;
	text-decoration: none;
}
-->
  </style>
  <style type="text/css">
<!--
.style14 {font-size: small}
body {
	background-color: #cccccc;
}
.style16 {
	color: #FFFFFF;
	font-weight: bold;
}
.style21 {font-size: 12px}
-->
  </style>
</head>
<body><table width="800" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="5" cellspacing="0" >
<tbody>
   <tr>
            <td valign="top" bgcolor="#330000"><a
 href="http://www.txstate.edu"><img src="txstate_logo2.gif"
 alt="TxState" name="TxState" id="TxState" border="0"></a></td>
            <td width="99" valign="top" bgcolor="#330000" class="style4"><br>            </td>
            <td bgcolor="#330000">
              <div class="style7" align="right"><a href="LogOut.php" class="style14 style16">Log
Out</a></div></td>
          </tr>
          
        <tr>
            <td colspan="3" height="21" valign="top">
            <div align="center">
              <p>&nbsp;</p>
              <p><a class="irb" href="index.php"><span class="style21"><strong>Institutional Review Board</strong></span></a>              </p>
              <p class="style6">Online Application
              <hr>
            </div></td>
          </tr>
          <tr>
            <td colspan="3" height="19" valign="top">
			  <div align="center"><span class="style46">
			  <div align="center"><?php if ($_SESSION['User_Type'] == "reviewer") echo "<a href='reviewer_Home.php'>"; ?><?php if ($_SESSION['User_Type'] == "IRB Chair" || $_SESSION['User_Type'] == "IRB Staff") echo "<a href='osp_irb_home.php'>"; ?>OSP IRB Home</a> </div></td>
          </tr>
  </tbody>
      </table>
      </td>
  </tr>
    <tr>
      <td valign="top" ><div align="center">
        <p><strong>IRB Message Center -- Search Messages</strong></p>
        <p align="left">Note: Only messages sent by Message Center are recorded and searchable. </p>
        </div></td></tr><tr><td bgcolor="#dddddd"><form name="form1" method="post" action="">
          <label>
          <div align="left"><strong>Enter Application Number here:</strong>
              <input name="appNum" type="text" id="appNum">
          </div>
          <strong>
          <label></label>
          </strong>
          <p align="left">
          <input name="order" type="radio" value="EmailTime">
          Order By Date
           <input name="order" type="radio" value="FromEmail">
          Order By Sender
          <input name="order" type="radio" value="ToEmail">
          Order By Receiver 
          <input name="order" type="radio" value="Time">
Order By Application Number <br>
		   <input type="hidden" name="searchEmail" value="IRBForm">
          <input type="submit" name="Submit" value="      Search      ">
          </label>
        </form>
     </td></tr><tr><td>
		<?php
		if ((isset($_POST["searchEmail"])) && ($_POST["searchEmail"] == "IRBForm")){
		?>
          <table width="700" border="1">
            <tr>
              <td><strong>Date</strong></td>
              <td><strong>From</strong></td>
              <td><strong>To</strong></td>
              <td><strong>Subject</strong></td>
              <td>&nbsp;</td>
            </tr>
			<?php do{ ?>
            <tr>
              <td><?Php echo $row_Recordset1['EmailTime'];?></td>
              <td><?Php echo $row_Recordset1['FromEmail'];?></td>
              <td><?Php echo $row_Recordset1['ToEmail'];?></td>
              <td><?Php echo $row_Recordset1['Subject'];?></td>
              <td><input type="button" onclick="alert('<?Php echo $row_Recordset1['Msg'];?>')" value="View Message"></td>
            </tr>
			<?php
			}while($row_Recordset1 = mysql_fetch_assoc($Recordset1))
			?>
          </table>
		  <?php
		  ?>
          <p>&nbsp;</p>
        </td>
     </tr></table>
       
	
	  
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset);

?>
