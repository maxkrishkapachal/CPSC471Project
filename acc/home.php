<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");

    $user_data = getUserData($conn);

    # edit account
    if(isset($_REQUEST['edit-account-button'])){
        header("Location: editAccount.php");
        die;
    }

    # logout
    if(isset($_REQUEST['logout-button'])){
        header("Location: logout.php");
        die;
    }

    # add log
    if(isset($_REQUEST['add-log-button'])){
        header("Location: ../log/addLog.php");
        die;
    }

    # edit log
    if(isset($_REQUEST['log-instance']) && isset($_REQUEST['edit-log-button'])){
        $_SESSION['log-instance'] = $_REQUEST['log-instance'];
        header("Location: ../log/editLog.php");
        die;
    } 

    # delete log
    if(isset($_REQUEST['log-instance']) && isset($_REQUEST['delete-log-button'])){
        $_SESSION['log-instance'] = $_REQUEST['log-instance'];
        header("Location: ../log/deleteLog.php");
        die;
    }

    # search logs

    # add list
    if(isset($_REQUEST['add-list-button'])){
        header("Location: ../list/addList.php");
        die;
    }

    # edit list
    if(isset($_REQUEST['list-instance']) && isset($_REQUEST['edit-list-button'])){
        $_SESSION['list-instance'] = $_REQUEST['list-instance'];
        header("Location: ../list/editList.php");
        die;
    } 

    # delete list
    if(isset($_REQUEST['list-instance']) && isset($_REQUEST['delete-list-button'])){
        $_SESSION['list-instance'] = $_REQUEST['list-instance'];
        header("Location: ../list/deleteList.php");
        die;
    }

    # view list
    if(isset($_REQUEST['list-instance']) && isset($_REQUEST['view-list-button'])){
        $_SESSION['list-instance'] = $_REQUEST['list-instance'];
        header("Location: ../list/viewList.php");
        die;
    }

    # search lists

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="../gen/main.css" media="screen">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        
        <!-- This page needs:
            - PERSONAL ACCOUNT -
            * edit account 
            * logout
            - MEDIA, CREW, PUBLISHER -
            * search bar for the media, publishers, and crew
            * add new media button, publishers, and crew
            * select media, publisher, or crew
            - LOGS -
            * search logs
            * add log
            * select log
            * edit log
            * delete log
            - COMMENTS -
            * view comments
            - LIST - 
            * add list button
            * search bar for the lists
            * lists
            * select list option
            * delete list option once selected
            * edit list option once selected 
        -->
        <form method='post'>
            <div class='account'>
                <div class='account-buttons'>
                    <input class='btn' type='submit' name='edit-account-button' value='Edit Account'>
                    <input class='btn' type='submit' name='logout-button' value='Logout'>
                </div>
                <div class='welcome-label-div'>
                    <label class='welcome-label'>
                        Welcome, <?php 
                            $name = $user_data['name'];
                            if(!empty($name)) echo $name;
                            else echo $user_data['username'];
                        ?>
                    </label>
                </div>
            </div>
            <div class='main-page-container'>   
                <div class='log ll-box'> 
                    <div class='mpc-buttons'>
                        <input class='btn' type='submit' name='add-log-button' value='Add Log'>
                        <input class='btn' type='submit' name='edit-log-button' value='Edit Log'>
                        <input class='btn' type='submit' name='delete-log-button' value='Delete Log'>
                    </div>
                    <form class='log mpc-el search-form' id="form" role="search">
                        <input class='log mpc-el' type="search" id="query" name="log-search"  placeholder="Search Logs...">
                        <button class='log mpc-el btn'>Search</button>
                    </form> 
                    <div class='scroll'>
                        <div class='scr'>
                            <?php  
                                checkTable($conn, 'LOGS');

                                $username = $user_data['username'];
                                
                                $logs = "
                                    SELECT *
                                    FROM LOGS
                                    WHERE username = '$username'
                                ";

                                $logs_result = mysqli_query($conn, $logs);

                                while($row = mysqli_fetch_assoc($logs_result)){
                                    # need to print out media name, rating, remarks, date
                                    $medianame = convertQuotes($row['medianame'], "QUOTES");
                                    $rating = $row['rating'];
                                    $remarks = convertQuotes($row['remarks'], "QUOTES");
                                    $date = $row['date'];
                                    $logID = $row['logID'];
                                    
                                    ?>
                                        <div class='instance'>
                                            <input class='instance-block' name='log-instance' type='radio' value='<?php echo $logID ?>'>
                                            <div class='instance-block in-name' name='name'>
                                                <?php echo $medianame ?>
                                            </div>
                                            <div class='instance-block in-rating' name='rating'>
                                                <?php echo $rating ?>
                                            </div>
                                            <div class='instance-block in-remarks' name='remarks'>
                                                <?php echo $remarks ?>
                                            </div>
                                            <div class='instance-block in-date' name='date'>
                                                <?php echo $date ?>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class='list ll-box'>
                    <div class='mpc-buttons'>
                        <input class='btn' type='submit' name='add-list-button' value='Add List'>
                        <input class='btn' type='submit' name='edit-list-button' value='Edit List'>
                        <input class='btn' type='submit' name='delete-list-button' value='Delete List'>
                        <input class='btn' type='submit' name='view-list-button' value='View List'>
                    </div>
                    <form class='list mpc-el search-form' id="form" role="search">
                        <input class='list mpc-el' type="search" id="query" name="list-search"  placeholder="Search Lists...">
                        <button class='list mpc-el btn'>Search</button>
                    </form>
                    <div class='scroll'>
                        <div class='scr'>
                        <?php  
                                checkTable($conn, 'LIST');

                                $username = $user_data['username'];
                                
                                $lists = "
                                    SELECT *
                                    FROM LIST
                                    WHERE username = '$username'
                                ";

                                $lists_result = mysqli_query($conn, $lists);

                                while($row = mysqli_fetch_assoc($lists_result)){
                                    # need to print out media name, rating, remarks, date
                                    $name = convertQuotes($row['name'], "QUOTES");
                                    $desc = convertQuotes($row['description'], "QUOTES");
                                    $listID = $row['listID'];

                                    ?>
                                        <div class='instance'>
                                            <input class='instance-block' name='list-instance' type='radio' value='<?php echo $listID ?>'>
                                            <div class='instance-block in-name' name='name'>
                                                <?php echo $name?>
                                            </div>
                                            <div class='instance-block in-desc' name='desc'>
                                                <?php echo $desc ?>
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