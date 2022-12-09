<?php
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_listID = NULL;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $user_listID = $_GET['listinst'];
    }

    $user_data = getUserData($conn);

    checkTable($conn, 'LOGS');

    $get_list = "
        SELECT *
        FROM LIST
        WHERE listID = '$user_listID'
    ";

    $list_result = mysqli_query($conn, $get_list);

    if($list_result && mysqli_num_rows($list_result) == 1){
        $user_list = mysqli_fetch_assoc($list_result);

        $list_name = convertQuotes($user_list['name'], "QUOTES");
    }

    if(isset($_REQUEST['delete'])){
        $user_listID = $_POST['listID'];
        $list_delete = "
            DELETE 
            FROM LIST
            WHERE listID = '$user_listID'
        ";
            
        mysqli_query($conn, $list_delete);
        
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
                    <form class="delete-list-form" action="" method="post">
                        <div class='media-title-div'>
                            <label class='media-title'>Delete List <?php echo $list_name ?>?</label>
                        </div>
                        <input hidden name='listID' value='<?php echo $user_listID ?>'>
                         
                        <input name="delete" type="submit" class="button" value="Delete">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

