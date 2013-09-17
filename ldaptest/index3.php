<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>LDAP Test Result</title>
    </head>
    <body>
        <?php
        //basic sequence with LDAP is connect, bind, search, interpret search
        //result, close connection
        echo "<h3>LDAP Query Test</h3>";

        $connURL = "ldaps://matrix.txstate.edu"; //connection url
        //Parameters for binding to LDAP server. (Authentication)
        $rdn = "fprofile-adpull@matrix.txstate.edu"; //relativ distinguishd name
        $pass = "7tq876gf"; //password for rdn
        //Connecting............................................................
        echo "<b>Connecting.................................................." .
        "............................................................." .
        "......................................................</b><br />";
        $conn = ldap_connect($connURL); //connect to the LDAP server
        echo "Connect result is: <b>" . $conn . "</b><br />";
        echo "<br />";

        if ($conn) {
            //Binding...........................................................
            echo "<b>Binding for ($rdn, ...).." .
            "................................................................" .
            "..................................</b><br />";
            $bind = ldap_bind($conn, $rdn, $pass); //bind to the LDAP server
            $err = ldap_errno($conn); //retrieve error code for bind attempt
            echo "Error: <b>" . $err . " = " . ldap_err2str($err) .
            "</b><br />";
            echo "Bind result is: <b>" . $bind . "</b><br />";
            echo "<br />";

            //Querying..........................................................
            if ($bind) {
                echo "<b>Querying............................................" .
                "............................................................" .
                "............................................................" .
                "...</b><br />";
                //TxState NetID of user to query for
                $userID = $_POST["txstate_netid"];
                $dn = "ou=Txstate Users,dc=matrix,dc=txstate,dc=edu";
                $filter = "(&(sAMAccountName=$userID))";
                $attributes = array("cn", "displayname", "mail", "title",
                    "department", "telephonenumber", "givenname", "sn",
                    "physicaldeliveryofficename", "streetaddress", "l", "st",
                    "postalcode", "facsimileTelephoneNumber");
//                $search = ldap_search($conn, $dn, $filter, $attributes);
                $search = ldap_search($conn, $dn, $filter);
                if ($search) {
                    $entry = ldap_first_entry($conn, $search);
                    $attrs = ldap_get_attributes($conn, $entry);
                    $entries = ldap_get_entries($conn, $search);
                    echo $attrs["count"] . " attributes held for this entry:<p>";
                    for ($i = 0; $i < $attrs["count"]; $i++) {
                        echo "<b>$i: $attrs[$i] :</b>" . $entries[0][$attrs[$i]][0] . "<br />";
                    }
                    echo "<b>$i: $attrs[$i] :</b>" . $entries[0]["distinguishedName"][0] . "<br />";
                    echo "<b>$i: $attrs[$i] :</b>" . $entries[0]["givenName"][0] . "<br />";
                    echo "<b>$i: $attrs[$i] :</b>" . $entries[0]["countryCode"][0] . "<br />";
                    echo "<b>$i: $attrs[$i] :</b>" . $entries[0]["accountExpires"][0] . "<br />";
                    echo "<b>$i: $attrs[$i] :</b>" . $entries[0]["lastLogon"][0] . "<br />";
                    echo "<b>$i: $attrs[$i] :</b>" . $entries[0]["badPwdCount"][0] . "<br />";
                }else {
                    echo "<b>Search failed for userID: </b>" . $userID .
                    "</b><br />";
                }
            }else {
                echo "<b>Failed to bind to LDAP server</b><br />";
            }
            echo "<br />";
            echo "Closing connection...<br />";
            ldap_close($conn);
        }else {
            echo "<b>Unable to connect to LDAP server</b>";
        }
        print"<p><input type=\"button\" name=\"back\" value=\"Go Back\"
            onclick=\"history.go(-1);return true;\"></p>";
        ?>
    </body>
</html>
