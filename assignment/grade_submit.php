<?php
    $marks = $_POST['marks'];
    $subid = htmlspecialchars($_GET["subid"]);
    $db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
    $query = "SELECT * FROM submission where subid = '$subid'";
    $result = mysqli_query($db,$query); 
    $row = "";
    if ($result){
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    if ($row) {
       $assignment_code = $row[0]['assignid'];
       $query = "UPDATE submission SET marks= '$marks' WHERE subid='$subid'";
       $result = mysqli_query($db,$query); 
       if ($result){
           header("location:http://localhost/Paathshaala/assignment/grade.php?assignment_code=".$assignment_code);
       }
    }

   
    
    ?>