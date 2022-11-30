<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    checkTable($conn, 'USER'); = getUserData($conn);

    # report member
    if(isset($_REQUEST['report'])){

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
                    <form class="report-member" action="" method="">

                        <input name="report member" type="submit" class="button" value="">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
*/
