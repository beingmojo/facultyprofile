<?php
session_start();

include_once 'utils.php';

$err_code = real_get_error();
if( $err_code != $_err_db_connect ) {
    $db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
    real_update_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
}

$_POST['page-title'] = "Error";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
include_once 'includes/page-top.php';
?>

<script type="text/javascript">
    <!--
    startList = function()
    {
        if (document.all&&document.getElementById)
        {
            navRoot = document.getElementById("nav");
            for (i=0; i<navRoot.childNodes.length; i++)
            {
                node = navRoot.childNodes[i];
                if (node.nodeName=="LI")
                {
                    node.onmouseover=function()
                    {
                        this.className+=" over";
                    }
                    node.onmouseout=function()
                    {
                        this.className=this.className.replace(" over", "");
                    }
                }
            }
        }
    }

    window.onload=function()
    {
        startList();
    }

    -->
</script>
<table width="100%" border="0">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->

            <span class="error_message"><b>Message: </b><?php print real_error($err_code)?></span>

            <?php
            if( real_check_user_groupid( $db_conn, "admin" ) == true ) {
                print( "<br />" );

                printf( "<span class=\"error_message\"><b>Code: </b>%s</span>", $err_code );

                print( "<br /><br /><br />" );

                print( "<span class='form_elements'><B>Last few error logs: </B></span>" );
                print( "<BR />" );
                if( $err_code != $_err_db_connect ) {
                    $query = "SELECT * FROM gen_error_log ORDER BY datetime DESC LIMIT 0, 5";
                    $results = mysql_query( $query, $db_conn );
                    while( $row = mysql_fetch_array( $results ) ) {
                        print("<BR>");
                        print( "<span class=\"form_elements\"><b>Time: </b>" .  htmlspecialchars($row["datetime"]) . "</span>" );
                        print("<BR>");
                        print( "<span class=\"form_elements\"><b>Details: </b>" .  htmlspecialchars($row["message"]) . "</span>" );
                        print( "<BR>");
                        print( "<span class=\"form_elements\"><b>Information: </b>" .  htmlspecialchars($row["info"]) . "</span>" );
                        print("<BR>");
                    }
                }
            }

            session_destroy();
            ?>
            <br /><br />
            <!-- InstanceEndEditable -->
        </td>
    </tr>
    <tr><!-- Page footer -->
        <td align="center">
            <p align="center"><img src="images/line.jpg" alt="" width="700" height="1"/></p>
            <p>
                <a href="http://www.uta.edu/collaborate" target="_blank" class="rsp">powering - The Partnership</a><br />
                &copy; 2010 <a href="http://www.txstate.edu/" target="www.txstate.edu">Texas State University-San Marcos</a> &nbsp; | Questions or Comments about this site? | &nbsp; Email: <a href="feedback.php">webmaster</a> <br /><br />
            </p>
        </td>
    </tr>
</table>
</body>
</html>