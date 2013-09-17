<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $pattern = "test-90-test";
        $replacement = ")";
        $string = "test-90-test always";
        $a = eregi_replace  ($pattern , $replacement, $string );
        echo $a;
        ?>
    </body>
</html>
