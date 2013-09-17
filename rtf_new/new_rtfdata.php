<?php
include "rtf_class.php";
include "../utils.php";

$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_update_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
$pid = $_GET["pid"];
//$pid=1;
if($pid != "")
{
	//query and result set for general information
	$q1 = "SELECT * FROM ppl_general_info WHERE pid=". real_mysql_specialchars( $pid, false );
	$res1=real_execute_query($q1,$db_conn);
	$r1=mysql_fetch_array($res1);
	
	//query and result set for education
	$q2 = "SELECT * FROM ppl_prof_preparation WHERE pid=". real_mysql_specialchars( $pid, false);
	$res2=real_execute_query($q2,$db_conn);
	
	$q3 = "SELECT * FROM ppl_appointment WHERE pid=".real_mysql_specialchars( $pid, false )." ORDER BY s_date ASC, e_date ASC";
	$res3=real_execute_query($q3,$db_conn);
	
	$q4 = "SELECT * FROM ppl_publication WHERE pid=".real_mysql_specialchars( $pid, false)." ORDER BY year ASC";
	$res4=real_execute_query($q4,$db_conn);
	
	$q5 = "SELECT * FROM ppl_support WHERE pid=".real_mysql_specialchars($pid, false)." ORDER BY prj_status ASC";
	$res5=real_execute_query($q5,$db_conn);

        $q6="SELECT * FROM ppl_additional WHERE pid=".real_mysql_specialchars($pid, false)." ORDER BY add_id ASC";
        $res6=real_execute_query($q6,$db_conn);

         $q7="SELECT * FROM ppl_teaching WHERE pid=".real_mysql_specialchars($pid, false)." ORDER BY course_id ASC";
         $res7=real_execute_query($q7,$db_conn);
}
else
{
	exit();
}


$file_rtf = "vita.rtf";
Header("Content-type: application/octet-stream");


Header("Content-Disposition: attachment; filename=$file_rtf");
$rtf = new RTF("rtf_config.inc");

$text = "<footer><font size=8 color=#666666><b>Generated Using Research Profile </b>
		<a file=http://www.txstate.edu/research> http://www.txstate.edu/research</a></font></footer>";
$rtf->parce_html($text);


//displaying cirriculum vitae header and name details
$text = "<table border=0><tr><td bgcolor=#666666><b>CURRICULUM VITAE</b></td></tr></table><br>".
        "<table border=0><tr><td><b>".$r1['f_name'].		
        " ".$r1['m_name']." ".$r1['l_name'].
		"</b></td></tr> </table>";
		
$rtf->parce_html( $text);			

//displaying the designation
$text = "<p><table border=0><tr><td width=60%>".$r1['pri_designation']."</td><td rowspan=5></td></tr>
 							<tr><td>Texas State University - San Marcos</td><td></td></tr>
							<tr><td>Box ".$r1['mailbox'].", ".$r1['city'].", ".$r1['state']." ".$r1['zipcode']."</td><td></td></tr>
						 	<tr><td>Phone: ".$r1['phone_no_1'].", FAX: ".$r1['fax_no'].", Email: <a file=mailto:".$r1['email_id']."><font color=#0000ff>".$r1['email_id']."</font></a></td><td></td></tr>
						 	<tr><td>URL: <a file=".$r1['url_1']."><font color=#0000ff>".$r1['url_1']."</font></a></td><td></td></tr></table>";

$rtf->parce_html($text);

//displaying education information header
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Education</b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
while($r2=mysql_fetch_array($res2))
{
	$text = "<table border=0><tr><td width=50%>".$r2['institution'] ."</td><td width=10%>	".$r2['degree']."</td><td width=10%>".$r2['year']."</td><td align=right width=30%>".$r2['major']."</td></tr></table>" ;
	$rtf->parce_html($text);	
}


//displaying university experience information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>University Experience</b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
while($r3=mysql_fetch_array($res3))
{
	$text= "<table border=0><tr><td width=12%>".$r3['s_date'] ."</td><td width=12%>".$r3['e_date']."</td><td width=28%>".$r3['rank']."</td><td align=justify width=48%>".$r3['univ_comp']."</td></tr></table>";
	$rtf->parce_html($text);
}

//displaying the publications information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Publications</b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
$i=1;
while($r4=mysql_fetch_array($res4))
{	
	$text= "<table border=0><tr><td width=5%>".$i."."."</td><td align=justify>".strip_tags($r4['name'])."</td></tr><tr><td></td><td></td></tr></table>";
	$i=$i+1;
	$rtf->parce_html($text);
}
			
			
//displaying the grants information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Grants</b></td></tr></table>";
$rtf->parce_html($text);

