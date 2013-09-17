<?php
$_ldap_input_login_name = "utaAccountName";
$_ldap_input_login_id = "utaID";
$_ldap_input_first_name = "givenName";
$_ldap_input_last_name = "sn";
$_ldap_input_cedar_id = "cedarid";

$_ldap_sort_by[0] = "givenName";
$_ldap_sort_by[1] = "sn";

// People
$_ldap_pplc_output[0] = "displayname"; // full name - People
$_ldap_pplc_output[1] = "utadeptname"; // dept name (check it)
$_ldap_pplc_output[2] = "utaemployeetitle"; //rank  - People
$_ldap_pplc_output[3] = "utaid"; //login id not login name - People
$_ldap_pplc_output[4] = "sn"; // last name - People
$_ldap_pplc_output[5] = "givenname"; // first name - People
$_ldap_pplc_output[6] = "utamiddlename"; // middlename (not available)
$_ldap_pplc_output[7] = "utaemployeephone"; // Phone number - People
$_ldap_pplc_output[8] = "mail"; // email id - People
$_ldap_pplc_output[9] = "utamailalias"; // email alias - People
$_ldap_pplc_output[10] = "utaemployeeroom"; // room number (not available)
$_ldap_pplc_output[11] = "utaemployeebldg"; // building name (not available)
$_ldap_pplc_output[12] = "utaemployeecampusbox"; // PO Box number  - People
$_ldap_pplc_output[13] = "utaEmployeeStatus"; // employee status e.g. active/inactive - People
$_ldap_pplc_output[14] = "utaDeptCode"; // department code - People
// Useless right now [start]
$_ldap_pplc_output[15] = "utaHomeStreet1"; //  - People
$_ldap_pplc_output[16] = "utaHomeStreet2"; //  - People
$_ldap_pplc_output[17] = "utaHomeCity"; //  - People
$_ldap_pplc_output[18] = "utaHomeState"; //  - People
$_ldap_pplc_output[19] = "utaHomeZip"; //  - People
$_ldap_pplc_output[20] = "homePhone"; //  - People
// Useless [end]
$_ldap_pplc_output[21] = "utaAccountName"; // - People
$_ldap_pplc_output[22] = "cn"; // Common Name - People
$_ldap_pplc_output[23] = "utaEmployeeUTEID"; // - People

// Accounts
$_ldap_pplc_output[24] = "eduPersonPrimaryAffiliation"; // primary affiliation - Accounts
// not used right now [start]
$_ldap_pplc_output[25] = "eduPersonAffiliation"; // primary affiliation - Accounts
$_ldap_pplc_output[26] = "eduPersonPrincipalName"; // primary affiliation - Accounts
// not used [end]
$_ldap_pplc_output[27] = "cedarid"; //unique cedar id - Accounts, People
$_ldap_pplc_output[28] = "uid"; // utaAccountName in People - Accounts

// Department
$_ldap_pplc_output[29] = "utaDeptParentCode"; // department code for parent department - (not available)
$_ldap_pplc_output[30] = "utaPrimaryEmail";

//$dataset = real_get_pplc('objectClass', '*', $_ldap_search_dn_dept); //echo "<pre>"; print_r($dataset); echo "</pre>";
//$dataset = real_get_pplc('uid', 'rmittal', $_ldap_search_dn_acct); echo "<pre>"; print_r($dataset); echo "</pre>";
//$dataset = real_get_pplc('utaDeptCode', '0220003', $_ldap_search_dn_ppl); echo "<pre>"; print_r($dataset); echo "</pre>";

$connect = real_db_connect($_db_server, $_db_username, $_db_password, $_db_name);

