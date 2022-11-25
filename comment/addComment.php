<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    if($_REQUEST['add']){
        # content, commentID, mediaID, username, date
        $content = convertQuotes($_POST['content'], "SYMBOLS");
        $commentID = createID('COM', $user_data['username']);
        $mediaID = "FIX LATER";
        $username = $user_data['username'];
        $date = getDateTime();

        if(!empty($content)){
            checkTable($conn, 'COMMENT');

            $query = "INSERT INTO LOGS VALUES
                ('$id', '$date', '$remarks', '$rating', '$media', '$username', '$medianame')";
            
            mysqli_query($conn, $query);
            
            # here, we would actually want to go back to the media page, haven't made those yet
            # for now, we'll just have it go back to the main page
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
            <form class="add-comment-form" action="" method="post">
              <input name="content" type="text" class="input" id="content" autocomplete="off" placeholder="What would you like to say?*">
    
              <input name="add" type="submit" class="button" value="Add Comment">
              <input name="cancel" type="submit" class="button" value="Cancel">
            </form>
          </div>
        </div>
      </div>
    </body>
</html>