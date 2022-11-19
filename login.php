<?php 
    session_start();

    include("connect.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user_or_email = $_POST['user_or_email'];
        $password = $_POST['password'];
    
        if(!empty($user_or_email) && !empty($password)){
            
            $query = "
                SELECT * 
                FROM USER 
                WHERE (
                    username = '$user_or_email'
                    OR email_address = '$user_or_email'
                );";
            
            $result = mysqli_query($conn, $query);
            
            if($result && mysqli_num_rows($result) > 0){
                $user_data = mysqli_fetch_assoc($result);
                
                if($user_data['password'] == $password){
                    
                    $_SESSION['username'] = $user_data['username'];
                    header("Location: index.php");
                    die;
                }
            }
        }
        else {
            echo "Please give valid input.";
        }
    }    
?> 

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <link rel="stylesheet" href="login-signup.css" media="screen">
  <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        
      <div class="form-wrap">
        <div class="tabs">
          <h3 class="signup-tab"><a href="signup.php">Sign Up</a></h3>
          <h3 class="login-tab"><a class="active">Login</a></h3>
        </div>
        <div class="tabs-content">
          <div id="login-tab-content" class="active">
            <form class="login-form" action="" method="post">
              <input name="user_or_email" type="text" class="input" id="user_login" autocomplete="off" placeholder="Email or Username">
              <input name="password" type="password" class="input" id="user_pass" autocomplete="off" placeholder="Password">
    
              <input name="submit" type="submit" class="button" value="Login">
            </form><!--.login-form-->
          </div><!--.login-tab-content-->
        </div><!--.tabs-content-->
      </div><!--.form-wrap-->
    </body>
</html>