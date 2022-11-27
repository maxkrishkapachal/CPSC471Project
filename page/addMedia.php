<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    if($_REQUEST['add']){
        $id = createID('MED', $user_data['username']);
        $title = convertQuotes($_POST['title'], "SYMBOLS");
        $rd = convertQuotes($_POST['release_date'], "SYMBOLS");
        $desc = convertQuotes($_POST['description'], "SYMBOLS");

        if(!empty($title)){
            checkTable($conn, 'MEDIA');
            $title_check = "
              SELECT ID
              FROM MEDIA
              WHERE title = '$title'; 
            ";

            $title_result = mysqli_query($conn, $title);

            if($title_result && mysqli_num_rows($title_result) == 0){
                $query = "INSERT INTO CREW (ID, release_date, title, description) VALUES
                    ('$id', '$rd', '$title', $description)";
                
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
                <form class="add-media-form" action="" method="post">
                <input name="title" type="text" class="input" id="title" autocomplete="off" placeholder="Title*">
                <input name="release_date" type="text" class="input" id="release_date" autocomplete="off" placeholder="Release Date">
                <input name="description" type="text" class="input" id="description" autocomplete="off" placeholder="Description">
                
                <input name="add" type="submit" class="button" value="Add Media">
                <input name="cancel" type="submit" class="button" value="Cancel">
                </form>
            </div>
            </div>
        </div>
    </body>
</html>