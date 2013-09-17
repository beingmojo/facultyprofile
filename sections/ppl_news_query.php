<?php
#include database connection variables
//include the link to the connection string to your public affairs database here
/*
include "";

#connect to "uta" database
function uta_db_connect ()
{
	global $host, $dbuser, $password;
	$link1 = @mysql_connect($host, $dbuser, $password, true);
	if ($link1 && mysql_select_db ("uta"))
		return ($link1);
	return (FALSE);
}

#connect to "public_affairs" database
 function pub_affairs_connect ()
{
	global $host, $dbuser, $password;
	$link2 = @mysql_connect($host, $dbuser, $password, true);
	if ($link2 && mysql_select_db ("public_affairs"))
		return ($link2);
	return (FALSE);
}

# connect to "univ_pub" database
function univ_pub_db_connect()
{
	global $host, $dbuser, $password;
	$link3 = @mysql_connect($host, $dbuser, $password, true);
	if ($link3 && mysql_select_db ("univ_pub"))
		return ($link3);
	return (FALSE);
	
}

# Connect to the database
$conn = uta_db_connect ();
$conn_univ_pub = univ_pub_db_connect ();
$conn_pub_affairs = pub_affairs_connect ();
$namerows = mysql_fetch_array( $ppl_general_info_results );

if($namerows["f_name"]!="" || $namerows["l_name"]!="")
{
//	original code follows
		//$urlname = $namerows["f_name"] . " " . $namerows["l_name"];
//	the line below fixes the apostrophe issue
		$urlname = real_rte_specialchars($namerows["f_name"],true) . " " . real_rte_specialchars($namerows["l_name"], true);
// another fix to revert to
		//$urlname = str_replace("'", "\'", $namerows["f_name"]) . " " . str_replace("'", "\'", $namerows["l_name"]);
}
$fac_name = $urlname;
//echo $urlname;
$counter = 0;
		
# Search Research Magazine for any articles related to expert		
$query5 = "SELECT  * FROM  researchmag_articles  WHERE
			  MATCH(content) AGAINST('\"$fac_name\"' IN BOOLEAN MODE)" ;
	
$result5 = mysql_query($query5, $conn_univ_pub) or die(mysql_error());
$num_results1 = mysql_num_rows($result5);		  
if($num_results1 > 0) {								
	$counter = 1;  
}					
$modif_fac_name = strtolower($fac_name);
$modif_fac_name = ucwords($modif_fac_name);
	
# Search UTA Magazine for any articles related to expert
$query6 = "SELECT * FROM  stories  WHERE
			   MATCH(headline,subheadline,content,summary) AGAINST('\"$fac_name\"' IN BOOLEAN MODE)" ;			  		
$result6 = mysql_query($query6, $conn_univ_pub) or die(mysql_error()) ;
$num_results2 = mysql_num_rows($result6);
if($num_results2 > 0) 
{						
		$counter = 1;
}
	
# Search News Releases for any articles related to expert
$query = "SELECT * FROM  stories  WHERE
		   MATCH(story_text) AGAINST('\"$fac_name\"' IN BOOLEAN MODE)" ;			  		
$result = mysql_query($query, $conn_pub_affairs) or die(mysql_error()) ;
$num_results = mysql_num_rows($result);
if($num_results > 0) 
{						
	$counter = 1;
}
*/
	if( $editable == true )
		$ppl_news_query = "SELECT * FROM ppl_news WHERE pid = " . real_mysql_specialchars( $pid, true );
	else
		$ppl_news_query = "SELECT * FROM ppl_news WHERE status = 0 AND pid = " . real_mysql_specialchars( $pid, true ) ;
	$ppl_news_results = real_execute_query ( $ppl_news_query, $db_conn );

	if( $editable == true )
	{
		$ppl_news_max_id_query = "SELECT MAX( news_id ) FROM ppl_news WHERE pid = " . real_mysql_specialchars( $pid, true );
		$ppl_news_max_id_results = real_execute_query ( $ppl_news_max_id_query, $db_conn );
	}


?>