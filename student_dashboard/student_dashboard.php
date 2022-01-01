<?php 
 	session_start();
    if(isset($_SESSION["user"])){
      $user=$_SESSION["user"];

    }
 ?>

<!DOCTYPE html>

<html>

<head>

	<title>Student Dashboard</title>

	

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="styles.css">

</head>

<body>

	

	<nav class="navbar navbar-dark bg-primary">

	  <a class="navbar-brand">PAATHSAALA</a>

	  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"> Join Class </button>

	</nav>

<?php

	// $user = "jai.mehta@somaiya.edu";
	// $user = "student1@gmail.com";

    $db_classes = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');

	

	if (!$db_classes) {

	    die("Connection failed: " . mysqli_connect_error());

	}

	

	else{

		$query_classes = "SELECT * FROM classes WHERE class_code IN (SELECT class_code FROM members where email='$user')";

		$result_classes = mysqli_query($db_classes,$query_classes);

		$row_classes = "";

		if ($result_classes){

			$row_classes = mysqli_fetch_all($result_classes, MYSQLI_ASSOC);

		}

		?>

		<div class="container py-4">

		    <div class="card-deck-wrapper">

		        <div class="card-deck">

		<?php

		for($i=0;$i<count($row_classes);$i++){

		?>

		<div class="col-sm-4">

            <div class="card-columns-fluid">

		            <div class="card p-2 mb-5">



		                <a class="card-block stretched-link text-decoration-none" href="http://localhost/Paathshaala/class/class.php?class_code=<?php echo $row_classes[$i]['class_code']; ?>" >

		                    <h4 class="card-title"><?php echo $row_classes[$i]["class_name"]; ?></h4>

		                    <p class="card-text">Class Code: <?php echo $row_classes[$i]["class_code"]; ?></p>

		                    <p class="card-text"><small class="text-muted">Created on: <?php echo $row_classes[$i]["class_creation_date"]; ?></small></p>

		                </a>

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



<!-- Modal -->

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalCenterTitle">Enter Class Code</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

       <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

      <div class="modal-body">

		

		  <div class="form-group">

		    <label for="class_code">Class Room Code:</label>



		    

		    <input type="text" class="form-control" id="class_code" name="class_code" placeholder="Class Code" required>

		  </div>

		  <div class="form-group">

		    <label for="class_join_date">Date of Joining:</label>

		    <?php 

		    $class_join_date=date("d-m-Y");

		    echo $class_join_date . "<br>"; 

		    ?>

		  </div>

		  </div>

		  

      

      <div class="modal-footer">

      	<button type="submit" class="btn btn-primary">Submit</button>



      	</div>

		</form>

		<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {



  

  $class_code = $_POST["class_code"];

  



$db = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');



$order = "SELECT * FROM members where class_code = '$class_code' and email = '$user'";

$result = mysqli_query($db,$order);

$row = "";

if($result) {

	$row = mysqli_fetch_all($result, MYSQLI_ASSOC);

	if($row) {

		?>

<script>

 

  alert("You have already Joined the class!");



</script>

		<?php 



		

	}

	else {

		$db = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');

		$query = "SELECT * FROM classes WHERE class_code = '$class_code';";

		$result = mysqli_query($db,$query); 



		if($result->num_rows === 0)

		{?>

			<script>

	 

			alert("You have entered a wrong code!");

		  

		  </script>

		<?php }

else { 

	$order = "INSERT INTO members

	(email, class_code, member_type) VALUES ('$user','$class_code','Member')";    

$result = mysqli_query($db,$order); //order executes

mysqli_close($db);

}

		

	}





	

	

}





 

?>



<script type="text/javascript"> window.location.href ="student_dashboard.php";</script>





<?php

}

?>



      </div>

    </div>

  </div>





</body>

</html>



