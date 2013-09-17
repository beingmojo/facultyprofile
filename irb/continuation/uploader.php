<?php require_once('../Connections/con3.php');
session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

/////////////////////////////////////////////////////////////////
$today=date("m/d/y H:i:s");
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

 
 if ($_POST["fileUp"]){
$appNum=$_POST["appNum"];
}
$errmsg;
if ($_POST["fileUp"]){

if ($_FILES["file"]["error"] > 0)
  {

  $errmsg = "Upload file failed. Please choose a file to upload";
  }

else{
$dir="../appdoc/".$appNum."/continuation/";
 

if (!is_dir($dir))
{
    umask("0002");
    mkdir($dir, 0775); 
chmod($dir, 0775);
}


if (strpos($_FILES["file"]["name"], "\'") !== false) 
die("<font color='red'>Sorry, you must upload a file without an apostrophe in the file name. <a href='uploader.php?appNum=".$appNum."'>Back</a>");

$today=date("Ymd");
$newFileName = $today.$_FILES["file"]["name"];
    
//move_uploaded_file($_FILES["file"]["tmp_name"], $dir. $_FILES["file"]["name"]);
move_uploaded_file($_FILES["file"]["tmp_name"], $dir. $newFileName);
 chmod($dir.$newFileName, 0775);
 


}


//}//file size uplode ok
}//no error
?>


<script language="javascript">
 
 
 function returnHome()
 {
 location.href="<?php echo $_SESSION['myhome'];?>";
 }
</script>
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

</td></tr><tr><td>
<table width="800" height="300" border="0" align="center" bgcolor="#ffffff">
  <tr>
<td bgcolor="#000000"><div align="center"><a class="irb" href="<?php echo $_SESSION['myhome'];?>">My IRB Home</a> <span class="style42"></span> 


  
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
$directory = "../appdoc/".$appNum;

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
     <?php 
	  
   ?>
   <hr>


   </form>
     </label>
   </p>
    
 

   </td>
   <tr><td><br><br>
<table style="width: 100%;" border="0" cellpadding="0" cellspacing="0">
           
                <tr>
                  <td><hr></td>
                </tr>
             
    <tr>
      <td style="vertical-align: top; height: 60px;"><?php include("../footer.php"); ?></td>
    </tr>
</table>
   </td></tr></table>
	
</body> 
</html>
