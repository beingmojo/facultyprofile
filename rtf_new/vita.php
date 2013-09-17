<?php
//**************PAGE SETTINGS AND INCLUDES*******************************
include_once 'phprtflite/lib/PHPRtfLite.php';
$file_name = 'vita.rtf';

//******************RETRIEVENT POST AND GET INFORMATION******************

if(isset($_GET['pid'])){
    $pid = $_GET['pid'];
}
elseif(isset($_POST['pid'])){
    $pid = $_POST['pid'];
}
else{
    echo 'Ops... you didn\'t get here with a link<br><a href=\"https://researchprofiles.txstate.edu\" target=\"_self\">Back to Homepage</a>';
    exit();
//    $pid = 1238;
}


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
    $q4_1 = "SELECT name FROM ppl_publication WHERE pid = $pid ORDER BY year DESC";
    //$querys[] = $mysqli->real_escape_string($q4_1);
    $querys[] = $q4_1;
    $q5 = "SELECT * FROM ppl_support WHERE pid=$pid ORDER BY prj_status ASC";
    $querys[] = $mysqli->real_escape_string($q5);
    /*$q6 = "SELECT * FROM ppl_additional WHERE pid = $pid ORDER BY add_id ASC";
    $querys[] = $mysqli->real_escape_string($q6);*/
    $q6 = "SELECT * FROM ppl_teaching WHERE pid = $pid ORDER BY course_id ASC";
    $querys[] = $mysqli->real_escape_string($q6);
    $q7 = "SELECT * FROM ppl_activity where pid = $pid";
    $querys[] = $q7;
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

//MAIN DOCUMENT
$result = $mysqli->store_result();
$row = $result->fetch_assoc();
$name = "$row[l_name], $row[f_name] $row[m_name]";
$username = $row['login_id'];
$title = $row['title'];

$section = $rtf->addSection();

//PERSONAL INFORMATION
$table = $section->addTable(PHPRtfLite_Table::ALIGN_CENTER);
$table->addColumn(18);
$table->addRow();

$cell = $table->getCell(1,1);
$cell->setVerticalAlignment('center');
$cell->writeText("<b>CURRICULUM VITAE</b>", $arial11,$leftFormat);
$cell->setBackgroundColor("#666666");

$section->writeText("<b>$name</b>", $arial11, $subTitleFormat);

$table = $section->addTable(PHPRtfLite_Table::ALIGN_LEFT);
$table->addColumn(18);
$table->addRows(4);
$table->writeToCell(1, 1, "Texas State University-San Marcos", $arial11);
$table->writeToCell(2, 1, "Box", $arial11);
$table->writeToCell(3, 1, "Phone", $arial11);
$table->writeToCell(4, 1, "URL", $arial11);

//EDUCATION SECTION
if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

$table = $section->addTable(PHPRtfLite_Table::ALIGN_LEFT);
$table->addColumnsList(array(8,2,4,4));
$table->addRow();
$table->mergeCellRange(1, 1, 1, 4);
$table->writeToCell(1, 1, "<b>Education</b>", $arial11, $leftFormat);
$table->getCell(1, 1)->setBackgroundColor('#666666');

$i = 1;
while($row = $result->fetch_assoc()){
    $table->addRow();
    $i++;
    $table->writeToCell($i, 1, $row['institution'].$i, $arial11);
    $table->writeToCell($i, 2, $row['degree'], $arial11);
    $table->writeToCell($i, 3, $row['year'], $arial11);
    $table->writeToCell($i, 4, $row['major'], $arial11);
}


//UNIVERSITY EXPERIENCE SECTIONN
if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

$table = $section->addTable(PHPRtfLite_Table::ALIGN_LEFT);
$table->addColumnsList(array(4,14));
$table->addRow();
$table->mergeCellRange(1, 1, 1, 2);
$table->writeToCell(1, 1, "<b>University Experience</b>", $arial11);
$table->getCell(1, 1)->setBackgroundColor('#666666');
$i = 1;
while($row = $result->fetch_assoc()){
    $i++;
    $table->addRow();
    $table->writeToCell($i, 1, $row['dates'], $arial11, $centerFormat);
    $table->writeToCell($i, 2, $row['position'], $arial11, $leftFormat);
}
$table->setVerticalAlignmentForCellRange('center', 1, 1, $i, 2);

//PUBLICATIONS SECTION
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


