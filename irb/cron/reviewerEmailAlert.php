<?php 
$hostname_con = "localhost";
$database_con = "osp_irbdb";
$username_con = "ospirb";
$password_con = "ospirb080307";
$con = mysql_connect($hostname_con, $username_con, $password_con) or trigger_error(mysql_error(),E_USER_ERROR); 

$query = "SELECT appNum, numReviewers,reviewNum, reviewRequestingDate, rev1Finished, rev2Finished, rev3Finished from reviewlog where noticeChair <> 'Yes'";
  mysql_select_db($database_con, $con);
$result = mysql_query($query,$con);
$row_result = mysql_fetch_assoc($result);

$irbadmin = "ospirb@txstate.edu";
$irbchair = "jl30@txstate.edu";
$lastReviewNum = 1;
do{
	$appNum=$row_result['appNum'];
	$lastReviewNum=max($lastReviewNum,$row_result['reviewNum']);
	}while ($row_result = mysql_fetch_assoc($result));
	mysql_free_result($result);
	
//////////////////////////////////////////////////////////////////////////	
	$query = "SELECT appNum, numReviewers,reviewNum, reviewRequestingDate, rev1Finished, rev2Finished, rev3Finished from reviewlog where (reviewNum=".$lastReviewNum." && noticeChair <> 'Yes')";
	  mysql_select_db($database_con, $con);
