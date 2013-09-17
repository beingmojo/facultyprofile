<?php require_once('../Connections/con3.php');
session_start();

$restrictGoTo = "../unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}




$id=$_GET['ID'];
mysql_select_db($database_con3, $con3);
$query_Recordset1 = "Select * FROM continuation where ID='".$id."'";
$Recordset1 = mysql_query($query_Recordset1, $con3) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
.style51 {font-size: small}
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

   <tr background="tbbg.gif">
            <td valign="top"><p align="left"><img src="../banner2.jpg" height="160"></td>
            <td valign="middle" background="../tbbg.gif"><p align="center"> <a class="tsu" href="http://www.txstate.edu">Texas State University</a></p>
              <p align="center"><a class="irbhome" href="index.php" ><span class="style43">I</span>nstitutional <span class="style43">R</span>eview <span class="style43">B</span>oard<br><span class="style43">O</span>nline <span class="style43">A</span>pplication</p>
           </a>
          
            </span></td>
  </tr>
</table> 

</td></tr><tr><td>
<table width="100%" bgcolor="#FFFFFF" border="0">

 <tr bgcolor="#000000">
    <td  align="center">
   <a href="../<?php echo $_SESSION['myhome'];?>" class="irb">My IRB Home</a></span> <span class="style42">|</span> <a href="../LogOut.php" class="irb">Log Out</a>      </td></tr></table>
		<tr><td> 
     
      <p align="center"><br><span class="body"><?php echo $_SESSION['name'];?></span></p></td>
        </tr>
       
    <tr>
      <td valign="top"> 
  <p align="center"><span class="style49"><strong><br>
    IRB CONTINUATION/CHANGE APPLICATION</strong></span></p>
	<p align="left" class="style47"><a href="irb_status_summary_app.php?ID=<?php echo $row_Recordset1['ID']; ?>">Application Status</a></p> <p><strong>Application Number:</strong> <?php echo $row_Recordset1['ID']; ?>
    
  <hr>
  <p class="style48"><strong>Section 1 </strong></p>
  <p class="style47">&nbsp;1.&nbsp;	Original IRB Reference Number:&nbsp;&nbsp;<span class="style50">&nbsp;</span></p>
  <blockquote>
    <p class="style47"><?php echo $row_Recordset1['App_Number']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	State the grant ID number:&nbsp;&nbsp;&nbsp;&nbsp;</p>
  <blockquote>
    <p class="style47"><?php echo $row_Recordset1['GrantIDNumber']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; State the length of project period:&nbsp;</p>
  <blockquote>
    <p class="style47"><?php echo $row_Recordset1['LengthOfProject']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Do you require a signed hard copy of the IRB's decision for your records?&nbsp;&nbsp;&nbsp;</p>
  <blockquote>
    <p class="style51"><?php echo $row_Recordset1['IRBDecisionHardCopy']; ?></p>
  </blockquote>
  <p class="style47"><span class="style48"><strong>Section 2 </strong></span></p>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp; What is the status of your study?</p>
  <blockquote>
    <p align="left" class="style47">&nbsp; <?php echo $row_Recordset1['StudyStatus']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; If you chose &quot;Other&quot;, please provide an explanation: </p>
  <blockquote>
    <p class="style47"><?php echo $row_Recordset1['StudyStatusExplanation']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;2. Total number of participants <em><strong>approved</strong></em> for the study:</p>
  <blockquote>
    <p class="style51">  <?php echo $row_Recordset1['NumberOfParticipantsApproved']; ?></p>
  </blockquote>
  <p class="style47">&nbsp;3. Number of participants <em><strong>enrolled since last IRB review (continuing or initial):</strong></em></p>
  <blockquote>
    <p class="style47"><?php echo $row_Recordset1['ParticipantsEnrolledSinceLastReview']; ?></span></p>
  </blockquote>
  <p class="style47">&nbsp;4. Number of participants <em><strong>enrolled in the study to date </strong></em>: </p>
  <blockquote>
    <p class="style47"><?php echo $row_Recordset1['ParticipantsEnrolledToDate']; ?></span>&nbsp;</p>
  </blockquote>
  <p class="style47">&nbsp;5. If actual total enrollment is different from the original project enrollment, provide an explanation:</p>
  <blockquote>
    <p class="style47"><?php echo $row_Recordset1['DifferentEnrollmentExplanation']; ?></span></p>
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
  <p class="style47"><strong>
  </strong>  </p> </td>
  </tr><tr><td>  <tr><td> <hr><b>Uploaded Files</b> </td></tr>
  <tr><td>  <?php
$path = "../appdoc/".$row_Recordset1['App_Number']."/continuation";
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

?><hr><b>Upload files</b>
                 <form action="uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
     <p>
  <input type="hidden" name="fileUp" value="Yes" id="fileUp">
  <input type="hidden" name="appNum" value="<?php echo $row_Recordset1['App_Number']; ?>" id="appNum">

       <input type="file" name="file" />
       <input type="submit" name="Submit" value="Upload File" />
     </p>
     <p>*You will have to browse and upload one document  at a time.</p>
   </form>

 <table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table></table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
