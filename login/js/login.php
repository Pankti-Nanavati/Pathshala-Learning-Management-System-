<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
$emailErr =  $passerr = $wrong = "";  
$email = "";  

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
      

   
    //Email Validation   
    if (empty($_POST["email"])) {  
            $emailErr = "Email is required";  
    } 
    else {  
            $email = input_data($_POST["email"]);  
            // check that the e-mail address is well-formed  
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                $emailErr = "Invalid email format";  
            }  
     }
     
     if(!empty($_POST["password"]) && $_POST["password"] != "" ){

      if (strlen($_POST["password"]) <= '8') {
          $passerr = "Your Password Must Contain At Least 8 Digits !";
      }
      elseif(!preg_match("#[0-9]+#",$_POST["password"])) {
          $passerr = "Your Password Must Contain At Least 1 Number !";
      }
      elseif(!preg_match("#[A-Z]+#",$_POST["password"])) {
          $passerr = "Your Password Must Contain At Least 1 Capital Letter !";
      }
      elseif(!preg_match("#[a-z]+#",$_POST["password"])) {
          $passerr = "Your Password Must Contain At Least 1 Lowercase Letter !";
      }
      elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["password"])) {
          $passerr = "Your Password Must Contain At Least 1 Special Character !";
      }
  }else{
      $passerr = "";
  }
  $password = $_POST["password"];
  $hash_password = escapeshellcmd("PY.py $password");
  $hashed_output = shell_exec($hash_password);
  $db = mysqli_connect('localhost','root','','paathshaala') or 
  die('Error connecting to MySQL server.');
                      
  $row = "SELECT * FROM users WHERE email= '$email' AND password=MD5('$password')";
  $result = mysqli_query($db,$row); //order executes
                    
  if (mysqli_num_rows($result) == 0){
    $passerr = "Password entered is incorrect!";
    mysqli_close($db); 
  } 
  else{
      session_start();
      $_SESSION["user"] = $_POST["email"];
      header("location:http://localhost/Paathshaala/teacher_dashboard/teacher_dashboard.php");
      mysqli_close($db);                
                          
    }

  }

function input_data($data) {  
  $data = trim($data);  
  $data = stripslashes($data);  
  $data = htmlspecialchars($data);  
  return $data;  
}  
   
?>

    <div class="main">

        
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Log In</h2>

                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="email" placeholder="Email-ID"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" placeholder="Password"/>
                            </div>
                            <a href="forgotpassword.php">Forgot Password?</a>
                            
                            <div class="form-group form-button">
                                <input type="submit" name="submit" class="form-submit" value="Login"/>
                            </div>
                            <a href="/Paathshaala/signup/signup.php" class >Not a Member, Sign Up Now!</a>

                            <?php
                                if(isset($_POST['submit'])) {
                                    if($emailErr!=""){
                                        echo "<br>$emailErr";
                                    }
                                if($passerr!=""){
                                    echo "<br>$passerr";
                                }
                            }
    ?>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>