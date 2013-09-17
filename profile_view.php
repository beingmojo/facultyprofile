<?php
/*
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);
*/
session_start();
include_once 'urlLoad.php';
include_once 'utils.php';

$_POST['page-title'] = "Edit Profile";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-link4'] = "<link rel='icon' href='favicon.ico' type='image/ico' />";
$_POST['page-script1'] = "<script language='JavaScript' type='text/javascript' src='rteresources/html2xhtml.js'></script>";
$_POST['page-script2'] = "<script language='JavaScript' type='text/javascript' src='rteresources/richtext.js'></script>";
$_POST['page-script3'] = "<script language='JavaScript' type='text/javascript' src='scripts/section_and_menu.js'></script>";
$_POST['page-script4'] = "<script language='JavaScript' type='text/javascript' src='scripts/findprofile.js'></script>";

$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';

/*Variable initialization*/
if(!isset($_GET['pid'])) die();
$pid = $_GET['pid'];
$rawstring = $_GET['srch'];
$view = 0;
if(isset($_GET['view']))
    if($_GET['view'] == 1 || $_GET[''] == 2 || $_GET[''] == 3 || $_GET[''] == 4)
        $view = $_GET['view'];
    if($_GET['onlyview'] != "")
        $onlyview = "1";
$page = "https://researchprofiles.txstate.edu/editprofile.php?onlyview=$onlyview&pid=$pid&view=$view&pt=1";
$wds = explode(' ', $rawstring);

/*Function declaration*/

function hl($inp, $words){
    //this function will search the string(document) for words supplied in array as argument
    $replace=array_flip(array_flip($words)); // remove duplicates
    $pattern=array();
    foreach ($replace as $k=>$fword){
        $fword = preg_quote($fword);
        if(real_filter($fword) != ''){
            $pattern[]='/\b(' . real_filter($fword) . ')(?!>)\b/i'; //original regex--problems with matches within tags
            //$pattern[] = '/\b(' . real_filter($fword) . ')(?!(.*"))\b/i';
            $replace[$k]='<span class="highlight">$1</span>';
        }
    }
    return preg_replace($pattern, $replace, $inp);
}

/*page load*/
$result = load($page);

//print_r($result);
?>

<!-- <html>
    <head>-->
        <style>
            span.highlight{
                background-color: yellow;
            }
        </style>
<!--    </head>
    <body>
-->        
        <?php echo hl($result,$wds); //page processing ?>
<!--    </body>
</html> -->