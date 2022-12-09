<?php
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $mediaID = $_SESSION['id'];
    $user_data = getUserData($conn);

    checkTable($conn, 'MEDIA');

    $get_media = "
        SELECT *
        FROM MEDIA
        WHERE ID = '$mediaID'
    ";

    $media_result = mysqli_query($conn, $get_media);

    if($media_result && mysqli_num_rows($media_result) == 1){
        $media = mysqli_fetch_assoc($media_result);
    }

    $title = $media['title'];
    
    if(isset($_REQUEST['delete'])){
        $media_delete = "
            DELETE 
            FROM MEDIA
            WHERE ID = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        $media_delete = "
            DELETE 
            FROM BOOK
            WHERE ID = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        
        $media_delete = "
            DELETE 
            FROM COMMENT
            WHERE mediaID = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        
        $media_delete = "
            DELETE 
            FROM ELEMENT
            WHERE mediaID = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        
        $media_delete = "
            DELETE 
            FROM LOG
            WHERE mediaID = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        
        $media_delete = "
            DELETE 
            FROM MEDIA_TAG
            WHERE mediaid = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        
        $media_delete = "
            DELETE 
            FROM MOVIE
            WHERE ID = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        
        $media_delete = "
            DELETE 
            FROM PUBLISHED
            WHERE mediaID = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        
        $media_delete = "
            DELETE 
            FROM VIDEO_GAME
            WHERE ID = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        
        $media_delete = "
            DELETE 
            FROM WORKS_ON
            WHERE mediaID = '$mediaID'
        ";

        mysqli_query($conn, $media_delete);

        header("Location: ../acc/search.php");
        die;
    }

    if(isset($_REQUEST['cancel'])){
        $_SESSION['id'] = $mediaID;
        header("Location: ../media/media.php");
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
                            <label class='media-title'>Are you sure you want to delete <?php echo $title ?>?</label>
                        </div>
                        
                        <input name="delete" type="submit" class="button" value="Delete">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

