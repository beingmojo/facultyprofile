<?php

//calling rtf classes
include "rtf_class.php";
include "../utils.php";

//***********************************************************************************************

//databse connection information
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

//***********************************************************************************************

$pid = $_GET["pid"];  //getting the pid information
//$pid=1;

if($pid != "")
{
	//query and result set for general information
	$q1 = "SELECT * FROM ppl_general_info WHERE pid=". real_mysql_specialchars( $pid, false );
	$res1=real_execute_query($q1,$db_conn);
	$r1=mysql_fetch_array($res1);
	
	//query and result set for education/training
	$q2 = "SELECT * FROM ppl_prof_preparation WHERE pid=". real_mysql_specialchars( $pid, false);
	$res2=real_execute_query($q2,$db_conn);
	
	$q3 = "SELECT * FROM ppl_appointment WHERE pid=".real_mysql_specialchars( $pid, false )." ORDER BY s_date DESC, e_date DESC";
	$res3=real_execute_query($q3,$db_conn);
	
	$q4 = "SELECT * FROM ppl_publication WHERE pid=".real_mysql_specialchars( $pid, false)." ORDER BY year DESC";
	$res4=real_execute_query($q4,$db_conn);
	
	$q5 = "SELECT * FROM ppl_support WHERE pid=".real_mysql_specialchars($pid, false)." ORDER BY prj_status ASC";
	$res5=real_execute_query($q5,$db_conn);
}
else
{
	exit();
}


$file_rtf = "biosketch.rtf";
Header("Content-type: application/octet-stream");


Header("Content-Disposition: attachment; filename=$file_rtf");
$rtf = new RTF("rtf_config.inc");

//adding header to pages
$text = "<header><font size=9 face=arial>Principal Investigator/Program Director (Last, First, Middle):</font><font size=10 face=arial> ".  $r1['l_name']." ".$r1['f_name']." ".$r1['m_name']."</font><hr></header>";
$rtf->parce_html($text);


//adding footer to pages
$text = "<footer><hr><table width=100% border=0><tr><td width=20% valign=bottom align=left><font size=9 face=arial>PHS 398 (Rev 07/19)</font></td><td width=50% valign=bottom align=center><font size=9 face=arial>Page <b><u><cpagenum></u></b></font></td><td align=right valign=bottom><b><font size=9 face=arial>Biographical Sketch Format Page</font></b></td></tr></table></footer>";
$rtf->parce_html($text);


//displaying cirriculum vitae header and name details
$text = "<table border=b><tr><td align=center><font size=12 face=arial><b>Biographical Sketch</b></font><br><font size=8 face=arial>Provide the following information for the key personnel and other significant contributors in the order listed on Form page 2.<br>Follow the format for each person. <b>DO NOT EXCEED FOUR PAGES.</b></font></td></tr></table>";
$rtf->parce_html( $text);

$text = "<p><table border=t width=100%>
			<tr>
 				<td align=left width=50% border=t,r,b><font size=9 face=arial>  NAME</font><br><b>  ".$r1['f_name'].		
        " ".$r1['m_name']." ".$r1['l_name'].
		"</b></td>
				<td rowspan=2 border=t,b><font size=9 face=arial>  POSITION TITLE</font><br><b>  ".$r1['pri_designation']."</b></td>
			</tr>
			<tr>
				<td border=r,b><font size=9 face=arial>  eRA COMMONS USER NAME</font><br><b>  ".$r1['f_name']."</b></td>
				<td></td>
			</tr>
			<tr>
				<td valign=middle colspan=2 border=b><font size=9 face=arial>  EDUCATION/TRAINING </font><font size=8 face=arial>(Begin with baccalauureate or other professional education, such as nursing, and include postdoctoral training.)</font></td>
				
			</tr>
			</table>
			<table width=100% border=0>
			<tr>
				<td align=center border=r,b width=40% valign=middle><font size=9 face=arial>INSTITUTION AND LOCATION</font></td>
				<td align=center border=r,b width=15% valign=middle><font size=9 face=arial>DEGREE</font><br><font size=8 face=arial>(if applicable)</font></td>
				<td align=center border=r,b width=15% valign=middle><font size=9 face=arial>YEAR(s)</font></td>
				<td align=center border=b valign=middle><font size=9 face=arial>FIELD OF STUDY</font></td>
			</tr></table>";

