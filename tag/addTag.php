<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);
    $mediaID = NULL;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $mediaID = $_GET['id'];
    }

    if(isset($_REQUEST['add'])){
        $mediaID = $_POST['mediaID'];
        $tag = convertQuotes($_POST['tag'], "SYMBOLS");

        if(!empty($tag)){
            checkTable($conn, 'MEDIA_TAG');
            checkTable($conn, "MEDIA");

            $tag_check = "
              SELECT *
              FROM MEDIA_TAG
              WHERE tag = '$tag'
              AND mediaid = '$mediaID'
            ";

            $tag_result = mysqli_query($conn, $tag_check);

            if($tag_result && mysqli_num_rows($tag_result) == 0){
                $query = "
                    INSERT 
                    INTO MEDIA_TAG
                    VALUES
                    ('$mediaID', '$tag')
                ";
                
                mysqli_query($conn, $query);
                returnAddy($mediaID);
            }
        }
    }    
    if(isset($_REQUEST['cancel'])){
        $mediaID = $_POST['mediaID'];
        returnAddy($mediaID);
    }

    function returnAddy($mediaID){
        header("Location: ../media/media.php?id=$mediaID");
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
                <form class="add-tag-form" action="" method="post">
                    <input name="tag" type="text" class="input" id="tag" autocomplete="off" placeholder="Tag*">
                    <input hidden name='mediaID' value='<?php echo $mediaID ?>'>
                        
                    <input name="add" type="submit" class="button" value="Add Tag">
                    <input name="cancel" type="submit" class="button" value="Cancel">
                </form>
            </div>
            </div>
        </div>
    </body>
</html>