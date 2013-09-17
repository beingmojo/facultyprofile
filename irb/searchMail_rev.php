<?php require_once('Connections/con3.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
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
			  <div align="center"><a href='reviewer_Home.php'>OSP IRB Home</a> </div></td>
          </tr>
  </tbody>
      </table>
      </td>
  </tr>
    <tr>
      <td height="348" valign="top"><div align="center">
        <p>IRB Message Center </p>
        <p><strong>Search Messages</strong></p>
        <p>&nbsp;</p>
        <form name="form1" method="post" action="">
          <label><strong>Enter Application Number here:</strong>
          <input type="text" name="textfield">
          </label>
          <strong>
          <label></label>
          </strong>
      <p><strong>                
                  <input name="radiobutton" type="radio" value="radiobutton">
                Order </strong>By Date</p>
                <p><strong>
                  <input name="radiobutton" type="radio" value="radiobutton">
                Order</strong> By Sender</p>
                <p><strong>
                  <input name="radiobutton" type="radio" value="radiobutton">
                Order</strong> By Receiver </p>
          <p>&nbsp;</p>
        </form>
        <div align="left">
          <p>&nbsp;</p>
        </div>
     </div>	 </td></tr></table>
       
	
	  
</body>
</html>
<?php
mysql_free_result($Recordset);

?>
