<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    $mediaID = $_SESSION['id'];

    checkTable($conn, 'MEDIA');
    $media_query = "
      SELECT *
      FROM MEDIA
      WHERE ID = '$mediaID'; 
    ";

    $media_result = mysqli_query($conn, $media_query);

    if($media_result && mysqli_num_rows($media_result) == 1){
        $media_struct = mysqli_fetch_assoc($media_result);
        $title = $media_struct['title'];
    }

    if(isset($_REQUEST['add'])){
        $id = createID('LOG', $user_data['username']);
        $date = getDateTime();
        $remarks = convertQuotes($_POST['remarks'], "SYMBOLS");
        $rating = $_POST['rating'];
        $username = $user_data['username'];

        checkTable($conn, 'LOGS');

        $log_check = "
          SELECT * 
          FROM LOGS 
          WHERE username = '$username'
          AND mediaID = '$mediaID'
        ";
            
        $log_check_result = mysqli_query($conn, $log_check);
        
        if($log_check_result && mysqli_num_rows($log_check_result) > 0)
            echo "Already logged this media";

        else {
            $query = "
              INSERT 
              INTO LOGS 
              VALUES
              ('$id', '$date', '$remarks', '$rating', '$mediaID', '$username')
            ";
            
            mysqli_query($conn, $query);

            $query = "
              UPDATE MEDIA
              SET ranking = (
                SELECT AVG(rating) AS rating 
                FROM LOGS 
                WHERE mediaID = '$mediaID'
              )
              WHERE ID = '$mediaID'
            ";

            mysqli_query($conn, $query);

            header("Location: ../acc/home.php");
            die;
        }
    }
    if(isset($_REQUEST['cancel'])){
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
              <div class='media-title-div'>
                <label class='media-title'>Add <?php echo $title ?>?</label>
              </div>
              
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