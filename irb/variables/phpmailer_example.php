<?php 



// example on using PHPMailer with GMAIL 



include("class.phpmailer.php");

include("class.smtp.php");



$mail=new PHPMailer();



$mail->IsSMTP();

$mail->SMTPAuth = true; // enable SMTP authentication

$mail->SMTPSecure = "ssl"; // sets the prefix to the servier

$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server

$mail->Port = 465; // set the SMTP port 



$mail->Username = "yourname@gmail.com"; // GMAIL username

$mail->Password = "password"; // GMAIL password



$mail->From = "replyto@yourdomain.com";

$mail->FromName = "Webmaster";

$mail->Subject = "This is the subject";

$mail->Body = "Hi,<br>This is the HTML BODY<br>"; //HTML 
Body

$mail->AltBody = "This is the body when user views in plain text format"; 
//Text Body



$mail->WordWrap = 50; // set word wrap



$mail->AddAddress("username@domain.com","First Last");

$mail->AddReplyTo("replyto@yourdomain.com","Webmaster");

$mail->AddAttachment("/path/to/file.zip"); // attachment

$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); 
// attachment



$mail->IsHTML(true); // send as HTML



if(!$mail->Send()) {

echo "Mailer Error: " . $mail->ErrorInfo;

} else {

echo "Message has been sent";

}


