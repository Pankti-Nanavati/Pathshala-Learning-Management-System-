<?php 
 session_start();
    if(isset($_SESSION["user"])){
      $user=$_SESSION["user"];

    }
	// $user = "student5@gmail.com";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Quiz Respond</title>
	<link rel="stylesheet" type="text/css" href="quiz_style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<?php  
	$code = $_GET['quiz_code'];
	$db = mysqli_connect('localhost','root','','paathshaala');
	if (!$db) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	else {
		$query = "SELECT * FROM quiz_qanda WHERE quiz_code = '$code';";
		$query_class_code = "SELECT * FROM quizzes WHERE quiz_code='$code'";


		$result_class_code = mysqli_query($db,$query_class_code);
		$row_class_code = "";
		if($result_class_code) {

			$row_class_code = mysqli_fetch_all($result_class_code, MYSQLI_ASSOC);
			if($row_class_code){
				$class_code = $row_class_code[0]["class_code"];
			}
		}


		$result = mysqli_query($db,$query); 
		$row = "";
	    if ($result){
		$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
		}
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$answers = array();
		for($k=1;$k<=count($row);$k++){
			if(isset($_POST[$code.$k])){
				array_push($answers, $_POST[$code.$k]);
			}
			else{
				array_push($answers, "null");
			}
		}
		$correct = 0;
		$score = 0;
		$unanswered = 0;
		$total_marks = 0;
		for($n=0;$n<count($row);$n++){
			$total_marks = $total_marks + $row[$n]["marks"];
			if($answers[$n]=="null"){
				$unanswered = $unanswered+1;
			}
			else if($answers[$n]==$row[$n]["correct_answer"]){
				$correct = $correct + 1;
				$score = $score + $row[$n]["marks"];
			}
		}
		$total_questions = count($row);
		$incorrect = $total_questions-$correct-$unanswered;
		$quiz_code = $code;
		echo "Number of questions correct/Total number of questions: ".$correct."/".count($row)."<br>";
		echo "You scored: ".$score."<br>";
		echo "You did not answer ".$unanswered." questions";
		$db_results = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');

	

		if (!$db_results) {

	    	die("Connection failed: " . mysqli_connect_error());

		}

		else{
			$query_results = "INSERT INTO quiz_result (	quiz_code,
													    email,
													    total_questions,
													    total_marks,
													    total_correct,
													    total_incorrect,
													    total_unanswered,
													    score_obtained) 
													    VALUES 
													  (	'$quiz_code',
														'$user',
														'$total_questions',
														'$total_marks',
														'$correct',
														'$incorrect',
														'$unanswered',
														'$score')";

			$result_results = mysqli_query($db_results,$query_results);
			
			?><script type="text/javascript">window.location.href="http://localhost/Paathshaala/class/class.php?class_code=<?php echo $class_code; ?>"</script>	<?php
		}

    
	}

?>
<body>
	<?php
			$query_subject = "SELECT * FROM quizzes where quiz_code='$code';";
			$result_subject = mysqli_query($db,$query_subject);
			$row_subject = mysqli_fetch_all($result_subject, MYSQLI_ASSOC);
			?><span id="subject"><?php echo $row_subject[0]["subject"];?> Quiz</span><br>
	<form id="quiz_respond" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?quiz_code=".$code;?>" id="answer_quiz">
		<?php
			for($i=0;$i<count($row);$i++){
				$question_no = $i+1;
				?><span id="question"><?php echo $question_no.")"."	";
				echo $row[$i]["question"]."</span><span id='pushright'>(".$row[$i]["marks"]." M)</span>"."<br>";
				for($j=1;$j<=6;$j++){
					if($row[$i]["a_".$j]!=NULL){

						?>
						<input id="answers" type="radio" name="<?php echo $code.$question_no ?>" value="<?php echo $row[$i]["a_".$j]; ?>">
						<span id="option"><?php 
					
						echo $row[$i]["a_".$j]."<br>";
					}
					?></span><?php
					
				}
				echo "<br>";
				?><hr id="hr" style="height:2px;border-width:0;background-color:gray"><?php
			}
		?>
		<button id="submit" type="submit" class="btn btn-primary mb-2">Submit</button>
	</form>
</body>
</html>