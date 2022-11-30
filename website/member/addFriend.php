<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    checkTable($conn, 'USER'); = getUserData($conn);

    # add other user as friend
    if(isset($_REQUEST['add-friend-button'])){

    }
    
?> 
/*
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
                    <form class="add-friend" action="" method="">

                        <input name="add friend" type="submit" class="button" value="">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
*/ 
