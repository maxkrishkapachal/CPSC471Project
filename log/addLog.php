<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    if($_REQUEST['add']){
        $remarks = convertQuotes($_POST['remarks'], "SYMBOLS");
        $rating = $_POST['rating'];
        $date = getDateTime();
        $id = createID('LOG', $user_data['username']);
        $username = $user_data['username'];
        $media = convertQuotes($_POST['media_name'], "SYMBOLS");

        if(!empty($media) && !empty($rating)){
            checkTable($conn, 'MEDIA');
            $mediaID = "
              SELECT ID
              FROM MEDIA
              WHERE title = '$media'; 
            ";

            $media_result = mysqli_query($conn, $mediaID);

            if($media_result && mysqli_num_rows($media_result) == 1){
                $media_struct = mysqli_fetch_assoc($media_result);
                $mediaID = $media_struct['ID'];
            }
            else
                $mediaID = "UNKNOWN";

            checkTable($conn, 'LOGS');

            $log_check = "
              SELECT * 
              FROM LOGS 
              WHERE username = '$username'
              AND mediaID = '$mediaID'
              AND mediaID <> 'UNKNOWN'";
                
            $log_check_result = mysqli_query($conn, $log_check);
            
            if($log_check_result && mysqli_num_rows($log_check_result) > 0)
                echo "Already logged this media";

            else {
                $query = "INSERT INTO LOGS VALUES
                  ('$id', '$date', '$remarks', '$rating', '$mediaID', '$username', '$media')";
                
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
            <form class="add-log-form" action="" method="post">
              <input name="media_name" type="text" class="input" id="media_name" autocomplete="off" placeholder="Title*">
              <input name="remarks" type="text" class="input" id="log_remarks" autocomplete="off" placeholder="What did you think?">
              <input name="rating" type="number" class="input" id="log_rating" autocomplete="off" placeholder="?/10*">
    
              <input name="add" type="submit" class="button" value="Add Log">
              <input name="cancel" type="submit" class="button" value="Cancel">
            </form>
          </div>
        </div>
      </div>
    </body>
</html>