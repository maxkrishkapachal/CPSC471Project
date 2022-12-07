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

    if(isset($_REQUEST['view-button']) && isset($_REQUEST['elem-instance'])){
        $element_type = explode("~~", $_POST['elem-instance']);
        
        $return_add = "Location: ../media/publisher.php";
        $_SESSION['name'] = $element_type[1];

        if($element_type[0] == "M"){
            $return_add = "Location: ../media/media.php";
            $_SESSION['id'] = $element_type[1];
        }

        else if($element_type[0] == "C"){

        }

        header($return_add); 
        die;
    }

    if(isset($_REQUEST['delete-from-list-button']) && isset($_REQUEST['elem-instance'])){
        $element_type = explode("~~", $_POST['elem-instance']);

        $_SESSION['elem-instance'] = $element_type[2];
        header('Location: elem/deleteElem.php'); 
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
                <div class='row-of-buttons'>
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
                        <input class='btn' type='submit' name='view-button' value='View'>
                        <input class='btn' type='submit' name='delete-from-list-button' value='Delete From List'>
                    </div>
                    <form class='log mpc-el search-form' id="form" role="search">
                        <input class='log mpc-el' type="search" id="query" name="elem-search"  placeholder="Search List Elements...">
                        <button class='log mpc-el btn'>Search</button>
                    </form> 
                    <div class='scroll scroll-elem'>
                        <div class='scr'>
                            <?php  
                                checkTable($conn, 'ELEMENT');
                                checkTable($conn, "MEDIA");
                                checkTable($conn, "PUBLISHER");
                                checkTable($conn, "CREW");

                                $username = $user_data['username'];
                                
                                $elem = "
                                    SELECT *
                                    FROM ELEMENT AS E, MEDIA AS M
                                    WHERE E.mediaID = M.ID
                                    AND E.listID = '$user_listID'
                                ";

                                $elem_result = mysqli_query($conn, $elem);

                                while($row = mysqli_fetch_assoc($elem_result)){
                                    # need to print out media name, rating, remarks, date
                                    $medianame = convertQuotes($row['title'], "QUOTES");
                                    
                                    ?>
                                        <div class='instance'>
                                            <input class='instance-block' name='elem-instance' type='radio' value='M~~<?php echo $row['ID'] ?>~~<?php echo $row['elementID'] ?>'>
                                            <div class='instance-block in-elem-name' name='name'>
                                                <?php echo $medianame ?>
                                            </div>  
                                        </div>
                                    <?php
                                }

                                
                                $elem = "
                                    SELECT *
                                    FROM ELEMENT AS E, PUBLISHER AS P
                                    WHERE E.mediaID = P.name
                                    AND E.listID = '$user_listID'
                                ";

                                $elem_result = mysqli_query($conn, $elem);

                                while($row = mysqli_fetch_assoc($elem_result)){
                                    # need to print out media name, rating, remarks, date
                                    $name = $row['name'];
                                    $medianame = convertQuotes($name, "QUOTES");
                                    
                                    ?>
                                        <div class='instance'>
                                            <input class='instance-block' name='elem-instance' type='radio' value='P~~<?php echo $name ?>~~<?php echo $row['elementID'] ?>'>
                                            <div class='instance-block in-elem-name' name='name'>
                                                <?php echo $medianame ?>
                                            </div>  
                                        </div>
                                    <?php
                                }

                                
                                $elem = "
                                    SELECT *
                                    FROM ELEMENT AS E, CREW AS C
                                    WHERE E.mediaID = C.crewID
                                    AND E.listID = '$user_listID'
                                ";

                                $elem_result = mysqli_query($conn, $elem);

                                while($row = mysqli_fetch_assoc($elem_result)){
                                    # need to print out media name, rating, remarks, date
                                    $medianame = convertQuotes($row['name'], "QUOTES");
                                    
                                    ?>
                                        <div class='instance'>
                                            <input class='instance-block' name='elem-instance' type='radio' value='C~~<?php echo $row['crewID'] ?>~~<?php echo $row['elementID'] ?>'>
                                            <div class='instance-block in-elem-name' name='name'>
                                                <?php echo $medianame ?>
                                            </div>  
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