<?php session_start();
    if(isset($_SESSION["user"])){
      $user=$_SESSION["user"];

    }


	    $db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
	    $query_usertype = "SELECT * FROM users WHERE email = '$user'";

		$result_usertype = mysqli_query($db,$query_usertype);

		$row_usertype = "";

		if ($result_usertype){

			$row_usertype = mysqli_fetch_all($result_usertype, MYSQLI_ASSOC);

		}
		$teacher=0;
		if($row_usertype[0]["member_type"]=='Teacher'){
			$teacher=1;
		}
?>

<!DOCTYPE html>

<html>

<head>

	<title>Teacher Dashboard</title>

	<link rel="stylesheet" type="text/css" href="dashboard.css">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



</head>

<body>

	

	<nav class="navbar navbar-dark bg-primary">

	  <a class="navbar-brand" style="color: white;">PATHSHALA</a>

	  <div class="pull-right">
	  	<?php
	  	if ($teacher==1) 
	  	{

	  	 
	  	 ?>

	  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"> Create Class </button>
	  <?php 
	  }
	  ?>

	  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter1"> Join Class </button>

	  <a href="http://localhost/paathshaala/profile/profile.php"><button type="button" class="btn btn-primary"> Profile </button></a>

	  <a href="http://localhost/paathshaala/login/login.php"><button type="button" class="btn btn-primary"> Logout </button></a>


	</div>

	</nav>

<?php

	//$user = "pankti.n@somaiya.edu";
	//$user="jai.mehta@somaiya.edu";
	// $user ="teacher2@somaiya.edu";
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
		if(!$row_classes){
			if($teacher==0){
				?>
				<p id="no_class">You have not joined any class yet!</p>
				<?php
			}
			else{
				?>
				<p id="no_class">You have not created and joined any class yet!</p>
				<?php
			}
		}

		for($i=0;$i<count($row_classes);$i++){

		?>

		<div class="col-sm-4">

            <div class="card-columns-fluid">

		            <div class="card  mb-5 rounded shadow">



		                <a class="card-block stretched-link text-decoration-none" href="http://localhost/Paathshaala/class/class.php?class_code=<?php echo $row_classes[$i]['class_code']; ?>" >
		                	<div class="card-header" style="background-color: black;">

		                    <h4 class="card-title" style="color: white;"><?php echo $row_classes[$i]["class_name"]; ?></h4>
</div>
		                    <p class="card-text pt-5 pl-3" style="font-size: 20px;">Class Code: <?php echo $row_classes[$i]["class_code"]; ?></p>

		                    <p class="card-text pl-3 pt-3 pb-1" style="font-size: 15px;"><small class="text-muted">Created on: <?php echo $row_classes[$i]["class_creation_date"]; ?></small></p>

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

        <h5 class="modal-title" id="exampleModalCenterTitle">Enter Details</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

    	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

      <div class="modal-body">

		

		  <div class="form-group">

		    <label for="class_code">Class Room Code:</label>

	<?php

    $counter=1;

    $db = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');

    while($counter==1){

    $command = escapeshellcmd('python class_code.py');

    $output = shell_exec($command);

	$row = "SELECT * FROM classes WHERE class_code='$output'";

	$result = mysqli_query($db,$row); //order executes

    if (mysqli_num_rows($result) == 0){

	mysqli_close($db);

	$counter=0;

	}



}







	?>



		    <input type="text" readonly class="form-control" id="class_code" name="class_code" value="<?php echo $output; ?>">

		    <small id="codehelp" class="form-text text-muted">Share this code to add students in the class</small>

		  <div class="form-group">		  </div>



		    <label for="class_name">Class Name:</label> 

		    <input type="text" class="form-control" id="class_name" name="class_name" placeholder="Class Name" required>

		  </div>

		  <div class="form-group">

		    <label for="class_creation_date">Date of Creation:</label>

		    <?php 

		    $class_creation_date=date("d-m-Y");

		    echo $class_creation_date . "<br>"; 

		    ?>

		  </div>

		  </div>

		  

      

      <div class="modal-footer">

      	<button type="submit" class="btn btn-primary">Submit</button>



      	</div>

		</form>

		



      </div>

    </div>

  </div>



<!-- Modal -->

<div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

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



		    

		    <input type="text" class="form-control" id="class_code_join" name="class_code_join" placeholder="Class Code" required>

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

	$class_code_join = $_POST["class_code_join"];	

  if ($class_code_join) {



$db = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');

$order = "SELECT * FROM members where class_code = '$class_code_join' and email = '$user'";

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

		$query = "SELECT * FROM classes WHERE class_code = '$class_code_join';";

		$result = mysqli_query($db,$query); 



		if($result->num_rows === 0)

		{?>

			<script>

	 

			alert("You have entered a wrong code!");

		  

		  </script>

		<?php }

		else { 

			$order = "INSERT INTO members

			(email, class_code,member_type) VALUES ('$user','$class_code_join','Member')";    

			$result = mysqli_query($db,$order); //order executes

			mysqli_close($db);

		}

		

	}





	

}

}



else {

  $class_name = $_POST["class_name"];

  $class_code = $_POST["class_code"];

  


$db = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');



$order = "INSERT INTO classes

      (class_code, class_name, class_creator, class_creation_date) VALUES ('$class_code', '$class_name', '$user', 

      '$class_creation_date')";    

$result = mysqli_query($db,$order); //order executes

 



  $order = "INSERT INTO members

	(email, class_code,member_type) VALUES ('$user','$class_code','Creator')";    

$result = mysqli_query($db,$order); //order executes

mysqli_close($db);

 

?>



<script type="text/javascript"> window.location.href ="teacher_dashboard.php";</script>

<?php

}





 

?>



<script type="text/javascript"> window.location.href ="teacher_dashboard.php";</script>





<?php

}

?>



      </div>

    </div>

  </div>





</body>

</html>



</body>

</html>



