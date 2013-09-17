<?php
session_start();
include_once 'securimage/securimage.php';   //CAPCHA library include
//validating code from capchta
$securimage = new Securimage();
if($securimage->check($_POST['captcha_code']) == FALSE){
    header("Location:feedback.php?role=$_POST[role]&fullname=$_POST[fullname]&email=$_POST[email]&rcomments=$_POST[comments]&status=1");
    exit();
}

$_POST['page-title'] = "Send Feed Back...";
$_POST['page-link1'] = "<link rel='stylesheet' type='text/css' href='styles/index.css' />";
$_POST['page-link2'] = "<link href='styles/style1.css' rel='stylesheet' type='text/css' />";
$_POST['page-link3'] = "<link href='styles/list.css' rel='stylesheet' type='text/css' />";
$_POST['page-include-page-top2'] = "true";
include_once 'includes/page-top.php';
include_once 'includes/page-top2.php';
include_once 'utils.php';

//IP Address track
function getIP(){
    $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else
        $ip = "UNKNOWN";
    return $ip;
}

//Original File Created by Rajat Mittal
//Comments: Receives form objects as XML http Post and send email
//Modified by Rajat Mittal Dec 21, 2006 based on Feedback from UT Pan American
$message = strip_tags(stripslashes($_POST['comments']));
$role = strip_tags(stripslashes($_POST['role']));
$fullname = strip_tags(stripslashes($_POST['fullname']));
$email = strip_tags(stripslashes($_POST['email']));
$ip = getIP();
$sent_message = "Name: " . $fullname . "\nRole: " . $role . "\nIP Address:" . $ip ."\nMessage:" . $message;

if($message == ""){
    real_redirect("feedback.php?comments=Message cannot be empty");
}

if ($email == "") {
    $email = "donotreply@txstate.edu";
}
$subject = "";
//changed from raweb@uta.edu to erahelpdesk@uta.edu by Rajat
//-----------------------------------------------------------------------
//Please change the email address here for the feedback form submission
//---------------------------------------------------------------------
//$raweb = "sailaja@txstate.edu";
$raweb = "oera@txstate.edu";
$subject = "Feedback from RPS";

$headers = 'From: ' . $email . "\r\n" . 'Reply-To: ' . $email . "\r\n" . 'X-Mailer: PHP/' . phpversion();
if (@mail($raweb, $subject, $sent_message, $headers)) {
    print "Thank you, Your message has been successfully received. The Research Web Service " .
        "Team will get in touch with you shortly to resolve the problem";
}else {
    print "<span style=\"color:red\">" .
        "An error was encountered and your feedback was not sent. Please contact the " .
        "Research Web Service Team directly at <a href=\"mailto:$raweb\">$raweb</a>." .
        "</span>";
}
?>
