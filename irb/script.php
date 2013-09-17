<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<script>
function deleteConfirm(a,b,c)
{
if (confirm('Are you sure you want to remove this reviewer from the application? Doing so, the the evaluations/comments that the reviewer ever made to this application will be removed permanently from the record of this application.')){
dirlocation="deleteReviewerAss.php?oldID="+a+"&appNum="+b+"&id="+c;
document.location.href=dirlocation;
}
}
</script>
<body>
</body>
</html>
