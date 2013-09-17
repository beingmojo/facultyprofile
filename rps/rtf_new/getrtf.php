<?php
// Example use
include("rtf_class.php");

$rtf = new rtf("rtf_config.inc");
$page_numbers = 1;
$page_orientation = "portrait";
$font_face = "arial";
$font_size="12";

$rtf->setPaperSize(5);

/*$rtf->setAuthor("Rajat Mittal");
$rtf->setOperator("rmittal@uta.edu");
$rtf->setTitle("RTF Document");
$rtf->addColour("#000000");
$rtf->addText($_POST['text']);
$rtf->getDocument(); */
?>