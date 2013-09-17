<?php

// should be removed, here only for pretty output

error_reporting(0);

// if active directory field does not exist for user then output 'Field does not exist for this user' else output data

function check_isset($attribute)
{
        if (!isset($attribute))
        {
                return 'Field does not exist for this user';
        }
        else
        {
                return $attribute;
        }
}

// using ldap bind
$rdn = "fprofile-adpull@matrix.txstate.edu";
$pass = "7tq876gf";

// connect to ldap server
$conn = ldap_connect('ldaps://matrix.txstate.edu', 636);

if ($conn)
{
    // binding to ldap server
    $bind = ldap_bind($conn, $rdn, $pass);

    // verify binding
    if ($bind)
    {
        $username = "YS11";
        $dn = "OU=Txstate Users,DC=matrix,DC=txstate,DC=edu";
        $filter = "(&(objectCategory=person)(sAMAccountName=$username))";
        $attributes = array("cn", "displayname", "mail", "title", "department", "telephonenumber", "givenname", "sn", "physicaldeliveryofficename", "streetaddress", "l", "st", "postalcode", "facsimileTelephoneNumber");
        $search = ldap_search($conn, $dn, $filter, $attributes);

        if ($search)
        {
                $entries = ldap_get_entries($conn, $search);

                echo "cn: " . check_isset($entries[0]['cn'][0]) . "\n";
                echo "displayname: " . check_isset($entries[0]['displayname'][0]) . "\n";
                echo "mail: " . check_isset($entries[0]['mail'][0]) . "\n";
                echo "title: " . check_isset($entries[0]['title'][0]) . "\n";
                echo "department: " . check_isset($entries[0]['department'][0]) . "\n";
                echo "telephonenumber: " . check_isset($entries[0]['telephonenumber'][0]) . "\n";
                echo "givenname: " . check_isset($entries[0]['givenname'][0]) . "\n";
                echo "sn: " . check_isset($entries[0]['sn'][0]) . "\n";
                echo "physicaldeliveryofficename: " . check_isset($entries[0]['physicaldeliveryofficename'][0]) . "\n";
                echo "streetaddress: " . check_isset($entries[0]['streetaddress'][0]) . "\n";
                echo "l: " . check_isset($entries[0]['l'][0]) . "\n";
                echo "st: " . check_isset($entries[0]['st'][0]) . "\n";
                echo "postalcode: " . check_isset($entries[0]['postalcode'][0]) . "\n";
                echo "facsimileTelephoneNumber: " . check_isset($entries[0]['facsimileTelephoneNumber'][0]) . "\n";
        }
        else
        {
                echo "LDAP search failed";
        }

    }
    else
    {
        echo "LDAP bind failed";
    }
}
else
{
        echo "LDAP conn failed";
}

?>