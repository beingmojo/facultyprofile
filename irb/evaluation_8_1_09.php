<?php require_once('Connections/con3.php');
session_start();
require_once('variables/variables.php');
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


$time=date("m/d/y H:i:s");


//////////////////////////////////

$appNum = $_GET['appNum'];
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "IRBForm")) {


$today=date("m/d/y H:i:s");
	 $newaction=$_POST['irbActionLog']."<br><br>".$today.":<br>";
	 $newaction = $newaction."One of the reviewers evaluated the application. Approved the application? ".strtoupper($_POST['approve']);
if (!$_POST['approve'])
  die("<font color='red'>You need to select whether you approve this application or not.<br><a href='javascript:history.back()'> Back </a>");
  
  if (!$_POST['finishReview'])
  die("<font color='red'>You need to select whether you have finished reviewing this application or not.<br><a href='javascript:history.back()'> Back </a>");
$appNum = $_POST['App_Number'];
  if((strtoupper(trim($_POST['approve'])) =="NO" )||(trim($_POST['approve']) =="Approved pending changes" ))
  {
  if($_POST['comments']==""){
  die("<font color='red'>Because you did not approve this application you must provide comments in the textarea.<br><a href='javascript:history.back()'> Back </a>");
  
    }
  }
$comb_comments=$_POST['Prevcomments']."\r\r".$today." \r".$_POST['comments'];
if(trim($_POST['rev1ID']) == $_SESSION['username']){

	if (strtoupper($_POST['finishReview']) == "YES"){
	
		$updateSQL = "update reviewlog set rev1Finished='".$_POST['finishReview']."', rev1Approved ='".$_POST['approve']."' where (reviewNum='". $_POST['reviewnum']."' && appNum='".$_POST['App_Number']."')";
	   
			$result = mysql_query($updateSQL, $con3);
			
		}

	if((strtoupper(trim($_POST['approve'])) =="YES")||(trim($_POST['approve']) =="Approved pending changes")){
$updateSQL = sprintf("UPDATE application SET rev1Comments=%s, rev1Approved=%s, rev1ApprovedDate=%s, irbActionLog=%s WHERE App_Number=%s",		
                       GetSQLValueString($comb_comments, "text"),
                       GetSQLValueString($_POST['approve'], "text"),
                       GetSQLValueString($time, "text"),
					      GetSQLValueString($newaction, "text"),
                       GetSQLValueString($_POST['App_Number'], "text"));
                   
		}
		else{
		
		$updateSQL = sprintf("UPDATE application SET rev1Comments=%s, rev1Approved=%s, irbActionLog=%s WHERE App_Number=%s",		
                       GetSQLValueString($comb_comments, "text"),
                       GetSQLValueString($_POST['approve'], "text"),
                       GetSQLValueString($newaction, "text"),
                       GetSQLValueString($_POST['App_Number'], "text"));
		
		
		}
   }
   ////////////////////////////////////////////////////////////
    if(trim($_POST['rev2ID']) == $_SESSION['username']){
	
	if ($_POST['finishReview'] == "Yes"){
	
	
		$updateSQL = "update reviewlog set rev2Finished='".$_POST['finishReview']."', rev2Approved ='".$_POST['approve']."' where (reviewNum='".$_POST['reviewnum']."' && appNum='".$_POST['App_Number']."')";
	   
			$result = mysql_query($updateSQL, $con3);
		}
		
	if((strtoupper(trim($_POST['approve'])) =="YES")||(trim($_POST['approve']) =="Approved pending changes")){
$updateSQL = sprintf("UPDATE application SET rev2Comments=%s, rev2Approved=%s, rev2ApprovedDate=%s, irbActionLog=%s WHERE App_Number=%s",		
                       GetSQLValueString($comb_comments, "text"),
                       GetSQLValueString($_POST['approve'], "text"),
                       GetSQLValueString($time, "text"),
					      GetSQLValueString($newaction, "text"),
                       GetSQLValueString($_POST['App_Number'], "text"));
                   
		
                  }
				 else
				 {
$updateSQL = sprintf("UPDATE application SET rev2Comments=%s, rev2Approved=%s, irbActionLog=%s WHERE App_Number=%s",
                       GetSQLValueString($comb_comments, "text"),
                       GetSQLValueString($_POST['approve'], "text"),
                      GetSQLValueString($newaction, "text"),
                       GetSQLValueString($_POST['App_Number'], "text"));
                  }

   }
   
   //////////////////////////////////////////
      if(trim($_POST['rev3ID']) == $_SESSION['username']){
	 // if ($_POST['finishReview'] == "Yes"){
	
		$updateSQL = "update reviewlog set rev3Finished='".$_POST['finishReview']."', rev3Approved ='".$_POST['approve']."' where (reviewNum='".$_POST['reviewnum']."' && appNum='".$_POST['App_Number']."')";
	   
			$result = mysql_query($updateSQL, $con3);
	  	//}
	   if((strtoupper(trim($_POST['approve'])) =="YES")||(trim($_POST['approve']) =="Approved pending changes")){
$updateSQL = sprintf("UPDATE application SET rev3Comments=%s, rev3Approved=%s, rev3ApprovedDate=%s, irbActionLog=%s WHERE App_Number=%s",
                       GetSQLValueString($comb_comments, "text"),
                       GetSQLValueString($_POST['approve'], "text"),
                       GetSQLValueString($time, "text"),
					   GetSQLValueString($newaction, "text"),
                       GetSQLValueString($_POST['App_Number'], "text"));
                  }
				  else
				     
	{
$updateSQL = sprintf("UPDATE application SET rev3Comments=%s, rev3Approved=%s, irbActionLog=%s WHERE App_Number=%s",
                       GetSQLValueString($comb_comments, "text"),
                       GetSQLValueString($_POST['approve'], "text"),
                       GetSQLValueString($newaction, "text"),
                       GetSQLValueString($_POST['App_Number'], "text"));
                  }
   }
   mysql_select_db($database_con3, $con3);
  $Result1 = mysql_query($updateSQL, $con3) or die(mysql_error());
  
  
  //email notification to chairs if all reviewers finished reviewer
  
    mysql_select_db($database_con3, $con3);
$query = "select numReviewers from application where App_Number='".$_POST['App_Number']."'";
$Result = mysql_query($query, $con3);
$row_result = mysql_fetch_assoc($Result);
$totalnum = mysql_num_rows($Result);
  $numReviewers = $row_result['numReviewers'];
 //echo "number of reviewers:".$numReviewers."<br>";
  mysql_free_result($Result);
  
  mysql_select_db($database_con3, $con3);
$query = "select * from reviewlog where (reviewNum = '".$_POST['reviewnum']."' && appNum='".$_POST['App_Number']."')";
$Result = mysql_query($query, $con3);
$row_result = mysql_fetch_assoc($Result);
//$numReviewers = $row_result['numReviewers'];
//echo "finished:".$row_result['rev1Finished']."/";
//echo $row_result['rev2Finished'];
//have all the reviewers finished review?
if($numReviewers == 2){
if (($row_result['rev1Finished']=="Yes") && ($row_result['rev2Finished']=="Yes")){
//echo "chair need to be noticed";

//testing code
$subject = "IRB Application ".$_POST['App_Number'].": Reviewers have finished reviewing the application";
$body = "IRB Application ".$_POST['App_Number'].": Reviewers have finished reviewing the application";
$to = "ys11@txstate.edu";
mail($to,$subject,$body,$headers);
//end testing
//find if chair is noticed
if(trim(strtoupper($row_result['noticeChair']))<>"YES"){
//echo "<br>Notice Chair:".$row_result['noticeChair'];
//email

	$body = "\r\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\rApplication Number: ".$_POST['App_Number']."\rAll reviewers have reviewed the application for the reviewing round number ".$_POST['reviewnum'].".\r\rPlease click the following link to log into IRB Online Application System:\r\n".$irbadd."?appNum=".$_POST['App_Number']."\r\n";
    
	$subject = "IRB Application ".$_POST['App_Number'].": Reviewers have finished reviewing the application";

//find chairs email address
	mysql_select_db($database_con3, $con3);
$query_Recordset = "SELECT Email FROM `user` where User_Type='IRB Chair'";
$Recordset = mysql_query($query_Recordset, $con3) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);
  $from="From: ".$_SESSION['Email'];
do
{

 $to = $row_Recordset['Email'];
//$to = "ys11@txstate.edu";
mail($to,$subject,$body,$headers);

}while($row_Recordset = mysql_fetch_assoc($Recordset));

  mysql_free_result($Recordset);
  //insert noticechair
$insertSQL="update reviewlog set noticeChair='Yes' where (appNum='".$_POST['App_Number']."' && reviewNum='".$_POST['reviewnum']."')";

mysql_select_db($database_con3, $con3);
$result = mysql_query($insertSQL, $con3);
 }//if not noticed
 }//all reviewed
 }//if number =2
 //have all the reviewers finished review?
