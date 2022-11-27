<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_listID = $_SESSION['list-instance'];
    $user_data = getUserData($conn);

    checkTable($conn, 'LIST');

    $get_list = "
        SELECT *
        FROM LIST
        WHERE listID = '$user_listID'
    ";

    $list_result = mysqli_query($conn, $get_list);

    if($list_result && mysqli_num_rows($list_result) == 1){
        $user_list = mysqli_fetch_assoc($list_result);

        $list_name = convertQuotes($user_list['name'], "QUOTES");
        $desc = convertQuotes($user_list['description'], "QUOTES");
    }

    if(isset($_REQUEST['save'])){
        $list_name = convertQuotes($_POST['list_name'], "SYMBOLS");
        $desc = convertQuotes($_POST['desc'], "SYMBOLS");

        if(!empty($list_name)){
            $list_edit = "
                UPDATE LIST
                SET name = '$list_name', description = '$desc'
                WHERE listID = '$user_listID'
            ";
                
            mysqli_query($conn, $list_edit);
            
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
                    <form class="edit-list-form" action="" method="post">
                        <input name="list_name" type="text" class="input" id="list_name" autocomplete="off" value="<?php echo $list_name ?>">
                        <input name="desc" type="text" class="input" id="desc" autocomplete="off" value="<?php echo $desc ?>">
                        
                        <input name="save" type="submit" class="button" value="Save List">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>