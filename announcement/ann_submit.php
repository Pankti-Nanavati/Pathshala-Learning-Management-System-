<?php
 session_start();
    if(isset($_SESSION["user"])){
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
    echo $current_class_code;
    $ann = $_POST["ann"];
    $ann = trim($ann," "); 
    if ($ann=="") {
        header("location:http://localhost/Paathshaala/announcement/announcement.php?code=".$current_class_code);
    }
else {
    $ann = test_input($ann);
    $ann = trim($ann," "); 
    $db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
    $counter=1;
    while($counter==1){

    $command = escapeshellcmd('python class_code.py');

    $output = shell_exec($command);

    $row = "SELECT * FROM announcement WHERE annid='$output'";

    $result = mysqli_query($db,$row); //order executes

    if (mysqli_num_rows($result) == 0){

    mysqli_close($db);

    $counter=0;

    
    }


}



 $date = date("Y-m-d");
  date_default_timezone_set('Asia/Kolkata');
  $currentDateTime=date('m/d/Y H:i:s');
  $newDateTime = date('h:i A', strtotime($currentDateTime));
  
  echo $ann; 
  echo '<br>';
  echo $user;
  echo '<br>';
  echo $date;
  echo '<br>';
  echo $newDateTime;
  echo '<br>';
  echo $output;
  echo '<br>';
  echo $current_class_code;
  

        $db = mysqli_connect('localhost','root','','Paathshaala') or 
        die('Error connecting to MySQL server.');
        $announcement = "INSERT INTO announcement(description, email, date, time, annid, class_code) VALUES ('$ann','$user','$date','$newDateTime','$output','$current_class_code')";
        $result = mysqli_query($db,$announcement); 
        mysqli_close($db);
        header("location:http://localhost/Paathshaala/class/class.php?class_code=".$current_class_code);
}
?>