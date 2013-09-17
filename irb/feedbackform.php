<?php require_once('Connections/con3.php'); ?>
<?php
session_start();
$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
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
$pageurl=$_GET['pageurl'];
//if the login form is submitted
if (isset($_POST['submit'])) { 
$pageurl=$_POST['pageurl'];
////////////////////////////////////
$today=date("m/d/y H:i:s");

$insertSQL = sprintf("INSERT INTO feedback (pageurl, comments, commentsDate, username) VALUES (%s, %s, %s, %s)",
      GetSQLValueString($_POST['pageurl'], "text"),
	  GetSQLValueString($_POST['comments'], "text"),
	  GetSQLValueString($today, "text"),
	  GetSQLValueString($_POST['username'], "text"));

$Result1 = mysql_query($insertSQL, $con3) or die(mysql_error()); 
 
 //////////////////////////////////

}
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
      <td colspan="4" bgcolor="#000000"><div align="center" class="style9"><span class="style15"><a class="irb" href="javascript:window.close()">Close this Window and Go Back</a> <span class="style42">|</span> <a class="irb" href="LogOut.php">Log Out</a></span></div></td>
</tr></table></td></tr>
    <tr>
      <td> <table width = "700" align="center"> 
        <tr><td>
       <br> <p align="center"><strong>IRB Online Application System Feedback</strong></p>
      
	   <?php
	   if (isset($_POST['submit'])) { 
	   echo "<font color='red'>Thank you very much for your comments!</font></p>";
	   }?>
  Please use this feedback form to send us your comments, questions and suggestions. Thanks! </p>
       </div></td>
</tr>
   
  <tr><td>

<table border="0" bgcolor="#FFFFFF" > 
<tr><td>
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  URL of the page that you would like to give comments on: <br><input name="pageurl" value="<?php echo $pageurl;?>" size="60"/>
  </p>
  <p>Your comments:<br>
  <textarea name="comments" cols="80" rows="8"></textarea> 
  </p><p><input type="hidden" name="insert" maxlength="50" value="inserted"> 

  <input type="hidden" name="username" maxlength="50" value="<?php echo $_SESSION['username'];?>"> 
    <input type="submit" name="submit" value="Send Comments" />

</form>
      
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
