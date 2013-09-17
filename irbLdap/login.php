<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
ini_set('display_errors', true);
if(isset($_POST['uid']) && isset($_POST['password']))
{
	$uid = trim($_POST['uid']);
	$password = trim($_POST['password']);
	$ldaphost = "matrix.txstate.edu";
	$ldapport = 636;
	$ldap_domain="matrix.txstate.edu";
	$global_password="3RajukAg";
$ldap_dn = "fprofile-adpull@matrix.txstate.edu";
		

	$profilepull = "fprofile-adpull";
	
$ldapconn = ldap_connect($ldaphost, $ldapport) or die("Could not connect to $ldaphost");
	$global_dn="dc=matrix, dc=txstate, dc=edu";
	
	$global_password = "*****";
	
	
	$bd = @ldap_bind($ldapconn, $global_dn, $global_password);
 	if(!$bd) {
        echo "<br>server binding failed";  
		}
		
	$bd = ldap_bind($ldapconn, $ldap_dn, $global_password);
 	if(!$bd) {
        echo "<br>ol: bind with $ldap_dn failed";  
		}

		$ldap_dn = $uid . "@matrix.txstate.edu, dc=matrix, dc=txstate, dc=edu"; 
	$bd = ldap_bind($ldapconn, $ldap_dn, $password);
 	if(!$bd) {
        echo "<br>xxx bind with $ldap_dn failed";  
		}

	$bd = ldap_bind($ldapconn, "uid=fprofile-adpull,dc=matrix, dc=txstate, dc=edu", $global_password);
	if(!$bd){
	echo "<br>bind with fprofile-adpull failed";
	}
	
	$bd = ldap_bind($ldapconn, $global_dn, $global_password);
	if(!$bd){
	echo "<br>bind with $global_dn failed";
	}
	
	$bd = ldap_bind($ldapconn, "uid=$uid, dc=matrix, dc=txstate, dc=edu", $password);
	if(!$bd){
	echo "<br>bind with $uid failed";
	}
	else echo "<br>bind with $uid success";
	
	$bd = ldap_bind($ldapconn, "cn=$uid, dc=matrix, dc=txstate, dc=edu", $password);
	if(!$bd){
	echo "<br>bind with cn=$uid failed";
	}
	$bd = ldap_bind($ldapconn, "fprofile-adpull", "3RajukAg");
	if(!$bd){
	echo "<br>bind with fprofile-adpull failed";
	}

}



?>
<body><hr />
<form action="login.php" method="post" name="login">
NetID: <input name="uid" type="text" /><br />
Password: <input name="password" type="password" />

<input name="submit" type="submit" value="Submit" />
</form>


</body>
</html>