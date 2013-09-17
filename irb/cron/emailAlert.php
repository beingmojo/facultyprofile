<?php 
$hostname_con = "localhost";
$database_con = "osp_irbdb";
$username_con = "ospirb";
$password_con = "ospirb080307";
$con = mysql_pconnect($hostname_con, $username_con, $password_con) or trigger_error(mysql_error(),E_USER_ERROR); 

$query = sprintf("SELECT App_Number, username, ActionFlag, ActionRequestDate FROM application");
  mysql_select_db($database_con, $con);
$check = mysql_query($query,$con) or die(mysql_error());
$info = mysql_fetch_assoc($check);
$check2 = mysql_num_rows($check);


do{
	$username=$info['username'];

	if (strtoupper($info['ActionFlag']) == "ON"){
		$actionRequestDate=$info['ActionRequestDate'];
		$timestampe=strtotime($actionRequestDate);
		$timestampe = $timestampe+7*60*60*24;	
		$alterTime = date("m/d/y",$timestampe);		
		$timeNow=date("m/d/y");
		
		if ($timeNow >= $alterTime){
			$query = sprintf("SELECT Email from user where username = '".$username."'");


			$recordset = mysql_query($query,$con) or die(mysql_error());
			$row_recordset = mysql_fetch_assoc($recordset);
			$totalrecord = mysql_num_rows($recordset);
			$emailto = $row_recordset['Email'];
			$subject="IRB Reminder";
			$body ="IRB is waiting for your response to the request sent to you on ".$actionRequestDate." regarding the IRB application you submitted. The application number is: ". $info['App_Number'];
		mail($emailto,$subject, $body,'From:ospirb@txstate.edu'); 
			mysql_free_result($recordset);	
			
		}
	}
}while($info = mysql_fetch_assoc($check));
mysql_free_result($check);
?>