if($numReviewers == 3){
if (($row_result['rev1Finished']=="Yes") && ($row_result['rev2Finished']=="Yes")&&($row_result['rev3Finished']=="Yes")){

//testing code
if ($_SESSION['username'] == "eas17"){
 $to="ys11@txstate.edu";
 	$subject = "IRB Application ".$_POST['App_Number'].": Reviewers have finished reviewing the application";
	$body = "\r\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\rApplication Number: ".$_POST['App_Number']."\rAll reviewers have reviewed the application for the reviewing round number ".$_POST['reviewnum'].".\r\rPlease click the following link to log into IRB Online Application System:\r\n".$irbadd."?appNum=".$_POST['App_Number']."\r\n";
mail($to,$subject,$body,$headers);

}
//end testing

//find if chair is noticed
if(trim(strtoupper($row_result['noticeChair']))!="YES"){

//email

	$body = "\r\rDO NOT REPLY TO THIS MESSAGE. This email message is generated by the IRB online application program. \r\rApplication Number: ".$_POST['App_Number']."\rAll reviewers have reviewed the application for the reviewing round number ".$_POST['reviewnum'].".\r\r\Please click the following link to log into IRB Online Application System:\r\n".$irbadd."?appNum=".$_POST['App_Number']."\r\n";
    
	$subject = "IRB Application ".$_POST['App_Number']." Reviewers have finished reviewing the application";

//find chairs email address
	mysql_select_db($database_con3, $con3);
$query_Recordset = "SELECT Email FROM `user` where User_Type='IRB Chair'";
$Recordset = mysql_query($query_Recordset, $con3) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);
  $from="From: ".$_SESSION['Email'];
do
{

  $to = $row_Recordset['Email'];

mail($to,$subject,$body,$headers);
 $to="ys11@txstate.edu";
mail($to,$subject,$body,$headers);

}while($row_Recordset = mysql_fetch_assoc($Recordset));

  mysql_free_result($Recordset);
  //insert noticechair
$insertSQL="update reviewlog set noticeChair='Yes' where (appNum='".$_POST['App_Number']."' && reviewNum='".$_POST['reviewnum']."')";
mysql_select_db($database_con3, $con3);
$result = mysql_query($insertSQL, $con3);
 }
 
 

}//if not noticed
}//end if all reviewed
  

} //end post

