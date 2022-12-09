<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_logID = NULL;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $user_logID = $_GET['loginst'];
    }

    $user_data = getUserData($conn);

    # the plan here is that we have the user_data, and the mediaID
    # so, we need to go into the logs, find the ones that have the username and the mediaID
    checkTable($conn, 'LOGS');

    $get_log = "
        SELECT L.mediaID, L.remarks, L.rating, M.title
        FROM LOGS AS L, MEDIA AS M
        WHERE L.logID = '$user_logID'
        AND L.mediaID = M.ID
    ";

    $log_result = mysqli_query($conn, $get_log);

    if($log_result && mysqli_num_rows($log_result) == 1){
        $user_log = mysqli_fetch_assoc($log_result);

        $mediaID = $user_log['mediaID'];
        $remarks = convertQuotes($user_log['remarks'], "QUOTES");
        $rating = $user_log['rating'];
        $title = convertQuotes($user_log['title'], "QUOTES");
    }

    if(isset($_REQUEST['save'])){
        $user_logID = $_POST['userLog'];
        $mediaID = $_POST['mediaID'];
        $remarks = convertQuotes($_POST['remarks'], "SYMBOLS");
        $rating = $_POST['rating'];

        if(!empty($rating)){
            $log_edit = "
                UPDATE LOGS
                SET remarks = '$remarks', rating = '$rating'
                WHERE logID = '$user_logID'
            ";
                
            mysqli_query($conn, $log_edit);

            $query = "
              UPDATE MEDIA
              SET ranking = (
                SELECT AVG(rating) AS rating 
                FROM LOGS 
                WHERE mediaID = '$mediaID'
              )
              WHERE ID = '$mediaID'
            ";

            mysqli_query($conn, $query);

            
            header("Location: ../acc/home.php");
            die;
        }
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
                    <form class="edit-log-form" action="" method="post">
                        <div class='media-title-div'>
                            <label class='media-title'><?php echo $title ?></label>
                        </div>
                        <input hidden name='userLog' value='<?php echo $user_logID ?>'>
                        <input hidden name='mediaID' value='<?php echo $mediaID ?>'>
              
                        <input name="remarks" type="text" class="input" id="log_remarks" autocomplete="off" value="<?php echo $remarks ?>">
                        <input name="rating" type="number" class="input" id="log_rating" autocomplete="off" value="<?php echo $rating ?>">
                
                        <input name="save" type="submit" class="button" value="Save Log">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>