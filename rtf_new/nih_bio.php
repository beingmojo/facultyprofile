<?php
//**************PAGE SETTINGS AND INCLUDES*******************************
include_once 'phprtflite/lib/PHPRtfLite.php';
$file_name = 'biosketch.rtf';

//******************RETRIEVENT POST AND GET INFORMATION******************
$selected = array();
$relevant = array();

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
            if($value == 2){
                $relevant[] = $name;
            }
        }
    }
}

$qry_selected = implode("','",$selected);
$qry_relevant = implode("','",$relevant);

//**********DATABASE CONNECTION AND QUERYS****************************
if($pid != ""){
    $mysqli = new 
mysqli("localhost","ys11","profilesystempass","newprofile");
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
    $q4_2 = "SELECT name FROM ppl_publication WHERE pid = $pid AND pub_id IN('$qry_relevant') ORDER BY year DESC";
    //$querys[] = $mysqli->real_escape_string($q4_2);
    $querys[] = $q4_2;
    $q5 = "SELECT * FROM ppl_support WHERE pid=$pid ORDER BY prj_status ASC";
    $querys[] = $mysqli->real_escape_string($q5);
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
    //HEADER CREATION
$header = $section->addHeader();
$hTable = $header->addTable(PHPRtfLite_Table::ALIGN_CENTER);
//$hTable->
$hTable->addColumn(18);
$hTable->addRow();
$hCell = $hTable->getCell(1, 1);

$hCell->setBorder($hBorder);
$hCell->writeText("Program Director/Principal Investigator: $name", $arial8,$centerFormat);
    //FOOTER CREATION
$footer = $section->addFooter();
$fTable = $footer->addTable('center');
$fTable->addColumnsList(array(6,6,6));
$fTable->addRow();
$fTable->writeToCell(1,1,"PHS 398/2590(Rev. 06/09)", $arial8,$leftFormat);
$fTable->writeToCell(1, 2, "Page <pagenum>", $arial8, $centerFormat);
$fTable->writeToCell(1, 3, "<b>Biographical Sketch Format Page</b>", $arial8, $rightFormat);
$fTable->setBorderForCellRange($topBorder, 1, 1, 1, 3);

    //MAIN DOCUMENT
$section->writeText("  ");
$table = $section->addTable(PHPRtfLite_Table::ALIGN_CENTER);
$table->addColumnsList(array(8,2,2,6));
$table->addRows(6);
$table->mergeCellRange(1, 1, 1, 4);
$table->mergeCellRange(2, 1, 2, 4);
$table->mergeCellRange(3, 2, 4, 4);
$table->mergeCellRange(5, 1, 5, 4);
$table->setVerticalAlignmentForCellRange('center', 1, 1, 6, 4);

$cell = $table->getCell(1,1);
$table->setBorderForCellRange($hBorder, 1, 1, 1, 4);
$cell->setVerticalAlignment('center');
$cell->writeText("<b>BIOGRAPHICAL SKETCH</b>", $arial11,$centerFormat);
//$cell->writeText("Provide the following information for the Senior/key personnel and other significant contributions.", $arial8,$centerFormat);
$cell->writeText("Provide the following information for the Senior/key personnel and other significant contributions.<br>Follow this format for each person. <b>DO NOT EXCEED FOUR PAGES.</b>", $arial8, $centerFormat);

$table->setBorderForCellRange($topBottomBorder, 2, 1, 2, 4);
$table->writeToCell(2, 1, "  ", $arial8,$centerFormat);

$table->getCell(3, 1)->setBorder($topRightBottomBorder);
//$table->getCell(3, 2)->setBorder($topRightBottomBorder);
$table->writeToCell(3, 1, "NAME", $arial8, $leftFormat);
$table->writeToCell(3, 1, $name, $arial11, $leftFormat);

$table->getCell(4, 1)->setBorder($topRightBottomBorder);
$table->writeToCell(4, 1, "eRA COMMONS USER NAME (credential, e.g., agency login)", $arial8, $leftFormat);
$table->writeToCell(4, 1, $username, $arial11, $leftFormat);

$table->getCell(3, 2)->setVerticalAlignment('center');
$table->writeToCell(3, 2, "POSITION TITLE", $arial8, $leftFormat);
$table->writeToCell(3, 2, $title, $arial11, $leftFormat);

$table->setBorderForCellRange($topBottomBorder, 5, 1, 5, 4);
$table->writeToCell(5, 1, "EDUCATION/TRAINING <i>(Begin with baccalaureate or other initial professional education, such as nursing, include postdoctoral training and residency training if applicable)</i>", $arial8, $leftFormat);

$table->getCell(6, 1)->setBorder($topRightBottomBorder);
$table->getCell(6, 2)->setBorder($topLeftRightBottomBorder);
$table->getCell(6, 3)->setBorder($topLeftRightBottomBorder);
$table->getCell(6, 4)->setBorder($topleftBottomBorder);
$table->writeToCell(6, 1, "INSTITUTION AND LOCATION", $arial8, $centerFormat);
$table->writeToCell(6, 2, "DEGREE<br><i>(if applicable)</i>", $arial8, $centerFormat);
$table->writeToCell(6, 3, "MM/YY", $arial8, $centerFormat);
$table->writeToCell(6, 4, "FIELD OF STUDY", $arial8, $centerFormat);


if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

//$table->addRows($result->num_rows);
//$table->setVerticalAlignmentForCellRange('center', 7, 1, 7+$result->num, 4);

for($i = 1; $i <= $result->num_rows; $i++){
    $row = $result->fetch_assoc();
    $table->addRow();
    $table->setTextAlignmentForCellRange("center", 6+$i, 1, 6+$i, 4);
    $table->setVerticalAlignmentForCellRange("center", 6+$i, 1, 6+$i, 4);
    if($i == 1){
        $table->getCell(6+$i, 1)->setBorder($topRightBorder);
        $table->getCell(6+$i, 2)->setBorder($topLeftRightBorder);
        $table->getCell(6+$i, 3)->setBorder($topLeftRightBorder);
        $table->getCell(6+$i, 4)->setBorder($topLeftBorder);
    }
    elseif($i == $result->num_rows){
        $table->getCell(6+$i, 1)->setBorder($rightBottomBorder);
        $table->getCell(6+$i, 2)->setBorder($leftRightBottomBorder);
        $table->getCell(6+$i, 3)->setBorder($leftRightBottomBorder);
        $table->getCell(6+$i, 4)->setBorder($leftBottomBorder);
    }
    else{
        $table->getCell(6+$i, 1)->setBorder($rightBorder);
        $table->getCell(6+$i, 2)->setBorder($leftRightBorder);
        $table->getCell(6+$i, 3)->setBorder($leftRightBorder);
        $table->getCell(6+$i, 4)->setBorder($leftBorder);
        
    }
    $table->writeToCell(6+$i, 1, $row['institution'], $arial11);
    $table->writeToCell(6+$i, 2, $row['degree'], $arial11);
    $table->writeToCell(6+$i, 3, $row['year'], $arial11);
    $table->writeToCell(6+$i, 4, $row['major'], $arial11);
}

//SECTION A
$section->writeText("<b>A. Personal Statement</b>", $arial11, $subTitleFormat);
$section->writeText("Place here your personal statement<br>", $arial11, $leftFormat);

//SECTION B
if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

$section->writeText("<b>B. Positions and Honors</b>", $arial11, $subTitleFormat);
$section->writeText("<b><u>Positions and Employment</u></b>", $arial11, $leftFormat);
$table = $section->addTable('left');
$table->addColumnsList(array(4,14));
$i = 0;
while($row = $result->fetch_assoc()){
    $i++;
    $table->addRow();
    $table->writeToCell($i, 1, $row['dates'], $arial11, $centerFormat);
    $table->writeToCell($i, 2, $row['position'], $arial11, $leftFormat);
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

$section->writeText("<b>C. Selected Peer-reviewed Publications</b> (Selected from $num_publications peer-reviewed publications)", $arial11, $subTitleFormat);
$section->writeText("<b><u>Most relevant to the current application</u></b>", $arial11, $leftFormat);

$table = $section->addTable('left');
$table->addColumnsList(array(1,17));
$i = 0;
while($row = $result->fetch_assoc()){
    $i++;
    $table->addRow();
    $table->writeToCell($i, 1, "$i.", $arial11, $leftFormat);
    $table->writeToCell($i, 2, $row['name'], $arial11, $leftFormat);
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
    $section->writeText("<b><u>Additional recent publications of impportance to the field (in chronological order)</u></b>", $arial11, $subTitleFormat);
    $table = $section->addTable('left');
    $table->addColumnsList(array(1,17));
    $i = 0;
    while($row = $result->fetch_assoc()){
        $i++;
        $table->addRow();
        $table->writeToCell($i, 1, "$i.", $arial11, $leftFormat);
        $table->writeToCell($i, 2, $row['name'], $arial11, $leftFormat);
    }
    $table->setVerticalAlignmentForCellRange('top', 1, 1, $i, 2);
    $table->setTextAlignmentForCellRange('left', 1, 1, $i, 2);
}

//SECTION D
if(!$mysqli->next_result()){
    $section->writeText($mysqli->error);
    $rtf->save('php://output');
    exit();
}
$result = $mysqli->store_result();

$section->writeText("<b>D. Research Support</b>", $arial11, $subTitleFormat);
//$section->writeText("<u><b>Ongoing Research Support</b></u>", $arial11, $subTitleFormat);
$ongoing = true;
$completed = true;
$pending = true;

while($row = $result->fetch_assoc()){
    if($row['prj_status'] == 1 && $ongoing == true){
        $section->writeText("<b><u>Ongoing Research</u></b>", $arial11, $subTitleFormat);
        $ongoing = false;
    }
    if($row['prj_status'] == 2 && $completed == true){
        $section->writeText("<b><u>Completed Research</u></b>", $arial11, $subTitleFormat);
        $completed = false;
    }
    if($row['prj_status'] == 3 && $pending == true){
        $section->writeText("<b><u>Pending Research</u></b>", $arial11, $subTitleFormat);
        $pending = false;
    }

    $table = $section->addTable('left');
    $table->addColumnsList(array(3,15));
    $table->addRows(3);
    $table->writeToCell(1, 1, "Duration:", $arial11, $leftFormat);
    $table->writeToCell(1, 2, "$row[s_date] - $row[e_date]", $arial11, $leftFormat);
    $table->writeToCell(2, 1, "Sponsor:", $arial11, $leftFormat);
    $table->writeToCell(2, 2, $row['sponsor'], $arial11, $leftFormat);
    $table->writeToCell(3, 1, "Title:", $arial11, $leftFormat);
    $table->writeToCell(3, 2, $row['title'], $arial11, $leftFormat);
}

$rtf->save('php://output');
?>
