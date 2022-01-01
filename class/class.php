
<?php
    session_start();
    if(isset($_SESSION["user"])){
      $user=$_SESSION["user"];

    }

    $current_class_code = htmlspecialchars($_GET["class_code"]);
    // $user="teacher2@somaiya.edu";
    // $user = "student5@gmail.com";
    // $user="student1@gmail.com";

    $creator=0;
    $db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');



    $check_creator = "SELECT * FROM members WHERE email = '$user' and class_code = '$current_class_code'and member_type IN ('Creator')";

    $result = mysqli_query($db,$check_creator);

    $row = "";

    if($result) {

        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if($row){
            $creator=1;
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
   <link rel="stylesheet" type="text/css" href="class.css">




</head>

<body>
  


    <!-- NAVBAR STARTS -->

    <nav class="navbar navbar-dark bg-primary">

      <a class="navbar-brand" href="http://localhost/Paathshaala/teacher_dashboard/teacher_dashboard.php">PATHSHALA</a>

      

      

        <!--<button class="dropdown-item" type="button" data-toggle="modal" data-target="#exampleModalCenter">Create Quiz</button>-->

        <?php



            if($creator==1) {

        ?>

        <button class="btn btn-info plusicon" type="button" id="dropdownMenuButton" data-toggle="dropdown" style="background:transparent;"><span class="fa fa-plus"></span> 

      </button>

        <div class="dropdown-menu dropdown-menu-right mr-3 mt-1">

        <a class="text-decoration-none" href="http://localhost/Paathshaala/quiz/quiz_details.php?code=<?php echo $current_class_code; ?>"><button class="dropdown-item border-bottom shadow-sm" type="button" style="font-size: 18px;">Create Quiz</button></a>

        <a class="text-decoration-none" href="http://localhost/Paathshaala/assignment/assignment.php?code=<?php echo $current_class_code; ?>"><button class="dropdown-item border-bottom pt-2 shadow-sm" type="button" style="font-size: 18px;">Create Assignment</button></a>

        <a class="text-decoration-none" href="http://localhost/Paathshaala/announcement/announcement.php?code=<?php echo $current_class_code; ?>"><button class="dropdown-item border-bottom pt-2 shadow-sm" type="button" style="font-size: 18px;">Make Announcement</button></a>

        <a class="text-decoration-none" href="http://localhost/Paathshaala/videos/uploadvideos.php?code=<?php echo $current_class_code; ?>"><button class="dropdown-item pt-2" type="button" style="font-size: 18px;">Upload Lectures</button></a>

      </div>

      <?php } else {?>
       


<a href="http://localhost/Paathshaala/assignment/scores.php?code=<?php echo $current_class_code; ?>"><button type="button" class="btn btn-primary"> View Marks </button></a>
        <?php } ?>

    </nav>

    <!-- NAVBAR ENDS -->



    <?php

    $db_quizzes = mysqli_connect('localhost','root','','paathshaala') or die('Error connecting to MySQL server.');

    

    if (!$db_quizzes) {

        die("Connection failed: " . mysqli_connect_error());

    }

    else{
        // QUIZ START
        $query_quizzes = "SELECT * FROM quizzes WHERE class_code='$current_class_code' ORDER BY create_date";

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
                     
                <div class="col-sm-7 mt-5">

                   <div class="card-columns-fluid">

                    <?php

                    for($i=0;$i<count($row_quizzes);$i++){
                        
                    ?>

                    

                                <div class="card mb-5">

                                    <p>
                                    <span class="badge badge-primary">Quiz</span>
                                        <?php if($creator==1){ ?>
                                        <a class="card-link" href="http://localhost/Paathshaala/quiz/quizdelete.php?quiz_code=<?php echo $row_quizzes[$i]["quiz_code"]; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                        
                                        <?php } ?>

                                        <h4 class="card-title pl-4 pt-3"><?php echo $row_quizzes[$i]["subject"]; ?></h4>

                                    </p>
                                    
                                    <?php if($creator==1){ ?>
                                    <a class="card-link pl-4 mb-2" href="http://localhost/Paathshaala/quiz/quizresult.php?quiz_code=<?php echo $row_quizzes[$i]["quiz_code"]; ?>">Results</a>
                                    <?php } else{ 
                                                $q_code = $row_quizzes[$i]['quiz_code'];
                                                $query_check_result = "SELECT * FROM quiz_result WHERE quiz_code='$q_code' AND email='$user'";

                                                $result_check_result = mysqli_query($db,$query_check_result);

                                                $row_check_result = "";

                                                if ($result_check_result)
                                                {
                                                    $row_check_result = mysqli_fetch_all($result_check_result, MYSQLI_ASSOC);
                                                }
                                                $valid_till = $row_quizzes[$i]["date_validity"];
                                                if ($row_check_result) {
                                                    ?>
                                                    <p class="card-text pl-4 mb-4">You have already attempted this quiz once!</p>
                                                    <?php
                                                }
                                                elseif ($valid_till<date("Y-m-d")){
                                                    ?><p class="card-text pl-4 mb-4">Quiz not valid anymore!</p><?php
                                                }
                                                else{?>
                                                    <a class="card-link pl-4 mb-2" href="http://localhost/Paathshaala/quiz/quizrespond.php?quiz_code=<?php echo $row_quizzes[$i]["quiz_code"]; ?>">Attempt Quiz</a>
                                                    <?php 
                                                }
                                            } 
                                        ?>
                                    <p class="card-text pl-4 mb-4"><small class="text-muted">Created on: <?php echo $row_quizzes[$i]["create_date"]; ?></small>

                                    <small class="text-muted ml-5 mb-4">Valid Till: <?php echo $row_quizzes[$i]["date_validity"]; ?></small>
                                    <?php if($creator==1){ ?>
                                    <a class="card-link text-decoration-none" href="http://localhost/Paathshaala/quiz/quizreschedule.php?quiz_code=<?php echo $row_quizzes[$i]["quiz_code"]; ?>"><small class="ml-5 mb-4">Reschedule</small></a>
                                    <?php } 
                                    ?>
 
                                    
                                    </p>

                                </div>

                            
                        <?php

                        }

                        ?>
                        
                        <!-- Announcement start -->
                        

                        <?php
                        $query_announcement = "SELECT * FROM announcement WHERE class_code='$current_class_code' ORDER BY date";

                        $result_announcement = mysqli_query($db_quizzes,$query_announcement);
                
                        $row_announcement = "";
                
                        if ($result_announcement)
                
                        {
                
                            $row_announcement = mysqli_fetch_all($result_announcement, MYSQLI_ASSOC);
                
                        }

                        

                    for($i=0;$i<count($row_announcement);$i++){
                        
                    ?>
                               <div class="card mb-5">
                                
                                <p>
                                <span class="badge badge-primary">Annoucement</span>
                                    <?php if($creator==1){ ?>
                                    
                                    <a class="card-link" href="http://localhost/Paathshaala/announcement/announcementdelete.php?announcement_id=<?php echo $row_announcement[$i]["annid"]; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                    
                                    <?php } ?>

                                    <h4 class="card-title pl-4 pt-3"><?php echo $row_announcement[$i]["description"]; ?></h4>

                                </p>
                                
                                <p class="card-text pl-4 mb-4"><small class="text-muted">Created on: <?php echo $row_announcement[$i]["date"]; ?> <?php echo $row_announcement[$i]["time"]; ?></small>

                                
                               
                                </p>

                            </div>

                            <?php

                        }

                        ?>
                        <!-- Announcement end -->

                        

                        <!-- Assignment start -->
                        <?php
                        $query_assignment = "SELECT * FROM assignment WHERE class_code='$current_class_code' ORDER BY date";

                        $result_assignment = mysqli_query($db_quizzes,$query_assignment);
                  
                        $row_assignment = "";
                  
                        if ($result_assignment)
                  
                        {
                  
                            $row_assignment = mysqli_fetch_all($result_assignment, MYSQLI_ASSOC);
                  
                        }

                        for($i=0;$i<count($row_assignment);$i++){
                      
                            ?>
                            <div class="card mb-5">
                            <p>
                            <span class="badge badge-primary">Assignment</span>
                            <?php if($creator==1){ ?>
                            <a class="card-link" href="http://localhost/Paathshaala/assignment/assignmentdelete.php?assignment_code=<?php echo $row_assignment[$i]["assignid"]; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                            <?php } ?>
                            <h4 class="card-title pl-4 pt-3"><?php echo $row_assignment[$i]["title"]; ?></h4>
                            <?php if ($row_assignment[$i]["description"]) {?>
                            <small class="text-muted pl-4 mb-2">Details: <?php echo $row_assignment[$i]["description"]; ?></small> 
                            <?php } ?>
                            </p>
                            <?php if($creator==1){ ?>
                            <a class="card-link pl-4 mb-2" href="http://localhost/Paathshaala/assignment/grade.php?assignment_code=<?php echo $row_assignment[$i]["assignid"]; ?>">Grade Submissions</a>
                            <?php } else{ 
                     /* $q_code = $row_quizzes[$i]['quiz_code'];
                      $query_check_result = "SELECT * FROM quiz_result WHERE quiz_code='$q_code' AND email='$user'";
          
                      $result_check_result = mysqli_query($db,$query_check_result);
          
                      $row_check_result = "";
          
                      if ($result_check_result)
                      {
                          $row_check_result = mysqli_fetch_all($result_check_result, MYSQLI_ASSOC);
                      }
                      $valid_till = $row_quizzes[$i]["date_validity"];
                      if ($row_check_result) {
                          ?>
                          <p class="card-text pl-4 mb-4">You have already attempted this quiz once!</p>
                          <?php
                      }
                      elseif ($valid_till<date("Y-m-d")){
                          ?><p class="card-text pl-4 mb-4">Quiz not valid anymore!</p><?php
                      }
                      else{?>
                          <a class="card-link pl-4 mb-2" href="http://localhost/Paathshaala/quiz/quizrespond.php?quiz_code=<?php echo $row_quizzes[$i]["quiz_code"]; ?>">Attempt Quiz</a>
                          <?php 
                      }*/
                  } 
              ?>
              <p class="card-text pl-4 mb-4"><small class="text-muted">Marks: <?php echo $row_assignment[$i]["marks"]; ?> </small>
              <p class="card-text pl-4 mb-4"><small class="text-muted">Created on: <?php echo $row_assignment[$i]["date"]; ?> <?php echo $row_assignment[$i]["time"]; ?></small>
          
              <small class="text-muted ml-5 mb-4">Due Date: <?php echo $row_assignment[$i]["duedate"]; ?></small>
              <?php if($creator==1){ ?>
              <a class="card-link text-decoration-none" href="http://localhost/Paathshaala/assignment/assignmentreschedule.php?assignment_code=<?php echo $row_assignment[$i]["assignid"]; ?>"><small class="ml-5 mb-4">Reschedule</small></a>
              <?php } 
              else { 
              $assignid = $row_assignment[$i]["assignid"];
              $query = "SELECT * FROM submission WHERE  assignid='$assignid' and email = '$user'";
          
              $result = mysqli_query($db_quizzes,$query);
          
              $row = "";
          
              if ($result)
          
              {
          
                $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
          
              }
                if (!$row) {
          
          
             ?>
             <a class="card-link text-decoration-none" href="http://localhost/Paathshaala/assignment/submission.php?assignment_code=<?php echo $row_assignment[$i]["assignid"]; ?>"><small class="ml-5 mb-4">Submit Assignment</small></a>
             <?php } 
             else  {?>
            <p class="card-text pl-4 mb-4">You have already submitted this assignment!</p>
            <?php
            }
            }?>
            </p>
          
            </div>
          
          <?php
          
          }
          
          ?>

        <!-- Assignment end -->

        <!-- Video Start -->

        <?php   
        
        $query_video = "SELECT * FROM videos WHERE class_code='$current_class_code' ORDER BY date";

        $result_video = mysqli_query($db,$query_video);

        $row_video = "";

        if ($result_video)

        {

            $row_video = mysqli_fetch_all($result_video, MYSQLI_ASSOC);

        }

    ?>
        
        

        <?php

                    for($i=0;$i<count($row_video);$i++){
                        
                    ?>
                    
                    <div class="card mb-5">
                                
                                <p>
                                <span class="badge badge-primary">Lecture Videos</span>
                                    <?php if($creator==1){ ?>
                                    
                                    <a class="card-link" href="http://localhost/Paathshaala/videos/deletevideos.php?video_id=<?php echo $row_video[$i]["video_id"]; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-trash" aria-hidden="true"></i></button></a>
                                    
                                    <?php } ?>
                                    
                                    <h4 class="card-title pl-4 pt-3"><?php echo $row_video[$i]["description"]; ?></h4>

                                </p>
                                
                                <p class="card-text pl-4 mb-4"><small class="text-muted">Created on: <?php echo $row_video[$i]["date"]; ?> <?php echo $row_video[$i]["time"]; ?></small>

                                <a class="card-link text-decoration-none" href="http://localhost/Paathshaala/videos/seevideos.php?video_id=<?php echo $row_video[$i]["video_id"]?>"><small class="ml-5 mb-4">Download Lecture / Listen into the Lecture</small></a>
                               
                                </p>

                            </div>

                            <?php

                        }

                        ?>
                        <!-- Video end -->



                        
                        </div>

                     </div>


<div class="col-sm-5">
   

<?php

	if ($creator==0){
    // 1st graph starts

	                  $db = mysqli_connect('localhost','root','','paathshaala') or
                    die('Error connecting to MySQL server.');
                    $row = "SELECT COUNT(*) FROM assignment WHERE class_code= '$current_class_code'";
                    $result = mysqli_query($db,$row);
                    
          					if ($result)
          					{
          						$total = mysqli_fetch_all($result, MYSQLI_ASSOC);
          					}  
                   
                    if($total[0]['COUNT(*)']!=0){               

                    
                    	$row1 = "SELECT COUNT(*) FROM submission WHERE email='$user' AND class_code='$current_class_code' AND status='Turned On Time'";
                    	$result1 = mysqli_query($db,$row1);
                      
                      if ($result1)
                      {
                        $submitted = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                      }                   
                      $s1= $submitted[0]["COUNT(*)"];

                    
                      $row2 = "SELECT COUNT(*) FROM submission WHERE email='$user' AND class_code='$current_class_code' AND status=' Turned In Late'";
                      $result2 = mysqli_query($db,$row2);
                      $submitted_late="";
                      if ($result2)
                      {
                        $submitted_late = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                      }                   
                      $sl1 = $submitted_late[0]["COUNT(*)"];

                      $not_submitted=$total[0]["COUNT(*)"] - ($submitted[0]["COUNT(*)"] + $submitted_late[0]["COUNT(*)"]);
                      if($s1!=0){
                     


                    ?>
                    <div id="piechart">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                    <script type="text/javascript">
                    // Load google charts
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    // Draw the chart and set the chart values
                    function drawChart() {
                      var data = google.visualization.arrayToDataTable([
                      ['Task', 'Number'],
                      ['Submitted', <?php echo $s1;?>],
                      ['Not Submitted', <?php echo $not_submitted;?>],
                      ['Submitted Late', <?php echo $sl1;?>]
                    ]);

                      // Optional; add a title and set the width and height of the chart
                      var options = {'title':'Submissions', 'width':550, 'height':400};

                      // Display the chart inside the <div> element with id="piechart"
                      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                      chart.draw(data, options);
                    }

                    </script>
                  </div>

<!-- 1ST GRAPH STUDENT ENDS -->
<?php
}
}
else{
  ?>
  <div id="piechart">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                    <script type="text/javascript">
                    // Load google charts
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    // Draw the chart and set the chart values
                    function drawChart() {
                      var data = google.visualization.arrayToDataTable([
                      ['Task', 'Number'],
                      ['Submitted', <?php echo $s1;?>],
                      ['Not Submitted', <?php echo $not_submitted;?>],
                      ['Submitted Late', <?php echo $sl1;?>]
                    ]);

                      // Optional; add a title and set the width and height of the chart
                      var options = {'title':'Submissions', 'width':550, 'height':400};

                      // Display the chart inside the <div> element with id="piechart"
                      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                      chart.draw(data, options);
                    }

                    </script>
                  </div>
<?php

}

//2nd GRAPH STUDENT STARTS



                    $row = "SELECT quiz_code FROM quizzes WHERE class_code= '$current_class_code'";
                    $result = mysqli_query($db,$row);
                    
                    if ($result)
                    {
                      $quiz_code = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    }
                         
                   
                    if($quiz_code){

                    
                    $quiz_codes=array();
                    for($i=0;$i < count($quiz_code); $i++){         
                    array_push($quiz_codes,$quiz_code[$i]["quiz_code"]);
                    }
                 


                    $ids = implode("','",$quiz_codes);

                    // print_r($ids);
                    $row1 = "SELECT email FROM quiz_result WHERE quiz_code IN ('".$ids."');";
                
                    $result1 = mysqli_query($db,$row1);
                    $sum1="";
                    if ($result1)
                    {
                      $sum1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                    }  
                    if($sum1){
                    $unique_array = array_unique($sum1, SORT_REGULAR);
                    $new_array = array_values($unique_array);
                    
                    $emails=array();
                    for($i=0;$i < count($new_array); $i++){         
                    array_push($emails,$new_array[$i]["email"]);
                    }
                    
                    // print_r($emails);

                    $row2 = "SELECT email, score_obtained, total_marks FROM quiz_result WHERE quiz_code IN ('".$ids."');";
                
                    $result2 = mysqli_query($db,$row2);
                    $sum2="";
                    if ($result2)
                    {
                      $sum2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                    }  
                    
                    $count1=0;
                    $count2=0;
                    $count3=0;
                    $count4=0;
                    $count5=0;
                    $percentage_user=0;
                    foreach ($emails as $key => $value) {
                      $total_marks=0;
                      $score_obtained=0;
                      $percent=0;
                      for ($i=0; $i < count($sum2); $i++) { 
                        if ($value==$sum2[$i]["email"]) {
                          
                          $score_obtained=$score_obtained + $sum2[$i]["score_obtained"];
                          $total_marks=$total_marks + $sum2[$i]["total_marks"];
                          
                         
                        }
                      }
                    
                     $percent=($score_obtained/$total_marks)*100;
                     // echo "Percentage" . $percent;
                     if($user==$value){
                      $percentage_user=$percent;
                     }
                     if ($percent<10){
                      $count1=$count1+1;
                     }
                     elseif($percent<45 && $percent>=10){
                      $count2=$count2+1;
                     }
                     elseif($percent>=45 && $percent<70){
                      $count3=$count3+1;
                     }
                     elseif($percent>=70 && $percent<85){
                      $count4=$count4+1;
                     }
                     else{
                      $count5=$count5+1;
                     }
                    }
                
?>

<div class="ml-1 mt-3">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff2);

      function drawStuff2() {
        var data2 = new google.visualization.arrayToDataTable([
          ['Percentage', 'Number of Students'],
          ["<10%", <?php echo $count1; ?>],
          ["10% - 44%", <?php echo $count2; ?>],
          ["45% - 69%", <?php echo $count3; ?>],
          ["70% - 84%", <?php echo $count4; ?>],
          ['>80%', <?php echo $count5; ?>]
        ]);

        var options2 = {
          // title: 'Chess opening moves',
          width: 450,
          legend: { position: 'none' },
          // chart: { title: 'Chess opening moves',
          //          subtitle: 'popularity by percentage' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: 'top', label: 'Number of Students'} // Top x-axis.
            }
          },
          bar: { groupWidth: "50%" }
        };

        var chart2 = new google.charts.Bar(document.getElementById('chart2'));
        chart2.draw(data2, options2);
      };
    </script>
    <div id="chart2" style="width: 400px; height: 300px;"></div>
<div class="d-flex justify-content-around mt-3">
    <?php echo "<b>Your percentage:  " . number_format($percentage_user,2) . "%</b>";
    ?>
    </div>
  </div>
<!-- 2ND GRAPH STUDENT ENDS -->
<?php } } }?>


  

</div>

                </div>

            </div>

        </div>
        
    <!-- END -->

<?php 
    }
    ?>

        

</body>

</html>