mysql_select_db($database_con3, $con3);
$query_Recordset1 = "SELECT * FROM application where App_Number='".$appNum."' && (rev1ID='".$_SESSION['username']."' || rev2ID='".$_SESSION['username']."' || rev3ID='".$_SESSION['username']."')";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
if($totalRows_Recordset1<1){
	die("<font color='red'>You are not assigned to evaluate this application.<br><a href='javascript:history.back()'> Back </a>");
	}
/*
mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT `user`.Email, `user`.User_Type FROM `user` where User_Type='IRB Staff'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
*/
mysql_select_db($database_con3, $con3);
$query_Recordset3 = "SELECT `user`.username, `user`.FirstName, `user`.LastName FROM `user` where username='".$_SESSION['username']."'";
$Recordset3 = mysql_query($query_Recordset3, $con3) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

/*
 $numRev = 0;
if ($row_Recordset1['rev1ID'] !="") $numRev = $numRev + 1;
if ($row_Recordset1['rev2ID'] !="") $numRev = $numRev + 1;
if ($row_Recordset1['rev3ID'] !="") $numRev = $numRev + 1;
//echo "Number of reviewers: ".$numRev."<br>";
 $numComments = 0;
if (trim($row_Recordset1['rev1Comments']) <>"")
$numComments = $numComments + 1;

if (trim($row_Recordset1['rev2Comments']) <>"") 
$numComments = $numComments + 1;
if (trim($row_Recordset1['rev3Comments']) <>"") 
$numComments = $numComments + 1;
*/

/*
if ()
{
mysql_select_db($database_con3, $con3);
$query_Recordset = "SELECT Email FROM `user` where User_Type='IRB Chair'";
$Recordset = mysql_query($query_Recordset, $con3) or die(mysql_error());
$row_Recordset = mysql_fetch_assoc($Recordset);
$totalRows_Recordset = mysql_num_rows($Recordset);
  $from="From: ospirb@txstate.edu";
  $subject="All Reviewers have reviewed IRB application: ".$appNum;
  $body = "All Reviewers have submitted comments on IRB application: ".$appNum."\r\r\nNumber of reviewers: ".$numRev."\r\nComments received: ".$numComments.".";
do
{


 $to = $row_Recordset['Email'];

//mail($to,$subject,$body,$from);


}while($row_Recordset = mysql_fetch_assoc($Recordset));

  mysql_free_result($Recordset);
 

}
*/
mysql_select_db($database_con3, $con3);
$query="select reviewNum from reviewlog where appNum = '".$appNum."'";
$record1 = mysql_query($query, $con3);
$row = mysql_fetch_assoc($record1);
$reviewnum = 1;
do{

$reviewnum = max($reviewnum, $row['reviewNum']);

}while($row = mysql_fetch_assoc($record1));

