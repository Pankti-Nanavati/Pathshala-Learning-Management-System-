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
$query_view_result = "SELECT * FROM quiz_result WHERE quiz_code='$quiz_code'";
$result_view_result = mysqli_query($db,$query_view_result);
if($result_view_result) {
	$row_view_result = mysqli_fetch_all($result_view_result, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
	<nav class="navbar navbar-dark bg-primary">
	  <a class="navbar-brand" href="http://localhost/Paathshaala/teacher_dashboard/teacher_dashboard.php">PAATHSAALA</a>
	  	<ul class="navbar-nav mr-auto">
		  <li class="nav-item active">
	        <a class="nav-link" href="javascript:history.go(-1)" title="Return to previous page">BACK TO CLASS<span class="sr-only">(current)</span></a>
	      </li>
  		</ul>
	</nav>
	<title>Quiz Result</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
	  <div class="row">
	    <div class="col-lg">
	      	<table class="table">
			  <thead>
			    <tr>
			    	<th scope="col">No.</th>
			      	<th scope="col">Email</th>
			      	<th scope="col">Score</th>
			      	<th scope="col">Out of</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php for($i=0;$i<count($row_view_result);$i++){
			  		?>
			  		<tr>
				      	<th scope="row"><?php echo $i+1; ?></th>
				      	<td><?php echo $row_view_result[$i]["email"]; ?></td>
				      	<td><?php echo $row_view_result[$i]["score_obtained"]; ?></td>
				      	<td><?php echo $row_view_result[$i]["total_marks"]; ?></td>
				    </tr>
			  		<?php
			  	} ?>
			    
			  </tbody>
			</table>
	    </div>
	    <div class="col">
	    </div>
	  </div>
	</div>
<?php mysqli_close($db); ?>
</body>
</html>