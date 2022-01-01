<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="profile.css">

  <nav class="navbar navbar-dark bg-primary">
	  <a class="navbar-brand" href="http://localhost/Paathshaala/teacher_dashboard/teacher_dashboard.php">PATHSHALA</a>
	  	<ul class="navbar-nav mr-auto">
		  <li class="nav-item active">
	        <a class="nav-link" href="http://localhost/Paathshaala/profile/profile.php" title="Return to previous page">BACK TO PROFILE<span class="sr-only">(current)</span></a>
	      </li>
  		</ul>
	</nav>
    <title>See Videos</title>
</head>
</head>

<body>
<?php
function input_data($data) {  
  $data = trim($data);  
  $data = stripslashes($data);  
  $data = htmlspecialchars($data);  
  return $data;  
}  
?>   
<br><br>
<form><center>
	<?php
	$db = mysqli_connect('localhost','root','','paathshaala') or 
	die('Error connecting to MySQL server.');
    $email_loggedin=$_SESSION["user"];
	//$email_loggedin = $_SESSION["email"];
	$query = "SELECT * from users where email = '$email_loggedin';";
	$result = mysqli_query($db,$query);
	while($row=mysqli_fetch_assoc($result))
    {
        echo 'Email:<br> <input type="text" value='.$row['email'].'><br>';
        mysqli_close($db);
		
	}
	
	?>

</form></center>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<center><br>Password<br><input type="password" name="new_password" placeholder="Enter New Password"><br><br>
Confirm Password<br><input type="password" name="re_new_password" placeholder="Confirm New Password"><br>

<input type="submit" name="submit" value="Submit" class="loginbutton"></center></form>

<?php
$new_password_Err="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$new_password=$_POST["new_password"];
/*echo $_POST["new_password"];
echo $new_password;*/
//$email=$_SESSION["email"];
/*echo $email;*/
$re_new_password=$_POST["re_new_password"];
	
	if(!empty($_POST["new_password"]) && !empty($_POST["re_new_password"])){
		if ($_POST["new_password"]!=$_POST["re_new_password"]) {
			$new_password_Err=  "Passwords does not match!"."<br>";
		}
		else{
			$db = mysqli_connect('localhost','root','','paathshaala') or 
			die('Error connecting to MySQL server.');

            $query = "UPDATE users SET `password` = MD5('$new_password') WHERE `email`='$email_loggedin'";
            /*echo $query;*/


            $result = mysqli_query($db,$query);	//order executes
            /*echo $result;*/
			if($result){
				echo("<br><p>Password change successful!<br></p>");
				mysqli_close($db);
				
			} else{
				echo("<br><p>Try Again!<br></p>");
			}

				

		}
	}
	else{
        $new_password_Err = "Please fill the required fields!";
        echo "$new_password_Err";
		}

	}
	
?>	
      





	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
  





</body>
</html>