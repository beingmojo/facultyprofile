<?php
include_once 'phprtflite/lib/PHPRtfLite.php';

$file_name = 'biosketch.rtf';

//******************RETRIEVENT POST AND GET INFORMATION******************
$selected = array();

if(isset($_GET['pid'])){
    $pid = $_GET['pid'];
}
elseif(isset($_POST['pid'])){
    $pid = $_POST['pid'];
    foreach ($_POST as $name=>$value){
        if($name != 'pid'){
            if($value == 1){
                $selected[] = $name;
            }
        }
    }
}

$qry_selected = implode("','",$selected);

//**********DATABASE CONNECTION AND QUERYS****************************
if($pid != ""){
    $mysqli = new mysqli("localhost","ys11","profilesystempass","newprofile");
    if(mysqli_connect_errno()){
        printf("Connect failed: %s\n",  mysqli_connect_error());
        exit();
    }
    $querys  = array();
    $mysqli->set_charset('utf8');
    $q1 = "SELECT * FROM ppl_general_info WHERE pid = $pid";
    $querys[] = $mysqli->real_escape_string($q1);
    $q2 = "SELECT * FROM ppl_prof_preparation WHERE pid = $pid ORDER BY year ASC";
    $querys[] = $mysqli->real_escape_string($q2);
    $q3 = "SELECT IF(s_date <> '',
                        CONCAT(s_date,
                            IF(e_date <> '',
                                CONCAT('-',e_date),
                                ''
                            )
                        ),
                        e_date
                   )as dates,
                CONCAT(rank,
                        if(dept_school <> '',
                            CONCAT(', ',dept_school),
                            ''
                        ), 
                        if(off_coll <> '',
                            CONCAT(', ',off_coll),
                            ''
                        ),
                        if(univ_comp <> '', 
                            CONCAT(',',univ_comp),
                            ''
                        )
                ) as position
            FROM ppl_appointment
            WHERE pid = $pid
            ORDER BY s_date DESC, e_date DESC";
    $querys[] = $q3;
    $q4_11 = "SELECT Count(name) as total FROM ppl_publication WHERE pid = $pid";
    $querys[] = $q4_11;
    $q4_1 = "SELECT name FROM ppl_publication WHERE pid = $pid AND pub_id IN('$qry_selected') ORDER BY year DESC";
    //$querys[] = $mysqli->real_escape_string($q4_1);
    $querys[] = $q4_1;
    $q4_2 = "SELECT name FROM ppl_activity WHERE pid = $pid";
    //$querys[] = $mysqli->real_escape_string($q4_2);
    $querys[] = $q4_2;
    //$q5 = "SELECT * FROM ppl_support WHERE pid=$pid ORDER BY prj_status ASC";
    //$querys[] = $mysqli->real_escape_string($q5);
    $final_query = implode(";",$querys);
    $mysqli->multi_query($final_query);
}
else{
    exit();
}

//DOCUMENT CREATION
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=$file_name");

PHPRtfLite::registerAutoloader();
$rtf = new PHPRtfLite();

//DOCUMENT PROPERTIES
$rtf->setPaperWidth(21.59);
$rtf->setPaperHeight(27.94);
$rtf->setMargins(1.27, 1.27, 1.27, 1.27);

//FONTS
$arial9 = new PHPRtfLite_Font(9,'Arial');
$arial8 = new PHPRtfLite_Font(8,'Arial');
$arial11 = new PHPRtfLite_Font(11,'Arial');

//FORMATING
$centerFormat = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER);
$leftFormat = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT);
$rightFormat = new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_RIGHT);
$subTitleFormat = new PHPRtfLite_ParFormat();
    $subTitleFormat->setSpaceBefore(.634);
    $subTitleFormat->setSpaceAfter(.2116);
    $subTitleFormat->setTextAlignment('left');

$hBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000')
            );
$topBottomBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000')
            );
$topRightBottomBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000')
            );
$topleftBottomBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000')
            );
$topLeftBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF')
            );
$leftBottomBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000')
            );
$rightBottomBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000')
            );
$topRightBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF')
            );
$topLeftRightBottomBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000')
            );
$topLeftRightBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF')
            );
$leftRightBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF')
            );
$leftRightBottomBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#000000')
            );
$leftBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF')
            );
$rightBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF')
            );
$topBorder = new PHPRtfLite_Border(
                $rtf,
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#000000'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF'),
                new PHPRtfLite_Border_Format(1,'#FFFFFF')
            );

$result = $mysqli->store_result();
$row = $result->fetch_assoc();
$name = "$row[l_name], $row[f_name] $row[m_name]";
$username = $row['login_id'];
$title = $row['title'];

$section = $rtf->addSection();

    //MAIN DOCUMENT
$section->writeText("<b>Biographical Sketch - $name</b><br>", $arial11, $centerFormat);
$section->writeText("Texas State University-San Marcos", $arial11,$centerFormat);
$section->writeText("$username@txstate.edu<br>", $arial11, $centerFormat);

//SECTION A
$section->writeText("<b>a. Professional Preparation</b><br>", $arial11, $leftFormat);

