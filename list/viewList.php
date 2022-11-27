<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");

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

    if(isset($_REQUEST['back-button'])){
        header('Location: ../acc/home.php'); 
        die;
    }

?>

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
                    <input class='btn' type='submit' name='back-button' value='Home'>
                </div>
                <div class='welcome-label-div'>
                    <label class='welcome-label'>
                        <?php 
                            echo $list_name;
                        ?>
                    </label>
                </div>
                <div class='desc-label-div'>
                    <label class='description-label'>
                        <?php
                            echo $desc;
                        ?>
                    </label>
                </div>
            </div>
            <div class='main-page-container'>   
                <div class='log ll-box'> 
                    <div class='mpc-buttons'>
                        <input class='btn' type='submit' name='add-to-list-button' value='Add To List'>
                        <input class='btn' type='submit' name='delete-from-list-button' value='Delete From List'>
                    </div>
                    <form class='log mpc-el search-form' id="form" role="search">
                        <input class='log mpc-el' type="search" id="query" name="elem-search"  placeholder="Search List Elements...">
                        <button class='log mpc-el btn'>Search</button>
                    </form> 
                    <div class='scroll elem'>
                        <div class='scr'>
                            <?php  
                                checkTable($conn, 'ELEMENT');

                                $username = $user_data['username'];
                                
                                $elem = "
                                    SELECT *
                                    FROM ELEMENT
                                    WHERE username = '$username'
                                ";

                                $elem_result = mysqli_query($conn, $elem);

                                while($row = mysqli_fetch_assoc($elem_result)){
                                    # need to print out media name, rating, remarks, date
                                    $listID = $row['listID'];
                                    $medianame = convertQuotes($row['medianame'], "QUOTES");
                                    
                                    ?>
                                        <div class='instance'>
                                            <input class='instance-block' name='elem-instance' type='radio' value='<?php echo $listID . $medianame ?>'>
                                            <div class='instance-block in-name' name='name'>
                                                <?php echo $medianame ?>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>