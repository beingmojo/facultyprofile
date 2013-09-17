<?php require_once('../Connections/con3.php'); ?>
<?php
  mysql_select_db($database_con3, $con3);
  mysql_query("alter table application change ActionRequestDate ActionRequestDate varchar(25),
change ReceivedDate ReceivedDate varchar(25), 
change RevisionRequestDate RevisionRequestDate varchar(25), 
change ApprovedDate ApprovedDate varchar(25),
change RevisionDate RevisionDate varchar(25), 
change ReviewDate ReviewDate varchar(25), 
change rev1ApprovedDate rev1ApprovedDate varchar(25),
change rev2ApprovedDate rev2ApprovedDate varchar(25),
change rev3ApprovedDate rev3ApprovedDate varchar(25),
change submissionFinishedDate submissionFinishedDate varchar(25),
change irbApprovedDate irbApprovedDate varchar(25),
change ChairReviewDate ChairReviewDate varchar(25),
change requestHSPActionDate requestHSPActionDate varchar(25)") or die("Alter table Error: ".mysql_error());
echo "application table altered";
mysql_close($con3);


?>
