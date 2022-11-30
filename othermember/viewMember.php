<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");

    $user_data = getUserData($conn);
    
    # view other user page
    Select m.username, m.status, u.email_address, u.Name, u.bio
    FROM member as m, user as u
    WHERE m.username = @Username
       and m.username = u.username
    And m.status = @status
       and u.email_address = @email_address
       and u.Name = @Name
       and u.bio = @bio;

    # add user as friend
    if(isset($_REQUEST['add-friend-button'])){
      header("Location: ../log/addFriend.php");
      die;
    }

    # block user
    if(isset($_REQUEST['block-button'])){
      DELETE 
      FROM can_interact as i
      WHERE i.member_username1 = 'username1'
            AND i.member_username2 = 'username2'
      ";
      die;
    }

    # report user
    if(isset($_REQUEST['report-button'])){
      header("Location: ../log/reportUser.php");
      die;
    }

//     # add log
//     if(isset($_REQUEST['add-log-button'])){
//         header("Location: ../log/addLog.php");
//         die;
//     }

//     # edit list
//     if(isset($_REQUEST['list-instance']) && isset($_REQUEST['edit-list-button'])){
//         $_SESSION['list-instance'] = $_REQUEST['list-instance'];
//         header("Location: ../list/editList.php");
//         die;
//     } 

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
                    <input class='btn' type='submit' name='add-friend-button' value='Add Friend'>
                    <input class='btn' type='submit' name='block-member-button' value='Bloxk'>
                    <input class='btn' type='submit' name='report-member-button' value='Report'>
                </div>
                <div class='welcome-label-div'>
                    <label class='welcome-label'>
                        Welcome, <?php 
                            $name = $user_data['name'];
                            if(!empty($name)) echo $name;
                            else echo $user_data['username'];
                        ?>
                    </label>
                </div>
            </div>
        </form>
    </body>
</html>
*/
