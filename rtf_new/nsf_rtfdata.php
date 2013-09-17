<?php

//calling rtf classes
include "rtf_class.php";
include "../utils.php";

//***********************************************************************************************

//databse connection information
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

//***********************************************************************************************
$selected = array();

if(isset($_GET['pid'])){
	$pid = $_GET['pid'];  //getting the pid information
}
elseif(isset($_POST['pid'])){
	$pid = $_POST['pid'];
	foreach($_POST as $name=>$value){
		if($name != 'pid'){
			if($value == 1){
				$selected[] = $name;
			}
		}
	}
}
$qry_selected = implode("','",$selected);
//$pid=1;

if($pid != "")
{
	//query and result set for general information
	$q1 = "SELECT * FROM ppl_general_info WHERE pid=". real_mysql_specialchars( $pid, false );
	$res1=real_execute_query($q1,$db_conn);
	$r1=mysql_fetch_array($res1);
	
	//query and result set for education/training
	$q2 = "SELECT * FROM ppl_prof_preparation WHERE pid=". real_mysql_specialchars( $pid, false)."ORDER BY year ASC";
	$res2=real_execute_query($q2,$db_conn);
	
//	$q3 = "SELECT * FROM ppl_appointment WHERE pid=".real_mysql_specialchars( $pid, false )." ORDER BY s_date DESC, e_date DESC";
	$q3 = "SELECT s_date, e_date, 
				CONCAT(rank, if(dept_school <> '',CONCAT(', ',dept_school),''), if(off_coll<>'',CONCAT(', ',off_coll),''), if(univ_comp<>'',CONCAT(',',univ_comp),'')) as position
			FROM ppl_appointment 
			WHERE pid=".real_mysql_specialchars( $pid, false )." ORDER BY s_date DESC, e_date DESC";	
	$res3=real_execute_query($q3,$db_conn);
	
	$q4 = "SELECT * FROM ppl_publication WHERE pid=".real_mysql_specialchars( $pid, false)." AND pub_id IN('$qry_selected') ORDER BY year DESC";
	$res4=real_execute_query($q4,$db_conn);
	
	$q5 = "SELECT * FROM ppl_activity WHERE pid=".real_mysql_specialchars($pid, false)." ORDER BY act_id ASC";
	$res5=real_execute_query($q5,$db_conn);
}
else
{
	exit();
}


$file_rtf = "Biographical_Sketch.rtf";
Header("Content-type: application/octet-stream;charset=UTF-8");


Header("Content-Disposition: attachment; filename=$file_rtf");
$rtf = new RTF("rtf_config.inc");

$text = "<footer><font size=8 color=#666666><b>Generated Using Research Profile </b>
		<a file=http://www.txstate.edu/research>http://www.txstate.edu/research</a></font></footer>";
$rtf->parce_html($text);


//displaying cirriculum vitae header and name details
$text = "<table border=0><tr><td align=center><b>Biographical Sketch".
        " - ".$r1['f_name'].		
        " ".$r1['m_name']." ".$r1['l_name'].
		"</b></td></tr></table>";
		
		
$rtf->parce_html( $text);			

//displaying the designation
$text = "<p><table border=0><tr><td align=center>".$r1['pri_designation']."</td></tr>
 							<tr><td align=center>Texas State University - San Marcos</td></tr>
							<tr><td align=center><a file=mailto:".$r1['email_id']."><font color=#0000ff>".$r1['email_id']."</font></a></td></tr>
						 	<tr><td align=center><a file=".$r1['url_1']."><font color=#0000ff>".$r1['url_1']."</font></a></td></tr></table><p>";


$rtf->parce_html($text);

//displaying Professional Presentation information header
$text = "<table border=0><tr><td><b>a.  Professional Preparation</b></td></tr></table><p>
<table border=1 bord_color=#CCCCCC width=98% align=right><tr><td align=left width=50%>Institution</td><td align=left width=10%>Degree</td><td align=left width=10%>Year</td><td align=left>Major</td></tr></table>";
$rtf->parce_html($text);

//looping through the information
while($r2=mysql_fetch_array($res2))
{
	$text = "<table border=1 bord_color=#CCCCCC width=98% align=right><tr><td width=50% align=left>".$r2['institution'] ."</td><td width=10% align=left>	".$r2['degree']."</td><td width=10% align=left>".$r2['year']."</td><td align=left width=30%>".$r2['major']."</td></tr></table>" ;
	$rtf->parce_html($text);	
}


//diaplaying positions and honors information
$text = "<br><table border=0><tr><td><b>b.  Appiontments</b></td></tr></table>";
$rtf->parce_html($text);

$i=1;
//looping through the information
while($r3=mysql_fetch_array($res3))
{
	$text= "<p><table border=0><tr><td width=6% align=center><b>".$i.".</b></td><td>".$r3['s_date'] ." - ".$r3['e_date'].",<b> ".$r3['position'].",</b></td></tr></table>";
	$rtf->parce_html($text);
	$i++;
	
}


//displaying the publications information
$text = "<br><table border=0><tr><td><b>c.  Publications</b></td></tr></table><p>";
$rtf->parce_html($text);

