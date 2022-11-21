<?php
session_start();

include("connect.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email_address'];

    if(!empty($username) && !empty($password) && !empty($email)){
        $query = "INSERT INTO USER (username, email_address, password) VALUES 
            ('$username', '$email', '$password')";

        mysqli_query($conn, $query);
        header("Location: login.php");
        die;
    }
    else {
        echo "Please give valid input.";
    }
}

// if(isset($_SESSION['username'])) {
//     $user = $_SESSION['username'];
//     $query = "SELECT * FROM USER WHERE username = '$user'";

//     $result = mysqli_query($conn, $query);

//     if($result && mysqli_num_rows($result) > 0){
//         $user_data = mysqli_fetch_assoc($result);
//     }

//     header("Location: login.php");
//     die;
// }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <link rel="stylesheet" href="main.css" media="screen">
  <head>
        <meta charset="utf-8">
        <title></title>
  </head>
  <body>
  <?php
    
    ?>
    <div class="form-wrap">
      <div class="tabs">
        <h3 class="signup-tab"><a class="active">Sign Up</a></h3>
        <h3 class="login-tab"><a href="login.php">Login</a></h3>
      </div><!--.tabs-->
  
      <div class="tabs-content">
        <div id="signup-tab-content" class="active">
          <form class="signup-form" action="" method="post">
            <input name="email_address" type="email" class="input" id="user_email" autocomplete="off" placeholder="Email">
            <input name="username" type="text" class="input" id="user_name" autocomplete="off" placeholder="Username">
            <input name="password" type="password" class="input" id="user_pass" autocomplete="off" placeholder="Password">
            <input name="submit" type="submit" class="button" value="Sign Up">
          </form><!--.login-form-->
          
        </div><!--.signup-tab-content-->
      </div><!--.tabs-content-->
    </div><!--.form-wrap-->
  </body>
</html>

