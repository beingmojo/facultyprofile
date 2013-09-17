<?php  
include '../utils.php';
session_start();
$_err_page = "../" . $_err_page;
$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
real_check_valid_session( $db_conn, $_SESSION['UID'], session_id(), $_SERVER['REMOTE_ADDR']);

$type = $_GET["type"];
$resultset = $_GET["resultset"] ;
$boxname = $_GET["boxname"];
$typename = $_GET["typename"];
$maxrows = $_GET["maxrows"];
$funcname = $_GET["funcname"];
$onlysearch = $_GET["onlysearch"] == 1 ? 1 : 0; // Default : Search and Return results
$pplsearchtype = ($_GET["pplsearchtype"] == 'list' || $_GET["pplsearchtype"] == 'dir') ? $_GET["pplsearchtype"] : 'list_and_dir' ; // Default : Search both profiles list and directory
$pplsearchtype = ($type == 'ppl' || $type == 'ppla' || $type == 'pplb' ) ? $pplsearchtype : '';
$nomanualentry = $_GET["nomanualentry"] == 1 ? 1 : 0; // Default: Allow manual entry
$changerank = $_GET["changerank"] == 1 ? 1 : 0; //Default: Do not allow to change rank 
?>

<html>
<head>
<link href="../styles/style1.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../scripts/browse_search_profile.js"></script>
<script language="JavaScript" type="text/javascript" src="../scripts/section_and_menu.js"></script>
<script language="JavaScript" type="text/javascript" src="../rteresources/html2xhtml.js"></script>
<script language="JavaScript" type="text/javascript" src="../rteresources/richtext.js"></script>

<script type="text/javascript">
initRTE("../rteresources/", "../rteresources/", "", true);
</script>
<?php
print( "<script type='text/javascript'>fpOnlySearch=$onlysearch</script>" );
?>
</head>

<body bgcolor="white">

