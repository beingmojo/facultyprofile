<?php
$_ldap_login_dn = "uid=oouidoo, dc=matrix, dc=txstate, dc=edu";
$ldaphost="";
$ldapport="";
$ldapserver="";
$uid="";
$ldapconn=ldap_connect($ldaphost, $ldapport) or die("could not connect to $ldaphost");

$ldapuname=$uid."@".$ldapserver;
$ldappass="3RajukAg";
$ldapdn="dc=matric, dc=txstate, dc=edu";
$ldapsearchdn="cn=People, dc=matrix, dc=txstate, dc=edu";

$ldapbind=ldap_bind($ldapconn, $ldapdn, $ldappass) or die("Could not bind to server. Error is ".ladp_error($ldapconn));

$justthese = array("cn, sn, uid, department, telephoneNumber, ou");

function ldapLogin($ldapcon, $ldapuname, $ldappass)
{
	
include_once("include/session.inc");
include_once("include/functions.inc");

PageTop();
LocBar("Financial Department -> Login");

if( isset($_POST['login']) && isset($_POST['password']) )
{
    //LDAP stuff here.
    $username = trim($_POST['login']);
    $password = trim($_POST['password']);

    TabTop("Authenticating...");
    $ds = ldap_connect(_LDAP_SERVER_);
    
    //Can't connect to LDAP.
    if( !ds )
    {
        echo "Error in contacting the LDAP server -- contact ";
        echo "technical services!  (Debug 1)";
        TabBot();
        exit;
    }
    
    //Connection made -- bind anonymously and get dn for username.
    $bind = @ldap_bind($ds);
    
    //Check to make sure we're bound.
    if( !bind )
    {
        echo "Anonymous bind to LDAP FAILED.  Contact Tech Services! (Debug 2)";
        TabBot();
        exit;
    }
    
    $search = ldap_search($ds, "dc=corp,dc=sample,dc=com", "uid=$username");
    
    //Make sure only ONE result was returned -- if not, they might've thrown a * into the username.  Bad user!
    if( ldap_count_entries($ds,$search) != 1 )
    {
        echo "Error processing username -- please try to login again. (Debug 3)";
        redirect(_WEBROOT_ . "/login.php");
        TabBot();
        exit;
    }
    
    $info = ldap_get_entries($ds, $search);
    
    //Now, try to rebind with their full dn and password.
    $bind = @ldap_bind($ds, $info[0][dn], $password);
    if( !$bind || !isset($bind))
    {
        echo "Login failed -- please try again. (Debug 4)";
        redirect(_WEBROOT_ . "/login.php");
        TabBot();
        exit;
    }
    
    //Now verify the previous search using their credentials.
    $search = ldap_search($ds, "dc=corp,dc=sample,dc=com", "uid=$username");
        
    $info = ldap_get_entries($ds, $search);
    if( $username == $info[0][uid][0] )
    {
        echo "Authenticated.";
        TabBot();
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $info[0][cn][0];
        redirect(_WEBROOT_ . "/index.php");
        exit;
    }
    else
    {
        echo "Login failed -- please try again.";
        redirect(_WEBROOT_ . "/login.php");
        TabBot();
        exit;
    }
    ldap_close($ds);
    exit;
}




}


function ldapSearch($ldapconn, $ldapuname, $ldappass, $sr)
{

$ldapbind=ldap_bind($ldapconn, $ldapdn, $ldappass) or die("Could not bind to server. Error is ".ladp_error($ldapconn));

$justthese = array("cn", "sn", "uid", "department", "telephoneNumber", "ou", "mail");
$filter="(uid=*)";


$sr=ldap_search($ldapconn, $filter, $justthese);

$countEntries = ldap_count_entries($ldapconn,$sr);
$info = ldap_get_entries($ldapconn, $sr);
for ($i=0; $i<$info["count"]; $i++)
	{
	
	echo "dn: ".$info[$i]["dn"]."<br>";
	for($j=0; $j<$info[$i]["count"]; $j++)
	echo $info[$i][$info[$i][$j]][0]."<br>";
	
	}
}
?>