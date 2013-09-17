<?php
require('fpdf/fpdf.php');
require('fpdf/fpdi.php');
define('FPDF_FONTPATH','fpdf/font/');
include 'utils.php';
//add additional pages
//retrieve form elements
//----------------------
$f_name=real_unescape($_POST['f_name']);
$l_name=real_unescape($_POST['l_name']);
$m_name=real_unescape($_POST['m_name']);
$designation=real_unescape($_POST['designation']);
$count2 = real_unescape($_POST['count2']);
for($i=1;$i<=$count2;$i++) {
    $fieldname = 'inst_loc_'.$i;
    $inst_loc[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'degree_'.$i;
    $degree[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'year_'.$i;
    $year[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'major_'.$i;
    $major[$i] = real_unescape($_POST[$fieldname]);
}
$count3 = real_unescape($_POST['count3']);
for($i=1;$i<=$count3;$i++) {
    $fieldname = 's_date_'.$i;
    $s_date[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'e_date_'.$i;
    $e_date[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'rank_'.$i;
    $rank[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'inst_'.$i;
    $inst[$i] = real_unescape($_POST[$fieldname]);
}
$count4 = real_unescape($_POST['count4']);
for($i=1;$i<=$count4;$i++) {
    $fieldname = 'pub_'.$i;
    $pub[$i] = real_unescape($_POST[$fieldname]);
}
$count5 = real_unescape($_POST['count5']);
for($i=1;$i<=$count5;$i++) {
    $fieldname = 'duration_'.$i;
    $duration[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'spon_'.$i;
    $spon[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'title_'.$i;
    $title[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'goal_'.$i;
    $goal[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'role_'.$i;
    $role[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'status_'.$i;
    $status[$i] = real_unescape($_POST[$fieldname]);
}
//---------------------
//end of retreival

//procesesing on form elements
$name=$l_name.", ".$f_name." ".$m_name;
//end of processing

//set PDF parameters
$pdf=new fpdi('P','mm','Letter');

//get page count of source file
$pagecount = $pdf->setSourceFile("fpdf/biosketch.pdf");
$page_no=0;
//set page parametes
$pdf->SetDisplayMode('real','continuous');
$pdf->SetAutoPageBreak(false);
$pdf->SetMargins(2.5,2.5,2.5);
$tplidx = $pdf->ImportPage(1);
$pdf->addPage();
$page_no=$page_no+1;
$pdf->useTemplate($tplidx);

//page 1
$pdf->SetFont('Arial','',9);
$pdf->SetXY(114,265);
$pdf->Cell(11,0,$page_no);
$pdf->SetFont('Arial','U',11);
$pdf->SetXY(105, 17);
$pdf->Cell(110,0,$name);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(15,49);
$pdf->Cell(110,0,$name);
$pdf->SetXY(109,49);
$pdf->Cell(150,0,$designation);
$startoftable=73;
$ypos=75;
$rowheight=5;
$rowheight2=7;
for($i=1;$i<=$count2;$i++) {
    $pdf->SetXY(15,$ypos);
    $pdf->Cell(90,0,$inst_loc[$i]);
    $pdf->Cell(25,0,$degree[$i]);
    $pdf->Cell(25,0,$year[$i]);
    $pdf->Cell(90,0,$major[$i]);
    $ypos=$ypos+$rowheight;
}
$endoftable=$startoftable+$count2*$rowheight;
$pdf->Line(103.25, $startoftable, 103.25, $endoftable);
$pdf->Line(129.85, $startoftable, 129.85, $endoftable);
$pdf->Line(154.85, $startoftable, 154.85, $endoftable);
$pdf->Line(14,$endoftable,202,$endoftable);
$ypos=$endoftable+$rowheight;
$pdf->SetXY(15,$ypos);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(100,0,"A.  Positions and Honors.");
$ypos=$ypos+$rowheight2;
$pdf->SetFont('Arial','',11);
for($i=1;$i<=$count3;$i++) {
    $pdf->SetXY(15,$ypos);
    $pdf->Cell(30,0,$s_date[$i]." - ".$e_date[$i]);
    $pdf->Cell(100,0,$rank[$i]."; ".$inst[$i]);
    $ypos=$ypos+$rowheight;
}
$ypos=$ypos+$rowheight2-$rowheight;
$pdf->SetXY(15,$ypos);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(100,0,"B.  Selected peer-reviewed publications (ascending chronological order)");
$ypos=$ypos+$rowheight2;
$pdf->SetFont('Arial','',11);
for($i=1;$i<=$count4;$i++) {
    $pdf->SetXY(15,$ypos);
    $pdf->MultiCell(190,4,$i.". ".$pub[$i]."\n");
    $currentY=$pdf->GetY();
    if($currentY>=256) {
        $tplidx = $pdf->ImportPage(2);
        $pdf->addPage();
        $page_no=$page_no+1;
        $pdf->useTemplate($tplidx);
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(114,265);
        $pdf->Cell(11,0,$page_no);
        $pdf->SetFont('Arial','U',9);
        $pdf->SetXY(105,16);
        $pdf->Cell(100,0,$name);
        $pdf->SetFont('Arial','',11);
        $ypos=20;
        $currentY=0;
    }
    else {
        $ypos=$currentY+2;
    }
}

$ypos=$ypos+$rowheight2;
$pdf->SetXY(15,$ypos);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(100,0,"C.  Research Support");
$ypos=$ypos+$rowheight2;
$status_check=0;
for($i=1;$i<=$count5;$i++) {
    $pdf->SetXY(15,$ypos);
    $newstatus=$status[$i];
    if($status_check!=$newstatus) {
        $pdf->SetFont('Arial','U',11);
        if($newstatus==1) {
            $title_r="Ongoing Research Support";
        }
        else {
            if($newstatus==2) {
                $title_r="Completed Research Support";
            }
            else {
                if($newstatus==3) {
                    $title_r="Pending Research Support";
                }
            }
        }
        $pdf->Cell(180,0,$title_r);
        $status_check=$newstatus;
        $pdf->SetFont('Arial','',11);
        $ypos=$ypos+$rowheight;
        $currentY=$pdf->GetY();
        if($currentY>=256) {
            $tplidx = $pdf->ImportPage(2);
            $pdf->addPage();
            $page_no=$page_no+1;
            $pdf->useTemplate($tplidx);
            $pdf->SetFont('Arial','',9);
            $pdf->SetXY(114,265);
            $pdf->Cell(11,0,$page_no);
            $pdf->SetFont('Arial','U',9);
            $pdf->SetXY(105,16);
            $pdf->Cell(100,0,$name);
            $pdf->SetFont('Arial','',11);
            $ypos=20;
            $currentY=0;
        }
        $pdf->SetXY(15,$ypos);
    }
    $durspon=$duration[$i]."     ".$spon[$i];
    $pdf->Cell(150,0,$durspon);
    $ypos=$ypos+2;
    $currentY=$pdf->GetY();
    if($currentY>=256) {
        $tplidx = $pdf->ImportPage(2);
        $pdf->addPage();
        $page_no=$page_no+1;
        $pdf->useTemplate($tplidx);
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(114,265);
        $pdf->Cell(11,0,$page_no);
        $pdf->SetFont('Arial','U',9);
        $pdf->SetXY(105,16);
        $pdf->Cell(100,0,$name);
        $pdf->SetFont('Arial','',11);
        $ypos=20;
        $currentY=0;
    }
    $pdf->SetXY(15,$ypos);
    $pdf->MultiCell(200,4,$title[$i]);
    $ypos=$ypos+6;
    $currentY=$pdf->GetY();
    if($currentY>=256) {
        $tplidx = $pdf->ImportPage(2);
        $pdf->addPage();
        $page_no=$page_no+1;
        $pdf->useTemplate($tplidx);
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(114,265);
        $pdf->Cell(11,0,$page_no);
        $pdf->SetFont('Arial','U',9);
        $pdf->SetXY(105,16);
        $pdf->Cell(100,0,$name);
        $pdf->SetFont('Arial','',11);
        $ypos=20;
        $currentY=0;
    }
    if($goal[$i]!='') {
        $pdf->Multicell(190,4,$goal[$i]."\n");
        $ypos=$ypos+$rowheight;
    }
    $currentY=$pdf->GetY();
    if($currentY>=256) {
        $tplidx = $pdf->ImportPage(2);
        $pdf->addPage();
        $page_no=$page_no+1;
        $pdf->useTemplate($tplidx);
        $pdf->SetFont('Arial','',11);
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(114,265);
        $pdf->Cell(11,0,$page_no);
        $pdf->SetFont('Arial','U',9);
        $pdf->SetXY(105,16);
        $pdf->Cell(100,0,$name);
        $ypos=20;
        $currentY=0;
    }
    $pdf->SetXY(15,$ypos);
    $pdf->Cell(100,0,"Role: ".$role[$i]);
    $ypos=$ypos+$rowheight2;
    $currentY=$pdf->GetY();
    if($currentY>=256) {
        $tplidx = $pdf->ImportPage(2);
        $pdf->addPage();
        $page_no=$page_no+1;
        $pdf->useTemplate($tplidx);
        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(114,265);
        $pdf->Cell(11,0,$page_no);
        $pdf->SetFont('Arial','U',9);
        $pdf->SetXY(105,16);
        $pdf->Cell(100,0,$name);
        $pdf->SetFont('Arial','',11);
        $ypos=20;
        $currentY=0;
    }
    $pdf->SetXY(15,$ypos);
}

//$tplidx = $pdf->ImportPage(2);
//$pdf->addPage();
//$pdf->useTemplate($tplidx);
//$pdf->SetFont('Arial','',11);
$pdf->Output("mybiosketch.pdf","D");
$pdf->closeParsers();
?>