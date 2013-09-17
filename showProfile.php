<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include_once 'urlLoad.php';

function hl($inp, $words)
{
  $replace=array_flip(array_flip($words)); // remove duplicates
  $pattern=array();
  foreach ($replace as $k=>$fword) {
     $pattern[]='/\b(' . $fword . ')(?!>)\b/i';
     $replace[$k]='<span class="highlight">$1</span>';
  }
  return preg_replace($pattern, $replace, $inp);
}

//$options = array('return_info' => true);
//$result = load('https://researchprofiles.txstate.edu/editprofile.php?onlyview=1&pid=2979');
$pid = $_GET['pid'];
$view = $_GET['view'];
$result = load("https://researchprofiles.txstate.edu/editprofile.php?onlyview=$view&pid=$pid");
$wds = array("software","lopez","texas");

//print_r($result);

//phpinfo();
?>

<html>
    <head>
        <style>
            span.highlight{
                background-color: yellow;
            }
        </style>
    </head>
    <body>
        <?php print(hl($result,$wds)); ?>
    </body>
</html>
