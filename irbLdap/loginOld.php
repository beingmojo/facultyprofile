<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
if(isset($_POST['uid']) && isset($_POST['password']))
{
	$uid = trim($_POST['uid']);
	$password = trim($_POST['password']);
	$ldapserver = "matrix.txstate.edu";
	
	$ldap_domain="matrix.txstate.edu";
	$global_password="3RajukAg";
	$global_dn="dc=matrix, dc=txstate, dc=edu";
	$ldapconn = ldap_connect($ldapserver,636);
	
	if(!$ldapconn)
	{
		
		echo "Error connecting to ldap server";
		exit;
		
	}

	

	$profilepull = "fprofile-adpull";

	$ldap_dn = "fprofile-adpull@matrix.txstate.edu";
	$global_password = "3RajukAg";
	
	$bd = @ldap_bind($ldapconn, $ldap_dn, $global_password);
 	if(!$bd) {
        echo "<br>ol: bind with fprofile failed";  
		}

	$ldap_dn = $uid . "@matrix.txstate.edu"; 
	$bd = @ldap_bind($ldapconn, $ldap_dn, $password);
 	if(!$bd) {
        echo "<br>ol: bind with uid failed";  
		}

	$bd = @ldap_bind($ldapconn, "uid=fprofile-adpull,dc=matrix, dc=txstate, dc=edu", $global_password);
	if(!$bd){
	echo "<br>bind with fprofile-adpull failed";
	}
	
	$bd = @ldap_bind($ldapconn, $global_dn, $global_password);
	if(!$bd){
	echo "<br>bind with global failed";
	}
	
	$bd = @ldap_bind($ldapconn, "uid=$uid, dc=matrix, dc=txstate, dc=edu", $password);
	if(!$bd){
	echo "<br>bind with $uid failed";
	}
	
	$bd = @ldap_bind($ldapconn, "cn=Yongxia Xia, dc=matrix, dc=txstate, dc=edu", $password);
	if(!$bd){
	echo "<br>bind with cn failed";
	}
	
	
	
}



?>
<body>
<form action="login.php" method="post" name="login">
NetID: <input name="uid" type="text" /><br />
Password: <input name="password" type="password" />

<input name="submit" type="submit" value="Submit" />
</form>


</body>
</html>