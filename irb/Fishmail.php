<?php
$add = $_GET['add'];
$subject="Fish Habitat Survey Login";
$username=$_GET['username'];
$pass=$_GET['password'];

$body = "Do not reply.\r This is your login information for the Texas Fish Habitat Survey website:\rUsername: ".$username."\rPassword: ".$pass;
	mail($add,$subject,$body,$from);


  header("Location: ". "http://rsi-db.its.txstate.edu/fishsurvey/"); 
  exit;

?>