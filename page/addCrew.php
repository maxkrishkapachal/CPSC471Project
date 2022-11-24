<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = convertQuotes($_POST['name'], "SYMBOLS");
        $role = convertQuotes($_POST['role'], "SYMBOLS");
        $id = createID('CRE', $user_data['username']);

        if(!empty($name) && !empty($role)){
            checkTable($conn, 'CREW');

            $query = "INSERT INTO CREW VALUES
                ('$id', '$name', '$role')";
            
            mysqli_query($conn, $query);
            header("Location: ../acc/home.php");
            die;
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
        
      <div class="form-wrap">
        <div class="tabs-content">
          <div class="active">
            <form class="add-crew-form" action="" method="post">
              <input name="name" type="text" class="input" id="name" autocomplete="off" placeholder="Name*">
              <input name="role" type="text" class="input" id="role" autocomplete="off" placeholder="Role*">
              
              <input name="add" type="submit" class="button" value="Add Crew">
              <input name="cancel" type="button" onclick="header('Location: \'../acc/home.php\''); die;" class="button" value="Cancel">
            </form>
          </div>
        </div>
      </div>
    </body>
</html>