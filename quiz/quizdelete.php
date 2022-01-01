<?php 
	$quiz_code = $_GET["quiz_code"]
?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete Quiz</title>
</head>
<body>
<?php  
$db = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');
$query = "SELECT * FROM quizzes WHERE quiz_code='$quiz_code'";
$result = mysqli_query($db,$query);
$row = "";
if($result) {

	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if($row){
		$class_code = $row[0]["class_code"];
	}
}
$quiz_result_delete = "DELETE FROM quiz_result WHERE quiz_code = '$quiz_code'";
$quiz_questions_delete = "DELETE FROM quiz_qanda WHERE quiz_code = '$quiz_code'";
$quiz_origin_delete = "DELETE FROM quizzes WHERE quiz_code = '$quiz_code'";
$result_deleted = mysqli_query($db,$quiz_result_delete);
$questions_deleted = mysqli_query($db,$quiz_questions_delete);
$origin_deleted = mysqli_query($db,$quiz_origin_delete);
mysqli_close($db);
?>
<script type="text/javascript">window.location.href="http://localhost/Paathshaala/class/class.php?class_code=<?php echo $class_code; ?>"</script>
</body>
</html>