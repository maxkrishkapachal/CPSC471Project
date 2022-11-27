<?php
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_commentID = $_SESSION['comment-instance'];
    $user_data = getUserData($conn);

    checkTable($conn, 'COMMENT');

    $get_comment = "
        SELECT M.title
        FROM COMMENT AS C, MEDIA AS M
        WHERE C.commentID = '$user_commentID'
        AND C.mediaID = M.ID
    ";

    $comment_result = mysqli_query($conn, $get_comment);

    if($comment_result && mysqli_num_rows($comment_result) == 1){
        $user_comment = mysqli_fetch_assoc($comment_result);

        $media = convertQuotes($user_comment['title'], "QUOTES");
    }

    if(isset($_REQUEST['delete'])){
        $comment_delete = "
            DELETE 
            FROM COMMENT
            WHERE commentID = '$user_commentID'
        ";
            
        mysqli_query($conn, $comment_delete);
        
        header("Location: ../acc/home.php");
        die;
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
                    <form class="delete-log-form" action="" method="post">
                        <div class='media-title-div'>
                            <label class='media-title'>Delete Comment on<?php echo $media ?>?</label>
                        </div>
                        
                        <input name="delete" type="submit" class="button" value="Delete">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

