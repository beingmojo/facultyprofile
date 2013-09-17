<?php 
$hostname_con = "localhost";
$database_con = "osp_irbdb";
$username_con = "ospirb";
$password_con = "ospirb080307";
$con = mysql_pconnect($hostname_con, $username_con, $password_con) or trigger_error(mysql_error(),E_USER_ERROR); 
// $row_Recordset1['Status'] == "Approved"
$query = sprintf("SELECT App_Number,username,lastApprovalDate,ApprovedDate,numContinued,Status from application where Status ='APPROVED'");
  mysql_select_db($database_con, $con);
$check = mysql_query($query,$con) or die(mysql_error());
$info = mysql_fetch_assoc($check);
$check2 = mysql_num_rows($check);
//echo $info['App_Number']."<br>";

do{
	$username=$info['username'];

//	if (strtoupper($info['Status']) == "APPROVED"){
if (($info['numContinued']) !=2){
		if($info['lastApprovalDate']!="")
			$actionRequestDate=$info['lastApprovalDate'];
		else	
			$actionRequestDate=$info['ApprovedDate'];
			
			//echo "Again: ".$info['App_Number']."<br>";
			$exprationDate=date("m/d/y", strtotime($actionRequestDate) + 365*60*60*24);
		
		$timestampe=strtotime($actionRequestDate);
		//test
		$timestampe = $timestampe+344*60*60*24;
		
		//$timestampe = $timestampe+344*60*60*24;	
		$alterTime = date("m/d/y",$timestampe);	
		//$alterTime2 = date("m/d/y",	$timestampe + 358*60*60*24);
		
		//test
		$alterTime2 = date("m/d/y",	strtotime($actionRequestDate) + 358*60*60*24);
		
		$timeNow=date("m/d/y");
		
		//if ($timeNow >= $alterTime){
		if (($timeNow >= $alterTime) && ($timeNow <=$alterTime2)){
			$query = sprintf("SELECT Email from user where username = '".$username."'");

			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$emailto = $row_recordset['Email'];
		//	echo $emailto." ".$username."<br>";
			mysql_free_result($recordset);
		//echo "Time to alert";
		//echo "Approval date: ".$actionRequestDate. "   Expiration date: ". $exprationDate."; Alert time 1: ".$alterTime. "Alert time 2: ".$alterTime2."<br>";
			$query = sprintf("SELECT Email from user where username = '".$username."'");


			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$emailto = $row_recordset['Email'];
			$subject="IMPORTANT! IRB Continuation Application Reminder";
		
						
			$body ="Your IRB application is going to be expired. The application number is: ". $info['App_Number']. ". If you need to request for continuation, please log into the IRB Online Application Management System at: http://www.osp.txstate.edu/irb/. You will not be able to apply for continuation after ".$exprationDate.". If you have already submitted an application for continuation or if the project for you sought IRB approval is already over, you may disregard this notice. \r\r\n However, if your project is continuing, you will need to request a continuation WELL IN ADVANCE of the expiration date so that the project can be reviewed and approved for continuation.  If your continuation has not been approved by the expiration date, you will have to submit a new IRB application.";	
			mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 
			mail("ys11@txstate.edu", $subject, $body,'From:ospirb@txstate.edu');
			
			mysql_free_result($recordset);	
			
			}
			
				
	}
	
}while($info = mysql_fetch_assoc($check));
mysql_free_result($check);
?>
