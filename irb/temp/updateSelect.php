<?php require_once('../Connections/con3.php'); ?>
<?php
  mysql_select_db($database_con3, $con3);
  mysql_query("UPDATE application SET lastApprovalDate = ApprovedDate WHERE lastApprovalDate = NULL") 
  or die("Alter table Error: ".mysql_error());
echo "Updated";
mysql_close($con3);


?>
