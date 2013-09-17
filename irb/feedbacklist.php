<?php require_once('Connections/dbc.php'); ?>
<?php
session_start();
$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

if (!($_SESSION['User_Type'] == "IRB Support")) { 
  

  header("Location: ". $restrictGoTo); 
 
}
 function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
?>
<?php
$query_Recordset1 = "select pageurl, comments, commentsDate from feedback order by pageurl";
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
.style42 {color: #FFFFFF}
.style43 {font-size: large}
-->
  </style>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="tbbg.gif" >

   <tr background="tbbg.gif">
            <td width="552" valign="top"><p align="left" class="style6 style24"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
            </p>
            </span></td>
   </tr>
  
      </table>
	  
      </td>
  </tr>
<tr><td>
<table width="800" border="0" align="center" bgcolor="#ffffff">
  <tr>
      <td colspan="4" bgcolor="#000000"><div align="center" class="style9"><span class="style15"><a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42">|</span> <a class="irb" href="LogOut.php">Log Out</a></span></div></td>
</tr></table></td></tr>
    <tr>
      <td> <br><br><table width = "800" align="center" border="1" cellspacing="-1"> 
        <tr><td colspan="3">
       <br> <p align="center"><strong>IRB Online Application System Feedbacks</strong><br><br></p>
       <tr><td align="center"><Strong>Page URL</Strong></td><td align="center"><Strong>Comments</Strong></td><td align="center"><Strong>Comment Date</Strong></td></tr>
	   <?php
	 do{ ?>
<tr><td align="center">

<?php echo $row_Recordset1['pageurl']; ?></td><td align="center">
<?php echo $row_Recordset1['comments']?></td><td align="center">
<?php echo $row_Recordset1['commentsDate']?></td align="center">

</tr>
<?php }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
mysql_free_result($Recordset1);
      
    ?>
	</div></td>
      </tr> 

</table> 


</td></tr><tr><td><br><br>
           
            <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr></table>


</body>
</html>
