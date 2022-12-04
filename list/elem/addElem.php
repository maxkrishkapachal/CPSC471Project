<?php 
    session_start();

    include("../../gen/connect.php");
    include('../../gen/functions.php');

    $user_data = getUserData($conn);
    $user_listID = $_SESSION['list-instance'];

    if(isset($_REQUEST['add'])){
        $id = createID('ELEM', $user_data['username']);
        $username = $user_data['username'];
        $media = convertQuotes($_POST['media_name'], "SYMBOLS");

        if(!empty($media)){
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

           checkTable($conn, 'ELEMENT');

            $query = "INSERT INTO ELEMENT VALUES
                ('$id', '$user_listID', '$mediaID', '$media', '$username')";
            
            mysqli_query($conn, $query);
            header("Location: ../viewList.php");
            die;
        }
    }
    if(isset($_REQUEST['cancel'])){
        header('Location: ../viewList.php'); 
        die;
    }    
?> 


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <link rel="stylesheet" href="../../gen/main.css" media="screen">
  <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        
      <div class="form-wrap">
        <div class="tabs-content">
          <div class="active">
            <form class="add-elem-form" action="" method="post">
              <input name="media_name" type="text" class="input" id="media_name" autocomplete="off" placeholder="Title*">
    
              <input name="add" type="submit" class="button" value="Add Element">
              <input name="cancel" type="submit" class="button" value="Cancel">
            </form>
          </div>
        </div>
      </div>
    </body>
</html>