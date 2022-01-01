<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form </title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    $first_nameErr = $last_nameErr = $DOBErr = $email_idErr = $gender = $password = $confirm_password = "";
    $first_name = $last_name = $DOB = $email_id = $genderErr = $passwordErr = $confirm_passwordErr = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //first name validation
      if (empty($_POST["first_name"])) {
        $first_nameErr = "First Name is required";
      } else {
        $first_name = test_input($_POST["first_name"]);
        $first_name = trim($first_name," ");
        $first_name = ucwords($first_name);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$first_name) || str_word_count($first_name)>1) {
          $first_nameErr = "Enter a valid First Name";
          $first_name = "";
        }
      }
    
      //last name validation
      if (empty($_POST["last_name"])) {
        $last_nameErr = "Last Name is required";
      } else {
        $last_name = test_input($_POST["last_name"]);
        $last_name = trim($last_name," ");
        $last_name = ucwords($last_name);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$last_name) || str_word_count($last_name)>1) {
          $last_nameErr = "Enter a valid Last Name";
          $last_name = "";
        }
      }
      
      //date of birth validation
      if (empty($_POST["DOB"])) {
        $DOBErr = "Date of Birth is required";
      } else {
        $DOB = test_input($_POST["DOB"]);
        $date = date("d/m/yy");
        $DOB_arr  = explode('/', $DOB);
      if (!checkdate($DOB_arr[1], $DOB_arr[0], $DOB_arr[2])) {
          $DOBErr = "Enter Valid Date of Birth";
      }
        //$DOB_t = strtotime($DOB);
        //$date_t = strtotime($date);
        //if($DOB_t >= $date_t)
        //{
            //$DOBErr = "Enter Valid Date of Birth 2";
        //}
        }
      
      
        
    
    
      //email validation
      $db = mysqli_connect('localhost','root','','Paathshaala') or die('Error connecting to MySQL server.');
      $email_id = test_input($_POST["email_id"]);
      $row = "SELECT * FROM users WHERE email='$email_id'";
      $result = mysqli_query($db,$row); //order executes
      if (mysqli_num_rows($result) == 0){
        mysqli_close($db);
      if (empty($_POST["email_id"])) {
        $email_idErr = "Email is required";
      } else {
        $email_id = test_input($_POST["email_id"]);
        if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
          $email_idErr = "Invalid email format";
          $email_id = "";
        }
      }
    }
    else {
      $email_idErr = "This email id has already been registered";
    }
     
      
    $member_type = $_POST['member_type'];
        
      //Gender validation
    
      if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
      } else {
        $gender = test_input($_POST["gender"]);
      }
        
    // password validation
    
    if(!empty($_POST["password"])){
        if ($_POST["password"]!=$_POST["confirm_password"]) {
            $confirm_passwordErr .=  "Passowrd and Confirm Password does not match!"."<br>";
        }
        if (strlen($_POST["password"]) < '8') {
            $passwordErr .= "Your Password Must Contain At Least 8 Characters!"."<br>";
        }
        elseif(!preg_match("#[0-9]+#",$_POST["password"])) {
            $passwordErr .= "Your Password Must Contain At Least 1 Number!"."<br>";
        }
        elseif(!preg_match("#[A-Z]+#",$_POST["password"])) {
            $passwordErr .= "Your Password Must Contain At Least 1 Uppercase Letter!"."<br>";
        }
        elseif(!preg_match("#[a-z]+#",$_POST["password"])) {
            $passwordErr .= "Your Password Must Contain At Least 1 Lowercase Letter!"."<br>";
        }
        elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["password"])) {
            $passwordErr .= "Your Password Must Contain At Least 1 Special Character!"."<br>";
        }
    }else{
        $passwordErr .= "Please Enter your password"."<br>";
    }
        
    
    //$cookie_value = $email_id;
    //setcookie('user', $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    //header("location:http://localhost/wp_mini_proj/signup_form/cookie_set.php");
    
    if ($first_nameErr=="" && $last_nameErr=="" && $DOBErr =="" && $email_idErr =="" && $genderErr =="" && $passwordErr =="" && $confirm_passwordErr =="")
    {
    //$cookie_value = $email_id;
    //setcookie('email', $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    //$_SESSION["firstname"] = $first_name;
    //$_SESSION["lastname"] = $last_name;
    //$_SESSION["emailid"] = $email_id;
    //$_SESSION["department"] = $department;
    //header("location:http://localhost/wp_mini_proj/signup_form/session_set.php");
    $password = $_POST['password'];
    $password = md5($password);
    //$hash_password = escapeshellcmd("python PY.py $password");
    //$hashed_output = shell_exec($hash_password);




    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['DOB'];
    $email = $_POST['email_id'];
    $gender = $_POST['gender'];
    $member_type = $_POST['member_type'];
    
    
    $db = mysqli_connect('localhost','root','','Paathshaala');
    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }
    else {
        $sql = "INSERT INTO users VALUES ('$first_name','$last_name', '$dob', '$gender', '$email','$member_type','$password')";
        if (mysqli_query($db, $sql)) {
            mysqli_close($db);
            
            header("location:http://localhost/Paathshaala/login/login.php");
            
    }
    else { mysqli_close($db);?>
        <div class="container-fluid">
            <div class="alert alert-danger">
                <strong>Authentication Failed!</strong> 
        </div>
        <?php
    }
    
    
    }
    }
    }
    
    
    
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    ?> 


    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="first_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="first_name" id="first_name" placeholder="Your First Name" value="<?php echo $first_name?>"/>
                                <span class="error" style="color:red;"><?php echo $first_nameErr;?></span>
                            </div>
                            <div class="form-group">
                                <label for="last_name"><i class="zmdi zmdi-account-o material-icons-name"></i></label>
                                <input type="text" name="last_name" id="last_name" placeholder="Your Last Name" value="<?php echo $last_name?>"/>
                                <span class="error" style="color:red;"><?php echo $last_nameErr;?></span>
                            </div>
                            <div class="form-group">
                                <label for="DOB"><i class="zmdi zmdi-calendar material-icons-name"></i></label>
                                <input type="text" name="DOB" id="DOB" placeholder="dd/mm/yyyy" value="<?php echo $DOB?>"/>
                                <span class="error" style="color:red;"><?php echo $DOBErr;?></span>
                            </div>
                            <div class="form-group">
                                <label for="email_id"><i class="zmdi zmdi-email material-icons-name"></i></label>
                                <input type="email_id" name="email_id" id="email_id" placeholder="Your Email" value="<?php echo $email_id?>"/>
                                <span class="error" style="color:red;"><?php echo $email_idErr;?></span>
                            </div>
                            <div class="form-group" >
                            
                            <table>
                                <tbody>
                                    <tr>
                                    <td><i class="zmdi zmdi-male-female material-icons-name"></i></td>
                                    <td>  </td>
                                    <td>Gender: </td>
                                    <?php if ($gender == 'male') {?>
                                      <td><input type="radio"  name="gender" id="gender" value="male" checked></td>
                                    <?php } else { ?> 
                                      <td><input type="radio"  name="gender" id="gender" value="male" ></td>
                                    <?php } ?>
                                    <td>  </td>
                                    <td>Male </td>
                                    <?php if ($gender == 'female') {?>
                                      <td><input type="radio"  name="gender" id="gender" value="female" checked></td>
                                    <?php } else { ?> 
                                      <td><input type="radio"  name="gender" id="gender" value="female" ></td>
                                    <?php } ?>
                                    <td>  </td>
                                    <td> Female </td>
                                    <?php if ($gender == 'other') {?>
                                      <td><input type="radio"  name="gender" id="gender" value="other" checked></td>
                                    <?php } else { ?> 
                                      <td><input type="radio"  name="gender" id="gender" value="other" ></td>
                                    <?php } ?>
                                    <td>  </td>
                                    <td>Other</td>
                                    </tr>
                                    <tr>
                                    <span class="error" style="color:red; width: 150px;"><?php echo $genderErr;?></span>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            <div class="form-group">
                            <table>
                                <tbody>
                                    <tr>
                                    <td><i class="zmdi zmdi-accounts material-icons-name"></i></label></td>
                                    <td> Member type: </td>
                                    <td>
                                            <select class="form-control" style=" width: 150px; margin: 10px; padding:2px;" name="member_type" id="member_type">
                                            <?php if ($member_type =='Teacher')  { ?>
                                              	<option value="Teacher" selected >Teacher</option>
                                            <?php } 
                                            else { ?>
                                              <option value="Teacher" >Teacher</option>
                                            <?php }   ?>    
                                            <?php if ($member_type =='Student')  { ?>
                                              	<option value="Student" selected >Student</option>
                                            <?php } 
                                            else { ?>
                                              <option value="Student" >Student</option>
                                            <?php }   ?>    
      												
                                                         </select>
                                                        </td>
                                                        </tr>
                                </tbody>
                            </table>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock material-icons-name"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $password?>"/>
                                <span class="error"   style="color:red;"><?php echo $passwordErr;?></span>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password"><i class="zmdi zmdi-lock-outline material-icons-name"></i></label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Repeat your password" value="<?php echo $confirm_password?>"/>
                                <span class="error" style="color:red;"><?php echo $confirm_passwordErr;?></span>
                            </div>
                            
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="/Paathshaala/login/login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>

       
    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

