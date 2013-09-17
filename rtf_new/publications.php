<?php
	session_start();
	include_once '../utils.php';
	
	if(!isset($_GET['pid']) || !isset($_GET['target'])){
		echo "Ops... you reach this page by accident.<br>Go back: <a href=\"https://researchprofiles.txstate.edu\" target=\"_self\">Home</a>";
		exit();
	}
	$pid = $_GET['pid'];
        //$pid = 1238;
	$target = $_GET['target'];
        //$target = "nih";
	if(isset($_GET['relevant'])) $relevant = true;
	else $relevant = false;
	$page = "";
	
	switch($target){
		case "nih":
			$page = "nih_bio.php";
			//$page = "nih_rtfdata.php";
                        //$page = "../../phprtflite/nih_bio.php";
			break;
		case "nsf":
			$page = "nsf_bio.php";
			break;
		default:
			exit;
			break;
	}
	
	$db_conn = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);
	$query1 = "SELECT * FROM ppl_publication WHERE pid=".real_mysql_specialchars( $pid, false)." ORDER BY year DESC";
	$results = real_execute_query($query1, $db_conn);
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<script type="text/javascript">
			function selectAll(val){
				var elem = document.getElementById('publications').elements;
				for(var i = 0; i < elem.length; i++){
					if(elem[i].type == 'radio' && elem[i].value == val){
						elem[i].checked = true;
					}
				}
			}
			
			function sendInfo(){
				var elem = document.getElementById('publications').elements;
				for(var i = 0; i < elem.length; i++){
					if(elem[i].type == 'radio' && elem[i].value == 1 && elem[i].checked == true){
						document.getElementById('publications').submit();
						return;
					}
				}
				alert("You must mark at least one publicatio as selected");
			}
		</script>
	</head>
	<body>
		<form id="publications" name="publications" action="<?php echo $page; ?>" method="post">
			<table width="80%" align="center" border="1">
				<tr>
					<td colspan="5" align="center">
						<b>Please select the publications you would like to add to your Biosketch</b>
					</td>
				</tr>
				<tr>
					<td>
						<b>Not Selected:</b>
					</td>
					<td>
						<b>Selected:</b>
					</td>
					<?php if($relevant){ ?>
					<td>
						<b>Additional:</b>
					</td>
					<?php } ?>
					<td>
						<b>Year:</b>
					</td>
					<td>
						<b>Name:</b>
					</td>
				<tr>
				<tr>
					<td>
						<a href="#" onClick="selectAll(0); return false;">Select all:</a>
					</td>
					<?php if($relevant){ ?>
					<td>
						<a href="#" onClick="selectAll(1); return false;">Select all:</a>
					</td>
					<?php } ?>
					<td>
						<a href="#" onClick="selectAll(2); return false;">Select all:</a>
					</td>
					<td colspan="2">
						<p></p>
					</td>
				<tr>
				<?php while($row = mysql_fetch_assoc($results)){ ?>
					<tr>
						<td>
							<input type="radio" name="<?php echo $row['pub_id']; ?>" value="0" checked="true">Not Selected
						</td>
						<td>
							<input type="radio" name="<?php echo $row['pub_id']; ?>" value="1">Selected
						</td>
						<?php if($relevant){ ?>
						<td>
							<input type="radio" name="<?php echo $row['pub_id']; ?>" value="2">Aditional
						</td>
						<?php } ?>
						<td>
							<?php echo htmlspecialchars(strip_tags($row['year'])); ?>
						</td>
						<td>
							<?php echo strip_tags($row['name']); ?>
						</td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="5" align="center">
						<button type="button" name="btnSubmit" id="btnSubmit" onClick="sendInfo();" >Continue</button>
					</td>
				</tr>
			</table>
			<input type="hidden" name="pid" id="pid" value="<?php echo $pid; ?>" />
		</form>
	</body>
</html>
