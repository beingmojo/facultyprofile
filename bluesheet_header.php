<?
$order=1;
	if($_GET['submiton'])
	{		
		$order=1;
		if($_GET['submiton']==1)
		{
			$order=2;	
			$_SESSION['sort_orderby']="ASC";
		}
		else
		{
			$_SESSION['sort_orderby']="DESC";			
		}
		
			$_SESSION['sort_view']="bs_timestamp";
			
	}
	if($_GET['investigator'])
	{
		$order=1;
		if($_GET['investigator']==1)
		{
			$order=2;
			$_SESSION['sort_orderby']="ASC";
		}
		else
		{
			$_SESSION['sort_orderby']="DESC";
		}		
		
		$_SESSION['sort_view']="name";		
	}
	if(!$_SESSION['sort_view'])
	{
		$sort_view = "bs_timestamp";
		$_SESSION['sort_view']="bs_timestamp";
	}
	else
	 	$sort_view =$_SESSION['sort_view'];
?>		