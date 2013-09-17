<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php



/* fix a date */  
function fix_date($date)   
{   
    $date = explode('-',str_replace('/','-',$date));    
    return $date[2].'-'.$date[0].'-'.$date[1];   
}  
?>
