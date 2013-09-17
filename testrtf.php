<?php
// Example use
include "./rtf_new/rtf_class.php";
include "utils.php";

//retrieve form elements
//----------------------
$f_name=real_unescape($_POST['f_name']);
$l_name=real_unescape($_POST['l_name']);
$m_name=real_unescape($_POST['m_name']);
$designation=real_unescape($_POST['designation']);
$mbox=real_unescape($_POST['mbox']);
$city=real_unescape($_POST['city']);
$state=real_unescape($_POST['state']);
$zipcode=real_unescape($_POST['zipcode']);
$phone=real_unescape($_POST['phone']);
$fax=real_unescape($_POST['fax']);
$email=real_unescape($_POST['email']);
$url=real_unescape($_POST['url']);
$image_id=real_unescape($_POST['image']);

$count2 = real_unescape($_POST['count2']);
for($i=1;$i<=$count2;$i++) {
    $fieldname = 'inst_loc_'.$i;
    $inst_loc[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'degree_'.$i;
    $degree[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'year_'.$i;
    $year[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'major_'.$i;
    $major[$i] = real_unescape($_POST[$fieldname]);
}
$count3 = real_unescape($_POST['count3']);
for($i=1;$i<=$count3;$i++) {
    $fieldname = 's_date_'.$i;
    $s_date[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'e_date_'.$i;
    $e_date[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'rank_'.$i;
    $rank[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'inst_'.$i;
    $inst[$i] = real_unescape($_POST[$fieldname]);
   }
$count4 = real_unescape($_POST['count4']);
for($i=1;$i<=$count4;$i++) {
    $fieldname = 'pub_'.$i;
    $pub[$i] = real_unescape($_POST[$fieldname]);
}
$count5 = real_unescape($_POST['count5']);
for($i=1;$i<=$count5;$i++) {
    $fieldname = 'duration_'.$i;
    $duration[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'spon_'.$i;
    $spon[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'title_'.$i;
    $title[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'goal_'.$i;
    $goal[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'role_'.$i;
    $role[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'status_'.$i;
    $status[$i] = real_unescape($_POST[$fieldname]);
}
$count7= real_unescape($_POST['count7']);
   for($i=1;$i<=$count7;$i++) {
    $fieldname = 'course_title_'.$i;
    $course_title[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'course_number_'.$i;
    $course_number[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'sem_'.$i;
    $sem[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'desc_'.$i;
    $desc[$i] = real_unescape($_POST[$fieldname]);
    }
  $count6= real_unescape($_POST['count6']);
   for($i=1;$i<=$count6;$i++) {
    $fieldname = 'nm_'.$i;
    $nm[$i] = real_unescape($_POST[$fieldname]);
    $fieldname = 'descrip_'.$i;
    $descrip[$i] = real_unescape($_POST[$fieldname]);
        }
//---------------------
//end of retreival

//procesesing on form elements
$name=$l_name.", ".$f_name." ".$m_name;
//end of processing

$file_rtf = "Cvita.rtf";
Header("Content-type: application/octet-stream");


Header("Content-Disposition: attachment; filename=$file_rtf");
$rtf = new RTF("./rtf_new/rtf_config.inc");

$text = "<footer><font size=8 color=#666666><b>Generated Using Research Profile </b><a file=http://www.txstate.edu/research> http://www.txstate.edu/research</a></font></footer>";
$rtf->parce_html($text);


//displaying cirriculum vitae header and name details
$text = "<table border=0><tr><td bgcolor=#666666><b>CURRICULUM VITAE</b></td></tr></table><br>".
        "<table border=0><tr><td><b>".$f_name.
        " ".$m_name." ".$l_name.
        "</b></td></tr> </table>";

$rtf->parce_html( $text);			

//displaying the designation
$text = "<p><table border=0><tr><td width=60%>".$designation."</td><td rowspan=5></td></tr>
							<tr><td>Texas State University - San Marcos</td><td></td></tr>
							<tr><td>Box ".$mbox.", ".$city.", ".$state." ".$zipcode."</td><td></td></tr>
						 	<tr><td>Phone: ".$phone.", FAX: ".$fax.", Email: <a file=mailto:".$email."><font color=#0000FF>".$email."</font></a></td><td></td></tr>
						 	<tr><td>URL: <a file=".$url."><font color=#0000FF>".$url."</font></a></td><td></td></tr></table>";

$rtf->parce_html($text);

//displaying education information header
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Education</b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
for($i=1;$i<=$count2;$i++) {
    $text = "<table border=0><tr><td width=50%>".$inst_loc[$i] ."</td><td width=10%>	".$degree[$i]."</td><td width=10%>".$year[$i]."</td><td align=right width=30%>".$major[$i]."</td></tr></table>" ;
    $rtf->parce_html($text);
}

//displaying university experience information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>University Experience</b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
for($i=1;$i<=$count3;$i++) {
    $text= "<table border=0><tr><td width=12%>".$s_date[$i] ."</td><td width=12%>".$e_date[$i]."</td><td width=28%>".$rank[$i]."</td><td align=justify width=48%>".$inst[$i]."</td></tr></table>";
    $rtf->parce_html($text);
}

//displaying the publications information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Publications</b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
for($i=1;$i<=$count4;$i++) {
    $text= "<table border=0><tr><td width=5%>".$i."."."</td><td align=justify>".strip_tags($pub[$i])."</td></tr><tr><td></td><td></td></tr></table>";
    $rtf->parce_html($text);
}

//displaying the research support information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Grants</b></td></tr></table>";
$rtf->parce_html($text);

// looping through the information
$test1 = true;
$test2 = true;
$test3 = true;
for($i=1;$i<=$count5; $i++) {
    if ($test1 == true && $status[$i]==1 ) {
        $text = "<br><table border=0><tr><td bgcolor=#666666><b>Ongoing Grants</b></td></tr></table>";
        $rtf->parce_html($text);
        $test1 =false;
    }
    if ($test2 == true && $status[$i]==2 ) {
        $text = "<br><table border=0><tr><td bgcolor=#666666><b>Completed Grants</b></td></tr></table>";
        $rtf->parce_html($text);
        $test2 = false;

    }
    if ($test3 == true && $status[$i]==3 ) {
        $text = "<br><table border=0><tr><td bgcolor=#666666><b>Pending Grants</b></td></tr></table>";
        $rtf->parce_html($text);
        $test3 = false;

    }

    $text = "<table border=0><tr><td width=10%>Duration: </td><td>".$duration[$i]."</td></tr>
							 <tr><td width=10%>Sponsor: </td><td>".$spon[$i]."</td></tr>
							 <tr><td width=10%>Title: </td><td>".$title[$i]."</td></tr>
							 <tr><td width=10%>Goal: </td><td>".$goal[$i]."</td></tr>
							 <tr><td width=10%>Role: </td><td>".$role[$i]."</td></tr></table><br>";
    $rtf->parce_html($text);
}

//displaying the teaching information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Teaching:</b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
for($i=1;$i<=$count7;$i++) {
    $text= "<table border=0>
        <tr><td width=8%>Course Name:</td><td>".$course_title[$i] ."</td></tr>
        <tr><td width=10%>Course Number: </td><td >".$course_number[$i]."</td></tr>
            <tr><td width=8%>Semester:</td><td>".$sem[$i]."</td></tr>
                <tr><td  width=15%>Description:</td><td>".$desc[$i]."</td></tr></table><br>";
    $rtf->parce_html($text);
}

	//displaying the activities information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Activities:</b></td></tr></table><br>";
$rtf->parce_html($text);

//looping through the information
for($i=1;$i<=$count6;$i++) {
    $text= "<table border=0>
        <tr><td width=12%>Name:</td><td>".$nm[$i] ."</td></tr>
        <tr><td width=15%>Description:</td><td>".$descrip[$i]."</td></tr></table>";
    $rtf->parce_html($text);
}


/*$rtf->setPaperSize(5);

$rtf->setAuthor("Sailaja Vellanki");
$rtf->setOperator("sailaja@txstate.edu");
$rtf->setTitle("RTF Document");
$rtf->addColour("#000000");
$rtf->addText($_POST['text']);
$rtf->getDocument(); */

$fin = $rtf->get_rtf();
echo $fin;
$fp = fopen($file_rtf, "w");
fwrite($fp, $fin);
@fclose($fp);

?>			