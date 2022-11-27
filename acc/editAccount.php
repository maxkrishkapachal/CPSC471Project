<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    checkTable($conn, 'USER');

    if(isset($_REQUEST['save'])){
        $name = convertQuotes($_POST['name'], "SYMBOLS");
        $bio = convertQuotes($_POST['bio'], "SYMBOLS");
        $password = $_POST['password'];
        $username = $user_data['username'];

        if(!empty($password)){
            $acc_edit = "
                UPDATE USER
                SET name = '$name', bio = '$bio', password = '$password'
                WHERE username = '$username'
            ";
                
            mysqli_query($conn, $acc_edit);
            
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
                    <form class="edit-account-form" action="" method="post">
                        <input name="name" type="text" class="input" id="name" autocomplete="off" placeholder='Name' value="<?php echo $user_data['name'] ?>">
                        <input name="bio" type="text" class="input" id="bio" autocomplete="off" placeholder='Bio' value="<?php echo $user_data['bio'] ?>">
                        <input name="password" type="text" class="input" id="password" autocomplete="off" value="<?php echo $user_data['password'] ?>">

                        <input name="save" type="submit" class="button" value="Save">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