function real_get_pplc($key, $value, $_ldap_search_dn)
{
	global $_authentication;
	global $connect;

	if ($_authentication == "DB")
	{
		if ($value == "9999999999")
		{
			$table = array();
			for ($j=0; $j<30; $j++)
			{
				$table[0][$j] = "";
			}
			$table[0][3] = $value;
			$table[0][27] = $value;
			$table[0][5] = "Vice President for Research / Director, Grant & Contract Services";
			$table[0][22] = $table[0][5];
			$table[0][21] = "raweb";
			$table[0][8] = "raweb@uta.edu";
			$table[0][30] = $table[0][8];
			$table[0][21] = $value;
			return $table;
		}
		else
		{
			$query = "select * from db_user_info where login_id='$value'";
			//echo $query . "<br>";
			$result_i1 = mysql_query($query, $connect) or die("01 - " . mysql_error() . "==" . $query);
			$name1 = "Unavailable";
			$email1 = "un@vaila.ble";
			if ($row1 = mysql_fetch_array($result_i1))
			{
				$f_name = $row1["f_name"];
				$l_name = $row1["l_name"];
				$email1 = $row1["email"];
			}
			$table = array();
			for ($j=0; $j<30; $j++)
			{
				$table[0][$j] = "";
			}
			$table[0][21] = $value;
			$table[0][3] = $value;
			$table[0][22] = $l_name . ", " . $f_name;
			$table[0][4] = $l_name;
			$table[0][5] = $f_name;
			$table[0][27] = $value;
			$table[0][8] = $email1;
			$table[0][30] = $table[0][8];
			return $table;
		}
	}
	else
	{
		if ($value == "9999999999")
		{
			$table = array();
			for ($j=0; $j<30; $j++)
			{
				$table[0][$j] = "";
			}
			$table[0][3] = $value;
			$table[0][27] = $value;
			$table[0][5] = "Vice President for Research / Director, Grant & Contract Services";
			$table[0][22] = $table[0][5];
			$table[0][21] = "raweb";
			$table[0][8] = "raweb@uta.edu";
			$table[0][30] = $table[0][8];
			return $table;
		}
		else
		{
			//echo "real_get_pplc called for $key, $value, $_ldap_search_dn<br>\n";
			global $_ldap_input_login_id, $_ldap_pplc_output,  $_ldap_sort_by;
			$input_fields = array();
			$input_fields[0][0] = $key; $input_fields[0][1] = $value;
			$result_ldap = real_query_info_ldap($input_fields, $_ldap_pplc_output,
				5000, $_ldap_sort_by, 0, $_ldap_search_dn);
			return $result_ldap;
		}
	}
}

function real_query_info_ldap($input_fields, $output_fields, $limit, $sort_by, $pageno, $_ldap_search_dn)
{
	global $_ldap_server, $_ldap_global_dn, $_ldap_global_passwd, $_browse_search_rows_per_page;
	global $_err_ldap_connect;
	global $_err_page;
	$_browse_search_rows_per_page = 1000;
	$output = array();
	$dataset = array();
	if( $ldap = ldap_connect($_ldap_server) )
    {
		if (!($res = @ldap_bind($ldap, $_ldap_global_dn, $_ldap_global_passwd)))
		{
			ldap_close( $ldap );
			echo "Could not connect to ldap server using the specified dn and password.<br>\n";
		}
		$search_filter = "(".$input_fields[0][0]."=".$input_fields[0][1].")";
		//echo "Search By: $search_filter In $_ldap_search_dn<br>\n";
		//echo "$sr = @ldap_search( $ldap, $_ldap_search_dn, $search_filter, $output_fields, 0, $limit, 0);<br>";
		$sr = @ldap_search( $ldap, $_ldap_search_dn, $search_filter, $output_fields, 0, $limit, 0);
		if($sr)
		{
			//echo "<pre>". ldap_error($ldap) . "</pre>";
			$count_entries = ldap_count_entries ($ldap, $sr);
			//echo "<pre>$count_entries</pre>";
			$info = @ldap_get_entries($ldap, $sr);
			//echo "<pre>"; print_r($info); echo "</pre>";
			for ($i=0; $i<$info["count"]; $i++)
			{
				for($j=0; $j<count($output_fields); $j++)
				{
					$dataset[$i][$j] = $info[$i][strtolower($output_fields[$j])][0];
				}
			}
		}
		ldap_close( $ldap );
		//echo "-----------------------<br>\n";
		return $dataset;
    }
	else
		echo "LDAP Connect Error<br>\n";
}
?>