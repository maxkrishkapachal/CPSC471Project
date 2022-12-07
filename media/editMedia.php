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

    $mediaID = $media['ID'];
    $title = convertQuotes($media['title'], "QUOTES");
    $rd = $media['release_date'];
    $desc = convertQuotes($media['description'], "QUOTES");


    if(isset($_REQUEST['save'])){
        $title = convertQuotes($_POST['title'], "SYMBOLS");
        $rd = $_POST['release_date'];
        $desc = convertQuotes($_POST['description'], "SYMBOLS");

        if(!empty($title)){
            $media_edit = "
                UPDATE MEDIA
                SET title = '$title', release_date = '$rd', description = '$desc'
                WHERE ID = '$mediaID'
            ";
                
            mysqli_query($conn, $media_edit);
            
            returnAddy($mediaID);
        }
    }

    if(isset($_REQUEST['cancel'])){
        returnAddy($mediaID);
    }

    function returnAddy($mediaID){
        $_SESSION['id'] = $mediaID;
        header("Location: media.php");
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
                    <form class="edit-media-form" action="" method="post">
                        <input name="title" type="text" class="input" autocomplete="off" placeholder="Title*" value="<?php echo $title ?>">
                        <input name="release_date" type="text" class="input" autocomplete="off" placeholder="Release Date" value="<?php echo $rd ?>">
                        <input name="description" type="text" class="input" autocomplete="off" placeholder="Description" value="<?php echo $desc ?>">
                    
                        <input name="save" type="submit" class="button" value="Save Media">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>