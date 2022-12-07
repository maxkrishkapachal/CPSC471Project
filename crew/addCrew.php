<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    if($_REQUEST['add']){
        $name = convertQuotes($_POST['name'], "SYMBOLS");
        $desc = convertQuotes($_POST['desc'], "SYMBOLS");
        $id = createID('CRE', $user_data['username']);

        if(!empty($name)){
            checkTable($conn, 'CREW');

            $query = "INSERT INTO CREW VALUES
                ('$id', '$name', '$desc')";
            
            mysqli_query($conn, $query);
            header("Location: ../acc/home.php");
            die;
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
            <form class="add-crew-form" action="" method="post">
              <input name="name" type="text" class="input" id="name" autocomplete="off" placeholder="Name*">
              <input name="desc" type="text" class="input" id="desc" autocomplete="off" placeholder="Desc">
              
              <input name="add" type="submit" class="button" value="Add Crew">
              <input name="cancel" type="submit" class="button" value="Cancel">
            </form>
          </div>
        </div>
      </div>
    </body>
</html>