<!DOCTYPE html>  
<html>  
<head>  
<title>Mini Project</title>
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
// define variables to empty values  
$emailErr = $passerr = "";  
$email = "";  
  
//Input fields validation  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
      

   
    //Email Validation   
    if (empty($_POST["email"])) {  
            $emailErr = "Email is required";  
    } else {  
            $email = input_data($_POST["email"]);  
            // check that the e-mail address is well-formed  
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                $emailErr = "Invalid email format";  
            }  
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
                <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                
            </div>

            <div class="signin-form">
                <h2 class="form-title">Change Password</h2>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                    <div class="form-group">
                        <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="email" name="email" placeholder="Email-ID"/>
                    </div>
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $email=$_POST["email"];
                        $db = mysqli_connect('localhost','root','','paathshaala') or 
                        die('Error connecting to MySQL server.');
                        $n=10;
                        function getName($n) {
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $randomString = '';

                        for ($i = 0; $i < $n; $i++) {
                            $index = rand(0, strlen($characters) - 1);
                            $randomString .= $characters[$index];
                        }

                        return $randomString;
                        }
                        $password = getName($n);
                        $password = '@'.$password.'5';
                        $order = "UPDATE users SET password = MD5('$password') WHERE email='$email';";
                        $result = mysqli_query($db,$order);
                        $st="Your New Passwors is ".$password. ".You can reset to your own choice password once Logged into the system from Profile Section";
                        require_once('PHPMailer/PHPMailerAutoload.php');

                          $mail= new PHPMailer();
                          $mail->isSMTP();
                          $mail->SMTPAuth = true;
                          $mail->SMTPSecure ='ssl';
                          $mail->Host ='smtp.gmail.com';
                          $mail->Port = '465';
                          $mail->isHTML();
                          $mail->Username = 'paathshaala.reset@gmail.com';
                          $mail->Password = 'Paathshaala99';
                          $mail->SetFrom('noreply@pathshala.org');
                          $mail->Subject = 'Paathshala Password';
                          $mail->Body = $st;
                          $mail->addAddress($email);
                        
                          $mail->Send();
                          echo "New Password has been sent to the given Email-ID. If you haven't received it please check it under spam folder.";                                     
                        
                        
                      }
                      ?>
                    <div class="form-group form-button">
                        <input type="submit" name="submit" class="form-submit" value="Send Email"/>
                    </div>

                </form>

<br?><br>
<a href="login.php">Login Now!</a>
            </div>
        </div>
    </div>
</section>

</div>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>  
</html>