$table = $section->addTable(PHPRtfLite_Table::ALIGN_CENTER);
$table->addColumnsList(array(8,2,2,6));
$table->addRow();

$table->getCell(1, 1)->setBorder($topRightBottomBorder);
$table->getCell(1, 2)->setBorder($topLeftRightBottomBorder);
$table->getCell(1, 3)->setBorder($topLeftRightBottomBorder);
$table->getCell(1, 4)->setBorder($topleftBottomBorder);
$table->writeToCell(1, 1, "INSTITUTION", $arial11, $centerFormat);
$table->writeToCell(1, 2, "DEGREE", $arial11, $centerFormat);
$table->writeToCell(1, 3, "MM/YY", $arial11, $centerFormat);
$table->writeToCell(1, 4, "MAJOR", $arial11, $centerFormat);


if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

for($i = 1; $i <= $result->num_rows; $i++){
    $j = 1;
    $row = $result->fetch_assoc();
    $table->addRow();
    $table->setTextAlignmentForCellRange("center", $j+$i, 1, $j+$i, 4);
    $table->setVerticalAlignmentForCellRange("center", $j+$i, 1, $j+$i, 4);
    if($i == 1){
        $table->getCell($j+$i, 1)->setBorder($topRightBorder);
        $table->getCell($j+$i, 2)->setBorder($topLeftRightBorder);
        $table->getCell($j+$i, 3)->setBorder($topLeftRightBorder);
        $table->getCell($j+$i, 4)->setBorder($topLeftBorder);
    }
    elseif($i == $result->num_rows){
        $table->getCell($j+$i, 1)->setBorder($rightBottomBorder);
        $table->getCell($j+$i, 2)->setBorder($leftRightBottomBorder);
        $table->getCell($j+$i, 3)->setBorder($leftRightBottomBorder);
        $table->getCell($j+$i, 4)->setBorder($leftBottomBorder);
    }
    else{
        $table->getCell($j+$i, 1)->setBorder($rightBorder);
        $table->getCell($j+$i, 2)->setBorder($leftRightBorder);
        $table->getCell($j+$i, 3)->setBorder($leftRightBorder);
        $table->getCell($j+$i, 4)->setBorder($leftBorder);
        
    }
    $table->writeToCell($j+$i, 1, $row['institution'], $arial11);
    $table->writeToCell($j+$i, 2, $row['degree'], $arial11);
    $table->writeToCell($j+$i, 3, $row['year'], $arial11);
    $table->writeToCell($j+$i, 4, $row['major'], $arial11);
}

//SECTION B
if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

$section->writeText("<b>b. Appointments</b><br>", $arial11, $subTitleFormat);
$table = $section->addTable('left');
$table->addColumnsList(array(4,14));
$i = 0;
while($row = $result->fetch_assoc()){
    $i++;
    $table->addRow();
    $table->writeToCell($i, 1, rtrim($row['dates']), $arial11, $centerFormat);
    $table->writeToCell($i, 2, rtrim($row['position']), $arial11, $leftFormat);
}
$table->setVerticalAlignmentForCellRange('center', 1, 1, $i, 2);

//SECTION C
if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();
$row = $result->fetch_assoc();
$num_publications = $row['total'];

if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

$section->writeText("<b>c. Selected Peer-reviewed Publications</b> <i>(Selected from $num_publications peer-reviewed publications)</i><br>", $arial11, $subTitleFormat);

$table = $section->addTable('left');
$table->addColumnsList(array(1,17));
$i = 0;
while($row = $result->fetch_assoc()){
    $i++;
    $table->addRow();
    $table->writeToCell($i, 1, "$i.", $arial11, $leftFormat);
    $table->writeToCell($i, 2, rtrim($row['name']), $arial11, $leftFormat);
}
$table->setVerticalAlignmentForCellRange('top', 1, 1, $i, 2);
$table->setTextAlignmentForCellRange('left', 1, 1, $i, 2);

if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

if($result->num_rows > 0){
    $section->writeText("<b>Synergistic Activities</b><br>", $arial11, $subTitleFormat);
    $table = $section->addTable('left');
    $table->addColumnsList(array(1,17));
    $i = 0;
    while($row = $result->fetch_assoc()){
        $i++;
        $table->addRow();
        $table->writeToCell($i, 1, "$i.", $arial11, $leftFormat);
        $table->writeToCell($i, 2, rtrim($row['name']), $arial11, $leftFormat);
    }
    $table->setVerticalAlignmentForCellRange('top', 1, 1, $i, 2);
    $table->setTextAlignmentForCellRange('left', 1, 1, $i, 2);
}

$section->writeText("<b>e. Collaborators & other affiliations</b><br>", $arial11, $subTitleFormat);
$section->writeText("<b>(i)Collaborators</b><br>", $arial11, $subTitleFormat);
$section->writeText("<b>(ii)Graduate and Postdoctoral Advisors</b> <i>(List your own grad advisor(s), principal postdoctoral sponsor(s) and their current organizational affiliations.)</i><br>", $arial11, $subTitleFormat);
$section->writeText("<b>Thesis Advisor and Postgraduate-Scholar Sponsor</b><br>", $arial11, $subTitleFormat);

$rtf->save('php://output');

?>
