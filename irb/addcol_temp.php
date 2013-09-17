<?php require_once('Connections/dbc.php');

mysql_query("ALTER TABLE application ADD COLUMN appActionLog TEXT, ADD COLUMN irbActionLog TEXT, ADD COLUMN revActionLog TEXT"); 
echo "Updated";

?>

UPDATE `my_table` SET `my_field` = CONACT(`my_field`, ' append this');
UPDATE table SET field = CONCAT(COALESCE(field, ''), 'New Data') 