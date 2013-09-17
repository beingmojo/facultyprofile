<table border="0" width="90%">
  <tr>
          <td width="100%" colspan="2">
		  <?

		  if (($is_ogcs_admin) || ($is_dept_admin != false))
			{
			?>
			<table width="52%" style="width: 100%;" border="0" cellspacing="2" cellpadding="2" align="left">
              <tr>
                <td  colspan='2'>
				<a name='createnew'><span class="font_topic">Create a New BlueSheet  </span></a>
				</td>
              </tr>
				<tr>
				<td width="5%" valign="top"><img src='images/bullets/edit.gif' alt='New BlueSheet' /></td>
				<td class="form_elements_text">
				<span onClick="document.getElementById('bsStart').style.display = 'block';" style="cursor:pointer;color:#0000FF">
					Start a new blue sheet
				</span>
				<br />
				<div id="bsStart" style="display:none">
					<table border="0">
					<tr>
						<td>Bluesheet name:</td><td><input type="text" id="bs_name" /><font color="#FF0000">*</font></td>
					</tr>
					<tr>
						<td valign="top">Description:</td><td><input type="text" id="bs_comments" /></td>
					</tr>
					<tr>
						<script src="scripts/f_bs_manage.js"></script>
						<td>PI Name:</td><td><input type="text" id="pi_name" onKeyUp="FindProfiles('<?php if ($is_dept_admin != false) echo $is_dept_admin; ?>');" />
						<font color="#FF0000">*</font> (format: lastname, firstname)</td>
					</tr>
					<tr>
						<TD colspan="2"><div id="piResults" style="overflow:auto; height: 250px; display:none;"></div></TD>
					</tr>
					<tr>
						<td></td><td align="left"><font color="#FF0000">* Required Fields</font></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
						  <script>
							function Go()
							{
								if (document.getElementById("bs_name").value == "")
									alert("Error: Bluesheet name is missing.");
								else if (pid==0)
									alert("Error: Bluesheet Investigator is missing.");
								else
								{
									uri = "bluesheet/bs_template.php?pid=" + pid + "&bs_name=" +
										document.getElementById("bs_name").value + "&bs_comments=" + document.getElementById("bs_comments").value;
									window.location = uri;
								}
							}
						  </script>
							<input type="button" value="Go" onClick="Go()" />
						</td>
					</tr>
					</table>
				</div>
				</td>
				</tr>
            </table>
			<?
			}
			else
			{

		   ?>
		    <table width="100%"  border="0" cellspacing="2" cellpadding="2" align="left">
              <tr>
                <td colspan='2'>
				<a name='createnew'><span class="font_topic">Create a New BlueSheet  </span></a>
				</td>
              </tr>
				<tr>
				<td width="5%" valign="top"><img src='images/bullets/edit.gif' alt='New BlueSheet' /></td>
				<td class="form_elements_text">
				<span onClick="document.getElementById('bsStart').style.display = 'block';" style="cursor:pointer;color:#0000FF">
					Start a new blue sheet
				</span>
				<br />
				<div id="bsStart" style="display:none">
					<table border="0">
					<tr>
						<td>Bluesheet name:</td><td><input type="text" id="bs_name" /><font color="#FF0000">*</font></td>
					</tr>
					<tr>
						<td valign="top">Description:</td><td><input type="text" id="bs_comments" /></td>
					</tr>
					<tr>
						<td></td><td align="left"><font color="#FF0000">* Required Fields</font></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
						  <script>
							function Go()
							{
								if (document.getElementById("bs_name").value == "")
									alert("Error: Bluesheet name is missing.");
								else
								{
									uri = "bluesheet/bs_template.php?pid=<?php print($pid); ?>&bs_name=" +
										document.getElementById("bs_name").value + "&bs_comments=" + document.getElementById("bs_comments").value;
									window.location = uri;
								}
							}
						  </script>
						  <!--
  							<input type="button" value="Go" onclick="Go()" disabled/>
							<br />
							We are currently testing the blue sheet routing process.<br />
							Please email <a href="mailto:erahelpdesk@uta.edu">erahelpdesk@uta.edu</a> meanwhile for help on starting a new bluesheet.
							-->

							<input type="button" value="Go" onClick="Go()" <?php if ($pid==0) echo "disabled"; ?>/>
							<?
								if ($pid==0)
								{
									echo "<br>You need to have a profile before starting a bluesheet." .
										"<br>Please click on 'Account Info' and confirm your information to automatically create a scratch profile.";
								}
							?>

						</td>
					</tr>
					</table>
				</div>
				</td>
				</tr>
            </table>
			<?
			}
			?>
		  </td>
  </tr>
		</table>