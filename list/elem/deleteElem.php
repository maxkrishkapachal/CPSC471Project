<?php
    session_start();

    include("../../gen/connect.php");
    include('../../gen/functions.php');

    $user_elemID = NULL;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $user_elemID = $_GET['eleminst'];
    }

    $user_data = getUserData($conn);

    checkTable($conn, 'ELEMENT');

    $get_list = "
        SELECT listID
        FROM ELEMENT
        WHERE elementID = '$user_elemID'
    ";

    $list_result = mysqli_query($conn, $get_list);
    if($list_result && mysqli_num_rows($list_result) == 1){
        $user_list = mysqli_fetch_assoc($list_result);  
        $user_listID = $user_list['listID'];  
    }
    
    if(isset($_REQUEST['delete'])){
        $user_listID = $_POST['listID'];
        $user_elemID = $_POST['elementID'];
        $elem_delete = "
            DELETE 
            FROM ELEMENT
            WHERE elementID = '$user_elemID'
        ";
            
        mysqli_query($conn, $elem_delete);
        
        returnAddy($user_listID);
    }

    if(isset($_REQUEST['cancel'])){
        $user_listID = $_POST['listID'];
        returnAddy($user_listID);
    }

    function returnAddy($user_listID){
        header("Location: ../viewList.php?listinst=$user_listID");
        die;
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="../../gen/main.css" media="screen">
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
                            <label class='media-title'>Are you sure you want to delete?</label>
                        </div>
                        <input hidden name='elementID' value='<?php echo $user_elemID ?>'>
                        <input hidden name='listID' value='<?php echo $user_listID ?>'>
                         
                        
                        <input name="delete" type="submit" class="button" value="Delete">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

