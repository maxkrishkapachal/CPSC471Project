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

    echo "<label>comment id: $user_commentID</label>";

    checkTable($conn, 'COMMENT');

    $get_comment = "
        SELECT M.ID, M.title
        FROM COMMENT AS C, MEDIA AS M
        WHERE C.commentID = '$user_commentID'
        AND C.mediaID = M.ID
    ";

    $comment_result = mysqli_query($conn, $get_comment);
    $user_comment = mysqli_fetch_assoc($comment_result);

    $mediaID = $user_comment['ID'];
    $title = convertQuotes($user_comment['title'], "QUOTES");

    if(isset($_REQUEST['delete'])){
        $comment_delete = "
            DELETE 
            FROM COMMENT
            WHERE commentID = '$user_commentID'
        ";
            
        mysqli_query($conn, $comment_delete);
        

        //header("Location: ../media/media.php");
        //die;
    }

    if(isset($_REQUEST['cancel'])){
        header('Location: ../media/media.php'); 
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
                    <form class="delete-log-form" action="" method="post">
                        <div class='media-title-div'>
                            <label class='media-title'>Delete Comment on <?php echo $title ?>?</label>
                        </div>
                        
                        <input name="delete" type="submit" class="button" value="Delete">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

