<?php require_once('Connections/dbc.php');
session_start();

$restrictGoTo = "unauthorized.php";

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
?>


<?php

$query_Recordset1 = "SELECT * FROM user ORDER BY LastName";
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

<script>
function deleteConfirm(str)
{
if (confirm('Are you sure you want to remove this user permanently?')){
dirlocation="deleteApplicant.php?ID="+str;
document.location.href=dirlocation;
}
}
</script>
  <style type="text/css">
<!--
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
            <td width="552" valign="top"><p align="left"><img src="banner2.jpg" width="550" height="160"></td>
            <td width="248" valign="middle" background="tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
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
      <td height="348" valign="top">
<table width="100%" align="center" border="0"><tr><td>
   <p>&nbsp;</p>
        <p align="center"><span class="style3">SEARCH IRB USERS</span><br>
        </p>
        <form name="form1" method="post" action="searchuser.php">
            <label>
            <div align="center"><span class="style27">Enter the Last Name to Search</span>
              
              <input type="text" name="LastName">
              <input type="submit" name="Submit" value="Search User">
            </div>
            <div align="center"><br>
                </label>
            </div>
              <label></label>
          </form>
          <br></td><tr>
   
    <tr>
      <td height="348" valign="top" bgcolor="#FFFFFF">
<table align="center">
  <tr>
    <td colspan="2" class="style3"><div align="center">IRB USERS    </div>    </tr><tr><td colspan="2" class="style18"><hr /></td></tr>
<?php do{ ?>
<tr><td width="197" class="style18" >Name:</td>
<td width="376" class="style18">

  <span class="style16"><?php echo $row_Recordset1['FirstName']; ?>&nbsp;<?php echo $row_Recordset1['LastName']; ?>
  <input name="button" type='button' onClick="deleteConfirm('<?php echo $row_Recordset1['username']?>')" value='Remove User'>
  </span>

  </td>
</tr><tr><td class="style18" >User Name:</td><td class="style18">
    <span class="style16"><?php echo $row_Recordset1['username']; ?></span></td>
  <td class="style18">&nbsp;</td>
</tr>
<tr><td class="style18" >Password:</td><td class="style18">
    <span class="style16"><?php echo $row_Recordset1['password']; ?></span></td>
  <td class="style18">&nbsp;</td>
</tr>


<tr><td class="style18" >Phone:</td><td class="style18"><?php echo $row_Recordset1['Phone']; ?></td>
  <td class="style18">&nbsp;</td>
</tr>
<tr><td class="style18" >Email:</td><td class="style18"><?php echo $row_Recordset1['Email']; ?></td>
</tr>
<tr><td class="style18" >Department:</td><td class="style18"><?php echo $row_Recordset1['Department']; ?></td>
</tr>
<tr><td class="style18" >Applicant is a:</td><td class="style18"><?php echo $row_Recordset1['User_Type']; ?></td>
</tr>
<tr><td class="style18" >Major:</td><td class="style18"><?php echo $row_Recordset1['Major']; ?></td>
</tr>
<tr><td class="style18" >Rank:</td><td class="style18"><?php echo $row_Recordset1['Rank']; ?></td>
</tr>

<tr><td class="style18" >HSP Training:</td><td class="style18"><?php echo $row_Recordset1['Training']; ?></td>
</tr>
<tr>
  <td class="style18" >Last Login: </td>
  <td class="style18"><?php echo $row_Recordset1['lastLogin']; ?></td>
</tr>

<tr><td colspan="2" class="style18"><hr /></td></tr>
<?php }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) 
?>
</table>
<div align="center" class="style18">Office of Sponsored Programs <br>
For questions regarding application submission contact IRB at <a href="mailto:ospirb@txstate.edu">ospirb@txstate.edu</a> , x 7975</div></td>
    </tr></table>
      </body>
</html>
<?php
mysql_free_result($Recordset1);
?>
