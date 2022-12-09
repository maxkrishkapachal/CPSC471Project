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

    # search
    if(isset($_REQUEST['search-button'])){
        header("Location: search.php");
        die;
    }

    # stats
    if(isset($_REQUEST['stats-button'])){
        header("Location: ../media/statistic.php");
        die;
    }

    # logout
    if(isset($_REQUEST['logout-button'])){
        header("Location: logout.php");
        die;
    }

    # edit log
    if(isset($_REQUEST['log-instance']) && isset($_REQUEST['edit-log-button'])){
        header("Location: ../log/editLog.php?loginst=".$_REQUEST['log-instance']);
        die;
    } 

    # delete log
    if(isset($_REQUEST['log-instance']) && isset($_REQUEST['delete-log-button'])){
        header("Location: ../log/deleteLog.php?loginst=".$_REQUEST['log-instance']);
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
        header("Location: ../list/editList.php?listinst=".$_REQUEST['list-instance']);
        die;
    } 

    # delete list
    if(isset($_REQUEST['list-instance']) && isset($_REQUEST['delete-list-button'])){
        header("Location: ../list/deleteList.php?listinst=".$_REQUEST['list-instance']);
        die;
    }

    # view list
    if(isset($_REQUEST['list-instance']) && isset($_REQUEST['view-list-button'])){
        header("Location: ../list/viewList.php?listinst=".$_REQUEST['list-instance']);
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
                <div class='row-of-buttons'>
                    <input class='btn btn-input' type='submit' name='edit-account-button' value='Edit Account'>
                    <input class='btn btn-input' type='submit' name='search-button' value='Search'>
                    <input class='btn btn-input' type='submit' name='stats-button' value='Statistics'>
                    <input class='btn btn-input' type='submit' name='logout-button' value='Logout'>
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
                        <input class='btn btn-input' type='submit' name='edit-log-button' value='Edit Log'>
                        <input class='btn btn-input' type='submit' name='delete-log-button' value='Delete Log'>
                    </div>
                    <div class='scroll scroll-home'>
                        <div class='scr'>
                            <?php  
                                checkTable($conn, 'LOGS');
                                checkTable($conn, "MEDIA");

                                $username = $user_data['username'];
                                
                                $logs = "
                                    SELECT *
                                    FROM LOGS AS L, MEDIA AS M
                                    WHERE L.username = '$username'
                                    AND L.mediaID = M.ID
                                ";

                                $logs_result = mysqli_query($conn, $logs);

                                while($row = mysqli_fetch_assoc($logs_result)){
                                    # need to print out media name, rating, remarks, date
                                    $medianame = convertQuotes($row['title'], "QUOTES");
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
                        <input class='btn btn-input' type='submit' name='add-list-button' value='Add List'>
                        <input class='btn btn-input' type='submit' name='edit-list-button' value='Edit List'>
                        <input class='btn btn-input' type='submit' name='delete-list-button' value='Delete List'>
                        <input class='btn btn-input' type='submit' name='view-list-button' value='View List'>
                    </div>
                    <div class='scroll scroll-home'>
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