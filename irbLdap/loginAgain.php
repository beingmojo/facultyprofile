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
$rps_ldap_attribute_cn = "cn"; //ldap search attribute: common name / txstate net id
$rps_ldap_attribute_dname = "displayname"; //ldap search attribute: display name / full names
$rps_ldap_attribute_email = "mail"; //ldap search attribute: email address
$rps_ldap_attribute_title = "title"; //ldap search attribute: title
$rps_ldap_attribute_dept = "department"; //ldap search attribute: department
$rps_ldap_attribute_phone = "telephonenumber"; //ldap search attribute: telephone number
$rps_ldap_attribute_f_name = "givenname"; //ldap search attribute: given name / firstname
$rps_ldap_attribute_m_name = "midname"; //ldap search attribute: given name / firstname
$rps_ldap_attribute_l_name = "sn"; //ldap search attribute: surname / lastname
$rps_ldap_attribute_office = "physicaldeliveryofficename"; //ldap search attribute: office building and room number
$rps_ldap_attribute_street = "streetaddress"; //ldap search attribute: street address
$rps_ldap_attribute_city = "l"; //ldap search attribute: city
$rps_ldap_attribute_state = "st"; //ldap search attribute: state code
$rps_ldap_attribute_zip = "postalcode"; //ldap search attribute: postal (zip) code
$rps_ldap_attribute_fax = "facsimileTelephoneNumber";
$rps_ldap_attribute_sn = "sn";
$rps_ldap_attribute_txstatePersonAffiliation = "txstatePersonAffiliation"; //staff, faculty, etc.
//ldap search attribute: fax
//////////////////////////////////////////////////////
//String filter = "uid=" + username;
    $conn = ldap_connect($rps_ldap_conn_url); //connect to the LDAP server
    if ($conn) {
 
       $bind = @ldap_bind($conn, "fprofile-adpull@matrix.txstate.edu", "3RajukAg");
	   	if($bind) {
        echo "<br>server binding with fprofile-adpull@matrix.txstate.edu good.<br>";  
		
		$filter = $rps_ldap_filter_prefix . "$uid))";
		 $rs=ldap_search($conn, "ou=Txstate Users, dc=matrix, dc=txstate, dc=edu", $filter );
		 echo "<br>filter=".$filter;
		 if($rs){
		 echo "<br>search found.<br>";
		 
			 $entry=ldap_get_entries($conn, $rs);
			 if($entry)
			 {
				 echo "<br>found entry.<br>";//get distingusted name
				 $distName=$entry[0]["dn"];
				 
				 echo "dn = '". $distName."'";
				 
			 }
			 
			 $bd=@ldap_bind($conn, $distName, $password);
			 if($bd){
				 echo "<br>Login success";
				 
			 }
		
		 
		 
           // $search = ldap_search($conn, $rps_ldap_search_dn, $filter, $rps_ldap_attributes);
		   $search = ldap_search($conn, $rps_ldap_search_dn, $filter);
            if ($search) {
                $entries = ldap_get_entries($conn, $search);
                if ($entries) {
                    $f_name = trim($entries[0][$rps_ldap_attribute_f_name][0]);
                    $arr_name = explode(" ", $f_name, 2);
                    if (count($arr_name) <= 1) {
                        $first_name = $f_name;
                    }else {
                        $first_name = $arr_name[0];
                        $middle_name = $arr_name[1];
                    }
                 
				
				  $returnArray= array($rps_ldap_attribute_cn => $entries[0][$rps_ldap_attribute_cn][0],
                        $rps_ldap_attribute_dname => $entries[0][$rps_ldap_attribute_dname][0],
                        $rps_ldap_attribute_email => $entries[0][$rps_ldap_attribute_email][0],
                        $rps_ldap_attribute_title => $entries[0][$rps_ldap_attribute_title][0],
                        $rps_ldap_attribute_dept => $entries[0][$rps_ldap_attribute_dept][0],
                        $rps_ldap_attribute_phone => $entries[0][$rps_ldap_attribute_phone][0],
                       // $rps_ldap_attribute_f_name => $first_name,
                       // $rps_ldap_attribute_m_name => $middle_name,
                        $rps_ldap_attribute_l_name => $entries[0][$rps_ldap_attribute_l_name][0],
                        $rps_ldap_attribute_office => $entries[0][$rps_ldap_attribute_office][0],
                        $rps_ldap_attribute_street => $entries[0][$rps_ldap_attribute_street][0],
                        $rps_ldap_attribute_city => $entries[0][$rps_ldap_attribute_city][0],
                        $rps_ldap_attribute_state => $entries[0][$rps_ldap_attribute_state][0],
                        $rps_ldap_attribute_zip => $entries[0][$rps_ldap_attribute_zip][0],
                        $rps_ldap_attribute_fax => $entries[0][$rps_ldap_attribute_sn][0],
						 $rps_ldap_attribute_txstatePersonAffiliation => $entries[0][$rps_ldap_attribute_txstatePersonAffiliation][0]
											);
						echo $returnArray['cn']."<br>";
						echo $returnArray['mail']."<br>";
						echo $returnArray['displayname']."<br>";
						echo $returnArray['department']."<br>";
						echo $returnArray['sn']."<br>";
						echo $returnArray['telephonenumber']."<br>";
						echo $returnArray['txstatePersonAffiliation']."<br>";
						//echo $returnArray['memberOf']."<br>";
						//echo $returnArray['objectClass']."<br><hr>";
						
				 $search = ldap_search($conn, $rps_ldap_search_dn, $filter);
            if ($search) {
                $data = ldap_first_entry($conn, $search);
                if ($data) {
                   $attrs = ldap_get_attributes($conn, $data);
                 
					$attrsCount = $attrs['count'];
				
					
					for ($i=0; $i<$attrsCount; $i++){
					//echo $attrs[$i]."=".$entries[0]["$attrs[$i]"]."<br>";
					$value=ldap_get_values($conn, $data, $attrs[$i]);
					echo $attrs[$i]."=".$value[0]."<br>";
					}
					$value=ldap_get_values($conn, $data, "txstatePersonAffiliation");
					echo $value[0];
					$value=ldap_get_values($conn, $data, "sAMAccountName");
					echo "<br>txSate account:".$value[0];
             } 
			 } 
			 } 
			 } 
		
		@ldap_unbind($conn);
		
		
	}
}

	}
}
?>
<body><hr />
<form action="loginAgain.php" method="post" name="login">
NetID: <input name="uid" type="text" /><br />
Password: <input name="password" type="password" />

<input name="submit" type="submit" value="Submit" />
</form>


</body>
</html>