<?php require_once('Connections/con3.php');
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

   
  /////////////////////////////////
  mysql_select_db($database_con3, $con3);
 //$query = "select * from notelog where appNum='".$_GET['appNum']."' order by reviewNum";
   $query = "select * from notelog order by enterTime DESC";

  $result = mysql_query($query, $con3);
  $row = mysql_fetch_assoc($result);
  $numrows=mysql_num_rows($result);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="irbstyle.css" rel="stylesheet" type="text/css">
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
           
            </p>
            </span></td>
   </tr>
</tbody></table></td></tr><tr><td>
<table width="800" border="0" align="center" bgcolor="#ffffff">
          <tr>
            <td height="19" valign="top" bgcolor="#000000">
			  <div align="center"><span class="style46"><a href='osp_irb_home.php' class="irb">My IRB Home</a> </span><span class="style39">| <a href="LogOut.php" class="irb">Log Out</a> </div></td>
          </tr>
  </tbody>
      </table></td></tr><tr><td>
<table width="800" border="0" align="center" bgcolor="#ffffff">
          <tr><td align="center"><br><br><strong>Admin/Chair Notes</strong><br><br>
  <?php
	  echo "<table border = '1' cellspacing ='-1' width='600' bgcolor='#ffffff'><tr><td>Application Number</td><td>Time Entered</td></tr>";
  do{
  
  echo "<tr><td><a href='statSummary.php?appNum=".$row['appNum']."'>".$row['appNum']."</a><td>".$row['enterTime']."</td></tr>";
  
  
  }while ($row = mysql_fetch_assoc($result));
echo "</table>";
mysql_free_result($result);
mysql_close($con3);


?></td>
</td></tr></table></td></tr><tr><td><br><br><br><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></table>