$table = $section->addTable(PHPRtfLite_Table::ALIGN_LEFT);
$table->addColumnsList(array(1,17));
$table->addRow();
$table->mergeCellRange(1, 1, 1, 2);
$table->writeToCell(1, 1, '<b>Publications</b>', $arial11);
$table->getCell(1, 1)->setBackgroundColor('#666666');
$i = 1;
while($row = $result->fetch_assoc()){
    $i++;
    $table->addRow();
    $table->writeToCell($i, 1, ($i-1).".", $arial11, $leftFormat);
    $table->writeToCell($i, 2, preg_replace('/\s{2,}/',' ' ,$row['name']), $arial11, $leftFormat);
}
$table->setVerticalAlignmentForCellRange('top', 1, 1, $i, 2);
$table->setTextAlignmentForCellRange('left', 1, 1, $i, 2);

//GRANTS SECTION
if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

$table = $section->addTable(PHPRtfLite_Table::ALIGN_LEFT);
$table->addColumnsList(array(4,14));
$table->addRow();
$table->mergeCellRange(1, 1, 1, 2);
//$count = $result->num_rows;
$table->writeToCell(1, 1, "<b>Grants</b>", $arial11);
$table->getCell(1, 1)->setBackgroundColor('#666666');

$ongoing = true;
$completed = true;
$pending = true;
$i = 1;
while($row = $result->fetch_assoc()){
    if($row['prj_status'] == 1 && $ongoing == true){
        $i++;
        $table->addRow();
        $table->mergeCellRange($i, 1, $i, 2);
        $table->writeToCell($i,1,"<i>Ongoing Research</i>", $arial11);
        $table->getCell($i, 1)->setBackgroundColor('#666666');
        $ongoing = false;
    }
    if($row['prj_status'] == 2 && $completed == true){
        $i++;
        $table->addRow();
        $table->mergeCellRange($i, 1, $i, 2);
        $table->writeToCell($i,1,"<i>Completed Research</i>", $arial11);
        $table->getCell($i, 1)->setBackgroundColor('#666666');
        $completed = false;
    }
    if($row['prj_status'] == 3 && $pending == true){
        $i++;
        $table->addRow();
        $table->mergeCellRange($i, 1, $i, 2);
        $table->writeToCell($i,1,"<i>Pending Research</i>", $arial11);
        $table->getCell($i, 1)->setBackgroundColor('#666666');
        $pending = false;
    }
    
    $table->addRows(4);
    $i++;
    $table->writeToCell($i, 1, "Duration:", $arial11, $leftFormat);
    $table->writeToCell($i, 2, "$row[s_date] - $row[e_date]", $arial11, $leftFormat);
    $i++;
    $table->writeToCell($i, 1, "Sponsor:", $arial11, $leftFormat);
    $table->writeToCell($i, 2, $row['sponsor'], $arial11, $leftFormat);
    $i++;
    $table->writeToCell($i, 1, "Title:", $arial11, $leftFormat);
    $table->writeToCell($i, 2, $row['title'], $arial11, $leftFormat);
    $i++;
}

//TEACHING SECTION
if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

$table = $section->addTable(PHPRtfLite_Table::ALIGN_LEFT);
$table->addColumnsList(Array(3,3,3,3,3,3));
$table->addRow();
$table->mergeCellRange(1, 1, 1, 6);
$table->writeToCell(1, 1, "<b>Teaching</b>", $arial11);
$table->getCell(1, 1)->setBackgroundColor("#666666");

$i = 1;
while($row = $result->fetch_assoc()){
    $table->addRows(2);
    $i++;
    $table->writeToCell($i, 1, "Course Title:", $arial11);
    $table->writeToCell($i, 2, $row['course_title'], $arial11);
    $table->writeToCell($i, 3, "Course Number:", $arial11);
    $table->writeToCell($i, 4, $row['course_number'], $arial11);
    $table->writeToCell($i, 5, "Period:", $arial11);
    $table->writeToCell($i, 6, "$row[semester] $row[year]", $arial11);
    $i++;
    $table->mergeCellRange($i, 2, $i, 6);
    $table->writeToCell($i, 1, "Description:", $arial11);
    $table->writeToCell($i, 2, $row['description'], $arial11);
}

//ACTIVITY SECTION
if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

$table = $section->addTable(PHPRtfLite_Table::ALIGN_LEFT);
$table->addColumnsList(Array(4,14));
$table->addRow();
$table->mergeCellRange(1, 1, 1, 2);
$table->writeToCell(1, 1, "<b>Activities:</b>", $arial11);
$table->getCell(1, 1)->setBackgroundColor('#666666');

$i=1;
while($row = $result->fetch_assoc()){
    $table->addRows(3);
    $i++;
    $table->writeToCell($i, 1, "Name:", $arial11);
    $table->writeToCell($i, 2, $row['name'], $arial11);
    $i++;
    $table->writeToCell($i, 1, "Description:", $arial11);
    $table->writeToCell($i, 2, $row['description'], $arial11);
    $i++;
}

$rtf->save('php://output');
?>
