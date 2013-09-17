<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<?php

//upload file

$targetpath = "appdoc";
//$target= $targetpath; 

//$target = $targetpath . $_POST['App_Num'];


<?php
for($x=0;$x<3;$x++){

if ($_FILES["file"["error"][$x] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"][$x] . "<br />";
  }
else
  {
  echo "Upload: " . $_FILES["file"]["name"][$x] . "<br />";
  echo "Type: " . $_FILES["file"]["type"][$x]. "<br />";
  echo "Size: " . ($_FILES["file"]["size"][$x] / 1024) . " Kb<br />";
  //echo "Temp File Folder Used: " . $_FILES["file"].["tmp_name"];
  echo "<br>";
  }

     
      move_uploaded_file($_FILES["file"]["tmp_name"][$x], "appdoc/" . $_FILES["file"]["name"][$x]);
      echo "Stored in: " . "appdoc/" . $_FILES["file"]["name"][$x];
     
}
?> 
  	           

</body>
</html>
