<?php require_once('connection/dbc.php'); ?>

<?php
mysql_query("CREATE TABLE application(App_Number VARCHAR(50), PRIMARY KEY(App_Number), username VARCHAR(30), ProjectTitle TEXT, ProjectType VARCHAR(50), CourseNumber VARCHAR(20), FunderName TEXT, SignedHardCopy VARCHAR(3), ChildrenUnder18 VARCHAR(3), NursingHomePatients VARCHAR(3), Prisoner VARCHAR(3), PregnantWomenOrFetuses VARCHAR(3), IllnessInjoryOrDisability VARCHAR(3), MentallyOrPsychologicallyImpaired VARCHAR(3), IncentiveForParticipation VARCHAR(3), RequestName VARCHAR(3), RequestSSN VARCHAR(3), RequestPhoneNum VARCHAR(3), RequestAddress VARCHAR(3), RequestMedicalInfo VARCHAR(3), RequestNone VARCHAR(3), RiskRating VARCHAR(2), BenefitRating VARCHAR(2), RiskAssesMethod TEXT, InformedConsentDoc VARCHAR(3), NoInformedConsentExp TEXT, AppropriateLanguage VARCHAR(3), OtherLanguage VARCHAR(3), ArrangeForTranslators VARCHAR(3), TranslatorUnderstand VARCHAR(3), ObtainSubjectsSignature VARCHAR(3), ProvideCopyOfConsentDoc VARCHAR(3), LiabilityRelease VARCHAR(3), ResearchInvolvementStatement VARCHAR(3),  ExplanationOfPurpose VARCHAR(3), ExpectDuration VARCHAR(3), IdentificationOfExperimentalProc VARCHAR(3), DescriptionOfRisk VARCHAR(3), ExpectedBenefit VARCHAR(3), AlternativesOfDisclosure VARCHAR(3), ExplanationOfCompensation VARCHAR(3), ContactInfo VARCHAR(3), VoluntaryParticipationStatement VARCHAR(3))")

or die("Create table Error: ".mysql_error());
echo "Application table created";
mysql_close($con);

?>