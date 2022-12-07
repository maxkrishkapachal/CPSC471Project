<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    if(isset($_REQUEST['add'])){
        $name = convertQuotes($_POST['name'], "SYMBOLS");
        $desc = convertQuotes($_POST['desc'], "SYMBOLS");

        if(!empty($name)){
            checkTable($conn, 'PUBLISHER');

            $name_check = "
              SELECT *
              FROM PUBLISHER
              WHERE name = '$name'; 
            ";

            $name_result = mysqli_query($conn, $name_check);

            if($name_result && mysqli_num_rows($name_result) == 0){
                $query = "
                    INSERT 
                    INTO PUBLISHER 
                    VALUES
                    ('$name', '$desc')
                ";
                
                mysqli_query($conn, $query);
                header("Location: ../acc/search.php");
                die;
            }
        }
    } 
    if(isset($_REQUEST['cancel'])){
        header('Location: ../acc/search.php'); 
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
                <form class="add-publisher-form" action="" method="post">
                <input name="name" type="text" class="input" id="name" autocomplete="off" placeholder="Name*">
                <input name="desc" type="text" class="input" id="description" autocomplete="off" placeholder="Description">

                <input name="add" type="submit" class="button" value="Add Publisher">
                <input name="cancel" type="submit" class="button" value="Cancel">
                </form>
            </div>
            </div>
        </div>
    </body>
</html>