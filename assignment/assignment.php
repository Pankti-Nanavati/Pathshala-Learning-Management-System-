<?php
 session_start();
    if(isset($_SESSION["user"])){
      $user=$_SESSION["user"];

    }
	$current_class_code = htmlspecialchars($_GET["code"]);
    // $user = "kunj.gala@somaiya.edu";
    ?>


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <nav class="navbar navbar-dark bg-primary">
	  <a class="navbar-brand" href="http://localhost/Paathshaala/teacher_dashboard/teacher_dashboard.php">PATHSHALA</a>
	  	<ul class="navbar-nav mr-auto">
		  <li class="nav-item active">
	        <a class="nav-link" href="javascript:history.go(-1)" title="Return to previous page">BACK TO CLASS<span class="sr-only">(current)</span></a>
	      </li>
  		</ul>
	</nav>
</head>
<body>
<?php 
$title = $desc = $marks = $due_date = "";
$duedateErr = "";
$title = $desc = $marks = $due_date = "";
$duedateErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
date_default_timezone_set('Asia/Kolkata');
$title = $_POST["title"];
$desc = $_POST["desc"];
$marks = $_POST['marks'];
$due_date = $_POST["duedate"];
$date = date("Y-m-d");
$due_date_t = strtotime($due_date);
$date_t = strtotime($date);
$current_class_code = $current_class_code;
if ($due_date<$date)
{
  $duedateErr = "Enter a Valid Due date";
}
else  {
  $db = mysqli_connect('localhost','root','','Paathshaala') or 
              die('Error connecting to MySQL server.');
  $counter=1;
    while($counter==1){

    $command = escapeshellcmd('python class_code.py');

    $output = shell_exec($command);

    $row = "SELECT * FROM assignment WHERE assignid='$output'";

    $result = mysqli_query($db,$row); //order executes

    if (mysqli_num_rows($result) == 0){

    mysqli_close($db);

    $counter=0;

    
    }
  }
    
    
    $date_today = date("Y-m-d");
    $currentDateTime=date('m/d/Y H:i:s');
    $newDateTime = date('h:i A', strtotime($currentDateTime));
          $db = mysqli_connect('localhost','root','','Paathshaala') or 
          die('Error connecting to MySQL server.');
          $assignment = "INSERT INTO assignment
                  (title, description, marks, duedate, email, date, time,assignid,class_code)
                  VALUES
                  ('$title', '$desc', '$marks' , '$due_date','$user','$date_today','$newDateTime','$output','$current_class_code')";
          $result = mysqli_query($db,$assignment); 
          mysqli_close($db);
          header("location:http://localhost/Paathshaala/class/class.php?class_code=".$current_class_code);
  //header("location:http://localhost/Paathshaala/assignment/assign_submit.php?code=".$current_class_code);
}
}
?>
<div class="container" >

<div class="col-9">
<br>
<br>
<br>
<h2>Enter Assignment Details</h2>
<br>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?code='.$current_class_code;?>" class="container" id="register-form">

<div class="form-group">
<label for="title">Title of Assignment:</label>
<input class="form-control" type="text" name="title" id="title" placeholder="Enter Assignment Title" value="<?php echo $title?>" required />
</div>

<div class="form-group">
<label for="title">Description:</label>
<textarea class="form-control" rows="4" cols="50" name="desc" id="desc" placeholder="Enter Description" ><?php echo $desc?></textarea>
</div>

<div class="form-group">
<label for="title">Total Marks:</label>
<input class="form-control" type="number" name="marks" id="marks" placeholder="Enter Total Marks" value="<?php echo $marks?>" required>
</div>

<div class="form-group">
<label for="title">Due date:</label>
<input class="form-control" type="date" class="form-control" id="duedate" name="duedate" placeholder="dd-mm-YYYY" value="<?php echo $due_date?>" placeholder="Enter Due Date" required>
<span class="error" style="color:red;"><?php echo $duedateErr;?></span>
</div>
<br>
<button type="submit" class="btn btn-primary mb-2">Submit</button>


  <!--<input type="text" id="title" name="title"><br>
  <span class="error">* </span>
  <label for="desc">Description:</label><br>
  <input type="desc" id="desc" name="desc"><br>
  <label for="marks">Total Marks:</label><br>
  <input type="number" id="marks" name="marks"><br>
  <label for="due">Due Date:</label><br>
  <input type="date" id="due" name="due"><br><br>
  <button type="button" class="btn btn-success">Create Assignment</button> -->
</form>
</div>
</div>


</body>
</html>


