<?php require_once('Connections/con3.php');

if ($_POST["fileUp"]){

if ($_FILES["file"]["error"] > 0)
  {

  $errmsg = "Upload file failed. Please choose a file to upload";
  }

else{
$dir="appdoc/test";
if (!is_dir($dir)) 
{ 
mkdir($dir); 
} 


     
move_uploaded_file($_FILES["file"]["tmp_name"], $dir."/". $_FILES["file"]["name"]);
     // echo "Stored as: " . "appdoc/" . $_FILES["file"]["name"];
     
	//  echo "<a href='applicant_home.php'>Back to Application Home</a><br>";
}

?>

<hr>
<strong>Upload Supporting Document(s) (</strong><span class="style44">Maximum allowed file size: 2M</span><strong>)</strong>
<p>At a minimum, your supporting documentation must include a Synopsis and if applicable, a Consent Form.  
  
  In addition, other types of supporting documents include surveys or questionnaires, subject recruitment materials, approvals from other IRBs or from external sites, etc. 
<form action="uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
     <p>
  <input type="hidden" name="fileUp" value="Yes" id="fileUp">
  <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
       
       <input type="file" name="file" /> 
       <input type="submit" name="Submit" value="Upload File" />
     </p>
     <p>*You will have to browse and upload one document  at a time.</p>
   </form>
 

  </label>

   <form method="post" action="revisionFinished.php" name="form3" id="form3">
	 <input type="hidden" name="appNum" value="<?php echo $appNum; ?>" id="appNum">
	  <input type="hidden" name="appsub" value="Revision Submitted" id="appsub">
	  <input name="save" type="button" value="Save Application Revison and Return Home" onClick="returnHome()">
     <input type="submit" name="Submit2" value="Submit Revision and Return Home" onclick="return confirmRevSubmit()"></form>
	 <?php
	

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
