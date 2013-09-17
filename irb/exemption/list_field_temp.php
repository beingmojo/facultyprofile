<?php require_once('../Connections/con3.php'); ?>
<?php
  mysql_select_db($database_con3, $con3);

$fields = mysql_list_fields($database_con3, "continuation", $con3);

$columns = mysql_num_fields($fields);



for ($i = 0; $i < $columns; $i++) {

    echo mysql_field_name($fields, $i) . " ".mysql_field_type($fields, $i)."\n";;

}


?>
