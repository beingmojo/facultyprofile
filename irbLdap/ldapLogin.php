<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IRB Online Application</title>
</head>
<?php
session_start();
//ini_set('display_errors', true);
//require_once('Connections/dbc.php');
include 'varifyUser.php';
if(isset($_POST['uid']) && isset($_POST['password']))
{
	$uid = trim($_POST['uid']);
	$password = trim($_POST['password']);
	$ldaphost = "matrix.txstate.edu";
	$rps_ldap_conn_url = "ldaps://matrix.txstate.edu";
	$ldapport = 636;
	$ldap_domain="matrix.txstate.edu";
	$global_password="3RajukAg";
	//////////////////////
	$rps_ldap_search_dn = "ou=Txstate Users,dc=matrix,dc=txstate,dc=edu"; //distinguished name for ldap search 
$rps_ldap_filter_prefix = "(&(objectCategory=person)(sAMAccountName="; //.$uid."))"; //ldap search filter
$rps_ldap_attributes = array("cn", "displayname", "mail", "title",
    "department", "telephonenumber", "givenname", "sn",
    "physicaldeliveryofficename", "streetaddress", "l", "st",
    "postalcode", "facsimileTelephoneNumber", "sAMAccountName", "txstatePersonAffiliation"); //ldap search attributes

    $conn = ldap_connect($rps_ldap_conn_url) or die("Could not connect to $ldaphost"); //connect to the LDAP server
    if ($conn) {
 
       $bind = @ldap_bind($conn, "fprofile-adpull@matrix.txstate.edu", "7tq876gf");
	   	if($bind) {
        //echo "<br>server binding with fprofile-adpull@matrix.txstate.edu good.<br>";  
		
		$filter = $rps_ldap_filter_prefix . "$uid))";
		 $rs=ldap_search($conn, "ou=Txstate Users, dc=matrix, dc=txstate, dc=edu", $filter );
		 //echo "<br>filter=".$filter;
		 if($rs){
			 
			 $entry=ldap_get_entries($conn, $rs);
			 if($entry)
			 {
			
				 $distName=$entry[0]["dn"];
						 
			 }
			 
			 $bd=@ldap_bind($conn, $distName, $password);
			 if($bd)
			 {
				 echo "<br>Logged in";
				 
			 }		 
						
				 $search = ldap_search($conn, $rps_ldap_search_dn, $filter, $rps_ldap_attributes);
            if ($search) 
			{
                $data = ldap_first_entry($conn, $search);
                if ($data) 
				{
                   /*
				   $attrs = ldap_get_attributes($conn, $data);
                 
					$attrsCount = $attrs['count'];
									
					for ($i=0; $i<$attrsCount; $i++)
					{
					//echo $attrs[$i]."=".$entries[0]["$attrs[$i]"]."<br>";
					$value=ldap_get_values($conn, $data, $attrs[$i]);
					echo $attrs[$i]."=".$value[0]."<br>";
					}
					*/
					$userType=ldap_get_values($conn, $data, "txstatePersonAffiliation");
					$_SESSION['User_Type'] = $userType[0];
					$email=ldap_get_values($conn, $data, "mail");
					$_SESSION['Email'] = $email[0];
					$uid=ldap_get_values($conn, $data, "sAMAccountName");
					$_SESSION['username'] = $uid[0];
					$displayname=ldap_get_values($conn, $data, "displayname");
					$_SESSION['name'] = $displayname[0];
					$department = ldap_get_values($conn, $data, "department");
					$_SESSION['department'] = $department[0];
					$lastName=ldap_get_values($conn, $data, "sn");
					$_SESSION['lastName']=$lastName[0];
					$givenName = ldap_get_values($conn, $data, "givenname");
					$_SESSION['firstName']=$givenName[0];
					echo "<br>Username/User ID: ".$_SESSION['username']."<br>";
					echo "User Type: ".$_SESSION['User_Type']."<br>";
					echo "Full Name: ".$_SESSION['name']."<br>";
					echo "Last Name: ".$_SESSION['lastName']."<br>";
					echo "Department/Office: ".$_SESSION['department']."<br>";
					if($_POST['asApp']=="Yes")
					$_SESSION['asApp']=$_POST['asApp'];
					$userIs = varifyUser();
                                        echo $userIs."<br>";
				/*
					if (!varifyUser()){
						die("Error login, please contact IRB Administrator");
				
						}
						
					*/
					}//if date
						
			 		} //end if search
			 } //end if rs
			@ldap_unbind($conn);
		}//if bind
		else {

                 echo "Binding failed";

                }
	}// if conn
    
}// if post
?>
<body><hr />
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="login">
  <p>NetID:
  <input name="uid" type="text" /><br />
    Password: <input name="password" type="password" />
  </p>
  <p>For IRB Chairs and Administrator, please check the box if you want to login as <br />
an applicant to see your own application(s):<br />
<input name="asApp" type="checkbox" id="asApp" value="Yes" /></p>
  <input name="appNum" type="hidden" value="<?php echo $_GET['appNum'];?>" />
   <p> <input name="submit" type="submit" value="Submit" />
  </p>
</form>


</body>
</html>