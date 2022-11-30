<?php
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    if(isset($_REQUEST['block'])){
      DELETE 
      FROM can_interact as i
      WHERE i.member_username1 = 'username1'
            AND i.member_username2 = 'username2'
      ";
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
                    <form class="block-member" action="" method="">

                        <input name="block member" type="submit" class="button" value="">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
*/
