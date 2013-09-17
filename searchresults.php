<?php
session_start();
//***************************INCLUDES********************************
include_once 'utils.php';

//***************************DB CONNECTION***************************
//$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
/*if ($_SESSION["UID"] != "") {
    real_check_valid_session($db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
}*/
/*new database connection mysqli will replace mysql extension*/
$mysqli = new mysqli('localhost','ys11','profilesystempass','newprofile');
if($mysqli->connect_errno){
    echo 'Undefined error: please try again later';
}
$mysqli->set_charset('utf8');

$_POST['page-title'] = "Search Results";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';

// Subsearch & pid_list
if ($_GET["subsearch"] == 'on') $pid_list = $_SESSION["basic_search_pid_list"];
else $pid_list = array();

//Code modified by Rajat to remove hardcoding of institution logo
//Please change the link to your university logo and the alt tag to have it customized for your instititution
$instsrc = "";
$alt = "Texas State";
//end of code change
//Code added by Jonathan to remove extra slashes
$rawsearchstring = stripslashes($_GET["search"]);
$srch = urlencode($rawsearchstring);    //this will be passed as a get parameter to profile_view.php

$searchstrings = explode(' ', $rawsearchstring);
$searchstring = "";
$searchtype_basic = 0;
$searchtype_basic_faculty = 0;
$searchtype_basic_researchcenter = 0;
$searchtype_basic_technology = 0;
$searchtype_basic_facility = 0;
$searchtype_basic_equipment = 0;
$searchtype_basic_labgroup = 0;
$searchtype_basic_expression = 0;

//Code added by Jonathan to escape user input in search query
//$searchstring = mysql_real_escape_string($searchstring);

//$src = "editprofile.php";
$src = "profile_view.php";
$searchtype = $_GET["searchtype"];

if ($searchtype == "home" || $searchtype == "") {
    $searchtype_basic = -1;
    $searchtype_basic_faculty = 1;
    $searchtype_basic_researchcenter = 1;
    $searchtype_basic_technology = 1;
    $searchtype_basic_facility = 1;
    $searchtype_basic_equipment = 1;
    $searchtype_basic_labgroup = 1;
    $link = 'newsearch.php';
}

if ($searchtype == "basic") {
    $searchtype_basic = 1;
    if ($_GET["faculty"] == "true") $searchtype_basic_faculty = 1;
    if ($_GET["researchcenter"] == "true") $searchtype_basic_researchcenter = 1;
    if ($_GET["technology"] == "true") $searchtype_basic_technology = 1;
    /*if ($_GET["facility"] == "true")*/ $searchtype_basic_facility = 1;
    if ($_GET["equipment"] == "true") $searchtype_basic_equipment = 1;
    /*if ($_GET["labgroup"] == "true")*/ $searchtype_basic_labgroup = 1;
    if($_GET["expression"] == "true") {
        $searchtype_basic_expression = 1;
        foreach ($searchstrings as $srchstr) {
            if ($srchstr != ""){
                $searchstring = $searchstring ."+". $srchstr." " ;
            }
        }
    }
    else{
        $searchstring = $rawsearchstring;
    }
    $link = 'newsearch.php';
}

if(isset($_GET['rec_per_page'])) $rec_per_page = $_GET['rec_per_page'];
else $rec_per_page = 10;
if(isset($_GET['curr_page'])) $curr_page = $_GET['curr_page'];
else $curr_page = 1;
$curr_record = ($curr_page - 1) * 10;

$mysqli->multi_query("call n_search_results($searchtype_basic_faculty,
                                            $searchtype_basic_researchcenter,
                                            $searchtype_basic_technology,
                                            $searchtype_basic_facility,
                                            $searchtype_basic_equipment,
                                            $searchtype_basic_labgroup,
                                            0,
                                            '$searchstring',
                                            $curr_record,
                                            $rec_per_page);");
$res = $mysqli->store_result();
$row_num_results = $res->fetch_assoc();
$num_results = $row_num_results[num_results];
//echo $num_results.' against '.$row_num_results[num_results];
mysqli_free_result($res);

$mysqli->next_result();
$res2 = $mysqli->store_result();


//$_SESSION["basic_search_pid_list"] = $pid_list;

/* * *****Paging added by Jonathan - December 2006*************************** */
/* NEW 
 
 if (isset($_GET['page'])) $page = $_GET['page'];
 
else {
    $page = 1;
    $_SERVER['REQUEST_URI'] .= "&amp;page=1";
}
$rec_per_page = preg_match('/^[0-9]{1,3}$/', $_GET['rec_per_page']) ? $_GET['rec_per_page'] : 10; //Modified by Jose
$start_rec = $page * $rec_per_page - $rec_per_page + 1;
$total_pages = ceil(count($info) / $rec_per_page);*/
function printPages() {	//*********Function Modified by Jose
    global $num_results;
    global $rec_per_page;
    global $curr_page;
    $pages = $num_results / $rec_per_page;
    $current_url = $_SERVER['REQUEST_URI'];
    for($i = 1; $pages > 0; $i++,$pages--){
        if($i == $curr_page){
            echo "<label class='font_topic'>$i </label> ";
                continue;
        }
        else 
            $url_sorting = preg_replace('/curr_page=[0-9]+/','curr_page='.$i,$current_url,-1,$x_count);
        if(!$x_count) 
            $url_sorting = $url_sorting."&curr_page=$i";
        echo "<a id=\"normal_link\" class='font_topic' href=\"$url_sorting\">$i</a> ";
    }
}
 
