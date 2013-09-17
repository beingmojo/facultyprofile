<?php
require_once('Connections/dbc.php');
session_start();
ini_set('display_errors', true);
function varifyUser()
{
	
	$uid = $_SESSION['username'];
	if (!get_magic_quotes_gpc()) {
		$uid = addslashes($uid);
	}
	$query = sprintf("SELECT * FROM user WHERE username = '%s' ", $uid);
//echo $query;
	$check = mysql_query($query,$con) or die(mysql_error());
	$info = mysql_fetch_assoc($check);
	$check2 = mysql_num_rows($check);
	
	$lastLogin = date("l dS \of F Y h:i:s A");
//Gives error if user dosen't exist

	if (!$check2)
	
	 {
	// now we insert it into the database
	$insert = "INSERT INTO user (User_Type, username) VALUES ('".$_SESSION['User_Type']."', '".$uid."')";
	$add_member = mysql_query($insert) or die(mysql_error());
	
	 $insertSQL = sprintf("UPDATE user SET lastLogin=%s WHERE username=%s", GetSQLValueString($lastLogin, "text"), GetSQLValueString($_SESSION['username'], "text"));

	$Result1 = mysql_query($insertSQL, $con) or die(mysql_error()); 
						
	$_SESSION['myhome']="./applicant_home.php";
		header("Location: ./applicant_home.php");
		
		exit;
	
	}
	
	else{
		
	 $insertSQL = sprintf("UPDATE user SET lastLogin=%s WHERE username=%s", GetSQLValueString($lastLogin, "text"), GetSQLValueString($_SESSION['username'], "text"));

	$Result1 = mysql_query($insertSQL, $con) or die(mysql_error()); 
						
		$_SESSION['User_Type'] =  $info['User_Type'];
		
	if (($info['User_Type'] == "IRB Staff") || ($info['User_Type'] == "IRB Chair")){
				
						//set home page
						
				$_SESSION['myhome']="./osp_irb_home.php";	
				if($_SESSION['asApp']=="Yes"){
					$_SESSION['myhome']="./applicant_home.php";
	
					}

	
				if($_POST['appNum']<>"") 
					header("Location: ./searchApp.php?appNum=".$_POST['appNum']);
				else
				header("Location: ./osp_irb_home.php");
				exit;
			}
 if ($info['User_Type'] == "Faculty" || $info['User_Type'] == "staff" || $info['User_Type'] == "Student")
	{
		$_SESSION['myhome']="./applicant_home.php";
		header("Location: ./applicant_home.php");
		
		exit;
	}
 if ($info['User_Type'] == "reviewer")
	{
		$_SESSION['myhome']="./rev_home.php";
		header("Location: ./rev_home.php");
		exit;
	}

  if ($info['User_Type'] == "IRB Support")
	{
		$_SESSION['myhome']="./osp_irb_home.php";
		
		header("Location: ./osp_irb_home.php");
		exit;
	}
	}//end else
	
	
	return $_SESSION['User_Type'];
	
	
	
}


function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}



?>