//looping through the information
$i=1;
while($r4=mysql_fetch_array($res4))
{	
	if($i < 11)
	{
		$text= "<table border=0><tr><td width=6% align=center><b>".$i.".</b>"."</td><td align=justify>".iconv("UTF-8","ISO-8859-1//TRANSLIT",strip_tags($r4['name']))."</td></tr><tr><td></td><td></td></tr></table>";
		$i=$i+1;
		$rtf->parce_html($text);
	}
}
			

//displaying the Synergistic activities information
$text = "<p><table border=0><tr><td><b>d.  Synergistic Activities</b></td></tr></table><p>";
$rtf->parce_html($text);

$j=1;
while($r5=mysql_fetch_array($res5))
{		
	if($j < 6)
	{
		$text= "<table border=0><tr><td width=6% align=center><b>".$j.".</b>"."</td><td align=justify><b>".$r5['name']." - </b>".strip_tags($r5['description'])."</td></tr><tr><td></td><td></td></tr></table>";
		$j=$j+1;
		$rtf->parce_html($text);
	}
	
}
	
//displaying the collaborators and other affiliations information
$text = "<p><table border=0><tr><td><b>e.  Collaborators & Other Affiliations</b></td></tr></table><p>";
$rtf->parce_html($text);
$text = "<p><table border=0><tr><td><b>(i)Collaborators</b></td></tr></table><p>";
$rtf->parce_html($text);
$text = "<p><table border=0><tr><td><b>(ii)Graduate and Postdoctoral Advisors</b><i>(List your own grad advisor(s), principal postdoctoral sponsor(s) & their current org affiliation)</i></td></tr></table><p>";
$rtf->parce_html($text);
$text = "<p><table border=0><tr><td><b>(iii)Thesis Advisor and Postgraduate-Scholar Sponsor</b></td></tr></table><p>";
$rtf->parce_html($text);


			/*$count3=0;
			while($r3=mysql_fetch_array($res3))
			 {
			   $count3=$count3+1;
			    print($r3["rank"]);
			   print " ";
			   print $r3["dept_school"];
			 
			   if($r3["dept_school"]!='')
			   	print ", ";
			   else 
			    print " ";
			   print $r3["off_school"];
			 
			   if($r3["off_school"]!='')
				print ", ";
			   else 
			   	print " ";
			   print($r3["univ_comp"]);
			   print " [ ";		
			   print($r3["s_date"]);
			   print " -  ";
			   print($r3["e_date"]);
			   print " ] ";  
			   print "</td></tr> <tr><td>";
			   
			  }
			 if($count3>0)
			 		print "</td></tr>";
			        print "</table><br>";
					
			$count2=0;
			print "<table border=0>";	
			while($r2 = mysql_fetch_array($res2))
			 {
			   $count2 = $count2+1;
			   
	    		print "<tr><td>";
				print($r2["institution"]);
				print " ";
				print($r2["degree"]);
				print " ";
				print($r2["year"]);
				print " ";
				print($r2["major"]);
				print "</td></tr>";
               
			  }
			     print "</table>";        
			  if($count2>0)
				print "<br><br> ";
			     
				
			 $count4=0;
			 print "<table border=0>";	
             print "<tr><td><font size='10'><b>";
		     print "PUBLICATIONS";
		     print "</b></font></td></tr>";
			 print "<tr><td></td></tr>";	
			 print "</table><table border=0>";
			 while($r4=mysql_fetch_array($res4))
			 {
			   $count4=$count4+1;
        	   print "<tr><td width=8><b>";
			   print " $count4. ";
			   print "</b></td><td align=justify>";
			   print "".strip_tags($r4["name"])."";
			   print "</td></tr>";
			   print "<tr><td></td><td></td></tr>";
			 }// end of while 
			 
			  print "</table>";
			  if($count4>0)
			  {
			  	print "<br>";
			  }
				
			 $count5=0;
			 $status=0;
			 while($r5=mysql_fetch_array($res5))
			 {
			   $count5=$count5+1;
			   $newstatus=$r5["prj_status"];
			   if($status!=$newstatus)
			   {
					$status=$newstatus;
					$subcount=$subcount+1;
					if($status==1)
					{	 
						$title="Ongoing Research Support";
					}
					else
					{
						if($status==2)
						{
							$title="Completed Research Support";
						}
						else
						{
							if($status=3)
							{
								$title="Pending Research Support";
         					}
						}
					}
					print "<table border=0>";	
                	print "<tr><td><font size='10'><b>";
					print $title;
					print "</b></font></td></tr>";
					print "<tr><td></td></tr></table>";
			   }
			   
			
			print "<table border=0>";	
            print "<tr><td align=justify width=8><b>$count5.</b></td>";
			print "<td align=justify>";
			print($r5["title"]);
			print($r5["prj_abstract"]);
			print " [ ";
			print($r5["s_date"]." - ".$r5["e_date"]);
			print " ] ";
			print($r5["sponsor"]);			
		    print $r5["prj_status"];
			print "</td> </tr><tr><td></td><td></td></tr></table>";
			
		  }*/
		  
$fin = $rtf->get_rtf();
echo $fin;
$fp = fopen($file_rtf, "w");
fwrite($fp, $fin);
@fclose($fp);

 ?>
