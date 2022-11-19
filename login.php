<?php 
    include("connect.php");
    session_start();
    
    if(isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']); 
      
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $sql = "SELECT * FROM USER WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
	if($count == 1) {	
        header('Location: test.php');
        die;
    } 
    else {
        echo  "Your Login Name or Password is invalid";
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
              <input type="text" class="input" id="user_login" autocomplete="off" placeholder="Email or Username">
              <input type="password" class="input" id="user_pass" autocomplete="off" placeholder="Password">
    
              <input type="submit" class="button" value="Login">
            </form><!--.login-form-->
          </div><!--.login-tab-content-->
        </div><!--.tabs-content-->
      </div><!--.form-wrap-->
    </body>
</html>