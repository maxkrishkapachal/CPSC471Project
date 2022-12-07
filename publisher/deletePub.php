<?php
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $pubID = $_SESSION['name'];
    $user_data = getUserData($conn);

    checkTable($conn, 'PUBLISHER');

    $name = convertQuotes($pubID, "QUOTES");

    if(isset($_REQUEST['delete'])){
        $pub_delete = "
            DELETE 
            FROM PUBLISHER
            WHERE name = '$pubID'
        ";
            
        mysqli_query($conn, $pub_delete);

        header("Location: ../acc/search.php");
        die;
    }

    if(isset($_REQUEST['cancel'])){
        $_SESSION['name'] = $pubID;
        header("Location: ../media/publisher.php");
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
                            <label class='media-title'>Are you sure you want to delete <?php echo $name ?>?</label>
                        </div>
                        
                        <input name="delete" type="submit" class="button" value="Delete">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

