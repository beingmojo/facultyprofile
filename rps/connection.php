<?php
	//Created by Raghavendra Kyatham - May 02, 2006
	//Modified by Rajat Mittal - May 02, 2006
	//This file has been created to to give other applications at UTA a read-only access to our database

	$dbserver			=	"tag305871"; // database server name
	$dbname				=	"rps"; // database name
	$dbusername			=	"rpsadmin"; // databsae user name
	$dbpassword			=	"rpsadminpass"; // database password

	$db_conn = mysql_connect( $dbserver, $dbusername, $dbpassword ) or die("There was an error connecting ".
																		   "to the database server");
	$db_select = mysql_select_db( $dbname, $db_conn ) or die("There was an error connecting to the database");
?>
