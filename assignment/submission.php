<?php 
session_start();
    if(isset($_SESSION["user"])){
      $user=$_SESSION["user"];

    }
    $assignment_code = $_GET["assignment_code"];
    // $user = "student5@gmail.com";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Submission</title>
	<link rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
	$sub_emp = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
		$query = "SELECT * FROM assignment WHERE assignid='$assignment_code'";
		$result = mysqli_query($db,$query);
		$row = "";
		if($result) {
		
			$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
			if($row){
				$class_code = $row[0]["class_code"];
				$duedate = $row[0]["duedate"];
			}
		}
		$counter=1;
        while($counter==1){
    
        $command = escapeshellcmd('python class_code.py');
    
        $output = shell_exec($command);
    
        $row = "SELECT * FROM submission WHERE subid='$output'";
    
        $result = mysqli_query($db,$row); //order executes
    
        if (mysqli_num_rows($result) == 0){
    
        mysqli_close($db);
    
        $counter=0;
    
        
        }
    
    
    }
       
		$date = date("y-m-d");
		date_default_timezone_set('Asia/Kolkata');
		$currentDateTime=date('m/d/Y H:i:s');
		$newDateTime = date('h:i A', strtotime($currentDateTime));
		$date_t = strtotime($date);
		$duedate_t = strtotime($duedate);
        if ($date_t>$duedate_t){
            $status = " Turned In Late";
        }
        else {
            $status = "Turned On Time";
        }
		
		$target_dir = "uploads/";
        $sub_empFileName = $target_dir . md5(time() . rand()) . '.' . strtolower(pathinfo(basename($_FILES["sub_emp"]["name"]),PATHINFO_EXTENSION));
	    if (!move_uploaded_file($_FILES["sub_emp"]["tmp_name"], $sub_empFileName)) {
        //Show File Upload Error
        die('Error occured while uploading sub_emp');
	}
	    $db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
		$order = "INSERT INTO submission (class_code, assignid, file_name, email, date, time, subid, status) 
		VALUES ('$class_code','$assignment_code', '$sub_empFileName', '$user','$date','$newDateTime','$output','$status')";
		$result = mysqli_query($db,$order);
		mysqli_close($db);
	
		header("location:http://localhost/Paathshaala/class/class.php?class_code=".$class_code);
		?>
		<?php
	}
	?>
	<br>
	<br>
	<br>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?assignment_code=".$assignment_code;?>" enctype="multipart/form-data">
		<div class="container">	
		<div class="col-8">
			<div class="form-group">
		
		    	<label for="submission">Select a file: </label>
		    	<input class="form-control" style="padding-bottom:10px;height:45px;" type="file" id="sub_emp" name="sub_emp">
		  	</div>
			  <button type="submit" class="btn btn-primary mb-2">Submit</button>
		</div>
	  </div>
	</form>


</body>
</html>