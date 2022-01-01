<?php
	$current_class_code = htmlspecialchars($_GET["class_code"]);
	$user="pankti.n@somaiya.edu";
	$creator = 0;
	$db_check_creator = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');
	if (!$db_check_creator) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	else{
		$query_check_creator = "SELECT * FROM members WHERE email='$user'";
		$result_check_creator = mysqli_query($db_check_creator,$query_check_creator);
		$row_check_creator = "";
		if ($result_check_creator){
			$row_check_creator = mysqli_fetch_all($result_check_creator, MYSQLI_ASSOC);
		}
		if($row_check_creator[0]["member_type"]=="creator"){
			$creator = 1;
		}
	}
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
		<a class="text-decoration-none" href="http://localhost/Paathshaala/assignment/assignment.php?code=<?php echo $current_class_code; ?>"><button class="dropdown-item" type="button">Create Assignment</button></a>
	    <a class="text-decoration-none" href="http://localhost/Paathshaala/announcement/announcement.php?code=<?php echo $current_class_code; ?>"><button class="dropdown-item" type="button">Make Announcement</button></a>
	  </div>
	</nav>
	<!-- NAVBAR ENDS -->

	<?php
    $db_quizzes = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');
	
	if (!$db_quizzes) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	else{
		$query_quizzes = "SELECT * FROM quizzes WHERE quiz_creator='$user' && class_code='$current_class_code' ORDER BY create_date";
		$result_quizzes = mysqli_query($db_quizzes,$query_quizzes);
		$row_quizzes = "";
		if ($result_quizzes)
		{
			$row_quizzes = mysqli_fetch_all($result_quizzes, MYSQLI_ASSOC);
		}
	?>
		<div class="container py-4">
		    <div class="card-deck-wrapper">
		        <div class="card-deck">
					<?php
					for($i=0;$i<count($row_quizzes);$i++){
					?>
					<div class="col-sm-7">
			            <div class="card-columns-fluid">
					            <div class="card mb-5">
					            	<p>
					                	<a class="card-link" href="http://localhost/Paathshaala/quiz/quizdelete.php?quiz_code=<?php echo $row_quizzes[$i]["quiz_code"]; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
					                    <h4 class="card-title pl-4 pt-3"><?php echo $row_quizzes[$i]["subject"]; ?></h4>
					                </p>
					                <a class="card-link pl-4 mb-2" href="http://localhost/Paathshaala/quiz/quizresult.php?quiz_code=<?php echo $row_quizzes[$i]["quiz_code"]; ?>">Results</a>
					                <p class="card-text pl-4 mb-4"><small class="text-muted">Created on: <?php echo $row_quizzes[$i]["create_date"]; ?></small>
					                <small class="text-muted ml-5 mb-4">Valid Till: <?php echo $row_quizzes[$i]["date_validity"]; ?></small>
					                <a class="card-link text-decoration-none" href="http://localhost/Paathshaala/quiz/quizreschedule.php?quiz_code=<?php echo $row_quizzes[$i]["quiz_code"]; ?>"><small class="ml-5 mb-4">Reschedule </small></a>
					                </p>
					            </div>
					        </div>
					    </div>
					    <?php
					    }
					    ?>
		        </div>
		    </div>
		</div>
	<?php	
	}
	?>

</body>
</html>