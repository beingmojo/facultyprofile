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
//                $userID = $_POST["txstate_netid"];
                $userID = "mb29";
                $dn = "ou=Txstate Users,dc=matrix,dc=txstate,dc=edu";
                $filter = "(&(objectCategory=person)(sAMAccountName=$userID))";
                $attributes = array("cn", "displayname", "mail", "title",
                    "department", "telephonenumber", "givenname", "sn",
                    "physicaldeliveryofficename", "streetaddress", "l", "st",
                    "postalcode", "facsimileTelephoneNumber", "school");
                $search = ldap_search($conn, $dn, $filter, $attributes);
                if ($search) {
                    $entries = ldap_get_entries($conn, $search);
                    //print out the particular entries
                    //undefined indexes will result if the particular user does
                    //not have one of the fields below
                    echo "<b>cn: </b>" . $entries[0]['cn'][0] . "<br />";
                    echo "<b>displayname: </b>" .
                    $entries[0]['displayname'][0] . "<br />";
                    echo "<b>mail: </b>" . $entries[0]['mail'][0] . "<br />";
                    echo "<b>title: </b>" . $entries[0]['title'][0] . "<br />";
                    echo "<b>department: </b>" . $entries[0]['department'][0] .
                    "<br />";
                    echo "<b>telephone number: </b>" .
                    $entries[0]['telephonenumber'][0] . "<br />";
                    echo "<b>givenname: </b>" . $entries[0]['givenname'][0] . "<br />";
                    echo "<b>...: </b>" . $entries[0]['...'][0] . "<br />";
                    echo "<b>sn: </b>" . $entries[0]['sn'][0] . "<br />";
                    echo "<b>physicaldeliveryofficename: </b>" . $entries[0]['physicaldeliveryofficename'][0] . "<br />";
                    echo "<b>streetaddress: </b>" . $entries[0]['streetaddress'][0] . "<br />";
                    echo "<b>l: </b>" . $entries[0]['l'][0] . "<br />";
                    echo "<b>st: </b>" . $entries[0]['st'][0] . "<br />";
                    echo "<b>postalcode: </b>" . $entries[0]['postalcode'][0] . "<br />";
                    echo "<b>facsimileTelephoneNumber: </b>" . $entries[0]['facsimileTelephoneNumber'][0] . "<br />";
                    echo "<b>college: </b>" . $entries[0]['school'][0] . "<br />";
                } else {
                    echo "<b>Search failed for userID: </b>" . $userID .
                    "</b><br />";
                }
            } else {
                echo "<b>Failed to bind to LDAP server</b><br />";
            }
            echo "<br />";
            echo "Closing connection...<br />";
            ldap_close($conn);
        } else {
            echo "<b>Unable to connect to LDAP server</b>";
        }
        print"<p><input type=\"button\" name=\"back\" value=\"Go Back\"
            onclick=\"history.go(-1);return true;\"></p>";
        ?>
    </body>
</html>
