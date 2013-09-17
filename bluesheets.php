<?

	include 'bluesheet/includes/bs_ldaputils.php';
	$main_view = $_GET['view'];
	$is_ogcs_admin = real_check_user_groupid( $db_conn, "ogcs_admin" );
	$is_dept_admin = real_check_dept_admin( $db_conn );
	
	echo "<table><tr style='font-size:11px'>";
	//if ( isOGCSSuperAdmin($_SESSION['UID']) )
	if ( $is_ogcs_admin )
	{
		echo "<td colspan='5' class='table_content' style='padding-left:20px;padding-right:20px;'>" . 
			"<a style='font-weight:bold' href=\"researchspace.php?view=$main_view&blue_view=1\">Routed Bluesheets</a></td>";
	}
	echo "<td colspan='5' class='table_content' style='padding-left:20px;padding-right:20px;'>" . 
		"<a style='font-weight:bold' href=\"researchspace.php?view=$main_view&blue_view=2\">Bluesheets For Review</a></td>";
	if ( isOGCSSuperAdmin($_SESSION['UID']) || $is_ogcs_admin )
	{
		echo "<td colspan='5' class='table_content' style='padding-left:20px;padding-right:20px;'>" . 
			"<a style='font-weight:bold' href=\"researchspace.php?view=$main_view&blue_view=3\">Completed Bluesheets</a></td>";
	}
	echo "<td colspan='5' class='table_content' style='padding-left:20px;padding-right:20px;'>" . 
		"<a style='font-weight:bold' href=\"researchspace.php?view=$main_view&blue_view=4\">My Bluesheets</a></td>";	
	if($is_dept_admin)
	{
		echo "<td colspan='5' class='table_content' style='padding-left:20px;padding-right:20px;'><a style='font-weight:bold' href=\"researchspace.php?view=$main_view&blue_view=5\">Department Bluesheets</a></td>";	
	}
	
	echo "<td rowspan='2' style='padding-left:20px;'><img src='images/arrow3_red.gif'></td><td rowspan='2' style='font-family:Tahoma;font-weight:bold;'> <span style='color:red;'> Improved/Faster View by Categories</span><br>Click on the sections listed to view Bluesheets in the different sections.</td>";
	echo "</tr><tr></tr></table>";
	
	if($_GET['blue_view']==null)
	{
            echo "hello";
		if($_SESSION['blue_view']==1)
		{
			include "bluesheet_routed.php";
		}
		else if	($_SESSION['blue_view']==2)
		{
			include "bluesheet_review.php";
		}
		else if($_SESSION['blue_view']==3)
		{
			include "bluesheet_completed.php";
		}
		else if($_SESSION['blue_view']==4)
		{
			include "bluesheet_my.php";
		}	
		else if($_SESSION['blue_view']==5)
		{
			include "bluesheets_dept.php";
		}
		else
		{
			if ( isOGCSSuperAdmin($_SESSION['UID']) )
			{
				$_SESSION['blue_view']=1;
				include "bluesheet_routed.php";
			}
			else if($is_ogcs_admin)
			{
				$_SESSION['blue_view']=2;
				include "bluesheet_review.php";
			}
			else if($is_dept_admin)
			{
				$_SESSION['blue_view']=5;
				include "bluesheets_dept.php";
			}		
			else
			{			
				$_SESSION['blue_view'] = 4;
				include "bluesheet_my.php";
			}	
		}
	}
	else
	{	
		if($_GET['blue_view']==1)
		{
			$_SESSION['blue_view']=1;
			include "bluesheet_routed.php";
		}
		else if	($_GET['blue_view']==2)
		{
			$_SESSION['blue_view']=2;
			include "bluesheet_review.php";
		}
		else if($_GET['blue_view']==3)
		{
			$_SESSION['blue_view']=3;		
			include "bluesheet_completed.php";
		}
		else if($_GET['blue_view']==4)
		{
			$_SESSION['blue_view']=4;		
			include "bluesheet_my.php";
		}	
		else if($_GET['blue_view']==5)
		{
			$_SESSION['blue_view']=5;		
			include "bluesheets_dept.php";
		}
		
	}
?>

