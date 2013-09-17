<?php require_once('Connections/con3.php'); ?>
<?php
/*
 mysql_select_db($database_con3, $con3);
$query = "select numReviewers, ReviewDate, rev1ID, rev2ID, rev3ID from application where App_Number='".$_GET['appNum']."'";
   //$query = "select numReviewers, ReviewDate, rev1ID, rev2ID, rev3ID from application";
  //$result = mysql_query($query, $con3);
  $row = mysql_fetch_assoc($result);
 $numrows=mysql_num_rows($result);
 echo "Number of Reviewers: ".$row['numReviewers']."<br>";
 echo "Reviewer Assignment/Review Requesting Date: ".$row['ReviewDate']."<br>";
 if(trim($row['rev1ID'])==""){}
  else
 echo "Reviewer 1 ID: ".$row['rev1ID']."<br>";
  
 if(trim($row['rev2ID'])==""){}
  else
  echo "Reviewer 2 ID: ".$row['rev2ID']."<br>";
  
  if(trim($row['rev3ID']) ==""){}
  else
  echo "Reviewer 3 ID: ".$row['rev3ID']."<br>";
  
  if ((trim($row['rev1ID'])=="")&&(trim($row['rev2ID'])=="")&&(trim($row['rev3ID'])==""))
 echo "No reviewers assigned."."<br>";
  mysql_free_result($result);
  */
  /////////////////////////////////
  mysql_select_db($database_con3, $con3);
 //$query = "select * from reviewlog where appNum='".$_GET['appNum']."' order by reviewNum";
 $query = "select * from reviewlog order by appNum";
  $result = mysql_query($query, $con3);
  $row = mysql_fetch_assoc($result);
  $numrows=mysql_num_rows($result);
 // echo $numrows."<br>";
	  echo "<table border = '1'><tr><td>App_Num</td><td>rev1Finished</td><td>rev2Finished</td><td>rev3Finished</td><td>rev1Approved</td><td>rev2Approved</td><td>rev3Approved</td><td>Review Number</td><td>noticeChair</td><td>ReviewRequestingDate</td></tr>";
  do{
  
  echo "<tr><td>&nbsp;".$row['appNum']."<td>&nbsp;".$row['rev1Finished']."</td><td>&nbsp;".$row['rev2Finished']."</td><td>&nbsp;".$row['rev3Finished']."</td><td>&nbsp;".$row['rev1Approved']."</td><td>&nbsp;".$row['rev2Approved']."</td><td>&nbsp;".$row['rev3Approved']."</td><td>&nbsp;".$row['reviewNum']."</td><td>&nbsp;".$row['noticeChair']."</td><td>&nbsp;".$row['reviewRequestingDate']."</td></tr>";
  
  
  }while ($row = mysql_fetch_assoc($result));
echo "</table>";
mysql_free_result($result);
mysql_close($con3);


?>
