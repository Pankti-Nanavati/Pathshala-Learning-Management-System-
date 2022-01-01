<?php
session_start();
    if(isset($_SESSION["user"])){
      $user=$_SESSION["user"];

    }
    $assignment_code = htmlspecialchars($_GET["assignment_code"]);
    $db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
		$query = "SELECT * FROM assignment WHERE assignid='$assignment_code'";
		$result = mysqli_query($db,$query);
		$row = "";
		if($result) {
		
			$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
			if($row){
				$class_code = $row[0]["class_code"];
				
			}
    }
  
    mysqli_close($db);
    // $user ="teacher2@somaiya.edu";
    //$user="jai.mehta@somaiya.edu";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Dashboard</title>
        <link rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <nav class="navbar navbar-dark bg-primary">
	  <a class="navbar-brand" href="http://localhost/Paathshaala/teacher_dashboard/teacher_dashboard.php">PATHSHALA</a>
	  	<ul class="navbar-nav mr-auto">
		  <li class="nav-item active">
	        <a class="nav-link" href="http://localhost/Paathshaala/class/class.php?class_code=<?php echo $class_code;?>" title="Return to previous page">BACK TO CLASS<span class="sr-only">(current)</span></a>
	      </li>
  		</ul>
	</nav>
    
    </head>
    <body>
        <?php 
        $marksErr = $marks ="";
       
          
           
            $db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
            $query = "SELECT * FROM submission where assignid = '$assignment_code'";
          
            $result = mysqli_query($db,$query); 
           
            $row = "";
           
            if ($result){
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_close($db);
            
        
        ?>
        
        <br>
        <br>
        <br>
        <div class=container>
        <table class="table table-hover">
            <thead>
                <tr class="bg-primary" style="color:white">
                  <th scope="col">No.</th>
                  <th scope="col">Student Name</th>
                  <th scope="col">Student Email</th>
                  <th scope="col">File</th>
                  <th scope="col">Status</th>
                  <th scope="col">Marks</th>
                  <th scope="col">Enter Marks</th>
                  <th scope="col">Grade</th>
                  
                </tr>
            </thead>
            <tbody>
                      <?php  
                      
                      if($row){
                      for($i=0;$i<count($row);$i++){
                        $db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
                        $user1 = $row[$i]["email"];
                        $query1 = "SELECT * FROM users WHERE email='$user1'";
                        $result1 = mysqli_query($db,$query1);
                        $row1= "";
                        if ($result1) {
                          $row1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                          if($row1){
                            $fname = $row1[0]["fname"];
                            $lname = $row1[0]["lname"];
                            
                          }

                        }
                        mysqli_close($db);
                        $student_name = $fname . ' ' . $lname;
                          ?>
                          
                          <tr>
                          <td><?php echo ($i+1);?></td>
                          <td><?php echo $student_name;?></td>
                        <td><?php echo $row[$i]["email"];?></td>
                        <?php $id = $row[$i]["subid"]?>
                        <td><a href="http://localhost/Paathshaala/assignment/<?php echo $row[$i]["file_name"];?>" target="_blank">
                          View file</a></td>
                          <td><?php echo $row[$i]["status"];?></td>
                        <td><?php echo $row[$i]["marks"];?></td>
                        <?php if ($row[$i]['marks']!=NULL) {?>
                        <td><form method="POST"><input type="number" name="marks" id="marks" placeholder="Enter Marks" disabled></form>
                        <?php  } else { $subid =$row[$i]['subid']?>
                          
                        <td><form method="POST" action="grade_submit.php?subid=<?php echo $subid?>" enctype="multipart/form-data"><input type="number" name="marks" id="marks" placeholder="Enter Marks">
                        <?php  }  ?>
                        
                        <?php if ($row[$i]['marks']!=NULL) {?>
                            <td><input type="button" class="btn btn-success" id="mybutton" value="Graded" disabled></td>
                              <?php  } else { ?>
                                
                              <td>  <input class="btn btn-primary" type="submit" name="submit" value="Grade"></td></form>
                                  <?php  }  ?>
    
                          </tr>
                      <?php 
                          }}
                      ?>
                      
                      
    
    
                      
            </tbody>
        </table>
        </div>
        <?php 
           }
        ?>
        
        
        
    
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>