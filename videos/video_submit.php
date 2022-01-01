<?php 
 	session_start();
    if(isset($_SESSION["user"])){
      $user=$_SESSION["user"];

    }
    $class_code = htmlspecialchars($_GET["code"]);
    // $user = "jai.mehta@somaiya.edu";
?>
	<?php 
	$sub_emp = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');	
		$date = date("d-m-y");
		date_default_timezone_set('Asia/Kolkata');
		$currentDateTime=date('m/d/Y H:i:s');
		$newDateTime = date('h:i A', strtotime($currentDateTime));
		$marks='65';
		$target_dir = "uploads/";
        $sub_empFileName = $target_dir . md5(time() . rand()) . '.' . strtolower(pathinfo(basename($_FILES["sub_emp"]["name"]),PATHINFO_EXTENSION));
		$description=$_POST["description"];
	    if (!move_uploaded_file($_FILES["sub_emp"]["tmp_name"], $sub_empFileName)) {
        //Show File Upload Error
        die('Error occured while uploading sub_emp');
    }
		$order = "INSERT INTO videos (file_name, email, date, time,class_code,description) VALUES ('$sub_empFileName','$user', '$date', '$newDateTime','$class_code','$description')";
		$result = mysqli_query($db,$order);
		if($result){
			header("location:http://localhost/Paathshaala/class/class.php?class_code=".$class_code);
		}
		mysqli_close($db);
		

	?>
	<?php
	}
	?>