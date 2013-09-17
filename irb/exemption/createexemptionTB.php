
 <?php require_once('../Connections/dbc.php'); ?>

<?php
mysql_query("CREATE TABLE exemption(SenderStatus VARCHAR(30),  sponsorship VARCHAR(50), FirstName VARCHAR(40), LastName VARCHAR(40), Phone VARCHAR(20), Email VARCHAR(60), FacultyName VARCHAR(30), academic_project VARCHAR(3), contribute_knowledge VARCHAR(3), share_results VARCHAR(3), interact_people VARCHAR(3), collect_info VARCHAR(3), involve_pregnant VARCHAR(3),involve_prisoners VARCHAR(3),involve_vulnerable VARCHAR(3),medical_identifiers VARCHAR(3),minor_subjects VARCHAR(3),FDAproduct_used VARCHAR(3),ingest_substance VARCHAR(3),physical_tasks VARCHAR(3),influence_behavior VARCHAR(3),sensitive_discussion VARCHAR(3),exposeto_discomfort VARCHAR(3),subject_deception VARCHAR(3),taping_subjects VARCHAR(3),exempt_category VARCHAR(30),project_purpose VARCHAR(250),category_pertains VARCHAR(250),exempt_reason VARCHAR(250))")

or die("Create table Error: ".mysql_error());
echo "exemption table created";
mysql_close($con);
 
?>