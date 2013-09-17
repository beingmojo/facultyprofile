<table width="100%" border="0">
    <tr>
        <!-- Menu Bar MODIFY Styles\list.css to modify properties like position -->
        <td style="background-color: #480000;" valign="top" align="right">
            <div id="menu">
                <ul id="nav">
                    <li>
                        <a href='https://researchprofiles.txstate.edu/index.php' style='color:#FFFFFF'>Home</a>
                    </li>
                    <?php if($_SESSION['UID'] != "") { ?>
                    <li>
                        <a href="https://researchprofiles.txstate.edu/researchspace.php" style="color: #FFFFFF">My Dashboard</a>
                    </li>
                    <li>
                        <a href="https://researchprofiles.txstate.edu/myprofiles.php" style="color: #FFFFFF">Existing Profiles</a>
                    </li>
                    <li>
                        <a href="https://researchprofiles.txstate.edu/biosketches.php?self=1" style="color: #FFFFFF">Vita & Biosketch Tools</a>
                    </li>
                    <?php } ?>
                    <li><a href="https://researchprofiles.txstate.edu/browseprofiles.php?view=1" style="color:#FFFFFF">Browse Profiles</a>
                        <ul>
                            <li><a href="https://researchprofiles.txstate.edu/browseprofiles.php?view=1">Faculty</a></li>
                            <li><a href="https://researchprofiles.txstate.edu/browseprofiles.php?view=2">Center</a></li>
                            <li><a href="https://researchprofiles.txstate.edu/browseprofiles.php?view=3">Technology</a></li>
                            <li><a href="https://researchprofiles.txstate.edu/browseprofiles.php?view=5">Equipment</a></li>
                           <!-- <li><a href="/browseprofiles.php?view=4">Facility</a></li>
                             <li><a href="/browseprofiles.php?view=6">Labs &amp; Groups</a></li>-->
                            <li><a href="https://researchprofiles.txstate.edu/courses.php">Courses</a></li>
                        </ul>
                    </li>
                    <li><a href="https://researchprofiles.txstate.edu/newsearch.php" style='color:#FFFFFF'>Search </a>
                        <ul>
                            <li><a href="https://researchprofiles.txstate.edu/newsearch.php">Basic</a></li>
                            <!-- <li><a href="/clustersearch.php">Cluster</a></li> 
                            <li><a href="/advsearch.php">Advanced</a></li>-->
                        </ul>
                    </li>
                    <li><a href="https://researchprofiles.txstate.edu/aboutrps.php" style='color:#FFFFFF'>Support</a>
                        <ul>
                            <li><a href="https://researchprofiles.txstate.edu/aboutrps.php">About RPS</a></li>
                            <li><a href="https://researchprofiles.txstate.edu/help/index.php">Help and FAQ's</a></li>
                            <li><a href="https://researchprofiles.txstate.edu/feedback.php">Contact Us</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </td>
        <?php if($_SESSION['UID'] != ""){ ?>
        <td style="background-color: #480000;">
            <a href="https://researchprofiles.txstate.edu/logoff.php" style='color:#FFFFFF'>Logout</a>
        </td>
        <?php } ?>
    </tr>
</table>
<?php
                        if ($_POST['page-include-page-top2'] != "") {
                            echo "<!--SECTION: Start of page-specific items -->";
                        }
?>
