<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //change this to your email.
        $to = "os1023@txstate.edu";
        $from = "os1023@txstate.edu";
        $subject = "Hello! This is HTML email";

        //begin of HTML message
        $message = <<<EOF
<html>
  <body bgcolor="#DCEEFC">
    <center>
        <b>Looool!!! I am reciving HTML email......</b> <br>
        <font color="red">Thanks Mohammed!</font> <br>
        <a href="http://www.maaking.com/">* maaking.com</a>
    </center>
      <br><br>*** Now you Can send HTML Email <br> Regards<br>MOhammed Ahmed - Palestine
  </body>
</html>
EOF;
        //end of message
        $headers  = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";

        //options to send to cc+bcc
        //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
        //$headers .= "Bcc: [email]email@maaking.cXom[/email]";

        // now lets send the email.
        if(mail($to, $subject, $message, $headers)) {
            echo "Message has been sent....!";
        }else {
            echo "Message not sent....!";
        }
        ?>
    </body>
</html>
