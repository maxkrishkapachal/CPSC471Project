<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");

    # view users in a list?

    $user_name = $_SESSION['list-instance'];
    $user_data = getUserData($conn);

    checkTable($conn, 'USER');

    $get_user = "
        SELECT *
        FROM USER
        WHERE username = '$user_name'
    ";

    $result = mysqli_query($conn, $get_user;

    if($result && mysqli_num_rows($result) == 1){
        $user_name = mysqli_fetch_assoc($result);

        $user_list = convertQuotes($user_name['username'], "QUOTES");
        $name = convertQuotes($user_list['name'], "QUOTES");
    }

    if(isset($_REQUEST['back-button'])){
        header('Location: ../acc/home.php'); 
        die;
    }

    # add user as friend
    if(isset($_REQUEST['add-friend-button'])){
      SELECT FROM can_interact as i
      WHERE i.member_username1 = 'username1'
            AND i.member_username2 = 'username2'
    }

    # block user
    if(isset($_REQUEST['block-button'])){
      DELETE FROM can_interact as i
      WHERE i.member_username1 = 'username1'
            AND i.member_username2 = 'username2'
    }

    # report user
    if(isset($_REQUEST['report-button'])){
      header("Location: ../log/reportUser.php");
      die;
    }

?>
/*
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="../gen/main.css" media="screen">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <form method='post'>
            <div class='account'>
                <div class='account-buttons'>
                    <input class='btn' type='submit' name='back-button' value='Return Home'>
                    <input class='btn' type='submit' name='add-friend-button' value='Add Friend'>
                    <input class='btn' type='submit' name='block-member-button' value='Block'>
                    <input class='btn' type='submit' name='report-member-button' value='Report'>
                </div>
            </div>
        </form>
    </body>
</html>
*/
