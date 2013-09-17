<?php 
$hostname_con = "localhost";
$database_con = "osp_irbdb";
$username_con = "ospirb";
$password_con = "ospirb080307";
$con = mysql_connect($hostname_con, $username_con, $password_con) or trigger_error(mysql_error(),E_USER_ERROR); 

$query = "SELECT appNum, numReviewers, reviewRequestingDate, rev1Finished, rev2Finished, rev3Finished from reviewlog where noticeChair <> 'Yes'";
  mysql_select_db($database_con, $con);
$result = mysql_query($query,$con);
$row_result = mysql_fetch_assoc($result);



do{
	$appNum=$row_result['appNum'];

		$actionRequestDate=$row_result['reviewRequestingDate'];
		$timestampe=strtotime($actionRequestDate);
		$timestampe = $timestampe+7*60*60*24;	
		$alterTime = date("m/d/y",$timestampe);		
		$timeNow=date("m/d/y");
		
		if ($timeNow >= $alterTime){
		///////////////////////////////////////
		if($row_result['numReviewers'] == 2){
		if($row_result['rev1Finished'] <>"Yes"){
			$query = "SELECT rev1ID from application where App_Number = '".$appNum."'";


			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev1ID= $row_recordset['rev1ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev1ID."'";
	
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
						
			$subject="IRB Reminder";
			$body ="IRB is waiting for you to review the application assigned to you. The application number is: ". $appNum;
			$emailto = $row_recordset['Email'];
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 
			mysql_free_result($recordset);
	}
	if($row_result['rev2Finished'] <>"Yes"){
			$query = "SELECT rev2ID from application where App_Number = '".$appNum."'";


			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev2ID= $row_recordset['rev2ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev2ID."'";
	
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
						
			$subject="IRB Reminder";
			$body ="IRB is waiting for you to review the application assigned to you. The application number is: ". $appNum;
			$emailto = $row_recordset['Email'];
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 
		mysql_free_result($recordset);
	}
	}//end if number of reviewers = 2
	////////////////////////////////////////////////////////
			if($row_result['numReviewers'] == 3){
			if($row_result['rev1Finished'] <>"Yes"){
			$query = "SELECT rev1ID from application where App_Number = '".$appNum."'";


			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev1ID= $row_recordset['rev1ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev1ID."'";
	
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
						
			$subject="IRB Reminder";
			$body ="IRB is waiting for you to review the application assigned to you. The application number is: ". $appNum;
			$emailto = $row_recordset['Email'];
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 
	}
	if($row_result['rev2Finished'] <>"Yes"){
			$query = "SELECT rev2ID from application where App_Number = '".$appNum."'";


			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev2ID= $row_recordset['rev2ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev2ID."'";
	
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
						
			$subject="IRB Reminder";
			$body ="IRB is waiting for you to review the application assigned to you. The application number is: ". $appNum;
			$emailto = $row_recordset['Email'];
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 
		mysql_free_result($recordset);
	}
		if($row_result['rev3Finished'] <>"Yes"){
			$query = "SELECT rev3ID from application where App_Number = '".$appNum."'";


			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev3ID= $row_recordset['rev3ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev3ID."'";
	
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
						
			$subject="IRB Reminder";
			$body ="IRB is waiting for you to review the application assigned to you. The application number is: ". $appNum;
			$emailto = $row_recordset['Email'];
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 
		mysql_free_result($recordset);
		}
	}//end if number of reviewers = 3
			
		
	}//if today > alert time 
}while($row_result = mysql_fetch_assoc($result));
mysql_free_result($result);
?>