mysql_select_db($database_con3, $con3);

$query="select rev1Finished, rev2Finished, rev3Finished from reviewlog where appNum = '".$appNum."' && reviewNum = '".$reviewnum."'";

$record2 = mysql_query($query, $con3);
$row2 = mysql_fetch_assoc($record2);

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
.style44 {color: #FF0000}
-->
  </style>
  
  <script language="JavaScript">
<!--
function finish_check()
{

var finishedChecked = false;


for (i = 0; i < form1.finishReview.length; i++)
{

if (form1.finishReview[i].checked)
finishedChecked = true; 
}

if (!finishedChecked)
{

alert("Please indicate whether you have finished the review.");
return false;
}
return true;
}

-->
</script>

  
  
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
           </a>
            </p>
            </span></td>
   </tr>
          
       
        </tbody>
      </table>
      </td>
  </tr>
</tbody></table>
<table width="800" border="0" align="center" bgcolor="#ffffff">
  <tr>
    <td colspan="4" bgcolor="#000000"><div align="center">
			  <div align="center"><span class="style46">
			  <div align="center" class="style6"><span class="style2"><a href="<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a> </span><span class="style42">| </span><span class="style2"><a href="reviewer_app.php" class="irb">Evaluate Applications Assigned </a> </span><span class="style42">| </span><span class="style2"><a href="rev_listApp.php" class="irb">List All IRB Applications</a> <span class="style42">|</span> <a href="LogOut.php" class="irb">Log Out</a></span></div></td>
          </tr>
  
    <tr bgcolor="#FFFFFF">
      <td height="348" valign="top" bgcolor="#FFFFFF">
          <br>
        <p align="center"><?php echo $_SESSION['name']."__".$_SESSION['username'];?></p>
		<table width="800"><tr><td wid="100%">


<h5 align="center" class="style5">IRB APPLICATION EVALUATION</h5>
<p class="body">APPLICATION REFERENCE NUMBER: <font color = "red"><?php echo $appNum; ?></font>
    </h5><br>
	<?php
	//echo "Number of reviewers: ".$numRev."<br>";
		//echo "Number of comments: ".$numComments."<br>";
	
	if(!($row_Recordset1['Status'] == "Approved") && !($row_Recordset1['Status'] == "Application Approved - Exempt"))
{

  echo "<a href='appSummary_reviewer.php?appNum=". $appNum."'>Review Application Data</a>  |  "; ?> 
  <?php echo "<a href='statSummary_rev.php?appNum=". $appNum."'>Summary of Status,  Evaluation and Action Log</a><hr>";?>
    
  <blockquote class="style5">

  This is the <font color="#FF0000"><?php echo $reviewnum;?> </font>Round of Review.<p>
      <form name="form1" method="post" action="evaluation.php" onsubmit="return finish_check()">
        <label class="body">
        <span class="style44">*</span>Approve the Application?</label>
        <p>
         <input name="approve" id="approve" type="radio" value="Yes"
		  <?php 
		  if ($row_Recordset1['rev1ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev1Approved']) == "YES") echo "checked";
		  if ($row_Recordset1['rev2ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev2Approved']) == "YES") echo "checked";
		  		  if ($row_Recordset1['rev3ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev3Approved']) == "YES") echo "checked";
				  ?>
		  >
        Yes<br>
        <input name="approve" id="radio" type="radio" value="Approved pending changes"
		  <?php 
		  if ($row_Recordset1['rev1ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev1Approved']) == "APPROVED PENDING CHANGES") echo "checked";
		  if ($row_Recordset1['rev2ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev2Approved']) == "APPROVED PENDING CHANGES") echo "checked";
		  		  if ($row_Recordset1['rev3ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev3Approved']) == "APPROVED PENDING CHANGES") echo "checked";
				  ?>
		  > 
        Approved pending changes
