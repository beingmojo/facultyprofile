<html>
<head>
	
<style type="text/css">
<!--
.calendar_title {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
	text-align: center;
	color:#FFFFFF;
}
.calendar_desc {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: normal;
	color:#FFFFFF;
}

-->
</style>
<link href="../css/main0905.css" rel="stylesheet" type="text/css">
<link href="../css/homepage.css" rel="stylesheet" type="text/css">
<link href="../css/gateway_rollover.css" rel="stylesheet" type="text/css">

</head>
<body>
<div id="leftcolumn">
<table width="100%" class="menulist" border="0" cellpadding="0" cellspacing="0" align="left"> 
<?php

class RSSParser {

   var $insideitem = false; 
   var $tag = ""; 
   var $title = ""; 
   var $description = ""; 
   var $link = ""; 
   var $calendar_result = array();
	 
/*
- <item rdf:about="https://www.uta.edu/events/main.php?view=event&calendarid=research&eventid=1128618812893">
  <link>https://www.uta.edu/events/main.php?view=event&calendarid=research&eventid=1128618812893</link> 
  <title>IACUC Meeting</title> 
  <description>10/12 All day: Animal Subjects</description> 
  </item>
  */

   function startElement($parser, $tagName, $attrs) { 
       if ($this->insideitem) { 
           $this->tag = $tagName; 
       } elseif ($tagName == "ITEM") { 
           $this->insideitem = true; 
       } 
   } 

   function endElement($parser, $tagName) {
       if ($tagName == "ITEM") { 
           //printf("<p><b><a href='%s'>%s</a></b></p>", 
           // trim($this->link),htmlspecialchars(trim($this->title))); 
           //printf("<p>%s</p>", 
           //  htmlspecialchars(trim($this->description))); 
					 /*
					 array_push($this->calendar_result,
					 htmlspecialchars(trim($this->title)),
					 htmlspecialchars(trim($this->description)),
					 trim($this->link)); */
//					    <td align = "left" valign="top"><img src="../images/vcalendar.gif" width="10" height="12"/></td>
					 echo('
					  <tr>
					    <td align = "left" class="calendar_desc" valign="top"><strong><a href="'.trim($this->link).'" target="_parent">'.htmlspecialchars(trim($this->title)).'</a></strong>'.htmlspecialchars(trim($this->description)).'<br><br></td>
					  </tr>
					  ');
           $this->title = ""; 
           $this->description = ""; 
           $this->link = ""; 
           $this->insideitem = false; 
       } 
   } 

   function characterData($parser, $data) { 
       if ($this->insideitem) { 
           switch ($this->tag) { 
               case "TITLE": 
               $this->title .= $data; 
               break; 
               case "DESCRIPTION": 
               $this->description .= $data; 
               break; 
               case "LINK": 
               $this->link .= $data; 
               break; 
           } 
       } 
   } 
} 

$xml_parser = xml_parser_create(); 
$rss_parser = new RSSParser(); 
//$this -> $xml_parser;
xml_set_object($xml_parser,$rss_parser); 
xml_set_element_handler($xml_parser, "startElement", "endElement"); 
xml_set_character_data_handler($xml_parser, "characterData"); 
$fp = fopen("http://www.uta.edu/events/export.php?type=rss1_0&calendar=research ","r ") 
   or die("Error reading RSS data."); 

while ($data = fread($fp, 4096)) 
   xml_parse($xml_parser, $data, feof($fp)) 
       or die(sprintf("XML error: %s at line %d",  
           xml_error_string(xml_get_error_code($xml_parser)),  
           xml_get_current_line_number($xml_parser))); 

		fclose($fp); 
		xml_parser_free($xml_parser);

?>
   
</table>
</div>
</body>
</html>