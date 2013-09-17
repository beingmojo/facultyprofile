<?php
// Example use
include("rtf_class.php");

$file_rtf = "Cvita.rtf";
Header("Content-type: application/octet-stream");

Header("Content-Disposition: attachment; filename=$file_rtf");

$rtf = new RTF("rtf_config.inc");

$page_orientation = "portrait";
$page_width=300;
$page_height=600;
$font_face = "arial";
$font_size = "20";
$rtf->parce_HTML($_POST['text']);

$fin = $rtf->get_rtf();
echo $fin;
$fp = fopen($file_rtf, "w");

fwrite($fp, $fin);
@fclose($fp);

/*$rtf->setPaperSize(5);

$rtf->setAuthor("Rajat Mittal");
$rtf->setOperator("rmittal@uta.edu");
$rtf->setTitle("RTF Document");
$rtf->addColour("#000000");
$rtf->addText($_POST['text']);
$rtf->getDocument(); */
?>