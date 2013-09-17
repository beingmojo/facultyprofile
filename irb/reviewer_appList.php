<?php require_once('Connections/dbc.php'); 
 require_once('Connections/con3.php');
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
            <td width="248" valign="middle" background="tbbg.gif"><p align="center" class="tsu">Texas State University</p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
            </p>
            </span></td>
   </tr>
          
       
        </tbody>
      </table>
      </td>
  </tr>
<tr><td>
<table width="800" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
			  <div align="center"><span class="style46">
			  <div align="center" class="style6"><span class="style2"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a> </span><span class="style42">| </span><span class="style2"><a href="reviewer_app.php" class="irb">Evaluate Applications Assigned </a> </span><span class="style42">| </span><span class="style2"><a href="rev_listApp.php" class="irb">List All IRB Applications</a> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a></span></div></td>
          </tr>
  
   <tr><td colspan="4"><br><div align="center"><?php echo $_SESSION['name'];?></div></td></tr>
<table width="800" border="0" align="center" cellpadding="6" cellspacing="0" bgcolor="#FFFFFF">

<tr><td><div align="left" class="style23">
  <div align="center"><br>
  <strong>ALL ACTIVE APPLICATIONS ASSIGNED TO YOU </strong></div>
</div></td>
</tr><tr><td ><hr>
</td>
</tr>
<?php

//echo "<table border = '1'><tr><td>Application Number</td><td>Status</td><td>Reviewer 1 Finished?</td><td>Reviewer 2 Finished?</td><td>Reviewer 3 Finished?</td><td>Reviewer 1 Approved?</td><td>Reviewer 2 Approved?</td><td>Reviewer 3 Approved?</td><td>Review Number</td><td>Has Chair Been Notified?</td><td>Latest Review Requesting Date</td></tr>";
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($_SESSION['username']) : $_SESSION['username'];

$query_Recordset1 = "SELECT username, ActionFlag, application.App_Number, application.ProjectTitle, application.Status FROM application WHERE ((application.rev1ID = '".$theValue."' || application.rev2ID = '".$theValue."' || application.rev3ID = '".$theValue."') && (Status != 'Approved' && Status != 'Applicant Requested Continuation' && Status != 'Application Approved - Exempt' && Status != 'Applicant Requested Change' && Status != 'Application Discontinued')) ORDER BY submissionFinishedDate DESC, App_Number ASC";

$Recordset1 = mysql_query($query_Recordset1, $con) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if($row_Recordset1['rev3ID']){
echo "<table border = '1'><tr><td>Application Number</td><td>Status</td><td>Reviewer 1 Finished?</td><td>Reviewer 2 Finished?</td><td>Reviewer 3 Finished?</td><td>Reviewer 1 Approved?</td><td>Reviewer 2 Approved?</td><td>Reviewer 3 Approved?</td><td>Review Number</td><td>Has Chair Been Notified?</td><td>Latest Review Requesting Date</td></tr>";
}
else {
echo "<table border = '1'><tr><td>Application Number</td><td>Status</td><td>Reviewer 1 Finished?</td><td>Reviewer 2 Finished?</td><td>Reviewer 1 Approved?</td><td>Reviewer 2 Approved?</td><td>Review Number</td><td>Has Chair Been Notified?</td><td>Latest Review Requesting Date</td></tr>";
}

do{
mysql_select_db($database_con3, $con3);
 //$query = "select * from reviewlog where appNum='".$_GET['appNum']."' order by reviewNum";
$query = "select * from reviewlog where appNum = '".$row_Recordset1['App_Number']."' order by reviewNum";
  $result = mysql_query($query, $con3);
  $row = mysql_fetch_assoc($result);
  $numrows=mysql_num_rows($result);
  
do {
if($row_Recordset1['rev3ID']){
  echo " <tr><td>&nbsp;".$row['appNum']."<td>".$row_Recordset1['Status']."</td><td>&nbsp;".$row['rev1Finished']."</td><td>&nbsp;".$row['rev2Finished']."</td><td>&nbsp;".$row['rev3Finished']."</td><td>&nbsp;".$row['rev1Approved']."</td><td>&nbsp;".$row['rev2Approved']."</td><td>&nbsp;".$row['rev3Approved']."</td><td>&nbsp;".$row['reviewNum']."</td><td>&nbsp;".$row['noticeChair']."</td><td>&nbsp;".$row['reviewRequestingDate']."</td></tr>";
  }

  
  else
  {

  echo " <tr><td>&nbsp;".$row['appNum']."<td>".$row_Recordset1['Status']."</td><td>&nbsp;".$row['rev1Finished']."</td><td>&nbsp;".$row['rev2Finished']."</td></td><td>&nbsp;".$row['rev1Approved']."</td><td>&nbsp;".$row['rev2Approved']."</td><td>&nbsp;".$row['reviewNum']."</td><td>&nbsp;".$row['noticeChair']."</td><td>&nbsp;".$row['reviewRequestingDate']."</td></tr>";
  }
  }while ($row = mysql_fetch_assoc($result));
  mysql_free_result($result);

  }while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
echo "</table>";
  mysql_free_result($Recordset1);



?>




   
  </table>

   <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td>&nbsp;</td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;">
	  <?php include("footer.php"); ?>
      </td>
    </tr>

</table>

</body>
</html>

