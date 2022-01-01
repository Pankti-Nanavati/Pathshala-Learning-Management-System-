<?php 
	$assignment_code = $_GET["assignment_code"]
?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete Assignment</title>
</head>
<body>
<?php  
$db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
$query = "SELECT * FROM assignment WHERE assignid='$assignment_code'";
$result = mysqli_query($db,$query);
$row = "";
if($result) {

	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if($row){
		$class_code = $row[0]["class_code"];
	}
}
$submission_delete = "DELETE FROM submission WHERE assignid='$assignment_code'";
$assignment_delete = "DELETE FROM assignment WHERE assignid='$assignment_code'";
$submission_deleted = mysqli_query($db,$submission_delete);
$result_deleted = mysqli_query($db,$assignment_delete);
mysqli_close($db);
?>
<script type="text/javascript">window.location.href="http://localhost/Paathshaala/class/class.php?class_code=<?php echo $class_code; ?>"</script>
</body>
</html>