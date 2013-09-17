<?php require_once('Connections/con3.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

/////////////////////////////////////////////////////////////////
 $appNum = $_GET['appNum'];
 if ($_POST["fileUp"]){
 $appNum = $_POST['appNum'];
 }
  mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT username, Status, App_Number from application where App_Number='".$appNum."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

if($row_Recordset2['username'] != $_SESSION['username']) {
if (!($_SESSION['User_Type'] == "IRB Staff")) {   
 
	if (!($_SESSION['User_Type'] == "IRB Chair")) {
   
 
  header("Location: ". $restrictGoTo); 
  exit;
  }
}

  }
  /*
 
 mysql_select_db($database_con3, $con3);
$query_Recordset2 = "SELECT Status, App_Number from application where App_Number='".$appNum."'";
$Recordset2 = mysql_query($query_Recordset2, $con3) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

*/
if (!($row_Recordset2['Status'] =="IRB Admin Requests Revision")){
 
	if (!($row_Recordset2['Status'] =="IRB Chair Requests Revision"))
	{
		if (!($row_Recordset2['Status'] =="Application in Process"))
		{
		die("The application is locked. Please contact the IRB Administrator or Chair to unlock this application. <a href='javascript:history.back()'>Back</a>");
		}
		}
		}


 
 if ($_POST["fileUp"]){
$appNum=$_POST["appNum"];
}
$errmsg;
if ($_POST["fileUp"]){

if ($_FILES["file"]["error"] > 0)
  {
  //echo "Error: " . $_FILES["file"]["error"] . "<br />";
  $errmsg = "Upload file failed. Please choose a file to upload";
  }
/*
else
  {
  echo "File Uploaded: " . $_FILES["file"]["name"] . "<br />";
  echo "Type: " . $_FILES["file"]["type"] . "<br />";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  //echo "Temp File Folder Used: " . $_FILES["file"]["tmp_name"];
  echo "<br>";
  echo "Application Number: ".$appNum."<br>";
  }
*//*
if (($_FILES["file"]["size"] / 1024) > 1900)
{
	echo "Error: File size exceeded limit</br>";
	}
	
else{
*/
else{
$dir="appdoc/".$appNum;
 
//mkdir($dir); 
if (!is_dir($dir))
{
    umask("0002");
    mkdir($dir, 2775); 
	//chown($dir, "osp");
}


if (strpos($_FILES["file"]["name"], "\'") !== false) 
die("<font color='red'>Sorry, you must upload a file without an apostrophe in the file name. <a href='uploader.php?appNum=".$appNum."'>Back</a>");

//$filename= str_replace("\'", "_", $_FILES["file"]["name"]);
    
move_uploaded_file($_FILES["file"]["tmp_name"], $dir."/". $_FILES["file"]["name"]);
 // chmod($dir."/". $_FILES["file"]["name"], 2775);
 
 // move_uploaded_file($_FILES["file"]["tmp_name"], $dir."/". $filename);
  //chmod($dir."/".$filename, 664);

}


//}//file size uplode ok
}//no error
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
.style44 {
	color: #FF0000;
	font-style: italic;
}
.style45 {color: #FF0000}
-->
  </style>
  <script>
 function confirmSubmission(i)
{

if (i==0) {
	if (confirm("You have not submitted any documentation. You must at least have a synopsis. Once you submit, you will not be able to make changes to your form or your uploaded documents, and your application will be forwarded for review. Are you sure you are ready to submit?")){
	document.form2.submit();
		}
	}
if (i>0) {
if(confirm("Once you submit, you will not be able to make changes to your form or your uploaded documents, and your application will be forwarded for review. Are you sure you are ready to submit?"))
document.form2.submit();
}
return false;
}
 
  function confirmRevSubmit()
{
if(confirm("Are you sure you are ready to submit? Once you submit, you will not be able to make changes to your form or your uploaded documents, and your application will be forwarded for review.")){
document.form3.submit();
}

	return false ;
}
 
 function returnHome()
 {
 location.href="<?php echo $_SESSION['myhome'];?>";
 }
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
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff">
  <tr>
<td bgcolor="#000000"><div align="center"><a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42">|</span> 

<a class="irb" href="
<?php 
if(($_SESSION['User_Type'] == 'IRB Chair') || ($_SESSION['User_Type'] == 'IRB Staff')) 
	echo "statSummary.php"; 
else 
	echo "statSummary_app.php"; 
?>
?appNum=<?php echo $row_Recordset2['App_Number'];?>">Application Status</a> <span class="style42">|</span> <a class="irb" href="<?php if(($_SESSION['User_Type'] == 'IRB Chair') || ($_SESSION['User_Type'] == 'IRB Staff')) echo "appSummary_irb.php"; 
else echo "appSummary_applicant.php";?>
?appNum=<?php echo $row_Recordset2['App_Number'];?>">Review Application Data</a><?php 
	if (($row_Recordset2['Status'] == "Application in Process") || ($row_Recordset2['Status'] == "IRB Admin Requests Revision") || ($row_Recordset2['Status'] == "IRB Chair Requests Revision"))
	echo " <span class='style42'>|</span> <a class='irb' href='appUpdate_applicant.php?appNum=".$row_Recordset2['App_Number']."'>Update Application Form</a>"; ?>
	
 <?php 
if (($row_Recordset2['Status'] == "Application in Process") || ($row_Recordset2['Status'] == "IRB Admin Requests Revision") || ($row_Recordset2['Status'] == "IRB Chair Requests Revision"))
	echo " <span class='style42'>|</span> <a class='irb' href='uploader.php?appNum=".$row_Recordset2['App_Number']."'>Upload Documents</a>";
	
	?>

    <?php if ($row_Recordset2['Status'] == "Approved"){
	echo " <span class='style42'>|</span> <a class='irb' href='continuation/irb_continuation_change_form.php?appNum=".$rs_app['App_Number']."'>Apply for Continuation/Change</a>"; }?>
	
    <?php if ($row_Recordset2['Status'] == "Approved") echo " <span class='style42'>|</span> <a class='irb' href='certificate.php?appNum=".$row_Recordset2['App_Number']."'>Print Out Certificate</a>";?>
	  <span class="style42">|</span>  <a href="LogOut.php" class="irb">Log
        Out</a></div></td>
  </tr>
  <tr><td><div align="center">
  
      <br><strong>
      <?php echo $_SESSION['name'];?></strong></div></td>
  </tr><tr><td>
  <?php
  if ($_POST["fileUp"]){
if ($_FILES["file"]["error"] > 0)
  {
  //echo "Error: " . $_FILES["file"]["error"] . "<br />";
  echo "<font color='red'>".$errmsg.".</font>";
  }
else
  {
echo "File just uploaded: " . $_FILES["file"]["name"] . "<br />";
echo "Type: " . $_FILES["file"]["type"] . "<br />";
 echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  //echo "Temp File Folder Used: " . $_FILES["file"]["tmp_name"];
 // echo "<br>";
 // echo "Application Number: ".$appNum."<br>";
  }
 
 } 
 ?>

 <p>IRB Application Number: <?php echo $appNum; ?>
<hr>
<strong>Document(s) Uploaded for the Application</strong>
<p>
   <?php
$directory = "appdoc/".$appNum;

$i=0;
if (!is_dir($directory)){
//echo "No file uploaded.";
}
else
{
$dh = @ opendir($directory);

while (($file = @ readdir($dh)) !== false) {
    if($file != "." && $file != "..") {
        
        $i++;
		echo "$i. <a href='$directory/$file'>$file</a><br />";
    }
	
	}
	
@ closedir($dh);
}
if ($i==0) echo "None<br>";
?>
<hr>
<strong>Upload Supporting Document(s) (</strong><span class="style44">Maximum allowed file size: 2M</span><strong>)</strong>
<p>At a minimum, your supporting documentation must include a Synopsis and if applicable, a Consent Form.  
  
  In addition, other types of supporting documents include surveys or questionnaires, subject recruitment materials, approvals from other IRBs or from external sites, etc. 
  <p><br>
      <span class="style45">If your file name includes an apostrophe ( ' ), you will need to rename it before uploading the document. </span>
  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
     <p>
  <input type="hidden" name="fileUp" value="Yes" id="fileUp">
  <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
       
       <input type="file" name="file" /> 
       <input type="submit" name="Submit" value="Upload File" />
     </p>
     <p>*You will have to browse and upload one document  at a time.</p>
   </form>
 

  </label>
     <?php if ($row_Recordset2['Status'] == "Application in Process") {
	  mysql_free_result($Recordset2);
   ?>
   <hr>
   If you are not yet finished with your form or  uploading your documents but want to exit, click on the Save Application and Return Home button  below. This will allow you to return to your application later.
  	 <?php if ($i > 0){ ?> <p>If you believe that you have completed the  application form correctly and you are finished uploading all supporting  documents, click Submit Application button below.&nbsp; Once you click the Submit Application button,  you will not be able to make changes, and your application will be forwarded  for review.</p>
     <label><form method="post" action="submissionFinished.php" name="form2" id="form2">

	 <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	  <input type="hidden" name="appsub" value="Application Submitted" id="appsub">
	    <input type="submit" name="Submit2" value="Submit Application and Return Home" onclick="return confirmSubmission(<?php echo $i;?>)">
		<?php
		}?>
<input name="save" type="button" value="Save Application and Return Home" onClick="returnHome()">
   </form>
     </label>
   </p>
    <?php
	 }?>
   <?php if (($row_Recordset2['Status'] == "IRB Admin Requests Revision") || ($row_Recordset2['Status'] == "IRB Chair Requests Revision")){
   mysql_free_result($Recordset2);
   ?>
   <hr>If you believe that you have completed the revision of your application and you have completed uploading all supporting documents requested, click &quot;Submit Revision&quot; button below. Your application will now be forwarded for review. 
   <p>Please note: Should your application be deemed incompleted by the IRB, you will receive an email requesting additional information and/or documents.
   <form method="post" action="revisionFinished.php" name="form3" id="form3">
	 <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	  <input type="hidden" name="appsub" value="Revision Submitted" id="appsub">
	  <input name="save" type="button" value="Save Application Revison and Return Home" onClick="returnHome()">
     <input type="submit" name="Submit2" value="Submit Revision and Return Home" onclick="return confirmRevSubmit()"></form>
	 <?php
	 }


?>

   </td>
   <tr><td><br><br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("footer.php"); ?></td>
    </tr>
</table>
   </td></tr></table>
	
</body> 
</html>
