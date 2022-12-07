<?php

    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

   
    $user_data = getUserData($conn);
    $ban_user = $_SESSION['banuser'];

    checkTable($conn, 'USER');

    $get_user =  "SELECT *
        FROM USER
        WHERE username = '$ban_user'
    ";

    $user_result = mysqli_query($conn, $get_user);

    if($user_result && mysqli_num_rows($user_result) == 1){
        $user_row = mysqli_fetch_assoc($user_result);
    }

    if(isset($_REQUEST['delete'])){
        $user_delete = "DELETE 
            FROM USER
            WHERE username = '$ban_user'
        ";
        mysqli_query($conn, $user_delete);

        $interact_delete = "DELETE
        FROM CAN_INTERACT
            WHERE 
            (memberID_1 = '$ban_user') or 
            (memberID_2 = '$ban_user')";
        mysqli_query($conn, $interact_delete);

        $comment_delete = "DELETE 
            FROM COMMENT
            WHERE username = '$ban_user'";
        
        mysqli_query($conn, $comment_delete);
        
        $log_delete = "DELETE 
            FROM LOGS
            WHERE username = '$ban_user'";
        mysqli_query($conn, $log_delete);

        $list_delete = "DELETE 
            FROM LIST
            WHERE username = '$ban_user'";
        mysqli_query($conn, $list_delete);

        $element_delete = "DELETE 
            FROM ELEMENT
            WHERE username = '$ban_user'
        ";
            
        mysqli_query($conn, $element_delete);
        
        header("Location: viewMember.php");
        die;
    }

    if(isset($_REQUEST['cancel'])){
        header('Location: viewMember.php'); 
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
                            <label class='media-title'>ARE YOU SURE YOU WANT TO DELETE <?php echo $ban_user ?>?</label>
                        </div>
                        
                        <input name="delete" type="submit" class="button" value="YES">
                        <input name="cancel" type="submit" class="button" value="NO">
                    </form>
                </div>
            </div>
        </div>
    </body>
</htm
?>