<?php
/*
<font size="1" face="Verdana, Arial, Helvetica, sans-serif">
<a href="" id="previous">previous</a> | <a href="" id="more">more</a> | <a href="" id="next">next</a>
</font><br><br>
<img src="">
<br>
<b>
//Professor Name goes here
<br>
Research Summary:</b>
<br>
//Research Summary goes here
*/
?>
<?php
include 'utils.php';

function formatRTEOutput($output)
{
	$formatted = $output;
	$formatted = strip_tags($formatted);
	$formatted = preg_replace("/&[\\w]+;/", "", $formatted);
	$formatted = htmlspecialchars($formatted);
	
	return $formatted;
}

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
$q_image="SELECT DISTINCT T1.pid, T1.section_id, T1.image_id, T2.name, T2.type_id, T2.status FROM gen_image_info T1, gen_profile_info T2 " .
	   "WHERE T1.section_id = 0 AND T1.pid=T2.pid AND T1.pid <> 2 AND T2.status=0";
$r_image=real_execute_query($q_image,$db_conn);
$i=1;
while($row=mysql_fetch_row($r_image))
{
	$name[$i]=$row[0]."_".$row[1]."_".$row[2];
	$text_display[$i]=$row[3];
	$pid_store[$i]=$row[0];
	$text_research[$i]="";	
	
	//$row[4] points to the type_id field in the database.
	// Get the rest of the details based on which profile we're getting!!
	if($row[4]==1) // the profile is of "Faculty"
	{
		$q_research="SELECT name, description FROM ppl_research WHERE pid=".$row[0]." LIMIT 0,3";
		$q_desig = "SELECT designation FROM ppl_general_info WHERE pid=".$row[0];
		$r_research=real_execute_query($q_research, $db_conn);
		$result_desig = real_execute_query($q_desig, $db_conn);
	
		while($row_desig = mysql_fetch_array($result_desig))
			$designation[$i]= htmlspecialchars($row_desig["designation"]);
		
		while($r_r = mysql_fetch_array($r_research))
		{
			if($text_research[$i] != "")
				$text_research[$i] = $text_research[$i] . "<br>";
			$text_research[$i] = $text_research[$i] . htmlspecialchars(trim($r_r["name"]));
		}
		if($text_research[$i] != "")
		{
			$text_research[$i] = "<div style=\"font-weight:bold \">Research Summary: </div>" .
				$text_research[$i];
		}
                if (trim($row_descr["description"]) == "")
		{
			$text_research[$i] = "";
		}
		else
		{
			$text_research[$i] = "<div style=\"font-weight:bold \">About: </div><BR>";
			$text_research[$i].= formatRTEOutput(trim($row_descr["description"]));
		}
	}
	else if($row[4]==2)  // profile is of "Research Center"
	{
		$q_descr = "SELECT description FROM ctr_info WHERE pid=".$row[0];
		$result_descr = real_execute_query($q_descr, $db_conn);
		$row_descr = mysql_fetch_array($result_descr);
				
		if (trim($row_descr["description"]) == "")
		{
			$text_research[$i] = "";
		}
		else
		{
			$text_research[$i] = "<div style=\"font-weight:bold \">About: </div><BR>";
			$text_research[$i].= formatRTEOutput(trim($row_descr["description"]));
		}
	}
	else if($row[4]==3) // profile is of "Technology"
	{
		$q_descr = "SELECT description FROM tech_abstract WHERE pid=".$row[0];
		$result_descr = real_execute_query($q_descr, $db_conn);
		$row_descr = mysql_fetch_array($result_descr);
		
		if (trim($row_descr["description"]) == "")
		{
			$text_research[$i] = "";
		}
		else
		{
			$text_research[$i] = "<div style=\"font-weight:bold \">Abstract: </div><BR>";
			$text_research[$i].= formatRTEOutput(trim($row_descr["description"]));
		}
	}
	else if($row[4]==4) // profile is of "Facility"
	{
		$q_descr = "SELECT description FROM fac_info WHERE pid=".$row[0];
		$result_descr = real_execute_query($q_descr, $db_conn);
		$row_descr = mysql_fetch_array($result_descr);
		if (trim($row_descr["description"]) == "")
		{
			$text_research[$i] = "";
		}
		else
		{
			$text_research[$i] = "<div style=\"font-weight:bold \">About: </div><BR>";
			$text_research[$i] .= formatRTEOutput(trim($row_descr["description"]));
		}
	}
	else if($row[4]==5) // profile is of "Equipment"
	{
		$q_descr = "SELECT description FROM eqp_info WHERE pid=".$row[0];
		$result_descr = real_execute_query($q_descr, $db_conn);
		$row_descr = mysql_fetch_array($result_descr);
		if (trim($row_descr["description"]) == "")
		{
			$text_research[$i] = "";
		}
		else
		{
			$text_research[$i] = "<div style=\"font-weight:bold \">Description: </div><BR>";
			$text_research[$i] .= formatRTEOutput(trim($row_descr["description"]));
		}
	}
		
	if(strlen($text_research[$i])>280)
		$text_research[$i]=substr($text_research[$i],0,220)."....";
	else
		while(strlen($text_research[$i])<=180)
			$text_research[$i]=$text_research[$i]."&nbsp;";
	$i++;
}
// language text for various areas...
$lang_back = "previous";
$lang_next = "next";
$lang_img_hover = "click to view profile...";
$lang_img_alt = "slideshow image";

