<?php 
	$announcement_code = $_GET["announcement_id"]
?>
<!DOCTYPE html>
<html>
<head>
	<title>Delete Announcement</title>
</head>
<body>
<?php  
$db = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');
$query = "SELECT * FROM announcement WHERE annid='$announcement_code'";
$result = mysqli_query($db,$query);
$row = "";
if($result) {

	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if($row){
		$class_code = $row[0]["class_code"];
	}
}
$announcement_delete = "DELETE FROM announcement WHERE annid='$announcement_code'";
$result_deleted = mysqli_query($db,$announcement_delete);

mysqli_close($db);
?>
<script type="text/javascript">window.location.href="http://localhost/Paathshaala/class/class.php?class_code=<?php echo $class_code; ?>"</script>
</body>
</html>