<br>
          
          <input name="approve" type="radio" id="approve" value="No"
			    <?php 
		  if ($row_Recordset1['rev1ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev1Approved']) == "NO") echo "checked";
		  if ($row_Recordset1['rev2ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev2Approved']) == "NO") echo "checked";
		  		  if ($row_Recordset1['rev3ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev3Approved']) == "NO") echo "checked";
				  ?>
			  
			  >
          No</p>
        <p><span class="body"><span class="style44">*</span></span>Have you finished reviewing the application? The IRB Chair will not see your comments if you do not indicate that you have finished the review of the application. 
          Yes<input name="finishReview" type="radio" id="finishReview" value="Yes" <?php if (($row_Recordset1['rev1ID'] == $_SESSION['username']) && strtoupper($row2['rev1Finished']) =="YES") echo "checked"; 

		  elseif(($row_Recordset1['rev2ID'] == $_SESSION['username']) && strtoupper($row2['rev2Finished']) =="YES") echo "checked"; 
		  elseif(($row_Recordset1['rev3ID'] == $_SESSION['username']) && strtoupper($row2['rev3Finished']) =="YES") echo "checked"; 
		 // else echo "checked";
		  ?>>
		     &nbsp;&nbsp; No<input name="finishReview" type="radio" id="finishReview" value="No" <?php if (($row_Recordset1['rev1ID'] == $_SESSION['username']) && strtoupper($row2['rev1Finished']) =="NO") echo "checked"; 
		  if(($row_Recordset1['rev2ID'] == $_SESSION['username']) && strtoupper($row2['rev2Finished']) =="NO") echo "checked"; 
		  if(($row_Recordset1['rev3ID'] == $_SESSION['username']) && strtoupper($row2['rev3Finished']) =="NO") echo "checked"; 
		  ?>
		  >
        </p>
        <?php		/* Donot remember why these codes are here    
		  if ($row_Recordset1['rev1ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev1Approved']) == "NO") echo "rev1";
		  if ($row_Recordset1['rev2ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev2Approved']) == "NO") echo "rev2";
		  		  if ($row_Recordset1['rev3ID'] == $_SESSION['username'] && strtoupper($row_Recordset1['rev3Approved']) == "NO") echo "rev3";
				 */
				 
				  ?>
				  
			<DIV class="style47" ID="prevcomments" ><span class="body">Previous Comments:</span><br>
			 
 <?php
 $oldcomments="";
  if( trim($row_Recordset1['rev1ID']) == $_SESSION['username'] ){
 $oldcomments=$row_Recordset1['rev1Comments']; 
}
if( trim($row_Recordset1['rev2ID']) == $_SESSION['username'] )
{

$oldcomments= $row_Recordset1['rev2Comments']; 
}
  if( trim($row_Recordset1['rev3ID']) == $_SESSION['username'] ){
 
$oldcomments= $row_Recordset1['rev3Comments']; 
}

if ($oldcomments<>""){?>

<p>
<textarea name="dummy" id="dummy" cols="80" rows="8"> <?php echo $oldcomments;?></textarea>
<p>
<input name="Prevcomments" id="Prevcomments" type="hidden" value="<?php echo $oldcomments;?>">
<?php
}
else echo "None<p>";
?>
 <p><span class="body"><span class="style44">*</span>Please add comments here:</span><br>

<textarea name="comments" cols="80" rows="6" id="comments"></textarea>
</span></LABEL>
</DIV>

            <input type="hidden" name="App_Number" ID="App_Number" value="<?php echo $appNum;?>">
            <input type="hidden" name="MM_update" value="IRBForm">
            <input type="hidden" name="irbActionLog" value="<?php echo $row_Recordset1['irbActionLog']; ?>">
			
            <input type="hidden" name="rev1ID" value="<?php echo $row_Recordset1['rev1ID']; ?>">
            <input type="hidden" name="rev2ID" value="<?php echo $row_Recordset1['rev2ID']; ?>">
            <input type="hidden" name="rev3ID" value="<?php echo $row_Recordset1['rev3ID']; ?>">
<input type="hidden" name = "Status" value="<?php echo $row_Recordset1['Status'];?>">
		   <input type="hidden" name = "reviewnum" value="<?php echo $reviewnum;?>">
            <input type="hidden" name="revName" value="<?php echo $row_Recordset3['FirstName']." ".$row_Recordset3['LastName']; ?>">
              <input name="submit" type="submit" value="Submit Comments" >
              
              <br>
              <span class="body">*Please click the &quot;Submit Comments&quot; button only once.</span>
      </form>
      </blockquote>
   <p class="style5">
 
   </p>
  </p>
 </td>
</tr>
<?php
}
else
  {
  echo "This application has been approved. It is locked from any modifications. Only IRB Chair or Administrator can unlock this application for evaluation.";

  }//application locked

?><tr><td> </table></td></tr><tr><td><table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table></td></tr></td></table></td></tr></table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
mysql_free_result($record1);
mysql_free_result($record2);
//mysql_free_result($Recordset2);

mysql_free_result($Recordset3);


?>
