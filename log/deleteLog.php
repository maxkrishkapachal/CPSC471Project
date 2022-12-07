<?php
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_logID = $_SESSION['log-instance'];
    $user_data = getUserData($conn);

    checkTable($conn, 'LOGS');

    $get_log = "
        SELECT M.title
        FROM LOGS AS L, MEDIA AS M
        WHERE L.logID = '$user_logID'
        AND L.mediaID = M.ID
    ";

    $log_result = mysqli_query($conn, $get_log);

    if($log_result && mysqli_num_rows($log_result) == 1){
        $user_log = mysqli_fetch_assoc($log_result);

        $title = convertQuotes($user_log['title'], "QUOTES");
    }

    if(isset($_REQUEST['delete'])){
        $log_delete = "
            DELETE 
            FROM LOGS
            WHERE logID = '$user_logID'
        ";
            
        mysqli_query($conn, $log_delete);
        
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
                            <label class='media-title'>Delete Log for <?php echo $title ?>?</label>
                        </div>
                        
                        <input name="delete" type="submit" class="button" value="Delete">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

