<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_commentID = NULL;

    //$user_commentID = $_SESSION['comment-instance'];
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
      $user_commentID = $_GET['comment'];
    }
    
    $user_data = getUserData($conn);

    checkTable($conn, 'COMMENT');

    $get_comment = "
        SELECT *
        FROM COMMENT
        WHERE commentID = '$user_commentID'
    ";

    $comment_result = mysqli_query($conn, $get_comment);

    if($comment_result && mysqli_num_rows($comment_result) == 1){
        $user_comment = mysqli_fetch_assoc($comment_result);

        $content = convertQuotes($user_comment['content'], "QUOTES");
    }

    if(isset($_POST['save'])){
        $content = convertQuotes($_POST['content'], "SYMBOLS");
        $user_commentID = $_REQUEST['comment_ID'];
        
        if(!empty($content)){
            $comment_edit = "
                UPDATE COMMENT
                SET content = '$content'
                WHERE commentID = '$user_commentID'
            ";
            
            mysqli_query($conn, $comment_edit);
            
            header("Location: ../media/media.php?id=".$user_comment['mediaID']."");
            die;
        }
    }

    if(isset($_POST['cancel'])){
        header("Location: ../media/media.php?id=".$user_comment['mediaID']."");
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
            <form class="edit-comment-form" action="" method="post">
              <input hidden name="comment_ID" value='<?php echo $user_commentID ?>'>
              <input name="content" type="text" class="input" id="content" autocomplete="off" value="<?php echo $content ?>">
    
              <input name="save" type="submit" class="button" value="Save Comment">
              <input name="cancel" type="submit" class="button" value="Cancel">
            </form>
          </div>
        </div>
      </div>
    </body>
</html>