$delay = 7;

################################################################################
// grab the variables we want set for newer php version compatability
$directory = "images/128";
$currentPic = $_GET['currentPic'];
$auto = 1;

// check for platform dependent path info... (for windows and mac OSX)
$path = $_SERVER['PHP_SELF'];

$template = implode("", file('template1.html'));

$header = "Research Showcase";
$title = "$header";

$back_src = "$lang_back";
$next_src = "$lang_next";

$dh = opendir( "$directory" );
$pic_info = array();
$time_info = array();
$text = array();
$pid = array();
$des = array();
for($j=1;$j<$i;$j++)
{
	$file=$name[$j].".jpg";
	$text[] = htmlspecialchars($text_display[$j]);
	$des[] = $designation[$j];
	$text_r[] = $text_research[$j];
	$pid[] = $pid_store[$j];
	$pic_info[] = $file;
}

// begin messing with the array
$number_pics = count ($pic_info);
if (($currentPic > $number_pics)||($currentPic == $number_pics)||!$currentPic)
	$currentPic = '0';
$item = explode (";", rtrim($pic_info[$currentPic]));
$last = $number_pics - 1;
$next = $currentPic + 1;
if ($currentPic > 0 ) $back = $currentPic - 1;
	else $currentPic = "0";


$blank = empty($item[1])?'&nbsp;':$item[1];

if ($currentPic > 0 ) $nav=$back;
else $nav=$last;

//$uri = $path."?directory=".$directory.$auto_url."&currentPic=".$next;

//$nav = "<a href='$path?directory=$directory&currentPic=$nav'>$back_src</a>";
$nav = "<span style='cursor:pointer;'  onclick='javascript:getContent(\"$path?directory=$directory&currentPic=$nav\")'>$back_src</span>";
$current_show = "$path?directory=$directory";
//$next_link = "<a href='$path?directory=$directory&currentPic=$next'>$next_src</a>";
$next_link = "<span style='cursor:pointer;'   onclick='javascript:getContent(\"$path?directory=$directory&currentPic=$next\")'>$next_src</span>";
$template = str_replace("<BACK>",$nav,$template);
$template = str_replace("<NEXT>",$next_link,$template);

$template = str_replace("<EXIF_COMMENT>",$text[$currentPic],$template);
$template = str_replace("<INTERESTS>",$text_r[$currentPic],$template);
$profile_link="<a href='editprofile.php?pid=".$pid[$currentPic]."&onlyview=1' target='_parent'>more</a>";
$template = str_replace("<LINK>",$profile_link,$template);

$image_title = "$item[1]";
$template = str_replace("<IMAGE_TITLE>",$image_title,$template);
$template = str_replace("<DESIGNATION>",$des[$currentPic],$template);

// {{{ ------- my_circular($a_images, $currentPic, $thumb_row);

