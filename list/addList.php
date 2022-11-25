<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    if($_REQUEST['add']){
        # id, name, desc, username
        $id = createID('LIS', $user_data['username']);
        $name = convertQuotes($_POST['list_name'], "SYMBOLS");
        $desc = convertQuotes($_POST['desc'], "SYMBOLS");
        $username = $user_data['username'];

        if(!empty($name)){
            checkTable($conn, 'LIST');

            $list_check = "
              SELECT * 
              FROM LIST 
              WHERE username = '$username'
              AND name = '$name'
            ";
                
            $list_check_result = mysqli_query($conn, $list_check);
            
            if($list_check_result && mysqli_num_rows($list_check_result) > 0)
                echo "Already logged this media";

            else {
                $query = "INSERT INTO LIST VALUES
                ('$id', '$name', '$desc', '$username')";
                
                mysqli_query($conn, $query);
                header("Location: ../acc/home.php");
                die;
            }
        }
    }    
    if($_REQUEST['cancel']){
      header('Location: ../acc/home.php'); 
      die;
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
            <form class="add-list-form" action="" method="post">
              <input name="list_name" type="text" class="input" id="list_name" autocomplete="off" placeholder="List Name*">
              <input name="desc" type="text" class="input" id="desc" autocomplete="off" placeholder="Description">
              
              <input name="add" type="submit" class="button" value="Add List">
              <input name="cancel" type="submit" class="button" value="Cancel">
            </form>
          </div>
        </div>
      </div>
    </body>
</html>