<?php
require_once('Connections/dbc.php'); 
require_once('variables/variables.php'); 
$Name = "OSP IRB"; //senders name
$email = "ospirb@txstate.edu"; //senders e-mail adress
$recipient = "yongxiaskadberg@yahoo.com"; //recipient
$mail_body = chr(13)."\r\r\nInstitutional Review Board".chr(13)."Office of Research Compliance".chr(13)."Texas State University-San Marcos".chr(13)."(ph) 512/245-2314 / (fax) 512/245-3847 / ospirb@txstate.edu".chr(13)."\rJCK 489".chr(13)."601 University Drive, San Marcos, TX 78666 ".chr(13)."\rTexas State University-San Marcos is a member of the Texas State University System".chr(13)."NOTE:  This email, including attachments, may include confidential and/or proprietary information and may be used only by the person or entity to which it is addressed. If the reader of this email is not the intended recipient or his or her agent, the reader is hereby notified that any dissemination, distribution or copying of this email is prohibited.  If you have received this email in error, please notify the sender by replying to this message and deleting this email immediately.  Unless otherwise indicated, all information included within this document and any documents attached should be considered working papers of this office, subject to the laws of the State of Texas.\r\r";



$subject = "Subject for reviever"; //subject
$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields

//ini_set('sendmail_from', 'ospirb@txstate.edu'); 

mail($recipient, $subject, $mail_body, $header); //mail command :)
?>