function my_circular($thumbnail_dir, &$template, $a_images, $currentPic, $thumb_row, $directory) {
global $path;
global $auto_url;

// get size of $a_images array...
$number_pics = count($a_images);
// do a little error checking...
if ($currentPic > $number_pics) $currentPic = 0;
if ($currentPic < 0) $currentPic = 0;
if ($thumb_row < 0) $thumb_row = 1;

// check if thumbnail row is greater than number of images...
if ($thumb_row > $number_pics) $thumb_row = $number_pics;

// split the thumbnail number and make it symmetrical...
$half = floor($thumb_row/2);

// show thumbnails
// left hand thumbs
if (($currentPic - $half) < 0) { // near the start...
    $underage = ($currentPic-1) - $half; 
    for ( $x=($number_pics-abs($underage+1)); $x<$number_pics; $x++) {
        $next=$x;
        $item = explode (";", rtrim($a_images[$x]));
        $out .= "\n<a href='$path?directory=$directory$auto_url&currentPic=$next' class='thumbnail'><img border=0 src='$directory/$thumbnail_dir/".$item[0]."' class='thumbnail'></a>";
    }
    for ( $x=0; $x<$currentPic  ; $x++ ) {
        $next=$x;
        $item = explode (";", rtrim($a_images[$x]));
        $out .= "\n<a href='$path?directory=$directory$auto_url&currentPic=$next' class='thumbnail'><img border=0 src='$directory/$thumbnail_dir/".$item[0]."' class='thumbnail'></a>";
    }
}
else {
    for ( $x=$currentPic-$half; $x < $currentPic; $x++ ) {
        $next=$x;
        $item = explode (";", rtrim($a_images[$x]));
        $out .= "\n<a href='$path?directory=$directory$auto_url&currentPic=$next' class='thumbnail'><img border=0 src='$directory/$thumbnail_dir/".$item[0]."' class='thumbnail'></a>";
    }
}

// show current (center) image thumbnail...
$item = explode (";", rtrim($a_images[$currentPic]));
$out .= "\n<img border=0 src='$directory/$thumbnail_dir/".rtrim($item[0])."' class='thumbnail_center'>";

// array for right side...
if (($currentPic + $half) >= $number_pics) { // near the end
    $overage = (($currentPic + $half) - $number_pics);
    for ( $x=$currentPic+1; $x < $number_pics; $x++) {
        $next=$x;
        $item = explode (";", rtrim($a_images[$x]));
        $out .= "\n<a href='$path?directory=$directory$auto_url&currentPic=$next' class='thumbnail'><img border=0 src='$directory/$thumbnail_dir/".$item[0]."' class='thumbnail'></a>";
    }
    for ( $x=0; $x<=abs($overage); $x++) {
        $next=$x;
        $item = explode (";", rtrim($a_images[$x]));
        $out .= "\n<a href='$path?directory=$directory$auto_url&currentPic=$next' class='thumbnail'><img border=0 src='$directory/$thumbnail_dir/".$item[0]."' class='thumbnail'></a>";
    }
}
else {
    for ( $x=$currentPic+1; $x<=$currentPic+$half; $x++ ) {  // right hand thumbs
        $next=$x;
        $item = explode (";", rtrim($a_images[$x]));
        $out .= "\n<a href='$path?directory=$directory$auto_url&currentPic=$next' class='thumbnail'><img border=0 src='$directory/$thumbnail_dir/".$item[0]."' class='thumbnail'></a>";
    }
}
        $template = str_replace("<THUMBNAIL_ROW>",$out,$template);
}
        $auto_url = "&auto=1";
        //$meta_refresh = "<meta http-equiv='refresh' content='".$delay;
        //$meta_refresh .= ";url=".$path."?directory=".$directory.$auto_url."&currentPic=".$next."'>";
		$uri = $path."?directory=".$directory.$auto_url."&currentPic=".$next;
		$meta_referesh = "";
        $template = str_replace("<META_REFRESH>",$meta_refresh,$template);
        $auto_slideshow = "<a href='$path?directory=$directory&currentPic=$currentPic'>$lang_stop_slideshow</a>\n";
        $template = str_replace("<AUTO_SLIDESHOW_LINK>",$auto_slideshow,$template);

$images = "<a href='editprofile.php?pid=".$pid[$currentPic]."&onlyview=1' target='_parent'>";
$images .= "<img border=0 src='$directory/$item[0]' class='image' alt='$lang_img_alt' title='$lang_img_hover'></a>";
$template = str_replace("<IMAGE>",$images,$template);

if( file_exists( "$directory/$thumbnail_dir" ) ) { 
    my_circular($thumbnail_dir, $template, $pic_info, $currentPic, $thumb_row, $directory); 
}

$image_filename = "$item[0]";
$template = str_replace("<IMAGE_FILENAME>",$image_filename,$template);

echo $uri . "\n";
echo $template;
?>