<?php
	$current_class_code = htmlspecialchars($_GET["code"]);
	$user="pankti.n@somaiya.edu"
?>
<!DOCTYPE html>
<html>
<head>
	<title>Class</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
	

	<!-- NAVBAR STARTS -->
	<nav class="navbar navbar-dark bg-primary">
	  <a class="navbar-brand" href="http://localhost/Paathshaala/teacher_dashboard/teacher_dashboard.php">PAATHSAALA</a>
	  <button class="btn btn-info" type="button" id="dropdownMenuButton" data-toggle="dropdown"><span class="fa fa-plus"></span> 
	  </button>
	  <div class="dropdown-menu dropdown-menu-right">
	    <!--<button class="dropdown-item" type="button" data-toggle="modal" data-target="#exampleModalCenter">Create Quiz</button>-->
	    <a class="text-decoration-none" href="http://localhost/Paathshaala/quiz/quiz_details.php?code=<?php echo $current_class_code; ?>"><button class="dropdown-item" type="button">Create Quiz</button></a>
	    <button class="dropdown-item" type="button">Create Assignment</button>
	    <button class="dropdown-item" type="button">Make Announcement</button>
	  </div>
	</nav>
	<!-- NAVBAR ENDS -->


	<!-- MODAL STARTS -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalCenterTitle">Enter Details</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          	<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	       	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?code='.$current_class_code;?>">
	      	<div class="modal-body">
			  	<div class="form-group">
			    	<label for="quiz_code">Quiz Code:</label>
					<?php
					    $counter=1;
					    $db = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');
					    while($counter==1){
					    $command = escapeshellcmd('python quiz_code.py');
					    $output = shell_exec($command);
						$row = "SELECT * FROM classes WHERE class_code='$output'";
						$result = mysqli_query($db,$row); //order executes
					    if (mysqli_num_rows($result) == 0){
						mysqli_close($db);
						$counter=0;
						}}
					?>			    	
			    	<input type="text" readonly class="form-control" id="quiz_code" name="quiz_code" value="<?php echo $output; ?>">
			    </div>
			    <div class="form-group">
				    <label for="subject_name">Subject Name:</label> 
				    <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Enter Subject Name" required>
				</div>
			    <div class="form-group">
				    <label for="number_questions">Number of Questions:</label> 
				    <input type="Number" min="1" class="form-control" id="number_questions" name="number_questions" placeholder="Enter Number of Questions" required>
				</div>
				<div class="form-group">
				    <label for="number_options">Number of Options:</label> 
				    <input type="Number" min="2" max="6" class="form-control" id="number_options" name="number_options" placeholder="Enter Number of Options" required>
				</div>
				<div class="form-group">
				    <label for="validity_date">Validity Date:</label> 
				    <input type="date" class="form-control" id="validity_date" name="validity_date" required>
				</div>
		  	</div>
		    <div class="modal-footer">
		      	<button type="submit" class="btn btn-primary">Submit</button>
			</div>
			</form>
			</div>
		</div>
	</div>
	<!-- MODAL ENDS -->
<?php 
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$subject = $_POST["subject_name"];
		$number_of_questions = $_POST["number_questions"];
		$number_of_options = $_POST["number_options"];
		$validity_date = $_POST["validity_date"];
		#date_validity
		$create_date = date("d-m-Y");
		$quiz_code = $output;
		$class_code = $current_class_code;
		$quiz_creator = $user;
		$db_quiz_details = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');
		if (!$db_quiz_details) {
	    	die("Connection failed: " . mysqli_connect_error());
		}
		else{
			$sql_quiz_details = "INSERT INTO quizzes (quiz_code,quiz_creator,subject,number_of_questions,number_of_options,class_code,create_date,date_validity) VALUES ('$quiz_code','$quiz_creator','$subject','$number_of_questions','$number_of_options','$class_code','$create_date','$validity_date')";
			if (mysqli_query($db_quiz_details, $sql_quiz_details)) {
				mysqli_close($db_quiz_details);
				$quiz_query = array(
			    'nquestions' => $number_of_questions, 
			    'noptions' => $number_of_options,
			    'code' => $quiz_code,
			    'subject' => $subject
			    );

				$quiz_query = http_build_query($quiz_query);
				header("location:http://localhost/paathshaala/quiz/quizprepare.php?$quiz_query");
			}
			?>
			<?php
		}
		?>
		
		<?php
	}
?>



</body>
</html>