<?php
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $pubID = NULL;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $pubID = $_GET['name'];
    }

    $user_data = getUserData($conn);

    checkTable($conn, 'PUBLISHER');

    $name = convertQuotes($pubID, "QUOTES");

    if(isset($_REQUEST['delete'])){
        $pubID = $_POST['name'];
        $pub_delete = "
            DELETE 
            FROM PUBLISHER
            WHERE name = '$pubID'
        ";
            
        mysqli_query($conn, $pub_delete);

        $pub_delete = "
            DELETE 
            FROM ELEMENT
            WHERE mediaID = '$pubID'
        ";
            
        mysqli_query($conn, $pub_delete);

        $pub_delete = "
            DELETE 
            FROM EMPLOYS
            WHERE publisher = '$pubID'
        ";
            
        mysqli_query($conn, $pub_delete);

        $pub_delete = "
            DELETE 
            FROM PUBLISHED
            WHERE publisher = '$pubID'
        ";
            
        mysqli_query($conn, $pub_delete);

        header("Location: ../acc/search.php");
        die;
    }

    if(isset($_REQUEST['cancel'])){
        $pubID = $_POST['name'];
        header("Location: ../media/publisher.php?name=$pubID");
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
                        <input hidden name='name' value='<?php echo $pubID ?>'>
                        
                        
                        <input name="delete" type="submit" class="button" value="Delete">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

