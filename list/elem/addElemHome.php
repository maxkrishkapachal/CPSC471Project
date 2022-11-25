<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    if($_REQUEST['add']){
        # listID, mediaID (from media title), username
        # here, the list ID would be passed along with the $_SESSION value
        # we would do that in the list page, so it can't do anything yet.
        $listID = $_SESSION['current_list'];
        $media = convertQuotes($_POST['title'], "SYMBOLS");
        $username = $user_data['username'];

        if(!empty($media)){
            checkTable($conn, 'MEDIA');
            $mediaID = "
              SELECT ID
              FROM MEDIA
              WHERE title = '$media'; 
            ";

            $media_result = mysqli_query($conn, $media);

            if($media_result && mysqli_num_rows($media_result) == 1){
                $media_struct = mysqli_fetch_assoc($media_result);
                $mediaID = $media_struct['ID'];
            }
            else
                $mediaID = "UNKNOWN";
        
            checkTable($conn, 'ELEMENT');

            $element_check = "
            SELECT * 
            FROM ELEMENT
            WHERE username = '$username'
            AND listID = '$listID'
            AND (
                mediaID = '$mediaID'
                OR media_name = '$media'
            )";
                
            $element_check_result = mysqli_query($conn, $element_check);
            
            if($element_check_result && mysqli_num_rows($element_check_result) > 0)
                echo "Already listed this media";

            else {
                $query = "INSERT INTO ELEMENT VALUES
                ('$listID', '$mediaID', '$media', '$username')";
                
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
            <form class="add-list-elem-form" action="" method="post">
              <input name="title" type="text" class="input" id="title" autocomplete="off" placeholder="Title">
              
              <input name="add" type="submit" class="button" value="Add To List">
              <input name="cancel" type="submit" class="button" value="Cancel">
            </form>
          </div>
        </div>
      </div>
    </body>
</html>