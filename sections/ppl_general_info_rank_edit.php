<?php  
include '../utils.php';
session_start();
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);
//$gen_hierarchy_types_query = "SELECT hid, name, h1, h2, h3 FROM gen_hierarchy_types ORDER BY hid" ;
$gen_hierarchy_types_query = "SELECT hid, name, h1, h2, h3 FROM gen_hierarchy_types ORDER BY h1, h2, h3" ;
$gen_hierarchy_types_results = real_execute_query ( $gen_hierarchy_types_query, $db_conn );	
$gen_rank_types_query = "SELECT rank_id, rank FROM gen_rank_types ORDER BY rank" ;
$gen_rank_types_results = real_execute_query ( $gen_rank_types_query, $db_conn );	


$curr_rank = rawurldecode( $_GET["rank"] );
$curr_hid_list = rawurldecode( $_GET["hid"] );
$rank_type = $_GET["type"];
$record_no = $_GET["record"];
?>

<html>
<head>
<link href="../styles/style1.css" rel="stylesheet" type="text/css">

</head>

<body bgcolor="white">

<form name='ppl_general_info_rank_edit_form'>
<script type="text/javascript">

	function Trim(s) 
	{
		// Remove leading spaces and carriage returns
		while ((s.substring(0,1) == ' ') || (s.substring(0,1) == '\n') || (s.substring(0,1) == '\r'))
		{ s = s.substring(1,s.length); }
		
		// Remove trailing spaces and carriage returns
		while ((s.substring(s.length-1,s.length) == ' ') || (s.substring(s.length-1,s.length) == '\n') || (s.substring(s.length-1,s.length) == '\r'))
		{ s = s.substring(0,s.length-1); }
		
		return s;
	}

	function Done( rank_type, record_no )
	{
		if( rank_type == "Other" )
		{
			parent.ChangeRank(document.ppl_general_info_rank_edit_form.rank.value, document.ppl_general_info_rank_edit_form.hid_list.value, rank_type, record_no );		
		}
		else
		{
			ClearRank(rank_type);
			var rank = Trim(AddRank(3));
			if( rank != "" )
				parent.ChangeRank( rank, document.ppl_general_info_rank_edit_form.hid_list.value, rank_type, record_no );		
		}
	}
		
	function AddRank( type )
	{
		// type 1: Other Rank, Choose from the list
		// type 2: Other Rank, Enter new rank
		// type 3: Primary Rank, Choose from the list
		var desig="", dept="", desigtext="", depttext="", rank="";	
		if( type == 2 )
		{
			desigtext = Trim( document.ppl_general_info_rank_edit_form.ppl_general_info_designation_text.value );
			depttext = Trim( document.ppl_general_info_rank_edit_form.ppl_general_info_department_text.value );
		}
		if( type == 1 || type == 3 )
		{
			var desigval = document.ppl_general_info_rank_edit_form.ppl_general_info_designation.value; 
			var deptval = document.ppl_general_info_rank_edit_form.ppl_general_info_department.value;
			if( desigval != "" )
			{
				desig = desigval.split( "|"  );
				if( desig[1] != "" )
				{
					desigtext = desig[1];
				}
			}
				
	
			if( deptval != "" )
			{
				dept = deptval.split( "|" );
				if( dept[1] != "" )
				{
					depttext = dept[1];
				}
				if( dept[0] != "" && dept[0] != "0" )
				{
					if( document.ppl_general_info_rank_edit_form.hid_list.value == "" )
						document.ppl_general_info_rank_edit_form.hid_list.value = dept[0];
					else
						document.ppl_general_info_rank_edit_form.hid_list.value += "|" + dept[0];
				}
			}
		}
	
		rank = desigtext;
		if( desigtext != "" && depttext != "" )
			rank = rank + "-";
		rank = rank + depttext;
		
		if( type == 3 )
		{
			return rank;
		}
		else
		{
			if( document.ppl_general_info_rank_edit_form.rank.value != "" && rank != "" )
				document.ppl_general_info_rank_edit_form.rank.value = document.ppl_general_info_rank_edit_form.rank.value + ", ";
			document.ppl_general_info_rank_edit_form.rank.value = document.ppl_general_info_rank_edit_form.rank.value + rank;
			return document.ppl_general_info_rank_edit_form.rank.value;
		}
	}

	function ClearRank( rank_type )
	{
		if( rank_type == "Other" )
			document.ppl_general_info_rank_edit_form.rank.value = "";
		document.ppl_general_info_rank_edit_form.hid_list.value = "";
	}

