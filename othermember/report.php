<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");

    $user_data = getUserData($conn);



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
                    <input class='btn btn-input' type='submit' name='back-button' value='Return Home'>
                </div>
            </div>
        </form>
    </body>
</html>
*/
