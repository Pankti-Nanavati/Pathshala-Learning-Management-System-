<?php  
$quiz_code = $_GET["quiz_code"];
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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reschedule Quiz</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<nav class="navbar navbar-dark bg-primary">
  		<a class="navbar-brand" href="http://localhost/Paathshaala/teacher_dashboard/teacher_dashboard.php">PATHSHAALA</a>
	</nav>
	<?php 
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$new_date = $_POST["new_date"];
		$query_reschedule="UPDATE quizzes SET date_validity ='$new_date' WHERE quiz_code = '$quiz_code'";
		$result_reschedule = mysqli_query($db,$query_reschedule);
		mysqli_close($db);
		?><script type="text/javascript">window.location.href = "http://localhost/Paathshaala/class/class.php?class_code=<?php echo $class_code; ?>"</script><?php
	}
	?>
	<form style="margin: 500px;" class="mt-5" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?quiz_code=".$quiz_code;?>">
		<div class="container">	
			<div class="form-group">
		    	<label for="rechedule">Select a new date</label>
		    	<input type="date" class="form-control" id="rechedule" placeholder="dd-mm-YYYY" name="new_date">
		  	</div>
		  		<button style="margin-left: 150px" type="submit" class="btn btn-primary">Submit</button>
		</div>
	  
	</form>
</body>
</html>