$result = mysql_query($query,$con);
$row_result = mysql_fetch_assoc($result);
do{
	$appNum=$row_result['appNum'];
	$lastReviewNum=max($lastReviewNum,$row_result['reviewNum']);
	$query1 = "SELECT Status, numReviewers from application where App_Number='".$appNum."'";
  mysql_select_db($database_con, $con);
$result1 = mysql_query($query1,$con);
$row_result1 = mysql_fetch_assoc($result1);
$status = $row_result1['Status'];
$numReviewers = $row_result1['numReviewers'];
mysql_free_result($result1);
if (($status <> "Application Approved - Exempt") && ($status <> "Approved") && ($status <> "Applicant Requested Continuation")&& ($status <> "Application Discontinued")&& ($status <> "Applicant Requested Change") && ($status <> "IRB Chair Requests Revision")){

	//echo "<br><br>application number: ". $appNum."<br>";
	//echo "Status: ".$status."<br>";
	//echo "number of reviewers: ".$numReviewers."<br>";
		$actionRequestDate=$row_result['reviewRequestingDate'];
	//	echo "Requesting date: ".$actionRequestDate."<br>";
		$timestampe=strtotime($actionRequestDate);
		$timestampe = $timestampe+14*60*60*24;	
		$alterTime = date("m/d/y",$timestampe);		
		$timeNow=date("m/d/y");
		
		if ($timeNow >= $alterTime){
		///////////////////////////////////////
		if($numReviewers == 2){
		if($row_result['rev1Finished'] <>"Yes"){
			$query = "SELECT rev1ID from application where App_Number = '".$appNum."'";

			  mysql_select_db($database_con, $con);
			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev1ID= $row_recordset['rev1ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev1ID."'";
	  mysql_select_db($database_con, $con);
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$emailto = $row_recordset['Email'];			
			$subject="IRB Reminder to ". $emailto;
			$body ="The IRB Chair is waiting for you to review the application assigned to you two weeks ago. The application number is: ". $appNum. ". If you have approved the application, please ignore this message.";
			
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu');

 mail($irbadmin,$subject, $body,'From:ospirb@txstate.edu');
 mail($irbchair,$subject, $body,'From:ospirb@txstate.edu');
  mail('ys11@txstate.edu',$subject, $body,'From:ospirb@txstate.edu');
			//echo "testing: ".$emailto." <br>";
			//echo $body."<br>";
			mysql_free_result($recordset);
	}
	if($row_result['rev2Finished'] <>"Yes"){
			$query = "SELECT rev2ID from application where App_Number = '".$appNum."'";

			  mysql_select_db($database_con, $con);
			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev2ID= $row_recordset['rev2ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev2ID."'";
		  mysql_select_db($database_con, $con);
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$emailto = $row_recordset['Email'];			
			$subject="IRB Reminder to ". $emailto;
			$body ="The IRB Chair is waiting for you to review the application assigned to you two weeks ago. The application number is: ". $appNum. ". If you have approved the application, please ignore this message.";
			
			
			//echo "testing: ".$emailto." <br>";
		//	echo $body;
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu');
		
 mail($irbadmin, $subject, $body,'From:ospirb@txstate.edu');
mail($irbchair, $subject, $body,'From:ospirb@txstate.edu'); 
 mail('ys11@txstate.edu',$subject, $body,'From:ospirb@txstate.edu');
 
		mysql_free_result($recordset);
	}
	}//end if number of reviewers = 2
	////////////////////////////////////////////////////////
			if($numReviewers == 3){
			if($row_result['rev1Finished'] <>"Yes"){
			$query = "SELECT rev1ID from application where App_Number = '".$appNum."'";

			  mysql_select_db($database_con, $con);
			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev1ID= $row_recordset['rev1ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev1ID."'";
	  mysql_select_db($database_con, $con);
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
					$emailto = $row_recordset['Email'];			
					$subject="IRB Reminder to ". $emailto;
			$body ="The IRB Chair is waiting for you to review the application assigned to you two weeks ago. The application number is: ". $appNum. ". If you have approved the application, please ignore this message.";
			
			
		//	echo "testing: ".$emailto." <br>";
		//	echo $body;
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 
			
 mail($irbadmin,$subject, $body,'From:ospirb@txstate.edu');
 mail($irbchair,$subject, $body,'From:ospirb@txstate.edu');
  mail('ys11@txstate.edu',$subject, $body,'From:ospirb@txstate.edu');
	}
	if($row_result['rev2Finished'] <>"Yes"){
			$query = "SELECT rev2ID from application where App_Number = '".$appNum."'";

			  mysql_select_db($database_con, $con);
			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev2ID= $row_recordset['rev2ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev2ID."'";
	  mysql_select_db($database_con, $con);
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$emailto = $row_recordset['Email'];			
	$subject="IRB Reminder to ". $emailto;
			$body ="The IRB Chair is waiting for you to review the application assigned to you two weeks ago. The application number is: ". $appNum. ". If you have approved the application, please ignore this message.";
			
			
		//	echo "testing: ".$emailto." <br>";
		//	echo $body;
			
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 
			
 mail($irbadmin,$subject, $body,'From:ospirb@txstate.edu');
 mail($irbchair,$subject, $body,'From:ospirb@txstate.edu');
  mail('ys11@txstate.edu',$subject, $body,'From:ospirb@txstate.edu');
		mysql_free_result($recordset);
	}
		if($row_result['rev3Finished'] <>"Yes"){
			$query = "SELECT rev3ID from application where App_Number = '".$appNum."'";

			  mysql_select_db($database_con, $con);
			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$rev3ID= $row_recordset['rev3ID'];
				mysql_free_result($recordset);
			
	$query = "SELECT Email from user where username = '".$rev3ID."'";
	  mysql_select_db($database_con, $con);
	$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$emailto = $row_recordset['Email'];			
	$subject="IRB Reminder to ". $emailto;
			$body ="The IRB Chair is waiting for you to review the application assigned to you two weeks ago. The application number is: ". $appNum. ". If you have approved the application, please ignore this message.";
			
			
		//	echo "testing: ".$emailto." <br>";
			//echo $body;
			
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 

 	mail($irbadmin,$subject, $body,'From:ospirb@txstate.edu');
	 mail($irbchair,$subject, $body,'From:ospirb@txstate.edu');
	 	 mail('ys11@txstate.edu',$subject, $body,'From:ospirb@txstate.edu');
		mysql_free_result($recordset);
		}
	}//end if number of reviewers = 3
			
		
	}//if today > alert time 
	
	}
}while($row_result = mysql_fetch_assoc($result));
mysql_free_result($result);
?>
