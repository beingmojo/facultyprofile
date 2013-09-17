<?php
$_POST['page-title'] = "Admin";
$_POST['page-link1'] = "<link rel='icon' href='http:favicon.ico' type='image/ico' />";
$_POST['page-link2'] = "<link href='styles/main0905.css' rel='stylesheet' type='text/css'>";
include_once 'includes/page-top.php';
?>

<form action="admin_login.php" method="post" enctype="application/x-www-form-urlencoded" name="login" id="login">
    <div class="subtitle">
        <table  align="center" border="0" cellspacing="0" class="subtitle" cellpadding="5">
            <tr>
                <td>  TxState Net ID </td>
                <td><input name="uid" type="text" class="searchbox" id="uid" size="15" /></td>
            </tr>
            <tr>
                <td>  Password </td>
                <td><input name="passwd" type="password" class="form_elements_text" id="passwd" size="15" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align='right'><input type="submit" value='Login' /></td>
            </tr>
        </table>
    </div>
</form>
</body>
</html>