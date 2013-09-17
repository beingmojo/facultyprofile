<?php
ini_set('SMTP', 'smtp.txstate.edu');
ini_set('smtp_port', 25);
ini_set('sendmail_from', 'ospirb@txstate.edu');
$Name = "OSP IRB"; //sender's name
$email = "ospirb@txstate.edu"; //sender's email adress
$headers = "From: ". $Name . " <" . $email . ">\r\n"; //header fields
$recipient = "ssjsyx@gmail.com"; //recipient
$mail_body = chr(13)."\r\r\nInstitutional Review Board".chr(13)."\r\nOffice of Research Compliance".chr(13)."\r\nTexas State University-San Marcos".chr(13)."\r\n(ph) 512/245-2314 / (fax) 512/245-3847 / ospirb@txstate.edu".chr(13)."\r\nJCK 489".chr(13)."\r\n601 University Drive, San Marcos, TX 78666 ".chr(13)."\r\nTexas State University-San Marcos is a member of the Texas State University System".chr(13)."\r\nNOTE:  This email, including attachments, may include confidential and/or proprietary information and may be used only by the person or entity to which it is addressed. If the reader of this email is not the intended recipient or his or her agent, the reader is hereby notified that any dissemination, distribution or copying of this email is prohibited.  If you have received this email in error, please notify the sender by replying to this message and deleting this email immediately.  Unless otherwise indicated, all information included within this document and any documents attached should be considered working papers of this office, subject to the laws of the State of Texas.\r\n";


$subject = "SMTP test"; //subject

mail($recipient, $subject, $mail_body, $headers); //mail

$recipient = "yongxia_xia@yahoo.com"; //recipient
mail($recipient, $subject, $mail_body, $headers); //mail
?>