<?php
print( "<table width='100%'  border='0' cellspacing='0' id='gen_find_profile_box' >" );
	print( "<tr>" );
		print( "<td>" );
			print( "<table width='100%' cellspacing='0'>" );
				print( "<form name='gen_find_profile_search_form' onSubmit='return fpSearch(\"$boxname\", \"$type\", \"$pplsearchtype\", $changerank, $maxrows, 1);'>" );
				print( "<tr class='table_background'>" );
					print( "<td>" );
					print( "&nbsp;<img alt='find' src='../images/icons/find.gif'>" );			
					if( $type == 'tech' || $type=='ctr' || $type=='eqp' || $type=='fac' || $type=='lab' )
					{
						print( "&nbsp;<span class='form_elements_section_header'>Name</span>" );
						print( "&nbsp;<input class='form_elements_edit' type='text' name='fullname' id='fullname' value='' size='80' />" );
					}
					if( $type == 'ppl' ||  $type == 'ppla' ||  $type == 'pplb' )
					{
						print( "&nbsp;&nbsp;<span class='form_elements_section_header'>Last Name</span>" );
						print( "&nbsp;<input class='form_elements_edit' type='text' name='lname' id='lname' value=''>" );
						print( "&nbsp;&nbsp;&nbsp;<span class='form_elements_section_header'>First Name</span>" );
						print( "&nbsp;<input class='form_elements_edit' type='text' name='fname' id='fname' value=''>" );
					}
					print( "</td>" );
					print( "<td align='right'>" );
					print( "<input type='submit' name='find' id='find' value='Search' >" );
					print( "</td>" );
				print( "</tr>" );
				if( ( $pplsearchtype == 'list_and_dir' ) && ( $type == 'ppl' ||  $type == 'ppla' ||  $type == 'pplb' ) )
				{
					print( "<tr>" );
						print( "<td class='form_elements_edit'>" );
						print( "<input type='radio' name='ppl_list_or_dir' id='ppl_profiles_list' CHECKED>" );
						print( "List of profiles in rSp" );
						print( "&nbsp;&nbsp;&nbsp;&nbsp;" );
						print( "<input type='radio' name='ppl_list_or_dir' id='ppl_user_dir' >" );
						print( "Complete Users directory (Limited to 500 records)" );
						print( "</td>" );
					print( "</tr>" );
				}
				print( "</form>" );			
			print( "</table>" );
		print( "</td>" );
	print( "</tr>" );
	print( "<tr>" );
		print( "<td align='center'>" );
		print( "<table id='" . $boxname . "_search_table' width='100%' border='1' cellspacing='0'>" );
			print( "<tr>" );
					print( "<td id='" . $boxname . "_search_table_footer' colspan='3'>&nbsp;</td>" );
			print( "</tr>" );

			print( "<tr id='" . $boxname . "_search_table_header' class='table_background_other'>" );
				print( "<td width='3%'><span class='form_elements_text'>No.</span></td>" );
				print( "<td align='center'><span class='form_elements_text'>$typename</span></td>" );
				if( $onlysearch != 1 )
					print( "<td width='3%'>&nbsp;</td>" );
			print( "</tr>" );
		print( "</table>" );
		print( "</span>" );
		print( "</td>" );
	print( "</tr>" );
	
	print( "<tr>" );
		print( "<td>" );
		print( "&nbsp;" );

		print( "</td>" );
	print( "</tr>" );
	if( $onlysearch != 1 )
	{
		if( $nomanualentry == 0 )
		{
			if( $type == 'eqp' || $type == 'lab' || $type=='ppl' || $type=='ppla' || $type == 'pplb' )
			{
				print( "<form name='gen_find_profile_entry_form' onSubmit='return fpAddManualEntry(\"$boxname\", \"$type\", \"$maxrows\" );'>" );
				print( "<tr>" );
					print( "<td>" );
					print( "<table width='100%' cellspacing='0'>" );
						print( "<tr class='table_background'>" );
							print( "<td align='left'>" );
								print( "&nbsp;<img alt='new' src='../images/icons/new.gif'>&nbsp;&nbsp;<span class='form_elements_section_header'>Enter New Information<span>" );
							print( "</td>" );
							print( "<td align='right'>" );
							print( "<input type='submit' name='gen_find_profile_add_manual' value='Add' >" );
							print( "</td>" );
						print( "</tr>" );
					print( "</table>" );
					print( "</td>" );				
				print( "</tr>" );
				if( $type == 'eqp' || $type == 'lab' )
				{
					print( "<tr>" );
						print( "<td align='left'>" );
						print( "<span class='form_elements_text'>Name</span> &nbsp; <input type='text' id='gen_find_profile_enter_name' value='' size='40'>" );
						print( "</td>" );
					print( "</tr>" );
					print( "<tr>" );
						print( "<td align='left'><span class='form_elements_text'>" );
						print( "<script language=\"JavaScript\" type=\"text/javascript\">" );
						print( "writeRichText('gen_find_profile_enter_description', 'gen_find_profile_enter_description', '', 600, 100, true, false, true);" );
						print( "</script>" );
						print( "</span></td>" );
					print( "</tr>" );
				}
				if( $type == 'ppl' || $type == 'ppla' || $type == 'pplb' )
				{
					print( "<tr>" );
						print( "<td >" );
						print( "<table width='100%' cellspacing='0' border='0' cellpadding='0'>" );
							print( "<tr >" );
								print( "<td><table width='100%' cellspacing='0' border='1'><tr>" );
								print( "<td><span class='form_elements_text'>Name</span></td>" );
								print( "<td><input class='form_elements_edit' type='text' name='gen_find_profile_enter_title' id='gen_find_profile_enter_title' value='' maxlength='8' size='5'><BR><span class='form_elements_row_action'>Title</span></td>" );
								print( "<td><input class='form_elements_edit' type='text' name='gen_find_profile_enter_lname' id='gen_find_profile_enter_lname' value='' maxlength='255' size='20'><BR><span class='form_elements_row_action'>Last Name</span></td>" );
								print( "<td><input class='form_elements_edit' type='text' name='gen_find_profile_enter_fname' id='gen_find_profile_enter_fname' value='' maxlength='255' size='20'><BR><span class='form_elements_row_action'>First Name</span></td>" );
								print( "<td><input class='form_elements_edit' type='text' name='gen_find_profile_enter_mname' id='gen_find_profile_enter_mname' value='' maxlength='255' size='20'><BR><span class='form_elements_row_action'>Middle Name</span></td>" );
								print( "</tr></table></td>" );
							print( "</tr>" );
							print( "<tr>" );
								print( "<td><table width='100%' cellspacing='0' border='1'>" );
								print( "<tr>" );
									print( "<td><span class='form_elements_text'>Rank</span>" );
									print( "<input type='hidden' name='gen_find_profile_enter_hid' id='gen_find_profile_enter_hid' value='' >" );
									print( "&nbsp;&nbsp;<input class='form_elements_edit' type='text' name='gen_find_profile_enter_rank' id='gen_find_profile_enter_rank' value='' maxlength='255' size='20'>" );
									print( "</td>" );
									if( $type == 'ppla' || $type=='pplb')
									{
										print( "<td><span class='form_elements_text'>Phone</span>" );
										print( "&nbsp;&nbsp;<input class='form_elements_edit' type='text' name='gen_find_profile_enter_phone' id='gen_find_profile_enter_phone' value='' maxlength='32' size='10'></td>" );
										print( "<td><span class='form_elements_text'>Email</span>" );
										print( "&nbsp;&nbsp;<input class='form_elements_edit' type='text' name='gen_find_profile_enter_email' id='gen_find_profile_enter_email' value='' maxlength='255' size='20'></td>" );
									}
								print( "</tr>" );
								if( $type=='pplb')
								{
									print( "<tr>" );
											print( "<td><span class='form_elements_text'>Mail Box</span>" );
											print( "&nbsp;&nbsp;<input class='form_elements_edit' type='text' name='gen_find_profile_enter_mailbox' id='gen_find_profile_enter_mailbox' value='' maxlength='16' size='5'></td>" );
											print( "<td><span class='form_elements_text'>Room No.</span>" );
											print( "&nbsp;&nbsp;<input class='form_elements_edit' type='text' name='gen_find_profile_enter_mailbox' id='gen_find_profile_enter_roomno' value='' maxlength='8' size='5'></td>" );
											print( "<td><span class='form_elements_text'>Building</span>" );
											print( "&nbsp;&nbsp;<input class='form_elements_edit' type='text' name='gen_find_profile_enter_mailbox' id='gen_find_profile_enter_building' value='' maxlength='255' size='20'></td>" );
									print( "</tr>" );
								}								

								print( "</table></td>" );
							print( "</tr>" );
						
						print( "</table>" );					
						print( "</td>" );
					print( "</tr>" );
				}
				print( "<tr>" );
				print( "</tr>" );
				print( "<tr>" );
					print( "<td>" );
					print( "&nbsp;" );
					print( "</td>" );
				print( "</tr>" );
				print( "</form>" );			
			}
		}
		
		print( "<tr class='table_background' >" );
			print( "<td align='left'>" );
				print( "&nbsp;<img alt='select' src='../images/icons/select.gif'>&nbsp;&nbsp;<span class='form_elements_section_header'>Selected List<span>" );
			print( "</td>" );
		print( "</tr>" );
		
		print( "<tr>" );
			print( "<td align='center'>" );
			print( "<table id='" . $boxname . "_select_table' width='100%' border='1' cellspacing='0'>" );
				print( "<tr id='" . $boxname . "_select_table_header' class='table_background_other'>" );
					print( "<td width='3%'><span class='form_elements_text'>No.</span></td>" );
					print( "<td align='center'><span class='form_elements_text'>$typename</span></td>" );
					print( "<td width='3%'>&nbsp;</td>" );
						
				print( "</tr>" );
				print( "<tr>" );
					if( $type == 'ppla' || $type == 'pplb' )
						print( "<td id='" . $boxname . "_select_table_footer' colspan='5'>&nbsp;</td>" );
					else
						print( "<td id='" . $boxname . "_select_table_footer' colspan='3'>&nbsp;</td>" );
				print( "</tr>" );
			print( "</table>" );
		print( "</tr>" );
		
		print( "<tr>" );
			print( "<td align='center' colspan='2' height='5'>" );
			print( "</td>" );
		print( "</tr>" );

		print( "<tr>" );
			print( "<td align='center' colspan='2' >" );
				print( "<table width='100%'  border='0' cellspacing='0' cellpadding='0' >" );
					print( "<tr>" );
						print( "<td align='right' >" );
						$funcname = $funcname == "" ? "fpProcessResults" : $funcname;
						print( "<input type='button' name='ok' value='OK' onclick='parent." . $funcname . "( \"$boxname\", fpResultsSelect)'>" );
						print( "<input type='button' name='cancel' value='Cancel' onclick='parent.cancelFindProfile( \"$boxname\" )'>" );
						print( "</td>" );
					print( "</tr>" );
				print( "</table>" );
			print( "</td>" );
		print( "</tr>" );
	}
print( "</table>" );
	
?>
<div id='ppl_general_info_pri_rank_box' style='display:none;z-index:100' onSelectStart='return false'>
	<div id='ppl_general_info_pri_rank_header' >
		<span id='ppl_general_info_pri_rank_caption' >Edit Primary Rank</span>
		<span id='ppl_general_info_pri_rank_close' >
		<img alt='close' src='../images/buttons/close.gif' onClick='hide_popup("ppl_general_info_pri_rank")'>
		</span>
	</div>
	<div id='ppl_general_info_pri_rank_content' >
	<iframe id='ppl_general_info_pri_rank_frame' ></iframe>
	</div>
</div>

</body>
</html>