?>

<script type="text/javascript">
    <!--
    var timer;
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

    //-->
</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="form_elements_row_action" id="basic_layout">
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <!-- content goes here -->
    <tr>
        <td colspan="2">
            <!-- InstanceBeginEditable name="content" -->
            <br  />
            <form id='search_form' name='search_form' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='get'>
                <table width='100%' cellpadding='0' cellspacing='0'>
                        <label for='searchtype'>
                            <input type='hidden' id='searchtype' name='searchtype' value='basic' />
                        </label>
                        <tr>
                            <td>
                            </td>
                            <td colspan='4' align='left'>
                                <span class='form_elements'>Search&nbsp;</span>
                                <label for='searchbox1'>
                                    <input type='text' id='searchbox1' name='search' value='<?php echo htmlentities($rawsearchstring); ?>' size='100'>
                                </label>&nbsp;
                                <label for='searchbox2'>
                                    <input type='text' id='searchbox2' name='rec_per_page' value='<?php echo $rec_per_page; ?>' size='1' maxlength='3'>
                                </label>&nbsp;
                                <span class='form_elements'>Results per page&nbsp;</span>
                                <input name='submit' type='submit' value='Go' style="width:40px;">
                            </td>
                        </tr>

                        <tr>
                            <td>
                            </td>
                            <td>
                                <?php $checked = $searchtype_basic_faculty == 1 ? "checked" : ""; ?>
                                <label for='faculty'>
                                    <input type='checkbox' name='faculty' id='faculty' value='true' <?php echo $checked; ?>>
                                </label>
                                <img src='images/bullets/faculty.gif' width='12' height='12' alt='>'>
                                <span class='form_elements'>Faculty / Expertise</span>
                            </td>
                            <td >
                                <?php $checked = $searchtype_basic_researchcenter == 1 ? "checked" : ""; ?>
                                <label for='researchcenter'>
                                    <input type='checkbox' id='researchcenter' name='researchcenter' value='true' <?php echo $checked; ?>>
                                </label>
                                <img src='images/bullets/center.gif' width='12' height='12' alt='>'>
                                <span class='form_elements'>Research Centers</span>
                            </td>
                            <td>
                                <?php $checked = $searchtype_basic_technology == 1 ? "checked" : ""; ?>
                                <label for='technology'>
                                    <input type='checkbox' id='technology' name='technology' value='true' <?php echo $checked; ?>>
                                </label>
                                <img src='images/bullets/technology.gif' width='12' height='12' alt='>'>
                                <span class='form_elements'>Technologies and Patents</span>
                            </td>
        <!--                    <td>
                                <?php //$checked = $searchtype_basic_facility == 1 ? "checked" : ""; ?>
                                <label for='facility'>
                                    <input type='checkbox' name='facility' id='facility' value='true' <?php //echo $checked; ?>>
                                </label>
                                <img src='images/bullets/facility.gif' width='12' height='12' alt='>'>
                                <span class='form_elements'>Research Facilities</span>
                            </td>
        -->
                        </tr>

                        <tr>
                            <td width='100'>
                            </td>
                            <td>
                                <?php $checked = $searchtype_basic_equipment == 1 ? "checked" : ""; ?>
                                <label for='equipment'>
                                    <input type='checkbox' name='equipment' id='equipment' value='true' <?php echo $checked; ?>>
                                </label>
                                <img src='images/bullets/equipment.gif' width='12' height='12' alt='>'>
                                <span class='form_elements'>Equipment</span>
                            </td>
                            <td>
                                <?php $checked = $searchtype_basic_expression == 1 ? "checked" : ""; ?>
                                <label for='expression'>
                                    <input type='checkbox' id='expression' name='expression' value='true' <?php echo $checked; ?>>
                                </label>
                                <!-- <img src='images/bullets/labgroup.gif' width='12' height='12' alt='>'> -->
                                <span class='form_elements'>Strict Search</span>
                            </td>
        <!--                <td>
                                <?php //$checked = $search_basic_expression == 1 ? "checked" : ""; ?>
                                <label for='expression'>
                                    <input type='checkbox' id='expression' name='expression' <?php //echo $checked; ?>>
                                </label>
                                <span class='form_elements'>Search whole phrases</span>
                            </td>
                            <td>
                                <label for='subsearch'>
                                    <input type='checkbox' id='subsearch' name='subsearch' >
                                </label>
                                <span class='form_elements'>Search within these results</span>
                            </td>
        -->
                        </tr>
                </table>
            </form>
            <br>
            <br>
            <table width='100%' cellpadding='0' cellspacing='0'>
                <tr>
                    <td colspan="6" align="center">
			<?php /********For paging, added by Jose***********
			foreach($letters as $key=>$value){
				$current_url = $_SERVER['REQUEST_URI'];
				$url_sorting = preg_replace('/apage=[A-Za-z]/','apage='.$value,$current_url,-1,$x_count);
				if(!$x_count){
					$url_sorting = $current_url."&apage=$value";
				}
				if($value == $search_letter){
					echo "<label class='font_topic'>$value </label>";
				}
				else{
					echo "<a id=\"normal_link\" href=\"$url_sorting\">$value</a>";
				}
				
			}
			***********End code***************************/
			//echo "<br/>";
                        ?>
                        <?php printPages(); ?>
                        
                    </td>
                </tr>
                <tr>
                    <td colspan='6' class='table_background_other'>
                        <?php
                            if($num_results != 0){
                                print( "<span class='form_elements'><B>" . $num_results . " profiles found </B></span>"); //Modified by Jose
                            }
                            else{
				print( "<span class='form_elements'><B>0 profiles found</B></span>"); //Modified by Jose
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan='6'>&nbsp;</td>
                </tr>
                <?php $counter = $curr_record; ?>
                    <?php if ($num_results != 0) { ?>
                        <?php while($row_result = $res2->fetch_assoc()) { ?>
                            <?php $counter++; ?>
                                <tr>
                                    <td rowspan='3' align='center' class='form_elements'>
                                        <?php echo $counter; ?>
                                        <!-- <img src='images/icons/rating_star.gif'> -->
                                    </td>
                                    <td rowspan='3' width='48' height='48' align='center' valign='middle'>
                                        <?php $imgSrc = !preg_match('/_[0-9]+_/', $row_result['rImage']) ? "images/48/" . $row_result['pid'] . "_0_" . $row_result['rImage'] . ".jpg" : "images/48/" . $row_result['rImage'] . ".jpg"; ?>
                                        <?php 
                                            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $_home . "/" . $imgSrc)) 
                                                print( "<img src='$imgSrc' alt='" . $row_result['rName'] . "'>");
                                            else 
                                                print( "<img src='images/picture_not_available.png' alt='" . $row_result['rName'] . "'>"); 
                                        ?>
                                    </td>
                                    <td rowspan='3' width='5'>
                                        
                                    </td>
                                    <td>
                                        <a href='<? echo "$src?onlyview=1&amp;pid=$row_result[pid]&srch=$srch"; ?>'>
                                            <span class='font_topic'>
                                                <?php echo htmlspecialchars($row_result['rName']); ?>
                                            </span>
                                        </a>
                                    </td>
                                    <td rowspan='3' width='20' height='48' valign='middle' align='center'>
                                        <?php
                                            if ($row_result['rType'] == 1) {
                                                $imgsrc = "images/bullets/faculty.gif";
                                                $alt = "Faculty";
                                            }
                                            if ($row_result['rType'] == 2) {
                                                $imgsrc = "images/bullets/center.gif";
                                                $alt = "Research Center";
                                            }
                                            if ($row_result['rType'] == 3) {
                                                $imgsrc = "images/bullets/technology.gif";
                                                $alt = "Technology";
                                            }
                                            if ($row_result['rType'] == 4) {
                                                $imgsrc = "images/bullets/facility.gif";
                                                $alt = "Facility";
                                            }
                                            if ($row_result['rType'] == 5) {
                                                $imgsrc = "images/bullets/equipment.gif";
                                                $alt = "Equipment";
                                            }
                                            if ($row_result['rType'] == 6) {
                                                $imgsrc = "images/bullets/labgroup.gif";
                                                $alt = "Labs &amp; Groups";
                                            }
                                        ?>
                                        <img src='<?php echo $imgsrc; ?>' width='12' height='12' alt='<?php echo $alt; ?>'>
                                    </td>
                                    <td rowspan='3' width='48' height='48' valign='middle' align='center'>
                                        <img src='images/txstate-logo.png' width='60' alt='$alt'>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='form_elements'>
                                            <?php $row_result['rInfo']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class='form_elements'>
                                            <B>Relevant Sections : </B>
                                            <?php echo $row_result['rsection']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='6'>
                                        <HR>
                                    </td>
                                </tr>
                        <?php }//end of for ?>
                    <?php }//end of if
                          else {
                            print( "");
                          }
                    ?>
                <tr>
                    <td colspan="6" align="center">
                        <br />
			<?php printPages(); ?>
			<br/>
                        <br />
                        <br />
                    </td>
                </tr>
            </table>
            <!-- InstanceEndEditable -->
        </td>
    </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
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
<!-- InstanceEnd -->
</html>