// looping through the information
$test1 = true;
$test2 = true;
$test3 = true;
while($r5=mysql_fetch_array($res5))
{		
	if ($test1 == true && $r5['prj_status']==1 )
	{	$text = "<br><table border=0><tr><td bgcolor=#666666><b>Ongoing Grants</b></td></tr></table>";
		$rtf->parce_html($text);
		$test1 =false;
	}
	if ($test2 == true && $r5['prj_status']==2 )
	{	$text = "<br><table border=0><tr><td bgcolor=#666666><b>Completed Grants</b></td></tr></table>";
		$rtf->parce_html($text);
		$test2 = false;
		
	}
	if ($test3 == true && $r5['prj_status']==3 )
	{	$text = "<br><table border=0><tr><td bgcolor=#666666><b>Pending Grants</b></td></tr></table>";
		$rtf->parce_html($text);
		$test3 = false;
		
	}
	
	$text = "<table border=0><tr><td width=10%>Duration: </td><td>".$r5['s_date']." - ".$r5['e_date']."</td></tr>
							 <tr><td width=10%>Sponsor: </td><td>".$r5['sponsor']."</td></tr>
							 <tr><td width=10%>Title: </td><td>".$r5['title']."</td></tr>
							 </table><br>";
	$rtf->parce_html($text);
}
//displaying the teaching information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Teaching:</b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
$i=1;
while($r7=mysql_fetch_array($res7))
{
	$text= "<table border=0>
            <tr>
            <td width=5%>".$i."."."Course Title:</td>
            <td >".$r7['course_title']."</td>
                <td>Course Number:".$r7['course_number']."</td>
                <td>Semester:".$r7['semester'].$r7['year']."</td>
           </tr>
            <tr><td width=15%>Description: </td><td colspan=3>".$r7['description']."</td></tr>
                         </table><br><br>";
	$i=$i+1;
	$rtf->parce_html($text);
}
	//displaying the activities information
$text = "<br><table border=0><tr><td bgcolor=#666666><b>Activities:</b></td></tr></table>";
$rtf->parce_html($text);

//looping through the information
$i=1;
while($r6=mysql_fetch_array($res6))
{
	$text= "<table border=0>
            <tr>
            <td width=5%>".$i."."."Name:</td>
            
            <td align=justify>".strip_tags($r6['name'])."</td>
            </tr>
            <tr><td width=15%>Description: </td><td>".$r6['description']."</td></tr>
                         </table><br>";
	$i=$i+1;
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
						$title="Ongoing Grants";
					}
					else
					{
						if($status==2)
						{
							$title="Completed Grants";
						}
						else
						{
							if($status=3)
							{
								$title="Pending Grants";
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
			
		  }
                          $count7=0;
			 print "<table border=0>";
             print "<tr><td><font size='10'><b>";
		     print "TEACHING";
		     print "</b></font></td></tr>";
			 print "<tr><td></td></tr>";
			 print "</table><table border=0>";
			 while($r7=mysql_fetch_array($res7))
			 {
			   $count7=$count7+1;
        	   print "<tr><td width=8><b>";
			   print " $count7. ";
			   print "</b></td><td >";
			   print ($r7["course_title"]);
                           print "</td><td></td><td>";
                           print($r7["course_number"]);
                           print "</td><td></td><td>";
		           print $r7["semester"].$r7["year"];
			   print "</td></tr>";
                           print "<tr><td>";
                           print($r7["description"]);
			   print "</td></tr>";
                           print "<tr><td></td><td></td></tr><br>";
                           print "  ";
			 }// end of while

			  print "</table>";
			  if($count7>0)
			  {
                            
                                 print "/r/n";
			  	print "<br><br>";
			  }

                          $count6=0;
			 print "<table border=0>";
             print "<tr><td><font size='10'><b>";
		     print "ACTIVITIES";
		     print "</b></font></td></tr>";
			 print "<tr><td></td></tr>";
			 print "</table><table border=0>";
			 while($r6=mysql_fetch_array($res6))
			 {
			   $count6=$count6+1;
                         print "<br><br>";
        	   print "<tr><td width=8><b>";
			   print " $count6. ";
			   print "</b></td><td align=justify>";
			   print "".strip_tags($r6["name"])."";
			   print "</td></tr>";
                           print "<tr><td>";
                           print($r6["description"])."<br>";
				print "</td></tr>";
                          print "</td></tr>";
			   print "<tr><td></td><td></td></tr>";

			 }// end of while

			  print "</table>";
			  if($count6>0)
			  {
                              print "/r/n";
			  	print "<br><br>";
			  }
                         */
		  
$fin = $rtf->get_rtf();
echo $fin;
$fp = fopen($file_rtf, "w");
fwrite($fp, $fin);
@fclose($fp);

 ?>
