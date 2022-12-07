<?php
session_start();

include("../gen/connect.php");
include("../gen/functions.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email_address'];
    $code = $_POST['admin_code'];

    if(!empty($username) && !empty($password) && !empty($email)){
        checkTable($conn, 'USER');

        $query = "
            SELECT * 
            FROM USER 
            WHERE (
                username = '$username'
                OR email_address = '$email'
            );";
            
        $result = mysqli_query($conn, $query);
        
        if($result && mysqli_num_rows($result) > 0)
            echo "Username or email already in use";

        else {
            if(!empty($code) && checkAdminCode($code))
              $query = "INSERT INTO USER (username, email_address, password, user_type) VALUES 
                ('$username', '$email', '$password', 'ADMIN')";
            else 
              $query = "INSERT INTO USER (username, email_address, password) VALUES 
                ('$username', '$email', '$password')";

            mysqli_query($conn, $query);
            header("Location: login.php");
            die;
        }
    }
    else {
        echo "Please give valid input.";
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <link rel="stylesheet" href="../gen/main.css" media="screen">
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
      </div>
  
      <div class="tabs-content">
        <div id="signup-tab-content" class="active">
          <form class="signup-form" action="" method="post">
            <input name="email_address" type="email" class="input" id="user_email" autocomplete="off" placeholder="Email*">
            <input name="username" type="text" class="input" id="user_name" autocomplete="off" placeholder="Username*">
            <input name="password" type="password" class="input" id="user_pass" autocomplete="off" placeholder="Password*">
            <input name="admin_code" type="text" class="input" id="user_code" autocomplete="off" placeholder="Admin Code">
            
            <input name="submit" type="submit" class="button" value="Sign Up">
          </form>
          
        </div>
      </div>
    </div>
  </body>
</html>

