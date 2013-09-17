<?
$results5 = real_execute_query($query, $db_conn);
		if (mysql_num_rows($results5) > 0)
		{
			while($rows5 = mysql_fetch_array($results5))
			{
				$no_rec = $rows5['no_rec'];
			}
		}				 
		if($no_rec > 15 )
		{
		echo "<span style=font-weight:bold;>Page&nbsp;";

			$currentpage = $page/15;
			echo $currentpage+1;
			
		echo "</span>&nbsp;&nbsp;";
			$count=0;
			$prev= $page-15;
			$next=$page+15;			
			echo "<a href='researchspace.php?view=$main_view&blue_view=$blue_view&page=0'><<</a>&nbsp;&nbsp;";
			echo "<a href='researchspace.php?view=$main_view&blue_view=$blue_view&page=$prev'><</a>&nbsp;&nbsp;";
			for($i=0;$i<$no_rec;$i=$i+15)
			{
							$count++;		
				if($page==$i)
					echo "$count&nbsp;&nbsp;";
				else
					echo "<a href='researchspace.php?view=$main_view&blue_view=$blue_view&page=$i'>$count</a>&nbsp;&nbsp;";		

			}
			$last=$i-15;
			if($next==$i)
				$next=$next-15;
			echo "<a href='researchspace.php?view=$main_view&blue_view=$blue_view&page=$next'>></a>&nbsp;&nbsp;";
			echo "<a href='researchspace.php?view=$main_view&blue_view=$blue_view&page=$last'>>></a>&nbsp;&nbsp;";
			
			
		}
		
?>