<?php
session_start();

include_once 'utils.php';

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
rps_check_has_info($_SESSION['UID'], $db_conn);

$_POST['page-title'] = "My Research Space";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-script1'] = "<script type='text/javascript' src='scripts/section_and_menu.js'></script>";
$_POST['page-script2'] = "<script type='text/javascript' src='scripts/findprofile.js'></script>";
$_POST['page-script3'] = "<script type='text/javascript' src='fac_evaluation/javascript.js'></script>";
$_POST['page-script4'] = "<script type='text/javascript' src='scripts/section_and_menu.js'></script>";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';

$is_admin = real_check_user_groupid( $db_conn, "admin" );
$is_tech_admin = real_check_user_groupid( $db_conn, "tech_admin" );
$is_oric_admin = real_check_user_groupid( $db_conn, "oric_admin" );
$is_curriculum_admin = real_check_user_groupid( $db_conn, "curriculum_admin" );
$view=real_unescape($_GET['view']);
if ($view=="") {
    $view=1;
}
?>

<script type="text/javascript">
    <!--
    startList = function() {
        if (document.all&&document.getElementById) {
            navRoot = document.getElementById("nav");
            for (i=0; i<navRoot.childNodes.length; i++) {
                node = navRoot.childNodes[i];
                if (node.nodeName=="LI") {
                    node.onmouseover=function() {
                        this.className+=" over";
                    }
                    node.onmouseout=function() {
                        this.className=this.className.replace(" over", "");
                    }
                }
            }
        }
    }
    window.onload=function() {
        startList();
    }
    -->
</script>

</head>
<table width="100%" border="0">
    <tr><!-- Main Content -->
        <td>
            <?php
            
            print( "<table width='100%' border='0' cellspacing='0' cellpadding='0'> " );
            print( "<tr >" );
            switch ($view) {
                case 1:
                    print( "<td style=\"color: #111111; font-size: 14px; font-weight: bold\" height='33' width='111' valign='bottom' align='center'>My Profiles</td>" );
                    //print( "<td style=\"color: #eeeeee; font-size: 14px;\" height='33' width='200' valign='bottom' align='center' ><a href='researchspace.php?view=2' style='text-decoration:none'> BlueSheet (Under Construction)</a></td>" );
					print( "<td style=\"color: #eeeeee; font-size: 14px;\" height='33' width='200' valign='bottom' align='center' ><a href='researchspace.php?view=3' style='text-decoration:none'> Biosketches & Vitas</a></td>" );
                    break;
                case 2:
                    print( "<td style=\"color: #eeeeee; font-size: 14px;\" height='33' width='111' valign='bottom' align='center'><a href='researchspace.php?view=1' style='text-decoration:none'>My Profiles</a></td>" );
                    //print( "<td style=\"color: #111111; font-size: 14px; font-weight: bold\" height='33' width='200' valign='bottom' align='center' > BlueSheet (Under Construction)</td>" );
					print( "<td style=\"color: #eeeeee; font-size: 14px;\" height='33' width='200' valign='bottom' align='center' ><a href='researchspace.php?view=3' style='text-decoration:none'> Biosketches & Vitas</a></td>" );
                    break;
				case 3:
					print( "<td style=\"color: #eeeeee; font-size: 14px;\" height='33' width='111' valign='bottom' align='center'><a href='researchspace.php?view=1' style='text-decoration:none'>My Profiles</a></td>" );
                                        //print( "<td style=\"color: #eeeeee; font-size: 14px;\" height='33' width='200' valign='bottom' align='center' ><a href='researchspace.php?view=2' style='text-decoration:none'> BlueSheet (Under Construction)</a></td>" );
					print( "<td style=\"color: #111111; font-size: 14px; font-weight: bold\" height='33' width='111' valign='bottom' align='center'>Biosketches & Vitas</td>" );
					break;
            }
            print( "<td>&nbsp;</td>" );
            print( "</tr>" );
            print( "<tr>" );
            print( "<td colspan='8' height='5' bgcolor='#480000'> </td>" );
            print( "</tr>" );
            print( "<tr>" );
            print( "<td colspan='6' height='5' > </td>" );
            print( "</tr>" );
            print( "</table>" );
            if ($view==1) {
                include "f_myprofiles.php";
            }
            if ($view==2) {
                
                $pid = "0";
                $query1 = "SELECT pid FROM gen_profile_info WHERE type_id=1 AND owner_login_id='".$_SESSION['UID']."'";
                
                $results = real_execute_query($query1, $db_conn);
                
                while( $rows = mysql_fetch_array( $results ) ) {
                    $pid = $rows["pid"];
                }
                       
                   include "bluesheets.php";
            }
			if ($view==3) {
				/*$pid = "0";
                $query1 = "SELECT pid FROM gen_profile_info WHERE type_id=1 AND owner_login_id='".$_SESSION['UID']."'";
                
                $results = real_execute_query($query1, $db_conn);
                
                while( $rows = mysql_fetch_array( $results ) ) {
                    $pid = $rows["pid"];
                }
				*/
                include "biosketches.php";
            }
            ?>
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
