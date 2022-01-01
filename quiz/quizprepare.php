<!DOCTYPE html>
<html>
<head>
	<title>Quiz Questions Number</title>
	<title>Enter Quiz Details</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<?php 
	$code = $_GET["quiz_code"];
	$db = mysqli_connect('localhost','root','','paathshaala');
			if (!$db) {
				die("Connection failed: " . mysqli_connect_error());
			}
			else {
				$sql = "SELECT * FROM quizzes WHERE quiz_code = '$code';";
				$result = mysqli_query($db,$sql); 
				$row = "";
			    if ($result){
					$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
					mysqli_close($db);
				}
				$number_of_questions = $row[0]["number_of_questions"];
				$number_of_options = $row[0]["number_of_options"];
				$class_code = $row[0]["class_code"];
			}
	$quiz_query = array(
		'nquestions' => $number_of_questions, 
		'noptions' => $number_of_options,
		'quiz_code' => $code,
		'class_code'=>$class_code
	);
	$quiz_query = http_build_query($quiz_query);
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		for($i=1;$i<=$number_of_questions;$i++){
	  		$question = $_POST[$code.$i];
	  		$marks_per_question = $_POST[$code.$i.'marks'];
	  		$options = array();
	  		for($j=1;$j<=$number_of_options+1;$j++){
	  			array_push($options,$_POST[$code.$i.$j]);
			}
			$db = mysqli_connect('localhost','root','','paathshaala');
			if (!$db) {
				die("Connection failed: " . mysqli_connect_error());
			}
			else {
				if($number_of_options==2){
					$sql = "INSERT INTO quiz_qanda (quiz_code,question,a_1,a_2,correct_answer,marks) VALUES ('$code','$question','$options[0]','$options[1]','$options[2]','$marks_per_question')";
				}
				if($number_of_options==3){
					$sql = "INSERT INTO quiz_qanda (quiz_code,question,a_1,a_2,a_3,correct_answer,marks) VALUES ('$code','$question','$options[0]','$options[1]','$options[2]','$options[3]','$marks_per_question')";
				}
				if($number_of_options==4){
					$sql = "INSERT INTO quiz_qanda (quiz_code,question,a_1,a_2,a_3,a_4,correct_answer,marks) VALUES ('$code','$question','$options[0]','$options[1]','$options[2]','$options[3]','$options[4]','$marks_per_question')";
				}

				if($number_of_options==5){
					$sql = "INSERT INTO quiz_qanda (quiz_code,question,a_1,a_2,a_3,a_4,a_5,correct_answer,marks) VALUES ('$code','$question','$options[0]','$options[1]','$options[2]','$options[3]','$options[4]','$options[5]','$marks_per_question')";
				}
				if($number_of_options==6){
					$sql = "INSERT INTO quiz_qanda (quiz_code,question,a_1,a_2,a_3,a_4,a_5,a_6,correct_answer,marks) VALUES ('$code','$question','$options[0]','$options[1]','$options[2]','$options[3]','$options[4]','$options[5]','$options[6]','$marks_per_question')";
				}
				if (mysqli_query($db, $sql)) {
					mysqli_close($db);
				}
		  	}
	  	}
	  	header("location:http://localhost/Paathshaala/class/class.php?class_code=".$class_code);
	}

?>
<body>
	
	<form class="container mt-5" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?quiz_code='.$code;?>">
		<h1 style="color:#0275d8">Please fill in the questions and answer options!</h1>
		<?php 
			for($q = 1; $q <= $number_of_questions; $q++) {
				?>
				<div class="form-group">
					<label for="question"><?php echo "Question ".$q."<br>";?></label>
					<input class="form-control" type="text" name="<?php echo $code.$q; ?>" id="question" required="True">
				</div>
			  <?php
			  for($o = 1; $o <= $number_of_options+1; $o++){
			  	if($o <= $number_of_options){
			  		?>
			  		<div class="form-group">
			  			<label for="options"><?php echo "Option ".$o."<br>";?></label>
			  			<input class="form-control" type="text" name="<?php echo $code.$q.$o; ?>" id="options" required="True">
			  		</div>

			  		<?php
			  	}
			  	else{
			  		?>
			  		<div class="form-group">
			  			<label for="correct_answer"><?php echo "Enter the correct answer choice here:"."<br>";?></label>
			  			<input class="form-control" type="text" name="<?php echo $code.$q.$o; ?>" id="correct_answer" required="True">
			  		</div>
			  		<?php
			  	}
			  	
			  }
			  ?>
			  		<div class="form-group">
			  			<label for="marks"><?php echo "Enter the marks for the above question"."<br>";?></label>
			  			<input class="form-control" id="marks" type="text" name="<?php echo $code.$q.'marks'; ?>" id="marks" required="True"><br><br>
			  		</div>
			  		<?php
			}
		?>
		<button type="submit" class="btn btn-primary mb-2">Submit</button>
	</form>
</body>
</html>