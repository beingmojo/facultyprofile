<html><head><title></title></head><body>

<?php


session_start();

$restrictGoTo = "unauthorized.php";

if (!isset($_SESSION['username'])){   
 
  header("Location: ". $restrictGoTo); 
  exit;
}

/////////////////////////////////////////////////////////////////

$appNum=$_POST["appNum"];

if ($_POST["fileUp"] == "yes"){
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  {
  echo "File Uploaded: " . $_FILES["file"]["name"] . "<br />";
  echo "Type: " . $_FILES["file"]["type"] . "<br />";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  //echo "Temp File Folder Used: " . $_FILES["file"]["tmp_name"];
  echo "<br>";
  }

mkdir("appdoc/".$appNum);

     
  move_uploaded_file($_FILES["file"]["tmp_name"], "appdoc/" .$appNum."/". $_FILES["file"]["name"]);
     // echo "Stored as: " . "appdoc/" . $_FILES["file"]["name"];
     
	  echo "<a href='applicant_home.php'>Back to Application Home</a><br>";
}
?>
   <form action="uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
<input type="hidden" name="fileUp" value="yes" id="fileUp">
<input type="hidden" name="appNum" value="<?php $appNum ?>" id="appNum">
  <label>More File to Upload:<br> 
  <input type="file" name="file" /> 
  </label>
  <p><input type="submit" name="Submit" value="Submit" /></form>
   </p>
   <p>If you have finished your application submission, click the &quot;Application Submission Finished&quot; button. 
     <label><form action="applicationFinished.php">
     <input type="submit" name="Submit2" value="Application Submission Finished">
     </label>
   </p>
   </form>
	
  </body> 
</html>