$rtf->parce_html($text);
			
			//looping through the information
while($r2=mysql_fetch_array($res2))
{
	$text = "<table border=0 width=100%>
			 <tr>
			 	<td width=40%  valign=middle align=left border=r>  ".$r2['institution'] ."</td>
				<td width=15%  valign=middle align=left border=r>  ".$r2['degree']."</td>
				<td width=15%  valign=middle align=left border=r>  ".$r2['year']."</td>
				<td align=left>  ".$r2['major']."</td>
			 </tr></table>" ;
	$rtf->parce_html($text);	
}

$text= "<table border=0 width=100%>
		<tr>
			<td width=40% align=center border=r></td>
			<td width=15% align=center border=r></td>
			<td width=15% align=center border=r></td>
			<td align=center ></td>
		</tr>
		<tr>
			<td width=40% align=center border=r,b></td>
			<td width=15% align=center border=r,b></td>
			<td width=15% align=center border=r,b></td>
			<td align=center border=b></td>
		</tr>
		</table>";

$rtf->parce_html( $text);			


//diaplaying positions and honors information
$text = "<br><table border=0><tr><td><b>A. Positions and Honors</b></td></tr>
							 <tr><td></td></tr>
							 <tr><td><b><u>Positions and Employment</u></b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
while($r3=mysql_fetch_array($res3))
{
	$text= "<table border=0><tr><td width=15% align=left>".$r3['s_date'] ." - ".$r3['e_date']."</td><td align=left>".$r3['rank'].",</b> Department of ".$r3['dept_school'].", ".$r3['univ_comp'].". "."</td></tr></table>";
	$rtf->parce_html($text);
	
}


//displaying the publications information
$text = "<br><table border=0><tr><td><b>B. Publications</b></td></tr></table><p>";
$rtf->parce_html($text);

//looping through the information
$i=1;
while($r4=mysql_fetch_array($res4))
{	
		$text= "<table border=0><tr><td><b>".$i.".     </b>".strip_tags($r4['name'])."</td></tr></table>";
		$i=$i+1;
		$rtf->parce_html($text);
	
}
	
//displaying the research support information
$text = "<br><table border=0><tr><td><b>C. Research Support</b></td></tr></table>";
$rtf->parce_html($text);

// looping through the information
$test1 = true;
$test2 = true;
$test3 = true;
while($r5=mysql_fetch_array($res5))
{		
	if ($test1 == true && $r5['prj_status']==1 )
	{	$text = "<br><table border=0><tr><td><b><u>Ongoing Research Support</u></b></td></tr></table>";
		$rtf->parce_html($text);
		$test1 =false;
	}
	if ($test2 == true && $r5['prj_status']==2 )
	{	$text = "<br><table border=0><tr><td><b><u>Completed Research Support</u></b></td></tr></table>";
		$rtf->parce_html($text);
		$test2 = false;
		
	}
	if ($test3 == true && $r5['prj_status']==3 )
	{	$text = "<br><table border=0><tr><td><b><u>Pending Research Support</u></b></td></tr></table>";
		$rtf->parce_html($text);
		$test3 = false;
		
	}
	
	$text = "<table border=0><tr><td width=10%>Duration: </td><td>".$r5['s_date']." - ".$r5['e_date']."</td></tr>
							 <tr><td width=10%>Sponsor: </td><td>".$r5['sponsor']."</td></tr>
							 <tr><td width=10%>Title: </td><td>".$r5['title']."</td></tr>
							 </table><br>";
	$rtf->parce_html($text);
}
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
