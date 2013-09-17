<?php
//Added on April 30, 2009
ini_set('SMTP', 'smtp.txstate.edu');
ini_set('smtp_port', 25);
ini_set('sendmail_from', 'ospirb@txstate.edu');
$Name = "AVPR IRB"; //sender's name
$email = "ospirb@txstate.edu"; //sender's email adress
$headers = "From: ". $Name . " <" . $email . ">\r\n"; //header fields

$irbName = "TXState IRB"; //senders name
$irbemail = "ospirb@txstate.edu"; 
//$irbchairemail = "lasser@txstate.edu";
$irbchairemail = "es17@txstate.edu";

//senders e-mail adress
//$headers="From: ospirb@txstate.edu";
//$headers = "From: ". $irbName . " <" . $irbemail . ">\r\n";
$ospemail="ospirb@txstate.edu";
$ospcontact="sb45@txstate.edu";
//$emailSig=chr(13)."\r\r\nInstitutional Review Board".chr(13)."Office of Research Compliance".chr(13)."Texas State University-San Marcos".chr(13)."(ph) 512/245-2314 / (fax) 512/245-3847 / ospirb@txstate.edu".chr(13)."\rJCK 489".chr(13)."601 University Drive, San Marcos, TX 78666 ".chr(13)."\rTexas State University-San Marcos is a member of the Texas State University System".chr(13)."NOTE:  This email, including attachments, may include confidential and/or proprietary information and may be used only by the person or entity to which it is addressed. If the reader of this email is not the intended recipient or his or her agent, the reader is hereby notified that any dissemination, distribution or copying of this email is prohibited.  If you have received this email in error, please notify the sender by replying to this message and deleting this email immediately.  Unless otherwise indicated, all information included within this document and any documents attached should be considered working papers of this office, subject to the laws of the State of Texas.\r\r";


$emailSig = chr(13)."\r\r\n======================================\r\n"."\r\nInstitutional Review Board\r\n"."Office of Research Compliance"."\r\nTexas State University-San Marcos\r\n"."(ph) 512/245-2314 / (fax) 512/245-3847 / ospirb@txstate.edu / JCK 489\r\n"."601 University Drive, San Marcos, TX 78666\r\n"."\r\nTexas State University-San Marcos is a member of the Texas State University System\r\n"."NOTE:  This email, including attachments, may include confidential and/or proprietary information and may be used only by the person or entity to which it is addressed. If the reader of this email is not the intended recipient or his or her agent, the reader is hereby notified that any dissemination, distribution or copying of this email is prohibited.  If you have received this email in error, please notify the sender by replying to this message and deleting this email immediately.  Unless otherwise indicated, all information included within this document and any documents attached should be considered working papers of this office, subject to the laws of the State of Texas.\r\r";


$irbadd="http://www.osp.txstate.edu/irb/";
?>
