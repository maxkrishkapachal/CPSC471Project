<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $pubID = $_SESSION['name'];
    $user_data = getUserData($conn);

    checkTable($conn, 'PUBLISHER');

    $get_pub = "
        SELECT *
        FROM PUBLISHER
        WHERE name = '$pubID'
    ";

    $pub_result = mysqli_query($conn, $get_pub);

    if($pub_result && mysqli_num_rows($pub_result) == 1){
        $pub = mysqli_fetch_assoc($pub_result);
    }

    $name = convertQuotes($pub['name'], "QUOTES");
    $desc = convertQuotes($pub['description'], "QUOTES");


    if(isset($_REQUEST['save'])){
        $desc = convertQuotes($_POST['desc'], "SYMBOLS");
    
        if(!empty($name)){
            $pub_edit = "
                UPDATE PUBLISHER
                SET description = '$desc'
                WHERE name = '$pubID'
            ";
                
            mysqli_query($conn, $pub_edit);
            
            returnAddy($pubID);
        }
    }

    if(isset($_REQUEST['cancel'])){
        returnAddy($pubID);
    }

    function returnAddy($pubID){
        $_SESSION['name'] = $pubID;
        header("Location: ../media/publisher.php");
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
                    <form class="edit-pub-form" action="" method="post">
                        <div class='media-title-div'>
                            <label class='media-title'><?php echo $name ?></label>
                        </div>    
                        <input name="desc" type="text" class="input" autocomplete="off" placeholder="Description" value="<?php echo $desc ?>">
                    
                        <input name="save" type="submit" class="button" value="Save Publisher">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>