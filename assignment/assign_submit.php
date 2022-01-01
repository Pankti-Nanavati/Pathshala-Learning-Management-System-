<?php
 session_start();
    if(isset($_SESSION["user"]))
    {
      $user=$_SESSION["user"];

    }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

	$current_class_code = htmlspecialchars($_GET["code"]);
    // $user = "pankti.n@somaiya.edu";

    $title = $desc = $marks  = "";
$titleErr = $marksErr = $due_dateErr = "";
if (empty($_POST["title"])) {
    $titleErr = "Title is required";
  } else {
  $title = test_input($_POST["title"]);
  $title = trim($title," ");
  }
  
  //description validation
  
  $desc = test_input($_POST["desc"]);
  $desc = trim($desc," ");
  
  
  //marks validation
  if (empty($_POST["marks"])) {
    $marksErr = "Total Marks is required";
  } else {
  $marks = test_input($_POST["marks"]);
  $marks = trim($marks," ");
  }
  
  //date validation
  $due_date = $_POST["duedate"];
  $date = date("d-m-y");
  //echo $due_date;
  //echo '<br>';
  //echo $date;
  
  
    if($titleErr == ""  && $marksErr == "" && $due_dateErr == "" ){

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
        $date = date("d-m-y");
        date_default_timezone_set('Asia/Kolkata');
        $currentDateTime=date('m/d/Y H:i:s');
        $newDateTime = date('h:i A', strtotime($currentDateTime));
              $db = mysqli_connect('localhost','root','','Paathshaala') or 
              die('Error connecting to MySQL server.');
              $assignment = "INSERT INTO assignment
                      (title, description, marks, duedate, email, date, time,assignid,class_code)
                      VALUES
                      ('$title', '$desc', '$marks' , '$due_date','$user','$date','$newDateTime','$output','$current_class_code')";
              $result = mysqli_query($db,$assignment); 
              mysqli_close($db);
              header("location:http://localhost/Paathshaala/class/class.php?class_code=".$current_class_code);
      }
else {
    header("location:http://localhost/Paathshaala/assignment/assignment.php?code=".$current_class_code);
}
    ?>