</script>
<?php

	print( "<input type='hidden' name='hid_list' value='$curr_hid_list' />" );
	if( mysql_num_rows( $gen_hierarchy_types_results ) > 0 )
		mysql_data_seek( $gen_hierarchy_types_results, 0 );
	print( "<table width='100%'  cellspacing='0' cellpadding='2' id='ppl_general_info_rank_edit_box' >" );
		print( "<tr class='table_background'>" );
			print( "<td>" );
			print( "&nbsp;<span class='form_elements_section_header'>Choose from the existing list</span>" );
			print( "</td>" );
			if( $rank_type == "Other" )
			{
				print( "<td align='right'>" );
				print( "<a  onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='AddRank(1)'><img alt='add' border='0' src='../images/buttons/add.gif' > <span class='form_elements_section_action'>Add &nbsp;</span></a>" );							
				print( "</td>" );
			}			
		print( "</tr>" );

	print( "</table>" );
	
	print( "<table width='100%' cellspacing='0' border='1'>" );
		print( "<tr>" );
			print( "<td align='center' class='table_background_other'>" );
			print( "<span class='form_elements_text'>Designation</span>" );
			print( "</td>" );
			print( "<td align='center' class='table_background_other'>" );
			print( "<span class='form_elements_text'>Department</span>" );
			print( "</td>" );
		print( "</tr>" );

		print( "<tr>" );
			print( "<td align='center'>" );
			$size = $rank_type=="Other" ? 15 : 22;
			print( "<select name='ppl_general_info_designation' class='form_elements_edit' size='$size' style='width:300px'> " );
			$selected = "selected";
				while( $gen_rank_types_rows = mysql_fetch_array( $gen_rank_types_results) )
				{
					print( "<option value='" . $gen_rank_types_rows["rank_id"] . "|" . $gen_rank_types_rows["rank"] . "' $selected" );
					print( " > " );
					print( $gen_rank_types_rows["rank"] );
					$selected = '';
				}
			print( "</select>" );
			print( "</td>" );
		
			print( "<td align='center'>" );
			print( "<select  name='ppl_general_info_department' class='form_elements_edit' size='$size' style='width:300px'> " );
				$selected = 'selected';
				while( $gen_hierarchy_types_rows = mysql_fetch_array( $gen_hierarchy_types_results) )
				{
					print( "<option value='" . $gen_hierarchy_types_rows["hid"] . "|" . $gen_hierarchy_types_rows["name"] . "' $selected" );
					print( " > " );
					if( $gen_hierarchy_types_rows["h2"] != 0 )
						print( "&nbsp;&nbsp;&nbsp;" );
					if( $gen_hierarchy_types_rows["h3"] != 0 )
						print( "&nbsp;&nbsp;&nbsp;" );
					$selected = '';
					print( $gen_hierarchy_types_rows["name"] );
				}
			print( "</select>" );
			print( "</td>" );
		print( "</tr>" );
	print( "</table>" );

	if( $rank_type == "Other" )
	{
		print( "<table width='100%'  cellspacing='0' cellpadding='2' id='ppl_general_info_rank_edit_box' >" );
			print( "<tr><td height='10'></td></tr>" );
			print( "<tr>" );
				print( "<td class='table_background'>" );
				print( "&nbsp;<span class='form_elements_section_header'>Enter new rank if not found in the list</span>" );
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );

		print( "<table width='100%' cellspacing='0' border='0'>" );
			print( "<tr>" );
				print( "<td align='left'>" );
				print( "<span class='form_elements_text'>Designation<span>&nbsp;<input type='text' name='ppl_general_info_designation_text' value='' size='30'>" );
				print( "</td>" );
				print( "<td align='left'>" );
				print( "<span class='form_elements_text'>Department<span>&nbsp;<input type='text' name='ppl_general_info_department_text' value='' size='30'>" );
				print( "</td>" );
				print( "<td align='right'>" );
					print( "<a  onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='AddRank(2)'><img alt='add' border='0' src='../images/buttons/add.gif' > <span class='form_elements_row_action'>Add &nbsp;</span></a>" );							
				print( "</td>" );
			print( "</tr>" );
		print( "</table>" );
	}	
	print( "<table width='100%' cellspacing='0'>" );
		print( "<tr><td height='10'></td></tr>" );
		if( $rank_type == "Other" )
		{
			print( "<tr class='table_background_other'>" );
				print( "<td align='left' >" );
				print( "<span class='form_elements_text'>Rank<span>" );
				print( "&nbsp;<input type='text' name='rank' value='$curr_rank' size='70' maxlength='255' readonly>" );
				print( "</td>" );
				print( "<td align='right' >" );
				print( "<a  onmouseover='style.cursor=\"pointer\";style.cursor=\"hand\"' style='text-decoration:none' onclick='ClearRank(\"$rank_type\")'><img alt='cancel' border='0' src='../images/buttons/cancel.gif' > <span class='form_elements_row_action'>Clear &nbsp;</span></a>" );			
				print( "</td>" );
			print( "</tr>" );
			print( "<tr><td height='10'></td></tr>" );
		}
		print( "<tr><td colspan=2 align='right'>" );
			print( "<input type='button' name='ok' value='OK' onclick='Done( \"$rank_type\", \"$record_no\" )'>" );
			print( "<input type='button' name='cancel' value='Cancel' onclick='parent.CancelChangeRank(\"$rank_type\", \"$record_no\" )'>" );
		print( "</td></tr>" );

	print( "</table>" );

	
?>

</form>
</body>
</html>