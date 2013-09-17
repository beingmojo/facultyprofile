<?php require_once('../Connections/con3.php');
session_start();

$restrictGoTo = "../unauthorized.php";

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

$id=$_GET["ID"];
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "Select * FROM continuation where ID='".$id."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$app=$row_Recordset1['username'];

mysql_select_db($database_con3, $con3);
$query_Recordset2 = "Select FirstName, LastName, Email,Phone, Department FROM user where username='".$app."'";;
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=iso-8859-1">
  <title>Texas State University-San Marcos | IRB Online Application</title>
  <LINK href="../irbstyle.css" rel="stylesheet" type="text/css">


  <style type="text/css">
<!--
.style42 {color: #FFFFFF}
.style43 {font-size: large}
-->
  </style></head>
  <script language="javascript">
function deleteConfirm(str, app, id)
{
if (confirm('Are you sure you want to remove this file from the application?')){
dirlocation="deleteAppFile_app.php?fn="+str+"&appNum="+app+"&ID="+id;
document.location.href=dirlocation;
}
}
</script>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
  <tr><td>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" background="../tbbg.gif" >
<tbody>
   <tr background="tbbg.gif">
            <td valign="top"><p align="left" class="style6 style24"><img src="../banner2.jpg" height="160"></td>
            <td valign="middle" background="../tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard <span class="style43">O</span>nline <span class="style43">A</span>pplication </p>
           </a>
          
            </span></td>
 
  </tr>
</tbody></table> 

</td></tr><tr><td valign="top">
<table width="100%" bgcolor="#FFFFFF" border="0">

 <tr bgcolor="#000000">
    <td bgcolor="#000000" align="center" colspan="4">
       <div align="center"><a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a> <span class="style42">|</span> <a href="irb_listContinuation.php" class="irb">All IRB Continuation/Change Applications</a> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a></div></td></tr>
		<tr><td colspan="4"> 
   
      </td>
        </tr></table><tr><td>
<table width="812" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF" align="center">
  <tr><td>

  <p align="center" class="style49"><br><strong>APPLICATION FOR IRB CONTINUATION/CHANGE</strong></p>
  <p align="left" class="style47"><a href="irb_evaluationContinuation.php?ID=<?php echo $id;?>">Evaluate & Comment</a></p>
    <p><strong>Application Number:</strong> <?php echo $row_Recordset1['ID']; ?>
  <p class="style48"><hr>Section 1 </p>
  <p class="style47">&nbsp;1.&nbsp;	Original IRB Reference Number:&nbsp;&nbsp;<span class="style50">&nbsp;</span></p>
  <blockquote>
    <p class="style52"><?php echo $row_Recordset1['App_Number']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	State the grant ID number:&nbsp;&nbsp;&nbsp;&nbsp;</p>
  <blockquote>
    <p class="style52"><?php echo $row_Recordset1['GrantIDNumber']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; State the length of project period:&nbsp;</p>
  <blockquote>
    <p class="style52">	<?php echo $row_Recordset1['LengthOfProject']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Do you require a signed hard copy of the IRB's decision for your records?&nbsp;&nbsp;&nbsp;</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['IRBDecisionHardCopy']; ?></p>
  </blockquote>
  <p class="style48">Section 2 </p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp; What is the status of your study?</p>
  <blockquote>
    <p align="left" class="style47">&nbsp; <span class="style52"><?php echo $row_Recordset1['StudyStatus']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; If you chose &quot;Other&quot;, please provide an explanation: </p>
  <blockquote>
    <p class="style52"><?php echo $row_Recordset1['StudyStatusExplanation']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;2. Total number of participants <em><strong>approved</strong></em> for the study:</p>
  <blockquote>
    <p class="style51">  <?php echo $row_Recordset1['NumberOfParticipantsApproved']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;3. Number of participants <em><strong>enrolled since last IRB review (continuing or initial):</strong></em></p>
  <blockquote>
    <p class="style52"><?php echo $row_Recordset1['ParticipantsEnrolledSinceLastReview']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;4. Number of participants <em><strong>enrolled in the study to date </strong></em>: </p>
  <blockquote>
    <p class="style47"><span class="style52"><?php echo $row_Recordset1['ParticipantsEnrolledToDate']; ?></span>&nbsp;</p>
  </blockquote>
  <p class="style47">&nbsp;5. If actual total enrollment is different from the original project enrollment, provide an explanation:</p>
  <blockquote>
    <p class="style52"><?php echo $row_Recordset1['DifferentEnrollmentExplanation']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;6.&nbsp; Has your relationship with the study sponsor changed since the IRB review in any way which might require conflict of interest disclosure (e.g. stock purchases, royalty payments, patents, Board position, etc.)??</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['RelationshipChange']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;7.&nbsp; Have there been any changes in Principal Investigator, Co-Investigators or staff?</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['PIChange']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> If yes,</strong> please explain:</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['PIChangeExplanation']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;8.&nbsp; Summarize preliminary information about any results and/or trends (DO NOT LEAVE BLANK):</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['ResultsSummary']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;9.&nbsp; Describe any unanticipated problems in the conduct of the study (if none, state &quot;none&quot;):</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['UnanticpatedProblems']; ?></p>
  </blockquote>
  <p class="style47">10.&nbsp; Has the risk/benefit relationship for subjects changed from the initial expectation?</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['RiskBenefitChange']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>If yes,</strong> describe what has changed from the initial expectations:</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['RiskBenefitChangedExplanation']; ?></p>
  </blockquote>
  <p class="style47">11.&nbsp; List and Explain any other changes in the study or study period originally approved by the IRB (if none, state &quot;none&quot;):</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['ChangesInStudySinceApproval']; ?></p>
  </blockquote>
  <tr><td>  <tr><td> <hr><b>Uploaded Files </b></td></tr>
  <tr><td>  <?php
  //$path = "http://www.osp.txstate.edu/irb/appdoc/".$row_Recordset1['App_Number'];
  $path = "../appdoc/".$row_Recordset1['App_Number']."/continuation";
//$path = "../appdoc/".$row_Recordset1['App_Number']."/continuation";
//$path = "../appdoc/".$row_Recordset1['App_Number'];
//echo "path = ".$path."<br>";
$dh = @ opendir($path);
$i=1;
$k=0;
while (($file = @ readdir($dh)) != false) {
    if($file != "." && $file != "..") {
        echo "$i. <a href='$path/$file'>$file</a>  ";
		?>

		<input name='button' type='button' onClick="deleteConfirm('<?php echo $file;?>', '<?php echo $row_Recordset1['App_Number']; ?>', '<?php echo $id; ?>')" value='Delete File'><br>
	<?php
        $i++;
		$k=$k+1;
    }
}
@ closedir($dh);
if ($k==0)
echo "No Document uploaded";

?> <p>

      </td></tr>
 <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;">
 
 <?php include("../footer.php"); ?>



      </td>
    </tr>
</table>
 </td>
  </tr></table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
?>
