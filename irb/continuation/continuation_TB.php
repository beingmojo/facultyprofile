
<?php require_once('../Connections/dbc.php');
mysql_query("CREATE TABLE continuation(
  ID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY(ID),
  App_Number VARCHAR(15) NOT NULL,
GrantIDNumber VARCHAR(45),
 LengthOfProject VARCHAR(3),
IRBDecisionHardCopy VARCHAR(3),
 StudyStatus VARCHAR(45),
StudyStatusExplanation TEXT,
NumberOfParticipantsApproved VARCHAR(3),
ParticipantsEnrolledSinceLastReview VARCHAR(3),
ParticipantsEnrolledToDate VARCHAR(3),
DifferentEnrollmentExplanation TEXT,
RelationshipChange VARCHAR(3),
PIChange VARCHAR(3),
PIChangeExplanation TEXT,
ResultsSummary TEXT,
UnanticpatedProblems TEXT,
RiskBenefitChange VARCHAR(3),
RiskBenefitChangedExplanation TEXT,
ChangesInStudySinceApproval TEXT)") or die("Create table Error: ".mysql_error());
echo "Continuation table created";
mysql_close($con);


?>